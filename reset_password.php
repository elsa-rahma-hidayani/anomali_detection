<form action="update_password.php" method="POST">
    <input type="hidden" name="token" value="<?php echo $_GET['token']; ?>">
    <label for="new_password">Password Baru:</label>
    <input type="password" id="new_password" name="new_password" required>
    <button type="submit">Ubah Password</button>
</form>
