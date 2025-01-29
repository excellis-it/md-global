@extends('admin.layouts.master')
@section('title')
    Terms & Condition - {{ env('APP_NAME') }} admin
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
                        <h3 class="page-title">Terms & Condition Information</h3>
                        <ul class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('cms.terms-and-condition.index') }}">Terms & Condition</a></li>
                            <li class="breadcrumb-item active">List</li>
                        </ul>
                    </div>
                    <div class="col-auto float-end ms-auto">
                        <a href="{{ route('cms.terms-and-condition.create') }}" class="btn add-btn"><i class="fa fa-plus"></i> Add 
                            Terms and Condition</a>
                    </div>
                </div>
            </div>

            <div class="card">
                <div class="card-body">
                    <div class="card-title">
                        <div class="row">
                            <div class="col-md-6">
                                <h4 class="mb-0">Terms & Condition Details</h4>
                            </div>

                        </div>
                    </div>

                    <hr />
                    <div class="table-responsive">
                        <table id="myTable" class="dd table table-striped table-bordered" style="width:100%">
                            <thead>
                                <tr>
                                    <th> #ID </th>
                                    <th> Type</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($terms as $term)
                                    <tr>
                                        <td>{{ $term->id }}</td>
                                        <td>{{ $term->type }}</td>
                                        <td>
                                            <a href="{{ route('cms.terms-and-condition.edit', $term->id) }}"
                                                class="btn btn-sm bg-success-light"><i class="far fa-edit"></i> Edit</a> &nbsp; &nbsp;
                                            <a href="javascript:void(0)" id="delete" data-route="{{ route('cms.terms-and-condition.delete', $term->id) }}"
                                                class="btn btn-sm bg-danger-light"><i class="far fa-trash-alt"></i>
                                                Delete</a>
                                        </td>
                                    </tr>
                                @endforeach
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
                "columnDefs": [{
                        "orderable": false,
                        "targets": [2]
                    },
                    {
                        "orderable": true,
                        "targets": [0, 1]
                    }
                ],
            });

        });
    </script>
    <script>
        $(document).on('click', '#delete', function(e) {
            swal({
                    title: "Are you sure?",
                    text: "To delete this notification.",
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
