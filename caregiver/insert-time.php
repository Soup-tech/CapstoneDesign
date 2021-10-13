<?php
    require '../includes/header.php';
    require_once '../includes/dbhandler.php';
    session_start();

    $name_err = $amount_err = "";

    if (isset($_POST['submit'])) {
        // Get POST request
        $amount = (int) $_POST['amount'];
        $day = $_POST['DOM'];
        $hour = $_POST['Hour'];
        $minute = $_POST['Minute'];

        // Creating correct format for datetime
        $year = date("Y");
        $month = date("m");

        // Convert named days to numerical dates
        $datetime = $year.'/'.$month.'/'.$day.' '.$hour.':'.$minute.':00.00';

        //// Error Handling
        // Name
        if (empty(trim($_POST['name']))) {
            $name_err = "Please enter a name";
        } else if (strlen(trim($_POST['name'])) > 100) {
            $name_err = "Name of Medication is too large";
        } else {
            $name = $_POST['name'];
        }

        // Amount
        if (empty(trim($_POST['amount']))) {
            $amount_err = "Please enter an amounnt";
        } else if ((int) $_POST['amount'] > 10) {
            $amount_err = "Too much medication";
        }

       
        // Prepare sql
        $sql = "INSERT INTO medicine (NAME,AMOUNT,TIME) VALUES ('$name','$amount','$datetime')";
        // echo $sql; // DEBUGGING

        if ($stmt = mysqli_prepare($conn,$sql)) {
            
            // Bind the variables
			mysqli_stmt_bind_param($stmt, "sss", $param_name,$param_amount,$param_datetime);

            // Set the variables
            $param_name = $name;
            $param_amount = $amount;
            $param_datetime = $datetime;

            // Execute
            if (mysqli_stmt_execute($stmt)) {
                echo "Success!";
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