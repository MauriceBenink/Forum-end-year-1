<!DOCTYPE html>
<html lang = "nl">
<head>
<?php
session_start();
include "php/forum.php";
include "php/login/reg_functions.php";
include "php/global_functions.php";
?>
</head>
<?php

$register_error_message='';
$username='';
$password='';
if(!isset($_SESSION['id'])) {
	if ((isset($_POST['username'])) && (!empty($_POST['username'])) && (isset($_POST['password'])) && (!empty($_POST['password']))) {
		$username = check_POST('username',true);
		$password = check_POST('password',false);
		if(empty($register_error_message)) {
			print_r($username. " " .$password);

			$send_to_database = $conn->prepare("SELECT * FROM users WHERE login_name = SHA1('$username') AND password = SHA1('$password')");
			$send_to_database->execute();
			$result = $send_to_database->fetchAll();
			if (empty($result[0]['banned_by_user_id']) || !isset($result[0]['banned_by_user_id'])) {
				if (count($result) == 1) {
					$status = explode(",", $result[0]['status']);
					$_SESSION['id'] = $result[0]['id'];
					echo $result[0]['id'];
					if ($status[0] == 0) {
						echo "<br>verification needed";
						header("Location: verification.php?");
						die();
					} else {
						echo '<br> welcome ';
						echo $result[0]['display_name'];
						header("Location: landing.php?");
					}
					//		die();

					//[] = row [][] = cell
				} else {
					echo "<br> wrong username/password";
					echo "<form action = \"forgotpassword.php\"><input type=\"submit\" value=\"Forgot password\"></form>";
				}
			} else {
				$banned = explode(",", $result[0]['banned_by_user_id']);
				echo "<br>I'm sorry but it seems you have been banned for :\"$banned[1]\"";
			}
		}
	}
}else{
	header("Location: landing.php?");
}
echo $register_error_message;
	?>
<div>By going on this website you accept that this site uses cookies</div><br>
	<form method="post">
			<div>Username:<input class='rowz' name="username" type="text" placeholder="Derpy123"></div>
			<div>Password:<input class='rowz' name="password" type="password" placeholder="ThisIsTottallyNotMyPassword"></div>
			<input id="contactbutton" type="submit" value="Submit">
	</form>
	<form action = "register.php"><input type="submit" value="Register"></form>
	<form action = "landing.php"><input type="submit" value="use geust account"></form>
<body>
</body>
</html>