@extends('dashboard.layouts.app')
@section('title', 'Penugasan Role')
@section('name_header', 'Assignment')

@section('breadcrumbs')
    <?php
    $breadcrumbs = [['name' => 'Role Permission', 'link' => route('manage.roles.index')]];
    ?>
@endsection

@section('content')
    <div class="container">

        <a href="{{ route('manage.roles.index') }}" class="btn btn-secondary mb-4">
            Back
        </a>

        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif
        @if (session('error'))
            <div class="alert alert-danger">{{ session('error') }}</div>
        @endif

        <div class="card">
            <div class="card-header bg-transparent text-white">
                <h3>Assignment</h3>
            </div>
            <div class="card-body">
                <form action="{{ route('manage.roles.assign') }}" method="POST">
                    @csrf
                    @method('PUT')
                    @if ($roleGroups->isEmpty() || $permissions->isEmpty())
                        <div class="alert alert-warning">
                            <p>Silakan buat setidaknya satu Role Group dan satu Permission di halaman Kelola sebelum
                                melakukan penugasan.</p>
                        </div>
                    @else
                        <div class="table-responsive">
                            <table class="table table-bordered table-striped text-center">
                                <thead class="table-dark">
                                    <tr>
                                        <th>Permissions</th>
                                        @foreach ($roleGroups as $group)
                                            <th class="text-warning">{{ $group->name }}</th>
                                        @endforeach
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($permissions as $permission)
                                        <tr>
                                            <td class="text-start">
                                                <strong>{{ $permission->name }}</strong>
                                                <small class="text-muted d-block">({{ $permission->slug }})</small>
                                            </td>
                                            @foreach ($roleGroups as $group)
                                                @php
                                                    $isAssigned = $group->permissions->contains($permission->id);
                                                @endphp
                                                <td>
                                                    <div class="form-check form-check-inline">
                                                        <input class="form-check-input" type="checkbox"
                                                            name="assignments[{{ $group->id }}][{{ $permission->id }}]"
                                                            value="1"
                                                            id="check-{{ $group->id }}-{{ $permission->id }}"
                                                            {{ $isAssigned ? 'checked' : '' }}>
                                                        <label class="form-check-label visually-hidden"
                                                            for="check-{{ $group->id }}-{{ $permission->id }}"></label>
                                                    </div>
                                                </td>
                                            @endforeach
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <button type="submit" class="btn btn-success mt-3 w-100">Simpan</button>
                    @endif
                </form>
            </div>
        </div>
    </div>
@endsection
