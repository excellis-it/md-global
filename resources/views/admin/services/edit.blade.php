@extends('admin.layouts.master')
@section('title')
    {{ env('APP_NAME') }} | Edit Service
@endsection
@push('styles')
<style>
    .ck-editor__editable_inline {
           height: 200px;
       }
</style>
@endpush

@section('content')
    <div class="page-wrapper">

        <div class="content container-fluid">

            <div class="page-header">
                <div class="row align-items-center">
                    <div class="col">
                        <h3 class="page-title">Edit Details</h3>
                        <ul class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('services.index') }}">Service</a></li>
                            <li class="breadcrumb-item active">Edit Service</li>
                        </ul>
                    </div>
                    <div class="col-auto float-end ms-auto">
                        {{-- <a href="#" class="btn add-btn" data-bs-toggle="modal" data-bs-target="#add_group"><i
                            class="fa fa-plus"></i> Add Blog Category</a> --}}
                    </div>
                </div>
            </div>

            <div class="card">
                <div class="card-body">
                    <div class="card-title">
                        <div class="row">
                            <div class="col-xl-12 mx-auto">
                                <h6 class="mb-0 text-uppercase">Edit Service</h6>
                                <hr>
                                <div class="card border-0 border-4">
                                    <div class="card-body">
                                        <form action="{{ route('services.update') }}" method="POST"
                                            enctype="multipart/form-data">
                                            @csrf
                                            <input type="hidden" name="id" value="{{  $service->id }}">
                                            <div class="border p-4 rounded label_color">
                                                <div class="row">
                                                    <div class="col-md-12 mb-3">
                                                        <label for="inputEnterYourName" class="col-form-label"> Slug <span
                                                                style="color: red;">*</span></label>
                                                        <input type="text" name="slug" id=""
                                                            class="form-control" value="{{ $service['slug'] }}"
                                                            placeholder="Enter Blog Slug">
                                                        @if ($errors->has('slug'))
                                                            <div class="error" style="color:red;">
                                                                {{ $errors->first('slug') }}</div>
                                                        @endif
                                                    </div>
                                                    <div class="col-md-12 mb-3">
                                                        <label for="inputEnterYourName" class="col-form-label"> Image </label>
                                                        <input type="file" name="image" id=""
                                                            class="form-control"
                                                            value="{{ $service['image'] }}">
                                                        @if ($errors->has('image'))
                                                            <div class="error" style="color:red;">
                                                                {{ $errors->first('image') }}</div>
                                                        @endif
                                                    </div>
                                                    @if ($service['image'])
                                                        <div class="col-md-12 mb-3">
                                                            <label for="inputEnterYourName" class="col-form-label">View
                                                               Image </label>
                                                            <br>
                                                            <img src="{{ Storage::url($service['image']) }}"
                                                                alt="" class="img-design">
                                                        </div>
                                                    @endif
                                                    <div class="col-md-12 mb-3">
                                                        <label for="inputEnterYourName" class="col-form-label"> Title <span
                                                                style="color: red;">*</span></label>
                                                        <input type="text" name="title" id=""
                                                            class="form-control" value="{{ $service['title'] }}"
                                                            placeholder="Title">
                                                        @if ($errors->has('title'))
                                                            <div class="error" style="color:red;">
                                                                {{ $errors->first('title') }}</div>
                                                        @endif
                                                    </div>
                                                    <div class="col-md-12 mb-3">
                                                        <label for="inputEnterYourName" class="col-form-label"> Description <span
                                                                style="color: red;">*</span></label>
                                                        <textarea type="text" name="description" id="description"
                                                            class="form-control" value=""
                                                            placeholder="Description">{{ $service['description'] }}</textarea>
                                                        @if ($errors->has('description'))
                                                            <div class="error" style="color:red;">
                                                                {{ $errors->first('description') }}</div>
                                                        @endif
                                                    </div>

                                                    <div class="col-md-12 mt-4 mb-2">
                                                        <h6 class="mb-0 text-uppercase">SEO Content</h6>
                                                        <hr>
                                                    </div>

                                                    <div class="col-md-6 mb-3">
                                                        <label for="inputEnterYourName" class="col-form-label"> Meta Title </label>
                                                        <input type="text" name="meta_title" id=""
                                                            class="form-control" value="{{ $service['meta_title'] }}"  placeholder="Meta Title">
                                                        @if ($errors->has('meta_title'))
                                                            <div class="error" style="color:red;">
                                                                {{ $errors->first('meta_title') }}</div>
                                                        @endif
                                                    </div>

                                                    <div class="col-md-6 mb-3">
                                                        <label for="inputEnterYourName" class="col-form-label"> Meta keywords  </label>
                                                        <input type="text" name="meta_keyword" id=""
                                                            class="form-control" value="{{ $service['meta_keyword'] }}"  placeholder="Meta Keywords">
                                                        @if ($errors->has('meta_keyword'))
                                                            <div class="error" style="color:red;">
                                                                {{ $errors->first('meta_keyword') }}</div>
                                                        @endif
                                                    </div>

                                                    <div class="col-md-12 mb-3">
                                                        <label for="inputEnterYourName" class="col-form-label"> Meta description </label>
                                                        <textarea type="text" name="meta_description" id=""
                                                            class="form-control" cols="30" rows="10" value=""  placeholder="Meta Description">{{ $service['meta_description'] }}</textarea>
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
    ClassicEditor.create(document.querySelector("#description"));
</script>
@endpush
