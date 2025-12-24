@extends('dashboard.layouts.app')

@section('title', 'Edit Video')
@section('name_header', 'Edit Video')

@section('breadcrumbs')
    <?php
    // Mengubah breadcrumbs dari Photo Manage ke Video Manage
    $breadcrumbs = [['name' => 'Video Manage', 'link' => route('manage.video.index')]];
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

    <section id="video-table">
        <div class="card">

            <div class="card-header d-flex justify-content-between align-items-center">
                <h4 class="card-title">{{ $folder->name }}</h4>

                {{-- Mengubah route kembali ke index video --}}
                <a href="{{ route('manage.video.index') }}" class="btn btn-secondary">
                    Back
                </a>
            </div>

            <div class="card-body">


                <div class="mb-3">
                    <input type="text" class="form-control" value="{{ $folder->name }}" disabled>
                </div>

                {{-- GRID VIDEO --}}
                <div class="row g-3">

                    {{-- Mengubah variabel looping dari $photos menjadi $videos --}}
                    @forelse ($videos as $video)
                        <div class="col-md-3 col-sm-4 col-6">

                            <div class="border rounded p-2 position-relative shadow-sm">

                                {{-- TOMBOL DELETE --}}
                                {{-- Mengubah route ke manage.video.destroy --}}
                                <form class="delete-video-form" action="{{ route('manage.video.destroy', $video->id) }}"
                                    method="POST">
                                    @csrf
                                    @method('DELETE')

                                    <button type="button"
                                        class="btn btn-sm btn-danger btn-delete-video position-absolute top-0 end-0 m-1">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </form>


                                {{-- PREVIEW VIDEO --}}
                                <video controls preload="metadata" muted src="{{ asset('storage/' . $video->file_path) }}"
                                    class="img-fluid rounded" style="height: 170px; width:100%; object-fit: cover;">
                                    <source src="{{ asset('storage/' . $video->file_path) }}"
                                        type="{{ $video->mime_type }}">
                                    Browser Anda tidak mendukung tag video.
                                </video>

                                <p class="mt-2 mb-0 small text-muted text-center">
                                    {{ $video->file_name }}
                                </p>

                                {{-- Tambahan info ukuran --}}
                                @if (isset($video->size))
                                    <p class="mb-0 small text-primary text-center">
                                        Size: {{ number_format($video->size / 1024 / 1024, 2) }} MB
                                    </p>
                                @endif

                            </div>

                        </div>
                    @empty

                        <div class="col-12 text-center py-5">
                            <h5 class="text-muted">Tidak ada video untuk ditampilkan.</h5>
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
            // Mengubah selector dari '.btn-delete-photo' menjadi '.btn-delete-video'
            document.querySelectorAll('.btn-delete-video').forEach(button => {
                button.addEventListener('click', function(e) {
                    const form = this.closest('.delete-video-form');

                    Swal.fire({
                        // Mengubah teks notifikasi
                        title: "Yakin hapus video ini?",
                        text: "Data yang sudah terhapus tidak bisa dikembalikan!",
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
