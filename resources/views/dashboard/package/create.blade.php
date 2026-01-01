@extends('dashboard.layouts.app')

@section('title', 'Add Package')
@section('name_header', 'Add Package')

@section('breadcrumbs')
    <?php
    $breadcrumbs = [['name' => 'Package Manage', 'link' => route('manage.package.index')]];
    ?>
@endsection

@section('content')

    @if ($errors->any())
        <div class="alert alert-danger alert-dismissible fade show">
            <strong>Gagal Menyimpan!</strong> Silakan periksa kembali input Anda.
            <ul class="mb-0 mt-2">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
            <button class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <section id="multiple-column-form">
        <div class="row match-height">
            <div class="col-12">
                <div class="card">

                    <div class="card-header">
                        <h4 class="card-title">Create New Package</h4>
                    </div>

                    <div class="card-body">
                        <form method="POST" action="{{ route('manage.package.store') }}">
                            @csrf

                            <div class="row">

                                {{-- Plan --}}
                                <div class="col-md-6 col-12">
                                    <div class="form-group">
                                        <label>Plan</label>
                                        <select name="plan" class="form-control @error('plan') is-invalid @enderror">
                                            @foreach (['beginner', 'basic', 'pro', 'premium'] as $plan)
                                                <option value="{{ $plan }}"
                                                    {{ old('plan') == $plan ? 'selected' : '' }}>
                                                    {{ ucfirst($plan) }}
                                                </option>
                                            @endforeach
                                        </select>
                                        @error('plan')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                {{-- Package Name --}}
                                <div class="col-md-6 col-12">
                                    <div class="form-group">
                                        <label>Package Name</label>
                                        <input type="text" name="package_name"
                                            class="form-control @error('package_name') is-invalid @enderror"
                                            value="{{ old('package_name') }}">
                                        @error('package_name')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                {{-- Description --}}
                                <div class="col-12">
                                    <div class="form-group">
                                        <label>Description</label>
                                        <textarea name="package_desc" rows="4" class="form-control @error('package_desc') is-invalid @enderror">{{ old('package_desc') }}</textarea>
                                        @error('package_desc')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                {{-- Price --}}
                                <div class="col-md-6 col-12">
                                    <div class="form-group">
                                        <label>Price</label>
                                        <div class="input-group">
                                            <span class="input-group-text">Rp</span>
                                            <input type="text" name="price"
                                                class="form-control @error('price') is-invalid @enderror" placeholder="0"
                                                value="{{ old('price') }}" oninput="formatRupiah(this)">
                                        </div>
                                        @error('price')
                                            <div class="invalid-feedback d-block">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                {{-- Storage --}}
                                <div class="col-md-6 col-12">
                                    <div class="form-group">
                                        <label>Storage Limit (GB)</label>
                                        <input type="number" name="storage_limit_gb" class="form-control"
                                            value="{{ old('storage_limit_gb') }}">
                                    </div>
                                </div>

                                {{-- Features --}}
                                <div class="col-12 mt-3">
                                    <label class="mb-1">Fitur</label>

                                    <div id="features-wrapper">
                                        @php
                                            $oldFeatures = old('features', ['', '', '']);
                                        @endphp

                                        @foreach ($oldFeatures as $index => $feature)
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
                                        + Tambah Fitur
                                    </button>
                                </div>

                                {{-- Action --}}
                                <div class="col-12 d-flex justify-content-end mt-4">
                                    <button type="submit" class="btn btn-primary me-1">
                                        Save Package
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
            <input type="text" name="features[]" class="form-control"
                placeholder="Contoh: Priority Support">
            <button type="button" class="btn btn-danger remove-feature">
                <i class="bi bi-trash"></i>
            </button>
        `;

            wrapper.appendChild(div);
        }

        document.addEventListener('click', function(e) {
            if (e.target.closest('.remove-feature')) {
                const item = e.target.closest('.feature-item');
                if (document.querySelectorAll('.feature-item').length > 1) {
                    item.remove();
                }
            }
        });
    </script>
@endpush
