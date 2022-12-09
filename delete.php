<?php 
	require 'include/header.php';

	if(isset($_POST['btnProcess'])) {
        unset($_SESSION['cartItems'][$_POST['hdnKey']][$_POST['hdnSize']]);

        $_SESSION['cart'] -= $_POST['hdnQuantity'];
        header("Location: cart.php");
    }

    $id = $_GET['k'];
	$sql = "SELECT * FROM tbl_products WHERE id = ?";
	$stmt = $conn->prepare($sql);
	$stmt->bind_param("i", $id);
	$stmt->execute();
	$result = $stmt->get_result();
	$row = $result->fetch_assoc();
?>
<style>
	<?php include 'css/style.css'; ?>
</style>
<a href="cart.php">
	<button type="button" class="btn btn-primary float-right">	
		<i class="fas fa-shopping-cart"></i> Cart <span class="badge badge-light"><?php echo $_SESSION['cart']; ?></span>
	</button>
</a>
<form method="post">
	<div class="row mt-5 pb-4">
		<?php if(isset($_GET['k']) && isset($row)): ?>
	        <div class="col-md-4 col-sm-6 mb-4">
	            <div class="product-grid2 card">
	                <div class="product-image2">
	                    <a href="">
	                        <img class="pic-1" src="img/<?php echo $row['photo1']; ?>">
	                        <img class="pic-2" src="img/<?php echo $row['photo2']; ?>">
	                    </a>                            
	                </div>                        
	            </div>
	        </div>                
	        <div class="col-md-8 col-sm-6 mt-5">                
	            <h3 class="title">
	                <?php echo $row['name']; ?>
	                <span class="badge badge-dark">₱ <?php echo $row['price']; ?></span>
	            </h3>
	            <p class="text-justify"><?php echo $row['description']; ?></p>                    
	            <hr>
	            <input type="hidden" name="hdnKey" value="<?php echo $_GET['k']; ?>">
	            <input type="hidden" name="hdnSize" value="<?php echo $_GET['s']; ?>">
	            <input type="hidden" name="hdnQuantity" value="<?php echo $_GET['q']; ?>">

	            <h3 class="title">Size: <?php echo $_GET['s']; ?></h3>                        
	            <hr>
	            <h3 class="title">Quantity: <?php echo $_GET['q']; ?></h3>
	            <br>
	            <button type="submit" name="btnProcess" class="btn btn-dark btn"><i class="fa fa-trash"></i> Confirm Product Removal</button>
	            <a href="cart.php" class="btn btn-danger btn"><i class="fa fa-arrow-left"></i> Cancel / Go Back</a>
	        </div>                                
	    <?php else: ?>
	        <div class="col-12 card p-5">
	            <h3 class="text-center text-danger">No Product Found!</h3>
	        </div>
	    <?php $stmt->close(); $conn->close(); endif; ?>
	</div>
</form>