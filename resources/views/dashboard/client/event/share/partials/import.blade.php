<div class="card border-0 shadow-sm">
    <div class="card-body p-4">
        <div class="mb-4">
            <h5 class="fw-bold mb-1">Import Kontak WhatsApp</h5>
            <p class="text-muted small mb-0">Import tamu undangan langsung dari file Excel atau CSV untuk mempermudah
                pengiriman undangan.</p>
        </div>

        <form action="{{ route('home.import', $event->public_code) }}" method="POST" enctype="multipart/form-data"
            id="importWhatsappForm">
            @csrf
            <div class="mb-4">
                <label for="wa_file" class="form-label small fw-bold text-muted text-uppercase">Pilih File
                    Kontak</label>
                <input class="form-control form-control-sm" type="file" id="wa_file" name="excel_file"
                    accept=".xlsx, .xls, .csv" required {{ !$isPro ? 'disabled' : '' }}>
                <div class="form-text mt-2 small">
                    <i class="fas fa-info-circle me-1"></i> Format yang didukung: <span class="fw-bold">.xlsx,
                        .csv</span>
                </div>
            </div>

            @if ($isPro)
                <div class="d-grid d-md-flex gap-2">
                    <button type="submit" class="btn btn-primary px-4 py-2">
                        Mulai Import
                    </button>

                    <a href="{{ route('home.template.download', $event->public_code) }}"
                        class="btn btn-outline-primary px-4 py-2">
                        Unduh Template
                    </a>
                </div>
            @else
                <div class="alert alert-primary small mb-0">
                    <strong>Fitur Premium</strong><br>
                    Import tamu via Excel hanya tersedia untuk paket
                    <b>Pro</b> dan <b>Premium</b>.
                    Silakan upgrade untuk menggunakan fitur ini.
                </div>
            @endif
        </form>
    </div>
</div>
