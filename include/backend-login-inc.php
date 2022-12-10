<?php 
	if (isset($_POST['submitBTN'])) {
		session_start();
		require 'database.php';

		$username = $_POST['username'];
		$password = $_POST['password'];
	
		$sql = "SELECT * FROM tbl_user";
		$stmt = $conn->prepare($sql);
		$stmt->execute();
		$result = $stmt->get_result();

		if (!empty($result)) {	
			while ($row = $result->fetch_assoc()) {
				$inputHashPass = md5($password);

				$usernameMatch = ($username == $row['username']) ? true : false;
				$passMatch = ($inputHashPass == $row['password']) ? true : false;
				if ($usernameMatch == true && $passMatch == true) {
					$_SESSION['username'] = $row['username'];
					$_SESSION['name'] = $row['name'];
					header("Location: ../index.php");
					exit();		
				} else {
					$_SESSION['message'] = "Error = Incorrect Credentials".$tempName.$passMatch.$terminate;
					$_SESSION['messageType'] = "danger";
					header("Location: ../backend-login.php");
				}
			}					
			$stmt->close();
			$conn->close();
		}		
	}