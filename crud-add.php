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
    <div class="w-25 mx-auto text-center alert alert-<?php echo $_SESSION['messageType']?> alert-dismissible fade show" role="alert">
        <?php echo $_SESSION['message']; ?>
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">&times;</span>
        </button>
    </div>
    <?php unset($_SESSION['message']); unset($_SESSION['messageType']); ?>
<?php endif ?> 
<div class="card mx-auto my-5 shadow-lg" style="width: 500px; border-radius: 10px;">
	<div class="card-header">
		<nav class="navbar navbar-expand-lg navbar-light mb-4 p-0">
			<a class="navbar-brand" href="index.php">
				HOME
			</a>
		</nav>
		<?php if (isset($_GET['update'])) :
			$id = $_GET['update'];

			$sql = "SELECT * FROM tbl_products WHERE id = ?";
			$stmt = $conn->prepare($sql);
			$stmt->bind_param("i", $id);
			$stmt->execute();
			$result = $stmt->get_result();
			$row = $result->fetch_assoc();
		?>
		<h3>Update Product</h3>
		<p>Change or Update your product information.</p>
		<form method="post" action="include/crud-inc.php" class="pt-3" enctype="multipart/form-data">
			<input type="hidden" name="updateKey" value="<?php echo $row['id'] ?>">
			<div class="form-group">
				<label>PRODUCT NAME</label>
				<input type="text" name="name" class="form-control" value="<?php echo $row['name'] ?>">
			</div>
			<div class="form-group">
				<label>PRODUCT DESCRIPTION</label>
				<textarea id="description" name="description" rows="7" cols="62">
<?php echo $row['description'] ?>
				</textarea>
			</div>
			<div class="form-group">
				<label>PRODUCT PRICE</label>
				<input type="number" min="1" name="price" class="form-control" value="<?php echo $row['price'] ?>">
			</div>
			<div class="form-inline mb-3">
				<label class="mr-2">ORGINAL</label>
				<input type="hidden" name="currentPhoto1" value="<?php echo $row['photo1']; ?>">
				<img src="img/<?php echo $row['photo1']; ?>" class="img-thumbnail" style="height: 50px;">
				<label class="mx-2">PHOTO 1</label>
				<input type="file" name="photo1" id="photo1">		
			</div>
			<div class="form-inline">
				<label class="mr-2">ORGINAL</label>
				<input type="hidden" name="currentPhoto2" value="<?php echo $row['photo2']; ?>">
				<img src="img/<?php echo $row['photo2']; ?>" class="img-thumbnail" style="height: 50px;">
				<label class="mx-2">PHOTO 2</label>
				<input type="file" name="photo2" id="photo2">
			</div>
			<div class="mt-3 text-center">
				<button type="submit" name="update" class="btn btn-dark mr-2"><i class="fas fa-check-circle"></i> UPDATE</button>
				<a href="crud.php" class="btn btn-danger btn btn-danger"><i class="fas fa-times-circle"></i> Cancel / Go Back</a>
			</div>
		</form>
		<?php $stmt->close(); $conn->close(); else : ?>
			<h3>Insert Product</h3>
			<p>Add some good quality items and affordable price.</p>
			<form method="post" action="include/crud-inc.php" class="pt-3" enctype="multipart/form-data">
				<div class="form-group">
					<label>PRODUCT NAME</label>
					<input type="text" name="name" class="form-control">
				</div>
				<div class="form-group">
					<label>PRODUCT DESCRIPTION</label>
					<textarea id="description" name="description" rows="3" cols="62">
					</textarea>
				</div>
				<div class="form-group">
					<label>PRODUCT PRICE</label>
					<input type="number" min="1" name="price" class="form-control">
				</div>
				<div class="form-inline mb-3">
					<label class="mr-2">PHOTO 1</label>
					<input type="file" name="photo1" id="photo1">
				</div>
				<div class="form-inline">
					<label class="mr-2">PHOTO 2</label>
					<input type="file" name="photo2" id="photo2">
				</div>
				<div class="mt-3 text-center">
					<button type="submit" name="add" class="btn btn-dark mr-2"><i class="fas fa-check-circle"></i> SUBMIT</button>
					<a href="crud.php" class="btn btn-danger btn btn-danger"><i class="fas fa-times-circle"></i> Cancel / Go Back</a>
				</div>
			</form>
		<?php endif; ?>
	</div>
</div>