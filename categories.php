<?php
	define("inside",true);
	define("access_admin","GitZone");

	ob_start("ob_gzhandler");

	// get funcamental file which contain config and template files,settings.
	include("./inc/fundamentals.php");
	include("./inc/Classes/system.logs.php");
	$logs     = new logs();

	include("./inc/Classes/system-categories.php");
	$category        = new systemCategories();




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
                case"add":
				if($login->doCheckPermission("cities_add") == false)
				{
					$tm->fetch("$lang[not_permission]","user-permission.tpl");
				}else
				{
					$smarty->assign(area_name,"add");
					if($_POST)
					{
							$_city['cat_name'] 		        = 	sanitize($_POST["cat_name"]);

							if ($_city[cat_name] =="" )
							{
								$errors[cat_name] = $lang['no_name'];
							}else
							{
								$check = $category->isCategoriesExists($_city['cat_name']);
								if(is_array($check))
								{
									if($_city['id'] != $check['id'])
									{
										$errors[cat_name] = $lang['add_this_cities_before'];
									}
								}
							}



							if(is_array($errors))
							{
								$smarty->assign(errors,$errors);
								$smarty->assign(n,$_city);
							}else
							{
								$add = $category->addNewCategories($_city);
							if($add == 1)
							{
								/*$logs->addLog(18,
									array(
										"type" 		=> 	"admin",
										"module" 	=> 	"cities",
										"mode" 		=> 	"add",
										"city"      => $mId,
										"id" 		=>	$login->getUserId(),
									),"admin",$login->getUserId(),1
								);*/
								$smarty->assign(success,$lang['add_cities_success']);
								include("./inc/Classes/pager.class.php");
								$pager = new pager();
								$page 		= intval($_GET[page]);

								$pager->doAnalysisPager("page",$page,$basicLimit,
                                                        $category->getTotalCategories(),"categories.html".$paginationAddons,$paginationDialm);

								$thispage = $pager->getPage();
								$limitmequry = " LIMIT ".($thispage-1) * $basicLimit .",". $basicLimit;

								$smarty->assign(area_name,"list");
								$smarty->assign('pager',$pager->getAnalysis());
								$smarty->assign(u,$category->getsiteCategories($limitmequry));
							}
						}
					}
				}
            break;
    case"list":
				if($login->doCheckPermission("cities_list") == false)
				{
					$tm->fetch("$lang[not_permission]","user-permission.tpl");
				}else
				{

						$smarty->assign(area_name,"list");
/*
						$smarty->assign(s,$governorate);
*/
/*
                         $smarty->assign(c,$governorate->getsiteGovernorates());
*/
						$smarty->assign(u,$category->getsiteCategories(""));

						/*$logs->addLog(13,
										array(
											"type" 		=> 	"admin",
											"module" 	=> 	"cities",
											"mode" 		=> 	"add",
											"city"      => $city->getTotalCities(),
											"id" 		=>	$login->getUserId(),
										),"admin",$login->getUserId(),1
									);*/

				}
			break;

			case"delete":
				if($login->doCheckPermission("cities_delete") == false)
				{
					$tm->fetch("$lang[not_permission]","user-permission.tpl");
				}
				else
				{
					$mId = intval($_POST['id']);
					$delete = $city->deleteCities($mId);
					if($delete == 1)
					{
						/*$logs->addLog(14,
									array(
										"type" 		=> 	"admin",
										"module" 	=> 	"cities",
										"mode" 		=> 	"delete",
										"city"      => $mId,
										"id" 		=>	$login->getUserId(),
									),"admin",$login->getUserId(),1
								);*/
						echo 116;
						exit;
					}
				}
			break;

			case"status":
				if($login->doCheckPermission("cities_active") == false)
				{
					$tm->fetch("$lang[not_permission]","user-permission.tpl");
				}
				else
				{
					$mId = $_POST['id'];

					$status = $_POST['status'];
					$active = $city->activestatusCities($mId,$status);
					if($active == 1)
					{
						/*$logs->addLog(15,
									array(
										"type" 		=> 	"admin",
										"module" 	=> 	"cities",
										"mode" 		=> 	"active",
										"city"      => $mId,
										"id" 		=>	$login->getUserId(),
									),"admin",$login->getUserId(),1
								);*/
						echo 1190;
						exit;
					}
				}
			break;
			case"edit":
				if($login->doCheckPermission("cities_edit") == false)
				{
					$tm->fetch("$lang[not_permission]","user-permission.tpl");
				}
				else
				{
					$mId = intval($_GET['id']);
					if($mId != 0)
					{
						$logs->addLog(16,
									array(
										"type" 		=> 	"admin",
										"module" 	=> 	"cities",
										"mode" 		=> 	"edit",
										"city"      => $mId,
										"id" 		=>	$login->getUserId(),
									),"admin",$login->getUserId(),1
								);
						$smarty->assign(area_name,"edit");
                    $smarty->assign(c,$category->getsiteCategories_1());

						$smarty->assign(u,$category->getCategoriesInformation($mId));
					}
				}
			break;
			case"view":
				if($login->doCheckPermission("cities_view") == false)
				{
					$tm->fetch("$lang[not_permission]","user-permission.tpl");
				}else
				{
					$mId = intval($_GET['id']);
					if($mId != 0)
					{
						/*$logs->addLog(17,
									array(
										"type" 		=> 	"admin",
										"module" 	=> 	"cities",
										"mode" 		=> 	"view",
										"city"      => $mId,
										"id" 		=>	$login->getUserId(),
									),"admin",$login->getUserId(),1
								);*/
						$smarty->assign(area_name,"view");
						$smarty->assign(u,$category->getCategoriesInformation($mId));
					}
				}
			break;
			case"update":
			    $mId = intval($_GET['id']);
				if($mId != 0)
				{
					$smarty->assign(area_name,"edit");
					$smarty->assign(u,$category->getCategoriesInformation($mId));
	        		if($_POST)
	        		{
	        			$_city['id'] 				    = 	$mId;
	        			$_city['cat_name'] 		        = 	sanitize($_POST["cat_name"]);
	        			$_city['category'] 		        = 	sanitize($_POST["category"]);

        				$_city['status'] 			    = 	intval($_POST["status"]);


	        			if ($_city[cat_name] =="" )
	        			{
	        				$errors[cat_name] = $lang['no_name'];
	        			}else
						{
								$check = $category->isCategoriesExists($_city['cat_name']);
								if(is_array($check))
								{
									if($_city['id'] != $check['id'])
									{
										$errors[cat_name] = $lang['add_this_cities_before'];
									}
								}
							}





	                    if(is_array($errors))
	                    {
	                    	$smarty->assign(errors,$errors);
							$smarty->assign(n,$_city);
	                    }else
	                    {

	                    	$update = $category->setCategoriesInformation($_city);
							if($update == 1)
							{
								$smarty->assign(success,$lang['edit_cities_success']);
								include("./inc/Classes/pager.class.php");
								$pager = new pager();
								$page  = intval($_GET[page]);

				                $pager->doAnalysisPager("page",$page,$basicLimit,
                                                        $category->getTotalCategories(),"categories.html".$paginationAddons,$paginationDialm);

								$thispage = $pager->getPage();
								$limitmequry = " LIMIT ".($thispage-1) * $basicLimit .",". $basicLimit;

								$smarty->assign(area_name,"list");
								$smarty->assign('pager',$pager->getAnalysis());
								$smarty->assign(u,$category->getsiteCategories($limitmequry));
							}
	                    }
	                }
				}
            break;
			case"add_cat":
				if($login->doCheckPermission("cities_add") == false)
				{
					$tm->fetch("$lang[not_permission]","user-permission.tpl");
				}else
				{
					$smarty->assign(area_name,"add_cat");
					$smarty->assign(c,$category->getsiteCategories_1());
					if($_POST)
					{
							$_city['parent_id'] 		        = 	sanitize($_POST["category"]);
							$_city['cat_name'] 		        = 	sanitize($_POST["cat_name"]);


							if ($_city[cat_name] =="" )
							{
								$errors[cat_name] = $lang['no_name'];
							}else
							{
								$check = $category->isCategoriesExists($_city['cat_name']);
								if(is_array($check))
								{
									if($_city['id'] != $check['id'])
									{
										$errors[cat_name] = $lang['add_this_cities_before'];
									}
								}
							}


							if(is_array($errors))
							{
								$smarty->assign(errors,$errors);
								$smarty->assign(n,$_city);
							}else
							{
								$add = $category->addNewCategories_1($_city);
							if($add == 1)
							{
								/*$logs->addLog(18,
									array(
										"type" 		=> 	"admin",
										"module" 	=> 	"cities",
										"mode" 		=> 	"add",
										"city"      => $mId,
										"id" 		=>	$login->getUserId(),
									),"admin",$login->getUserId(),1
								);*/
								$smarty->assign(success,$lang['add_cities_success']);
								include("./inc/Classes/pager.class.php");
								$pager = new pager();
								$page 		= intval($_GET[page]);

								$pager->doAnalysisPager("page",$page,$basicLimit,
                                                        $category->getTotalCategories(),"categories.html".$paginationAddons,$paginationDialm);

								$thispage = $pager->getPage();
								$limitmequry = " LIMIT ".($thispage-1) * $basicLimit .",". $basicLimit;

								$smarty->assign(area_name,"list");
								$smarty->assign('pager',$pager->getAnalysis());
								$smarty->assign(u,$category->getsiteCategories($limitmequry));
							}
						}
					}
				}
            break;

		}
		$smarty->assign(footJs,array('list-controls.js'));
		$tm->display("$lang[cities_mangment]","categories.tpl");
	}

	$db->disconnect();
	ob_end_flush();
?>
