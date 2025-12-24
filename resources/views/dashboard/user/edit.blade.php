@extends('dashboard.layouts.app')

@section('title', 'Edit User')
@section('name_header', 'Edit User')

@section('breadcrumbs')
    <?php
    $breadcrumbs = [['name' => 'User Manage', 'link' => route('manage.users.index')]];
    ?>
@endsection

@section('content')

    @if ($user->trashed())
        <div class="alert alert-warning">
            Folder ini sedang dalam status dihapus. Untuk mengedit detail, Anda harus
            merestore terlebih dahulu.
        </div>
    @endif

    <section id="multiple-column-form">
        <div class="row match-height">
            <div class="col-12">
                <div class="card">

                    <div class="card-header">
                        <h4 class="card-title">Edit User</h4>
                    </div>

                    <div class="card-content">
                        <div class="card-body">

                            <!-- Form -->
                            <form class="form" method="{{ $user->trashed() ? 'POST' : 'POST' }}"
                                action="{{ $user->trashed() ? route('manage.users.restore', $user) : route('manage.users.update', $user) }}">
                                @csrf
                                @if (!$user->trashed())
                                    @method('PUT')
                                @else
                                    @method('PUT') <!-- Restore tetap pakai PUT -->
                                @endif

                                <div class="row">

                                    <div class="col-md-6 col-12">
                                        <div class="form-group">
                                            <label>Name</label>
                                            <input type="text" name="name"
                                                class="form-control @error('name') is-invalid @enderror"
                                                value="{{ old('name', $user->name) }}"
                                                {{ $user->trashed() ? 'disabled' : 'required' }}>
                                            @error('name')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-md-6 col-12">
                                        <div class="form-group">
                                            <label>Email</label>
                                            <input type="email" name="email"
                                                class="form-control @error('email') is-invalid @enderror"
                                                value="{{ old('email', $user->email) }}"
                                                {{ $user->trashed() ? 'disabled' : 'required' }}>
                                            @error('email')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-md-12 col-12">
                                        <div class="form-group">
                                            <label>Role Permission</label>
                                            <select name="role_group_id"
                                                class="form-control @error('role_group_id') is-invalid @enderror"
                                                {{ $user->trashed() ? 'disabled' : 'required' }}>
                                                @foreach ($roles as $role)
                                                    <option value="{{ $role->id }}"
                                                        {{ old('role_group_id', $user->role_group_id) == $role->id ? 'selected' : '' }}>
                                                        {{ Str::title($role->name) }}
                                                    </option>
                                                @endforeach
                                            </select>
                                            @error('role_group_id')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>



                                    <div class="col-12 d-flex justify-content-end">
                                        @if ($user->trashed())
                                            <button type="submit" class="btn btn-success me-1 mb-1">Restore</button>
                                        @else
                                            <button type="submit" class="btn btn-primary me-1 mb-1">Update</button>
                                        @endif
                                        <a href="{{ route('manage.users.index') }}"
                                            class="btn btn-light-secondary me-1 mb-1">Cancel</a>
                                    </div>

                                </div>
                            </form>

                        </div>
                    </div>

                </div>
            </div>
        </div>
    </section>

@endsection
