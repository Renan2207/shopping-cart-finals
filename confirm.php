<?php require 'include/header.php'?>
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
<h4 class="title mt-4 mb-3">Product Successfull Added to Cart, what do you want to do next?</h4>
<a href="cart.php" class="text-decoration-none">
	<button type="submit" class="btn btn-secondary" name="confirmBtn"><i class="fas fa-shopping-cart"></i></i> View Cart</button>  
</a>
<a href="index.php" class="text-decoration-none">
	<button type="submit" class="btn btn-danger" name="backBtn"><i class="fas fa-shopping-bag"></i> Continue Shopping</button>
</a>