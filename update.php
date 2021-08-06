<?php
    include 'includes/header.php';
    include_once 'includes/dbhandler.php';
    
    $name = $name_err = "";
    $username = $username_err = "";
    $email = $email_err = "";
    $password = $password_err = "";
    $confirm_password = $confirm_password_err = "";

    // Check if the user is logged in, if not redirect to the login page
    if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== True) {
        header("Location: index.php");
        exit;
    }

    if ($_SERVER["REQUEST_METHOD"] == "POST") {

        // ======= Validate form =======
        // Validate name
        if (empty(trim($_POST["name"]))) {
            $name_err = "Please enter a name";
        } else if (!preg_match('/^[a-zA-z0-9_]+$/',trim($_POST["name"]))) {
            $name_err = "Names can only contain letters, numbers, and underscore";
        } else {
            $name = trim($_POST["name"]);
        }
        // Validate username
        if (empty(trim($_POST["username"]))) {
            $username_err = "Please enter a username";
        } else if (!preg_match('/^[a-zA-z0-9_]+$/',trim($_POST["username"]))) {
            $username_err = "Username can only contain letters, numbers, and underscore";
        } else {
            $username = trim($_POST["username"]);
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
        } else if (!preg_match('/^[a-zA-z0-9_]+$/',trim($_POST["password"]))) {
            $password_err = "Password can only contain letters, numbers, and underscore";
        } else if (strlen(trim($_POST["password"])) < 6) {
            $password_err = "Password must be more than 6 characters";
        } else {
            $password = $_POST["password"];
        }
        // Validate confirm password
        if (empty(trim($_POST["confirm_password"]))) {
            $confirm_password_err = "Please confrim your password";
        } else {
            $confirm_password = trim($_POST["confirm_password"]);
            if (($confirm_password != $password) && (!empty($password_err))) {
                $confirm_password_err = "Passwords do not match";
            }
        }

        // ======= Update Account =======
        // No errors
        if (empty($name_err) && empty($username_err) && empty($email_err) && empty($password_err) && empty($confrim_password_err)) {
            $sql = "UPDATE accounts SET name=?, username=?, email=?, password=? WHERE id=0";

            if ($stmt = mysqli_prepare($conn,$sql)) {
                // Bind
                mysqli_stmt_bind_param($stmt,"ssss",$param_name,$param_username,$param_email,$param_password);

                // Set params
                $param_name = $name;
                $param_username = $username;
                $param_email = $email;
                $param_password = password_hash($password,PASSWORD_DEFAULT);

                if (mysqli_stmt_execute($stmt)) {
                    header("Location: index.php");
                    exit;
                } else {
                    echo "An error occured";
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
        <title>Update Admin</title>
        <link rel="stylesheet" type="text/css" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
        <style>
            body { font: 14px sans-serif; }
		    .wrapper{ width: 360px; padding: 20px; margin: 100px auto;}
        </style>
    </head>
    <body>
        <div class="wrapper">
            <h2>Update Admin</h2>
            <p>Please fill out the form to update the admin account</p>
            <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="POST">
                <div class="form-group">
                    <label>Name</label>
                    <input type="text" name="name" class="form-control <?php echo (!empty($name_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $name; ?>">
                    <span class="invalid-feedback"><?php echo $name_err; ?></span>
                </div>
                <div class="form-group">
                    <label>Username</label>
                    <input type="text" name="username" class="form-control <?php echo (!empty($username_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $username; ?>">
                    <span class="invalid-feedback"><?php echo $username_err; ?></span>
                </div>
                <div class="form-group">
                    <label>Email</label>
                    <input type="text" name="email" class="form-control <?php echo (!empty($email_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $email; ?>">
                    <span class="invalid-feedback"><?php echo $email_err; ?></span>
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