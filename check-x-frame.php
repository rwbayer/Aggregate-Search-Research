<?php
		$xFrame = false;

    	// Check for x-frame header setting
    	$url_headers = get_headers($_GET['url']);
		foreach ($url_headers as $key => $value)
		{
			$x_frame_options_deny = strpos(strtolower($url_headers[$key]), strtolower('X-Frame-Options: DENY'));
			$x_frame_options_sameorigin = strpos(strtolower($url_headers[$key]), strtolower('X-Frame-Options: SAMEORIGIN'));
			$x_frame_options_allow_from = strpos(strtolower($url_headers[$key]), strtolower('X-Frame-Options: ALLOW-FROM'));
			$x_frame_options_allow_from = strpos(strtolower($url_headers[$key]), strtolower('frame-ancestors'));
			if ($x_frame_options_deny !== false || $x_frame_options_sameorigin !== false || $x_frame_options_allow_from !== false)
			{
				$xFrame = true;
			}
		}
		
		if($xFrame || sizeof($url_headers)<2)
		{
			echo "true";
		}
		else
		{
			echo "false";
		}
?>


