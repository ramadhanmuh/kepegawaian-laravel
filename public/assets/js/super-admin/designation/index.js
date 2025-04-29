$(document).ready(function() {

    var baseURL = $('meta[name="base-url"]').attr('content');

    $('#datatable').DataTable({
        processing: true,
        serverSide: true,
        responsive: true,
        cache: false,
        ajax: {
            url: baseURL + '/super-admin/designations/list',
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
            { data: 'created_at', name: 'created_at' },
            { data: 'updated_at', name: 'updated_at' },
            {
                data: null,
                name: 'action',
                orderable: false,
                searchable: false,
                className: 'text-lg-center',
                render: function (data, type, row) {
                    var editButton = '<a href="' + baseURL + '/super-admin/designations/' + row.id + '/edit" class="btn btn-sm btn-warning"><i class="fas fa-edit"></i> <span class="d-none d-lg-inline">Ubah</span></a>';

                    var deleteButton = '<form class="d-inline" method="POST" action="' + baseURL + '/super-admin/designations/' + row.id + '"><input type="hidden" name="_token" value="' + $('meta[name="csrf-token"]').attr('content') + '" /><input type="hidden" name="_method" value="DELETE" /><button type="submit" class="btn btn-sm btn-danger"><i class="fas fa-trash"></i> <span class="d-none d-lg-inline">Hapus</span></button></form>';

                    return detailButton + ' ' + editButton + ' ' + deleteButton;
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

});