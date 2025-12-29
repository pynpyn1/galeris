<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kebijakan Privasi - Galleris</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        // Warna Palet: #435ebf
                        primary: '#435ebf',
                        'primary-dark': '#364a96',
                    }
                }
            }
        }
    </script>
    <style>
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
                Kebijakan Privasi
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
                    <span class="font-bold text-primary">Galleris</span> menghormati privasi Anda. Kebijakan ini
                    menjelaskan bagaimana kami mengelola, melindungi, dan menggunakan data yang Anda percayakan kepada
                    kami.
                </p>
            </div>

            <ol class="space-y-12 list-none p-0 counter-reset-item">

                <li class="relative pl-0">
                    <div class="flex items-center mb-4 pb-2 border-b-2 border-primary/10">
                        <div class="bg-primary/10 p-2 rounded-lg mr-4">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-primary" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                            </svg>
                        </div>
                        <h2 class="text-2xl font-bold text-primary">1. Informasi yang Kami Kumpulkan</h2>
                    </div>
                    <ul class="pl-2 md:pl-12 space-y-4">
                        <li class="flex items-start">
                            <svg class="h-6 w-6 text-primary mr-3 shrink-0" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M5 13l4 4L19 7" />
                            </svg>
                            <span><span class="font-bold text-primary">Data Pendaftaran:</span> Nama, alamat email, dan
                                nomor telepon (WhatsApp).</span>
                        </li>
                        <li class="flex items-start">
                            <svg class="h-6 w-6 text-primary mr-3 shrink-0" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M5 13l4 4L19 7" />
                            </svg>
                            <span><span class="font-bold text-primary">Konten Media:</span> Foto dan video yang Anda
                                unggah ke server kami.</span>
                        </li>
                        <li class="flex items-start">
                            <svg class="h-6 w-6 text-primary mr-3 shrink-0" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M5 13l4 4L19 7" />
                            </svg>
                            <span><span class="font-bold text-primary">Data Penggunaan:</span> Log aktivitas, interaksi
                                dengan Bot WhatsApp, dan data pemindaian QR Code.</span>
                        </li>
                    </ul>
                </li>

                <li class="relative pl-0">
                    <div class="flex items-center mb-4 pb-2 border-b-2 border-primary/10">
                        <div class="bg-primary/10 p-2 rounded-lg mr-4">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-primary" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M19.428 15.428a2 2 0 00-1.022-.547l-2.384-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z" />
                            </svg>
                        </div>
                        <h2 class="text-2xl font-bold text-primary">2. Cara Kami Menggunakan Informasi Anda</h2>
                    </div>
                    <ul class="pl-2 md:pl-12 space-y-3">
                        <li class="flex items-start">
                            <svg class="h-6 w-6 text-primary mr-3 shrink-0" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            <span>Menyediakan layanan penyimpanan dan pembuatan galeri.</span>
                        </li>
                        <li class="flex items-start">
                            <svg class="h-6 w-6 text-primary mr-3 shrink-0" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            <span>Mengirimkan tautan galeri dan QR Code melalui Bot WhatsApp.</span>
                        </li>
                        <li class="flex items-start">
                            <svg class="h-6 w-6 text-primary mr-3 shrink-0" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            <span>Menghubungi Anda terkait pembaruan layanan atau tagihan.</span>
                        </li>
                        <li class="flex items-start">
                            <svg class="h-6 w-6 text-primary mr-3 shrink-0" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            <span>Meningkatkan performa sistem dan keamanan platform.</span>
                        </li>
                    </ul>
                </li>

                <li class="relative pl-0">
                    <div class="flex items-center mb-4 pb-2 border-b-2 border-primary/10">
                        <div class="bg-primary/10 p-2 rounded-lg mr-4">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-primary" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M8.684 13.342C8.886 12.938 9 12.482 9 12c0-.482-.114-.938-.316-1.342m0 2.684a3 3 0 110-2.684m0 2.684l6.632 3.316m-6.632-6l6.632-3.316m0 0a3 3 0 105.367-2.684 3 3 0 00-5.367 2.684zm0 9.316a3 3 0 105.368 2.684 3 3 0 00-5.368-2.684z" />
                            </svg>
                        </div>
                        <h2 class="text-2xl font-bold text-primary">3. Berbagi Informasi</h2>
                    </div>
                    <ul class="pl-2 md:pl-12 space-y-4">
                        <li class="flex items-start">
                            <svg class="h-6 w-6 text-primary mr-3 shrink-0" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            <span><span class="font-bold text-primary">Publik/Tamu:</span> Saat Anda membagikan QR
                                Code, konten di dalam galeri tersebut menjadi dapat diakses oleh siapa saja yang
                                memindai kode tersebut.</span>
                        </li>
                        <li class="flex items-start">
                            <svg class="h-6 w-6 text-primary mr-3 shrink-0" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            <span><span class="font-bold text-primary">Pihak Ketiga:</span> Kami tidak menjual data
                                Anda. Kami hanya membagikan data kepada penyedia layanan infrastruktur (seperti server
                                cloud atau gateway WhatsApp) semata-mata untuk operasional sistem.</span>
                        </li>
                        <li class="flex items-start">
                            <svg class="h-6 w-6 text-primary mr-3 shrink-0" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            <span><span class="font-bold text-primary">Hukum:</span> Kami dapat mengungkapkan data jika
                                diwajibkan oleh perintah pengadilan atau penegak hukum yang sah.</span>
                        </li>
                    </ul>
                </li>

                <li class="relative pl-0">
                    <div class="flex items-center mb-4 pb-2 border-b-2 border-primary/10">
                        <div class="bg-primary/10 p-2 rounded-lg mr-4">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-primary" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                            </svg>
                        </div>
                        <h2 class="text-2xl font-bold text-primary">4. Keamanan Data</h2>
                    </div>
                    <div class="pl-2 md:pl-12">
                        <p class="text-lg leading-relaxed">
                            Kami menggunakan enkripsi standar industri dan protokol keamanan server yang ketat untuk
                            melindungi foto, video, dan data pribadi Anda dari akses yang tidak sah, kehilangan, atau
                            penyalahgunaan.
                        </p>
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
                        <h2 class="text-2xl font-bold text-primary">5. Hak Pengguna</h2>
                    </div>
                    <div class="pl-2 md:pl-12">
                        <p class="mb-3 font-medium text-gray-800">Anda memiliki hak penuh untuk:</p>
                        <ul class="space-y-3">
                            <li class="flex items-center bg-blue-50 p-2 rounded-md">
                                <svg class="h-5 w-5 text-primary mr-3" fill="none" viewBox="0 0 24 24"
                                    stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                                Mengakses data pribadi yang kami simpan.
                            </li>
                            <li class="flex items-center bg-blue-50 p-2 rounded-md">
                                <svg class="h-5 w-5 text-primary mr-3" fill="none" viewBox="0 0 24 24"
                                    stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                                Meminta penghapusan akun dan seluruh konten media Anda (Hak untuk Dilupakan).
                            </li>
                            <li class="flex items-center bg-blue-50 p-2 rounded-md">
                                <svg class="h-5 w-5 text-primary mr-3" fill="none" viewBox="0 0 24 24"
                                    stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                                Memperbarui informasi kontak dan profil.
                            </li>
                        </ul>
                    </div>
                </li>

                <li class="relative pl-0">
                    <div class="flex items-center mb-4 pb-2 border-b-2 border-primary/10">
                        <div class="bg-primary/10 p-2 rounded-lg mr-4">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-primary" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M4 7v10c0 2.21 3.582 4 8 4s8-1.79 8-4V7M4 7c0 2.21 3.582 4 8 4s8-1.79 8-4M4 7c0-2.21 3.582-4 8-4s8 1.79 8 4m0 5c0 2.21-3.582 4-8 4s-8-1.79-8-4" />
                            </svg>
                        </div>
                        <h2 class="text-2xl font-bold text-primary">6. Penyimpanan Data</h2>
                    </div>
                    <div class="pl-2 md:pl-12">
                        <p class="text-lg leading-relaxed">
                            Kami menyimpan konten Anda selama akun Anda aktif. Jika Anda berhenti berlangganan atau
                            menghapus akun, kami akan menghapus data Anda dari server kami dalam kurun waktu <span
                                class="font-bold text-red-500">30 hari</span> setelah penutupan akun.
                        </p>
                    </div>
                </li>

                <li class="relative pl-0">
                    <div class="flex items-center mb-4 pb-2 border-b-2 border-primary/10">
                        <div class="bg-primary/10 p-2 rounded-lg mr-4">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-primary" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                            </svg>
                        </div>
                        <h2 class="text-2xl font-bold text-primary">7. Kontak</h2>
                    </div>
                    <div class="pl-2 md:pl-12 bg-blue-50 rounded-xl p-6 border border-blue-100">
                        <p class="text-lg mb-2">Jika ada pertanyaan mengenai privasi ini, silakan hubungi kami di:</p>
                        <div class="font-bold text-primary text-xl">
                            support@galleris.com </div>
                        <div class="text-gray-600 mt-1">
                            +62 812-3456-7890 </div>
                    </div>
                </li>

            </ol>

            <div class="mt-16 pt-8 border-t border-gray-100 text-center text-gray-500 text-sm">
                <p>&copy; {{ date('Y') }} Galleris. Seluruh Hak Cipta Dilindungi.</p>
            </div>

        </div>
    </main>

</body>

</html>
