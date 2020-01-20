<?php if(!defined("inside")) exit;

/*/////////////////////////////////////
* Filename: admin-lengths.php
* Purpose: site settings actions ( update ).
* Author: ibnkamal@msn.com
* Date: 04/04/2015
/////////////////////////////////////*/

class systemUsers
{
	var $tableName 	= "users";

	function getsiteUsers($addon = "")
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

	function getTotalUsers($addon = "")
	{
		if($GLOBALS['login']->doCheck() == true)
		{
			$query 				= $GLOBALS['db']->query("SELECT COUNT(*) AS `total` FROM `".$this->tableName."` ");
			$queryTotal 		= $GLOBALS['db']->fetchrow();
			$total 				= $queryTotal['total'];
			return ($total);
		}else{$GLOBALS['login']->doDestroy();return false;}
	}
	
	
	function getUsersInformation($mId)
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
					"count_name"	    => 		$sitecountry['count_name'],
					"count_name_ar"	    => 		$sitecountry['count_name_ar'],
					"status"			    => 		$sitecountry['status']
				);
			}else{return null;}
		}else{$GLOBALS['login']->doDestroy();return false;}
	}
	
	function deleteUsers($mId)
	{
		$GLOBALS['db']->query("DELETE LOW_PRIORITY FROM `".$this->tableName."` WHERE `id` = '".$mId."' LIMIT 1 ");
		return 1;
	}
	
	function setUsersInformation($country)
	{
		
		$GLOBALS['db']->query("UPDATE LOW_PRIORITY `".$this->tableName."` SET
			`count_name`  =	'".$country[count_name]."',
			`count_name_ar`  =	'".$country[count_name_ar]."',
			`status`		    =	'".$country[status]."'
			WHERE `id` 		    = 	'".$country[id]."' LIMIT 1 ");
		return 1;
	}
	
	function isUsersExists($name)
	{
		if($GLOBALS['login']->doCheck() == true)
		{
			$query = $GLOBALS['db']->query("SELECT * FROM `".$this->tableName."` WHERE `count_name_ar` = '".$name."'  LIMIT 1 ");
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
	
	function addNewUsers($country)
	{
		$sql=$GLOBALS['db']->query("INSERT LOW_PRIORITY INTO `".$this->tableName."`
		(`id`, `count_name`,`count_name_ar`,`status`)VALUES
		( NULL ,  '".$country[count_name]."' ,'".$country[count_name_ar]."' ,  '1') ");

		return 1;
	}
	
	

	

	
}
?>