@extends('admin.layouts.master')
@section('title')
    {{ env('APP_NAME') }} | Edit Blogs Details
@endsection
@push('styles')
@endpush

@section('content')
    <div class="page-wrapper">

        <div class="content container-fluid">

            <div class="page-header">
                <div class="row align-items-center">
                    <div class="col">
                        <h3 class="page-title">Edit Details</h3>
                        <ul class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('blogs.index') }}">Blogs</a></li>
                            <li class="breadcrumb-item active">Edit Blogs Details</li>
                        </ul>
                    </div>
                    <div class="col-auto float-end ms-auto">
                        {{-- <a href="#" class="btn add-btn" data-bs-toggle="modal" data-bs-target="#add_group"><i
                            class="fa fa-plus"></i> Add Blogs</a> --}}
                    </div>
                </div>
            </div>

            <div class="card">
                <div class="card-body">
                    <div class="card-title">
                        <div class="row">
                            <div class="col-xl-12 mx-auto">
                                <h6 class="mb-0 text-uppercase">Edit A Blogs</h6>
                                <hr>
                                <div class="card border-0 border-4">
                                    <div class="card-body">
                                        <form action="{{ route('blogs.update') }}" method="POST"
                                            enctype="multipart/form-data">
                                            @csrf
                                            <input type="hidden" name="id" value="{{ $blog->id }}">
                                            <div class="border p-4 rounded">
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <label for="inputEnterYourName" class="col-form-label"> Category
                                                            <span style="color: red;">*</span></label>
                                                        <select name="blog_category_id" id="blog_category_id" class="form-control">
                                                            <option value="">Select a category</option>
                                                            @foreach ($categories as $category)
                                                                <option value="{{ $category['id'] }}" @if($category['blog_category_id'] = $blog['blog_category_id']) selected @endif>
                                                                    {{ $category['name'] }}</option>
                                                            @endforeach
                                                        </select>
                                                        @if ($errors->has('blog_category_id'))
                                                            <div class="error" style="color:red;">
                                                                {{ $errors->first('blog_category_id') }}</div>
                                                        @endif
                                                    </div>
                                                    <div class="col-md-6">
                                                        <label for="inputEnterYourName" class="col-form-label"> Title <span
                                                                style="color: red;">*</span></label>
                                                        <input type="text" name="title" id=""
                                                            class="form-control" value="{{ $blog['title'] }}"
                                                            placeholder="Enter Blog Title">
                                                        @if ($errors->has('title'))
                                                            <div class="error" style="color:red;">
                                                                {{ $errors->first('title') }}</div>
                                                        @endif
                                                    </div>
                                                    <div class="col-md-6">
                                                        <label for="inputEnterYourName" class="col-form-label"> Slug <span
                                                                style="color: red;">*</span></label>
                                                        <input type="text" name="slug" id=""
                                                            class="form-control" value="{{ $blog['slug'] }}"
                                                            placeholder="Enter Blog Slug">
                                                        @if ($errors->has('slug'))
                                                            <div class="error" style="color:red;">
                                                                {{ $errors->first('slug') }}</div>
                                                        @endif
                                                    </div>

                                                    <div class="col-md-6">
                                                        <label for="inputEnterYourName" class="col-form-label"> Status
                                                            <span style="color: red;">*</span></label>
                                                        <select name="status" id="" class="form-control">
                                                            <option value="">Select a Status</option>
                                                            <option value="1"
                                                                @if ($blog['status'] == 1) selected="" @endif>Active
                                                            </option>
                                                            <option value="0"
                                                                @if ($blog['status'] == 0) selected="" @endif>
                                                                Inactive</option>
                                                        </select>
                                                        @if ($errors->has('status'))
                                                            <div class="error" style="color:red;">
                                                                {{ $errors->first('status') }}</div>
                                                        @endif
                                                    </div>

                                                    <div class="col-md-6">
                                                        <label for="inputEnterYourName" class="col-form-label"> Image </label>
                                                        <input type="file" name="image" id=""
                                                            class="form-control"
                                                            value="{{ $blog['image'] }}">
                                                        @if ($errors->has('image'))
                                                            <div class="error" style="color:red;">
                                                                {{ $errors->first('image') }}</div>
                                                        @endif
                                                    </div>
                                                    @if ($blog['image'])
                                                        <div class="col-md-6">
                                                            <label for="inputEnterYourName" class="col-form-label">View
                                                                Profile Picture </label>
                                                            <br>
                                                            <img src="{{ Storage::url($blog['image']) }}"
                                                                alt="" class="img-design">
                                                        </div>
                                                    @endif
                                                    <div class="col-md-12">
                                                        <label for="inputEnterYourName" class="col-form-label"> Content
                                                            <span style="color: red;">*</span></label>
                                                        <textarea name="content" id="" cols="30" rows="10"
                                                            class="form-control">{{ $blog['content'] }}</textarea>
                                                        @if ($errors->has('content'))
                                                            <div class="error" style="color:red;">
                                                                {{ $errors->first('content') }}</div>
                                                        @endif
                                                    </div>

                                                    <div class="col-md-12 mt-4 mb-2">
                                                        <h6 class="mb-0 text-uppercase">SEO Content</h6>
                                                        <hr>
                                                    </div>

                                                    <div class="col-md-6 mb-3">
                                                        <label for="inputEnterYourName" class="col-form-label"> Meta Title </label>
                                                        <input type="text" name="meta_title" id=""
                                                            class="form-control" value="{{ $blog['meta_title'] }}" placeholder="Enter Meta Title">
                                                        @if ($errors->has('meta_title'))
                                                            <div class="error" style="color:red;">
                                                                {{ $errors->first('meta_title') }}</div>
                                                        @endif
                                                    </div>

                                                    <div class="col-md-6 mb-3">
                                                        <label for="inputEnterYourName" class="col-form-label"> Meta keywords  </label>
                                                        <input type="text" name="meta_keyword" id=""
                                                            class="form-control" value="{{ $blog['meta_keyword'] }}" placeholder="Enter Meta Keywords">
                                                        @if ($errors->has('meta_keyword'))
                                                            <div class="error" style="color:red;">
                                                                {{ $errors->first('meta_keyword') }}</div>
                                                        @endif
                                                    </div>

                                                    <div class="col-md-12 mb-3">
                                                        <label for="inputEnterYourName" class="col-form-label"> Meta description </label>
                                                        <textarea type="text" name="meta_description" id=""
                                                            class="form-control" cols="30" rows="10" value="" placeholder="Enter Meta Description">{{ $blog['meta_description'] }}</textarea>
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
<script src="https://cdn.ckeditor.com/4.13.0/standard/ckeditor.js"></script>
    <script>
        CKEDITOR.replace('content');
        CKEDITOR.on('instanceReady', function(evt) {
            var editor = evt.editor;

            editor.on('change', function(e) {
                var contentSpace = editor.ui.space('contents');
                var ckeditorFrameCollection = contentSpace.$.getElementsByTagName('iframe');
                var ckeditorFrame = ckeditorFrameCollection[0];
                var innerDoc = ckeditorFrame.contentDocument;
                var innerDocTextAreaHeight = $(innerDoc.body).height();
                // console.log(innerDocTextAreaHeight);
            });
        });
    </script>
@endpush
