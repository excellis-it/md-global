@extends('frontend.layouts.master')
@section('meta_title')
@endsection
@section('title')
    Specialist
@endsection
@push('styles')
@endpush

@section('content')
    <section class="inr-bnr">
        <div class="inr-bnr-img">
            <img src="{{ asset('frontend_assets/images/category-bg.jpg') }}">
            <div class="inr-bnr-text">
                <h1>Categories</h1>
            </div>
        </div>
    </section>
    @if ($speciliaztions->count() > 0)
        <section class="search-bar-1">
            <div class="container">
                <div class="search-bar-1-wrap">
                    <div class="row justify-content-end">
                        <div class="col-xl-3">
                            <div class="search_box">
                                <div class="search_field">
                                    <input type="text" class="input search-specilzation"
                                        placeholder="Search specilzation">
                                    <button type="button"><i class="fas fa-search"></i></button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <section class="cat-box-1">
            <div class="container">
                <div class="cat-box-wrap">
                    @include('frontend.search-specilzation')
                </div>
            </div>
        </section>
    @else
    <section class="career">
        <div class="container">
          <div class="wrapper">
            <div class="content">
              <h1>No Specialization Found</h1>
            </div>
          </div>
        </div>
      </section>
    @endif
@endsection

@push('scripts')
    <script>
        $(document).ready(function() {
            $('.search-specilzation').on('keyup', function() {
                var query = $(this).val();
                $.ajax({
                    url: "{{ route('search.specilzation') }}",
                    type: "GET",
                    data: {
                        search: query
                    },
                    success: function(resp) {
                        // console.log(resp);
                        $('.cat-box-wrap').html(resp.view);
                    }
                });

            });
        });
    </script>
@endpush
