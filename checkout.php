<?php 
	require 'include/header.php';
	unset($_SESSION['cart']);
	unset($_SESSION['cartItems']);
	$_SESSION['cart'] = 0;
?>
<style>
	<?php include 'css/style.css'; ?>
	footer {
		position: absolute;
		bottom: 0;
	    left: 0; 
	    width: 100%;
	    height: -100px;
	}
</style>
<a href="cart.php">
	<button type="button" class="btn btn-primary float-right">	
		<i class="fas fa-shopping-cart"></i> Cart <span class="badge badge-light"><?php echo $_SESSION['cart']; ?></span>
	</button>
</a>
<hr>
<h4 class="title mt-4 mb-3">Online Shopping is Successful!</h4>
<a href="index.php">
	<button type="submit" class="btn btn-danger" name="backBtn"><i class="fas fa-shopping-bag"></i> Continue </button>
</a>