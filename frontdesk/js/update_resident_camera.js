document.addEventListener("DOMContentLoaded", () => {
    const startCameraBtn = document.getElementById("edit-start-camera-btn");
    const takePhotoBtn = document.getElementById("edit-take-photo-btn");
    const stopCameraBtn = document.getElementById("edit-stop-camera-btn");

    const cameraFeed = document.getElementById("edit-camera-feed");
    const photoCanvas = document.getElementById("edit-photo-canvas");
    const photoDisplay = document.getElementById("resident-photo-display");
    const photoUploadInput = document.getElementById("edit-photo-upload");
    const cameraContainer = document.querySelector(
        ".edit-camera-stuff-container"
    );

    let stream;

    async function startCamera() {
        try {
            console.log("Requesting camera...");
            stream = await navigator.mediaDevices.getUserMedia({ video: true });
            cameraFeed.srcObject = stream;

            console.log("Camera started", stream);
            cameraContainer.style.display = "block";
            cameraFeed.style.display = "block";
            photoDisplay.style.display = "none";
            startCameraBtn.style.display = "none";
            takePhotoBtn.style.display = "inline-block";
            stopCameraBtn.style.display = "inline-block";
        } catch (error) {
            console.error("Camera error:", error);
            alert("Camera access failed: " + error.message);
        }
    }

    function stopCamera() {
        if (stream) {
            stream.getTracks().forEach((track) => track.stop());
            stream = null;
        }

        cameraFeed.srcObject = null;
        cameraFeed.style.display = "none";
        cameraContainer.style.display = "none";
        photoDisplay.style.display = "block";
        takePhotoBtn.style.display = "none";
        stopCameraBtn.style.display = "none";
        startCameraBtn.style.display = "inline-block";
    }

    function takePhoto() {
        console.log("Taking photo...");
        const context = photoCanvas.getContext("2d");
        const videoWidth = cameraFeed.videoWidth;
        const videoHeight = cameraFeed.videoHeight;

        if (videoWidth === 0 || videoHeight === 0) {
            alert("Camera is not ready.");
            return;
        }

        photoCanvas.width = videoWidth;
        photoCanvas.height = videoHeight;
        context.drawImage(cameraFeed, 0, 0, videoWidth, videoHeight);

        photoCanvas.toBlob((blob) => {
            if (!blob) {
                console.error("Failed to capture blob.");
                return;
            }

            const file = new File([blob], "resident_photo.png", {
                type: "image/png",
            });

            const dataTransfer = new DataTransfer();
            dataTransfer.items.add(file);
            photoUploadInput.files = dataTransfer.files; // Optional preview

            const reader = new FileReader();
            reader.onload = function () {
                console.log("Photo preview loaded");
                photoDisplay.src = reader.result;
            };
            reader.readAsDataURL(file);

            stopCamera();
        }, "image/png");
    }

    startCameraBtn.addEventListener("click", startCamera);
    takePhotoBtn.addEventListener("click", takePhoto);
    stopCameraBtn.addEventListener("click", stopCamera);
});
