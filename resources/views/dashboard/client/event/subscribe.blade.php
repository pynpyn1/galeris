@extends('dashboard.layouts.app')

@section('title', 'Subscribe Package')

@section('content')
    <div class="container py-5">
        @include('dashboard.client.event.partials.subscribe.card.pending')
        @include('dashboard.client.event.partials.subscribe.card.verification')
        @include('dashboard.client.event.partials.subscribe.card.active')
        {{-- Header --}}
        <div class="text-center mb-5">
            <h1 class="fw-bold">
                {{ $hasActivePackage ? 'Upgrade Paket Berlangganan' : 'Pilih Paket Berlangganan' }}
            </h1>
            <p class="text-muted mt-2">
                {{ $hasActivePackage
                    ? 'Jangan batasi kreativitasmu! Buka semua fitur eksklusif sekarang'
                    : 'Pilih paket yang paling sesuai dengan kebutuhan Anda' }}
            </p>
        </div>


        {{-- Package Cards --}}
        <div class="row justify-content-center align-items-stretch g-4">

            @foreach ($packages->sortBy('price') as $package)
                <div class="col-12 col-md-4">
                    @php
                        $isActivePackage = $hasActivePackage && $hasActivePackage->package_id === $package->id;
                        $isLowerPackage = $hasActivePackage && $package->price < $hasActivePackage->package->price;
                        $isSamePackage = $hasActivePackage && $package->price == $hasActivePackage->package->price;
                        $isUpgradeable = $hasActivePackage && $package->price > $hasActivePackage->package->price;
                    @endphp

                    <div class="card h-100 border-0 shadow
                {{ $package->plan === 'pro' ? 'bg-primary text-white scale-pro' : 'bg-white' }}"
                        style="border-radius: 1rem;">

                        @if ($package->plan === 'pro')
                            <div class="pro-badge">
                                SAVE IDR 20.000
                            </div>
                        @endif



                        <div class="card-body d-flex flex-column p-4 text-center">
                            @if ($pendingPurchase)
                                <a href="{{ route('home.checkout.show', $pendingPurchase) }}"
                                    class="position-relative me-3">
                                    <i class="bi bi-wallet2 fs-5"></i>
                                    <span
                                        class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
                                        !
                                    </span>
                                </a>
                            @endif

                            {{-- Name --}}
                            <span
                                class="text-uppercase fw-bold mb-2
                        {{ $package->plan === 'pro' ? 'text-light' : 'text-primary' }}">
                                {{ $package->package_name }}
                            </span>

                            {{-- Price --}}
                            <h2
                                class="fw-bolder mb-4
                        {{ $package->plan === 'pro' ? 'text-white' : 'text-dark' }}">
                                Rp{{ number_format($package->price, 0, ',', '.') }}
                                <span class="fs-6 fw-normal opacity-75">/bulan</span>
                            </h2>

                            {{-- Description --}}
                            <p class="mb-4 text-start">
                                {{ $package->package_desc }}
                            </p>

                            {{-- Features --}}
                            <ul class="list-unstyled text-start mb-auto">
                                @foreach ($package->feature as $feature)
                                    <li class="mb-2 d-flex align-items-start">
                                        <i
                                            class="bi bi-check-circle-fill me-2
                                    {{ $package->plan === 'pro' ? 'text-light' : 'text-primary' }}"></i>
                                        <span>{{ $feature }}</span>
                                    </li>
                                @endforeach
                            </ul>

                            {{-- Button --}}
                            <form action="{{ route('home.checkout.select') }}" method="POST" class="mt-4">
                                @csrf
                                <input type="hidden" name="package_id" value="{{ $package->id }}">

                                <button
                                    class="btn fw-bold py-3 w-100
        {{ $package->plan === 'pro' ? 'btn-light text-primary' : 'btn-outline-primary' }}"
                                    @if ($hasActivePackage && !$isUpgradeable) disabled @endif>
                                    @if ($isActivePackage)
                                        <i class="bi bi-bag-check-fill me-2"></i>
                                        Paket Aktif
                                    @elseif ($hasActivePackage && $isLowerPackage)
                                        <i class="bi bi-bag-check-fill me-2"></i>
                                        Tidak Bisa Downgrade
                                    @elseif ($hasActivePackage && $isSamePackage)
                                        <i class="bi bi-dash-circle me-2"></i>
                                        Paket Saat Ini
                                    @else
                                        <i class="bi bi-bag-check-fill me-2"></i>

                                        {{ $hasActivePackage ? 'Upgrade Paket' : 'Pilih ' . $package->package_name }}
                                    @endif
                                </button>
                            </form>


                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <div class="text-center text-muted mt-5">
            <small>
                Pembayaran aman • Upgrade kapan saja • Dukungan 24/7
            </small>
        </div>

    </div>

@endsection

@push('styles')
    <style>
        .scale-pro {
            transform: scale(1.05);
            z-index: 2;
        }

        .pro-badge {
            position: absolute;
            top: 0;
            right: 0;
            background: #ffffff;
            color: #4f5bd5;
            font-weight: 700;
            font-size: 0.75rem;
            padding: 6px 14px;
            border-bottom-left-radius: 14px;
            border-top-right-radius: 1rem;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.12);
            z-index: 3;
        }
    </style>
@endpush
@push('scripts')
    <script>
        @if (session('success'))
            showToast(@json(session('success')), 'success');
        @endif

        @if (session('error'))
            showToast(@json(session('error')), 'error');
        @endif

        @if (session('warning'))
            showToast(@json(session('warning')), 'warning');
        @endif
    </script>
    @if ($pendingPurchase)
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                showToast(
                    'Anda masih memiliki pembayaran yang belum selesai. Silakan lanjutkan pembayaran.',
                    'warning',
                    7000
                );
            });
        </script>
    @endif
@endpush
