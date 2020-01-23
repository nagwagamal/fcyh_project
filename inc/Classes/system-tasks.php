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
		( NULL ,  '".$task[tittle]."' ,  '".$task[category]."' ,  '".$task[description]."' ,  '".$task[img]."' ,  '".$task[lon]."' ,  '".$task[lat]."' ,  '".$task[assiged_to]."' ,  '".$task[user_id]."' ,  '".$task[requested_time]."' ,'".$task[arrived_time]."' ,'".$task[total_time]."','".$task[review]."' ,  '1') ");

		return 1;
	}
}
?>
