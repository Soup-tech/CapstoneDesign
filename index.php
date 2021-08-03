 <?php
	require 'includes/header.php';
	require_once 'includes/dbhandler.php';

	// Start session
	session_start();

	// Check if user is already logged in
	if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == True) {
		header("location: home.php");
		exit;
	}

	$username = "";
	$password = "";
	$username_err = $password_err = $login_err = "";


	// Process data when form is submitted
	if ($_SERVER['REQUEST_METHOD'] == "POST") {

		// Check if creds are empty
		if (empty(trim($_POST['username']))) {
			$username_err = "Please enter a username";
		} else {
			$username = trim($_POST['username']);
		}
		if (empty(trim($_POST['password']))) {
			$password_err = "Please enter a password";
		} else {
			$password = trim($_POST['password']);
		}
		
		// Check if creds are valid
		if (empty($username_err) && empty($password_err)) {
			// Prepare sql query
			$sql = "SELECT id,username,password FROM accounts WHERE username=?";

			if ($stmt = mysqli_prepare($conn,$sql)) {
				// Bind the variables
				mysqli_stmt_bind_param($stmt, "s", $param_username);

				// Set parameters
				$param_username = $username;

				// Execute
				if (mysqli_stmt_execute($stmt)) {
					// Store results
					mysqli_stmt_store_result($stmt);

					// Check if username exists
					if (mysqli_stmt_num_rows($stmt) == 1) {
						mysqli_stmt_bind_result($stmt, $id, $username, $hashed_password);

						if (mysqli_stmt_fetch($stmt)) {
							if (password_verify($password, $hashed_password)) {
								
								// *Potential* First time login
								if ($username == "admin" && $password == "admin2021") { 
									$sql = "SELECT id,username,password FROM accounts WHERE username=?";
									header("Location: update.php");
								} else {
									// Password is correct
									session_start();

									$_SESSION["loggedin"] = True;
									$_SESSION['id'] = $id;
									$_SESSION['username'] = $username;

									header("Location: home.php");
								}

							} else {
								$login_err = "Invalid username or password";
							}
						}
					} else {
						$login_err = "Invalid username or password";
					}
				} else {
					echo "Something went wrong :C";
				}

				// Close
				mysqli_stmt_close($stmt);
			}
		}
		mysqli_close($conn);
	}
?> 

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Welcome!</title>
	<link rel="stylesheet" type="text/css" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
	<style>
		body { font: 14px sans-serif; }
		.wrapper{ width: 360px; padding: 20px; margin: 100px auto;}
	</style>
</head>
<body>
	<div class="wrapper">
		<h2>Login</h2>
		<p>Please fill in your credentials to login</p>

		<?php
		if (!empty($login_err)) {
			echo '<div class="alert alert-danger">'.$login_err.'</div>';
		}
		?>

		<form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
			<div class="form-group">
				<label>Username</label>
				<input type="text" name="username" class="form-control <?php echo (!empty($username_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $username; ?>">
				<span class="invalid-feedback"><?php echo $username_err; ?></span>
			</div>
			<div class="form-group">
				<label>Password</label>
				<input type="password" name="password" class="form-control <?php echo (!empty($password_err)) ? 'is-invalid' : ''; ?>">
				<span class="invalid-feedback"><?php echo $password_err; ?></span>
			</div>
			<div class="form-group">
				<input type="submit" class="btn btn-primary" value="Login">
			</div>

		</form>

	</div>

</body>