if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'];
    // Cek apakah email ada di database
    // Jika ada, buat token unik
    $token = bin2hex(random_bytes(50)); 
    // Simpan token ke database dengan email dan timestamp
    
    // Kirim email ke pengguna
    $resetLink = "https://example.com/reset_password.php?token=" . $token;
    $subject = "Reset Password";
    $message = "Klik link ini untuk mereset password Anda: " . $resetLink;
    mail($email, $subject, $message);
    
    echo "Link reset password telah dikirim ke email Anda.";
}
