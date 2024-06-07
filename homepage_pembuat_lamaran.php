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

?>

<!DOCTYPE html>
<html lang="en">
<head>
    
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Home page</title>
   <link href="style/homepage1.css" rel="stylesheet">
   <style>
        @import url('https://fonts.googleapis.com/css2?family=Nunito+Sans:ital,opsz,wght@0,6..12,200..1000;1,6..12,200..1000&display=swap');
   </style>
</head>
<body>
    <div class="container">
        <nav>
            <img src="foto/Logo.svg" class="logo">
            <ul>
                <li>
                    <!-- blank space-->
                </li>
            </ul>
             <!-- Button untuk membuat lamaran -->
            <button class="btn1"><a href="form_pembuat_lamaran.php">Tambah</a></button>
            <button class="btn2"><a href="form_membuatan_lamaran.php">Buat</a></button>
            <button class="btn3"><a href="profil.php">Profil</a></button>
        </nav>
        <body class="title">
            <h1>Selamat datang, <?php echo $user_type; ?>!</h1>
            <p class="typ">Anda sekarang bisa mengakses fitur Pembuat Lamaran.</p>
        </body>
            
           
        <div class="card-wrapper">
       
        <?php
$select_product = mysqli_query($koneksi,  "SELECT * from lamaran") 
or die('query failed');

if(mysqli_num_rows($select_product) > 0){
    while($fetch_product = mysqli_fetch_assoc($select_product)){
?>
        </a>
            <div class="card" style="">
                <div class="card-content">
                    <div class="text-content">
                        <h2 class="namaLamaran"><?php echo $fetch_product['NamaLamaran']; ?></h2>
                        <p class="Specifikasi"><?php echo $fetch_product['Spesifikasi']; ?></p>
                    </div>
                    <div class="button-container">
                        <form action="cekLamaran.php" method="post">
                            <input type="hidden" name="lamaran_id" value="<?php echo $fetch_product['ID_lamaran']; ?>">
                            <button type="submit" class="button 1">Cek</button>
                         </form>

                    <!-- Tambahkan tombol Edit -->
                        <form action="edit_lamaran.php" method="post">
                            <input type="hidden" name="lamaran_id" value="<?php echo $fetch_product['ID_lamaran']; ?>">
                            <button type="submit" class="button 2">Edit</button>
                        </form>

                        <form action="delete_lamaran.php" method="post">
                            <input type="hidden" name="product_id" value="<?php echo $fetch_product['ID_lamaran']; ?>">
                            <button type="submit" class="button 3">Delete</button>
                        </form>
                    </div>
                </div>
            </div>
            <!-- Tambahkan input hidden untuk menyimpan informasi lamaran -->
            <input type="hidden" name="Nama_Lamaran" value="<?php echo $fetch_product['NamaLamaran']; ?>">
            <input type="hidden" name="Spesifikasi" value="<?php echo $fetch_product['Spesifikasi']; ?>">
            <input type="hidden" name="product_id" value="<?php echo $fetch_product['ID_lamaran']; ?>">
            <?php
    };
};
?>
</div>
        <a href="logout.php" class="logout">Logout</a> <!-- Tambahkan link logout di sini -->
    </div>
</body>
</html>

