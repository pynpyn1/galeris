@extends('dashboard.layouts.app-event')

@section('title', 'Kelola Photo')

@section('content')
    <div class="row justify-content-center mb-4">
        <div class="col-md-8">
            @include('dashboard.client.event.upload.photo.partials.warning')
        </div>
    </div>
    @include('dashboard.client.event.upload.photo.partials.storage_warning')



    @include('dashboard.client.event.upload.photo.partials.foto')

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
            border-radius: 10px;
            background: #f8fafc;
            min-height: 220px;
            padding: 20px;
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
            align-items: center;
            align-content: center;
            gap: 15px;

            transition: all 0.3s ease;
            position: relative;
        }

        .modern-dropzone:hover {
            border-color: #3b82f6;
            background: #eff6ff;
        }

        .modern-dropzone .dz-message {
            width: 100%;
            text-align: center;
            margin: 2em 0;
        }

        /* Styling Preview Dropzone */
        .dropzone .dz-preview {
            background: transparent;
            margin: 0 !important;
        }

        .dropzone .dz-preview .dz-image {
            width: 120px;
            height: 120px;
            border-radius: 8px;
            overflow: hidden;
        }

        .dropzone .dz-preview .dz-image img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .dropzone .dz-preview .dz-remove {
            margin-top: 8px;
            color: #dc3545;
            text-decoration: none;
            font-weight: 600;
            font-size: 0.85rem;
            display: block;
            text-align: center;
            cursor: pointer;
            border: 1px solid #dc3545;
            border-radius: 4px;
            padding: 2px 5px;
            background: white;
        }

        .dropzone .dz-preview .dz-remove:hover {
            background: #dc3545;
            color: white;
            text-decoration: none;
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

            const myDropzone = new Dropzone("#myDropzone", {
                url: "#",
                autoProcessQueue: false,
                uploadMultiple: true,
                addRemoveLinks: true,
                parallelUploads: 50,
                maxFiles: 50,
                acceptedFiles: ".jpeg,.jpg,.png,.webp",
                dictRemoveFile: "Batal",
            });

            const form = document.getElementById('my-dropzone-form');

            form.addEventListener('submit', function(e) {
                e.preventDefault();

                if (myDropzone.getAcceptedFiles().length === 0) {
                    alert("Silakan pilih minimal satu foto!");
                    return;
                }

                const files = myDropzone.getAcceptedFiles();

                const dataTransfer = new DataTransfer();

                files.forEach(file => {
                    dataTransfer.items.add(file);
                });

                const fileInput = document.createElement("input");
                fileInput.type = "file";
                fileInput.name = "photos[]";
                fileInput.multiple = true;
                fileInput.style.display = "none";
                fileInput.files = dataTransfer.files;
                form.appendChild(fileInput);
                form.submit();
            });
        });
    </script>
    <script>
        function deleteAllConfirm() {
            Swal.fire({
                title: 'Hapus semua foto?',
                text: 'Semua foto dalam folder ini akan dihapus permanen!',
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

        function deletePhotoConfirm(button) {
            Swal.fire({
                title: 'Hapus foto?',
                text: 'Foto ini akan dihapus permanen.',
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
