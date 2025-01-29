@extends('admin.layouts.master')
@section('title')
    Manage Roles - {{ env('APP_NAME') }} admin
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
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h4>Manage Roles</h4>
                <a href="{{ route('admin.manage-roles.create') }}" class="btn btn-primary btn-sm"><i class="fa fa-plus"></i>
                    Create
                    Role</a>
            </div>

            <div class="card">
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered table-hover">
                            <thead class="table-dark">
                                <tr>
                                    <th>#</th>
                                    <th>Role Name</th>
                                    <th style="max-width: 300px;">Permissions</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($roles as $index => $role)
                                    <tr>
                                        <td>{{ $index + 1 }}</td>
                                        <td>{{ ucfirst($role->name) }}</td>
                                        <td style="max-width: 300px;text-wrap: auto;">
                                            @foreach ($role->permissions as $permission)
                                                <span class="badge bg-dark">{{ Str::headline($permission->name) }}</span>
                                            @endforeach
                                        </td>
                                        <td>
                                            <a href="{{ route('admin.manage-roles.edit', $role->id) }}"
                                                class="btn btn-dark btn-sm"><i class="fa fa-pencil-square-o text-white"
                                                    aria-hidden="true"></i></a>
                                            <button type="button" class="btn btn-transparent btn-sm delete-role-btn"
                                                data-role-id="{{ $role->id }}"
                                                data-action="{{ route('admin.manage-roles.destroy', $role->id) }}"
                                                data-bs-toggle="modal" data-bs-target="#deleteRoleModal">
                                                <i class="fa fa-trash" aria-hidden="true"></i>
                                            </button>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>


            <!-- Users Table -->
            <div class="mt-5">

                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h4>Admin Users</h4>
                    <a href="{{ route('admin.manage-users.create') }}" class="btn btn-primary btn-sm"><i
                            class="fa fa-plus"></i>
                        Create
                        Admin User</a>
                </div>

                <table class="table">
                    <thead>
                        <tr>
                            <th>Sr No</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Role(s) & Permissions</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($users as $user)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $user->name }}</td>
                                <td>{{ $user->email }}</td>
                                <td>
                                    @if ($user->roles->isNotEmpty())
                                        <!-- Check if the user has roles -->
                                        @foreach ($user->roles as $role)
                                            <strong>{{ $role->name }}</strong> <!-- Display role name -->
                                            <!-- View Permissions Button -->
                                            <button type="button" class="btn btn-secondary btn-sm ms-2"
                                                data-bs-toggle="modal"
                                                data-bs-target="#permissionsModal{{ $role->id }}">
                                                <i class="fa fa-eye" aria-hidden="true"></i>
                                            </button>

                                            <!-- Permissions Modal -->
                                            <div class="modal fade" id="permissionsModal{{ $role->id }}" tabindex="-1"
                                                aria-labelledby="permissionsModalLabel{{ $role->id }}"
                                                aria-hidden="true">
                                                <div class="modal-dialog">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title"
                                                                id="permissionsModalLabel{{ $role->id }}">Permissions
                                                                for Role: {{ $role->name }}</h5>
                                                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                                aria-label="Close"></button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <ul style="max-height: 400px; overflow-y: auto;">
                                                                @foreach ($role->permissions as $permission)
                                                                    <li>{{ Str::headline($permission->name) }}</li>
                                                                    <!-- Display permissions associated with the role -->
                                                                @endforeach
                                                            </ul>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-secondary"
                                                                data-bs-dismiss="modal">Close</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                    @else
                                        No role assigned
                                    @endif
                                </td>

                                <td>
                                    <a href="{{ route('admin.manage-users.edit', $user->id) }}"
                                        class="btn btn-dark btn-sm"><i class="fa fa-pencil-square-o text-white"
                                            aria-hidden="true"></i></a>

                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>

            </div>





        </div>
    </div>

    <!-- Delete Confirmation Modal -->
    <div class="modal fade" id="deleteRoleModal" tabindex="-1" aria-labelledby="deleteRoleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header bg-danger text-white">
                    <h5 class="modal-title" id="deleteRoleModalLabel">Confirm Deletion</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    Are you sure you want to delete this role?<br> This action cannot be undone.
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <form id="deleteRoleForm" method="POST">
                        @csrf
                        <button type="submit" class="btn btn-danger">Delete</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const deleteModal = document.getElementById('deleteRoleModal');
            const deleteForm = document.getElementById('deleteRoleForm');

            document.querySelectorAll('.delete-role-btn').forEach(button => {
                button.addEventListener('click', function() {
                    const action = this.getAttribute('data-action');
                    deleteForm.setAttribute('action', action);
                });
            });
        });
    </script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Show/Hide Permissions List when clicking on Role Name
            document.querySelectorAll('.role-name').forEach(roleName => {
                roleName.addEventListener('click', function() {
                    const roleId = this.getAttribute('data-role-id');
                    const permissionsList = document.getElementById('permissions-' + roleId);
                    if (permissionsList.style.display === 'none') {
                        permissionsList.style.display = 'block';
                    } else {
                        permissionsList.style.display = 'none';
                    }
                });
            });

            // Handle Delete User Form with Confirmation
            document.querySelectorAll('.delete-user-form').forEach(form => {
                form.addEventListener('submit', function(event) {
                    event.preventDefault();
                    if (confirm("Are you sure you want to delete this user?")) {
                        this.submit();
                    }
                });
            });
        });
    </script>
@endpush
