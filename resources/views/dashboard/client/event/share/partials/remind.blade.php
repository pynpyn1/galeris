<div class="col-md-7">
    <div class="card shadow-sm mb-4">
        <div class="card-body">

            <div class="d-flex justify-content-between align-items-center mb-2">
                <h5 class="mb-0">Remind guests</h5>

                <div class="form-check form-switch">
                    <input class="form-check-input" type="checkbox" id="remindGuestToggle"
                        {{ $link?->send_wa ? 'checked' : '' }}>
                </div>
            </div>

            <p class="text-muted" style="font-size: 0.9rem;">
                Get more uploads by giving your guests the option to receive a gallery link via Email the day after.
            </p>

            <button class="btn btn-primary w-100" id="saveRemindBtn" disabled>
                Save
            </button>

        </div>
    </div>
</div>
