@extends('dashboard.layouts.app')

@section('title', 'Edit QR Template')
@section('name_header', 'Edit QR Template')

@section('breadcrumbs')
    <?php
    $breadcrumbs = [['name' => 'QR Template Manage', 'link' => route('manage.qr_template.index')]];
    ?>
@endsection

@section('content')


    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show">
            {{ session('success') }}
            <button class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    {{-- ERROR --}}
    @if (session('error'))
        <div class="alert alert-danger alert-dismissible fade show">
            {{ session('error') }}
            <button class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <section id="qr-template-edit">
        <div class="card">

            <div class="card-header d-flex justify-content-between align-items-center">
                <h4 class="card-title">Manage QR Template</h4>
                <a href="{{ route('manage.qr_template.index') }}" class="btn btn-outline-primary">
                    Back
                </a>
            </div>

            <div class="card-body">

                <form action="{{ route('manage.qr_template.update', $template->id) }}" method="POST"
                    enctype="multipart/form-data" class="mb-4">

                    @csrf
                    @method('PUT')

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label>Template Name</label>
                            <input type="text" name="name_template" value="{{ $template->name_template }}"
                                class="form-control" required>
                        </div>

                        <div class="col-md-6">
                            <label>Status</label>
                            <select name="is_active" class="form-control" required>
                                <option value="1" {{ $template->is_active ? 'selected' : '' }}>Active</option>
                                <option value="0" {{ !$template->is_active ? 'selected' : '' }}>Inactive</option>
                            </select>
                        </div>
                    </div>

                    {{-- UPLOAD TAMBAHAN --}}
                    <div class="mb-3">
                        <label>Upload Tambahan QR Template</label>
                        <input type="file" name="templates[]" class="form-control" multiple
                            accept=".png,.jpg,.jpeg,.svg">
                        <small class="text-muted">
                            Bisa upload file tambahan (PNG / JPG / SVG)
                        </small>
                    </div>

                    <div class="text-end">
                        <button class="btn btn-primary">
                            Update Template
                        </button>
                    </div>
                </form>

                <hr>

                {{-- GRID FILE QR --}}
                <div class="row g-3">

                    @forelse ($files as $file)
                        <div class="col-md-3 col-sm-4 col-6">

                            <div class="border rounded p-2 position-relative shadow-sm">

                                {{-- DELETE FILE --}}
                                <form class="delete-qr-file-form"
                                    action="{{ route('manage.qr_template.destroy.file', $file->id) }}" method="POST">
                                    @csrf
                                    @method('DELETE')

                                    <button type="button"
                                        class="btn btn-sm btn-danger btn-delete-qr-file position-absolute top-0 end-0 m-1">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </form>

                                {{-- PREVIEW --}}
                                <img src="{{ asset('storage/' . $file->path_template) }}" class="img-fluid rounded"
                                    style="height:170px;width:100%;object-fit:contain;background:#f8f9fa;">

                                <p class="mt-2 mb-0 small text-muted text-center">
                                    {{ basename($file->path_template) }}
                                </p>

                            </div>

                        </div>
                    @empty

                        <div class="col-12 text-center py-5">
                            <h5 class="text-muted">Belum ada file QR Template.</h5>
                        </div>
                    @endforelse

                </div>

            </div>

        </div>
    </section>

@endsection

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {

            document.querySelectorAll('.btn-delete-qr-file').forEach(button => {
                button.addEventListener('click', function() {
                    const form = this.closest('.delete-qr-file-form');

                    Swal.fire({
                        title: "Yakin hapus file ini?",
                        text: "File QR tidak bisa dikembalikan!",
                        icon: "warning",
                        showCancelButton: true,
                        confirmButtonColor: "#d33",
                        cancelButtonColor: "#6c757d",
                        confirmButtonText: "Ya, hapus!",
                        cancelButtonText: "Batal"
                    }).then((result) => {
                        if (result.isConfirmed) {
                            form.submit();
                        }
                    });
                });
            });

        });
    </script>
@endpush
