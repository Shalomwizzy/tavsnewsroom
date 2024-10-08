<?php

namespace App\Http\Controllers;
use App\Models\PostNews;
use App\Models\Category;
use App\Models\Tags;
use App\Models\SocialFollows;
use App\Models\TrendingNews;
use Illuminate\Http\Request;
use App\Models\Subscriber;
use App\Mail\NewsletterEmail;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use App\Http\Controllers\SEOController;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Collection;
use Illuminate\Pagination\LengthAwarePaginator;

class PostNewsController extends Controller
{
    protected $seoController;

    public function __construct(SEOController $seoController)
    {
        $this->seoController = $seoController;
    }
  
    public function index()
    {
        // Fetch draft, pending, and published posts as separate queries
        $draftPosts = PostNews::where('status', 'draft')->latest()->get();
        $pendingPosts = PostNews::where('status', 'pending')->latest()->get();
        $publishedPosts = PostNews::where('status', 'published')->latest()->get();
    
        // Merge all posts into a single collection and sort them by date
        $allPosts = $draftPosts->merge($pendingPosts)->merge($publishedPosts)->sortByDesc('created_at');
    
        // Set pagination parameters
        $perPage = 20;
        $currentPage = LengthAwarePaginator::resolveCurrentPage();
        $currentItems = $allPosts->slice(($currentPage - 1) * $perPage, $perPage)->values(); // .values() to reset keys
    
        // Create a new LengthAwarePaginator instance
        $paginatedItems = new LengthAwarePaginator($currentItems, $allPosts->count(), $perPage, $currentPage, [
            'path' => request()->url(),
            'query' => request()->query(),
        ]);
    
        // Return the view with the paginated items
        return view('admin.post-news.index', compact('paginatedItems'));
    } 
    
    

    

    public function show()
    {
        // Fetch only published posts, ordered by the actual publication date (recent date first)
        $posts = PostNews::where('status', 'published')
                         ->orderBy('published_at', 'desc') // Assuming 'published_at' is the correct date field
                         ->paginate(4);
        
        // Fetch social follows, trending news, and tags
        $socialFollows = SocialFollows::all(); 
        $trendingNews = TrendingNews::where('section', 'body')->get(); 
        $tags = Tags::all();
        
        // Return the view with the ordered posts and other data
        return view('post-news.show', compact('posts', 'socialFollows', 'trendingNews', 'tags'));
    }
    
    // public function show()
    // {
    //     $posts = PostNews::where('status', 'published')->latest()->paginate(4);
    //     $socialFollows = SocialFollows::all(); // Assuming you have a SocialFollow model
    //     $trendingNews = TrendingNews::where('section', 'body')->get(); // Assuming you have a TrendingNews model
    //     $tags = Tags::all(); // Assuming you have a Tag model
    
    //     return view('post-news.show', compact('posts', 'socialFollows', 'trendingNews', 'tags'));
    // }
    

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


    public function store(Request $request)
{
    $request->validate([
        'headline' => 'required|max:255',
        'category_id' => 'required|exists:categories,id',
        'date' => 'required|date',
        'image' => 'required|image|max:2048',
        'content' => 'required',
        'meta_title' => 'nullable|max:255',
        'meta_description' => 'nullable',
        'meta_keywords' => 'nullable',
        'status' => 'required|in:draft,published,pending',
        'scheduled_for' => 'nullable|date',
    ]);

    $imagePath = null;
    if ($request->hasFile('image')) {
        $imageFile = $request->file('image');
        $imageFileName = "news_" . time() . '.' . $imageFile->extension();
        $location = public_path('images/news_images');
        $imageFile->move($location, $imageFileName);
        $imagePath = 'images/news_images/' . $imageFileName;
    }

    $post = new PostNews();
    $post->headline = $request->headline;
    $post->slug = Str::slug($request->headline);
    $post->category_id = $request->category_id;
    $post->date = $request->date;
    $post->image_url = $imagePath;
    $post->content = $request->content;
    $post->meta_title = $request->meta_title;
    $post->meta_description = $request->meta_description;
    $post->meta_keywords = $request->meta_keywords;
    $post->status = $request->status;
    $post->scheduled_for = $request->scheduled_for;

    $post->save();

        // Perform SEO analysis for all posts
        $this->seoController->analyze($post->id);

    if ($post->status == 'published') {
        $subscribers = Subscriber::all();
        foreach ($subscribers as $subscriber) {
            Mail::to($subscriber->email)->send(new NewsletterEmail($post, $subscriber->email));
        }
    }

    return redirect()->route('post-news.read-more', [
        'year' => $post->date->year,
        'month' => $post->date->month,
        'day' => $post->date->day,
        'slug' => $post->slug
    ])->with('success', 'News post created successfully.');

    // return redirect()->route('post-news.read-more', ['slug' => $post->slug])->with('success', 'News post created successfully.');
}




    
    public function update(Request $request, $id)
    {
        $post = PostNews::findOrFail($id);
    
        $request->validate([
            'headline' => 'required|max:255',
            'category_id' => 'required|exists:categories,id',
            'date' => 'required|date',
            'content' => 'required',
            'meta_title' => 'nullable|max:255',
            'meta_description' => 'nullable',
            'meta_keywords' => 'nullable',
            'status' => 'required|in:draft,published,pending',
            'scheduled_for' => 'nullable|date|after:now',
        ]);
    
        $post->headline = $request->headline;
        $post->slug = Str::slug($request->headline);
        $post->category_id = $request->category_id;
        $post->date = $request->date;
    
        if ($request->hasFile('image')) {
            $imageFile = $request->file('image');
            $imageFileName = "news_" . time() . '.' . $imageFile->extension();
            $location = public_path('images/news_images');
            $imageFile->move($location, $imageFileName);
            $post->image_url = 'images/news_images/' . $imageFileName;
        }
    
        $post->content = $request->content;
        $post->meta_title = $request->meta_title;
        $post->meta_description = $request->meta_description;
        $post->meta_keywords = $request->meta_keywords;
        $post->status = $request->status;
        $post->scheduled_for = $request->scheduled_for;
    
        $post->save(); // Save the post first
    
        if ($post->status == 'pending' && $post->scheduled_for) {
            // Perform SEO analysis
            $this->seoController->analyze($post->id);
        }


          // Send email to all subscribers
          if ($post->status == 'published') {
            $subscribers = Subscriber::all();
            foreach ($subscribers as $subscriber) {
                Mail::to($subscriber->email)->send(new NewsletterEmail($post, $subscriber->email));
            }
        }
        return redirect()->route('post-news.read-more', [
            'year' => $post->date->year,
            'month' => $post->date->month,
            'day' => $post->date->day,
            'slug' => $post->slug
        ])->with('success', 'News post updated successfully.');
    
    }
    

    public function approve($id)
    {
        $post = PostNews::findOrFail($id);
        $post->update(['status' => 'published']);

        // Send email to all subscribers
        $subscribers = Subscriber::all();
        foreach ($subscribers as $subscriber) {
            Mail::to($subscriber->email)->send(new NewsletterEmail($post, $subscriber->email));
        }

        return redirect()->back()->with('success', 'Post approved and published successfully.');
    }

    

    public function edit($id)
    {
        $post = PostNews::findOrFail($id);
        $categories = Category::all();
        return view('admin.post-news.edit', compact('post', 'categories'));
    }

    public function destroy($id)
    {
        $post = PostNews::findOrFail($id);
        $post->delete();
       
        return redirect()->back()->with('success', 'News post deleted successfully.');

        // return redirect()->route('post-news.index')->with('success', 'News post deleted successfully.');
    }
    
    
    public function readMore($year, $month, $day, $slug)
    {
        $tags = Tags::with('category')->get();
        $post = PostNews::where('slug', $slug)->firstOrFail();
        $socialFollows = SocialFollows::where('is_active', true)->get();
        $trendingNews = TrendingNews::with('postNews')->get();
    
        // Fetch related news - limit to 2 latest published news
        $relatedNews = PostNews::where('category_id', $post->category_id)
                               ->where('id', '!=', $post->id)
                               ->where('status', 'published') // Ensure the news is published
                               ->orderBy('created_at', 'desc') // Order by latest
                               ->limit(2)
                               ->get();
    
        // Prepare meta tags
        $metaTags = [
            'og_url' => url()->current(),
            'og_type' => 'website',
            'og_title' => $post->meta_title ?: $post->headline,
            'og_description' => strip_tags($post->meta_description ?: Str::limit($post->content, 150)),
            'og_image' => $post->image_url ? asset($post->image_url) : '',
    
            'twitter_card' => 'summary_large_image',
            'twitter_domain' => parse_url(url('/'), PHP_URL_HOST),
            'twitter_url' => url()->current(),
            'twitter_title' => $post->meta_title ?: $post->headline,
            'twitter_description' => strip_tags($post->meta_description ?: Str::limit($post->content, 150)),
            'twitter_image' => $post->image_url ? asset($post->image_url) : '',
        ];
    
        return view('post-news.read-more', compact('post', 'socialFollows', 'trendingNews', 'tags', 'relatedNews', 'metaTags'));
    }
    


  


}

//     public function readMore($year, $month, $day, $slug)
// {
//     $tags = Tags::with('category')->get();
//     $post = PostNews::where('slug', $slug)->firstOrFail();
//     $socialFollows = SocialFollows::where('is_active', true)->get();
//     $trendingNews = TrendingNews::with('postNews')->get();

//     // Fetch related news - limit to 2 latest published news
//     $relatedNews = PostNews::where('category_id', $post->category_id)
//                            ->where('id', '!=', $post->id)
//                            ->where('status', 'published') // Ensure the news is published
//                            ->orderBy('created_at', 'desc') // Order by latest
//                            ->limit(2)
//                            ->get();

//     return view('post-news.read-more', compact('post', 'socialFollows', 'trendingNews', 'tags', 'relatedNews'));
// }