<?php
require 'config.php';
session_start();

// Ambil ID user yang sedang login
$id_user = $_SESSION['user_id'];
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['buat_lamaran'])) {
    $namaLamaran = $_POST['namaLamaran'];
    $tanggal_lamaran = $_POST['tanggal_lamaran'];
    $spesifikasi = $_POST['spesifikasi'];
    $id_user = $_SESSION['user_id']; // Ambil ID user yang sedang login
    $max_lamaran = $_POST['Max_lamaran'];
    // Masukkan data ke dalam tabel lamaran
    $insert = mysqli_query($koneksi, "INSERT INTO lamaran (namaLamaran, tanggal_lamaran, spesifikasi, id_user,Max_lamaran) VALUES ('$namaLamaran', '$tanggal_lamaran', '$spesifikasi', '$id_user','$max_lamaran')");
    if ($insert) {
        header('Location: homepage_pembuat_lamaran.php?status=sukses');
    } else {
        header('Location: homepage_pembuat_lamaran.php?status=gagal');
    }
}
?>
