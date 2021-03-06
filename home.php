<?php
    require 'includes/header.php';
    session_start();

    // Check if the user is logged in, if not redirect to the login page
    if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== True) {
        header("Location: index.php");
        exit;
    }

    //// Alert information ////    
    // Read and pull information into array
    $myFile = "raspberry-pi/quick_info.csv";
    $lines = file($myFile);
    $information = explode(",", $lines[1]);

    // Expected refill date
    $expected_refill_date = $information[0];

    // Previous information
    $previous_medication = $information[1];
    $previous_pushtime = $information[2];
    
    // Next information
    $next_medication = $information[3];
    $next_world = $information[4];
    $expected_pushtime = $information[5];
    
?>

<!DOCTYPE html>
<html lang="en">

    <head>
        <link rel="stylesheet" type="text/css" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
        <style>
            body {font: 20px sans-serif;
                background-image: url('includes/backr.jpg');    /* Testing adding a background image for the website */
            }
            .card {
                margin: 0 auto; 
                float: none; 
                margin-bottom: 10px;  }
                
            .wrapper { width: 300px; padding: 20px; margin: 100px auto; }
            /*.form-group { border: 5px outset red; background-color: lightblue; text-align: center;}*/
            a { color: inherit; text-decoration: none; }
            /*a:hover {color: red; } */ 
        </style>
    </head>
    <body>
    
        <div class="wrapper">
            <?php if (isset($_SESSION['caregiver'])): ?>
                    <div class="form-group">
                        <a href="caregiver/caregiver-menu.php">Caregiver Menu</a> 
                    </div>
            <?php endif ?>
            <div class="form-group">
                <a href="history/history-menu.php">History Menu</a>
            </div>
        </div>

        <?php
        echo '<div class="card bg-info border-dark mb-3" style=" max-width: 400px;"> 
        <b> Current Alerts</b> ';
            echo 'Expected Refill Date: '.$expected_refill_date;
            echo '<br>';
            echo '<br>';
            
            echo '<b>Quick History</b>';
            echo 'Previously Dispensed Medication: '.$previous_medication;
            echo '<br>';
            echo 'Push Time: '.$previous_pushtime;
            echo '<br>';
            echo '<br>';

            echo '<b>Expected</b>';
            echo 'Next Medication: '.$next_medication;
            echo '<br>';
            echo 'Day-Slot: '.$next_world;
            echo '<br>';
            echo 'Expected Dispense Time: '.$expected_pushtime;
            echo '<br>';            
        echo'</div>';        
        ?>
    </body>
</html>