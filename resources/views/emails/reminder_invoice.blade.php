<!DOCTYPE html>
<html lang="id">

<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <style>
        /* Base styles */
        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Helvetica, Arial, sans-serif;
            background-color: #edf2f7;
            color: #718096;
            margin: 0;
            padding: 0;
            width: 100% !important;
            -webkit-text-size-adjust: none;
            /* Mencegah font membesar otomatis di iOS */
        }

        .content {
            max-width: 570px;
            margin: 0 auto;
            padding: 0;
            text-align: left;
            /* Reset text align agar isi card tetap rata kiri */
        }

        /* Card Style */
        .card {
            background-color: #ffffff;
            border-radius: 4px;
            /* Sedikit lebih rounded */
            border: 1px solid #e8e5ef;
            padding: 32px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.05);
        }

        /* Typography */
        h1 {
            color: #3d4852;
            font-size: 19px;
            font-weight: bold;
            margin-top: 0;
            text-align: left;
        }

        p {
            font-size: 16px;
            line-height: 1.6em;
            margin-top: 0;
            color: #3d4852;
        }

        /* Custom Highlight Box */
        .summary-box {
            background-color: #f8fafc;
            /* Sedikit lebih biru-abu muda */
            border: 1px solid #e2e8f0;
            border-radius: 6px;
            padding: 20px;
            margin: 25px 0;
            text-align: center;
        }

        .amount {
            color: #435ebf;
            /* Palette Utama */
            font-size: 26px;
            font-weight: 800;
            display: block;
            margin-top: 8px;
        }

        .date {
            font-size: 13px;
            color: #64748b;
            text-transform: uppercase;
            font-weight: 600;
            letter-spacing: 0.5px;
        }

        /* Button Style */
        .btn-wrapper {
            text-align: center;
            margin-top: 30px;
        }

        .btn {
            background-color: #435ebf;
            color: #ffffff;
            display: inline-block;
            padding: 12px 30px;
            border-radius: 6px;
            text-decoration: none;
            font-weight: bold;
            font-size: 16px;
            box-shadow: 0 2px 4px rgba(67, 94, 191, 0.3);
            /* Shadow halus sesuai warna */
        }

        .btn:hover {
            background-color: #364b99;
        }

        /* Footer */
        .footer {
            text-align: center;
            width: 100%;
            margin-top: 25px;
            font-size: 12px;
            color: #b0adc5;
        }

        /* Utility */
        a {
            color: #3d4852;
            text-decoration: none;
        }
    </style>
</head>

<body style="background-color: #edf2f7;">

    <table width="100%" cellpadding="0" cellspacing="0" role="presentation"
        style="background-color: #edf2f7; width: 100%;">
        <tr>
            <td align="center" style="padding: 30px 0;">

                <div class="content">

                    <div style="text-align: center; padding-bottom: 25px;">
                        <a href="{{ url('/') }}" style="font-size: 20px; font-weight: bold; color: #435ebf;">
                            {{ config('app.name') }}
                        </a>
                    </div>

                    <div class="card">
                        <h1>Halo, {{ $purchase->user->name }}</h1>

                        <p>
                            Invoice <strong>#{{ $purchase->invoice_number }}</strong> Anda akan segera jatuh tempo.
                            Berikut adalah rinciannya:
                        </p>

                        <div class="summary-box">
                            <span class="date">Jatuh Tempo:
                                {{ $purchase->next_payment_due_at->format('d M Y') }}</span>
                            <span class="amount">Rp{{ number_format($purchase->final_price, 0, ',', '.') }}</span>
                        </div>

                        <p>
                            Mohon selesaikan pembayaran sebelum tanggal tersebut agar layanan Anda tetap aktif.
                        </p>

                        <div class="btn-wrapper">
                            <a href="{{ route('home.checkout.show', $purchase) }}" class="btn">
                                Lihat Tagihan
                            </a>
                        </div>

                        <p
                            style="margin-top: 30px; font-size: 14px; border-top: 1px solid #eeeeee; padding-top: 20px; color: #718096;">
                            Salam,<br>
                            <strong>{{ config('app.name') }}</strong>
                        </p>
                    </div>

                    <div class="footer">
                        &copy; {{ date('Y') }} {{ config('app.name') }}. All rights reserved.
                    </div>

                </div>
            </td>
        </tr>
    </table>

</body>

</html>
