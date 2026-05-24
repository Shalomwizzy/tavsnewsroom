<?php

namespace App\Http\Controllers;

use App\Models\PostNews;
use App\Models\PostView;
use App\Models\Bookmark;
use App\Models\WebsiteSetting;
use App\Models\Category;
use App\Models\Tags;
use App\Models\SocialFollows;
use App\Models\TrendingNews;
use App\Http\Requests\StorePostNewsRequest;
use App\Http\Requests\UpdatePostNewsRequest;
use Illuminate\Support\Str;
use App\Http\Controllers\SEOController;
use App\Services\GeminiService;
use Illuminate\Support\Facades\Cache;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;
use Intervention\Image\Encoders\WebpEncoder;

class PostNewsController extends Controller
{
    protected SEOController $seoController;

    public function __construct(SEOController $seoController)
    {
        $this->seoController = $seoController;
    }
  
    public function index()
    {
        $paginatedItems = PostNews::withCount('postViews')
            ->whereIn('status', ['draft', 'pending', 'published'])
            ->latest()
            ->paginate(20);

        return view('admin.post-news.index', compact('paginatedItems'));
    } 
    
    

    


    public function show()
    {
        $posts = PostNews::where('status', 'published')->latest()->paginate(4);
        $socialFollows = SocialFollows::all(); // Assuming you have a SocialFollow model
        $trendingNews = TrendingNews::where('section', 'body')->get(); // Assuming you have a TrendingNews model
        $tags = Tags::all(); // Assuming you have a Tag model
    
        return view('post-news.show', compact('posts', 'socialFollows', 'trendingNews', 'tags'));
    }
    

    public function adminShow(PostNews $post)
    {
        return view('admin.post-news.show', compact('post'));
    }
    public function draft()
    {
        $draftPosts = PostNews::where('status', 'draft')->latest()->paginate(20);
        return view('admin.post-news.draft', compact('draftPosts'));
    }
    
    public function pending()
    {
        $pendingPosts = PostNews::where('status', 'pending')->latest()->paginate(20);
        return view('admin.post-news.pending', compact('pendingPosts'));
    }
    
    public function published()
    {
        $publishedPosts = PostNews::where('status', 'published')->latest()->paginate(20);
        return view('admin.post-news.published', compact('publishedPosts'));
    }
    
  

    public function create()
    {
        $categories = Category::all();
        return view('admin.post-news.create', compact('categories'));
    }


    public function store(StorePostNewsRequest $request)
{

    $imagePath = null;
    if ($request->hasFile('image')) {
        $imagePath = $this->processNewsImage($request->file('image'));
    }

    $post = new PostNews();
    $post->headline = $request->headline;
    $post->slug = Str::slug($request->headline);
    $post->category_id = $request->category_id;
    $post->date = $request->date;
    $post->image_url = $imagePath;
    $post->content = clean($request->content, 'news_content');
    $post->meta_title = $request->meta_title;
    $post->meta_description = $request->meta_description;
    $post->meta_keywords = $request->meta_keywords;
    $post->status = $request->status;
    $post->scheduled_for = $request->scheduled_for;
    $post->is_breaking = $request->boolean('is_breaking');
    $post->user_id = auth()->id();

    $post->save();

        // Perform SEO analysis for all posts
        $this->seoController->analyze($post->id);

    if ($post->status == 'published') {
        \App\Jobs\SendNewsletterJob::dispatch($post->id);
    }

    return redirect()->route('post-news.read-more', [
        'year' => $post->date->year,
        'month' => $post->date->month,
        'day' => $post->date->day,
        'slug' => $post->slug
    ])->with('success', 'News post created successfully.');

    // return redirect()->route('post-news.read-more', ['slug' => $post->slug])->with('success', 'News post created successfully.');
}




    
    public function update(UpdatePostNewsRequest $request, int $id)
    {
        $post = PostNews::findOrFail($id);
    
        $post->headline = $request->headline;
        $post->slug = Str::slug($request->headline);
        $post->category_id = $request->category_id;
        $post->date = $request->date;
    
        if ($request->hasFile('image')) {
            $post->image_url = $this->processNewsImage($request->file('image'));
        }
    
        $post->content = clean($request->content, 'news_content');
        $post->meta_title = $request->meta_title;
        $post->meta_description = $request->meta_description;
        $post->meta_keywords = $request->meta_keywords;
        $post->status = $request->status;
        $post->scheduled_for = $request->scheduled_for;
        $post->is_breaking = $request->boolean('is_breaking');

        $post->save();

        if ($post->status == 'pending' && $post->scheduled_for) {
            // Perform SEO analysis
            $this->seoController->analyze($post->id);
        }


        if ($post->status == 'published') {
            \App\Jobs\SendNewsletterJob::dispatch($post->id);
        }
        return redirect()->route('post-news.read-more', [
            'year' => $post->date->year,
            'month' => $post->date->month,
            'day' => $post->date->day,
            'slug' => $post->slug
        ])->with('success', 'News post updated successfully.');
    
    }
    

    public function approve(int $id)
    {
        $post = PostNews::findOrFail($id);
        $post->update(['status' => 'published']);

        \App\Jobs\SendNewsletterJob::dispatch($post->id);

        return redirect()->back()->with('success', 'Post approved and published successfully.');
    }

    

    public function edit(int $id)
    {
        $post = PostNews::findOrFail($id);
        $categories = Category::all();
        return view('admin.post-news.edit', compact('post', 'categories'));
    }

    public function destroy(int $id)
    {
        $post = PostNews::findOrFail($id);
        $post->delete();

        return redirect()->back()->with('success', 'News post moved to trash.');
    }

    public function trash()
    {
        $trashedPosts = PostNews::onlyTrashed()->latest('deleted_at')->paginate(20);
        return view('admin.post-news.trash', compact('trashedPosts'));
    }

    public function restore(int $id)
    {
        PostNews::onlyTrashed()->findOrFail($id)->restore();
        return redirect()->back()->with('success', 'News post restored successfully.');
    }

    public function forceDelete(int $id)
    {
        PostNews::onlyTrashed()->findOrFail($id)->forceDelete();
        return redirect()->back()->with('success', 'News post permanently deleted.');
    }

    public function scheduled()
    {
        $posts = PostNews::where('status', 'pending')
            ->whereNotNull('scheduled_for')
            ->where('scheduled_for', '>', now())
            ->orderBy('scheduled_for')
            ->paginate(20);
        return view('admin.post-news.scheduled', compact('posts'));
    }


    public function readMore(int $year, int $month, int $day, string $slug)
{
        unset($year, $month, $day);
    $tags = Tags::with('category')->get();
    $post = PostNews::withCount('postViews')->where('slug', $slug)->firstOrFail();
    $socialFollows = SocialFollows::where('is_active', true)->get();
    $trendingNews = TrendingNews::with('postNews')->get();

    // Record one view per IP per day
    PostView::firstOrCreate([
        'post_news_id' => $post->id,
        'ip_address'   => request()->ip(),
        'viewed_date'  => now()->toDateString(),
    ]);

    $isBookmarked = auth()->check()
        ? Bookmark::where('user_id', auth()->id())->where('post_news_id', $post->id)->exists()
        : false;

    $commentsEnabled = (bool) WebsiteSetting::getValue('comments_enabled', '1');
    $comments = $post->comments()->approved()->latest()->get();

    // Related articles — semantic search via Gemini keyword expansion, cached 48h per article
    $relatedNews = Cache::remember("related_articles_{$post->id}", now()->addHours(48), function () use ($post) {
        try {
            $gemini = app(GeminiService::class);

            // Build a rich search seed from the article's own metadata
            $seed = trim($post->headline . ' ' . ($post->meta_keywords ?? ''));
            $terms = $gemini->expandSearchQuery($seed);

            // Search other published articles for any of those terms
            $candidates = PostNews::withCount('postViews')
                ->where('id', '!=', $post->id)
                ->where('status', 'published')
                ->where(function ($q) use ($terms) {
                    foreach ($terms as $term) {
                        $t = addslashes($term);
                        $q->orWhere('headline',        'LIKE', "%{$t}%")
                          ->orWhere('meta_keywords',   'LIKE', "%{$t}%")
                          ->orWhere('meta_description','LIKE', "%{$t}%");
                    }
                })
                ->latest()
                ->limit(12)
                ->get();

            // Score: same-category bonus (3pts) + normalised view count (up to 2pts) + recency (up to 1pt)
            $maxViews = $candidates->max('post_views_count') ?: 1;
            $scored = $candidates->map(function ($art) use ($post, $maxViews) {
                $score  = ($art->category_id === $post->category_id) ? 3 : 0;
                $score += round(($art->post_views_count / $maxViews) * 2, 2);
                $score += $art->date >= now()->subDays(30)->toDateString() ? 1 : 0;
                $art->_score = $score;
                return $art;
            })->sortByDesc('_score')->take(3);

            // Fallback: if semantic search returned fewer than 3, pad with category matches
            if ($scored->count() < 3) {
                $excludeIds = $scored->pluck('id')->push($post->id)->all();
                $fallback = PostNews::withCount('postViews')
                    ->where('status', 'published')
                    ->where('category_id', $post->category_id)
                    ->whereNotIn('id', $excludeIds)
                    ->orderByDesc('post_views_count')
                    ->limit(3 - $scored->count())
                    ->get();
                $scored = $scored->concat($fallback);
            }

            return $scored->values();
        } catch (\Throwable) {
            // Fallback to category-based if Gemini fails
            return PostNews::withCount('postViews')
                ->where('id', '!=', $post->id)
                ->where('status', 'published')
                ->where('category_id', $post->category_id)
                ->orderByDesc('post_views_count')
                ->limit(3)
                ->get();
        }
    });

    return view('post-news.read-more', compact(
        'post', 'socialFollows', 'trendingNews', 'tags', 'relatedNews',
        'isBookmarked', 'commentsEnabled', 'comments'
    ));
}

    private function processNewsImage(\Illuminate\Http\UploadedFile $file): string
    {
        $location = public_path('images/news_images');
        $fileName = 'news_' . time() . '.webp';

        (new ImageManager(new Driver()))
            ->decode($file->getRealPath())
            ->scaleDown(width: 1200)
            ->encode(new WebpEncoder(quality: 82))
            ->save($location . '/' . $fileName);

        return 'images/news_images/' . $fileName;
    }
}