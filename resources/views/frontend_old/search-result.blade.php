@if (count($blogs) > 0)
    @foreach ($blogs as $blog)
        <div class="blog-box-1">
            <div class="blog-inr-img">
                <img src="{{ Storage::url($blog['image']) }}" alt="" />
            </div>
            <div class="blog-text">
                <div class="date-box d-flex align-items-center justify-content-end">
                    <div class="bl-date-img">
                        <img src="{{ asset('frontend_assets/images/date.png') }}" alt="" />
                    </div>
                    <div class="bl-date">
                        <h4>{{ date("d M' Y", strtotime($blog['created_at'])) }}</h4>
                    </div>
                </div>
                <div class="head-1 h-b pb-3">
                    <h2>{{ $blog['title'] }}</h2>
                </div>
                <div class="para p-b">
                    <p>
                        {!! substr($blog['content'], 0, 250) !!}
                    </p>
                </div>
                <div class="main-btn pt-4">
                    <a href="{{ route('blogs.details', ['category_slug' => $blog['category']['slug'], 'blog_slug' => $blog['slug']]) }}"
                        tabindex="0"><span>read more</span><span class="btn-arw"><i
                                class="fa-solid fa-arrow-right"></i></span></a>
                </div>
            </div>
        </div>
    @endforeach
@else
    <div>
        <h2>No blogs found</h2>
    </div>
@endif
