<div class="row justify-content-center mt-4">
    <div class="col-md-10">
        <div class="card shadow-sm mb-4">
            <div class="card-body">

                <!-- Header -->
                <div class="d-flex justify-content-between align-items-center mb-2">
                    <h5 class="mb-0">Pengaturan Whatsapp </h5>

                    <div class="form-check form-switch">
                        <input class="form-check-input" type="checkbox" id="waSettingToggle"
                            {{ $user->chatbot_status ? 'checked' : '' }}>
                    </div>
                </div>

                <!-- Description -->
                <p class="text-muted" style="font-size: 0.9rem;">
                    Aktifkan fitur ini untuk menghubungkan WhatsApp Anda melalui pemindaian QR
                    dan gunakan sebagai bot pesan otomatis.
                    Pesan dapat disesuaikan dengan kebutuhan Anda dan akan dikirimkan kepada tamu.
                </p>


                <!-- Save Button -->
                <button class="btn btn-primary w-100" id="saveWaSettingBtn" disabled>
                    Save Settings
                </button>


            </div>
        </div>
    </div>

</div>
