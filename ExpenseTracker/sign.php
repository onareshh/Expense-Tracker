<?php
session_start();
$success = 0;
$user = 0;

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    include 'connect.php';
    $username = $_POST['username'];
    $password = $_POST['password'];
  // Get the selected role from the form

    $sql = "SELECT * FROM `registration` WHERE username='$username'";

    $result = mysqli_query($con, $sql);
    if ($result) {
        $num = mysqli_num_rows($result);
        if ($num > 0) {
            $user = 1;
        } else {
            $sql = "INSERT INTO `registration` (username, password) VALUES ('$username', '$password')";
            $result = mysqli_query($con, $sql);
            if ($result) {
                $success = 1;
            } else {
                die(mysqli_error($con));
            }
        }
    }
}
?>

  <!doctype html>
  <html lang="en">
    <head>
      <!-- Required meta tags -->
      <meta charset="utf-8">
      <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

      <!-- Bootstrap CSS -->
      <link rel="stylesheet" href="signcss.css">

      <title>Expense Tracker Signup</title>
    </head>
    <body>

    <?php
    if($user){
      echo '<div class="alert alert-danger alert-dismissible fade show" role="alert">
      <strong>Ohh noo Sorry </strong> User Already Exits
      <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">&times;</span>
      </button>
    </div>';
    }
    ?>
   <?php
   if($success){
    $_SESSION['username'] = $username;
    header("Location: index2.php");
    exit();
   }?>


    <center>
      <h1 class="title">Expense Tracker </h1>
    </center>
      
      <section class="container">
        <form  id="form" method="post">
            <div class="formLine">
                <label for="username">Username: </label>
                 <input type="text" id="username" name="username" required>
            </div>
            <div class="formLine">
                <label for="password">Password: </label>
                <input type="password" id="password" name="password" pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}" title="Must contain at least one number and one uppercase and lowercase letter, and at least 8 or more characters" required>
            </div>
            <button type="submit"> Signup</button>
        </form>
        <p>Already have an Account? </p>
        <a href="login.php" id="login">Login</a>
    </section>
      

    
    
      
    </body>
  </html>
