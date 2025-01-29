@extends('admin.layouts.master')
@section('title')
    Edit Role - {{ env('APP_NAME') }} admin
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
            <div class="row">
                <div class="col-md-8 offset-md-2">
                    <div class="card">
                        <div class="card-header">
                            <h4>Edit Role</h4>
                        </div>
                        <div class="card-body">
                            @if (session('error'))
                                <div class="alert alert-danger">{{ session('error') }}</div>
                            @endif
                            <form action="{{ route('admin.manage-roles.update', $role->id) }}" method="POST">
                                @csrf
                                <div class="mb-3">
                                    <label class="form-label">Role Name</label>
                                    <input type="text" name="name" class="form-control" value="{{ $role->name }}"
                                        required>
                                    @error('name')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label class="form-label">Assign Permissions</label>
                                    <div class="row">
                                        @foreach ($permissions as $permission)
                                            <div class="col-md-4">
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" name="permissions[]"
                                                        value="{{ $permission->name }}" id="perm-{{ $permission->id }}"
                                                        {{ in_array($permission->name, $rolePermissions) ? 'checked' : '' }}>
                                                    <label class="form-check-label" for="perm-{{ $permission->id }}">
                                                        {{ Str::headline($permission->name) }}
                                                    </label>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                    @error('permissions')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>

                                <button type="submit" class="btn btn-primary">Update Role</button>
                                <a href="{{ route('admin.manage-roles') }}" class="btn btn-secondary">Cancel</a>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
@endsection
