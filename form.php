<?php
	include 'config.php';
	include "constants.php";
	session_start();

	header('Content-Type: text/html; charset=utf-8');

	$con = mysql_connect($_DATABASEHOST, $_DATABASEUSER, $_DATABASEPASSWORD);
	mysql_select_db($_DATABASE);

	if(!$_SESSION['userId'])
	{
		echo "Please set userId first";
		die();
	}
	if(isset($_REQUEST["submitted"])) 
	{
		$taskid = $_REQUEST['_taskid'];
		$result = mysql_query("SELECT DISTINCT Question_ID FROM AggSeaQuestions WHERE Task_ID = $taskid");

		if (!$result) {
				$message  = 'Invalid query: ' . mysql_error() . "\n";
				$message .= 'Whole query: ' . $query;
		}

		$storeArray = Array();
		
		while ($row = mysql_fetch_array($result, MYSQL_ASSOC)) 
		{
    		$storeArray[] =  $row['Question_ID'];
		}

		$i = 1;
		foreach ($storeArray as $value)
		{
			if (isset($_REQUEST[$i])) 
			{
				$response = urldecode($_REQUEST[$i]);
				$userId = $_SESSION['userId'];
				$questionId = $value;
				$system = $_SESSION['recent_interface'];
				$query = "INSERT INTO `AggSeaAnswers` (`User_ID`, `Question_ID`, `Response`, `Task_ID`, `System`) VALUES ('$userId', '$questionId', '$response', '$taskid', '$system')";
				if (!mysql_query($query)) 
				{
					$message = mysql_error();
					mysql_close($con);
				}
			}
			$i = $i + 1;
		}

		header("Location: studyManager.php");
		die();
	}

	if (!$con) {
	    die('Could not connect: ' . mysql_error());
	}

	$taskid = $_REQUEST['taskid'];

	$result = mysql_query("SELECT * FROM AggSeaQuestions WHERE Task_ID = $taskid ORDER BY Question_Order");
	
	if (!$result) 
	{
			$message  = 'Invalid query: ' . mysql_error() . "\n";
			$message .= 'Whole query: ' . $query;
	}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01//EN">

<html>
<head>
	<link rel="stylesheet" type="text/css" href="style.css">
	<script src="Javascript/jquery-1.11.0.min.js" type="text/javascript"></script>
	<script src="Javascript/jquery.validate.min" type="text/javascript"></script>
	<script src="Javascript/additional-methods.min.js" type="text/javascript"></script>
	<script src="lightbox/lightbox.min.js"></script>
	<link href="lightbox/lightbox.css" rel="stylesheet" />
	<link href='http://fonts.googleapis.com/css?family=Indie+Flower' rel='stylesheet' type='text/css'>

	<title>
		Aggregated Search
	</title>
</head>
<body>
	<div class='container'>
		<div class='headerContainer'>
			<div class='instruction'>
				<?php
					$taskid = $_REQUEST['taskid'];
					if ($taskid == DEMOGRAPHICS) 
					{
						echo "<p>Demographic Questionnaire</p>";
					} 
					else if ($taskid == LOCUS_OF_CONTROL)
					{
						echo "<p><strong>Instructions: </strong> For each couple of statements, click on the button next to the one statement that best describes how you feel.</p>";
					}
					else if ($taskid == GEFT) 
					{
						echo "Please create an account at Mind Garden following the link. Then complete the Group Embedded Figures Test (GEFT).";
						echo "<br><br><a href='https://transform.mindgarden.com/login'>GEFT</a>";
					} 
					else if ($taskid == SYSTEM_QUESTIONNAIRE) 
					{
						echo "<p>Please indicate your level of agreement with the items (1 = strongly disagree; 5 = strongly agree)</p>";
					} 
					else if ($taskid == EXIT_QUESTIONNAIRE) 
					{
						echo "<div><p>Please nominate a single system for each.</p></div>";
						echo "<p>Click to see larger images.</p>";

						echo "<div id='images'>";
						echo "<div class='image' style='margin-left: 0px; margin-right:55px; border: 1px solid black;'>";
						echo "<a href='images/panelled.png' data-lightbox='image1' data-title='Panelled'>";
						echo "<img src='images/panelled.png' width='100px'/></a></div>";
						echo "<div class='image' style='margin-left: 55px; margin-right:45px; border: 1px solid black;'>";
						echo "<a href='images/tabbed.png' data-lightbox='image2' data-title='Tabbed'>";
						echo "<img src='images/tabbed.png' width='100px'/></a></div>";
						echo "<div class='image' style='margin-left: 45px; margin-right:0px; border: 1px solid black;'>";
						echo "<a href='images/blended.png' data-lightbox='image4' data-title='Blended'>";
						echo "<img src='images/blended.png' width='100px'/></a></div><br><br><br><br></div>";

						echo "<div><label for='panel'>Panelled&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</label>";
						echo "<label for='panel'>Tabbed&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</label>";
						echo "<label for='panel'>Blended&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</label>";
					}
				?>
			</div>
			<div class='mainContainer'>
				<form id="questionForm">
					<?php
						$prev_was_multiple = false;
						while($row = mysql_fetch_assoc($result)) {
							$question_id = $row['Question_Order'];
							if ($row['Type'] == 'text') {
								if ($prev_was_multiple) {
									echo "</select>";
									echo "<br>";
									echo "<br>";
									$prev_was_multiple = false;
								}
								echo "<br>";
								echo $row['Question_Text'];
								echo "<br>";
								if ($row['Size'] == 'small') {
									echo "<input type='text' size='40' name='$question_id'> <br />";
									echo "<br>";
								} else if ($row['Size'] == 'medium') {
									echo "<input type='text' size='50' name='$question_id'> <br />";
								} else if ($row['Size'] == 'large') {
									echo "<textarea rows='5' cols='70' name='$question_id' form='questionForm'></textarea> <br />";
									echo "<br>";
								}
							} else if ($row['Type'] == 'multiple' && $row['Q_Order'] == 1) {
								echo "<br>";
								if ($prev_was_multiple) {
									echo "</select>";
									echo "<br>";
									echo "<br>";
								}
								$prev_was_multiple = true;
								$name = $row['Q_Option'];
								echo $row['Question_Text'];
								echo "<br>";
								echo "<select name='$question_id'>";
								echo "<option value='$name'>$name</option>";
							} else if ($row['Type'] == 'multiple' && $row['Q_Order'] != 1) {
								echo "<br>";
								$prev_was_multiple = true;
								$name = $row['Q_Option'];
								echo "<option value='$name'>$name</option>";
							} 
							else if ($row['Type'] == 'radio' && $row['Q_Order'] == 1) {
								echo "<br>";
								if ($prev_was_multiple) {
									echo "</select>";
									echo "<br>";
									echo "<br>";
									$prev_was_multiple = false;
								}
								$_id = $row['ID'];
								echo $row['Question_Text'];
								$_option = htmlentities($row['Q_Option'], ENT_QUOTES);
								$_url = urlencode($_option);
								echo "<br/>";
								echo "<input type='radio' id='$_id' name='$question_id' value='$_url' class='css-radio2'>";
								echo "<label for='$_id' class='css-radio2-label'></label>";
								echo " " . $_option . "&nbsp;&nbsp;";
								if ($row['Size'] == "large") {
									echo "<br/>";
							  }

							} else if ($row['Type'] == 'radio' && $row['Q_Order'] != 1) {
								$_id = $row['ID'];
								$_option = htmlentities($row['Q_Option'], ENT_QUOTES);
								$_url = urlencode($_option);
								echo "<input type='radio' id='$_id' name='$question_id' value='$_url' class='css-radio2'>";
								echo "<label for='$_id' class='css-radio2-label'></label>";
								echo " " . $_option . "&nbsp;&nbsp;";
								if ($row['Q_Order'] == 5) {
									echo "<br/>";
								}
								if ($row['Size'] == "large") {
									echo "<br/>";
							  }
							} else {
								echo "invalid queston type in database.";
							}
						}
						if ($prev_was_multiple) {
									echo "</select>";
									echo "<br></br>";
									$prev_was_multiple = false;
						}
					?>
					<br>
					<?php
						$taskid = $_REQUEST['taskid'];
						echo "<input type='hidden' name='_taskid' value='$taskid'>";
					?>
					<br></br>
					<input type="hidden" name="submitted" value="true">
					<?php
						$taskid = $_REQUEST['taskid'];
						if ($taskid != GEFT) 
						{
							echo "<input type='submit' value='Submit Survey' action='' style='margin-bottom: 100px;'>";
						}
					?>
					<br>
				</form>
			</div>
		</div>
	</div>
	</body>
</html>
