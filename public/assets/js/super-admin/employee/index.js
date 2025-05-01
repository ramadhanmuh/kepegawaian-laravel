$(document).ready(function() {

    var baseURL = $('meta[name="base-url"]').attr('content');

    var table = $('#datatable').DataTable({
        processing: true,
        serverSide: true,
        responsive: true,
        cache: false,
        ajax: {
            url: baseURL + '/super-admin/employees/list',
            data: function (d) {
                d.designation_id = $('#designation_id').val();
            },
        },
        columns: [
            {
                data: null,
                name: 'number',
                orderable: false,
                searchable: false,
                className: 'text-center align-middle',
                render: function (data, type, row, meta) {
                    return meta.row + meta.settings._iDisplayStart + 1;
                }
            },
            {
                data: 'photo',
                name: 'photo',
                orderable: false,
                searchable: false,
                className: 'text-center align-middle',
                render: function (data) {
                    return '<img src="'+ baseURL +'/' + data + '" width="80">';
                }
            },
            {
                data: 'full_name',
                name: 'full_name',
                className: 'align-middle',
            },
            {
                data: 'number',
                name: 'number',
                className: 'align-middle',
            },
            {
                data: 'designation',
                name: 'designation',
                className: 'align-middle',
            },
            {
                data: 'phone',
                name: 'phone',
                className: 'align-middle',
            },
            {
                data: null,
                name: 'action',
                orderable: false,
                searchable: false,
                className: 'text-xl-center align-middle',
                render: function (data, type, row) {
                    var dropdown = '<div class="dropdown"><button class="btn btn-secondary btn-sm dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">Pilih</button><ul class="dropdown-menu">';

                    var detailButton = '<li><a href="' + baseURL + '/super-admin/employees/' + row.id + '" class="dropdown-item"><i class="fas fa-folder-open"></i> <span>Detail</span></a></li>';

                    var editButton = '<li><a href="' + baseURL + '/super-admin/employees/' + row.id + '/edit" class="dropdown-item"><i class="fas fa-edit"></i> <span>Ubah</span></a></li>';

                    var deleteButton = '<li><form class="d-inline" method="POST" action="' + baseURL + '/super-admin/employees/' + row.id + '"><input type="hidden" name="_token" value="' + $('meta[name="csrf-token"]').attr('content') + '" /><input type="hidden" name="_method" value="DELETE" /><button type="submit" class="dropdown-item"><i class="fas fa-trash"></i> <span>Hapus</span></button></form></li>';

                    dropdown += detailButton + editButton + deleteButton;

                    dropdown += '</ul></div>';

                    console.log(dropdown);

                    return dropdown;
                }
            }
        ],
        order: [[2, 'asc']],
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
    $('#designation_id').change(function() {
        table.ajax.reload();
    });

});