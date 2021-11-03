<?php 
    include '../includes/header.php';

    // Check if the user is logged in, if not redirect to the login page
    if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== True) {
        header("Location: /index.php");
        exit;
    }
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <title>Alerts</title>
        <meta charset="utf-8">
        <style>
            body { font: 14px sans-serif; }
            .alerts-menu { height: 700px; width: 1550px; border: 1px solid #4e4e4e; font: 16px Arial, Serif; overflow: auto; margin: 20px; float: left; }
            .back { width: 150px; float: left; border: 1px solid grey; margin-left: 100px; text-align: center; }
        </style>
    </head>

    <body>
        <div class="alerts-menu">
            <!-- #TODO Interactive alerts menu -->
        </div>
        <div class="back">
            <a href="/history/history-menu.php">Back</a>
        </div>
    </body>
</html>