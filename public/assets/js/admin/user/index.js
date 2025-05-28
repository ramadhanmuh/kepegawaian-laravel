$(document).ready(function() {

    var baseURL = $('meta[name="base-url"]').attr('content');

    var table = $('#datatable').DataTable({
        processing: true,
        serverSide: true,
        responsive: true,
        cache: false,
        ajax: {
            url: baseURL + '/admin/users/list',
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
                className: 'text-xl-center',
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
                className: 'text-xl-center',
                render: function (data, type, row) {
                    var userID = $('#datatable').attr('data-user-id');

                    var detailButton = '<a href="' + baseURL + '/admin/users/' + row.id + '" class="btn btn-sm btn-info"><i class="fas fa-folder-open"></i> <span class="d-none d-lg-inline">Detail</span></a>';                    

                    if (userID != row.id && row.role !== 'super_admin') {
                        var editButton = '<a href="' + baseURL + '/admin/users/' + row.id + '/edit" class="btn btn-sm btn-warning"><i class="fas fa-edit"></i> <span class="d-none d-lg-inline">Ubah</span></a>';
    
                        var deleteButton = '<form class="d-inline" method="POST" action="' + baseURL + '/admin/users/' + row.id + '"><input type="hidden" name="_token" value="' + $('meta[name="csrf-token"]').attr('content') + '" /><input type="hidden" name="_method" value="DELETE" /><button type="submit" class="btn btn-sm btn-danger"><i class="fas fa-trash"></i> <span class="d-none d-lg-inline">Hapus</span></button></form>';

                        return detailButton + ' ' + editButton + ' ' + deleteButton;
                    }
                    
                    return detailButton;
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