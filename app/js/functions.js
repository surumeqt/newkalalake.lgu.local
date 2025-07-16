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

function liveFillInputsByDocket(){
    const uploadDocket = document.getElementById('upload_doket_id').value;

    const xhr = new XMLHttpRequest();
    const formData = new FormData();
    formData.append('docket_lookup', uploadDocket);

    xhr.onreadystatechange = function () {
        if (xhr.readyState === 4 && xhr.status === 200) {
            const response = JSON.parse(xhr.responseText);
            if (response.success) {
                document.getElementById('upload_case_title').value = response.data.Case_Title;
                document.getElementById('upload_complainant_name').value = response.data.Complainant_Name;
                document.getElementById('upload_complainant_address').value = response.data.Complainant_Address;
                document.getElementById('upload_respondent_name').value = response.data.Respondent_Name;
                document.getElementById('upload_respondent_address').value = response.data.Respondent_Address;
                document.getElementById('upload_case_type').value = response.data.Case_Type;
                document.getElementById('hours').value = response.data.Hearing_Time;
                setSelectOption('iat', response.data.Time_Period);
                setSelectOption('upload_case_type', response.data.Case_Type);
                setSelectOption('upload_status_selection', response.data.Hearing_Status);
                setSelectOption('upload_hearing_type', response.data.Hearing_Type);
                if (response.data.Hearing_Date) {
                    const date = new Date(response.data.Hearing_Date);
                    const formatted = date.toISOString().split('T')[0];
                    document.getElementById('upload_hearing_date').value = formatted;
                }
            } else {
                console.error("Case not found:", response.message);
            }
        }
    };

    xhr.open("POST", "../backend/upload.controller.php", true);
    xhr.send(formData);
}

function setSelectOption(selectId, valueToSet) {
    const selectElement = document.getElementById(selectId);
    let optionExists = false;

    for (let i = 0; i < selectElement.options.length; i++) {
        if (selectElement.options[i].value === valueToSet) {
            optionExists = true;
            break;
        }
    }

    if (!optionExists) {
        const newOption = document.createElement("option");
        newOption.value = valueToSet;
        newOption.text = valueToSet;
        selectElement.appendChild(newOption);
    }

    selectElement.value = valueToSet;
}

function showGalleryImages(docketNumber) {
    const xhr = new XMLHttpRequest();
    xhr.open("GET", `../backend/get.gallery.php?docket=${encodeURIComponent(docketNumber)}`, true);
    xhr.setRequestHeader('Accept', 'application/json');

    xhr.onreadystatechange = function () {
        if (xhr.readyState === 4) {
            const modal = document.getElementById('gallery-modal');
            const galleryContainer = modal.querySelector('.gallery-images');

            if (xhr.status === 200) {
                try {
                    const images = JSON.parse(xhr.responseText);

                    if (Array.isArray(images) && images.length > 0) {
                        galleryContainer.innerHTML = images.map(base64 => `
                            <img src="data:image/jpeg;base64,${base64}" class="gallery-image" alt="Uploaded Image" />
                        `).join('');
                    } else {
                        galleryContainer.innerHTML = '<p class="text-gray-600">No images uploaded for this case yet.</p>';
                    }

                    modal.classList.add('active');
                    document.body.style.overflow = 'hidden';

                } catch (e) {
                    galleryContainer.innerHTML = '<p class="text-red-600">Error loading images: Invalid data received.</p>';
                    console.error("Invalid JSON from backend:", xhr.responseText, e);
                }
            } else {
                galleryContainer.innerHTML = `<p class="text-red-600">Failed to load images. Server responded with status: ${xhr.status}</p>`;
                console.error("Server error:", xhr.status, xhr.responseText);
            }
        }
    };

    xhr.send();
}

function closeGalleryModal() {
    const modal = document.getElementById('gallery-modal');
    if (modal) {
        modal.classList.remove('active');
        document.body.style.overflow = '';
        const galleryContainer = modal.querySelector('.gallery-images');
        if (galleryContainer) {
            galleryContainer.innerHTML = '';
        }
    }
}