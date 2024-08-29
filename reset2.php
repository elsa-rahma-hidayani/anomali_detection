<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'];

    // Jalankan send-email.js dengan Node.js untuk mengirim email
    $command = 'node C:/xampp/htdocs/anomali_detection/send-email.js ' . escapeshellarg($email);
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
