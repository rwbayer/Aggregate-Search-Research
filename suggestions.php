<?php   
	if(!isset($_SESSION)) 
    { 
        session_start(); 
    } 

	header('Content-Type: text/html; charset=utf-8');

	include 'date.php';

	if($_POST["searchText"]!='')
	{
	    $accountKey = 'cae409a141334c12803754295da9a25b';
	    $ServiceRootURL =  "https://api.cognitive.microsoft.com/bing/v5.0/suggestions/";

	    $WebSearchURL = $ServiceRootURL;

	    $context = stream_context_create(array(
	        'http' => array(
	            'request_fulluri' => true,
	            'header'  => 'Ocp-Apim-Subscription-Key: ' . $accountKey
	        ),
	        'ssl' => array(
					'verify_peer'      => false,
					'verify_peer_name' => false,
				)
	    ));

		$request = $WebSearchURL . '?q=' . urlencode('\'' . $_POST["searchText"] . '\'');

	    $response = file_get_contents($request, 0, $context);

	    $jsonobj = json_decode($response);

	    $count == 0;

	    foreach($jsonobj->suggestionGroups as $group)
	    {
	    	foreach($group->searchSuggestions as $value)
	    	{
	    		if ($count == 3)
	    			break;

	    		$data .= '<a class="suggestionLink" href="">';
	            $data .= $value->displayText;
	            $data .= '</a>';
	            $count++;
	    	}

	    	if ($count == 3)
	    		break;
	    }
   	}
	exit($data);
?>