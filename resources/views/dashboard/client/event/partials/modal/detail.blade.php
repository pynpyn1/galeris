<div class="modal fade" id="editDetailModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <form method="POST" action="{{ route('home.update', $event->public_code) }}">
            @csrf
            @method('PUT')

            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Ubah Acara</h5>
                    <button class="btn-close " data-bs-dismiss="modal"></button>
                </div>

                <div class="modal-body">
                    <div class="mb-3">
                        <p class="mb-1 fw-semibold">Nama Acara</p>
                        <input type="text" name="name" class="form-control" value="{{ $event->name }}" required>
                    </div>

                    <div class="mb-2">
                        <p class="mb-1 fw-semibold">Tanggal Acara Dimulai</p>
                        <input type="text" class="form-control"
                            value="{{ \Carbon\Carbon::parse($event->date_event)->format('d M Y') }}" readonly>

                    </div>

                    <span class="text-muted" style="font-size: 0.85rem;">
                        Mulai dari tanggal yang Anda pilih, tamu Anda dapat mengunggah foto dan video selama 3 bulan.
                        Tanggal tidak dapat diubah setelah acara dimulai.
                    </span>

                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-primary" data-bs-dismiss="modal">
                        Batal
                    </button>
                    <button type="submit" class="btn btn-primary">
                        Simpan
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>
