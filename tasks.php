<?php
	define("inside",true);
	define("access_admin","GitZone");

	ob_start("ob_gzhandler");

	// get funcamental file which contain config and template files,settings.
	include("./inc/fundamentals.php");

	include("./inc/Classes/system.logs.php");
	$log = new logs();
	include("./inc/Classes/system-users.php");
	$users=new systemUsers();
include("./inc/Classes/system-categories.php");
	$category=new systemCategories();
include("./inc/Classes/system-tasks.php");
	$tasks=new systemTasks();
if($login->doCheck() == false)
	{
		$smarty->assign(logMode,1);
		$smarty->assign(logdata,$lang['LGN_YOU_MUST_LOGIN']);
		$smarty->assign(area_name,"login");
		$tm->fetch("$lang[login]","user-login.tpl");
	}else
	{
        switch($_GET['do'])
        {  case"":
           case"add":
         if($login->doCheckPermission("governorates_add") == false)
				{
					$tm->fetch("$lang[not_permission]","user-permission.tpl");
				}else
				{
					$smarty->assign(area_name,"add");
            	$smarty->assign(p,$users->getsiteUsers());
					$smarty->assign(c,$category->getsiteCategories());

					if($_POST)
					{

	        			$_task['tittle'] 		                    = 	sanitize($_POST["tittle"]);
        				$_task['cat_id'] 		                    = 	sanitize($_POST["category"]);
        				$_task['description'] 		                    = 	sanitize($_POST["description"]);
        				$_task['img'] 		                    = 	sanitize($_POST["img"]);
        				$_task['lon'] 		                    = 	sanitize($_POST["lon"]);
        				$_task['lat'] 		                    = 	sanitize($_POST["lat"]);
        				$_task['assiged_to'] 		                    = 	sanitize($_POST["assiged_to"]);
        				$_task['user_id'] 		                    = 	sanitize($_POST["user_id"]);
        				$_task['requested_time'] 		                    = 	sanitize($_POST["requested_time"]);
        				$_task['arrived_time'] 		                    = 	sanitize($_POST["arrived_time"]);
        				$_task['total_time'] 		                    = 	sanitize($_POST["total_time"]);
        				$_task['review'] 		                    = 	sanitize($_POST["review"]);


	        			if ($_task[tittle]  =="" )
	        			{
	        				$_task[tittle] = $lang['no_name'];
	        			}
						if(is_array($errors))
						{
							$smarty->assign(errors,$errors);
							$smarty->assign(n,$_task);
						}else
						{
							$add = $tasks->addNewTasks($_task);
/*
                    		header( 'Location:country.html' );
*/


							if($add == 1)
							{
								/*$logs->addLog(12,
									array(
										"type" 		=> 	"admin",
										"module" 	=> 	"Governorates",
										"mode" 		=> 	"add",
										"country"   => $mId,
										"id" 		=>	$login->getUserId(),
									),"admin",$login->getUserId(),1
								);
*/
								header( 'Location:users.html' );
                                exit;
								// $smarty->assign(area_name,"list") ;
								// $smarty->assign(success,$lang['add_Governorates_success']);
								// include("./inc/Classes/pager.class.php");
								// $pager = new pager();
								// $page 		= intval($_GET[page]);

								// $pager->doAnalysisPager("page",$page,$basicLimit,$governorate->getTotalGovernorates(),"governorates.html".$paginationAddons,$paginationDialm);

								// $thispage = $pager->getPage();
								// $limitmequry = " LIMIT ".($thispage-1) * $basicLimit .",". $basicLimit;
								// $smarty->assign(area_name,"list");
								// $smarty->assign('pager',$pager->getAnalysis());
								// $smarty->assign(u,$governorate->getsiteGovernorates($limitmequry));
							}
						}
					}
				}
            break;
      }
		$smarty->assign(footJs,array('list-controls.js'));
		$tm->display("$lang[tasks_mangment]","tasks.tpl");
	}

	$db->disconnect();
	ob_end_flush();
?>
