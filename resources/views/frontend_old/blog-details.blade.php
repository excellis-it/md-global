@extends('frontend.layouts.master')
@section('meta_title')
@endsection
@section('title')
    Blogs
@endsection
@push('styles')
@endpush

@section('content')
    <section class="inr-bnr">
        <div class="inr-bnr-img">
            <img src="{{ asset('frontend_assets/images/blog-bg.jpg') }}" alt="" />
            <div class="inr-bnr-text">
                <h1>Blog</h1>
            </div>
        </div>
    </section>
    <section class="blog-inr">
        <div class="container">
            <div class="blog-inr-wrap">
                <div class="row justify-content-between">
                    <div class="col-xl-9 col-12">
                        <div class="blog-box-1">
                            <div class="blog-inr-img">
                                <img src="{{ Storage::url($blog['image']) }}" alt="" />
                            </div>
                            <div class="blog-text">
                                <div class="date-box d-flex align-items-center justify-content-end">
                                    <div class="bl-date-img">
                                        <img src="assets/images/date.png" alt="" />
                                    </div>
                                    <div class="bl-date">
                                        <h4>{{ date("d M' Y", strtotime($blog['created_at'])) }}</h4>
                                    </div>
                                </div>
                                <div class="blg-d">
                                    <div class="head-1 h-b pb-3">
                                        <h2>{{ $blog['title'] }}</h2>
                                    </div>
                                    <div class="para p-b">
                                        {!! $blog['content'] !!}
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                    <div class="col-xl-3 col-12">
                        @if (count($blogsCategories) > 0)
                            <div class="cat-div">
                                <div class="cat-box">
                                    <h4>CATEGORIES</h4>
                                    <ul class="cat-list">
                                        @foreach ($blogsCategories as $category)
                                            <li><a
                                                    href="{{ route('blogs', ['slug' => $category['slug']]) }}">{{ $category['name'] }}</a>
                                            </li>
                                        @endforeach
                                    </ul>
                                </div>
                            </div>
                        @endif
                        <div class="cat-div">
                            {{-- <div class="cat-box">
                                <h4>SEARCH</h4>
                                <div class="search-form">
                                    <form action="/">
                                        <input type="text" placeholder="search here" name="search" />
                                        <button type="submit">
                                            <i class="fa fa-search"></i>
                                        </button>
                                    </form>
                                </div>
                            </div> --}}
                        </div>
                        @if (count($lastBlogs) > 0)
                            <div class="cat-div">
                                <div class="cat-box">
                                    <h4>LAST 10 POST</h4>
                                    <ul class="cat-list">
                                        @foreach ($lastBlogs as $lastBlog)
                                            <li><a
                                                    href="{{ route('blogs.details', ['category_slug' => $lastBlog['category']['slug'], 'blog_slug' => $lastBlog['slug']]) }}">
                                                    {{ $lastBlog['title'] }}
                                                </a></li>
                                        @endforeach
                                    </ul>
                                </div>
                            </div>
                        @endif
                        {{-- <div class="cat-div">
                            <div class="cat-box">
                                <h4>FIRST 10 POSTS</h4>
                                <ul class="cat-list">
                                    <li>
                                        <a href="#">Five Benefits Of Individual Health Insurance</a>
                                    </li>
                                    <li>
                                        <a href="#">What Are the Advantages of Group Health Insurance?</a>
                                    </li>
                                </ul>
                            </div>
                        </div> --}}
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@push('scripts')
@endpush
