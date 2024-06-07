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

if (isset($_POST['Apply'])) {
    $query_user_name = mysqli_query($koneksi, "SELECT Nama FROM user WHERE user_id = '$user_id'");
    if ($row = mysqli_fetch_assoc($query_user_name)) {
        $nama_user = $row['Nama'];

        // Tangkap data yang dikirimkan melalui form
        $lamaran_id = $_POST['product_id'];
        $nama_lamaran = $_POST['Nama_Lamaran'];
        $spesifikasi = $_POST['Spesifikasi'];
        $cv_pelamar = $_POST['CV'];
        $foto_pelamar = $_POST['Foto'];

        // Cek apakah pelamar sudah melamar lamaran ini sebelumnya
        $select_application = mysqli_query($koneksi, "SELECT * FROM terlamar WHERE Id_user = '$user_id' AND Id_lamaran = '$lamaran_id'") or die('Query failed');

        if (mysqli_num_rows($select_application) > 0) {
            $message[] = 'You have already applied for this job!';
        } else {
            $queryhistori = "INSERT INTO histori (Id_user, Id_lamaran, Nama_lamaran) VALUES ('$user_id', '$lamaran_id', '$nama_lamaran')";
            mysqli_query($koneksi, $queryhistori);

            // Simpan data lamaran ke dalam tabel terlamar
            $query = "INSERT INTO terlamar (Id_user, Id_lamaran, Nama_lamaran, user_CV, user_Photo, Nama_user) VALUES ('$user_id', '$lamaran_id', '$nama_lamaran', '$cv_pelamar', '$foto_pelamar', '$nama_user')";

            if (mysqli_query($koneksi, $query)) {
                // Update nilai Total_lamaran di tabel lamaran
                $update_total_lamaran_query = "UPDATE lamaran SET Total_lamaran = Total_lamaran + 1 WHERE ID_lamaran = '$lamaran_id'";
                mysqli_query($koneksi, $update_total_lamaran_query);

                // Ambil nilai Max_lamaran dari tabel lamaran
                $get_max_lamaran_query = "SELECT * FROM lamaran WHERE ID_lamaran = '$lamaran_id'";
                $result = mysqli_query($koneksi, $get_max_lamaran_query);
                $row = mysqli_fetch_assoc($result);
                $max_lamaran = $row['Max_lamaran'];

                // Periksa apakah Total_lamaran sudah sama dengan Max_lamaran
                if ($max_lamaran == $row['Total_lamaran']) {
                    $message[] = 'This job is no longer available for application.';
                } else {
                    $message[] = 'Application submitted successfully!';
                }
            } else {
                $message[] = 'Error: ' . mysqli_error($koneksi);
            }
        }
    }
}

// Fungsi untuk memeriksa apakah pelamar sudah memiliki data tambahan
function pelamarSudahPunyaDataTambahan($user_id)
{
    global $koneksi;

    // Query untuk memeriksa apakah pelamar sudah memiliki data tambahan (CV)
    $query = "SELECT CV FROM pelamar WHERE id_user = '$user_id'";
    $result = mysqli_query($koneksi, $query);

    // Periksa apakah query berhasil dieksekusi dan apakah CV sudah ada untuk pelamar tersebut
    if ($result && mysqli_num_rows($result) > 0) {
        return true; // Jika CV sudah ada untuk pelamar, kembalikan true
    } else {
        return false; // Jika CV belum ada untuk pelamar, kembalikan false
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Home page</title>
   <link rel="stylesheet" href="style/hompage2.css">
   <!-- custom css file link  -->
</head>
<body>
    <div class="container">
        
        <?php if ($user_type == 'Pelamar'): ?>
            
            <nav>
                <img src="foto/Logo.svg" class="logo">
                <ul>
                    <li>
                        <!-- white space -->
                    </li>
                </ul>
                <button class="btn"><a href="form_pelamar.php">Tambah </a></button>
                <button class="btn"><a href="histori.php">Histori</a></button>
                <button class="profile"><a href="profil.php">Profil</a></button>
            </nav>
            <body class="title">
                <h1>Selamat datang, <?php echo $user_type; ?>!</h1>
                <p>Anda sekarang bisa mengakses fitur Pelamar.</p>
                <form class="search" method="post" action="prosescari.php">
                
                    <input type="text" name="search_data" placeholder="Cari lamaran kerja...">
                    <button type="submit" name="cari">Cari</button>
                
                </form>
            </body>

        <?php endif; ?>
            
               
    <div class="card-wrapper">
        
        <?php
// Periksa apakah sudah ada hasil pencarian
if (isset($_SESSION['search_results'])) {
    $search_results = $_SESSION['search_results'];
    if (!empty($search_results)) {
        foreach ($search_results as $result) 
        {?>
                    <form class="box" method="post" action="">
                        
                        <div class="box-content">
                            <div class="text-content">
                                <div class="Nama_Lamaran"><?php echo $result['NamaLamaran']; ?></div>
                                <div class="Spesifikasi"><?php echo $result['Spesifikasi']; ?></div>
                            </div>
    
                                <input type="hidden" name="Nama_Lamaran" value="<?php echo $result['NamaLamaran']; ?>">
                                <input type="hidden" name="Spesifikasi" value="<?php echo $result['Spesifikasi']; ?>">
                                <input type="hidden" name="product_id" value="<?php echo $result['ID_lamaran']; ?>">
                                <?php if (pelamarSudahPunyaDataTambahan($user_id)) { ?>
                        </div>    
                        
                <!-- Jika pelamar sudah memiliki data tambahan, tampilkan form apply -->
                <?php
// Ambil semua data dari tabel pelamar berdasarkan ID pelamar yang sedang login
$select_pelamar = mysqli_query($koneksi, "SELECT * FROM pelamar WHERE id_user = '$user_id'") or die('query failed');

// Periksa apakah ada data yang berhasil diambil
if (mysqli_num_rows($select_pelamar) > 0) {
    // Jika ada data, tampilkan formulir Apply
    while ($fetch_search = mysqli_fetch_assoc($select_pelamar)) {
?>

    <div class="box-content">
        <form action="" method="post">
            <!-- Tambahkan input hidden untuk menyimpan ID lamaran yang akan dilamar -->
            <input type="hidden" name="product_id" value="<?php echo $result['ID_lamaran']; ?>">
            <!-- Tambahkan input hidden untuk menyimpan CV dan foto pelamar -->
            <input type="hidden" name="CV" value="<?php echo $fetch_search['CV']; ?>">
            <input type="hidden" name="Foto" value="<?php echo $fetch_search['Foto']; ?>">
            <input type="hidden" name="Nama_Lamaran" value="<?php echo $result['NamaLamaran']; ?>">
            <input type="hidden" name="Spesifikasi" value="<?php echo $result['Spesifikasi']; ?>">      
               <div class="btn-konten">
            <form action="" method="post">
                <button class="button" type="submit" name="Apply">Apply</button>
            </form>   
        </form>
            <form action="cekLamar.php" method="post" class="gap">
                <input type="hidden" name="lamaran_id" value="<?php echo $fetch_product['ID_lamaran']; ?>">
                <button type="submit" class="button">Cek</button>
            </form>
         </div>
    </div>
<?php
    }
?>
            <?php } else { ?>
                <!-- Jika pelamar belum memiliki data tambahan, tampilkan pesan dan berikan link untuk menambah data tambahan -->
                <p>Anda harus menambahkan data tambahan terlebih dahulu sebelum melamar.</p>
                <a href="form_pelamar.php">Tambahkan data tambahan</a>
            <?php } ?>
        <?php } ?>
        <?php } 
    } else {
        echo "Tidak ada hasil pencarian.";
    }
    // Hapus hasil pencarian dari sesi setelah ditampilkan
    unset($_SESSION['search_results']);
} else {
    // Tampilkan daftar lamaran kerja seperti biasa
    $select_product = mysqli_query($koneksi, "SELECT * FROM lamaran") or die('query failed');
    if (mysqli_num_rows($select_product) > 0) {
        while ($fetch_product = mysqli_fetch_assoc($select_product)) {
?>
    <form method="post" class="box" action="">
        <div class="box-content">
            <div class="text-content">
                <div class="Nama_Lamaran"><?php echo $fetch_product['NamaLamaran']; ?></div>
                <div class="Spesifikasi"><?php echo $fetch_product['Spesifikasi']; ?></div>
            </div>
            <!-- Tambahkan input hidden untuk menyimpan informasi lamaran -->
            <input type="hidden" name="Nama_Lamaran" value="<?php echo $fetch_product['NamaLamaran']; ?>">
            <input type="hidden" name="Spesifikasi" value="<?php echo $fetch_product['Spesifikasi']; ?>">
            <input type="hidden" name="product_id" value="<?php echo $fetch_product['ID_lamaran']; ?>">
            <?php if (pelamarSudahPunyaDataTambahan($user_id)) { ?>
        </div>
                <!-- Jika pelamar sudah memiliki data tambahan, tampilkan form apply -->
                <?php
// Ambil semua data dari tabel pelamar berdasarkan ID pelamar yang sedang login
$select_pelamar = mysqli_query($koneksi, "SELECT * FROM pelamar WHERE id_user = '$user_id'") or die('query failed');

// Periksa apakah ada data yang berhasil diambil
if (mysqli_num_rows($select_pelamar) > 0) {
    // Jika ada data, tampilkan formulir Apply
    while ($fetch_pelamar = mysqli_fetch_assoc($select_pelamar)) {
?>
        <div class="box-content">
            <form action="" method="post">
                <!-- Tambahkan input hidden untuk menyimpan ID lamaran yang akan dilamar -->
                <input type="hidden" name="product_id" value="<?php echo $fetch_product['ID_lamaran']; ?>">
                <!-- Tambahkan input hidden untuk menyimpan CV dan foto pelamar -->
                <input type="hidden" name="CV" value="<?php echo $fetch_pelamar['CV']; ?>">
                <input type="hidden" name="Foto" value="<?php echo $fetch_pelamar['Foto']; ?>">
                <input type="hidden" name="Nama_Lamaran" value="<?php echo $fetch_product['NamaLamaran']; ?>">
                <input type="hidden" name="Spesifikasi" value="<?php echo $fetch_product['Spesifikasi']; ?>">
                <div class="btn-konten">
                <form action="" method="post">
                <button class="button" type="submit" name="Apply">Apply</button>
            </form>
            </form>
            <form action="cekLamar.php" method="post" class="gap">
                <input type="hidden" name="lamaran_id" value="<?php echo $fetch_product['ID_lamaran']; ?>">
                <button type="submit" class="button">Cek</button>
            </form>
            </div>
        </div>
<?php
    }
?>
            <?php } else { ?>
                <!-- Jika pelamar belum memiliki data tambahan, tampilkan pesan dan berikan link untuk menambah data tambahan -->
                <p>Anda harus menambahkan data tambahan terlebih dahulu sebelum melamar.</p>
                <a href="form_pelamar.php">Tambahkan data tambahan</a>
            <?php } ?>
        <?php } ?>
    </form>
<?php
        }
    }
}
?>
</div>
        <a href="logout.php" class="logout">Logout</a> <!-- Tambahkan link logout di sini -->
    </div>
</body>
</html>