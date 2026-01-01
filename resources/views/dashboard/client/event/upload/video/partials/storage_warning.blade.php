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
                                <p>Segera tingkatkan langganan anda untuk mendapatkan extra storage dan fitur lainnya!
                                </p>
                                <a href="{{ route('home.subscribe') }}" class="btn btn-outline-primary ">Tingkatkan
                                    Langganan</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif
