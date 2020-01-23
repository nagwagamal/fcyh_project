<?php if(!defined("inside"))exit;
/*/////////////////////////////////////
* Filename: admin-lengths.php
* Purpose: site settings actions ( update ).
* Author: ibnkamal@msn.com
* Date: 04/04/2015
/////////////////////////////////////*/
class systemTasks
{
   var $tableName="tasks";
   function addNewTasks($task)
	{
		$sql=$GLOBALS['db']->query("INSERT LOW_PRIORITY INTO `".$this->tableName."`
		(`id`, `tittle`,`cat_id`,`description`,`img`,`lon`,`lat`,`assiged_to`,`user_id`,`requested_time`,`arrived_time`,`total_time`,`review`,`status`)VALUES
		( NULL ,  '".$task[title]."' ,  '".$task[cat_id]."' ,  '".$task[description]."' ,  '".$task[img]."' ,  '".$task[lon]."' ,  '".$task[lat]."' ,  '".$task[assiged_to]."' ,  '".$task[user_id]."' ,  '".$task[requested_time]."' ,'".$task[arrived_time]."' ,'".$task[total_time]."','".$task[review]."' ,  '1') ");

		return 1;
	}
    function getTotalTasks($addon = "")
	{
		if($GLOBALS['login']->doCheck() == true)
		{
			$query 				= $GLOBALS['db']->query("SELECT COUNT(*) AS `total` FROM `".$this->tableName."` ");
			$queryTotal 		= $GLOBALS['db']->fetchrow();
			$total 				= $queryTotal['total'];
			return ($total);
		}else{$GLOBALS['login']->doDestroy();return false;}
	}
    function getsiteTasks($addon = "")
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
    function deleteTasks($mId)
	{
		$GLOBALS['db']->query("DELETE LOW_PRIORITY FROM `".$this->tableName."` WHERE `id` = '".$mId."' LIMIT 1 ");
		return 1;
	}
    function getTasksInformation($mId)
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
					"tittle"	    => 		$sitecountry['tittle'],
					"cat_id"	    => 		$sitecountry['cat_id'],
					"description"	    => 		$sitecountry['description'],
					"img "	    => 		$sitecountry['img '],
					"lon"	    => 		$sitecountry['lon'],
					"lat"	    => 		$sitecountry['lat'],
					"assiged_to"	    => 		$sitecountry['assiged_to'],
					"user_id"	    => 		$sitecountry['user_id'],
					"requested_time"	    => 		$sitecountry['requested_time'],
					"arrived_time"	    => 		$sitecountry['arrived_time'],
					"total_time"	    => 		$sitecountry['total_time'],
					"review"	    => 		$sitecountry['review'],
					"status"			    => 		$sitecountry['status']
				);
			}else{return null;}
		}else{$GLOBALS['login']->doDestroy();return false;}
	}
    function setTasksInformation($_task)
	{

		$GLOBALS['db']->query("UPDATE LOW_PRIORITY `".$this->tableName."` SET

			`tittle`	    = 		'".$_task[tittle]."',
					`description`	    = 		'".$_task[description]."',
					`img`	    = 		'".$_task[img]."',
					`lon`	    = 		'".$_task[lon]."',
					`lat`	    = 		'".$_task[lat]."',
					`assiged_to`	    = 		'".$_task[assiged_to]."',
					`user_id`	    = 		'".$_task[user_id]."',
					`requested_time`	    = 		'".$_task[requested_time]."',
					`arrived_time`	    = 		'".$_task[arrived_time]."',
					`total_time`	    = 		'".$_task[total_time]."',
					`review`	    = 		'".$_task[review]."'

			WHERE `id` 		    = 	'".$_task[id]."' LIMIT 1 ");
		return 1;
	}


}
?>
