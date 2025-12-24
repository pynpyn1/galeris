<div class="modal fade" id="editDetailModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <form method="POST" action="{{ route('home.update', $event->public_code) }}">
            @csrf
            @method('PUT')

            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Edit Event</h5>
                    <button class="btn-close " data-bs-dismiss="modal"></button>
                </div>

                <div class="modal-body">
                    <div class="mb-3">
                        <p class="mb-1 fw-semibold">Event title</p>
                        <input type="text" name="name" class="form-control" value="{{ $event->name }}" required>
                    </div>

                    <div class="mb-2">
                        <p class="mb-1 fw-semibold">Activation date</p>
                        <input type="text" class="form-control"
                            value="{{ \Carbon\Carbon::parse($event->date_event)->format('d M Y') }}" readonly>

                    </div>

                    <span class="text-muted" style="font-size: 0.85rem;">
                        From the date you choose, your guests can upload photos and videos for 3 months.
                        The date cannot be changed once the event has started.
                    </span>

                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-primary" data-bs-dismiss="modal">
                        Cancel
                    </button>
                    <button type="submit" class="btn btn-primary">
                        Save
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>
