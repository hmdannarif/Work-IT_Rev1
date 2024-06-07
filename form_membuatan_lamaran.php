<!DOCTYPE html>
<html>
<head>
    <title>Form Pembuatan Lamaran</title>
    <link rel="stylesheet" href="style/buat.css">
</head>
<body class="container">
    <div class="konten">
        <h2>Form Pembuatan Lamaran</h2>
        <div class="form">
            <form action="ProsesPembuatanLamaran.php" method="POST">
                <!-- <label for="namaLamaran">Nama Lamaran:</label><br> -->
                <input type="text" id="namaLamaran" name="namaLamaran" placeholder="Nama Lamaran"><br>
                <!-- <label for="tanggal_lamaran">Tanggal Lamaran:</label><br> -->
                <input type="date" id="tanggal_lamaran" name="tanggal_lamaran"><br>
                <!-- <label for="spesifikasi">Spesifikasi:</label><br> -->
                <textarea id="spesifikasi" name="spesifikasi" placeholder="Spesifikasi"></textarea><br><br>
                <!-- <label for="maxLamaran">Max Lamaran:</label><br> -->
                <input type="text" id="maxLamaran" name="Max_lamaran" placeholder="Maximal rekrutmen"><br>
                <input class="btn" type="submit" value="Buat Lamaran" name="buat_lamaran">
            </form>
        </div>
    </div>
</body>
</html>
