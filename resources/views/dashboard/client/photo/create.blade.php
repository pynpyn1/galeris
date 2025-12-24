@extends('dashboard.layouts.app')

@section('title', 'Upload Foto')
@section('name_header', 'Upload Foto')

@section('breadcrumbs')
    <?php
    $breadcrumbs = [['name' => 'Photo Manage', 'link' => route('photo.index')]];
    ?>
@endsection

@section('content')

    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    @if (session('error'))
        <div class="alert alert-danger alert-dismissible fade show">
            {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <section class="section">

        <div class="card">
            <div class="card-header">
                <h4>Tambah Foto Baru</h4>
            </div>

            <div class="card-body">

                <form action="{{ route('photo.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf

                    {{-- PILIH FOLDER --}}
                    <div class="mb-3">
                        <label class="form-label">Pilih Folder</label>
                        <select name="folder_id" class="form-control @error('folder_id') is-invalid @enderror" required>
                            <option value="" disabled selected>-- Pilih Folder --</option>
                            @foreach ($folders as $folder)
                                <option value="{{ $folder->id }}">{{ $folder->name }}</option>
                            @endforeach
                        </select>
                        @error('folder_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- UPLOAD MULTIPLE FOTO --}}
                    <div class="mb-3">
                        <label class="form-label">Upload Foto (Multiple)</label>
                        <input type="file" class="form-control @error('photo_file.*') is-invalid @enderror"
                            name="photo_file[]" accept="image/*" multiple required>
                        <small class="text-muted">Format: JPG, PNG, GIF — Max 5MB per file.</small>

                        @error('photo_file.*')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="d-flex justify-content-end mt-4">
                        <button class="btn btn-primary">Upload</button>
                        <a href="{{ route('photo.index') }}" class="btn btn-light ms-2">Cancel</a>
                    </div>

                </form>

            </div>
        </div>

    </section>

@endsection
