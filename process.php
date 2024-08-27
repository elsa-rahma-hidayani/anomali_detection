<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

echo '<pre>';
print_r($_FILES);
echo '</pre>';

// Check if the form was submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Check if the file was uploaded
    if (isset($_FILES['logfile'])) {
        // Get the uploaded file error code
        $fileError = $_FILES['logfile']['error'];

        // Check if the file was uploaded successfully
        if ($fileError === UPLOAD_ERR_OK) {
            // Get the uploaded file
            $uploadedFile = $_FILES['logfile']['tmp_name'];

            // Define the path to the temporary access.log
            $tempLogFilePath = 'uploads/access.log';

            // Move the uploaded file to the designated directory
            if (move_uploaded_file($uploadedFile, $tempLogFilePath)) {
                // Define the command to run the check.py script
                $command = escapeshellcmd('python3 check.py');

                // Execute the command
                $output = shell_exec($command);

                // Check if the script ran successfully
                if ($output !== null) {
                    // Provide the user with the results
                    echo '<h2>Anomaly Detection Results</h2>';
                    echo '<pre>' . $output . '</pre>';
                    echo '<a href="results/attack_detection_results.csv" download="attack_detection_results.csv">Download Results CSV</a>';
                } else {
                    echo 'Error: Unable to process the log file.';
                }

                // Optionally, delete the uploaded file to free up space
                unlink($tempLogFilePath);
            } else {
                echo 'Error: Failed to move the uploaded file.';
            }
        } else {
            // Handle file upload errors
            switch ($fileError) {
                case UPLOAD_ERR_INI_SIZE:
                    echo 'Error: The uploaded file exceeds the upload_max_filesize directive in php.ini.';
                    break;
                case UPLOAD_ERR_FORM_SIZE:
                    echo 'Error: The uploaded file exceeds the MAX_FILE_SIZE directive specified in the HTML form.';
                    break;
                case UPLOAD_ERR_PARTIAL:
                    echo 'Error: The uploaded file was only partially uploaded.';
                    break;
                case UPLOAD_ERR_NO_FILE:
                    echo 'Error: No file was uploaded.';
                    break;
                case UPLOAD_ERR_NO_TMP_DIR:
                    echo 'Error: Missing temporary folder.';
                    break;
                case UPLOAD_ERR_CANT_WRITE:
                    echo 'Error: Failed to write file to disk.';
                    break;
                case UPLOAD_ERR_EXTENSION:
                    echo 'Error: File upload stopped by extension.';
                    break;
                default:
                    echo 'Error: Unknown file upload error.';
                    break;
            }
        }
    } else {
        echo 'Error: No file uploaded.';
    }
} else {
    echo 'Error: Form not submitted.';
}
?>
