<?php

	// if(!isset($_SESSION)) 
 //    { 
 //        session_start(); 
 //    } 

	header('Content-Type: text/html; charset=utf-8');

	include 'date.php';
    include 'config.php';
    include 'redirect.php';

	if($_POST["searchText"]!='')
	{
        $received = false;
        while(!$received)
        {
            $accountKey = $_MSAZUREACCOUNTKEY;

            $ServiceRootURL =  "https://api.cognitive.microsoft.com/bing/v5.0/videos/search";

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

    		$request = $WebSearchURL . '?q=' . urlencode( $_POST["searchText"] ) . '&mkt=' . urlencode( $_POST["market"]  ) . '&count=' . $_POST["results"] . '&offset=' . $_POST["offset"];

            $response = @file_get_contents($request, 0, $context);
        
            $jsonobj = json_decode($response);
        
            $i = 1;
            
    		if (is_array($jsonobj->value) || is_object($jsonobj->value))
    		{
                $received = true;
    			$data = array();

        		foreach($jsonobj->value as $value)
        		{
                    $finalURL = get_final_url($value->hostPageUrl);
            		$item = '<div class=\'video\' rank="rank' . $i . '"><a uniqueid="' . $value->videoId . '" class="image fancybox fancybox.iframe" title="' . $value->name . '" href="' . $finalURL . '" vertical="Video" style="background-image: url(' . $value->thumbnailUrl . ');">';
                	$item .= '</a><a href="javascript:;" class="favButton relevant" vertical="Video">Relevant</a></div>';
            		array_push($data, $item);
                    $i++;
            	}
        	}
        }
	}

	$returnObject = (object) [
	    'data' => $data,
	    'source' => "Video",
	    'searchText' => $_POST["searchText"]
	  ];

	exit(json_encode($returnObject));
?>