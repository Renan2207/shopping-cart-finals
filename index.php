<?php 
	require 'include/header.php'; 
	ob_start(); 
	header('Cache-Control: no cache');
	if (!isset($_SESSION['cart'])) {
		$_SESSION['cart'] = 0; 
	}
?>
<style>
<?php include 'css/style.css'; ?>
</style>
<a href="cart.php">
	<button type="button" class="btn btn-primary float-right">	
		<i class="fas fa-shopping-cart"></i> Cart <span class="badge badge-light"><?php echo $_SESSION['cart']; ?></span>
	</button>
</a>
<?php if (isset($_SESSION['message'])) : ?>
	<?php header("Location: index.php"); ?>
	<div class="w-25 mx-auto text-center alert alert-<?php echo $_SESSION['messageType']?> alert-dismissible fade show" role="alert">
	  	<?php echo $_SESSION['message']; ?>
	  	<button type="button" class="close" data-dismiss="alert" aria-label="Close">
	    <span aria-hidden="true">&times;</span>
	  	</button>
	</div>
	<?php unset($_SESSION['message']); unset($_SESSION['messageType']); ?>
<?php endif ?>
<div class="row mt-5">
	<?php 
		$sql = "SELECT * FROM tbl_products";
		$stmt = $conn->prepare($sql);
		$stmt->execute();
		$result = $stmt->get_result();

		if (!empty($result)) :
			while ($row = $result->fetch_assoc()) :
	?>
			<div class="col-md-3 col-sm-6 mb-3">
				<div class="product-grid2">
					<div class="product-image2">
						<a href="details.php?k=<?= $row['id']; ?>">
							<img class="pic-1" src="img/<?php echo $row['photo1'];?>">
							<img class="pic-2" src="img/<?php echo $row['photo2'];?>">
						</a>
						<a class="add-to-cart" href="details.php?k=<?= $row['id']; ?>"><i class="fas fa-cart-plus"></i> Add to cart
						</a>
					</div>
					<div class="product-content">
						<h3 class="title">
							<a href="details.php?k=<?php $row['id']; ?>" class="text-decoration-none"><?php echo $row['name']; ?></a>
						</h3>
						<span class="price badge badge-secondary text-light">₱ <?php echo $row['price']; ?></span>
					</div>
				</div>
			</div>
			<?php endwhile ?>
		<?php else: ?>
			<div class="col-md-3 col-sm-6 mb-3">
				<h3>No Product Found!</h3>
			</div>
		<?php $stmt->close(); $conn->close(); endif; ?>	
	</div>