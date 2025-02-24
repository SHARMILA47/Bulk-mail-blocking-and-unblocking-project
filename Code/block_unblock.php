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

// Handle individual email blocking/unblocking
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = $_POST['action'];

    if ($action == 'block' || $action == 'unblock') {
        $email = $_POST['email'];
        $status = ($action == 'block') ? 'blocked' : 'unblocked';

        // Get the current password for the email
        $result = $conn->query("SELECT Password FROM details WHERE Mail='$email'");
        $row = $result->fetch_assoc();
        $currentPassword = $row['Password'] ?? null;

        if ($action == 'block') {
            // Change the password to a new value and save the old one
            $newPassword = 'bit_' . uniqid();
            $sql = "UPDATE details SET Password='$newPassword', previous_password='$currentPassword', status='$status' WHERE Mail='$email'";
        } else { // unblock
            if ($currentPassword) {
                // Revert to the previous password
                $sql = "UPDATE details SET Password=previous_password, status='$status' WHERE Mail='$email'";
            } else {
              //  echo "No previous password to revert to for: $email<br>";
                // Skip this email
                return; // Exit the current request and skip further processing
            }
        }

        if ($conn->query($sql) === TRUE) {
            echo "Email $status successfully for: $email<br>";
        } else {
           // echo "Error: " . $conn->error . "<br>";
        }
    }

    // Handle CSV for bulk blocking/unblocking
    if ($action == 'block_bulk' || $action == 'unblock_bulk') {
        $status = ($action == 'block_bulk') ? 'blocked' : 'unblocked';

        if (isset($_FILES['email_csv']['tmp_name'])) {
            $csvFile = fopen($_FILES['email_csv']['tmp_name'], 'r');
            while (($row = fgetcsv($csvFile)) !== FALSE) {
                $email = $row[0]; // Assuming email is in the first column of the CSV

                // Get the current password for the email
                $result = $conn->query("SELECT Password FROM details WHERE Mail='$email'");
                $currentRow = $result->fetch_assoc();
                $currentPassword = $currentRow['Password'] ?? null;

                if ($action == 'block_bulk') {
                    // Change the password to a new value and save the old one
                    $newPassword = 'bit_' . uniqid();
                    $sql = "UPDATE details SET Password='$newPassword', previous_password='$currentPassword', status='$status' WHERE Mail='$email'";
                } else { // unblock
                    if ($currentPassword) {
                        // Revert to the previous password
                        $sql = "UPDATE details SET Password=previous_password, status='$status' WHERE Mail='$email'";
                    } else {
                      //  echo "No previous password to revert to for: $email<br>";
                        // Skip this email
                        continue; // This is now inside a loop
                    }
                }

                if (!$conn->query($sql)) {
                   // echo "Error updating $email: " . $conn->error . "<br>";
                }
            }
            fclose($csvFile);
            //echo "Bulk $status operation completed!<br>";
        }
    }
}

$conn->close();
?>
