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
                background-image: url('includes/backr.jpg');    /* Testing adding a background image for the website */
            }
            .wrapper { width: 300px; padding: 20px; margin: 100px auto; }
            /*.form-group { border: 5px outset red; background-color: lightblue; text-align: center;}*/
            a { color: inherit; text-decoration: none; }
            /*a:hover {color: red; } */ 
        </style>
 </head>
// First row of cards 
<div class="card-group">
  <div class="card">
    <div class="card-body">
      //PLACE CARD CONTENT IN THESE SPACES
      
    </div>
  </div>
  <div class="card">
    <div class="card-body">
      
      
    </div>
  </div>
  <div class="card">
    <div class="card-body">
      
      
    </div>
  </div>
</div>
//Second Row of Cards
<div class="card-group">
  <div class="card">
    <div class="card-body">
      
      
    </div>
  </div>
  <div class="card">
    <div class="card-body">
      
      
    </div>
  </div>
  <div class="card">
    <div class="card-body">
      
      
    </div>
  </div>
</div>
//Third Row of Cards
<div class="card-group">
  <div class="card">
    <div class="card-body">
     
      
    </div>
  </div>
  <div class="card">
    <div class="card-body">
      
      
    </div>
  </div>
  <div class="card">
    <div class="card-body">
     
    </div>
  </div>
</div>
//Fourth Row of cards
<div class="card-group">
  <div class="card">
    <div class="card-body">
      

    </div>
  </div>
  <div class="card">
    <div class="card-body">
      

    </div>
  </div>
  <div class="card">
    <div class="card-body">
      

    </div>
  </div>
</div>

<div class="card-group">
  <div class="card">
    <div class="card-body">
     

    </div>
  </div>
  <div class="card">
    <div class="card-body">
     

    </div>
  </div>
  <div class="card">
    <div class="card-body">
     

    </div>
  </div>
</div>


        

</html>