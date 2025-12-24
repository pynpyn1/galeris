@extends('dashboard.layouts.app')

@section('title', 'Add User')
@section('name_header', 'Add User')

@section('breadcrumbs')
    <?php
    $breadcrumbs = [['name' => 'User Manage', 'link' => route('manage.users.index')]];
    ?>
@endsection

@section('content')

    <section id="multiple-column-form">
        <div class="row match-height">
            <div class="col-12">
                <div class="card">

                    <div class="card-header">
                        <h4 class="card-title">Create New User</h4>
                    </div>

                    <div class="card-content">
                        <div class="card-body">

                            <form class="form" method="POST" action="{{ route('manage.users.store') }}">
                                @csrf
                                <div class="row">

                                    <!-- Name -->
                                    <div class="col-md-6 col-12">
                                        <div class="form-group">
                                            <label>Name</label>
                                            <input type="text" name="name"
                                                class="form-control @error('name') is-invalid @enderror"
                                                value="{{ old('name') }}" required>
                                            @error('name')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>

                                    <!-- Email -->
                                    <div class="col-md-6 col-12">
                                        <div class="form-group">
                                            <label>Email</label>
                                            <input type="email" name="email"
                                                class="form-control @error('email') is-invalid @enderror"
                                                value="{{ old('email') }}" required>
                                            @error('email')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>


                                    <!-- Nomor -->
                                    <div class="col-md-6 col-12">
                                        <div class="form-group">
                                            <label>Nomor Telpon</label>
                                            <input placeholder="62" type="number" name="phone"
                                                class="form-control @error('phone') is-invalid @enderror"
                                                value="{{ old('phone') }}" required>
                                            @error('phone')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>

                                    <!-- Role Group (Normal Select) -->
                                    <div class="col-md-6 col-12">
                                        <div class="form-group">
                                            <label>Role Permission</label>
                                            <select name="role_group_id"
                                                class=" form-control  @error('role_group_id') is-invalid @enderror"
                                                required>
                                                <option value="" disabled selected>Pilih Role</option>
                                                @foreach ($roles as $role)
                                                    <option value="{{ $role->id }}"
                                                        {{ old('role_group_id') == $role->id ? 'selected' : '' }}>
                                                        {{ Str::title($role->name) }}
                                                    </option>
                                                @endforeach
                                            </select>
                                            @error('role_group_id')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>

                                    <!-- Password -->
                                    <div class="col-md-6 col-12">
                                        <div class="form-group">
                                            <label>Password</label>
                                            <input type="password" name="password"
                                                class="form-control @error('password') is-invalid @enderror" required>
                                            @error('password')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>

                                    <!-- Confirm Password -->
                                    <div class="col-md-6 col-12">
                                        <div class="form-group">
                                            <label>Confirm Password</label>
                                            <input type="password" name="password_confirmation"
                                                class="form-control @error('password_confirmation') is-invalid @enderror"
                                                required>
                                            @error('password_confirmation')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>

                                    <!-- Buttons -->
                                    <div class="col-12 d-flex justify-content-end">
                                        <button type="submit" class="btn btn-primary me-1 mb-1">Save</button>
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
