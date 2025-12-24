@extends('dashboard.layouts.app')
@section('title', 'Role Permission')
@section('name_header', 'Role Permission')

@section('content')
    <div class="container">
        <div class="d-flex mb-4">
            <a href="{{ route('manage.roles.group.edit') }}" class="btn btn-primary me-2">
                Kelola Role Group & Permissions
            </a>

            <a href="{{ route('manage.roles.assign.edit') }}" class="btn btn-info text-white">
                Kelola Assignment
            </a>
        </div>

        <hr>

        <div class="card mb-4">
            <div class="card-header">
                <h3>Daftar Role Groups ({{ $roleGroups->count() }})</h3>
            </div>
            <div class="card-body">
                <ul class="list-group">
                    @forelse ($roleGroups as $group)
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            {{ $group->name }}
                            <span class="badge bg-primary rounded-pill">{{ $group->id }}</span>
                        </li>
                    @empty
                        <li class="list-group-item text-muted">Belum ada Role Group yang dibuat.</li>
                    @endforelse
                </ul>
            </div>
        </div>

        <hr>

        <div class="card mb-4">
            <div class="card-header">
                <h3>Daftar Permissions ({{ $permissions->count() }})</h3>
            </div>
            <div class="card-body">
                <ul class="list-group">
                    @forelse ($permissions as $permission)
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            {{ $permission->name }}
                            <span class="badge bg-primary rounded-pill">{{ $permission->slug }}</span>
                        </li>
                    @empty
                        <li class="list-group-item text-muted">Belum ada Permission yang tersedia.</li>
                    @endforelse
                </ul>
            </div>
        </div>

    </div>
@endsection
