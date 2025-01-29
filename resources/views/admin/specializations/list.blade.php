@extends('admin.layouts.master')
@section('title')
    All Specialization Details - {{ env('APP_NAME') }} admin
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
                        <h3 class="page-title">Specializations Information</h3>
                        <ul class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('specializations.index') }}">Specializations</a>
                            </li>
                            <li class="breadcrumb-item active">List</li>
                        </ul>
                    </div>
                    <div class="col-auto float-end ms-auto">
                        <a href="{{ route('specializations.create') }}" class="btn add-btn"><i class="fa fa-plus"></i> Add a
                            Specialization</a>
                    </div>
                </div>
            </div>

            <div class="card">
                <div class="card-body">
                    <div class="card-title">
                        <div class="row">
                            <div class="col-md-6">
                                <h4 class="mb-0">Specializations Details</h4>
                            </div>

                        </div>
                    </div>

                    <hr />
                    <div class="table-responsive">
                        <table id="myTable" class="dd table table-striped table-bordered" style="width:100%">
                            <thead>
                                <tr>
                                    <th>Specializations Name</th>
                                    <th>Slug</th>
                                    <th>Status</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @include('admin.specializations.specializations-list')
                            </tbody>
                        </table>

                    </div>
                </div>
            </div>

        </div>

    </div>
@endsection

@push('scripts')
    <link rel="stylesheet" href="https://cdn.datatables.net/rowreorder/1.3.2/css/rowReorder.dataTables.min.css">
    <script src="https://cdn.datatables.net/rowreorder/1.3.2/js/dataTables.rowReorder.min.js"></script>
    <script>
        $(document).ready(function() {
            // Initialize DataTable
            var table = $('#myTable').DataTable({
                "aaSorting": [],
                "columnDefs": [{
                        "orderable": false,
                        "targets": [2, 3]
                    },
                    {
                        "orderable": true,
                        "targets": [0, 1]
                    }
                ],

            });

            table.on('row-reorder', function(e, diff, edit) {
                console.log('Row Reorder Event:', e);
                console.log('Row Reorder Diff:', diff);
                console.log('Row Reorder Edit:', edit);

                var reorderData = diff.map(function(row) {
                    return {
                        id: $(row.node).attr('id').replace('row_', ''),
                        newPosition: row.newData
                    };
                });

                $.ajax({
                    url: "{{ route('specializations.reorder') }}",
                    method: 'POST',
                    data: {
                        _token: '{{ csrf_token() }}',
                        reorderData: reorderData
                    },
                    success: function(response) {

                        if (response.status == 'success') {
                            toastr.success('Reordering updated successfully');
                            // Update the table body content
                            $('#myTable').DataTable().clear().draw();
                            $('#myTable').find('tbody').html(response.view);
                            $('#myTable').DataTable().rows.add($('#myTable').find('tbody tr'))
                                .draw();
                        } else {
                            // toastr.error('Failed to update reordering');

                        }
                    },

                    error: function(xhr, status, error) {
                        console.error('Error:', error);
                        alert('Failed to update reordering');
                    }
                });
            });
        });
    </script>


    <script>
        $(document).on('click', '#delete', function(e) {
            swal({
                    title: "Are you sure?",
                    text: "To delete this specialization.",
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
    <script>
        $('.toggle-class').change(function() {
            var status = $(this).prop('checked') == true ? 1 : 0;
            var id = $(this).data('id');

            $.ajax({
                type: "GET",
                dataType: "json",
                url: '{{ route('specializations.change-status') }}',
                data: {
                    'status': status,
                    'id': id
                },
                success: function(resp) {
                    console.log(resp.success)
                }
            });
        });
    </script>
@endpush
