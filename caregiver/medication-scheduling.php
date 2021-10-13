<?php
    require '../includes/header.php';
    require_once '../includes/dbhandler.php';

    // Start session
    session_start();

    /*
    // Check if user is logged in
    if (!isset($_SESSION['loggedin']) && $_SESSION['loggedin'] !== True) {
        header("location: /index.php");
        exit;
    }
    */
?>
<!DOCTYPE html>
<link rel="stylesheet" type="text/css" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
<html lang="en">
<head>
        <link rel="stylesheet" type="text/css" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
        <style>
            body {font: 20px sans-serif;
                background-image: url('../includes/backr.jpg');    /* Testing adding a background image for the website */
            }
            .wrapper { width: 300px; padding: 20px; margin: 100px auto; }
            /*.form-group { border: 5px outset red; background-color: lightblue; text-align: center;}*/
            a { color: inherit; text-decoration: none; }
            /*a:hover {color: red; } */ 
            .card{
              width: 500;
              margin: 0 auto; /* Added */
              float: none; /* Added */
              padding: none;
              background: transparent;
              
            }
          
        </style>
 </head>

  <div class="card" >
  <div class="card border-dark mb-3" style="max-width: 18rem;">
    <div class="card-body" >
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
    </div>
 

</html>