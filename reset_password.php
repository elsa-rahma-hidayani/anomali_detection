<?php
include 'koneksi.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $token = $_POST['token'];
    $password = $_POST['password'];
    $confirmPassword = $_POST['confirm-password'];

    // Validasi password dan konfirmasi password
    if ($password !== $confirmPassword) {
        echo "Password tidak cocok";
        exit;
    }

    // Cek token dan waktu kedaluwarsa
    $stmt = $conn->prepare("SELECT id_member FROM login WHERE reset_token = ? AND reset_token_expiry > NOW()");
    $stmt->bind_param("s", $token);
    $stmt->execute();
    $result = $stmt->get_result();
    $user = $result->fetch_assoc();

    if ($user) {
        // Token valid, proses reset password
        $hashedPassword = password_hash($password, PASSWORD_BCRYPT);

        // Update password dan hapus token dari database
        $stmt = $conn->prepare("UPDATE login SET password = ?, reset_token = NULL, reset_token_expiry = NULL WHERE id_member = ?");
        $stmt->bind_param("si", $hashedPassword, $user['id_member']);
        $stmt->execute();

        echo "Password berhasil direset.";
    } else {
        // Token tidak valid atau sudah kedaluwarsa
        echo "Token tidak valid atau sudah kedaluwarsa.";
    }
}
?>
