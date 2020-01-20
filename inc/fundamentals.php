<?php if(!defined("inside")) exit; ?>
<?php
	error_reporting (E_ALL ^ E_NOTICE);

    ######### Main PATHs #########
	define('INCLUDES_PATH',dirname(__FILE__) . DIRECTORY_SEPARATOR);
	define('ASSETS_PATH', INCLUDES_PATH . "../assets". DIRECTORY_SEPARATOR);

	#########  Db & config Files  #########
	include(INCLUDES_PATH 	. 	"/Classes/database.class.php");
	include(INCLUDES_PATH 	. 	"/config.php");
	// include(INCLUDES_PATH 	. 	"/config_basic_dawaa.php");
	include(ASSETS_PATH		.	"/assets.php");


	######### START SMARTY ENGINE #########
	require_once(INCLUDES_PATH . "Classes/libs/Smarty.class.php" );
	$smarty 				= new Smarty;
	$smarty->compile_check 	= true;
	$smarty->debugging 		= false;
	$smarty->compile_dir 	= './cash/';
	$smarty->compile_id 	= "LOY_";
	require_once(INCLUDES_PATH . "Classes/libs/customSmarty.php" );
	$smarty->template_dir 	= "./assets/themes";

	$tm = new Template("admin",$db,$smarty);
    $smarty->assign('headinc',"headinc.tpl");
    $smarty->assign('topmenu',"topmenu.tpl");
    $smarty->assign('sidebar',"sidebar.tpl");
    $smarty->assign('footinc',"footinc.tpl");
    $smarty->assign('currancy',$Currancy);
    $smarty->assign('bussiness_type',$bussinessType);



    ######### Registered Admin Functions (Smarty) #########
	$smarty->registerPlugin("function","getFromTable", "getFromTable");
	$smarty->registerPlugin("function","buildaddress", "buildaddress");
	$smarty->registerPlugin("function","getcount", "getcount");
	$smarty->registerPlugin("function","getcities", "getcities");
	$smarty->registerPlugin("function","getposition", "getposition");
	$smarty->registerPlugin("function","checkappointment", "checkappointment");
	######### Admin Authorization Class #########
	include("./inc/Classes/user-login.php");
	$login = new userLogin();






    ######### Language files #########
    include("./assets/Languages/ar.php");
    $smarty->assign("lang",$lang);
    $smarty->assign('site_name',"SFA");


//------------------CONTROL IN LINK ---------------//
	$GLOBALS['db']->query("SELECT  `group` FROM `staffs` WHERE `id` = '".$GLOBALS['login']->getUserId()."' ");
	 $queryTotal = $GLOBALS['db']->resultcount();
	if($queryTotal == 1)
	{
		$userPerms = $GLOBALS['db']->fetchitem();
		if($userPerms['group'] == -1)
			{
				$group=  array(
					
					"id"			                                    => 		1,
					"name"			                                    => 		1,
					"groups_list"			                            => 		1,
					"groups_delete"			                            => 		1,
					"groups_add"			                            => 		1,
					"groups_edit"			                            => 		1,
					"groups_active"			                            => 		1,
					"groups_view"			                            => 		1,
					"staffs_list"			                            => 		1,
					"staffs_delete"			                            => 		1,
					"staffs_add"			                            => 		1,
					"staffs_edit"			                            => 		1,
					"staffs_active"			                            => 		1,
					"staffs_view"			                            => 		1,
					"supervisors_list"			                        => 		1,
					"supervisors_delete"			                    => 		1,
					"supervisors_add"			                        => 		1,
					"supervisors_edit"			                        => 		1,
					"supervisors_active"			                    => 		1,
					"supervisors_view"			                        => 		1,
					"governorates_list"			                        => 		1,
					"governorates_delete"			                    => 		1,
					"governorates_add"			                        => 		1,
					"governorates_edit"			                        => 		1,
					"governorates_active"                               => 		1,
					"governorates_view"		                            => 		1,
					"cities_list"			                            => 		1,
					"cities_delete"			                            => 		1,
					"cities_add"			                            => 		1,
					"cities_edit"			                            => 		1,
					"cities_active"			                            => 		1,
					"cities_view"			                            => 		1,
					"representatives_list"			                    => 		1,
					"representatives_delete"			                => 		1,
					"representatives_add"			                    => 		1,
					"representatives_edit"			                    => 		1,
					"representatives_active"			                => 		1,
					"representatives_view"			                    => 		1,
					"jobs_list"			                                => 		1,
					"jobs_delete"			                            => 		1,
					"jobs_add"			                                => 		1,
					"jobs_edit"			                                => 		1,
					"jobs_active"			                            => 		1,
					"jobs_view"			                                => 		1,
					"clients_list"			                            => 		1,
					"clients_delete"			                        => 		1,
					"clients_add"			                            => 		1,
					"clients_edit"			                            => 		1,
					"clients_active"			                        => 		1,
					"clients_view"			                            => 		1,
					"products_list"			                            => 		1,
					"products_delete"			                        => 		1,
					"products_add"			                            => 		1,
					"products_edit"			                            => 		1,
					"products_active"			                        => 		1,
					"products_view"			                            => 		1,
					"orders_list"			                            => 		1,
					"orders_delete"			                            => 		1,
					"orders_add"			                            => 		1,
					"orders_edit"			                            => 		1,
					"orders_active"			                            => 		1,
					"orders_view"			                            => 		1,
					"returns_products_list"			                    => 		1,
					"returns_products_delete"			                => 		1,
					"returns_products_add"			                    => 		1,
					"returns_products_edit"			                    => 		1,
					"returns_products_active"			                => 		1,
					"returns_products_view"			                    => 		1,
					"installments_list"			                        => 		1,
					"installments_delete"			                    => 		1,
					"installments_add"			                        => 		1,
					"installments_edit"			                        => 		1,
					"installments_active"                               => 		1,
					"installments_view"	                                => 		1,
					"appointment_list"			                        => 		1,
					"appointment_delete"			                    => 		1,
					"appointment_add"			                        => 		1,
					"appointment_edit"			                        => 		1,
					"appointment_active"			                    => 		1,
					"appointment_view"			                        => 		1,
					"offers_list"			                            => 		1,
					"offers_delete"			                            => 		1,
					"offers_add"			                            => 		1,
					"offers_edit"			                            => 		1,
					"offers_active"			                            => 		1,
					"offers_view"			                            => 		1,
					"news_list"			                                => 		1,
					"news_delete"			                            => 		1,
					"news_add"			                                => 		1,
					"news_edit"			                                => 		1,
					"news_active"			                            => 		1,
					"news_view"			                                => 		1,
					"notifications_list"			                    => 		1,
					"notifications_delete"			                    => 		1,
					"notifications_add"			                        => 		1,
					"notifications_edit"			                    => 		1,
					"notifications_active"			                    => 		1,
					"notifications_view"			                    => 		1,
					"contacts_active"			                        => 		1,
					"contacts_list"			                            => 		1,
					"contacts_view"			                            => 		1,
					"invitation_active"			                        => 		1,
					"invitation_list"			                        => 		1,
					"invitation_view"			                        => 		1,
					"search"			                                => 		1,
					"logs"			                                    => 		1,
					"setting"			                                => 		1,
					"status"		                                    => 		1
				);
			}else
			{
				$query = $GLOBALS['db']->query("SELECT * FROM `groups`  WHERE `id` = '".$userPerms['group']."' ");
				$queryTotal = $GLOBALS['db']->resultcount();
				if($queryTotal >0)
				{
					$sitegroup = $GLOBALS['db']->fetchitem();
					$group= array(
							"id"			                => 		$sitegroup['id'],
							"name"			                => 		$sitegroup['name'],
							"groups_list"			        => 		$sitegroup['groups_list'],
							"groups_delete"			        => 		$sitegroup['groups_delete'],
							"groups_add"			        => 		$sitegroup['groups_add'],
							"groups_edit"			        => 		$sitegroup['groups_edit'],
							"groups_active"			        => 		$sitegroup['groups_active'],
							"groups_view"			        => 		$sitegroup['groups_view'],
							"staffs_list"			        => 		$sitegroup['staffs_list'],
							"staffs_delete"			        => 		$sitegroup['staffs_delete'],
							"staffs_add"			        => 		$sitegroup['staffs_add'],
							"staffs_edit"			        => 		$sitegroup['staffs_edit'],
							"staffs_active"			        => 		$sitegroup['staffs_active'],
							"staffs_view"			        => 		$sitegroup['staffs_view'],
							"supervisors_list"			    => 		$sitegroup['supervisors_list'],
							"supervisors_delete"			=> 		$sitegroup['supervisors_delete'],
							"supervisors_add"			    => 		$sitegroup['supervisors_add'],
							"supervisors_edit"			    => 		$sitegroup['supervisors_edit'],
							"supervisors_active"			=> 		$sitegroup['supervisors_active'],
							"supervisors_view"			    => 		$sitegroup['supervisors_view'],
						    "governorates_list"			    => 		$sitegroup['governorates_list'],
							"governorates_delete"	        => 		$sitegroup['governorates_delete'],
							"governorates_add"			    => 		$sitegroup['governorates_add'],
							"governorates_edit"		        => 		$sitegroup['governorates_edit'],
							"governorates_active"           => 		$sitegroup['governorates_active'],
							"governorates_view"		        => 		$sitegroup['governorates_view'],
							"cities_list"			        => 		$sitegroup['cities_list'],
							"cities_delete"			        => 		$sitegroup['cities_delete'],
							"cities_add"			        => 		$sitegroup['cities_add'],
							"cities_edit"			        => 		$sitegroup['cities_edit'],
							"cities_active"			        => 		$sitegroup['cities_active'],
							"cities_view"			        => 		$sitegroup['cities_view'],
							"representatives_list"			=> 		$sitegroup['representatives_list'],
							"representatives_delete"        => 		$sitegroup['representatives_delete'],
							"representatives_add"	        => 		$sitegroup['representatives_add'],
							"representatives_edit"	        => 		$sitegroup['representatives_edit'],
							"representatives_active"        => 		$sitegroup['representatives_active'],
							"representatives_view"	        => 		$sitegroup['representatives_view'],
							"jobs_list"			            => 		$sitegroup['jobs_list'],
							"jobs_delete"			        => 		$sitegroup['jobs_delete'],
							"jobs_add"			            => 		$sitegroup['jobs_add'],
							"jobs_edit"			            => 		$sitegroup['jobs_edit'],
							"jobs_active"			        => 		$sitegroup['jobs_active'],
							"jobs_view"			            => 		$sitegroup['jobs_view'],
						    "clients_list"			        => 		$sitegroup['clients_list'],
							"clients_delete"			    => 		$sitegroup['clients_delete'],
							"clients_add"			        => 		$sitegroup['clients_add'],
							"clients_edit"			        => 		$sitegroup['clients_edit'],
							"clients_active"			    => 		$sitegroup['clients_active'],
							"clients_view"			        => 		$sitegroup['clients_view'],
							"products_list"			        => 		$sitegroup['products_list'],
							"products_delete"			    => 		$sitegroup['products_delete'],
							"products_add"			        => 		$sitegroup['products_add'],
							"products_edit"			        => 		$sitegroup['products_edit'],
							"products_active"			    => 		$sitegroup['products_active'],
							"products_view"			        => 		$sitegroup['products_view'],
							"orders_list"			        => 		$sitegroup['orders_list'],
							"orders_delete"			        => 		$sitegroup['orders_delete'],
							"orders_add"			        => 		$sitegroup['orders_add'],
							"orders_edit"			        => 		$sitegroup['orders_edit'],
							"orders_active"			        => 		$sitegroup['orders_active'],
							"orders_view"			        => 		$sitegroup['orders_view'],
							"returns_products_list"			=> 		$sitegroup['returns_products_list'],
							"returns_products_delete"		=> 		$sitegroup['returns_products_delete'],
							"returns_products_add"			=> 		$sitegroup['returns_products_add'],
							"returns_products_edit"			=> 		$sitegroup['returns_products_edit'],
							"returns_products_active"		=> 		$sitegroup['returns_products_active'],
							"returns_products_view"			=> 		$sitegroup['returns_products_view'],
							"installments_list"			    => 		$sitegroup['installments_list'],
							"installments_delete"	        => 		$sitegroup['installments_delete'],
							"installments_add"  	        => 		$sitegroup['installments_add'],
							"installments_edit"	            => 		$sitegroup['installments_edit'],
							"installments_active"           => 		$sitegroup['installments_active'],
							"installments_view"		        => 		$sitegroup['installments_view'],
							"appointment_list"			    => 		$sitegroup['appointment_list'],
							"appointment_delete"			=> 		$sitegroup['appointment_delete'],
							"appointment_add"			    => 		$sitegroup['appointment_add'],
							"appointment_edit"	            => 		$sitegroup['appointment_edit'],
							"appointment_active"            => 		$sitegroup['appointment_active'],
							"appointment_view"		        => 		$sitegroup['appointment_view'],
							"offers_list"			        => 		$sitegroup['offers_list'],
							"offers_delete"			        => 		$sitegroup['offers_delete'],
							"offers_add"			        => 		$sitegroup['offers_add'],
							"offers_edit"			        => 		$sitegroup['offers_edit'],
							"offers_active"			        => 		$sitegroup['offers_active'],
							"offers_view"			        => 		$sitegroup['offers_view'],
							"news_list"			            => 		$sitegroup['news_list'],
							"news_delete"			        => 		$sitegroup['news_delete'],
							"news_add"			            => 		$sitegroup['news_add'],
							"news_edit"			            => 		$sitegroup['news_edit'],
							"news_active"			        => 		$sitegroup['news_active'],
							"news_view"			            => 		$sitegroup['news_view'],
							"notifications_list"			=> 		$sitegroup['notifications_list'],
							"notifications_delete"			=> 		$sitegroup['notifications_delete'],
							"notifications_add"			    => 		$sitegroup['notifications_add'],
							"notifications_edit"			=> 		$sitegroup['notifications_edit'],
							"notifications_active"			=> 		$sitegroup['notifications_active'],
							"notifications_view"			=> 		$sitegroup['notifications_view'],
							"contacts_view"		            => 		$sitegroup['contacts_view'],
							"contacts_list"		            => 		$sitegroup['contacts_list'],
							"contacts_active"		        => 		$sitegroup['contacts_active'],
							"invitation_view"		        => 		$sitegroup['invitation_view'],
							"invitation_list"		        => 		$sitegroup['invitation_list'],
							"invitation_active"		        => 		$sitegroup['invitation_active'],
							"search"		                => 		$sitegroup['search'],
							"logs"		                    => 		$sitegroup['logs'],
							"setting"		                => 		$sitegroup['setting'],
							"status"		                => 		$sitegroup['status']
						);
				}
		   }
			$smarty->assign('group',$group);
	}

    if($login->doCheck() == true)
	{
		$smarty->assign('username',$login->getName());
	}


	$smarty->assign('pagetime',time());

	$basicLimit = 25;
	// -------------------PATH-FOR-IMAGE-------------------//

	  $smarty->assign('path_img',$path_img);
	  $smarty->assign('Currancy',$Currancy);




	########### DROPDOWN FOR PRINT ##################
	  $smarty->assign('export','<div class="row" style="position: absolute;left: 30px">
		                      <div class="btn-group pull-right" style=" padding: 15px;">
								<div class="dropdown">
									<button class="btn btn-default dropdown-toggle" type="button" id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
										<span class="glyphicon glyphicon-print"></span><strong> Export </strong>
									</button>
									<ul class="dropdown-menu" aria-labelledby="dropdownMenu1" >
										<li><a href="#" class="pdf" dir="ltr" style="text-align: left ; color: black;font-size: 20px"><img src="./assets/img/pdf.png" width="30px"> pdf </a></li>
										<li class="divider"></li>
										<li><a href="#" class="xlxs" dir="ltr" style="text-align: left ; color: black;font-size: 20px"><img src="./assets/img/xls.png" width="30px"> XLS </a></li>
									</ul>
								</div>
							  </div>
							</div>');


?>
