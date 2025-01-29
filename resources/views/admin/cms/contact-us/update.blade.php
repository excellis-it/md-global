@extends('admin.layouts.master')
@section('title')
    Update Contact Us Page Content - {{ env('APP_NAME') }} admin
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
                        <h3 class="page-title">Contact Us Page Information</h3>
                        <ul class="breadcrumb">
                            <li class="breadcrumb-item">CMS</li>
                            <li class="breadcrumb-item"><a href="{{ route('cms.contact-us.index') }}">Contact Page</a></li>
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
                                <h6 class="mb-0 text-uppercase">Update Contact Us Page Content</h6>
                                <hr>
                                <div class="card border-0 border-4">
                                    <div class="card-body">
                                        <form action="{{ route('cms.contact-us.update') }}" method="POST"
                                            enctype="multipart/form-data">
                                            @csrf
                                            <input type="hidden" name="id" value="{{ $contactUs->id }}">
                                            <div class="border p-4 rounded">
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <label for="inputEnterYourName" class="col-form-label"> Contact Page Title
                                                            <span style="color: red;">*</span></label>
                                                            <textarea type="text" name="contact_page_title" id="contact_page_title"
                                                            class="form-control" value=""
                                                            placeholder="Enter Title">{{ $contactUs['contact_page_title'] }}</textarea>
                                                        @if ($errors->has('contact_page_title'))
                                                            <div class="error" style="color:red;">
                                                                {{ $errors->first('contact_page_title') }}</div>
                                                        @endif
                                                    </div>
                                                    <div class="col-md-6">
                                                        <label for="inputEnterYourName" class="col-form-label"> Visit Us <span
                                                                style="color: red;">*</span></label>
                                                        <input type="text" name="visit_us" id=""
                                                            class="form-control" value="{{ $contactUs['visit_us'] }}"
                                                            placeholder="Enter Visit Us">
                                                        @if ($errors->has('visit_us'))
                                                            <div class="error" style="color:red;">
                                                                {{ $errors->first('visit_us') }}</div>
                                                        @endif
                                                    </div>
                                                    <div class="col-md-6">
                                                        <label for="inputEnterYourName" class="col-form-label"> Call Us <span
                                                                style="color: red;">*</span></label>
                                                        <input type="text" name="call_us" id=""
                                                            class="form-control" value="{{ $contactUs['call_us'] }}"
                                                            placeholder="Call Us">
                                                        @if ($errors->has('call_us'))
                                                            <div class="error" style="color:red;">
                                                                {{ $errors->first('call_us') }}</div>
                                                        @endif
                                                    </div>
                                                    <div class="col-md-6">
                                                        <label for="inputEnterYourName" class="col-form-label"> Mail Us <span
                                                                style="color: red;">*</span></label>
                                                        <input type="text" name="mail_us" id=""
                                                            class="form-control" value="{{ $contactUs['mail_us'] }}"
                                                            placeholder="Mail Us">
                                                        @if ($errors->has('mail_us'))
                                                            <div class="error" style="color:red;">
                                                                {{ $errors->first('mail_us') }}</div>
                                                        @endif
                                                    </div>

                                                    <div class="col-md-12 mt-4 mb-2">
                                                        <h6 class="mb-0 text-uppercase">SEO Content</h6>
                                                        <hr>
                                                    </div>

                                                    <div class="col-md-6 mb-3">
                                                        <label for="inputEnterYourName" class="col-form-label"> Meta Title </label>
                                                        <input type="text" name="meta_title" id=""
                                                            class="form-control" value="{{ $contactUs['meta_title'] }}"  placeholder="Meta Title">
                                                        @if ($errors->has('meta_title'))
                                                            <div class="error" style="color:red;">
                                                                {{ $errors->first('meta_title') }}</div>
                                                        @endif
                                                    </div>

                                                    <div class="col-md-6 mb-3">
                                                        <label for="inputEnterYourName" class="col-form-label"> Meta keywords  </label>
                                                        <input type="text" name="meta_keyword" id=""
                                                            class="form-control" value="{{ $contactUs['meta_keyword'] }}"  placeholder="Meta Keywords">
                                                        @if ($errors->has('meta_keyword'))
                                                            <div class="error" style="color:red;">
                                                                {{ $errors->first('meta_keyword') }}</div>
                                                        @endif
                                                    </div>

                                                    <div class="col-md-12 mb-3">
                                                        <label for="inputEnterYourName" class="col-form-label"> Meta description </label>
                                                        <textarea type="text" name="meta_description" id=""
                                                            class="form-control" cols="30" rows="10" value=""  placeholder="Meta Description">{{ $contactUs['meta_description'] }}</textarea>
                                                        @if ($errors->has('meta_description'))
                                                            <div class="error" style="color:red;">
                                                                {{ $errors->first('meta_description') }}</div>
                                                        @endif
                                                    </div>

                                                    <div class="row" style="margin-top: 20px; float: left;">
                                                        <div class="col-sm-9">
                                                            <button type="submit"
                                                                class="btn px-5 submit-btn">Update</button>
                                                        </div>
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
    ClassicEditor.create(document.querySelector("#contact_page_title"));
</script>

@endpush
