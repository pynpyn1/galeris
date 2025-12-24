@extends('dashboard.layouts.app')

@section('title', 'Discount Management')

@push('styles')
    <link rel="stylesheet" href="https://cdn.datatables.net/v/bs5/dt-2.0.8/datatables.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/responsive/3.0.0/css/responsive.bootstrap5.min.css">
    <style>
        /* Modern Soft Badges */
        .badge.bg-light-success {
            background-color: #e8fadf;
            color: #71dd37;
        }

        .badge.bg-light-danger {
            background-color: #ffe5e5;
            color: #ff3e1d;
        }

        .badge.bg-light-warning {
            background-color: #fff2d6;
            color: #ffab00;
        }

        /* Modern Button Styles */
        .btn-light-warning {
            background: #fff2d6;
            color: #ffab00;
            border: none;
        }

        .btn-light-danger {
            background: #ffe5e5;
            color: #ff3e1d;
            border: none;
        }

        .btn-light-warning:hover {
            background: #ffab00;
            color: #fff;
        }

        .btn-light-danger:hover {
            background: #ff3e1d;
            color: #fff;
        }

        .table thead th {
            text-transform: uppercase;
            font-size: 0.85rem;
            letter-spacing: 0.5px;
        }
    </style>
@endpush

@section('content')
    <div class="page-heading d-flex justify-content-between align-items-center mb-3">
        <h3>Discount Codes</h3>
        <a href="{{ route('manage.discount.create') }}" class="btn btn-primary shadow-sm">
            <i class="bi bi-plus-lg"></i> Add New Discount
        </a>
    </div>

    <section class="section">
        <div class="card border-0 shadow-sm">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover align-middle" id="serverSideTable" style="width:100%">
                        <thead class="table-light">
                            <tr>
                                <th width="5%">No</th>
                                <th>Code</th>
                                <th>Type</th>
                                <th>Value</th>
                                <th>Quota</th>
                                <th>Status</th>
                                <th width="15%">Action</th>
                            </tr>
                        </thead>
                        <tbody></tbody>
                    </table>
                </div>
            </div>
        </div>
    </section>
@endsection

@push('scripts')
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdn.datatables.net/v/bs5/dt-2.0.8/datatables.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        $(function() {
            $('#serverSideTable').DataTable({
                processing: true,
                serverSide: true,
                responsive: true,
                ajax: "{{ route('manage.discount.data') }}",
                columns: [{
                        data: 'DT_RowIndex',
                        name: 'DT_RowIndex',
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: 'code',
                        render: function(data) {
                            return `<span class="fw-bold text-primary">${data}</span>`;
                        }
                    },
                    {
                        data: 'type'
                    },
                    {
                        data: 'value',
                        className: 'fw-bold'
                    },
                    {
                        data: 'quota'
                    },
                    {
                        data: 'is_active'
                    },
                    {
                        data: 'action',
                        orderable: false,
                        searchable: false
                    }
                ],
                language: {
                    search: "_INPUT_",
                    searchPlaceholder: "Search records...",
                }
            });
        });

        function deleteData(id) {
            Swal.fire({
                title: 'Are you sure?',
                text: "You won't be able to revert this!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#ff3e1d',
                cancelButtonColor: '#8592a3',
                confirmButtonText: 'Yes, delete it!',
                customClass: {
                    confirmButton: 'btn btn-danger me-2',
                    cancelButton: 'btn btn-secondary'
                },
                buttonsStyling: false
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: `/manage/discount/delete/${id}`,
                        type: 'DELETE',
                        data: {
                            _token: "{{ csrf_token() }}"
                        },
                        success: function(res) {
                            Swal.fire('Deleted!', 'Discount has been deleted.', 'success');
                            $('#serverSideTable').DataTable().ajax.reload();
                        }
                    });
                }
            });
        }
    </script>
@endpush
