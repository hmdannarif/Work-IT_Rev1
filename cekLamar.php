<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Lamaran</title>
    <link rel="stylesheet" href="style/ceklamaran.css">
</head>
<body>
    <div class="container">
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

        // Periksa apakah data lamaran_id dikirim melalui metode POST
        if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['lamaran_id'])) {
            $lamaran_id = $_POST['lamaran_id'];

            // Query untuk mendapatkan ID pembuat lamaran dari tabel lamaran
            $query = "SELECT Id_user FROM lamaran WHERE ID_lamaran = '$lamaran_id'";
            $result = mysqli_query($koneksi, $query);

            if (mysqli_num_rows($result) > 0) {
                $lamaran_data = mysqli_fetch_assoc($result);
                $pembuat_id = $lamaran_data['Id_user'];

                // Query untuk mendapatkan detail pembuat lamaran dari tabel pembuat_lamaran
                $query_pembuat = "SELECT * FROM pembuat_lamaran WHERE Id_user = '$pembuat_id'";
                $result_pembuat = mysqli_query($koneksi, $query_pembuat);

                if (mysqli_num_rows($result_pembuat) > 0) {
                    // Tampilkan detail pembuat lamaran
                    $fetch_pembuat = mysqli_fetch_assoc($result_pembuat);
                    echo "<h2>Detail Pembuat Lamaran</h2>";
                    echo "<div class='pembuat-detail'>";
                    echo "<div class='detail-item'><strong>Nama Tempat:</strong> " . $fetch_pembuat['Nama_tempat'] . "</div>";
                    echo "<div class='detail-item'><strong>Nama Perusahaan:</strong> " . $fetch_pembuat['Nama_perusahaan'] . "</div>";
                    ?>
                    <img class="pelamar-foto" src="foto/<?php echo  $fetch_pembuat['FotoPerusahaan']; ?>">
                    <?php
                    echo "</div>";
                } else {
                    echo "<p>Data pembuat lamaran tidak ditemukan.</p>";
                }
            } else {
                // Jika lamaran tidak ditemukan, tampilkan pesan
                echo "<p>Lamaran tidak ditemukan.</p>";
            }
        }
        echo "<p><a href='homepagePelamar.php' class='btn btn-back'>Kembali ke Homepage</a></p>";
        ?>
    </div>
</body>
</html>
