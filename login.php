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
