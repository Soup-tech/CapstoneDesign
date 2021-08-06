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
    <link rel="stylesheet" type="text/css"
        href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
    body {
        font: 20px sans-serif;
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
        margin-left: 65%;
        margin-top: 10%;
        width: 300px;
        padding: 20px;
        border: 3px black;
    }

    div.caregiver-info {
        background-color: lightgray;
        border: 3px black;
        font-weight: bold;
        padding: 10px;
    }

    a {
        color: inherit;
        text-decoration: none;
    }
    </style>
</head>

<body>
    <div class="wrapper">
            <form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
                <div class="caregivers">
                    <?php 
                        $sql = "SELECT name,username,email FROM accounts WHERE caregiver=1";
                        $result = mysqli_query($conn,$sql);
                        while ($row = mysqli_fetch_array($result)) {
                            echo '<div class="caregiver-info">
                                    <div class="form-group">
                                        <p>Name: '.htmlspecialchars($row["name"]).'</p>
                                    </div>                
                                    <div class="form-group">
                                        <p>Username: '.htmlspecialchars($row["username"]).'</p>
                                    </div>
                                    <div class="form-group">
                                        <p>Email: '.htmlspecialchars($row["email"]).'</p>
                                    </div>
                                    <input type="radio" class="input-group-lg">
                                </div>';
                        }
                    ?>
                </div>
    
                <div class="caregiver-options">
                    <div class="form-group">
                        <a href="/caregiver/add-caregiver.php">Add Caregiver</a>
                    </div>
                    <div class="form-group">
                        <a href="#edit-caregiver">Edit Caregiver</a>
                    </div>
                    <div class="form-group">
                        <a href="#remove-caregiver">Remove Caregiver</a>
                    </div>
                </div>
            </form>
    </div>
</body>

</html>