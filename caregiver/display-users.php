<?php

    require '../includes/header.php';
    require '../includes/dbhandler.php';

    // Mode
    // Display = 1; Edit = 0
    $mode = 1;
    if (isset($_POST['edit'])) {
        $mode = 0;
    }

    // Check if the user is logged in, if not redirect to the login page
    if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== True) {
        header("Location: /index.php");
        exit;
    } else if (!isset($_SESSION['caregiver'])) { // Ensure users cannot access caregiver menus
        header("Location: /home.php");
        exit;
    }

    // Ensure that there is at least one user
    $sql = "SELECT * FROM accounts WHERE caregiver=0";
    $results = mysqli_query($conn,$sql);
    $rowcount = mysqli_num_rows($results);

    // No users in the database. Redirect to create a user
    if ($rowcount == 0) {
        header('Location: create-user.php');
    }

    // Updating information
    if (isset($_POST['confirm'])) {
        $name = $name_err = "";
        $email = $email_err = "";
        $username = $username_err = "";

        // Validate name
        if (empty(trim($_POST["name"]))) {
            $name_err = "Please enter a name";
        } else {
            $name = trim($_POST["name"]);
        }

        // Validate username
        if (empty(trim($_POST["username"]))) {
            $username_err = "Please enter a username";
        } elseif (!preg_match('/^[a-zA-z0-9_]+$/',trim($_POST["username"]))) {
            $username_err = "Username can only contain letters, numbers, and underscore";
        } else {
            // Prepare sql
            $sql = "SELECT username FROM accounts WHERE username=?";

            if ($stmt = mysqli_prepare($conn, $sql)) {
                // Bind variables for sql statement
                mysqli_stmt_bind_param($stmt, "s", $param_username);

                // Set params
                $param_username = trim($_POST["username"]);

                // Execute sql 
                if (mysqli_stmt_execute($stmt)) {
                    mysqli_stmt_store_result($stmt);

                    if (mysqli_stmt_num_rows($stmt) == 1) {
                        $username_err = "Username is already taken";
                    } else {
                        $username = trim($_POST["username"]);
                    }
                } else {
                    echo "Something went wrong";
                }
                mysqli_stmt_close($stmt);
            }
        }

        // Validate email
        if (empty(trim($_POST["email"]))) {
            $email_err = "Please enter an email";
        } else if (!filter_var($_POST["email"], FILTER_VALIDATE_EMAIL)) {
            $email_err = "Invalid email format";
        } else {
            $email = trim($_POST["email"]);
        }

        // Check for errors
        if (empty($name_err) && empty($email_err) && empty($username_err)) {
            $sql = "UPDATE `accounts` SET `name`=?,`username`=?,`email`=? WHERE caregiver=0";
 
             if ($stmt = mysqli_prepare($conn,$sql)) {
                 // Bind 
                 mysqli_stmt_bind_param($stmt,"sss",$param_name,$param_username,$param_email);
                 
                 $param_name = $name;
                 $param_username = $username;
                 $param_email = $email;
                 
                 
                 if (mysqli_stmt_execute($stmt)) {
                     exit;
                 } else {
                     echo "Something went wrong";
                 }
                 
                 mysqli_stmt_close($stmt);
             }
         }

    }

?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <link rel="stylesheet" type="text/css" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
        <style>
            body {font: 20px sans-serif;
                background-image: url('../includes/backr.jpg');}
            .wrapper { width: 300px; padding: 20px; margin: 100px auto; }
            /*.form-group { border: 5px outset red; background-color: lightblue; text-align: center;}*/
            a { color: inherit; text-decoration: none; }
            /*a:hover {color: red; } */ 
        </style>
    </head>
    <body>

        <!-- Should only be one user -->
        <?php if ($mode): ?>
            <?php
                $sql = "SELECT * FROM accounts WHERE caregiver=0";
                $results = mysqli_query($conn,$sql);
                $row = mysqli_fetch_assoc($results);
                echo '
                    <div class="placeholder">
                        <form id="info" method="POST">
                            <label for="">Name</label>
                            <p>'.$row['name'].'</p>
                            <label for="">Username</label>
                            <p>'.$row['username'].'</p>
                            <label for="">Email</label>
                            <p>'.$row['email'].'</p>
                            <button type="submit" name="edit" class="btn btn-danger btn-lg">Edit</button>                 
                        </form>
                    </div>
                ';    
            ?>
        <?php else: ?>
            <?php
                $sql = "SELECT * FROM accounts WHERE caregiver=0";
                $results = mysqli_query($conn,$sql);
                $row = mysqli_fetch_assoc($results);
                echo '
                    <div class="placeholder">
                        <form id="info" method="POST">
                            <label for="">Name</label>
                            <input type="text" name="name" value='.$row['name'].'>
                            <br>
                            <label for="">Username</label>
                            <input type="text" name="username" value='.$row['username'].'>
                            <br>
                            <label for="">Email</label>
                            <input type="text" name="email" value='.$row['email'].'>
                            <br>
                            <button type="submit" name="confirm" class="btn btn-danger btn-lg">Confirm</button>
                        </form>
                    </div>
                
                ';
            ?>
        <?php endif ?>
    </body>
</html>