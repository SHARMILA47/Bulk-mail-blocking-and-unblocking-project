<!DOCTYPE html>
<html>
<head>
    <title>Blocked Emails</title>
    <link rel="icon" href="bannari college logo.jpeg">
    <link rel="stylesheet" type="text/css" href="view_blocked.css">
</head>
<body>
    <center>
        <h1>Blocked Emails</h1>
        <ul>
            <?php
            // Database connection
            $servername = "localhost";
            $username = "root";
            $password = "";
            $dbname = "mailportal";

            $conn = new mysqli($servername, $username, $password, $dbname);

            // Check connection
            if ($conn->connect_error) {
                die("Connection failed: " . $conn->connect_error);
            }

            // Query to fetch blocked emails
            $result = $conn->query("SELECT Mail FROM details WHERE status='blocked'");

            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    $email = $row['Mail'];
                    echo "<li>$email <form method='POST' action='block_unblock.php' style='display:inline;'>
                              <input type='hidden' name='email' value='$email'>
                              <button type='submit' name='action' value='unblock'>Unblock</button>
                          </form></li>";
                }
            } else {
                echo "<li>No blocked emails found.</li>";
            }

            $conn->close();
            ?>
        </ul>
        <a href="index.php">Back</a>
    </center>
</body>
</html>
