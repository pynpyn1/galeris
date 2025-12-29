@extends('dashboard.layouts.app')
@section('title', 'Galléris Digital Photo Album with QR Code for Guest')
@section('content')
    <div class="">
        <div class="justify-content-center">
            <div class="col-12 col-sm-10 col-md-10 mb-4">
            </div>
        </div>

        @if ($folders->isEmpty())
            @if ($hasActivePackage)
                @include('dashboard.client.partials.modal.event')
                <div class="row justify-content-center">
                    <div class="col-12 col-sm-10 col-md-10 mb-4">
                        <div class="card shadow-sm mb-4">
                            <div class="card-body d-flex flex-column align-items-center text-center">

                                <h4 class="card-title fs-2 mb-2">Start Creating a New Event</h4>

                                <p class="card-text mb-4" style="font-size: 1.0rem;">
                                    Your package is now active! Create your event now to start
                                    collecting and sharing precious moments without any trial restrictions.
                                </p>

                                {{-- Tombol Trigger Modal!!! --}}
                                <button type="button"
                                    class="btn active d-flex justify-content-center align-items-center text-white"
                                    style="background: #435ebf" data-bs-toggle="modal" data-bs-target="#createEventModal">
                                    Create Now <i class="ms-2 bi bi-plus-circle"></i>
                                </button>

                            </div>
                        </div>
                    </div>
                </div>
            @else
                <div class="row justify-content-center">

                    <div class="col-12 col-sm-10 col-md-10 mb-4">
                        @include('dashboard.client.event.partials.subscribe.card.pending')

                        <div class="card shadow-sm mb-4">
                            <div class="card-body d-flex flex-column align-items-center text-center">

                                <h4 class="card-title fs-2 mb-2">Try Now</h4>

                                <p class="card-text mb-4" style="font-size: 1.0rem;">
                                    Here you have the opportunity to try out how our platform works.
                                    This trial gives you 7 days of access with limited data usage.
                                    Downloads for images and videos are disabled.
                                </p>
                                <form action="{{ route('folder.client.store') }}" method="POST">
                                    @csrf
                                    <button type="submit" class="btn active w-100 text-white" style="background: #435ebf">
                                        Create Event <i class="ms-2 bi bi-arrow-right"></i>
                                    </button>
                                </form>
                            </div>
                        </div>

                    </div>
                </div>
            @endif
        @else
            <div class="row justify-content-center">
                <div class="col-12 col-sm-10 col-md-10 mb-4">
                    @include('dashboard.client.event.partials.subscribe.card.pending')
                </div>
            </div>
            <div class="row justify-content-center">
                @foreach ($folders as $f)
                    <div class="col-12 col-sm-10 col-md-10 mb-4">

                        <div class="card d-md-flex flex-md-row rounded border overflow-hidden shadow-sm bg-white p-0">

                            <div class="d-none d-md-block flex-shrink-0"
                                style="width: 35%; max-width: 280px; height: 100%;">
                                <img src="{{ $f->thumbnail }}" alt="Thumbnail {{ $f->name }}"
                                    class="w-100 h-100 object-cover rounded-start">
                            </div>


                            <div class="d-block d-md-none p-3 pb-0">
                                <img src="{{ $f->thumbnail }}" alt="Thumbnail {{ $f->name }}" class="w-100 rounded"
                                    style="max-height: 200px; object-fit: cover;">
                            </div>


                            <div class="card-body d-flex flex-column justify-content-between p-4 flex-grow-1">

                                <div>
                                    <h5 class="font-weight-bold mb-1">{{ $f->name }}</h5>

                                    <p class="text-sm text-muted mb-2">
                                        <i class="bi bi-calendar-event me-1"></i>
                                        {{ \Carbon\Carbon::parse($f->date)->format('d M Y') }}
                                    </p>


                                    @if ($f->is_trial)
                                        <span class=" bg-primary text-light rounded px-3 py-1"
                                            style="--bs-text-opacity: .5; font-size: 0.90em">Trial Event
                                        </span>
                                    @else
                                        <span class=" bg-primary text-light rounded px-3 py-1"
                                            style="--bs-text-opacity: .5; font-size: 0.90em"> Event
                                        </span>
                                    @endif
                                </div>

                                <div class="d-md-none mt-3">
                                    <a href="{{ route('home.show', $f->code) }}" class="btn btn-primary w-100">
                                        Open Event <i class="bi bi-arrow-right ms-2"></i>
                                    </a>
                                </div>
                            </div>

                            <div class="d-none d-md-flex align-items-end p-4">
                                <a href="{{ route('home.show', $f->code) }}"
                                    class="btn btn-primary text-white d-flex align-items-center justify-content-center">
                                    Open Event <i class="bi bi-arrow-right ms-2 "></i>
                                </a>
                            </div>
                        </div>
                    </div>
                @endforeach

            </div>
        @endif
    </div>



    {{-- Pricelist --}}
    @include('dashboard.client.partials.pricelist')

    {{-- Toggle Setting Bot --}}
    @include('dashboard.client.partials.chatbot')

    <div id="chatbotMessageWrapper" style="{{ $user->chatbot_status ? '' : 'display:none;' }}">
        @include('dashboard.client.partials.message')
    </div>

@endsection


@push('styles')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <style>
        .flatpickr-months {
            background: #435ebf !important;
        }

        .flatpickr-current-month {
            color: #fff !important;
        }

        .flatpickr-months .flatpickr-prev-month,
        .flatpickr-months .flatpickr-next-month {
            color: #fff !important;
        }

        .flatpickr-months .flatpickr-prev-month svg,
        .flatpickr-months .flatpickr-next-month svg {
            fill: #fff !important;
        }

        .flatpickr-weekdays {
            background: #435ebf !important;
        }

        .flatpickr-weekday {
            color: #fff !important;
            font-weight: 500;
        }

        .flatpickr-day.selected,
        .flatpickr-day.startRange,
        .flatpickr-day.endRange,
        .flatpickr-day.selected:hover,
        .flatpickr-day.startRange:hover,
        .flatpickr-day.endRange:hover {
            background: #435ebf !important;
            border-color: #435ebf !important;
            color: #fff !important;
        }

        .flatpickr-day.today {
            border-color: #435ebf !important;
        }

        .flatpickr-day:hover {
            background: rgba(67, 94, 191, 0.15) !important;
        }

        .flatpickr-day.disabled,
        .flatpickr-day.prevMonthDay,
        .flatpickr-day.nextMonthDay {
            color: #cbd5e1 !important;
        }

        .flatpickr-calendar.arrowTop:before,
        .flatpickr-calendar.arrowTop:after {
            border-bottom-color: #435ebf !important;
        }
    </style>
@endpush

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>

    <script>
        @if (session('success'))
            showToast(@json(session('success')), 'success');
        @endif

        @if (session('error'))
            showToast(@json(session('error')), 'error');
        @endif

        @if (session('warning'))
            showToast(@json(session('warning')), 'warning');
        @endif
    </script>
    {{-- Toggle --}}
    <script>
        document.addEventListener('DOMContentLoaded', function() {

            const toggle = document.getElementById('waSettingToggle');
            const saveBtn = document.getElementById('saveWaSettingBtn');
            const messageWrapper = document.getElementById('chatbotMessageWrapper');

            let initialValue = toggle.checked;

            toggle.addEventListener('change', function() {
                saveBtn.disabled = (toggle.checked === initialValue);
            });

            saveBtn.addEventListener('click', function() {
                saveBtn.disabled = true;

                fetch("{{ route('home.togglewa', $user->id) }}", {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': "{{ csrf_token() }}"
                        },
                        body: JSON.stringify({
                            chatbot_status: toggle.checked ? 1 : 0
                        })
                    })
                    .then(res => {
                        if (!res.ok) throw new Error('Request gagal');
                        return res.json();
                    })
                    .then(data => {
                        initialValue = toggle.checked;
                        saveBtn.disabled = true;

                        if (toggle.checked) {
                            messageWrapper.style.display = '';
                        } else {
                            messageWrapper.style.display = 'none';
                        }

                        showToast(data.message, 'success');
                    })
                    .catch(err => {
                        showToast(err.message, 'error');
                        saveBtn.disabled = false;
                    });
            });
        });
    </script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {

            const modal = document.getElementById('createEventModal');

            modal.addEventListener('shown.bs.modal', function() {
                flatpickr("#eventDatePicker", {
                    dateFormat: "Y-m-d",
                    minDate: "today",
                    disableMobile: true,
                    allowInput: true,
                    animate: true,

                });
            });

        });
    </script>
@endpush
