<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gallery - {{ $link->folder->name }}</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,400..900;1,400..900&family=Montserrat:wght@300;400;500&display=swap"
        rel="stylesheet">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    <style>
        :root {
            --primary-blue: #435ebf;
            --dark-blue: #364ea4;
            --bg-gray: #f8f9fa;
            --selection-gold: #435ebf;
        }

        body {
            background-color: var(--bg-gray);
            font-family: 'Montserrat', sans-serif;
            color: #333;
            overflow-x: hidden;
        }

        /* Hero Header Section */
        .hero-section {
            position: relative;
            height: 480px;
            margin: 15px;
            border-radius: 40px;
            overflow: hidden;
            background: url('{{ $link->folder->thumbnail }}') center/cover no-repeat;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            color: white;
            text-align: center;
            box-shadow: 0 15px 35px rgba(0, 0, 0, 0.15);
        }

        .hero-overlay {
            position: absolute;
            inset: 0;
            background: rgba(0, 0, 0, 0.35);
            border: 8px solid rgba(255, 255, 255, 0.15);
            border-radius: 40px;
            pointer-events: none;
        }

        .hero-content {
            position: relative;
            z-index: 2;
            width: 90%;
        }

        .hero-title {
            font-family: 'Playfair Display', serif;
            font-size: 4.5rem;
            font-weight: 700;
            margin-bottom: 5px;
            text-shadow: 2px 4px 10px rgba(0, 0, 0, 0.3);
        }

        .hero-date-wrapper {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 20px;
            max-width: 600px;
            margin: 0 auto;
        }

        .date-line {
            height: 1px;
            flex-grow: 1;
            background: linear-gradient(to var(--direction, right), transparent, rgba(255, 255, 255, 0.8));
        }

        .hero-date {
            font-size: 1.1rem;
            font-weight: 400;
            letter-spacing: 6px;
            text-transform: uppercase;
            white-space: nowrap;
            color: rgba(255, 255, 255, 0.9);
        }

        /* Navigation */
        .top-nav-actions {
            position: absolute;
            top: 30px;
            left: 40px;
            right: 40px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            z-index: 10;
        }

        .logo-wrapper img {
            height: 45px;
            filter: brightness(0) invert(1);
        }

        .btn-download-main {
            background: linear-gradient(90deg, var(--primary-blue), var(--dark-blue));
            border: none;
            border-radius: 30px;
            padding: 10px 28px;
            color: white !important;
            font-weight: 500;
            box-shadow: 0 4px 15px rgba(67, 94, 191, 0.4);
            transition: 0.3s;
        }

        /* Filter Section */
        .filter-container {
            margin: -35px 15px 40px 15px;
            padding: 0 25px;
            position: relative;
            z-index: 20;
        }

        .search-bar-wrapper {
            background: white;
            border-radius: 35px;
            padding: 8px 8px 8px 25px;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.05);
            display: flex;
            align-items: center;
            width: 100%;
            max-width: 420px;
        }

        .search-bar-wrapper input {
            border: none;
            outline: none;
            width: 100%;
            font-size: 0.9rem;
        }

        .btn-send-wa {
            background-color: var(--primary-blue);
            border: none;
            border-radius: 50%;
            width: 40px;
            height: 40px;
            color: white;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: 0.3s;
            flex-shrink: 0;
        }

        .tag-pill {
            background: white;
            border: 1px solid #e0e0e0;
            padding: 8px 22px;
            border-radius: 25px;
            color: #666;
            font-size: 0.85rem;
            cursor: pointer;
            transition: 0.3s;
            font-weight: 500;
        }

        .tag-pill.active,
        .tag-pill:hover {
            background: var(--primary-blue);
            color: white;
            border-color: var(--primary-blue);
        }

        /* Gallery Grid - 7 Columns */
        .gallery-grid {
            columns: 7;
            column-gap: 12px;
            margin: 0 15px 40px 15px;
            padding: 0 25px;
        }

        .gallery-item {
            break-inside: avoid;
            margin-bottom: 12px;
            border-radius: 12px;
            overflow: hidden;
            position: relative;
            transition: transform 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275), opacity 0.3s ease;
            transform: scale(1);
            opacity: 1;
            cursor: pointer;
            user-select: none;
            border: 4px solid transparent;
        }

        .gallery-item.selected {
            border-color: var(--selection-gold);
            transform: scale(0.95);
        }

        /* Checkbox badge */
        .select-badge {
            position: absolute;
            top: 10px;
            right: 10px;
            background: var(--selection-gold);
            color: black;
            width: 24px;
            height: 24px;
            border-radius: 50%;
            display: none;
            align-items: center;
            justify-content: center;
            font-size: 0.9rem;
            z-index: 5;
        }

        .gallery-item.selected .select-badge {
            display: flex;
        }

        .gallery-item.anim-zoom-out {
            transform: scale(0.6);
            opacity: 0;
        }

        .gallery-item.d-none-custom {
            display: none;
        }

        .gallery-item img,
        .gallery-item video {
            width: 100%;
            display: block;
            border-radius: 8px;
        }

        .gallery-item.featured {
            border: 4px solid var(--primary-blue);
        }

        /* Floating Selection Bar */
        .selection-bar {
            position: fixed;
            bottom: 30px;
            left: 50%;
            transform: translateX(-50%) translateY(150%);
            background: #1a1a1a;
            color: white;
            padding: 10px 20px;
            border-radius: 50px;
            display: flex;
            align-items: center;
            gap: 15px;
            z-index: 1000;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.5);
            transition: transform 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
            min-width: 350px;
        }

        .selection-bar.active {
            transform: translateX(-50%) translateY(0);
        }

        .count-circle {
            background: var(--selection-gold);
            color: black;
            width: 32px;
            height: 32px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: bold;
            font-size: 0.9rem;
        }

        .btn-download-selected {
            background: var(--selection-gold);
            border: none;
            color: white;
            padding: 8px 20px;
            border-radius: 25px;
            font-weight: 600;
            display: flex;
            align-items: center;
            gap: 8px;
            transition: 0.3s;
        }

        .btn-download-selected:hover {
            background: #364ea4;
        }

        .selection-divider {
            width: 1px;
            height: 25px;
            background: #444;
        }

        .btn-close-selection {
            background: transparent;
            border: none;
            color: #888;
            font-size: 1.5rem;
            cursor: pointer;
            padding: 0;
            line-height: 1;
        }

        .empty-gallery {
            column-span: all;
            text-align: center;
            padding: 100px 0;
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
            }
        }
    </style>
</head>

<body>

    <div class="hero-section">
        <div class="hero-overlay"></div>
        <div class="top-nav-actions">
            <a href="#" class="logo-wrapper">
                <img src="{{ asset('asset/img/logo.png') }}" alt="Logo">
            </a>
            <div class="dropdown">
                <button class="btn btn-download-main dropdown-toggle" data-bs-toggle="dropdown">
                    <i class="bi bi-cloud-arrow-down-fill me-2"></i> Download
                </button>
                <ul class="dropdown-menu dropdown-menu-end shadow border-0 p-2" style="border-radius: 15px;">
                    <li><a class="dropdown-item rounded-3" href="#"><i
                                class="bi bi-file-zip-fill me-2"></i>Download ZIP</a></li>
                    <li>
                        <hr class="dropdown-divider">
                    </li>
                    <li><a class="dropdown-item rounded-3" href="#">Original Quality</a></li>
                </ul>
            </div>
        </div>

        <div class="hero-content">
            <h1 class="hero-title">{{ $link->folder->name }}</h1>
            <div class="hero-date-wrapper">
                <div class="date-line" style="--direction: left;"></div>
                <span
                    class="hero-date">{{ \Carbon\Carbon::parse($link->folder->date_event)->format('d . m . Y') }}</span>
                <div class="date-line" style="--direction: right;"></div>
            </div>
        </div>
    </div>

    <div class="filter-container">
        <div class="row g-4 align-items-center">
            <div class="col-12 col-md-6 col-lg-5">
                <form action="{{ route('guest.store', $link->folder->id) }}" method="post">
                    @csrf
                    <div class="search-bar-wrapper">
                        <input name="number" type="tel" placeholder="Kirim ke WhatsApp...">
                        <button class="btn-send-wa">
                            <i class="bi bi-send-fill"></i>
                        </button>
                    </div>
                </form>
                <div class="mt-2 ps-2">
                    <small class="text-muted d-flex align-items-center gap-2" style="font-size: 0.75rem; opacity: 0.8;">
                        <i class="bi bi-info-circle-fill text-primary"></i>
                        Simpan link galeri ini di WA Anda
                    </small>
                </div>
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

                    <div class="tag-pill filter-btn active" data-target="all">Semua ({{ $media->count() }})</div>
                    @if ($photosCount > 0)
                        <div class="tag-pill filter-btn" data-target="photo"><i class="bi bi-image me-1"></i> Foto</div>
                    @endif
                    @if ($videosCount > 0)
                        <div class="tag-pill filter-btn" data-target="video"><i class="bi bi-play-circle me-1"></i>
                            Video</div>
                    @endif

                    <div class="dropdown">
                        <button class="tag-pill dropdown-toggle border-0 shadow-sm" type="button"
                            data-bs-toggle="dropdown" id="sortLabel">Urutan</button>
                        <ul class="dropdown-menu border-0 shadow-sm dropdown-menu-end">
                            <li><a class="dropdown-item sort-btn" href="#" data-sort="newest">Terbaru</a></li>
                            <li><a class="dropdown-item sort-btn" href="#" data-sort="oldest">Terlama</a></li>
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

            <div class="gallery-item filter-item" data-type="{{ $type }}" data-timestamp="{{ $timestamp }}"
                data-url="{{ asset('storage/' . $item->file_path) }}" data-filename="{{ basename($item->file_path) }}">

                <div class="select-badge"><i class="bi bi-check"></i></div>

                @if ($isImg)
                    <img src="{{ asset('storage/' . $item->file_path) }}" alt="Gallery Item" loading="lazy">
                @else
                    <div class="video-wrapper position-relative">
                        <video src="{{ asset('storage/' . $item->file_path) }}" class="w-100" muted
                            preload="metadata"></video>
                        <div class="position-absolute top-50 start-50 translate-middle">
                            <i class="bi bi-play-circle-fill text-white" style="font-size: 3rem; opacity: 0.85;"></i>
                        </div>
                    </div>
                @endif
            </div>
        @empty
            <div class="empty-gallery">
                <i class="bi bi-camera-fill text-muted" style="font-size: 3rem;"></i>
                <p class="text-muted mt-3">Belum ada media di album ini.</p>
            </div>
        @endforelse
    </div>

    <div class="selection-bar" id="selectionBar">
        <div class="count-circle" id="selectedCount">0</div>
        <div class="selection-text text-white fw-medium" id="selectionLabel">Selected</div>
        <div class="selection-divider"></div>
        <button class="btn-download-selected" id="btnDownloadSelected">
            <i class="bi bi-download"></i> Download Selected
        </button>
        <button class="btn-close-selection" id="btnCloseSelection">
            <i class="bi bi-x"></i>
        </button>
    </div>

    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        $(document).ready(function() {
            let selectedItems = [];

            // MULTI-SELECT LOGIC
            $('.gallery-item').on('click', function() {
                const $item = $(this);
                $item.toggleClass('selected');

                const itemData = {
                    url: $item.data('url'),
                    filename: $item.data('filename')
                };

                if ($item.hasClass('selected')) {
                    selectedItems.push(itemData);
                } else {
                    selectedItems = selectedItems.filter(i => i.url !== itemData.url);
                }

                updateSelectionBar();
            });

            function updateSelectionBar() {
                const count = selectedItems.length;
                if (count > 0) {
                    $('#selectedCount').text(count);
                    $('#selectionLabel').text(count + (count > 1 ? ' items selected' : ' item selected'));
                    $('#selectionBar').addClass('active');
                } else {
                    $('#selectionBar').removeClass('active');
                }
            }

            $('#btnCloseSelection').on('click', function() {
                $('.gallery-item').removeClass('selected');
                selectedItems = [];
                updateSelectionBar();
            });

            $('#btnDownloadSelected').on('click', function() {
                if (selectedItems.length === 0) return;

                const $btn = $(this);
                const originalHtml = $btn.html();
                $btn.html('<span class="spinner-border spinner-border-sm"></span> Downloading...');

                selectedItems.forEach((item, index) => {
                    setTimeout(() => {
                        const link = document.createElement('a');
                        link.href = item.url;
                        link.download = item.filename;
                        document.body.appendChild(link);
                        link.click();
                        document.body.removeChild(link);
                    }, index * 400); // Jeda agar tidak diblokir browser
                });

                setTimeout(() => $btn.html(originalHtml), 1000);
            });

            // FILTER LOGIC
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
            });

            // SORT LOGIC
            $('.sort-btn').on('click', function(e) {
                e.preventDefault();
                const sortType = $(this).data('sort');
                const $container = $('#gallery-container');
                const $items = $('.filter-item');
                $('#sortLabel').text($(this).text());

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
    </script>
</body>

</html>
