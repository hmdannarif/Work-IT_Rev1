<?php
session_start();

// Hancurkan semua sesi
session_destroy();

// Redirect ke halaman login atau halaman utama
header('Location: login.php');
exit();
?>