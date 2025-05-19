@extends('layouts.super-admin')

@section('title', 'Pemberhentian Kerja - Ubah')

@section('description', 'Halaman untuk menambahkan data Pemberhentian Kerja.')

@section('content')
    <h1 class="mt-4">Ubah Pemberhentian Kerja</h1>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item">
            <a href="{{ route('super-admin.terminations.index') }}" class="text-decoration-none">
                Pemberhentian Kerja
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
                    <form action="{{ route('super-admin.terminations.update', $item->id) }}" class="row" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="col-md-6 mb-3">
                            <label for="employee_id" class="form-label">Pegawai <small class="text-danger">*</small></label>
                            <select name="employee_id" id="employee_id" class="form-select w-100" required>
                                @if ($selectedEmployee !== null)
                                    <option value="{{ $selectedEmployee->id }}" selected>
                                        {{ $selectedEmployee->number }} - {{ $selectedEmployee->full_name }}
                                    </option>
                                @endif
                            </select>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="termination_type_id" class="form-label">Jenis <small class="text-danger">*</small></label>
                            <select name="termination_type_id" id="termination_type_id" class="form-select" required>
                                <option value="">-- Pilih --</option>
                                @forelse ($termination_types as $termination_type)
                                    <option value="{{ $termination_type->id }}"
                                        {{ old('termination_type_id') === null ? ($item->termination_type_id == $termination_type->id ? 'selected' : '') : (old('termination_type_id') == $termination_type->id ? 'selected' : '') }}    
                                    >
                                        {{ $termination_type->name }}
                                    </option>
                                @empty
                                    
                                @endforelse
                            </select>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="subject" class="form-label">Subyek <small class="text-danger">*</small></label>
                            <input type="text" class="form-control" id="subject" name="subject" value="{{ old('subject') === null ? $item->subject : old('subject') }}" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="notice_date" class="form-label">Tanggal Pemberitahuan <small class="text-danger">*</small></label>
                            <input type="date" class="form-control" id="notice_date" name="notice_date" value="{{ old('notice_date') === null ? $item->notice_date : old('notice_date') }}">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="termination_date" class="form-label">Tanggal Pemberhentian <small class="text-danger">*</small></label>
                            <input type="date" class="form-control" id="termination_date" name="termination_date" value="{{ old('termination_date') === null ? $item->termination_date : old('termination_date') }}">
                        </div>
                        <div class="col-12 mb-3">
                            <label for="description" class="form-label">Deskripsi <small class="text-danger">*</small></label>
                            <textarea name="description" id="description" rows="3" class="form-control" required>{{ old('description') === null ? $item->description : old('description') }}</textarea>
                        </div>
                        <div class="col-12">
                            <button type="submit" id="submit_button" class="btn btn-primary">Simpan</button>
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
    <script defer src="{{ url('assets/js/super-admin/termination/edit.js') }}"></script>
@endpush