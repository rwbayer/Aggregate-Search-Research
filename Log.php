<?php
	session_start();
  	include 'config.php';
	$con = mysql_connect($_DATABASEHOST, $_DATABASEUSER, $_DATABASEPASSWORD);
	if (!$con)
	{
	    die('Could not connect: ' . mysql_error());
	}
	header('Content-Type: text/html; charset=utf-8');

	// mysql_set_charset('utf8', $con);
	// mysql_query("SET NAMES utf8");
	mysql_select_db($_DATABASE);

	$userID = $_SESSION['userId'];
	$interface = $_SESSION['interface'];
	$taskId = $_SESSION['taskId'];

	$type = $_REQUEST["type"];

	if ($type == 'query')
	{
		$searchQuery = mysql_real_escape_string ($_REQUEST["searchQuery"]);
		$currentinterface = $_REQUEST["currentinterface"];
		$suggestion = ($_REQUEST["suggestion"] == "true") ? 1 : 0;

		$query = "INSERT INTO AggSeaQueryLog (User_ID, Task_ID, Interface, Current_Interface, Search_Query, Suggestion, Time) VALUES ('" . $userID . "','" . $taskId . "','" . $interface . "','" . $currentinterface . "','" . $searchQuery . "','" . $suggestion . "' , NOW());";
		if (!mysql_query($query)) 
		{
			$query .= mysql_error();
			// $response_array['query'] = $query;
		}
		else
		{
			$_SESSION['current_query'] = mysql_insert_id();
		}
	}
	else if ($type == 'link')
	{
		$QueryId = $_SESSION['current_query'];
		$link = mysql_real_escape_string ($_REQUEST["link"]);
		$vertical = $_REQUEST["vertical"];
		$title = mysql_real_escape_string ($_REQUEST["title"]);
		$snippet = mysql_real_escape_string ($_REQUEST["snippet"]);
		$rank = $_REQUEST["rank"];
		$currentinterface = $_REQUEST["currentinterface"];

		//Save query
		$query = "INSERT INTO AggSeaLinkLog (User_ID, Task_ID, Interface, Current_Interface, Query_ID, Link, Vertical, Title, Snippet, Rank, Timestamp) VALUES ('" . $userID . "','" . $taskId . "','" . $interface . "','" . $currentinterface . "','" . $QueryId . "','" . $link . "','" . $vertical . "','" . $title . "','" . $snippet . "','" . $rank . "' , NOW());";
		if (!mysql_query($query)) 
		{
			$query .= mysql_error();
		}
	}
	else if ($type == 'nav')
	{
		$QueryId = $_SESSION['current_query'];
		$page = mysql_real_escape_string ($_REQUEST["page"]);
		$navType = mysql_real_escape_string ($_REQUEST["navType"]);
		$previousinterface = $_REQUEST["previousinterface"];
		$currentinterface = $_REQUEST["currentinterface"];

		//Save query
		$query = "INSERT INTO AggSeaNavLog (User_ID, Task_ID, Interface, Previous_Interface, Current_Interface, Query_ID, Page, Type, Timestamp) VALUES ('" . $userID . "','" . $taskId . "','" . $interface . "','" . $previousinterface . "','" . $currentinterface . "','" . $QueryId . "','" . $page . "','" . $navType . "' , NOW());";
		if (!mysql_query($query)) 
		{
			$query .= mysql_error();
		}
	}
	else if ($type == 'favorite')
	{
		$QueryId = $_REQUEST['queryId'];
		$link = mysql_real_escape_string ($_REQUEST["link"]);
		$vertical = $_REQUEST["vertical"];
		$title = mysql_real_escape_string ($_REQUEST["title"]);
		$snippet = mysql_real_escape_string ($_REQUEST["snippet"]);
		$rank = $_REQUEST["rank"];
		$currentinterface = $_REQUEST["currentinterface"];

		//Save query
		$query = "INSERT INTO AggSeaFavoriteLog (User_ID, Task_ID, Interface, Current_Interface, Query_ID, Link, Vertical, Title, Snippet, Rank, Timestamp) VALUES ('" .
		    $userID . "','" . $taskId . "','" . $interface . "','" . $currentinterface . "'," . $QueryId . ",'" .
				$link . "','" . $vertical . "','" . $title . "','" . $snippet . "','" .
				$rank . "', NOW())";
		
		if (!mysql_query($query)) 
		{
			$query .= mysql_error();
		}
	}
	  
	mysql_close($con);
	// echo json_encode($response_array);

?>