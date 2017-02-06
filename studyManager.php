<?php
	include "config.php";
	session_start();
	$NUM_STUDIES = 50;

	$con = mysql_connect($_DATABASEHOST, $_DATABASEUSER, $_DATABASEPASSWORD);
	mysql_select_db($_DATABASE);
	if ($_SESSION['studyPhase'] == -1) {
		$query = "INSERT INTO UserLog (StudyId, init_time) VALUES ('" . $_SESSION['studyId'] . "' , NOW())";
		mysql_query($query);
		$_SESSION['userId'] = mysql_insert_id();
		if($_SESSION['studyId'] == -1){
			$_SESSION['studyId'] = $_SESSION['userId'] % $NUM_STUDIES;
		}
		$query = "UPDATE UserLog SET StudyId= '" .$_SESSION['studyId'] ."' WHERE user_id ='".$_SESSION['userId']."' ";
		mysql_query($query);
  }

	if ($_SESSION['studyId'] != -1 && $_SESSION['studyPhase'] != -1) {
		mysql_query("
		    UPDATE TaskPerformance SET
				  task_end = NOW()
			  WHERE user_id = " . $_SESSION['userId'] . " AND study_id = " .
			    $_SESSION['studyId'] . " AND TaskID = " . $_SESSION['taskId'] . ";");
		$_SESSION['studyPhase'] = $_SESSION['studyPhase'] + 1;
	} else {
    $_SESSION['studyPhase'] = 1;
  }

	$result = mysql_query(
	    "SELECT * FROM Study WHERE study_id = " . $_SESSION['studyId'] .
      " AND task_order = " . $_SESSION['studyPhase'] .
			" ORDER BY task_order ASC");
  if (!mysql_num_rows($result)) {
		//echo $_SESSION['userId'] . " " . $_SESSION['studyId'] . " " .
		     //$_SESSION['studyPhase'] . " " . $_SESSION['taskId'] . " ALL DONE";
  		header("Location: studyStart.php");
		die();
  }

	while ($row = mysql_fetch_assoc($result)) {
		$_SESSION['taskId'] = $row['TaskID'];
		// echo "\nRunning task #" . $_SESSION['taskId'] . " (type=" . $row['task_type'] . ").";
		mysql_query("
		    INSERT INTO TaskPerformance
				  (user_id, study_id, TaskID, task_start)
			  VALUES (
				  " . $_SESSION['userId'] . ", " .
					$_SESSION['studyId'] . ", " .
					$_SESSION['taskId'] . ", NOW());");
		if ($row['task_type'] == "survey") {
			if ($_SESSION['taskId'] == 13) {
				header("Location: CheckIn.php");
				die();
			} else if($_SESSION['taskId'] == 14){
				header("Location: consentForm.php");
				die();
			} else {
				header("Location: form.php?taskid=" . $_SESSION['taskId']);
				die();
			}
		} else if ($row['task_type'] == "task") {
			if ($row['system'] == 1) {
				$_SESSION['recent_interface'] = 1;
				header("Location: PerMIA.php?interface=panel&taskid=" . $_SESSION['taskId']);
				die();
			} else if ($row['system'] == 2) {
				$_SESSION['recent_interface'] = 2;
				header("Location: PerMIA.php?interface=tabbed&taskid=" . $_SESSION['taskId']);
				die();
			} else if ($row['system'] == 3) {
				$_SESSION['recent_interface'] = 3;
				header("Location: PerMIAil.php?interface=interleaved-dynamic&taskid=" . $_SESSION['taskId']);
				die();
			} else if ($row['system'] == 4) {
				$_SESSION['recent_interface'] = 4;
				header("Location: PerMIAil.php?interface=non-blended-vertical&taskid=" . $_SESSION['taskId']);
				die();
			}
		}
	}
	session_destroy();
	session_start();
	header("Refresh:0"); //It refreshes your current page
	die();
?>
