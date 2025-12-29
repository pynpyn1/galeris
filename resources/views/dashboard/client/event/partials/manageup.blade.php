    <div class="row justify-content-center mt-4">
        <div class="col-md-8">
            <div class="card shadow-sm">
                <div class="card-body">
                    <h5 class="mb-1">Kelola unggahan</h5>
                    <p class="text-muted mb-4" style="font-size: 0.9rem;">
                        Di sini Anda dapat melihat berapa banyak ruang yang terpakai dan mengunduh semua gambar dan
                        video.
                    </p>

                    <div class="d-flex align-items-center justify-content-around mb-4">

                        <div class="text-center">
                            <i class="bi bi-images text-primary fs-4"></i>
                            <p class="h6 mb-0 fw-semibold">{{ $upload_stats['image_count'] }}</p>
                            <p class="text-muted mb-0" style="font-size: 0.9rem;">gambar</p>
                        </div>

                        <div class="text-center">
                            <i class="bi bi-film text-primary fs-5"></i>
                            <p class="h6 mb-0 fw-semibold">{{ $upload_stats['video_count'] }}</p>
                            <p class="text-muted mb-0" style="font-size: 0.9rem;">video</p>
                        </div>

                        <div class="text-center">
                            <i class="bi bi-cloud-upload text-primary fs-4"></i>
                            <p class="h6 mb-0 fw-semibold">{{ $upload_stats['total_size'] }} /
                                {{ $upload_stats['limit_storage'] }}</p>
                            <p class="text-muted mb-0" style="font-size: 0.9rem;">ruang penyimpanan</p>
                        </div>
                    </div>

                    <div class="d-flex justify-content-between">
                        @if ($can_download && !$is_trial)
                            <a href="{{ route('home.download', $event->public_code) }}"
                                class="btn btn-primary me-2 w-100">
                                Unduh unggahan
                            </a>
                        @else
                            <button class="btn btn-primary me-2 w-100" disabled>
                                Unduh unggahan
                            </button>
                        @endif

                        <a href="{{ route('provide.photo', $link->slug) }}" target="_blank"
                            class="btn btn-outline-primary w-100">
                            Go to gallery <i class="bi bi-arrow-up-right"></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
