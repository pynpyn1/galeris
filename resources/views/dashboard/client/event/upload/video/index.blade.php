@extends('dashboard.layouts.app-event')

@section('title', 'Kelola Video')

@section('content')
    @include('dashboard.client.event.upload.video.partials.storage_warning')

    @include('dashboard.client.event.upload.video.partials.video')

@endsection

@push('styles')
    <link rel="stylesheet" href="https://unpkg.com/dropzone@5/dist/min/dropzone.min.css" type="text/css" />
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />

    <style>
        .pagination {
            gap: 8px;
            align-items: center;
        }

        .page-item .page-link {
            border: none;
            border-radius: 12px;
            padding: 10px 18px;
            color: #64748b;
            background-color: #ffffff;
            font-weight: 600;
            font-size: 0.9rem;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.04);
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            position: relative;
        }

        .page-item:not(.active):not(.disabled) .page-link:hover {
            color: #435ebf;
            background-color: #ffffff;
            transform: translateY(-3px);
            box-shadow: 0 8px 15px rgba(67, 94, 191, 0.1);
        }

        .page-item.active .page-link {
            background: #435ebf;
            color: #ffffff;
            box-shadow: 0 4px 12px rgba(67, 94, 191, 0.35);
            /* Glow effect */
            transform: scale(1.05);
        }

        .page-item.disabled .page-link {
            color: #cbd5e1;
            background-color: #f8fafc;
            box-shadow: none;
            cursor: not-allowed;
            opacity: 0.7;
        }

        @media (max-width: 576px) {
            .page-item .page-link {
                padding: 8px 12px;
                font-size: 0.8rem;
            }
        }


        .gallery-thumb {
            object-fit: cover;
            image-rendering: -webkit-optimize-contrast;
            filter: saturate(0.95) contrast(0.95);
            transition: transform 0.3s ease, filter 0.3s ease;
            will-change: transform;
        }

        .gallery-thumb:hover {
            transform: scale(1.05);
            filter: none;
        }

        .select2-container--default .select2-selection--single {
            height: 38px;
            padding: 5px 10px;
            border-radius: 6px;
            border: 1px solid #ced4da;
        }

        .select2-selection__rendered {
            line-height: 26px !important;
        }

        .select2-selection__arrow {
            height: 36px !important;
        }

        .modern-dropzone {
            border: 2px dashed #cbd5e1;
            border-radius: 12px;
            background: #f8fafc;
            min-height: 200px;
            padding: 10px;
            display: flex;
            flex-wrap: wrap;
            justify-content: flex-start;
            align-items: flex-start;
            gap: 10px;
            transition: all 0.3s ease;
        }

        .modern-dropzone:hover {
            border-color: #435ebf;
            background: #eff6ff;
        }

        .modern-dropzone .dz-message {
            width: 100%;
            margin: 2em 0;
            order: -1;
        }

        .modern-dropzone.dz-started .dz-message {
            display: none;
        }

        .dropzone .dz-preview {
            background: transparent;
            position: relative;
            z-index: 10;
            margin: 0 !important;
            width: calc(50% - 5px);
            flex: 0 0 calc(50% - 5px);
            min-height: auto;
        }

        .dropzone .dz-preview .dz-image {
            width: 100% !important;
            height: 0 !important;
            padding-bottom: 100%;
            border-radius: 12px;
            overflow: hidden;
            position: relative;
        }

        .dropzone .dz-preview .dz-image img {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .dropzone .dz-preview .dz-progress {
            background: rgba(0, 0, 0, 0.5);
            height: 8px;
            border-radius: 10px;
            position: absolute;
            top: auto !important;
            bottom: 15px !important;
            left: 50% !important;
            transform: translateX(-50%) !important;
            margin-left: 0 !important;
            width: 80%;
            opacity: 0;
            transition: opacity 0.3s ease;
            z-index: 20;
            pointer-events: none;
        }

        .dropzone .dz-preview.is-uploading .dz-progress {
            opacity: 1;
        }

        .dropzone .dz-preview .dz-progress .dz-upload {
            background: #22c55e;
            background: linear-gradient(to right, #22c55e, #4ade80);
            display: block;
            height: 100%;
            width: 0%;
            border-radius: 10px;
            transition: width 0.3s linear;
        }

        .dropzone .dz-preview .dz-remove {
            position: absolute;
            top: 5px;
            right: 5px;
            z-index: 30;
            color: #ef4444;
            background: rgba(255, 255, 255, 0.9);
            border-radius: 5%;
            width: 24px;
            height: 24px;
            display: flex;
            align-items: center;
            justify-content: center;
            text-decoration: none;
            cursor: pointer;
            border: none;
            transition: all 0.2s;
            margin: 0;
            padding: 0;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        .dropzone .dz-preview .dz-remove:hover {
            background: #ef4444;
            color: white;
            transform: scale(1.1);
        }

        .dropzone .dz-preview .dz-success-mark,
        .dropzone .dz-preview .dz-error-mark {
            display: none;
        }

        @keyframes uploadPulse {
            0% {
                box-shadow: 0 0 0 0 rgba(34, 197, 94, 0.7);
                transform: scale(1);
            }

            50% {
                box-shadow: 0 0 0 5px rgba(34, 197, 94, 0);
                transform: scale(0.98);
            }

            100% {
                box-shadow: 0 0 0 0 rgba(34, 197, 94, 0);
                transform: scale(1);
            }
        }

        .dz-preview.upload-active .dz-image {
            animation: uploadPulse 1.5s infinite;
            border: 2px solid #22c55e;
            opacity: 0.8;
        }

        @media (min-width: 768px) {
            .dropzone .dz-preview {
                width: 140px;
                flex: 0 0 auto;
            }

            .dropzone .dz-preview .dz-image {
                height: 140px !important;
                padding-bottom: 0;
            }
        }
    </style>
@endpush

@push('scripts')
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://unpkg.com/dropzone@5/dist/min/dropzone.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
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
        document.addEventListener("DOMContentLoaded", function() {
            $('#sort-select').select2({
                minimumResultsForSearch: Infinity,
                width: 'resolve'
            });

            $('#sort-select').on('change', function() {
                document.getElementById('sort-form').submit();
            });
        });

        Dropzone.autoDiscover = false;

        document.addEventListener("DOMContentLoaded", function() {

            const MAX_MB = 1024;
            const form = document.getElementById('my-dropzone-form');
            const submitBtn = document.getElementById('submit-all');
            const submitText = document.getElementById('submit-text');
            const submitLoading = document.getElementById('submit-loading');

            const myDropzone = new Dropzone("#myDropzone", {
                url: "#",
                autoProcessQueue: false,
                uploadMultiple: true,
                parallelUploads: 5,
                maxFiles: 5,
                acceptedFiles: "video/*",
                addRemoveLinks: true,
                dictRemoveFile: `<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg>`,
                clickable: true,
                thumbnailWidth: 300,
                thumbnailHeight: 300,
            });

            myDropzone.on("addedfile", function(file) {
                if (file.size > MAX_MB * 1024 * 1024) {
                    showToast(`Ukuran video maksimal ${MAX_MB}MB`, 'error');
                    myDropzone.removeFile(file);
                }
            });

            form.addEventListener('submit', function(e) {
                e.preventDefault();

                const files = myDropzone.getAcceptedFiles();

                if (files.length === 0) {
                    showToast("Silakan pilih minimal satu video!", "warning");
                    return;
                }

                submitBtn.disabled = true;
                submitText.classList.add('d-none');
                submitLoading.classList.remove('d-none');

                const previews = document.querySelectorAll('.dz-preview');
                previews.forEach(el => {
                    el.classList.add('upload-active');
                    el.classList.add('is-uploading');
                });

                const formData = new FormData(form);
                files.forEach(file => {
                    formData.append('videos[]', file);
                });

                const xhr = new XMLHttpRequest();
                xhr.open("POST", form.action, true);
                xhr.setRequestHeader('X-CSRF-TOKEN', document.querySelector('input[name="_token"]').value);

                xhr.upload.onprogress = function(e) {
                    if (e.lengthComputable) {
                        const percent = Math.round((e.loaded / e.total) * 100);
                        const progressBars = document.querySelectorAll('.dz-upload');
                        progressBars.forEach(bar => {
                            bar.style.width = percent + "%";
                        });
                    }
                };

                xhr.onload = function() {
                    previews.forEach(el => {
                        el.classList.remove('upload-active');
                        el.classList.remove('is-uploading');
                    });

                    if (xhr.status === 200) {
                        showToast('Upload berhasil!', 'success');
                        setTimeout(() => {
                            window.location.reload();
                        }, 800);
                    } else if (xhr.status === 413) {
                        showToast('Ukuran file terlalu besar!', 'error');
                        resetButton();
                    } else {
                        showToast('Upload gagal!', 'error');
                        resetButton();
                    }
                };

                xhr.onerror = function() {
                    showToast('Terjadi kesalahan jaringan!', 'error');
                    resetButton();
                    previews.forEach(el => el.classList.remove('upload-active'));
                };

                xhr.send(formData);
            });

            function resetButton() {
                submitBtn.disabled = false;
                submitText.classList.remove('d-none');
                submitLoading.classList.add('d-none');
            }
        });
    </script>
    <script>
        function deleteAllConfirm() {
            Swal.fire({
                title: 'Hapus semua video?',
                text: 'Semua video dalam folder ini akan dihapus permanen!',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Ya, Hapus Semua',
                cancelButtonText: 'Batal',
                reverseButtons: true,
                confirmButtonColor: '#dc3545',
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById('delete-all-form').submit();
                }
            });
        }

        function deletevideoConfirm(button) {
            Swal.fire({
                title: 'Hapus video?',
                text: 'Video ini akan dihapus permanen.',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Ya, Hapus',
                cancelButtonText: 'Batal',
                reverseButtons: true,
                confirmButtonColor: '#dc3545',
            }).then((result) => {
                if (result.isConfirmed) {
                    button.closest('form').submit();
                }
            });
        }
    </script>
@endpush
