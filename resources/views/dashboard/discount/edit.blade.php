@extends('dashboard.layouts.app')

@section('title', 'Edit Discount')
@section('name_header', 'Edit Discount')

@section('content')

    <section class="section">
        <div class="card">
            <div class="card-header">
                <h4>Edit Discount Code</h4>
            </div>
            <div class="card-body">
                <form method="POST" action="{{ route('manage.discount.update', $discount->id) }}">
                    @csrf
                    @method('PUT')

                    <div class="row">
                        <div class="col-md-6">
                            <label>Code</label>
                            <input type="text" name="code" class="form-control" value="{{ $discount->code }}" required>
                        </div>

                        <div class="col-md-6">
                            <label>Type</label>
                            <select name="type" class="form-control">
                                <option value="fixed" {{ $discount->type == 'fixed' ? 'selected' : '' }}>Fixed</option>
                                <option value="percent" {{ $discount->type == 'percent' ? 'selected' : '' }}>Percent
                                </option>
                            </select>
                        </div>

                        <div class="col-md-6 mt-2">
                            <label>Value</label>
                            <input type="number" name="value" class="form-control" value="{{ $discount->value }}">
                        </div>

                        <div class="col-md-6 mt-2">
                            <label>Quota</label>
                            <input type="number" name="quota" class="form-control" value="{{ $discount->quota }}">
                        </div>

                        <div class="col-md-6 mt-2">
                            <label>Start At</label>
                            <input type="datetime-local" name="start_at" class="form-control"
                                value="{{ optional($discount->start_at)->format('Y-m-d\TH:i') }}">
                        </div>

                        <div class="col-md-6 mt-2">
                            <label>End At</label>
                            <input type="datetime-local" name="end_at" class="form-control"
                                value="{{ optional($discount->end_at)->format('Y-m-d\TH:i') }}">
                        </div>

                        <div class="col-md-6 mt-2">
                            <label>Status</label>
                            <select name="is_active" class="form-control">
                                <option value="1" {{ $discount->is_active ? 'selected' : '' }}>Active</option>
                                <option value="0" {{ !$discount->is_active ? 'selected' : '' }}>Inactive</option>
                            </select>
                        </div>

                        <div class="col-12 mt-3 d-flex justify-content-end">
                            <button class="btn btn-primary me-1">Update</button>
                            <a href="{{ route('manage.discount.index') }}" class="btn btn-light-secondary">Cancel</a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </section>

@endsection
