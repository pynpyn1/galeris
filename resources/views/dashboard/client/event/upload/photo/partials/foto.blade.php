<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card shadow-sm mb-4 border-0">
            <div class="card-header bg-white py-3 border-bottom-0">
                <h5 class="m-0 fw-bold">
                    Upload Foto Baru
                </h5>
            </div>

            <div class="card-body">
                <form id="my-dropzone-form" action="{{ route('home.photo.store', $event->public_code) }}" method="POST"
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
                                <h5 class="text-dark fw-bold">Klik atau Drop Foto Disini</h5>
                                <span class="text-muted small">Maksimal 50MB per file (JPG, PNG, WEBP)</span>
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
                            Simpan Foto
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <div class="card shadow-sm border-0">
            <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
                <h5 class="m-0 fw-bold">Kelola Foto</h5>



                <div class="d-flex align-items-center gap-2 ">
                    <form method="POST" action="{{ route('home.photo.destroyAll', $event->public_code) }}"
                        id="delete-all-form">
                        @csrf
                        @method('DELETE')

                        <button type="button" class="btn btn-sm btn-danger"
                            {{ $photos->total() === 0 ? 'disabled' : '' }} onclick="deleteAllConfirm()">
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
                        {{ $photos->total() }} Foto
                    </span>
                </div>
            </div>



            <div class="card-body bg-light">
                <div class="row g-3">
                    @forelse ($photos as $photo)
                        <div class="col-6 col-md-3 py-4">
                            <div class="card h-100 shadow-sm border-0 overflow-hidden">
                                <div style="height:180px;" class="position-relative bg-white">
                                    <img src="{{ asset('storage/' . $photo->file_path) }}" loading="lazy"
                                        decoding="async" width="300" height="180" class="w-100 h-100"
                                        style="object-fit:cover; transition: transform 0.3s;"
                                        onmouseover="this.style.transform='scale(1.05)'"
                                        onmouseout="this.style.transform='scale(1)'">
                                </div>
                                <div class="card-footer bg-white p-2 border-top-0">
                                    <form action="{{ route('home.photo.destroy', [$event->public_code, $photo->id]) }}"
                                        method="POST"class="delete-photo-form">
                                        @csrf
                                        @method('DELETE')
                                        <button type="button" onclick="deletePhotoConfirm(this)"
                                            class="btn btn-sm btn-outline-danger w-100 d-flex align-items-center justify-content-center">
                                            Hapus
                                        </button>

                                    </form>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="col-12 py-5 text-center">
                            <p class="text-muted">Belum ada foto.</p>
                        </div>
                    @endforelse

                </div>

            </div>
            <div class="d-flex justify-content-between align-items-center mt-3 px-4">
                <small class="text-muted py-3">
                    Halaman {{ $photos->currentPage() }} dari {{ $photos->lastPage() }}
                </small>

                <div class="pagination-wrapper">
                    {{ $photos->links('vendor.pagination.simple-window') }}

                </div>
            </div>


        </div>

    </div>
</div>
