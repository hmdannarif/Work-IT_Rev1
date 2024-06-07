<?php
session_start();
include 'config.php';

// Proses formulir login
if (isset($_POST['login'])) {
    $name = $_POST['user_name'];
    $password = $_POST['user_password'];

    // Lindungi dari serangan SQL injection
    $name = mysqli_real_escape_string($koneksi, $name);
    $password = mysqli_real_escape_string($koneksi, $password);

    // Query untuk memeriksa keberadaan pengguna
    $query = "SELECT user_id, jenis_user FROM user WHERE user_name = '$name' AND user_password = '$password'";
    $result = mysqli_query($koneksi, $query);

    if ($result->num_rows == 1) {
        // Pengguna ditemukan, ambil jenis pengguna dari hasil query
        $row = $result->fetch_assoc();
        $jenis_user = $row['jenis_user'];
        $user_id = $row['user_id'];

        // Cek apakah user_id sudah ada dalam tabel pelamar atau pembuat_lamaran
        $check_pelamar_query = mysqli_query($koneksi, "SELECT * FROM pelamar WHERE id_user = '$user_id'");
        $check_pembuat_lamaran_query = mysqli_query($koneksi, "SELECT * FROM pembuat_lamaran WHERE id_user = '$user_id'");

        if ($jenis_user == 'Pelamar' && mysqli_num_rows($check_pelamar_query) == 0) {
            // Jika pelamar dan belum ada dalam tabel pelamar, masukkan ke dalam tabel pelamar
            $insert_pelamar = mysqli_query($koneksi, "INSERT INTO pelamar (id_user) VALUES ('$user_id')");
        } elseif ($jenis_user == 'Pembuat_lamaran' && mysqli_num_rows($check_pembuat_lamaran_query) == 0) {
            // Jika pembuat lamaran dan belum ada dalam tabel pembuat_lamaran, masukkan ke dalam tabel pembuat_lamaran
            $insert_pembuat_lamaran = mysqli_query($koneksi, "INSERT INTO pembuat_lamaran (id_user) VALUES ('$user_id')");
        }
        if ($jenis_user == 'Pelamar') {
            // Set session user_id dan user_type
            $_SESSION['user_id'] = $user_id;
            $_SESSION['user_type'] = 'Pelamar';
            // Arahkan pengguna ke halaman homepagePelamar
            header('Location: homepagePelamar.php?status=sukses');
            exit();
        } elseif ($jenis_user == 'Pembuat_lamaran') {
            // Set session user_id dan user_type
            $_SESSION['user_id'] = $user_id;
            $_SESSION['user_type'] = 'Pembuat Lamaran';
            // Arahkan pengguna ke halaman homepage_pembuat_lamaran
            header('Location: homepage_pembuat_lamaran.php?status=sukses');
            exit();
        }
        // Arahkan pengguna ke halaman beranda
        header('Location: homepage.php?status=sukses');
        exit();
    } else {
        // Jika pengguna tidak ditemukan, arahkan ke halaman login dengan status gagal
        header('Location: login.php?status=gagal');
        exit();
    }
}
?>

