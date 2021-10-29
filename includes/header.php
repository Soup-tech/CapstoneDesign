<?php session_start() ?>

<!DOCTYPE html>
<html lang="en">
	<head>
		<link rel="stylesheet" type="text/css" href="/css/header.css" />
	</head>

	<body>
		<div class="header">
			<a href="#default" class="logo">Our_Logo</a>
			<div class="header-right">
				
				<?php 
					if (isset($_SESSION['loggedin'])): ?>
						<a class='navigation-link' href='/home.php'>Home</a>
						<a class='navigation-link' href='/logout.php'>Logout</a>
					<?php else: ?>
						<a class='navigation-link' href='/index.php'>Login</a>
					<?php endif ?>
				<a href="/about-us.php">About</a>
			</div>
		</div>
	</body>

</html>