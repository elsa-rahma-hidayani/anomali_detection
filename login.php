<?php
include 'koneksi.php'; // Menyertakan file koneksi

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Menghindari SQL Injection
    $email = $conn->real_escape_string($email);

    // Query untuk mendapatkan user berdasarkan email
    $sql = "SELECT * FROM login WHERE email = '$email'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();

        // Verifikasi password
        if (password_verify($password, $user['password'])) {
            // Password benar, redirect ke halaman index.php
            header("Location: index.php");
            exit();
        } else {
            echo "Password salah.";
        }
    } else {
        echo "Email tidak ditemukan.";
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Login Form</title>
    <link rel="stylesheet" type="text/css" href="assets/css/Login.css"> 
</head>
<body>
    <div class="container">
        <div class="logo">
            <img src="your_logo.png" alt="Company Logo"> 
        </div>
        <h2>Login to your account</h2>
        
            <div class="form-group">
                <label for="email">Email:</label>
                <input type="email" id="email" name="email" placeholder="Enter your email">
            </div>
            <div class="form-group">
                <label for="password">Password:</label>
                <input type="password" id="password" name="password" placeholder="Enter your password">
            </div>

            <a href="index.php">
                <button type="button">SIGN IN</button>
            </a>

                
            
            <div class="forgot">
            <a href="Reset.html">Forgot Password</a>
            </div>

            <div class="create">
            <a href="register.php">Create New Account</a>
            </div>
        </form>
    </div>
</body>
</html>