@extends('dashboard.layouts.app')

@section('title', 'Add Photo')
@section('name_header', 'Add Photo')

@section('breadcrumbs')
    <?php
    $breadcrumbs = [['name' => 'Photo Manage', 'link' => route('manage.photo.index')]];
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
                        <h4 class="card-title">Upload New Photo</h4>
                    </div>

                    <div class="card-content">
                        <div class="card-body">

                            {{-- FORM --}}
                            <form class="form" id="create-photo-form" method="POST"
                                action="{{ route('manage.photo.store') }}" enctype="multipart/form-data">
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
                                        <label>Upload Foto (Multiple & Drag & Drop)</label>

                                        <div class="dropzone" id="photo-dropzone"></div>

                                        <small class="text-muted">Format: JPG, PNG, GIF — Max 5MB per file.</small>
                                    </div>

                                    {{-- Buttons --}}
                                    <div class="col-12 d-flex justify-content-end mt-3">
                                        <button type="submit" class="btn btn-primary me-1 mb-1">Upload Photo</button>
                                        <a href="{{ route('manage.photo.index') }}"
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

        var dz = new Dropzone("#photo-dropzone", {
            url: "#",
            autoProcessQueue: false,
            uploadMultiple: true,
            parallelUploads: 20,
            maxFiles: 20,
            maxFilesize: 5,
            acceptedFiles: ".jpeg,.jpg,.png,.gif,.svg",
            addRemoveLinks: true,
            dictDefaultMessage: "Seret & jatuhkan foto di sini atau klik untuk memilih",
            dictRemoveFile: "Hapus",
        });

        document.getElementById('create-photo-form').addEventListener('submit', function(e) {
            e.preventDefault();

            let form = this;

            dz.getAcceptedFiles().forEach(file => {

                let dataTransfer = new DataTransfer();
                dataTransfer.items.add(file);

                let input = document.createElement('input');
                input.type = 'file';
                input.name = 'photo_file[]';
                input.files = dataTransfer.files;

                form.appendChild(input);
            });

            if (dz.getAcceptedFiles().length === 0) {
                alert('Silakan pilih minimal 1 foto');
                return;
            }

            form.submit();
        });
    </script>
@endpush
