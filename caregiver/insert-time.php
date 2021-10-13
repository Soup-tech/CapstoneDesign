<?php
    require '../includes/header.php';
    session_start();

    if (isset($_POST['submit'])) {
        $name = $_POST['name'];
        $amount = $_POST['amount'];
        $day = $_POST['DOM'];
        $hour = $_POST['Hour'];
        $minute = $_POST['Minute'];

        // Creating correct format for datetime
        $year = (string) date("Y");
        $month = (string) date("m");
        $day = (string) $day;
        $hour = (string) $hour;
        $minute = (string) $minute;

        // Convert named days to numerical dates
        
        $datetime = $year + '-' + $month + '-' + $day + ' ' + $hour + ': ' + $minute + ': 00.00';
        echo $datetime;
        
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
        <form id="Dispatch-Time" method="POST">
            <label for="">Medication Name</label>
            <input type="text" name="name" class="form-control">
            <label for="">Amount</label>
            <input type="text" name="amount" class="form-control">
            <select name="DOM">
                <option value="01">01</option>
                <option value="02">02</option>
                <option value="03">03</option>
                <option value="04">04</option>
                <option value="05">05</option>
            </select>
            <select name="Hour">
                <option value="00">00</option>
                <option value="01">01</option>
                <option value="02">02</option>
                <option value="03">03</option>
            </select>
            <select name="Minute">
                <option value="00">00</option>
                <option value="01">01</option>
                <option value="02">02</option>
                <option value="03">03</option>
            </select>
            <button type="submit" name="submit" class="btn btn-primary">Submit</button>
        </form>

    </body>

</html>