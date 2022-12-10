<?php
	session_start();
	require 'database.php';
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8 (Without BOM)">
	<title>Shopping Cart</title>
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css">
	<link href="https://fonts.googleapis.com/css?family=Roboto+Condensed:300&display=swap" rel="stylesheet">
	<link href="https://fonts.googleapis.com/css?family=Oswald:600|PT+Serif&display=swap" rel="stylesheet">
	<link href="https://fonts.googleapis.com/css2?family=Abel&family=Anton&display=swap" rel="stylesheet">
	<script src="https://kit.fontawesome.com/8395324130.js" crossorigin="anonymous"></script>
</head>
<body>
	<div class="text-center mt-3">
		<?php if (isset($_SESSION['username'])) : ?>
			<a href="crud.php" class="text-dark text-decoration-none link"><?php echo $_SESSION['name']; ?></a>
			<a href="include/logout-inc.php" class="text-dark text-decoration-none link" onclick="return confirm('Are you sure want to Logout?')">Logout</a>
		<?php elseif (isset($_SESSION['name'])) : ?>
			<a href="account.php" class="text-dark text-decoration-none link"><?php echo $_SESSION['name']; ?></a>
			<a href="include/logout-inc.php" class="text-dark text-decoration-none link" onclick="return confirm('Are you sure want to Logout?')">Logout</a>
		<?php else : ?>
			<a href="login.php" class="text-dark text-decoration-none link">Sign In</a>
		<?php endif; ?>
	</div>
	<div class="container mt-4 mb-4">
		<i class="fas fa-store fa-2x"></i>
		<h3 class="d-inline"><b>Learn IT Easy Online Shop</b></h3>		