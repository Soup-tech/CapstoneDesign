<?php
    require '../includes/header.php';
    require_once '../includes/dbhandler.php';
    session_start();

    if (isset($_POST['reset'])) {
        // Get POST request
        $day = $_POST['day'];
        $part = $_POST['part'];

        // Correct format
        $full_day = $day.'-'.$part;
        echo $full_day;
        // Prepare sql
        $sql = "UPDATE `medicine` SET `NAME`='',`AMOUNT`='',`TIME`='' WHERE `DAY-COUNT`='".$full_day."'";
        // echo $sql; // DEBUGGING

        if ($stmt = mysqli_prepare($conn,$sql)) {
            
            // Bind the variables
			mysqli_stmt_bind_param($stmt, "s", $param_full_day);

            // Set the variables
            $param_full_day =$full_day;

            // Execute
            if (mysqli_stmt_execute($stmt)) {
                echo "Success!";
            } else {
                echo "Did not successfully update";
            }

        } else {
            echo "Something went wrong";
        } 

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
        <form id="reset" method="POST">
            <label for="">Day Num.</label>
            <select name="day">
                <option value="1">1</option>
                <option value="2">2</option>
                <option value="3">3</option>
                <option value="4">4</option>
                <option value="5">5</option>
                <option value="6">6</option>
                <option value="7">7</option>
                <option value="8">8</option>
                <option value="9">9</option>
                <option value="10">10</option>
                <option value="11">11</option>
                <option value="12">12</option>
                <option value="13">13</option>
                <option value="14">14</option>
            </select>
            <br>
            <label for="">Part</label>
            <select name="part">
                <option value="1">AM</option>
                <option value="2">PM</option>
            </select>
            <br>
            <button type="submit" name="reset" class="btn btn-primary">Submit</button>
        </form>

    </body>

</html>