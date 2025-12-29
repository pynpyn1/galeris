<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Galleris</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;600;700;800&display=swap"
        rel="stylesheet" />
    <style>
        html {
            scroll-behavior: smooth !important;
            scroll-padding-top: 100px;
        }

        body {
            font-family: "Plus Jakarta Sans", sans-serif;

        }
    </style>
</head>

<body class="bg-slate-50 text-slate-900">
    {{-- NAVBAR --}}
    @include('layout.partials.navbar')
    <!-- JUMBOTRON -->
    @include('layout.partials.hero')
    {{-- TUTORIAL --}}
    @include('layout.partials.tutorial')
    <!--  FITUR  -->
    @include('layout.partials.fitur')
    <!-- BERLANGGANAN -->
    @include('layout.partials.berlangganan')
    {{-- ACARA --}}
    @include('layout.partials.acara')
    {{-- CTA --}}
    @include('layout.partials.cta')
    {{-- FAQ --}}
    @include('layout.partials.faq')
    {{-- FOOTER --}}
    @include('layout.partials.footer')


    <script>
        function setActive(element) {
            // 1. Ambil semua elemen dengan class 'nav-link'
            const links = document.querySelectorAll('.nav-link');

            // 2. Hapus class aktif (indigo) dan kembalikan ke warna semula (slate)
            links.forEach(link => {
                link.classList.remove('text-indigo-600', 'font-bold');
                link.classList.add('text-slate-600');
            });

            // 3. Tambahkan class aktif ke elemen yang diklik
            element.classList.add('text-indigo-600', 'font-bold');
            element.classList.remove('text-slate-600');
        }
    </script>
    <script>
        const sections = document.querySelectorAll("section");
        const navLinks = document.querySelectorAll(".nav-link");

        window.addEventListener("scroll", () => {
            let current = "";

            sections.forEach((section) => {
                const sectionTop = section.offsetTop;
                const sectionHeight = section.clientHeight;
                // Deteksi posisi scroll
                if (pageYOffset >= sectionTop - 150) {
                    current = section.getAttribute("id");
                }
            });

            navLinks.forEach((link) => {
                link.classList.remove("text-indigo-600", "font-bold");
                if (link.getAttribute("href").includes(current)) {
                    link.classList.add("text-indigo-600", "font-bold");
                }
            });
        });
    </script>
</body>

</html>
