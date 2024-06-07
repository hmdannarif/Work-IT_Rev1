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

            // Lakukan pengecekan lamaran di sini, contoh:
            // Misalnya, Anda ingin menampilkan detail lamaran berdasarkan lamaran_id
            $query = "SELECT * FROM terlamar WHERE Id_lamaran = '$lamaran_id'";
            $result = mysqli_query($koneksi, $query);

            if (mysqli_num_rows($result) > 0) {
                // Tampilkan detail lamaran dalam loop
                while ($fetch_product = mysqli_fetch_assoc($result)) {
                    $pelamar_id = $fetch_product['Id_user']; // Asumsikan ada kolom user_id pada tabel terlamar
                    echo "<h2>Detail Pelamar</h2>";
                    echo "<div class='lamaran-detail'>";
                    echo "<div class='detail-item'><strong>Nama Lamaran:</strong> " . $fetch_product['Nama_lamaran'] . "</div>";
                    echo "<div class='detail-item'><strong>Nama User:</strong> " . $fetch_product['Nama_user'] . "</div>";
                    echo "<div class='detail-item'><strong>CV:</strong> <a href='download_cv.php?url=" . $fetch_product['user_CV'] . "'>Download CV</a></div>";
                    echo "<div class='detail-item'><strong></strong> <img src='foto/" . $fetch_product['User_photo'] . "' alt='Foto Pelamar' class='pelamar-foto'></div>";
                    echo "</div>";
                    echo "<div class='actions'>";
                    // Tombol Delete pelamar
                    echo "<form method='POST' action='delet_pelamar.php'>
                            <input type='hidden' name='user_id' value='" . $pelamar_id . "'>
                            <input type='submit' value='Delete' class='btn btn-delete'>
                          </form>";
                    echo "</div>";
                }
                echo "<div class='actions'>";
                // Tombol Accept lamaran
                echo "<form method='POST' action='accept_pelamar.php'>
                        <input type='hidden' name='lamaran_id' value='" . $lamaran_id . "'>
                        <input type='submit' value='Accept' class='btn btn-accept'>
                      </form>";
                echo "</div>";
            } else {
                // Jika lamaran tidak ditemukan, tampilkan pesan
                echo "<p>Lamaran tidak ditemukan.</p>";
            }
        }
        echo "<p><a href='homepage_pembuat_lamaran.php' class='btn btn-back'>Kembali ke Homepage</a></p>";
        ?>
    </div>
</body>
</html>
