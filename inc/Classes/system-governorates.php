<?php if(!defined("inside")) exit;

/*/////////////////////////////////////
* Filename: admin-lengths.php
* Purpose: site settings actions ( update ).
* Author: ibnkamal@msn.com
* Date: 04/04/2015
/////////////////////////////////////*/

class systemGovernorates
{
	var $tableName 	= "governorates";

	function getsiteGovernorates($addon = "")
	{
		if($GLOBALS['login']->doCheck() == true)
		{
			$query = $GLOBALS['db']->query("SELECT * FROM `".$this->tableName."` ORDER BY `id` DESC ".$addon);
			$queryTotal = $GLOBALS['db']->resultcount();
			if($queryTotal > 0)
			{
				return($GLOBALS['db']->fetchlist());
			}else{return null;}
		}else{$GLOBALS['login']->doDestroy();return false;}
	}

	function getTotalGovernorates($addon = "")
	{
		if($GLOBALS['login']->doCheck() == true)
		{
			$query 				= $GLOBALS['db']->query("SELECT COUNT(*) AS `total` FROM `".$this->tableName."` ");
			$queryTotal 		= $GLOBALS['db']->fetchrow();
			$total 				= $queryTotal['total'];
			return ($total);
		}else{$GLOBALS['login']->doDestroy();return false;}
	}
	
	
	function getGovernoratesInformation($mId)
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
					"gov_name"	    => 		$sitecountry['gov_name'],
					"gov_name_ar"	    => 		$sitecountry['gov_name_ar'],
					"count_id"	    => 		$sitecountry['count_id'],
					"status"			    => 		$sitecountry['status']
				);
			}else{return null;}
		}else{$GLOBALS['login']->doDestroy();return false;}
	}
	
	function deleteGovernorates($mId)
	{
		$GLOBALS['db']->query("DELETE LOW_PRIORITY FROM `".$this->tableName."` WHERE `id` = '".$mId."' LIMIT 1 ");
		return 1;
	}
	
	function setGovernoratesInformation($governorate)
	{
		
		$GLOBALS['db']->query("UPDATE LOW_PRIORITY `".$this->tableName."` SET
			`gov_name_ar`  =	'".$governorate[gov_name_ar]."',
			`gov_name`  =	'".$governorate[gov_name]."',
			`count_id`  =	'".$governorate[count_id]."',
			`status`		    =	'".$governorate[status]."'
			WHERE `id` 		    = 	'".$governorate[id]."' LIMIT 1 ");

		return 1;
	}
	
	function isGovernoratesExists($name)
	{
		if($GLOBALS['login']->doCheck() == true)
		{
			$query = $GLOBALS['db']->query("SELECT * FROM `".$this->tableName."` WHERE `gov_name_ar` = '".$name."'  LIMIT 1 ");
			$queryTotal = $GLOBALS['db']->resultcount();
			if($queryTotal == 1)
			{
				$siteDepartment = $GLOBALS['db']->fetchitem($query);
				return array(
					"id"			=> 		$siteDepartment['id'],
				);


			}else{return true;}
		}else{$GLOBALS['login']->doDestroy();return false;}
	}
	
	function addNewGovernorates($governorate)
	{
		$sql=$GLOBALS['db']->query("INSERT LOW_PRIORITY INTO `".$this->tableName."`
		(`id`, `gov_name_ar`,`gov_name`,`count_id`,`status`)VALUES
		( NULL ,  '".$governorate[gov_name_ar]."' ,'".$governorate[gov_name]."' ,'".$governorate[count_id]."' ,  '1') ");

		return 1;
	}
	
	function activestatusGovernorates($mId,$status)
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