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

document.addEventListener("DOMContentLoaded", function () {
    var baseURL = getBaseUrl();

    var totalActiveEmployeeXhr = new XMLHttpRequest();

    totalActiveEmployeeXhr.open("GET", baseURL + '/super-admin/dashboard/total-active-employee', true);

    totalActiveEmployeeXhr.setRequestHeader("X-Requested-With", "XMLHttpRequest");

    totalActiveEmployeeXhr.onreadystatechange = function () {
        if (totalActiveEmployeeXhr.readyState === 4) {
            if (totalActiveEmployeeXhr.status === 200) {
                var response = JSON.parse(totalActiveEmployeeXhr.responseText);
                document.getElementById("totalActiveEmployee").textContent = numberFormat(response.total);
            } else {
                document.getElementById("totalActiveEmployee").textContent = "Gagal memuat";
            }
        }
    };

    totalActiveEmployeeXhr.send();
});