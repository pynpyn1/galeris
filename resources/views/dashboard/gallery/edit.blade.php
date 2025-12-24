@extends('dashboard.layouts.app')

@section('title', 'Edit Gallery')
@section('name_header', 'Edit Gallery')

@section('breadcrumbs')
    <?php
    $breadcrumbs = [['name' => 'Gallery Manage', 'link' => route('manage.gallery.index')]];
    ?>
@endsection

@section('content')
    <div class="card">
        <div class="card-body">
            <form action="{{ route('manage.gallery.update', $gallery->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="mb-3">
                    <label for="title" class="form-label">Title</label>
                    <input type="text" name="title" class="form-control" value="{{ old('title', $gallery->title) }}"
                        required>
                </div>

                <div class="mb-3">
                    <label for="descrtiption" class="form-label">Description</label>
                    <textarea name="descrtiption" class="form-control">{{ old('descrtiption', $gallery->descrtiption) }}</textarea>
                </div>

                <div class="mb-3">
                    <label for="image" class="form-label">Image</label>
                    <input type="file" name="image" class="form-control">
                    @if ($gallery->image_path)
                        <img src="{{ asset('storage/' . $gallery->image_path) }}" class="img-thumbnail mt-2"
                            style="width:150px;height:100px;object-fit:cover;">
                    @endif
                </div>

                <button type="submit" class="btn btn-primary">Update</button>
            </form>
        </div>
    </div>
@endsection
