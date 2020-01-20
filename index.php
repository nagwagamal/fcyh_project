<?php
	// output buffer..
	ob_start("ob_gzhandler");

    // my system key cheker..
    define("inside",true);

		
    // get funcamental file which contain config and template files,settings.
	include("./inc/fundamentals.php");
   
	include("./inc/Classes/system.logs.php");
	$logs      = new logs();

	


	include("./inc/Classes/system-dashboard.php");
	$dash = new systemDashboard();

	if($login->doCheck() == false)
	{
 		$smarty->assign(logMode,1);
		$smarty->assign(area_name,"login");
		$smarty->assign(logdata,$lang['LGN_YOU_MUST_LOGIN']);
		$tm->fetch($lang['login'],"user-login.tpl");
	}else
	{

		switch($_GET['do'])
		{
			case"":
	
				// include("./inc/Classes/pager.class.php");
				// $pager      = new pager();
				// $page 		= intval($_GET[page]);
				// $basicLimit = 5 ;
				// $pager->doAnalysisPager("page",$page,$basicLimit,$Reps->getTotalReps(),"dashboard.html".$paginationAddons,$paginationDialm);
				// $thispage = $pager->getPage();
				// $limitmequry = " LIMIT ".($thispage-1) * $basicLimit .",". $basicLimit;
					
				$smarty->assign(area_name,"list");
				// $smarty->assign('pager',$pager->getAnalysis()) ;
/*
				$smarty->assign(u,$rep->getsite_disableLocations() );
*/
				
				
			break;

		}
		$smarty->assign(footJs,array('list-controls.js'));
		$tm->display($lang['NDX_PAGE_NAME'],"dashboard.tpl");

	}

	$db->disconnect();
	ob_end_flush();
?>
