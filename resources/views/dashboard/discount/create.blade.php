@extends('dashboard.layouts.app')

@section('title', 'Add Discount')
@section('name_header', 'Add Discount')

@section('content')
    <section class="section">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card border-0 shadow-sm">
                    <div class="card-header bg-transparent border-bottom py-3">
                        <h4 class="card-title mb-0">Create New Discount Code</h4>
                    </div>
                    <div class="card-body p-4">
                        <form method="POST" action="{{ route('manage.discount.store') }}">
                            @csrf

                            <div class="row g-3">
                                <div class="col-md-6">
                                    <label class="form-label fw-bold">Discount Code</label>
                                    <input type="text" name="code" class="form-control form-control-lg text-uppercase"
                                        placeholder="E.g. PROMO2024" required value="{{ old('code') }}">
                                    <small class="text-muted">Unique code for customers to use.</small>
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label fw-bold">Discount Type</label>
                                    <select name="type" id="discount_type" class="form-select form-select-lg" required>
                                        <option value="fixed" {{ old('type') == 'fixed' ? 'selected' : '' }}>Fixed Amount
                                            (IDR)</option>
                                        <option value="percent" {{ old('type') == 'percent' ? 'selected' : '' }}>Percentage
                                            (%)</option>
                                    </select>
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label fw-bold">Discount Value</label>
                                    <div class="input-group input-group-lg">
                                        <span class="input-group-text" id="addon-prefix">Rp</span>
                                        <input type="number" name="value" class="form-control" placeholder="0" required
                                            value="{{ old('value') }}">
                                        <span class="input-group-text d-none" id="addon-suffix">%</span>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label fw-bold">Usage Quota</label>
                                    <div class="input-group input-group-lg">
                                        <input type="number" name="quota" class="form-control" placeholder="Unlimited"
                                            value="{{ old('quota') }}">
                                        <span class="input-group-text"><i class="bi bi-people"></i></span>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label fw-bold">Start Date</label>
                                    <input type="datetime-local" name="start_at" class="form-control form-control-lg"
                                        value="{{ old('start_at') }}">
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label fw-bold">End Date</label>
                                    <input type="datetime-local" name="end_at" class="form-control form-control-lg"
                                        value="{{ old('end_at') }}">
                                </div>

                                <div class="col-md-12">
                                    <label class="form-label fw-bold d-block">Initial Status</label>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="is_active" id="active"
                                            value="1" checked>
                                        <label class="form-check-label" for="active">Active</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="is_active" id="inactive"
                                            value="0">
                                        <label class="form-check-label" for="inactive">Inactive</label>
                                    </div>
                                </div>

                                <hr class="mt-4">

                                <div class="col-12 d-flex justify-content-end gap-2">
                                    <a href="{{ route('manage.discount.index') }}" class="btn btn-light px-4">Cancel</a>
                                    <button type="submit" class="btn btn-primary px-5 shadow-sm">
                                        Submit Discount
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
