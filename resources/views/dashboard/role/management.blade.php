@extends('dashboard.layouts.app')
@section('title', 'Kelola Group & Permission')
@section('name_header', 'Kelola Role Group & Permissions')

@section('breadcrumbs')
    <?php
    $breadcrumbs = [['name' => 'Role Permission', 'link' => route('manage.roles.index')]];
    ?>
@endsection

@section('content')
    <div class="container">
        <h1 class="mb-4">Pengelolaan Group </h1>
        <a href="{{ route('manage.roles.index') }}" class="btn btn-secondary mb-4 ">
            Back
        </a>

        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif
        @if (session('error'))
            <div class="alert alert-danger">{{ session('error') }}</div>
        @endif




        <div class="card mb-4">
            <div class="card-header bg-transparent text-white">
                <h3>Role Group</h3>
            </div>
            <div class="card-body">
                <h4>Tambah Role Group Baru</h4>
                <form action="{{ route('manage.roles.group') }}" method="POST" class="d-flex mb-4">
                    @csrf
                    <input type="text" name="name" class="form-control me-2"
                        placeholder="Nama Role Group (ex: Admin, User)" required>
                    <button type="submit" class="btn btn-primary">Tambah</button>
                </form>
                <hr>
                <h4>Daftar Role Groups</h4>
                <ul class="list-group">
                    @forelse ($roleGroups as $group)
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            <span>{{ $group->name }} <span
                                    class="badge bg-secondary rounded-pill">{{ $group->id }}</span></span>

                            {{-- FORM UNTUK DELETE ROLE GROUP --}}
                            <form action="{{ route('manage.roles.group.destroy', $group->id) }}" method="POST"
                                onsubmit="return confirm('Apakah Anda yakin ingin menghapus Role Group {{ $group->name }}? Ini akan menghapus semua penugasannya juga.');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm">Hapus</button>
                            </form>
                        </li>
                    @empty
                        <li class="list-group-item text-muted">Belum ada Role Group.</li>
                    @endforelse
                </ul>
            </div>
        </div>


    </div>
@endsection
