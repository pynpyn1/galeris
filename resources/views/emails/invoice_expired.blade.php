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
        }

        .content {
            max-width: 570px;
            margin: 0 auto;
            padding: 0;
            text-align: left;
        }

        /* Card Style */
        .card {
            background-color: #ffffff;
            border-radius: 4px;
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
            border: 1px solid #e2e8f0;
            border-radius: 6px;
            padding: 20px;
            margin: 25px 0;
            text-align: center;
        }

        .amount {
            color: #435ebf;
            /* Palette Utama */
            font-size: 24px;
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

        .sub-text {
            display: block;
            margin-top: 5px;
            font-size: 14px;
            color: #718096;
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
                        <h1>Halo, {{ $userName }}</h1>

                        <p>
                            Mohon maaf, invoice Anda telah kadaluarsa karena batas waktu pembayaran telah berakhir.
                        </p>

                        <div class="summary-box">
                            <span class="date">Invoice Kadaluarsa</span>
                            <span class="amount">#{{ $invoiceNumber }}</span>
                            <span class="sub-text">Nominal: Rp {{ $amount }}</span>
                        </div>

                        <p>
                            Jika Anda ingin melanjutkan layanan, silakan buat invoice baru melalui aplikasi kami dengan
                            menekan tombol di bawah ini.
                        </p>

                        <div class="btn-wrapper">
                            <a href="{{ route('home.subscribe') }}" class="btn">
                                Berlangganan Disini
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
