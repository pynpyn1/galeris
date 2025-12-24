@extends('dashboard.layouts.app')

@section('title', 'Generate QR')
@section('name_header', 'Generate QR')

@section('breadcrumbs')
    <?php
    $breadcrumbs = [['name' => 'URL Manage', 'link' => route('qrcode.index')]];
    ?>
@endsection

@section('content')

    <section id="multiple-column-form">
        <div class="row match-height">
            <div class="col-12">
                <div class="card">

                    <div class="card-header">
                        <h4 class="card-title">Generate New URL</h4>
                    </div>

                    <div class="card-content">
                        <div class="card-body">

                            <form class="form" method="POST" action="{{ route('qrcode.store') }}">
                                @csrf

                                <div class="row">

                                    <div class="col-md-12 col-12">
                                        <div class="form-group">
                                            <label for="folder_id">Select Folder</label>
                                            <select name="folder_id"
                                                class="form-control @error('folder_id') is-invalid @enderror" required>
                                                <option value="" disabled selected>Pilih Folder</option>

                                                @foreach ($folders as $folder)
                                                    <option value="{{ $folder->id }}"
                                                        {{ old('folder_id') == $folder->id ? 'selected' : '' }}>
                                                        {{ $folder->name }}
                                                    </option>
                                                @endforeach
                                            </select>

                                            @error('folder_id')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-md-12 col-12 mt-2">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" name="send_wa" value="1"
                                                id="send_wa">

                                            <label class="form-check-label" for="send_wa">
                                                Kirim QR
                                            </label>
                                        </div>
                                    </div>


                                    <div class="col-12 d-flex justify-content-end">
                                        <button type="submit" class="btn btn-primary me-1 mb-1">Generate QR Code</button>
                                        <a href="{{ route('qrcode.index') }}"
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
