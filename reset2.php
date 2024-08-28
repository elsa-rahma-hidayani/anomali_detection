<?php 
// Array untuk respon JSON
$response = array();
$email = $_POST['email']; // Parameter cuma email saja

// Sertakan file koneksi ke database
require 'koneksi.php';

// Periksa apakah email ada di database
$sql = "SELECT * FROM `login` WHERE `email` = '$email'";
if($result = $conn->query($sql)){
    if($count = $result->num_rows){
        $response["field"] = array();
        
        while($row = $result->fetch_object()){
            $data = array();
            $data["id_member"] = $row->id_member;
            
            // Generate token unik untuk reset password
            $reset_token = bin2hex(random_bytes(32));
            
            // Simpan token ke database
            $conn->query("UPDATE `login` SET `reset_token` = '$reset_token', `reset_token_expiry` = DATE_ADD(NOW(), INTERVAL 1 HOUR) WHERE `id_member` = '$row->id_member'");
            
            // Buat link reset password dengan token
            $reset_link = "http://localhost/reset-password.php?token=".$reset_token;

            // Konten/isi email
            $mailContent = '
                <html>
                    <h4>Halo '.$row->full_name.',</h4>
                    <p>Kami menerima permintaan untuk mereset password Anda. Silakan klik link di bawah ini untuk mengatur ulang password Anda:</p>
                    <p><a href="'.$reset_link.'" target="_blank">Reset Password</a></p>
                    <p>Jika Anda tidak meminta reset password, abaikan email ini.</p>
                    <p>&copy; '.date("Y").' Layanan Aplikasi Blablabla</p>
                </html>
            ';

            // Encode konten HTML
            $encodedMailContent = escapeshellarg($mailContent);

            // Path ke send-email.js
            $scriptPath = 'C:\\xampp\\htdocs\\anomali_detection\\send-email.js';
            $command = 'node ' . escapeshellarg($scriptPath) . ' ' .
                       escapeshellarg($email) . ' ' .
                       escapeshellarg('Reset Password') . ' ' .
                       $encodedMailContent;

            // Jalankan skrip Node.js untuk mengirim email
            exec($command, $output, $return_var);
            
            // Log output dan status
            file_put_contents('php_command_output_log.txt', print_r($output, true));
            file_put_contents('php_command_return_var_log.txt', $return_var);

            if ($return_var === 0) {
                $data["message"] = "Email reset password telah dikirim. Silakan cek email Anda untuk instruksi lebih lanjut.";
            } else {
                $data["message"] = "Maaf, terjadi kesalahan sistem. Permintaan Anda tidak dapat diproses.";
                // Tambahkan logging detail untuk debugging
                file_put_contents('php_error_log.txt', print_r($output, true), FILE_APPEND);
            }
            
            array_push($response["field"], $data);
        }
        
        $response["success"] = 1;
        
        // Echoing JSON response
        echo json_encode($response);
    } else {
        // Email tidak ditemukan
        $response["success"] = 0;
        $response["message"] = "Maaf, email tidak terdaftar!";
        // Echo no users JSON
        echo json_encode($response);
    }
    
    $result->free();
} else {
    // Error pada query
    $response["success"] = 0;
    $response["message"] = "Maaf, terdapat error pada database";
    // Echo error JSON
    echo json_encode($response);
}
?>
