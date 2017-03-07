<?php
	include "config.php";
	include "constants.php";
	session_start();
	$NUM_STUDIES = 50;

	$con = mysql_connect($_DATABASEHOST, $_DATABASEUSER, $_DATABASEPASSWORD);
	mysql_select_db($_DATABASE);
	if ($_SESSION['studyPhase'] == -1)
	{
		$query = "INSERT INTO AggSeaUserLog (Study_Id, Init_Time) VALUES ('" . $_SESSION['studyId'] . "' , NOW())";
		mysql_query($query);
		$_SESSION['userId'] = mysql_insert_id();
		if ($_SESSION['studyId'] == -1)
		{
			$_SESSION['studyId'] = $_SESSION['userId'] % $NUM_STUDIES;
		}
		$query = "UPDATE AggSeaUserLog SET Study_Id= '" .$_SESSION['studyId'] ."' WHERE User_Rd ='".$_SESSION['userId']."' ";
		mysql_query($query);
  	}

	if ($_SESSION['studyId'] != -1 && $_SESSION['studyPhase'] != -1) 
	{
		mysql_query("
		    UPDATE AggSeaTaskPerformance SET
				  Task_End = NOW()
			  WHERE User_ID = " . $_SESSION['userId'] . " AND Study_ID = " .
			    $_SESSION['studyId'] . " AND Task_ID = " . $_SESSION['taskId'] . ";");
		$_SESSION['studyPhase'] = $_SESSION['studyPhase'] + 1;
	} 
	else 
	{
    	$_SESSION['studyPhase'] = 1;
  	}

	$result = mysql_query(
	    "SELECT * FROM AggSeaStudy WHERE Study_ID = " . $_SESSION['studyId'] .
      " AND Task_Order = " . $_SESSION['studyPhase'] .
			" ORDER BY Task_Order ASC");
  if (!mysql_num_rows($result)) {
		//echo $_SESSION['userId'] . " " . $_SESSION['studyId'] . " " .
		     //$_SESSION['studyPhase'] . " " . $_SESSION['taskId'] . " ALL DONE";
  		header("Location: studyStart.php");
		die();
  }

	while ($row = mysql_fetch_assoc($result)) {
		$_SESSION['taskId'] = $row['Task_ID'];
		// echo "\nRunning task #" . $_SESSION['taskId'] . " (type=" . $row['task_type'] . ").";
		mysql_query("
		    INSERT INTO AggSeaTaskPerformance
				  (User_ID, Study_ID, Task_ID, Task_Start)
			  VALUES (
				  " . $_SESSION['userId'] . ", " .
					$_SESSION['studyId'] . ", " .
					$_SESSION['taskId'] . ", NOW());");
		if ($row['Task_Type'] == "survey") 
		{
			// dont think check in will be used...
			if ($_SESSION['taskId'] == CHECK_IN) 
			{
				$_SESSION['recent_interface'] = 
				header("Location: CheckIn.php");
				die();
			} 
			else if($_SESSION['taskId'] == CONSENT)
			{
				$_SESSION['recent_interface'] = 0;
				header("Location: consentForm.php");
				die();
			} 
			else 
			{
				header("Location: form.php?taskid=" . $_SESSION['taskId']);
				die();
			}
		} 
		else if ($row['Task_Type'] == "task") 
		{
			if ($row['System'] == PANEL) 
			{
				$_SESSION['recent_interface'] = PANEL;
				header("Location: search-experiment.php?interface=panel&source1=Web&source2=Image&numResults2=6&source3=Web&numResults3=4&source4=News&numResults4=2&numResults1=5&taskId=" . $_SESSION['taskId']);
				die();
			} 
			else if ($row['System'] == TABBED)
			{
				$_SESSION['recent_interface'] = TABBED;
				header("Location: search-experiment.php?interface=tabbed&source1=Web&source2=&numResults2=&source3=&numResults3=&source4=&numResults4=&numResults1=10&taskId=" . $_SESSION['taskId']);
				die();
			} 
			else if ($row['System'] == BLENDED)
			{
				$_SESSION['recent_interface'] = BLENDED;
				header("Location: search-experiment.php?interface=blended&source1=Web&source2=Image&numResults2=4&source3=News&numResults3=2&source4=Web&numResults4=4&numResults1=2&taskId=" . $_SESSION['taskId']);
				die();
			} 
		}
	}
	session_destroy();
	session_start();
	header("Refresh:0"); //It refreshes your current page
	die();
?>
