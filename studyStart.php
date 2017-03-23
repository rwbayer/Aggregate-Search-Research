<?php

session_start();

if(isset($_REQUEST["submitted"])) 
{
	if (intval($_REQUEST['password']) == 8899) {
		$_SESSION['studyId'] = intval($_REQUEST['study']);
		$_SESSION['studyPhase'] = -1;
		header("Location: studyManager.php");
		die();
	} else {
		echo "wrong password";
		header("Location: studyStart.php");
		die();
	}
}

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01//EN">

	<html>
		<head>
			<link rel="stylesheet" type="text/css" href="style.css">
			<script src="Javascript/jquery-1.11.0.min.js" type="text/javascript"></script>
			<script src="Javascript/jquery.validate.min.js" type="text/javascript"></script>
			<script src="Javascript/additional-methods.min.js" type="text/javascript"></script>
			<link href='http://fonts.googleapis.com/css?family=Indie+Flower' rel='stylesheet' type='text/css'>
			<title>
				Aggregated Search
			</title>
		</head>
		<body>
			<div class='container'>
				<div class='headerContainer'>
					<div class='mainContainer'>
						<form>
							<p> Welcome to Aggregated Search study!</p>
						  Enter Study Id:</br>
							<input id = "studyIdBox" name='study' type= "studyId" style='width:150px;' value=""/></br></br>
							Enter Password:</br>
							<input id = "pwdBox" name='password' type= "password" style='width:150px;' value=""/></br></br>
								<input type="hidden" name="submitted" value="true">
								<input type="submit" value="Save and get started!" action="">
						</form>
					</div>
				</div>
			</div>
		</body>
