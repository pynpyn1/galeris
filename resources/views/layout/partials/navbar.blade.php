<nav class="fixed top-6 left-1/2 -translate-x-1/2 w-[90%] max-w-6xl z-50">
    <div
        class="bg-white/80 backdrop-blur-md border border-white/20 shadow-lg rounded-2xl px-8 py-4 flex justify-between items-center">

        <div class="flex items-center">
            <a href="/">
                <img src="{{ asset('asset/img/GALLERIS_LOGO.png') }}" alt="EventGallery Logo"
                    class="h-10 w-auto object-contain">
            </a>
        </div>

        <ul class="hidden md:flex items-center gap-8 text-slate-600 font-medium">
            <li><a href="#tutorial" onclick="setActive(this)" class="nav-link hover:text-indigo-600 transition">Tentang
                    Kami</a></li>
            <li><a href="#fitur" onclick="setActive(this)" class="nav-link hover:text-indigo-600 transition">Fitur</a>
            </li>
            <li><a href="#berlangganan" onclick="setActive(this)"
                    class="nav-link hover:text-indigo-600 transition">Berlangganan</a></li>
            <li><a href="#acara" onclick="setActive(this)" class="nav-link hover:text-indigo-600 transition">Acara</a>
            </li>
            <li><a href="#faq" onclick="setActive(this)" class="nav-link hover:text-indigo-600 transition">FAQ</a>
            </li>
        </ul>

        <a href="{{ route('login') }}"
            class="bg-indigo-600 hover:bg-indigo-700 text-white px-6 py-2.5 rounded-xl font-semibold transition shadow-md shadow-indigo-200">
            Buat Event
        </a>
    </div>
</nav>
