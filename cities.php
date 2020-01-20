<?php
	define("inside",true);
	define("access_admin","GitZone");

	ob_start("ob_gzhandler");

	// get funcamental file which contain config and template files,settings.
	include("./inc/fundamentals.php");
	include("./inc/Classes/system.logs.php");
	$logs     = new logs();

	include("./inc/Classes/system-cities.php");
	$city        = new systemCities();

	include("./inc/Classes/system-governorates.php");
	$governorate = new systemGovernorates();


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
				if($login->doCheckPermission("cities_list") == false)
				{
					$tm->fetch("$lang[not_permission]","user-permission.tpl");
				}else
				{
					$governorate 		= intval($_GET[governorate]);
					if($governorate == 0)
					{
						include("./inc/Classes/pager.class.php");
						$pager          = new pager();
						$page 			= intval($_GET[page]);
						$pager->doAnalysisPager("page",$page,$basicLimit,$city->getTotalCities(),"cities.html".$paginationAddons,$paginationDialm);
						$thispage = $pager->getPage();
						$limitmequry = " LIMIT ".($thispage-1) * $basicLimit .",". $basicLimit;
						$smarty->assign(area_name,"list");
						$smarty->assign('pager',$pager->getAnalysis());
						$smarty->assign(u,$city->getsiteCities($limitmequry,$governorate));
					}else
					{
						$smarty->assign(area_name,"list");
/*
						$smarty->assign(s,$governorate);
*/
                         $smarty->assign(c,$governorate->getsiteGovernorates());
						$smarty->assign(u,$city->getsiteCities("",$governorate));

						$logs->addLog(13,
										array(
											"type" 		=> 	"admin",
											"module" 	=> 	"cities",
											"mode" 		=> 	"add",
											"city"      => $city->getTotalCities(),
											"id" 		=>	$login->getUserId(),
										),"admin",$login->getUserId(),1
									);
					}
				}
			break;
			case"city":
				
				$governorate = $_POST['gov_id'];
				$city        = $city->getsiteCities("",$governorate);
				
				foreach($city as $c)
				{
					echo '<option value="'.$c['id'].'"{if '.$c['id'].' eq $u.city}selected="selected"{/if}>'.$c['city_name_ar'].'</option>';
				}
				exit;
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
						$logs->addLog(14,
									array(
										"type" 		=> 	"admin",
										"module" 	=> 	"cities",
										"mode" 		=> 	"delete",
										"city"      => $mId,
										"id" 		=>	$login->getUserId(),
									),"admin",$login->getUserId(),1
								);
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
						$logs->addLog(15,
									array(
										"type" 		=> 	"admin",
										"module" 	=> 	"cities",
										"mode" 		=> 	"active",
										"city"      => $mId,
										"id" 		=>	$login->getUserId(),
									),"admin",$login->getUserId(),1
								);
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
						$smarty->assign(c,$governorate->getsiteGovernorates());
						$smarty->assign(u,$city->getCitiesInformation($mId));
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
						$logs->addLog(17,
									array(
										"type" 		=> 	"admin",
										"module" 	=> 	"cities",
										"mode" 		=> 	"view",
										"city"      => $mId,
										"id" 		=>	$login->getUserId(),
									),"admin",$login->getUserId(),1
								);
						$smarty->assign(area_name,"view");
						$smarty->assign(c,$governorate->getsiteGovernorates());
						$smarty->assign(u,$city->getCitiesInformation($mId));
					}
				}
			break;
			case"update":
			    $mId = intval($_GET['id']);
				if($mId != 0)
				{
					$smarty->assign(area_name,"edit");
					$smarty->assign(c,$governorate->getsiteGovernorates());
					$smarty->assign(u,$city->getCitiesInformation($mId));
	        		if($_POST)
	        		{
	        			$_city['id'] 				    = 	$mId;
	        			$_city['city_name'] 		        = 	sanitize($_POST["city_name"]);
	        			$_city['city_name_ar'] 		        = 	sanitize($_POST["city_name_ar"]);
	        			$_city['gov_id'] 			    = 	intval($_POST["gov_id"]);
        				$_city['status'] 			    = 	intval($_POST["status"]);


	        			if ($_city[city_name_ar] =="" )
	        			{
	        				$errors[city_name_ar] = $lang['no_name_by_arabic'];
	        			}else
						{
							$check = $city->isCitiesExists($_city['city_name_ar']);
							if(is_array($check))
							{
								if($_city['id'] != $check['id'])
								{
									$errors[city_name_ar] = $lang['add_this_cities_before'];
								}
							}
						}

						if ($_city[city_name] =="" )
	        			{
	        				$errors[city_name] = $lang['no_name_by_english'];
	        			}else
						{
							$check = $city->isCitiesExists($_city['city_name']);
							if(is_array($check))
							{
								if($_city['id'] != $check['id'])
								{
									$errors[city_name] = $lang['add_this_cities_before'];
								}
							}
						}


	                    if(is_array($errors))
	                    {
	                    	$smarty->assign(errors,$errors);
							$smarty->assign(n,$_city);
	                    }else
	                    {

	                    	$update = $city->setCitiesInformation($_city);
							if($update == 1)
							{
								$smarty->assign(success,$lang['edit_cities_success']);
								include("./inc/Classes/pager.class.php");
								$pager = new pager();
								$page  = intval($_GET[page]);

				                $pager->doAnalysisPager("page",$page,$basicLimit,$city->getTotalCities(),"cities.html".$paginationAddons,$paginationDialm);

				                $thispage = $pager->getPage();
				                $limitmequry = " LIMIT ".($thispage-1) * $basicLimit .",". $basicLimit;

								$smarty->assign(area_name,"list");
								$smarty->assign('pager',$pager->getAnalysis());
								$smarty->assign(u,$city->getsiteCities($limitmequry));
							}
	                    }
	                }
				}
            break;
			case"add":
				if($login->doCheckPermission("cities_add") == false)
				{
					$tm->fetch("$lang[not_permission]","user-permission.tpl");
				}else
				{
					$smarty->assign(area_name,"add");
					$smarty->assign(c,$governorate->getsiteGovernorates());
					if($_POST)
					{
							$_city['city_name'] 		        = 	sanitize($_POST["city_name"]);
							$_city['city_name_ar'] 		        = 	sanitize($_POST["city_name_ar"]);
							$_city['gov_id'] 			    = 	intval($_POST["governorate"]);
							$_city['status'] 			    = 	intval($_POST["status"]);


							if ($_city[city_name_ar] =="" )
							{
								$errors[city_name_ar] = $lang['no_name_by_arabic'];
							}else
							{
								$check = $city->isCitiesExists($_city['city_name_ar']);
								if(is_array($check))
								{
									if($_city['id'] != $check['id'])
									{
										$errors[city_name_ar] = $lang['add_this_cities_before'];
									}
								}
							}

							if ($_city[city_name] =="" )
							{
								$errors[city_name] = $lang['no_name_by_english'];
							}else
							{
								$check = $city->isCitiesExists($_city['city_name']);
								if(is_array($check))
								{
									if($_city['id'] != $check['id'])
									{
										$errors[city_name] = $lang['add_this_cities_before'];
									}
								}
							}


							if(is_array($errors))
							{
								$smarty->assign(errors,$errors);
								$smarty->assign(n,$_city);
							}else
							{
								$add = $city->addNewCities($_city);
							if($add == 1)
							{
								$logs->addLog(18,
									array(
										"type" 		=> 	"admin",
										"module" 	=> 	"cities",
										"mode" 		=> 	"add",
										"city"      => $mId,
										"id" 		=>	$login->getUserId(),
									),"admin",$login->getUserId(),1
								);
								$smarty->assign(success,$lang['add_cities_success']);
								include("./inc/Classes/pager.class.php");
								$pager = new pager();
								$page 		= intval($_GET[page]);

								$pager->doAnalysisPager("page",$page,$basicLimit,$city->getTotalCities(),"cities.html".$paginationAddons,$paginationDialm);

								$thispage = $pager->getPage();
								$limitmequry = " LIMIT ".($thispage-1) * $basicLimit .",". $basicLimit;

								$smarty->assign(area_name,"list");
								$smarty->assign('pager',$pager->getAnalysis());
								$smarty->assign(u,$city->getsiteCities($limitmequry));
							}
						}   
					}
				}
            break;

		}
		$smarty->assign(footJs,array('list-controls.js'));
		$tm->display("$lang[cities_mangment]","cities.tpl");
	}

	$db->disconnect();
	ob_end_flush();
?>
