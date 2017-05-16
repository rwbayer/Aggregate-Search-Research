<?php

	if(!isset($_SESSION)) 
    { 
        session_start(); 
    } 

	header('Content-Type: text/html; charset=utf-8');

	include 'date.php';
	include 'config.php';
	include 'redirect.php';

	if($_REQUEST["searchText"]!='')
	{
		$received = false;
		while (!$received)
		{
	        $accountKey = $_MSAZUREACCOUNTKEY;
	        
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

	        $response = @file_get_contents($request, 0, $context);
	    
	        $jsonobj = json_decode($response);
	    
	        $i = 1;
	        
	        
			if (is_array($jsonobj->value) || is_object($jsonobj->value))
			{
				$received = true;
				$data = array();

	    		foreach($jsonobj->value as $value)
	    		{
	    			$finalURL = get_redirect_url($value->url);

					$item = '<div class="resultlistitem" rank="rank' . $i . '"><div class=\'title\'>';

					$item .= '<a class="title fancybox fancybox.iframe" href="' . $finalURL . '" target="' . $target . '" vertical="News">';
	        		$item .= strip_tags($value->name);
	        		$item .= '</a>';
					$item .= '<a href="javascript:;" class="favButton relevant" vertical="News">Relevant</a>';
	        		$item .= '</div>';
					$item .= '<div class=\'url\'>' . urldecode($value->provider[0]->name);
					$news_date = urldecode($value->datePublished);
					$year = substr($news_date,0, 4);
					$month = substr($news_date,5,2);
					$day = substr($news_date,8,2);

					$item .= ' - ' . $month . '/' . $day . '/' . $year  . '</div>';


					$item .= '<div class=\'snippet\'>' . strip_tags($value->description) . '</div>';
					$item .= '</div>';
					array_push($data, $item);
					$i++;
				}
			}
		}
	}

	$returnObject = (object) [
	    'data' => $data,
	    'source' => "News",
	    'searchText' => $_REQUEST["searchText"]
	  ];

	exit(json_encode($returnObject));
?>