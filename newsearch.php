<?php

	if(!isset($_SESSION)) 
    { 
        session_start(); 
    } 

	header('Content-Type: text/html; charset=utf-8');

	include 'date.php';

	if($_REQUEST["searchText"]!='')
	{
	        $accountKey = '02f1ae9415b74e2e8ba145df5d767af1';

	        if ($_REQUEST["source"] == "News")
	        {
	        	$ServiceRootURL =  "https://api.cognitive.microsoft.com/bing/v5.0/news/search/";
	        }
	        else if ($_REQUEST["source"] == "Image")
	        {

	        }
	        else if ($_REQUEST["source"] == "Video")
	        {

	        }
	        else
	        {
	        	$ServiceRootURL =  "https://api.cognitive.microsoft.com/bing/v5.0/search/";
	        }
 
	        $WebSearchURL = $ServiceRootURL;

	        $context = stream_context_create(array(
	            'http' => array(
	                'request_fulluri' => true,
	                'header'  => "Ocp-Apim-Subscription-Key: " . $accountKey
	            ),
	            'ssl' => array(
 					'verify_peer'      => false,
 					'verify_peer_name' => false,
 				)
	        ));

			$request = $WebSearchURL . '?q=' . urlencode('\'' . $_REQUEST["searchText"] . '\'') . '&mkt=' . urlencode('\'' . $_REQUEST["market"]  . '\'') . '&count=' . $_REQUEST["results"] . '&offset=' . $_REQUEST["offset"];

	        $response = file_get_contents($request, 0, $context);
        
	        $jsonobj = json_decode($response);
        
	        $data = '<div ID="resultList">';

	        
	        if ($_REQUEST["source"] == "Image")
        	{
        		foreach($jsonobj->images->value as $value)
        		{
        			$data .= '<div class=\'image\'><a href="' . $value->hostPageUrl . '">';
            		$data .= '<img src="' . $value->contentUrl . '" height="auto" width="150">';
            		$data .= '</a></div>';
            	}
        	}
        	else if ($_REQUEST["source"] == "Video")
        	{
        		foreach($jsonobj->videos->value as $value)
        		{
        			$data .= '<div class=\'video\'><a href="' . $value->hostPageUrl . '">';
            		$data .= '<img src="' . $value->thumbnailUrl . '" height="auto" width="160">';
            		$data .= '</a></div>';
            	}
        	}
        	else if ($_REQUEST["source"] == "News")
        	{
        		foreach($jsonobj->value as $value)
        		{
        			$data .= '<div class="resultlistitem"><div class=\'title\'><a href="' . $value->url . '">';
            		$data .= strip_tags($value->name);
            		$data .= '</a></div>';
			
					$data .= '<div class=\'url\'>' . urldecode($value->provider->name);
					$news_date = urldecode($value->datePublished);
					$year = substr($news_date,0, 4);
					$month = substr($news_date,5,2);
					$day = substr($news_date,8,2);

					$data .= ' - ' . $month . '/' . $day . '/' . $year  . '</div>';
				
					$data .= '<div class=\'snippet\'>' . strip_tags($value->description) . '</div>';
					$data .= '</div>';
				}
        	}
        	else
        	{
        		foreach($jsonobj->webPages->value as $value)
        		{
	        		$data .= '<div class="resultlistitem"><div class=\'title\'><a href="' . $value->url . '">';
	            	$data .= strip_tags($value->name);
	            	$data .= '</a></div>';
	            	$data .= '<div class=\'url\'>' . urldecode($value->displayUrl) . '</div>';
	            	$data .= '<div class=\'snippet\'>' . strip_tags($value->snippet) . '</div>';
					$data .= '</div>';
				}
        	}  
        
	        $data .= "</div>";
	}

	$returnObject = (object) [
	    'data' => $data,
	    'source' => $_REQUEST["source"],
	    'i' => $_REQUEST["i"],
	    'searchText' => $_REQUEST["searchText"]
	  ];

	exit(json_encode($response));
?>