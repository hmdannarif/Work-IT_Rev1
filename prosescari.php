<?php
session_start();
include 'config.php'; // Koneksi ke database

// Periksa apakah pengguna sudah login
// Ambil informasi sesi
$user_id = $_SESSION['user_id'];
$user_type = $_SESSION['user_type']; // Anda perlu mengambil jenis pengguna dari sesi

if (isset($_POST['cari'])) {
    $search_data = $_POST['search_data'];

    // Query pencarian
    $query = "SELECT * FROM lamaran WHERE NamaLamaran LIKE '%$search_data%'";
    $result = mysqli_query($koneksi, $query);

    // Mengumpulkan hasil pencarian ke dalam array
    if ($result) {
        while ($row = mysqli_fetch_assoc($result)) {
            $search_results[] = $row;
        }
    }
    
    // Simpan hasil pencarian ke dalam sesi atau cookie
    $_SESSION['search_results'] = $search_results;

    // Tentukan halaman tujuan berdasarkan jenis pengguna
    if ($user_type == 'Pelamar') {
        header('Location: homepagePelamar.php');
    } elseif ($user_type == 'Pembuat_Lamaran') {
        header('Location: homepage_pembuat_lamaran.php');
    }
    exit();
}

?>