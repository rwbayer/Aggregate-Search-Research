<?php

	if(!isset($_SESSION)) 
    { 
        session_start(); 
    } 

	header('Content-Type: text/html; charset=utf-8');

	include 'date.php';

	if($_REQUEST["searchText"]!='')
	{
        $accountKey = '7b9cec439fc24fbeaafa5349ad4a2105';

        $ServiceRootURL =  "https://api.cognitive.microsoft.com/bing/v5.0/images/search";

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
			$data = '<div ID="resultList">';

			foreach($jsonobj->value as $value)
    		{

        		$data .= '<div class=\'image\' rank="rank' . $i . '"><a uniqueid="' . $value->imageId . '" class="image" title="' . $value->name . '" href="' . $value->hostPageUrl . '" vertical="Image" style="background-image: url(' . $value->thumbnailUrl . ');">';
            	$data .= '</a><a href="javascript:;" class="favButton relevant" vertical="Image">Relevant</a></div>';
        		$i++;
        	}

        	$data .= "</div>";
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