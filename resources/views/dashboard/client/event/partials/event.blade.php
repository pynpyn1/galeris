    {{-- Card Event --}}
    <div class="row justify-content-center mt-5">
        <div class="col-md-8">

            <div class="card d-flex flex-md-row shadow-sm">

                <div class="position-relative d-none d-md-block" style="width:60vh !important; max-width:280px;">
                    <img src="{{ $event->thumbnail }}" class="w-100 h-100 img-cover rounded-start">

                    <button data-bs-toggle="modal" data-bs-target="#editThumbnailModal"
                        class="btn btn-sm btn-edit-thumb d-flex justify-content-center align-items-center position-absolute start-50 bottom-0 translate-middle-x mb-2 px-3 py-1">
                        <i class="bi bi-image me-1"></i> Edit
                    </button>
                </div>

                <div class="card-body d-flex flex-column">

                    <div class="position-relative d-block d-md-none mb-4">
                        <img src="{{ $event->thumbnail }}" class="w-100 h-100 img-cover object-cover rounded">

                        <button class="btn btn-sm btn-light position-absolute top-0 start-0 m-2" data-bs-toggle="modal"
                            data-bs-target="#editThumbnailModal">
                            <i class="bi bi-image"></i> Edit
                        </button>
                    </div>

                    <h4 class="mb-1">{{ $event->name }}</h4>

                    <div class="mb-4">
                        <p class="text-muted text-sm mb-1">
                            <i class="bi bi-calendar-event"></i>
                            {{ \Carbon\Carbon::parse($event->date_event)->format('d M Y') }}
                        </p>

                        <span class="text-muted" style="font-size: 0.85rem;">
                            The event expires on
                            {{ \Carbon\Carbon::parse($event->date_event_end)->format('d M Y') }}
                        </span>
                    </div>

                    <div class="mt-auto">
                        <button class="btn btn-outline-primary w-100 mb-3" data-bs-toggle="modal"
                            data-bs-target="#editDetailModal">
                            <i class="bi bi-pencil"></i> Edit details
                        </button>

                        <a href="{{ route('provide.photo', $link->slug) }}" class="btn w-100 text-white"
                            style="background:#435ebf">
                            Go to gallery <i class="bi bi-arrow-up-right"></i>
                        </a>

                    </div>

                </div>

            </div>
        </div>
    </div>
