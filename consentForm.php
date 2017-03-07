<?php
	include "config.php";
	include 'localise.php';
	include "constants.php";
	session_start();
	if(!$_SESSION['userId'])
	{
		echo "Please set userId first";
		die();
	}
	$message = '';
	$con = mysql_connect($_DATABASEHOST, $_DATABASEUSER, $_DATABASEPASSWORD);
	mysql_select_db($_DATABASE);

	if (isset($_REQUEST["submitted"])) {

		$userId = $_SESSION['userId'];
		$questionId = 1;
		$response = "Agree";
		$taskid = CONSENT;

		$query = "INSERT INTO `AggSeaAnswers` (`User_ID`, `Question_ID`, `Response`, `Task_ID`, `System`) VALUES ('$userId', '$questionId', '$response', '$taskid', '0')";
		if (!mysql_query($query)) 
		{
			$message = mysql_error();
			mysql_close($con);
			echo $message;
		}
		if($message=='') 
		{
			mysql_close($con);
			header("Location: studyManager.php");
			die();
		}
	}
?>

<!DOCTYPE html>
<html lang="en-US">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
<head>
	<title>Consent Form</title>
	<style>
		input[type=submit] {
		padding:5px 15px;
		background:#00cc00;
		border:0 none transparent;
		cursor:pointer;
		-webkit-border-radius: 5px;
		border-radius: 5px;
		font-size: medium;
		color: #fff;
		-webkit-user-select: none;
		height: 30px;
	    }
	</style>
</head>

<body style="width:60%;margin-left:auto;margin-right:auto">
	<div id="title" style="text-align:center;">
		<h2>Consent Form</h2>
	</div>
	<div id="content">
		<p>Dear Participant:</p>
		<p>The Human-Centered Computing research lab, led by Dr. Ben Steichen in the Department of Computer Engineering at Santa Clara University, is conducting a research study to investigate different aggregated web search interface designs.</p>
		<p>We are requesting your participation, which will involve approximately 60 minutes of your time, during which you will be asked to complete 16 search tasks using novel aggregated search interfaces. You will first be asked to complete a short demographic questionnaire. Following a standard test to measure your Learning Styles, you will be presented with several different interfaces, and you will be asked to conduct simple web search tasks with different interfaces, and mark your favorite search results for each task.</p>
		<p>During the study, we will be recording your eye gaze behavior using an eye tracker, physiological signals using a wearable wristband, and facial expressions using a camera. All information (including questionnaires, task answers, and sensor information) will be stored on a password-protected computer in a locked room.  All information collected will be completely anonymized, i.e. your name will not be associated with any of the information that we collect as part of the study. In addition, the recorded facial expression video will be immediately converted to facial action codes (fully anonymous) after you have completed the study, and the video will then be erased.</p>
		<p>Your participation in this study is entirely voluntary.  If you choose not to participate, or to withdraw from the study at any time, there will be no penalty.  It will not affect your grades (if applicable) in any way.  The results of the research study may be published, but again, no personal data will ever be revealed in any of the publications.</p>
		<p>Possible benefits of your participation are the exposure to novel aggregated web search research prototypes, and the exposure and engagement in academic research. In addition, you will receive a 20 dollar gift card as a reward. If you have any questions concerning the research study, or would like to hear more about the results, you can contact us at bsteichen@scu.edu or via telephone at (408) 551 - 3512.</p>
		<p>Sincerely,</p>
		<p>Dr. Ben Steichen</p>

		<form>
		<input type="checkbox" name="agree" value="agree" required>I have read and understood the above consent form. I certify that I am 18 years of age or older and, by checking the below checkbox and clicking the submit button to enter the study, I indicate my willingness to voluntarily take part in the study.<br><br>
		<input type="hidden" name="submitted" value="true">
		<input type="submit"  value="Submit" action="">
		</form>

		<p>If you have any questions about your rights as a subject/participant in this research, or if you feel you have been placed at risk, you can contact the Chair of the Human Subjects Committee, through Office of Research Compliance and Integrity at (408) 554-5591.</p>

	</div>
</body>
