<?php 
	require 'database.php';
	session_start();

	if (isset($_POST['add'])) {
		$name = htmlspecialchars(ucwords($_POST['name']));
		$description = htmlspecialchars($_POST['description']);
		$price = $_POST['price'];

		$photo1 = $_FILES['photo1']['name'];
		$photo1FileType = $_FILES['photo1']['type'];
		$photo1Upload = "../img/" . $photo1;

		$photo2 = $_FILES['photo2']['name'];
		$photo2FileType = $_FILES['photo2']['type'];
		$photo2Upload = "../img/" . $photo2;

		$allowed = array("image/jpeg", "image/jpg", "image/png");		

		if(!in_array($photo1FileType, $allowed) || !in_array($photo2FileType, $allowed)) {
		 	$_SESSION['message'] = "Error = Invalid image file type";
			$_SESSION['messageType'] = "danger";
		 	header("Location: ../crud-add.php");	
		  	exit();
		} else {
			$sql = "INSERT INTO tbl_products (name, description, price, photo1, photo2) VALUES (?, ?, ?, ?, ?)";
			$stmt = $conn->prepare($sql);
			$stmt->bind_param("ssiss", $name, $description, $price, $photo1, $photo2);
			$stmt->execute();

			move_uploaded_file($_FILES['photo1']['tmp_name'], $photo1Upload);
			move_uploaded_file($_FILES['photo2']['tmp_name'], $photo2Upload);
			
			$stmt->close();
			$conn->close();

			$_SESSION['message'] = "Success = Item Added";
			$_SESSION['messageType'] = "success";
			header("Location: ../crud-add.php");
		}	
	} 

	elseif (isset($_GET['delete'])) {
		$id = $_GET['delete'];

		$sql = "SELECT photo1, photo2 FROM tbl_products WHERE id = ?";
		$stmt = $conn->prepare($sql);
		$stmt->bind_param("i", $id);
		$stmt->execute();
		$result = $stmt->get_result();
		$row = $result->fetch_assoc();

		$imagePath1 = "../img/" . $row['photo1'];
		$imagePath2 = "../img/" . $row['photo2'];
		unlink($imagePath1);
		unlink($imagePath2);

		$sqlDelete = "DELETE FROM tbl_products WHERE id = ?";
		$stmtDelete = $conn->prepare($sqlDelete);
		$stmtDelete->bind_param("i", $id);
		$stmtDelete->execute();
		
		$stmtDelete->close();
		$conn->close();

		$_SESSION['message'] = "Success = Item Deleted";
		$_SESSION['messageType'] = "success";
		header("Location: ../crud.php");
	} 

	elseif (isset($_POST['update'])) {
		$id = $_POST['updateKey'];
		$name = htmlspecialchars(ucwords($_POST['name']));
		$description = htmlspecialchars($_POST['description']);
		$price = $_POST['price'];

		$sql = "SELECT photo1, photo2 FROM tbl_products WHERE id = ?";
		$stmt = $conn->prepare($sql);
		$stmt->bind_param("i", $id);
		$stmt->execute();
		$result = $stmt->get_result();
		$row = $result->fetch_assoc();

		$currentPhoto1 = $row['photo1'];
		$currentPhoto1Type = $_FILES['photo1']['type'];

		$currentPhoto2 = $row['photo2'];
		$currentPhoto2Type = $_FILES['photo2']['type'];

		$allowed = array("image/jpeg", "image/jpg", "image/png");		
		$haveAnNullValue =  $currentPhoto1Type != "" || $currentPhoto2Type != "";
		$haveAnInvalidType = !in_array($currentPhoto1Type, $allowed) || !in_array($currentPhoto2Type, $allowed);
		
		if ($haveNullType && $haveAnInvalidType) {
	 		$_SESSION['message'] = "Error = Invalid image file type";
			$_SESSION['messageType'] = "danger";
	 		header("Location: ../crud-add.php");	
	  		exit();
		}	

		$issetPhoto1 = isset($_FILES['photo1']['name']) && $_FILES['photo1']['name'] != "";
		$issetPhoto2 = isset($_FILES['photo2']['name']) && $_FILES['photo2']['name'] != "";
		
		if ($issetPhoto1) {
			$newPhoto1 = $_FILES['photo1']['name'];
			$newPhoto1Upload = "../img/" . $newPhoto1;
			unlink("../img/" . $currentPhoto1);
			move_uploaded_file($_FILES['photo1']['tmp_name'], $newPhoto1Upload);
		} else {
			$newPhoto1 = $currentPhoto1;
		}

		if ($issetPhoto2) {
			$newPhoto2 = $_FILES['photo2']['name'];
			$newPhoto2Upload = "../img/" . $newPhoto2;
			unlink("../img/" . $currentPhoto2);
			move_uploaded_file($_FILES['photo2']['tmp_name'], $newPhoto2Upload);
		} else {
			$newPhoto2 = $currentPhoto2;
		}

		$sqlUpdate = "UPDATE tbl_products SET name = ?, description = ?, price = ?, photo1 = ?, photo2 = ? WHERE id = ?";
		$stmtUpdate = $conn->prepare($sqlUpdate);
		$stmtUpdate->bind_param("ssissi",$name, $description, $price, $newPhoto1, $newPhoto2, $id);
		$stmtUpdate->execute();

		$stmtUpdate->close();
		$conn->close();

		$_SESSION['message'] = "Success = Item Updated";
		$_SESSION['messageType'] = "success";
		header("Location: ../crud.php");
	}

	