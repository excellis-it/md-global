@extends('admin.layouts.master')
@section('title')
    All Video Calling Payment History Details - {{ env('APP_NAME') }} admin
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
                        <h3 class="page-title">Video Calling Payment History Information</h3>
                        <ul class="breadcrumb">
                            <li class="breadcrumb-item"><a href="javascript:void(0);">Video Calling Payment History</a></li>
                            <li class="breadcrumb-item active">List</li>
                        </ul>
                    </div>

                </div>
            </div>

            <div class="card">
                <div class="card-body">
                    <div class="card-title">
                        <div class="row">
                            <div class="col-md-6">
                                <h4 class="mb-0">Video Calling Payment History Details</h4>
                            </div>

                        </div>
                    </div>

                    <hr />
                    <div class="table-responsive">
                        <table id="myTable" class="dd table table-striped table-bordered" style="width:100%">
                            <thead>
                                <tr>
                                    <th>Patient Name</th>
                                    <th>Patient Email</th>
                                    <th>Medical Stuff Name</th>
                                    <th>Medical Stuff Email</th>
                                    <th>Duration</th>
                                    <th>Amount ($)</th>
                                    <th>Calling Date</th>
                                </tr>
                            </thead>
                            <tbody>

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

        </div>

    </div>
@endsection

@push('scripts')
    <script>
        $(document).ready(function() {

            var table = $('#myTable').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url: "{{ route('video-call-payment.list-ajax') }}",
                    type: "POST", // specifying the type of request
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr(
                            'content') // include CSRF token if you are using Laravel
                    }
                },
                columns: [{
                        data: 'patient_name',
                        name: 'patient_name',
                        orderable: false,

                    },
                    {
                        data: 'patient_email',
                        name: 'patient_email',
                        orderable: false,
                    },
                    {
                        data: 'doctor_name',
                        name: 'doctor_name',
                        orderable: false,
                    },
                    {
                        data: 'doctor_email',
                        name: 'doctor_email',
                        orderable: false,
                    },
                    {
                        data: 'duration',
                        name: 'duration'
                    },
                    {
                        data: 'amount',
                        name: 'amount'
                    },
                    {
                        data: 'created_at',
                        name: 'created_at'
                    }

                ]
            });

        });
    </script>
    <script>
        $(document).on('click', '#delete', function(e) {
            swal({
                    title: "Are you sure?",
                    text: "To delete this patient.",
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
