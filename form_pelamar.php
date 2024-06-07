<?php
session_start();
include 'config.php'; // Koneksi ke database
// Periksa apakah pengguna sudah login
if (!isset($_SESSION['user_id'])) {
    // Redirect atau tampilkan pesan bahwa pengguna harus login terlebih dahulu
    header('Location: login.php');
    exit();
}
$user_id = $_SESSION['user_id'];
?>

<!DOCTYPE html>
<html>
<head>
    <title>Form Pembuat Lamaran</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <link href="style/datapelamar.css" rel="stylesheet" type="text/css" media="all" />
    <link href="//fonts.googleapis.com/css?family=Roboto:300,300i,400,400i,700,700i" rel="stylesheet">
</head>
<body>
    <div class="container">
        <h1>Creative Pelamar Form</h1>
        <div class="konten">
                <form action="register_pelamar.php" method="POST" enctype="multipart/form-data">
                        <p>   
                            <label>Foto (jpg/jpeg/png): </label>
                            <input type="file" name="Foto" accept="image/jpeg, image/jpg, image/png" />
                        </p>
                        <p>
                            <label>Keahlian: </label>
                            <textarea name="keahlian" placeholder="Keahlian"></textarea>
                        </p>
                        <p>
                            <label>CV (pdf): </label>
                            <input type="file" name="cv" accept="application/pdf" />
                        </p>
                        <p>
                            <input type="submit" value="Submit" name="pelamar" />
                        </p>
                    <p>Have an account? <a href="login.php">Login now</a></p>
                </form>
        </div>
    </div>
</body>
</html>