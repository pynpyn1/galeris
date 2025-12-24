@extends('dashboard.layouts.app')

@section('title', 'Edit Folder')
@section('name_header', 'Edit Folder')

@section('content')

    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show">
            {{ session('success') }}
            <button class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    @if ($errors->any())
        <div class="alert alert-danger alert-dismissible fade show">
            <strong>Gagal!</strong> Periksa kembali input Anda.
            <button class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    @if ($folder->trashed())
        <div class="alert alert-warning">
            Folder ini sudah dihapus. Tekan “Restore” untuk mengaktifkan kembali.
        </div>
    @endif

    <section id="multiple-column-form">
        <div class="row match-height">
            <div class="col-12">

                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">{{ $folder->name }}</h4>
                    </div>

                    <div class="card-content">
                        <div class="card-body">

                            <form class="form" method="POST" action="{{ route('folder.client.update', $folder->id) }}">
                                @csrf
                                @method('PUT')

                                <div class="row">

                                    {{-- Folder Name --}}
                                    <div class="col-12">
                                        <div class="form-group">
                                            <label for="folder-name">Folder Name</label>

                                            <input type="text" id="folder-name"
                                                class="form-control @error('name') is-invalid @enderror" name="name"
                                                value="{{ old('name', $folder->name) }}"
                                                {{ $folder->trashed() ? 'disabled' : '' }}>

                                            @if ($folder->trashed())
                                                <input type="hidden" name="name" value="{{ $folder->name }}">
                                            @endif

                                            @error('name')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>

                                    {{-- Visibility --}}
                                    <div class="col-12">
                                        <div class="form-group">
                                            <label for="visibility">Visibility</label>

                                            <select name="visibility" id="visibility"
                                                class="form-control @error('visibility') is-invalid @enderror"
                                                {{ $folder->trashed() ? 'disabled' : '' }}>

                                                <option value="private"
                                                    {{ old('visibility', $folder->visibility) == 'private' ? 'selected' : '' }}>
                                                    Private
                                                </option>

                                                <option value="public"
                                                    {{ old('visibility', $folder->visibility) == 'public' ? 'selected' : '' }}>
                                                    Public
                                                </option>

                                            </select>

                                            @if ($folder->trashed())
                                                <input type="hidden" name="visibility" value="{{ $folder->visibility }}">
                                            @endif

                                            @error('visibility')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-12 d-flex justify-content-end">
                                        @if ($folder->trashed())
                                            <button type="submit" class="btn btn-success me-1 mb-1">Restore Folder</button>
                                        @else
                                            <button type="submit" class="btn btn-primary me-1 mb-1">Update Folder</button>
                                        @endif

                                        <a href="{{ route('folder.client.index') }}"
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
