<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Dashboard</title>

    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@300;400;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('assets/css/bootstrap.css') }}">

    <link rel="stylesheet" href="{{ asset('assets/vendors/iconly/bold.css') }}">

    <link rel="stylesheet" href="{{ asset('assets/vendors/perfect-scrollbar/perfect-scrollbar.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/vendors/bootstrap-icons/bootstrap-icons.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/app.css') }}">
    <link rel="shortcut icon" href="assets/images/favicon.svg" type="image/x-icon">

    <style>
        :root {
            --primary-color: #435ebf;

        }

        body {
            font-family: 'Inter', sans-serif;
            background-color: #f0f2f5;
            min-height: 100vh;
            display: grid;
            place-items: center;
            margin: 0;
            padding: 20px;
        }

        .login-container {
            background: #ffffff;
            border-radius: 20px;
            overflow: hidden;
            box-shadow: 0 15px 35px rgba(0, 0, 0, 0.1);
            max-width: 1000px;
            width: 100%;
        }

        .login-image {
            background: linear-gradient(135deg, #364ea4, #435ebf),
                url('https://images.unsplash.com/photo-1557683316-973673baf926?auto=format&fit=crop&q=80');
            background-size: cover;
            background-position: center;
            display: flex;
            flex-direction: column;
            justify-content: center;
            padding: 40px;
            color: white;
        }

        .login-form-section {
            padding: 50px;
        }

        .btn-login {
            border-radius: 10px;
            padding: 10px;
            padding-left: 12px;
            padding-right: 12px;
            font-weight: 600;
        }

        .divider {
            display: flex;
            align-items: center;
            text-align: center;
            margin: 25px 0;
        }

        .divider::before,
        .divider::after {
            content: '';
            flex: 1;
            border-bottom: 1px solid #dee2e6;
        }

        .divider span {
            padding: 0 10px;
            color: #6c757d;
            font-size: 0.85rem;
        }
    </style>
</head>

<body>

    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-10">
                <div class="login-container">
                    <div class="row g-0">
                        <div class="col-md-6 login-image d-none d-md-flex">
                            <img src="{{ asset('asset/img/GALLERIS_WHITE.png') }}" class="w-25 mb-2" alt="">
                            <h2 class="fw-bold text-light mb-3">Selamat Datang Kembali!</h2>
                            <p class="lead">
                                Kelola galeri Anda dengan lebih mudah dan cepat dalam satu platform terintegrasi.
                            </p>
                        </div>

                        <div class="col-md-6 login-form-section">
                            <h3 class="fw-bold text-primary mb-2">Login</h3>
                            <p class="text-muted mb-4">Silakan masukkan akun anda</p>

                            {{-- LOGIN MANUAL --}}
                            <form method="POST" action="{{ route('login.post') }}">
                                @csrf

                                <div class="mb-3">
                                    <label class="form-label">Email Address</label>
                                    <input type="email" name="email" class="form-control" required>
                                </div>

                                <div class="mb-3">
                                    <label class="form-label">Password</label>
                                    <input type="password" name="password" class="form-control" required>
                                </div>

                                <div class="d-flex justify-content-between mb-3">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="remember">
                                        <label class="form-check-label small">Ingat Saya</label>
                                    </div>
                                    <a href="#" class="small text-primary">Lupa Password?</a>
                                </div>

                                <button type="submit" class="btn btn-primary w-100 btn-login">
                                    Masuk Sekarang
                                </button>
                            </form>

                            <div class="divider">
                                <span>ATAU</span>
                            </div>


                            <a href="{{ route('social.login', ['provider' => 'discord']) }}"
                                class="mb-2 btn w-100 btn-outline-primary btn-login">
                                <i class="bi bi-discord"></i> Discord
                            </a>

                            <a href="{{ route('social.login', ['provider' => 'google']) }}"
                                class="btn w-100 btn-outline-danger btn-login">
                                <i class="bi bi-google"></i> Google
                            </a>

                            <a href="{{ route('social.login', ['provider' => 'facebook']) }}"
                                class="mt-2 btn w-100 btn-outline-primary btn-login">
                                <i class="bi bi-facebook"></i> Facebook
                            </a>



                            <p class="text-center text-muted small mt-4">
                                &copy; 2025 Gallèris. All rights reserved.
                            </p>

                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
