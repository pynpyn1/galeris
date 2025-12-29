<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hubungi Kami - Galleris</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
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

<body class="bg-primary/5 text-gray-700 antialiased min-h-screen flex flex-col">

    <header class="bg-primary py-16 px-4 relative overflow-hidden shrink-0">
        <div class="absolute inset-0 bg-gradient-to-b from-primary-dark/20 to-transparent pointer-events-none"></div>

        <div class="max-w-4xl mx-auto text-center relative z-10">
            <h1 class="text-4xl md:text-5xl font-extrabold text-white mb-3 tracking-tight">
                Hubungi Kami
            </h1>
            <p class="text-blue-100 text-lg font-medium">
                Kami siap membantu menjawab pertanyaan Anda.
            </p>
        </div>
    </header>

    <main class="px-4 pb-20 relative z-20 flex-grow">
        <div class="max-w-3xl mx-auto bg-white rounded-2xl shadow-xl -mt-10 p-8 md:p-12 overflow-hidden">

            @if (session('success'))
                <div class="mb-8 flex items-center bg-green-50 border-l-4 border-green-500 text-green-700 p-4 rounded shadow-sm"
                    role="alert">
                    <svg class="h-6 w-6 mr-3 text-green-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    <div>
                        <p class="font-bold">Berhasil!</p>
                        <p class="text-sm">{{ session('success') }}</p>
                    </div>
                </div>
            @endif

            <form action="{{ route('help.contactus.store') }}" method="POST" class="space-y-6">
                @csrf

                <div>
                    <label for="name" class="block text-sm font-semibold text-gray-700 mb-2">Nama Lengkap</label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <svg class="h-5 w-5 text-gray-400" xmlns="http://www.w3.org/2000/svg" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                            </svg>
                        </div>
                        <input type="text" name="name" id="name" required placeholder="Masukkan nama Anda"
                            class="w-full pl-10 pr-4 py-3 rounded-lg border border-gray-300 focus:border-primary focus:ring-4 focus:ring-primary/10 transition duration-200 outline-none placeholder-gray-400">
                    </div>
                </div>

                <div>
                    <label for="email" class="block text-sm font-semibold text-gray-700 mb-2">Alamat Email</label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <svg class="h-5 w-5 text-gray-400" xmlns="http://www.w3.org/2000/svg" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                            </svg>
                        </div>
                        <input type="email" name="email" id="email" required placeholder="nama@email.com"
                            class="w-full pl-10 pr-4 py-3 rounded-lg border border-gray-300 focus:border-primary focus:ring-4 focus:ring-primary/10 transition duration-200 outline-none placeholder-gray-400">
                    </div>
                </div>

                <div>
                    <label for="subject" class="block text-sm font-semibold text-gray-700 mb-2">Subjek</label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <svg class="h-5 w-5 text-gray-400" xmlns="http://www.w3.org/2000/svg" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M7 20l4-16m2 16l4-16M6 9h14M4 15h14" />
                            </svg>
                        </div>
                        <input type="text" name="subject" id="subject" required placeholder="Perihal pesan Anda"
                            class="w-full pl-10 pr-4 py-3 rounded-lg border border-gray-300 focus:border-primary focus:ring-4 focus:ring-primary/10 transition duration-200 outline-none placeholder-gray-400">
                    </div>
                </div>

                <div>
                    <label for="message" class="block text-sm font-semibold text-gray-700 mb-2">Pesan</label>
                    <div class="relative">
                        <div class="absolute top-3 left-3 pointer-events-none">
                            <svg class="h-5 w-5 text-gray-400" xmlns="http://www.w3.org/2000/svg" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z" />
                            </svg>
                        </div>
                        <textarea name="message" id="message" rows="5" required
                            placeholder="Tuliskan detail pertanyaan atau kendala Anda di sini..."
                            class="w-full pl-10 pr-4 py-3 rounded-lg border border-gray-300 focus:border-primary focus:ring-4 focus:ring-primary/10 transition duration-200 outline-none resize-y placeholder-gray-400"></textarea>
                    </div>
                </div>

                <div class="pt-4">
                    <button type="submit"
                        class="w-full bg-primary hover:bg-primary-dark text-white font-bold py-4 px-6 rounded-xl transition duration-300 transform hover:-translate-y-1 shadow-lg shadow-primary/30 flex justify-center items-center group">
                        <span>Kirim Pesan</span>
                        <svg class="w-5 h-5 ml-2 transform group-hover:translate-x-1 transition-transform"
                            fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M14 5l7 7m0 0l-7 7m7-7H3" />
                        </svg>
                    </button>
                </div>
            </form>

            <div class="mt-8 text-center border-t border-gray-100 pt-6">
                <p class="text-sm text-gray-500">
                    Atau hubungi kami langsung via WhatsApp: <br>
                    <a href="#" class="text-primary font-bold hover:underline mt-1 inline-block">+62
                        895-2486-3306</a>
                </p>
            </div>

        </div>
    </main>

</body>

</html>
