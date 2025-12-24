@extends('dashboard.layouts.app')

@section('title', 'Foto Manage')
@section('name_header', 'Foto Manage')

@section('content')

    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    @if (session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif


    @if ($errors->any())
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <strong>Gagal Menyimpan!</strong> Silakan periksa kembali input Anda.

            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>

            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <section class="section">
        <div class="card">
            <div class="card-header">
                {{-- Mengganti route ke manage.photo.create dan label ke Add Photo --}}
                <a href="{{ route('manage.photo.create') }}" class="btn btn-primary">Add Photo</a>
            </div>
            <div class="card-body">
                <table class="table table-striped table-hover responsive" id="serverSideTable" style="width:100%">
                    <thead>
                        <tr>
                            <th>No.</th>
                            {{-- Kolom disesuaikan untuk Foto --}}
                            <th>Folder</th>
                            <th>Foto</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
            </div>
        </div>

    </section>
    <!-- Modal Preview Foto -->
    <div class="modal fade" id="photoModal" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">

                <div class="modal-body p-0">
                    <div id="photoCarousel" class="carousel slide" data-bs-ride="carousel">
                        <div class="carousel-inner" id="carouselPhotos"></div>

                        <button class="carousel-control-prev bg-transparent" type="button" data-bs-target="#photoCarousel"
                            data-bs-slide="prev">
                            <span class="carousel-control-prev-icon"></span>
                        </button>

                        <button class="carousel-control-next bg-transparent" type="button" data-bs-target="#photoCarousel"
                            data-bs-slide="next">
                            <span class="carousel-control-next-icon"></span>
                        </button>

                    </div>
                </div>

            </div>
        </div>
    </div>


@endsection

@push('styles')
    <link rel="stylesheet" href="https://cdn.datatables.net/v/bs5/dt-2.0.8/datatables.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/responsive/3.0.0/css/responsive.bootstrap5.min.css">

    <style>
        .modal-backdrop.show {
            opacity: 0.7 !important;
        }


        .carousel-control-prev,
        .carousel-control-next {
            width: 8%;
            opacity: 1 !important;
            border: 0;
        }

        .carousel-control-prev-icon,
        .carousel-control-next-icon {
            background-image: none !important;
            width: 60px;
            height: 60px;
        }

        .carousel-control-prev-icon::after {
            content: '‹';
            font-size: 60px;
            color: white;
            font-weight: bold;
        }

        .carousel-control-next-icon::after {
            content: '›';
            font-size: 60px;
            color: white;
            font-weight: bold;
        }

        .carousel-control-prev:hover,
        .carousel-control-next:hover {
            opacity: 1;
            transform: scale(1.1);
            transition: 0.2s;
        }

        #photoCarousel {
            position: relative;
        }

        .carousel-control-prev {
            left: -60px;
        }

        .carousel-control-next {
            right: -60px;
        }

        .modal-dialog.modal-lg {
            max-width: 100%;
            width: 80%;
        }

        .modal-body {
            background: black;
        }
    </style>
@endpush

@push('scripts')
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdn.datatables.net/2.0.8/js/dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/v/bs5/dt-2.0.8/datatables.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script src="https://cdn.datatables.net/responsive/3.0.0/js/dataTables.responsive.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/3.0.0/js/responsive.bootstrap5.min.js"></script>

    <script>
        $(document).on('click', '.photo-stack', function() {
            let photos = $(this).data('photos');

            let html = "";
            photos.forEach((src, i) => {
                html += `
            <div class="carousel-item ${i === 0 ? 'active' : ''}">
                <img src="${src}" class="d-block w-100" style="object-fit:contain; height:80vh;">
            </div>
        `;
            });

            $("#carouselPhotos").html(html);

            let myModal = new bootstrap.Modal(document.getElementById('photoModal'));
            myModal.show();
        });

        $(document).ready(function() {
            $('#serverSideTable').DataTable({
                processing: true,
                serverSide: true,

                ajax: {
                    url: "{{ route('manage.photo.data') }}",
                    type: "GET"
                },

                columns: [{
                        data: 'DT_RowIndex',
                        name: 'DT_RowIndex',
                        orderable: false,
                        searchable: false,
                        width: '5%'
                    },
                    {
                        data: 'folder_name',
                        name: 'folder_name'
                    },
                    {
                        data: 'file_path',
                        name: 'file_path'
                    },
                    {
                        data: 'status',
                        name: 'status',
                        orderable: false,
                        searchable: false
                    }, {
                        data: 'action',
                        name: 'action',
                        orderable: false,
                        searchable: false
                    }
                ],

                language: {
                    infoFiltered: "",
                    processing: "<button class='btn btn-lg btn-primary' type='button' disabled><span class='spinner-border spinner-border-sm' role='status' aria-hidden='true'></span> Loading...</button>"
                }

            });

            $('#serverSideTable').on('click', '.delete-photo-btn', function() {
                var photoId = $(this).data('id');

                Swal.fire({
                    title: "Apakah Anda Yakin?",
                    text: "Anda tidak akan dapat mengembalikan foto ini!",
                    icon: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#d33",
                    cancelButtonColor: "#6c757d",
                    confirmButtonText: "Ya, Hapus!",
                    cancelButtonText: "Batal"
                }).then((result) => {
                    if (result.isConfirmed) {
                        $('#delete-form-' + photoId).submit();
                    }
                });
            });
        });
    </script>
@endpush
