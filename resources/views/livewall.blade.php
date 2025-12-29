<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Live Photo Wall</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />

    <style>
        body {
            font-family: 'Inter', sans-serif;
        }

        ::-webkit-scrollbar {
            width: 8px;
        }

        ::-webkit-scrollbar-track {
            background: #0f172a;
        }

        ::-webkit-scrollbar-thumb {
            background: #334155;
            border-radius: 4px;
        }

        ::-webkit-scrollbar-thumb:hover {
            background: #435ebf;
        }

        .glow-blue {
            box-shadow: 0 0 20px rgba(67, 94, 191, 0.4);
        }

        .glow-input:focus {
            box-shadow: 0 0 0 2px rgba(67, 94, 191, 0.3);
        }

        .glass-panel {
            background: rgba(20, 20, 20, 0.95);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.1);
        }
    </style>
</head>

<body class="bg-black overflow-hidden text-white">

    <div id="setupModal" class="fixed inset-0 z-50 flex items-center justify-center p-4">
        <div class="absolute inset-0 bg-black/90 backdrop-blur-md"></div>

        <div
            class="relative w-full max-w-5xl glass-panel rounded-3xl overflow-hidden shadow-2xl flex flex-col md:flex-row animate-fade-in-up">

            <div class="absolute top-0 left-0 w-full h-1 bg-[#435ebf] shadow-[0_0_15px_#435ebf]"></div>

            <div
                class="w-full md:w-5/12 p-8 bg-[#0a0a0a] border-b md:border-b-0 md:border-r border-white/10 flex flex-col">
                <div class="mb-6">
                    <h2 class="text-2xl font-bold text-white tracking-tight flex items-center gap-2">
                        <span class="w-2 h-8 bg-[#435ebf] rounded-full"></span>
                        Soundtrack
                    </h2>
                    <p class="text-xs text-gray-400 mt-1 ml-4">Setel suasana dengan musik latar.</p>
                </div>

                @if ($canUseMusic)
                    <div class="space-y-5 flex-1">
                        <div>
                            <label class="text-xs font-semibold text-gray-400 uppercase tracking-wider mb-2 block">Cari
                                Lagu
                                (YouTube)</label>
                            <div class="relative group">
                                <input id="musicQuery" type="text" placeholder="Coldplay - A Sky Full of Stars..."
                                    class="w-full bg-[#1a1a1a] border border-white/10 text-white text-sm rounded-xl px-4 py-3 pl-10 focus:outline-none focus:border-[#435ebf] glow-input transition-all placeholder-gray-600">
                                <svg class="w-4 h-4 text-gray-500 absolute left-3.5 top-3.5 group-focus-within:text-[#435ebf] transition-colors"
                                    fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                                </svg>
                            </div>
                            <button onclick="searchMusic()"
                                class="mt-3 w-full bg-[#1a1a1a] hover:bg-[#252525] text-white border border-white/10 hover:border-[#435ebf] rounded-xl py-2.5 text-sm font-medium transition-all duration-300 flex items-center justify-center gap-2 group">
                                <span>Cari Lagu</span>
                                <svg class="w-4 h-4 text-gray-500 group-hover:text-[#435ebf] transition-colors"
                                    fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M14 5l7 7m0 0l-7 7m7-7H3"></path>
                                </svg>
                            </button>
                        </div>

                        <div id="musicStatus"
                            class="relative overflow-hidden bg-[#435ebf]/10 border border-[#435ebf]/30 rounded-xl p-4 min-h-[80px] flex items-center justify-center text-center">
                            <div class="absolute top-0 right-0 p-2 opacity-20">
                                <svg class="w-12 h-12 text-[#435ebf]" fill="currentColor" viewBox="0 0 24 24">
                                    <path
                                        d="M12 3v10.55c-.59-.34-1.27-.55-2-.55-2.21 0-4 1.79-4 4s1.79 4 4 4 4-1.79 4-4V7h4V3h-6z" />
                                </svg>
                            </div>
                            <span class="text-sm text-[#435ebf] font-medium relative z-10">Belum ada lagu dipilih</span>
                        </div>
                    </div>
                @else
                    <div
                        class="flex-1 flex flex-col items-center justify-center text-center p-6 bg-[#1a1a1a]/50 border border-dashed border-white/10 rounded-2xl relative overflow-hidden group">

                        <div
                            class="absolute inset-0 bg-gradient-to-b from-[#435ebf]/5 to-transparent opacity-0 group-hover:opacity-100 transition-duration-500 transition-opacity pointer-events-none">
                        </div>

                        <div
                            class="w-12 h-12 bg-[#0a0a0a] border border-white/10 rounded-full flex items-center justify-center mb-3 group-hover:border-[#435ebf]/50 transition-colors duration-300 z-10 shadow-lg shadow-black/50">
                            <svg class="w-5 h-5 text-gray-400 group-hover:text-[#435ebf] transition-colors"
                                fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z">
                                </path>
                            </svg>
                        </div>

                        <h3 class="text-sm font-bold text-white mb-1 z-10">Fitur Terkunci</h3>
                        <p class="text-xs text-gray-500 mb-5 max-w-[200px] z-10">
                            Upgrade ke paket <span class="text-[#435ebf] font-bold">PRO</span> untuk menyisipkan lagu
                            favorit dari YouTube.
                        </p>

                        <a href="{{ route('home.subscribe') }}"
                            class="px-5 py-2.5 bg-[#435ebf] hover:bg-[#364a96] text-white text-xs font-bold rounded-xl transition-all shadow-lg shadow-[#435ebf]/20 hover:shadow-[#435ebf]/40 z-10 flex items-center gap-2">
                            <span>Buka Akses Pro</span>
                            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M13 7l5 5m0 0l-5 5m5-5H6"></path>
                            </svg>
                        </a>
                    </div>
                @endif

                <div class="mt-6 pt-6 border-t border-white/10">
                    <p class="text-[10px] text-gray-500 leading-relaxed text-justify">
                        <strong class="text-gray-300">Catatan:</strong> Audio akan dimute secara default (kebijakan
                        browser). Unmute manual diperlukan setelah start.
                    </p>
                </div>
            </div>

            <div class="w-full md:w-7/12 p-8 bg-[#0f0f0f] relative">
                <div class="mb-8 flex justify-between items-end">
                    <div>
                        <h2 class="text-2xl font-bold text-white tracking-tight">Konfigurasi</h2>
                        <p class="text-sm text-gray-400 mt-1">Sesuaikan tampilan Livewall Anda.</p>
                    </div>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">

                    <div class="space-y-2">
                        <label class="text-xs font-semibold text-gray-400 uppercase tracking-wider">Kecepatan
                            Slide</label>
                        <div class="relative">
                            <select id="speed"
                                class="w-full bg-[#1a1a1a] border border-white/10 text-white rounded-xl px-4 py-3 focus:outline-none focus:border-[#435ebf] glow-input appearance-none cursor-pointer">
                                <option value="slower">Slower (8s)</option>
                                <option value="normal" selected>Best (5s)</option>
                                <option value="faster">Faster (2.5s)</option>
                            </select>
                            <div
                                class="absolute inset-y-0 right-0 flex items-center px-4 pointer-events-none text-gray-400">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M19 9l-7 7-7-7"></path>
                                </svg>
                            </div>
                        </div>
                    </div>

                    <div class="space-y-2">
                        <label class="text-xs font-semibold text-gray-400 uppercase tracking-wider">Mode Rotasi</label>
                        <div class="relative">
                            <select id="rotation"
                                class="w-full bg-[#1a1a1a] border border-white/10 text-white rounded-xl px-4 py-3 focus:outline-none focus:border-[#435ebf] glow-input appearance-none cursor-pointer">
                                <option value="dynamic" selected>Dynamic (Acak)</option>
                                <option value="single">Single (Urut)</option>
                            </select>
                            <div
                                class="absolute inset-y-0 right-0 flex items-center px-4 pointer-events-none text-gray-400">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M19 9l-7 7-7-7"></path>
                                </svg>
                            </div>
                        </div>
                    </div>

                    <div class="space-y-2 sm:col-span-2">
                        <label class="text-xs font-semibold text-gray-400 uppercase tracking-wider">Posisi QR
                            Code</label>
                        <div class="grid grid-cols-2 gap-3">
                            <select id="qrPosition"
                                class="w-full bg-[#1a1a1a] border border-white/10 text-white rounded-xl px-4 py-3 focus:outline-none focus:border-[#435ebf] glow-input appearance-none cursor-pointer">
                                <option value="br">Kanan Bawah (Default)</option>
                                <option value="tr">Kanan Atas</option>
                                <option value="bl">Kiri Bawah</option>
                                <option value="tl">Kiri Atas</option>
                            </select>

                            <label
                                class="flex items-center justify-center gap-3 bg-[#1a1a1a] border border-white/10 rounded-xl px-4 py-3 cursor-pointer hover:bg-[#252525] transition-colors select-none">
                                <div class="relative flex items-center">
                                    <input id="toggleQR" type="checkbox" checked
                                        class="peer h-5 w-5 cursor-pointer appearance-none rounded-md border border-gray-500 transition-all checked:border-[#435ebf] checked:bg-[#435ebf]">
                                    <svg class="pointer-events-none absolute left-1/2 top-1/2 -translate-x-1/2 -translate-y-1/2 text-white opacity-0 peer-checked:opacity-100"
                                        xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none"
                                        stroke="currentColor" stroke-width="4" stroke-linecap="round"
                                        stroke-linejoin="round" width="12" height="12">
                                        <polyline points="20 6 9 17 4 12"></polyline>
                                    </svg>
                                </div>
                                <span class="text-sm font-medium">Tampilkan QR</span>
                            </label>
                        </div>
                    </div>
                </div>

                <div class="mt-10">
                    <button onclick="startLivewall()"
                        class="w-full bg-[#435ebf] hover:bg-[#364b99] text-white rounded-xl py-4 font-bold tracking-widest text-lg shadow-[0_4px_14px_0_rgba(67,94,191,0.39)] hover:shadow-[0_6px_20px_rgba(67,94,191,0.23)] hover:-translate-y-1 transition-all duration-300 flex items-center justify-center gap-3">
                        <svg class="w-6 h-6 animate-pulse" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M8 5v14l11-7z" />
                        </svg>
                        START LIVEWALL
                    </button>
                </div>
            </div>

        </div>
    </div>


    <div id="livewall" class="hidden">
        <div class="swiper w-screen h-screen">
            <div class="swiper-wrapper">
                @php $buffer = null; @endphp
                @foreach ($photos as $photo)
                    @php $isPortrait = ($photo->height ?? 0) > ($photo->width ?? 0); @endphp
                    @if ($isPortrait)
                        @if ($buffer)
                            <div class="swiper-slide flex items-center justify-center gap-6 px-10">
                                <img src="{{ asset('storage/' . $buffer->file_path) }}"
                                    class="w-1/2 h-full object-contain zoom">
                                <img src="{{ asset('storage/' . $photo->file_path) }}"
                                    class="w-1/2 h-full object-contain zoom">
                            </div>
                            @php $buffer = null; @endphp
                        @else
                            @php $buffer = $photo; @endphp
                        @endif
                    @else
                        <div class="swiper-slide flex items-center justify-center">
                            <img src="{{ asset('storage/' . $photo->file_path) }}"
                                class="max-w-full max-h-full object-contain zoom">
                        </div>
                    @endif
                @endforeach
                @if ($buffer)
                    <div class="swiper-slide flex items-center justify-center">
                        <img src="{{ asset('storage/' . $buffer->file_path) }}"
                            class="max-w-full max-h-full object-contain zoom">
                    </div>
                @endif
            </div>
        </div>

        <div id="qrBox" class="fixed z-40 bg-white p-3 rounded-xl shadow-xl">
            <img src="{{ asset('qr/' . $link->generate_qr_code) }}" class="w-28 h-28">
        </div>
    </div>

    <div id="player"></div>



    <style>
        .swiper-slide {
            display: flex;
            justify-content: center;
            align-items: center;
            width: 100%;
            height: 100%;
            overflow: hidden;
        }

        .swiper-slide img.zoom {
            width: 100%;
            height: 100%;
            object-fit: cover;
            object-position: center;
            animation: zoomInEffect 10s ease-in-out forwards;
        }

        @keyframes zoomInEffect {
            0% {
                transform: scale(1);
            }

            100% {
                transform: scale(1.12);
            }
        }
    </style>


    <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
    <script src="https://www.youtube.com/iframe_api"></script>


    <script>
        const CAN_USE_MUSIC = @json($canUseMusic);
        let swiper;
        let selectedVideoId = null;
        let player;

        const speedMap = {
            slower: 8000,
            normal: 5000,
            faster: 2500
        };

        async function searchMusic() {

            const query = document.getElementById('musicQuery').value;
            const status = document.getElementById('musicStatus');
            const KEY = "{{ config('services.youtube.key') }}";

            if (!CAN_USE_MUSIC) {
                alert('Fitur musik hanya tersedia untuk PRO Package');
                return;
            }

            if (!query) {
                status.innerHTML = '<span class="text-red-400">Silakan ketik judul lagu</span>';
                return;
            }

            status.innerHTML = '<span class="text-gray-300 animate-pulse">Sedang mencari...</span>';

            try {
                const res = await fetch(
                    `https://www.googleapis.com/youtube/v3/search?part=snippet&type=video&maxResults=1&q=${encodeURIComponent(query)}&key=${KEY}`
                );
                const data = await res.json();

                if (data.items?.length) {
                    selectedVideoId = data.items[0].id.videoId;
                    const title = data.items[0].snippet.title;
                    status.innerHTML = `
                <div class="flex flex-col items-center">
                    <span class="text-xs text-gray-400 mb-1">Siap Diputar:</span>
                    <span class="text-[#435ebf] font-bold line-clamp-2">${title}</span>
                </div>
            `;
                    status.className =
                        "relative overflow-hidden bg-[#435ebf]/10 border border-[#435ebf] rounded-xl p-4 min-h-[80px] flex items-center justify-center text-center shadow-[0_0_15px_rgba(67,94,191,0.2)] transition-all";
                } else {
                    status.innerHTML = '<span class="text-red-400">Lagu tidak ditemukan</span>';
                }
            } catch (error) {
                console.error(error);
                status.innerHTML = '<span class="text-red-400">Error API</span>';
            }
        }

        function startLivewall() {
            document.getElementById('setupModal').classList.add('hidden');
            document.getElementById('livewall').classList.remove('hidden');

            initSwiper();
            setQrPosition();
            handleQrToggle();

            if (selectedVideoId) playMusic(selectedVideoId);

            document.documentElement.requestFullscreen().catch(e => console.log(e));
        }

        function initSwiper() {
            const speed = speedMap[document.getElementById('speed').value];
            const rotation = document.getElementById('rotation').value;

            if (swiper) swiper.destroy(true, true);

            swiper = new Swiper('.swiper', {
                loop: true,
                effect: 'fade',
                autoplay: {
                    delay: speed,
                    disableOnInteraction: false
                },
                on: {
                    slideChangeTransitionStart() {
                        if (rotation === 'dynamic') {
                            swiper.slideTo(
                                Math.floor(Math.random() * swiper.slides.length),
                                0
                            );
                        }
                    }
                }
            });
        }

        function setQrPosition() {
            const pos = document.getElementById('qrPosition').value;
            const qr = document.getElementById('qrBox');

            qr.className = 'fixed z-40 bg-white p-3 rounded-xl shadow-xl';
            if (pos === 'br') qr.classList.add('bottom-6', 'right-6');
            if (pos === 'tr') qr.classList.add('top-6', 'right-6');
            if (pos === 'bl') qr.classList.add('bottom-6', 'left-6');
            if (pos === 'tl') qr.classList.add('top-6', 'left-6');
        }

        function handleQrToggle() {
            const isChecked = document.getElementById('toggleQR').checked;
            const qr = document.getElementById('qrBox');
            qr.style.display = isChecked ? 'block' : 'none';
        }

        function playMusic(videoId) {
            if (!CAN_USE_MUSIC) {
                alert('Fitur musik hanya tersedia untuk PRO Package');
                return;
            }
            if (player) player.destroy();


            const playerDiv = document.getElementById('player');
            playerDiv.innerHTML = '';

            player = new YT.Player('player', {
                height: '0',
                width: '0',
                videoId: videoId,
                playerVars: {
                    autoplay: 1,
                    controls: 0,
                    loop: 1,
                    playlist: videoId,
                    modestbranding: 1,
                    rel: 0
                },
                events: {
                    'onReady': (event) => {
                        event.target.setVolume(50);
                        event.target.playVideo();
                    },
                    'onStateChange': (event) => {
                        if (event.data === YT.PlayerState.ENDED) {
                            event.target.playVideo();
                        }
                    }
                }
            });
        }

        function onYouTubeIframeAPIReady() {
            if (selectedVideoId) playMusic(selectedVideoId);
        }
    </script>


</body>

</html>
