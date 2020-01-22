<?php
	define("inside",true);
	define("access_admin","GitZone");

	ob_start("ob_gzhandler");

	// get funcamental file which contain config and template files,settings.
	include("./inc/fundamentals.php");


	include("./inc/Classes/system-users.php");
	$user = new systemUsers();
	include("./inc/Classes/system.logs.php");
	$log = new logs();


	if($login->doCheck() == false)
	{
		$smarty->assign(logMode,1);
		$smarty->assign(logdata,$lang['LGN_YOU_MUST_LOGIN']);
		$smarty->assign(area_name,"login");
		$tm->fetch("$lang[login]","user-login.tpl");
	}else
	{
        switch($_GET['do'])
		{
			case"":
			case"list":
				if($login->doCheckPermission("governorates_list") == false)
				{
					$tm->fetch("$lang[not_permission]","user-permission.tpl");
				}else
				{
					include("./inc/Classes/pager.class.php");
					$pager      = new pager();
					$page 		= intval($_GET[page]);
/*
					$action = $_GET['action'] ;
					if( $action == 'success'){
						$smarty->assign(success,$lang['add_Governorates_success']);
					}	*/
					$pager->doAnalysisPager("page",$page,$basicLimit,$user->getTotalUsers(),"users.html".$paginationAddons,$paginationDialm);
					$thispage = $pager->getPage();
					$limitmequry = " LIMIT ".($thispage-1) * $basicLimit .",". $basicLimit;
					$smarty->assign(area_name,"list");
					$smarty->assign('pager',$pager->getAnalysis());
					$smarty->assign(u,$user->getsiteUsers($limitmequry));
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
					$delete = $user->deleteUsers($mId);
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
						$smarty->assign(u,$user->getUsersInformation($mId));
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
						$smarty->assign(u,$user->getUsersInformation($mId));
					}
				}
			break;
			case"update":
			    $mId = intval($_GET['id']);
				if($mId != 0)
				{
					$smarty->assign(area_name,"edit");
					$smarty->assign(u,$user->getUsersInformation($mId));
	        		if($_POST)
	        		{
	        			$_user['id'] 				                = 	$mId;
        				$_user['name'] 		                    = 	sanitize($_POST["name"]);
        				$_user['email'] 		                    = 	sanitize($_POST["email"]);
        				$_user['email_key'] 		                    = 	sanitize($_POST["email_key"]);
        				$_user['email_verified'] 		                    = 	sanitize($_POST["email_verified"]);
        				$_user['mobile'] 		                    = 	sanitize($_POST["mobile"]);
        				$_user['mobile_key'] 		                    = 	sanitize($_POST["mobile_key"]);
        				$_user['mobile_verified'] 		                    = 	sanitize($_POST["mobile_verified"]);
        				$_user['city_id'] 		                    = 	sanitize($_POST["city_id"]);
        				$_user['lon'] 		                    = 	sanitize($_POST["lon"]);
        				$_user['lat'] 		                    = 	sanitize($_POST["lat"]);
        				$_user['address'] 		                    = 	sanitize($_POST["address"]);
        				$_user['volunteer'] 		                    = 	sanitize($_POST["volunteer"]);


	        			if ($_user[name] =="" )
	        			{
	        				$_user[name] = $lang['no_name'];
	        			}else
						{
							$check = $user->isUsersExists($_user['name'] );
							if(is_array($check))
							{
								if($_user['id']  != $check['id'])
								{
									$errors[name] = $lang['add_this_Governorates_before'];
								}
							}
						}


	                    if(is_array($errors))
	                    {
	                    	$smarty->assign(errors,$errors);
							$smarty->assign(n,$_user);
	                    }else
	                    {
	                    	$update = $user->setUsersInformation($_user);
							if($update == 1)
							{
								$smarty->assign(success,$lang['edit_Governorates_success']);
								include("./inc/Classes/pager.class.php");
								$pager = new pager();
								$page  = intval($_GET[page]);

				                $pager->doAnalysisPager("page",$page,$basicLimit,$user->getTotalUsers(),"users.html".$paginationAddons,$paginationDialm);

				                $thispage = $pager->getPage();
				                $limitmequry = " LIMIT ".($thispage-1) * $basicLimit .",". $basicLimit;

								$smarty->assign(area_name,"list");
								$smarty->assign('pager',$pager->getAnalysis());
					$smarty->assign(u,$user->getsiteUsers($limitmequry));
							}
	                    }
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
					if($_POST)
					{


	        			$_user['name'] 		                    = 	sanitize($_POST["name"]);
        				$_user['email'] 		                    = 	sanitize($_POST["email"]);
        				$_user['email_key'] 		                    = 	sanitize($_POST["email_key"]);
        				$_user['email_verified'] 		                    = 	sanitize($_POST["email_verified"]);
        				$_user['mobile'] 		                    = 	sanitize($_POST["mobile"]);
        				$_user['mobile_key'] 		                    = 	sanitize($_POST["mobile_key"]);
        				$_user['mobile_verified'] 		                    = 	sanitize($_POST["mobile_verified"]);
        				$_user['city_id'] 		                    = 	sanitize($_POST["city_id"]);
        				$_user['lon'] 		                    = 	sanitize($_POST["lon"]);
        				$_user['lat'] 		                    = 	sanitize($_POST["lat"]);
        				$_user['address'] 		                    = 	sanitize($_POST["address"]);
        				$_user['volunteer'] 		                    = 	sanitize($_POST["volunteer"]);


	        			if ($_user[name] =="" )
	        			{
	        				$_user[name] = $lang['no_name'];
	        			}else
						{
							$check = $user->isUsersExists($_user['name'] );
							if(is_array($check))
							{
								if($_user['id']  != $check['id'])
								{
									$errors[name] = $lang['add_this_Governorates_before'];
								}
							}
						}

						if(is_array($errors))
						{
							$smarty->assign(errors,$errors);
							$smarty->assign(n,$_user);
						}else
						{
							$add = $user->addNewUsers($_user);
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
		$tm->display("$lang[users_mangment]","users.tpl");
	}

	$db->disconnect();
	ob_end_flush();
?>
