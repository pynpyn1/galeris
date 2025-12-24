@extends('dashboard.layouts.app-event')

@section('title', $event->name)

@section('content')

    @include('dashboard.client.event.partials.event')

    {{-- Card download QR Code --}}
    @include('dashboard.client.event.partials.qrcode')


    {{-- Manage upload --}}
    @include('dashboard.client.event.partials.manageup')

    {{-- Show Guest --}}



    {{-- PriceList (Statis) --}}
    @include('dashboard.client.event.share.partials.pricelist')


    {{-- Modal Edit Detail Event --}}
    @include('dashboard.client.event.partials.modal.detail')

    {{-- Modal Edit Thumbnail --}}
    @include('dashboard.client.event.partials.modal.thumbnail')







@endsection

@push('styles')
    <link href="https://unpkg.com/filepond/dist/filepond.css" rel="stylesheet">
    <link href="https://unpkg.com/filepond-plugin-image-preview/dist/filepond-plugin-image-preview.css" rel="stylesheet">
    <style>
        .btn-edit-thumb {
            background: rgba(0, 0, 0, 0.45);
            color: #fff;
            border: 1px solid rgba(255, 255, 255, 0.3);
            backdrop-filter: blur(6px);
            border-radius: 999px;
            transition: all 0.3s ease;
        }

        .btn-edit-thumb:hover {
            background: rgba(0, 0, 0, 0.65);
            color: #fff;
            transform: translate(-50%, -2px);
        }

        .img-cover {
            width: 100%;
            height: 100%;
            object-fit: cover;
            object-position: center;
        }


        .filepond--root {
            max-height: none;
            font-family: inherit;
        }

        .event-upload .filepond--panel-root {
            background: #f9fafb;
            border: 2px dashed #d1d5db;
            border-radius: 16px;
        }

        .event-upload .filepond--drop-label {
            min-height: 35vh;
            color: #6b7280;
            font-size: 16px;
        }

        .event-upload .filepond--drop-label label {
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 12px;
        }

        .event-upload .filepond--drop-label label::before {
            content: '';
            width: 48px;
            height: 48px;
            background: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' fill='none' stroke='%236b7280' stroke-width='2' viewBox='0 0 24 24'%3E%3Cpath d='M12 16V4M12 4l-4 4M12 4l4 4M4 16v2a2 2 0 002 2h12a2 2 0 002-2v-2'/%3E%3C/svg%3E") no-repeat center;
            background-size: contain;
        }

        .filepond--credits {
            display: none;
        }
    </style>
@endpush

@push('scripts')
    <script src="https://unpkg.com/filepond/dist/filepond.js"></script>
    <script src="https://unpkg.com/filepond-plugin-image-preview/dist/filepond-plugin-image-preview.js"></script>
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
    <script>
        FilePond.registerPlugin(FilePondPluginImagePreview);

        FilePond.create(document.querySelector('.event-upload'), {
            instantUpload: true,
            allowMultiple: false,

            server: {
                process: {
                    url: "{{ route('home.thumbnail', $event->id) }}",
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    onload: () => {
                        location.reload();
                    }
                }
            }
        });
    </script>
@endpush
