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
            <!-- Placeholder for result content -->
            <p>Your uploaded file has been analyzed. Here are the results:</p>
            <table>
                <thead>
                    <tr>
                        <th>Attack Type</th>
                        <th>Count</th>
                    </tr>
                </thead>
                <tbody>
                    <!-- The results will be inserted here dynamically -->
                    <tr>
                        <td>Path Traversal</td>
                        <td id="path-traversal-count">0</td>
                    </tr>
                    <tr>
                        <td>SQL Injection</td>
                        <td id="sql-injection-count">0</td>
                    </tr>
                    <tr>
                        <td>OGNL Injection</td>
                        <td id="ognl-injection-count">0</td>
                    </tr>
                    <tr>
                        <td>XSS</td>
                        <td id="xss-count">0</td>
                    </tr>
                    <tr>
                        <td>Remote File Inclusion (RFI)</td>
                        <td id="rfi-count">0</td>
                    </tr>
                    <tr>
                        <td>Malicious Payload</td>
                        <td id="malicious-payload-count">0</td>
                    </tr>
                    <tr>
                        <td>HTTP Methods Abuse</td>
                        <td id="http-methods-abuse-count">0</td>
                    </tr>
                    <tr>
                        <td>Password-Based Attacks</td>
                        <td id="password-attacks-count">0</td>
                    </tr>
                    <tr>
                        <td>Denial of Service (DoS)</td>
                        <td id="dos-count">0</td>
                    </tr>
                </tbody>
            </table>
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
