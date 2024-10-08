<!-- Tags Start -->

<div class="pb-3">
    <div class="bg-light py-2 px-4 mb-3" style="background-color: #f8f9fa;">
        <h3 class="m-0" style="color: #212529;">Tags</h3>
    </div>
    <div class="d-flex flex-wrap m-n1">
        @foreach ($tags as $tag)
        <a href="{{ route('category.show', $tag->category->slug) }}" class="btn btn-sm btn-outline-secondary m-1" style="color: #333; border-color: #333; background-color: #fff;" aria-label="Tag: {{ $tag->category->name }}">
            {{ $tag->category->name }}
        </a>
        @endforeach
    </div>
</div> 

{{-- 
<div class="col-lg-3 col-md-6 mb-5">
    <h4 class="font-weight-bold mb-4" style="color: #212529;">Tags</h4>
    <div class="d-flex flex-wrap m-n1">
        @foreach ($tags as $tag)
        <a href="{{ route('category.show', $tag->category->slug) }}" class="btn btn-sm btn-outline-secondary m-1 tag-link" style="color: #333; border-color: #333; background-color: #fff;">
            {{ $tag->category->name }}
        </a>
        @endforeach
    </div>
</div> --}}




<!-- Tags End -->


















{{-- <!-- Tags Start -->
<div class="pb-3">
    <div class="bg-light py-2 px-4 mb-3" style="background-color: #f8f9fa;">
        <h3 class="m-0" style="color: #212529;">Tags</h3>
    </div>
    <div class="d-flex flex-wrap m-n1">
        @foreach ($tags as $tag)
        <a href="{{ route('category.show', $tag->category->slug) }}" class="btn btn-sm btn-outline-secondary m-1" style="color: #333; border-color: #333; background-color: #fff;">
            {{ $tag->category->name }}
        </a>
        @endforeach
    </div>
</div>
<!-- Tags End --> --}}
