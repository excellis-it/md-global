@extends('admin.layouts.master')
@section('title')
    All Membership History Details - {{ env('APP_NAME') }} admin
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
                        <h3 class="page-title">Membership History Information</h3>
                        <ul class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('membership-history.index') }}">Membership
                                    History</a></li>
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
                                <h4 class="mb-0">Membership history Details</h4>
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
                                    <th>Membership Plan</th>
                                    <th>Membership Start Date</th>
                                    <th>Membership End Date</th>
                                    <th>Plan Amount ($)</th>
                                    {{-- <th>Action</th> --}}
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
                    url: "{{ route('membership-history.list-ajax') }}",
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
                        data: 'membership_plan',
                        name: 'membership_plan',
                        orderable: false,
                    },
                    {
                        data: 'membership_start_date',
                        name: 'membership_start_date'
                    },
                    {
                        data: 'membership_end_date',
                        name: 'membership_end_date',
                    },
                    {
                        data: 'plan_amount',
                        name: 'plan_amount'
                    },
                    // {
                    //     data: 'action',
                    //     name: 'action',
                    //     orderable: false,
                    //     searchable: false
                    // },

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
