@php
    $canEditChatbot = auth()->user()->canEditChatbot();
@endphp

<div class="row justify-content-center">
    <div class="col-12 col-lg-5 mb-4">
        <div class="card modern-card shadow-sm h-100 border-0">
            <div class="card-body p-4 p-xl-5 d-flex flex-column">
                @if (!$canEditChatbot)
                    <div class="alert alert-primary mt-3 small rounded-4">
                        <strong>Custom chatbot message</strong> tersedia untuk paket
                        <strong>Pro</strong> & <strong>Premium</strong>.
                    </div>
                @endif

                <div class="mb-4">
                    <div class="d-flex align-items-center mb-2">
                        <h5 class="modern-title mb-0">Pesan Pengingat</h5>
                    </div>
                    <p class="text-muted small">Personalisasi pesan otomatis untuk tamu spesial Anda.</p>
                </div>

                <form action="{{ route('chatbot.update', $chatbot->id) }}" method="POST"
                    class="flex-grow-1 d-flex flex-column">
                    @csrf
                    @method('PUT')

                    <div class="form-group mb-4 flex-grow-1">
                        <label class="small fw-bold mb-2 text-dark">Template Pesan</label>
                        <textarea name="message" class="form-control modern-textarea" rows="5"
                            {{ $canEditChatbot ? '' : 'readonly disabled' }}
                            placeholder="Contoh: Halo {name}, silakan buka album foto Anda di {url}">{{ $chatbot->message ?? '' }}</textarea>

                        <div class="mt-3 p-3 rounded-4 border-0" style="background: #f8faff;">
                            <p class="mb-1 fw-bold text-dark" style="font-size: 0.75rem;">Shortcode Tersedia:</p>
                            <span class="badge bg-white text-primary border me-1 px-2 py-1">{name}</span>
                            <span class="badge bg-white text-primary border px-2 py-1">{url}</span>
                        </div>
                    </div>

                    <button type="submit" class="btn btn-modern-primary text-white w-100"
                        {{ $canEditChatbot ? '' : 'disabled' }}>
                        <i class="bi bi-cloud-check me-2"></i> Simpan Konfigurasi
                    </button>
                </form>
            </div>
        </div>
    </div>

    <div class="col-12 col-lg-5 mb-4">
        <div class="card modern-card shadow-sm h-100 border-0">
            <div class="card-body p-4 p-xl-5 text-center d-flex flex-column">
                <div class="d-flex justify-content-between align-items-start mb-4">
                    <div class="text-start">
                        <h5 class="modern-title mb-1">Gateway WhatsApp</h5>
                        <p class="text-muted small mb-0">Integrasi sistem bot mandiri.</p>
                    </div>
                    <div id="connection-status" class="status-pill bg-secondary text-white">Disconnected</div>
                </div>

                <div class="qr-wrapper mb-4 d-flex align-items-center justify-content-center"
                    style="min-height: 250px;">
                    <img id="whatsapp-qr-img" class="img-fluid rounded-3"
                        style="max-width: 200px; display: none; z-index: 1;" alt="QR Code">

                    <div id="qr-placeholder" class="text-muted small position-relative" style="z-index: 1;">
                        <div class="mb-3">
                            <i class="bi bi-qr-code-scan" style="font-size: 3.5rem; color: #dee2e6;"></i>
                        </div>
                        <p class="fw-medium mb-0">Menyiapkan Enkripsi QR...</p>
                    </div>
                </div>

                <div class="mt-auto text-start">
                    <div class="d-flex align-items-center mb-3 text-muted">
                        <i class="bi bi-info-circle me-2"></i>
                        <small>Buka WhatsApp > Perangkat Tertaut > Tautkan Perangkat.</small>
                    </div>
                    <button style="padding: 12px 24px;" id="refresh-qr"
                        class="btn btn-outline-primary w-100 fw-bold shadow-sm">
                        <i class="bi bi-arrow-repeat me-2"></i> Regenerate QR
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

@push('styles')
    <style>
        :root {
            --primary-blue: #435ebf;
            --dark-blue: #364ea4;
            --soft-bg: #f8faff;
            --glass-border: rgba(255, 255, 255, 0.4);
        }

        body {
            background-color: var(--soft-bg);
        }

        /* Modern Glass Card */
        .modern-card {
            background: rgba(255, 255, 255, 0.8);
            backdrop-filter: blur(10px);
            border: 1px solid var(--glass-border);
            border-radius: 24px;
            /* Ultra-rounded */
            transition: all 0.4s cubic-bezier(0.165, 0.84, 0.44, 1);
        }


        /* Typography */
        .modern-title {
            font-weight: 800;
            letter-spacing: -0.02em;
        }

        /* Floating Input Style */
        .modern-textarea {
            border-radius: 16px;
            border: 2px solid transparent;
            background: #f1f4fb;
            transition: all 0.3s ease;
            padding: 1rem;
        }

        .modern-textarea:focus {
            background: #fff;
            border-color: var(--primary-blue);
            box-shadow: 0 0 0 4px rgba(67, 94, 191, 0.1);
        }

        .status-pill {
            padding: 6px 16px;
            border-radius: 100px;
            font-weight: 600;
            font-size: 0.75rem;
            text-transform: uppercase;
            letter-spacing: 0.05em;
        }

        .status-connected {
            background: #e1f9f0;
            color: #1a7f64;
            box-shadow: 0 0 15px rgba(26, 127, 100, 0.2);
        }

        .qr-wrapper {
            background: white;
            padding: 2rem;
            border-radius: 20px;
            position: relative;
            overflow: hidden;
        }

        .qr-wrapper::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            border: 2px dashed #e2e8f0;
            border-radius: 20px;
            margin: 5px;
        }

        .btn-modern-primary {
            background: var(--dark-blue);
            padding: 12px 24px;
            font-weight: 600;
            border: none;
            transition: all 0.3s;
        }
    </style>
@endpush

@push('scripts')
    <script>
        const QR_IMG = document.getElementById('whatsapp-qr-img');
        const QR_PLACEHOLDER = document.getElementById('qr-placeholder');
        const STATUS_BADGE = document.getElementById('connection-status');
        const REFRESH_BTN = document.getElementById('refresh-qr');

        const WA_SESSION_ID = "{{ auth()->user()->wa_session_id }}";
        const CONNECTED_IMG = "{{ asset('asset/img/404.jpeg') }}";

        function updateStatus(status) {
            if (status === 'connected') {
                STATUS_BADGE.classList.remove('bg-secondary');
                STATUS_BADGE.classList.add('bg-success');
                STATUS_BADGE.textContent = 'Connected';

                QR_IMG.src = CONNECTED_IMG;
                QR_IMG.style.display = 'block';
                QR_PLACEHOLDER.style.display = 'none';
            } else {
                STATUS_BADGE.classList.remove('bg-success');
                STATUS_BADGE.classList.add('bg-secondary');
                STATUS_BADGE.textContent = 'Disconnected';
            }
        }


        async function fetchQRAndStatus() {
            try {
                const res = await fetch(
                    `https://botadorawedding.test/qr?wa_session_id=${WA_SESSION_ID}`
                );

                const data = await res.json();

                if (data.status === 'connected') {
                    updateStatus('connected');
                    return;
                }

                if (data.qr) {
                    QR_IMG.src = data.qr;
                    QR_IMG.style.display = 'block';
                    QR_PLACEHOLDER.style.display = 'none';
                } else {
                    QR_IMG.style.display = 'none';
                    QR_PLACEHOLDER.style.display = 'block';
                }

                updateStatus(data.status);
            } catch (err) {
                console.error("Gagal memuat status WA:", err);
            }
        }


        fetchQRAndStatus();
        const qrInterval = setInterval(fetchQRAndStatus, 5000);

        REFRESH_BTN.addEventListener('click', async function() {
            this.disabled = true;
            this.innerHTML =
                '<span class="spinner-border spinner-border-sm me-2"></span>Loading...';

            await fetchQRAndStatus();

            this.disabled = false;
            this.innerHTML =
                '<i class="bi bi-arrow-repeat me-2"></i> Regenerate QR';
        });
    </script>
@endpush
