@if (!auth()->user()->canUploadOriginalResolution())
    <div class="alert bg-white shadow-sm d-flex align-items-center p-3" role="alert"
        style="border: none; border-left: 5px solid #ffc107; border-radius: 8px;">

        {{-- Text --}}
        <div class="flex-grow-1">
            <span class="fw-bold text-dark d-block">Resolusi Terbatas</span>
            <span class="text-muted small">Foto anda akan dikompres. Dapatkan kualitas asli dengan paket
                Pro.</span>
        </div>

        {{-- Button --}}
        <a href="{{ route('home.subscribe') }}" class="btn btn-outline-warning text-dark fw-bold btn-sm ms-3">
            Upgrade
        </a>
    </div>
@endif
