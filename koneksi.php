<?php
include 'koneksi.php';

$sql = "SELECT id, nama, email FROM anomali_detection";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Pengguna</title>
</head>
<body>
    <h1>Data Pengguna</h1>
    <table border="1">
        <tr>
            <th>ID</th>
            <th>Nama</th>
            <th>Email</th>
        </tr>
        <?php
        if ($result->num_rows > 0) {
            // Output data setiap baris
            while($row = $result->fetch_assoc()) {
                echo "<tr><td>" . $row["id"]. "</td><td>" . $row["nama"]. "</td><td>" . $row["email"]. "</td></tr>";
            }
        } else {
            echo "<tr><td colspan='3'>0 hasil</td></tr>";
        }
        ?>
    </table>
</body>
</html>

<?php
$conn->close();
?>
