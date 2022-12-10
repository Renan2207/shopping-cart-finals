<?php 
	if (isset($_POST['submitBTN'])) {
		session_start();
		require 'database.php';

		$currentPass = $_POST['currentPass'];
		$newPass = $_POST['newPass'];
		$confirmNewPass = $_POST['confirmNewPass'];

		
		if (isset($_SESSION['username'])) {
			$thereIsAnError = false;
			$sql = "SELECT * FROM tbl_user";
			$stmt = $conn->prepare($sql);
			$stmt->execute();
			$result = $stmt->get_result();

			if (!empty($result)) {
				while ($row = $result->fetch_assoc()) {
				$inputHashPass = md5($currentPass);
				$id = $_SESSION['userid'];
					if ($inputHashPass != $row['password']) {
						$_SESSION['message'][] = "Error = Current password is incorrect";
						$_SESSION['messageType'] = "danger";
						$thereIsAnError = true;
					} 
					if ($newPass != $confirmNewPass) {
						$_SESSION['message'][] = "Error = New password not match";
						$_SESSION['messageType'] = "danger";
						$thereIsAnError = true;
					} 
					if ($currentPass == $newPass) {
						$_SESSION['message'][] = "Error = New password required";
						$_SESSION['messageType'] = "danger";
						$thereIsAnError = true;
					} 
					if ($thereIsAnError) {
						header("Location: ../account.php");
						exit();
					}
					$newHashPass = md5($newPass);
					$updateSQL = "UPDATE tbl_user SET password = ? WHERE userId = ?";
					$updateStmt = $conn->prepare($updateSQL);
					$updateStmt->bind_param("si", $newHashPass, $id);
					$updateStmt->execute();
					$stmt->close();
					$conn->close();

					$_SESSION['message'][] = "Success = Password change";
					$_SESSION['messageType'] = "success";
					header("Location: ../index.php");
					exit();
				}			
			}
		} else  {
			$id = $_SESSION['userid'];
			$thereIsAnError = false;
			$sql = "SELECT * FROM tbl_user WHERE userid = ?";
			$stmt = $conn->prepare($sql);
			$stmt->bind_param("i" , $id);
			$stmt->execute();
			$result = $stmt->get_result();

			if (!empty($result)) {
				while ($row = $result->fetch_assoc()) {
				$inputHashPass = md5($currentPass);
					if ($inputHashPass != $row['password']) {
						$_SESSION['message'][] = "Error = Current password is incorrect";
						$_SESSION['messageType'] = "danger";
						$thereIsAnError = true;
					} 
					if ($newPass != $confirmNewPass) {
						$_SESSION['message'][] = "Error = New password not match";
						$_SESSION['messageType'] = "danger";
						$thereIsAnError = true;
					}
					if ($currentPass == $newPass) {
						$_SESSION['message'][] = "Error = New password required";
						$_SESSION['messageType'] = "danger";
						$thereIsAnError = true;
					} 
					if ($thereIsAnError) {
						header("Location: ../account.php");
						exit();
					}
					$newHashPass = md5($newPass);
					$updateSQL = "UPDATE tbl_user SET password = ? WHERE userid = ?";
					$updateStmt = $conn->prepare($updateSQL);
					$updateStmt->bind_param("si", $newHashPass, $id);
					$updateStmt->execute();
					$stmt->close();
					$conn->close();

					$_SESSION['message'] = "Success = Password change";
					$_SESSION['messageType'] = "success";
					header("Location: ../index.php");
					exit();
				}			
				
			}
		}
	}
