<?php

	if(!isset($_SESSION)) 
    { 
        session_start(); 
    } 

	header('Content-Type: text/html; charset=utf-8');

	include 'date.php';

	if($_REQUEST["searchText"]!='')
	{
	        $accountKey = '2Lmd9VneTkyPpUqPyZeDiSBdRRSDDfvZikK9l+J81W0';
	        $ServiceRootURL =  "https://api.datamarket.azure.com/Bing/Search/";
 
	        $WebSearchURL = $ServiceRootURL . $_REQUEST["source"] .'?$format=json&$top=' . $_REQUEST["results"] . '&$skip=' . $_REQUEST["offset"] ;

	        $context = stream_context_create(array(
	            'http' => array(
	                'request_fulluri' => true,
	                'header'  => "Authorization: Basic " . base64_encode($accountKey . ":" . $accountKey)
	            ),
	            'ssl' => array(
 					'verify_peer'      => false,
 					'verify_peer_name' => false,
 				)
	        ));

			$request = $WebSearchURL . '&Query=' . urlencode('\'' . $_REQUEST["searchText"] . '\'') . '&Market=' . urlencode('\'' . $_REQUEST["market"]  . '\'');

	        $response = file_get_contents($request, 0, $context);
        
	        $jsonobj = json_decode($response);
        
	        $data = '<div ID="resultList">';

			$i = 1;

	        foreach($jsonobj->d->results as $value)
	        {
	        	if ($_REQUEST["source"]=="Image")
	        	{
	        		$data .= '<div class=\'image\' rank="rank' . $i . '"><a class="image" href="' . $value->SourceUrl . '" vertical="Image" style="background-image: url(' . $value->Thumbnail->MediaUrl . ');">';
	            	$data .= '</a><a href="javascript:;" class="favButton" vertical="Image">Relevant</a></div>';
	        	}
	        	else if ($_REQUEST["source"]=="Video")
	        	{
	        		$data .= '<div class=\'video\' rank="rank' . $i . '"><a class="image" href="' . $value->MediaUrl . '" vertical="Video" style="background-image: url(' . $value->Thumbnail->MediaUrl . ');">';
	            	$data .= '</a><a href="javascript:;" class="favButton" vertical="Video">Relevant</a></div>';
	        	}
	        	else
	        	{
	        		$data .= '<div class="resultlistitem" rank="rank' . $i . '"><div class=\'title\'>';
	            	
				
					if($_REQUEST["source"]=="News")
					{
						$data .= '<a class="title" href="' . $value->Url . '" target="' . $target . '" vertical="News">';
	            		$data .= strip_tags($value->Title);
	            		$data .= '</a>';
						$data .= '<a href="javascript:;" class="favButton" vertical="News">Relevant</a>';
	            		$data .= '</div>';
						$data .= '<div class=\'url\'>' . urldecode($value->Source);
						$news_date = urldecode($value->Date);
						$year = substr($news_date,0, 4);
						$month = substr($news_date,5,2);
						$day = substr($news_date,8,2);

						$data .= ' - ' . $month . '/' . $day . '/' . $year  . '</div>';
					}
					else
					{
						$data .= '<a class="title" href="' . $value->Url . '" target="' . $target . '" vertical="Web">';
	            		$data .= strip_tags($value->Title);
	            		$data .= '</a>';
						$data .= '<a href="javascript:;" class="favButton" vertical="Web">Relevant</a>';
						$data .= '</div>';
						$data .= '<div class=\'url\'>' . urldecode($value->Url) . '</div>';
					}
					
					$data .= '<div class=\'snippet\'>' . strip_tags($value->Description) . '</div>';
					$data .= '</div>';
	        	}   
	            $i++;
	        }
        
	        $data .= "</div>";
	}

	$returnObject = (object) [
	    'data' => $data,
	    'source' => $_REQUEST["source"],
	    'i' => $_REQUEST["i"],
	    'searchText' => $_REQUEST["searchText"]
	  ];

	exit(json_encode($returnObject));
?>