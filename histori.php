<?php
session_start();
include 'config.php';

// Periksa apakah pengguna sudah login
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}

$user_id = $_SESSION['user_id'];

$query = "SELECT * FROM histori WHERE Id_user = '$user_id'";
$result = mysqli_query($koneksi, $query);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Riwayat Lamaran</title>
    <link rel="stylesheet" href="style/histori.css">
</head>
<body>
    <div class="container">
        <h1>Riwayat Lamaran</h1>
        <table border="1">
            <tr>

                <th>Nama Lamaran</th>
                <th>Status</th>
            </tr>
            <?php while ($row = mysqli_fetch_assoc($result)) { ?>
                <tr>
                    <td><?php echo $row['Nama_lamaran']; ?></td>
                    <td><?php echo $row['Status']; ?></td>
                </tr>
            <?php } ?>
        </table>
        <p class="btn-back"><a href="homepagePelamar.php">Homepage</a></p>
    </div>
    
</body>
</html>