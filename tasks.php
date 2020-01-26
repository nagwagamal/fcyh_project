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
         case"list":
             if($login->doCheckPermission("governorates_add") == false)
				{
					$tm->fetch("$lang[not_permission]","user-permission.tpl");
				}else
				{include("./inc/Classes/pager.class.php");
					$pager      = new pager();
					$page 		= intval($_GET[page]);
/*
					$action = $_GET['action'] ;
					if( $action == 'success'){
						$smarty->assign(success,$lang['add_Governorates_success']);
					}	*/
					$pager->doAnalysisPager("page",$page,$basicLimit,$tasks->getTotalTasks(),"tasks.html".$paginationAddons,$paginationDialm);
					$thispage = $pager->getPage();
					$limitmequry = " LIMIT ".($thispage-1) * $basicLimit .",". $basicLimit;
                    $smarty->assign(area_name,"list");
            	    $smarty->assign(p,$users->getsiteUsers());
					$smarty->assign(c,$category->getsiteCategories());
                    $smarty->assign('pager',$pager->getAnalysis());
					$smarty->assign(u,$tasks->getsiteTasks($limitmequry));
					/*$logs->addLog(7,
									array(
										"type" 		=> 	"admin",
										"module" 	=> 	"Governorates",
										"mode" 		=> 	"list",
										"Governorates" => $governorate->getTotalGovernorates(),
										"id" 		=>	$login->getUserId(),
									),"admin",$login->getUserId(),1
								);*/


                }
break;
         case"delete":
				if($login->doCheckPermission("governorates_delete") == false)
				{
					$tm->fetch("$lang[not_permission]","user-permission.tpl");
				}
				else
				{
					$mId = intval($_POST['id']);
					$delete = $tasks->deleteTasks($mId);
					if($delete == 1)
					{
						/*$logs->addLog(9,
									array(
										"type" 		=> 	"admin",
										"module" 	=> 	"Governorates",
										"mode" 		=> 	"delete",
										"country"   => $mId,
										"id" 		=>	$login->getUserId(),
									),"admin",$login->getUserId(),1
								);*/
						echo 116;
						exit;
					}
				}
			break;
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

	        			$_task['title'] 		                    = 	sanitize($_POST["title"]);
        				$_task['cat_id'] 		                    = 	sanitize($_POST["category"]);
        				$_task['description'] 		                    = 	sanitize($_POST["description"]);
        				$_task['lon'] 		                    = 	sanitize($_POST["lon"]);
        				$_task['lat'] 		                    = 	sanitize($_POST["lat"]);
        				$_task['assiged_to'] 		                    = 	sanitize($_POST["assigned"]);
        				$_task['user_id'] 		                    = 	sanitize($_POST["user_task"]);
        				$_task['requested_time'] 		                    = 	sanitize($_POST["requested_time"]);
        				$_task['arrived_time'] 		                    = 	sanitize($_POST["arrived_time"]);
        				$_task['total_time'] 		                    = 	sanitize($_POST["total_time"]);
        				$_task['review'] 		                    = 	sanitize($_POST["review"]);

if($_FILES && ( $_FILES['img']['name'] != "") && ( $_FILES['img']['tmp_name'] != "" ) )
						{
							if(!empty($_FILES['img']['error']))
							{
								switch($_FILES['img']['error'])
								{
									case '1':
										$errors[img] = $lang['UP_ERR_SIZE_BIG'];
										break;
									case '2':
										$errors[img] = $lang['UP_ERR_SIZE_BIG'];
										break;
									case '3':
										$errors[img] = $lang['UP_ERR_FULL_UP'];
										break;
									case '4':
										$errors[img] = $lang['UP_ERR_SLCT_FILE'];
										break;
									case '6':
										$errors[img] = $lang['UP_ERR_TMP_FLDR'];
										break;
									case '7':
										$errors[img] = $lang['UP_ERR_NOT_UPLODED'];
										break;
									case '8':
										$errors[img] = $lang['UP_ERR_UPLODED_STPD'];
										break;
									case '999':
									default:
										$errors[img] = $lang['UP_ERR_UNKNOWN'];
								}
							}elseif(empty($_FILES['img']['tmp_name']) || $_FILES['img']['tmp_name'] == 'none')
							{
								$errors[img] = $lang['UP_ERR_SLCT_FILE'];
							}
						}
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
                             if( $_FILES && ( $_FILES['img']['name'] != "") && ( $_FILES['img']['tmp_name'] != "" ) )
							{
								include_once("./inc/Classes/upload.class.php");

								$allow_ext = array("jpg","gif","png");

								$upload    = new Upload($allow_ext,false,0,0,5000,$uploadimg,".","",false,'reps_');

								$files[name] 	= addslashes($_FILES["img"]["name"]);
								$files[type] 	= $_FILES["img"]['type'];
								$files[size] 	= $_FILES["img"]['size']/1024;
								$files[tmp] 	= $_FILES["img"]['tmp_name'];
								$files[ext]		= $upload->GetExt($_FILES["img"]["name"]);

								$upfile	= $upload->Upload_File($files);

								if($upfile)
								{
									$_task[img] =  "uploads/". $upfile[ext] . "/" .  $upfile[newname];
								}else
								{
								   $errors[img] = $lang['UP_ERR_NOT_UPLODED'];
								}
								@unlink($_FILES['image']);
							}
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
								header( 'Location:tasks.html' );
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
         case"update":
			    $mId = intval($_GET['id']);
				if($mId != 0)
				{
					$smarty->assign(area_name,"edit");
            	$smarty->assign(p,$users->getsiteUsers());
					$smarty->assign(c,$category->getsiteCategories());

					if($_POST)
					{
	        			$_task['id'] 				                = 	$mId;
	        			$_task['title'] 		                    = 	sanitize($_POST["tittle"]);
        				$_task['cat_id'] 		                    = 	sanitize($_POST["category"]);
        				$_task['description'] 		                    = 	sanitize($_POST["description"]);
        				$_task['lon'] 		                    = 	sanitize($_POST["lon"]);
        				$_task['lat'] 		                    = 	sanitize($_POST["lat"]);
        				$_task['assiged_to'] 		                    = 	sanitize($_POST["assiged_to"]);
        				$_task['user_id'] 		                    = 	sanitize($_POST["user_id"]);
        				$_task['requested_time'] 		                    = 	sanitize($_POST["requested_time"]);
        				$_task['arrived_time'] 		                    = 	sanitize($_POST["arrived_time"]);
        				$_task['total_time'] 		                    = 	sanitize($_POST["total_time"]);
        				$_task['review'] 		                    = 	sanitize($_POST["review"]);
if($_FILES && ( $_FILES['img']['name'] != "") && ( $_FILES['img']['tmp_name'] != "" ) )
						{
							if(!empty($_FILES['img']['error']))
							{
								switch($_FILES['img']['error'])
								{
									case '1':
										$errors[img] = $lang['UP_ERR_SIZE_BIG'];
										break;
									case '2':
										$errors[img] = $lang['UP_ERR_SIZE_BIG'];
										break;
									case '3':
										$errors[img] = $lang['UP_ERR_FULL_UP'];
										break;
									case '4':
										$errors[img] = $lang['UP_ERR_SLCT_FILE'];
										break;
									case '6':
										$errors[img] = $lang['UP_ERR_TMP_FLDR'];
										break;
									case '7':
										$errors[img] = $lang['UP_ERR_NOT_UPLODED'];
										break;
									case '8':
										$errors[img] = $lang['UP_ERR_UPLODED_STPD'];
										break;
									case '999':
									default:
										$errors[img] = $lang['UP_ERR_UNKNOWN'];
								}
							}elseif(empty($_FILES['img']['tmp_name']) || $_FILES['img']['tmp_name'] == 'none')
							{
								$errors[img] = $lang['UP_ERR_SLCT_FILE'];
							}
						}



	        			if ($_task[tittle]  =="" )
	        			{
	        				$_task[tittle] = $lang['no_name'];
	        			}


	                    if(is_array($errors))
	                    {
	                    	$smarty->assign(errors,$errors);
							$smarty->assign(n,$_task);
	                    }else
	                    {if( $_FILES && ( $_FILES['img']['name'] != "") && ( $_FILES['img']['tmp_name'] != "" ) )
							{
								include_once("./inc/Classes/upload.class.php");

								$allow_ext = array("jpg","gif","png");

								$upload    = new Upload($allow_ext,false,0,0,5000,$uploadimg,".","",false,'reps_');

								$files[name] 	= addslashes($_FILES["img"]["name"]);
								$files[type] 	= $_FILES["img"]['type'];
								$files[size] 	= $_FILES["img"]['size']/1024;
								$files[tmp] 	= $_FILES["img"]['tmp_name'];
								$files[ext]		= $upload->GetExt($_FILES["img"]["name"]);

								$upfile	= $upload->Upload_File($files);

								if($upfile)
								{
									$_task[img] =  "uploads/". $upfile[ext] . "/" .  $upfile[newname];
								}else
								{
								   $errors[img] = $lang['UP_ERR_NOT_UPLODED'];
								}
								@unlink($_FILES['image']);
							}

	                    	$update = $tasks->setTasksInformation($_task);
							if($update == 1)
							{
								$smarty->assign(success,$lang['edit_Governorates_success']);
								include("./inc/Classes/pager.class.php");
								$pager = new pager();
								$page  = intval($_GET[page]);

				                $pager->doAnalysisPager("page",$page,$basicLimit,$tasks->getTotalTasks(),"tasks.html".$paginationAddons,$paginationDialm);

				                $thispage = $pager->getPage();
				                $limitmequry = " LIMIT ".($thispage-1) * $basicLimit .",". $basicLimit;

								$smarty->assign(area_name,"list");
								$smarty->assign('pager',$pager->getAnalysis());
					$smarty->assign(u,$tasks->getsiteTasks($limitmequry));
							}
	                    }
	                }
				}
            break;
         case"edit":
				if($login->doCheckPermission("governorates_edit") == false)
				{
					$tm->fetch("$lang[not_permission]","user-permission.tpl");
				}
				else
				{
					$mId = intval($_GET['id']);
					if($mId != 0)
					{
						$smarty->assign(area_name,"edit");
                        $smarty->assign(p,$users->getsiteUsers());
					$smarty->assign(c,$category->getsiteCategories());
						$smarty->assign(u,$tasks->getTasksInformation($mId));
//						$logs->addLog(10,
//									array(
//										"type" 		=> 	"admin",
//										"module" 	=> 	"Governorates",
//										"mode" 		=> 	"edit",
//										"country"   => $mId,
//										"id" 		=>	$login->getUserId(),
//									),"admin",$login->getUserId(),1
//								);
					}
				}
			break;
         case"view":
				if($login->doCheckPermission("governorates_view") == false)
				{
					$tm->fetch("$lang[not_permission]","user-permission.tpl");
				}else
				{
					$mId = intval($_GET['id']);
					if($mId != 0)
					{/*
						$logs->addLog(11,
									array(
										"type" 		=> 	"admin",
										"module" 	=> 	"Governorates",
										"mode" 		=> 	"view",
										"country"   => $mId,
										"id" 		=>	$login->getUserId(),
									),"admin",$login->getUserId(),1
								);*/
						$smarty->assign(area_name,"view");
						$smarty->assign(u,$tasks->getTasksInformation($mId));
                        $smarty->assign(p,$users->getsiteUsers());
					 $smarty->assign(c,$category->getsiteCategories());
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
