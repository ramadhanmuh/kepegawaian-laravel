@extends('layouts.super-admin')

@section('title', 'Pendidikan Pegawai - Ubah')

@section('description', 'Halaman untuk mengubah data pendidikan pegawai.')

@section('content')
    <h1 class="mt-4">Ubah Pendidikan Pegawai</h1>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item">
            <a href="{{ route('super-admin.employee-education.index') }}" class="text-decoration-none">
                Pendidikan Pegawai
            </a>
        </li>
        <li class="breadcrumb-item active">Ubah</li>
    </ol>
    <div class="row mb-3">
        <div class="col-12">
            @session('success')
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ $value }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endsession
            @if ($errors->any())
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <ul class="m-0">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif
            <div class="card">
                <div class="card-body">
                    <form action="{{ route('super-admin.employee-education.store') }}" class="row" method="POST" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" name="id" id="id" required>
                        <div class="col-md-6 mb-3">
                            <label for="employee_id" class="form-label">Pegawai <small class="text-danger">*</small></label>
                            <select name="employee_id" id="employee_id" class="form-select w-100">
                                <option value="{{ $selectedEmployee->id }}" selected>
                                    {{ $selectedEmployee->number }} - {{ $selectedEmployee->full_name }}
                                </option>
                            </select>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="level" class="form-label">Jenjang <small class="text-danger">*</small></label>
                            <select name="level" id="level" class="form-select" required>
                                <option value="">-- Pilih --</option>
                                <option value="sd" {{ old('level') === null ? ($item->level === 'sd' ? 'selected' : '') : (old('level') === 'sd' ? 'selected' : '')  }}>SD</option>
                                <option value="smp" {{ old('level') === null ? ($item->level === 'smp' ? 'selected' : '') : (old('level') === 'smp' ? 'selected' : '')  }}>SMP</option>
                                <option value="sma" {{ old('level') === null ? ($item->level === 'sma' ? 'selected' : '') : (old('level') === 'sma' ? 'selected' : '')  }}>SMA</option>
                                <option value="s1" {{ old('level') === null ? ($item->level === 's1' ? 'selected' : '') : (old('level') === 's1' ? 'selected' : '')  }}>Sarjana (S1)</option>
                                <option value="s2" {{ old('level') === null ? ($item->level === 's2' ? 'selected' : '') : (old('level') === 's2' ? 'selected' : '')  }}>Magister (S2)</option>
                                <option value="s3" {{ old('level') === null ? ($item->level === 's3' ? 'selected' : '') : (old('level') === 's3' ? 'selected' : '')  }}>Doktor (S3)</option>
                            </select>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="school_name" class="form-label">Nama Sekolah/Kampus <small class="text-danger">*</small></label>
                            <input type="text" class="form-control" id="school_name" name="school_name" value="{{ old('school_name') === null ? $item->school_name : old('school_name') }}" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="major" class="form-label">Jurusan</label>
                            <input type="major" class="form-control" id="major" name="major" value="{{ old('major') === null ? $item->major : old('major') }}">
                        </div>
                        <div class="col-12 mb-3">
                            <label for="school_address" class="form-label">Alamat Sekolah/Kampus <small class="text-danger">*</small></label>
                            <textarea name="school_address" id="school_address" rows="3" class="form-control" required>{{ old('school_address') === null ? $item->school_address : old('school_address') }}</textarea>
                        </div>
                        <div class="col-12">
                            <button type="submit" id="submit_button" class="btn btn-primary" disabled>Simpan</button>
                        </div>
                    </form>  
                </div>
            </div>
        </div>
    </div>
@endsection

@push('styles')
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2-bootstrap-5-theme@1.3.0/dist/select2-bootstrap-5-theme.min.css" />
    <!-- Or for RTL support -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2-bootstrap-5-theme@1.3.0/dist/select2-bootstrap-5-theme.rtl.min.css" />
@endpush

@push('scripts')
    <script defer src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script defer src="{{ url('assets/js/super-admin/employee-education/edit.js') }}"></script>
@endpush