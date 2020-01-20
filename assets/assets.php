<?php
 

	######### Main Security Basic Filter Function ;) #########
	ini_set('date.timezone', 'Africa/Cairo');

	function sanitize( $str , $type = "str" )
	{
		$str = strip_tags ($str);
		$str = trim ($str);
		$str = htmlspecialchars ($str, ENT_NOQUOTES);
		$str = addslashes ($str);
		if($type == "area")
		$str = str_replace("\n","<br />",$str);
		return $str;
	}

	function parseTwinty( $str )
	{
		$str = substr($str,0,20);
		return $str;
	}

	

	function colorize($val)
	{
		if($val > 0)
		{
			$color = "red";

		}else
		{
			$color = "black";

		}
		return ("<font color=".$color.">".$val."</font>");
	}




	function parseSubMeters($val)
	{
		$dotPos = strrpos($val,",");
		if($dotPos != false)
		{
			$metersFlo = intval(substr($val,$dotPos+1));
		}else{
			$dotPos = strrpos($val,".");
			if($dotPos != false)
			{
				$metersFlo = (substr($val,$dotPos+1));
			}
			else
			{
				$metersFlo = "-";
			}	
		}
		return ($metersFlo);
	}


	  
	function getusername($_Id)
	{

		$product = $GLOBALS['db']->query(" SELECT * FROM `staffs` WHERE `id` = '".$_Id."' LIMIT 1");
		$productCount = $GLOBALS['db']->resultcount();
		if($productCount == 1)
		{
			$_product = $GLOBALS['db']->fetchitem($product);
			return ($_product['name']);
		}
		else
		{
			return ($GLOBALS['lang']['not_define']);
		}
	}


	function getkindname($_Id)
	{

		$product = $GLOBALS['db']->query(" SELECT * FROM `kind` WHERE `id` = '".$_Id."' LIMIT 1");
		$productCount = $GLOBALS['db']->resultcount();
		if($productCount == 1)
		{
			$_product = $GLOBALS['db']->fetchitem($product);
			return ($_product['name_en']);
		}
		else
		{
			return ($GLOBALS['lang']['not_define']);
		}
	}

	function getCatname($_Id)
	{

		$product = $GLOBALS['db']->query(" SELECT * FROM `categories` WHERE `id` = '".$_Id."' LIMIT 1");
		$productCount = $GLOBALS['db']->resultcount();
		if($productCount == 1)
		{
			$_product = $GLOBALS['db']->fetchitem($product);
			return ($_product['name_ar'] ." - ". $_product['name'] );
		}
		else
		{
			return ($GLOBALS['lang']['not_define']);
		}
	}


	function getinvoce($_Id)
	{

		$product = $GLOBALS['db']->query(" SELECT * FROM `installments` WHERE `order_id` = '".$_Id."' LIMIT 1");
		$productCount = $GLOBALS['db']->resultcount();
		if($productCount == 1)
		{
			$_product = $GLOBALS['db']->fetchitem($product);
			return ($_product['invoice']);
		}
		else
		{
			return ($GLOBALS['lang']['not_define']);
		}
	}


	function money_target($_Id)
	{

		$product = $GLOBALS['db']->query(" SELECT * FROM `target_money` WHERE `rep_id` = '".$_Id."' LIMIT 1");
		$productCount = $GLOBALS['db']->resultcount();
		if($productCount == 1)
		{
			$_product = $GLOBALS['db']->fetchitem($product);
			return ($_product['target']);
		}
		else
		{
			return ($GLOBALS['lang']['not_define']);
		}
	}
	function visits_target($_Id)
	{

		$product = $GLOBALS['db']->query(" SELECT * FROM `target_money` WHERE `rep_id` = '".$_Id."' LIMIT 1");
		$productCount = $GLOBALS['db']->resultcount();
		if($productCount == 1)
		{
			$_product = $GLOBALS['db']->fetchitem($product);
			return ($_product['visits']);
		}
		else
		{
			return ($GLOBALS['lang']['not_define']);
		}
	}

	function clients_target($_Id)
	{

		$product = $GLOBALS['db']->query(" SELECT * FROM `target_money` WHERE `rep_id` = '".$_Id."' LIMIT 1");
		$productCount = $GLOBALS['db']->resultcount();
		if($productCount == 1)
		{
			$_product = $GLOBALS['db']->fetchitem($product);
			return ($_product['clients']);
		}
		else
		{
			return ($GLOBALS['lang']['not_define']); 
		}
	}

	function office_target($_Id)
	{

		$product = $GLOBALS['db']->query(" SELECT * FROM `target_money` WHERE `rep_id` = '".$_Id."' LIMIT 1");
		$productCount = $GLOBALS['db']->resultcount();
		if($productCount == 1)
		{
			$_product = $GLOBALS['db']->fetchitem($product);
			return ($_product['office_target']);
		}
		else
		{
			return ($GLOBALS['lang']['not_define']); 
		}
	}

   function notes($_Id)
	{

		$product = $GLOBALS['db']->query(" SELECT * FROM `notes` WHERE `appointment_id` = '".$_Id."' LIMIT 1");
		$productCount = $GLOBALS['db']->resultcount();
		if($productCount == 1)
		{
			$_product = $GLOBALS['db']->fetchitem($product);
			return ($_product['note']);
		}
		
	}

	function HR_target($_Id)
	{

		$product = $GLOBALS['db']->query(" SELECT * FROM `target_money` WHERE `rep_id` = '".$_Id."' LIMIT 1");
		$productCount = $GLOBALS['db']->resultcount();
		if($productCount == 1)
		{
			$_product = $GLOBALS['db']->fetchitem($product);
			return ($_product['HR_target']);
		}
		else
		{
			return ($GLOBALS['lang']['not_define']); 
		}
	}
	function daily_report($_Id)
	{

		$product = $GLOBALS['db']->query(" SELECT * FROM `target_money` WHERE `rep_id` = '".$_Id."' LIMIT 1");
		$productCount = $GLOBALS['db']->resultcount();
		if($productCount == 1)
		{
			$_product = $GLOBALS['db']->fetchitem($product);
			return ($_product['daily_report']);
		}
		else
		{
			return ($GLOBALS['lang']['not_define']); 
		}
	}
		


	function checkappointment($params, &$smarty)
	{
		$_Id          = $params['a'];
		$type         = $params['b'];

		$product = $GLOBALS['db']->query(" SELECT * FROM `appointment` WHERE `type_id` = '".$_Id."' && `type` = '".$type."' LIMIT 1");
		$productCount = $GLOBALS['db']->resultcount();
		if($productCount == 1)
		{
			return 1;
		}
		else
		{
			return 2; 
		}
	}

	function checkstock($_Id)
	{
		$date = date('Y-m-d');

		$product = $GLOBALS['db']->query(" SELECT * FROM `client_stock` WHERE `client_id` = '".$_Id."' && `date` = '".$date."' LIMIT 1");
		$productCount = $GLOBALS['db']->resultcount();
		if($productCount == 1)
		{
			return 1;
		}
	}

	function checkprescriptions($_Id)
	{
		$date = date('Y-m-d');

		$product = $GLOBALS['db']->query(" SELECT * FROM `prescriptions` WHERE `client_id` = '".$_Id."' && `date` = '".$date."' LIMIT 1");
		$productCount = $GLOBALS['db']->resultcount();
		if($productCount == 1)
		{
			$_product = $GLOBALS['db']->fetchitem($product);
			return ($_product['supervisor_id']);
		}else
		{
			return 0;
		}
	}

	function GetID($table , $name)
	{
		if($GLOBALS['login']->doCheck() == true)
		{
			$query = $GLOBALS['db']->query("SELECT * FROM `".$table."` WHERE `name` = '".$name."'  LIMIT 1 ");
			$queryTotal = $GLOBALS['db']->resultcount();
			if($queryTotal == 1)
			{
				$siteid = $GLOBALS['db']->fetchitem($query);
				return array(
					"id"			=> 		$siteid['id'],
				);


			}else{return true;}
		}else{$GLOBALS['login']->doDestroy();return false;}
	}
 

	function getTotalorders($id , $type_id){
		$query = $GLOBALS['db']->query("SELECT count(*) AS total FROM `orders` WHERE $type_id = '".$id."' ");
		$queryTotal = $GLOBALS['db']->resultcount();
		if($queryTotal == 1)
		{
			$siteid = $GLOBALS['db']->fetchitem($query);
			return ( $siteid['total'] ) ;


		}else{return true;}

	}


	function getTotalinstallments($id , $type_id){
		$query = $GLOBALS['db']->query("SELECT count(*) AS total FROM `installments` WHERE $type_id = '".$id."' ");
		$queryTotal = $GLOBALS['db']->resultcount();
		if($queryTotal == 1)
		{
			$siteid = $GLOBALS['db']->fetchitem($query);
			return ( $siteid['total'] ) ;


		}else{return true;}

	}

	function getTotalreturns($id , $type_id){
		$query = $GLOBALS['db']->query("SELECT count(*) AS total FROM `returns` WHERE $type_id = '".$id."' ");
		$queryTotal = $GLOBALS['db']->resultcount();
		if($queryTotal == 1)
		{
			$siteid = $GLOBALS['db']->fetchitem($query);
			return ( $siteid['total'] ) ;


		}else{return true;}

	}

	function getTotalappointment($id , $type_id){
		$query = $GLOBALS['db']->query("SELECT count(*) AS total FROM `tasks` WHERE $type_id = '".$id."' AND ( ( (`type` ='visit2' && `notifications_done` = 1) || (`type` != 'visit2' ) ) OR `start` != 0  ) ");
		$queryTotal = $GLOBALS['db']->resultcount();
		if($queryTotal == 1)
		{
			$siteid = $GLOBALS['db']->fetchitem($query);
			return ( $siteid['total'] ) ;


		}else{return true;}

	}

	function getTotalfinish_appointment($id,$month){
		
		$query = $GLOBALS['db']->query("SELECT count(*) AS total FROM `tasks` WHERE `rep_id` = '".$id."' AND `rep_confirm` = 1 AND `date` = '".$month."'  ");
		$queryTotal = $GLOBALS['db']->resultcount();
		
		if($queryTotal == 1)
		{
			$siteid = $GLOBALS['db']->fetchitem($query);
			return ( $siteid['total'] ) ;


		}else{return true;}

	}

	function getTotal_all_finish_appointment($id,$month){
		
		$query = $GLOBALS['db']->query("SELECT count(*) AS total FROM `tasks` WHERE `rep_id` = '".$id."' AND `rep_confirm` = 1 AND MONTH(`date`) = '".$month."'  ");
		$queryTotal = $GLOBALS['db']->resultcount();
		
		if($queryTotal == 1)
		{
			$siteid = $GLOBALS['db']->fetchitem($query);
			return ( $siteid['total'] ) ;


		}else{return true;}

	}

	function getTotalfinish_clients($id,$month){
		
		$query = $GLOBALS['db']->query("SELECT count(*) AS total FROM `clients` WHERE `by` = '".$id."' AND DATE(`reg_time`) = '".$month."'  ");
		$queryTotal = $GLOBALS['db']->resultcount();
		
		if($queryTotal == 1)
		{
			$siteid = $GLOBALS['db']->fetchitem($query);
			return ( $siteid['total'] ) ;


		}else{return true;}

	}

	function getTotal_all_finish_clients($id,$month){
		
		$query = $GLOBALS['db']->query("SELECT count(*) AS total FROM `clients` WHERE `by` = '".$id."' AND MONTH(`reg_time`) = '".$month."'  ");
		$queryTotal = $GLOBALS['db']->resultcount();
		
		if($queryTotal == 1)
		{
			$siteid = $GLOBALS['db']->fetchitem($query);
			return ( $siteid['total'] ) ;


		}else{return true;}

	}


	function getTotalfinish_orders($id,$month){
		
		$query = $GLOBALS['db']->query("SELECT count(*) AS total FROM `orders` WHERE `rep_id` = '".$id."' AND `status` = 2 AND DATE(`date`) = '".$month."'  ");
		$queryTotal = $GLOBALS['db']->resultcount();
		
		if($queryTotal == 1)
		{
			$siteid = $GLOBALS['db']->fetchitem($query);
			return ( $siteid['total'] ) ;


		}else{return true;}

	}

	function getTotal_all_finish_orders($id,$month){
		
		$query = $GLOBALS['db']->query("SELECT count(*) AS total FROM `orders` WHERE `rep_id` = '".$id."' AND `status` = 2 AND MONTH(`date`) = '".$month."'  ");
		$queryTotal = $GLOBALS['db']->resultcount();
		
		if($queryTotal == 1)
		{
			$siteid = $GLOBALS['db']->fetchitem($query);
			return ( $siteid['total'] ) ;


		}else{return true;}

	}

	function getTotalfinish_installments($id,$month){
		
		$query = $GLOBALS['db']->query("SELECT count(*) AS total FROM `installments` WHERE `rep_id` = '".$id."' AND `rep_confirm` = 1 AND DATE(`date`) = '".$month."'  ");
		$queryTotal = $GLOBALS['db']->resultcount();
		
		if($queryTotal == 1)
		{
			$siteid = $GLOBALS['db']->fetchitem($query);
			return ( $siteid['total'] ) ;


		}else{return true;}

	}

	function getTotal_all_finish_installments($id,$month){
		
		$query = $GLOBALS['db']->query("SELECT count(*) AS total FROM `installments` WHERE `rep_id` = '".$id."' AND `rep_confirm` = 1 AND MONTH(`date`) = '".$month."'  ");
		$queryTotal = $GLOBALS['db']->resultcount();
		
		if($queryTotal == 1)
		{
			$siteid = $GLOBALS['db']->fetchitem($query);
			return ( $siteid['total'] ) ;


		}else{return true;}

	}

	function getTotalfinish_returns($id,$month){
		
		$query = $GLOBALS['db']->query("SELECT count(*) AS total FROM `returns` WHERE `rep_id` = '".$id."' AND `status` = 2 AND DATE(`date`) = '".$month."'  ");
		$queryTotal = $GLOBALS['db']->resultcount();
		
		if($queryTotal == 1)
		{
			$siteid = $GLOBALS['db']->fetchitem($query);
			return ( $siteid['total'] ) ;


		}else{return true;}

	}

	function getTotal_all_finish_returns($id,$month){
		
		$query = $GLOBALS['db']->query("SELECT count(*) AS total FROM `returns` WHERE `rep_id` = '".$id."' AND `status` = 2 AND MONTH(`date`) = '".$month."'  ");
		$queryTotal = $GLOBALS['db']->resultcount();
		
		if($queryTotal == 1)
		{
			$siteid = $GLOBALS['db']->fetchitem($query);
			return ( $siteid['total'] ) ;


		}else{return true;}

	}


	function getgroupname($_Id)
	{

		$product = $GLOBALS['db']->query(" SELECT * FROM `groups` WHERE `id` = '".$_Id."' LIMIT 1");
		$productCount = $GLOBALS['db']->resultcount();
		if($productCount == 1)
		{
			$_product = $GLOBALS['db']->fetchitem($product);
			return ($_product['name']);
		}
		else
		{
			return ($GLOBALS['lang']['not_define']); 
		}
	}



 	function getlog_type($_Id)
		{

			$product = $GLOBALS['db']->query(" SELECT * FROM `log_type` WHERE `id` = '".$_Id."' LIMIT 1");
			$productCount = $GLOBALS['db']->resultcount();
			if($productCount == 1)
			{
				$_product = $GLOBALS['db']->fetchitem($product);
				return ("<b>".$_product['module']."</b>");
			}
			else
			{
				return ($GLOBALS['lang']['not_define']); 
			}
		}



	function getMembershipType($_Id)
	{
			$mem = "membership_".$_Id;
			if($_Id > 0 && $_Id <=3)
			{
				return ($GLOBALS[$mem]);
			}else
			{
				return ($GLOBALS['lang']['not_define']);
			}
		}



	function parseMeters($val)
	{
		 return intval($val);
	}
	function parseMoney($val)
	{
		$dotPos = strrpos($val,".");
		if($dotPos != false)
		{
			$moneyFlo = (substr($val,0,$dotPos));
		}
		return ($moneyFlo);
		
	}
	

    ######### Swapping textarea Content #########
    function br2nl($str)
	{
	    $str = str_replace("<br />","\n",$str);
	    return $str;
	}

	function commaSeperate($str)
	{
	    $str = str_replace(",","<br />",$str);
	    return $str;
	}


	######### Valid Email Check #########
	function checkMail($str)
	{
		return ( ! preg_match("/^([a-z0-9\+_\-]+)(\.[a-z0-9\+_\-]+)*@([a-z0-9\-]+\.)+[a-z]{2,6}$/ix", $str)) ? false : true;
	}

	function full_date_format ($date)
	{
	    return  date('l dS F Y ', strtotime($date));
	}
	function number ($number)
	{
	    return  number_format($number,1, '.', '');;
	}

	function full_format_ar ($val)
	{
		global $arCodeObject;
		return $arCodeObject->int2str($val);
	}

    function _date_format ($date)
	{
	    return  date(" A h:i  Y/m/d  ",strtotime($date));
	}

	function _time_format ($time)
	{
	    return  date(" g:i A",strtotime($time));
	}

	function array_length ($array)
	{
	    return  count($array);
	}
	
	function getFromTable($params, &$smarty)
	{
		$attId   		= $params['a'];
		$tableName   	= $params['b'];
		$functionName   = $params['c'];
		$attName   		= $params['d'];
		require_once('./inc/Classes/system-'.$tableName.'.php');

		eval("\$class = new system".ucfirst($tableName)."();");

		$returnedData = $class->$functionName($attId);

		return ($returnedData[$attName]);
	}


	////// GET_COUNT////////////////////
   function getcount($params, &$smarty)
	{
		$_Id          = $params['a'];
		$table        = $params['b'];
		$where        = $params['c'];
	    $query=$GLOBALS['db']->query(" SELECT COUNT(*) AS COUNT FROM `$table` WHERE `$where` = '".$_Id."'");
		$count = $GLOBALS['db']->fetchitem($query);
	    
	    return( 
				$count['COUNT']
		);
   }


	function getcityname($_Id)
	{

		$product = $GLOBALS['db']->query(" SELECT * FROM `cities` WHERE `id` = '".$_Id."' LIMIT 1");
		$productCount = $GLOBALS['db']->resultcount();
		if($productCount == 1)
		{
			$_product = $GLOBALS['db']->fetchitem($product);
			return ($_product['name_ar']." - ". $_product['name_en'] );
		}else
		{
			return ($GLOBALS['lang']['not_define']);
		}
	}  

	function getgovernoratename($_Id)
	{

		$product = $GLOBALS['db']->query(" SELECT * FROM `governorates` WHERE `id` = '".$_Id."' LIMIT 1");
		$productCount = $GLOBALS['db']->resultcount();
		if($productCount == 1)
		{
			$_product = $GLOBALS['db']->fetchitem($product);
			return ($_product['name_ar'] );
		}else
		{
			return ($GLOBALS['lang']['not_define']);
		}
	}

	function getjobname($_Id)
	{

		$product = $GLOBALS['db']->query(" SELECT * FROM `jobs` WHERE `id` = '".$_Id."' LIMIT 1");
		$productCount = $GLOBALS['db']->resultcount();
		if($productCount == 1)
		{
			$_product = $GLOBALS['db']->fetchitem($product);
			return ($_product['job']);
		}else
		{
			return ($GLOBALS['lang']['not_define']);
		}
	}


	function get_inform_work( $_id ){
		
		$date = date('Y-m-d');
		
		$works = $GLOBALS['db']->query(" SELECT `daily_working`.* , TIME(`end_time`) AS `time_only` FROM `daily_working` WHERE `rep_id` = '".$_id."' AND `date` = '".$date."' ORDER BY `id` DESC LIMIT 1");
		$worktCount = $GLOBALS['db']->resultcount();
		if($worktCount == 1){
			$_works = $GLOBALS['db']->fetchitem($works);
			
			if( $_works['end_lon'] == 0.00000000 && $_works['end_lat'] == 0.00000000 ){
				
				$time1 = $_works['start_time'] ;
				$time2 =  date("H:i:s") ;
				list($hours, $minutes) = explode(':', $time1);
				$firstTimestamp = mktime($hours, $minutes);

				list($hours, $minutes) = explode(':', $time2);
				$secondTimestamp = mktime($hours, $minutes);

				$seconds =  $secondTimestamp - $firstTimestamp;

				$seconds<0?$seconds+=24*60*60:"";

				$minutes = ($seconds / 60) % 60;
				$hours = floor($seconds / (60 * 60));

				return "<p style='color:blue;font-size: 13px;'>".$GLOBALS['lang']['work_ago']."<b>$hours</b> ".$GLOBALS['lang']['hours']."<b>$minutes</b>".$GLOBALS['lang']['minutes']."</p>";

			}else{
				
				$time1 = $_works['time_only'] ;
				$time2 =  date("H:i:s") ; 
				list($hours, $minutes) = explode(':', $time1);
				$firstTimestamp = mktime($hours, $minutes);

				list($hours, $minutes) = explode(':', $time2);
				$secondTimestamp = mktime($hours, $minutes);

				$seconds =  $secondTimestamp - $firstTimestamp;

				$seconds<0?$seconds+=24*60*60:"";

				$minutes = ($seconds / 60) % 60;
				$hours = floor($seconds / (60 * 60));

				return "<p style='font-size: 13px;'>".$GLOBALS['lang']['work_end']."<b>$hours</b> ".$GLOBALS['lang']['hours']."<b>$minutes</b>".$GLOBALS['lang']['minutes']."</p>";


			}
		}else{
			return "<p style='color:red;font-size: 13px;'>".$GLOBALS['lang']['work_out']."</p>" ;
		}


	}

	function get_since($time , $time2="")
	{
		$time = strtotime($time);

		if($time2 =="")
		{
			$time2 = time();	
		}else
		{
			$time2 =  strtotime($time2);

		}
	
		$time =  abs($time2 - $time); // to get the time since that moment
		$time = ($time<1)? 1 : $time;

		$tokens = array (
			31536000 => 'سنة',
			2592000 => 'شهر',
			604800 => 'إسبوع',
			86400 => 'يوم',
			3600 => 'ساعة',
			60 => 'دقيقة',
			1 => 'ثواني'
		);
	
		foreach ($tokens as $unit => $text) {
			if ($time < $unit) continue;
			$numberOfUnits = floor($time / $unit);
			return $numberOfUnits.' '.$text.(($numberOfUnits>1)?'':'');
		}
	
	}
	function get_gov_rep(  $_id  ){
		$date = date('Y-m-d');
		$tasks = $GLOBALS['db']->query(" SELECT * FROM `tasks` WHERE `type`='visit2' AND `rep_id` = '".$_id."' AND `notifications_done` = '0'  LIMIT 1");
		$taskstCount = $GLOBALS['db']->resultcount();
		if($taskstCount > 0){
			$_task = $GLOBALS['db']->fetchitem($tasks);
			$client_id = $_task['client_id'] ;
			$clients = $GLOBALS['db']->query(" SELECT clients.`governorate` AS gov_id , governorates.`name_ar` AS gov_name FROM `clients` INNER JOIN `governorates` ON clients.`governorate` = governorates.`id` WHERE clients.`id` = '".$client_id."' LIMIT 1");
			$clientsCount = $GLOBALS['db']->resultcount();
			if($clientsCount > 0 ){
				$_client = $GLOBALS['db']->fetchitem($clients);
				return $_client['gov_name'] ;
			}
			
		}
	}

	
	function getcount_hour_work( $_id ,$date=0 ){
		
		if( $date == 0){
			$date = date('Y-m-d');
		}

		$works = $GLOBALS['db']->query(" SELECT `daily_working`.* , TIME(`end_time`) AS `time_only` FROM `daily_working` WHERE `rep_id` = '".$_id."' AND `date` = '".$date."' ORDER BY `id` DESC ");
		$worktCount = $GLOBALS['db']->resultcount();
		if($worktCount > 0){
			
			$_works = $GLOBALS['db']->fetchlist($works);
			$total_hour = 0 ;
			$total_min = 0  ;
			foreach( $_works as $work ){
				if( $work['start_time'] == 0 ||  $work['end_time'] == 0){
					return $GLOBALS['lang']['no_end_work'];
				}else{
				
					$time1 = $work['start_time'] ;
					$time2 = $work['time_only'] ;
					list($hours, $minutes) = explode(':', $time1);
					$firstTimestamp = mktime($hours, $minutes);

					list($hours, $minutes) = explode(':', $time2);
					$secondTimestamp = mktime($hours, $minutes);

					$seconds =  $secondTimestamp - $firstTimestamp;

					$seconds<0?$seconds+=24*60*60:"";

					$minutes = ($seconds / 60) % 60;
					$hours = floor($seconds / (60 * 60));
					$total_hour += $hours ;
					$total_min += $minutes ;

			    }
			}
			return "<p style='font-size: 13px;'><b>$total_hour</b> ".$GLOBALS['lang']['hours']."<b>$total_min</b>".$GLOBALS['lang']['minutes']."</p>";

		}else{
			return "<p style='font-size: 13px;color:#c3c3c3'>0 ".$GLOBALS['lang']['hours']."0".$GLOBALS['lang']['minutes']."</p>";
		}
	}

	function count_checkin_out_in_day( $_id ,$date=0 ){
		
		if( $date == 0){
			$date = date('Y-m-d');
		}

		$works = $GLOBALS['db']->query(" SELECT `daily_working`.* , TIME(`end_time`) AS `time_only` FROM `daily_working` WHERE `rep_id` = '".$_id."' AND `date` = '".$date."' ORDER BY `id` DESC ");
		$worktCount = $GLOBALS['db']->resultcount();
		if( $worktCount == 0 ){
			return "<p style='font-size: 13px;color:#c3c3c3'><b>$worktCount</b> ".$GLOBALS['lang']['ownce']."</p>";
		}else{
			return "<p style='font-size: 13px;'><b>$worktCount</b> ".$GLOBALS['lang']['ownce']."</p>";
		}

	}

	function count_checkin_out_month( $_id ,$date=0 ){
		
		if( $date == 0){
			$date = date('m');
		}

		$works = $GLOBALS['db']->query(" SELECT `daily_working`.* , TIME(`end_time`) AS `time_only` FROM `daily_working` WHERE `rep_id` = '".$_id."' AND MONTH(`date`) = '".$date."' ORDER BY `id` DESC ");
		$worktCount = $GLOBALS['db']->resultcount();
		return "<p style='font-size: 13px;'><b>$worktCount</b> ".$GLOBALS['lang']['ownce']."</p>";

	}

	function count_checkin_out_in_month( $_id ,$date=0 ){
		
		if( $date == 0){
			$date = date('Y-m-d');
		}

		$works = $GLOBALS['db']->query(" SELECT `daily_working`.* , TIME(`end_time`) AS `time_only` FROM `daily_working` WHERE `rep_id` = '".$_id."' AND MONTH(`date`) = '".$date."' ORDER BY `id` DESC ");
		$worktCount = $GLOBALS['db']->resultcount();
		if($worktCount > 0){
			
			$_works = $GLOBALS['db']->fetchlist($works);
			$total_hour = 0 ;
			$total_min = 0  ;
			foreach( $_works as $work ){
				if( $work['start_time'] != 0 &&  $work['end_time'] != '0000-00-00 00:00:00'){
					
				
					$time1 = $work['start_time'] ;
					$time2 = $work['time_only'] ;
					list($hours, $minutes) = explode(':', $time1);
					$firstTimestamp = mktime($hours, $minutes);

					list($hours, $minutes) = explode(':', $time2);
					$secondTimestamp = mktime($hours, $minutes);

					$seconds =  $secondTimestamp - $firstTimestamp;

					$seconds<0?$seconds+=24*60*60:"";

					$minutes = ($seconds / 60) % 60;
					$hours = floor($seconds / (60 * 60));

					$query_work_hour = $GLOBALS['db']->query("SELECT `work_hour` FROM `work_days` limit 1 ");
					$work_hour_Count = $GLOBALS['db']->resultcount();
					if( $worktCount > 0 ){
						$_work_hour = $GLOBALS['db']->fetchitem($query_work_hour);
						$_hour 		=  $_work_hour['work_hour'];
					}

					if( $hours >= $_hour){
						$total_h += $_hour ;
					}else{
						$total_h += $hours ;
						$total_min += $minutes ;
					}
					
					

			    }
			}
			return "<p style='font-size: 13px;'><b>$total_h</b> ".$GLOBALS['lang']['hours']."<b>$total_min</b>".$GLOBALS['lang']['minutes']."</p>";

		}else{
			return "<p style='font-size: 13px;'><b>0</b> ".$GLOBALS['lang']['hours']."<b>0</b>".$GLOBALS['lang']['minutes']."</p>";
		}

	}

	function def_hour($_id ,$date=0){
		if( $date == 0){
			$date = date('Y-m-d');
		}

		$works = $GLOBALS['db']->query(" SELECT `daily_working`.* , TIME(`end_time`) AS `time_only` FROM `daily_working` WHERE `rep_id` = '".$_id."' AND `date` = '".$date."' ORDER BY `id` DESC ");
		$worktCount = $GLOBALS['db']->resultcount();
		if($worktCount > 0){
			
			$_works = $GLOBALS['db']->fetchlist($works);
			$total_hour = 0 ;
			$total_min = 0  ;
			foreach( $_works as $work ){
				if( $work['start_time'] == 0 ||  $work['end_time'] == 0){
					return $GLOBALS['lang']['no_end_work'];
				}else{
				
					$time1 = $work['start_time'] ;
					$time2 = $work['time_only'] ;
					list($hours, $minutes) = explode(':', $time1);
					$firstTimestamp = mktime($hours, $minutes);

					list($hours, $minutes) = explode(':', $time2);
					$secondTimestamp = mktime($hours, $minutes);

					$seconds =  $secondTimestamp - $firstTimestamp;

					$seconds<0?$seconds+=24*60*60:"";

					$minutes = ($seconds / 60) % 60;
					$hours = floor($seconds / (60 * 60));
					$total_hour += $hours ;
					$total_min += $minutes ;

			    }
			}

			$query_work_hour = $GLOBALS['db']->query("SELECT `work_hour` FROM `work_days` limit 1 ");
			$work_hour_Count = $GLOBALS['db']->resultcount();
			if( $worktCount > 0 ){
				$_work_hour = $GLOBALS['db']->fetchitem($query_work_hour);
				$_hour 		=  $_work_hour['work_hour'];
			}
			
			if( $total_hour >= $_hour ){
				return "<p style='font-size: 13px;'><b>0</b> ".$GLOBALS['lang']['hours']."<b>0</b>".$GLOBALS['lang']['minutes']."</p>";
			}else{
				$def_h = $_hour - $total_hour ;
				return "<p style='font-size: 13px;'><b>$def_h</b> ".$GLOBALS['lang']['hours']."<b>$total_min</b>".$GLOBALS['lang']['minutes']."</p>";
			}

		}else{
			return "<p style='font-size: 13px;'><b>8</b> ".$GLOBALS['lang']['hours']."<b>0</b>".$GLOBALS['lang']['minutes']."</p>";
		}
	}

	function def_hour_in_month($_id ,$date=0){
		if( $date == 0){
			$date = date('m');
		}
		

		$works = $GLOBALS['db']->query(" SELECT `daily_working`.* , TIME(`end_time`) AS `time_only` FROM `daily_working` WHERE `rep_id` = '".$_id."' AND MONTH(`date`) = '".$date."' ORDER BY `id` DESC ");
		$worktCount = $GLOBALS['db']->resultcount();
		if($worktCount > 0){
			
			$_works = $GLOBALS['db']->fetchlist($works);
			$total_hour = 0 ;
			$total_min = 0  ;
			foreach( $_works as $work ){
				if( $work['start_time'] != 0 &&  $work['end_time'] != '0000-00-00 00:00:00'){
				
					$time1 = $work['start_time'] ;
					$time2 = $work['time_only'] ;
					list($hours, $minutes) = explode(':', $time1);
					$firstTimestamp = mktime($hours, $minutes);

					list($hours, $minutes) = explode(':', $time2);
					$secondTimestamp = mktime($hours, $minutes);

					$seconds =  $secondTimestamp - $firstTimestamp;

					$seconds<0?$seconds+=24*60*60:"";

					$minutes = ($seconds / 60) % 60;
					$hours = floor($seconds / (60 * 60));

					$query_work_hour = $GLOBALS['db']->query("SELECT `work_hour` FROM `work_days` limit 1 ");
					$work_hour_Count = $GLOBALS['db']->resultcount();
					if( $worktCount > 0 ){
						$_work_hour = $GLOBALS['db']->fetchitem($query_work_hour);
						$_hour 		=  $_work_hour['work_hour'];
					}

					if( $hours >= $_hour){
						$t_h +=  $_hour ;
						// $def_all_hour = ($_hour*31) - $t_h ;
					}else{
						$t_h +=  $hours ;
						// $def_all_hour = ($_hour*31) - $t_h ;
						$t_m += $minutes ;
					}
				}
			}
			$def_all_hour = ($_hour*31) - $t_h ;
	
			return "<p style='font-size: 13px;'><b>$def_all_hour</b> ".$GLOBALS['lang']['hours']."<b>$t_m</b>".$GLOBALS['lang']['minutes']."</p>";


		}else{
			return "<p style='font-size: 13px;'><b>0</b> ".$GLOBALS['lang']['hours']."<b>0</b>".$GLOBALS['lang']['minutes']."</p>";
		}
	}


	function get_time_work($_id){
		
		$works = $GLOBALS['db']->query(" SELECT `date` ,`start_time` FROM `daily_working` WHERE `rep_id` = '".$_id."' AND `end_time` = '0000-00-00 00:00:00' ORDER BY `id` DESC LIMIT 1 ");
		$worktCount = $GLOBALS['db']->resultcount();
		if( $worktCount > 0 ){
			$data = $GLOBALS['db']->fetchitem($works);
			$d = $data['date'] ;
			$t = $data['start_time'] ;
			$t_format = date(" g:i A",strtotime($t) ) ;
			$all_time = $d." ".$t_format ;
			return ( $all_time  );
		}
	}

	function get_date_postpone($_id){
		
		$works = $GLOBALS['db']->query(" SELECT `date` FROM `tasks` WHERE `id` = '".$_id."'  ");
		$worktCount = $GLOBALS['db']->resultcount();
		if( $worktCount > 0 ){
			$data = $GLOBALS['db']->fetchitem($works);
			$dd = $data['date'] ;
			$d = date("Y/m/d  ", strtotime( $dd )) ;
			return ( $d  );
		}else
		{
			return ($GLOBALS['lang']['not_define']);
		}
	}

	function getrep_id($_Id)
	{

		$product = $GLOBALS['db']->query(" SELECT * FROM `clients` WHERE `id` = '".$_Id."' LIMIT 1");
		$productCount = $GLOBALS['db']->resultcount();
		if($productCount == 1)
		{
			$_product = $GLOBALS['db']->fetchitem($product);
			return ($_product['rep_id']);
		}else
		{
			return ($GLOBALS['lang']['not_define']);
		}
	}

	function getsupervisorname($_Id)
	{

		$product = $GLOBALS['db']->query(" SELECT * FROM `supervisors` WHERE `id` = '".$_Id."' LIMIT 1");
		$productCount = $GLOBALS['db']->resultcount();
		if($productCount == 1)
		{
			$_product = $GLOBALS['db']->fetchitem($product);
			return ($_product['name']);
		}else
		{
			return ($GLOBALS['lang']['not_define']);
		}
	}
	function getrepname($_Id)
	{

		$product = $GLOBALS['db']->query(" SELECT * FROM `reps` WHERE `id` = '".$_Id."' LIMIT 1");
		$productCount = $GLOBALS['db']->resultcount();
		if($productCount == 1)
		{
			$_product = $GLOBALS['db']->fetchitem($product);
			return ($_product['name']);
		}else
		{
			return ($GLOBALS['lang']['not_define']);
		}
	}


	function return_status_name($id){
		$return_status = $GLOBALS['db']->query(" SELECT * FROM `return_status` WHERE `id` = $id ");
		$returnCount = $GLOBALS['db']->resultcount();
		if($returnCount == 1){
			$_return = $GLOBALS['db']->fetchitem($return_status);
			return ($_return['name']);
		}else{
			return ($GLOBALS['lang']['not_define']);
		}

	}

	function count_work($t1 ,$t2 ){
		
		$time1 = $t1 ;
		$time2 = $t2 ;
		list($hours, $minutes) = explode(':', $time1);
		$firstTimestamp = mktime($hours, $minutes);

		list($hours, $minutes) = explode(':', $time2);
		$secondTimestamp = mktime($hours, $minutes);

		$seconds =  $secondTimestamp - $firstTimestamp;

		$seconds<0?$seconds+=24*60*60:"";

		$minutes = ($seconds / 60) % 60;
		$hours = floor($seconds / (60 * 60));

		return "<b>$hours</b> ".$GLOBALS['lang']['hours']."<b>$minutes</b>".$GLOBALS['lang']['minutes']."</b>";


	}
	function location_time($t1 ){
		$_date = new DateTime();
		$time1 = $t1 ;
		$time2 = $_date->format("h:i:s")  ;
		list($hours, $minutes) = explode(':', $time1);
		$firstTimestamp = mktime($hours, $minutes);

		list($hours, $minutes) = explode(':', $time2);
		$secondTimestamp = mktime($hours, $minutes);

		$seconds =  $secondTimestamp - $firstTimestamp;

		$seconds<0?$seconds+=24*60*60:"";

		$minutes = ($seconds / 60) % 60;
		$hours = floor($seconds / (60 * 60));

		return "<b>$hours</b> ".$GLOBALS['lang']['hours']."<b>$minutes</b>".$GLOBALS['lang']['minutes']."</b>";


	}


	function getproduectname($_Id)
	{

		$product = $GLOBALS['db']->query(" SELECT * FROM `products` WHERE `id` = '".$_Id."' LIMIT 1");
		$productCount = $GLOBALS['db']->resultcount();
		if($productCount == 1)
		{
			$_product = $GLOBALS['db']->fetchitem($product);
			return ($_product['name_ar']);
		}else
		{
			return ($GLOBALS['lang']['not_define']);
		}
	}


	function getclientname($_Id)
	{

		$product = $GLOBALS['db']->query(" SELECT * FROM `clients` WHERE `id` = '".$_Id."' LIMIT 1");
		$productCount = $GLOBALS['db']->resultcount();
		if($productCount == 1)
		{
			$_product = $GLOBALS['db']->fetchitem($product);
			return ($_product['name']);
		}else
		{
			return ($GLOBALS['lang']['not_define']);
		}
	}



	   function getcities($params, &$smarty)
		{
			$country   		    = $params['a'];
		    $city   		    = $params['b'];
			$query = $GLOBALS['db']->query(" SELECT * FROM `cities` WHERE `governorate` = '".$country."' AND `status` = 1 ");
			$cityCount = $GLOBALS['db']->resultcount();
			if($cityCount > 0)
			{
				$cities = $GLOBALS['db']->fetchlist();
				foreach($cities as $c)
				{
					if($c['id'] == $city )
					{
						echo '<option value="'.$c['id'].'" selected="selected">'.$c['name_en']." - ".$c['name_ar'].'</option>';
					}
					else
					{
						echo '<option value="'.$c['id'].'">'.$c['name_en']." - ".$c['name_ar'].'</option>';
					}

				}
			}else
			{
				return ($GLOBALS['lang']['not_define']);
			}
		}


		function getimages($_images)
		{

			if($_images)
			{
				$images = explode(",",$_images);
				foreach($images as $i =>$image)
				{
					return ($image);
				}
			}
			else
			{
				return ($GLOBALS['lang']['not_define']);
			}
		}

		


    function getFromInternalTable($a, $b, $c, $d)
	{
		$attId   		= $a;
		$tableName   	= $b;
		$functionName   = $c;
		$attName   		= $d;

		require_once('./inc/Classes/system-'.$tableName.'.php');

		eval("\$class = new system".ucfirst($tableName)."();");

		$returnedData = $class->$functionName($attId);

		if($returnedData[$attName] != "")
        return ($returnedData[$attName]);
        return "";
	}
    
    function replacestring($num){
	     $num =	  str_replace("] , [","]<br>[",$num);
		  return "$num";
	  }


	function buildaddress($params, &$smarty)
	{
		
		$attmob   		= $params['a'];
		$attId   		= $params['e'];
		$tableName   	= $params['b'];
		$functionName   = $params['c'];
		$attName   		= $params['d'];
		
		require_once('./inc/Classes/system-'.$tableName.'.php');

		eval("\$class = new system".ucfirst($tableName)."();");

		$returnedData = $class->$functionName($attId , $attmob );
		return ($returnedData[$attName]);
	}

	function getposition($params, &$smarty)
	{

		$Id   		    = $params['a'];
		$table   		= $params['b'];


		$query = $GLOBALS['db']->query("SELECT x.id , x.position FROM (SELECT t.id,@rownum := @rownum + 1 AS position FROM `".$table."` t
		JOIN (SELECT @rownum := 0)r) x WHERE x.id = '".$Id."'");
		 $productCount = $GLOBALS['db']->resultcount();
		if($productCount == 1)
		{
			$_product = $GLOBALS['db']->fetchitem($product);
			$position = $_product['position'] - 1;
			return ($position);
		}

	}

function getpersentcash($ototal,$tcash){
        if($GLOBALS['login']->doCheck() == true)
		{
            $result=($ototal/$tcash)*100;
            return  round($result, 2);
        }
		else{$GLOBALS['login']->doDestroy();return false;}
        
    }
function getpersentreturn($rtotal,$treturn){
        if($GLOBALS['login']->doCheck() == true)
		{
            $result=($rtotal/$treturn)*100;
            return  round($result, 2);
        }
		else{$GLOBALS['login']->doDestroy();return false;}
        
    }

	function getreplocatianinday($mId)
	{
		
	}


	

?>
