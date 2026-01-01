@if ($unpaidPurchase)
    <div class="card border-0 shadow-sm rounded-4 overflow-hidden mb-4"
        style="background: linear-gradient(135deg, #fff7ed 0%, #ffffff 100%);
               border-left: 4px solid #f59e0b !important;">

        <div class="card-body p-3 p-md-4">
            <div class="d-flex flex-column flex-md-row align-items-center align-items-md-start gap-3 gap-md-4">

                <div class="flex-shrink-0">
                    <div class="rounded bg-warning bg-opacity-10 d-flex align-items-center justify-content-center"
                        style="width: 56px; height: 56px;">
                        <svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" fill="#f59e0b"
                            viewBox="0 0 16 16">
                            <path
                                d="M8 1a7 7 0 1 0 0 14A7 7 0 0 0 8 1Zm0 3a.75.75 0 0 1 .75.75v3.5a.75.75 0 0 1-1.5 0v-3.5A.75.75 0 0 1 8 4Zm0 7a1 1 0 1 1 0-2 1 1 0 0 1 0 2Z" />
                        </svg>
                    </div>
                </div>

                <div class="flex-grow-1 text-center text-md-start w-100">
                    <div class="d-flex flex-column flex-md-row justify-content-between align-items-center mb-2 gap-2">
                        <h6 class="fw-bold text-dark mb-0">
                            Menunggu Pembayaran
                        </h6>
                        <span class="badge rounded-pill bg-warning bg-opacity-10 text-dark px-3 py-2 small fw-semibold">
                            Belum Dibayar
                        </span>
                    </div>

                    <p class="text-secondary mb-3 small lh-base">
                        Anda sudah memilih paket
                        <span class="fw-bold text-dark">
                            {{ $unpaidPurchase->package->package_name }}
                        </span>.
                        Silakan selesaikan pembayaran untuk mengaktifkan langganan.
                    </p>

                    <div class="d-flex flex-column flex-md-row gap-2">
                        <a href="{{ route('home.checkout.show', $unpaidPurchase) }}"
                            class="btn btn-warning btn-sm px-4 py-2 rounded-3 fw-semibold shadow-sm  w-md-auto">
                            Lanjutkan Pembayaran
                        </a>

                        <a href="mailto:dirajadanu@gmail.com"
                            class="btn btn-outline-warning btn-sm px-3 py-2 rounded-3 fw-medium border  w-md-auto">
                            Hubungi Admin
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endif
