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

                    {{-- UPDATED BUTTON STRUCTURE FOR SPINNER --}}
                    <div class="d-flex justify-content-end mt-3">
                        <button type="submit" id="submit-all" class="btn btn-primary px-4 py-2"
                            {{ $storagePercent >= 98 ? 'disabled' : '' }}>
                            <span id="submit-text">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                    viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                    stroke-linecap="round" stroke-linejoin="round" class="me-2">
                                    <path d="M19 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11l5 5v11a2 2 0 0 1-2 2z" />
                                    <polyline points="17 21 17 13 7 13 7 21" />
                                    <polyline points="7 3 7 8 15 8" />
                                </svg>
                                Simpan Video
                            </span>
                            <span id="submit-loading" class="d-none">
                                <span class="spinner-border spinner-border-sm me-2"></span>
                                Mengupload...
                            </span>
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <div class="card shadow-sm border-0 rounded-4">
            <div class="card-header bg-white py-3 px-3 px-md-4 border-bottom-0">
                <div class="row align-items-center g-3">
                    <div class="col-12 col-md-auto me-md-auto">
                        <div class="d-flex align-items-center gap-2">
                            <h5 class="m-0 fw-bold text-dark">Kelola Video</h5>
                            <span
                                class="badge bg-primary-subtle text-primary border border-primary-subtle rounded-pill px-3">
                                {{ $videos->total() }} Video
                            </span>
                        </div>
                    </div>

                    <div class="col-12 col-md-auto">
                        <div class="row g-2">
                            <div class="col-7 col-md-auto">
                                <form method="GET" id="sort-form">
                                    <select name="sort" id="sort-select"
                                        class="form-select form-select-sm bg-light border-0 fw-bold text-secondary"
                                        style="height: 38px; min-width: 140px;">
                                        <option value="latest" {{ $sort === 'latest' ? 'selected' : '' }}>Terbaru
                                        </option>
                                        <option value="oldest" {{ $sort === 'oldest' ? 'selected' : '' }}>Terlama
                                        </option>
                                        <option value="date" {{ $sort === 'date' ? 'selected' : '' }}>By Tanggal
                                        </option>
                                        <option value="time" {{ $sort === 'time' ? 'selected' : '' }}>By Waktu
                                        </option>
                                    </select>
                                </form>
                            </div>

                            <div class="col-5 col-md-auto">
                                <form method="POST" action="{{ route('home.video.destroyAll', $event->public_code) }}"
                                    id="delete-all-form">
                                    @csrf
                                    @method('DELETE')
                                    <button type="button"
                                        class="btn btn-danger btn-sm w-100 d-flex align-items-center justify-content-center gap-2"
                                        style="height: 38px;" {{ $videos->total() === 0 ? 'disabled' : '' }}
                                        onclick="deleteAllConfirm()">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                            viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                            stroke-linecap="round" stroke-linejoin="round">
                                            <polyline points="3 6 5 6 21 6"></polyline>
                                            <path
                                                d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2">
                                            </path>
                                        </svg>
                                        <span class="d-none d-md-inline">Hapus Semua</span>
                                        <span class="d-md-none">Hapus</span>
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card-body bg-light p-3 p-md-4">
                <div class="row g-2 g-md-3">
                    @forelse ($videos as $video)
                        <div class="col-6 col-md-3">
                            <div
                                class="card h-100 border-0 shadow-sm photo-card position-relative overflow-hidden rounded-3">
                                <div style="height:180px;" class="position-relative bg-secondary-subtle">
                                    <video class="w-100 h-100 img-fixed" style="object-fit: cover;" controls
                                        preload="metadata">
                                        <source src="{{ asset('storage/' . $video->file_path) }}"
                                            type="{{ $video->mime_type }}">
                                        Browser Anda tidak mendukung video.
                                    </video>
                                </div>
                                <div class="card-footer bg-white p-2 border-top-0">
                                    <form
                                        action="{{ route('home.video.destroy', [$event->public_code, $video->id]) }}"
                                        method="POST" class="delete-video-form">
                                        @csrf
                                        @method('DELETE')
                                        <button type="button" onclick="deletevideoConfirm(this)"
                                            class="btn btn-light text-danger btn-sm w-100 fw-bold shadow-sm d-flex align-items-center justify-content-center gap-1 delete-btn-hover">
                                            Hapus
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="col-12 py-5 text-center">
                            <div class="mb-3 opacity-50">
                                <svg xmlns="http://www.w3.org/2000/svg" width="48" height="48"
                                    viewBox="0 0 24 24" fill="none" stroke="#64748b" stroke-width="1.5"
                                    stroke-linecap="round" stroke-linejoin="round">
                                    <rect x="3" y="3" width="18" height="18" rx="2" ry="2">
                                    </rect>
                                    <circle cx="8.5" cy="8.5" r="1.5"></circle>
                                    <polyline points="21 15 16 10 5 21"></polyline>
                                </svg>
                            </div>
                            <p class="text-muted fw-medium small">Belum ada video.</p>
                        </div>
                    @endforelse
                </div>
            </div>

            <div class="d-flex justify-content-between align-items-center mt-3 px-4 pb-3">
                <small class="text-muted fw-bold" style="font-size: 0.8rem;">
                    Hal {{ $videos->currentPage() }} / {{ $videos->lastPage() }}
                </small>
                <div class="pagination-wrapper">
                    {{ $videos->links('vendor.pagination.simple-window') }}
                </div>
            </div>
        </div>
    </div>
</div>
