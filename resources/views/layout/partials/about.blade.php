    <style>
        /* CSS Kustom untuk About Section */
        #about {
            padding: 80px 0 0;
            /* Padding atas untuk konten utama */
            background-color: #fff;
            position: relative;
            overflow: hidden;
            /* Penting agar SVG curved tidak terpotong */
        }

        /* Styling Icon Emas */
        #about .icon-box {
            color: #C69A4D;
            /* Warna Emas untuk Ikon dan Judul */
            transition: 0.3s;
            padding: 20px;
        }

        #about .icon-box i,
        #about .icon-box svg {
            font-size: 50px;
            margin-bottom: 20px;
        }

        #about .icon-box h4 {
            font-weight: bold;
            color: #C69A4D;
            /* Warna Emas untuk Judul */
            margin-bottom: 15px;
        }

        #about .icon-box p {
            color: #555;
            font-size: 14px;
        }

        /* Styling Judul Utama */
        #about .main-title {
            color: #555;
            margin-bottom: 60px;
            font-size: 1.2rem;
        }

        /* CSS untuk Efek Melengkung (Curved Bottom) */
        .curved-bottom {
            position: absolute;
            bottom: 0;
            left: 0;
            width: 100%;
            line-height: 0;
            transform: rotate(180deg);
            /* Membalikkan kurva agar cekung ke bawah */
        }

        .curved-bottom svg {
            display: block;
        }

        .curved-bottom .shape-fill {
            fill: #000;
            /* Warna kurva di bagian bawah (sesuai screenshot: hitam) */
        }
    </style>

    <section id="about" style="height: 60vh !important;  ">
        <div class="container">
            <div class="row text-center mb-5">
                <div class="col-12">
                    <img src="{{ asset('asset/img/adora-logo.png') }}" alt="Adora Logo" class="mb-3"
                        style="height: 40px; filter: grayscale(100%) brightness(0) invert(1);">
                    <p class="main-title">
                        Adora Wedding berfokus pada keindahan visual yang akan dikenang selamanya
                    </p>
                </div>
            </div>

            <div class="row text-center">

                <div class="col-lg-3 col-md-6 mb-4">
                    <div class="icon-box">
                        <i class="bi bi-camera"></i>
                        <h4>Fotografi Premium</h4>
                        <p>Setiap momen ditangkap dengan estetika lembut & penuh rasa.</p>
                    </div>
                </div>

                <div class="col-lg-3 col-md-6 mb-4">
                    <div class="icon-box">
                        <i class="bi bi-qr-code-scan"></i>
                        <h4>Barcode Scan Gallery</h4>
                        <p>Tamu dapat langsung men-scan barcode dan mengunduh foto mereka secara real-time.</p>
                    </div>
                </div>

                <div class="col-lg-3 col-md-6 mb-4">
                    <div class="icon-box">
                        <i class="bi bi-heart"></i>
                        <h4>Pengalaman Tamu Lebih Personal</h4>
                        <p>Setiap momen ditangkap dengan estetika lembut & penuh rasa.</p>
                    </div>
                </div>

                <div class="col-lg-3 col-md-6 mb-4">
                    <div class="icon-box">
                        <i class="bi bi-currency-dollar"></i>
                        <h4>Harga Terjangkau</h4>
                        <p>Kualitas tetap elegan dengan penawaran paket yang sesuai kebutuhan dan anggaran mahasiswa
                            sekalipun.</p>
                    </div>
                </div>
            </div>
        </div>

    </section>
