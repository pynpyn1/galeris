    <div class="row justify-content-center mt-4">
        <div class="col-md-8">
            <div class="card shadow-sm">


                <div class="card-body">
                    <div class="row align-items-center">

                        <div class="col-md-5 text-center order-md-2 mb-4 mb-md-0">

                            @if ($link && $link->generate_qr_code)
                                <img src="{{ $qr_path }}" alt="QR Code Event" style="width: 160px; height: 160px;"
                                    class="mb-3 border rounded p-1">

                                <a href="{{ $qr_path }}" download="QR-{{ $event->public_code }}.svg"
                                    class="btn btn-sm btn-outline-primary w-100">
                                    <i class="bi bi-download me-1"></i> Download QR Code
                                </a>
                            @else
                                <div class="alert alert-warning">
                                    QR Code belum tersedia.
                                </div>
                            @endif
                        </div>

                        <div class="col-md-7 order-md-1 ">
                            <h5 class="mb-3">Share with your guests
                            </h5>
                            <p class="text-muted" style="font-size: 0.85rem;">
                                You can share your event via a link or a QR code. Here you can also select a print-ready
                                template with your QR code on it. </p>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
