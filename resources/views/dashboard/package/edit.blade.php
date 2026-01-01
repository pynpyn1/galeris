@extends('dashboard.layouts.app')

@section('title', 'Edit Package')
@section('name_header', 'Edit Package')

@section('breadcrumbs')
    <?php
    $breadcrumbs = [['name' => 'Package Manage', 'link' => route('manage.package.index')]];
    ?>
@endsection

@section('content')

    @if ($errors->any())
        <div class="alert alert-danger alert-dismissible fade show">
            <strong>Gagal Menyimpan!</strong> Silakan periksa kembali input Anda.
            <button class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <div id="feature-error" class="alert alert-danger alert-dismissible fade show d-none">
        <strong>Gagal Menyimpan!</strong> Minimal harus ada 3 fitur dan tidak boleh kosong.
        <button class="btn-close" data-bs-dismiss="alert"></button>
    </div>

    <section id="multiple-column-form">
        <div class="row match-height">
            <div class="col-12">
                <div class="card">

                    <div class="card-header">
                        <h4 class="card-title">{{ $package->package_name }}</h4>
                    </div>

                    <div class="card-body">
                        <form method="POST" action="{{ route('manage.package.update', $package->id) }}">
                            @csrf
                            @method('PUT')

                            <div class="row">

                                <div class="col-md-6 col-12">
                                    <div class="form-group">
                                        <label>Plan</label>
                                        <select name="plan" class="form-control">
                                            @foreach (['beginner', 'basic', 'pro', 'premium'] as $plan)
                                                <option value="{{ $plan }}"
                                                    {{ old('plan', $package->plan) == $plan ? 'selected' : '' }}>
                                                    {{ ucfirst($plan) }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                <div class="col-md-6 col-12">
                                    <div class="form-group">
                                        <label>Package Name</label>
                                        <input type="text" name="package_name" class="form-control"
                                            value="{{ old('package_name', $package->package_name) }}">
                                    </div>
                                </div>

                                <div class="col-12">
                                    <div class="form-group">
                                        <label>Description</label>
                                        <textarea name="package_desc" rows="4" class="form-control">{{ old('package_desc', $package->package_desc) }}</textarea>
                                    </div>
                                </div>

                                <div class="col-md-6 col-12">
                                    <div class="form-group">
                                        <label>Price</label>
                                        <div class="input-group">
                                            <span class="input-group-text">Rp</span>
                                            <input type="text" name="price" class="form-control"
                                                value="{{ old('price', number_format($package->price, 0, ',', '.')) }}"
                                                oninput="formatRupiah(this)">
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-6 col-12">
                                    <div class="form-group">
                                        <label>Storage Limit (GB)</label>
                                        <input type="number" name="storage_limit_gb" class="form-control"
                                            value="{{ old('storage_limit_gb', $package->storage_limit_gb) }}">
                                    </div>
                                </div>

                                <div class="col-12 mt-3">
                                    <label class="mb-1">Features</label>

                                    @php
                                        $features = old('features', $package->feature ?? []);
                                        if (count($features) < 3) {
                                            $features = array_pad($features, 3, '');
                                        }
                                    @endphp

                                    <div id="features-wrapper">
                                        @foreach ($features as $feature)
                                            <div class="input-group mb-2 feature-item">
                                                <input type="text" name="features[]" class="form-control"
                                                    value="{{ $feature }}">
                                                <button type="button" class="btn btn-danger remove-feature">
                                                    <i class="bi bi-trash"></i>
                                                </button>
                                            </div>
                                        @endforeach
                                    </div>

                                    <button type="button" class="btn btn-sm btn-outline-primary mt-2"
                                        onclick="addFeature()">
                                        + Tambah Feature
                                    </button>
                                </div>

                                <div class="col-12 mt-3">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="is_active" value="1"
                                            id="is_active" {{ old('is_active', $package->is_active) ? 'checked' : '' }}>
                                        <label class="form-check-label" for="is_active">
                                            Package Active
                                        </label>
                                    </div>
                                </div>

                                <div class="col-12 d-flex justify-content-end mt-4">
                                    <button type="submit" class="btn btn-primary me-1">
                                        Update Package
                                    </button>
                                    <a href="{{ route('manage.package.index') }}" class="btn btn-light-secondary">
                                        Cancel
                                    </a>
                                </div>

                            </div>
                        </form>
                    </div>

                </div>
            </div>
        </div>
    </section>

@endsection

@push('scripts')
    <script>
        function formatRupiah(input) {
            let value = input.value.replace(/[^0-9]/g, '');
            input.value = value.replace(/\B(?=(\d{3})+(?!\d))/g, ".");
        }

        function addFeature() {
            const wrapper = document.getElementById('features-wrapper');
            const div = document.createElement('div');
            div.classList.add('input-group', 'mb-2', 'feature-item');
            div.innerHTML = `
            <input type="text" name="features[]" class="form-control">
            <button type="button" class="btn btn-danger remove-feature">
                <i class="bi bi-trash"></i>
            </button>
        `;
            wrapper.appendChild(div);
        }

        document.addEventListener('click', function(e) {
            if (e.target.closest('.remove-feature')) {
                const items = document.querySelectorAll('.feature-item');
                if (items.length > 1) {
                    e.target.closest('.feature-item').remove();
                }
            }
        });

        document.querySelector('form').addEventListener('submit', function(e) {
            const featureInputs = document.querySelectorAll('input[name="features[]"]');
            const featureError = document.getElementById('feature-error');
            let filled = 0;

            featureInputs.forEach(input => {
                if (input.value.trim() !== '') {
                    filled++;
                }
            });

            if (filled < 3) {
                e.preventDefault();
                featureError.classList.remove('d-none');
                featureError.scrollIntoView({
                    behavior: 'smooth'
                });
            } else {
                featureError.classList.add('d-none');
            }
        });
    </script>
@endpush
