var baseURL = $('meta[name="base-url"]').attr('content');

$('#employee_id').select2({
    theme: 'bootstrap-5',
    placeholder: 'Pilih Pegawai',
    ajax: {
        url: baseURL + '/admin/terminations/employees',
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