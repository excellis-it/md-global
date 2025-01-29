@extends('admin.layouts.master')
@section('title')
    All Qna Details - {{ env('APP_NAME') }} admin
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
                        <h3 class="page-title">Qnas Information</h3>
                        <ul class="breadcrumb">
                            <li class="breadcrumb-item">CMS</li>
                            <li class="breadcrumb-item"><a href="{{ route('cms.qna.index') }}">Qnas</a></li>
                            <li class="breadcrumb-item active">List</li>
                        </ul>
                    </div>
                    <div class="col-auto float-end ms-auto">
                        <a href="#" class="btn add-btn" data-bs-toggle="modal" data-bs-target="#add_qna"><i
                                class="fa fa-plus"></i> Add QNA</a>
                    </div>
                </div>
            </div>

            <div class="card">
                <div class="card-body">
                    <div class="card-title">
                        <div class="row">
                            <div class="col-md-6">
                                <h4 class="mb-0">Qnas Details</h4>
                            </div>

                        </div>
                    </div>

                    <hr />
                    <div class="table-responsive">
                        <table id="myTable" class="dd table table-striped table-bordered" style="width:100%">
                            <thead>
                                <tr>
                                    <th> # </th>
                                    <th> Question</th>
                                    <th> Answer</th>
                                    <th>Status</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($qnas as $key => $qna)
                                    <tr>
                                        <td>{{ $key + 1 }}</td>
                                        <td>{{ $qna->question }}</td>
                                        <td>{!! substr($qna->answer, 0, 50) !!}.....</td>
                                        <td>
                                            <div class="button-switch">
                                                <input type="checkbox" id="switch-orange" class="switch toggle-class"
                                                    data-id="{{ $qna['id'] }}" {{ $qna['status'] ? 'checked' : '' }} />
                                                <label for="switch-orange" class="lbl-off"></label>
                                                <label for="switch-orange" class="lbl-on"></label>
                                            </div>
                                        </td>
                                        <td>
                                            <a title="Edit Qna" class="edit-qna" href="#" data-bs-toggle="modal"
                                                data-bs-target="#edit_qna" data-id="{{ $qna->id }}"
                                                data-route="{{ route('cms.qna.edit', $qna->id) }}"><i
                                                    class="fas fa-edit"></i></a> &nbsp;&nbsp;

                                            <a title="Delete Qna" data-route="{{ route('cms.qna.delete', $qna->id) }}"
                                                href="javascipt:void(0);" id="delete"><i class="fas fa-trash"></i></a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div id="add_qna" class="modal custom-modal fade" role="dialog">
                <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">Create QNA</h5>
                            <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <form action="{{ route('cms.qna.store') }}" method="POST" id="createForm"
                                enctype="multipart/form-data">
                                @csrf
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label>Question<span class="text-danger">*</span></label>
                                                    <input type="text" class="form-control" name="question"
                                                        id="question">
                                                </div>
                                            </div>
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label>Answer<span class="text-danger">*</span></label>
                                                    <textarea name="answer" id="answer" cols="30" rows="10" class="form-control"></textarea>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="submit-section">
                                    <button class="btn btn-primary submit-btn">Create</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <div id="edit_qna" class="modal custom-modal fade" role="dialog">
                <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">Edit Question & Answer</h5>
                            <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <form action="{{ route('cms.qna.update') }}" method="POST" id="editForm"
                                enctype="multipart/form-data">
                                @csrf
                                <div class="row">
                                    <div class="col-md-12">
                                        <input type="hidden" id="hidden_id" name="id" value="">
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label>Question<span class="text-danger">*</span></label>
                                                    <input type="text" class="form-control" name="edit_question"
                                                        id="edit_question">
                                                </div>
                                            </div>
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label>Answer<span class="text-danger">*</span></label>
                                                    <textarea type="text" class="form-control" name="edit_answer" id="edit_answer" cols="30" rows="10"> </textarea>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="submit-section">
                                    <button class="btn btn-primary submit-btn">Update</button>
                                </div>
                            </form>
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
        // ClassicEditor.create(document.querySelector("#edit_answer"));
        // ClassicEditor.create(document.querySelector("#answer"));
    </script>
    <script>
        $(document).ready(function() {
            //Default data table
            $('#myTable').DataTable({
                "aaSorting": [],
                "columnDefs": [{
                        "orderable": false,
                        "targets": [3, 4]
                    },
                    {
                        "orderable": true,
                        "targets": [0, 1, 2]
                    }
                ]
            });

        });
        $(document).ready(function() {
            // Initialize CKEditor and keep a reference
            let editorInstance;
            ClassicEditor
                .create(document.querySelector("#answer"))
                .then(editor => {
                    editorInstance = editor;
                    // Listen for changes in the CKEditor instance
                    editor.model.document.on('change:data', () => {
                        // Update the textarea
                        editor.updateSourceElement();
                        // Manually trigger validation for the answer field
                        $("#createForm").validate().element("#answer");
                    });
                })
                .catch(error => {
                    console.error(error);
                });

            // Initialize form validation
            $('#createForm').validate({
                ignore: [], // Important for hidden textarea (replaced by CKEditor)
                rules: {
                    question: {
                        required: true,
                    },
                    answer: {
                        required: true, // This will work because the textarea is updated on change
                    },
                },
                messages: {
                    question: {
                        required: "Please enter question",
                    },
                    answer: {
                        required: "Please enter answer",
                    },
                },
            });
        });
    </script>
    <script>
        $(document).on('click', '#delete', function(e) {
            swal({
                    title: "Are you sure?",
                    text: "To delete this qna.",
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
                url: '{{ route('cms.qna.change-status') }}',
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
    <script>
        $(document).ready(function() {
            // Initialize CKEditor and keep a reference
            let editorInstance;
            ClassicEditor
                .create(document.querySelector("#edit_answer"))
                .then(editor => {
                    editorInstance = editor;
                    // Listen for changes in the CKEditor instance
                    editor.model.document.on('change:data', () => {
                        // Update the textarea
                        editor.updateSourceElement();
                        // Manually trigger validation for the edit_answer field
                        $("#editForm").validate().element("#edit_answer");
                    });
                })
                .catch(error => {
                    console.error(error);
                });

            $('.edit-qna').on('click', function() {
                var id = $(this).data('id');
                var route = $(this).data('route');
                $('#loading').addClass('loading');
                $('#loading-content').addClass('loading-content');
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
                $.ajax({
                    url: route,
                    type: 'POST',
                    data: {
                        id: id,
                    },
                    dataType: 'JSON',
                    success: async function(data) {
                        await $('#hidden_id').val(data.qna.id);
                        await $('#edit_question').val(data.qna.question);

                        // Set value in CKEditor instance
                        if (editorInstance) {
                            editorInstance.setData(data.qna.answer);
                        }

                        await $('#loading').removeClass('loading');
                        await $('#loading-content').removeClass('loading-content');
                    }
                });
            });

            // Initialize form validation
            $('#editForm').validate({
                ignore: [], // Important for hidden textarea (replaced by CKEditor)
                rules: {
                    edit_question: {
                        required: true,
                    },
                    edit_answer: {
                        required: true, // This will work because the textarea is updated on change
                    },
                },
                messages: {
                    edit_question: {
                        required: "Please enter question",
                    },
                    edit_answer: {
                        required: "Please enter answer",
                    },
                },
            });
        });
    </script>
@endpush
