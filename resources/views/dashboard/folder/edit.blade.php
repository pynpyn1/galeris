@extends('dashboard.layouts.app')
@section('title', 'Edit Folder')
@section('name_header', 'Edit Folder')
@section('breadcrumbs')
    <?php
    $breadcrumbs = [['name' => 'Folder Manage', 'link' => route('manage.folder.index')]];
    ?>
@endsection

@section('content')
    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif
    @if ($errors->any())
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <strong>Gagal Menyimpan!</strong> Silakan periksa kembali input Anda.
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    @if ($folder->trashed())
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
                        <h4 class="card-title">{{ $folder->name }}</h4>
                    </div>
                    <div class="card-content">
                        <div class="card-body">
                            <form class="form" id="edit-folder-form" method="POST"
                                action="{{ route('manage.folder.update', $folder->id) }}">
                                @csrf
                                @method('PUT')
                                <input type="hidden" name="user_id" value="{{ $folder->user_id }}">
                                <div class="row">

                                    <div class="col-md-6 col-12">
                                        <div class="form-group">
                                            <label for="client-id-column">Client Name</label>
                                            <select name="client_id" id="client-id-column"
                                                class="form-control @error('client_id') is-invalid @enderror" required
                                                disabled {{ $folder->trashed() ? 'disabled' : '' }}>

                                                <option value="" disabled>Pilih Client</option>
                                                @foreach ($clients as $client)
                                                    <option value="{{ $client->id }}"
                                                        data-name-engaged="{{ $client->name_engaged }}"
                                                        {{ old('client_id', $folder->client_id) == $client->id ? 'selected' : '' }}>
                                                        {{ $client->name_engaged }} ({{ $client->email }})
                                                    </option>
                                                @endforeach
                                            </select>
                                            @if ($folder->trashed())
                                                <input type="hidden" name="client_id" value="{{ $folder->client_id }}">
                                            @endif
                                            @error('client_id')
                                                <div class="invalid-feedback"> {{ $message }} </div>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-md-6 col-12">
                                        <div class="form-group">
                                            <label for="status-column">Visibility</label>
                                            <select name="visibility" id="status-column"
                                                class="form-control @error('visibility') is-invalid @enderror" required
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
                                                <div class="invalid-feedback"> {{ $message }} </div>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-12">
                                        <div class="form-group">
                                            <label for="folder-name-column">Folder Name</label>
                                            <input type="text" id="folder-name-column"
                                                class="form-control @error('name') is-invalid @enderror"
                                                placeholder="Nama Client akan diisi otomatis" name="name"
                                                value="{{ old('name', $folder->name) }}"
                                                {{ $folder->trashed() ? 'disabled' : '' }}>

                                            @if ($folder->trashed())
                                                <input type="hidden" name="name" value="{{ $folder->name }}">
                                            @endif
                                            @error('name')
                                                <div class="invalid-feedback"> {{ $message }} </div>
                                            @enderror
                                        </div>
                                    </div>


                                    <div class="col-12 d-flex justify-content-end">
                                        @if ($folder->trashed())
                                            <button type="submit" class="btn btn-success me-1 mb-1">Restore Folder</button>
                                        @else
                                            <button type="submit" class="btn btn-primary me-1 mb-1">Update Folder</button>
                                        @endif

                                        <a href="{{ route('manage.folder.index') }}"
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
