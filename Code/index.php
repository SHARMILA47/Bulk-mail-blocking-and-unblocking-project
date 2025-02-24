<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BIT Mail Block/Unblock Portal</title>
    <link rel="icon" href="bannari college logo.jpeg">
    <link rel="stylesheet" type="text/css" href="index.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script> <!-- jQuery Library -->
</head>
<body>
    <div class="container">
        <center><h1>BANNARI AMMAN INSTITUTE OF TECHNOLOGY</h1></center>
        
        <div class="section-wrapper">
            <h2>Block or Unblock an Individual Email</h2>
            <form id="individual-email-form">
                <input type="email" name="email" placeholder="Enter email" required>
                <div class="button-group">
                    <button type="button" onclick="submitIndividualAction('block')">Block</button>
                    <button type="button" onclick="submitIndividualAction('unblock')">Unblock</button>
                </div>
            </form>
            <div id="individual-result"></div> <!-- For displaying individual operation result -->
        </div>
        
        <div class="section-wrapper">
            <h2>Bulk Block/Unblock via CSV</h2>
            <form id="bulk-email-form" enctype="multipart/form-data">
                <input type="file" name="email_csv" accept=".csv" required>
                <div class="button-group">
                    <button type="button" onclick="submitBulkAction('block_bulk')">Block Bulk</button>
                    <button type="button" onclick="submitBulkAction('unblock_bulk')">Unblock Bulk</button>
                </div>
            </form>
            <div id="bulk-result"></div> <!-- For displaying bulk operation result -->
        </div>
        
        <center>
            <a href="view_blocked.php">View Blocked Emails</a>
            <span style="margin-left: 20px;"></span> <!-- Add some spacing -->
            <a href="login.php">Logout</a> <!-- Logout link -->
        </center>
    </div>

    <script>
        function submitIndividualAction(action) {
            var email = $('[name="email"]').val();
            $.post('block_unblock.php', { email: email, action: action }, function(response) {
                $('#individual-result').html(response);
            });
        }

        function submitBulkAction(action) {
            var formData = new FormData($('#bulk-email-form')[0]);
            formData.append('action', action);
            $.ajax({
                url: 'block_unblock.php',
                type: 'POST',
                data: formData,
                processData: false,
                contentType: false,
                success: function(response) {
                    $('#bulk-result').html(response);
                }
            });
        }
    </script>
</body>
</html>
