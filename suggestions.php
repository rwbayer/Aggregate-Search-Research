<?php   
	if(!isset($_SESSION)) 
    { 
        session_start(); 
    } 

	header('Content-Type: text/html; charset=utf-8');

	include 'date.php';

	if($_REQUEST["searchText"]!='')
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

		$request = $WebSearchURL . '?q=' . urlencode('\'' . $_REQUEST["searchText"] . '\'');

	    $response = file_get_contents($request, 0, $context);

	    $jsonobj = json_decode($response);

	    foreach($jsonobj->suggestionGroups as $group)
	    {
	    	foreach($group->searchSuggestions as $value)
	    	{
	    		$data .= '<a class="suggestionLink" href="">';
	            $data .= $value->displayText;
	            $data .= '</a>';
	    	}
	    }
   	}
	exit($data);
?>