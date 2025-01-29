@extends('admin.layouts.master')
@section('title')
    {{ env('APP_NAME') }} | Update Footer CMS
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
                            <li class="breadcrumb-item"><a href="javascript:void(0);">Footer CMS</a></li>
                            <li class="breadcrumb-item active">Update Footer CMS</li>
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
                                        <form action="{{ route('cms.footer.update', $footer->id) }}" method="POST"
                                            enctype="multipart/form-data">
                                            @method('PUT')
                                            @csrf
                                            <div class="border p-4 rounded">
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <label for="inputEnterYourName" class="col-form-label">Website Name
                                                            <span style="color: red;">*</span></label>
                                                        <input type="text" name="website_name" id=""
                                                            class="form-control" value="{{ $footer['website_name'] }}"
                                                            placeholder="Enter Website Name">
                                                        @if ($errors->has('website_name'))
                                                            <div class="error" style="color:red;">
                                                                {{ $errors->first('website_name') }}</div>
                                                        @endif
                                                    </div>
                                                    <div class="col-md-6">
                                                        <label for="inputEnterYourName" class="col-form-label"> Address
                                                            <span style="color: red;">*</span></label>
                                                        <input type="text" name="address" id="" class="form-control"
                                                            value="{{ $footer['address'] }}" placeholder="Enter Address">
                                                        @if ($errors->has('address'))
                                                            <div class="error" style="color:red;">
                                                                {{ $errors->first('address') }}</div>
                                                        @endif
                                                    </div>
                                                    <div class="col-md-6">
                                                        <label for="inputEnterYourName" class="col-form-label"> Phone
                                                            <span style="color: red;">*</span></label>
                                                        <input type="text" name="phone" id="" class="form-control"
                                                            value="{{ $footer['phone'] }}" placeholder="Enter Phone">
                                                        @if ($errors->has('phone'))
                                                            <div class="error" style="color:red;">
                                                                {{ $errors->first('phone') }}</div>
                                                        @endif
                                                    </div>
                                                    <div class="col-md-6">
                                                        <label for="inputEnterYourName" class="col-form-label"> Email
                                                            <span style="color: red;">*</span></label>
                                                        <input type="text" name="email" id="" class="form-control"
                                                            value="{{ $footer['email'] }}" placeholder="Enter Email">
                                                        @if ($errors->has('email'))
                                                            <div class="error" style="color:red;">
                                                                {{ $errors->first('email') }}</div>
                                                        @endif
                                                    </div>
                                                    <div class="col-md-6">
                                                        <label for="inputEnterYourName" class="col-form-label"> Business Phone
                                                            <span style="color: red;">*</span></label>
                                                        <input type="text" name="business_phone" id="" class="form-control"
                                                            value="{{ $footer['business_phone'] }}"
                                                            placeholder="Enter Business Phone">
                                                        @if ($errors->has('business_phone'))
                                                            <div class="error" style="color:red;">
                                                                {{ $errors->first('business_phone') }}</div>
                                                        @endif
                                                    </div>
                                                    <div class="col-md-6">
                                                        <label for="inputEnterYourName" class="col-form-label"> Newsletter Title
                                                            <span style="color: red;">*</span></label>
                                                        <input type="text" name="newsletter_title" id="" class="form-control"
                                                            value="{{ $footer['newsletter_title'] }}"
                                                            placeholder="Enter Newsletter Title">
                                                        @if ($errors->has('newsletter_title'))
                                                            <div class="error" style="color:red;">
                                                                {{ $errors->first('newsletter_title') }}</div>
                                                        @endif
                                                    </div>
                                                    <div class="col-md-12">
                                                        <label for="inputEnterYourName" class="col-form-label"> Footer Description
                                                            <span style="color: red;">*</span></label>
                                                        <textarea type="text" name="footer_description" id="footer_description" class="form-control"
                                                            placeholder="Enter Footer Description" cols="30" rows="10">{{ $footer['footer_description'] }}</textarea>
                                                        @if ($errors->has('footer_description'))
                                                            <div class="error" style="color:red;">
                                                                {{ $errors->first('footer_description') }}</div>
                                                        @endif
                                                    </div>
                                                    {{-- <div style="display: flex;"> --}}
                                                    <div class="col-md-12">
                                                        <label for="inputEnterYourName" class="col-form-label"> Social Link <span style="color: red;">*</span></label>
                                                    </div>
                                                    <div class="add-name">
                                                        @foreach ($footer->footerSocialLinks as $key => $vall)
                                                            <div class="row">
                                                                <div class="col-md-4 pb-3">
                                                                    <div style="display: flex">
                                                                        <input type="text" name="icon[]"
                                                                            class="form-control"
                                                                            value="{{ $vall->icon }}"
                                                                            placeholder="Social Icon" id="plan-{{ $vall->id }}" required>
                                                                    </div>
                                                                </div>

                                                                <div class="col-md-4 pb-3">
                                                                    <div style="display: flex">
                                                                        <input type="text" name="link[]"
                                                                            class="form-control"
                                                                            value="{{ $vall->link }}"
                                                                            placeholder="Social Icon" id="link-{{ $vall->id }}" required>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-4">
                                                                    @if ($key == 0)
                                                                        <button type="button"
                                                                            class="btn btn-success add good-button"><i
                                                                                class="fas fa-plus"></i> Add More
                                                                            Social</button>
                                                                    @endif
                                                                    @if ($key != 0)
                                                                        <button type="button"
                                                                            class="btn btn-danger cross good-button" data-id="{{ $vall->id }}"> <i
                                                                                class="fas fa-close"></i> Remove</button>
                                                                    @endif
                                                                </div>
                                                            </div>
                                                            {{-- </br> --}}
                                                        @endforeach

                                                    </div>

                                                    {{-- </div> --}}


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
    <script>
        $(document).ready(function() {
            $(".add").click(function() {

                $(".add-name").append(
                    '<div class="row"><div class="col-md-4 pb-3"><div style="display: flex"><input type="text" name="icon[]" required class="form-control"  placeholder="Social Icon"></div> </div> <div class="col-md-4 pb-3"><div style="display: flex"><input type="text" name="link[]" required class="form-control"  placeholder="Social Link"></div> </div> <div class="col-md-4 "><button type="button" class="btn btn-danger cross good-button"> <i class="fas fa-close"></i> Remove</button></div>'
                );
            });
        });

        $(document).on('click', '.cross', function() {
            // remove pareent div
            $(this).parent().parent().remove();
        });
    </script>
    <script src="https://cdn.ckeditor.com/ckeditor5/28.0.0/classic/ckeditor.js"></script>
    <script>
        ClassicEditor.create(document.querySelector("#footer_description"));
    </script>
@endpush
