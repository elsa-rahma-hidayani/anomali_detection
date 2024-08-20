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

