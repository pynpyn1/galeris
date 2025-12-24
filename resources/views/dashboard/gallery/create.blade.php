@extends('dashboard.layouts.app')

@section('title', 'Add Gallery')
@section('name_header', 'Add Gallery')

@section('breadcrumbs')
    <?php
    $breadcrumbs = [['name' => 'Gallery Manage', 'link' => route('manage.gallery.index')]];
    ?>
@endsection

@section('content')
    <div class="card">
        <div class="card-body">
            <form action="{{ route('manage.gallery.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="mb-3">
                    <label for="title" class="form-label">Title</label>
                    <input type="text" name="title" class="form-control" value="{{ old('title') }}" required>
                </div>

                <div class="mb-3">
                    <label for="descrtiption" class="form-label">Description</label>
                    <textarea name="descrtiption" class="form-control">{{ old('descrtiption') }}</textarea>
                </div>

                <div class="mb-3">
                    <label for="image" class="form-label">Image</label>
                    <input type="file" name="image" class="form-control" required>
                </div>

                <button type="submit" class="btn btn-primary">Save</button>
            </form>
        </div>
    </div>
@endsection
