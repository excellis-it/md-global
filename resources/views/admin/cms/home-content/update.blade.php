@extends('admin.layouts.master')
@section('title')
    Update Home Page Content - {{ env('APP_NAME') }} admin
@endsection
@push('styles')
    <style>
        .dataTables_filter {
            margin-bottom: 10px !important;
        }

        .ck-editor__editable_inline {
            height: 200px;
        }
    </style>
@endpush

@section('content')
    <section id="loading">
        <div id="loading-content"></div>
    </section>
    <div class="page-wrapper">

        <div class="content container-fluid">

            <div class="page-header">
                <div class="row align-items-center">
                    <div class="col">
                        <h3 class="page-title">Home Page Information</h3>
                        <ul class="breadcrumb">
                            <li class="breadcrumb-item">CMS</li>
                            <li class="breadcrumb-item"><a href="{{ route('cms.home.index') }}">Contact Page</a></li>
                        </ul>
                    </div>
                    <div class="col-auto float-end ms-auto">
                        {{-- <a href="#" class="btn add-btn" data-bs-toggle="modal" data-bs-target="#add_qna"><i
                                class="fa fa-plus"></i> Add QNA</a> --}}
                    </div>
                </div>
            </div>

            <div class="card">
                <div class="card-body">
                    <div class="card-title">
                        <div class="row">
                            <div class="col-xl-12 mx-auto">
                                <h6 class="mb-0 text-uppercase">Update Home Page Content</h6>
                                <hr>
                                <div class="card border-0 border-4">
                                    <div class="card-body">
                                        <form action="{{ route('cms.home-content.update') }}" method="POST"
                                            enctype="multipart/form-data">
                                            @csrf
                                            <input type="hidden" name="id" value="{{ $home->id ?? '' }}">
                                            <div class="border p-4 rounded label_color">
                                                <div class="row">
                                                    <div class="col-md-12 mb-3">
                                                        <label for="inputEnterYourName" class="col-form-label"> Section 1
                                                            Title
                                                            <span style="color: red;">*</span></label>
                                                        <textarea type="text" name="section_1_title" id="section_1_title"
                                                            class="form-control"
                                                            value=""
                                                            placeholder="Enter Section 1 Title">{{ $home['section_1_title'] ?? '' }}</textarea>
                                                        @if ($errors->has('section_1_title'))
                                                            <div class="error" style="color:red;">
                                                                {{ $errors->first('section_1_title') }}</div>
                                                        @endif
                                                    </div>
                                                    <div class="col-md-12 mb-3">
                                                        <label for="inputEnterYourName" class="col-form-label"> Section 1
                                                            Description <span style="color: red;">*</span></label>
                                                        <textarea type="text" name="section_1_description"
                                                            id="section_1_description" class="form-control"
                                                            placeholder="Enter Section 1 Description">{{ $home['section_1_description'] ?? '' }}</textarea>
                                                        @if ($errors->has('section_1_description'))
                                                            <div class="error" style="color:red;">
                                                                {{ $errors->first('section_1_description') }}</div>
                                                        @endif
                                                    </div>
                                                    <div class="col-md-12 mt-4 mb-2">
                                                        <h3 class="mb-0 text-uppercase">Blog</h3>
                                                        <hr>
                                                    </div>
                                                    <div class="col-md-12 mb-3">
                                                        <label for="inputEnterYourName" class="col-form-label"> Section 2
                                                            Title <span style="color: red;">*</span></label>
                                                        <textarea type="text" name="section_2_title" id="section_2_title"
                                                            class="form-control"
                                                            value=""
                                                            placeholder="Enter Section 2 Title">{{ $home['section_2_title'] ?? '' }}</textarea>
                                                        @if ($errors->has('section_2_title'))
                                                            <div class="error" style="color:red;">
                                                                {{ $errors->first('section_2_title') }}</div>
                                                        @endif
                                                    </div>
                                                    <div class="col-md-12 mb-3">
                                                        <label for="inputEnterYourName" class="col-form-label"> Section 2
                                                            Description <span style="color: red;">*</span></label>
                                                        <textarea type="text" name="section_2_description"
                                                            id="section_2_description" class="form-control"
                                                            placeholder="Enter Section 2 Description">{{ $home['section_2_description'] ?? '' }}</textarea>
                                                        @if ($errors->has('section_2_description'))
                                                            <div class="error" style="color:red;">
                                                                {{ $errors->first('section_2_description') }}</div>
                                                        @endif
                                                    </div>


                                                    {{-- Collaboration --}}
                                                    <div class="col-md-12 mt-4 mb-2">
                                                        <h3 class="mb-0 text-uppercase">Collaboration</h3>
                                                        <hr>
                                                    </div>
                                                    {{-- section 1 --}}
                                                    <div class="col-md-12 mb-3">
                                                        <label for="inputEnterYourName" class="col-form-label"> Section 1
                                                            Title
                                                            <span style="color: red;">*</span></label>
                                                        <textarea type="text" name="colab_section_1_title" id="colab_section_1_title"
                                                            class="form-control"
                                                            value=""
                                                            placeholder="Enter Section 1 Title">{{ $home['colab_section_1_title'] ?? '' }}</textarea>
                                                        @if ($errors->has('colab_section_1_title'))
                                                            <div class="error" style="color:red;">
                                                                {{ $errors->first('colab_section_1_title') }}</div>
                                                        @endif
                                                    </div>
                                                    <div class="col-md-12 mb-3">
                                                        <label for="inputEnterYourName" class="col-form-label"> Section 1
                                                            Description
                                                            <span style="color: red;">*</span></label>
                                                        <textarea type="text" name="colab_section_1_description"
                                                            id="colab_section_1_description" class="form-control"
                                                            placeholder="Enter Section 1 Description">{{ $home['colab_section_1_description'] ?? '' }}</textarea>
                                                        @if ($errors->has('colab_section_1_description'))
                                                            <div class="error" style="color:red;">
                                                                {{ $errors->first('colab_section_1_description') }}</div>
                                                        @endif
                                                    </div>
                                                    <div class="col-md-12 mb-3">
                                                        <label for="inputEnterYourName" class="col-form-label"> Section 1
                                                            Link
                                                            <span style="color: red;">*</span></label>
                                                        <input type="text" name="colab_section_1_link" id=""
                                                            class="form-control"
                                                            value="{{ $home['colab_section_1_link'] ?? '' }}"
                                                            placeholder="Enter Section 1 Title">
                                                        @if ($errors->has('colab_section_1_link'))
                                                            <div class="error" style="color:red;">
                                                                {{ $errors->first('colab_section_1_link') }}</div>
                                                        @endif
                                                    </div>
                                                    {{-- section 2 --}}
                                                    <div class="col-md-12 mb-3">
                                                        <label for="inputEnterYourName" class="col-form-label"> Section 2
                                                            Title
                                                            <span style="color: red;">*</span></label>
                                                        <textarea type="text" name="colab_section_2_title" id="colab_section_2_title"
                                                            class="form-control"
                                                            value=""
                                                            placeholder="Enter Section 2 Title">{{ $home['colab_section_2_title'] ?? '' }}</textarea>
                                                        @if ($errors->has('colab_section_2_title'))
                                                            <div class="error" style="color:red;">
                                                                {{ $errors->first('colab_section_2_title') }}</div>
                                                        @endif
                                                    </div>

                                                    <div class="col-md-12 mb-3">
                                                        <label for="inputEnterYourName" class="col-form-label"> Section 2
                                                            Description
                                                            <span style="color: red;">*</span></label>
                                                        <textarea type="text" name="colab_section_2_description"
                                                            id="colab_section_2_description" class="form-control"
                                                            placeholder="Enter Section 2 Description">{{ $home['colab_section_2_description'] ?? '' }}</textarea>
                                                        @if ($errors->has('colab_section_2_description'))
                                                            <div class="error" style="color:red;">
                                                                {{ $errors->first('colab_section_2_description') }}</div>
                                                        @endif
                                                    </div>
                                                    <div class="col-md-12 mb-3">
                                                        <label for="inputEnterYourName" class="col-form-label"> Section 2
                                                            Link
                                                            <span style="color: red;">*</span></label>
                                                        <input type="text" name="colab_section_2_link" id=""
                                                            class="form-control"
                                                            value="{{ $home['colab_section_2_link'] ?? '' }}"
                                                            placeholder="Enter Section 2 Title">
                                                        @if ($errors->has('colab_section_2_link'))
                                                            <div class="error" style="color:red;">
                                                                {{ $errors->first('colab_section_2_link') }}</div>
                                                        @endif
                                                    </div>
                                                    {{-- section 3 --}}
                                                    <div class="col-md-12 mb-3">
                                                        <label for="inputEnterYourName" class="col-form-label"> Section 3
                                                            Title
                                                            <span style="color: red;">*</span></label>
                                                        <textarea type="text" name="colab_section_3_title" id="colab_section_3_title"
                                                            class="form-control"
                                                            value=""
                                                            placeholder="Enter Section 3 Title">{{ $home['colab_section_3_title'] ?? '' }}</textarea>
                                                        @if ($errors->has('colab_section_3_title'))
                                                            <div class="error" style="color:red;">
                                                                {{ $errors->first('colab_section_3_title') }}</div>
                                                        @endif
                                                    </div>
                                                    <div class="col-md-12 mb-3">
                                                        <label for="inputEnterYourName" class="col-form-label"> Section 3
                                                            Description
                                                            <span style="color: red;">*</span></label>
                                                        <textarea type="text" name="colab_section_3_description"
                                                            id="colab_section_3_description" class="form-control"
                                                            placeholder="Enter Section 3 Description">{{ $home['colab_section_3_description'] ?? '' }}</textarea>
                                                        @if ($errors->has('colab_section_3_description'))
                                                            <div class="error" style="color:red;">
                                                                {{ $errors->first('colab_section_3_description') }}</div>
                                                        @endif
                                                    </div>
                                                    <div class="col-md-12 mb-3">
                                                        <label for="inputEnterYourName" class="col-form-label"> Section 3
                                                            Link
                                                            <span style="color: red;">*</span></label>
                                                        <input type="text" name="colab_section_3_link" id=""
                                                            class="form-control"
                                                            value="{{ $home['colab_section_3_link'] ?? '' }}"
                                                            placeholder="Enter Section 3 Title">
                                                        @if ($errors->has('colab_section_3_link'))
                                                            <div class="error" style="color:red;">
                                                                {{ $errors->first('colab_section_3_link') }}</div>
                                                        @endif
                                                    </div>


                                                    {{-- About US --}}
                                                    {{-- section 1 --}}
                                                    <div class="col-md-12 mt-4 mb-2">
                                                        <h3 class="mb-0 text-uppercase">About US</h3>
                                                        <hr>
                                                    </div>
                                                    <div class="col-md-12 mb-3">
                                                        <label for="inputEnterYourName" class="col-form-label"> Section
                                                            Title
                                                            <span style="color: red;">*</span></label>
                                                        <textarea type="text" name="about_section_title" id="about_section_title"
                                                            class="form-control"
                                                            value=""
                                                            placeholder="Enter Section Title">{{ $home['about_section_title'] ?? '' }}</textarea>
                                                        @if ($errors->has('about_section_title'))
                                                            <div class="error" style="color:red;">
                                                                {{ $errors->first('about_section_title') }}</div>
                                                        @endif
                                                    </div>
                                                    <div class="col-md-12 mb-3">
                                                        <label for="inputEnterYourName" class="col-form-label"> Section
                                                            Description
                                                            <span style="color: red;">*</span></label>
                                                        <textarea name="about_section_description" id="about_section_description" class="form-control"
                                                            placeholder="Enter Section Description">{{ $home['about_section_description'] ?? '' }}</textarea>
                                                        @if ($errors->has('about_section_description'))
                                                            <div class="error" style="color:red;">
                                                                {{ $errors->first('about_section_description') }}</div>
                                                        @endif
                                                    </div>
                                                    <div class="col-md-12 mb-3">
                                                        <label for="inputEnterYourName" class="col-form-label"> Section
                                                            Link
                                                            <span style="color: red;">*</span></label>
                                                        <input type="text" name="about_section_link" id=""
                                                            class="form-control"
                                                            value="{{ $home['about_section_link'] ?? '' }}"
                                                            placeholder="Enter Section Link">
                                                        @if ($errors->has('about_section_link'))
                                                            <div class="error" style="color:red;">
                                                                {{ $errors->first('about_section_link') }}</div>
                                                        @endif
                                                    </div>

                                                    {{-- Our Services --}}
                                                    {{-- section 1 --}}
                                                    <div class="col-md-12 mt-4 mb-2">
                                                        <h3 class="mb-0 text-uppercase">Our Services</h3>
                                                        <hr>
                                                    </div>
                                                    <div class="col-md-12 mb-3">
                                                        <label for="inputEnterYourName" class="col-form-label"> Section
                                                            Title
                                                            <span style="color: red;">*</span></label>
                                                        <textarea type="text" name="services_section_title"
                                                            id="services_section_title" class="form-control"
                                                            value=""
                                                            placeholder="Enter Section Title">{{ $home['services_section_title'] ?? '' }}</textarea>
                                                        @if ($errors->has('services_section_title'))
                                                            <div class="error" style="color:red;">
                                                                {{ $errors->first('services_section_title') }}</div>
                                                        @endif
                                                    </div>
                                                    {{-- Testimonial --}}
                                                    {{-- section 1 --}}
                                                    <div class="col-md-12 mt-4 mb-2">
                                                        <h3 class="mb-0 text-uppercase">Testimonial</h3>
                                                        <hr>
                                                    </div>
                                                    <div class="col-md-12">
                                                        <label for="inputEnterYourName" class="col-form-label"> Section
                                                            Title
                                                            <span style="color: red;">*</span></label>
                                                        <textarea type="text" name="testimonial_section_title"
                                                            id="testimonial_section_title" class="form-control"
                                                            value=""
                                                            placeholder="Enter Section Title">{{ $home['testimonial_section_title'] ?? '' }}</textarea>
                                                        @if ($errors->has('testimonial_section_title'))
                                                            <div class="error" style="color:red;">
                                                                {{ $errors->first('testimonial_section_title') }}</div>
                                                        @endif
                                                    </div>


                                                    <div class="col-md-12 mt-4 mb-2">
                                                        <h3 class="mb-0 text-uppercase">SEO Content</h3>
                                                        <hr>
                                                    </div>

                                                    <div class="col-md-6 mb-3">
                                                        <label for="inputEnterYourName" class="col-form-label"> Meta Title </label>
                                                        <input type="text" name="meta_title" id=""
                                                            class="form-control" value="{{ $home['meta_title'] }}"  placeholder="Meta Title">
                                                        @if ($errors->has('meta_title'))
                                                            <div class="error" style="color:red;">
                                                                {{ $errors->first('meta_title') }}</div>
                                                        @endif
                                                    </div>

                                                    <div class="col-md-6 mb-3">
                                                        <label for="inputEnterYourName" class="col-form-label"> Meta keywords  </label>
                                                        <input type="text" name="meta_keyword" id=""
                                                            class="form-control" value="{{ $home['meta_keyword'] }}"  placeholder="Meta Keywords">
                                                        @if ($errors->has('meta_keyword'))
                                                            <div class="error" style="color:red;">
                                                                {{ $errors->first('meta_keyword') }}</div>
                                                        @endif
                                                    </div>

                                                    <div class="col-md-12 mb-3">
                                                        <label for="inputEnterYourName" class="col-form-label"> Meta description </label>
                                                        <textarea type="text" name="meta_description" id=""
                                                            class="form-control" cols="30" rows="10" value=""  placeholder="Meta Description">{{ $home['meta_description'] }}</textarea>
                                                        @if ($errors->has('meta_description'))
                                                            <div class="error" style="color:red;">
                                                                {{ $errors->first('meta_description') }}</div>
                                                        @endif
                                                    </div>

                                                <div class="row" style="margin-top: 20px; float: left;">
                                                    <div class="col-sm-9">
                                                        <button type="submit" class="btn px-5 submit-btn">Update</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
@endsection

@push('scripts')
    <script src="https://cdn.ckeditor.com/ckeditor5/28.0.0/classic/ckeditor.js"></script>
    <script>
        ClassicEditor.create(document.querySelector("#section_1_title"));
        ClassicEditor.create(document.querySelector("#section_2_title"));
        ClassicEditor.create(document.querySelector("#colab_section_1_title"));
        ClassicEditor.create(document.querySelector("#colab_section_2_title"));
        ClassicEditor.create(document.querySelector("#colab_section_3_title"));
        ClassicEditor.create(document.querySelector("#about_section_title"));
        ClassicEditor.create(document.querySelector("#services_section_title"));
        ClassicEditor.create(document.querySelector("#testimonial_section_title"));
        ClassicEditor.create(document.querySelector("#section_1_description"));
        ClassicEditor.create(document.querySelector("#section_2_description"));
        ClassicEditor.create(document.querySelector("#colab_section_1_description"));
        ClassicEditor.create(document.querySelector("#colab_section_2_description"));
        ClassicEditor.create(document.querySelector("#colab_section_3_description"));
        ClassicEditor.create(document.querySelector("#about_section_description"));
    </script>
@endpush
