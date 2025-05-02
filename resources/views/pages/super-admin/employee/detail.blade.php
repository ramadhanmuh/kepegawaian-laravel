@extends('layouts.super-admin')

@section('title', 'Pegawai - Detail')

@section('description', 'Halaman untuk melihat informasi detail pengguna.')

@section('content')
    <h1 class="mt-4">Detail Pegawai</h1>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item">
            <a href="{{ route('super-admin.employees.index') }}" class="text-decoration-none">
                Pegawai
            </a>
        </li>
        <li class="breadcrumb-item active">Detail</li>
    </ol>
    <div class="row mb-3">
        <div class="col-12 mb-3 text-end">
            <a href="{{ route('super-admin.employees.edit', $item->id) }}" class="btn btn-warning btn-sm">
                <i class="fas fa-edit"></i>
                Ubah
            </a>
        </div>
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md order-1 order-md-0">
                            <div class="row">
                                <div class="col-12 mb-3">
                                    <h5>{{ $item->full_name }}</h5>
                                </div>
                                <div class="col-12 mb-3">
                                    <b>Nomor Telepon Genggam :</b>
                                    <p class="m-0">{{ $item->phone }}</p>
                                </div>
                                <div class="col-12 mb-3">
                                    <b>Email :</b>
                                    <p class="m-0">{{ $item->email }}</p>
                                </div>
                                <div class="col-12">
                                    <b>Alamat :</b>
                                    <p class="m-0">{{ $item->address }}</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-auto order-0 order-md-0 mb-3 mb-md-0">
                            <img src="{{ url($item->photo) }}" alt="Foto Pegawai" width="124">
                        </div>
                    </div>

                    <hr>

                    <div class="row mb-3">
                        <div class="col-md-4 col-xl-3">
                            Tanggal Masuk Perusahaan
                            <span class="d-md-none">:</span>
                        </div>
                        <div class="col-auto d-none d-md-block">
                            :
                        </div>
                        <div class="col">
                            {{ $item->date_of_joining }}
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-4 col-xl-3">
                            Tempat Lahir
                            <span class="d-md-none">:</span>
                        </div>
                        <div class="col-auto d-none d-md-block">
                            :
                        </div>
                        <div class="col">
                            {{ $item->place_of_birth }}
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-4 col-xl-3">
                            Tanggal Lahir
                            <span class="d-md-none">:</span>
                        </div>
                        <div class="col-auto d-none d-md-block">
                            :
                        </div>
                        <div class="col">
                            {{ $item->date_of_birth }}
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-4 col-xl-3">
                            Jenis Kelamin
                            <span class="d-md-none">:</span>
                        </div>
                        <div class="col-auto d-none d-md-block">
                            :
                        </div>
                        <div class="col">
                            @if ($item->gender === 'pria')
                                Pria
                            @elseif ($item->gender === 'wanita')
                                Wanita
                            @else
                                ''
                            @endif
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-4 col-xl-3">
                            Agama
                            <span class="d-md-none">:</span>
                        </div>
                        <div class="col-auto d-none d-md-block">
                            :
                        </div>
                        <div class="col">
                            @switch($item->religion)
                                @case('islam')
                                    Islam
                                    @break
                                @case('kristen_protestan')
                                    Kristen Protestan
                                    @break
                                @case('kristen_katolik')
                                    Kristen Katolik
                                    @break
                                @case('hindu')
                                    Hindu
                                    @break
                                @case('buddha')
                                    Buddha
                                    @break
                                @case('konghucu')
                                    Konghucu
                                    @break
                                @default
                                    -
                            @endswitch
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-4 col-xl-3">
                            Status Pernikahan
                            <span class="d-md-none">:</span>
                        </div>
                        <div class="col-auto d-none d-md-block">
                            :
                        </div>
                        <div class="col">
                            @switch($item->marital_status)
                                @case('belum_menikah')
                                    Belum Menikah
                                    @break
                                @case('sudah_menikah')
                                    Sudah Menikah
                                    @break
                                @default
                                    -
                            @endswitch
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-4 col-xl-3">
                            Tanggal Dibuat
                            <span class="d-md-none">:</span>
                        </div>
                        <div class="col-auto d-none d-md-block">
                            :
                        </div>
                        <div class="col">
                            {{ $item->created_at }}
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-4 col-xl-3">
                            Tanggal Diubah
                            <span class="d-md-none">:</span>
                        </div>
                        <div class="col-auto d-none d-md-block">
                            :
                        </div>
                        <div class="col">
                            {{ $item->created_at === $item->updated_at ? '-' : $item->updated_at }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection