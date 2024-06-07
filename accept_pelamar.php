<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Lamaran</title>
    <link rel="stylesheet" href="style/accept.css">
</head>
<body>
    <div class="container">
<?php
session_start();
include 'config.php';

// Periksa apakah pengguna sudah login
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['lamaran_id'])) {
    $lamaran_id = $_POST['lamaran_id'];

    // Ambil user_id dan nama lamaran
    $query_get_lamaran = "SELECT Id_user, Nama_lamaran FROM terlamar WHERE ID_lamaran = '$lamaran_id'";
    $result = mysqli_query($koneksi, $query_get_lamaran);
    $row = mysqli_fetch_assoc($result);
    $user_id = $row['Id_user'];
    $nama_lamaran = $row['Nama_lamaran'];

    // Hapus lamaran dari tabel lamaran
    // Update status lamaran pada tabel histori jika user_id sudah ada
    $query_update_history = "UPDATE histori SET Status = 'Diterima' WHERE Id_user = '$user_id' AND Id_lamaran = '$lamaran_id'";
    mysqli_query($koneksi, $query_update_history);
    $query_delete_lamaran = "DELETE FROM lamaran WHERE ID_lamaran = '$lamaran_id'";
    mysqli_query($koneksi, $query_delete_lamaran);
    if (mysqli_query($koneksi, $query_update_history)) {
        echo "Lamaran berhasil diaccept.";
    } else {
        echo "Gagal mengaccept lamaran: " . mysqli_error($koneksi);
    }
    echo "<p><a href='homepage_pembuat_lamaran.php'>Kembali ke Homepage</a></p>";
} else {
    echo "Aksi tidak valid.";
}
?></div>
</body>