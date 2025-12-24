<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Nomor HP - Galleris</title>

    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@300;400;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('assets/css/bootstrap.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/vendors/bootstrap-icons/bootstrap-icons.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/app.css') }}">

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

        .update-container {
            background: #ffffff;
            border-radius: 20px;
            overflow: hidden;
            box-shadow: 0 15px 35px rgba(0, 0, 0, 0.1);
            max-width: 900px;
            width: 100%;
        }

        .side-image {
            background: linear-gradient(135deg, #364ea4, #435ebf),
                url('https://images.unsplash.com/photo-1512428559087-560fa5ceab42?auto=format&fit=crop&q=80');
            background-size: cover;
            background-position: center;
            display: flex;
            flex-direction: column;
            justify-content: center;
            padding: 40px;
            color: white;
        }

        .form-section {
            padding: 50px;
        }

        .btn-update {
            border-radius: 10px;
            padding: 12px;
            font-weight: 600;
        }

        /* Styling khusus prefix agar terlihat menyatu */
        .input-group-text-prefix {
            background-color: #f8f9fa;
            border-right: none;
            font-weight: bold;
            color: #495057;
        }

        .form-control-phone {
            border-left: none;
        }

        .form-control-phone:focus {
            box-shadow: none;
            border-color: #dee2e6;
        }

        .input-group:focus-within {
            box-shadow: 0 0 0 0.25rem rgba(67, 94, 191, 0.25);
            border-radius: 0.375rem;
        }
    </style>
</head>

<body>

    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-10">
                <div class="update-container">
                    <div class="row g-0">
                        <div class="col-md-6 side-image d-none d-md-flex">
                            <h2 class="fw-bold text-light mb-3">Keamanan Akun</h2>
                            <p class="lead">
                                Pastikan nomor HP Anda aktif untuk menerima notifikasi penting dan pemulihan akun.
                            </p>
                            <div class="mt-4">
                                <i class="bi bi-shield-check" style="font-size: 3rem; opacity: 0.8;"></i>
                            </div>
                        </div>

                        <div class="col-md-6 form-section">
                            <div class="mb-4">
                                <form action="{{ route('logout') }}" method="post">
                                    @csrf
                                    <button type="submit"
                                        class="btn btn-outline-primary text-decoration-none small text-muted">
                                        <i class="bi bi-arrow-left"></i> Keluar
                                    </button>
                                </form>
                            </div>

                            <h3 class="fw-bold text-primary mb-2">Update Nomor HP</h3>
                            <p class="text-muted mb-4">Masukkan nomor WhatsApp Anda.</p>

                            <form method="POST" action="{{ route('auth.phone.store', $user->id) }}"
                                onsubmit="combinePhone()">
                                @csrf
                                @method('PUT')

                                <input type="hidden" name="phone" id="full_phone_number">

                                <div class="mb-4">
                                    <label class="form-label fw-semibold">Nomor Telepon</label>
                                    <div class="input-group">
                                        <span class="input-group-text input-group-text-prefix">
                                            +62
                                        </span>
                                        <input type="tel" id="user_input"
                                            class="form-control form-control-lg form-control-phone"
                                            placeholder="8123456789" required oninput="validateInput(this)">
                                    </div>
                                </div>

                                <button type="submit" class="btn btn-primary w-100 btn-update shadow-sm">
                                    Simpan Perubahan
                                </button>
                            </form>

                            <p class="text-center text-muted small mt-5">
                                &copy; 2025 Gallèris. All rights reserved.
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        function validateInput(input) {
            // Hapus karakter non-angka
            let value = input.value.replace(/[^0-9]/g, '');

            // Opsional: Jika user tidak sengaja mengetik 0 atau 62 di awal, kita bersihkan
            if (value.startsWith('0')) {
                value = value.substring(1);
            } else if (value.startsWith('62')) {
                value = value.substring(2);
            }

            input.value = value;
        }

        function combinePhone() {
            const userInput = document.getElementById('user_input').value;
            // Gabungkan 62 dengan inputan user ke dalam hidden input
            document.getElementById('full_phone_number').value = '62' + userInput;
        }
    </script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
