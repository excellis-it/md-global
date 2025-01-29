@extends('admin.layouts.master')
@section('title')
    Edit Admin User - {{ env('APP_NAME') }} admin
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

            <div class="card card-body">

                <h4>Edit Admin User</h4>

                <hr>

                <form action="{{ route('admin.manage-users.update', $user->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="name" class="form-label">Name</label>
                                <input type="text" class="form-control" id="name" name="name"
                                    value="{{ $user->name }}" required>
                            </div>

                            <div class="mb-3">
                                <label for="email" class="form-label">Email</label>
                                <input type="email" class="form-control" id="email" name="email"
                                    value="{{ $user->email }}" required>
                            </div>

                            <div class="mb-3">
                                <label for="password" class="form-label">Password (Leave blank to keep current)</label>
                                <input type="password" class="form-control" id="password" name="password"
                                    autocomplete="new-password">
                            </div>

                            <div class="mb-3">
                                <label for="password_confirmation" class="form-label">Confirm Password</label>
                                <input type="password" class="form-control" id="password_confirmation"
                                    name="password_confirmation">
                            </div>

                            <div class="mb-3">
                                <label for="status" class="form-label">Status</label>
                                <select class="form-select" id="status" name="status" required>
                                    <option value="1" {{ $user->status == 1 ? 'selected' : '' }}>Active</option>
                                    <option value="0" {{ $user->status == 0 ? 'selected' : '' }}>Inactive</option>
                                </select>
                            </div>

                            <button type="submit" class="btn btn-primary">Update</button>

                        </div>

                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Assign Role</label><br>
                                @foreach ($roles as $role)
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="role_id"
                                            id="role_{{ $role->id }}" value="{{ $role->id }}"
                                            {{ $user->roles->contains($role->id) ? 'checked' : '' }}>
                                        <label class="form-check-label"
                                            for="role_{{ $role->id }}">{{ $role->name }}</label>
                                    </div>
                                @endforeach
                            </div>

                            <div id="permissions-list" class="mt-3 card card-body shadows">
                                <!-- Permissions will be shown here dynamically -->
                            </div>
                        </div>

                    </div>

                </form>

            </div>
        </div>

    </div>
@endsection

@push('scripts')
    <script>
        $(document).ready(function() {
            // Handle role selection and show permissions dynamically
            $('input[name="role_id"]').on('change', function() {
                const roleId = $(this).val();

                // Make an AJAX request to get permissions for the selected role using the route name
                $.ajax({
                    url: "{{ route('admin.roles.permissions') }}", // Use route name
                    method: 'POST',
                    data: {
                        _token: '{{ csrf_token() }}',
                        role_id: roleId
                    },
                    success: function(data) {
                        let permissionsHTML = '';
                        const colSize = 12 / Math.min(2, data
                        .length); // 4 columns max for permissions

                        // Generate permissions in grid format
                        data.forEach(function(permission) {

                            const permissionName = permission.name.replace(/_/g, ' ')
                                .replace(/\b\w/g, function(char) {
                                    return char.toUpperCase();
                                });

                            permissionsHTML += `
                            <div class="col-${colSize} mb-2">
                                    <label class="form-check-label" for="permission_${permission.id}">${permissionName}</label>
                            </div>
                        `;
                        });

                        // Insert the permissions list into the permissions div
                        $('#permissions-list').html(`
                        <h5>Permissions</h5>
                        <div class="row mt-2">
                            ${permissionsHTML}
                        </div>
                    `);
                    },
                    error: function(xhr, status, error) {
                        console.log('Error fetching permissions:', error);
                    }
                });
            });
        });
    </script>
@endpush
