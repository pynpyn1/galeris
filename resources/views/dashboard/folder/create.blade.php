@extends('dashboard.layouts.app')

@section('title', 'Add Folder')
@section('name_header', 'Add Folder')

@section('breadcrumbs')
    <?php
    $breadcrumbs = [['name' => 'Folder Manage', 'link' => route('manage.folder.index')]];
    ?>
@endsection

@section('content')

    <section id="multiple-column-form">
        <div class="row match-height">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">Create New Folder</h4>
                    </div>
                    <div class="card-content">
                        <div class="card-body">
                            <form class="form" id="create-folder-form" method="POST"
                                action="{{ route('manage.folder.store') }}">
                                @csrf

                                <div class="row">

                                    <div class="col-md-6 col-12">
                                        <div class="form-group">
                                            <label for="client-id-column">Client Name</label>
                                            <select name="client_id" id="client-id-column"
                                                class="form-control @error('client_id') is-invalid @enderror" required>
                                                {{-- Pastikan placeholder dinonaktifkan jika ada old value --}}
                                                <option value="" disabled {{ !old('client_id') ? 'selected' : '' }}>
                                                    Pilih Client</option>
                                                @foreach ($clients as $client)
                                                    <option value="{{ $client->id }}"
                                                        data-name-engaged="{{ $client->name }}"
                                                        {{ old('client_id') == $client->id ? 'selected' : '' }}>
                                                        {{ $client->name }} ({{ $client->email }})
                                                    </option>
                                                @endforeach
                                            </select>
                                            @error('client_id')
                                                <div class="invalid-feedback">
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-md-6 col-12">
                                        <div class="form-group">
                                            <label for="status-column">Status</label>
                                            <select name="visibility" id="status-column"
                                                class="form-control @error('visibility') is-invalid @enderror" required>
                                                <option value="private"
                                                    {{ old('visibility', 'private') == 'private' ? 'selected' : '' }}>
                                                    Private
                                                </option>
                                                <option value="public"
                                                    {{ old('visibility') == 'public' ? 'selected' : '' }}>
                                                    Public
                                                </option>
                                            </select>
                                            @error('visibility')
                                                <div class="invalid-feedback">
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-12">
                                        <div class="form-group">
                                            <label for="folder-name-column">Folder Name</label>
                                            <input type="text" id="folder-name-column"
                                                class="form-control @error('name') is-invalid @enderror"
                                                placeholder="Nama Client akan diisi otomatis" name="name"
                                                value="{{ old('name') }}"> {{-- 🚨 'readonly' dihapus --}}
                                            @error('name')
                                                <div class="invalid-feedback">
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                        </div>
                                    </div>


                                    <div class="col-12 d-flex justify-content-end">
                                        <button type="submit" class="btn btn-primary me-1 mb-1">Save Folder</button>
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

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const clientIdDropdown = document.getElementById('client-id-column');
            const folderNameInput = document.getElementById('folder-name-column');

            const defaultSuffix = ' - Wedding Folder';

            function updateFolderName(isInitialLoad = false) {
                const selectedOption = clientIdDropdown.options[clientIdDropdown.selectedIndex];
                const nameEngaged = selectedOption.getAttribute('data-name-engaged');

                if (selectedOption.value) {
                    let newFolderName = '';

                    if (nameEngaged) {
                        newFolderName = nameEngaged + defaultSuffix;
                    }

                    if (isInitialLoad && folderNameInput.value) {
                        return;
                    }
                    folderNameInput.value = newFolderName;

                } else if (!isInitialLoad) {
                    folderNameInput.value = '';
                }
            }

            if (clientIdDropdown.value) {
                updateFolderName(true);
            }

            clientIdDropdown.addEventListener('change', function() {
                updateFolderName(false);
            });
        });
    </script>
@endpush
