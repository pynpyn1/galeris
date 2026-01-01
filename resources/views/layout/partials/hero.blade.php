<section class="relative pt-40 pb-20 px-6">
    <div class="max-w-7xl mx-auto grid md:grid-cols-2 gap-12 items-center">
        <div class="space-y-8">
            <h1 class="text-5xl md:text-7xl font-extrabold leading-[1.1] tracking-tight text-slate-900">
                Elegant Photo <br />
                <span class="text-indigo-600">Sharing</span> <br />
                <span class="text-indigo-500/80">for Every Event</span>
            </h1>

            <p class="text-lg text-slate-500 max-w-md leading-relaxed">Kumpulkan dan bagikan kenangan secara instan
                melalui galeri cloud berbasis QR</p>

            <div class="flex flex-wrap gap-4">
                <button
                    class="bg-indigo-600 hover:bg-indigo-700 text-white px-8 py-4 rounded-2xl font-bold text-lg transition shadow-lg shadow-indigo-200">Buat
                    Event</button>
                <button
                    class="bg-white border border-slate-200 hover:bg-slate-50 text-slate-700 px-8 py-4 rounded-2xl font-bold text-lg transition shadow-sm">Lihat
                    Demo</button>
            </div>

            <div class="flex items-center gap-6 pt-4 text-sm font-medium text-slate-500">
                <div class="flex items-center gap-2"><span class="w-2 h-2 rounded-full bg-emerald-400"></span> Cloud
                    Storage</div>
                <div class="flex items-center gap-2"><span class="w-2 h-2 rounded-full bg-purple-400"></span>
                    Real-time Sync</div>
                <div class="flex items-center gap-2"><span class="w-2 h-2 rounded-full bg-blue-400"></span> Secure
                </div>
            </div>
        </div>

        <div class="relative">
            <div class="rounded-[2.5rem] overflow-hidden shadow-2xl rotate-2 hover:rotate-0 transition duration-500">
                <img src="{{ asset('asset/img/hero1.jpg') }}" alt="Event Photo" class="w-full h-[500px] object-cover" />
            </div>

            <div
                class="absolute -bottom-6 -left-6 bg-white p-4 rounded-2xl shadow-xl flex items-center gap-4 border border-slate-100">
                <div class="bg-indigo-100 p-3 rounded-xl">
                    <svg class="w-6 h-6 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7">
                        </path>
                    </svg>
                </div>
                <div>
                    <div class="text-xl font-bold text-slate-900">900+</div>
                    <div class="text-xs text-slate-500 font-medium">Event Terbuat</div>
                </div>
            </div>
        </div>
    </div>

    <div class="absolute top-0 right-0 -z-10 w-1/3 h-1/2 bg-gradient-to-b from-indigo-50 to-transparent opacity-50">
    </div>
</section>
