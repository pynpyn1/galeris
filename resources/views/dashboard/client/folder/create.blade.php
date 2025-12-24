@extends('dashboard.layouts.app')

@section('title', 'Add Folder')
@section('name_header', 'Add Folder')

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
                            <form class="form" method="POST" action="{{ route('folder.client.store') }}">
                                @csrf
                                <div class="row">

                                    {{-- Folder Name (Auto) --}}
                                    <div class="col-12">
                                        <div class="form-group">
                                            <label for="folder-name">Folder Name</label>
                                            <input type="text" id="folder-name" name="name" class="form-control"
                                                value="{{ $folderName }}">
                                        </div>
                                    </div>

                                    {{-- Visibility --}}
                                    <div class="col-12">
                                        <div class="form-group">
                                            <label for="visibility">Visibility</label>
                                            <select name="visibility" id="visibility"
                                                class="form-control @error('visibility') is-invalid @enderror" required>

                                                <option value="private">Private</option>
                                                <option value="public">Public</option>
                                            </select>
                                            @error('visibility')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>

                                    {{-- Date Event --}}
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="date_event">Event Date</label>
                                            <input type="text" id="date_event" name="date_event" class="form-control"
                                                autocomplete="off">
                                        </div>
                                    </div>


                                    <div class="col-md-12 col-12 mt-2">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" name="send_wa" value="1"
                                                id="send_wa">

                                            <label class="form-check-label" for="send_wa">
                                                Kirim QR Ke Whatsapp
                                            </label>
                                        </div>
                                    </div>

                                    {{-- Submit --}}
                                    <div class="col-12 d-flex justify-content-end">
                                        <button type="submit" class="btn btn-primary me-1 mb-1">Save</button>
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

@push('styles')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />
@endpush


@push('scripts')
    {{-- Daterangepicker JS --}}
    <script src="https://cdn.jsdelivr.net/npm/moment@2.29.4/moment.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>

    <script>
        $(function() {
            $('#date_event').daterangepicker({
                autoApply: true,
                locale: {
                    format: 'DD MMM YYYY'
                }
            });
        });
    </script>
@endpush
