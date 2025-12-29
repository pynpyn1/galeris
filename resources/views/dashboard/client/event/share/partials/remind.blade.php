<div class="col-md-7">
    <div class="card shadow-sm mb-4">
        <div class="card-body">

            <div class="d-flex justify-content-between align-items-center mb-2">
                <h5 class="mb-0">Ingatkan para tamu</h5>

                <div class="form-check form-switch">
                    <input class="form-check-input" type="checkbox" id="remindGuestToggle"
                        {{ $link?->send_wa ? 'checked' : '' }}>
                </div>
            </div>

            <p class="text-muted" style="font-size: 0.9rem;">
                Dapatkan lebih banyak unggahan dengan memberi tamu Anda opsi untuk menerima tautan galeri melalui
                Whatsapp sehari setelahnya.
            </p>

            <button class="btn btn-primary w-100" id="saveRemindBtn" disabled>
                Save
            </button>

        </div>
    </div>
</div>
