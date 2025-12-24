@extends('dashboard.layouts.app')

@section('title', 'Invoice Manage')
@section('name_header', 'Invoice Manage')

@section('content')

    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <section class="section">
        <div class="card">
            <div class="card-body">
                <table class="table table-striped table-hover responsive" id="invoiceTable" style="width:100%">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>No. Invoice</th>
                            <th>Customer</th>
                            <th>Package</th>
                            <th>Total</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
    </section>


    <div class="modal fade" id="statusModal" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <form id="statusForm" action="javascript:void(0)">
                @csrf
                @method('PUT')

                <input type="hidden" id="invoice_number">

                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Invoice</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>

                    <div class="modal-body">
                        <div class="row g-3">

                            <div id="paymentProofWrapper" class="col-md-6 d-none">
                                <label class="form-label fw-semibold">Bukti Pembayaran</label>

                                <div class="border rounded p-2 text-center bg-light">
                                    <img id="paymentProofImage" src="" alt="Bukti Pembayaran"
                                        class="img-fluid rounded shadow-sm cursor-pointer" style="max-height:320px"
                                        onclick="window.open(this.src, '_blank')">
                                </div>

                                <small class="text-muted d-block mt-2 text-center">
                                    Klik gambar untuk memperbesar
                                </small>
                            </div>

                            <div id="formWrapper" class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label fw-semibold">Status Pembayaran</label>
                                    <select class="form-select" name="payment_status" id="payment_status"
                                        style="width:100%">
                                        <option value="paid">Diterima</option>
                                        <option value="rejected">Ditolak</option>
                                    </select>
                                </div>

                                <div class="mb-3">
                                    <label class="form-label fw-semibold">Catatan / Pesan</label>
                                    <textarea class="form-control" name="note" id="note" rows="4" value="Pembayaran telah diverifikasi admin"></textarea>
                                </div>
                            </div>

                        </div>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-outline-primary" data-bs-dismiss="modal">
                            Cancel
                        </button>
                        <button type="submit" class="btn btn-primary">
                            Submit
                        </button>
                    </div>
                </div>

            </form>
        </div>
    </div>

@endsection

@push('styles')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/responsive/3.0.0/css/responsive.bootstrap5.min.css">
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
@endpush

@push('scripts')
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdn.datatables.net/v/bs5/dt-2.0.8/datatables.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdn.datatables.net/responsive/3.0.0/js/dataTables.responsive.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>


    <script>
        $(document).ready(function() {

            $('#invoiceTable').DataTable({
                processing: true,
                serverSide: true,
                ajax: "{{ route('manage.invoice.data') }}",

                columns: [{
                        data: 'DT_RowIndex',
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: 'invoice',
                        name: 'invoice_number'
                    },
                    {
                        data: 'customer',
                        name: 'user.name'
                    },
                    {
                        data: 'package',
                        name: 'package.package_name'
                    },
                    {
                        data: 'price',
                        name: 'final_price'
                    },
                    {
                        data: 'status',
                        orderable: false,
                        searchable: false
                    },
                ],

            });
        });


        $(document).on('click', '.invoice-status', function() {

            let invoice = $(this).data('invoice');
            let status = $(this).data('status');
            let method = $(this).data('method');
            let proof = $(this).data('proof');
            let note = $(this).data('note');

            $('#invoice_number').val(invoice);
            $('#payment_status').val(status).trigger('change');

            if (note && note.length > 0) {
                $('#note').val(note);
            } else {
                $('#note').val(
                    status === 'paid' ?
                    'Invoice ini sudah diterima dan tidak dapat diubah.' :
                    'Pembayaran telah diverifikasi admin'
                );
            }

            $('#paymentProofWrapper').addClass('d-none');
            $('#paymentProofImage').attr('src', '');

            if (method === 'manual' && proof) {
                $('#paymentProofImage').attr('src', proof);
                $('#paymentProofWrapper').removeClass('d-none');
            }

            if (status === 'paid' || status === 'rejected') {
                $('#payment_status').prop('disabled', true);
                $('#note').prop('disabled', true);
                $('#statusForm button[type="submit"]').prop('disabled', true);
            } else {
                $('#payment_status').prop('disabled', false);
                $('#note').prop('disabled', false);
                $('#statusForm button[type="submit"]').prop('disabled', false);
            }

            $('#statusModal').modal('show');
        });




        $('#payment_status').select2({
            dropdownParent: $('#statusModal'),
            width: '100%'
        });

        $('#statusForm').on('submit', function(e) {
            e.preventDefault();

            let invoice = $('#invoice_number').val();
            let status = $('#payment_status').val();
            let note = $('#note').val();

            $.ajax({
                url: '/manage/invoice/update/' + invoice,
                type: 'PUT',
                data: {
                    _token: $('meta[name="csrf-token"]').attr('content'),
                    payment_status: status,
                    note: note
                },
                success: function(res) {
                    $('#statusModal').modal('hide');
                    $('#invoiceTable').DataTable().ajax.reload(null, false);

                    Swal.fire({
                        icon: 'success',
                        title: 'Berhasil',
                        text: res.message
                    });

                    $('#note').val('');
                },
                error: function(xhr) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Gagal',
                        text: xhr.responseJSON?.message ?? 'Terjadi kesalahan'
                    });
                }
            });
        });
    </script>
@endpush
