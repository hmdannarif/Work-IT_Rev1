<!DOCTYPE html>
<html>
<head>
<title>Form Daftar</title>
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="css/register.css" rel="stylesheet" type="text/css" media="all" />
<link href="//fonts.googleapis.com/css?family=Roboto:300,300i,400,400i,700,700i" rel="stylesheet">
<link href="style/register.css" rel="stylesheet">
</head>
<body>
    <div class="main-w3layouts wrapper">
        <h1>Creative SignUp Form</h1>
        <div class="main-agileinfo">
            <div class="agileits-top">
                <form action="ProsesRegister.php" method="POST">   
                    <fieldset>
                        <p>
                            
                            <input type="text" name="user_name" placeholder="user_name" />
                        </p>
                        <p>    
                            
                            <input type="text" name="Nama" placeholder="Nama" />
                        </p>
                        <p>
                            
                            <input type="text" name="user_Email" placeholder="Email" />
                        </p>
                        <p>
                            <input type="text" name="user_password" placeholder="Password" />
                        </p>
                        <p>
                            <label class="radio">Jenis User: </label>
                            <label><input type="radio" name="jenis_user" value="Pelamar"> Pelamar</label>
                            <label><input type="radio" name="jenis_user" value="Pembuat_lamaran"> Pembuat Lamaran</label>
                        </p>
                        <p>
                            
                            <input type="text" name="User_telepon" placeholder="Telepon" />
                        </p>
                        <p>
                            <input type="submit" value="submit" name="daftar" />
                        </p>
                    </fieldset>
                    <p>Have an account? <a href="login.php">Login now</a></p>
                </form>
            </div>
        </div>
    </div>
</body>
</html>
