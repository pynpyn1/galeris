@extends('dashboard.layouts.app-event')

@section('title', 'Kelola Video')

@section('content')
    @if ($storagePercent >= 97)
        <div class="row justify-content-center mb-4">
            <div class="col-md-8">
                <div class="card border-danger shadow-sm">
                    <div class="card-body d-flex align-items-center gap-3">
                        <div class="flex-grow-1">
                            <h6 class="mb-1 fw-bold text-danger">
                                Penyimpanan Penuh
                            </h6>
                            <small class="text-muted">
                                Kapasitas penyimpanan Anda telah habis
                                ({{ round($usedStorage / 1024 / 1024, 2) }} MB /
                                {{ round($storageLimit / 1024 / 1024, 0) }} MB).
                            </small>

                            <div class="progress mt-2" style="height: 8px;">
                                <div class="progress-bar bg-danger progress-bar-striped progress-bar-animated"
                                    role="progressbar" style="width: 100%">
                                </div>
                            </div>

                            <div class="mt-3">
                                <small class="text-danger fw-semibold">
                                    Hapus beberapa video untuk dapat mengunggah video baru.
                                </small>
                            </div>
                        </div>


                    </div>
                </div>
            </div>
        </div>
    @elseif ($storagePercent >= 80)
        <div class="row justify-content-center mb-4">
            <div class="col-md-8">
                <div class="card border-warning shadow-sm">
                    <div class="card-body d-flex align-items-center gap-3">
                        <div class="flex-grow-1">
                            <h6 class="mb-1 fw-bold">
                                Penyimpanan Hampir Penuh
                            </h6>
                            <small class="text-muted">
                                Anda telah menggunakan
                                <strong>{{ $storagePercent }}%</strong>
                                dari total kapasitas
                                ({{ round($usedStorage / 1024 / 1024, 2) }} MB /
                                {{ round($storageLimit / 1024 / 1024, 0) }} MB).
                            </small>

                            <div class="progress mt-2" style="height: 8px;">
                                <div class="progress-bar rounded-pill progress-bar-striped progress-bar-animated bg-warning"
                                    role="progressbar" style="width: {{ $storagePercent }}%">
                                </div>
                            </div>
                            <div class="d-block">
                                <p>Segera tingkatkan langganan anda untuk mendapatkan extra storage dan fitur lainnya!</p>
                                <a href="{{ route('home.subscribe') }}" class="btn btn-outline-primary ">Tingkatkan
                                    Langganan</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif


    <div class="row justify-content-center">
        <div class="col-md-8">

            <div class="card shadow-sm mb-4 border-0">
                <div class="card-header bg-white py-3 border-bottom-0">
                    <h5 class="m-0 fw-bold">
                        Upload Video Baru
                    </h5>
                </div>

                <div class="card-body">
                    <form id="my-dropzone-form" action="{{ route('home.video.store', $event->public_code) }}" method="POST"
                        enctype="multipart/form-data">
                        @csrf

                        <div class="dropzone-container">
                            <div class="dropzone modern-dropzone" id="myDropzone">
                                <div class="dz-message needsclick">
                                    <div class="mb-3">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="64" height="64"
                                            viewBox="0 0 24 24" fill="none" stroke="#cbd5e1" stroke-width="1.5"
                                            stroke-linecap="round" stroke-linejoin="round">
                                            <path
                                                d="M17.5 19c0-1.7-1.3-3-3-3h-1.1c-.1-2.6-2.2-4.6-4.8-4.5-2.2 0-4.1 1.6-4.5 3.7C2 15.6 2 18.6 4.5 19h13z" />
                                            <polyline points="9 11 12 8 15 11" />
                                            <line x1="12" y1="8" x2="12" y2="16" />
                                        </svg>
                                    </div>
                                    <h5 class="text-dark fw-bold">Klik atau Drop Video Disini</h5>
                                    <span class="text-muted small">Maksimal 1GiB per file (MKV, MP4)</span>
                                </div>
                            </div>
                        </div>

                        <div class="d-flex justify-content-end mt-3">
                            <button type="submit" id="submit-all" class="btn btn-primary px-4 py-2"
                                {{ $storagePercent >= 98 ? 'disabled' : '' }}>
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24"
                                    fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                    stroke-linejoin="round" class="me-2">
                                    <path d="M19 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11l5 5v11a2 2 0 0 1-2 2z" />
                                    <polyline points="17 21 17 13 7 13 7 21" />
                                    <polyline points="7 3 7 8 15 8" />
                                </svg>
                                Simpan Video
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <div class="card shadow-sm border-0">
                <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
                    <h5 class="m-0 fw-bold">Kelola Video</h5>



                    <div class="d-flex align-items-center gap-2 ">
                        <form method="POST" action="{{ route('home.video.destroyAll', $event->public_code) }}"
                            id="delete-all-form">
                            @csrf
                            @method('DELETE')

                            <button type="button" class="btn btn-sm btn-danger"
                                {{ $videos->total() === 0 ? 'disabled' : '' }} onclick="deleteAllConfirm()">
                                Hapus Semua
                            </button>
                        </form>
                        <form method="GET" id="sort-form">
                            <select name="sort" id="sort-select" class="form-select form-select-sm"
                                style="width: 200px;">
                                <option value="latest" {{ $sort === 'latest' ? 'selected' : '' }}>
                                    Terbaru
                                </option>
                                <option value="oldest" {{ $sort === 'oldest' ? 'selected' : '' }}>
                                    Terlama
                                </option>
                                <option value="date" {{ $sort === 'date' ? 'selected' : '' }}>
                                    Berdasarkan Tanggal
                                </option>
                                <option value="time" {{ $sort === 'time' ? 'selected' : '' }}>
                                    Berdasarkan Waktu
                                </option>
                            </select>
                        </form>

                        <span class="badge bg-primary p-2 text-light border">
                            {{ $videos->total() }} Video
                        </span>
                    </div>
                </div>



                <div class="card-body bg-light">
                    <div class="row g-3">
                        @forelse ($videos as $video)
                            <div class="col-6 col-md-3 py-4">
                                <div class="card h-100 shadow-sm border-0 overflow-hidden">
                                    <div style="height:180px;" class="position-relative bg-white">
                                        <video class="w-100 h-100" style="object-fit: cover;" controls
                                            preload="metadata">
                                            <source src="{{ asset('storage/' . $video->file_path) }}"
                                                type="{{ $video->mime_type }}">
                                            Browser Anda tidak mendukung video.
                                        </video>
                                    </div>
                                    <div class="card-footer bg-white p-2 border-top-0">
                                        <form
                                            action="{{ route('home.video.destroy', [$event->public_code, $video->id]) }}"
                                            method="POST"class="delete-video-form">
                                            @csrf
                                            @method('DELETE')
                                            <button type="button" onclick="deletevideoConfirm(this)"
                                                class="btn btn-sm btn-outline-danger w-100 d-flex align-items-center justify-content-center">
                                                Hapus
                                            </button>

                                        </form>
                                    </div>
                                </div>
                            </div>
                        @empty
                            <div class="col-12 py-5 text-center">
                                <p class="text-muted">Belum ada video.</p>
                            </div>
                        @endforelse

                    </div>

                </div>
                <div class="d-flex justify-content-between align-items-center mt-3 px-4">
                    <small class="text-muted py-3">
                        Halaman {{ $videos->currentPage() }} dari {{ $videos->lastPage() }}
                    </small>

                    <div class="pagination-wrapper">
                        {{ $videos->links('vendor.pagination.simple-window') }}

                    </div>
                </div>


            </div>

        </div>
    </div>

@endsection

@push('styles')
    <link rel="stylesheet" href="https://unpkg.com/dropzone@5/dist/min/dropzone.min.css" type="text/css" />
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />

    <style>
        .pagination {
            gap: 8px;
            align-items: center;
        }

        .page-item .page-link {
            border: none;
            border-radius: 12px;
            padding: 10px 18px;
            color: #64748b;
            background-color: #ffffff;
            font-weight: 600;
            font-size: 0.9rem;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.04);
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            position: relative;
        }

        .page-item:not(.active):not(.disabled) .page-link:hover {
            color: #435ebf;
            background-color: #ffffff;
            transform: translateY(-3px);
            box-shadow: 0 8px 15px rgba(67, 94, 191, 0.1);
        }

        .page-item.active .page-link {
            background: #435ebf;
            color: #ffffff;
            box-shadow: 0 4px 12px rgba(67, 94, 191, 0.35);
            /* Glow effect */
            transform: scale(1.05);
        }

        .page-item.disabled .page-link {
            color: #cbd5e1;
            background-color: #f8fafc;
            box-shadow: none;
            cursor: not-allowed;
            opacity: 0.7;
        }

        @media (max-width: 576px) {
            .page-item .page-link {
                padding: 8px 12px;
                font-size: 0.8rem;
            }
        }


        .gallery-thumb {
            object-fit: cover;
            image-rendering: -webkit-optimize-contrast;
            filter: saturate(0.95) contrast(0.95);
            transition: transform 0.3s ease, filter 0.3s ease;
            will-change: transform;
        }

        .gallery-thumb:hover {
            transform: scale(1.05);
            filter: none;
        }

        .select2-container--default .select2-selection--single {
            height: 38px;
            padding: 5px 10px;
            border-radius: 6px;
            border: 1px solid #ced4da;
        }

        .select2-selection__rendered {
            line-height: 26px !important;
        }

        .select2-selection__arrow {
            height: 36px !important;
        }

        .modern-dropzone {
            border: 2px dashed #cbd5e1;
            border-radius: 10px;
            background: #f8fafc;
            min-height: 220px;
            padding: 20px;
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
            align-items: center;
            align-content: center;
            gap: 15px;

            transition: all 0.3s ease;
            position: relative;
        }

        .modern-dropzone:hover {
            border-color: #3b82f6;
            background: #eff6ff;
        }

        .modern-dropzone .dz-message {
            width: 100%;
            text-align: center;
            margin: 2em 0;
        }

        /* Styling Preview Dropzone */
        .dropzone .dz-preview {
            background: transparent;
            margin: 0 !important;
        }

        .dropzone .dz-preview .dz-image {
            width: 120px;
            height: 120px;
            border-radius: 8px;
            overflow: hidden;
        }

        .dropzone .dz-preview .dz-image img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .dropzone .dz-preview .dz-remove {
            margin-top: 8px;
            color: #dc3545;
            text-decoration: none;
            font-weight: 600;
            font-size: 0.85rem;
            display: block;
            text-align: center;
            cursor: pointer;
            border: 1px solid #dc3545;
            border-radius: 4px;
            padding: 2px 5px;
            background: white;
        }

        .dropzone .dz-preview .dz-remove:hover {
            background: #dc3545;
            color: white;
            text-decoration: none;
        }
    </style>
@endpush

@push('scripts')
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://unpkg.com/dropzone@5/dist/min/dropzone.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script>
        @if (session('success'))
            showToast(@json(session('success')), 'success');
        @endif

        @if (session('error'))
            showToast(@json(session('error')), 'error');
        @endif

        @if (session('warning'))
            showToast(@json(session('warning')), 'warning');
        @endif
    </script>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            $('#sort-select').select2({
                minimumResultsForSearch: Infinity,
                width: 'resolve'
            });

            $('#sort-select').on('change', function() {
                document.getElementById('sort-form').submit();
            });
        });

        Dropzone.autoDiscover = false;

        document.addEventListener("DOMContentLoaded", function() {

            const myDropzone = new Dropzone("#myDropzone", {
                url: "#",
                autoProcessQueue: false,
                uploadMultiple: true,
                addRemoveLinks: true,
                parallelUploads: 50,
                maxFiles: 5,
                acceptedFiles: ".mkv,.mp4",
                dictRemoveFile: "Batal",
            });

            const form = document.getElementById('my-dropzone-form');

            form.addEventListener('submit', function(e) {
                e.preventDefault();

                if (myDropzone.getAcceptedFiles().length === 0) {
                    Swal.fire({
                        title: 'Peringatan',
                        text: 'Minimal 1 Video!',
                        icon: 'warning',
                        showCancelButton: true,
                        showConfirmButton: false,
                        cancelButtonText: 'Batal',
                        reverseButtons: true,
                        confirmButtonColor: '#435ebf',
                    });
                    return;
                }

                const files = myDropzone.getAcceptedFiles();

                const dataTransfer = new DataTransfer();

                files.forEach(file => {
                    dataTransfer.items.add(file);
                });

                const fileInput = document.createElement("input");
                fileInput.type = "file";
                fileInput.name = "videos[]";
                fileInput.multiple = true;
                fileInput.style.display = "none";
                fileInput.files = dataTransfer.files;
                form.appendChild(fileInput);
                form.submit();
            });
        });
    </script>
    <script>
        function deleteAllConfirm() {
            Swal.fire({
                title: 'Hapus semua video?',
                text: 'Semua video dalam folder ini akan dihapus permanen!',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Ya, Hapus Semua',
                cancelButtonText: 'Batal',
                reverseButtons: true,
                confirmButtonColor: '#dc3545',
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById('delete-all-form').submit();
                }
            });
        }

        function deletevideoConfirm(button) {
            Swal.fire({
                title: 'Hapus video?',
                text: 'Video ini akan dihapus permanen.',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Ya, Hapus',
                cancelButtonText: 'Batal',
                reverseButtons: true,
                confirmButtonColor: '#dc3545',
            }).then((result) => {
                if (result.isConfirmed) {
                    button.closest('form').submit();
                }
            });
        }
    </script>
@endpush
