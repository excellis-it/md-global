@extends('admin.layouts.master')
@section('title')
Website Logo Upload  - {{ env('APP_NAME') }} admin
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
                        <h3 class="page-title">Website Logo Upload</h3>
                        <ul class="breadcrumb">
                            <li class="breadcrumb-item">CMS</li>
                            <li class="breadcrumb-item"><a href="{{ route('cms.logo.index') }}">Logo Upload</a></li>
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
                                <h6 class="mb-0 text-uppercase">Website Logo Upload</h6>
                                <hr>
                                <div class="card border-0 border-4">
                                    <div class="card-body">
                                        <form action="{{ route('cms.logo.update') }}" method="POST"
                                            enctype="multipart/form-data">
                                            @csrf
                                            <input type="hidden" name="id" value="{{ $logo->id  ?? ''}}">
                                            <div class="border p-4 rounded">
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <label for="inputEnterYourName" class="col-form-label"> Logo
                                                            <span style="color: red;">*</span></label>
                                                        <input type="file" name="logo" id=""
                                                            class="form-control" value="{{ $logo['logo'] ?? '' }}">
                                                        @if ($errors->has('logo'))
                                                            <div class="error" style="color:red;">
                                                                {{ $errors->first('logo') }}</div>
                                                        @endif
                                                    </div>
                                                    {{-- show logo --}}
                                                    <div class="col-md-6">
                                                        <label for="inputEnterYourName" class="col-form-label">
                                                            <span style="color: red;">*</span></label>
                                                        @if (isset($logo) && $logo['logo'] != null)
                                                            <img src="{{ Storage::url($logo['logo']) }}"
                                                                alt="logo" style="width: 100px; height: 100px;">
                                                        @else
                                                            <img src="{{ asset('admin_assets/img/logo2.png') }}"
                                                                alt="logo" style="width: 100px; height: 100px;">
                                                        @endif

                                                    </div>
                                                    <div class="col-md-6">
                                                        <label for="inputEnterYourName" class="col-form-label"> Favicon
                                                            <span style="color: red;">*</span></label>
                                                        <input type="file" name="favicon" id=""
                                                            class="form-control" value="{{ $logo['favicon'] ?? '' }}">
                                                        @if ($errors->has('favicon'))
                                                            <div class="error" style="color:red;">
                                                                {{ $errors->first('favicon') }}</div>
                                                        @endif
                                                    </div>
                                                    <div class="col-md-6">
                                                        <label for="inputEnterYourName" class="col-form-label">
                                                            <span style="color: red;">*</span></label>
                                                        @if (isset($logo) && $logo['favicon'] != null)
                                                            <img src="{{ Storage::url($logo['favicon']) }}"
                                                                alt="favicon" style="width: 100px; height: 100px;">
                                                        @else
                                                            <img src="{{ asset('admin_assets/img/favicon.ico') }}"
                                                                alt="favicon" style="width: 100px; height: 100px;">
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
@endpush
