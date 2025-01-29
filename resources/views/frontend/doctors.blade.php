@extends('frontend.layouts.master')
@section('meta_title')
<meta name="keywords" content="{{$data['meta_keyword'] ?? ''}}">
<meta name="description" content="{{$data['meta_description'] ?? ''}}">
@endsection
@section('title')
{{$data['meta_title'] ?? ''}}
@endsection
@push('styles')
@endpush

@section('content')
@php
    use App\Models\User;
@endphp
<section class="inr-bnr">
    <div class="inr-bnr-img">
        <div class="inr-bnr-text">
            <h1>Medical Stuff</h1>
            <nav>
                    <ol class="cd-breadcrumb custom-separator">
                        <li><a href="">Home</a></li>
                        <li class="current"><em>Medical Stuff</em></li>
                    </ol>
                </nav>
        </div>
    </div>
</section>

@if($doctors->count() > 0)
<section class="search-doc">
    <div class="container">
        <div class="search-doc-wrap">
            <div class="row justify-content-between align-items-center">
                <div class="col-xl-4">
                    <div class="search-text">
                        <h3>SearchMedical Staff</h3>
                    </div>
                    <div class="search-box-wrap d-flex mt-2">
                        <div class="search-box">
                            <form action="">
                                <input type="search" class="form-control" id="exampleFormControlInput1"
                                    placeholder="Search medical stuff here..." name="search">
                                    <input type="hidden" name="type" value="{{ $type }}">
                                    @if($type == 'symptoms')
                                        <input type="hidden" name="slug" value="{{ $data->symptom_slug }}">
                                    @elseif($type == 'specialization')
                                        <input type="hidden" name="slug" value="{{ $data->slug }}">
                                    @endif

                                    <!-- <div class="mn-btn search-btn">
                                        <button type="submit">Search</button>
                                    </div> -->
                            </form>
                        </div>

                    </div>
                </div>
                <div class="col-xl-7">
                    <div class="search-filter-box d-flex">
                        <div class="search-filter-box-1">
                            <!-- <form action="">
                                <label for="exampleFormControlInput1" class="form-label">Location</label>
                                <input type="text" class="form-control" id="exampleFormControlInput1"
                                    placeholder="Search location...">
                            </form> -->
                        </div>
                        <div class="search-filter-box-1">
                            <form action="">
                                <label for="exampleFormControlInput1" class="form-label">Filter</label>
                                <select class="form-select" aria-label="Default select example" name="clinicSearch" id="clinicSearch">
                                    <option value="2" selected>Clinical & Video consultation</option>
                                    <option value="1">Clinical Consultation</option>
                                </select>
                                <input type="hidden" name="type" id="type" value="{{ $type }}">
                                @if($type == 'symptoms')
                                    <input type="hidden" name="slug" id="slug" value="{{ $data->symptom_slug }}">
                                @elseif($type == 'specialization')
                                    <input type="hidden" name="slug" id="slug" value="{{ $data->slug }}">
                                @endif
                            </form>
                        </div>
                        <div class="search-filter-box-1">
                            <form action="">
                                <label for="exampleFormControlInput1" class="form-label">Sort by</label>
                                <select class="form-select" aria-label="Default select example" name="alphabeticsearch" id="alphabeticsearch">
                                    <option selected>Sort by alphabet</option>
                                    <option value="1">A-Z</option>
                                    <option value="2">Z-A</option>
                                </select>
                                <input type="hidden" name="type" id="type" value="{{ $type }}">
                                @if($type == 'symptoms')
                                    <input type="hidden" name="slug" id="slug" value="{{ $data->symptom_slug }}">
                                @elseif($type == 'specialization')
                                    <input type="hidden" name="slug" id="slug" value="{{ $data->slug }}">
                                @endif
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<section class="doc-list" id="searchResultsContainer">
    @if(!$status)
        @include('frontend.ajax-doctor-list')
    @else
    <div class="container" >
        <div class="doc-list-wrap">
            <div class="doc-list-head">
                <div class="head-1 h-b">
                    @if($type == 'specialization')
                    <h2>{{ $data['name'] }}</h2>
                    @else
                    <h2>{{ $data['symptom_name'] }}</h2>
                    @endif
                </div>
                <div class="doc-avl d-flex mt-2">
                    <div class="doc-avl-img">
                        <img src="{{ asset('frontend_assets/images/doc-v.png') }}" alt="">
                    </div>
                    <div class="doc-avl-text">
                        @if($doctors->count() > 0)
                        <h4>{{ $doctors->count() }}Medical Stuff available</h4>
                        @else
                        <h4>NoMedical Stuff available</h4>
                        @endif
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            @foreach($doctors as $doctor)
            <div class="col-xl-3 col-md-6 col-12">
                <div class="doc-spl-wrap-box">
                    <div class="doc-spl">
                        <div class="doc-spl-img-box">
                            @if($doctor->profile_picture)
                            <img src="{{ Storage::url($doctor->profile_picture) }}" alt="">
                            @else
                            <img src="{{ asset('frontend_assets/images/profile.png') }}" alt="">
                            @endif
                        </div>
                        <div class="find-doc-slide-text">
                            <h3>{{ $doctor->name }}</h3>
                            <h4>{{ User::getDoctorSpecializations($doctor['id']) }}</h4>
                            <h5></h5>
                            <div class="pec-div">
                                <span class="pec"><i class="fa-solid fa-thumbs-up"></i>99%</span>
                                <span class="exp"><span class="dot-1"></span> {{ $doctor->year_of_experience }} Years Exp</span>
                            </div>
                        </div>
                        <div class="bk-btn">
                            <a href="{{ route('booking-and-consultancy', encrypt($doctor->id)) }}"><span>book an appointment</span></a>
                        </div>
                    </div>

                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>
@endif
@else
<section class="career">
    <div class="container">
      <div class="wrapper">
        <div class="content">
          <h1>NoMedical Staff Found</h1>
        </div>
      </div>
    </div>
  </section>
@endif

@endsection

@push('scripts')
<script>
  $(document).ready(function() {


    // Function to fetch search results based on the selected alphabet
    function fetchResults(selectedAlphabet, type, slug, selectedClinic, doctorName) {
        var url = '{{route("doctor-filter")}}'
      $.ajax({
        url: url,
        method: 'GET',
        data: { alphabet: selectedAlphabet, type: type, slug: slug, clinic:selectedClinic, doctor:doctorName},
        success: function(data) {
            console.log(data);
            $('#searchResultsContainer').html(data.view);
        },
        error: function() {
          console.log('Error fetching results.');
        }
      });
    }

    // Function to fetch search results based on the selected clinic
    function fetchClinics(clinic, type, slug) {
        var url = '{{route("doctor-filter")}}'
      $.ajax({
        url: url,
        method: 'GET',
        data: { clinic: clinic, type: type, slug: slug },
        success: function(data) {
            console.log(data);
            $('#searchResultsContainer').html(data.view);
        },
        error: function() {
          console.log('Error fetching results.');
        }
      });
    }

    // Function to fetchMedical Stuff
    function fetchDoctor(doctor, type, slug) {
        var url = '{{ route("doctor-filter") }}'
        $.ajax({
            url: url,
            method: 'GET',
            data: { doctor: doctor, type: type, slug: slug },
            success: function(data) {
                console.log(data);
                $('#searchResultsContainer').html(data.view);
            },
            error: function() {
                console.log('Error fetching results.');
            }
        });
    }

    // Trigger the fetchResults function when the select box value changes
    $('#alphabeticsearch').on('change', function() {
      var selectedAlphabet = $(this).val();
      var type = $("#type").val();
      var slug = $("#slug").val();
      var selectedClinic = $('#clinicSearch').val();
      var  doctorName =  $('#exampleFormControlInput1').val();
      fetchResults(selectedAlphabet, type, slug, selectedClinic, doctorName);
    });

    $('#clinicSearch').on('change', function() {
      var selectedClinic = $(this).val();
      var type = $("#type").val();
      var slug = $("#slug").val();
      var selectedAlphabet = $('#alphabeticsearch').val();
      var  doctorName =  $('#exampleFormControlInput1').val();
      fetchResults(selectedAlphabet, type, slug, selectedClinic, doctorName);
    });

    $('#exampleFormControlInput1').on('keyup change', function() {
        var doctorName = $(this).val();
        var type = $("#type").val();
        var slug = $("#slug").val();
        var selectedAlphabet = $('#alphabeticsearch').val();
        var selectedClinic = $('#clinicSearch').val();
        fetchResults(selectedAlphabet, type, slug, selectedClinic, doctorName);
    });
  });
</script>

@endpush
