<?php
include 'koneksi.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'];

    // Generate unique token
    $token = bin2hex(random_bytes(32)); // Generate a 64-character token
    $expiry = date('Y-m-d H:i:s', strtotime('+1 hour')); // Token valid for 1 hour

    // Store the token and expiry time in the database
    $stmt = $conn->prepare("UPDATE login SET reset_token = ?, reset_token_expiry = ? WHERE email = ?");
    $stmt->bind_param("sss", $token, $expiry, $email);
    if ($stmt->execute()) {
        // Jalankan send-email.js dengan Node.js untuk mengirim email dengan token unik
        $command = 'node C:/xampp/htdocs/anomali_detection/assets/js/send-email.js ' . escapeshellarg($email) . ' ' . escapeshellarg($token);
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
