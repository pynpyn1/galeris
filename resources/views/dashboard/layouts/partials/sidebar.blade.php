<div id="sidebar" class="active d-flex flex-column ">
    <div class="sidebar-wrapper d-flex flex-column flex-grow-1 border-end">
        <div class="sidebar-header" style="padding: 1.5rem 1.5rem 1rem;">
            <div class="d-flex justify-content-between align-items-center">
                <div class="logo">
                    <a href="{{ url('/') }}">
                        <img src="{{ asset('asset/img/logo.png') }}" alt="Logo" style="height: 60px; width: auto;">
                    </a>
                </div>
                <div class="toggler">
                    <a href="#" class="sidebar-hide d-xl-none d-block"><i class="bi bi-x bi-middle"></i></a>
                </div>
            </div>
        </div>

        <div class="sidebar-menu">
            <ul class="menu">

                {{-- Dashboard --}}
                @if (Auth::check() && Auth::user()->hasPermissionTo('dashboard'))
                    <li class="sidebar-item {{ request()->is('dashboard') ? 'active' : '' }} ">
                        <a href="{{ route('dashboard') }}" class='sidebar-link'>
                            <i class="bi bi-speedometer2"></i>
                            <span>Dashboard</span>
                        </a>
                    </li>
                @else
                    <li class="sidebar-item {{ request()->is('home') ? 'active' : '' }} ">
                        <a href="{{ route('home.index') }}" class='sidebar-link'>
                            <i class="bi bi-house"></i>
                            <span>All events</span>
                        </a>
                    </li>
                @endif




                @if (
                    (Auth::check() &&
                        (Auth::user()->hasPermissionTo('manage_photo') ||
                            Auth::user()->hasPermissionTo('manage_folder') ||
                            Auth::user()->hasPermissionTo('manage_package') ||
                            Auth::user()->hasPermissionTo('manage_url'))) ||
                        Auth::user()->hasPermissionTo('manage_video'))
                    <li
                        class="sidebar-item has-sub
                        {{ request()->is('manage/package*') || request()->is('manage/photo*') || request()->is('manage/video*') || request()->is('manage/folder*') || request()->is('manage/url*') ? 'active' : '' }}">
                        <a href="#" class='sidebar-link'>
                            <i class="bi bi-gear-fill"></i>
                            <span>Management</span>
                        </a>
                        <ul class="submenu ">

                            {{-- Video --}}
                            @if (Auth::user()->hasPermissionTo('manage_video'))
                                <li class="submenu-item {{ request()->is('manage/video') ? 'active' : '' }}">
                                    <a href="{{ route('manage.video.index') }}"><i class="bi bi-film"></i>
                                        Video</a>
                                </li>
                            @endif

                            {{-- Foto --}}
                            @if (Auth::user()->hasPermissionTo('manage_photo'))
                                <li class="submenu-item {{ request()->is('manage/photo') ? 'active' : '' }}">
                                    <a href="{{ route('manage.photo.index') }}"><i class="bi bi-image-fill"></i>
                                        Foto</a>
                                </li>
                            @endif

                            {{-- Folder --}}
                            @if (Auth::user()->hasPermissionTo('manage_folder'))
                                <li class="submenu-item {{ request()->is('manage/folder') ? 'active' : '' }}">
                                    <a href="{{ route('manage.folder.index') }}"><i class="bi bi-folder-fill"></i>
                                        Folder</a>
                                </li>
                            @endif

                            {{-- URL --}}
                            @if (Auth::user()->hasPermissionTo('manage_url'))
                                <li class="submenu-item {{ request()->is('manage/url') ? 'active' : '' }}">
                                    <a href="{{ route('manage.url.index') }}"><i class="bi bi-link-45deg"></i> URL</a>
                                </li>
                            @endif

                            {{-- Qr Template --}}
                            @if (Auth::user()->hasPermissionTo('manage_qrtemplate'))
                                <li class="submenu-item {{ request()->is('manage/qr_template') ? 'active' : '' }}">
                                    <a href="{{ route('manage.qr_template.index') }}"><i
                                            class="bi bi-layout-text-window-reverse"></i>
                                        Qr Template</a>
                                </li>
                            @endif

                            {{-- Package --}}
                            @if (Auth::user()->hasPermissionTo('manage_package'))
                                <li class="submenu-item {{ request()->is('manage/package') ? 'active' : '' }}">
                                    <a href="{{ route('manage.package.index') }}">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                            fill="currentColor" class="bi bi-box-seam-fill" viewBox="0 0 16 16">
                                            <path fill-rule="evenodd"
                                                d="M15.528 2.973a.75.75 0 0 1 .472.696v8.662a.75.75 0 0 1-.472.696l-7.25 2.9a.75.75 0 0 1-.557 0l-7.25-2.9A.75.75 0 0 1 0 12.331V3.669a.75.75 0 0 1 .471-.696L7.443.184l.01-.003.268-.108a.75.75 0 0 1 .558 0l.269.108.01.003zM10.404 2 4.25 4.461 1.846 3.5 1 3.839v.4l6.5 2.6v7.922l.5.2.5-.2V6.84l6.5-2.6v-.4l-.846-.339L8 5.961 5.596 5l6.154-2.461z" />
                                        </svg>
                                        Package</a>
                                </li>
                            @endif


                        </ul>
                    </li>
                @endif


                {{-- Management Users --}}
                @if (Auth::check() && (Auth::user()->hasPermissionTo('manage_users') || Auth::user()->hasPermissionTo('manage_roles')))
                    <li
                        class="sidebar-item has-sub
                        {{ request()->is('manage/users*') || request()->is('manage/roles*') ? 'active' : '' }}">
                        <a href="#" class='sidebar-link'>
                            <i class="bi bi-people-fill"></i>
                            <span>Management Users</span>
                        </a>
                        <ul class="submenu ">
                            @if (Auth::user()->hasPermissionTo('manage_users'))
                                <li class="submenu-item {{ request()->is('manage/users*') ? 'active' : '' }}">
                                    <a href="{{ route('manage.users.index') }}"><i class="bi bi-person-fill"></i>
                                        Users</a>
                                </li>
                            @endif
                            @if (Auth::user()->hasPermissionTo('manage_roles'))
                                <li class="submenu-item {{ request()->is('manage/roles*') ? 'active' : '' }}">
                                    <a href="{{ route('manage.roles.index') }}"><i class="bi bi-shield-lock-fill"></i>
                                        Permission</a>
                                </li>
                            @endif
                        </ul>
                    </li>
                @endif

                {{-- Package Manage --}}

                @if (Auth::check() &&
                        (Auth::user()->hasPermissionTo('manage_invoice') || Auth::user()->hasPermissionTo('manage_discount')))
                    <li
                        class="sidebar-item has-sub
                        {{ request()->route('discount.index') || request()->route('manage.invoice.index') ? 'active' : '' }}">
                        <a href="#" class='sidebar-link'>
                            <i class="bi bi-receipt"></i>
                            <span>Management Invoice</span>
                        </a>
                        <ul class="submenu ">

                            @if (Auth::user()->hasPermissionTo('manage_invoice'))
                                <li class="submenu-item {{ request()->is('manage/invoice*') ? 'active' : '' }}">
                                    <a href="{{ route('manage.invoice.index') }}">
                                        <i class="bi bi-receipt-cutoff"></i>
                                        Invoice</a>
                                </li>
                                {{-- Recap --}}
                                <li class="submenu-item {{ request()->is('manage/recap*') ? 'active' : '' }}">
                                    <a href="{{ route('manage.invoice.index') }}">
                                        <i class="bi bi-receipt-cutoff"></i>
                                        Recap Income</a>
                                </li>
                            @endif
                            @if (Auth::user()->hasPermissionTo('manage_discount'))
                                <li class="submenu-item {{ request()->is('manage/discount*') ? 'active' : '' }}">
                                    <a href="{{ route('manage.discount.index') }}">
                                        <i class="bi bi-tags-fill"></i>
                                        Discount Code</a>
                                </li>
                            @endif
                        </ul>
                    </li>
                @endif

                {{-- ChatBot Manage --}}
                @if (Auth::check() && Auth::user()->hasPermissionTo('manage_chatbot'))
                    <li
                        class="sidebar-item has-sub
                        {{ request()->is('manage/connect*') || request()->is('manage/chatbot*') ? 'active' : '' }}">
                        <a href="#" class='sidebar-link'>
                            <i class="bi bi-chat-dots-fill"></i>
                            <span>ChatBot Manage</span>
                        </a>
                        <ul class="submenu ">
                            @if (Auth::user()->hasPermissionTo('manage_chatbot'))
                                <li class="submenu-item {{ request()->is('manage/chatbot') ? 'active' : '' }}">
                                    <a href="{{ route('manage.chatbot.index') }}"><i class="bi bi-gear-fill"></i>
                                        ChatBot
                                        Settings</a>
                                </li>
                            @endif

                            {{-- @if (Auth::user()->hasPermissionTo('setting_chatbot'))
                                <li class="submenu-item {{ request()->is('chatbot') ? 'active' : '' }}">
                                    <a href="{{ route('chatbot.index') }}"><i class="bi bi-gear-fill"></i>
                                        ChatBot
                                        Settings</a>
                                </li>
                            @endif --}}

                            <li class="submenu-item {{ request()->is('manage/connect') ? 'active' : '' }}">
                                <a href="{{ route('connect.index') }}"><i class="bi bi-phone-fill"></i> Connect
                                    Whatsapp</a>
                            </li>
                        </ul>
                    </li>
                @endif


            </ul>

        </div>

        @if (Auth::check() && Auth::user()->hasPermissionTo('dashboard_client'))
            <div class="sidebar-footer p-3 mt-auto mb-4">
                <a href="{{ $hasActivePackage ? 'javascript:void(0)' : route('home.subscribe') }}"
                    class="btn btn-primary border h-50 w-100 d-flex justify-content-center align-items-center mb-3"
                    @if ($hasActivePackage) data-bs-toggle="modal" data-bs-target="#createEventModal" @endif>
                    <i class="bi bi-plus"></i>
                    {{ $hasActivePackage ? 'Add New Event' : 'Buy New Event' }}
                </a>
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
