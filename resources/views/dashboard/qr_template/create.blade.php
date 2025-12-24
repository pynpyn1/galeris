@extends('dashboard.layouts.app')

@section('title', 'Add QR Template')
@section('name_header', 'Add QR Template')

@section('breadcrumbs')
    <?php
    $breadcrumbs = [['name' => 'QR Template Manage', 'link' => route('manage.qr_template.index')]];
    ?>
@endsection

@section('content')

    <section id="multiple-column-form">
        <div class="row match-height">
            <div class="col-12">
                <div class="card">

                    <div class="card-header">
                        <h4 class="card-title">Create New QR Template</h4>
                    </div>

                    <div class="card-content">
                        <div class="card-body">
                            <form method="POST" action="{{ route('manage.qr_template.store') }}"
                                enctype="multipart/form-data" id="qrTemplateForm">
                                @csrf

                                <div class="row mb-3">
                                    <div class="col-md-6">
                                        <label>Template Name</label>
                                        <input type="text" name="name_template" class="form-control" required>
                                    </div>

                                    <div class="col-md-6">
                                        <label>Status</label>
                                        <select name="is_active" class="form-control" required>
                                            <option value="1">Active</option>
                                            <option value="0">Inactive</option>
                                        </select>
                                    </div>
                                </div>

                                {{-- DROPZONE AREA ONLY --}}
                                <div id="qrTemplateDropzone" class="dropzone dropzone-area">
                                    <div class="dz-message">
                                        <h5>Drag & Drop QR Template di sini</h5>
                                        <p>PNG / JPG / SVG</p>
                                    </div>
                                </div>

                                <div class="text-end mt-3">
                                    <button type="submit" class="btn btn-primary">
                                        Save QR Template
                                    </button>
                                </div>
                            </form>


                        </div>
                    </div>

                </div>
            </div>
        </div>
    </section>

@endsection

@push('styles')
    <link rel="stylesheet" href="https://unpkg.com/dropzone@5/dist/min/dropzone.min.css">
    <style>
        /* === Dropzone Area Only === */
        .dropzone-area {
            border: 2px dashed #435ebe;
            border-radius: 12px;
            background: #f8f9ff;
            padding: 40px 20px;
            transition: all .3s ease;
        }

        .dropzone-area:hover {
            background: #eef1ff;
            border-color: #364fc7;
        }

        .dropzone-area.dz-drag-hover {
            border-color: #198754;
            background: #e6fff4;
        }

        /* Message */
        .dropzone-area .dz-message {
            text-align: center;
            color: #6c757d;
        }

        .dropzone-area .dz-message h5 {
            color: #364fc7;
            font-weight: 600;
        }

        .dropzone-area .dz-preview {
            border-radius: 10px;
            background: #fff;
            box-shadow: 0 4px 14px rgba(0, 0, 0, .06);
        }
    </style>
@endpush

@push('scripts')
    <script src="https://unpkg.com/dropzone@5/dist/min/dropzone.min.js"></script>
    <script>
        Dropzone.autoDiscover = false;

        let qrDropzone = new Dropzone("#qrTemplateDropzone", {
            url: "{{ route('manage.qr_template.store') }}",
            paramName: "files", // ⬅️ JANGAN pakai []
            uploadMultiple: true,
            parallelUploads: 10,
            maxFiles: 10,
            maxFilesize: 5,
            acceptedFiles: ".png,.jpg,.jpeg,.svg",
            autoProcessQueue: false,
            headers: {
                'X-CSRF-TOKEN': "{{ csrf_token() }}"
            }
        });

        document.querySelector("#qrTemplateForm").addEventListener("submit", function(e) {
            e.preventDefault();

            if (qrDropzone.files.length === 0) {
                alert("Silakan upload minimal 1 template");
                return;
            }

            qrDropzone.processQueue();
        });

        qrDropzone.on("sending", function(file, xhr, formData) {
            formData.append("name_template", document.querySelector("[name=name_template]").value);
            formData.append("is_active", document.querySelector("[name=is_active]").value);
        });

        qrDropzone.on("success", function() {
            window.location.href = "{{ route('manage.qr_template.index') }}";
        });
    </script>
@endpush
