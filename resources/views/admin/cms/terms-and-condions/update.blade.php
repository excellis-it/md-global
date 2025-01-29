@extends('admin.layouts.master')
@section('title')
    Update Terms And Condition Page Content - {{ env('APP_NAME') }} admin
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
                        <h3 class="page-title">Terms And Condition Page Information</h3>
                        <ul class="breadcrumb">
                            <li class="breadcrumb-item">CMS</li>
                            <li class="breadcrumb-item"><a href="{{ route('cms.terms-and-condition.index') }}">Contact
                                    Page</a></li>
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
                                <h6 class="mb-0 text-uppercase">Update Terms And Condition Page Content</h6>
                                <hr>
                                <div class="card border-0 border-4">
                                    <div class="card-body">
                                        <form action="{{ route('cms.terms-and-condition.update') }}" method="POST"
                                            enctype="multipart/form-data">
                                            @csrf
                                            <input type="hidden" name="id" value="{{ $terms->id }}">
                                            <div class="border p-4 rounded">
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <label for="inputEnterYourName" class="col-form-label"> Send To
                                                            <span style="color: red;">*</span></label>
                                                        <select name="type" class="form-control" id="">
                                                            <option value="">Select A Type</option>
                                                            <option value="Frontend"
                                                                {{ $terms->type == 'Frontend' ? 'selected' : '' }}>Frontend
                                                            </option>
                                                            <option value="Doctor"
                                                                {{ $terms->type == 'Doctor' ? 'selected' : '' }}>Doctor
                                                            </option>
                                                            <option value="Patient"
                                                                {{ $terms->type == 'Patient' ? 'selected' : '' }}>Patient
                                                            </option>
                                                        </select>
                                                        @if ($errors->has('type'))
                                                            <div class="error" style="color:red;">
                                                                {{ $errors->first('send') }}</div>
                                                        @endif
                                                    </div>
                                                    <div class="col-md-12">
                                                        <label for="inputEnterYourName" class="col-form-label"> Content
                                                            <span style="color: red;">*</span></label>
                                                        <textarea name="content" class="form-control" id="editor" cols="30" rows="10">{{ $terms->content }}</textarea>
                                                        @if ($errors->has('content'))
                                                            <div class="error" style="color:red;">
                                                                {{ $errors->first('content') }}</div>
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
    <script src="https://cdn.ckeditor.com/4.19.1/standard-all/ckeditor.js"></script>
    <script>
        // cke editor
        CKEDITOR.replace('editor', {
            // height: '100vh',
            // width: '100vw',
            // uiColor: '#888888',
        });

        CKEDITOR.on('instanceReady', function(evt) {
            var instanceName = 'editor';
            var editor = CKEDITOR.instances[instanceName];
        });
    </script>
@endpush
