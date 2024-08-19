<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Anomaly Checker</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            display: flex;
            flex-direction: column;
            min-height: 100vh;
            background-color: #f4f4f4;
        }

        .navbar {
            background-color: #333;
            padding: 15px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .navbar h1 {
            color: #fff;
            margin: 0;
            font-size: 24px;
        }

        .navbar a {
            color: #fff;
            text-decoration: none;
            padding: 10px 20px;
            background-color: #007BFF;
            border-radius: 5px;
            font-weight: bold;
        }

        .container {
            flex-grow: 1;
            display: flex;
            justify-content: center;
            align-items: center;
            text-align: center;
        }

        .upload-box {
            background-color: #fff;
            padding: 40px;
            border-radius: 10px;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.1);
        }

        .upload-box h1 {
            margin-bottom: 30px;
            font-size: 28px;
            color: #333;
        }

        .upload-box input[type="file"] {
            display: none;
        }

        .upload-box label {
            font-size: 18px;
            padding: 20px 40px;
            background-color: #007BFF;
            color: #fff;
            border-radius: 5px;
            cursor: pointer;
            display: inline-block;
            margin-bottom: 20px;
        }

        .upload-box button {
            padding: 15px 30px;
            background-color: #28a745;
            color: #fff;
            border: none;
            border-radius: 5px;
            font-size: 18px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        .upload-box button:hover {
            background-color: #218838;
        }

        footer {
            text-align: center;
            padding: 15px;
            background-color: #333;
            color: #fff;
        }
    </style>
</head>
<body>
    <div class="navbar">
        <h1>Anomaly Checker</h1>
        <a href="login.php">Login</a>
    </div>

    <div class="container">
        <div class="upload-box">
            <h1>Upload access.log File</h1>
            <form action="process.php" method="POST" enctype="multipart/form-data">
                <label for="access_log">Choose a file</label>
                <input type="file" name="access_log" id="access_log" accept=".log" required>
                <br>
                <button type="submit">Upload and Check Anomalies</button>
            </form>
        </div>
    </div>

    <footer>
        &copy; 2024 Anomaly Checker. All rights reserved.
    </footer>
</body>
</html>
