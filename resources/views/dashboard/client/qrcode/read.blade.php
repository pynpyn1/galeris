@extends('dashboard.layouts.app')

@section('title', 'QR Manage')
@section('name_header', 'QR Manage')

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
                <a href="{{ route('qrcode.create') }}" class="btn btn-primary">Add QR</a>
            </div>
            <div class="card-body">

                <table class="table table-striped table-hover responsive" id="urlTable" style="width:100%">
                    <thead>
                        <tr>
                            <th>No.</th>
                            <th>Folder</th>
                            <th>URL</th>
                            <th>QR Code</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                </table>

            </div>
        </div>
    </section>

@endsection

@push('styles')
    <link rel="stylesheet" href="https://cdn.datatables.net/v/bs5/dt-2.0.8/datatables.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/responsive/3.0.0/css/responsive.bootstrap5.min.css">
@endpush

@push('scripts')
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdn.datatables.net/2.0.8/js/dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/v/bs5/dt-2.0.8/datatables.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdn.datatables.net/responsive/3.0.0/js/dataTables.responsive.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/3.0.0/js/responsive.bootstrap5.min.js"></script>
    <script>
        $(document).ready(function() {

            $('#urlTable').DataTable({
                processing: true,
                serverSide: true,

                ajax: {
                    url: "{{ route('qrcode.data') }}",
                    type: "GET"
                },

                columns: [{
                        data: 'DT_RowIndex',
                        orderable: false,
                        searchable: false,
                        width: '5%'
                    },
                    {
                        data: 'folder_name',
                        name: 'folder.name'
                    },
                    {
                        data: 'url',
                        name: 'url',
                        render: function(data, type, row) {
                            return data;
                        }
                    },
                    {
                        data: 'qr',
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: 'status',
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: 'action',
                        orderable: false,
                        searchable: false
                    }
                ],

                language: {
                    infoFiltered: "",
                    processing: "<button class='btn btn-lg btn-primary' disabled><span class='spinner-border spinner-border-sm'></span> Loading...</button>"
                }

            });

            $('#urlTable').on('click', '.delete-url-btn', function() {
                var id = $(this).data('id');

                Swal.fire({
                    title: "Hapus URL ini?",
                    text: "Data akan dipindahkan ke trash!",
                    icon: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#d33",
                    cancelButtonColor: "#6c757d",
                    confirmButtonText: "Ya, Hapus!",
                    cancelButtonText: "Batal"
                }).then((result) => {
                    if (result.isConfirmed) {
                        $('#delete-form-' + id).submit();
                    }
                });
            });

        });
    </script>
@endpush
