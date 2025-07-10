document.addEventListener('click', function (event) {
    clickedViewButton = event.target.closest(".view-btn");
    if (clickedViewButton) {
        const docket = clickedViewButton.getAttribute("data-docket");
        showGalleryImages(docket);
    }
});
