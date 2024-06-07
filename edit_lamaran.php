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

// Periksa apakah ada data lamaran yang dikirimkan melalui metode POST
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['lamaran_id'])) {
    $product_id = $_POST['lamaran_id'];

    // Lakukan pengecekan lamaran di sini dan tampilkan formulir edit
    $query = "SELECT * FROM lamaran WHERE ID_lamaran = '$product_id'";
    $result = mysqli_query($koneksi, $query);

    if ($result && mysqli_num_rows($result) > 0) {
        $fetch_product = mysqli_fetch_assoc($result);
        ?>
        <!DOCTYPE html>
        <html lang="en">
        <head>
           <meta charset="UTF-8">
           <meta http-equiv="X-UA-Compatible" content="IE=edge">
           <meta name="viewport" content="width=device-width, initial-scale=1.0">
           <link rel="stylesheet" href="style/editlamaran.css">
           <title>Edit Lamaran</title>
        </head>
        <body>
            <div class="konten">
                <h2>Edit Lamaran</h2>
                <form action="proses_edit_lamaran.php" method="post">
                    <input type="hidden" name="product_id" value="<?php echo $fetch_product['ID_lamaran']; ?>">
                    <label for="nama_lamaran">Nama Lamaran:</label><br>
                    <input type="text" id="nama_lamaran" name="nama_lamaran" value="<?php echo $fetch_product['NamaLamaran']; ?>"><br>
                    <label for="spesifikasi">Spesifikasi:</label><br>
                    <textarea id="spesifikasi" name="spesifikasi"><?php echo $fetch_product['Spesifikasi']; ?></textarea><br><br>
                    <button type="submit">Simpan Perubahan</button>
                </form>
            </div>
        </body>
        </html>
        <?php
    } else {
        echo "Lamaran tidak ditemukan.";
    }
} else {
    echo "Invalid request.";
}
?>
