<?php
require 'config.php';
session_start(); // Koneksi ke database

// Periksa apakah pengguna sudah login
if (!isset($_SESSION['user_id'])) {
    // Redirect atau tampilkan pesan bahwa pengguna harus login terlebih dahulu
    header('Location: login.php');
    exit();
}

$user_id = $_SESSION['user_id'];

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['pembuat_lamaran'])) {
    $nama_tempat = $_POST['nama_tempat'];
    $nama_perusahaan = $_POST['nama_perusahaan'];
    $foto_name = $_FILES['photo']['name'];
    $foto_tmp_name = $_FILES['photo']['tmp_name'];
    $foto_size = $_FILES['photo']['size'];
    $foto_extension = strtolower(pathinfo($foto_name, PATHINFO_EXTENSION));
    $allowed_foto_extensions = array('jpg', 'jpeg', 'png');
    
    if (in_array($foto_extension, $allowed_foto_extensions)) {
            // File is valid, and was successfully uploaded
            $foto_destination = 'foto/' . $foto_name;
            move_uploaded_file($foto_tmp_name, $foto_destination);
            
            // Periksa apakah pengguna telah membuat lamaran sebelumnya
            $check_query = mysqli_query($koneksi, "SELECT * FROM pembuat_lamaran WHERE Id_user = '$user_id'");
            if (mysqli_num_rows($check_query) > 0) {
                // Pengguna sudah membuat lamaran sebelumnya, lakukan update data
                $update = mysqli_query($koneksi, "UPDATE pembuat_lamaran SET nama_tempat = '$nama_tempat', nama_perusahaan = '$nama_perusahaan', FotoPerusahaan = '$foto_name' WHERE Id_user = '$user_id'");
                
                if ($update) {
                    header('Location: homepage_pembuat_lamaran.php?status=update_sukses');
                } else {
                    header('Location: homepage_pembuat_lamaran.php?status=update_gagal');
                }
            } 
            }
        }  else {
        // Invalid file format or size
        header('Location: homepage_pembuat_lamaran.php?status=file_invalid');
    }

?>
