function convertToWIB(input) {    
    // Buat objek Date dari string ISO
    var date = new Date(input);
  
    // Tambah offset UTC+7 dalam milidetik (7 * 60 * 60 * 1000)
    var wibDate = new Date(date.getTime() + (7 * 60 * 60 * 1000));
  
    // Ambil komponen tanggal dan waktu
    var year = wibDate.getUTCFullYear();
    var month = ('0' + (wibDate.getUTCMonth() + 1)).slice(-2);
    var day = ('0' + wibDate.getUTCDate()).slice(-2);
    var hours = ('0' + wibDate.getUTCHours()).slice(-2);
    var minutes = ('0' + wibDate.getUTCMinutes()).slice(-2);
    var seconds = ('0' + wibDate.getUTCSeconds()).slice(-2);
  
    // Format akhir: YYYY-MM-DD HH:MM:SS
    return year + '-' + month + '-' + day + ' ' + hours + ':' + minutes + ':' + seconds;
}

$(document).ready(function() {

    var baseURL = $('meta[name="base-url"]').attr('content');

    $('#datatable').DataTable({
        processing: true,
        serverSide: true,
        responsive: true,
        cache: false,
        ajax: {
            url: baseURL + '/super-admin/termination-types/list',
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
            { data: 'description', name: 'description' },
            {
                data: null,
                name: 'action',
                orderable: false,
                searchable: false,
                className: 'text-xl-center',
                render: function (data, type, row) {
                    var dropdown = '<div class="dropdown d-inline"><button class="btn btn-secondary btn-sm dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">Pilih</button><ul class="dropdown-menu">';

                    var detailButton = '<li><a href="' + baseURL + '/super-admin/termination-types/' + row.id + '" class="dropdown-item"><i class="fas fa-folder-open"></i> <span>Detail</span></a></li>';

                    var editButton = '<li><a href="' + baseURL + '/super-admin/termination-types/' + row.id + '/edit" class="dropdown-item"><i class="fas fa-edit"></i> <span>Ubah</span></a></li>';

                    var deleteButton = '<li><form class="d-inline" method="POST" action="' + baseURL + '/super-admin/termination-types/' + row.id + '"><input type="hidden" name="_token" value="' + $('meta[name="csrf-token"]').attr('content') + '" /><input type="hidden" name="_method" value="DELETE" /><button type="submit" class="dropdown-item"><i class="fas fa-trash"></i> <span>Hapus</span></button></form></li>';

                    dropdown += detailButton + editButton + deleteButton;

                    dropdown += '</ul></div>';

                    return dropdown;
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