<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>EventGallery Slicing</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;600;700;800&display=swap"
        rel="stylesheet" />
    <style>
        body {
            font-family: "Plus Jakarta Sans", sans-serif;
        }
    </style>
</head>

<body class="bg-slate-50 text-slate-900">
    <nav class="fixed top-6 left-1/2 -translate-x-1/2 w-[90%] max-w-6xl z-50">
        <div
            class="bg-white/80 backdrop-blur-md border border-white/20 shadow-lg rounded-2xl px-8 py-4 flex justify-between items-center">
            <div class="text-2xl font-extrabold text-indigo-900">Event<span class="text-indigo-600">Gallery</span></div>

            <ul class="hidden md:flex items-center gap-8 text-slate-600 font-medium">
                <li><a href="#" class="hover:text-indigo-600 transition">Features</a></li>
                <li><a href="#" class="hover:text-indigo-600 transition">Pricing</a></li>
                <li><a href="#" class="hover:text-indigo-600 transition">Use Cases</a></li>
            </ul>

            <a href="#"
                class="bg-indigo-600 hover:bg-indigo-700 text-white px-6 py-2.5 rounded-xl font-semibold transition shadow-md shadow-indigo-200">
                Create Event </a>
        </div>
    </nav>
    <!-- JUMBOTRON -->
    <section class="relative pt-40 pb-20 px-6">
        <div class="max-w-7xl mx-auto grid md:grid-cols-2 gap-12 items-center">
            <div class="space-y-8">
                <h1 class="text-5xl md:text-7xl font-extrabold leading-[1.1] tracking-tight text-slate-900">
                    Elegant Photo <br />
                    <span class="text-indigo-600">Sharing</span> <br />
                    <span class="text-indigo-500/80">for Every Event</span>
                </h1>

                <p class="text-lg text-slate-500 max-w-md leading-relaxed">Collect and share memories instantly through
                    QR-based cloud galleries.</p>

                <div class="flex flex-wrap gap-4">
                    <button
                        class="bg-indigo-600 hover:bg-indigo-700 text-white px-8 py-4 rounded-2xl font-bold text-lg transition shadow-lg shadow-indigo-200">Create
                        Event</button>
                    <button
                        class="bg-white border border-slate-200 hover:bg-slate-50 text-slate-700 px-8 py-4 rounded-2xl font-bold text-lg transition shadow-sm">View
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
                <div
                    class="rounded-[2.5rem] overflow-hidden shadow-2xl rotate-2 hover:rotate-0 transition duration-500">
                    <img src="https://images.unsplash.com/photo-1516035069371-29a1b244cc32?q=80&w=1000&auto=format&fit=crop"
                        alt="Event Photo" class="w-full h-[500px] object-cover" />
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
                        <div class="text-xl font-bold text-slate-900">10K+</div>
                        <div class="text-xs text-slate-500 font-medium">Events Created</div>
                    </div>
                </div>
            </div>
        </div>

        <div class="absolute top-0 right-0 -z-10 w-1/3 h-1/2 bg-gradient-to-b from-indigo-50 to-transparent opacity-50">
        </div>
    </section>

    <!--=============================================== SECTION HOW WORKIT =========================== -->

    <section class="py-24 bg-white relative overflow-hidden">
        <div class="max-w-6xl mx-auto px-6">
            <div class="text-center mb-20">
                <h2 class="text-4xl md:text-5xl font-extrabold text-slate-900 mb-4">How It Works</h2>
                <p class="text-lg text-slate-500 max-w-2xl mx-auto">Three simple steps to collect and share event photos
                    effortlessly</p>
            </div>

            <div class="relative">
                <div class="hidden md:block absolute top-12 left-0 w-full h-[2px] bg-slate-100 z-0"></div>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-12 relative z-10">
                    <div class="flex flex-col items-center text-center group">
                        <div class="relative mb-8">
                            <div
                                class="hidden md:block absolute -top-4 left-1/2 -translate-x-1/2 w-3 h-3 bg-white border-2 border-slate-200 rounded-full">
                            </div>
                            <div
                                class="w-24 h-24 bg-indigo-600 rounded-3xl shadow-xl shadow-indigo-200 flex items-center justify-center text-white transform transition group-hover:-translate-y-2">
                                <svg class="w-12 h-12" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                        d="M12 4v1m6 11h2m-6 0h-2v4m0-11v3m0 0h.01M12 12h4.01M16 20h4M4 12h4m12 0h.01M5 8h2a1 1 0 001-1V5a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1zm12 0h2a1 1 0 001-1V5a1 1 0 00-1-1h-2a1 1 0 00-1 1v2a1 1 0 001 1zM5 20h2a1 1 0 001-1v-2a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1z">
                                    </path>
                                </svg>
                            </div>
                        </div>
                        <h3 class="text-xl font-bold text-slate-900 mb-3">Create & Share QR Code</h3>
                        <p class="text-slate-500 leading-relaxed text-sm px-4">Generate a unique QR code for your event
                            in seconds. Share it with guests via print or digital display.</p>
                    </div>

                    <div class="flex flex-col items-center text-center group">
                        <div class="relative mb-8">
                            <div
                                class="hidden md:block absolute -top-4 left-1/2 -translate-x-1/2 w-3 h-3 bg-white border-2 border-slate-200 rounded-full">
                            </div>
                            <div
                                class="w-24 h-24 bg-purple-500 rounded-3xl shadow-xl shadow-purple-200 flex items-center justify-center text-white transform transition group-hover:-translate-y-2">
                                <svg class="w-12 h-12" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                        d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"></path>
                                </svg>
                            </div>
                        </div>
                        <h3 class="text-xl font-bold text-slate-900 mb-3">Guests Upload Photos</h3>
                        <p class="text-slate-500 leading-relaxed text-sm px-4">Guests scan the code and instantly upload
                            their photos to your secure cloud gallery.</p>
                    </div>

                    <div class="flex flex-col items-center text-center group">
                        <div class="relative mb-8">
                            <div
                                class="hidden md:block absolute -top-4 left-1/2 -translate-x-1/2 w-3 h-3 bg-white border-2 border-slate-200 rounded-full">
                            </div>
                            <div
                                class="w-24 h-24 bg-orange-400 rounded-3xl shadow-xl shadow-orange-100 flex items-center justify-center text-white transform transition group-hover:-translate-y-2">
                                <svg class="w-12 h-12" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                        d="M8.684 13.342C8.886 12.938 9 12.482 9 12c0-.482-.114-.938-.316-1.342m0 2.684a3 3 0 110-2.684m0 2.684l6.632 3.316m-6.632-6l6.632-3.316m0 0a3 3 0 105.367-2.684 3 3 0 00-5.367 2.684zm0 9.316a3 3 0 105.368 2.684 3 3 0 00-5.368-2.684z">
                                    </path>
                                </svg>
                            </div>
                        </div>
                        <h3 class="text-xl font-bold text-slate-900 mb-3">Share & Relive Memories</h3>
                        <p class="text-slate-500 leading-relaxed text-sm px-4">Access all photos in real-time.
                            Download, share, and create lasting memories with everyone.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!--================================== SECTION FEATURE====================================== -->

    <section class="py-24 bg-slate-50">
        <div class="max-w-6xl mx-auto px-6">
            <div class="text-center mb-16">
                <h2 class="text-4xl md:text-5xl font-extrabold text-slate-900 mb-4">Powerful Features</h2>
                <p class="text-lg text-slate-500 max-w-2xl mx-auto">Everything you need to create memorable event photo
                    experiences</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                <div
                    class="bg-white p-10 rounded-[2.5rem] border border-slate-100 shadow-sm hover:shadow-md transition-all group">
                    <div
                        class="w-12 h-12 bg-indigo-600 rounded-xl flex items-center justify-center text-white mb-6 shadow-lg shadow-indigo-100">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold text-slate-900 mb-3">Instant Upload</h3>
                    <p class="text-slate-500 leading-relaxed">Photos appear in your gallery instantly as guests upload
                        them during the event.</p>
                </div>

                <div
                    class="bg-white p-10 rounded-[2.5rem] border border-slate-100 shadow-sm hover:shadow-md transition-all group">
                    <div
                        class="w-12 h-12 bg-emerald-500 rounded-xl flex items-center justify-center text-white mb-6 shadow-lg shadow-emerald-100">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z">
                            </path>
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold text-slate-900 mb-3">Secure & Private</h3>
                    <p class="text-slate-500 leading-relaxed">Your photos are encrypted and stored securely in the
                        cloud with enterprise-grade security.</p>
                </div>

                <div
                    class="bg-white p-10 rounded-[2.5rem] border border-slate-100 shadow-sm hover:shadow-md transition-all group">
                    <div
                        class="w-12 h-12 bg-violet-500 rounded-xl flex items-center justify-center text-white mb-6 shadow-lg shadow-violet-100">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z">
                            </path>
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold text-slate-900 mb-3">Unlimited Guests</h3>
                    <p class="text-slate-500 leading-relaxed">No limits on the number of guests who can contribute
                        photos to your event gallery.</p>
                </div>

                <div
                    class="bg-white p-10 rounded-[2.5rem] border border-slate-100 shadow-sm hover:shadow-md transition-all group">
                    <div
                        class="w-12 h-12 bg-rose-400 rounded-xl flex items-center justify-center text-white mb-6 shadow-lg shadow-rose-100">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z">
                            </path>
                            <circle cx="12" cy="13" r="3" stroke="currentColor" stroke-width="2">
                            </circle>
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold text-slate-900 mb-3">High-Quality Storage</h3>
                    <p class="text-slate-500 leading-relaxed">Original quality photos preserved. Download
                        full-resolution images anytime.</p>
                </div>

                <div
                    class="bg-white p-10 rounded-[2.5rem] border border-slate-100 shadow-sm hover:shadow-md transition-all group">
                    <div
                        class="w-12 h-12 bg-pink-400 rounded-xl flex items-center justify-center text-white mb-6 shadow-lg shadow-pink-100">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z">
                            </path>
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold text-slate-900 mb-3">Gallery Layouts</h3>
                    <p class="text-slate-500 leading-relaxed">Beautiful, customizable gallery views to showcase your
                        event photos elegantly.</p>
                </div>

                <div
                    class="bg-white p-10 rounded-[2.5rem] border border-slate-100 shadow-sm hover:shadow-md transition-all group">
                    <div
                        class="w-12 h-12 bg-amber-400 rounded-xl flex items-center justify-center text-white mb-6 shadow-lg shadow-amber-100">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z">
                            </path>
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold text-slate-900 mb-3">AI Enhancement</h3>
                    <p class="text-slate-500 leading-relaxed">Optional AI-powered photo enhancement and automatic face
                        detection for easy sorting.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- ========================   SECTION  PRICING  ================================= -->

    <section class="py-24 bg-white">
        <div class="max-w-6xl mx-auto px-6">
            <div class="text-center mb-16">
                <h2 class="text-4xl md:text-5xl font-extrabold text-slate-900 mb-4">Simple, Transparent Pricing</h2>
                <p class="text-lg text-slate-500 max-w-2xl mx-auto">Choose the perfect plan for your event. No hidden
                    fees, no surprises.</p>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 items-center">
                <div
                    class="bg-white p-10 rounded-[2.5rem] border border-slate-100 shadow-xl shadow-slate-100/50 flex flex-col h-full">
                    <div class="text-center mb-8">
                        <h3 class="text-2xl font-bold text-slate-900">Basic</h3>
                        <p class="text-sm text-slate-500 mt-2">Perfect for small gatherings and intimate events</p>
                        <div class="mt-6 flex justify-center items-baseline gap-1">
                            <span class="text-5xl font-extrabold text-slate-900">$29</span>
                            <span class="text-slate-500 font-medium">/ per event</span>
                        </div>
                    </div>

                    <ul class="space-y-4 mb-10 flex-grow">
                        <li class="flex items-center gap-3 text-slate-600">
                            <span
                                class="w-5 h-5 bg-emerald-100 text-emerald-600 rounded-full flex items-center justify-center flex-shrink-0">
                                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3"
                                        d="M5 13l4 4L19 7"></path>
                                </svg>
                            </span>
                            Up to 100 photos
                        </li>
                        <li class="flex items-center gap-3 text-slate-600">
                            <span
                                class="w-5 h-5 bg-emerald-100 text-emerald-600 rounded-full flex items-center justify-center flex-shrink-0">
                                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3"
                                        d="M5 13l4 4L19 7"></path>
                                </svg>
                            </span>
                            5GB storage
                        </li>
                        <li class="flex items-center gap-3 text-slate-600">
                            <span
                                class="w-5 h-5 bg-emerald-100 text-emerald-600 rounded-full flex items-center justify-center flex-shrink-0">
                                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3"
                                        d="M5 13l4 4L19 7"></path>
                                </svg>
                            </span>
                            Basic gallery layouts
                        </li>
                        <li class="flex items-center gap-3 text-slate-600">
                            <span
                                class="w-5 h-5 bg-emerald-100 text-emerald-600 rounded-full flex items-center justify-center flex-shrink-0">
                                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3"
                                        d="M5 13l4 4L19 7"></path>
                                </svg>
                            </span>
                            QR code generation
                        </li>
                        <li class="flex items-center gap-3 text-slate-600">
                            <span
                                class="w-5 h-5 bg-emerald-100 text-emerald-600 rounded-full flex items-center justify-center flex-shrink-0">
                                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3"
                                        d="M5 13l4 4L19 7"></path>
                                </svg>
                            </span>
                            Email support
                        </li>
                        <li class="flex items-center gap-3 text-slate-600">
                            <span
                                class="w-5 h-5 bg-emerald-100 text-emerald-600 rounded-full flex items-center justify-center flex-shrink-0">
                                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3"
                                        d="M5 13l4 4L19 7"></path>
                                </svg>
                            </span>
                            30-day access
                        </li>
                    </ul>

                    <button
                        class="w-full py-4 bg-slate-50 hover:bg-slate-100 text-slate-900 font-bold rounded-2xl transition-colors">Get
                        Started</button>
                </div>

                <div
                    class="relative bg-white p-10 rounded-[2.5rem] border-2 border-indigo-600 shadow-2xl shadow-indigo-100 flex flex-col h-full transform lg:scale-105 z-10">
                    <div
                        class="absolute -top-5 left-1/2 -translate-x-1/2 bg-indigo-600 text-white px-6 py-2 rounded-full text-sm font-bold shadow-lg shadow-indigo-200">
                        Most Popular</div>

                    <div class="text-center mb-8">
                        <h3 class="text-2xl font-bold text-slate-900">Premium</h3>
                        <p class="text-sm text-slate-500 mt-2">Most popular for weddings and conferences</p>
                        <div class="mt-6 flex justify-center items-baseline gap-1">
                            <span class="text-5xl font-extrabold text-slate-900">$79</span>
                            <span class="text-slate-500 font-medium">/ per event</span>
                        </div>
                    </div>

                    <ul class="space-y-4 mb-10 flex-grow">
                        <li class="flex items-center gap-3 text-slate-600">
                            <span
                                class="w-5 h-5 bg-indigo-600 text-white rounded-full flex items-center justify-center flex-shrink-0">
                                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3"
                                        d="M5 13l4 4L19 7"></path>
                                </svg>
                            </span>
                            Unlimited photos
                        </li>
                        <li class="flex items-center gap-3 text-slate-600">
                            <span
                                class="w-5 h-5 bg-indigo-600 text-white rounded-full flex items-center justify-center flex-shrink-0">
                                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3"
                                        d="M5 13l4 4L19 7"></path>
                                </svg>
                            </span>
                            50GB storage
                        </li>
                        <li class="flex items-center gap-3 text-slate-600 italic opacity-80">(And everything in Basic +
                            AI features)</li>
                    </ul>

                    <button
                        class="w-full py-4 bg-indigo-600 hover:bg-indigo-700 text-white font-bold rounded-2xl transition-all shadow-lg shadow-indigo-200">Start
                        Premium</button>
                </div>

                <div
                    class="bg-white p-10 rounded-[2.5rem] border border-slate-100 shadow-xl shadow-slate-100/50 flex flex-col h-full">
                    <div class="text-center mb-8">
                        <h3 class="text-2xl font-bold text-slate-900">VVIP</h3>
                        <p class="text-sm text-slate-500 mt-2">Luxury experience for exclusive events</p>
                        <div class="mt-6 flex justify-center items-baseline gap-1">
                            <span class="text-5xl font-extrabold text-slate-900">$199</span>
                            <span class="text-slate-500 font-medium">/ per event</span>
                        </div>
                    </div>

                    <ul class="space-y-4 mb-10 flex-grow text-sm">
                        <li class="flex items-center gap-3 text-slate-600">
                            <span
                                class="w-5 h-5 bg-emerald-100 text-emerald-600 rounded-full flex items-center justify-center flex-shrink-0">
                                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3"
                                        d="M5 13l4 4L19 7"></path>
                                </svg>
                            </span>
                            Unlimited photos & 200GB storage
                        </li>
                        <li class="flex items-center gap-3 text-slate-600">
                            <span
                                class="w-5 h-5 bg-emerald-100 text-emerald-600 rounded-full flex items-center justify-center flex-shrink-0">
                                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3"
                                        d="M5 13l4 4L19 7"></path>
                                </svg>
                            </span>
                            White-label solution
                        </li>
                        <li class="flex items-center gap-3 text-slate-600">
                            <span
                                class="w-5 h-5 bg-emerald-100 text-emerald-600 rounded-full flex items-center justify-center flex-shrink-0">
                                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3"
                                        d="M5 13l4 4L19 7"></path>
                                </svg>
                            </span>
                            Professional editing
                        </li>
                        <li class="flex items-center gap-3 text-slate-600">
                            <span
                                class="w-5 h-5 bg-emerald-100 text-emerald-600 rounded-full flex items-center justify-center flex-shrink-0">
                                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3"
                                        d="M5 13l4 4L19 7"></path>
                                </svg>
                            </span>
                            Live slideshow
                        </li>
                    </ul>

                    <button
                        class="w-full py-4 bg-slate-50 hover:bg-slate-100 text-slate-900 font-bold rounded-2xl transition-colors">Go
                        Luxury</button>
                </div>
            </div>

            <div class="mt-16 text-center">
                <p class="text-slate-500">
                    Need a custom plan for multiple events?
                    <a href="#" class="text-indigo-600 font-bold hover:underline">Contact our sales team</a>
                </p>
            </div>
        </div>
    </section>

    <!-- ========================   SECTION  PRICING  ================================= -->

    <section class="py-24 bg-slate-50">
        <div class="max-w-6xl mx-auto px-6">
            <div class="text-center mb-16">
                <h2 class="text-4xl md:text-5xl font-extrabold text-slate-900 mb-4">Perfect for Every Occasion</h2>
                <p class="text-lg text-slate-500 max-w-2xl mx-auto">From intimate celebrations to large-scale events,
                    we've got you covered</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <div class="bg-white rounded-[2.5rem] overflow-hidden shadow-sm hover:shadow-xl transition-all group">
                    <div class="h-64 overflow-hidden">
                        <img src="https://images.unsplash.com/photo-1519741497674-611481863552?q=80&w=1000&auto=format&fit=crop"
                            alt="Weddings"
                            class="w-full h-full object-cover transition duration-500 group-hover:scale-110" />
                    </div>
                    <div class="p-10 relative">
                        <div
                            class="w-12 h-12 bg-pink-500 rounded-2xl flex items-center justify-center text-white mb-6 shadow-lg shadow-pink-100">
                            <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24">
                                <path
                                    d="M12 21.35l-1.45-1.32C5.4 15.36 2 12.28 2 8.5 2 5.42 4.42 3 7.5 3c1.74 0 3.41.81 4.5 2.09C13.09 3.81 14.76 3 16.5 3 19.58 3 22 5.42 22 8.5c0 3.78-3.4 6.86-8.55 11.54L12 21.35z" />
                            </svg>
                        </div>
                        <h3 class="text-2xl font-bold text-slate-900 mb-4">Weddings</h3>
                        <p class="text-slate-500 leading-relaxed text-sm">Capture every precious moment from multiple
                            perspectives. Let your guests contribute to your wedding album.</p>
                    </div>
                </div>

                <div
                    class="bg-white rounded-[2.5rem] overflow-hidden shadow-sm hover:shadow-xl transition-all group border-2 border-transparent hover:border-indigo-100">
                    <div class="h-64 overflow-hidden">
                        <img src="https://images.unsplash.com/photo-1505373633560-fa2a29a7df73?q=80&w=1000&auto=format&fit=crop"
                            alt="Seminars"
                            class="w-full h-full object-cover transition duration-500 group-hover:scale-110" />
                    </div>
                    <div class="p-10 relative">
                        <div
                            class="w-12 h-12 bg-indigo-600 rounded-2xl flex items-center justify-center text-white mb-6 shadow-lg shadow-indigo-100">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z">
                                </path>
                            </svg>
                        </div>
                        <h3 class="text-2xl font-bold text-slate-900 mb-4">Seminars & Conferences</h3>
                        <p class="text-slate-500 leading-relaxed text-sm">Professional event documentation made easy.
                            Share presentations, networking moments, and key highlights instantly.</p>
                    </div>
                </div>

                <div class="bg-white rounded-[2.5rem] overflow-hidden shadow-sm hover:shadow-xl transition-all group">
                    <div class="h-64 overflow-hidden">
                        <img src="https://images.unsplash.com/photo-1464366400600-7168b8af9bc3?q=80&w=1000&auto=format&fit=crop"
                            alt="Private Events"
                            class="w-full h-full object-cover transition duration-500 group-hover:scale-110" />
                    </div>
                    <div class="p-10 relative">
                        <div
                            class="w-12 h-12 bg-violet-500 rounded-2xl flex items-center justify-center text-white mb-6 shadow-lg shadow-violet-100">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M8 7V3m8 3v4m0 0l-4-4m4 4l4-4m-12 4h12M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z">
                                </path>
                            </svg>
                        </div>
                        <h3 class="text-2xl font-bold text-slate-900 mb-4">Private Events</h3>
                        <p class="text-slate-500 leading-relaxed text-sm">Birthday parties, anniversaries, and
                            celebrations. Create shared memories with friends and family effortlessly.</p>
                    </div>
                </div>
            </div>

            <div class="mt-20 text-center">
                <p class="text-slate-600 font-medium mb-6">Not sure which event type suits you best?</p>
                <button
                    class="bg-indigo-600 hover:bg-indigo-700 text-white px-10 py-4 rounded-2xl font-bold text-lg transition shadow-lg shadow-indigo-200">Talk
                    to Our Team</button>
            </div>
        </div>
    </section>

    <!-- ========================   SECTION  CTA  ================================= -->

    <section class="py-20 px-6">
        <div
            class="max-w-6xl mx-auto bg-gradient-to-br from-indigo-600 via-indigo-700 to-purple-700 rounded-[3rem] p-12 md:p-24 text-center relative overflow-hidden shadow-2xl shadow-indigo-200">
            <div
                class="absolute top-0 left-1/2 -translate-x-1/2 w-full h-full bg-[radial-gradient(circle_at_center,_var(--tw-gradient-stops))] from-white/10 to-transparent pointer-events-none">
            </div>

            <div
                class="inline-flex items-center justify-center w-16 h-16 bg-white/10 backdrop-blur-md rounded-2xl text-white mb-8 border border-white/20">
                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z">
                    </path>
                </svg>
            </div>

            <h2 class="text-4xl md:text-6xl font-extrabold text-white mb-6 leading-tight">
                Turn Every Event Into a <br />
                <span class="text-yellow-200">Shared Memory</span>
            </h2>

            <p class="text-indigo-100 text-lg md:text-xl max-w-2xl mx-auto mb-12 opacity-90">Start creating beautiful
                photo galleries that bring people together. No credit card required. Get started in minutes.</p>

            <div class="flex flex-wrap justify-center gap-4 mb-16">
                <button
                    class="bg-white text-indigo-700 hover:bg-indigo-50 px-10 py-4 rounded-2xl font-bold text-lg transition shadow-xl">Create
                    Your First Event</button>
                <button
                    class="bg-transparent border-2 border-white/30 hover:border-white/60 text-white px-10 py-4 rounded-2xl font-bold text-lg transition">Watch
                    Demo Video</button>
            </div>

            <div class="w-full h-px bg-white/20 mb-10"></div>

            <div class="flex flex-wrap justify-center gap-8 md:gap-16 text-white/90 font-medium">
                <div class="flex items-center gap-2">
                    <span class="text-yellow-400">★</span>
                    4.9/5 Rating
                </div>
                <div class="flex items-center gap-2">
                    <span class="w-2 h-2 bg-emerald-400 rounded-full"></span>
                    10,000+ Events
                </div>
                <div class="flex items-center gap-2">
                    <span class="w-2 h-2 bg-pink-400 rounded-full"></span>
                    500K+ Photos Shared
                </div>
            </div>
        </div>
    </section>

    <!-- ========================   SECTION  FOOTER  ================================= -->

    <footer class="bg-[#0f172a] text-slate-400 py-16">
        <div class="max-w-6xl mx-auto px-6">
            <div class="grid grid-cols-2 md:grid-cols-5 gap-12 mb-16">
                <div class="col-span-2">
                    <div class="text-2xl font-extrabold text-white mb-6">Event<span
                            class="text-indigo-400">Gallery</span></div>
                    <p class="mb-8 max-w-sm leading-relaxed">The modern way to collect and share event photos. Trusted
                        by thousands of event organizers worldwide.</p>
                    <div class="flex gap-4">
                        <a href="#"
                            class="w-10 h-10 bg-slate-800 rounded-lg flex items-center justify-center hover:bg-indigo-600 transition-colors">
                            <svg class="w-5 h-5 text-white" fill="currentColor" viewBox="0 0 24 24">
                                <path
                                    d="M24 4.557c-.883.392-1.832.656-2.828.775 1.017-.609 1.798-1.574 2.165-2.724-.951.564-2.005.974-3.127 1.195-.897-.957-2.178-1.555-3.594-1.555-3.179 0-5.515 2.966-4.797 6.045-4.091-.205-7.719-2.165-10.148-5.144-1.29 2.213-.669 5.108 1.523 6.574-.806-.026-1.566-.247-2.229-.616-.054 2.281 1.581 4.415 3.949 4.89-.693.188-1.452.232-2.224.084.626 1.956 2.444 3.379 4.6 3.419-2.07 1.623-4.678 2.348-7.29 2.04 2.179 1.397 4.768 2.212 7.548 2.212 9.142 0 14.307-7.721 13.995-14.646.962-.695 1.797-1.562 2.457-2.549z" />
                            </svg>
                        </a>
                        <a href="#"
                            class="w-10 h-10 bg-slate-800 rounded-lg flex items-center justify-center hover:bg-indigo-600 transition-colors">
                            <svg class="w-5 h-5 text-white" fill="currentColor" viewBox="0 0 24 24">
                                <path
                                    d="M19 0h-14c-2.761 0-5 2.239-5 5v14c0 2.761 2.239 5 5 5h14c2.762 0 5-2.239 5-5v-14c0-2.761-2.238-5-5-5zm-11 19h-3v-11h3v11zm-1.5-12.268c-.966 0-1.75-.79-1.75-1.764s.784-1.764 1.75-1.764 1.75.79 1.75 1.764-.783 1.764-1.75 1.764zm13.5 12.268h-3v-5.604c0-3.368-4-3.113-4 0v5.604h-3v-11h3v1.765c1.396-2.586 7-2.777 7 2.476v6.759z" />
                            </svg>
                        </a>
                        <a href="#"
                            class="w-10 h-10 bg-slate-800 rounded-lg flex items-center justify-center hover:bg-indigo-600 transition-colors">
                            <svg class="w-5 h-5 text-white" fill="currentColor" viewBox="0 0 24 24">
                                <path
                                    d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z" />
                            </svg>
                        </a>
                    </div>
                </div>

                <div>
                    <h4 class="text-white font-bold mb-6">Product</h4>
                    <ul class="space-y-4">
                        <li><a href="#" class="hover:text-white transition">Features</a></li>
                        <li><a href="#" class="hover:text-white transition">Pricing</a></li>
                        <li><a href="#" class="hover:text-white transition">Use Cases</a></li>
                        <li><a href="#" class="hover:text-white transition">Demo</a></li>
                        <li><a href="#" class="hover:text-white transition">Updates</a></li>
                    </ul>
                </div>

                <div>
                    <h4 class="text-white font-bold mb-6">Company</h4>
                    <ul class="space-y-4">
                        <li><a href="#" class="hover:text-white transition">About Us</a></li>
                        <li><a href="#" class="hover:text-white transition">Careers</a></li>
                        <li><a href="#" class="hover:text-white transition">Press Kit</a></li>
                        <li><a href="#" class="hover:text-white transition">Contact</a></li>
                        <li><a href="#" class="hover:text-white transition">Partners</a></li>
                    </ul>
                </div>

                <div>
                    <h4 class="text-white font-bold mb-6">Resources</h4>
                    <ul class="space-y-4">
                        <li><a href="#" class="hover:text-white transition">Documentation</a></li>
                        <li><a href="#" class="hover:text-white transition">Help Center</a></li>
                        <li><a href="#" class="hover:text-white transition">Blog</a></li>
                        <li><a href="#" class="hover:text-white transition">Community</a></li>
                        <li><a href="#" class="hover:text-white transition">Status</a></li>
                    </ul>
                </div>

                <div class="hidden md:block">
                    <h4 class="text-white font-bold mb-6">Legal</h4>
                    <ul class="space-y-4">
                        <li><a href="#" class="hover:text-white transition">Privacy Policy</a></li>
                        <li><a href="#" class="hover:text-white transition">Terms of Service</a></li>
                        <li><a href="#" class="hover:text-white transition">Cookie Policy</a></li>
                        <li><a href="#" class="hover:text-white transition">GDPR</a></li>
                        <li><a href="#" class="hover:text-white transition">Security</a></li>
                    </ul>
                </div>
            </div>

            <div class="pt-8 border-t border-slate-800 flex flex-col md:flex-row justify-between items-center gap-6">
                <div class="text-sm">© 2024 EventGallery. All rights reserved.</div>
                <div class="flex gap-8 text-sm">
                    <a href="#" class="hover:text-white transition">Privacy</a>
                    <a href="#" class="hover:text-white transition">Terms</a>
                    <a href="#" class="hover:text-white transition">Cookies</a>
                </div>
            </div>
        </div>
    </footer>
</body>

</html>
