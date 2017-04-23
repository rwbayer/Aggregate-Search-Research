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
	        
	        $ServiceRootURL =  "https://api.cognitive.microsoft.com/bing/v5.0/news/search";

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

			$request = $WebSearchURL . '?q=' . urlencode( $_REQUEST["searchText"] ) . '&mkt=' . urlencode( $_REQUEST["market"]  ) . '&count=' . $_REQUEST["results"] . '&offset=' . $_REQUEST["offset"];

	        $response = file_get_contents($request, 0, $context);
	    
	        $jsonobj = json_decode($response);
	    
	        $i = 1;
	        
	        
			if (is_array($jsonobj->value) || is_object($jsonobj->value))
			{
				$received = true;
				$data = '<div ID="resultList">';

	    		foreach($jsonobj->value as $value)
	    		{
					$data .= '<div class="resultlistitem" rank="rank' . $i . '"><div class=\'title\'>';

					$data .= '<a class="title fancybox fancybox.iframe" href="' . $value->url . '" target="' . $target . '" vertical="News">';
	        		$data .= strip_tags($value->name);
	        		$data .= '</a>';
					$data .= '<a href="javascript:;" class="favButton relevant" vertical="News">Relevant</a>';
	        		$data .= '</div>';
					$data .= '<div class=\'url\'>' . urldecode($value->provider[0]->name);
					$news_date = urldecode($value->datePublished);
					$year = substr($news_date,0, 4);
					$month = substr($news_date,5,2);
					$day = substr($news_date,8,2);

					$data .= ' - ' . $month . '/' . $day . '/' . $year  . '</div>';


					$data .= '<div class=\'snippet\'>' . strip_tags($value->description) . '</div>';
					$data .= '</div>';
					$i++;
				}

				$data .= "</div>";
			}
		}
	}

	$returnObject = (object) [
	    'data' => $data,
	    'source' => $_REQUEST["source"],
	    'i' => $_REQUEST["i"],
	    'searchText' => $_REQUEST["searchText"]
	  ];

	exit(json_encode($returnObject));
?>