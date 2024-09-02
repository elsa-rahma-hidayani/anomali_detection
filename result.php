<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Result - Anomaly Checker</title>
    <link rel="stylesheet" href="assets/css/index.css">
</head>
<body>
    <div class="navbar">
        <h1>Anomaly Checker</h1>
        <a href="index.php">Back to Upload</a>
    </div>

    <div class="container">
        <h2>Analysis Results</h2>
        <div class="results-box">
            <?php
            if (isset($_FILES['logfile']) && $_FILES['logfile']['error'] == UPLOAD_ERR_OK) {
                // File successfully uploaded
                $file_name = basename($_FILES['logfile']['name']);
                $upload_dir = 'uploads/';
                $upload_file = $upload_dir . $file_name;

                if (move_uploaded_file($_FILES['logfile']['tmp_name'], $upload_file)) {
                    // Analyze the uploaded log file with check.py
                    $check_command = escapeshellcmd("python3 check.py $upload_file");
                    shell_exec($check_command);

                    // Check if the result file was created
                    if (!file_exists('result.txt')) {
                        echo "<p>Error: result.txt file was not created. Please check the anomaly detection process.</p>";
                        exit;
                    }

                    // Read results from result.txt
                    $results = file_get_contents('result.txt');

                    echo "<p>Your uploaded file has been analyzed. Here are the results:</p>";
                    echo "<pre>{$results}</pre>";

                    // Remove files after processing
                    unlink($upload_file);
                    unlink('access.csv');
                    unlink('result.txt');

                } else {
                    echo "<p>Failed to move uploaded file.</p>";
                    echo "<p><a href='index.php'>Go Back</a></p>";
                }
            } else {
                // File upload failed
                echo "<p>Failed to upload file.</p>";
                echo "<p>Please make sure you select a valid access.log file.</p>";
                echo "<p><a href='index.php'>Try Again</a></p>";
            }
            ?>
            <p>
                <a href="index.php" class="upload-again-btn">Upload another file</a>
            </p>
        </div>
    </div>

    <footer>
        &copy; 2024 Anomaly Checker. All rights reserved.
    </footer>
    <script src="assets/js/script.js"></script>
</body>
</html>
