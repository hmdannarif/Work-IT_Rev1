<?php
session_start();
include 'config.php';

// Periksa apakah pengguna sudah login
if (!isset($_SESSION['user_id'])) {
    // Redirect atau tampilkan pesan bahwa pengguna harus login terlebih dahulu
    header('Location: login.php');
    exit();
}

$user_id = $_SESSION['user_id'];
$user_type = $_SESSION['user_type'];

// Query untuk mengambil informasi dari tabel user
$query_user = "SELECT user_name, Nama, user_Email, User_telepon FROM user WHERE user_id = '$user_id'";
$result_user = mysqli_query($koneksi, $query_user);

// Query untuk mengambil informasi tambahan khusus pelamar
$query_pelamar = "SELECT Foto, Keahlian, CV FROM pelamar WHERE id_user = '$user_id'";
$result_pelamar = mysqli_query($koneksi, $query_pelamar);

// Query untuk mengambil informasi tambahan khusus pembuat lamaran
$query_pembuat_lamaran = "SELECT Nama_tempat, Nama_perusahaan,FotoPerusahaan FROM pembuat_lamaran WHERE id_user = '$user_id'";
$result_pembuat_lamaran = mysqli_query($koneksi, $query_pembuat_lamaran);
?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Profil</title>
   <link rel="stylesheet" href="style/profile.css">
   <style>
      /* CSS untuk gambar profil */
      .profile-image {
         width: auto; /* Sesuaikan lebar gambar sesuai kebutuhan */
         height: auto; /* Biarkan tinggi gambar menyesuaikan proporsi aslinya */
         border-radius: 50%; /* Agar gambar memiliki sudut yang bulat */
         border: 2px solid #ccc; /* Tambahkan border untuk gambar */
      }
   </style>
</head>
<body>
   <div class="box">
   <!-- Konten Profil -->
   <!-- Informasi User -->
   <?php
   // Menampilkan informasi user
   if ($result_user) {
      $row_user = mysqli_fetch_assoc($result_user);
      echo "<h2>Informasi User</h2>";
      echo "<p>User Name: " . $row_user['user_name'] . "</p>";
      echo "<p>Nama: " . $row_user['Nama'] . "</p>";
      echo "<p>Email: " . $row_user['user_Email'] . "</p>";
      echo "<p>Telepon: " . $row_user['User_telepon'] . "</p>";
      echo "<p><a href='edit_profile.php'>Edit Profil</a></p>";
      
   } else {
      echo "Error: " . mysqli_error($koneksi);
   }

   // Tampilkan informasi tambahan khusus pelamar
   if ($user_type == 'Pelamar' && $result_pelamar) {
      $row_pelamar = mysqli_fetch_assoc($result_pelamar);
      echo "<h2>Informasi Tambahan Khusus Pelamar</h2>";
      ?>
      <img src="foto/<?php echo $row_pelamar['Foto']; ?>">
      <?php
      echo "<p>Keahlian: " . $row_pelamar['Keahlian'] . "</p>";
      echo "<p><a href='download_cv.php?url=" . $row_pelamar['CV'] . "'>Download CV</a></p>";
      echo "<p ><a href='homepagePelamar.php'>Homepage</a></p>";

   } elseif ($user_type == 'Pembuat Lamaran' && $result_pembuat_lamaran) {
      // Tampilkan informasi tambahan khusus pembuat lamaran
      $row_pembuat_lamaran = mysqli_fetch_assoc($result_pembuat_lamaran);
      echo "<h2>Informasi Tambahan Khusus Pembuat Lamaran</h2>";
      echo "<p>Nama Tempat: " . $row_pembuat_lamaran['Nama_tempat'] . "</p>";
      echo "<p>Nama Perusahaan: " . $row_pembuat_lamaran['Nama_perusahaan'] . "</p>";
      ?>
      <img src="foto/<?php echo $row_pembuat_lamaran['FotoPerusahaan']; ?>">
      <?php
      echo "<p><a href='homepage_pembuat_lamaran.php'>Homepage</a></p>";
   } else {
      echo "Error: " . mysqli_error($koneksi);
   }
   ?>
   </div>
</body>
</html>


