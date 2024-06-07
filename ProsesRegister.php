<?php
require 'config.php';
session_start();
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['daftar'])) {
    $username = $_POST['user_name'];
    $email = $_POST['user_Email'];
    $password = $_POST['user_password'];
    $jenis_user = $_POST['jenis_user'];
    $telepon = $_POST['User_telepon'];
    $nama = $_POST['Nama'];

    // Masukkan data ke dalam tabel user
    $insert_user = mysqli_query($koneksi, "INSERT INTO user (user_name, user_Email, user_password, jenis_user, User_telepon, Nama) VALUES ('$username', '$email', '$password', '$jenis_user', '$telepon', '$nama')");
    $user_id = mysqli_insert_id($koneksi);
    
    $user_id = mysqli_insert_id($koneksi);
    
    if( $insert_==TRUE ) {
        // kalau berhasil alihkan ke halaman index.php dengan status=sukses
        header('Location: login.php?status=sukses');
    } else {
        // kalau gagal alihkan ke halaman indek.ph dengan status=gagal
        header('Location: login.php?status=gagal');
    }
}
?>
