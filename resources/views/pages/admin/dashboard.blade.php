@extends('layouts.admin')

@section('title', 'Dashboard')

@section('description', 'Halaman untuk melihat rangkuman data aplikasi.')

@section('content')
    <h1 class="mt-4">Dashboard</h1>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item active">Dashboard</li>
    </ol>
    <div class="row mb-3">
        <div class="col-md-6">
            <div class="card bg-white text-dark mb-4">
                <div class="card-header">
                    <h5 class="m-0">
                        Jumlah Pegawai Aktif
                    </h5>
                </div>
                <div class="card-body" id="totalActiveEmployee"></div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card bg-white text-dark mb-4">
                <div class="card-header">
                    <h5 class="m-0">
                        Jumlah Pegawai Non Aktif
                    </h5>
                </div>
                <div class="card-body" id="totalNonActiveEmployee"></div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card bg-white text-dark mb-4">
                <div class="card-header">
                    <h5 class="m-0">
                        Jumlah Pegawai Pria
                    </h5>
                </div>
                <div class="card-body" id="totalMaleEmployee"></div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card bg-white text-dark mb-4">
                <div class="card-header">
                    <h5 class="m-0">
                        Jumlah Pegawai Wanita
                    </h5>
                </div>
                <div class="card-body" id="totalFemaleEmployee"></div>
            </div>
        </div>
    </div>

    <div class="row mb-3">
        <div class="col-xl-6">
            <div class="card">
                <div class="card-header">
                    <h5 class="m-0">Usia Pegawai</h5>
                </div>
                <div class="card-body" id="employeeAgeChartColumn">
                    <canvas id="employeeAgeChart" class="w-100" height="200"></canvas>
                </div>
            </div>
        </div>
        <div class="col-xl-6">
            <div class="card">
                <div class="card-header">
                    <h5 class="m-0">
                        Pendidikan Pegawai
                    </h5>
                </div>
                <div class="card-body" id="educationChartColumn">
                    <canvas id="educationChart" class="w-100" height="200"></canvas>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script defer src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script defer src="{{ url('assets/js/admin/dashboard.js') }}"></script>
@endpush