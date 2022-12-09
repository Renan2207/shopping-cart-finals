<?php
	session_start();
	if (!isset($_SESSION['username'])) {
		header ("Location: /ShoppingCart/");
	}
	require 'include/database.php';
    $userType = array("Customer", "Admin");
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
    <div class="w-50 mx-auto text-center alert alert-<?php echo $_SESSION['messageType']?> alert-dismissible fade show" role="alert">
        <?php echo $_SESSION['message']; ?>
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">&times;</span>
        </button>
    </div>
    <?php unset($_SESSION['message']); unset($_SESSION['messageType']); ?>
<?php endif ?>
<div class="row mx-5">
	<div class="col-md-12">
		<table class="table table-striped table-hover text-center border">
            <thead class="bg-secondary text-white">
                <tr>                   
                    <th>NAME</th>
                    <th style="width: 50%;">DESCRIPTION</th>
                    <th>PRICE</th>
                    <th>PHOTO 1</th>
                    <th>PHOTO 2</th>
                    <th colspan="2">ACTION</th>
                </tr>
            </thead>
            <tbody>
            <?php 
				$sql = "SELECT * FROM tbl_products";
				$stmt = $conn->prepare($sql);
				$stmt->execute();
				$result = $stmt->get_result();

				if (!empty($result)) :
					while ($row = $result->fetch_assoc()) :
			?>            
	            <tr>
	                <td class="text-center font-weight-bold align-middle"><?php echo $row['name']; ?></td>
	                <td class="text-justify"><?php echo $row['description']; ?></td>
	                <td class="text-center align-middle">₱ <?php echo number_format($row['price'], 2); ?></td>
	                <td class="text-center align-middle"><img src="img/<?php echo $row['photo1']; ?>" class="img-thumbnail" style="height: 50px;"></td>
	                <td class="text-center align-middle"><img src="img/<?php echo $row['photo2']; ?>" class="img-thumbnail" style="height: 50px;"></td>
	                <form method="post" action="include/crud-inc.php">
		                <td class="text-center align-middle">
		                	<a href="crud-add.php?update=<?php echo $row['id']; ?>" class="btn btn-info btn-sm">
		                		<i class="fas fa-edit"></i>
		                	</a>
		                </td>
			            <td class="text-center align-middle">
			            	<a href="include/crud-inc.php?delete=<?php echo $row['id']; ?>" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure want to Delete this item?')"
			            		><i class="fa fa-trash"></i>
			            	</a>
			            </td>
	            	</form>
	            </tr>            
			<?php endwhile ?>
			<?php else: ?>             
	            <tr>
	                <td class="text-left">Product is still Empty</td>
	            </tr>            
	        <?php $stmt->close(); $conn->close(); endif; ?>
	    	</tbody>
	    </table>
	</div>
</div>
<div class="row container mx-auto mb-5">
    <div class="col-12 col-sm-12 col-md-4 col-lg-4">
        <a href="crud-add.php" class="btn btn-success btn btn-block"><i class="fas fa-plus-circle"></i> Add Product</a>
    </div>

    <div class="col-12 col-sm-12 col-md-4 col-lg-4">
        <a href="index.php" class="btn btn-danger btn btn-block"><i class="fas fa-times-circle"></i> Cancel / Go Back</a>
    </div>
    <div class="col-12 col-sm-12 col-md-4 col-lg-4">
        <a href="account.php" class="btn btn-primary btn btn-block"><i class="fa fa-key"></i> Change Admin Password</a>
    </div>
</div>
<?php if (empty($result)) : ?>
	<div style="height: 132px; "></div>
<?php endif ?>