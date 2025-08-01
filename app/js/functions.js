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

let currentGalleryImages = [];
let currentDocketNumber = '';

function showGalleryImages(docketNumber) {
    currentDocketNumber = docketNumber;
    const xhr = new XMLHttpRequest();
    xhr.open("GET", `../backend/get.gallery.php?docket=${encodeURIComponent(docketNumber)}`, true);
    xhr.setRequestHeader('Accept', 'application/json');

    const modal = document.getElementById('gallery-modal');
    const galleryContainer = modal.querySelector('.gallery-images');
    const downloadBtn = document.getElementById('download-gallery-btn');
    const loadingIndicator = document.getElementById('pdf-loading-indicator');

    galleryContainer.innerHTML = '';
    downloadBtn.disabled = true;
    loadingIndicator.classList.add('hidden');
    currentGalleryImages = [];

    xhr.onreadystatechange = function () {
        if (xhr.readyState === 4) {
            if (xhr.status === 200) {
                try {
                    const images = JSON.parse(xhr.responseText);

                    if (Array.isArray(images) && images.length > 0) {
                        currentGalleryImages = images;
                        galleryContainer.innerHTML = images.map(base64 => `
                            <img src="data:image/jpeg;base64,${base64}" class="gallery-image" alt="Uploaded Image" />
                        `).join('');
                        downloadBtn.disabled = false;
                    } else {
                        galleryContainer.innerHTML = '<p class="text-gray-600">No images uploaded for this case yet.</p>';
                        downloadBtn.disabled = true;
                    }

                    modal.classList.add('active');
                    document.body.style.overflow = 'hidden';

                } catch (e) {
                    galleryContainer.innerHTML = '<p class="text-red-600">Error loading images: Invalid data received.</p>';
                    console.error("Invalid JSON from backend:", xhr.responseText, e);
                    downloadBtn.disabled = true;
                }
            } else {
                galleryContainer.innerHTML = `<p class="text-red-600">Failed to load images. Server responded with status: ${xhr.status}</p>`;
                console.error("Server error:", xhr.status, xhr.responseText);
                downloadBtn.disabled = true;
            }
        }
    };
    xhr.send();
}
async function initiateServerPdfDownload() {
    if (currentGalleryImages.length === 0) {
        console.warn("No images to download.");
        return;
    }

    const downloadBtn = document.getElementById('download-gallery-btn');
    const loadingIndicator = document.getElementById('pdf-loading-indicator');

    downloadBtn.disabled = true;
    loadingIndicator.classList.remove('hidden');

    try {
        const formData = new FormData();
        formData.append('docketNumber', currentDocketNumber);
        currentGalleryImages.forEach((base64, index) => {
            formData.append(`images[${index}]`, base64);
        });

        const response = await fetch('../backend/download.view.images.php', {
            method: 'POST',
            body: formData
        });

        if (response.ok) {
            const blob = await response.blob();
            const url = window.URL.createObjectURL(blob);
            const a = document.createElement('a');
            a.style.display = 'none';
            a.href = url;
            const contentDisposition = response.headers.get('Content-Disposition');
            let filename = `Gallery_${currentDocketNumber || 'unknown'}.pdf`;
            if (contentDisposition && contentDisposition.indexOf('attachment') !== -1) {
                const filenameMatch = contentDisposition.match(/filename="([^"]+)"/);
                if (filenameMatch && filenameMatch.length > 1) {
                    filename = filenameMatch[1];
                }
            }
            a.download = filename;
            document.body.appendChild(a);
            a.click();
            window.URL.revokeObjectURL(url);
        } else {
            const errorText = await response.text();
            console.error("Server responded with an error:", response.status, errorText);
            alert(`Failed to generate PDF: ${errorText || 'Server error'}`);
        }
    } catch (error) {
        console.error("Error initiating PDF download:", error);
        alert("An unexpected error occurred while trying to download the PDF.");
    } finally {
        downloadBtn.disabled = false;
        loadingIndicator.classList.add('hidden');
    }
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