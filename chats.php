<?php
	define("inside",true);
	define("access_admin","GitZone");

	ob_start("ob_gzhandler");

	// get funcamental file which contain config and template files,settings.
	include("./inc/fundamentals.php");

include("./inc/Classes/system-chats.php");
	$chats = new systemChats();
	
	include("./inc/Classes/system-users.php");
	$user = new systemUsers();
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
					$pager->doAnalysisPager("page",$page,$basicLimit,$chats->getTotalChat(),"chats.html".$paginationAddons,$paginationDialm);
					$thispage = $pager->getPage();
					$limitmequry = " LIMIT ".($thispage-1) * $basicLimit .",". $basicLimit;
					$smarty->assign(area_name,"list");
					$smarty->assign('pager',$pager->getAnalysis());
					$smarty->assign(u,$chats->getsiteChat($limitmequry));
					$smarty->assign(p,$user->getsiteUsers());
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
                        $smarty->assign(u,$chats->getChatInformation($mId));
					   $smarty->assign(p,$user->getsiteUsers());
					}
				}
			break;
                }
		$smarty->assign(footJs,array('list-controls.js'));
		$tm->display("$lang[Governorates_mangment]","chats.tpl");
	}

	$db->disconnect();
	ob_end_flush();
?>
