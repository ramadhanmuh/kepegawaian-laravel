function getBaseUrl() {
    var metas = document.getElementsByTagName('meta');

    for (var i = 0; i < metas.length; i++) {
        if (metas[i].getAttribute('name') === 'base-url') {
            return metas[i].getAttribute('content');
        }
    }

    return null; // jika tidak ditemukan
}

function numberFormat(number) {
    return number.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
}

function showTotalActiveEmployee(baseURL) {
    var xhr = new XMLHttpRequest();

    xhr.open("GET", baseURL + '/super-admin/dashboard/total-active-employee?_=' + + new Date().getTime(), true);

    xhr.setRequestHeader("X-Requested-With", "XMLHttpRequest");

    xhr.onreadystatechange = function () {
        if (xhr.readyState === 4) {
            if (xhr.status === 200) {
                var response = JSON.parse(xhr.responseText);
                document.getElementById("totalActiveEmployee").textContent = numberFormat(response.total);
            } else {
                document.getElementById("totalActiveEmployee").textContent = "Gagal memuat";
            }
        }
    };

    xhr.send();
}

function showTotalNonActiveEmployee(baseURL) {
    var xhr = new XMLHttpRequest();

    xhr.open("GET", baseURL + '/super-admin/dashboard/total-non-active-employee?_=' + + new Date().getTime(), true);

    xhr.setRequestHeader("X-Requested-With", "XMLHttpRequest");

    xhr.onreadystatechange = function () {
        if (xhr.readyState === 4) {
            if (xhr.status === 200) {
                var response = JSON.parse(xhr.responseText);
                document.getElementById("totalNonActiveEmployee").textContent = numberFormat(response.total);
            } else {
                document.getElementById("totalNonActiveEmployee").textContent = "Gagal memuat";
            }
        }
    };

    xhr.send();
}

function showTotalMaleEmployee(baseURL) {
    var xhr = new XMLHttpRequest();

    xhr.open("GET", baseURL + '/super-admin/dashboard/total-male-employee?_=' + + new Date().getTime(), true);

    xhr.setRequestHeader("X-Requested-With", "XMLHttpRequest");

    xhr.onreadystatechange = function () {
        if (xhr.readyState === 4) {
            if (xhr.status === 200) {
                var response = JSON.parse(xhr.responseText);
                document.getElementById("totalMaleEmployee").textContent = numberFormat(response.total);
            } else {
                document.getElementById("totalMaleEmployee").textContent = "Gagal memuat";
            }
        }
    };

    xhr.send();
}

function showTotalFemaleEmployee(baseURL) {
    var xhr = new XMLHttpRequest();

    xhr.open("GET", baseURL + '/super-admin/dashboard/total-female-employee?_=' + + new Date().getTime(), true);

    xhr.setRequestHeader("X-Requested-With", "XMLHttpRequest");

    xhr.onreadystatechange = function () {
        if (xhr.readyState === 4) {
            if (xhr.status === 200) {
                var response = JSON.parse(xhr.responseText);
                document.getElementById("totalFemaleEmployee").textContent = numberFormat(response.total);
            } else {
                document.getElementById("totalFemaleEmployee").textContent = "Gagal memuat";
            }
        }
    };

    xhr.send();
}

function showTotalEmployeeEducation(baseURL) {
    var xhr = new XMLHttpRequest();

    xhr.open("GET", baseURL + '/super-admin/dashboard/total-employee-education?_=' + + new Date().getTime(), true);

    xhr.setRequestHeader("X-Requested-With", "XMLHttpRequest");

    xhr.onreadystatechange = function () {
        if (xhr.readyState === 4) {
            if (xhr.status === 200) {
                var response = JSON.parse(xhr.responseText);

                // Mapping lowercase level to uppercase label
                var labelMap = {
                    'sd': 'SD',
                    'smp': 'SMP',
                    'sma': 'SMA',
                    's1': 'S1',
                    's2': 'S2',
                    's3': 'S3'
                };

                // Order tetap
                var levelOrder = ['sd', 'smp', 'sma', 's1', 's2', 's3'];

                var labels = [];
                var values = [];

                for (var i = 0; i < levelOrder.length; i++) {
                    var key = levelOrder[i];
                    labels.push(labelMap[key]);
                    values.push(response[key] || 0);
                }

                var ctx = document.getElementById('educationChart').getContext('2d');

                new Chart(ctx, {
                    type: 'bar',
                    data: {
                        labels: labels,
                        datasets: [{
                            label: 'Jumlah Pegawai',
                            data: values,
                            backgroundColor: 'rgba(54, 162, 235, 0.6)',
                            borderColor: 'rgba(54, 162, 235, 1)',
                            borderWidth: 1
                        }]
                    },
                    options: {
                        responsive: true,
                        plugins: {
                            legend: {
                                display: false
                            },
                            tooltip: {
                                callbacks: {
                                    label: function (context) {
                                        var value = context.parsed.y;
    
                                        return 'Jumlah : ' + numberFormat(value);
                                    }
                                }
                            }
                        },
                        scales: {
                            y: {
                                beginAtZero: true,
                                ticks: {
                                    precision: 0,
                                    callback: function(value) {
                                        return numberFormat(value);
                                    }
                                }
                            }
                        },
                    }
                });
            } else {
                document.getElementById("educationChartColumn").textContent = "Gagal memuat";
            }
        }
    };

    xhr.send();
}

function showTotalEmployeeAge(baseURL) {
    var xhr = new XMLHttpRequest();

    xhr.open("GET", baseURL + '/super-admin/dashboard/total-employee-age?_=' + + new Date().getTime(), true);

    xhr.setRequestHeader("X-Requested-With", "XMLHttpRequest");

    xhr.onreadystatechange = function () {
        if (xhr.readyState === 4) {
            if (xhr.status === 200) {
                var data = JSON.parse(xhr.responseText);

                var values = Object.values(data);

                var ctx = document.getElementById('employeeAgeChart').getContext('2d');
                new Chart(ctx, {
                    type: 'bar',
                    data: {
                        labels: [
                            '< 20', '20an', '30an', '40an',
                            '50an', '60 =>'
                        ],
                        datasets: [{
                            label: 'Jumlah Pegawai',
                            data: values,
                            backgroundColor: 'rgba(54, 162, 235, 0.6)',
                            borderColor: 'rgba(54, 162, 235, 1)',
                            borderWidth: 1
                        }]
                    },
                    options: {
                        responsive: true,
                        plugins: {
                            legend: { display: false },
                            tooltip: {
                                callbacks: {
                                    label: function (context) {
                                        var value = context.parsed.y;
    
                                        return 'Jumlah : ' + numberFormat(value);
                                    }
                                }
                            }
                        },
                        scales: {
                            y: {
                                beginAtZero: true,
                                precision: 0
                            }
                        }
                    }
                });
            } else {
                document.getElementById("employeeAgeChartColumn").textContent = "Gagal memuat";
            }
        }
    };

    xhr.send();
}

document.addEventListener("DOMContentLoaded", function () {
    var baseURL = getBaseUrl();

    showTotalActiveEmployee(baseURL);

    showTotalNonActiveEmployee(baseURL);

    showTotalMaleEmployee(baseURL);

    showTotalFemaleEmployee(baseURL);

    showTotalEmployeeEducation(baseURL);

    showTotalEmployeeAge(baseURL);
});