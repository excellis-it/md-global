@extends('frontend.layouts.master')
@section('meta_title')
@endsection
@section('title')
Q&A / Blogs
@endsection
@push('styles')
@endpush

@section('content')
    <section class="inr-bnr">
        <div class="inr-bnr-img">
            <img src="{{ asset('frontend_assets/images/blog-bg.jpg') }}" alt="" />
            <div class="inr-bnr-text">
                <h1>Q&A / Blogs</h1>
            </div>
        </div>
    </section>
    <section class="q-acc">
        <div class="container">
            <div class="head-1 h-b text-center" data-aos="fade-up" data-aos-duration="1000">
                <h2>Frequently <span>Asked Questions</span></h2>
                <p>We have curated a list of general FAQs covering all your queries.</p>
            </div>
            <div class="q-acc" data-aos="fade-up" data-aos-duration="1000">
                <div class="accordion" id="accordionExample">
                    <div class="row justify-content-between">
                        @foreach ($qnas->chunk(5) as $items)
                        <div class="col-xl-6">
                            @foreach ($items as $key=>$item)
                            <div class="accordion-item">
                                <h2 class="accordion-header" id="headingOne">
                                    <button class="accordion-button @if($key==0) @else collapsed @endif" type="button" data-bs-toggle="collapse"
                                        data-bs-target="#collapse{{ $key }}" aria-expanded="true"
                                        aria-controls="collapse{{ $key }}">
                                        {{ $key+1 }}. {{ $item->question }}
                                    </button>
                                </h2>
                                <div id="collapse{{ $key }}" class="accordion-collapse collapse @if($key==0) show @endif"
                                    aria-labelledby="headingOne" data-bs-parent="#accordionExample">
                                    <div class="accordion-body">
                                        {!! $item->answer !!}
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        </div>
                        @endforeach
                        {{-- <div class="col-xl-6">
                            <div class="accordion-item">
                                <h2 class="accordion-header" id="headingSix">
                                    <button class="accordion-button collapsed" type="button"
                                        data-bs-toggle="collapse" data-bs-target="#collapseSix"
                                        aria-expanded="false" aria-controls="collapseSix">
                                        6. Can my employer contribute to my HSA?
                                    </button>
                                </h2>
                                <div id="collapseSix" class="accordion-collapse collapse"
                                    aria-labelledby="headingSix" data-bs-parent="#accordionExample">
                                    <div class="accordion-body">
                                        Yes, the contributions to HSAs can be made by you, your employer, or
                                        both. All the contributions are determined by whether you have
                                        contributed the maximum allowed or not. If your employer is contributing
                                        some of the money to your account, you can make up the difference. If
                                        your employer contributes to your HSA account, the contribution is not
                                        taxable to you, the employee.
                                    </div>
                                </div>
                            </div>
                            <div class="accordion-item">
                                <h2 class="accordion-header" id="headingSeven">
                                    <button class="accordion-button collapsed" type="button"
                                        data-bs-toggle="collapse" data-bs-target="#collapseSeven"
                                        aria-expanded="false" aria-controls="collapseSeven">
                                        7. What investment options can I get with my HSA?
                                    </button>
                                </h2>
                                <div id="collapseSeven" class="accordion-collapse collapse"
                                    aria-labelledby="headingSeven" data-bs-parent="#accordionExample">
                                    <div class="accordion-body">
                                        If you decide to buy into an HSA, then you have to make three basic
                                        choices:
                                        - Interest-bearing account
                                        - Money market account
                                        - Mutual funds account
                                    </div>
                                </div>
                            </div>
                            <div class="accordion-item">
                                <h2 class="accordion-header" id="headingEight">
                                    <button class="accordion-button collapsed" type="button"
                                        data-bs-toggle="collapse" data-bs-target="#collapseEight"
                                        aria-expanded="false" aria-controls="collapseEight">
                                        8. Can I use an HSA for my health insurance?
                                    </button>
                                </h2>
                                <div id="collapseEight" class="accordion-collapse collapse"
                                    aria-labelledby="headingEight" data-bs-parent="#accordionExample">
                                    <div class="accordion-body">
                                        Yes, the HSA is designed to cover the expenses not paid by your health
                                        plan, including deductibles, coinsurance, and copayments, as well as
                                        many expenses your health plan may not cover, such as acupuncture, eye
                                        surgery, and some over the counter medicines.
                                    </div>
                                </div>
                            </div>
                            <div class="accordion-item">
                                <h2 class="accordion-header" id="headingNine">
                                    <button class="accordion-button collapsed" type="button"
                                        data-bs-toggle="collapse" data-bs-target="#collapseNine"
                                        aria-expanded="false" aria-controls="collapseNine">
                                        9. What is a High Deductible Health Plan?
                                    </button>
                                </h2>
                                <div id="collapseNine" class="accordion-collapse collapse"
                                    aria-labelledby="headingNine" data-bs-parent="#accordionExample">
                                    <div class="accordion-body">
                                        A High Deductible Health Plan (HDHP) combines a Health Savings Account or a
                                        Health Reimbursement Arrangement with traditional medical coverage. It
                                        provides insurance coverage and a tax-advantaged way to help save future
                                        medical expenses. All these three give you greater flexibility and
                                        discretion over how you use your health care dollars because the funds can
                                        be used to cover qualified medical expenses that are not covered by your
                                        health plan.
                                    </div>
                                </div>
                            </div>
                            <div class="accordion-item">
                                <h2 class="accordion-header" id="headingTen">
                                    <button class="accordion-button collapsed" type="button"
                                        data-bs-toggle="collapse" data-bs-target="#collapseTen"
                                        aria-expanded="false" aria-controls="collapseTen">
                                        10. Does my HSA still in function after my death?
                                    </button>
                                </h2>
                                <div id="collapseTen" class="accordion-collapse collapse"
                                    aria-labelledby="headingTen" data-bs-parent="#accordionExample">
                                    <div class="accordion-body">
                                        You can designate a beneficiary or beneficiaries to receive your remaining
                                        HSA funds after your death. For example, your spouse can be the designated
                                        beneficiary of your HSA, and it will be treated as your spouse's HSA after
                                        your death. If your spouse is not the designated beneficiary of your HSA or
                                        the beneficiary is your estate. The account stops being an HSA, and the fair
                                        market value becomes taxable to the beneficiary in which year you die. If
                                        you don't designate a beneficiary, then the funds will be distributed
                                        according to the rules of the Custodial Agreement.
                                    </div>
                                </div>
                            </div>
                        </div> --}}
    
                    </div>
                </div>
            </div>
    </section>
    <section class="blog-inr">
        <div class="container">
            <div class="blog-inr-wrap">
                <div class="row justify-content-between">
                    <div class="col-xl-9 col-12" id="search-result">
                        @include('frontend.search-result')
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
                            <div class="cat-box">
                                <h4>SEARCH</h4>
                                <div class="search-form">
                                    <form action="javascript:void(0);">
                                        <input type="text" placeholder="search here" name="search" id="search-blog" data-route="{{ route('blogs.search') }}" />
                                        <button type="submit">
                                            <i class="fa fa-search"></i>
                                        </button>
                                    </form>
                                </div>
                            </div>
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


                <div class="pagi_1">
                    <nav aria-label="Page navigation example">
                        {{ $blogs->links() }}                                                                                                         
                    </nav>
                </div>
            </div>
        </div>
    </section>
@endsection

@push('scripts')
<script>
    $(document).ready(function() {
       $('#search-blog').keyup(function() {
           var search = $(this).val();
              var route = $(this).data('route');
               $.ajax({
                   url: route,
                   method: "POST",
                   data: {
                       "_token": "{{ csrf_token() }}",
                       "search": search
                   },
                   success: function(response) {
                       $('#search-result').html(response.view);
                   }
               });
           
       });
    });
</script>
@endpush
