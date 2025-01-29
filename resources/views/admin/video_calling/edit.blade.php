@extends('admin.layouts.master')
@section('title')
    Video Calling Price - {{ env('APP_NAME') }} admin
@endsection
@push('styles')
    <style>
        .dataTables_filter {
            margin-bottom: 10px !important;
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
                        <h3 class="page-title">Video Calling Price</h3>
                        <ul class="breadcrumb">
                            <li class="breadcrumb-item">Plan Section</li>
                            <li class="breadcrumb-item"><a href="{{ route('cms.contact-us.index') }}">Video Calling
                                    Price</a></li>
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
                                <h6 class="mb-0 text-uppercase">Video Calling Price / 30 Min</h6>
                                <hr>
                                <div class="card border-0 border-4">
                                    <div class="card-body">
                                        <form action="{{ route('video-call-price.update', $video['id']) }}" method="POST"
                                            enctype="multipart/form-data">
                                            @method('PUT')
                                            @csrf
                                            <div class="border p-4 rounded">
                                                <div class="row">
                                                    {{-- title --}}
                                                    <div class="col-md-12">
                                                        <input type="text" name="title" id=""
                                                            class="form-control" value="{{ $video['title'] }}"
                                                            placeholder="Title*">
                                                        @if ($errors->has('title'))
                                                            <div class="error" style="color:red;">
                                                                {{ $errors->first('title') }}</div>
                                                        @endif
                                                    </div>
                                                    {{-- price --}}
                                                    <div class="col-md-6 mt-4">
                                                        <input type="text" name="price" id=""
                                                            class="form-control" value="{{ $video['price'] }}"
                                                            placeholder="Price*">
                                                        @if ($errors->has('price'))
                                                            <div class="error" style="color:red;">
                                                                {{ $errors->first('price') }}</div>
                                                        @endif
                                                    </div>
                                                    {{-- duration --}}
                                                    <div class="col-md-6 mt-4">
                                                        <input type="text" name="duration" id=""
                                                            class="form-control" value="{{ $video['duration'] }}"
                                                            placeholder="Duration (min)*">
                                                        @if ($errors->has('duration'))
                                                            <div class="error" style="color:red;">
                                                                {{ $errors->first('duration') }}</div>
                                                        @endif
                                                    </div>
                                                    {{-- description --}}
                                                    <div class="col-md-12 mt-4">
                                                        <textarea name="description" id="description"
                                                            class="form-control" placeholder="Plan Description*">{{ $video['description'] }}</textarea>
                                                        @if ($errors->has('description'))
                                                            <div class="error" style="color:red;">
                                                                {{ $errors->first('description') }}</div>
                                                        @endif
                                                    </div>

                                                    <div class="col-md-6 mt-4">
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
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-lite.min.css">
<script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-lite.min.js"></script>

<script>
    $(document).ready(function() {
        // ClassicEditor.create(document.querySelector("#plan_description"));
        $('#description').summernote({
            placeholder: 'Plan Description*',
            tabsize: 2,
            height: 500
        });
    });
</script>
@endpush
