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

	$type = $_REQUEST["type"];

	if ($type == 'query')
	{
		$searchQuery = mysql_real_escape_string ($_REQUEST["searchQuery"]);
		$currentinterface = $_REQUEST["currentinterface"];

		$query = "INSERT INTO AggSeaQueryLog (User_ID, Interface, Current_Interface, Search_Query, Time) VALUES ('" . $userID . "','" . $interface . "','" . $currentinterface . "','" . $searchQuery . "' , NOW());";
		if (!mysql_query($query)) 
		{
			$query .= mysql_error();
		}
		else
		{
			$_SESSION['current_query'] = mysql_insert_id();
		}
	}
	else if($type=='edit')
	{
		$QueryId = $_SESSION['current_query'];
		$editedQuery = mysql_real_escape_string ($_REQUEST["editedQuery"]);
		$language = $_REQUEST["language"];

		//Save query
		$query = "Insert into EditLogEx (userID, interface, QueryId, editedQuery, language, timestamp) Values('" . $userID . "','" . $interface . "','" . $QueryId . "','" . $editedQuery . "','" . $language . "' , NOW())";
		if (!mysql_query($query)) {
			$query .= mysql_error();
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
		$query = "INSERT INTO AggSeaLinkLog (User_ID, Interface, Current_Interface, Query_ID, Link, Vertical, Title, Snippet, Rank, Timestamp) VALUES ('" . $userID . "','" . $interface . "','" . $currentinterface . "','" . $QueryId . "','" . $link . "','" . $vertical . "','" . $title . "','" . $snippet . "','" . $rank . "' , NOW());";
		if (!mysql_query($query)) 
		{
			$query .= mysql_error();
		}
	}
	else if ($type == 'nav')
	{
		$QueryId = $_SESSION['current_query'];
		$page = mysql_real_escape_string ($_REQUEST["page"]);
		$type = mysql_real_escape_string ($_REQUEST["type"]);
		$previousinterface = $_REQUEST["previousinterface"];
		$currentinterface = $_REQUEST["currentinterface"];

		//Save query
		$query = "INSERT INTO AggSeaNavLog (User_ID, Interface, Previous_Interface, Current_Interface, Query_ID, Page, Type, Timestamp) VALUES ('" . $userID . "','" . $interface . "','" . $previousinterface . "','" . $currentinterface . "','" . $QueryId . "','" . $page . "','" . $type . "' , NOW());";
		if (!mysql_query($query)) 
		{
			$query .= mysql_error();
		}
		echo $query;
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
		$query = "INSERT INTO AggSeaFavoriteLog (User_ID, Interface, Current_Interface, Query_ID, Link, Vertical, Title, Snippet, Rank, Timestamp) VALUES (" .
		    $userID . ",'" . $interface . "','" . $currentinterface . "'," . $QueryId . ",'" .
				$link . "','" . $vertical . "','" . $title . "','" . $snippet . "','" .
				$rank . "', NOW())";
		
		if (!mysql_query($query)) 
		{
			$query .= mysql_error();
		}
	}

	mysql_close($con);
?>
