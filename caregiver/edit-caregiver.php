<?php
    require '../includes/header.php';
    require_once '../includes/dbhandler.php';

    // Start session
    session_start();

    // Check if user is logged in
    if (!isset($_SESSION['loggedin']) && $_SESSION['loggedin'] !== True) {
        header("location: /index.php");
        exit;
    }
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>Edit Caregivers</title>
    <style>
    body {
        font: 14px sans-serif;
    }

    /* .wrapper{ width: 360px; padding: 20px; margin: 100px auto;} */
    div.caregivers {
        height: 700px;
        width: 700px;
        border: 1px solid #4e4e4e;
        font: 16px Arial, Serif;
        overflow: auto;
        margin: 20px;
        float: left;
    }

    div.caregiver-options {
        margin-left: 50%;
        width: 300px;
        padding: 20px; 
    }

    div.caregiver-info {
        background-color: lightgray;
        border: 3px black;
        font-weight: bold;
        padding: 10px;
    }

    .form-group { 
        border: 5px outset red; 
        background-color: lightblue; 
        text-align: center;
    }
    a { 
        color: inherit; 
        text-decoration: none; 
    }
    a:hover {
        color: red; 
    }
    </style>
</head>

<body>
    <div class="wrapper">
        <section>
            <div class="caregivers">
                <?php 
                    $sql = "SELECT username,email FROM accounts WHERE caregiver=1";
                    $result = mysqli_query($conn,$sql);
                    while ($row = mysqli_fetch_array($result)) {
                        echo '<div id="caregiver-info" class="caregiver-info">
                                <div class="caregiver-name">
                                    <p>'.htmlspecialchars($row["username"]).'</p>
                                </div>                
                                <div class="caregiver-email">
                                    <p>'.htmlspecialchars($row["email"]).'</p>
                                </div>
                              </div>';
                    }
                ?>
            </div>
        </section>

        <div class="caregiver-options">
            <form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
                <div class="form-group">
                    <a href="#add-caregiver">Add Caregiver</a>
                </div>
                <div class="form-group">
                    <a href="#edit-caregiver">Edit Caregiver</a>
                </div>
                <div class="form-group">
                    <a href="#remove-caregiver">Remove Caregiver</a>
            </form>
        </div>
    </div>
</body>
</html>