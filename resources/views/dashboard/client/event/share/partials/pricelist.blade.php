    <div class="row justify-content-center mb-5">
        @foreach ($packages as $package)
            @if ($package->plan === 'pro')
                @continue
            @endif
            @if ($package->plan === 'beginner')
                @continue
            @endif
            <div class="col-12 col-sm-10 col-md-4 mb-4">

                <div
                    class="card shadow-sm h-100 p-4 border-0 position-relative overflow-hidden
                {{ $package->plan === 'premium' ? 'bg-primary text-white' : 'bg-white text-dark' }}">

                    {{-- Badge Promo --}}
                    @if ($package->plan === 'premium')
                        <div class="position-absolute top-0 end-0 px-4 py-2 text-uppercase fw-bold bg-light text-primary"
                            style="border-bottom-left-radius: 1rem; z-index: 10;">
                            Save Rp120.000
                        </div>
                    @endif

                    <div class="card-body d-flex flex-column text-center p-0">

                        <span
                            class="text-uppercase fw-bold mt-4 mb-2
                        {{ $package->plan === 'premium' ? 'text-light' : 'text-primary' }}">
                            {{ $package->package_name }}
                        </span>

                        <h2 class="mb-4 fw-bolder d-flex justify-content-center align-items-end
                        {{ $package->plan === 'premium' ? 'text-white' : 'text-primary' }}"
                            style="font-size: 2.8rem; gap: 4px;">

                            Rp{{ number_format($package->price, 0, ',', '.') }}

                            <span class="fw-normal" style="font-size: 0.9rem; opacity: 0.8;">
                                / event
                            </span>
                        </h2>


                        <p class="mb-4 text-start">
                            {{ $package->package_desc }}
                        </p>

                        <h6
                            class="fw-bold mb-3 text-start text-uppercase
                        {{ $package->plan === 'premium' ? 'text-light' : 'text-primary' }}">
                            Termasuk
                        </h6>

                        <ul class="list-unstyled text-start mb-auto">
                            @foreach ($package->feature as $feature)
                                <li class="mb-2 d-flex align-items-start">
                                    <i class="bi bi-check-circle-fill me-2 mt-1
                                    {{ $package->plan === 'premium' ? 'text-light' : 'text-success' }}"
                                        style="font-size: 1.1rem;">
                                    </i>
                                    <span>{{ $feature }}</span>
                                </li>
                            @endforeach
                        </ul>

                        <a href="{{ route('home.subscribe') }}"
                            class="btn mt-4 fw-bold py-3 w-100 d-flex align-items-center justify-content-center
                        {{ $package->plan === 'premium' ? 'btn-light text-primary' : 'btn-primary' }}"
                            style="border-radius: 0.75rem;">
                            <i class="bi bi-bag-check-fill me-2"></i>
                            Beli {{ $package->package_name }}
                        </a>

                    </div>
                </div>
            </div>
        @endforeach
    </div>
