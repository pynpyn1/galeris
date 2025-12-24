@extends('dashboard.layouts.app')

@section('title', 'Add Video')
@section('name_header', 'Add Video')

@section('breadcrumbs')
    <?php
    // Mengubah breadcrumbs dari Photo Manage ke Video Manage
    $breadcrumbs = [['name' => 'Video Manage', 'link' => route('manage.video.index')]];
    ?>
@endsection

@section('content')

    {{-- Notifikasi --}}
    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    @if (session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    @if ($errors->any())
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <strong>Gagal Menyimpan!</strong> Silakan periksa kembali input Anda.
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <section id="multiple-column-form">
        <div class="row match-height">
            <div class="col-12">
                <div class="card">

                    <div class="card-header">
                        <h4 class="card-title">Upload New Video</h4>
                    </div>

                    <div class="card-content">
                        <div class="card-body">

                            {{-- FORM --}}
                            <form class="form" id="create-video-form" method="POST" {{-- Mengubah route ke manage.video.store --}}
                                action="{{ route('manage.video.store') }}" enctype="multipart/form-data">
                                @csrf

                                <div class="row">

                                    {{-- Folder --}}
                                    <div class="col-md-12 col-12">
                                        <div class="form-group">
                                            <label for="folder-id-column">Pilih Folder Tujuan</label>
                                            <select name="folder_id" id="folder-id-column"
                                                class="form-control @error('folder_id') is-invalid @enderror" required>
                                                <option value="" disabled selected>Pilih Folder</option>
                                                @foreach ($folders as $folder)
                                                    <option value="{{ $folder->id }}">{{ $folder->name }}</option>
                                                @endforeach
                                            </select>
                                            @error('folder_id')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-md-6 col-12"></div>

                                    {{-- Dropzone Area --}}
                                    <div class="col-12 mt-3">
                                        <label>Upload Video (Multiple & Drag & Drop)</label>

                                        {{-- Mengubah ID dropzone --}}
                                        <div class="dropzone" id="video-dropzone"></div>

                                        {{-- Mengubah informasi format dan ukuran --}}
                                        <small class="text-muted">Format: MP4, MOV, AVI, WEBM — Maks 100MB per file.</small>
                                    </div>

                                    {{-- Buttons --}}
                                    <div class="col-12 d-flex justify-content-end mt-3">
                                        <button type="submit" class="btn btn-primary me-1 mb-1">Upload Video</button>
                                        {{-- Mengubah route cancel --}}
                                        <a href="{{ route('manage.video.index') }}"
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

@push('styles')
    {{-- Dropzone CSS --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.9.3/dropzone.min.css" />
@endpush

@push('scripts')
    {{-- Dropzone JS --}}
    <script src="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.9.3/dropzone.min.js"></script>

    <script>
        Dropzone.autoDiscover = false;

        // Mengubah ID dropzone
        var dz = new Dropzone("#video-dropzone", {
            url: "#",
            autoProcessQueue: false,
            uploadMultiple: true,
            parallelUploads: 5, // Mengurangi parallel uploads karena file video lebih besar
            maxFiles: 10,
            maxFilesize: 100,
            // Mengubah acceptedFiles menjadi format video
            acceptedFiles: "video/mp4,video/mov,video/avi,video/webm",
            addRemoveLinks: true,
            dictDefaultMessage: "Seret & jatuhkan video di sini atau klik untuk memilih",
            dictRemoveFile: "Hapus",
            // Pesan error jika ukuran file melebihi batas
            // Baris bermasalah:
            dictFileTooBig: "Ukuran file terlalu besar (@{{ filesize }}MiB). Maksimum: @{{ maxFilesize }}MiB.",
        });

        // Mengubah ID form
        document.getElementById('create-video-form').addEventListener('submit', function(e) {
            e.preventDefault();

            let form = this;

            dz.getAcceptedFiles().forEach(file => {

                let dataTransfer = new DataTransfer();
                dataTransfer.items.add(file);

                let input = document.createElement('input');
                input.type = 'file';
                // PENTING: Mengubah nama input file menjadi 'video_file[]'
                input.name = 'video_file[]';
                input.files = dataTransfer.files;

                form.appendChild(input);
            });

            if (dz.getAcceptedFiles().length === 0) {
                alert('Silakan pilih minimal 1 video');
                return;
            }

            form.submit();
        });
    </script>
@endpush
