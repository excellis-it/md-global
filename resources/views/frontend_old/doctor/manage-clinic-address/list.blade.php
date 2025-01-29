@extends('frontend.layouts.master')
@section('meta_title')
@endsection
@section('title')
    Mange Service Centers Address
@endsection
@push('styles')
@endpush

@section('content')
    @php
        use App\Helpers\Helper;
    @endphp
    <section class="sidebar-sec" id="body-pd">
        <div class="container-fluid">
            <div class="sidebar-wrap d-flex justify-content-between">
                @include('frontend.doctor.partials.sidebar')

                <!-- Content -->
                <div class="sidebar-right height-100">
                    <div class="content">
                        <div class="my-app-div-wrap">
                            <div class="content-head-wrap d-flex justify-content-between align-items-center">
                                <div class="content-head mb-4">
                                    <h2>Manage Service Centers Address</h2>
                                    <h3><a href="{{ route('doctor.dashboard') }}">Dashboard</a> / Manage Service Centers Address</h3>
                                </div>
                                <div class="add-address">
                                    <a href="{{ route('doctor.manage-clinic.create') }}"><span>+ Add Address</span></a>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-12">
                                    <div class="clinical-consultation-wrap">
                                        <!-- <div class="clinicl-head">
                                                    <h3>Clinical Consultation</h3>
                                                </div> -->
                                        @if ($clinics->count() > 0)
                                            <div class="clinical-box-wrap">
                                                @foreach ($clinics->chunk(2) as $items)
                                                    <div class="row">
                                                        @foreach ($items as $clinic)
                                                            <div class="col-xl-10 col-lg-9 col-12">
                                                                <div class="manage-clinic-div">
                                                                    <div class="row">
                                                                        <div class="col-xl-3 col-md-6 col-12">
                                                                            <div class="cl-name">
                                                                                <h3>Service Centers Name</h3>
                                                                                <h2>{{ $clinic['clinic_name'] }}</h2>
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-xl-3 col-md-6 col-12">
                                                                            <div class="cl-name">
                                                                                <h3>Phone Number</h3>
                                                                                <h2>{{ $clinic['clinic_phone'] }}</h2>
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-xl-3 col-md-6 col-12">
                                                                            <div class="cl-name">
                                                                                <h3>Service Centers Address</h3>
                                                                                <h2>{{ $clinic['clinic_address'] }}</h2>
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-xl-3 col-md-6 col-12">
                                                                            <div class="cl-name">
                                                                                <h3>Slot Day</h3>
                                                                                <h2>
                                                                                    {{ Helper::getClinicOpeninDay($clinic['id']) }}
                                                                                </h2>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-xl-2 col-lg-3 col-12">
                                                                <div class="cl-edit">
                                                                    <div class="edit-btn d-flex align-items-center">
                                                                        <div class="edit-btn-1">
                                                                            <a
                                                                                href="{{ route('doctor.manage-clinic.edit', $clinic['id']) }}"><span><i
                                                                                        class="fa-solid fa-pen-to-square"></i></span></a>
                                                                        </div>
                                                                        <div class="edit-btn-1 edit-btn-2">
                                                                            <a href="javascript:void(0);" id="delete"
                                                                                data-route="{{ route('doctor.manage-clinic.delete', $clinic['id']) }}"><span><i
                                                                                        class="fa-solid fa-trash-can"></i></span></a>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        @endforeach
                                                    </div>
                                                @endforeach
                                                <div class="pagi_1 justify-content-center">
                                                    <nav aria-label="Page navigation example">
                                                        <div class="">
                                                            {{ $clinics->links() }}
                                                        </div>
                                                    </nav>
                                                </div>
                                            </div>
                                        @else
                                            <div class="clinical-box-wrap">
                                                <div class="row">
                                                    <div class="col-12">
                                                        <div class="no-data-found-img text-center">
                                                            <img src="{{ asset('frontend_assets/images/no-search-found.webp') }}"
                                                                alt="No Data Found">
                                                            {{-- <h3>No Data Found</h3> --}}
                                                        </div>
                                                    </div>
                                                </div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
    </section>
@endsection

@push('scripts')
    <script>
        $(document).on('click', '#delete', function(e) {
            swal({
                    title: "Are you sure?",
                    text: "To delete the clinic address.",
                    type: "warning",
                    confirmButtonText: "Yes",
                    showCancelButton: true
                })
                .then((result) => {
                    if (result.value) {
                        window.location = $(this).data('route');
                    } else if (result.dismiss === 'cancel') {
                        swal(
                            'Cancelled',
                            'Your stay here :)',
                            'error'
                        )
                    }
                })
        });
    </script>
@endpush
