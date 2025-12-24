<div class="col-md-7">
    <div class="card shadow-sm">
        <div class="card-body text-center">
            <h5 class="card-title">Share via QR code</h5>
            <p class="text-muted mb-4" style="font-size: 0.9rem;">
                The QR code can be edited and used on table cards, signs, and more.
            </p>

            <div class="mb-4">
                @if (isset($link) && $link && $link->generate_qr_code)
                    <img id="current-qr-code" src="{{ $qr_path }}" alt="QR Code Event"
                        style="width: 200px; height: 200px;" class="mb-3 border rounded p-2 shadow-sm">
                @else
                    <div class="alert alert-warning border-0 p-3 mx-auto" style="max-width: 200px;">
                        <i class="bi bi-qr-code-scan me-1"></i> QR Code not available.
                    </div>
                @endif
            </div>

            <div class="d-grid gap-2">
                <button class="btn btn-outline-primary py-2" type="button" data-bs-toggle="modal"
                    data-bs-target="#qrCodeEditModal">
                    Edit design
                </button>

                @if (isset($link) && $link && $link->generate_qr_code)
                    <a href="{{ $qr_path }}" download="QR-{{ $folder->public_code ?? 'event' }}.svg"
                        class="btn btn-primary py-2">
                        Download QR code
                    </a>
                @else
                    <button class="btn btn-dark py-2" type="button" disabled>
                        Download QR code
                    </button>
                @endif
            </div>
        </div>
    </div>
</div>
