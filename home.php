<?php
    require 'includes/header.php';
    session_start();

    // Check if the user is logged in, if not redirect to the login page
    if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== True) {
        header("Location: index.php");
        exit;
    }
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <link rel="stylesheet" type="text/css" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
        <style>
            body {font: 20px sans-serif;}
            .wrapper { width: 300px; padding: 20px; margin: 100px auto; }
            /*.form-group { border: 5px outset red; background-color: lightblue; text-align: center;}*/
            a { color: inherit; text-decoration: none; }
            /*a:hover {color: red; } */ 
        </style>
    </head>
    <body>
        <div class="wrapper">
            <div class="form-group">
                <a href="caregiver/caregiver-menu.php">Caregiver Menu</a>
            </div>
            <div class="form-group">
                <a href="#system-settings">System Settings</a>
            </div>
            <div class="form-group">
                <a href="history/history-menu.php">History Menu</a>
            </div>
        </div>
    </body>
</html>