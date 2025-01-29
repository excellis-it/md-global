@extends('admin.layouts.master')
@section('title')
    {{ env('APP_NAME') }} | Update Telehealth CMS
@endsection
@push('styles')
@endpush

@section('content')
    <div class="page-wrapper">

        <div class="content container-fluid">

            <div class="page-header">
                <div class="row align-items-center">
                    <div class="col">
                        <h3 class="page-title">Update Details</h3>
                        <ul class="breadcrumb">
                            <li class="breadcrumb-item"><a href="javascript:void(0);">Telehealth CMS</a></li>
                            <li class="breadcrumb-item active">Update Telehealth CMS</li>
                        </ul>
                    </div>
                    <div class="col-auto float-end ms-auto">
                        {{-- <a href="#" class="btn add-btn" data-bs-toggle="modal" data-bs-target="#add_group"><i
                            class="fa fa-plus"></i> Add Patient</a> --}}
                    </div>
                </div>
            </div>

            <div class="card">
                <div class="card-body">
                    <div class="card-title">
                        <div class="row">
                            <div class="col-xl-12 mx-auto">
                                <hr>
                                <div class="card border-0 border-4">
                                    <div class="card-body">
                                        <form action="{{ route('cms.telehealth.update', $telehealth->id) }}" method="POST"
                                            enctype="multipart/form-data">
                                            @method('PUT')
                                            @csrf
                                            <div class="border p-4 rounded">
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <label for="inputEnterYourName" class="col-form-label">Symptom Title
                                                            <span style="color: red;">*</span></label>
                                                        <textarea type="text" name="symptom_title" id="symptom_title"
                                                            class="form-control" value=""
                                                            placeholder="Enter Symptom Title">{{ $telehealth['symptom_title'] }}</textarea>
                                                        @if ($errors->has('symptom_title'))
                                                            <div class="error" style="color:red;">
                                                                {{ $errors->first('symptom_title') }}</div>
                                                        @endif
                                                    </div>
                                                    <div class="col-md-6">
                                                        <label for="inputEnterYourName"
                                                            class="col-form-label">Specialization Title
                                                            <span style="color: red;">*</span></label>
                                                        <textarea type="text" name="specialization_title" id="specialization_title"
                                                            class="form-control"
                                                            value=""
                                                            placeholder="Enter Specialization Title">{{ $telehealth['specialization_title'] }}</textarea>
                                                        @if ($errors->has('specialization_title'))
                                                            <div class="error" style="color:red;">
                                                                {{ $errors->first('specialization_title') }}</div>
                                                        @endif
                                                    </div>

                                                    <div class="col-md-6">
                                                        <label for="inputEnterYourName" class="col-form-label">Offer Image
                                                            1</label>
                                                        <input type="file" name="offer_image_1" id=""
                                                            class="form-control" value="{{ $telehealth['offer_image_1'] }}"
                                                            placeholder="Enter Offer Image 1">
                                                        @if ($errors->has('offer_image_1'))
                                                            <div class="error" style="color:red;">
                                                                {{ $errors->first('offer_image_1') }}</div>
                                                        @endif
                                                    </div>
                                                    {{-- offer image 1 --}}
                                                    <div class="col-md-6">
                                                        <label for="inputEnterYourName" class="col-form-label"></label>
                                                        @if ($telehealth['offer_image_1'] != null)
                                                            <img class="image-tele" src="{{ Storage::url($telehealth['offer_image_1']) }}"
                                                                alt="">
                                                        @else
                                                            <img class="image-tele" src="{{ asset('frontend_assets/images/doc-1.png') }}"
                                                                alt="">
                                                        @endif
                                                    </div>

                                                    <div class="col-md-6">
                                                        <label for="inputEnterYourName" class="col-form-label">Offer Image
                                                            2</label>
                                                        <input type="file" name="offer_image_2" id=""
                                                            class="form-control" value="{{ $telehealth['offer_image_2'] }}"
                                                            placeholder="Enter Offer Image 2">
                                                        @if ($errors->has('offer_image_2'))
                                                            <div class="error" style="color:red;">
                                                                {{ $errors->first('offer_image_2') }}</div>
                                                        @endif
                                                    </div>

                                                    {{-- offer image 2 --}}
                                                    <div class="col-md-6">
                                                        <label for="inputEnterYourName" class="col-form-label"></label>
                                                        @if ($telehealth['offer_image_2'] != null)
                                                            <img class="image-tele" src="{{ Storage::url($telehealth['offer_image_2']) }}"
                                                                alt="">
                                                        @else
                                                            <img class="image-tele" src="{{ asset('frontend_assets/images/doc-2.png') }}"
                                                                alt="">
                                                        @endif
                                                    </div>

                                                    <div class="col-md-6">
                                                        <label for="inputEnterYourName" class="col-form-label">Offer Image
                                                            3</label>
                                                        <input type="file" name="offer_image_3" id=""
                                                            class="form-control" value="{{ $telehealth['offer_image_3'] }}"
                                                            placeholder="Enter Offer Image 3">
                                                        @if ($errors->has('offer_image_3'))
                                                            <div class="error" style="color:red;">
                                                                {{ $errors->first('offer_image_3') }}</div>
                                                        @endif
                                                    </div>

                                                    {{-- offer image 3 --}}
                                                    <div class="col-md-6">
                                                        <label for="inputEnterYourName" class="col-form-label"></label>
                                                        @if ($telehealth['offer_image_3'] != null)
                                                            <img class="image-tele" src="{{ Storage::url($telehealth['offer_image_3']) }}"
                                                                alt="">
                                                        @else
                                                            <img class="image-tele" src="{{ asset('frontend_assets/images/doc-3.png') }}"
                                                                alt="">
                                                        @endif
                                                    </div>
                                                    <div class="col-md-6">
                                                        <label for="inputEnterYourName" class="col-form-label">How It
                                                            Works Title
                                                            <span style="color: red;">*</span></label>
                                                        <textarea type="text" name="how_it_works_title"
                                                            id="how_it_works_title" class="form-control"
                                                            value=""
                                                            placeholder="Enter How It Works Title">{{ $telehealth['how_it_works_title'] }}</textarea>
                                                        @if ($errors->has('how_it_works_title'))
                                                            <div class="error" style="color:red;">
                                                                {{ $errors->first('how_it_works_title') }}</div>
                                                        @endif
                                                    </div>
                                                    <div class="col-md-6">
                                                        <label for="inputEnterYourName" class="col-form-label">How It
                                                            Works Icon 1 Title
                                                            <span style="color: red;">*</span></label>
                                                        <textarea type="text" name="how_it_works_icon_1_title"
                                                            id="how_it_works_icon_1_title" class="form-control"
                                                            value=""
                                                            placeholder="Enter How It Works Icon 1 Title">{{ $telehealth['how_it_works_icon_1_title'] }}</textarea>
                                                        @if ($errors->has('how_it_works_icon_1_title'))
                                                            <div class="error" style="color:red;">
                                                                {{ $errors->first('how_it_works_icon_1_title') }}</div>
                                                        @endif
                                                    </div>
                                                    <div class="col-md-6">
                                                        <label for="inputEnterYourName" class="col-form-label">How It
                                                            Works Icon 2 Title
                                                            <span style="color: red;">*</span></label>
                                                        <textarea type="text" name="how_it_works_icon_2_title"
                                                            id="how_it_works_icon_2_title" class="form-control"
                                                            value=""
                                                            placeholder="Enter How It Works Icon 2 Title">{{ $telehealth['how_it_works_icon_2_title'] }}</textarea>
                                                        @if ($errors->has('how_it_works_icon_2_title'))
                                                            <div class="error" style="color:red;">
                                                                {{ $errors->first('how_it_works_icon_2_title') }}</div>
                                                        @endif
                                                    </div>
                                                    <div class="col-md-6">
                                                        <label for="inputEnterYourName" class="col-form-label">How It
                                                            Works Icon 3 Title
                                                            <span style="color: red;">*</span></label>
                                                        <textarea type="text" name="how_it_works_icon_3_title"
                                                            id="how_it_works_icon_3_title" class="form-control"
                                                            value=""
                                                            placeholder="Enter How It Works Icon 3 Title">{{ $telehealth['how_it_works_icon_3_title'] }}</textarea>
                                                        @if ($errors->has('how_it_works_icon_3_title'))
                                                            <div class="error" style="color:red;">
                                                                {{ $errors->first('how_it_works_icon_3_title') }}</div>
                                                        @endif
                                                    </div>

                                                    <div class="col-md-6">
                                                        <label for="inputEnterYourName" class="col-form-label">How It
                                                            Works Icon 1</label>
                                                        <input type="file" name="offer_image_3" id=""
                                                            class="form-control"
                                                            value="{{ $telehealth['how_it_works_icon_1'] }}"
                                                            placeholder="Enter Offer Image 3">
                                                        @if ($errors->has('how_it_works_icon_1'))
                                                            <div class="error" style="color:red;">
                                                                {{ $errors->first('how_it_works_icon_1') }}</div>
                                                        @endif
                                                    </div>

                                                    {{-- How It Works Icon 1 --}}
                                                    <div class="col-md-6">
                                                        <label for="inputEnterYourName" class="col-form-label"></label>
                                                        @if ($telehealth['how_it_works_icon_1'] != null)
                                                            <img class="image-tele" src="{{ Storage::url($telehealth['how_it_works_icon_1']) }}"
                                                                alt="">
                                                        @else
                                                            <img class="image-tele" src="{{ asset('frontend_assets/images/w-1.png') }}"
                                                                alt="">
                                                        @endif
                                                    </div>

                                                    <div class="col-md-6">
                                                        <label for="inputEnterYourName" class="col-form-label">How It
                                                            Works Icon 2</label>
                                                        <input type="file" name="how_it_works_icon_2" id=""
                                                            class="form-control"
                                                            value="{{ $telehealth['how_it_works_icon_2'] }}"
                                                            placeholder="Enter How It Works Icon 2">
                                                        @if ($errors->has('how_it_works_icon_2'))
                                                            <div class="error" style="color:red;">
                                                                {{ $errors->first('how_it_works_icon_2') }}</div>
                                                        @endif
                                                    </div>

                                                    {{-- How It Works Icon 2 --}}
                                                    <div class="col-md-6">
                                                        <label for="inputEnterYourName" class="col-form-label"></label>
                                                        @if ($telehealth['how_it_works_icon_2'] != null)
                                                            <img class="image-tele" src="{{ Storage::url($telehealth['how_it_works_icon_2']) }}"
                                                                alt="">
                                                        @else
                                                            <img class="image-tele" src="{{ asset('frontend_assets/images/w-2.png') }}"
                                                                alt="">
                                                        @endif

                                                    </div>

                                                    <div class="col-md-6">
                                                        <label for="inputEnterYourName" class="col-form-label">How It
                                                            Works Icon 3</label>
                                                        <input type="file" name="how_it_works_icon_3" id=""
                                                            class="form-control"
                                                            value="{{ $telehealth['how_it_works_icon_3'] }}"
                                                            placeholder="Enter How It Works Icon 3">
                                                        @if ($errors->has('how_it_works_icon_3'))
                                                            <div class="error" style="color:red;">
                                                                {{ $errors->first('how_it_works_icon_3') }}</div>
                                                        @endif
                                                    </div>

                                                    {{-- How It Works Icon 3 --}}
                                                    <div class="col-md-6">
                                                        <label for="inputEnterYourName" class="col-form-label"></label>
                                                        @if ($telehealth['how_it_works_icon_3'] != null)
                                                            <img class="image-tele" src="{{ Storage::url($telehealth['how_it_works_icon_3']) }}"
                                                                alt="">
                                                        @else
                                                            <img class="image-tele" src="{{ asset('frontend_assets/images/w-3.png') }}"
                                                                alt="">
                                                        @endif
                                                    </div>

                                                    <div class="col-md-12">
                                                        <label for="inputEnterYourName" class="col-form-label"> Symptom
                                                            Description
                                                            <span style="color: red;">*</span></label>
                                                        <textarea type="text" name="symptom_description" id="symptom_description" class="form-control"
                                                            placeholder="Enter Symptom Description" cols="30" rows="10">{{ $telehealth['symptom_description'] }}</textarea>
                                                        @if ($errors->has('symptom_description'))

                                                            <div class="error" style="color:red;">
                                                                {{ $errors->first('symptom_description') }}</div>
                                                        @endif
                                                    </div>

                                                    <div class="col-md-12 mt-4 mb-2">
                                                        <h4 class="mb-0 text-uppercase">SEO Content</h4>
                                                        <hr>
                                                    </div>

                                                    <div class="col-md-6 mb-3">
                                                        <label for="inputEnterYourName" class="col-form-label"> Meta Title </label>
                                                        <input type="text" name="meta_title" id=""
                                                            class="form-control" value="{{ $telehealth['meta_title'] }}"  placeholder="Meta Title">
                                                        @if ($errors->has('meta_title'))
                                                            <div class="error" style="color:red;">
                                                                {{ $errors->first('meta_title') }}</div>
                                                        @endif
                                                    </div>

                                                    <div class="col-md-6 mb-3">
                                                        <label for="inputEnterYourName" class="col-form-label"> Meta keywords  </label>
                                                        <input type="text" name="meta_keyword" id=""
                                                            class="form-control" value="{{ $telehealth['meta_keyword'] }}"  placeholder="Meta Keywords">
                                                        @if ($errors->has('meta_keyword'))
                                                            <div class="error" style="color:red;">
                                                                {{ $errors->first('meta_keyword') }}</div>
                                                        @endif
                                                    </div>

                                                    <div class="col-md-12 mb-3">
                                                        <label for="inputEnterYourName" class="col-form-label"> Meta description </label>
                                                        <textarea type="text" name="meta_description" id=""
                                                            class="form-control" cols="30" rows="10" value=""  placeholder="Meta Description">{{ $telehealth['meta_description'] }}</textarea>
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
    ClassicEditor.create(document.querySelector("#specialization_title"));
    ClassicEditor.create(document.querySelector("#symptom_title"));
    ClassicEditor.create(document.querySelector("#how_it_works_title"));
    ClassicEditor.create(document.querySelector("#how_it_works_icon_1_title"));
    ClassicEditor.create(document.querySelector("#how_it_works_icon_2_title"));
    ClassicEditor.create(document.querySelector("#how_it_works_icon_3_title"));
    ClassicEditor.create(document.querySelector("#symptom_description"));
</script>
@endpush
