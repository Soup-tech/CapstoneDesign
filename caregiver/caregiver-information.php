<?php
    include "../includes/header.php";
    include_once "../includes/dbhandler.php";

    // Check if the user is logged in, if not redirect to the login page
    if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== True) {
        header("Location: /index.php");
        exit;
    } else if (!isset($_SESSION['caregiver'])) { // Ensure users cannot access caregiver menus
        header("Location: /home.php");
        exit;
    }

?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <title>Caregiver Information</title>
        <style>
            body {font: 20px sans-serif;}
            .wrapper { width: 300px; padding: 20px; margin: 100px auto; }
        </style>

    </head>
    <body>
        <div class="wrapper">
            <!-- Profile picture maybe???? -->
            <div class="information-wrapper">


            </div>
        </div>
    </body>

</html>