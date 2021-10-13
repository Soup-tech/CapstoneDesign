<?php 
    include '../includes/header.php';
    include_once '../includes/dbhandler.php';

    /*
    // Check if the user is logged in, if not redirect to the login page
    if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== True) {
        header("Location: index.php");
        exit;
    }
    */
    $name = $name_err = "";
    $email = $email_err = "";
    $username = $username_err = "";
    $password = $password_err = "";
    $confirm_password = $confirm_password_err = "";

    // Form submit
    if ($_SERVER["REQUEST_METHOD"] == "POST") {

        // ======= Validate Form =======
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

        // Validate password
        if (empty(trim($_POST["password"]))) {
            $password_err = "Please enter a password";
        } elseif (strlen(trim($_POST["password"])) < 6) {
            $password_err = "Password must have at least 6 characters";
        } else {
            $password = trim($_POST["password"]);
        }

        // Validate confirm password
        if (empty(trim($_POST["confirm_password"]))) {
            $confirm_password_err = "Please confirm password";
        } else {
            $confirm_password = trim($_POST["confirm_password"]);
            if (empty($password_err) && ($password != $confirm_password)) {
                $confirm_password_err = "Passwords do not match";
            }
        }

        
        // Check for errors
        if (empty($name_err) && empty($email_err) && empty($username_err) && empty($password_err) && empty($confirm_password_err)) {
           $sql = "INSERT INTO accounts (name, username, email, password, caregiver) VALUES (?, ?, ?, ?, ?)";

            if ($stmt = mysqli_prepare($conn,$sql)) {
                // Bind 
                mysqli_stmt_bind_param($stmt,"sssss",$param_name,$param_username,$param_email,$param_password,$param_caregiver);
                
                $param_name = $name;
                $param_username = $username;
                $param_email = $email;
                $param_password = password_hash($password, PASSWORD_DEFAULT);
                $param_caregiver = 1;
                
                if (mysqli_stmt_execute($stmt)) {
                    echo "Works!";
                } else {
                    echo "Not works";
                }
                
                mysqli_stmt_close($stmt);
            }
        }

        mysqli_close($conn);
    }
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <title>Add Caregiver</title>
        <link rel="stylesheet" type="text/css" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
        <style>
            body { font: 14px sans-serif; }
            .wrapper{ width: 360px; padding: 20px; margin: 100px auto;}
        </style>
    </head>
    <body>
        <div class="wrapper">
            <h2>Create New Caregiver</h2>
            <p>Caregivers are able to add, remove and edit medication</p>
            <form action="<?php htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="POST">
                <div class="form-group">
                    <label>Name</label>
                    <input type="text" name="name" class="form-control <?php echo (!empty($name_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $name; ?>">
                    <span class="invalid-feedback"><?php echo $name_err; ?></span>
                </div>
                <div class="form-group">
                    <label>Email</label>
                    <input type="text" name="email" class="form-control <?php echo (!empty($email_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $email; ?>">
                    <span class="invalid-feedback"><?php echo $email_err; ?></span>
                </div>
                <div class="form-group">
                    <label>Username</label>
                    <input type="text" name="username" class="form-control <?php echo (!empty($username_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $username; ?>">
                    <span class="invalid-feedback"><?php echo $username_err; ?></span>
                </div>
                <div class="form-group">
                    <label>Password</label>
                    <input type="text" name="password" class="form-control <?php echo (!empty($password_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $password; ?>">
                    <span class="invalid-feedback"><?php echo $password_err; ?></span>
                </div>
                <div class="form-group">
                    <label>Confirm Password</label>
                    <input type="text" name="confirm_password" class="form-control <?php echo (!empty($confirm_password_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $confirm_password; ?>">
                    <span class="invalid-feedback"><?php echo $confirm_password_err; ?></span>
                </div>
                <div class="form-group">
                    <input type="submit" class="btn btn-primary" value="Submit">
                    <input type="reset" class="btn btn-secondary ml-2" value="Reset">
                </div> 
            </form> 
        </div>
    </body>
</html>