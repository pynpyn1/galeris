@extends('dashboard.layouts.app')

@section('title', 'Kelola Foto')
@section('name_header', 'Kelola Foto')

@section('breadcrumbs')
    <?php
    $breadcrumbs = [['name' => 'Photo Client', 'link' => route('photo.index')]];
    ?>
@endsection

@section('content')

    {{-- SUCCESS --}}
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

    <section id="photo-table">
        <div class="card">

            <div class="card-header d-flex justify-content-between align-items-center">
                <h4 class="card-title">Kelola Foto</h4>

                <a href="{{ route('photo.index') }}" class="btn btn-secondary">
                    Kembali
                </a>
            </div>

            <div class="card-body">

                {{-- Nama Folder --}}
                <div class="mb-3">
                    <input type="text" class="form-control" value="{{ $folder->name }}" disabled>
                </div>

                {{-- GRID FOTO --}}
                <div class="row g-3">

                    @forelse ($photos as $photo)
                        <div class="col-md-3 col-sm-4 col-6">

                            <div class="border rounded p-2 position-relative shadow-sm">

                                {{-- Tombol Hapus --}}
                                <form class="delete-photo-form" action="{{ route('photo.destroy', $photo->id) }}"
                                    method="POST">
                                    @csrf
                                    @method('DELETE')

                                    <button type="button"
                                        class="btn btn-sm btn-danger btn-delete-photo position-absolute top-0 end-0 m-1">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </form>

                                {{-- Preview Foto --}}
                                <img src="{{ asset('storage/' . $photo->file_path) }}" class="img-fluid rounded"
                                    style="height: 170px; width:100%; object-fit: cover;">

                                <p class="mt-2 mb-0 small text-muted text-center">
                                    {{ $photo->file_name ?? 'Photo' }}
                                </p>

                            </div>

                        </div>
                    @empty

                        <div class="col-12 text-center py-5">
                            <h5 class="text-muted">Tidak ada foto untuk ditampilkan.</h5>
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
            document.querySelectorAll('.btn-delete-photo').forEach(button => {
                button.addEventListener('click', function(e) {
                    const form = this.closest('.delete-photo-form');

                    Swal.fire({
                        title: "Yakin hapus foto ini?",
                        text: "Data yang sudah terhapus tidak dapat dikembalikan!",
                        icon: "warning",
                        showCancelButton: true,
                        confirmButtonColor: "#d33",
                        cancelButtonColor: "#3085d6",
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
