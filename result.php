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
                    // Convert log to CSV
                    $convert_command = escapeshellcmd("python3 convert_logs.py " . escapeshellarg($upload_file));
                    shell_exec($convert_command);

                    // Analyze CSV
                    $check_command = escapeshellcmd("python3 check.py access.csv");
                    $output = shell_exec($check_command);

                    // Process and display results
                    $lines = explode("\n", trim($output));
                    $results = [];
                    foreach ($lines as $line) {
                        // Ensure there is a ':' in the line
                        if (strpos($line, ':') !== false) {
                            list($attack_type, $count) = explode(':', $line, 2);
                            $results[trim($attack_type)] = (int) trim($count);
                        }
                    }

                    echo "<p>Your uploaded file has been analyzed. Here are the results:</p>";
                    echo "<table>
                        <thead>
                            <tr>
                                <th>Attack Type</th>
                                <th>Count</th>
                            </tr>
                        </thead>
                        <tbody>";

                    $attack_types = [
                        'Path Traversal',
                        'SQL Injection',
                        'OGNL Injection',
                        'XSS',
                        'Remote File Inclusion (RFI)',
                        'Malicious Payload',
                        'HTTP Methods Abuse',
                        'Password-Based Attacks',
                        'Denial of Service (DoS)'
                    ];

                    foreach ($attack_types as $type) {
                        $count = isset($results[$type]) ? $results[$type] : 0;
                        echo "<tr>
                            <td>{$type}</td>
                            <td id='" . strtolower(str_replace(' ', '-', $type)) . "-count'>{$count}</td>
                        </tr>";
                    }

                    echo "</tbody></table>";

                    // Remove files after processing
                    unlink($upload_file);
                    unlink('access.csv');

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
