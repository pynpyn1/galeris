<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Dashbords')</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@300;400;600;700;800&display=swap" rel="stylesheet">
    {{-- CORE CSS --}}
    <link rel="stylesheet" href="{{ asset('assets/css/bootstrap.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/vendors/iconly/bold.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/vendors/perfect-scrollbar/perfect-scrollbar.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/vendors/bootstrap-icons/bootstrap-icons.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/app.css') }}">
</head>

@stack('styles')
<style>
    #app {
        display: flex;
        flex-direction: column;
        min-height: 100vh;
    }

    #main {
        display: flex;
        flex-direction: column;
        flex-grow: 1;
    }

    .page-content {
        flex-grow: 1;
    }

    .fixed-bottom-footer {
        position: fixed;
        bottom: 0;
        width: 100%;
        z-index: 1030;
        background-color: var(--bs-light);
        padding: 10px;
        box-shadow: 0 -2px 5px rgba(0, 0, 0, 0.1);
    }

    #toast-container {
        position: fixed;
        bottom: 20px;
        right: 20px;
        left: auto;
        z-index: 2147483647;
        display: flex;
        flex-direction: column;
        gap: 10px;
    }

    .custom-toast {
        min-width: 260px;
        background: #fff;
        border-radius: 10px;
        padding: 12px 16px;
        display: flex;
        align-items: center;
        gap: 10px;
        box-shadow: 0 10px 25px rgba(0, 0, 0, .15);
        animation: fadeUp .3s ease;
        pointer-events: auto;
    }

    .custom-toast.success {
        border-left: 4px solid #435ebf;
    }

    .custom-toast.error {
        border-left: 4px solid #ef4444;
    }

    .custom-toast.warning {
        border-left: 4px solid #f59e0b;
    }

    .custom-toast.hide {
        opacity: 0;
        transform: translateY(10px);
        transition: all .4s ease;
    }


    @keyframes fadeUp {
        from {
            opacity: 0;
            transform: translateY(10px);
        }

        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    .sidebar-wrapper {
        display: flex;
        flex-direction: column;
        height: 100%;
        overflow-y: auto;
        padding-bottom: 1rem;
    }

    .sidebar-footer {
        margin-top: auto;
        flex-shrink: 0;
    }
</style>

<body>
    <div id="app" class="bg-white">
        {{-- Sidebar --}}
        @include('dashboard.client.partials.modal.event')
        @include('dashboard.layouts.partials.sidebar')
        {{-- Content Main --}}
        <div id="main">
            {{-- Header Content --}}
            <header class="mb-3">
                <a href="#" class="burger-btn d-block d-xl-none">
                    <i class="bi bi-justify fs-3"></i>
                </a>
            </header>



            <div class="page-heading">
                @if (Auth::check() && Auth::user()->hasPermissionTo('dashboard'))
                    @include('dashboard.layouts.partials.breadcrumb')
                @endif
            </div>
            <div class="page-content">
                @yield('content')
            </div>

        </div>
    </div>

    <div id="toast-container"></div>


    <script src="{{ asset('assets/vendors/perfect-scrollbar/perfect-scrollbar.min.js') }}"></script>
    <script src="{{ asset('assets/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('assets/vendors/apexcharts/apexcharts.js') }}"></script>
    <script src="{{ asset('assets/js/pages/dashboard.js') }}"></script>
    <script src="{{ asset('assets/js/main.js') }}"></script>

    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0/dist/js/select2.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        window.showToast = function(message, type = 'success', duration = 5000) {

            const container = document.getElementById('toast-container');

            const icons = {
                success: 'bi-check-circle-fill',
                error: 'bi-x-circle-fill',
                warning: 'bi-exclamation-triangle-fill'
            };

            const toast = document.createElement('div');
            toast.className = `custom-toast ${type}`;
            toast.innerHTML = `
                <i class="bi ${icons[type] || icons.success}"></i>
                <span>${message}</span>
            `;

            container.appendChild(toast);

            setTimeout(() => {
                toast.classList.add('hide');
                setTimeout(() => toast.remove(), 400);
            }, duration);
        };
    </script>



    @stack('scripts')

    <script>
        function logoutConfirm(event) {
            event.preventDefault();

            Swal.fire({
                title: 'Keluar dari sistem?',
                text: "Apakah kamu yakin ingin logout?",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Ya, Logout',
                cancelButtonText: 'Batal',
                reverseButtons: true
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById('logout-form').submit();
                }
            });
        }
    </script>
    <script>
        window.addEventListener('beforeunload', () => {
            console.log('PAGE RELOAD / DOM RESET');
        });
    </script>

</body>

</html>
