document.addEventListener("DOMContentLoaded", () => {
    const startCameraBtn = document.getElementById("start-camera-btn");
    const takePhotoBtn = document.getElementById("take-photo-btn");
    const stopCameraBtn = document.getElementById("stop-camera-btn");
    const cameraFeed = document.getElementById("camera-feed");
    const photoCanvas = document.getElementById("photo-canvas");
    const photoBlobInput = document.getElementById("photo-blob");

    let stream;

    // Function to start the camera and request permission
    async function startCamera() {
        try {
            // Request camera access from the user
            stream = await navigator.mediaDevices.getUserMedia({ video: true });
            cameraFeed.srcObject = stream;

            // Show the camera feed and 'Take Photo' button
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

    // Function to stop the camera stream
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

    // Function to take a photo from the camera feed
    function takePhoto() {
        const context = photoCanvas.getContext("2d");
        const videoWidth = cameraFeed.videoWidth;
        const videoHeight = cameraFeed.videoHeight;

        photoCanvas.width = videoWidth;
        photoCanvas.height = videoHeight;

        // Draw the current video frame onto the canvas
        context.drawImage(cameraFeed, 0, 0, videoWidth, videoHeight);

        // Convert the canvas content to a base64 string
        const photoDataUrl = photoCanvas.toDataURL("image/png");

        // Convert the Data URL to a Blob and store it in a hidden input
        // This makes it act like a file upload for the server
        photoCanvas.toBlob((blob) => {
            const file = new File([blob], "resident_photo.png", {
                type: "image/png",
            });
            // Create a DataTransfer object to simulate a file upload
            const dataTransfer = new DataTransfer();
            dataTransfer.items.add(file);
            document.getElementById("photo-upload").files = dataTransfer.files;

            // Log for verification
            console.log("Photo captured and ready for upload.");

            // Stop the camera after taking the photo
            stopCamera();
        }, "image/png");
    }

    // Event listeners for the buttons
    startCameraBtn.addEventListener("click", startCamera);
    takePhotoBtn.addEventListener("click", takePhoto);
    stopCameraBtn.addEventListener("click", stopCamera);
});
