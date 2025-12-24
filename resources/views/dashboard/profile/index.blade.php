@extends('dashboard.layouts.app')
@section('title', 'Profile Settings')
@section('name_header', 'Profile Settings')


@section('content')
    <div class="container">

        {{-- alert --}}
        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        {{-- error --}}
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul class="m-0">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <hr>

        <div class="row">
            <div class="col-md-6">
                <h5>Informasi Profil</h5>

                <div class="mb-3 text-center">
                    <img src="{{ $user->profile_photo_path
                        ? asset('storage/' . $user->profile_photo_path)
                        : 'https://ui-avatars.com/api/?name=' . urlencode($user->name) }}"
                        alt="Foto Profil" class="rounded-circle mb-3" width="120" height="120"
                        style="object-fit: cover;">
                </div>

                <form action="{{ route('profile.update', $user->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <div class="mb-3">
                        <label>Nama <code>*</code></label>
                        <input type="text" name="name" class="form-control" value="{{ old('name', $user->name) }}">
                    </div>

                    <div class="mb-3">
                        <label>Nama Terlibat </label>
                        <input type="text" placeholder="Man Engaged & Woman Engaged" name="name_engaged"
                            class="form-control" value="{{ old('name_engaged', $user->name_engaged) }}">
                    </div>

                    <div class="mb-3">
                        <label>Email <code>*</code></label>
                        <input type="email" name="email" class="form-control" value="{{ old('email', $user->email) }}">
                    </div>

                    <div class="mb-3">
                        <label>Foto Profil <code>*</code></label>
                        <input type="file" name="profile_photo_path" class="form-control">
                    </div>

                    <button class="btn btn-primary w-100">Update Profil</button>
                </form>
            </div>

            <div class="col-md-6 mt-5 mt-md-0">
                <h5>Ganti Password</h5>

                <form action="{{ route('profile.password', $user->id) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="mb-3">
                        <label>Password Lama</label>
                        <input type="password" name="current_password" class="form-control">
                    </div>

                    <div class="mb-3">
                        <label>Password Baru</label>
                        <input type="password" name="new_password" class="form-control">
                    </div>

                    <div class="mb-3">
                        <label>Konfirmasi Password Baru</label>
                        <input type="password" name="new_password_confirmation" class="form-control">
                    </div>

                    <button class="btn btn-warning w-100">Update Password</button>
                </form>
            </div>
        </div>

    </div>
@endsection
