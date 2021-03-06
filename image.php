<?php

	// if(!isset($_SESSION)) 
 //    { 
 //        session_start(); 
 //    } 

	header('Content-Type: text/html; charset=utf-8');

	include 'date.php';
    include 'config.php';
    include 'redirect.php';

	if($_POST["searchText"] != '')
	{
        $accountKey = $_MSAZUREACCOUNTKEY;

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

		$request = $WebSearchURL . '?q=' . urlencode( $_POST["searchText"] ) . '&mkt=' . urlencode( $_POST["market"]  ) . '&count=' . $_POST["results"] . '&offset=' . $_POST["offset"];

        $response = @file_get_contents($request, 0, $context);
    
        $jsonobj = json_decode($response);
    
        $i = 1;
        

		if (is_array($jsonobj->value) || is_object($jsonobj->value))
		{
			$data = array();

			foreach($jsonobj->value as $value)
    		{
                parse_str($value->hostPageUrl, $output);
                $finalURL = $output['r'];
        		$item = '<div class=\'image \' rank="rank' . $i . '"><a uniqueid="' . $value->imageId . '" class="image fancybox fancybox.iframe" title="' . $value->name . '" href="' . $finalURL . '" vertical="Image" style="background-image: url(' . $value->thumbnailUrl . ');">';
            	$item .= '</a><a href="javascript:;" class="favButton relevant" vertical="Image">Relevant</a></div>';
        		array_push($data, $item);
        		$i++;
        	}
		}
	}

	$returnObject = (object) [
	    'data' => $data,
	    'source' => "Image",
	    'searchText' => $_POST["searchText"]
	  ];

	exit(json_encode($returnObject));
?>