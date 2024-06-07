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
$query_pembuat_lamaran = "SELECT Nama_tempat, Nama_perusahaan FROM pembuat_lamaran WHERE id_user = '$user_id'";
$result_pembuat_lamaran = mysqli_query($koneksi, $query_pembuat_lamaran);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Tangkap data yang dikirimkan melalui form
    $nama = $_POST['nama'];
    $email = $_POST['email'];
    $telepon = $_POST['telepon'];
    
    // Update informasi dasar user
    $query_update_user = "UPDATE user SET Nama = '$nama', user_Email = '$email', User_telepon = '$telepon' WHERE user_id = '$user_id'";
    $result_update_user = mysqli_query($koneksi, $query_update_user);
    // Update informasi pada tabel terlamar
    $query_update_user_terlamar = "UPDATE terlamar SET Nama_user = '$nama' WHERE id_user = '$user_id'";
    $result_update_user_terlamar = mysqli_query($koneksi, $query_update_user_terlamar);

    if ($result_update_user) {
        // Jika pengguna adalah pelamar, update juga informasi tambahan
        if ($user_type == 'Pelamar') {
            // Tangkap data tambahan yang dikirimkan melalui form
            $keahlian = $_POST['keahlian'];
            $cv = $_FILES['cv']['name'];

            // Upload CV
            $cv_temp = $_FILES['cv']['tmp_name'];
            $cv_path = "cv/" . $cv;
            move_uploaded_file($cv_temp, $cv_path);

            // Upload Foto
            $foto_name = $_FILES['Foto']['name'];
            $foto_tmp_name = $_FILES['Foto']['tmp_name'];
            $foto_destination = 'foto/' . $foto_name;
            move_uploaded_file($foto_tmp_name, $foto_destination);

            // Query untuk update informasi tambahan pelamar
            $query_update_pelamar = "UPDATE pelamar SET Keahlian = '$keahlian', CV = '$cv', Foto = '$foto_name' WHERE id_user = '$user_id'";
            $result_update_pelamar = mysqli_query($koneksi, $query_update_pelamar);
            // Update informasi pada tabel terlamar
            $query_update_terlamar = "UPDATE terlamar SET user_CV = '$cv', User_photo = '$foto_name' WHERE id_user = '$user_id'";
            $result_update_terlamar = mysqli_query($koneksi, $query_update_terlamar);

            if ($result_update_pelamar) {
                // Redirect ke halaman profil setelah berhasil update
                header('Location: profil.php');
                exit();
            } else {
                echo "Error: " . mysqli_error($koneksi);
            }
        } elseif ($user_type == 'Pembuat Lamaran') {
            // Jika pengguna adalah pembuat lamaran, update informasi tambahan pembuat lamaran
            $nama_tempat = $_POST['nama_tempat'];
            $nama_perusahaan = $_POST['nama_perusahaan'];

            $foto_name = $_FILES['Photo']['name'];
            $foto_tmp_name = $_FILES['Photo']['tmp_name'];
            $foto_destination = 'foto/' . $foto_name;
            move_uploaded_file($foto_tmp_name, $foto_destination);

            // Query untuk update informasi tambahan pembuat lamaran
            $query_update_pembuat_lamaran = "UPDATE pembuat_lamaran SET Nama_tempat = '$nama_tempat', Nama_perusahaan = '$nama_perusahaan',FotoPerusahaan='$foto_name' WHERE id_user = '$user_id'";
            $result_update_pembuat_lamaran = mysqli_query($koneksi, $query_update_pembuat_lamaran);

            if ($result_update_pembuat_lamaran) {
                // Redirect ke halaman profil setelah berhasil update
                header('Location: profil.php');
                exit();
            } else {
                echo "Error: " . mysqli_error($koneksi);
            }
        }
    } else {
        echo "Error: " . mysqli_error($koneksi);
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Profil</title>
    <link rel="stylesheet" href="style/editprofile.css">
</head>
<body>
    <div class="container">
        <h2>Edit Profil</h2>
        <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" enctype="multipart/form-data">
            <?php
            if ($result_user) {
                $row_user = mysqli_fetch_assoc($result_user);
                ?>
                <label for="nama">Nama:</label>
                <input type="text" id="nama" name="nama" value="<?php echo $row_user['Nama']; ?>">

                <label for="email">Email:</label>
                <input type="email" id="email" name="email" value="<?php echo $row_user['user_Email']; ?>">

                <label for="telepon">Telepon:</label>
                <input type="tel" id="telepon" name="telepon" value="<?php echo $row_user['User_telepon']; ?>">

                <?php
            } else {
                echo "Error: " . mysqli_error($koneksi);
            }

            if ($user_type == 'Pelamar' && $result_pelamar) {
                $row_pelamar = mysqli_fetch_assoc($result_pelamar);
                ?>
                <label for="keahlian">Keahlian:</label>
                <input type="text" id="keahlian" name="keahlian" value="<?php echo $row_pelamar['Keahlian']; ?>">

                <label for="cv">CV:</label>
                <input type="file" id="cv" name="cv">

                <label for="Foto">Foto (jpg/jpeg/png):</label>
                <input type="file" id="Foto" name="Foto" accept="image/jpeg, image/jpg, image/png">
                <?php
            }

            if ($user_type == 'Pembuat Lamaran' && $result_pembuat_lamaran) {
                $row_pembuat_lamaran = mysqli_fetch_assoc($result_pembuat_lamaran);
                ?>
                <label for="nama_tempat">Nama Tempat:</label>
                <input type="text" id="nama_tempat" name="nama_tempat" value="<?php echo $row_pembuat_lamaran['Nama_tempat']; ?>">

                <label for="nama_perusahaan">Nama Perusahaan:</label>
                <input type="text" id="nama_perusahaan" name="nama_perusahaan" value="<?php echo $row_pembuat_lamaran['Nama_perusahaan']; ?>">
                
                <label for="Foto">Foto (jpg/jpeg/png):</label>
                <input type="file" id="Foto" name="Photo" accept="image/jpeg, image/jpg, image/png">
                <?php
            }
            ?>

            <input type="submit" value="Simpan">
        </form>
    </div>
</body>
</html>