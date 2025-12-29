<div id="sidebar" class="active d-flex flex-column ">
    <div class="sidebar-wrapper d-flex flex-column flex-grow-1 border-end">
        <div class="sidebar-header" style="padding: 1.5rem 1.5rem 1rem;">
            <div class="d-flex justify-content-between align-items-center">
                <div class="logo">
                    <a href="{{ url('/') }}">
                        <img src="{{ asset('asset/img/GALLERIS_LOGO.png') }}" alt="Logo"
                            style="height: 70px; width: auto;">
                    </a>
                </div>
                <div class="toggler">
                    <a href="#" class="sidebar-hide d-xl-none d-block"><i class="bi bi-x bi-middle"></i></a>
                </div>
            </div>
        </div>

        <div class="sidebar-menu">
            <ul class="menu">

                {{-- Home --}}
                @if (Auth::check() && Auth::user()->hasPermissionTo('dashboard_client'))
                    <li class="sidebar-item {{ request()->is('home') ? 'active' : '' }} ">
                        <a href="{{ route('home.index') }}" class='sidebar-link'>
                            <i class="bi bi-arrow-left"></i>
                            <span>All events</span>
                        </a>
                    </li>
                @endif


                {{-- Overfiew --}}
                @if (Auth::check() && Auth::user()->hasPermissionTo('dashboard_client'))
                    <li class="sidebar-item {{ request()->routeIs('home.show') ? 'active' : '' }}">
                        <a href="{{ route('home.show', $event->public_code) }}" class="sidebar-link">
                            <i class="bi bi-house"></i>
                            <span>Overview</span>
                        </a>
                    </li>
                @endif

                {{-- Upload Video Photo --}}
                @if (Auth::check() && (Auth::user()->hasPermissionTo('upload_photo') || Auth::user()->hasPermissionTo('upload_video')))
                    <li
                        class="sidebar-item has-sub {{ request()->routeIs('home.photo.*', 'home.video.*') ? 'active' : '' }}">
                        <a href="#" class="sidebar-link">
                            <i class="bi bi-cloud-arrow-up"></i>
                            <span>Manage Content</span>
                        </a>
                        <ul class="submenu">
                            @if (Auth::user()->hasPermissionTo('upload_photo'))
                                <li class="submenu-item {{ request()->routeIs('home.photo.*') ? 'active' : '' }}">
                                    <a href="{{ route('home.photo.index', $event->public_code) }}">
                                        <i class="bi bi-image"></i> Photo
                                    </a>
                                </li>
                            @endif

                            @if (Auth::user()->hasPermissionTo('upload_video'))
                                <li class="submenu-item {{ request()->routeIs('home.video.*') ? 'active' : '' }}">
                                    <a href="{{ route('home.video.index', $event->public_code) }}">
                                        <i class="bi bi-camera-video"></i> Video
                                    </a>
                                </li>
                            @endif
                        </ul>
                    </li>
                @endif


                @if (Auth::check() && Auth::user()->hasPermissionTo('dashboard_client'))
                    <li class="sidebar-item {{ request()->routeIs('home.share') ? 'active' : '' }}">
                        <a href="{{ route('home.share', $event->public_code) }}" class="sidebar-link">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                                class="bi bi-qr-code-scan" viewBox="0 0 16 16">
                                <path
                                    d="M0 .5A.5.5 0 0 1 .5 0h3a.5.5 0 0 1 0 1H1v2.5a.5.5 0 0 1-1 0zm12 0a.5.5 0 0 1 .5-.5h3a.5.5 0 0 1 .5.5v3a.5.5 0 0 1-1 0V1h-2.5a.5.5 0 0 1-.5-.5M.5 12a.5.5 0 0 1 .5.5V15h2.5a.5.5 0 0 1 0 1h-3a.5.5 0 0 1-.5-.5v-3a.5.5 0 0 1 .5-.5m15 0a.5.5 0 0 1 .5.5v3a.5.5 0 0 1-.5.5h-3a.5.5 0 0 1 0-1H15v-2.5a.5.5 0 0 1 .5-.5M4 4h1v1H4z" />
                                <path d="M7 2H2v5h5zM3 3h3v3H3zm2 8H4v1h1z" />
                                <path d="M7 9H2v5h5zm-4 1h3v3H3zm8-6h1v1h-1z" />
                                <path
                                    d="M9 2h5v5H9zm1 1v3h3V3zM8 8v2h1v1H8v1h2v-2h1v2h1v-1h2v-1h-3V8zm2 2H9V9h1zm4 2h-1v1h-2v1h3zm-4 2v-1H8v1z" />
                                <path d="M12 9h2V8h-2z" />
                            </svg>
                            <span>Share Qr Code</span>
                        </a>
                    </li>
                @endif

                @if (Auth::check() && Auth::user()->hasPermissionTo('dashboard_client'))
                    <li class="sidebar-item {{ request()->routeIs('home.templates') ? 'active' : '' }}">
                        <a href="{{ route('home.templates', $event->public_code) }}" class="sidebar-link">
                            <i class="bi bi-upload"></i>
                            <span>Qr Code Templates</span>
                        </a>
                    </li>
                @endif
                @if (Auth::check() && Auth::user()->hasPermissionTo('dashboard_client'))
                    <li class="sidebar-item">
                        <a href="{{ route('provide.photo', $event->link->slug) }}" target="_blank"
                            class="sidebar-link">
                            <i class="bi bi-arrow-up-right"></i>
                            <span>Go to gallery</span>
                        </a>
                    </li>
                @endif

                @if (Auth::check() && Auth::user()->hasPermissionTo('dashboard_client'))
                    <li class="sidebar-item">
                        <a href="{{ route('livewall.photo', $event->link->slug) }}" target="_blank"
                            class="sidebar-link">
                            <i class="bi bi-arrow-up-right"></i>
                            <span>Live gallery wall</span>
                        </a>
                    </li>
                @endif

            </ul>

        </div>

        @if (Auth::check() && Auth::user()->hasPermissionTo('dashboard_client'))
            <div class="sidebar-footer p-3 mt-auto mb-4">

                <a href="{{ route('home.subscribe') }}"
                    class="btn btn-primary border h-50 w-100 d-flex justify-content-center align-items-center mb-3">
                    <i class="bi bi-plus"></i>Buy new event</a>
                <a href="#"
                    class="btn btn-block border h-50 w-100 d-flex justify-content-center align-items-center"
                    onclick="logoutConfirm(event)">
                    <i class="bi bi-box-arrow-right me-2"></i> Logout
                </a>

                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                    @csrf
                </form>
            </div>
        @endif

        <button class="sidebar-toggler btn x"><i data-feather="x"></i></button>
    </div>
</div>
