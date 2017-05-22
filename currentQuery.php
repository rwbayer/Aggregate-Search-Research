<?php

	if(!isset($_SESSION)) 
    { 
        session_start(); 
    } 	
    include 'config.php';

	header('Content-Type: text/html; charset=utf-8');

	$returnObject = (object) [
	    'currentQuery' => $_SESSION['current_query'],
	    'uID' => $_POST["uID"],
	    'time' => $_POST["time"],
	    'link' => $_POST["link"],
	    'thumbnailLink' => $_POST["thumbnailLink"],
	    'vertical' => $_POST["vertical"],
	    'title' => $_POST["title"],
	    'snippet' => $_POST["snippet"],
	    'rank' => $_POST["rank"],
	    'currentinterface' => $_POST["currentinterface"]
	  ];
	
	exit(json_encode($returnObject));
?>