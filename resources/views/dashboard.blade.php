@extends('layouts.main')

@section('content')
<div class="container-fluid">
    <!-- Statistik Cards -->
    <div class="row mb-4">
        <div class="col-md-3">
            <div class="card h-100 shadow-sm">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="card-title text-muted">Tamu Hari Ini</h6>
                            <h2 class="mb-0">{{ $tamuHariIni }}</h2>
                        </div>
                        <div class="position-relative">
                            <div class="bg-primary bg-opacity-10 rounded-circle d-flex align-items-center justify-content-center"
                                style="width: 60px; height: 60px;">
                                <i class="bi bi-people fs-2 text-primary"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card h-100 shadow-sm">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="card-title text-muted">Tamu Bulan Ini</h6>
                            <h2 class="mb-0">{{ $tamuBulanIni }}</h2>
                        </div>
                        <div class="position-relative">
                            <div class="bg-success bg-opacity-10 rounded-circle d-flex align-items-center justify-content-center"
                                style="width: 60px; height: 60px;">
                                <i class="bi bi-calendar-check fs-2 text-success"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card h-100 shadow-sm">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="card-title text-muted">Tamu Tahun Ini</h6>
                            <h2 class="mb-0">{{ $tamuTahunIni }}</h2>
                        </div>
                        <div class="position-relative">
                            <div class="bg-info bg-opacity-10 rounded-circle d-flex align-items-center justify-content-center"
                                style="width: 60px; height: 60px;">
                                <i class="bi bi-graph-up fs-2 text-info"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card h-100 shadow-sm">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="card-title text-muted">Total Tamu</h6>
                            <h2 class="mb-0">{{ $totalTamu }}</h2>
                        </div>
                        <div class="position-relative">
                            <div class="bg-warning bg-opacity-10 rounded-circle d-flex align-items-center justify-content-center"
                                style="width: 60px; height: 60px;">
                                <i class="bi bi-person-lines-fill fs-2 text-warning"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Detail Statistik -->
    <div class="row">
        <div class="col-md-8 mx-auto">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">Statistik Berdasarkan Kategori</h5>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <thead class="table-gray-dark">
                                <tr>
                                    <th>Kategori</th>
                                    <th class="text-end">Jumlah</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($statistikKategori as $stat)
                                <tr>
                                    <td>{{ ucfirst($stat->kategori) }}</td>
                                    <td class="text-end">{{ $stat->total }}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection