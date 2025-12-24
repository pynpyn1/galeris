@extends('dashboard.layouts.app')

@section('title', 'Checkout')

@php($badge = $purchase->paymentBadge())

@section('content')
    <div class="container-fluid ">
        <div class="row justify-content-center">
            <div class="col-12 col-xl-10 col-xxl-9">

                <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
                    <div class="row g-0">

                        {{-- SISI KIRI: DETAIL TAGIHAN & INSTRUKSI --}}
                        <div class="col-lg-6 bg-light border-end">
                            <div class="p-4 p-md-5">
                                <div class="d-flex align-items-center mb-4">
                                    <div
                                        class="icon-box-status me-3 bg-primary text-white d-flex align-items-center justify-content-center lh-1">
                                        <i class="bi bi-receipt-cutoff fs-3"></i>
                                    </div>
                                    <div>
                                        <h4 class="fw-bold mb-0">Detail Tagihan</h4>
                                        <p class="text-muted small mb-0">Invoice #{{ $purchase->invoice_number }}</p>
                                    </div>
                                </div>

                                {{-- Pilihan Metode & Voucher --}}
                                <div class="card rounded-4 mb-3 border-0 shadow-sm overflow-hidden">
                                    <div class="card-body p-4">
                                        <div class="mb-3">
                                            <label class="form-label text-muted small fw-bold text-uppercase">Metode
                                                Pembayaran</label>
                                            <select id="paymentMethodSelector" class="form-select border-2 py-2 shadow-none"
                                                style="border-radius: 10px;">
                                                <option value="manual" selected>Manual (Transfer Bank)</option>
                                                <option value="midtrans">Otomatis (QRIS, VA, E-Wallet)</option>
                                            </select>
                                            <div class="mt-2">
                                                <span class="text-muted smaller">
                                                    <i class="bi bi-info-circle-fill text-primary"></i>
                                                    <span id="methodText">Metode manual wajib menyertakan bukti transfer
                                                        berupa foto.</span>
                                                </span>
                                            </div>
                                        </div>

                                        <hr class="my-3 opacity-25">

                                        <form method="POST" action="{{ route('home.checkout.applyDiscount', $purchase) }}">
                                            @csrf
                                            <label class="form-label text-muted small fw-bold text-uppercase">Kode
                                                Voucher</label>
                                            <div class="input-group">
                                                <input type="text" name="code"
                                                    class="form-control border-0 py-3 ps-4 shadow-none bg-light"
                                                    placeholder="Masukkan kode voucher" style="height: 50px;">
                                                <button type="submit"
                                                    class="btn btn-primary px-4 fw-bold border-0">Gunakan</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>

                                {{-- Paket Info --}}
                                <div class="card border-0 rounded-4 shadow-sm mb-4">
                                    <div class="card-body p-4">
                                        <div class="row align-items-center text-center text-md-start">
                                            <div class="col-md-7">
                                                <h6 class="text-muted small text-uppercase fw-bold mb-2">Paket Langganan
                                                </h6>
                                                <h4 class="fw-bold text-dark">{{ $purchase->package->package_name }}</h4>
                                                <span
                                                    class="badge {{ $badge['class'] }} px-3 py-2 rounded-pill mt-2 smaller">
                                                    <i class="bi {{ $badge['icon'] }} me-1"></i>
                                                    {{ $badge['label'] }}
                                                </span>
                                            </div>
                                            <div class="col-md-5 text-md-end mt-3 mt-md-0">
                                                <h6 class="text-muted small text-uppercase fw-bold mb-1">Total</h6>
                                                <h3 class="fw-bold fs-4 text-primary mb-0">
                                                    Rp{{ number_format($purchase->final_price, 0, ',', '.') }}</h3>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                {{-- Instruksi Manual (Hidden saat Midtrans) --}}
                                <div id="manualInstructionSection">
                                    <h6 class="fw-bold mb-3"><i class="bi bi-info-circle me-2 text-primary"></i>Instruksi
                                        Pembayaran</h6>
                                    <div class="instruction-container bg-white p-3 p-md-4 rounded-4 shadow-sm border">
                                        <label class="form-label text-muted small fw-bold">PILIH BANK</label>
                                        <select class="form-select mb-4 border-2 shadow-none" id="bankSelector">
                                            <option value="bca" data-rekening="6914 0100 0006 550">Bank BCA</option>
                                            <option value="mandiri" data-rekening="1234 5678 9012 345">Bank Mandiri</option>
                                            <option value="bni" data-rekening="0987 6543 2109 876">Bank BNI</option>
                                        </select>

                                        <div
                                            class="rekening-display p-3 rounded-4 text-center bg-light border border-dashed">
                                            <p class="text-muted small mb-2">Transfer ke Rekening <span id="bankNameDisplay"
                                                    class="fw-bold">BCA</span>:</p>
                                            <div class="d-flex align-items-center justify-content-center mb-2">
                                                <h3 class="fw-bold text-dark mb-0 me-3" id="accountNumber"
                                                    style="letter-spacing: 1px;">6914 0100 0006 550</h3>
                                                <button class="btn btn-sm btn-outline-primary rounded-pill px-3 fw-bold"
                                                    onclick="copyText()">SALIN</button>
                                            </div>
                                            <div class="pt-2 border-top mt-2">
                                                <small class="text-muted d-block smaller">Atas Nama:</small>
                                                <p class="fw-bold text-dark text-uppercase mb-0 small">Danudiraja Soenoto
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- SISI KANAN: KONFIRMASI / UPLOAD --}}
                        <div class="col-lg-6 bg-white d-flex align-items-center">
                            <div class="p-4 p-md-5 w-100">
                                @if ($purchase->payment_proof)
                                    <div class="text-center py-3">
                                        <div class="mb-4 d-inline-flex align-items-center justify-content-center bg-success bg-opacity-10 rounded-circle"
                                            style="width: 100px; height: 100px;">
                                            <i class="bi bi-check-lg fs-1 text-success"></i>
                                        </div>
                                        <h3 class="fw-bold text-dark">Terima Kasih!</h3>
                                        <p class="text-muted mx-auto" style="max-width: 400px;">
                                            Bukti pembayaran untuk invoice <span
                                                class="fw-bold text-dark">#{{ $purchase->invoice_number }}</span> telah kami
                                            terima dan akan diverifikasi dalam <span
                                                class="badge bg-primary-subtle text-primary fw-semibold">1x24 Jam</span>.
                                        </p>
                                        <div class="d-grid gap-2 mt-4">
                                            <a href="{{ route('home.index') }}"
                                                class="btn btn-primary btn-lg rounded-4 fw-bold shadow-sm py-3">Ke
                                                Dashboard</a>
                                        </div>
                                    </div>
                                @else
                                    <div id="paymentActionContainer">
                                        <h4 class="fw-bold mb-3" id="rightTitle">Konfirmasi</h4>
                                        <p class="text-muted small mb-4" id="rightSubtitle">Unggah bukti transfer untuk
                                            mempercepat aktivasi.</p>

                                        <form id="manualForm" action="{{ route('home.checkout.confirm', $purchase) }}"
                                            method="POST" enctype="multipart/form-data">
                                            @csrf
                                            <div id="uploadZoneContainer">
                                                <div class="upload-zone rounded-4 mb-4" id="dropArea">
                                                    <div class="text-center p-4 w-100" id="uploadPlaceholder">
                                                        <h6 class="fw-bold mb-1 text-dark">Pilih File Bukti</h6>
                                                        <p class="smaller text-muted mb-0">Klik area ini untuk mencari
                                                            gambar</p>
                                                    </div>
                                                    <div id="filePreview" class="d-none p-4 text-center w-100">
                                                        <h6 class="fw-bold text-success mb-1 text-truncate px-3"
                                                            id="fileNameDisplay">Nama_File.jpg</h6>
                                                        <button type="button"
                                                            class="btn btn-sm btn-link text-danger text-decoration-none fw-bold"
                                                            onclick="resetFile()">Ganti File</button>
                                                    </div>
                                                    <input type="file" name="payment_proof" id="fileInput"
                                                        accept="image/*" required>
                                                </div>

                                                <div
                                                    class="alert alert-warning border-0 rounded-4 mb-4 d-flex align-items-center shadow-sm">
                                                    <i class="bi bi-exclamation-circle-fill me-2 fs-5"></i>
                                                    <span class="smaller">Transfer nominal sesuai invoice hingga 3 digit
                                                        terakhir.</span>
                                                </div>
                                            </div>

                                            <button type="button" id="submitBtn"
                                                class="btn btn-primary btn-lg w-100 py-3 rounded-4 fw-bold shadow-sm mb-4 border-0">KIRIM
                                                SEKARANG</button>
                                        </form>

                                        <div class="text-center">
                                            <a href="{{ route('home.index') }}"
                                                class="text-decoration-none text-muted smaller fw-medium"><i
                                                    class="bi bi-arrow-left me-1"></i> Kembali</a>
                                        </div>
                                    </div>
                                @endif
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('styles')
    <style>
        .rounded-4 {
            border-radius: 1.25rem !important;
        }

        .smaller {
            font-size: 0.85rem;
        }

        .border-dashed {
            border-style: dashed !important;
            border-width: 2px !important;
        }

        .icon-box-status {
            width: 55px;
            height: 55px;
            border-radius: 14px;
        }

        .upload-zone {
            border: 2px dashed #dee2e6;
            background-color: #fcfcfc;
            position: relative;
            min-height: 200px;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: all 0.3s ease;
            cursor: pointer;
        }

        .upload-zone:hover {
            border-color: #0d6efd;
            background-color: #f0f7ff;
        }

        #fileInput {
            position: absolute;
            inset: 0;
            width: 100%;
            height: 100%;
            opacity: 0;
            z-index: 10;
            cursor: pointer;
        }
    </style>
@endpush

@push('scripts')
    {{-- PROD --}}
    <script src="https://app.midtrans.com/snap/snap.js" data-client-key="{{ config('services.midtrans.client_key') }}">
    </script>
    {{-- SANDBOX --}}
    {{-- <script src="https://app.sandbox.midtrans.com/snap/snap.js"
        data-client-key="{{ config('services.midtrans.client_key') }}"></script> --}}

    <script>
        let currentSnapToken = "{{ $purchase->snap_token }}";
    </script>

    <script>
        // Inisialisasi Element
        const methodSelector = document.getElementById('paymentMethodSelector');
        const methodText = document.getElementById('methodText');
        const manualInstruction = document.getElementById('manualInstructionSection');
        const uploadZone = document.getElementById('uploadZoneContainer');
        const submitBtn = document.getElementById('submitBtn');
        const rightTitle = document.getElementById('rightTitle');
        const rightSubtitle = document.getElementById('rightSubtitle');
        const fileInput = document.getElementById('fileInput');
        const manualForm = document.getElementById('manualForm');

        // Logic Switch Metode
        methodSelector.addEventListener('change', function() {
            if (this.value === 'midtrans') {
                methodText.innerText = "Pembayaran otomatis diproses tanpa perlu upload bukti.";
                manualInstruction.classList.add('d-none');
                uploadZone.classList.add('d-none');
                rightTitle.innerText = "Pembayaran Otomatis";
                rightSubtitle.innerText = "Klik tombol di bawah untuk membayar melalui QRIS, VA, atau E-Wallet.";
                submitBtn.innerText = "BAYAR SEKARANG";
                fileInput.required = false;
            } else {
                methodText.innerText = "Metode manual wajib menyertakan bukti transfer berupa foto.";
                manualInstruction.classList.remove('d-none');
                uploadZone.classList.remove('d-none');
                rightTitle.innerText = "Konfirmasi";
                rightSubtitle.innerText = "Unggah bukti transfer untuk mempercepat aktivasi.";
                submitBtn.innerText = "KIRIM SEKARANG";
                fileInput.required = true;
            }
        });

        // Trigger Submit sesuai Metode
        submitBtn.addEventListener('click', function() {
            if (methodSelector.value === 'midtrans') {
                payMidtrans();
            } else {
                if (fileInput.files.length === 0) {
                    alert('Silakan pilih file bukti transfer terlebih dahulu.');
                    return;
                }
                manualForm.submit();
            }
        });

        function payMidtrans() {
            submitBtn.disabled = true;
            submitBtn.innerText = "Memproses...";

            fetch("{{ route('home.checkout.snapCheckout', $purchase) }}")
                .then(res => res.json())
                .then(data => {

                    if (data.error) {
                        alert(data.message);
                        submitBtn.disabled = false;
                        submitBtn.innerText = "BAYAR SEKARANG";
                        return;
                    }

                    snap.pay(data.snapToken, {
                        onSuccess: function(result) {
                            location.reload();
                        },
                        onPending: function(result) {
                            location.reload();
                        },
                        onError: function(result) {
                            alert('Pembayaran gagal');
                        },
                        onClose: function() {
                            // TIDAK BIKIN SNAP BARU
                            submitBtn.disabled = false;
                            submitBtn.innerText = "BAYAR SEKARANG";
                        }
                    });
                })
                .catch(() => {
                    alert('Terjadi kesalahan');
                    submitBtn.disabled = false;
                    submitBtn.innerText = "BAYAR SEKARANG";
                });
        }


        function openSnap(token) {
            snap.pay(token, {
                onSuccess: function() {
                    location.reload();
                },
                onPending: function() {
                    location.reload();
                },
                onError: function() {
                    alert('Pembayaran gagal');
                    submitBtn.disabled = false;
                    submitBtn.innerText = "BAYAR SEKARANG";
                },
                onClose: function() {
                    // ✅ SNAP DITUTUP → TOKEN TETAP DISIMPAN
                    submitBtn.disabled = false;
                    submitBtn.innerText = "LANJUTKAN PEMBAYARAN";
                }
            });
        }



        // Preview File Upload
        fileInput.addEventListener('change', function() {
            const placeholder = document.getElementById('uploadPlaceholder');
            const preview = document.getElementById('filePreview');
            const fileName = document.getElementById('fileNameDisplay');
            if (this.files.length > 0) {
                placeholder.classList.add('d-none');
                preview.classList.remove('d-none');
                fileName.innerText = this.files[0].name;
            }
        });

        function resetFile() {
            fileInput.value = '';
            document.getElementById('uploadPlaceholder').classList.remove('d-none');
            document.getElementById('filePreview').classList.add('d-none');
        }

        // Copy & Bank Selector
        function copyText() {
            const text = document.getElementById('accountNumber').innerText;
            navigator.clipboard.writeText(text).then(() => {
                alert('Disalin!');
            });
        }

        document.getElementById('bankSelector').addEventListener('change', function() {
            const selected = this.options[this.selectedIndex];
            document.getElementById('accountNumber').innerText = selected.getAttribute('data-rekening');
            document.getElementById('bankNameDisplay').innerText = selected.text.replace('Bank ', '');
        });
    </script>
@endpush
