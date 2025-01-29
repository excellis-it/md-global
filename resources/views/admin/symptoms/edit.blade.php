@extends('admin.layouts.master')
@section('title')
    {{ env('APP_NAME') }} | Edit Symptoms Details
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
                            <li class="breadcrumb-item"><a href="{{ route('symptoms.index') }}">Symptoms</a></li>
                            <li class="breadcrumb-item active">Edit Symptoms Details</li>
                        </ul>
                    </div>
                    <div class="col-auto float-end ms-auto">
                        {{-- <a href="#" class="btn add-btn" data-bs-toggle="modal" data-bs-target="#add_group"><i
                            class="fa fa-plus"></i> Add Symptoms</a> --}}
                    </div>
                </div>
            </div>

            <div class="card">
                <div class="card-body">
                    <div class="card-title">
                        <div class="row">
                            <div class="col-xl-12 mx-auto">
                                <h6 class="mb-0 text-uppercase">Edit A Symptoms</h6>
                                <hr>
                                <div class="card border-0 border-4">
                                    <div class="card-body">
                                        <form action="{{ route('symptoms.update', $symptom->id) }}" method="POST"
                                            enctype="multipart/form-data">
                                            @method('PUT')
                                            @csrf
                                            <input type="hidden" name="id" value="{{ $symptom->id }}">
                                            <div class="border p-4 rounded">
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <label for="inputEnterYourName" class="col-form-label"> Specialization
                                                            <span style="color: red;">*</span></label>
                                                        <select name="specialization_id" id="specialization_id" class="form-control">
                                                            <option value="">Select Specialization</option>
                                                            @foreach ($specializations as $specialization)
                                                                <option value="{{ $specialization['id'] }}" @if($specialization['specialization_id'] = $symptom['specialization_id']) selected @endif>
                                                                    {{ $specialization['name'] }}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <label for="inputEnterYourName" class="col-form-label"> Symptom Name <span
                                                                style="color: red;">*</span></label>
                                                        <input type="text" name="symptom_name" id=""
                                                            class="form-control" value="{{ $symptom['symptom_name'] }}"
                                                            placeholder="Enter Symptom Name">
                                                        @if ($errors->has('symptom_name'))
                                                            <div class="error" style="color:red;">
                                                                {{ $errors->first('symptom_name') }}</div>
                                                        @endif
                                                    </div>
                                                    <div class="col-md-6">
                                                        <label for="inputEnterYourName" class="col-form-label"> Symptom Slug <span
                                                                style="color: red;">*</span></label>
                                                        <input type="text" name="symptom_slug" id=""
                                                            class="form-control" value="{{ $symptom['symptom_slug'] }}"
                                                            placeholder="Enter Symptom Slug">
                                                        @if ($errors->has('symptom_slug'))
                                                            <div class="error" style="color:red;">
                                                                {{ $errors->first('symptom_slug') }}</div>
                                                        @endif
                                                    </div>
                                                    <div class="col-md-6">
                                                        <label for="inputEnterYourName" class="col-form-label"> Status
                                                            <span style="color: red;">*</span></label>
                                                        <select name="symptom_status" id="" class="form-control">
                                                            <option value="">Select a Status</option>
                                                            <option value="1"
                                                                @if ($symptom['symptom_status'] == 1) selected="" @endif>Active
                                                            </option>
                                                            <option value="0"
                                                                @if ($symptom['symptom_status'] == 0) selected="" @endif>
                                                                Inactive</option>
                                                        </select>
                                                        @if ($errors->has('symptom_status'))
                                                            <div class="error" style="color:red;">
                                                                {{ $errors->first('symptom_status') }}</div>
                                                        @endif
                                                    </div>

                                                    <div class="col-md-6">
                                                        <label for="inputEnterYourName" class="col-form-label"> Image </label>
                                                        <input type="file" name="symptom_image" id=""
                                                            class="form-control"
                                                            value="{{ $symptom['symptom_image'] }}">
                                                        @if ($errors->has('symptom_image'))
                                                            <div class="error" style="color:red;">
                                                                {{ $errors->first('symptom_image') }}</div>
                                                        @endif
                                                    </div>
                                                    <div class="col-md-6">
                                                    </div>
                                                    @if ($symptom['symptom_image'])
                                                        <div class="col-md-6">
                                                            <label for="inputEnterYourName" class="col-form-label">View
                                                                Profile Picture </label>
                                                            <br>
                                                            <img src="{{ Storage::url($symptom['symptom_image']) }}"
                                                                alt="" class="img-design" style="height:50px; width: 50px; ">
                                                        </div>
                                                    @endif
                                                    <div class="col-md-12">
                                                        <label for="inputEnterYourName" class="col-form-label"> Description
                                                            <span style="color: red;">*</span></label>
                                                        <textarea name="symptom_description" id="" cols="30" rows="10"
                                                            class="form-control">{{ $symptom['symptom_description'] }}</textarea>
                                                        @if ($errors->has('symptom_description'))
                                                            <div class="error" style="color:red;">
                                                                {{ $errors->first('symptom_description') }}</div>
                                                        @endif
                                                    </div>

                                                    <div class="col-md-12 mt-4 mb-2">
                                                        <h6 class="mb-0 text-uppercase">SEO Content</h6>
                                                        <hr>
                                                    </div>

                                                    <div class="col-md-6 mb-3">
                                                        <label for="inputEnterYourName" class="col-form-label"> Meta Title </label>
                                                        <input type="text" name="meta_title" id=""
                                                            class="form-control" value="{{ $symptom['meta_title'] }}" placeholder="Enter Meta Title">
                                                        @if ($errors->has('meta_title'))
                                                            <div class="error" style="color:red;">
                                                                {{ $errors->first('meta_title') }}</div>
                                                        @endif
                                                    </div>

                                                    <div class="col-md-6 mb-3">
                                                        <label for="inputEnterYourName" class="col-form-label"> Meta keywords  </label>
                                                        <input type="text" name="meta_keyword" id=""
                                                            class="form-control" value="{{ $symptom['meta_keyword'] }}" placeholder="Enter Meta Keywords">
                                                        @if ($errors->has('meta_keyword'))
                                                            <div class="error" style="color:red;">
                                                                {{ $errors->first('meta_keyword') }}</div>
                                                        @endif
                                                    </div>

                                                    <div class="col-md-12 mb-3">
                                                        <label for="inputEnterYourName" class="col-form-label"> Meta description </label>
                                                        <textarea type="text" name="meta_description" id=""
                                                            class="form-control" cols="30" rows="10" value="" placeholder="Enter Meta Description">{{ $symptom['meta_description'] }}</textarea>
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
        CKEDITOR.replace('symptom_description');
        CKEDITOR.on('instanceReady', function(evt) {
            var editor = evt.editor;

            editor.on('change', function(e) {
                var contentSpace = editor.ui.space('contents');
                var ckeditorFrameCollection = contentSpace.$.getElementsByTagName('iframe');
                var ckeditorFrame = ckeditorFrameCollection[0];
                var innerDoc = ckeditorFrame.contentDocument;
                var innerDocTextAreaHeight = $(innerDoc.body).height();
                console.log(innerDocTextAreaHeight);
            });
        });
    </script>
    <script>
        $(document).ready(function() {
            $('#specialization_id').select2();
        });
        </script>
@endpush
