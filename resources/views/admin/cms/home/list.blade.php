@extends('admin.layouts.master')
@section('title')
    All Home Details - {{ env('APP_NAME') }} admin
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
                        <h3 class="page-title">Home Information</h3>
                        <ul class="breadcrumb">
                            <li class="breadcrumb-item">CMS</li>
                            <li class="breadcrumb-item"><a href="{{ route('cms.home.index') }}">Home Page</a></li>
                            <li class="breadcrumb-item active">List</li>
                        </ul>
                    </div>
                    {{-- <div class="col-auto float-end ms-auto">
                        <a href="#" class="btn add-btn" data-bs-toggle="modal" data-bs-target="#add_qna"><i
                                class="fa fa-plus"></i> Add Home Page Details</a>
                    </div> --}}
                </div>
            </div>
            <div class="card toggle-add">
                <div class="card-body">
                    <div class="card-title">
                        <div class="row">
                            <div class="col-xl-12 mx-auto">
                                <hr>
                                <div class="card border-0 border-4">
                                    <div class="card-body">
                                        <form action="{{ route('cms.home.store') }}" method="post"
                                            enctype="multipart/form-data" id="createForm">
                                            @csrf
                                            <input type="hidden" name="hidden_id" id="hidden_id">
                                            <div class="border p-4 rounded">
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <label for="inputEnterYourName" class="col-form-label">
                                                            Title</label>
                                                        <textarea type="text" name="title" id="title" cols="30" rows="10" class="form-control" value=""
                                                            placeholder="Enter Title"></textarea>

                                                    </div>
                                                    <div class="col-md-6">
                                                        <label for="inputEnterYourName" class="col-form-label"> Sub
                                                            Title</label>
                                                        <textarea type="text" name="sub_title" id="sub_title" cols="30" rows="10" class="form-control"
                                                            value="" placeholder="Enter Sub Title"></textarea>

                                                    </div>

                                                    <div class="col-md-6">
                                                        <label for="inputEnterYourName" class="col-form-label">
                                                            Image</label>
                                                        <input type="file" name="image" id="image"
                                                            class="form-control" value="{{ old('image') }}"
                                                            accept="image/*">

                                                    </div>
                                                    {{-- <div class="col-md-6">
                                                        <label for="inputEnterYourName" class="col-form-label"> Type <span style="color: red;">*</span></label>
                                                        <select name="type" id="type" class="form-control">
                                                            <option value="">Select a type</option>
                                                            <option value="1">Banner</option>
                                                            <option value="2">Body</option>
                                                        </select>

                                                    </div> --}}
                                                    <div class="row" style="margin-top: 20px; float: left;">
                                                        <div class="col-sm-9">
                                                            <button type="submit" class="btn px-5 submit-btn updateBtn"
                                                                id="updateBtn">Create</button>
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

            <div class="card">
                <div class="card-body">
                    <div class="card-title">
                        <div class="row">
                            <div class="col-md-6">
                                <h4 class="mb-0">Home Details</h4>
                            </div>

                        </div>
                    </div>

                    <hr />
                    <div class="table-responsive">
                        <table id="myTable" class="dd table table-striped table-bordered" style="width:100%">
                            <thead>
                                <tr>
                                    <th> # </th>
                                    <th> Title</th>
                                    <th> Sub Title</th>
                                    <th>Image</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($homePage as $key => $home)
                                    <tr>
                                        <td>{{ $key + 1 }}</td>
                                        <td>{!! substr($home->title, 0, 50) !!}
                                            {!! strlen($home->title) > 50 ? '....' : '' !!}</td>
                                        <td>{!! substr($home->sub_title, 0, 50) !!}{!! strlen($home->sub_title) > 50 ? '....' : '' !!}
                                        </td>
                                        <td>
                                            <img src="{{ $home->image }}" alt="image"
                                                style="width: 100px; height: 100px;">
                                        </td>
                                        <td>
                                            <a title="Edit Home" class="edit-home" href="#" data-bs-toggle="modal"
                                                data-bs-target="#edit_qna" data-id="{{ $home->id }}"
                                                data-route="{{ route('cms.home.edit') }}"><i class="fas fa-edit"></i></a>
                                            &nbsp;&nbsp;

                                            {{-- <a title="Delete Home" data-route="{{ route('cms.home.delete', $home->id) }}"
                                                href="javascipt:void(0);" id="delete"><i class="fas fa-trash"></i></a> --}}
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
    </script>
    <script>
        $(document).on('click', '#delete', function(e) {
            swal({
                    title: "Are you sure?",
                    text: "To delete this home.",
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
        // toggle add
        $(document).ready(function() {
            $('.toggle-add').hide();
            $('.add-btn').click(function() {
                $('.toggle-add').toggle();
            });
        });
    </script>
    <script src="https://cdn.ckeditor.com/ckeditor5/28.0.0/classic/ckeditor.js"></script>
    <script>
        let editors = {};

        // Initialize CKEditor for the specified fields
        ClassicEditor.create(document.querySelector("#title"))
            .then(editor => {
                editors['title'] = editor;
            })
            .catch(error => {
                console.error(error);
            });

        ClassicEditor.create(document.querySelector("#sub_title"))
            .then(editor => {
                editors['sub_title'] = editor;
            })
            .catch(error => {
                console.error(error);
            });

        $('.edit-home').on('click', function() {
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
                success: function(data) {
                    // Scroll to the top of the page
                    $('html, body').animate({
                        scrollTop: 0
                    }, 'fast');

                    $('.toggle-add').show();

                    // Set values for the hidden input
                    $('#hidden_id').val(data.homePage.id);

                    // Update CKEditor content
                    if (editors['title']) {
                        editors['title'].setData(data.homePage.title);
                    }
                    if (editors['sub_title']) {
                        editors['sub_title'].setData(data.homePage.sub_title);
                    }

                    // Update the button text and remove loading indicators
                    $('#updateBtn').text('Update');
                    $('#loading').removeClass('loading');
                    $('#loading-content').removeClass('loading-content');
                },
                error: function(xhr) {
                    console.error(xhr.responseText);
                    $('#loading').removeClass('loading');
                    $('#loading-content').removeClass('loading-content');
                }
            });
        });
    </script>

    <script>
        $(document).ready(function() {
            $('#createForm').validate({
                rules: {
                    title: {
                        required: true,
                    },
                    sub_title: {
                        required: true,
                    },

                    // type: {
                    //     required: true,
                    // },

                },

                messages: {
                    title: {
                        required: "Please enter title",
                    },
                    sub_title: {
                        required: "Please enter sub title",
                    },

                    // type: {
                    //     required: "Please select type",
                    // },
                },

            });
        });
    </script>
    <script>
        $(document).ready(function() {
            $('#editForm').validate({
                rules: {
                    edit_question: {
                        required: true,
                    },
                    edit_answer: {
                        required: true,
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
