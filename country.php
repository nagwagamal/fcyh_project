<?php
	define("inside",true);
	define("access_admin","GitZone");

	ob_start("ob_gzhandler");

	// get funcamental file which contain config and template files,settings.
	include("./inc/fundamentals.php");


	include("./inc/Classes/system-country.php");
	$country = new systemCountry();
	
	
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
					$pager->doAnalysisPager("page",$page,$basicLimit,$country->getTotalCountry(),"country.html".$paginationAddons,$paginationDialm);
					$thispage = $pager->getPage();
					$limitmequry = " LIMIT ".($thispage-1) * $basicLimit .",". $basicLimit;
					$smarty->assign(area_name,"list");
					$smarty->assign('pager',$pager->getAnalysis());
					$smarty->assign(u,$country->getsiteCountry($limitmequry));
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
			case"status":
				if($login->doCheckPermission("governorates_active") == false)
				{
					$tm->fetch("$lang[not_permission]","user-permission.tpl");
				}
				else
				{
					$mId = $_POST['id'];

					$status = $_POST['status'];
					$active = $country->activestatusCountry($mId,$status);
					if($active == 1)
					{
						/*$logs->addLog(8,
									array(
										"type" 		=> 	"admin",
										"module" 	=> 	"Governorates",
										"mode" 		=> 	"active",
										"country"   => $mId,
										"id" 		=>	$login->getUserId(),
									),"admin",$login->getUserId(),1
								);*/
						echo 1190;
						exit;
					}
				}
			case"delete":
				if($login->doCheckPermission("governorates_delete") == false)
				{
					$tm->fetch("$lang[not_permission]","user-permission.tpl");
				}
				else
				{
					$mId = intval($_POST['id']);
					$delete = $country->deleteCountry($mId);
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
						$smarty->assign(u,$country->getCountryInformation($mId));
						/*$logs->addLog(10,
									array(
										"type" 		=> 	"admin",
										"module" 	=> 	"Governorates",
										"mode" 		=> 	"edit",
										"country"   => $mId,
										"id" 		=>	$login->getUserId(),
									),"admin",$login->getUserId(),1
								);*/
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
					{
						/*$logs->addLog(11,
									array(
										"type" 		=> 	"admin",
										"module" 	=> 	"Governorates",
										"mode" 		=> 	"view",
										"country"   => $mId,
										"id" 		=>	$login->getUserId(),
									),"admin",$login->getUserId(),1
								);*/
						$smarty->assign(area_name,"view");
						$smarty->assign(u,$country->getCountryInformation($mId));
					}
				}
			break;
			case"update":
			    $mId = intval($_GET['id']);
				if($mId != 0)
				{
					$smarty->assign(area_name,"edit");
					$smarty->assign(u,$country->getCountryInformation($mId));
	        		if($_POST)
	        		{
	        			$_governorate['id'] 				                = 	$mId;
        				$_governorate['count_name'] 		                    = 	sanitize($_POST["count_name"]);
        				$_governorate['count_name_ar'] 		                    = 	sanitize($_POST["count_name_ar"]);
        				$_governorate['status'] 		                    = 	intval($_POST["status"]);


	        			if ($_governorate[count_name] =="" )
	        			{
	        				$errors[count_name] = $lang['no_name_by_english'];
	        			}else
						{
							$check = $country->isCountryExists($_governorate['count_name_ar']);
							if(is_array($check))
							{
								if($_governorate['id'] != $check['id'])
								{
									$errors[count_name] = $lang['add_this_Governorates_before'];
								}
							}
						}

						if ($_governorate[count_name_ar] =="" )
	        			{
	        				$errors[count_name_ar] = $lang['no_name_by_arabic'];
	        			}else
						{
							$check = $country->isCountryExists($_governorate['gov_name']);
							if(is_array($check))
							{
								if($_governorate['id'] != $check['id'])
								{
									$errors[count_name] = $lang['add_this_Governorates_before'];
								}
							}
						}

	                    if(is_array($errors))
	                    {
	                    	$smarty->assign(errors,$errors);
							$smarty->assign(n,$_governorate);
	                    }else
	                    {
	                    	$update = $country->setCountryInformation($_governorate);
							if($update == 1)
							{
								$smarty->assign(success,$lang['edit_Governorates_success']);
								include("./inc/Classes/pager.class.php");
								$pager = new pager();
								$page  = intval($_GET[page]);

				                $pager->doAnalysisPager("page",$page,$basicLimit,$country->getTotalCountry(),"country.html".$paginationAddons,$paginationDialm);

				                $thispage = $pager->getPage();
				                $limitmequry = " LIMIT ".($thispage-1) * $basicLimit .",". $basicLimit;

								$smarty->assign(area_name,"list");
								$smarty->assign('pager',$pager->getAnalysis());
								$smarty->assign(u,$country->getsiteCountry($limitmequry));
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
						$_governorate['count_name']   = 	sanitize($_POST["count_name"]);
        				$_governorate['count_name_ar']   = 	sanitize($_POST["count_name_ar"]);


	        			if ($_governorate[count_name] =="" )
	        			{
	        				$errors[count_name] = $lang['no_name_by_english'];
	        			}else
						{
							$check = $country->isCountryExists($_governorate['count_name']);
							if(is_array($check))
							{
								if($_governorate['id'] != $check['id'])
								{
									$errors[count_name] = $lang['add_this_Governorates_before'];
								}
							}
						}

						if ($_governorate[count_name_ar] =="" )
	        			{
	        				$errors[count_name_ar] = $lang['no_name_by_arabic'];
	        			}else
						{
							$check = $country->isCountryExists($_governorate['count_name']);
							if(is_array($check))
							{
								if($_governorate['id'] != $check['id'])
								{
									$errors[count_name] = $lang['add_this_Governorates_before'];
								}
							}
						}

						if(is_array($errors))
						{
							$smarty->assign(errors,$errors);
							$smarty->assign(n,$_governorate);
						}else
						{
							$add = $country->addNewCountry($_governorate);
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
								header( 'Location:country.html' );
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
		$tm->display("$lang[Governorates_mangment]","country.tpl");
	}

	$db->disconnect();
	ob_end_flush();
?>
