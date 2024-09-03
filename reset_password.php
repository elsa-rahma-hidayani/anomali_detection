<?php
if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $token = $_GET['token'];

    // Cek token di database
    $stmt = $pdo->prepare("SELECT id FROM login WHERE reset_token = :token AND reset_token_expiration > NOW()");
    $stmt->bindParam(":token", $token);
    $stmt->execute();
    $user = $stmt->fetch();

    if (!$user) {
        echo "Token tidak valid atau sudah kadaluwarsa.";
        exit;
    }

    // Tampilkan form untuk memasukkan password baru
    echo '<form method="POST">
            <input type="hidden" name="token" value="' . htmlspecialchars($token) . '">
            <label for="password">Password Baru:</label>
            <input type="password" name="password" id="password" required>
            <button type="submit">Reset Password</button>
          </form>';
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $token = $_POST['token'];
    $password = $_POST['password'];

    // Cek token di database lagi sebelum memperbarui password
    $stmt = $pdo->prepare("SELECT id FROM login WHERE reset_token = :token AND reset_token_expiration > NOW()");
    $stmt->bindParam(":token", $token);
    $stmt->execute();
    $user = $stmt->fetch();

    if (!$user) {
        echo "Token tidak valid atau sudah kadaluwarsa.";
        exit;
    }

    // Hash password baru
    $hashedPassword = password_hash($password, PASSWORD_BCRYPT);

    // Perbarui password dan hapus token
    $stmt = $pdo->prepare("UPDATE login SET password = :password, reset_token = NULL, reset_token_expiration = NULL WHERE id = :id");
    $stmt->bindParam(":password", $hashedPassword);
    $stmt->bindParam(":id", $user['id']);
    $stmt->execute();

    echo "Password Anda berhasil direset. Silakan login dengan password baru.";
}
