@extends('admin.layouts.master')
@section('title')
    {{ env('APP_NAME') }} | Create Privacy Policy
@endsection
@push('styles')
@endpush

@section('content')
    <div class="page-wrapper">

        <div class="content container-fluid">

            <div class="page-header">
                <div class="row align-items-center">
                    <div class="col">
                        <h3 class="page-title">Create</h3>
                        <ul class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('cms.privacy-policy.index') }}">Privacy Policy</a></li>
                            <li class="breadcrumb-item active">Create Privacy Policy</li>
                        </ul>
                    </div>
                    <div class="col-auto float-end ms-auto">
                        {{-- <a href="#" class="btn add-btn" data-bs-toggle="modal" data-bs-target="#add_group"><i
                            class="fa fa-plus"></i> Add Privacy Policy</a> --}}
                    </div>
                </div>
            </div>

            <div class="card">
                <div class="card-body">
                    <div class="card-title">
                        <div class="row">
                            <div class="col-xl-12 mx-auto">
                                <h6 class="mb-0 text-uppercase">Create A Privacy Policy</h6>
                                <hr>
                                <div class="card border-0 border-4">
                                    <div class="card-body">
                                        <form action="{{ route('cms.privacy-policy.store') }}" method="post"
                                            enctype="multipart/form-data">
                                            @csrf
                                            <div class="border p-4 rounded">
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <label for="inputEnterYourName" class="col-form-label"> Send To <span
                                                                style="color: red;">*</span></label>
                                                        <select name="type" class="form-control" id="">
                                                            <option value="">Select A Type</option>
                                                            <option value="Frontend">Frontend</option>
                                                            <option value="Doctor">Doctor</option>
                                                            <option value="Patient">Patient</option>
                                                        </select>
                                                        @if ($errors->has('type'))
                                                            <div class="error" style="color:red;">
                                                                {{ $errors->first('send') }}</div>
                                                        @endif
                                                    </div>
                                                    <div class="col-md-12">
                                                        <label for="inputEnterYourName" class="col-form-label"> Message <span
                                                                style="color: red;">*</span></label>
                                                      <textarea name="content" id="editor" cols="30" rows="10" class="form-control">{{ old('content') }}</textarea>
                                                        @if ($errors->has('content'))
                                                            <div class="error" style="color:red;">
                                                                {{ $errors->first('content') }}</div>
                                                        @endif
                                                    </div>

                                                    <div class="row" style="margin-top: 20px; float: left;">
                                                        <div class="col-sm-9">
                                                            <button type="submit"
                                                                class="btn px-5 submit-btn"><i class="la la-paper-plane"></i> Send Privacy Policy</button>
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
