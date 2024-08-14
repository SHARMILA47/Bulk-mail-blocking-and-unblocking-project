<?php
    $connect=mysqli_connect("localhost","root","","mailportal") or die("Connection failed");
    if(isset($_POST['Mail']))
    {
        $Mail=mysqli_real_escape_string($connect, $_POST['Mail']); 
        $Password=mysqli_real_escape_string($connect, $_POST['Password']);
        $query="Select * from details where Mail='$Mail' and Password='$Password'";
        $result = mysqli_query($connect, $query);

        if(mysqli_num_rows($result) == 1)
        {
            header('location:dashboard.php');
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
    <link rel="stylesheet" href="style.css">
    <style>
        a{
            color:aquamarine;
        }
    </style>
</head>
<body>
    <div class="wrapper">
        <form action="login.php" method="POST">
            <h1>Login</h1>
            <div class="input-box">
                <input type="text" name="Mail" placeholder="Enter Email Id"required>
            </div>
            <div class="input-box">
                <input type="password" name="Password" placeholder="Enter Password"required>
            </div>
            <div class="remember-forgot">
                <label><input type="checkbox">Remember Me</label>
                <a href="#">Forgot Password</a>
            </div>
            <div>
                <button type="submit"class="btn">Login</button>
                <div class="register-link">
                    <center>
                     <a href="#">Login with your google account</a></p>
                    </center>
                </div>
            </div>
        </form>
    </div>
</body>
</html>
