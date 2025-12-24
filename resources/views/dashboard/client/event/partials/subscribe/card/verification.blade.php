    @if ($verificationPurchase)
        <div class="card border-0 shadow-sm rounded-4 overflow-hidden mb-4"
            style="background: linear-gradient(135deg, #f8faff 0%, #ffffff 100%); border-left: 4px solid #0d6efd !important;">
            <div class="card-body p-4">
                <div class="d-flex align-items-start gap-4">
                    <div class="flex-shrink-0">
                        <div class="rounded bg-primary bg-opacity-10 d-flex align-items-center justify-content-center"
                            style="width: 56px; height: 56px; transition: all 0.3s ease;">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-50" fill="#fff"
                                class="bi bi-shield-check" viewBox="0 0 16 16">
                                <path
                                    d="M5.338 1.59a61 61 0 0 0-2.837.856.48.48 0 0 0-.328.39c-.554 4.157.726 7.19 2.253 9.188a10.7 10.7 0 0 0 2.287 2.233c.346.244.652.42.893.533q.18.085.293.118a1 1 0 0 0 .101.025 1 1 0 0 0 .1-.025q.114-.034.294-.118c.24-.113.547-.29.893-.533a10.7 10.7 0 0 0 2.287-2.233c1.527-1.997 2.807-5.031 2.253-9.188a.48.48 0 0 0-.328-.39c-.651-.213-1.75-.56-2.837-.855C9.552 1.29 8.531 1.067 8 1.067c-.53 0-1.552.223-2.662.524zM5.072.56C6.157.265 7.31 0 8 0s1.843.265 2.928.56c1.11.3 2.229.655 2.887.87a1.54 1.54 0 0 1 1.044 1.262c.596 4.477-.787 7.795-2.465 9.99a11.8 11.8 0 0 1-2.517 2.453 7 7 0 0 1-1.048.625c-.28.132-.581.24-.829.24s-.548-.108-.829-.24a7 7 0 0 1-1.048-.625 11.8 11.8 0 0 1-2.517-2.453C1.928 10.487.545 7.169 1.141 2.692A1.54 1.54 0 0 1 2.185 1.43 63 63 0 0 1 5.072.56" />
                                <path
                                    d="M10.854 5.146a.5.5 0 0 1 0 .708l-3 3a.5.5 0 0 1-.708 0l-1.5-1.5a.5.5 0 1 1 .708-.708L7.5 7.793l2.646-2.647a.5.5 0 0 1 .708 0" />
                            </svg>
                        </div>
                    </div>

                    <div class="flex-grow-1">
                        <div class="d-flex justify-content-between align-items-center mb-1">
                            <h6 class="fw-bold text-dark mb-0" style="letter-spacing: -0.2px;">Pembayaran Sedang
                                Diverifikasi</h6>
                            <span
                                class="badge rounded-pill bg-primary bg-opacity-10 text-white px-3 py-2 small fw-semibold">
                                Dalam Antrean
                            </span>
                        </div>

                        <p class="text-secondary mb-3 small lh-base">
                            Bukti pembayaran Anda telah masuk ke sistem. Tim admin kami sedang melakukan pengecekan
                            menyeluruh.
                            Estimasi waktu verifikasi adalah <span class="text-dark fw-bold">1×24 jam</span>.
                        </p>

                        <div class="d-flex gap-2">
                            <a href="{{ route('home.checkout.show', $verificationPurchase) }}"
                                class="btn btn-primary btn-sm px-4 py-2 rounded-3 fw-semibold shadow-sm transition-all">
                                Lihat Detail
                            </a>
                            <a href="mailto:dirajadanu@gmail.com"
                                class="btn btn-outline-primary btn-sm px-3 py-2 rounded-3 fw-medium  border">
                                Butuh Bantuan?
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif
