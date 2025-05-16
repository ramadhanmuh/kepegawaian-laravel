function generateUUID() {
    var d = new Date().getTime(); // Waktu sekarang
    var d2 = (performance && performance.now && (performance.now() * 1000)) || 0; // Waktu presisi tinggi jika tersedia
  
    return 'xxxxxxxx-xxxx-4xxx-yxxx-xxxxxxxxxxxx'.replace(/[xy]/g, function(c) {
        var r = Math.random() * 16; // Angka random dari 0 sampai 15
    
        if (d > 0) {
            r = (d + r) % 16 | 0;
            d = Math.floor(d / 16);
        } else {
            r = (d2 + r) % 16 | 0;
            d2 = Math.floor(d2 / 16);
        }
  
      return (c === 'x' ? r : (r & 0x3 | 0x8)).toString(16);
    });
}

document.getElementById('id').value = generateUUID();

document.getElementById('submit_button').removeAttribute('disabled');

var baseURL = $('meta[name="base-url"]').attr('content');

$('#employee_id').select2({
    theme: 'bootstrap-5',
    placeholder: 'Pilih Pegawai',
    ajax: {
        url: baseURL + '/super-admin/terminations/employees',
        dataType: 'json',
        delay: 250,
        data: function (params) {
            return { q: params.term };
        },
        processResults: function (data) {
            // Format: number - full_name
            var results = $.map(data, function(item) {
                return {
                    id: item.id,
                    text: item.number + ' - ' + item.full_name
                };
            });

            return {
                results: results
            };
        },
        cache: false
    }
});