@extends('dashboard.layouts.app')

@section('title', 'Dashboard')
@section('name_header', 'Dashboard')

@section('content')

    <div class="row">

        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card shadow border-0 h-100 py-3 bg-white">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-uppercase font-weight-bold text-primary mb-1" style="font-size: 0.7rem;">
                                Total Klien
                            </div>
                            <div class="h4 mb-0 font-weight-bolder text-gray-900">{{ $totalClients }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="bi bi-people-fill text-primary" style="font-size: 2.5rem;"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card shadow border-0 h-100 py-3 bg-white">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-uppercase font-weight-bold text-success mb-1" style="font-size: 0.7rem;">
                                Klien Baru (7 Hari)
                            </div>
                            <div class="h4 mb-0 font-weight-bolder text-gray-900">{{ $newClients }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="bi bi-person-plus-fill text-success" style="font-size: 2.5rem;"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card shadow border-0 h-100 py-3 bg-white">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-uppercase font-weight-bold text-info mb-1" style="font-size: 0.7rem;">
                                Total Folder
                            </div>
                            <div class="h4 mb-0 font-weight-bolder text-gray-900">{{ $totalFolders }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="bi bi-folder-fill text-info" style="font-size: 2.5rem;"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card shadow border-0 h-100 py-3 bg-white">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-uppercase font-weight-bold text-warning mb-1" style="font-size: 0.7rem;">
                                Total Photo
                            </div>
                            <div class="h4 mb-0 font-weight-bolder text-gray-900">{{ $totalPhotos }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="bi bi-image-fill text-warning" style="font-size: 2.5rem;"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">

        <div class="col-lg-6 mb-4">
            <div class="card shadow border-0 mb-4 text-white">
                <div class="card-header py-3 bg-primary ">
                    <h6 class="m-0 font-weight-bold text-white">
                        <i class="bi bi-person-lines-fill mr-2"></i> Klien Terbaru (5 Klien Terakhir Mendaftar)
                    </h6>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover" id="recentClientsTable" width="100%" cellspacing="0">
                            <thead>
                                <tr>
                                    <th>Nama</th>
                                    <th>Email</th>
                                    <th>Terdaftar Sejak</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($recentClients as $client)
                                    <tr>
                                        <td>{{ $client->name }}</td>
                                        <td>{{ $client->email }}</td>
                                        {{-- Sudah benar menggunakan Null Safe Operator --}}
                                        <td>{{ $client->created_at?->diffForHumans() ?? 'N/A' }}</td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="3" class="text-center text-muted">Tidak ada data klien
                                            baru.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-6 mb-4">
            <div class="card shadow border-0 mb-4">
                <div class="card-header py-3 bg-info ">
                    <h6 class="m-0 font-weight-bold text-white">
                        <i class="bi bi-folder-check mr-2"></i> Folder Terbaru (5 Folder Terakhir Dibuat)
                    </h6>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover" id="recentFoldersTable" width="100%" cellspacing="0">
                            <thead>
                                <tr>
                                    <th>Nama Folder</th>
                                    <th>Klien</th>
                                    <th>Dibuat Sejak</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($recentFolders as $folder)
                                    <tr>
                                        <td>{{ $folder->name }}</td>
                                        <td>{{ $folder->client->name ?? 'N/A' }}</td>
                                        <td>{{ $folder->created_at?->diffForHumans() ?? 'N/A' }}</td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="3" class="text-center text-muted">Tidak ada data folder
                                            baru.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

    </div>

    <div class="row">
        <div class="col-xl-6 col-md-6 mb-4">
            <div class="card shadow border-0 h-100 py-3 bg-white">
                <div class="card-body">
                    <div class="row no-gutters align-items-center ">
                        <div class="col mr-2">
                            <div class="text-uppercase font-weight-bold text-secondary mb-1" style="font-size: 0.7rem;">
                                Total QR Code Yang Dibuat
                            </div>
                            <div class="h4 mb-0 font-weight-bolder text-gray-900">{{ $totalLinks }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="bi bi-link-45deg text-secondary" style="font-size: 2.5rem;"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
