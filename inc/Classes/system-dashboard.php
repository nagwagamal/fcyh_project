<?php if(!defined("inside")) exit;

/*/////////////////////////////////////
* Filename: admin-invoices.php
* Purpose: site settings actions ( update ).
* Author: ibnkamal@msn.com
* Date: 04/04/2015
/////////////////////////////////////*/

class systemDashboard
{

	function getMESSAGEINDAY( )
	{
		if($GLOBALS['login']->doCheck() == true)
		{
			$date 				= 	date("Y-m-d 00:00:00");
			$date2 				= 	date("Y-m-d 23:59:59");
			$query 				=   $GLOBALS['db']->query("SELECT *  FROM `messages`  WHERE  `from` = 'client' && `status` = 0 && ((`time` <= '".$date2."' ) &&(`time` >= '".$date."' )) ORDER BY `id` DESC LIMIT 5 ");
			$queryTotal         =   $GLOBALS['db']->resultcount();
			if($queryTotal > 0)
			{
				$message 	= $GLOBALS['db']->fetchlist();
			}
			return ($message);
		}else{$GLOBALS['login']->doDestroy();return false;}
	}

	function getLATERINDAY( )
	{
		if($GLOBALS['login']->doCheck() == true)
		{
			$date 				= 	date("Y-m-d");
			$query 				=   $GLOBALS['db']->query("SELECT *  FROM `tasks`  WHERE (`update` !='not' && `activate_function` = 1 && `date` = '".$date."' && `status` = 1 && `rep_confirm`=1) ORDER BY `id` DESC");
			$queryTotal         =   $GLOBALS['db']->resultcount();
			if($queryTotal > 0)
			{
				$visits 	= $GLOBALS['db']->fetchlist();
			}
			return ($visits);
		}else{$GLOBALS['login']->doDestroy();return false;}
	}

	function getinvestINDAY( )
	{
		if($GLOBALS['login']->doCheck() == true)
		{
			$date 				= 	date("Y-m-d");
			$query 				=   $GLOBALS['db']->query("SELECT *  FROM `tasks`  WHERE (`type` ='visit' && `update` ='not' && `date` = '".$date."' && `status` = 1 && `rep_confirm`=1) ORDER BY `id` DESC");
			$queryTotal         =   $GLOBALS['db']->resultcount();
			if($queryTotal > 0)
			{
				$visits 	= $GLOBALS['db']->fetchlist();
			}
			return ($visits);
		}else{$GLOBALS['login']->doDestroy();return false;}
	}

	function getinstallmentINDAY( )
	{
			if($GLOBALS['login']->doCheck() == true)
			{
				$date 				= 	date("Y-m-d");
				$query 				=   $GLOBALS['db']->query("SELECT i.*  FROM `installments` i INNER JOIN `tasks` a ON i.`id` = a.`type_id` WHERE ( a.`update` ='not'&& a.`rep_confirm`=1 && a.`type` ='installment' && a.`date` = '".$date."' && a.`status` = 1 ) && (i.`rep_confirm`=1) ORDER BY i.`id` DESC");
				$queryTotal         =   $GLOBALS['db']->resultcount();
				if($queryTotal > 0)
				{
					$install 	= $GLOBALS['db']->fetchlist();
					foreach($install as $cId =>$i )
					{
						$total += $i['money_paid'];
					}
				}
				return ($install);
			}else{$GLOBALS['login']->doDestroy();return false;}
		}

	function getorderINDAY( )
	{
			if($GLOBALS['login']->doCheck() == true)
			{
				$date 				= 	date("Y-m-d");
				$query 				=   $GLOBALS['db']->query("SELECT o.*  FROM `orders` o INNER JOIN `tasks` a ON o.`id` = a.`type_id` WHERE (a.`update` ='not' && a.`rep_confirm`=1 && a.`type` ='order' && a.`date` = '".$date."' && a.`status` = 1) && (o.`delivered`=1) ORDER BY o.`id` DESC");
				$queryTotal         =   $GLOBALS['db']->resultcount();
				if($queryTotal > 0)
				{
					$orders 	= $GLOBALS['db']->fetchlist();
					foreach($orders as $cId =>$o )
					{
						$total += $o['paid'];
					}
				}
				return ($orders);
			}else{$GLOBALS['login']->doDestroy();return false;}
		}

	function getreturnINDAY( )
	{
		if($GLOBALS['login']->doCheck() == true)
		{
			$date 				= 	date("Y-m-d");
			$query 				=   $GLOBALS['db']->query("SELECT o.*  FROM `returns_products` o INNER JOIN `tasks` a ON o.`id` = a.`type_id` WHERE (a.`update` ='not' && a.`rep_confirm`=1 && a.`type` ='return' && a.`date` = '".$date."' && a.`status` = 1) && (o.`status`=1) ORDER BY o.`id` DESC");
			$queryTotal         =   $GLOBALS['db']->resultcount();
			if($queryTotal > 0)
			{
				$orders 	= $GLOBALS['db']->fetchlist();

			}
			return ($orders);
		}else{$GLOBALS['login']->doDestroy();return false;}
	}

	function getTopClient( )
	{
		if($GLOBALS['login']->doCheck() == true)
		{
			$query 				= $GLOBALS['db']->query("SELECT c.`id` AS client_id , count(o.id) AS orders , sum(o.total) AS total , sum(o.paid) AS paid , sum(o.remain) AS remain , ((sum(o.paid)/sum(o.total))*100) AS percentage FROM  `clients` c INNER JOIN `orders` o ON c.`id` = o.`client_id` WHERE o.`delivered` = 1  GROUP BY `client_id` ORDER BY paid DESC LIMIT 5");
			$queryTotal         = $GLOBALS['db']->resultcount();
			if($queryTotal > 0)
			{
				$client 	= $GLOBALS['db']->fetchlist();
				foreach($client as $cId =>$order )
				{
					$query 		                = $GLOBALS['db']->query("SELECT sum(total_price) AS returns FROM `returns_products` WHERE `return_status_id` = 1 && `rep_confirm` = 1 && `status` = 1 &&  `client_id`='".$order['client_id']."' ");
					$returns 	                = $GLOBALS['db']->fetchitem($query);
					$client[$cId]['returns']	= $returns['returns'];
					$client[$cId]['cridets']	= ($client[$cId]['remain'] - $returns['returns']);
				}
				return ($client);
			}
		}else{$GLOBALS['login']->doDestroy();return false;}
	}


	function getInstallmentsINDAY( )
	{
		if($GLOBALS['login']->doCheck() == true)
		{
			$date 				= 	date("Y-m-d");
			$date2 				= 	date("Y-m-d 23:59:59");
			$query 				= $GLOBALS['db']->query("SELECT * FROM `installments` WHERE  (`installement` != `money_paid`) && (`money_paid` > 0) && ((`date` >= '".$date1."') && (`date` <= '".$date2."')) ORDER BY `id` DESC LIMIT 5");
			$orderuncomplete 	= $GLOBALS['db']->fetchlist();
			return ($orderuncomplete);
		}else{$GLOBALS['login']->doDestroy();return false;}
	}

	function getInstallmentsnotcompletepayed($from,$to)
	{
		if($GLOBALS['login']->doCheck() == true)
		{
			$query 				= $GLOBALS['db']->query("SELECT * FROM `installments` WHERE  (`installement` != `money_paid`) && (`money_paid` > 0) && ((`date` <= '".$to."' ) &&(`date` >= '".$from."' )) ORDER BY `id` DESC");
			$orderuncomplete 	= $GLOBALS['db']->fetchlist();
			return ($orderuncomplete);
		}else{$GLOBALS['login']->doDestroy();return false;}
	}

	function bestclient($addon = "",$from,$to,$rep=0)
	{
		if($GLOBALS['login']->doCheck() == true)
		{
			if($rep !=0)
			{
				$rep_id = " AND `rep_id` = '".$rep."'";
			}
//			echo"SELECT `id` , `name` FROM `clients` WHERE `status` = 1".$rep_id.$addon;
			$_clientquery         = $GLOBALS['db']->query("SELECT `id` , `name` FROM `clients` WHERE `status` = 1".$rep_id.$addon);
			$_clientTotal         = $GLOBALS['db']->resultcount();
			if($_clientTotal > 0)
			{
				$_clients 	  = $GLOBALS['db']->fetchlist();
				foreach($_clients as $cId => $client)
				{
					$orderquery 		= $GLOBALS['db']->query("SELECT count(o.id) AS orders , sum(o.total) AS total , sum(o.paid) AS paid , sum(o.remain) AS remain  FROM `orders` o  WHERE o.`client_id` ='".$client['id']."' AND ((o.`date` <= '".$to."' ) &&(o.`date` >= '".$from."' )) AND o.`delivered` = '1' GROUP BY `client_id` ");
					$order 	            = $GLOBALS['db']->fetchitem($orderquery);
					$_clients[$cId]['orders']     =     $order['orders'];
					$_clients[$cId]['total']      =     $order['total'];
					$_clients[$cId]['paid']       =     $order['paid'];

					$installmentquery   = $GLOBALS['db']->query("SELECT count(i.id) AS installments , sum(i.money_paid) AS paid  FROM `installments` i  WHERE i.`client_id` ='".$client['id']."' AND ((i.`date` <= '".$to."' ) &&(i.`date` >= '".$from."' )) AND i.`rep_confirm` = '1' GROUP BY `client_id` ");
					$install            = $GLOBALS['db']->fetchitem($installmentquery);

					$_clients[$cId]['installments']             =     $install['installments'];
					$_clients[$cId]['install_paid']             =     $install['paid'];

					$query 		                = $GLOBALS['db']->query("SELECT sum(total_price) AS returns FROM `returns_products` WHERE ((`date` <= '".$to."' ) &&(`date` >= '".$from."' )) && `return_status_id` = 1 && `rep_confirm` = 1 && `status` = 1 &&  `client_id`='".$client['id']."' ");
					$returns 	                = $GLOBALS['db']->fetchitem($query);

					$_clients[$cId]['returns']	    = $returns['returns'];


					$query 		                    = $GLOBALS['db']->query("SELECT count(id) AS appointment FROM `tasks` WHERE ((`date` <= '".$to."' ) &&(`date` >= '".$from."' )) && `rep_confirm` = 1 && `type` = 'visit'  && `status` = 1 &&  `client_id`='".$client['id']."' ");
					$appointment              	    = $GLOBALS['db']->fetchitem($query);
					$_clients[$cId]['visit']       	= $appointment['appointment'];

					$_clients[$cId]['remain']	    = ($order['remain'] - $returns['returns']);
					$_clients[$cId]['cridet']	    = ($order['total']  - $returns['returns']);
					$_clients[$cId]['percentage']	= (($order['paid'] / $_clients[$cId]['cridet'])*100);
				}
				return ($_clients);
			}
		}else{$GLOBALS['login']->doDestroy();return false;}

	}
	function getTotalclient()
	{
		if($GLOBALS['login']->doCheck() == true)
		{
			$query 				= $GLOBALS['db']->query("SELECT COUNT(*) AS `total` FROM `clients` ");
			$queryTotal 		= $GLOBALS['db']->fetchrow();
			$total 				= $queryTotal['total'];
			return ($total);
		}else{$GLOBALS['login']->doDestroy();return false;}
	}

	function getBestClient($from,$to,$rep=0)
	{
		if($GLOBALS['login']->doCheck() == true)
		{
			if($rep !=0)
			{
				$rep_id = "AND c.`rep_id` = '".$rep."'";
			}

			$query 				= $GLOBALS['db']->query("SELECT c.`id` AS client_id , count(o.id) AS orders , sum(o.total) AS total , sum(o.paid) AS paid , sum(o.remain) AS remain  FROM  `clients` c INNER JOIN `orders` o ON c.`id` = o.`client_id` WHERE ((o.`date` <= '".$to."' ) &&(o.`date` >= '".$from."' )) AND o.`delivered` = 1 ".$rep_id."GROUP BY `client_id` ");
			$queryTotal         = $GLOBALS['db']->resultcount();
			if($queryTotal > 0)
			{
				$client 	= $GLOBALS['db']->fetchlist();
				foreach($client as $cId =>$order )
				{
					$query 		                = $GLOBALS['db']->query("SELECT sum(total_price) AS returns FROM `returns_products` WHERE ((`date` <= '".$to."' ) &&(`date` >= '".$from."' )) && `return_status_id` = 1 && `rep_confirm` = 1 && `status` = 1 &&  `client_id`='".$order['client_id']."' ");
					$returns 	                = $GLOBALS['db']->fetchitem($query);
					$client[$cId]['returns']	= $returns['returns'];
					$client[$cId]['total']	    = $client[$cId]['total'];
					$client[$cId]['remain']	    = ($client[$cId]['remain'] - $returns['returns']);
					$client[$cId]['cridet']	    = ($client[$cId]['total']  - $returns['returns']);
					$client[$cId]['percentage']	= (($order['paid'] / $client[$cId]['cridet'])*100);
				}
				return ($client);
			}
		}else{$GLOBALS['login']->doDestroy();return false;}
	}

	function getBestRep($from,$to)
	{
		if($GLOBALS['login']->doCheck() == true)
		{
			$query 				= $GLOBALS['db']->query("SELECT r.id AS rep_id , money_target  FROM `representatives` r ORDER BY rep_id ASC");
			$queryTotal         = $GLOBALS['db']->resultcount();
			if($queryTotal > 0)
			{
				$rep 	        = $GLOBALS['db']->fetchlist();
				foreach($rep as $cId =>$r )
				{
					$query 		                    = $GLOBALS['db']->query("SELECT count(id) AS orders , sum(paid) AS paid , sum(total) AS total FROM `orders`  WHERE ((`date` <= '".$to."' ) &&(`date` >= '".$from."' )) && `delivered` = 1 && `status` = 1 &&  `rep_id`='".$r['rep_id']."' ");
					$order   	                    = $GLOBALS['db']->fetchitem($query);
					$rep[$cId]['num_orders']	    = $order['orders'];
					$rep[$cId]['total_orders']	    = $order['total'];
					$query 		                    = $GLOBALS['db']->query("SELECT count(id) AS appointment FROM `tasks` WHERE ((`date` <= '".$to."' ) &&(`date` >= '".$from."' )) && `rep_confirm` = 1 && `type` = 'visit'  && `status` = 1 &&  `rep_id`='".$r['rep_id']."' ");
					$appointment              	    = $GLOBALS['db']->fetchitem($query);
					$rep[$cId]['visit']       	    = $appointment['appointment'];
					$query 		                    = $GLOBALS['db']->query("SELECT count(id) AS installment ,  sum(money_paid) AS installment_paid  FROM `installments` WHERE ((`date` <= '".$to."' ) &&(`date` >= '".$from."' ))  && `rep_confirm` = 1 && `status` = 1 &&  `rep_id`='".$r['rep_id']."' ");
					$installment 	                = $GLOBALS['db']->fetchitem($query);
					$rep[$cId]['installment']	    = $installment['installment'];
					$rep[$cId]['installment_paid']	= $installment['installment_paid'];
					$rep[$cId]['credit']	        = ($installment['installment_paid'] );

					$mon 		                    = $GLOBALS['db']->query("SELECT SUM(money) AS sales  FROM `rep_target_money` WHERE ((`date` <= '".$to."' ) &&(`date` >= '".$from."' )) && `rep_id` = '".$r['rep_id']."' ");
					$money              	        = $GLOBALS['db']->fetchitem($mon);
					$rep[$cId]['target_money']      = ((($rep[$cId]['credit'])/($r['money_target'])) *100) ;
				}
				return ($rep);
			}
		}else{$GLOBALS['login']->doDestroy();return false;}
	}

}

?>
