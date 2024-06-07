<?php
// Pastikan parameter URL 'url' telah diset dan merupakan file yang valid
if (isset($_GET['url']) && !empty($_GET['url'])) {
    // Path file CV
    $cv_path = 'cv/' . $_GET['url'];

    // Pastikan file CV ada
    if (file_exists($cv_path)) {
        // Set header untuk memberitahu browser bahwa file adalah file untuk diunduh
        header('Content-Description: File Transfer');
        header('Content-Type: application/pdf'); // Ganti tipe konten sesuai format CV Anda
        header('Content-Disposition: attachment; filename="' . basename($cv_path) . '"');
        header('Content-Length: ' . filesize($cv_path));
        readfile($cv_path);
        exit;
    } else {
        echo "File CV tidak ditemukan.";
    }
} else {
    echo "URL CV tidak valid.";
}
?>