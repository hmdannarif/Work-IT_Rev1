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
    // Tangkap ID lamaran dari formulir
    $product_id = $_POST['product_id'];

    // Lakukan penghapusan data lamaran dari database
    $delete_query = "DELETE FROM lamaran WHERE ID_lamaran = '$product_id'";
    $result = mysqli_query($koneksi, $delete_query);

    // Jika penghapusan berhasil
    if ($result) {
        // Hapus juga dari tabel terlamar
        $delete_terlamar_query = "DELETE FROM terlamar WHERE Id_lamaran = '$product_id'";
        $terlamar_result = mysqli_query($koneksi, $delete_terlamar_query);

        // Jika penghapusan dari kedua tabel berhasil
        if ($terlamar_result) {
            // Redirect ke halaman utama dengan pesan sukses
            $_SESSION['success_message'] = "Lamaran berhasil dihapus.";
            header('Location: homepage_pembuat_lamaran.php');
            exit();
        } else {
            // Jika penghapusan dari tabel terlamar gagal, tampilkan pesan kesalahan
            $_SESSION['error_message'] = "Gagal menghapus lamaran dari tabel terlamar. Silakan coba lagi.";
            header('Location: homepage_pembuat_lamaran.php');
            exit();
        }
    } else {
        // Jika penghapusan dari tabel lamaran gagal, tampilkan pesan kesalahan
        $_SESSION['error_message'] = "Gagal menghapus lamaran. Silakan coba lagi.";
        header('Location: homepage_pembuat_lamaran.php');
        exit();
    }
} else {
    // Jika data tidak dikirim melalui metode POST, redirect ke halaman utama
    header('Location: homepage_pembuat_lamaran.php');
    exit();
}
?>
