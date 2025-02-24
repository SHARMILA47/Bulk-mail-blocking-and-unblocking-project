<?php
$connect = mysqli_connect("localhost", "root", "", "mailportal") or die("Connection failed");

if (isset($_POST['Mail'])) {
    $Mail = mysqli_real_escape_string($connect, $_POST['Mail']); 
    $Password = mysqli_real_escape_string($connect, $_POST['Password']);
    $query = "SELECT * FROM details WHERE Mail='$Mail' AND Password='$Password'";
    $result = mysqli_query($connect, $query);

    if (mysqli_num_rows($result) == 1) {
        header('location:index.php');
        exit(); 
    } 
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="icon" href="bannari college logo.jpeg">
    <link rel="stylesheet" href="login.css">
</head>
<body>
    <div class="wrapper">
        <img src="bannari college logo.jpeg" alt="Bannari Amman Institute of Technology" class="logo">
        <form action="login.php" method="POST">
            <h1>Login</h1>
            <div class="input-box">
                <input type="text" name="Mail" placeholder="Enter Email Id" required>
            </div>
            <div class="input-box">
                <input type="password" name="Password" placeholder="Enter Password" required>
            </div>
            <div>
                <button type="submit" class="btn">Login</button>
            </div>
            <div class="register-link" style="text-align: center; margin-top: 20px;">
                <p>Login with your BIT account</p> <!-- Instruction for BIT account -->
            </div>
        </form>
    </div>
</body>
</html>
