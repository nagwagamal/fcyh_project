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
					"name"	    => 		$sitecountry['name'],
					"email"	    => 		$sitecountry['email'],
					"email_key"	    => 		$sitecountry['email_key'],
					"email_verified"	    => 		$sitecountry['email_verified'],
					"mobile"	    => 		$sitecountry['mobile'],
					"mobile_key"	    => 		$sitecountry['mobile_key'],
					"mobile_verified"	    => 		$sitecountry['mobile_verified'],
					"city_id"	    => 		$sitecountry['city_id'],
					"lon"	    => 		$sitecountry['lon'],
					"lat"	    => 		$sitecountry['lat'],
					"address"	    => 		$sitecountry['address'],
					"volunteer"	    => 		$sitecountry['volunteer'],
					"type"			    => 		$sitecountry['type']
				);
			}else{return null;}
		}else{$GLOBALS['login']->doDestroy();return false;}
	}
	
	function deleteUsers($mId)
	{
		$GLOBALS['db']->query("DELETE LOW_PRIORITY FROM `".$this->tableName."` WHERE `id` = '".$mId."' LIMIT 1 ");
		return 1;
	}
	
	function setUsersInformation($user)
	{
		
		$GLOBALS['db']->query("UPDATE LOW_PRIORITY `".$this->tableName."` SET

			`name`	    = 		'".$user[name]."',
					`email`	    = 		'".$user[email]."',
					`email_key`	    = 		'".$user[email_key]."',
					`email_verified`	    = 		'".$user[email_verified]."',
					`mobile`	    = 		'".$user[mobile]."',
					`mobile_key`	    = 		'".$user[mobile_key]."',
					`mobile_verified`	    = 		'".$user[mobile_verified]."',
					`city_id`	    = 		'".$user[city_id]."',
					`lon`	    = 		'".$user[lon]."',
					`lat`	    = 		'".$user[lat]."',
					`address`	    = 		'".$user[address]."',
					`volunteer`	    = 		'".$user[volunteer]."',
					`type`			    = 		'".$user[type]."',
					`status`			    = 		'".$user[status]."'
			WHERE `id` 		    = 	'".$user[id]."' LIMIT 1 ");
		return 1;
	}
	
	function isUsersExists($name)
	{
		if($GLOBALS['login']->doCheck() == true)
		{
			$query = $GLOBALS['db']->query("SELECT * FROM `".$this->tableName."` WHERE `name` = '".$name."'  LIMIT 1 ");
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
	
	function addNewUsers($user)
	{
		$sql=$GLOBALS['db']->query("INSERT LOW_PRIORITY INTO `".$this->tableName."`
		(`id`, `name`,`email`,`email_key`,`email_verified`,`mobile`,`mobile_key`,`mobile_verified`,`city_id`,`lon`,`lat`,`address`,`volunteer`,`type`,`status`)VALUES
		( NULL ,  '".$user[name]."' ,  '".$user[email]."' ,  '".$user[email_key]."' ,  '1' ,  '".$user[mobile]."' ,  '".$user[mobile_key]."' , '1' ,  '".$user[city_id]."' ,  '".$user[lon]."' ,'".$user[lat]."' ,'".$user[address]."','0' ,'".$user[type]."' ,  '1') ");

		return 1;
	}
	
	

	

	
}
?>
