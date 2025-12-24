@extends('dashboard.layouts.app')

@section('content')
    <h4>Invoice: {{ $purchase->invoice_number }}</h4>
    <h5>Total: Rp {{ number_format($purchase->final_price) }}</h5>

    <button id="pay-button" class="btn btn-primary">Bayar dengan Midtrans</button>

    <script src="https://app.sandbox.midtrans.com/snap/snap.js"
        data-client-key="{{ config('services.midtrans.client_key') }}"></script>
    <script>
        document.getElementById('pay-button').onclick = function() {
            snap.pay('{{ $snapToken }}', {
                onSuccess: function(result) {
                    window.location.href = "{{ route('home.subscribe') }}";
                },
                onPending: function(result) {
                    window.location.href = "{{ route('home.subscribe') }}";
                },
                onError: function(result) {
                    alert('Pembayaran gagal, coba lagi.');
                }
            });
        }
    </script>
@endsection
