@extends('admin.layouts.master')
@section('title')
    All Donation Details - {{ env('APP_NAME') }} admin
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
                        <h3 class="page-title">Donation Information</h3>
                        <ul class="breadcrumb">
                            <li class="breadcrumb-item"><a href="javascript:void(0);">Donation</a></li>
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
                                <h4 class="mb-0">Donation Details</h4>
                            </div>

                        </div>
                    </div>

                    <hr />
                    <div class="table-responsive">
                        <table id="myTable" class="dd table table-striped table-bordered" style="width:100%">
                            <thead>
                                <tr>
                                    <th>First Name</th>
                                    <th>Last Name</th>
                                    <th>Email</th>
                                    <th>Address</th>
                                    <th>City</th>
                                    <th>State</th>
                                    <th>Country</th>
                                    <th>Postcode</th>
                                    <th>Donation Amount ($)</th>
                                    <th>Payment Method</th>
                                    <th>Payment Status</th>
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
                    url: "{{ route('donations.list-ajax') }}",
                    type: "POST",
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                },
                columns: [{
                        data: 'first_name',
                        name: 'first_name',
                        orderable: true
                    },
                    {
                        data: 'last_name',
                        name: 'last_name',
                        orderable: true
                    },
                    {
                        data: 'email',
                        name: 'email',
                        orderable: true
                    },
                    {
                        data: 'address',
                        name: 'address',
                        orderable: true
                    },
                    {
                        data: 'city',
                        name: 'city',
                        orderable: true
                    },
                    {
                        data: 'state',
                        name: 'state',
                        orderable: true
                    },
                    {
                        data: 'country',
                        name: 'country',
                        orderable: true
                    },
                    {
                        data: 'postcode',
                        name: 'postcode',
                        orderable: true
                    },
                    {
                        data: 'donation_amount',
                        name: 'donation_amount'
                    },
                    {
                        data: 'payment_method',
                        name: 'payment_method'
                    },
                    {
                        data: 'payment_status',
                        name: 'payment_status'
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
