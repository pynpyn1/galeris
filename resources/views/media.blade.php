<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $link->folder->name ?? 'Gallery' }}</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,400..900;1,400..900&family=Inter:wght@300;400;500;600&display=swap"
        rel="stylesheet">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    <style>
        :root {
            --primary-blue: #435ebf;
            --dark-blue: #364ea4;
            --bg-gray: #f9fafb;
            --selection-gold: #435ebf;
            --border-radius-sm: 6px;
            --border-radius-md: 10px;
            --border-radius-lg: 20px;
        }

        body {
            background-color: var(--bg-gray);
            font-family: 'Inter', sans-serif;
            color: #1f2937;
            overflow-x: hidden;
        }

        .hero-section {
            position: relative;
            height: 420px;
            margin: 20px;
            border-radius: var(--border-radius-lg);
            overflow: hidden;
            background: url('{{ $link->folder->thumbnail }}') center/cover no-repeat;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            color: white;
            text-align: center;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
        }

        .hero-overlay {
            position: absolute;
            inset: 0;
            background: rgba(0, 0, 0, 0.4);
            border: 1px solid rgba(255, 255, 255, 0.1);
            border-radius: var(--border-radius-lg);
            pointer-events: none;
        }

        .hero-content {
            position: relative;
            z-index: 2;
            width: 90%;
        }

        .hero-title {
            font-family: 'Playfair Display', serif;
            font-size: 4rem;
            font-weight: 700;
            margin-bottom: 10px;
            text-shadow: 0 2px 4px rgba(0, 0, 0, 0.3);
        }

        .hero-date-wrapper {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 20px;
            max-width: 500px;
            margin: 0 auto;
        }

        .date-line {
            height: 1px;
            flex-grow: 1;
            background: rgba(255, 255, 255, 0.6);
        }

        .hero-date {
            font-size: 1rem;
            font-weight: 500;
            letter-spacing: 4px;
            text-transform: uppercase;
            color: rgba(255, 255, 255, 0.95);
        }

        .top-nav-actions {
            position: absolute;
            top: 25px;
            left: 30px;
            right: 30px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            z-index: 10;
        }

        .logo-wrapper img {
            height: 40px;
            filter: brightness(0) invert(1);
        }

        .btn-download-main {
            background: white;
            color: #333 !important;
            border: 1px solid rgba(255, 255, 255, 0.2);
            border-radius: var(--border-radius-sm);
            padding: 10px 20px;
            font-size: 0.9rem;
            font-weight: 600;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            transition: 0.2s;
        }

        .btn-download-main:hover {
            background: #f0f0f0;
        }

        .filter-container {
            margin: -30px 20px 30px 20px;
            padding: 0 10px;
            position: relative;
            z-index: 20;
        }

        .search-bar-wrapper {
            background: white;
            border-radius: var(--border-radius-md);
            padding: 6px 6px 6px 15px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.06);
            border: 1px solid #eee;
            display: flex;
            align-items: center;
            width: 100%;
            max-width: 400px;
        }

        .search-bar-wrapper input {
            border: none;
            outline: none;
            width: 100%;
            font-size: 0.95rem;
            background: transparent;
        }

        .btn-send-wa {
            background-color: var(--primary-blue);
            border: none;
            border-radius: var(--border-radius-sm);
            width: 38px;
            height: 38px;
            color: white;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: 0.2s;
            flex-shrink: 0;
        }

        .btn-send-wa:hover {
            background-color: var(--dark-blue);
        }

        .tag-pill {
            background: white;
            border: 1px solid #e5e7eb;
            padding: 8px 16px;
            border-radius: var(--border-radius-sm);
            color: #4b5563;
            font-size: 0.85rem;
            cursor: pointer;
            transition: 0.2s;
            font-weight: 500;
        }

        .tag-pill.active,
        .tag-pill:hover {
            background: #f3f4f6;
            color: #111;
            border-color: #d1d5db;
        }

        .tag-pill.active {
            background: var(--primary-blue);
            color: white;
            border-color: var(--primary-blue);
        }

        .gallery-grid {
            columns: 8;
            column-gap: 8px;
            margin: 0 20px 40px 20px;
            padding: 0 10px;
        }

        .gallery-item {
            break-inside: avoid;
            margin-bottom: 12px;
            border-radius: var(--border-radius-sm);
            overflow: hidden;
            position: relative;
            transition: transform 0.2s ease, opacity 0.3s ease;
            transform: scale(1);
            opacity: 1;
            cursor: pointer;
            user-select: none;
            border: 3px solid transparent;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.05);
        }

        .gallery-item.selected {
            border-color: var(--selection-gold);
            transform: scale(0.97);
        }

        .select-badge {
            position: absolute;
            top: 8px;
            right: 8px;
            background: var(--selection-gold);
            color: white;
            width: 22px;
            height: 22px;
            border-radius: 4px;
            display: none;
            align-items: center;
            justify-content: center;
            font-size: 0.85rem;
            z-index: 5;
        }

        .gallery-item.selected .select-badge {
            display: flex;
        }

        .gallery-item.anim-zoom-out {
            transform: scale(0.9);
            opacity: 0;
        }

        .gallery-item.d-none-custom {
            display: none;
        }

        .gallery-item img,
        .gallery-item video {
            width: 100%;
            display: block;
        }

        .selection-bar {
            position: fixed;
            bottom: 30px;
            left: 50%;
            transform: translateX(-50%) translateY(150%);
            background: #1f2937;
            color: white;
            padding: 10px 15px;
            border-radius: var(--border-radius-md);
            display: flex;
            align-items: center;
            gap: 15px;
            z-index: 1000;
            box-shadow: 0 15px 40px rgba(0, 0, 0, 0.25);
            transition: transform 0.4s cubic-bezier(0.16, 1, 0.3, 1);
            min-width: 320px;
            border: 1px solid #374151;
        }

        .selection-bar.active {
            transform: translateX(-50%) translateY(0);
        }

        .count-circle {
            background: white;
            color: #1f2937;
            min-width: 24px;
            height: 24px;
            padding: 0 6px;
            border-radius: 4px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 700;
            font-size: 0.8rem;
        }

        .btn-download-selected {
            background: var(--primary-blue);
            border: none;
            color: white;
            padding: 8px 16px;
            border-radius: 6px;
            font-weight: 500;
            font-size: 0.9rem;
            display: flex;
            align-items: center;
            gap: 8px;
            transition: 0.2s;
        }

        .btn-download-selected:hover {
            background: var(--dark-blue);
        }

        .btn-select-all {
            background: rgba(255, 255, 255, 0.1);
            border: none;
            color: white;
            width: 36px;
            height: 36px;
            border-radius: 6px;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: 0.2s;
            cursor: pointer;
            font-size: 1.2rem;
        }

        .btn-select-all:hover {
            background: rgba(255, 255, 255, 0.2);
            color: #fff;
        }

        .selection-divider {
            width: 1px;
            height: 20px;
            background: #4b5563;
        }

        .btn-close-selection {
            background: transparent;
            border: none;
            color: #9ca3af;
            font-size: 1.2rem;
            cursor: pointer;
            padding: 0;
            line-height: 1;
        }

        .btn-close-selection:hover {
            color: white;
        }

        .empty-gallery {
            column-span: all;
            text-align: center;
            padding: 80px 0;
        }

        .modal-content {
            border-radius: var(--border-radius-lg);
            border: none;
            overflow: hidden;
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.25);
        }

        .form-control-clean {
            border-radius: var(--border-radius-sm) !important;
            padding: 12px;
            background-color: #f9fafb;
            border: 1px solid #e5e7eb;
        }

        .form-control-clean:focus {
            background-color: white;
            box-shadow: 0 0 0 2px rgba(67, 94, 191, 0.2);
            border-color: var(--primary-blue);
        }

        .btn-clean-primary {
            border-radius: var(--border-radius-sm);
            background-color: var(--primary-blue);
            color: white;
            font-weight: 500;
            padding: 10px 24px;
        }

        .btn-clean-secondary {
            border-radius: var(--border-radius-sm);
            background-color: white;
            border: 1px solid #e5e7eb;
            color: #374151;
            font-weight: 500;
            padding: 10px 20px;
        }

        @media (max-width: 1400px) {
            .gallery-grid {
                columns: 5;
            }
        }

        @media (max-width: 1100px) {
            .gallery-grid {
                columns: 4;
            }
        }

        @media (max-width: 992px) {
            .gallery-grid {
                columns: 3;
            }

            .hero-title {
                font-size: 3rem;
            }
        }

        @media (max-width: 576px) {
            .gallery-grid {
                columns: 2;
            }

            .hero-title {
                font-size: 2.2rem;
            }

            .search-bar-wrapper {
                max-width: 100%;
            }

            .selection-bar {
                min-width: 90%;
                bottom: 20px;
            }

            .hero-section {
                margin: 10px;
                height: 350px;
            }

            .filter-container {
                margin: -25px 10px 30px 10px;
            }

            .gallery-grid {
                margin: 0 10px 40px 10px;
            }
        }

        .logo-light,
        .logo-dark {
            height: 40px;
            position: absolute;
            top: 0;
            left: 0;
            transition: opacity 0.3s;
        }

        .logo-light {
            opacity: 1;
        }

        .logo-dark {
            opacity: 0;
        }
    </style>
</head>

<body>
    <div class="modal fade" id="nameInputModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header border-0 p-4 pb-0">
                    <div>
                        <h5 class="modal-title fw-bold mb-1 text-dark">Satu langkah lagi!</h5>
                        <p class="mb-0 text-muted" style="font-size: 0.9rem;">Siapa nama Kakak?</p>
                    </div>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <form action="{{ route('guest.store', $link->folder->id) }}" method="post">
                    @csrf
                    <div class="modal-body p-4">

                        <div class="mb-3">
                            <label for="inputName" class="form-label text-muted small fw-bold text-uppercase"
                                style="font-size: 0.75rem; letter-spacing: 0.5px;">Nama Anda</label>
                            <input type="text" name="name"
                                class="form-control form-control-lg form-control-clean border-0" id="inputName"
                                placeholder="Tulis nama Kakak di sini..." required>
                        </div>

                        <input type="hidden" name="number" id="hiddenNumber">

                        <div class="p-3 bg-light rounded-2 border d-flex align-items-center gap-2" role="alert">
                            <i class="bi bi-whatsapp text-success"></i>
                            <small class="text-muted">Nomor WA: <span id="previewNumber"
                                    class="fw-bold text-dark"></span></small>
                        </div>

                    </div>
                    <div class="modal-footer border-0 p-4 pt-0">
                        <button type="button" class="btn btn-clean-secondary" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-clean-primary shadow-sm">
                            Kirim <i class="bi bi-arrow-right ms-2"></i>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="hero-section">
        <div class="hero-overlay"></div>
        <div class="top-nav-actions">
            <a href="/" class="logo-wrapper">
                <img src="{{ asset('asset/img/GALLERIS_LOGO.png') }}" alt="Logo" class="logo-light">
                <img src="{{ asset('asset/img/GALLERIS_WHITE.png') }}" alt="Logo" class="logo-dark">
            </a>
        </div>

        <div class="hero-content">
            <h1 class="hero-title">{{ $link->folder->name }}</h1>
            <div class="hero-date-wrapper">
                <div class="date-line"></div>
                <span
                    class="hero-date mx-3">{{ \Carbon\Carbon::parse($link->folder->date_event)->format('d . m . Y') }}</span>
                <div class="date-line"></div>
            </div>
        </div>
    </div>

    <div class="filter-container">
        <div class="row g-4 align-items-center">
            <div class="col-12 col-md-6 col-lg-5">
                <form action="{{ route('guest.store', $link->folder->id) }}" method="post">
                    @csrf
                    <div class="search-bar-wrapper">
                        <input id="displayNumber" type="tel" placeholder="Kirim link ke WhatsApp..."
                            class="form-control border-0 shadow-none p-0 ps-1">
                        <button type="button" class="btn-send-wa" id="btnTriggerModal">
                            <i class="bi bi-send-fill" style="font-size: 0.9rem;"></i>
                        </button>
                    </div>
                </form>
            </div>

            <div class="col-12 col-md-6 col-lg-7 text-md-end">
                <div class="d-flex flex-wrap gap-2 justify-content-md-end align-items-center">
                    @php
                        $imgExt = ['jpg', 'jpeg', 'png', 'webp', 'gif'];
                        $vidExt = ['mp4', 'mov', 'avi', 'webm'];

                        $photosCount = $media
                            ->filter(
                                fn($m) => in_array(strtolower(pathinfo($m->file_path, PATHINFO_EXTENSION)), $imgExt),
                            )
                            ->count();
                        $videosCount = $media
                            ->filter(
                                fn($m) => in_array(strtolower(pathinfo($m->file_path, PATHINFO_EXTENSION)), $vidExt),
                            )
                            ->count();
                    @endphp

                    <div class="tag-pill filter-btn active" data-target="all">Semua</div>
                    @if ($photosCount > 0)
                        <div class="tag-pill filter-btn" data-target="photo">Foto ({{ $photosCount }})</div>
                    @endif
                    @if ($videosCount > 0)
                        <div class="tag-pill filter-btn" data-target="video">Video ({{ $videosCount }})</div>
                    @endif

                    <div class="dropdown ms-2">
                        <button class="tag-pill dropdown-toggle d-flex align-items-center gap-2" type="button"
                            data-bs-toggle="dropdown" id="sortLabel">
                            <i class="bi bi-filter-right" style="font-size: 1.1rem;"></i> Urutan
                        </button>
                        <ul class="dropdown-menu border shadow-sm dropdown-menu-end p-1 mt-1"
                            style="border-radius: 8px;">
                            <li><a class="dropdown-item sort-btn rounded-1 py-2" href="#"
                                    data-sort="newest">Terbaru</a></li>
                            <li><a class="dropdown-item sort-btn rounded-1 py-2" href="#"
                                    data-sort="oldest">Terlama</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="gallery-grid" id="gallery-container">
        @forelse ($media as $index => $item)
            @php
                $ext = strtolower(pathinfo($item->file_path, PATHINFO_EXTENSION));
                $isImg = in_array($ext, $imgExt);
                $type = $isImg ? 'photo' : 'video';
                $timestamp = \Carbon\Carbon::parse($item->created_at)->timestamp;
            @endphp

            <div class="gallery-item filter-item" data-type="{{ $type }}"
                data-timestamp="{{ $timestamp }}" data-url="{{ asset('storage/' . $item->file_path) }}"
                data-filename="{{ basename($item->file_path) }}">

                <div class="select-badge"><i class="bi bi-check"></i></div>

                @if ($isImg)
                    <img src="{{ asset('storage/' . $item->file_path) }}" alt="Gallery Item" loading="lazy">
                @else
                    <div class="video-wrapper position-relative">
                        <video src="{{ asset('storage/' . $item->file_path) }}" class="w-100" muted
                            preload="metadata"></video>
                        <div class="position-absolute top-50 start-50 translate-middle">
                            <i class="bi bi-play-circle-fill text-white" style="font-size: 2.5rem; opacity: 0.9;"></i>
                        </div>
                    </div>
                @endif
            </div>
        @empty
            <div class="empty-gallery">
                <div
                    style="background: #eef2ff; width: 80px; height: 80px; border-radius: 20px; display: flex; align-items: center; justify-content: center; margin: 0 auto;">
                    <i class="bi bi-images text-primary" style="font-size: 2.5rem;"></i>
                </div>
                <h5 class="mt-4 fw-bold text-dark">Galeri Kosong</h5>
                <p class="text-muted">Belum ada media yang diunggah ke album ini.</p>
            </div>
        @endforelse
    </div>

    <div class="selection-bar" id="selectionBar">
        <div class="d-flex align-items-center gap-3">
            <div class="count-circle" id="selectedCount">0</div>
            <div class="text-white" style="font-size: 0.9rem;"><span id="selectionLabel"
                    class="fw-medium">Selected</span></div>
        </div>

        <div class="d-flex align-items-center gap-2 ms-auto">
            <button class="btn-download-selected" id="btnDownloadSelected">
                Download
            </button>

            <button class="btn-select-all" id="btnSelectAll" title="Pilih Semua yang Tampil">
                <i class="bi bi-check-all"></i>
            </button>

            <div class="selection-divider mx-2"></div>

            <button class="btn-close-selection" id="btnCloseSelection">
                <i class="bi bi-x-lg"></i>
            </button>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/FileSaver.js/2.0.5/FileSaver.min.js"></script>

    <script>
        function updateLogoBasedOnBackground() {
            const hero = document.querySelector('.hero-section');
            const logoLight = document.querySelector('.logo-light');
            const logoDark = document.querySelector('.logo-dark');

            if (!hero) return;

            const bg = window.getComputedStyle(hero).backgroundImage;
            const img = new Image();
            const urlMatch = bg.match(/url\(["']?(.*?)["']?\)/);
            if (!urlMatch) return;

            img.src = urlMatch[1];
            img.crossOrigin = "Anonymous";

            img.onload = function() {
                const canvas = document.createElement('canvas');
                canvas.width = img.width;
                canvas.height = img.height;
                const ctx = canvas.getContext('2d');
                ctx.drawImage(img, 0, 0);

                const imageData = ctx.getImageData(0, 0, canvas.width, canvas.height);
                let total = 0;
                for (let i = 0; i < imageData.data.length; i += 4) {
                    const r = imageData.data[i];
                    const g = imageData.data[i + 1];
                    const b = imageData.data[i + 2];
                    const brightness = (r * 299 + g * 587 + b * 114) / 1000;
                    total += brightness;
                }
                const avgBrightness = total / (img.width * img.height);

                if (avgBrightness > 128) {
                    logoLight.style.opacity = 0;
                    logoDark.style.opacity = 1;
                } else {
                    logoLight.style.opacity = 1;
                    logoDark.style.opacity = 0;
                }
            }
        }
        window.addEventListener('load', updateLogoBasedOnBackground);
    </script>

    <script>
        function updateLogoBasedOnBackground() {
            const hero = document.querySelector('.hero-section');
            const logoLight = document.querySelector('.logo-light');
            const logoDark = document.querySelector('.logo-dark');
            if (!hero) return;
            const bg = window.getComputedStyle(hero).backgroundImage;
            const urlMatch = bg.match(/url\(["']?(.*?)["']?\)/);
            if (!urlMatch) return;
            const img = new Image();
            img.src = urlMatch[1];
            img.crossOrigin = "Anonymous";
            img.onload = function() {
                const canvas = document.createElement('canvas');
                canvas.width = img.width;
                canvas.height = img.height;
                const ctx = canvas.getContext('2d');
                ctx.drawImage(img, 0, 0);
                const imageData = ctx.getImageData(0, 0, canvas.width, canvas.height);
                let total = 0;
                for (let i = 0; i < imageData.data.length; i += 4) {
                    total += (imageData.data[i] * 299 + imageData.data[i + 1] * 587 + imageData.data[i + 2] * 114) /
                        1000;
                }
                const avgBrightness = total / (img.width * img.height);
                if (avgBrightness > 128) {
                    logoLight.style.opacity = 0;
                    logoDark.style.opacity = 1;
                } else {
                    logoLight.style.opacity = 1;
                    logoDark.style.opacity = 0;
                }
            }
        }
        window.addEventListener('load', updateLogoBasedOnBackground);

        $(document).ready(function() {
            let selectedItems = [];
            let previousSelectionState = [];
            let isAllSelectedMode = false;

            function updateSelectionBar() {
                const count = selectedItems.length;
                if (count > 0) {
                    $('#selectedCount').text(count);
                    $('#selectionLabel').text(count + (count > 1 ? ' items' : ' item'));
                    $('#selectionBar').addClass('active');
                } else {
                    $('#selectionBar').removeClass('active');
                }
            }

            function isSelected(url) {
                return selectedItems.some(item => item.url === url);
            }

            $('.gallery-item').on('click', function() {
                const $item = $(this);
                const itemData = {
                    url: $item.data('url'),
                    filename: $item.data('filename')
                };

                if ($item.hasClass('selected')) {
                    $item.removeClass('selected');
                    selectedItems = selectedItems.filter(i => i.url !== itemData.url);
                } else {
                    $item.addClass('selected');
                    selectedItems.push(itemData);
                }

                isAllSelectedMode = false;
                updateSelectionBar();
            });

            $('#btnSelectAll').on('click', function() {
                const $btn = $(this);
                const visibleItems = $(
                    '.gallery-item:not(.d-none-custom)');

                if (!isAllSelectedMode) {

                    previousSelectionState = [...selectedItems];

                    visibleItems.each(function() {
                        const $el = $(this);
                        if (!$el.hasClass('selected')) {
                            $el.addClass('selected');
                            selectedItems.push({
                                url: $el.data('url'),
                                filename: $el.data('filename')
                            });
                        }
                    });

                    $btn.addClass('text-light');
                    isAllSelectedMode = true;

                } else {

                    $('.gallery-item').removeClass('selected');
                    selectedItems = [];

                    previousSelectionState.forEach(prevItem => {
                        const $el = $(`.gallery-item[data-url="${prevItem.url}"]`);
                        if ($el.length) {
                            $el.addClass('selected');
                            selectedItems.push(prevItem);
                        }
                    });

                    previousSelectionState = [];
                    $btn.removeClass('text-warning');
                    isAllSelectedMode = false;
                }

                updateSelectionBar();
            });

            $('#btnCloseSelection').on('click', function() {
                $('.gallery-item').removeClass('selected');
                selectedItems = [];
                previousSelectionState = [];
                isAllSelectedMode = false;
                $('#btnSelectAll').removeClass('text-warning');
                updateSelectionBar();
            });

            $('#btnDownloadSelected').on('click', async function() {
                if (selectedItems.length === 0) return;

                const $btn = $(this);
                const originalText = $btn.html();

                $btn.prop('disabled', true).html(
                    '<span class="spinner-border spinner-border-sm"></span> Zipping...');

                const zip = new JSZip();
                let countProcessed = 0;

                const promises = selectedItems.map(async (item) => {
                    try {
                        const response = await fetch(item.url);
                        const blob = await response.blob();

                        zip.file(item.filename, blob);

                        countProcessed++;
                        $btn.html(
                            `<span class="spinner-border spinner-border-sm"></span> ${countProcessed}/${selectedItems.length}`
                        );
                    } catch (error) {
                        console.error("Gagal download file:", item.filename, error);
                    }
                });

                try {
                    await Promise.all(promises);

                    $btn.html('<span class="spinner-border spinner-border-sm"></span> Generating...');
                    const content = await zip.generateAsync({
                        type: "blob"
                    });

                    saveAs(content, "{{ $link->folder->name ?? 'Gallery' }}.zip");

                } catch (err) {
                    alert("Terjadi kesalahan saat membuat ZIP.");
                    console.error(err);
                } finally {
                    $btn.prop('disabled', false).html(originalText);
                }
            });

            $('.filter-btn').on('click', function() {
                const target = $(this).data('target');
                $('.filter-btn').removeClass('active');
                $(this).addClass('active');

                $('.filter-item').addClass('anim-zoom-out');
                setTimeout(() => {
                    $('.filter-item').addClass('d-none-custom');
                    if (target === 'all') {
                        $('.filter-item').removeClass('d-none-custom');
                        setTimeout(() => $('.filter-item').removeClass('anim-zoom-out'), 50);
                    } else {
                        const items = $('.filter-item[data-type="' + target + '"]');
                        items.removeClass('d-none-custom');
                        setTimeout(() => items.removeClass('anim-zoom-out'), 50);
                    }
                }, 300);

                isAllSelectedMode = false;
                $('#btnSelectAll').removeClass('text-warning');
            });

            $('.sort-btn').on('click', function(e) {
                e.preventDefault();
                const sortType = $(this).data('sort');
                const $container = $('#gallery-container');
                const $items = $('.filter-item');
                $items.sort(function(a, b) {
                    const timeA = parseInt($(a).data('timestamp'));
                    const timeB = parseInt($(b).data('timestamp'));
                    return sortType === 'newest' ? timeB - timeA : timeA - timeB;
                });
                $('.filter-item').addClass('anim-zoom-out');
                setTimeout(() => {
                    $items.detach().appendTo($container);
                    setTimeout(() => $('.filter-item').removeClass('anim-zoom-out'), 50);
                }, 300);
            });
        });

        $('#btnTriggerModal').on('click', function() {
            openGuestModal();
        });
        $('#displayNumber').on('keypress', function(e) {
            if (e.which == 13) {
                e.preventDefault();
                openGuestModal();
            }
        });

        function openGuestModal() {
            var phoneNumber = $('#displayNumber').val().trim();
            if (phoneNumber === '') {
                $('#displayNumber').focus();
                return;
            }
            $('#hiddenNumber').val(phoneNumber);
            $('#previewNumber').text(phoneNumber);
            var myModal = new bootstrap.Modal(document.getElementById('nameInputModal'));
            myModal.show();
            $('#nameInputModal').on('shown.bs.modal', function() {
                $('#inputName').focus();
            });
        }
    </script>
</body>

</html>
