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
	        	$ServiceRootURL =  "https://api.cognitive.microsoft.com/bing/v5.0/news/search";
	        }
	        else if ($_REQUEST["source"] == "Image")
	        {
	        	$ServiceRootURL =  "https://api.cognitive.microsoft.com/bing/v5.0/images/search";
	        }
	        else if ($_REQUEST["source"] == "Video")
	        {
	        	$ServiceRootURL =  "https://api.cognitive.microsoft.com/bing/v5.0/video/search";
	        }
	        else
	        {
	        	$ServiceRootURL =  "https://api.cognitive.microsoft.com/bing/v5.0/search";
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

			$request = $WebSearchURL . '?q=' . urlencode( $_REQUEST["searchText"] ) . '&mkt=' . urlencode( $_REQUEST["market"]  ) . '&count=' . $_REQUEST["results"] . '&offset=' . $_REQUEST["offset"];

	        $response = file_get_contents($request, 0, $context);
        
	        $jsonobj = json_decode($response);
        
	        $data = '<div ID="resultList">';

	        $i = 1;
	        
	        if ($_REQUEST["source"] == "Image")
        	{
        		foreach($jsonobj->value as $value)
        		{
            		$data .= '<div class=\'image\' rank="rank' . $i . '"><a class="image" href="' . $value->hostPageUrl . '" vertical="Image" style="background-image: url(' . $value->contentUrl . ');">';
	            	$data .= '</a><a href="javascript:;" class="favButton relevant" vertical="Image">Relevant</a></div>';
            		$i++;
            	}
        	}
        	else if ($_REQUEST["source"] == "Video")
        	{
        		foreach($jsonobj->value as $value)
        		{
            		$data .= '<div class=\'video\' rank="rank' . $i . '"><a class="image" href="' . $value->hostPageUrl . '" vertical="Video" style="background-image: url(' . $value->thumbnailUrl . ');">';
	            	$data .= '</a><a href="javascript:;" class="favButton relevant" vertical="Video">Relevant</a></div>';
            		$i++;
            	}
        	}
        	else if ($_REQUEST["source"] == "News")
        	{
        		foreach($jsonobj->value as $value)
        		{
					$data .= '<div class="resultlistitem" rank="rank' . $i . '"><div class=\'title\'>';

					$data .= '<a class="title" href="' . $value->url . '" target="' . $target . '" vertical="News">';
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
        	}
        	else
        	{
        		foreach($jsonobj->webPages->value as $value)
        		{
					$data .= '<div class="resultlistitem" rank="rank' . $i . '"><div class=\'title\'>';
					$data .= '<a class="title" href="' . $value->url . '" target="' . $target . '" vertical="Web">';
            		$data .= strip_tags($value->name);
            		$data .= '</a>';
					$data .= '<a href="javascript:;" class="favButton relevant" vertical="Web">Relevant</a>';
					$data .= '</div>';
					$data .= '<div class=\'url\'>' . urldecode($value->displayUrl) . '</div>';
					$data .= '<div class=\'snippet\'>' . strip_tags($value->snippet) . '</div>';
					$data .= '</div>';
					$i++;
				}
        	}  
        
	        $data .= "</div>";
	}

	// foreach($jsonobj->d->results as $value)
	//         {
	//         	if ($_REQUEST["source"]=="Image")
	//         	{
	        		
	//         	}
	//         	else if ($_REQUEST["source"]=="Video")
	//         	{
	        		
	//         	}
	//         	else
	//         	{
	            	
				
	// 				if($_REQUEST["source"]=="News")
	// 				{
	// 				}
	// 				else
	// 				{
						
	// 				}
					
					
	//         	}   
	//             $i++;
	//         }
        
	//         $data .= "</div>";
	// }

	$returnObject = (object) [
	    'data' => $data,
	    'source' => $_REQUEST["source"],
	    'i' => $_REQUEST["i"],
	    'searchText' => $_REQUEST["searchText"]
	  ];

	exit(json_encode($returnObject));
?>