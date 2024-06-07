
<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>login</title>
   <link href="style/login.css" rel="stylesheet">
   <!-- custom css file link  -->
   <?php
if(isset($message)){
   foreach($message as $message){
      echo '<div class="message" onclick="this.remove();">'.$message.'</div>';
      
   }
}
?>
</head>
<body>


   
<div class="form-container">

   <form action="ProsesLogin.php" method="post">
      <h3>login now</h3>
      <input type="user_name" name="user_name" required placeholder="enter name" class="box">
      <input type="password" name="user_password" required placeholder="enter password" class="box">
      <input type="submit" name="login" class="btn" value="login now">
      <p>don't have an account? <a href="register.php">register now</a></p>
      
   </form>

</div>

</body>
</html>