<?php
include 'koneksi.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'];

    // Generate token unik
    $reset_token = bin2hex(random_bytes(16));

    // Waktu sekarang
    $current_time = date('Y-m-d H:i:s');

    // Waktu kedaluwarsa token (1 jam dari sekarang)
    $expiry_time = date('Y-m-d H:i:s', strtotime('+1 hour'));

    // Simpan token dan waktu kedaluwarsa ke dalam database
    $stmt = $conn->prepare("UPDATE login SET reset_token = ?, reset_token_expiry = ? WHERE email = ?");
    $stmt->bind_param("sss", $reset_token, $expiry_time, $email);
    $stmt->execute();

    // Jalankan send-email.js dengan Node.js untuk mengirim email
    $command = 'node C:/xampp/htdocs/anomali_detection/assets/js/send-email.js ' . escapeshellarg($email) . ' ' . escapeshellarg($reset_token);
    exec($command, $output, $resultCode);

    if ($resultCode === 0) {
        echo json_encode([
            "field" => [
                ["id_member" => "139", "message" => "Email reset password telah dikirim."]
            ],
            "success" => 1
        ]);
    } else {
        echo json_encode([
            "field" => [
                ["id_member" => "139", "message" => "Maaf, terjadi kesalahan sistem. Permintaan Anda tidak dapat diproses."]
            ],
            "success" => 0
        ]);
    }
}
?>
