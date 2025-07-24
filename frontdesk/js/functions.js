function liveSearch() {
    const docket = document.getElementById('search-input').value;
    const status = document.getElementById('hearing-status-filter').value;

    const xhr = new XMLHttpRequest();
    const formData = new FormData();
    formData.append('SearchByDcn', docket);
    formData.append('Hearing_status', status);

    xhr.onreadystatechange = function () {
        if (xhr.readyState === 4 && xhr.status === 200) {
            document.getElementById("records-body").innerHTML = xhr.responseText;
        }
    };

    xhr.open("POST", "../backend/filter.records.controller.php", true);
    xhr.send(formData);
}