@extends('layouts.super-admin')

@section('title', 'Pengguna')

@section('description', 'Halaman untuk melihat informasi daftar pengguna.')

@section('content')
    <h1 class="mt-4">Pengguna</h1>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item active">Pengguna</li>
    </ol>
    <div class="row">
        <div class="col-12 mb-3 text-end">
            <a href="{{ route('super-admin.users.create') }}" class="btn btn-primary btn-sm">
                <i class="fas fa-plus"></i>
                Tambah
            </a>
        </div>
        <div class="col-12">
            @session('success')
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ $value }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endsession
            @session('error')
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    {{ $value }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endsession
            <div class="card">
                <div class="card-body">
                    <div class="row mb-3">
                        <div class="col-md-3 col-lg-2">
                            <label for="role" class="form-label">Jenis</label>
                            <select name="role" id="role" class="form-select">
                                <option value="">Semua</option>
                                <option value="super_admin">Super Admin</option>
                                <option value="admin">Admin</option>
                            </select>
                        </div>
                    </div>
                    <table id="datatable" class="table table-bordered nowrap" style="width:100%">
                        <thead>
                            <tr>
                                <th class="text-center">No</th>
                                <th>Nama</th>
                                <th>Email</th>
                                <th>Telepon Genggam</th>
                                <th class="text-lg-center">Jenis</th>
                                <th class="text-lg-center">Aksi</th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('styles')
    <link href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css" rel="stylesheet">
    <link href="https://cdn.datatables.net/responsive/2.5.0/css/responsive.bootstrap5.min.css" rel="stylesheet">
@endpush

@push('scripts')
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/2.5.0/js/dataTables.responsive.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/2.5.0/js/responsive.bootstrap5.min.js"></script>

    <script>
        $(document).ready(function() {

            var baseURL = $('meta[name="base-url"]').attr('content');

            var table = $('#datatable').DataTable({
                processing: true,
                serverSide: true,
                responsive: true,
                cache: false,
                ajax: {
                    url: '{{ route('super-admin.users.list') }}',
                    data: function (d) {
                        d.role = $('#role').val();
                    },
                },
                columns: [
                    {
                        data: null,
                        name: 'number',
                        orderable: false,
                        searchable: false,
                        className: 'text-center',
                        render: function (data, type, row, meta) {
                            return meta.row + meta.settings._iDisplayStart + 1;
                        }
                    },
                    { data: 'name', name: 'name' },
                    { data: 'email', name: 'email' },
                    { data: 'phone', name: 'phone' },
                    {
                        data: 'role',
                        name: 'role',
                        className: 'text-lg-center',
                        render: function (data, type, row) {
                            switch (data) {
                                case 'super_admin':
                                    return 'Super Admin';
                                    break;

                                case 'admin':
                                    return 'Admin';
                                    break;
                            
                                default:
                                    return '-'
                                    break;
                            }
                        }
                    },
                    {
                        data: null,
                        name: 'action',
                        orderable: false,
                        searchable: false,
                        className: 'text-lg-center',
                        render: function (data, type, row) {
                            var detailButton = '<a href="' + baseURL + '/super-admin/users/' + row.id + '" class="btn btn-sm btn-info"><i class="fas fa-folder-open"></i> <span class="d-none d-lg-inline">Detail</span></a>';

                            var editButton = '<a href="' + baseURL + '/super-admin/users/' + row.id + '/edit" class="btn btn-sm btn-warning"><i class="fas fa-edit"></i> <span class="d-none d-lg-inline">Ubah</span></a>';

                            var deleteButton = '<form class="d-inline" method="POST" action="' + baseURL + '/super-admin/users/' + row.id + '">@csrf @method('DELETE') <button type="submit" class="btn btn-sm btn-danger"><i class="fas fa-trash"></i> <span class="d-none d-lg-inline">Hapus</span></button></form>';

                            return detailButton + ' ' + editButton + deleteButton;
                        }
                    }
                ],
                order: [[1, 'asc']],
                language: {
                    "processing": "Sedang memproses...",
                    "lengthMenu": "Tampilkan _MENU_ data",
                    "zeroRecords": "Tidak ditemukan data yang sesuai",
                    "info": "Menampilkan _START_ sampai _END_ dari _TOTAL_ data",
                    "infoEmpty": "Menampilkan 0 sampai 0 dari 0 data",
                    "infoFiltered": "(disaring dari _MAX_ data keseluruhan)",
                    "search": "Cari:",
                    "paginate": {
                        "first": "Pertama",
                        "last": "Terakhir",
                        "next": "Berikutnya",
                        "previous": "Sebelumnya"
                    },
                    "aria": {
                        "sortAscending": ": aktifkan untuk mengurutkan naik",
                        "sortDescending": ": aktifkan untuk mengurutkan turun"
                    }
                }
            });

            // ketika dropdown berubah, reload table
            $('#role').change(function() {
                table.ajax.reload();
            });

        });
    </script>
@endpush