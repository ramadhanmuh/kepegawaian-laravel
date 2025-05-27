@extends('layouts.admin')

@section('title', 'Pegawai - Ubah')

@section('description', 'Halaman untuk mengubah data pegawai.')

@section('content')
    <h1 class="mt-4">Ubah Pegawai</h1>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item">
            <a href="{{ route('admin.employees.index') }}" class="text-decoration-none">
                Pegawai
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
                    <form action="{{ route('admin.employees.update', $item->id) }}" class="row" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div class="col-md-6 mb-3">
                            <label for="full_name" class="form-label">Nama Lengkap <small class="text-danger">*</small></label>
                            <input type="text" class="form-control" id="full_name" name="full_name" value="{{ old('full_name') === null ? $item->full_name : old('full_name') }}" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="number" class="form-label">Nomor Pegawai <small class="text-danger">*</small></label>
                            <input type="text" class="form-control" id="number" name="number" value="{{ old('number') === null ? $item->number : old('number') }}" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="designation_id" class="form-label">Jabatan <small class="text-danger">*</small></label>
                            <select name="designation_id" id="designation_id" class="form-select">
                                <option value="">-- Pilih --</option>
                                @if (empty($designations))
                                    <option value="">Jabatan Tidak Ditemukan</option>
                                @else
                                    @foreach ($designations as $designation)
                                        <option value="{{ $designation->id }}" {{ old('designation_id') === null ? ($item->designation_id == $designation->id ? 'selected' : '') : (old('designation_id') == $designation->id ? 'selected' : '') }}>
                                            {{ $designation->name }}
                                        </option>
                                    @endforeach
                                @endif
                            </select>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="phone" class="form-label">Nomor Telepon Genggam <small class="text-danger">*</small></label>
                            <input type="text" class="form-control" id="phone" name="phone" value="{{ old('phone') === null ? $item->phone : old('phone') }}" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" class="form-control" id="email" name="email" value="{{ old('email') === null ? $item->email : old('email') }}">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="gender" class="form-label">Jenis Kelamin <small class="text-danger">*</small></label>
                            <select name="gender" id="gender" class="form-select" required>
                                <option value="">-- Pilih --</option>
                                <option value="pria" {{ old('gender') === null ? ($item->gender === 'pria' ? 'selected' : '') : (old('gender') === 'pria' ? 'selected' : '') }}>Pria</option>
                                <option value="wanita" {{ old('gender') === null ? ($item->gender === 'wanita' ? 'selected' : '') : (old('gender') === 'wanita' ? 'selected' : '') }}>Wanita</option>
                            </select>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="religion" class="form-label">Agama <small class="text-danger">*</small></label>
                            <select name="religion" id="religion" class="form-select" required>
                                <option value="">-- Pilih --</option>
                                <option value="islam" {{ old('religion') === null ? ($item->religion === 'islam' ? 'selected' : '') : (old('religion') === 'islam' ? 'selected' : '') }}>Islam</option>
                                <option value="kristen_protestan" {{ old('religion') === null ? ($item->religion === 'kristen_protestan' ? 'selected' : '') : (old('religion') === 'kristen_protestan' ? 'selected' : '') }}>Kristen Protestan</option>
                                <option value="kristen_katolik" {{ old('religion') === null ? ($item->religion === 'kristen_katolik' ? 'selected' : '') : (old('religion') === 'kristen_katolik' ? 'selected' : '') }}>Kristen Katolik</option>
                                <option value="hindu" {{ old('religion') === null ? ($item->religion === 'hindu' ? 'selected' : '') : (old('religion') === 'hindu' ? 'selected' : '') }}>Hindu</option>
                                <option value="buddha" {{ old('religion') === null ? ($item->religion === 'buddha' ? 'selected' : '') : (old('religion') === 'buddha' ? 'selected' : '') }}>Buddha</option>
                                <option value="konghucu" {{ old('religion') === null ? ($item->religion === 'konghucu' ? 'selected' : '') : (old('religion') === 'konghucu' ? 'selected' : '') }}>Konghucu</option>
                            </select>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="place_of_birth" class="form-label">Tempat Lahir <small class="text-danger">*</small></label>
                            <input type="text" class="form-control" id="place_of_birth" name="place_of_birth" value="{{ old('place_of_birth') === null ? $item->place_of_birth : old('place_of_birth') }}">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="date_of_birth" class="form-label">Tanggal Lahir <small class="text-danger">*</small></label>
                            <input type="date" class="form-control" id="date_of_birth" name="date_of_birth" value="{{ old('date_of_birth') === null ? $item->date_of_birth : old('date_of_birth') }}">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="date_of_joining" class="form-label">Tanggal Masuk Perusahaan <small class="text-danger">*</small></label>
                            <input type="date" class="form-control" id="date_of_joining" name="date_of_joining" value="{{ old('date_of_joining') === null ? $item->date_of_joining : old('date_of_joining') }}">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="marital_status" class="form-label">Status Pernikahan <small class="text-danger">*</small></label>
                            <select name="marital_status" id="marital_status" class="form-select" required>
                                <option value="">-- Pilih --</option>
                                <option value="belum_menikah" {{ old('marital_status') === null ? ($item->marital_status === 'belum_menikah' ? 'selected' : '') : (old('marital_status') === 'belum_menikah' ? 'selected' : '') }}>Belum Menikah</option>
                                <option value="sudah_menikah" {{ old('marital_status') === null ? ($item->marital_status === 'sudah_menikah' ? 'selected' : '') : (old('marital_status') === 'sudah_menikah' ? 'selected' : '') }}>Sudah Menikah</option>
                            </select>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="photo" class="form-label">Foto</label>
                            <input type="file" class="form-control" id="photo" name="photo">
                            <div class="form-text">Jika tidak diisi, maka akan menggunakan foto sebelumnya.</div>
                        </div>
                        <div class="col-12 mb-3">
                            <label for="address" class="form-label">Alamat Tempat Tinggal <small class="text-danger">*</small></label>
                            <textarea name="address" id="address" rows="3" class="form-control" required>{{ old('address') === null ? $item->address : old('address') }}</textarea>
                        </div>
                        <div class="col-12">
                            <button type="submit" class="btn btn-primary">Simpan</button>
                        </div>
                    </form>  
                </div>
            </div>
        </div>
    </div>
@endsection