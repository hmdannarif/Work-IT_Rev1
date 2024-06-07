<?php
session_start();
include 'config.php';

// Periksa apakah pengguna sudah login
if (!isset($_SESSION['user_id'])) {
    // Redirect atau tampilkan pesan bahwa pengguna harus login terlebih dahulu
    header('Location: login.php');
    exit();
}

// Periksa apakah ada data yang dikirimkan melalui metode POST
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['product_id'])) {
    // Tangkap data dari formulir
    $product_id = $_POST['product_id'];
    $nama_lamaran = $_POST['nama_lamaran'];
    $spesifikasi = $_POST['spesifikasi'];

    // Lakukan update data lamaran di database
    $query = "UPDATE lamaran SET NamaLamaran = '$nama_lamaran', Spesifikasi = '$spesifikasi' WHERE ID_lamaran = '$product_id'";
    $result = mysqli_query($koneksi, $query);
    
    $terlamar_query = "UPDATE terlamar SET Nama_lamaran = '$nama_lamaran' WHERE Id_lamaran = '$product_id'";
    $terlamar_result = mysqli_query($koneksi, $terlamar_query);
    
    if ($result && $terlamar_result) {
        // Jika update berhasil, redirect ke halaman utama dengan pesan sukses
        $_SESSION['success_message'] = "Lamaran berhasil diperbarui.";
        header('Location: homepage_pembuat_lamaran.php');
        exit();
    } else {
        // Jika terjadi kesalahan dalam query, tampilkan pesan kesalahan
        $_SESSION['error_message'] = "Terjadi kesalahan. Silakan coba lagi.";
        header('Location: homepage_pembuat_lamaran.php');
        exit();
    }
} else {
    // Jika data tidak dikirim melalui metode POST, redirect ke halaman utama
    header('Location: homepage_pembuat_lamaran.php');
    exit();
}
?>
