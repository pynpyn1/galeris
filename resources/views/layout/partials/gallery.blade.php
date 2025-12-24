<section id="services"
    style="
        background-image: url('{{ asset('asset/img/hero1.jpg') }}');
        background-repeat: no-repeat;
        background-size: cover;
        background-position: center;
        position: relative;
        min-height: 600px;
    ">

    <style>
        /* CSS Kustom untuk Section Services */
        #services {
            position: relative;
            padding-top: 0;
            padding-bottom: 0;
            overflow: hidden;
            color: #fff;
        }

        /* Overlay untuk membuat gambar background lebih gelap */
        .content-overlay {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.4);
            z-index: 1;
            /* Lapisan paling bawah */
        }

        /* Styling Wave Divider Atas (Putih) */
        .wave-top-white {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            line-height: 0;
            z-index: 3;
            /* Lapisan paling atas */
        }

        .wave-top-white svg {
            display: block;
            transform: scaleY(0.2);
            transform-origin: top;
        }

        /* Styling Wave Divider Bawah (Putih) */
        .wave-bottom-white {
            position: absolute;
            bottom: 0;
            left: 0;
            width: 100%;
            line-height: 0;
            z-index: 3;
            /* Lapisan paling atas */
        }

        .wave-bottom-white svg {
            display: block;
            transform: scaleY(0.2);
            transform-origin: bottom;
        }

        /* Kotak Layanan (Card Galeri) */
        .service-box {
            padding: 30px;
            text-align: center;
            border-radius: 10px;
            box-shadow: 0 0 15px rgba(0, 0, 0, 0.5);
            transition: 0.3s;
            color: #fff;
            background: rgba(0, 0, 0, 0.4);
            border: 1px solid rgba(255, 255, 255, 0.1);
            height: 100%;
            display: flex;
            flex-direction: column;
            justify-content: center;
        }

        .service-box i {
            font-size: 40px;
            color: #FFC300;
            margin-bottom: 15px;
        }

        .service-box h4,
        .service-box p {
            color: #fff !important;
        }

        .service-box h4 {
            font-weight: bold;
        }

        .main-content-wrapper {
            position: relative;
            z-index: 2;
            /* Di atas overlay (z-index: 1) */
            padding: 100px 0 100px;
        }

        /* === Kustom CSS untuk Scrollable Card (Slider 3 Kartu) === */

        .scrollable-row {
            /* Hapus z-index ekstrim di sini. Z-index 2 pada parent sudah cukup. */
            display: flex;
            overflow-x: auto;
            padding-bottom: 20px;
            margin: 0 -15px;
            scroll-snap-type: x mandatory;
            -webkit-overflow-scrolling: touch;
            /* Efek scroll yang lebih baik di iOS */
        }

        /* Sembunyikan scrollbar bawaan */
        .scrollable-row::-webkit-scrollbar {
            display: none;
        }

        .scrollable-row {
            -ms-overflow-style: none;
            /* IE and Edge */
            scrollbar-width: none;
            /* Firefox */
        }

        /* Wrapper untuk setiap kartu di dalam scrollable-row */
        .scroll-card-wrapper {
            flex: 0 0 85%;
            margin: 0 15px;
            scroll-snap-align: start;
        }

        /* Media Query untuk Desktop: Tampilkan 3 kartu tanpa perlu scroll */
        @media (min-width: 992px) {
            .scrollable-row {
                overflow-x: hidden;
                justify-content: space-between;
                margin: 0;
            }

            .scroll-card-wrapper {
                flex: 0 0 calc(33.333% - 20px);
                margin: 0 10px;
            }
        }
    </style>

    <div class="wave-top-white">
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1440 320">
            <path fill="#ffffff" fill-opacity="1"
                d="M0,160L45,0L90,160L135,64L180,64L225,288L270,320L315,288L360,64L405,224L450,192L495,320L540,96L585,32L630,160L675,96L720,96L765,288L810,256L855,288L900,288L945,160L990,192L1035,0L1080,224L1125,160L1170,128L1215,288L1260,160L1305,32L1350,128L1395,96L1440,256L1440,0L1395,0L1350,0L1305,0L1260,0L1215,0L1170,0L1125,0L1080,0L1035,0L990,0L945,0L900,0L855,0L810,0L765,0L720,0L675,0L630,0L585,0L540,0L495,0L450,0L405,0L360,0L315,0L270,0L225,0L180,0L135,0L90,0L45,0L0,0Z">
            </path>
        </svg>
    </div>

    <div class="content-overlay"></div>

    <div class="main-content-wrapper container">
        <div class="text-center">
            <h2 class="mb-1 display-4 fw-bold">Galeri Foto Kami</h2>
            <p class="mb-5">Semua foto pada acara kami dapat diakses oleh tamu hanya dengan memindai barcode yang
                tersedia</p>
        </div>

        <div class="scrollable-row">

            <div class="scroll-card-wrapper">
                <div class="service-box">
                    <i class="bi bi-camera-fill"></i>
                    <h4>Dokumentasi Lengkap</h4>
                    <p>Mencakup foto, video sinematik, dan drone untuk setiap detail acara Anda.</p>
                </div>
            </div>

            <div class="scroll-card-wrapper">
                <div class="service-box">
                    <i class="bi bi-bag-check-fill"></i>
                    <h4>Full Wedding Organizer</h4>
                    <p>Perencanaan A-Z, memastikan hari besar Anda berjalan tanpa cela dan terorganisir.</p>
                </div>
            </div>

            <div class="scroll-card-wrapper">
                <div class="service-box">
                    <i class="bi bi-geo-alt-fill"></i>
                    <h4>Vendor Pilihan</h4>
                    <p>Akses ke vendor terbaik dan terpercaya di seluruh kota untuk kualitas maksimal.</p>
                </div>
            </div>

            <div class="scroll-card-wrapper">
                <div class="service-box">
                    <i class="bi bi-images"></i>
                    <h4>Foto Tamu Cepat</h4>
                    <p>Galeri instan yang dapat diakses melalui pemindaian kode QR di lokasi.</p>
                </div>
            </div>

            <div class="scroll-card-wrapper">
                <div class="service-box">
                    <i class="bi bi-star-fill"></i>
                    <h4>Layanan Tambahan</h4>
                    <p>Tersedia opsi *photo booth* dan *live stream* untuk acara Anda.</p>
                </div>
            </div>

        </div>
    </div>
    <div class="wave-bottom-white">
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1440 320">
            <path fill="#ffffff" fill-opacity="1"
                d="M0,128L36.9,128L73.8,192L110.8,160L147.7,288L184.6,0L221.5,64L258.5,32L295.4,32L332.3,224L369.2,224L406.2,160L443.1,224L480,288L516.9,96L553.8,0L590.8,288L627.7,64L664.6,64L701.5,224L738.5,288L775.4,64L812.3,288L849.2,256L886.2,256L923.1,128L960,192L996.9,64L1033.8,256L1070.8,128L1107.7,320L1144.6,128L1181.5,96L1218.5,32L1255.4,96L1292.3,96L1329.2,32L1366.2,160L1403.1,160L1440,96L1440,320L1403.1,320L1366.2,320L1329.2,320L1292.3,320L1255.4,320L1218.5,320L1181.5,320L1144.6,320L1107.7,320L1070.8,320L1033.8,320L996.9,320L960,320L923.1,320L886.2,320L849.2,320L812.3,320L775.4,320L738.5,320L701.5,320L664.6,320L627.7,320L590.8,320L553.8,320L516.9,320L480,320L443.1,320L406.2,320L369.2,320L332.3,320L295.4,320L258.5,320L221.5,320L184.6,320L147.7,320L110.8,320L73.8,320L36.9,320L0,320Z">
            </path>
        </svg>
    </div>
</section>
