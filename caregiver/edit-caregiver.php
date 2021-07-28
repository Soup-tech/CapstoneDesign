<?php
    require '../includes/header.php';
    require_once '../includes/dbhandler.php';

    // Start session
    session_start();

    // Check if user is logged in
    if (!isset($_SESSION['loggedin']) && $_SESSION['loggedin'] !== True) {
        header("location: index.php");
        exit;
    }
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <title>Edit Caregivers</title>
        <style>
            
		    body { font: 14px sans-serif; }
		    /* .wrapper{ width: 360px; padding: 20px; margin: 100px auto;} */
            div.caregivers { height:100px;width:180px;border:1px solid #4e4e4e;font:16px Arial, Serif;overflow:auto; }
        </style>
    </head>

    <body>
        <div class="wrapper">
            <section>
                <div class="caregivers">

                </div>
            </section>
        </div>
    </body>
</html>
