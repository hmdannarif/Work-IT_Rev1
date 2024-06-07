
<!DOCTYPE html>
<html>
<head>
    <title>Form Pelamar</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <link rel="stylesheet" href="style/Tambah.css">
</head>
<body class="container">
    <div class="wrapper">
        <h1>Creative Pelamar Form</h1>
            <div class="konten">
                <form action="register_pembuat_lamaran.php" method="POST" enctype="multipart/form-data">  
                <input type="text" name="nama_tempat" placeholder="Nama Tempat" required>
                <input type="text" name="nama_perusahaan" placeholder="Nama Perusahaan" required><br>
                <label for="nama_lamaran">Logo Perusahaan:</label><br>
                <input type="file" name="photo" accept="image/jpeg, image/jpg, image/png" required>
                <input type="submit" name="pembuat_lamaran" value="Submit">
                </form>
            </div>
    </div>
</body>
</html>
