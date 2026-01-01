@extends('dashboard.layouts.app')

@section('title', 'Checkout')

@php($badge = $purchase->paymentBadge())

@section('content')
    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-12 col-xl-10 col-xxl-9">

                <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
                    <div class="row g-0">

                        <div class="col-lg-7 bg-light border-end">
                            <div class="p-4 p-md-5">

                                <div class="d-flex align-items-center mb-4">
                                    <div
                                        class="icon-box-status flex-shrink-0 bg-white text-primary shadow-sm d-flex align-items-center justify-content-center rounded-4 me-3">
                                        <i class="bi bi-receipt-cutoff"></i>
                                    </div>
                                    <div>
                                        <h4 class="fw-bold mb-0">Rincian Order</h4>
                                        <p class="text-muted small mb-0">Invoice #{{ $purchase->invoice_number }}</p>
                                    </div>
                                </div>

                                <div class="card border-0 rounded-4 shadow-sm mb-4">
                                    <div class="card-body p-4">
                                        <div
                                            class="d-flex flex-column flex-sm-row justify-content-between align-items-sm-start gap-3">

                                            <div class="w-100">
                                                <h6 class="text-muted small text-uppercase fw-bold mb-2">Paket Langganan
                                                </h6>
                                                <h4 class="fw-bold text-dark mb-1">{{ $purchase->package->package_name }}
                                                </h4>
                                                <span class="badge {{ $badge['class'] }} px-3 py-2 rounded-pill smaller">
                                                    <i class="bi {{ $badge['icon'] }} me-1"></i>
                                                    {{ $badge['label'] }}
                                                </span>
                                            </div>

                                            <div class="w-100 text-sm-end mt-2 mt-sm-0">
                                                <h6 class="text-muted small text-uppercase fw-bold mb-1">Harga</h6>
                                                <h5 class="fw-bold text-dark">
                                                    Rp{{ number_format($purchase->original_price, 0, ',', '.') }}
                                                </h5>
                                            </div>

                                        </div>
                                    </div>
                                </div>

                                <div class="card rounded-4 mb-3 border-0 shadow-sm overflow-hidden">
                                    <div class="card-body p-4">
                                        <form method="POST" action="{{ route('home.checkout.applyDiscount', $purchase) }}">
                                            @csrf
                                            <label class="form-label text-muted small fw-bold text-uppercase">
                                                <i class="bi bi-ticket-perforated-fill me-1"></i> Kode Voucher
                                            </label>
                                            <div class="input-group">
                                                <input type="text" name="code"
                                                    class="form-control border-0 py-3 ps-4 shadow-none bg-light"
                                                    placeholder="Punya kode promo?" style="height: 50px;">
                                                <button type="submit"
                                                    class="btn btn-primary px-4 fw-bold border-0">Gunakan</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-lg-5 bg-white d-flex flex-column position-relative">
                            <div class="p-4 p-md-5 w-100 h-100 d-flex flex-column justify-content-center">

                                <div class="text-center mb-4">
                                    <h5 class="fw-bold text-secondary text-uppercase ls-1">Total Pembayaran</h5>
                                    <h1 class="fw-bold text-primary display-6 display-md-5 mb-0 text-break">
                                        Rp{{ number_format($purchase->final_price, 0, ',', '.') }}
                                    </h1>
                                    @if ($purchase->discount_amount > 0)
                                        <span class="badge bg-success-subtle text-success rounded-pill mt-2">
                                            Hemat Rp{{ number_format($purchase->discount_amount, 0, ',', '.') }}
                                        </span>
                                    @endif
                                </div>

                                <div class="payment-methods-grid">
                                    <p class="text-center text-muted small fw-bold mb-3">PILIH METODE PEMBAYARAN</p>

                                    <div class="d-block d-md-none mb-3">
                                        <button onclick="payMidtrans('gopay')"
                                            class="btn btn-payment-card w-100 py-3 rounded-4 shadow-sm d-flex align-items-center justify-content-between px-4">
                                            <div class="d-flex align-items-center">
                                                <img src="https://upload.wikimedia.org/wikipedia/commons/8/86/Gopay_logo.svg"
                                                    class="bank-logo" alt="GoPay">
                                                <span class="ms-2 fw-bold text-muted small">/ QRIS</span>
                                            </div>
                                            <i class="bi bi-chevron-right small text-muted"></i>
                                        </button>
                                        <div class="text-center text-muted smaller my-3 fw-bold opacity-50">- ATAU -</div>
                                    </div>

                                    <div class="row g-2">
                                        <div class="col-6">
                                            <button onclick="payMidtrans('echannel')"
                                                class="btn btn-payment-card w-100 py-3 rounded-4 d-flex align-items-center justify-content-center">
                                                <img src="https://www.bankmandiri.co.id/image/layout_set_logo?img_id=31567&t=1757693631430"
                                                    class="bank-logo" alt="Mandiri">
                                            </button>
                                        </div>
                                        <div class="col-6">
                                            <button onclick="payMidtrans('bni_va')"
                                                class="btn btn-payment-card w-100 py-3 rounded-4 d-flex align-items-center justify-content-center">
                                                <img src="https://www.bni.co.id/Portals/1/BNI/Images/logo-bni-new.png"
                                                    class="bank-logo" alt="BNI">
                                            </button>
                                        </div>
                                        <div class="col-6">
                                            <button onclick="payMidtrans('bri_va')"
                                                class="btn btn-payment-card w-100 py-3 rounded-4 d-flex align-items-center justify-content-center">
                                                <img src="https://upload.wikimedia.org/wikipedia/commons/thumb/6/68/BANK_BRI_logo.svg/1280px-BANK_BRI_logo.svg.png"
                                                    class="bank-logo" alt="BRI">
                                            </button>
                                        </div>
                                        <div class="col-6">
                                            <button onclick="payMidtrans('cimb_va')"
                                                class="btn btn-payment-card w-100 py-3 rounded-4 d-flex align-items-center justify-content-center">
                                                <img src="https://cdn.brandfetch.io/id-4IaDdXY/theme/dark/logo.svg?c=1dxbfHSJFAPEGdCLU4o5B"
                                                    class="bank-logo" alt="CIMB">
                                            </button>
                                        </div>
                                        <div class="col-12">
                                            <button onclick="payMidtrans('permata_va')"
                                                class="btn btn-payment-card w-100 py-3 rounded-4 d-flex align-items-center justify-content-center">
                                                <img src="https://upload.wikimedia.org/wikipedia/commons/thumb/f/ff/Permata_Bank_%282024%29.svg/960px-Permata_Bank_%282024%29.svg.png"
                                                    class="bank-logo" alt="Permata">
                                            </button>
                                        </div>
                                    </div>

                                    <div class="d-none d-md-block text-center mt-3">
                                        <small class="text-muted fst-italic" style="font-size: 0.75rem;">
                                            <i class="bi bi-info-circle me-1"></i> Pembayaran QRIS/E-Wallet tersedia via
                                            Mobile.
                                        </small>
                                    </div>
                                </div>

                                <div class="text-center mt-4">
                                    <a href="{{ route('home.index') }}"
                                        class="text-decoration-none text-muted smaller fw-medium">
                                        <i class="bi bi-arrow-left me-1"></i> Batalkan
                                    </a>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('styles')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">

    <style>
        .rounded-4 {
            border-radius: 1.25rem !important;
        }

        .smaller {
            font-size: 0.85rem;
        }

        .ls-1 {
            letter-spacing: 1px;
        }

        .icon-box-status {
            width: 55px;
            height: 55px;
        }


        .btn-payment-card {
            border: 2px solid #f1f3f5;
            background-color: #fff;
            transition: all 0.2s ease-in-out;
            color: #333;
            min-height: 60px;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 0.5rem;
        }

        .btn-payment-card:hover {
            border-color: #0d6efd;
            background-color: #f8faff;
            transform: translateY(-3px);
            box-shadow: 0 5px 15px rgba(13, 110, 253, 0.1) !important;
        }

        .bank-logo {
            object-fit: contain;
            height: 20px;
            width: auto;
            max-width: 90%;
        }

        @media (min-width: 768px) {
            .bank-logo {
                height: 25px;
            }
        }

        body.swal2-shown>[aria-hidden="true"] {
            transition: 0.1s filter;
            filter: blur(10px);
        }
    </style>
@endpush

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://app.midtrans.com/snap/snap.js" data-client-key="{{ config('services.midtrans.client_key') }}">
    </script>

    <script>
        function payMidtrans(methodType) {
            Swal.fire({
                title: 'Memproses...',
                text: 'Menghubungkan ke Gateway Pembayaran',
                allowOutsideClick: false,
                didOpen: () => {
                    Swal.showLoading();
                }
            });

            const url = "{{ route('home.checkout.snapCheckout', $purchase) }}?payment_type=" + methodType;

            fetch(url)
                .then(response => response.json())
                .then(data => {
                    Swal.close();

                    if (data.error) {
                        Swal.fire({
                            icon: 'error',
                            title: 'Oops...',
                            text: data.message,
                            confirmButtonColor: '#0d6efd'
                        });
                        return;
                    }

                    snap.pay(data.snapToken, {
                        onSuccess: function(result) {
                            Swal.fire({
                                icon: 'success',
                                title: 'Pembayaran Berhasil!',
                                text: 'Paket langganan Anda aktif.',
                                confirmButtonColor: '#198754',
                                allowOutsideClick: false
                            }).then(() => {
                                window.location.href = "{{ route('home.index') }}";
                            });
                        },
                        onPending: function(result) {
                            Swal.fire({
                                icon: 'info',
                                title: 'Menunggu Pembayaran',
                                text: 'Selesaikan pembayaran di aplikasi Mobile Banking Anda.',
                                confirmButtonText: 'Cek Status',
                                confirmButtonColor: '#0d6efd'
                            }).then(() => {
                                location.reload();
                            });
                        },
                        onError: function(result) {
                            Swal.fire({
                                icon: 'error',
                                title: 'Gagal',
                                text: 'Terjadi kesalahan sistem.',
                            });
                        },
                        onClose: function() {}
                    });
                })
                .catch(error => {
                    console.error('Error:', error);
                    Swal.fire({
                        icon: 'error',
                        title: 'Koneksi Error',
                        text: 'Periksa koneksi internet Anda.',
                    });
                });
        }
    </script>
@endpush
