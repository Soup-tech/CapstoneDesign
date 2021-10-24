<?php
    require '../includes/header.php';
    require_once '../includes/dbhandler.php';
    session_start();

    $name_err = $amount_err = "";

    // Submission 
    if (isset($_POST['submit'])) { // Updating information
        // Get POST request
        $day_count = $_POST['Day-Count'];
        $part = $_POST['Day-Count-Part'];
        $hour = $_POST['Hour'];
        $minute = $_POST['Minute'];

        // Convert named days to numerical dates
        $datetime = $hour.':'.$minute;

        // Format for which day-part
        $full_day_count = $day_count.'-'.$part;

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
            $amount_err = "Please enter an amount";
        } else if ((int) $_POST['amount'] > 10) {
            $amount_err = "Too much medication";
        } else {
            $amount = $_POST['amount'];
        }

        // Prepare sql statement
        $sql = "UPDATE `medicine` SET `NAME`='".$name."',`AMOUNT`=".$amount.",`TIME`='".$datetime."' WHERE `DAY-COUNT`='".$full_day_count."'";
        // echo $sql; // DEBUGGING

        if ($stmt = mysqli_prepare($conn,$sql)) {
            
            // Bind the variables
			mysqli_stmt_bind_param($stmt, "ssss", $param_name,$param_amount,$param_datetime,$param_full_day_count);

            // Set the variables
            $param_name = $name;
            $param_amount = $amount;
            $param_datetime = $datetime;
            $param_full_day_count = $full_day_count;

            // Execute
            if (mysqli_stmt_execute($stmt)) {
                echo "Success!";
            }

        } else {
            echo "Something went wrong";
        }
        
    } else if (isset($_POST['reset'])) { // Clearing medication
        // Get POST request
        $day = $_POST['day'];
        $part = $_POST['part'];

        // Correct format
        $full_day = $day.'-'.$part;

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
                // echo "Success!"; // DEBUG
                return;
            } else {
                echo "Did not successfully update";
                return;
            }

        } else {
            echo "Something went wrong";
        } 
    }

    
?>

<!DOCTYPE html>
<link rel="stylesheet" type="text/css" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
<html lang="en">

<head>
    <link rel="stylesheet" type="text/css"
        href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
    body {
        font: 20px sans-serif;
        background-image: url('../includes/backr.jpg');
        /* Testing adding a background image for the website */
    }

    .wrapper {
        width: 300px;
        padding: 20px;
        margin: 100px auto;
    }

    /*.form-group { border: 5px outset red; background-color: lightblue; text-align: center;}*/
    a {
        color: inherit;
        text-decoration: none;
    }

    /*a:hover {color: red; } */
    .card {
        width: 300;
        margin: 0 auto; 
        /* Added */
        float: none;
        /* Added */
        padding: none;
        background: transparent;

    }
    </style>
</head>


<div class="card">
    <div class="card border-dark mb-3" style="max-width: 18rem;">
        <div class="card-body">
            <form id="Dispatch-Time" method="POST">
                <label for="">Medication Name</label>
                <input type="text" name="name" class="form-control">
                <label for="">Amount</label>
                <input type="text" name="amount" class="form-control">
                <select name="Day-Count">
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
                <select name="Hour">
                    <option value="00">00</option>
                    <option value="01">01</option>
                    <option value="02">02</option>
                    <option value="03">03</option>
                    <option value="04">04</option>
                    <option value="05">05</option>
                    <option value="06">06</option>
                    <option value="07">07</option>
                    <option value="08">08</option>
                    <option value="09">09</option>
                    <option value="10">10</option>
                    <option value="11">11</option>
                    <option value="12">12</option>
                </select>
                <select name="Minute">
                    <option value="00">00</option>
                    <option value="01">01</option>
                    <option value="02">02</option>
                    <option value="03">03</option>
                    <option value="04">04</option>
                    <option value="05">05</option>
                    <option value="06">06</option>
                    <option value="07">07</option>
                    <option value="08">08</option>
                    <option value="09">09</option>
                    <option value="10">10</option>
                    <option value="11">11</option>
                    <option value="12">12</option>
                    <option value="13">13</option>
                    <option value="14">14</option>
                    <option value="15">15</option>
                    <option value="16">16</option>
                    <option value="17">17</option>
                    <option value="18">18</option>
                    <option value="19">19</option>
                    <option value="20">20</option>
                    <option value="21">21</option>
                    <option value="22">22</option>
                    <option value="23">23</option>
                    <option value="24">24</option>
                    <option value="25">25</option>
                    <option value="26">26</option>
                    <option value="27">27</option>
                    <option value="28">28</option>
                    <option value="29">29</option>
                    <option value="30">30</option>
                    <option value="31">31</option>
                    <option value="32">32</option>
                    <option value="33">33</option>
                    <option value="34">34</option>
                    <option value="35">35</option>
                    <option value="36">36</option>
                    <option value="37">37</option>
                    <option value="38">38</option>
                    <option value="39">39</option>
                    <option value="40">40</option>
                    <option value="41">41</option>
                    <option value="42">42</option>
                    <option value="43">43</option>
                    <option value="44">44</option>
                    <option value="45">45</option>
                    <option value="46">46</option>
                    <option value="47">47</option>
                    <option value="48">48</option>
                    <option value="49">49</option>
                    <option value="50">50</option>
                    <option value="51">51</option>
                    <option value="52">52</option>
                    <option value="53">53</option>
                    <option value="54">54</option>
                    <option value="55">55</option>
                    <option value="56">56</option>
                    <option value="57">57</option>
                    <option value="58">58</option>
                    <option value="59">59</option>
                </select>
                <select name="Day-Count-Part">
                    <option value="1">AM</option>
                    <option value="2">PM</option>
                </select>

                <button type="submit" name="submit" class="btn btn-primary">Submit</button>
            </form>
        </div>
    </div>
</div>

<div class="card">
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
</div>

<div class="container">
    <div class="row">
        <?php
            $display_sql = "SELECT * FROM medicine";
            $results = mysqli_query($conn, $display_sql);
            
            for ($i=1; $i < 8; $i++) {
                $row = mysqli_fetch_assoc($results);
                $next_row = mysqli_fetch_assoc($results);
                echo '
                <div class="col-md">
                    <div class="card" >
                        <p>Day '.$i.'</p>
                        <br>
                        <p>Name: '.htmlspecialchars($row['NAME'],ENT_QUOTES,'UTF-8').'</p>
                        <p>Amount: '.htmlspecialchars($row['AMOUNT'],ENT_QUOTES,'UTF-8').'</p>
                        <p>Time: '.htmlspecialchars($row['TIME'],ENT_QUOTES,'UTF-8').'</p>
                        <br>
                        <p>Name: '.htmlspecialchars($next_row['NAME'],ENT_QUOTES,'UTF-8').'</p>
                        <p>Amount: '.htmlspecialchars($next_row['AMOUNT'],ENT_QUOTES,'UTF-8').'</p>
                        <p>Time: '.htmlspecialchars($next_row['TIME'],ENT_QUOTES,'UTF-8').'</p>
                    </div>
                </div>
                ';
            }
        ?>
    </div>

    <div class="row">
        <?php

            for ($i=8; $i < 15; $i++) {
                $row = mysqli_fetch_assoc($results);
                $next_row = mysqli_fetch_assoc($results);
                echo '
                <div class="col-md">
                    <div class="card" >
                        <p>Day '.$i.'</p>
                        <p>Name: '.htmlspecialchars($row['NAME'],ENT_QUOTES,'UTF-8').'</p>
                        <p>Amount: '.htmlspecialchars($row['AMOUNT'],ENT_QUOTES,'UTF-8').'</p>
                        <p>Time: '.htmlspecialchars($row['TIME'],ENT_QUOTES,'UTF-8').'</p>
                        <br>
                        <p>Name: '.htmlspecialchars($next_row['NAME'],ENT_QUOTES,'UTF-8').'</p>
                        <p>Amount: '.htmlspecialchars($next_row['AMOUNT'],ENT_QUOTES,'UTF-8').'</p>
                        <p>Time: '.htmlspecialchars($next_row['TIME'],ENT_QUOTES,'UTF-8').'</p>
                    </div>
                </div>
                ';
            }
        ?>
    </div>
</div>
</div>




</html>