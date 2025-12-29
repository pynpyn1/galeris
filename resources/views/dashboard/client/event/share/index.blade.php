@extends('dashboard.layouts.app-event')

@section('title', 'Share Event Link')

@section('content')
    <div class="row justify-content-center mt-4">
        {{-- Share Link --}}
        @include('dashboard.client.event.share.partials.share')

        {{-- Share QR --}}
        @include('dashboard.client.event.share.partials.shareqr')

        {{-- Remind Guest --}}
        @include('dashboard.client.event.share.partials.remind')

        {{-- Import Whatsapp --}}
        <section class="col-md-7 mt-4" id="importWhatsappSection">
            @include('dashboard.client.event.share.partials.import')
        </section>



    </div>



    {{-- Modal Edit QR --}}
    @include('dashboard.client.event.share.modal.edit')
@endsection


@push('scripts')
    <script src="https://unpkg.com/qr-code-styling@1.6.0/lib/qr-code-styling.js"></script>
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
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const toggle = document.getElementById('remindGuestToggle');
            const saveBtn = document.getElementById('saveRemindBtn');
            const importSection = document.getElementById('importWhatsappSection');

            if (!toggle || !saveBtn || !importSection) return;

            // Inisialisasi hide/show import
            importSection.style.display = toggle.checked ? 'block' : 'none';

            const initialState = toggle.checked;

            toggle.addEventListener('change', function() {
                saveBtn.disabled = toggle.checked === initialState;
                importSection.style.display = toggle.checked ? 'block' : 'none';
            });

            saveBtn.addEventListener('click', function() {
                saveBtn.disabled = true;

                fetch("{{ route('home.remind', $event->public_code) }}", {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                        body: JSON.stringify({
                            send_wa: toggle.checked ? 1 : 0
                        })
                    })
                    .then(res => res.json())
                    .then(data => {
                        if (data.success) {
                            showToast(data.message, 'success');
                            location.reload();
                        } else {
                            saveBtn.disabled = false;
                        }
                    })
                    .catch(err => {
                        console.error(err);
                        showToast('Gagal menyimpan pengaturan', 'error');
                        saveBtn.disabled = false;
                    });
            });
        });
    </script>
    <script>
        const qrData = "{{ $url }}";

        let qrCode = new QRCodeStyling({
            width: 200,
            height: 200,
            data: qrData,
            image: "",
            dotsOptions: {
                color: "#000000",
                type: "square"
            },
            backgroundOptions: {
                color: "#ffffff",
            },
            cornersSquareOptions: {
                type: "square"
            },
            cornersDotOptions: {
                type: "square"
            }
        });

        const previewContainer = document.getElementById("qr-code-preview-container");
        qrCode.append(previewContainer);

        function updateQR() {
            const style = document.querySelector('input[name="qr_style"]:checked').value;
            const eyeStyle = document.querySelector('input[name="qr_eye_style"]:checked').value;
            const fgColor = document.getElementById("fgColor").value;
            const bgColor = document.getElementById("bgColor").value;
            const errorLevel = document.getElementById("errorCorrection").value;

            let dotType = 'square';
            if (style === 'dot') {
                dotType = 'dots';
            } else if (style === 'fluid') {
                dotType = 'extra-rounded';
            }

            let cornerType = 'square';
            if (eyeStyle === 'round') {
                cornerType = 'extra-rounded';
            } else if (eyeStyle === 'soft_edge') {
                cornerType = 'dot';
            }

            qrCode.update({
                qrOptions: {
                    errorCorrectionLevel: document.getElementById('errorCorrection').value
                },

                dotsOptions: {
                    type: dotType,
                    color: fgColor,
                    animation: {
                        duration: 300,
                        easing: 'ease'
                    }
                },

                backgroundOptions: {
                    color: bgColor
                },
                cornersSquareOptions: {
                    type: cornerType
                },
                cornersDotOptions: {
                    type: cornerType
                }
            });
        }

        document.querySelectorAll('#qr-design-form input, #qr-design-form select').forEach(el => {
            el.addEventListener('change', updateQR);
            // showToast("Berhasil mengupdate", 'success');
        });





        const defaultQRConfig = {
            qr_style: 'square',
            qr_eye_style: 'square',
            fgColor: '#000000',
            bgColor: '#FFFFFF',
            errorCorrection: 'M'
        };


        function resetQR() {
            document.getElementById('styleSquare').checked = true;
            document.getElementById('eyeSquare').checked = true;
            document.getElementById('fgColor').value = defaultQRConfig.fgColor;
            document.getElementById('bgColor').value = defaultQRConfig.bgColor;
            document.getElementById('errorCorrection').value = defaultQRConfig.errorCorrection;

            qrCode.update({
                qrOptions: {
                    errorCorrectionLevel: defaultQRConfig.errorCorrection
                },
                dotsOptions: {
                    type: 'square',
                    color: defaultQRConfig.fgColor
                },
                backgroundOptions: {
                    color: defaultQRConfig.bgColor
                },
                cornersSquareOptions: {
                    type: 'square'
                },
                cornersDotOptions: {
                    type: 'square'
                }
            });
        }
    </script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {

            const resetBtn = document.getElementById('reset-qr-btn');
            if (resetBtn) {
                resetBtn.addEventListener('click', function() {
                    resetQR();
                });
            }

        });
    </script>

    <script>
        document.getElementById("save-qr-design-btn").addEventListener("click", function() {

            qrCode.getRawData("svg").then(blob => {
                let formData = new FormData();
                formData.append("qr_svg", blob);
                formData.append("_token", "{{ csrf_token() }}");

                fetch("{{ route('home.generate', $event->public_code) }}", {
                        method: "POST",
                        body: formData
                    })
                    .then(res => res.json())
                    .then(res => {
                        if (res.success) {
                            showToast("Berhasil mengupdate", 'success');
                            document.getElementById("current-qr-code").src = res.qr_url + '?' + Date
                                .now();
                            bootstrap.Modal.getInstance(document.getElementById('qrCodeEditModal'))
                                .hide();

                        }
                    });
            });
        });
    </script>


    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const toggle = document.getElementById('remindGuestToggle');
            const saveBtn = document.getElementById('saveRemindBtn');

            const initialState = toggle.checked;

            toggle.addEventListener('change', function() {
                if (toggle.checked !== initialState) {
                    saveBtn.disabled = false;
                } else {
                    saveBtn.disabled = true;
                }
            });

            saveBtn.addEventListener('click', function() {
                saveBtn.disabled = true;

                fetch("{{ route('home.remind', $event->public_code) }}", {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                        body: JSON.stringify({
                            send_wa: toggle.checked ? 1 : 0
                        })
                    })
                    .then(res => res.json())
                    .then(data => {
                        if (data.success) {
                            location.reload();
                        } else {
                            saveBtn.disabled = false;
                        }
                    })
                    .catch(err => {
                        console.error(err);
                        alert('Failed to save setting');
                        saveBtn.disabled = false;
                    });
            });
        });
    </script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const copyButton = document.getElementById('copy-button');
            const shareLinkInput = document.getElementById('share-link');

            copyButton.addEventListener('click', function() {
                shareLinkInput.select();
                shareLinkInput.setSelectionRange(0, 99999);

                navigator.clipboard.writeText(shareLinkInput.value).then(() => {
                    showToast('Link berhasil disalin!', 'success');
                }).catch(err => {
                    console.error('Gagal menyalin: ', err);
                    showToast('Gagal menyalin link', 'error');
                });
            });
        });
    </script>
@endpush
