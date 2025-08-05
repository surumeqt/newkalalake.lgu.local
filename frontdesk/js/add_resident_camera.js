document.addEventListener("DOMContentLoaded", () => {
    const startCameraBtn = document.getElementById("start-camera-btn");
    const takePhotoBtn = document.getElementById("take-photo-btn");
    const stopCameraBtn = document.getElementById("stop-camera-btn");
    const cameraFeed = document.getElementById("camera-feed");
    const photoCanvas = document.getElementById("photo-canvas");
    const photoBlobInput = document.getElementById("photo-blob");

    let stream;

    async function startCamera() {
        try {
            stream = await navigator.mediaDevices.getUserMedia({ video: true });
            cameraFeed.srcObject = stream;

            cameraFeed.style.display = "block";
            takePhotoBtn.style.display = "inline-block";
            stopCameraBtn.style.display = "inline-block";
            startCameraBtn.style.display = "none";
        } catch (error) {
            console.error("Error accessing camera:", error);
            alert(
                `Could not access the camera. Error: ${error.name} - ${error.message}`
            );
        }
    }

    function stopCamera() {
        if (stream) {
            stream.getTracks().forEach((track) => track.stop());
            cameraFeed.srcObject = null;
            cameraFeed.style.display = "none";
            takePhotoBtn.style.display = "none";
            stopCameraBtn.style.display = "none";
            startCameraBtn.style.display = "inline-block";
        }
    }

    function takePhoto() {
        const context = photoCanvas.getContext("2d");
        const videoWidth = cameraFeed.videoWidth;
        const videoHeight = cameraFeed.videoHeight;

        photoCanvas.width = videoWidth;
        photoCanvas.height = videoHeight;

        context.drawImage(cameraFeed, 0, 0, videoWidth, videoHeight);

        const photoDataUrl = photoCanvas.toDataURL("image/png");

        photoCanvas.toBlob((blob) => {
            const file = new File([blob], "resident_photo.png", {
                type: "image/png",
            });
            const dataTransfer = new DataTransfer();
            dataTransfer.items.add(file);
            document.getElementById("photo-upload").files = dataTransfer.files;

            console.log("Photo captured and ready for upload.");

            stopCamera();
        }, "image/png");
    }

    startCameraBtn.addEventListener("click", startCamera);
    takePhotoBtn.addEventListener("click", takePhoto);
    stopCameraBtn.addEventListener("click", stopCamera);
});
