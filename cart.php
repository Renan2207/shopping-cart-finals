<?php
    require 'include/header.php';
    $_SESSION['totalAmount'] = $_SESSION['totalQuantity'] = $quantity = 0;

    if(isset($_POST['btnUpdate'])) {
        $cartKeys = $_POST['hdnKey'];
        $cartSize = $_POST['hdnSize'];
        $cartQuantities = $_POST['txtQuantity'];
      
        if(isset($cartKeys) && isset($cartSize) && isset($cartQuantities)) {
            $_SESSION['totalAmount'] = $_SESSION['totalQuantity'] = 0;
            foreach($cartKeys as $index => $key) {
                $_SESSION['cartItems'][$key][$cartSize[$index]] = $cartQuantities[$index];
                $_SESSION['totalQuantity'] += $cartQuantities[$index];
                $_SESSION['cart'] = $_SESSION['totalQuantity'];
                header("Location: cart.php");
            }
        } 
    }
?>
<style>
	<?php require 'css/style.css'; ?>
</style>
<a href="cart.php">
	<button type="button" class="btn btn-primary float-right">
	<i class="fas fa-shopping-cart"></i> Cart <span class="badge badge-light"><?php echo $_SESSION['cart']; ?></span>
	</button>
</a>
<form method="post">
	<div class="row mt-3">
	    <div class="col-12">
	        <table class="table table-striped table-hover text-center">
	            <thead class="table-borderless">
	                <tr>
	                    <th scope="col-1"></th>
	                    <th scope="col-3">Product</th>
	                    <th scope="col-1">Size</th>
	                    <th scope="col-2">Quantity</th>
	                    <th scope="col-2">Price</th>
	                    <th scope="col-2">Total</th>
	                    <th scope="col-1"></th>
	                </tr>
	            </thead>
	            <tbody>     
	                <?php if(isset($_SESSION['cartItems']) && $_SESSION['cart'] != 0): ?>		               
	                    <?php foreach($_SESSION['cartItems'] as $key => $value): ?>
	                    	<?php
	                    		$sql = "SELECT * FROM tbl_products WHERE id = ?";
	                    		$stmt = $conn->prepare($sql);
	                    		$stmt->bind_param("i", $key);
	                    		$stmt->execute();
	                    		$result = $stmt->get_result();
	                    		$row = $result->fetch_assoc();
	                    	?>
	                        <?php foreach($value as $size => $quantity): ?>		                        	
	                            <?php $_SESSION['totalAmount'] += $row['price'] * $quantity; ?>
	                            <tr>                                        
	                                <td><img src="img/<?php echo $row['photo1']; ?>" class="img-thumbnail" style="height: 50px;"></td>
	                                <td><?php echo $row['name']; ?></td>
	                                <td><?php echo $size; ?></td>
	                                <td>
	                                    <input type="hidden" name="hdnKey[]" value="<?php echo $key; ?>">
	                                    <input type="hidden" name="hdnSize[]" value="<?php echo $size; ?>">
	                                    <input type="number" name="txtQuantity[]" value="<?php echo $quantity; ?>" class="form-control text-center" min="1" max="100" required>
	                                </td>
	                                <td>₱ <?php echo number_format($row['price'], 2); ?></td>
	                                <td>₱ <?php echo number_format($row['price'] * $quantity, 2); ?></td>

	                                <td><a href="delete.php?<?php echo 'k=' . $key . '&s=' . $size . '&q=' . $quantity; ?>" class="btn btn-danger btn-sm"><i class="fa fa-trash"></i></a></td>
	                            </tr>                        
	                        <?php endforeach; $_SESSION['totalQuantity'] += $quantity; ?>
	                    <?php endforeach; ?>
	                    <?php $stmt->close(); $conn->close(); ?>
	                        <tr>
	                            <td colspan="2"> </td>
	                            <td><b>Total</b></td>
	                            <td><?php echo $_SESSION['cart']; ?></td>
	                            <td>----</td>
	                            <td><b>₱ <?php echo number_format($_SESSION['totalAmount'], 2); ?><b></td>
	                            <td>----</td>
	                        </tr>
	                <?php else: ?>          
	                    <tr>
	                        <td colspan="7" class="text-left">Cart is still Empty!</td>
	                    </tr>            
	                <?php endif; ?>
	            </tbody>
	        </table>                    
	    </div>            
	</div>
	<div class="row">
	    <div class="col-12 col-sm-12 col-md-4 col-lg-4">
	        <a href="index.php" class="btn btn-danger btn btn-block"><i class="fa fa-shopping-bag"></i> Continue Shopping</a>
	    </div>
	    <?php if(isset($_SESSION['cartItems']) && $_SESSION['cart'] != 0) : ?>
	        <div class="col-12 col-sm-12 col-md-4 col-lg-4">
	            <button type="submit" name="btnUpdate" class="btn btn-success btn btn-block"><i class="fa fa-edit"></i> Update Cart</button>
	        </div>
	        <div class="col-12 col-sm-12 col-md-4 col-lg-4">
	            <a href="checkout.php" class="btn btn-primary btn btn-block"><i class="fa fa-sign-out-alt"></i> Checkout</a>
	        </div>
	    <?php endif; ?>
	</div>
</form>
<div style="height: 121px; "></div>