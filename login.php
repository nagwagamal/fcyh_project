<?php
	// output buffer..
	ob_start("ob_gzhandler");

    // my system key cheker..
    define("inside",true);
	define("access_admin","GitZone");

	// get funcamental file which contain config and template files,settings.
	include("./inc/fundamentals.php");

    include("./inc/Classes/system.logs.php");
	$logs = new logs();

	switch($_GET['do'])
	{
        case"":

	        if($login->doCheck() == true)
			{
				/*$logs->addLog(1,
						array(
							"type" 		=> 	"admin",
							"module" 	=> 	"login",
							"mode" 		=> 	"login",
							"id" 		=>	$login->getUserId(),
						),"admin",$login->getUserId(),1
					);*/
				$smarty->assign(area_name,"login");
		       	$smarty->assign(logexception,1);
	       		$smarty->assign(logdata,$lang['LGN_IS_DUPLICATED']);
	       		$smarty->assign(logFine,1);
	       		$smarty->assign(hockHeader,"<META HTTP-EQUIV=\"Refresh\" CONTENT=\"2; url=index.html\">");
			}else
			{
				$smarty->assign(area_name,"login");
				$smarty->assign(logMode,1);
	       		$smarty->assign(logdata,$lang['login_access']);

			}

        break;
        case"login":
			/*$logs->addLog(2,
						array(
							"type" 		=> 	"admin",
							"module" 	=> 	"login",
							"mode" 		=> 	"login",
							"id" 		=>	$login->getUserId(),
						),"admin",$login->getUserId(),1
					);*/
            if($login->doCheck() == true)
			{

				$smarty->assign(area_name,"login");
				$smarty->assign(logexception,1);
	       		$smarty->assign(logdata,$lang['LGN_IS_DUPLICATED']);
	       		$smarty->assign(logFine,1);
	       		$smarty->assign(hockHeader,"<META HTTP-EQUIV=\"Refresh\" CONTENT=\"2; url=index.html\">");

			}else
			{
	            // recieving the parameters
	            $logResult = $login->doLogin(sanitize($_POST["email"]),sanitize($_POST["password"]),intval($_POST["remember"]));
//				$logs->addLog(3,
//						array(
//							"type" 		=> 	"admin",
//							"module" 	=> 	"login",
//							"mode" 		=> 	"login",
//							"id" 		=>	$login->getUserId(),
//						),"admin",$login->getUserId(),1
//					);

	        	if($logResult ==0)
	        	{
					/*$logs->addLog(4,
						array(
							"type" 		=> 	"admin",
							"module" 	=> 	"login",
							"mode" 		=> 	"login",
							"id" 		=>	$login->getUserId(),
						),"admin",$login->getUserId(),1
					);*/
					$smarty->assign(area_name,"login");
	        		$smarty->assign(logMode,1);
	                $smarty->assign(logdata,$lang['LGN_EMPTY_DATA']);
	        	}elseif($logResult ==1)
	        	{
					/*$logs->addLog(5,
						array(
							"type" 		=> 	"admin",
							"module" 	=> 	"login",
							"mode" 		=> 	"login",
							"id" 		=>	$login->getUserId(),
						),"admin",$login->getUserId(),1
					);*/
					$smarty->assign(area_name,"login");
	        		$smarty->assign(logLast,1);
	               	$smarty->assign(logdata,$lang['LGN_IS_SUCESSFULLY']);
	       			$smarty->assign(logFine,1);
	       			$smarty->assign(hockHeader,"<META HTTP-EQUIV=\"Refresh\" CONTENT=\"2; url=index.html\">");
	        	}elseif($logResult ==3)
	        	{
					/*$logs->addLog(6,
						array(
							"type" 		=> 	"admin",
							"module" 	=> 	"login",
							"mode" 		=> 	"login",
							"id" 		=>	$login->getUserId(),
						),"admin",$login->getUserId(),1
					);*/
					$smarty->assign(area_name,"login");
	        		$smarty->assign(logexception,1);
	       			$smarty->assign(logdata,$lang['LGN_IS_DUPLICATED']);
	       			$smarty->assign(logFine,1);
	       			$smarty->assign(hockHeader,"<META HTTP-EQUIV=\"Refresh\" CONTENT=\"2; url=index.html\">");
	        	}else
	       		{
					/*$logs->addLog(7,
						array(
							"type" 		=> 	"admin",
							"module" 	=> 	"login",
							"mode" 		=> 	"login",
							"id" 		=>	$login->getUserId(),
						),"admin",$login->getUserId(),1
					);*/
					$smarty->assign(area_name,"login");
	         		$smarty->assign(logMode,1);
	       			$smarty->assign(logdata,$lang['LGN_WORNG_DATA']);
	       		}
       		}

        break;
        case"logout":
       		if($login->doLogout() == true)
       		{
//				$logs->addLog(8,
//						array(
//							"type" 		=> 	"admin",
//							"module" 	=> 	"login",
//							"mode" 		=> 	"logout",
//							"id" 		=>	$login->getUserId(),
//						),"admin",$login->getUserId(),1
//					);
				$smarty->assign(area_name,"login");
       			$smarty->assign(logexception,1);
               	$smarty->assign(logdata,$lang['LGN_SUCCESSFUL_LOGOUT']);
       			$smarty->assign(logFine,1);
       			$smarty->assign(hockHeader,"<META HTTP-EQUIV=\"Refresh\" CONTENT=\"2; url=login.html\">");

       		}else
       		{
//				$logs->addLog(9,
//						array(
//							"type" 		=> 	"admin",
//							"module" 	=> 	"login",
//							"mode" 		=> 	"not login",
//							"id" 		=>	$login->getUserId(),
//						),"admin",$login->getUserId(),1
//					);
				$smarty->assign(area_name,"login");
       			$smarty->assign(logexception,1);
               	$smarty->assign(logdata,$lang['login_first']);
       			$smarty->assign(logFine,1);
       			$smarty->assign(hockHeader,"<META HTTP-EQUIV=\"Refresh\" CONTENT=\"2; url=login.html\">");
       		}

        break;
	  case"forgetten":
			$smarty->assign(area_name,"forgetten");
            $smarty->assign(logdata,$lang['search_account']);
			break;
	  case"send_message":
			$smarty->assign(area_name,"send_message");
			if($_POST)
        		{
					$_user['email'] 		    = 	$_POST["email"];
			        $done=$login->forgetpassword($_user);
				if($done == 1 ){
            		$smarty->assign(logdata,$lang['massage_confirm']);
				}else{
					 $smarty->assign(logdata,$lang['account_not_found']);
				}
			}
			break;
//	  case"rest_password":
//
//			$smarty->assign(area_name,"rest_password");
//            $smarty->assign(logdata,$lang['rest_password']);
//			if($_GET['email'] && $_GET['key'])
//			{
//				$_check['email']  = $_GET['email'];
//				$_check['key']  = $_GET['key'];
//
//				$check = $login->checkemail($_check);
//				if($check == 1 )
//				{
//
//					$smarty->assign(email,"$_GET[email]");
//					$smarty->assign(_key,"$_GET[key]");
//					if($_POST)
//					{
//						$_user['email'] 		    = 	$_POST["email"];
//						$_user['key'] 		        = 	$_POST["key"];
//						$_user['password'] 		    = 	$_POST["password"];
//						$reset=$login->resetpassword($_user);
//						if($reset == 1 ){
//						$smarty->assign(logMode,2);
//						$smarty->assign(logdata,$lang['pass_change']);
//						}
//					}
//				}
//				else
//				{
//					$smarty->assign(logMode,2);
//					$smarty->assign(logdata,$lang['link_expried']);
//				}
//
//
//			}
//	 break;
	}
	$tm->fetch("$lang[login_in]","user-login.tpl");
	$db->disconnect();
	ob_end_flush();
?>
