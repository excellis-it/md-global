@extends('admin.layouts.master')
@section('title')
    {{ env('APP_NAME') }} | Edit Testimonial
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
                            <li class="breadcrumb-item"><a href="{{ route('testimonials.index') }}">Testimonial</a></li>
                            <li class="breadcrumb-item active">Edit Testimonial</li>
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
                                <h6 class="mb-0 text-uppercase">Edit Testimonial</h6>
                                <hr>
                                <div class="card border-0 border-4">
                                    <div class="card-body">
                                        <form action="{{ route('testimonials.update') }}" method="POST"
                                            enctype="multipart/form-data">
                                            @csrf
                                            <input type="hidden" name="id" value="{{  $testimonial->id }}">
                                            <div class="border p-4 rounded label_color">
                                                <div class="row">
                                                    <div class="col-md-12 mb-3">
                                                        <label for="inputEnterYourName" class="col-form-label"> Name <span
                                                                style="color: red;">*</span></label>
                                                        <textarea type="text" name="name" id="name"
                                                            class="form-control" value=""
                                                            placeholder="Name">{{ $testimonial['name'] }}</textarea>
                                                        @if ($errors->has('name'))
                                                            <div class="error" style="color:red;">
                                                                {{ $errors->first('name') }}</div>
                                                        @endif
                                                    </div>
                                                    <div class="col-md-12 mb-3">
                                                        <label for="inputEnterYourName" class="col-form-label"> Description <span
                                                                style="color: red;">*</span></label>
                                                        <textarea type="text" name="description" id="description"
                                                            class="form-control" value=""
                                                            placeholder="Description">{{ $testimonial['description'] }}</textarea>
                                                        @if ($errors->has('description'))
                                                            <div class="error" style="color:red;">
                                                                {{ $errors->first('description') }}</div>
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
    ClassicEditor.create(document.querySelector("#name"));
    ClassicEditor.create(document.querySelector("#description"));
</script>
@endpush
