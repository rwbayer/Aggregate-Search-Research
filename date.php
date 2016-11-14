<?php

if(!isset($_SESSION)) 
    { 
        session_start(); 
    } 

class Date_Difference
{
    public static function getStringResolved($date, $market, $compareTo = NULL)
    {
	
		//Fix Chinese timezone (part 1)
		if($market=='zh-CN' || $market=='zh-HK' || $market=='zh-TW')
		{
			date_default_timezone_set('Asia/Shanghai');
		}
		else
		{
			date_default_timezone_set('UTC');
		}
	
        if(!is_null($compareTo)) {
            $compareTo = new DateTime($compareTo);
        }
        return self::getString(new DateTime($date), $market, $compareTo);
    }

    public static function getString(DateTime $date, $market, DateTime $compareTo = NULL)
    {
		$localised = $_SESSION['localised'];
	
        if(is_null($compareTo)) {
            $compareTo = new DateTime('now');
        }

		//Fix Chinese timezone (part 2)
		if($market=='zh-CN' || $market=='zh-HK' || $market=='zh-TW')
		{
			$date = new DateTime ( $date->format('Y-m-d H:i:s') , new DateTimeZone('Asia/Shanghai' ));
		}

        $diff = $compareTo->format('U') - $date->format('U');
        $dayDiff = floor($diff / 86400);

    	if(is_nan($dayDiff) || $dayDiff < 0) {
    		return $date->format('Y-m-d H:i:s');
        }

    	if($dayDiff == 0) {
            if($diff < 60) {
                return $localised['Just now'];
            } elseif($diff < 120) {
                return $localised['1 minute ago'];
            } elseif($diff < 3600) {
                return $localised['time-dummy'] . floor($diff/60) . $localised[' minutes ago'];
            } elseif($diff < 7200) {
                return $localised['1 hour ago'];
            } elseif($diff < 86400) {
                return $localised['time-dummy'] . floor($diff/3600) . $localised[' hours ago'];
            }
			else{
				return $date->format('Y-m-d');	
			}
        } elseif($dayDiff == 1) {
            return $localised['Yesterday'];
        } else {
            return $date->format('Y-m-d');
        }
    }
}

?>