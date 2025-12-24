<h3>@yield('name_header')</h3>

<nav aria-label="breadcrumb" class="breadcrumb-header d-flex justify-content-between align-items-center">

    {{-- Breadcrumb --}}
    <ol class="breadcrumb mb-0">
        @if (Request::is('dashboard') || Request::is('dashboard/'))
            <li class="breadcrumb-item active" aria-current="page">Dashboard</li>
        @else
            <li class="breadcrumb-item">
                <a href="{{ url('/dashboard') }}">Dashboard</a>
            </li>

            @if (isset($breadcrumbs) && is_array($breadcrumbs))
                @foreach ($breadcrumbs as $breadcrumb)
                    <li class="breadcrumb-item">
                        @if (isset($breadcrumb['link']))
                            <a href="{{ $breadcrumb['link'] }}">{{ $breadcrumb['name'] }}</a>
                        @else
                            {{ $breadcrumb['name'] }}
                        @endif
                    </li>
                @endforeach
            @endif

            <li class="breadcrumb-item active" aria-current="page">
                @yield('name_header', 'Page')
            </li>
        @endif
    </ol>

    {{-- ICON SETTINGS --}}
    <div class="d-flex align-items-center gap-3">

        {{-- Profile Settings --}}
        <a href="{{ route('profile.index', auth()->user()->id) }}" class="text-secondary" style="font-size: 1.4rem;"
            title="Pengaturan Profil">
            <i class="bi bi-gear"></i>
        </a>

        {{-- Logout --}}
        <a href="#" class="text-danger" style="font-size: 1.4rem;" onclick="logoutConfirm(event)">
            <i class="bi bi-box-arrow-right"></i>
        </a>

        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
            @csrf
        </form>

    </div>
</nav>
