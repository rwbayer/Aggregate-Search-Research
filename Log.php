<?php
	session_start();
  	include 'config.php';
	$con = mysql_connect($_DATABASEHOST, $_DATABASEUSER, $_DATABASEPASSWORD);
	if (!$con)
	{
	    die('Could not connect: ' . mysql_error());
	}
	header('Content-Type: text/html; charset=utf-8');

	mysql_set_charset('utf8', $con);
	mysql_query("SET NAMES utf8");
	mysql_select_db($_DATABASE);

	$userID = $_SESSION['userId'];
	$interface = $_SESSION['interface'];

	$type = $_REQUEST["type"];

	if ($type == 'query')
	{
		$searchQuery = mysql_real_escape_string ($_REQUEST["searchQuery"]);
		$currentinterface = $_REQUEST["currentinterface"];

		$query = "INSERT INTO AggSeaQueryLog (User_ID, Interface, Current_Interface, Search_Query, Timestamp) Values('" . $userID . "','" . $interface . "','" $currentinterface . "','" . $searchQuery . "' , NOW())";
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
		$language = $_REQUEST["language"];
		$title = mysql_real_escape_string ($_REQUEST["title"]);
		$snippet = mysql_real_escape_string ($_REQUEST["snippet"]);
		$rank = $_REQUEST["rank"];
		$currentinterface = $_REQUEST["currentinterface"];

		//Save query
		$query = "Insert into LinkLogEx (UserID, interface, QueryId, link, language, title, snippet, rank, timestamp) Values('" . $userID . "','" . $currentinterface . "','" . $QueryId . "','" . $link . "','" . $language . "','" . $title . "','" . $snippet . "','" . $rank . "' , NOW())";
		if (!mysql_query($query)) {
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
		$query = "INSERT INTO FavoriteLogEx (User_ID, Interface, Query_Id, Link, Vertical, Title, Snippet, Rank, Timestamp) VALUES (" .
		    $userID . ",'" . $currentinterface . "'," . $QueryId . ",'" .
				$link . "','" . $vertical . "','" . $title . "','" . $snippet . "','" .
				$rank . "', NOW())";
		
		if (!mysql_query($query)) 
		{
			$query .= mysql_error();
		}
	}

	mysql_close($con);
?>
