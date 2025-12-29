<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Syarat dan Ketentuan Layanan - Galleris</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        // Mendefinisikan warna palet yang diminta
                        primary: '#435ebf',
                        'primary-dark': '#364a96', // Versi sedikit lebih gelap untuk hover/aksen
                    }
                }
            }
        }
    </script>
    <style>
        /* Sedikit penyesuaian untuk font agar lebih modern */
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap');

        body {
            font-family: 'Inter', sans-serif;
        }
    </style>
</head>

<body class="bg-primary/5 text-gray-700 antialiased">

    <header class="bg-primary py-16 px-4 relative overflow-hidden">
        <div class="absolute inset-0 bg-gradient-to-b from-primary-dark/20 to-transparent pointer-events-none"></div>

        <div class="max-w-4xl mx-auto text-center relative z-10">
            <h1 class="text-4xl md:text-5xl font-extrabold text-white mb-4 tracking-tight">
                Syarat dan Ketentuan Layanan
            </h1>
            <p class="text-blue-100 text-lg font-medium">
                Terakhir Diperbarui: {{ date('d F Y') }}
            </p>
        </div>
    </header>

    <main class="px-4 pb-20 relative z-20">
        <div class="max-w-4xl mx-auto bg-white rounded-2xl shadow-xl -mt-10 p-8 md:p-12">

            <div class="prose prose-blue max-w-none mb-10">
                <p class="text-lg text-gray-600 leading-relaxed">
                    Selamat datang di <span class="font-bold text-primary">Galleris</span>. Mohon baca Syarat dan
                    Ketentuan ini dengan saksama sebelum menggunakan layanan kami. Dengan mengakses layanan kami, Anda
                    setuju untuk terikat oleh ketentuan ini.
                </p>
            </div>

            <ol class="space-y-12 list-none p-0 counter-reset-item">
                <li class="relative pl-0">
                    <div class="flex items-center mb-4 pb-2 border-b-2 border-primary/10">
                        <div class="bg-primary/10 p-2 rounded-lg mr-4">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-primary" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.747 0-3.332.477-4.5 1.253" />
                            </svg>
                        </div>
                        <h2 class="text-2xl font-bold text-primary">1. Definisi</h2>
                    </div>
                    <div class="space-y-3 pl-2 md:pl-12">
                        <p><span class="font-semibold text-gray-900">"Layanan"</span> merujuk pada platform Galleris,
                            termasuk situs web, penyimpanan media, sistem QR Code, dan layanan Bot WhatsApp.</p>
                        <p><span class="font-semibold text-gray-900">"Pengguna"</span> adalah individu atau entitas yang
                            mendaftar dan menggunakan layanan Galleris.</p>
                        <p><span class="font-semibold text-gray-900">"Konten"</span> merujuk pada foto, video, teks, dan
                            data lain yang diunggah oleh Pengguna.</p>
                    </div>
                </li>

                <li class="relative pl-0">
                    <div class="flex items-center mb-4 pb-2 border-b-2 border-primary/10">
                        <div class="bg-primary/10 p-2 rounded-lg mr-4">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-primary" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                            </svg>
                        </div>
                        <h2 class="text-2xl font-bold text-primary">2. Akun Pengguna</h2>
                    </div>
                    <div class="space-y-3 pl-2 md:pl-12 leading-relaxed">
                        <p class="mb-2">Anda bertanggung jawab penuh atas keamanan akun dan kata sandi Anda.</p>
                        <p>Anda wajib memberikan nomor WhatsApp yang valid dan aktif untuk keperluan verifikasi dan
                            penggunaan fitur Bot.</p>
                    </div>
                </li>

                <li class="relative pl-0">
                    <div class="flex items-center mb-4 pb-2 border-b-2 border-primary/10">
                        <div class="bg-primary/10 p-2 rounded-lg mr-4">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-primary" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M4 6h16M4 10h16M4 14h16M4 18h16" />
                            </svg>
                        </div>
                        <h2 class="text-2xl font-bold text-primary">3. Penggunaan Layanan</h2>
                    </div>
                    <ul class="pl-2 md:pl-12 space-y-4">
                        <li class="flex items-start">
                            <svg class="h-6 w-6 text-primary mr-3 shrink-0" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M5 13l4 4L19 7" />
                            </svg>
                            <span><span class="font-bold text-primary">Penyimpanan Media:</span> Galleris menyediakan
                                ruang penyimpanan untuk foto dan video. Kami berhak menetapkan batas penyimpanan sesuai
                                dengan paket yang Anda pilih.</span>
                        </li>
                        <li class="flex items-start">
                            <svg class="h-6 w-6 text-primary mr-3 shrink-0" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M5 13l4 4L19 7" />
                            </svg>
                            <span><span class="font-bold text-primary">QR Code:</span> QR Code yang dihasilkan bersifat
                                unik. Siapapun yang memiliki akses ke QR Code tersebut dapat melihat konten yang
                                ditautkan. Anda bertanggung jawab menjaga kerahasiaan QR Code jika konten bersifat
                                pribadi.</span>
                        </li>
                        <li class="flex items-start">
                            <svg class="h-6 w-6 text-primary mr-3 shrink-0" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M5 13l4 4L19 7" />
                            </svg>
                            <span><span class="font-bold text-primary">Bot WhatsApp:</span> Fitur ini bergantung pada
                                layanan pihak ketiga (Meta/WhatsApp). Kami tidak menjamin pengiriman pesan 100% instan
                                jika terjadi gangguan pada server WhatsApp global.</span>
                        </li>
                    </ul>
                </li>

                <li class="relative pl-0">
                    <div class="flex items-center mb-4 pb-2 border-b-2 border-red-100">
                        <div class="bg-red-100 p-2 rounded-lg mr-4">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-red-500" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                            </svg>
                        </div>
                        <h2 class="text-2xl font-bold text-primary">4. Konten yang Dilarang</h2>
                    </div>
                    <div class="pl-2 md:pl-12">
                        <p class="mb-3 font-medium">Anda dilarang keras mengunggah atau membagikan konten yang:</p>
                        <ul class="space-y-2 mb-4">
                            <li class="flex items-center text-red-600 bg-red-50 p-2 rounded-md">
                                <svg class="h-5 w-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd"
                                        d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z"
                                        clip-rule="evenodd" />
                                </svg>
                                Melanggar hukum di Indonesia (termasuk pornografi, perjudian, ujaran kebencian).
                            </li>
                            <li class="flex items-center text-red-600 bg-red-50 p-2 rounded-md">
                                <svg class="h-5 w-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd"
                                        d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z"
                                        clip-rule="evenodd" />
                                </svg>
                                Melanggar hak cipta atau kekayaan intelektual orang lain.
                            </li>
                            <li class="flex items-center text-red-600 bg-red-50 p-2 rounded-md">
                                <svg class="h-5 w-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd"
                                        d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z"
                                        clip-rule="evenodd" />
                                </svg>
                                Mengandung virus atau malware.
                            </li>
                        </ul>
                        <p class="text-sm text-gray-500 bg-gray-50 p-3 border-l-4 border-primary rounded-r">Galleris
                            berhak menghapus konten apapun yang melanggar ketentuan ini tanpa pemberitahuan sebelumnya.
                        </p>
                    </div>
                </li>

                <li class="relative pl-0">
                    <div class="flex items-center mb-4 pb-2 border-b-2 border-primary/10">
                        <div class="bg-primary/10 p-2 rounded-lg mr-4">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-primary" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z" />
                            </svg>
                        </div>
                        <h2 class="text-2xl font-bold text-primary">5. Pembayaran dan Berlangganan</h2>
                    </div>
                    <ul class="pl-2 md:pl-12 space-y-3">
                        <li class="flex items-start">
                            <svg class="h-6 w-6 text-primary mr-3 shrink-0" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            <span>Layanan tertentu mungkin berbayar. Keterlambatan pembayaran dapat mengakibatkan
                                pembekuan akses ke galeri atau fitur Bot WhatsApp.</span>
                        </li>
                        <li class="flex items-start">
                            <svg class="h-6 w-6 text-primary mr-3 shrink-0" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            <span>Tidak ada pengembalian dana (refund) untuk periode berlangganan yang sudah berjalan,
                                kecuali diatur lain oleh hukum.</span>
                        </li>
                    </ul>
                </li>

                <li class="relative pl-0">
                    <div class="flex items-center mb-4 pb-2 border-b-2 border-primary/10">
                        <div class="bg-primary/10 p-2 rounded-lg mr-4">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-primary" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                            </svg>
                        </div>
                        <h2 class="text-2xl font-bold text-primary">6. Batasan Tanggung Jawab</h2>
                    </div>
                    <ul class="pl-2 md:pl-12 space-y-3">
                        <li class="flex items-start">
                            <svg class="h-6 w-6 text-primary mr-3 shrink-0" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            <span>Galleris tidak bertanggung jawab atas kerugian tidak langsung yang timbul akibat
                                penggunaan layanan (misal: gangguan server WhatsApp, kesalahan pengguna dalam membagikan
                                QR Code).</span>
                        </li>
                        <li class="flex items-start">
                            <svg class="h-6 w-6 text-primary mr-3 shrink-0" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            <span>Galleris berupaya menjaga keamanan data, namun tidak bertanggung jawab atas kehilangan
                                data akibat peretasan di luar kendali kami atau force majeure.</span>
                        </li>
                    </ul>
                </li>

                <li class="relative pl-0">
                    <div class="flex items-center mb-4 pb-2 border-b-2 border-primary/10">
                        <div class="bg-primary/10 p-2 rounded-lg mr-4">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-primary" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                            </svg>
                        </div>
                        <h2 class="text-2xl font-bold text-primary">7. Perubahan Ketentuan</h2>
                    </div>
                    <div class="pl-2 md:pl-12">
                        <p class="text-lg leading-relaxed">Kami dapat mengubah syarat ini sewaktu-waktu. Perubahan akan
                            diinformasikan melalui situs web atau notifikasi WhatsApp. Penggunaan berkelanjutan atas
                            layanan setelah perubahan tersebut merupakan persetujuan Anda terhadap ketentuan yang baru.
                        </p>
                    </div>
                </li>
            </ol>

            <div class="mt-16 pt-8 border-t border-gray-100 text-center text-gray-500 text-sm">
                <p>&copy; {{ date('Y') }} Galleris. Hak Cipta Dilindungi.</p>
            </div>

        </div>
    </main>

</body>

</html>
