<?php if(!defined("inside")) exit;

/*/////////////////////////////////////
* Filename: admin-lengths.php
* Purpose: site settings actions ( update ).
* Author: ibnkamal@msn.com
* Date: 04/04/2015
/////////////////////////////////////*/

class systemCategories
{
	var $tableName 	= "categories";

	function getsiteCategories($addon = "")
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
function getsiteCategories_1(){
    if($GLOBALS['login']->doCheck() == true)
    {
      $query = $GLOBALS['db']->query("SELECT * FROM `".$this->tableName."` where `parent_id` is null ORDER BY `id` DESC ".$addon);
			 $queryTotal = $GLOBALS['db']->resultcount();
			if($queryTotal > 0)
			{
				return($GLOBALS['db']->fetchlist());
			}else{return null;}
		}else{$GLOBALS['login']->doDestroy();return false;}
    }

	function getTotalCategories($addon = "")
	{
		if($GLOBALS['login']->doCheck() == true)
		{
			$query 				= $GLOBALS['db']->query("SELECT COUNT(*) AS `total` FROM `".$this->tableName."` ");
			$queryTotal 		= $GLOBALS['db']->fetchrow();
			$total 				= $queryTotal['total'];
			return ($total);
		}else{$GLOBALS['login']->doDestroy();return false;}
	}
	function getCategoriesInformation($mId)
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
					"cat_name"			    => 		$sitecountry['cat_name'],
					"parent_id"		        => 		$sitecountry['parent_id'],
					"description"		        => 		$sitecountry['description'],
					"img"		        => 		$sitecountry['img'],
					"status"			    => 		$sitecountry['status']
				);
			}else{return null;}
		}else{$GLOBALS['login']->doDestroy();return false;}
	}



	function deleteCategories($mId)
	{
		$GLOBALS['db']->query("DELETE LOW_PRIORITY FROM `".$this->tableName."` WHERE `id` = '".$mId."' LIMIT 1 ");
		return 1;
	}

	function setCategoriesInformation($city)
	{
		if ($city[category] == 0 ){
		$GLOBALS['db']->query("UPDATE LOW_PRIORITY `".$this->tableName."` SET
			`cat_name`		    =	'".$city[cat_name]."',
			`parent_id`		    =	null ,
			`description`		    =	'".$city[description]."',
			`img`		    =	'".$city[img]."',
			`status`		    =	'".$city[status]."'
			WHERE `id` 		    = 	'".$city[id]."' LIMIT 1 ");

		return 1;}
        else{
            $GLOBALS['db']->query("UPDATE LOW_PRIORITY `".$this->tableName."` SET
			`cat_name`		    =	'".$city[cat_name]."',
			`parent_id`		    =	'".$city[category]."',
			`description`		    =	'".$city[description]."',
			`img`		    =	'".$city[img]."',
			`status`		    =	'".$city[status]."'
			WHERE `id` 		    = 	'".$city[id]."' LIMIT 1 ");

		return 1;
        }
	}

	function isCategoriesExists($name)
	{
		if($GLOBALS['login']->doCheck() == true)
		{
			$query = $GLOBALS['db']->query("SELECT * FROM `".$this->tableName."` WHERE  `cat_name` = '".$name."' LIMIT 1 ");
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

	function addNewCategories($city)
	{

		$sql=$GLOBALS['db']->query("INSERT LOW_PRIORITY INTO `".$this->tableName."`
		(`id`, `cat_name`, `parent_id`, `description`, `img`, `status`)VALUES
		( NULL ,  '".$city[cat_name]."',NULL ,'".$city[description]."','".$city[img]."','1') ");

		return 1;
	}
    function addNewCategories_1($city)
	{

		$sql=$GLOBALS['db']->query("INSERT LOW_PRIORITY INTO `".$this->tableName."`
		(`id`, `cat_name`, `parent_id`, `description`, `img`, `status`)VALUES
		( NULL ,  '".$city[cat_name]."' ,'".$city[parent_id]."','".$city[description]."','".$city[img]."','1') ");

		return 1;
	}
	function activestatusCategories($mId,$status)
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
