<style>
    .overlay {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background-color: rgba(0, 0, 0, 0.5);
        z-index: 0;
    }

    .logo {
        height: 50px;
        filter: brightness(0) invert(1);
    }

    .hero-title h1 {
        font-family: 'Times New Roman', serif;
        color: #FFD700 !important;
        text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.7);
    }

    .btn-gold {
        background-color: #FFC300;
        color: white;
        border: none;
        font-weight: bold;
        padding: 12px 30px;
        border: 1px solid white;

    }

    .btn-gold:hover {
        background-color: #e5b200;
        color: #000;
    }



    .logo {
        height: 50px;
        filter: brightness(0) invert(1);
        position: absolute;
        top: 20px;
        left: 20px;
        z-index: 3;
    }

    .hero-title h1 {
        font-family: 'Times New Roman', serif;
        color: #FFD700 !important;
        text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.7);
        margin-top: 0 !important;
    }

    .hero-title h1 .display-1 {
        font-size: 6rem;
    }
</style>

<section id="hero" class="vh-100 position-relative d-flex justify-content-center text-white"
    style="background-image: url('{{ asset('asset/img/hero.jpg') }}'); background-size: cover; background-position: center;">

    <div class="overlay"></div>

    <div class="container-fluid position-relative z-1 d-flex flex-column h-100 pt-4 pb-5">
        <div class="row w-100 flex-grow-1">
            <div class="col-12 text-start mb-5">
                <img src="{{ asset('asset/img/adora-logo.png') }}" alt="Adora Logo" class="logo">
            </div>

            <div class="col-12 text-center hero-content-center align-items-center">
                <div class="hero-title">
                    <h1 class="display-1 fw-bold text-shadow-lg">ADORA WEDDING</h1>
                </div>

                <div class="col-12 text-center mt-5">
                    <a href="#about" class="btn btn-xl rounded-pill btn-gold me-3">Kenapa Kami</a>
                    <a href="#contact" class="btn btn-xl rounded-pill btn-gold">Hubungi Kami</a>
                </div>
            </div>
        </div>
    </div>
</section>
