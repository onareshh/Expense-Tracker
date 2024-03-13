<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    include 'connect.php';
    $username = $_POST['username'];
    $password = $_POST['password'];

    $sql = "SELECT * FROM `registration` WHERE username='$username' AND password='$password'";
    $result = mysqli_query($con, $sql);
    if ($result) {
        $num = mysqli_num_rows($result);
        if ($num > 0) {
            $_SESSION['username'] = $username;
            header("Location: index2.php");
            exit();
        }
    }
}
?>





<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Expense Tracker Login</title>
    <link rel="stylesheet" href="log.css">
</head>
<body>
    <center>
        <h1 class="title">Expense Tracker </h1>
    </center>

    <section class="container">
        <form action="" method="POST" id="form"> <!-- Added method="POST" to the form -->
            <div class="formLine">
                <label for="username">Username: </label>
                <input type="text" id="username" name="username" required>
            </div>
            <div class="formLine">
                <label for="password">Password: </label>
                <input type="password" id="password" name="password" pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}" title="Must contain at least one number and one uppercase and lowercase letter, and at least 8 or more characters" required>
            </div>
            <button type="submit"> Login</button>
        </form>
        <p>
            Don't have an account?
        </p>
        <a href="sign.php">
            Create one
        </a>
    </section>
</body>
</html>
