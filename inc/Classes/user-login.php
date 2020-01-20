<?php if(!defined("inside")) exit;

class userLogin
{
 var $name;
 var $email;
 var $password;
 var $remember;
 var $id;
 var $prefix 		= "Shawwa_";
 var $tableName 	= "staffs";
 var $salt 			= "12*4";
 var $hours 		= 10;

 function doLogin($email,$pass,$remember)
 {
 	if($email !=""  || $pass != "")
 	{
 		if($this->isLogged() == false){
	 		global $db;
			
		 	$query = $db->query("SELECT * FROM `".$this->tableName."` WHERE `email`='".$email."' AND `password`='".md5(($this->salt.$pass.$this->salt))."'");
	 		$queryTotal = $db->resultcount();
		    if($queryTotal == 1)
		    {
				$userData = $db->fetchitem($query);
				if($remember == 1){$this->hours = 4;}
				$this->setName($userData['name']);
				$this->setEmail($userData['email']);
	 			$this->setPassword($userData['password']);
	 			$this->setUserId($userData['id']);
	 			$db->query("UPDATE LOW_PRIORITY `".$this->tableName."` SET `log_time`='".time()."' WHERE `id`='".($userData['id'])."'");
				return 1;
		    }else{return 2;}
	 	}else{return 3;}
 	}else{return 0;}
 }

 function doLogout()
 {
 	if($this->isLogged() == true)
 	{
 		// query and get data from db
 		$this->doDestroy();
 		return  true;
 	}else{return false;}
 }

 function doDestroy()
 {
 	// query and get data from db
 	$this->doDestroyName();
 	$this->doDestroyEmail();
 	$this->doDestroyPassword();
 	$this->doDestroyUserId();
 }


 function doCheck()
 {
 	if($this->isLogged() == true)
 	{
 		global $db;
	 	$email = $this->getEmail();
	 	$pass = $this->getPassword();
	 	$id = $this->getUserId();
	 	$query = $db->query("SELECT * FROM `".$this->tableName."` WHERE `email`='$email' AND `password`='$pass' AND `id`='$id' ");
 		$queryTotal = $db->resultcount();
	    if($queryTotal == 1)
	    {
			return true;
	    }else{$this->doDestroy();return false;}
 	}else{$this->doDestroy();return false;}
 }

 function getUserInformation()
 {
 	if($this->isLogged() == true)
 	{
 		global $db;
	 	$email = $this->getEmail();
	 	$pass = $this->getPassword();
	 	$id = $this->getUserId();
	 	$query = $db->query("SELECT * FROM `".$this->tableName."` WHERE `email`='$email' AND `password`='$pass' AND `id`='$id' LIMIT 1 ");
 		$queryTotal = $db->resultcount();
	    if($queryTotal == 1)
	    {
	    	$userInformation = $db->fetchitem($query);
			return array(
				"name"=> 		$userInformation['name'],
				"email"=> 		$userInformation['email'],
				"password"=> 	$userInformation['password'],
				"mobile"=> 		$userInformation['mobile'],
				"notes"=> 		br2nl($userInformation['notes'])
			);
	    }else{$this->doDestroy();return false;}
 	}else{$this->doDestroy();return false;}
 }


 function setUserInformation($userInformation)
 {
 	//if($this->isLogged() == true)
 	if(1==1)
 	{
 		global $db;
        $userInformation[id] = $this->getUserId();
	 	if($userInformation[password] != "")
	 	{
	 		$queryGlue = "`password`='".md5(($salt.$userInformation[password].$salt))."',";
	 		$this->setPassword($userData['password']);
	 	}else
	 	{
	 		$queryGlue = "";
	 	}
	 	$this->setName($userInformation['name']);
		$this->setEmail($userInformation['email']);



	 	$db->query("UPDATE LOW_PRIORITY `".$this->tableName."` SET
	 	`name`='".$userInformation[name]."',
	 	`email`='".$userInformation[email]."',".$queryGlue."
	 	`log_time`='".time()."',
	 	`mobile`='".$userInformation[mobile]."',
	 	`notes`='".$userInformation[notes]."'
	 	WHERE `id`='".($userInformation['id'])."' LIMIT 1 ");

	 	return 1;
 	}else{$this->doDestroy();return false;}
 }


 function doCheckPermission($section)
 {
 	if($this->isLogged() == true)
 	{
		global $db;
		$id = $this->getUserId();
	 	$query 		= $db->query("SELECT `group` FROM `".$this->tableName."` WHERE `id`='".$id."' ");
		$queryTotal = $db->resultcount();
		if($queryTotal == 1)
		{
			$userGroup = $db->fetchitem($query);
			if($userGroup['group'] == -1)
			{
				return true;	
			}else
			{
				$query 		= $db->query("SELECT'".$section."'FROM `groups` WHERE `id`=$userGroup[group] AND `".$section."`=1 "); 
				 $queryTotal = $GLOBALS['db']->resultcount();
					if($queryTotal > 0)
					{
						
						return true;
					}
			}
		}else
		{
			return false;
		}
	    
		
	    //return true;
 	}else{return false;}
 }
	
	
function docheckcredit($id)
{
	if($this->isLogged() == true)
 	{
		global $db;
		$query 		= $db->query("SELECT sum(remain) AS remain FROM `orders` WHERE `delivered` = 1 && `client_id`='".$id."' ");
		$queryTotal = $db->resultcount();
		if($queryTotal > 1)
		{
			$clientremain = $db->fetchitem($query);
			$query 		= $db->query("SELECT sum(total_price) AS returns FROM `returns_products` WHERE `return_status_id` = 1 && `rep_confirm` = 1 && `status` = 1 &&  `client_id`='".$id."' ");
			$clientreturn = $db->fetchitem($query);
			$credit    = ($clientremain['remain'] - $clientreturn['returns']);
			$GLOBALS['db']->query("UPDATE LOW_PRIORITY `clients` SET
			`credit`             ='".$credit."'
			WHERE `id` 			 = '".$id."' LIMIT 1 ");
		}
	}
			
}

 function isLogged()
 {
    $email = $this->getEmail();
 	if(isset($email) && $email !=""){return true;}else{return false;}
 }

 function getName()
 {
 	$this->name = $_COOKIE[$this->prefix."name"];

    if($this->name !=""){return ($this->name);}else{return false;}
 }

 function setName($name)
 {
	if($name != "")
	{
	    if(@setcookie($this->prefix."name",$name,time()+($this->hours*3600))){return ($this->hours);}else{return false;}
 	}else{return false;}
 }

 function doDestroyName()
 {
 	if(@setcookie($this->prefix."name",$name,time()-($this->hours*3600))){return true;}else{return false;}
 }


 function getEmail()
 {
 	$this->email = $_COOKIE[$this->prefix."email"];
    if($this->email !=""){return ($this->email);}else{return false;}
 }

 function setEmail($name)
 {
	if($name != "")
	{
	    if(@setcookie($this->prefix."email",$name,time()+($this->hours*3600))){return ($this->hours);}else{return false;}
 	}else{return false;}
 }

 function doDestroyEmail()
 {
 	if(@setcookie($this->prefix."email",$name,time()-($this->hours*3600))){return true;}else{return false;}
 }

 function getPassword()
 {
 	$this->password = $_COOKIE[$this->prefix."password"];
    if($this->password !=""){return ($this->password);}else{return false;}
 }

 function setPassword($pass)
 {
	if($pass != "")
	{
	    if(@setcookie($this->prefix."password",$pass,time()+($this->hours*3600))){return true;}else{return false;}
 	}else{return false;}
 }
 function doDestroyPassword()
 {
 	if(@setcookie($this->prefix."password",$pass,time()-($this->hours*3600))){return true;}else{return false;}
 }

 function getUserId()
 {
    $this->id = $_COOKIE[$this->prefix."id"];
    if($this->id !=""){return ($this->id);}else{return false;}
 }

 function setUserId($id)
 {
	if($id != "" && is_numeric($id))
	{
	    if(@setcookie($this->prefix."id",$id,time()+($this->hours*3600))){return true;}else{return false;}
 	}else{return false;}
 }

 function doDestroyUserId()
 {
 	if(@setcookie($this->prefix."id",$id,time()-($this->hours*3600))){return true;}else{return false;}
 }

 function generateKey($length = 15)
	{
		$token 		= "";
		$key 		= "0123456789";
		$max 		= strlen($key);

		for ($i=0; $i < $length; $i++) {
			$token .= $key[$this->crypto_rand_secure(0, $max-1)];
		}
		return ($token);
	}

}



?>
