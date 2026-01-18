@extends('dashboard.layouts.app')

@section('title', 'Dashboard')
@section('name_header', 'Overview Dashboard')

@section('content')
    <div class="page-content">

        <div class="row">
            <div class="col-6 col-lg-3 col-md-6">
                <div class="card shadow-sm border-0 mb-4">
                    <div class="card-body px-3 py-4-5">
                        <div class="row align-items-center">
                            <div class="col-md-4 col-4">
                                <div class="stats-icon purple">
                                    <i class="bi bi-cash-stack text-white"></i>
                                </div>
                            </div>
                            <div class="col-md-8 col-8">
                                <h6 class="text-muted font-semibold">Pendapatan Hari Ini</h6>
                                <h6 class="font-extrabold mb-0">Rp {{ number_format($todayRevenue, 0, ',', '.') }}</h6>
                                <small class="text-xs {{ $percentageTodayRevenue >= 0 ? 'text-success' : 'text-danger' }}">
                                    {{ $percentageTodayRevenue > 0 ? '+' : '' }}{{ number_format($percentageTodayRevenue, 1) }}%
                                </small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-6 col-lg-3 col-md-6">
                <div class="card shadow-sm border-0 mb-4">
                    <div class="card-body px-3 py-4-5">
                        <div class="row align-items-center">
                            <div class="col-md-4 col-4">
                                <div class="stats-icon blue">
                                    <i class="bi bi-calendar-check text-white"></i>
                                </div>
                            </div>
                            <div class="col-md-8 col-8">
                                <h6 class="text-muted font-semibold">Pendapatan Bulan Ini</h6>
                                <h6 class="font-extrabold mb-0">Rp {{ number_format($monthRevenue, 0, ',', '.') }}</h6>
                                <small class="text-xs {{ $percentageMonthRevenue >= 0 ? 'text-success' : 'text-danger' }}">
                                    {{ $percentageMonthRevenue > 0 ? '+' : '' }}{{ number_format($percentageMonthRevenue, 1) }}%
                                </small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-6 col-lg-3 col-md-6">
                <div class="card shadow-sm border-0 mb-4">
                    <div class="card-body px-3 py-4-5">
                        <div class="row align-items-center">
                            <div class="col-md-4 col-4">
                                <div class="stats-icon green">
                                    <i class="bi bi-receipt text-white"></i>
                                </div>
                            </div>
                            <div class="col-md-8 col-8">
                                <h6 class="text-muted font-semibold">Total Transaksi</h6>
                                <h6 class="font-extrabold mb-0">{{ $totalPurchases }}</h6>
                                <small class="text-xs {{ $percentageTransactions >= 0 ? 'text-success' : 'text-danger' }}">
                                    {{ $percentageTransactions > 0 ? '+' : '' }}{{ number_format($percentageTransactions, 1) }}%
                                </small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-6 col-lg-3 col-md-6">
                <div class="card shadow-sm border-0 mb-4">
                    <div class="card-body px-3 py-4-5">
                        <div class="row align-items-center">
                            <div class="col-md-4 col-4">
                                <div class="stats-icon red">
                                    <i class="bi bi-people-fill text-white"></i>
                                </div>
                            </div>
                            <div class="col-md-8 col-8">
                                <h6 class="text-muted font-semibold">Total Klien</h6>
                                <h6 class="font-extrabold mb-0">{{ $totalClients }}</h6>
                                <small class="text-xs {{ $percentageClients >= 0 ? 'text-success' : 'text-danger' }}">
                                    {{ $percentageClients > 0 ? '+' : '' }}{{ number_format($percentageClients, 1) }}%
                                </small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-12 col-lg-8">
                <div class="card border-0 shadow-sm">
                    <div class="card-header bg-transparent border-0 pb-0">
                        <h4 class="card-title fw-bold">Analitik Pendapatan</h4>
                        <p class="text-muted text-sm">Grafik pendapatan per bulan tahun ini</p>
                    </div>
                    <div class="card-body">
                        <div id="revenue-chart"></div>
                    </div>
                </div>
            </div>

            <div class="col-12 col-lg-4">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-header bg-transparent border-0 pb-0">
                        <h4 class="card-title fw-bold">Statistik Aset</h4>
                    </div>
                    <div class="card-body d-flex flex-column justify-content-center align-items-center">
                        <div id="assets-chart"></div>
                        <div class="mt-4 text-center">
                            <h5 class="mb-0 fw-bold">{{ $totalPhotos }}</h5>
                            <small class="text-muted">Total Foto Tersimpan</small>
                        </div>
                        <div class="row mt-4 w-100 text-center">
                            <div class="col-6">
                                <h6 class="mb-0 fw-bold">{{ $totalFolders }}</h6>
                                <small class="text-muted text-xs">Event</small>
                            </div>
                            <div class="col-6">
                                <h6 class="mb-0 fw-bold">{{ $newClients }}</h6>
                                <small class="text-muted text-xs">New Clients</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
@endsection

@push('styles')
    <style>
        .stats-icon {
            width: 48px;
            height: 48px;
            border-radius: 0.5rem;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
        }

        .stats-icon i {
            font-size: 1.5rem;
            display: flex;
            align-items: center;
            justify-content: center;
            line-height: 1;
        }

        .stats-icon.purple {
            background-color: #9694ff;
        }

        .stats-icon.blue {
            background-color: #57caeb;
        }

        .stats-icon.green {
            background-color: #5ddab4;
        }

        .stats-icon.red {
            background-color: #ff7976;
        }

        .font-semibold {
            font-weight: 600;
        }

        .font-extrabold {
            font-weight: 800;
        }

        .text-xs {
            font-size: 0.8rem;
        }
    </style>
@endpush

@push('scripts')
    <script>
        var revenueOptions = {
            series: [{
                name: 'Pendapatan (Rp)',
                data: @json($chartRevenueData)
            }],
            chart: {
                height: 350,
                type: 'area',
                toolbar: {
                    show: false
                },
                fontFamily: 'Nunito, sans-serif'
            },
            dataLabels: {
                enabled: false
            },
            stroke: {
                curve: 'smooth',
                width: 2
            },
            xaxis: {
                categories: ["Jan", "Feb", "Mar", "Apr", "Mei", "Jun", "Jul", "Agu", "Sep", "Okt", "Nov", "Des"],
            },
            yaxis: {
                labels: {
                    formatter: function(value) {
                        return "Rp " + new Intl.NumberFormat('id-ID').format(value);
                    }
                }
            },
            colors: ['#435ebf'],
            fill: {
                type: "gradient",
                gradient: {
                    shadeIntensity: 1,
                    opacityFrom: 0.7,
                    opacityTo: 0.9,
                    stops: [0, 90, 100]
                }
            },
            tooltip: {
                y: {
                    formatter: function(val) {
                        return "Rp " + new Intl.NumberFormat('id-ID').format(val)
                    }
                }
            }
        };

        var revenueChart = new ApexCharts(document.querySelector("#revenue-chart"), revenueOptions);
        revenueChart.render();

        var assetsOptions = {
            series: [{{ $totalPhotos }}, {{ $totalFolders }}],
            chart: {
                type: 'donut',
                width: '100%',
                height: 300,
                fontFamily: 'Nunito, sans-serif'
            },
            labels: ['Photos', 'Event'],
            colors: ['#5ddab4', '#9694ff'],
            legend: {
                position: 'bottom'
            },
            plotOptions: {
                pie: {
                    donut: {
                        size: '70%',
                        labels: {
                            show: true,
                            total: {
                                show: true,
                                label: 'Total Assets',
                                formatter: function(w) {
                                    return w.globals.seriesTotals.reduce((a, b) => {
                                        return a + b
                                    }, 0)
                                }
                            }
                        }
                    }
                }
            }
        };

        var assetsChart = new ApexCharts(document.querySelector("#assets-chart"), assetsOptions);
        assetsChart.render();
    </script>
@endpush
