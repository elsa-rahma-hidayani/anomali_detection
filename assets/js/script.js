document.addEventListener("DOMContentLoaded", function() {
    const uploadButton = document.getElementById("upload-button");
    const fileInput = document.getElementById("file-upload");
    const uploadInfo = document.getElementById("upload-info");
    const uploadForm = document.querySelector('form');
    const submitButton = document.querySelector('button[type="submit"]');

    // Handle the file upload button click
    uploadButton.addEventListener("click", function() {
        fileInput.click();
    });

    // Update file name after selection
    fileInput.addEventListener("change", function() {
        const fileName = fileInput.files[0].name;
        uploadInfo.textContent = `Selected file: ${fileName}`;

        // Enable the submit button if file is selected
        submitButton.disabled = false;
    });

    // Disable submit button initially
    submitButton.disabled = true;

    // Update button text when form is submitted
    uploadForm.addEventListener('submit', function(event) {
        if (fileInput.files.length > 0) {
            submitButton.innerText = 'Uploading...';
            submitButton.disabled = true;  // Prevent multiple submissions

            // Simulate file upload (since actual upload handling depends on backend)
            // You may replace this with actual file upload event handling (AJAX or form submission event)
            setTimeout(function() {
                submitButton.innerText = 'Upload Completed'; // Change button text after upload finishes
                submitButton.disabled = false;  // Re-enable the button if necessary
            }, 3000);  // Simulate a 3-second upload
        } else {
            // Prevent form submission if no file is selected
            event.preventDefault();
            alert('Please select a file before uploading.');
        }
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
