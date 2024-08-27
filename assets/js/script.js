document.addEventListener("DOMContentLoaded", function() {
    // Handle the file upload button click
    const uploadButton = document.getElementById("upload-button");
    const fileInput = document.getElementById("file-upload");
    const uploadInfo = document.getElementById("upload-info");

    uploadButton.addEventListener("click", function() {
        fileInput.click();
    });

    fileInput.addEventListener("change", function() {
        const fileName = fileInput.files[0].name;
        uploadInfo.textContent = `Selected file: ${fileName}`;
    });

    // Handle the learn more button to toggle attack information
    const learnMoreButton = document.getElementById("learn-more");
    const attackInfo = document.getElementById("attack-info");

    learnMoreButton.addEventListener("click", function() {
        if (attackInfo.style.display === "none" || attackInfo.style.display === "") {
            attackInfo.style.display = "block";
            learnMoreButton.textContent = "Hide Details";
        } else {
            attackInfo.style.display = "none";
            learnMoreButton.textContent = "Learn About Detected Attacks";
        }
    });

    // Ensure the footer stays at the bottom of the page
    function adjustFooter() {
        const footer = document.querySelector("footer");
        const bodyHeight = document.body.offsetHeight;
        const windowHeight = window.innerHeight;
        if (bodyHeight < windowHeight) {
            footer.classList.add("fixed-footer");
        } else {
            footer.classList.remove("fixed-footer");
        }
    }

    window.addEventListener("resize", adjustFooter);
    window.addEventListener("load", adjustFooter);
});

// Function to check if a file is selected
document.addEventListener("DOMContentLoaded", function() {
    const uploadForm = document.querySelector('form');
    const fileInput = document.getElementById('logfile');
    const uploadButton = document.querySelector('button[type="submit"]');

    // Disable the submit button initially
    uploadButton.disabled = true;

    // Enable submit button only when a file is selected
    fileInput.addEventListener('change', function() {
        if (fileInput.files.length > 0) {
            uploadButton.disabled = false;
        } else {
            uploadButton.disabled = true;
        }
    });

    // Check if form is submitted without file
    uploadForm.addEventListener('submit', function(event) {
        if (fileInput.files.length === 0) {
            event.preventDefault();
            alert('Please select a file before uploading.');
        }
    });
});

document.getElementById('logfile').addEventListener('change', function () {
    if (this.files && this.files[0]) {
        document.querySelector('button[type="submit"]').innerText = 'Uploading...';
    }
}); 
