<?php
	require 'include/header.php';
	$sizes = array('XS','SM','MD','LG','XL',);
	ob_start(); 
	header('Cache-Control: no cache');
?>
<style>
	<?php include 'css/style.css'; ?>
</style>
<a href="cart.php">
	<button type="button" class="btn btn-primary float-right">
	<i class="fas fa-shopping-cart"></i> Cart <span class="badge badge-light"><?php echo $_SESSION['cart']; ?></span>
	</button>
</a>
<?php 
	$id = $_GET['k'];
	$sql = "SELECT * FROM tbl_products WHERE id = ?";
	$stmt = $conn->prepare($sql);
	$stmt->bind_param("i", $id);
	$stmt->execute();
	$result = $stmt->get_result();
	$row = $result->fetch_assoc();
?>
<div class="row mt-5 pb-4">
	<?php if(isset($_GET['k']) && isset($row)) : ?>
		<div class="col-md-4 col-sm-6">
			<div class="product-grid2">
				<div class="product-image2">
					<a href="details.php?k=<?php echo $key?>">
						<img class="pic-1" src="img/<?php echo $row['photo1']; ?>">
						<img class="pic-2" src="img/<?php echo $row['photo2']; ?>">
					</a>
				</div>
			</div>
		</div>
		<div class="col-md-6 col-sm-6">
			<div class="product-content">
				<h4 class="title"><b><?php echo $row['name']; ?></b>
				<span class="price badge badge-secondary text-light ml-2 mb-2" style="font-size: 15px;">₱ <?php echo $row['price']; ?></span></h4>
				<p class="text-justify"><?php echo $row['description']; ?></p>
				<h4 class="title"><b>Select Size:</b></h4>
				<form method="post">
					<input type="hidden" name="hdnKey" value="<?php echo $_GET['k']; ?>">
					<?php foreach($sizes as $size) : ?>
						<?php if($sizes[0] == $size) : ?>
							<input type="radio" name="size" id="<?php echo $size; ?>" value="<?php echo $size; ?>" checked>
							<label class="mr-2" for="<?php echo $size; ?>"><?php echo $size; ?></label>
						<?php else : ?>
							<input type="radio" name="size" id="<?php echo $size; ?>" value="<?php echo $size; ?>">
							<label class="mr-2" for="<?php echo $size; ?>"><?php echo $size; ?></label>
						<?php endif ?>
					<?php endforeach ?>
					<h4 class="title"><b>Quantity</b></h4>
					<input type="number" id="quantity" name="quantity" placeholder="0" min="1" max="100" class="form-control mb-3" required />
					<button type="submit" class="btn btn-secondary float-left mb-3 mr-2" name="confirmBtn"><i class="fas fa-check-circle"></i> Confirm Product Purchase</button>
				</form>
				<a href="index.php">
					<button type="submit" class="btn btn-danger" name="backBtn"><i class="fas fa-times-circle"></i> Cancel /Go Back</button>
				</a>
				<?php
					if (isset($_POST['confirmBtn'])) {
						if (!isset($_SESSION['name'])) {
							$_SESSION['message'] = "Error = No account signin";
							$_SESSION['messageType'] = "danger";
							header("Location: login.php");
						} else {
							if(isset($_SESSION['cartItems'][$_POST['hdnKey']][$_POST['size']]))
						        $_SESSION['cartItems'][$_POST['hdnKey']][$_POST['size']] += $_POST['quantity']; 
						    else
						        $_SESSION['cartItems'][$_POST['hdnKey']][$_POST['size']] = $_POST['quantity']; 

						    $_SESSION['cart'] += $_POST['quantity'];
						    header("location: confirm.php");
						}						
					}
				?>
			</div>
		</div>
	<?php else : ?>
		<div class="col">
			<h3>No Product Found!</h3>
		</div>
	<?php $stmt->close(); $conn->close(); endif; ?>	
</div>