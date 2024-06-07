<?php
require 'config.php';
session_start();
include 'konek.php'; // Koneksi ke database

// Periksa apakah pengguna sudah login
if (!isset($_SESSION['user_id'])) {
    // Redirect atau tampilkan pesan bahwa pengguna harus login terlebih dahulu
    header('Location: login.php');
    exit();
}

$user_id = $_SESSION['user_id'];

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['pelamar'])) {
    // File Foto
    $foto_name = $_FILES['Foto']['name'];
    $foto_tmp_name = $_FILES['Foto']['tmp_name'];
    $foto_size = $_FILES['Foto']['size'];
    $foto_extension = strtolower(pathinfo($foto_name, PATHINFO_EXTENSION));
    $allowed_foto_extensions = array('jpg', 'jpeg', 'png');

    // File CV
    $cv_name = $_FILES['cv']['name'];
    $cv_tmp_name = $_FILES['cv']['tmp_name'];
    $cv_size = $_FILES['cv']['size'];
    $cv_extension = strtolower(pathinfo($cv_name, PATHINFO_EXTENSION));
    $allowed_cv_extension = array('pdf');

    // Validasi dan simpan file
    if (in_array($foto_extension, $allowed_foto_extensions) && in_array($cv_extension, $allowed_cv_extension)) {
        // Simpan file foto
        $foto_destination = 'foto/' . $foto_name;
        move_uploaded_file($foto_tmp_name, $foto_destination);

        // Simpan file CV
        $cv_destination = "cv/" . $cv_name;
        move_uploaded_file($cv_tmp_name, $cv_destination);
        
        // Cek apakah user_id sudah ada dalam tabel pelamar
        $check_pelamar_query = mysqli_query($koneksi, "SELECT * FROM pelamar WHERE id_user = '$user_id'");
        if (mysqli_num_rows($check_pelamar_query) > 0) {
            // Pengguna sudah ada dalam tabel pelamar, lakukan update data
            $update = mysqli_query($koneksi, "UPDATE pelamar SET foto = '$foto_name', keahlian = '{$_POST['keahlian']}', cv = '$cv_name' WHERE id_user = '$user_id'");
            
            if ($update) {
                header('Location: homepagePelamar.php?status=update_sukses');
            } else {
                header('Location: homepagePelamar.php?status=update_gagal');
            }
        } 
    } else {
        header('Location: form_pelamar.php?status=invalid_file');
    }
}
?>
