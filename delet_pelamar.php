<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Lamaran</title>
    <link rel="stylesheet" href="style/delet.css">
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

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['user_id'])) {
    $user_id = $_POST['user_id'];

    // Ambil lamaran terkait
    $query_get_lamaran = "SELECT Id_lamaran FROM terlamar WHERE Id_user = '$user_id'";
    $result = mysqli_query($koneksi, $query_get_lamaran);

    while ($row = mysqli_fetch_assoc($result)) {
        $lamaran_id = $row['Id_lamaran'];
        // Update status lamaran menjadi "Ditolak" untuk semua lamaran dengan user_id yang sama
        $query_update_status = "UPDATE histori SET Status = 'Ditolak' WHERE Id_user = '$user_id' AND Id_lamaran = '$lamaran_id'";
        mysqli_query($koneksi, $query_update_status);      
    }

    // Hapus pelamar dari tabel terlamar
    $query_delete_terlamar = "DELETE FROM terlamar WHERE Id_user = '$user_id'";
    if (mysqli_query($koneksi, $query_delete_terlamar)) {
        echo "Pelamar berhasil dihapus.";
    } else {
        echo "Gagal menghapus pelamar: " . mysqli_error($koneksi);
    }
    echo "<p><a href='homepage_pembuat_lamaran.php'>Kembali ke Homepage</a></p>";
} else {
    echo "Aksi tidak valid.";
}
?></div>
</body>