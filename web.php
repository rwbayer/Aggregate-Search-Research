<?php

	if(!isset($_SESSION)) 
    { 
        session_start(); 
    } 

	header('Content-Type: text/html; charset=utf-8');

	include 'date.php';

	if($_REQUEST["searchText"]!='')
	{
		$received = false;
		while (!$received)
		{
	        $accountKey = '7b9cec439fc24fbeaafa5349ad4a2105';

	        $ServiceRootURL =  "https://api.cognitive.microsoft.com/bing/v5.0/search";

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

			$request = $WebSearchURL . '?q=' . urlencode( $_REQUEST["searchText"] ) . '&mkt=' . urlencode( $_REQUEST["market"]  ) . '&count=' . $_REQUEST["results"] . '&offset=' . $_REQUEST["offset"] . "&responsefilter=webpages";

	        $response = file_get_contents($request, 0, $context);
	    
	        $jsonobj = json_decode($response);
	    
	        $i = 1;
	        
			if (is_array($jsonobj->webPages->value) || is_object($jsonobj->webPages->value))
			{
				$received = true;
				$data = array();

	    		foreach($jsonobj->webPages->value as $value)
	    		{
					$item = '<div class="resultlistitem" rank="rank' . $i . '"><div class=\'title\'>';
					$item .= '<a class="title fancybox fancybox.iframe" href="' . $value->url . '" target="' . $target . '" vertical="Web">';
	        		$item .= strip_tags($value->name);
	        		$item .= '</a>';
					$item .= '<a href="javascript:;" class="favButton relevant" vertical="Web">Relevant</a>';
					$item .= '</div>';
					$item .= '<div class=\'url\'>' . urldecode($value->displayUrl) . '</div>';
					$item .= '<div class=\'snippet\'>' . strip_tags($value->snippet) . '</div>';
					$item .= '</div>';
					array_push($data, $item);
					$i++;
				}
			} 
		}
	}

	$returnObject = (object) [
	    'data' => $data,
	    'source' => "Web",
	    'searchText' => $_REQUEST["searchText"]
	  ];

	exit(json_encode($returnObject));
?>