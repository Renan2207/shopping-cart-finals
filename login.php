<?php
	session_start();
	require 'include/database.php';
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
	<style>
		<?php include 'css/style.css'; ?>
	</style>
</head>
<body>
<div class="container mt-4 mb-4">
	<i class="fas fa-store fa-2x"></i>
	<h3 class="d-inline"><b>Learn IT Easy Online Shop</b></h3>	
</div>
<?php if (isset($_SESSION['message'])) : ?>
    <div class="w-25 mx-auto text-center alert alert-<?php echo $_SESSION['messageType']?> alert-dismissible fade show" role="alert">
        <?php echo $_SESSION['message']; ?>
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">&times;</span>
        </button>
    </div>
    <?php unset($_SESSION['message']); unset($_SESSION['messageType']); ?>
<?php endif ?>  
<div class="d-flex align-items-center my-5">
        <div class="card mx-auto shadow-lg" style="width: 330px; border-radius: 10px;">
            <div class="card-header">
                <nav class="navbar navbar-expand-lg navbar-light mb-5 p-0" id="nav">
                    <a class="navbar-brand" href="index.php">
                        HOME
                    </a>
                    <div class="collapse navbar-collapse" id="navbarSupportedContent">
                        <ul class="navbar-nav ml-auto">
                            <li class="nav-item active">
                                <a class="nav-link" id="current" href="login.php">Sign In</a>
                        </ul>
                    </div>
                </nav>
                <h3>Sign In</h3>
                <p class="mb-4">Sign in to continue to our application</p>
                <form method="post" action="include/login-inc.php">
                    <input type="text" name="username" class="form-control mb-3" placeholder="username" required />
                    <input type="password" name="password" class="form-control mb-3" placeholder="Password" required />
                    <button class="btn btn-secondary btn-signin mb-5 w-100" name="submitBTN" type="submit">Sign in</button>
                </form>
            </div>
        </div>
    </div>
