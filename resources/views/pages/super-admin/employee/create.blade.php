@extends('layouts.super-admin')

@section('title', 'Pegawai - Tambah')

@section('description', 'Halaman untuk menambahkan data pegawai.')

@section('content')
    <h1 class="mt-4">Tambah Pegawai</h1>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item">
            <a href="{{ route('super-admin.employees.index') }}" class="text-decoration-none">
                Pegawai
            </a>
        </li>
        <li class="breadcrumb-item active">Tambah</li>
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
                    <form action="{{ route('super-admin.employees.store') }}" class="row" method="POST" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" name="id" id="id" required>
                        <div class="col-md-6 mb-3">
                            <label for="full_name" class="form-label">Nama Lengkap <small class="text-danger">*</small></label>
                            <input type="text" class="form-control" id="full_name" name="full_name" value="{{ old('full_name') }}" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="number" class="form-label">Nomor Pegawai <small class="text-danger">*</small></label>
                            <input type="text" class="form-control" id="number" name="number" value="{{ old('number') }}" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="designation_id" class="form-label">Jabatan <small class="text-danger">*</small></label>
                            <select name="designation_id" id="designation_id" class="form-select">
                                <option value="">-- Pilih --</option>
                                @if (empty($designations))
                                    <option value="">Jabatan Tidak Ditemukan</option>
                                @else
                                    @foreach ($designations as $item)
                                        <option value="{{ $item->id }}" {{ old('designation_id') == $item->id ? 'selected' : '' }}>
                                            {{ $item->name }}
                                        </option>
                                    @endforeach
                                @endif
                            </select>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="phone" class="form-label">Nomor Telepon Genggam <small class="text-danger">*</small></label>
                            <input type="text" class="form-control" id="phone" name="phone" value="{{ old('phone') }}" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" class="form-control" id="email" name="email" value="{{ old('email') }}">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="gender" class="form-label">Jenis Kelamin <small class="text-danger">*</small></label>
                            <select name="gender" id="gender" class="form-select" required>
                                <option value="">-- Pilih --</option>
                                <option value="pria" {{ old('gender') === 'pria' ? 'selected' : '' }}>Pria</option>
                                <option value="wanita" {{ old('gender') === 'wanita' ? 'selected' : '' }}>Wanita</option>
                            </select>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="religion" class="form-label">Agama <small class="text-danger">*</small></label>
                            <select name="religion" id="religion" class="form-select" required>
                                <option value="">-- Pilih --</option>
                                <option value="islam" {{ old('religion') === 'islam' ? 'selected' : '' }}>Islam</option>
                                <option value="kristen_protestan" {{ old('religion') === 'kristen_protestan' ? 'selected' : '' }}>Kristen Protestan</option>
                                <option value="kristen_katolik" {{ old('religion') === 'kristen_katolik' ? 'selected' : '' }}>Kristen Katolik</option>
                                <option value="hindu" {{ old('religion') === 'hindu' ? 'selected' : '' }}>Hindu</option>
                                <option value="buddha" {{ old('religion') === 'buddha' ? 'selected' : '' }}>Buddha</option>
                                <option value="konghucu" {{ old('religion') === 'konghucu' ? 'selected' : '' }}>Konghucu</option>
                            </select>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="place_of_birth" class="form-label">Tempat Lahir <small class="text-danger">*</small></label>
                            <input type="text" class="form-control" id="place_of_birth" name="place_of_birth" value="{{ old('place_of_birth') }}">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="date_of_birth" class="form-label">Tanggal Lahir <small class="text-danger">*</small></label>
                            <input type="date" class="form-control" id="date_of_birth" name="date_of_birth" value="{{ old('date_of_birth') }}">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="date_of_joining" class="form-label">Tanggal Masuk Perusahaan <small class="text-danger">*</small></label>
                            <input type="date" class="form-control" id="date_of_joining" name="date_of_joining" value="{{ old('date_of_joining') }}">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="marital_status" class="form-label">Status Pernikahan <small class="text-danger">*</small></label>
                            <select name="marital_status" id="marital_status" class="form-select" required>
                                <option value="">-- Pilih --</option>
                                <option value="belum_menikah" {{ old('marital_status') === 'belum_menikah' ? 'selected' : '' }}>Belum Menikah</option>
                                <option value="sudah_menikah" {{ old('marital_status') === 'sudah_menikah' ? 'selected' : '' }}>Sudah Menikah</option>
                            </select>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="photo" class="form-label">Foto <small class="text-danger">*</small></label>
                            <input type="file" class="form-control" id="photo" name="photo" required>
                        </div>
                        <div class="col-12 mb-3">
                            <label for="address" class="form-label">Alamat Tempat Tinggal <small class="text-danger">*</small></label>
                            <textarea name="address" id="address" rows="3" class="form-control" required>{{ old('address') }}</textarea>
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

@push('scripts')
    <script defer src="{{ url('assets/js/super-admin/employee/create.js') }}"></script>
@endpush