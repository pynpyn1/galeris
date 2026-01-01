<div class="modal fade" id="createEventModal" tabindex="-1" aria-labelledby="createEventModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow">

            {{-- Header --}}
            <div class="modal-header">
                <h5 class="modal-title fw-bold" id="createEventModalLabel">
                    Create New Event
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            {{-- Form --}}
            <form action="{{ route('folder.client.store') }}" method="POST">
                @csrf

                <div class="modal-body">

                    {{-- Event Name --}}
                    <div class="mb-3">
                        <label class="form-label fw-semibold">
                            Nama Acara
                        </label>
                        <input type="text" name="name" class="form-control"
                            placeholder="Wedding, Birthday Party, Baptism" required>
                    </div>

                    {{-- Event Date --}}
                    <div class="mb-3">
                        <label class="form-label fw-semibold">
                            Tanggal Acara Dimulai
                        </label>
                        <input type="text" name="date_event" id="eventDatePicker" class="form-control"
                            placeholder="Select event date" required>

                    </div>

                    <small class="text-muted">
                        Event will be active for 1 weeks automatically.
                    </small>
                </div>

                {{-- Footer --}}
                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">
                        Cancel
                    </button>
                    <button type="submit" class="btn text-white" style="background:#435ebf">
                        Create Event
                    </button>
                </div>
            </form>

        </div>
    </div>
</div>
