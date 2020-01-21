<?php if(!defined("inside")) exit;

/*/////////////////////////////////////
* Filename: admin-lengths.php
* Purpose: site settings actions ( update ).
* Author: ibnkamal@msn.com
* Date: 04/04/2015
/////////////////////////////////////*/

class systemCities
{
	var $tableName 	= "cities";

	function getsiteCities($addon = "",$governorate = 0)
	{
		if($GLOBALS['login']->doCheck() == true)
		{
			if($governorate == 0)
			{
				 $query = $GLOBALS['db']->query("SELECT * FROM `".$this->tableName."` ORDER BY  `id` DESC ".$addon);
			}else
			{
			     $query = $GLOBALS['db']->query("SELECT * FROM `".$this->tableName."` WHERE `gov_id` = '".$governorate."' ORDER BY `id` DESC ".$addon);
			}
			 $queryTotal = $GLOBALS['db']->resultcount();
			if($queryTotal > 0)
			{
				return($GLOBALS['db']->fetchlist());
			}else{return null;}
		}else{$GLOBALS['login']->doDestroy();return false;}
	}

	function getTotalCities($addon = "")
	{
		if($GLOBALS['login']->doCheck() == true)
		{
			$query 				= $GLOBALS['db']->query("SELECT COUNT(*) AS `total` FROM `".$this->tableName."` ");
			$queryTotal 		= $GLOBALS['db']->fetchrow();
			$total 				= $queryTotal['total'];
			return ($total);
		}else{$GLOBALS['login']->doDestroy();return false;}
	}
	function getCitiesInformation($mId)
	{
		if($GLOBALS['login']->doCheck() == true)
		{
			$query = $GLOBALS['db']->query("SELECT * FROM `".$this->tableName."` WHERE `id` = '".$mId."' LIMIT 1 ");
			$queryTotal = $GLOBALS['db']->resultcount();
			if($queryTotal > 0)
			{
				$sitecountry = $GLOBALS['db']->fetchitem($query);
				return array(
					"id"				    => 		$sitecountry['id'],
					"gov_id "			    => 		$sitecountry['gov_id'],
					"city_name"		        => 		$sitecountry['city_name'],
					"city_name_ar"		        => 		$sitecountry['city_name_ar'],
					"status"			    => 		$sitecountry['status']
				);
			}else{return null;}
		}else{$GLOBALS['login']->doDestroy();return false;}
	}
	
	
	
	function deleteCities($mId)
	{
		$GLOBALS['db']->query("DELETE LOW_PRIORITY FROM `".$this->tableName."` WHERE `id` = '".$mId."' LIMIT 1 ");
		return 1;
	}
	
	function setCitiesInformation($city)
	{
		
		$GLOBALS['db']->query("UPDATE LOW_PRIORITY `".$this->tableName."` SET
			`gov_id`			=	'".$city[governorate]."',
			`city_name_ar`		    =	'".$city[city_name_ar]."',
			`city_name`		    =	'".$city[city_name]."',
			`status`		    =	'".$city[status]."'
			WHERE `id` 		    = 	'".$city[id]."' LIMIT 1 ");

		return 1;
	}
	
	function isCitiesExists($name)
	{
		if($GLOBALS['login']->doCheck() == true)
		{
			$query = $GLOBALS['db']->query("SELECT * FROM `".$this->tableName."` WHERE  `city_name_ar` = '".$name."' LIMIT 1 ");
			$queryTotal = $GLOBALS['db']->resultcount();
			if($queryTotal == 1)
			{
				$sitecity = $GLOBALS['db']->fetchitem($query);
				return array(
					"id"			=> 		$sitecity['id'],
				);


			}else{return true;}
		}else{$GLOBALS['login']->doDestroy();return false;}
	}
	
	function addNewCities($city)
	{
		
		$sql=$GLOBALS['db']->query("INSERT LOW_PRIORITY INTO `".$this->tableName."`
		(`id`, `gov_id`, `city_name_ar`,`city_name` , `status`)VALUES
		( NULL ,  '".$city[gov_id]."' ,'".$city[city_name_ar]."','".$city[city_name]."','1') ");

		return 1;
	}
	function activestatusCities($mId,$status)
	{  
		if($status==1)
		{
			$GLOBALS['db']->query("UPDATE LOW_PRIORITY `".$this->tableName."` SET
			`status`    =	'0'
			 WHERE `id` 		 = 	'".$mId."' LIMIT 1 ");
			return 1;
		}else
		{
			$GLOBALS['db']->query("UPDATE LOW_PRIORITY `".$this->tableName."` SET
				`status`    =	'1'
			 	WHERE `id` 		 = 	'".$mId."' LIMIT 1 ");
			return 1;
		}
	}
	



	

	
}
?>
