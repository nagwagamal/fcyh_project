<?php if(!defined("inside")) exit;

/*/////////////////////////////////////
* Filename: admin-lengths.php
* Purpose: site settings actions ( update ).
* Author: ibnkamal@msn.com
* Date: 04/04/2015
/////////////////////////////////////*/

class systemChats
{
	var $tableName 	= "chats";

	function getsiteChat($addon = "")
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

	function getTotalChat($addon = "")
	{
		if($GLOBALS['login']->doCheck() == true)
		{
			$query 				= $GLOBALS['db']->query("SELECT COUNT(*) AS `total` FROM `".$this->tableName."` ");
			$queryTotal 		= $GLOBALS['db']->fetchrow();
			$total 				= $queryTotal['total'];
			return ($total);
		}else{$GLOBALS['login']->doDestroy();return false;}
	}
	
	
	function getChatInformation($mId)
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
					"from_user"	    => 		$sitecountry['from_user'],
					"to_user"	    => 		$sitecountry['to_user'],
					"message"	    => 		$sitecountry['message'],
					"time"			    => 		$sitecountry['time']
				);
			}else{return null;}
		}else{$GLOBALS['login']->doDestroy();return false;}
	}
		
}
?>