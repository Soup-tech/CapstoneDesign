<?php
    require '../includes/header.php';

?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <title>History Menu</title>
        <style>
            body { font: 14px sans-serif; }
		    .wrapper { width: 360px; padding: 20px; margin: 100px auto;}
            .history-menu { height: 700px; width: 1550px; border: 1px solid #4e4e4e; font: 16px Arial, Serif; overflow: auto; margin: 20px; float: left; }
            /* .menu-wrapper { width: 500px; border: 1px solid black; overflow: hidden; margin: 20px; } */
            .back { width: 150px; float: left; border: 1px solid grey; margin-left: 100px; text-align: center; }
            .alerts { width: 150px; float: left; border: 1px solid red; margin-left: 700px; text-align: center; }
            .medication-amount { width: 150px; border: 1px solid green; margin-left: 20px; text-align: center; overflow: hidden; float: left;  }
            .export { width: 150px; border: 1px solid blue; margin-left: 20px; text-align: center; overflow: hidden; float: left; }
        </style>
    </head>

    <body>
        <div class="history-menu">
            <!-- #TODO Interactive history menu -->
        </div>
        <div class="menu-wrapper">
            <div class="back">
                <a href="../">Back</a>
            </div>
            <div class="alerts">
                <a href="alerts.php">Alerts</a>
            </div>
            <div class="medication-amount">
                <a href="medication-amount.php">Medication Amount</a>
            </div>
            <div class="export">
                <a href="#export">Export</a>
            </div>
        </div>
    </body>
</html>