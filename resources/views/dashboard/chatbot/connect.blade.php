@extends('dashboard.layouts.app')

@section('title', 'Connect Whatsapp')
@section('name_header', 'Connect Whatsapp')

@section('content')
    <section class="section">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="mb-0">Whatsapp Connection</h5>
                <span class="badge bg-secondary" id="connection-status">Disconnected</span>
            </div>
            <div class="card-body text-center">
                <div id="whatsapp-qr" class="mb-3">
                    <img id="whatsapp-qr-img" class="img-fluid" style="max-width:300px;">
                </div>
                <p>Scan this QR code with your Whatsapp to connect.</p>
                <button id="refresh-qr" class="btn btn-primary mt-2">Refresh QR Code</button>
            </div>
        </div>
    </section>

    @push('scripts')
        <script>
            const QR_IMG = document.getElementById('whatsapp-qr-img');
            const STATUS_BADGE = document.getElementById('connection-status');
            const REFRESH_BTN = document.getElementById('refresh-qr');
            const USER_ID = "{{ Auth::id() }}";

            function updateStatus(status) {
                if (status === 'connected') {
                    STATUS_BADGE.classList.remove('bg-secondary');
                    STATUS_BADGE.classList.add('bg-success');
                    STATUS_BADGE.textContent = 'Connected';
                    QR_IMG.src = "{{ asset('asset/img/404.jpeg') }}";
                } else {
                    STATUS_BADGE.classList.remove('bg-success');
                    STATUS_BADGE.classList.add('bg-secondary');
                    STATUS_BADGE.textContent = 'Disconnected';
                }
            }

            async function fetchQRAndStatus() {
                try {
                    const res = await fetch(`https://botadorawedding.test/qr?user_id=${USER_ID}`);
                    const data = await res.json();
                    if (data.qr) QR_IMG.src = data.qr;
                    updateStatus(data.status);
                } catch (err) {
                    console.error(err);
                }
            }

            fetchQRAndStatus(); // awal load
            setInterval(fetchQRAndStatus, 5000); // polling

            REFRESH_BTN.addEventListener('click', fetchQRAndStatus);
        </script>
    @endpush
@endsection
