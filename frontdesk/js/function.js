function reflectAge(){
    const birthday = document.getElementById('birthday').value;
    if (birthday) {
        const birthDate = new Date(birthday);
        const today = new Date();
        let age = today.getFullYear() - birthDate.getFullYear();
        const monthDiff = today.getMonth() - birthDate.getMonth();
        if (monthDiff < 0 || (monthDiff === 0 && today.getDate() < birthDate.getDate())) {
            age--;
        }
        document.getElementById('age').value = age;
    } else {
        document.getElementById('age').value = '';
    }
}
function liveSearch() {
    const docket = document.getElementById('residentSearchInput').value;

    const xhr = new XMLHttpRequest();
    const formData = new FormData();
    formData.append('residentSearchInput', docket);

    xhr.onreadystatechange = function () {
        if (xhr.readyState === 4 && xhr.status === 200) {
            document.getElementById("residents-body").innerHTML = xhr.responseText;
        }
    };

    xhr.open("POST", "../backend/fd_controllers/residents.controller.php", true);
    xhr.send(formData);
}