<?php if(!defined("inside")) exit;

class New_API
{
    var $salt = "12*4";

    public function checkuserCredintials(){

        $udid 	= sanitize($_POST['udid']);
		if(!$udid)
		{
            $this->terminate('error','udid is missing',1);
             
		}
		if(sanitize($_POST['empho']) == "" || sanitize($_POST['pass']) == "" )
		{
            $this->terminate( 'error','عفواً يجب إدخال البريد الإلكتروني أو رقم الهاتف وكلمة المرور',1);
           
		}else
		{
			
			if(sanitize($_POST['user']) == "")
			{
                $this->terminate('error','عفواً يجب إدخال نوع المستخدم',1);
                
			}
			if(sanitize($_POST['token_fire']) == "")
			{
                $this->terminate('error','عفوا يجب ادخال المفتاح الخاص بالفايربيز',1);
                
			}
				
				$_empho = sanitize(($_POST['empho']));
                $_pass  = sanitize($_POST['pass']);
                $_pass_salt  = $this->salt.$_pass.$this->salt ;
                $_hash_pass = md5($_pass_salt);
				$udid   = sanitize($_POST['udid']);
				$token_fire   = $_POST['token_fire'] ;
				$system = new SystemLogin();
                
			if(sanitize($_POST['user']) == "rep")
			{


				$userLoginQuery = $GLOBALS['db']->query(" SELECT * FROM `reps` WHERE (`email` = '".$_empho."' OR `mobile` = '".$_empho."')  AND `password` = '".$_hash_pass."' AND `status`='1' LIMIT 1");
				$userCount = $GLOBALS['db']->resultcount();
				if($userCount == 1)
				{
                    $userCredintials 	    = $GLOBALS['db']->fetchitem($userLoginQuery);
					$staticKey 				= $this->updateToken("rep",$userCredintials['id'],$udid);
					$this->updateLoginTime("reps",$userCredintials['id']);
					$GLOBALS['db']->query("INSERT INTO `notifications`
                        (`id`, `user_type`, `not_token`,`user_id` ) VALUES
                        ( NULL ,'rep','".$token_fire."' ,'".$userCredintials['id']."' ) ");
					$_repCredintials 	= $this->buildMembershipCredintials("rep",$userCredintials,$staticKey);
                    $this->terminate('success',"",0,$_repCredintials);
                     
				}else
				{
                    $this->terminate('error','عفواً بيانات الدخول خاطئة',2);
                     
				}
			}elseif(sanitize($_POST['user']) == "client")
				{
                    $userLoginQuery = $GLOBALS['db']->query("SELECT * FROM `clients` WHERE (`email` = '".$_empho."' OR `mobile` = '".$_empho."') AND `password` = '".$_hash_pass."' AND `status`='1' LIMIT 1");
					$userCount      = $GLOBALS['db']->resultcount();
					if($userCount == 1)
					{
                        $clientCredintials 	    = $GLOBALS['db']->fetchitem($userLoginQuery);
                        $staticKey 				= $this->updateToken("client",$clientCredintials['id'],$udid);
                        if( $clientCredintials['mobile_verified'] == 1  ){
                            $this->updateLoginTime("clients",$clientCredintials['id']);
                            $GLOBALS['db']->query("INSERT INTO `notifications`(`id`, `user_type`, `not_token`,`user_id` ) VALUES
                                                ( NULL ,'client','".$token_fire."' ,'".$clientCredintials['id']."' ) ");
                            $_clientCredintials     = $this->buildMembershipCredintials("client",$clientCredintials,$staticKey);
                            $this->terminate('success',"",0,$_clientCredintials);
                        }else{
                            $this->terminate('error',"",0, "sorry,this account no verified ");
                        }
						
                         
                        
					}else
					{
                        $this->terminate('error','عفواً بيانات الدخول خاطئة',2);
                         
					}
			  }
		}

    }

    public function getPhoneKey()
    {
        
        if( $_POST['user'] == 'client' ){
        
                    
        if (  strlen($_POST['mobile']) != '11' || !is_numeric( $_POST['mobile'] ) )
		{
            $this->terminate('error','عفواً رقم الجوال يجب أن يكون '.(11).' رقم ', 7) ;
			
		}else
		{   
            $GLOBALS['db']->query(" SELECT * FROM `clients` WHERE `mobile` = '".$_POST['mobile']."'  ") ;
            $allData = $GLOBALS['db']->fetchlist() ;
            $countData = $GLOBALS['db']->resultcount() ;
            if( $countData != 0 ){
                $mobileKey = rand(1000, 9999) ;
                $GLOBALS['db']->query("UPDATE LOW_PRIORITY `clients` SET
                                        `mobile_key`     ='".$mobileKey."'
                                    WHERE `mobile` = '".$_POST['mobile']."'  LIMIT 1 ");
                                    
                // $this->terminate('success','',0,$mobileKey) ;
                $m = ['key' => $mobileKey] ;
                $this->terminate('success','',0,$m ) ;
            }else{
                $this->terminate('error','عفوا رقم التليفون غير مسجل بقاعده البيانات ', 7 ) ;
            }
            


            
        }

        }elseif( $_POST['user'] == 'rep' )
        {
            if ( strlen($_POST['mobile']) != '11' || !is_numeric( $_POST['mobile'] ) )
            {
                $this->terminate('error','عفواً رقم الجوال يجب أن يكون '.(11).' رقم ', 7) ;
                
            }else
            {   
                $GLOBALS['db']->query(" SELECT * FROM `reps` WHERE `mobile` = '".$_POST['mobile']."'  ") ;
                $allData = $GLOBALS['db']->fetchlist() ;
                $countData = $GLOBALS['db']->resultcount() ;
                if( $countData != 0 ){
                    $mobileKey = rand(1000, 9999) ;
                    $GLOBALS['db']->query("UPDATE LOW_PRIORITY `reps` SET
                                            `mobile_key`     ='".$mobileKey."'
                                        WHERE `mobile` = '".$_POST['mobile']."'  LIMIT 1 ");
                                        
                    // $this->terminate('success','',0,$mobileKey) ;
                    $m = ['key' => $mobileKey] ;
                    $this->terminate('success','',0,$m ) ;
                }else{
                    $this->terminate('error','عفوا رقم التليفون غير مسجل بقاعده البيانات ', 7 ) ;
                }
            }


        }else{
            $this->terminate('error','يجب ادخال نوع المستخدم  ', 7) ;
        }

    }

///////////////////////////////////////////////////////////////////////////////

function checkCode(){

    if( $_POST['user'] ){

        if( $_POST['user'] =='client' ){
            $user = "clients" ;
        }elseif( $_POST['user'] =='rep' ){
            $user = "reps" ;
        }else{
            $this->terminate('error','يجب ادخال نوع المستخدم  ', 7) ;
        }

        $_mobile = $_POST['mobile'] ; 
        if ( strlen( sanitize($_mobile ) ) != 11 || !is_numeric( sanitize($_mobile) ))
        {
            $this->terminate('error','عفواً رقم الجوال يجب أن يكون '.(11).' رقم ', 7) ;
            
        }else
        {       
                $code = $_POST['code'] ;
                $repPhone  = $_POST['mobile'] ;
                $userLoginQuery = $GLOBALS['db']->query(" SELECT * FROM $user WHERE  `mobile` = '".$_mobile."' LIMIT 1");
                $userCount = $GLOBALS['db']->resultcount();
                if( $userCount !=0 ){

                    $GLOBALS['db']->query("SELECT * FROM $user  WHERE `mobile` = '".$repPhone."' AND `mobile_key` = '".$code."' LIMIT 1 ") ;
                    $countData = $GLOBALS['db']->resultcount() ;
                    if($countData !=0 ){
                        $GLOBALS['db']->query("UPDATE LOW_PRIORITY $user SET
                                `mobile_verified`     ='1' , `mobile_key` = ''
                        WHERE `mobile` = '".$repPhone."'  LIMIT 1 ");

                        $msg['msg'] = 'success Ver' ;
                        $this->terminate('success','',1, $msg ) ;

                        
                    }else{
                        $this->terminate('error','',1, "this code is not correct" ) ;
                    }

                }else{
                    $this->terminate('error','',1, "عفوا هذا الرقم غير مسجل بقاعده البيانات" ) ;
                }
                
                                
        }


        
    }
}




///////////////////////////////////////////////////////////////////////////////
public function forgetPassword()
{
    $mobile = $_POST['mobile'] ;
    if (strlen( sanitize($mobile) ) != (11) || !is_numeric( sanitize($mobile) ) ){
        $this->terminate('error' ,'',0, 'يجب ادخال رقم تليفون صحيح ');
    }else{

        $user = $_POST['user'] ;
        if( $user == 'client' ){
            $nameTable = "clients" ;
        }elseif( $user == 'rep' ){
            $nameTable = "reps" ;
        }else{
            $this->terminate('error' ,'',0, 'يجب ادخال نوع المستخدم عميل او مندوب !');
        }

        $userLoginQuery = $GLOBALS['db']->query(" SELECT * FROM $nameTable WHERE  `mobile` = '".$mobile."' LIMIT 1");
		$userCount = $GLOBALS['db']->resultcount();
        if( $userCount != 0 ){

            if( !empty($_POST['pass']) && !empty($_POST['passConfirm']) ){

                if( $_POST['pass'] != $_POST['passConfirm'] ){
        
                    $this->terminate('error' ,'',0, 'Must Password equal PasswordConfirmation');
                    
                }else{
    
                    $pass = $_POST['pass'] ;
                    $_pass = $this->salt.$pass.$this->salt ;
                    $pass = md5($_pass );
                    $GLOBALS['db']->query("UPDATE LOW_PRIORITY $nameTable SET `password`= '".$pass."' WHERE `mobile` = '".$mobile."' LIMIT 1");
                    $userLoginQuery = $GLOBALS['db']->query(" SELECT * FROM $nameTable WHERE  `mobile` = '".$mobile."' LIMIT 1");
                    $userData =   $GLOBALS['db']->fetchitem($userLoginQuery) ;
                    $staticKey = $this->updateToken($user, $userData['id'], $_POST['udid']);
                    $data      = $this->buildMembershipCredintials( $user,$userData ,$staticKey);
                    $this->terminate(  'success' ,'',0,$data );
                    
                }
        
            }else{
                $this->terminate('error' ,'',0, 'Must Enter Password And Password Confirmation' );
                
            }

        }else{
            $this->terminate('error' ,'',0, 'عفوا رقم التليفون غير مسجل بقاعده البيانات ' );
        }

    }


}
///////////////////////////////////////////////////////////////////////////////
///////////////////////////////////////////////////////////////////////////////
    // public function getPhoneKey()
    // {

        
    //     if( !empty( $_POST['mobile'] ) && !empty( $_POST['mobile_key']) ){
    //         $mb = intval($_POST['mobile']) ;
    //         $mk = intval( $_POST['mobile_key']) ;


    //         $query 	= $GLOBALS['db']->query("SELECT * FROM `clients` WHERE `mobile` = '".$mb."' AND `mobile_key` = '".$mk."' ");
    //         $queryTotal = $GLOBALS['db']->resultcount();
    //         if( $queryTotal == 1)
    //         {
    //             $this->terminate('success',$mk) ;
    //         }
    //         else{
    //             $this->terminate('error', 'mobile not found' ,0) ;
                
    //         }


    //     }
    //     else{
    //         $this->terminate('error',' عفوا يجب ادخال جميع الباينات  ',7) ;
            
    //     }
        

    // }
///////////////////////////////////////////////////////////////////////////////////
///////////////////////////////////////////////////////////////////////////////////
public function user_register()
{
    // if(sanitize($_POST['email']) == "")
    // {
    //     $this->terminate('error','عفواً يجب إدخال البريد الإلكتروني',3);          
    // }else
    // {
        if(sanitize($_POST['mobile']) == "")
        {
            $this->terminate('error','عفواً يجب إدخال رقم الهاتف',3);
              
        }else
        {
            if(sanitize($_POST['name']) == "")
            {
                $this->terminate('error','عفواً يجب إدخال الإسم',3);
                  
            }else
            {
                if( $_POST['token_fire'] == "" ){
                    $this->terminate('error','عفواً يجب إدخال المفتاح الخاص بالفايربيز',3);
                }

                if( $this->checkMail($_POST['email']) == "false")
                {
                    $this->terminate('error','عفواً يجب إدخال البريد الإلكتروني بشكل صحيح',3);
                      
                }else
                {
                    if(sanitize($_POST['udid']) == "")
                    {
                        $this->terminate('error','عفواً يجب ادخال udid',3);
                          
                    }else
                    {
						// if(intval($_POST['governorate']) != 0)
						// {
                        //     $this->terminate('error','عفواً يجب إختيار المحافظة',3);
                              
						// }else
						// {
                        //     if(intval($_POST['city']) == 0)
                        //     {
                        //         $this->terminate('error','عفواً يجب إختيار المدينة',3);
                                  
                        //     }else
                        //     {

						// 		$governoratenCityQuery = $GLOBALS['db']->query(" SELECT * FROM `cities` WHERE  `status` = '1' AND `id` = '".intval($_POST['city'])."' AND `governorate` = '".intval($_POST['governorate'])."' LIMIT 1");
						// 		$governoratenCityQueryCount = $GLOBALS['db']->resultcount();
						// 		if($governoratenCityQueryCount != 1)
						// 		{
                        //             $this->terminate('error','عفواً يجب إختيار المدينة والمحافظة بشكل صحيح',12);
                                      
						// 		}else
						// 		{
						// 			$governorateQuery = $GLOBALS['db']->query(" SELECT * FROM `governorates` WHERE  `status` = '1' AND `id` = '".intval($_POST['governorate'])."' LIMIT 1");
						// 			$governorateQueryCount = $GLOBALS['db']->resultcount();
						// 			if($governorateQueryCount != 1)
						// 			{
                                        
                        //                 $this->terminate('error','عفواً يجب إختيار المحافظة بشكل صحيح',12);
                                          
						// 			}else
						// 			{
                        // 				$governorateData = $GLOBALS['db']->fetchitem($governorateQuery);
                                        if( $_POST['governorate'] && $_POST['city'] && $_POST['address']  || $_POST['lon']  && $_POST['lat']  ){
                                            if(sanitize($_POST['pass']) == " " || sanitize($_POST['pass2']) == " " )
										{
                                            $this->terminate('error','عفواً يجب إدخال كلمة المرور وتأكيد كلمة المرور',11);
                                              
										}else
										{
                                            if( sanitize($_POST['pass']) != sanitize($_POST['pass2']) )
                                            {
                                                $this->terminate('error','عفواً كلمتي المرور غير متطابقتان',12);
                                                  
                                            }else
                                            {
                                                if (strlen( sanitize($_POST['mobile']) ) != (11) || !is_numeric( sanitize($_POST['mobile']) ) )
                                                {
                                                    $this->terminate('error','عفواً رقم الجوال يجب أن يكون '.(11).' رقم ',7);
                                                      
                                                }else
                                                {
    
													if(sanitize($_POST['lon']) == " ")
													{
                                                        $this->terminate('error',' عفوا يجب ادخال lon',12);
                                                          
													}else
													{
														if(sanitize($_POST['lat']) == " ")
														{
                                                            $this->terminate('error',' عفوا يجب ادخال lat',12);
                                                              
														}else
														{
                                                            $_mail 			= 		sanitize(strtolower($_POST['email']));
                                                            $_mobile 		= 		sanitize($_POST['mobile']);
                                                            $_name 			= 		sanitize($_POST['name']);
                                                            $_governorate   = 		intval($_POST['governorate']);
                                                            $_city 			= 		intval($_POST['city']);
                                                            $_address 		= 		sanitize($_POST['address']);
                                                            $_kind 			= 		sanitize($_POST['kind']);
                                                            $_pass1 	    = 		sanitize($_POST['pass']);
                                                            $_pass2 		=		sanitize($_POST['pass2']);
                                                            $_pass          =       $this->salt.$_pass1.$this->salt ;
                                                            $_lon 		    =		sanitize($_POST['lon']);
                                                            $_lat 		    =		sanitize($_POST['lat']);
                                                            $udid 		    =		sanitize($_POST['udid']);
                                                            $token_fire     =		sanitize($_POST['token_fire']);
                                                            if( intval($_POST['rep_id']) > 0  ){
                                                                $_rep_id = intval($_POST['rep_id']) ;
                                                            }else{
                                                                $_rep_id = 0 ;
                                                            }

                                                            $GLOBALS['db']->query(" SELECT * FROM `clients` WHERE `email` = '".($_mail)."' OR `mobile` = '".($_mobile)."' ");
                                                            $prevReg = $GLOBALS['db']->resultcount();
                                                            if($prevReg > 0 )
                                                            {
                                                                $this->terminate('error','عفواً البريد الإلكتروني أو رقم الهاتف تم إستخدامهم مسبقاً لحساب آخر',13);                                                                  
                                                            }else
                                                            {
                                                                             
                                                                $system = new SystemLogin();
                                                                $mobileRandomKey 	= $this->generateKey(4);
                                                                $mailRandomKey 		= $this->generateKey(4);
                                                                $GLOBALS['db']->query
                                                                ("
                                                                    INSERT INTO `clients`
                                                                    (`name`, `email`, `email_key`,`email_verified`,`mobile_verified`,  `password`, `mobile`, `mobile_key`,`img`, `governorate`, `lon`, `lat`, `city`,`kind` ,`address`, `reg_time`,`rep_id`, `status` , `by`) VALUES
                                                                    ('".$_name."','".$_mail."' ,'".$mailRandomKey."',0,0, '".md5($_pass )."' ,  '".$_mobile."'  ,  '".$mobileRandomKey."'  ,'".$img."', '".$_governorate."', '".$_lon."','".$_lat."','".$_city."','".$_kind."','".$_address."','".date("Y-m-d H:i:s")."'  ,'".$_rep_id."', 1 , 0)
                                                                ");
                                                                $pid = $GLOBALS['db']->fetchLastInsertId();
                                                                $GLOBALS['db']->query
                                                                ("INSERT INTO `notifications`
                                                                    (`id`, `user_type`, `not_token`,`user_id` ) VALUES
                                                                    ( NULL ,'client','".$token_fire."' ,'".$pid."' )
                                                                ");
                                                                $userLoginQuery    = $GLOBALS['db']->query(" SELECT * FROM `clients` WHERE `email` = '".$_mail."' AND `status`='1' LIMIT 1");
                                                                $userCount         = $GLOBALS['db']->resultcount();
                                                                $clientCredintials = $GLOBALS['db']->fetchitem($userLoginQuery);
                                                                $staticKey 				= $this->updateToken("client",$clientCredintials['id'],$udid);
                                                                $GLOBALS['db']->query("UPDATE LOW_PRIORITY `pushs` SET `out` = '0'  WHERE `type` = 'client' AND `user_id` = '".$clientCredintials['id']."' ");
                                                                $_clientCredintials     = $this->buildMembershipCredintials("client",$clientCredintials,$staticKey);
                                                                $_clientCredintials['mobile_key'] = $mobileRandomKey;
                                                                $_clientCredintials = $this->buildMembershipCredintials("client",$clientCredintials,$staticKey);
                                                                $this->terminate('success',"",0,$_clientCredintials);
                                                                
                                                                  
                                                                  
                                                          }
                                                     }

														}

													}
                                            }
                                        
                                        }
                                        }else{
                                            $this->terminate('error',' عفوا يجب ادخال المحافظه والمدينه والعنوان او احداثيات الموقع ',12);
                                        }

										
										}

						// 			}
						// 		}
						// 	}
						// }
                }
            }
        }
    // }
}

//////////////////////////////////////////////////////////////////////////////////
public function mobile_verified(){
        
        $tokenUserId  = $this->testTokenprivate();
        if( $tokenUserId != 0 ){
            $userQuery = $GLOBALS['db']->query(" SELECT * FROM `clients` WHERE `id` = '".$tokenUserId."' LIMIT 1");
            $usersCount = $GLOBALS['db']->resultcount();
            if( $usersCount == 1 ){
                $allData = $GLOBALS['db']->fetchitem() ;
                $mobKey = $allData['mobile_key'] ;
                if( $mobKey != " " ){
                    $this->terminate('success',"",0, $mobKey );
                }else{
                    $this->terminate('error',"",0, "This user is already verified" );
                }
            }
        }else{
            $this->terminate('error',"",0," Sorry , udid Or static is notCorrect");
        }
            
 
        
        
}

//////////////////////////////////////////////////////////////////////////////////
public function GetGovernorates()
{
    $_governorate = intval($_POST['id']);

    if($_governorate != 0)
    {
        $addonQuery = "AND `id` = '".$_governorate."' ";
    }

    $_governorates = $GLOBALS['db']->query("SELECT * FROM `governorates` WHERE `status` = '1' ".$addonQuery);
    $_governorates_details = $GLOBALS['db']->fetchlist($_governorates);
    if($_governorates_details)
    {
		$lang  = sanitize($_POST['lang']);
        // $lang  = "ar";
        
        foreach($_governorates_details as $cId => $gov)
        {
            
            if($lang == "en")
            {
                $_cities = $GLOBALS['db']->query("SELECT id,name_en as `name` FROM `cities` WHERE `status` = '1' AND `governorate` = '".$gov['id']."'");
            }else{
                $_cities = $GLOBALS['db']->query("SELECT id,name_ar as `name` FROM `cities` WHERE `status` = '1' AND `governorate` = '".$gov['id']."'");
            }
            $_cities_details = $GLOBALS['db']->fetchlist($_cities);
            $_cities_count = $GLOBALS['db']->resultcount();
            
            
            if( $_cities_count > 0 ){

                foreach($_cities_details as $tId => $city)
                {
                    $cits[$tId]['id']             = intval($city['id']);
                    $cits[$tId]['name']     		= $city['name'];
                    
                }
                
            }    
                $governorates[]['governorates'] = [
                    'id'   =>  intval($gov['id']) ,
                    'name' => ($lang == "en")? html_entity_decode($gov['name_en']): html_entity_decode($gov['name_ar']),
                    'cities' => (is_array($cits)) ? $cits : array()
                ];
                $cits=[] ;
                
                            
        }

        $this->terminate('success','',0,$governorates);
        
          
    }else
    {
        
        $this->terminate('success','',0,"Sorry , No Found Available governorates");
          
    }
}


public function get_kind_client(){

    $kindId = intval($_POST['id']);
    if($kindId != 0)
    {
        $addonQuery = "AND `id` = '".$kindId."' ";
    } 
    $lang = sanitize($_POST['lang']) ;
    $kindQuery = $GLOBALS['db']->query(" SELECT * FROM `kind` WHERE `status` = 1 $addonQuery ") ;
    $kindData  = $GLOBALS['db']->fetchlist() ;
    $kindCount = $GLOBALS['db']->resultcount() ;
                                 
    if( $kindCount != 0 ){

        if( !empty($lang)  ){
            
            foreach( $kindData as $kid => $kind ){

                $kindArray[$kid]['id'] = $kind['id'] ;


                $kindArray[$kid]['name'] = $lang == 'ar' ? $kind['name_ar'] : $kind['name_en'] ;
                $kindArray[$kid]['description'] = $lang == 'ar' ? $kind['description_ar'] : $kind['description_en'] ;
                
            }
            $this->terminate('success'," ",0, $kindArray );

        }else{
            $this->terminate('error',' عفوا يجب ادخال اللغه ');
        }
    }else{
        $this->terminate('error','عفوا لا يوجد انواع متاحه حاليا');
    }


}


public function setPassword()
{
    $tokenUserId  = $this->testToken();
    $user         = sanitize($_POST['user']);
    if($user == "")
    {
        $this->terminate('error','عفواً يجب إدخال نوع المستخدم');
    }
    if($tokenUserId != 0)
    {
        if($user =='rep')
        {
            $userQuery = $GLOBALS['db']->query(" SELECT * FROM `reps` WHERE `id` = '".$tokenUserId."' LIMIT 1");
            $usersCount = $GLOBALS['db']->resultcount();
            if($usersCount == 1)
            {
                $userCredintials = $GLOBALS['db']->fetchitem($userQuery);
                $system         = new SystemLogin();
                $_newPassword   = sanitize($_POST['new_password']);
                $_newPassword2  = sanitize($_POST['new_password2']);
                $_oldPassword   = sanitize($_POST['old_password']);
                if(($_newPassword == $_oldPassword))
                {
                    $this->terminate('error','the new password like the old',180);
                     
                }

                $old_pass = md5($this->salt.$_oldPassword.$this->salt );
                if(  $userCredintials['password']  != $old_pass  )
                {
                    $this->terminate('error','invalid old password ',180);
                     
                }else
                {
                    if( ($_newPassword != "") && ($_newPassword2 != "") && ($_newPassword == $_newPassword2) )
                    {
                        $newHashedPassword = md5( $this->salt.$_newPassword.$this->salt );

                        $system->setPassword($newHashedPassword);

                        $GLOBALS['db']->query("UPDATE LOW_PRIORITY `reps` SET `password`='".$newHashedPassword."' WHERE `id` = '".$userCredintials['id']."' LIMIT 1");

                        $this->terminate('success','',0,"");
                        
                         
                    }else
                    {
                        $this->terminate('error','wrong password match , must new_password equal new_password2');
                         
                    }
                }
            }
 
        }
        elseif($user == 'client')
        {
            $userQuery = $GLOBALS['db']->query(" SELECT * FROM `clients` WHERE `id` = '".$tokenUserId."' LIMIT 1");
            $usersCount = $GLOBALS['db']->resultcount();
            if($usersCount == 1)
            {
                $userCredintials = $GLOBALS['db']->fetchitem($userQuery);
                $system = new SystemLogin();
                $_newPassword   = sanitize($_POST['new_password']);
                $_newPassword2  = sanitize($_POST['new_password2']);
                $_oldPassword   = sanitize($_POST['old_password']);
                $_old_pass      = $this->salt.$_oldPassword.$this->salt ;
                if(($_newPassword == $_oldPassword))
                {
                    $this->terminate('error','the new password like the old',180);
                     
                }

                
                if(  $userCredintials['password']  != md5($_old_pass)  )
                {
                    $this->terminate('error','invalid old password ',180);
                }else
                {
                   
                    if( ($_newPassword != "") && ($_newPassword2 != "") && ($_newPassword == $_newPassword2) )
                    {
                        
                        $newHashedPassword = md5( $this->salt.$_newPassword.$this->salt );

                        $system->setPassword($_newPassword);

                        $GLOBALS['db']->query("UPDATE LOW_PRIORITY `clients` SET `password`='".$newHashedPassword."',`reg_time` = now() WHERE `id` = '".$userCredintials['id']."' LIMIT 1");
                    

                        
                        $this->terminate('success','',0,"");
                    }else
                    {
                        $this->terminate('error','wrong password match , must new_password equal new_password2',180);
                    }
                }
            }

        }

    }
}


//////////////////////////////////////////////////////////////////////////////
//     function  updateToken 
//////////////////////////////////////////////////////////////////////////////
private function updateToken($in,$who,$udid)
    {
        if($in == "rep")
        {
            $GLOBALS['db']->query("DELETE LOW_PRIORITY FROM `tokens` WHERE `user_id` = '".$who."' AND `type` = 'rep' AND `udid` = '".($udid)."' ");

            $staticKey = $this->generateKey(20);

            $GLOBALS['db']->query("INSERT LOW_PRIORITY INTO `tokens` ( `id` , `token` , `type` , `user_id` , `udid` , `time` ) VALUES ( NULL ,  '".$staticKey."' ,  'rep' ,  '".$who."', '".$udid."', '".time()."' ) ");
            return $staticKey;
        }elseif($in == "client")
        {
            $GLOBALS['db']->query("DELETE LOW_PRIORITY FROM `tokens` WHERE `user_id` = '".$who."' AND `type` = 'client' AND `udid` = '".($udid)."' ");

            $staticKey = $this->generateKey(20);

            $GLOBALS['db']->query("INSERT LOW_PRIORITY INTO `tokens` ( `id` , `token` , `type` , `user_id` , `udid` , `time` ) VALUES ( NULL ,  '".$staticKey."' ,  'client' ,  '".$who."', '".$udid."', '".time()."' ) ");
            return $staticKey;
        }
    }

////////////////////////////////////////////////////////////
public function getProducts_toRep()
{
    $tokenUserId  = $this->testToken();
    $client_id    = intval( $_POST['client_id'] );
    if( $client_id == 0 ){ $this->terminate("error" ," Client_id Required " ,50 ); }

    if( $tokenUserId != 0 ){
        $client_products = $GLOBALS['db']->query(" SELECT inventory.product_id AS product_id ,inventory.storage AS stock , inventory.remain AS remain ,products.name_ar AS product_name , products.img AS img FROM `inventory` INNER JOIN `products` ON products.id = inventory.product_id WHERE inventory.client_id = '".$client_id."' AND inventory.rep_id = '".$tokenUserId."' ");
        $products_count  = $GLOBALS['db']->resultcount() ;
        if( $products_count > 0 ){
            $products_fetch  = $GLOBALS['db']->fetchlist() ;
            
            $products_details = [] ;
            foreach( $products_fetch as $k => $product ){

                $products_details[$k]['product_id']   = $product['product_id'] ;
                $products_details[$k]['stock']        = $product['stock'] ;
                $products_details[$k]['remain']       = $product['remain'] ;
                $products_details[$k]['product_name'] = $product['product_name'] ;
                $products_details[$k]['img'] = $product['img'] ? $this->getDefaults("url").$product['img'] : 'http://b-sfa.za3bot.com/inc/Classes/product.jpg' ;
            
            }

            $this->terminate('success','',0,$products_details) ;
        }

    }else{
        $this->terminate("erorr" , "invild static or udid",50);
    }
}

////////////////////////////////////////////////////////////

    public function setInventory(){
        $tokenUserId = $this->testToken();
        if( $tokenUserId != 0 ){
            $client_id   = intval( $_POST['client_id'] );
            $product_id  = intval( $_POST['product_id'] );
            $stock       = intval( $_POST['stock'] );
            $remain      = intval( $_POST['remain'] );
            $note        = sanitize($_POST['note']) ;
            if( $client_id == 0 ){ $this->terminate("error" ," Client_id Required " ,50 ); }
            if( $product_id == 0 ){ $this->terminate("error" ," product_id Required " ,50 ); }
            if($_FILES)
                    {
                        
                        if(!empty($_FILES['avatar']['error']))
                        {
                            //$this->terminate('success','',0);
                            switch($_FILES['avatar']['error'])
                            {
                                case '1':
                                    $this->terminate('error','عفوا حجم الملف أكبر من الحجم المسموح به',201);
                                    break;
                                case '2':
                                    $this->terminate('error','عفوا حجم الملف أكبر من الحجم المسموح به',202);
                                    break;
                                case '3':
                                    $this->terminate('error','عفوا لم نتمكن من تحميل الملف بالكامل',203);
                                    break;
                                case '4':
                                    $this->terminate('error','عفوا لم تقم باختيار الملف',204);
                                    break;
                                case '6':
                                    $this->terminate('error','هناك خطأ بالسيرفر مجلد التمب غير متوفر',205);
                                    break;
                                case '7':
                                    $this->terminate('error','عفوا لم نتمكن من تحميل الملف',206);
                                    break;
                                case '8':
                                    $this->terminate('error','عفوا الرجاء اعادة المحاولة تم ايقاف رفع الملف ربما بسبب انقطاع الخدمه',207);
                                    break;
                                case '999':
                                default:
                                    $this->terminate('error','خطأ غير معروف',208);
                            }
                        }
                        elseif(empty($_FILES['avatar']['tmp_name']) || $_FILES['avatar']['tmp_name'] == 'none')
                        {
                            $this->terminate('error','من فضلك قم باختيار ملف ليتم تحميله',209);
                        }else
                        {
                            $disallow_mime = array
                            (
                                "text/html",
                                "text/plain",
                                "magnus-internal/shellcgi",
                                "application/x-php",
                                "text/php",
                                "application/x-httpd-php" ,
                                "application/php",
                                "magnus-internal/shellcgi",
                                "text/x-perl",
                                "application/x-perl",
                                "application/x-exe",
                                "application/exe",
                                "application/x-java" ,
                                "application/java-byte-code",
                                "application/x-java-class",
                                "application/x-java-vm",
                                "application/x-java-bean",
                                "application/x-jinit-bean",
                                "application/x-jinit-applet",
                                "magnus-internal/shellcgi",
                                "image/svg",
                                "image/svg-xml",
                                "image/svg+xml",
                                "text/xml-svg",
                                "image/vnd.adobe.svg+xml",
                                "image/svg-xml",
                                "text/xml",
                            );
                            
                            include_once("upload.class.php");
                            $allow_ext = array("jpg","gif","png");
                            $upload    = new Upload($allow_ext,false,0,0,5000,"../uploads/",".","",false,'user_');
                            
                            $files[name] 	= addslashes($_FILES["avatar"]["name"]);
                            $files[type] 	= $_FILES["avatar"]['type'];
                            $files[size] 	= $_FILES["avatar"]['size']/1024;
                            $files[tmp] 	= $_FILES["avatar"]['tmp_name'];
                            $files[ext]		= $upload->GetExt($_FILES["avatar"]["name"]);
                            
                            
                            $upfile	= $upload->Upload_File($files);
                            //$this->terminate('success','',0); 
                            if($upfile)
                            {	
                                //$this->terminate('success','',0); 
                                $imgUrl =  "uploads/". $upfile[ext] . "/" .  $upfile[newname];

                            }else
                            {
                            $this->terminate('error','عفوا لم نتمكن من تحميل الملف',210);
                            }

                            @unlink($_FILES['avatar']);
                        }//					
                        
                    }        
            
            $img = $imgUrl ? $imgUrl : ' ' ;
            $checkQuery = $GLOBALS['db']->query("SELECT * FROM `inventory` WHERE `client_id`= '".$client_id."' AND`rep_id` ='".$tokenUserId ."' AND `product_id` ='".$product_id."'  ");
            $checkCount = $GLOBALS['db']->resultcount() ;
            if( $checkCount != 0 ){
                $inv = $GLOBALS['db']->fetchitem($checkQuery) ;
                $query = $GLOBALS['db']->query("UPDATE `inventory` SET `storage` = '".$stock."' ,  `remain` ='".$remain."' , `note`='".$note."',`avatar` ='".$img."'  ,`status` = 0 WHERE `id` = '".$inv['id']."' ");
            }else{
                $query = $GLOBALS['db']->query("INSERT INTO `inventory`(`id`, `client_id`, `rep_id`, `product_id`, `storage`, `remain`,`note` , `avatar`, `status`)
                VALUES (NULL,'".$client_id."','".$tokenUserId ."','".$product_id."','".$stock."','".$remain."','".$note."', '".$img."' , '0')") ;
            }
           
            $this->terminate('success','',0) ;
        }else{
            $this->terminate("erorr" , "invild static or udid",50);
        }


    }

////////////////////////////////////////////////////////////
    public function get_inventory_to_client(){
        $tokenUserId = $this->testToken();
        $client_products = $GLOBALS['db']->query(" SELECT inventory.product_id AS product_id ,inventory.storage AS stock , inventory.remain AS remain ,products.name_ar AS product_name , products.img AS img FROM `inventory` INNER JOIN `products` ON products.id = inventory.product_id WHERE inventory.client_id = '".$tokenUserId."' ");
        $products_count  = $GLOBALS['db']->resultcount() ;
        
        if( $products_count > 0 ){
            $products_fetch  = $GLOBALS['db']->fetchlist() ;
            $products_details = [] ;
            foreach( $products_fetch as $k => $product ){

                $products_details[$k]['product_id']   = $product['product_id'] ;
                $products_details[$k]['stock']        = $product['stock'] ;
                $products_details[$k]['remain']       = $product['remain'] ;
                $products_details[$k]['product_name'] = $product['product_name'] ;
                $products_details[$k]['img'] = $product['img'] ? $this->getDefaults("url").$product['img'] : 'http://b-sfa.za3bot.com/inc/Classes/product.jpg' ;
            
            }

            $this->terminate('success','',0,$products_details) ;
        }

    }
////////////////////////////////////////////////////////////

    public function GetProducts()
    {
        $_product     = intval($_POST['id']);
        
        if($_product != 0)
        {
            $addonQuery = "AND `id` = '".$_product."' ";
        }
        $lang = sanitize($_POST['lang']) ;
        if( $_POST['lang'] == ""){
            $this->terminate('error','',0,"Must Enter Laguage ");
        }
        $_categories = $GLOBALS['db']->query("SELECT * FROM `categories` WHERE `status` = 1 ");
        $_category_all = $GLOBALS['db']->fetchlist();
        $_category_count =   $GLOBALS['db']->resultcount() ;
    
        // $all = ['categories'] ;
        if( $_category_count == 0 ){

            // array_push($all ,'No Found Catogories in System' ) ;
            // $all[$cid][] = "No Found Catogories in System" ;
        }else{
            
            foreach($_category_all as $cId => $_category)
            {       
                    $_products = $GLOBALS['db']->query("SELECT * FROM `products` WHERE `cat_id` = '".$_category['id']."' ");
                    $_product_all = $GLOBALS['db']->fetchlist();
                    $_products_count =   $GLOBALS['db']->resultcount() ;
                    
                    // $products = array() ;
                    if( $_products_count == 0 ){
                        
                        
                        // array_push( $products ,'Sorry this Catgory no contain products' ) ;
                    }else{
                        
                        $prod_id        = intval($_category['id']);
                        if( $lang == 'ar'){
                            $prod_name     = $_category['name_ar'];
                        }else{
                            $prod_name     = $_category['name'];
                        }
                        
                        if( $lang == 'ar' ){
                            $prod_desc     = $_category['description_ar'];
                        }else{
                            $prod_desc     = $_category['description'];
                        }
                                                                       
                        $products = [] ;
                        foreach( $_product_all as $pId => $_product ){              
                            
                            $products[$pId]['id']        = intval($_product['id']);
                            // $products[$pId]['name']      = ($lang == "en") ? $_product['name_en'] : $_product['name_ar'];
                            if ($lang == 'ar'){ 
                                $products[$pId]['name'] = $_product['name_ar']  ;
                            }else{
                                $products[$pId]['name'] = $_product['name_en']  ;
                            }
                            // $products[$pId]['img']       = ($_product['img'] == "") ? $this->getDefaults("url").$this->getDefaults("img-default-product") : $this->getDefaults("url").$_product['img'];
                            // $products[$pId]['img']       = 'http://b-sfa.za3bot.com/inc/Classes/product.jpg';
                            $products[$pId]['img']       =  $this->getDefaults("url").'/SFA/'.$_product['img'] ; 
           
                            if ($lang == 'ar'){ 
                                $products[$pId]['about'] = $_product['about_ar']  ;
                            }else{
                                $products[$pId]['about'] = $_product['about_en']  ;
                            }
                            $products[$pId]['stock']                = $_product['stock'];
                            $products[$pId]['price']                = $_product['price'];
                            $products[$pId]['indications']          = $_product['indications'] ?? ' ' ;
                            $products[$pId]['composition']          = $_product['composition'] ?? ' '  ;
                            $products[$pId]['product_specification']= $_product['product_specification'] ?? ' '  ;
                            $products[$pId]['dose']                 = $_product['dose'] ?? ' '  ;
                            $products[$pId]['How_to_use']           = $_product['How_to_use'] ?? ' '  ;
                            $products[$pId]['the_expected_results'] = $_product['the_expected_results'] ?? ' ' ;
                            $products[$pId]['video']                = $_product['video'] ? 'http://b-sfa.za3bot.com/inc/Classes/'.$_product['video'] : ' ' ;
                            
                              
                            
                            // $_all_pro[$cId]['products'] = $products;   

                            
                        }
                        $_all_pro[]['categories'] = [
                            'id'           => intval($prod_id) ,
                            'name'         => $prod_name,
                            'description'  => $prod_desc,
                            'products' =>  $products
                            ] ;                        
                        
                        
                    }                                      
                }
                $this->terminate('success','',0,$_all_pro);
        }

    }
// ///////////////////////////////////////////////
    public function get_all_Products()
    {
        $_product     = intval($_POST['id']);
        
        if($_product != 0)
        {
            $addonQuery = "AND `id` = '".$_product."' ";
        }
        $lang = sanitize($_POST['lang']) ;
        if( $_POST['lang'] == ""){
            $this->terminate('error','',0,"Must Enter Laguage ");
        }
        $_products = $GLOBALS['db']->query("SELECT * FROM `products` WHERE `status` = 1 ");
        $_product_all = $GLOBALS['db']->fetchlist();
        $_products_count =   $GLOBALS['db']->resultcount() ;
        $products = [] ;
        foreach( $_product_all as $pId => $_product ){              
            
            $products[$pId]['id']        = intval($_product['id']);
            // $products[$pId]['name']      = ($lang == "en") ? $_product['name_en'] : $_product['name_ar'];
            if ($lang == 'ar'){ 
                $products[$pId]['name'] = $_product['name_ar']  ;
            }else{
                $products[$pId]['name'] = $_product['name_en']  ;
            }
            // $products[$pId]['img']       = ($_product['img'] == "") ? $this->getDefaults("url").$this->getDefaults("img-default-product") : $this->getDefaults("url").$_product['img'];
            $products[$pId]['img']       = $_product['img'] ? 'http://johnsonksa.net/Dawaa/'.$_product['img'] : 'http://b-sfa.za3bot.com/inc/Classes/product.jpg';
            if ($lang == 'ar'){ 
                $products[$pId]['about'] = $_product['about_ar']  ;
            }else{
                $products[$pId]['about'] = $_product['about_en']  ;
            }
            $products[$pId]['stock']                = $_product['stock'];
            $products[$pId]['price']                = $_product['price'];
            $products[$pId]['indications']          = $_product['indications'] ?? ' ' ;
            $products[$pId]['composition']          = $_product['composition'] ?? ' '  ;
            $products[$pId]['product_specification']= $_product['product_specification'] ?? ' '  ;
            $products[$pId]['dose']                 = $_product['dose'] ?? ' '  ;
            $products[$pId]['How_to_use']           = $_product['How_to_use'] ?? ' '  ;
            $products[$pId]['the_expected_results'] = $_product['the_expected_results'] ?? ' ' ;
            $products[$pId]['video']                = $_product['video'] ? 'http://b-sfa.za3bot.com/inc/Classes/'.$_product['video'] : ' ' ;
            
        
            
            // $_all_pro[$cId]['products'] = $products;   

            
        }                       
        
        $this->terminate('success','',0,$products);
        

    }


//  this function to generateKey
// //////////////////////////////////////////////////
    private function generateKey($length = 15)
	{
		$token 		= "";
		$key 		= "0123456789";
		$max 		= strlen($key);

		for ($i=0; $i < $length; $i++) {
			$token .= $key[$this->crypto_rand_secure(0, $max-1)];
		}
		return ($token);
	}
	

  //////////////////////////////////////////////////////////////////////////////  
	private function crypto_rand_secure($min, $max)
	{
		$range = $max - $min;
		if ($range < 1) return $min; // not so random...
		$log = ceil(log($range, 2));
		$bytes = (int) ($log / 8) + 1; // length in bytes
		$bits = (int) $log + 1; // length in bits
		$filter = (int) (1 << $bits) - 1; // set all lower bits to 1
		do {
			$rnd = hexdec(bin2hex(openssl_random_pseudo_bytes($bytes)));
			$rnd = $rnd & $filter; // discard irrelevant bits
		} while ($rnd > $range);
		return $min + $rnd;
	}
////////////////////////////////////////////////////////////////

    public function getOffer()
    {
        $_offer     = intval($_POST['id']);
        if($_offer != 0)
        {  $addonQuery = "AND `id` = '".$_offer."' ";     }
        $_offers = $GLOBALS['db']->query("SELECT * FROM `offers` WHERE `status` = '1' ".$addonQuery);
        $_offers_details = $GLOBALS['db']->fetchlist($_offers);
        if($_offers_details)
        {   $lang  = sanitize($_POST['lang']);
            if($lang != 'ar' && $lang != 'en' ){
                $this->terminate('error',' عفوا يجب ادخال اللغه ar || en ',14);
            }
            
            foreach($_offers_details as $pId => $offer)
            {
                $offers[$pId]['id']               = intval($offer['id']);
                $offers[$pId]['name']             = ($lang == "en")? html_entity_decode($offer['name_en']): html_entity_decode($offer['name_ar']);
                // $offers[$pId]['img']              = ($offer['img'] == "") ? $this->getDefaults("url").$this->getDefaults("img-default-offer") : $this->getDefaults("url").$offer['img'];
                $offers[$pId]['img']              = "http://b-sfa.za3bot.com/inc/Classes/product.jpg";
                $offers[$pId]['about']            = ($lang == "en")? html_entity_decode($offer['describtion_en']): html_entity_decode($offer['describtion_ar']);
                $offers[$pId]['quantity']         = $offer['quantity'];
                $offers[$pId]['price']            = $offer['price'];
                $offers[$pId]['status']           = $offer['status'];
            }
            $this->terminate('success','',0,$offers);
        }else
        {   $tasks_details = [];
            $this->terminate('success','',0,$tasks_details); }
    }

////////////////////////////////////////////////////////////////
    private function updateLoginTime($in,$who)
        {
            $GLOBALS['db']->query("UPDATE LOW_PRIORITY `".$in."` SET `log_time`= now() WHERE `id` = '".$who."' LIMIT 1");
        }
    

//////////////////////////////////////////////////////////////////

    private function buildMembershipCredintials($in="",$credintials="",$token="",$addons = array())
    {
        if($in == "rep")
        {
            $userData = array(
                "type"              =>     "rep",
                "id"                =>      intval($credintials['id']),
                "name"              =>      $credintials['name'],
                "email"             =>      $credintials['email'],
                "mobile"            =>      $credintials['mobile'],
                "governorate"       =>      $credintials['governorate'],
                "city"              =>      $credintials['city'],
                "img"			=>		($credintials["img"] == "") ? $this->getDefaults("url").$this->getDefaults("img-default-avatar") : $this->getDefaults("url").'SFA/'.$credintials["img"],
                // "img"			    =>		$credintials["img"],
                "status"			=>		$credintials["status"],
                "address"           =>      $credintials['address'],
                "reg_time"			=>		$credintials["reg_time"],
                "lon"			=>		$credintials["lon"],
                "lat"			=>		$credintials["lat"],
                
            );
        }elseif($in == "client")
        {
            $userData = array(
                "type"            => "client",
                "id"              => intval($credintials['id']),
                "name"            => $credintials['name'],
                "email"           => $credintials['email'],
                "mobile"          => $credintials['mobile'],
                "governorate"     => $credintials['governorate'],
                "city"            => $credintials['city'],
                "kind"            => $credintials['kind'],
                "img"		      => ($credintials["img"] == "") ? $this->getDefaults("url").$this->getDefaults("img-default-avatar") : $this->getDefaults("url").'SFA/'.$credintials["img"],
                // "img"		  =>		$credintials["img"],
                "address"         => $credintials['address'],
                "mobile_verified" => $credintials['mobile_verified'],
                "status"          => $credintials['status'],
                "mobile_key"      => $credintials['mobile_key'],
                "email_key"       => $credintials['email_key'],
                'rep_id'          => $credintials['rep_id'],
                "lon"			  => $credintials["lon"],
                "lat"			  => $credintials["lat"],
                "block"			  => $credintials["block"],
            );
        }
    
        if($token != "")
        {
            $userData["static"] = "".$token."";
        }
        if(is_array($addons) AND !empty($addons))
        {
            foreach($addons as $key => $feature)
            {
                $userData[$key] = "".$feature."";
            }
        }
        return $userData;
    }

///////////////////////////////////////////////////////////
public function get_user_data_for_rep(){
            
    $client_id = sanitize($_POST['client_id']);
    // $start 				= ( intval($_POST['p']) == 0)? 0 : intval($_POST['p']);
    // $queryLimit 		= " LIMIT ".((intval($start)-1) * $this->getDefaults("pagination")) ." , ". $this->getDefaults("pagination");
    $orderQuery = $GLOBALS['db']->query(" SELECT * FROM `orders` WHERE `client_id` = '".$client_id."' AND delivered=1 order by id desc ");
    $orderCount = $GLOBALS['db']->resultcount();
    $order_data = $GLOBALS['db']->fetchlist($orderQuery);
    
    $sumQuery = $GLOBALS['db']->query(" SELECT sum(total) AS sum_t  , sum(paid) AS sum_p , sum(remain) AS sum_r FROM `orders` WHERE delivered=1 AND  `client_id` = '".$client_id."' ");
    $sumCount = $GLOBALS['db']->resultcount();
    $sum_data = $GLOBALS['db']->fetchitem($sumQuery);
    
    
    $creditQuery = $GLOBALS['db']->query(" SELECT `credit` FROM `clients` WHERE `id` = '".$client_id."' LIMIT 1");
    $usersCount = $GLOBALS['db']->resultcount();
    $creditdata = $GLOBALS['db']->fetchitem($creditQuery);	
    
    
    // $sumQueryr = $GLOBALS['db']->query(" SELECT sum(price) AS sum_t_r FROM `returns_products` WHERE status= 1 AND  `client_id` = '".$client_id."' ");
    $sumQueryr = $GLOBALS['db']->query(" SELECT sum(price) AS sum_t_r FROM `returns_products` INNER JOIN `returns` ON returns_products.return_id = returns.id WHERE returns_products.status= 1 AND returns.client_id ='".$client_id."' ");
    $sum_datar = $GLOBALS['db']->fetchitem($sumQueryr);
    
    if ($sum_datar['sum_t_r'] ==''){
        $financial['returns'] = 0;
    }else{
        $financial['returns'] = $sum_datar['sum_t_r'];
    }
    
    
    
    if ($sum_data['sum_t'] ==''){
        $financial['total_financial_deals']=0;
    }else{
        $financial['total_financial_deals']=$sum_data['sum_t'] - $financial['returns'];
    }
    
    
    if ($sum_data['sum_p'] ==''){
        $financial['total_paid']=0;
    }else{
        $financial['total_paid']=$sum_data['sum_p'];
    }
    
    if ($creditdata['credit'] ==''){
        $financial['debts']=0;
    }else{
        $financial['debts']= $sum_data['sum_r'] - $financial['returns'];
    }
    
    
    $final_data =[];
    
    foreach($order_data as $key=>$value){
            
        
        $final_data[$key]['date']     = $value['date'];
        $final_data[$key]['order_id'] = $value['id'];
        $final_data[$key]['comments'] = "no other details";
        
        if($value['number_of_intallments']==1 || $value['number_of_intallments']==0){
            $final_data[$key]['pay_way'] = 'cash';
        }else{
            $final_data[$key]['pay_way'] = 'instalements';
        }
        
        $final_data[$key]['number_of_intallments'] = $value['number_of_intallments'];
        
        $instQuery = $GLOBALS['db']->query(" SELECT id, installement, money_paid, `status`,date FROM `installments` WHERE `order_id` = '".$value['id']."' ");
        $instdata = $GLOBALS['db']->fetchlist($instQuery);
        
        $final_data[$key]['intallments'] = $instdata;
        
        $final_data[$key]['number_of_monthes'] = $value['number_of_monthes'];
        $final_data[$key]['paid'] = $value['paid'];
        $final_data[$key]['remain'] = $value['remain'];
        $final_data[$key]['total'] = $value['total'];
        
        // $productQuery = $GLOBALS['db']->query(" SELECT product_id, quantity FROM `order_request` WHERE `order_id` = '".$value['id']."' ");
        $productQuery = $GLOBALS['db']->query(" SELECT * FROM `order_products` INNER JOIN `orders` ON order_products.order_id = orders.id WHERE client_id ='".$client_id."' ");
        $productCount = $GLOBALS['db']->resultcount();
        $productdata = $GLOBALS['db']->fetchlist($productQuery);
        $temp=[];
        foreach($productdata as $k=>$v){
            $Query = $GLOBALS['db']->query(" SELECT * FROM `products` WHERE `id` = '".$v['product_id']."' ");
            $products = $GLOBALS['db']->resultcount();
            if($products>0)
            {
                $data = $GLOBALS['db']->fetchitem($Query);
                $temp [$k]['product_id']  = $data['id'];
                $temp [$k]['quantity']    = $v['quantity'];
                $temp [$k]['name']        = $data['name'];
                $temp [$k]['price']       = $data['price'];
                $temp [$k]['img']         = $data['img'];
                $temp [$k]['video']       = $data['video'];
                $temp [$k]['about']       = $data['about'];
            }
            
        }
        $final_data[$key]['order_products'] = $temp;
    }

    ///////////////////////////////////////////////////////retuns 
    
    $returns_productsQuery = $GLOBALS['db']->query(" SELECT returns.id AS ID , returns.status AS statuts ,`price` , `date` ,`client_id` FROM `returns_products` INNER JOIN `returns` ON returns_products.return_id = returns.id WHERE client_id ='".$client_id."'");
    $returns_productsCount = $GLOBALS['db']->resultcount();
    $returns = $returns_productsCount ;
    $returns_products = $GLOBALS['db']->fetchlist($returns_productsQuery);
    $r_data=[];
    foreach($returns_products as $key=>$value){
        
        $r_data[$key]['id']         =$value['ID'];
        $r_data[$key]['status']     =$value['statuts'];
        $r_data[$key]['total_price']=$value['price'];
        $r_data[$key]['date']       =$value['date'];
        
        $userQuery = $GLOBALS['db']->query(" SELECT `id`,`name`, `email`, `mobile`,`kind`, `address` FROM `clients` WHERE `id` = '".$client_id."' LIMIT 1");
        $usersCount = $GLOBALS['db']->resultcount();
        $usersdata = $GLOBALS['db']->fetchitem($userQuery);		
        
//			$final_data[$key]['order_id'] = $value['id'];
        
        $user = [];
        $user['name'] = $usersdata['name'];
        $user['email'] = $usersdata['email'];
        $user['phone'] = $usersdata['phone'];
        $user['address'] = $usersdata['address'];
        $user['kind'] = $usersdata['kind'];
        $r_data[$key]['client_data'] = $user;
        
        
        $returns_requestsQuery = $GLOBALS['db']->query("SELECT * FROM `returns_products` WHERE return_id ='".$value['id']."'");
        $returns_requestsCount = $GLOBALS['db']->resultcount();
        $returns_requests = $GLOBALS['db']->fetchlist($returns_requestsQuery);
        $data=[];
        foreach($returns_requests as $k=>$v){
            $data[$k]['product_id']=$v['product_id'];
            $data[$k]['quantity']=$v['quantity'];

            $productsQuery = $GLOBALS['db']->query(" SELECT * FROM `products` WHERE id ='".$v['product_id']."' LIMIT 1");
            $productsCount = $GLOBALS['db']->resultcount();
            $products = $GLOBALS['db']->fetchitem($productsQuery);
            
            $data[$k]['name'] =$products['name'];
            $data[$k]['price']=$products['price'];
            $data[$k]['video']=$products['video'];
            $data[$k]['about']=$products['about'];
            $data[$k]['img']=$this->fix_image_upload($products['img']);
            
            
        }
        $r_data[$key]['returns_data']=$data;
}
    
$order = $GLOBALS['db']->query(" SELECT * FROM `orders` WHERE `client_id` = '".$client_id."' AND delivered=1 order by id desc ");
$orders = $GLOBALS['db']->resultcount();
$returns_Query = $GLOBALS['db']->query(" SELECT * FROM `returns_products` INNER JOIN `returns` ON returns_products.return_id = returns.id WHERE client_id ='".$client_id."' ");
$returns = $GLOBALS['db']->resultcount();	
    

$final['orders_count']  =   $orders;	
$final['returns_count'] =   $returns;	
$final['financial']     =   $financial;	
$final['orders']        =   $final_data;
$final['returns']       =   $r_data;

    
    
    
    
$this->terminate('success',"",0,$final);
    

}

//////////////////////////////////////////////////////////////

public function get_clients(){
		
    $tokenUserId = $this->testToken();
    $clientsQuery = $GLOBALS['db']->query(" SELECT * FROM `clients` WHERE `rep_id` = $tokenUserId ");
    $clientsCount = $GLOBALS['db']->resultcount();

    if($clientsCount > 0){
        $_clients = $GLOBALS['db']->fetchlist($clientsQuery);
        $clients = [];
        foreach($_clients as $k=>$v)
        {
            $govsQuery = $GLOBALS['db']->query(" SELECT * FROM `governorates` WHERE id = '".$v['governorate']."' ");
            $govsData   = $GLOBALS['db']->fetchitem() ;

            $citsQuery = $GLOBALS['db']->query(" SELECT * FROM `cities` WHERE id = '".$v['city']."' ");
            $citsData   = $GLOBALS['db']->fetchitem() ;

            $kindsQuery = $GLOBALS['db']->query(" SELECT * FROM `kind` WHERE id = '".$v['kind']."' ");
            $kindsData   = $GLOBALS['db']->fetchitem() ;


            $clients[$k]["id"]          =   $v["id"];
            $clients[$k]["name"]        =   $v["name"];
            $clients[$k]["email"]       =   $v["email"];
            $clients[$k]["mobile"]      =   $v["mobile"];
            $clients[$k]["img"]         =   $v["img"]  ? $this->getDefaults("url").$v["img"] : $this->getDefaults("url").'uploads/default-profile.jpg';
           
            $clients[$k]["kind"]        =   $kindsData["name_ar"];
            $clients[$k]["address"]     =   $v["address"] ?? " "; 
            $clients[$k]["governorate"] =   $govsData['name_ar'] ?? " ";
            $clients[$k]["city"]        =   $citsData['name_ar'] ?? " ";
            $clients[$k]["lat"]         =   $v["lat"] ;
            $clients[$k]["lon"]         =   $v["lon"];
            $clients[$k]["block"]         =   $v["block"];

            $_orders       = $GLOBALS['db']->query("SELECT * FROM `orders` WHERE `client_id` = '".$v['id']."' AND `rep_id` = '".$tokenUserId."' ");
            $_orderscounts = $GLOBALS['db']->resultcount();
            $clients[$k]['number_orders'] = $_orderscounts ;
            if($_orderscounts > 0)
            {
                $_orders_details = $GLOBALS['db']->fetchlist($_orders);
                $orders_details = [];
                foreach($_orders_details as $oId => $order)
                {
                    $order_details[$oId]['order_id']       =   intval($order['id']) ;
                    $order_details[$oId]['date']           =   $order['date'] ;
                    $order_details[$oId]['total']          =   $order['total'] ;
                    $order_details[$oId]['payment_method'] =   $order['payment_method'] ;
                    $order_details[$oId]['status']         =   $order['status'] ;


                                        
                }
                $clients[$k]['orders'] = $order_details ;
              
            }else{
                $clients[$k]['orders'] = [] ;
            }


            $_returns             = $GLOBALS['db']->query("SELECT * FROM `returns` WHERE `client_id` = '".$v['id']."' AND `rep_id` = '".$tokenUserId."' ");
            $_returnscounts       = $GLOBALS['db']->resultcount();
            $clients[$k]['number_returns'] = $_returnscounts ;
            if($_returnscounts > 0)
            {
                $_returns_details = $GLOBALS['db']->fetchlist($_returns);
                $orders_details = [];
                foreach($_returns_details as $rTd => $return)
                {
                    $return_details[$rTd]['return_id']       =   intval($return['id']) ;
                    $return_details[$rTd]['date']           =   $return['date'] ;
                    
                    $_returns_products = $GLOBALS['db']->query("SELECT `price` FROM `returns_products` WHERE `id` = '".$return['id']."' ");
                    $_returns_price = $GLOBALS['db']->fetchitem($_returns_products) ;
                    $return_details[$rTd]['total_price']    =   $_returns_price['price'] ;
                    
                }
                $clients[$k]['returns'] = $return_details ;
              
            }else{
                $clients[$k]['returns'] = [] ;
            }

            $targetQuery = $GLOBALS['db']->query(" SELECT SUM(`total`) as t, SUM(`paid`) as p , SUM(`remain`) as r FROM `orders` WHERE status !=0 AND `rep_id` = '".$tokenUserId."' AND `client_id` ='".$v["id"]."'");
            $targetdata = $GLOBALS['db']->fetchitem($targetQuery);
            $clients[$k]['total'] = $targetdata['t'] ?? 0 ;
            $clients[$k]['paid']  = $targetdata['p'] ?? 0 ;
            $clients[$k]['remain']  = $targetdata['r'] ?? 0 ;
        }   
            $this->terminate('success',"",0,$clients);	
            
        
    }else{
        $this->terminate('success',"empity",0);
    }
    
    
    


}


////////////////////////////////////////////////////////////

    private function getDefaults($attribute = "unknown")	
        {
            $settings = array(
                "url"						                => "http://".$_SERVER['SERVER_NAME']."/",
                "img-default-avatar"						=> "inc/Classes/avatar.jpg",
                "img-default-product"						=> "inc/Classes/product.jpg",
                "pagination"				                => 10
            );
            $this->settings = $settings;
            return ($settings[$attribute]);
        }
/////////////////////////////////////////////////////////////

public function update_profile()
{
    $tokenUserId  = $this->testToken();
    if($tokenUserId != 0)
    {
        $name       =   sanitize($_POST['name']);
        $email      =   sanitize(strtolower($_POST['email']));
        $address    =   sanitize($_POST['address']);
        $governorate =   intval($_POST['governorate']);
        $city       =   intval($_POST['city']);
        $mobile     =   sanitize($_POST['mobile']);
        $lon        =   floatval($_POST['lon']);
        $lat        =   floatval($_POST['lat']);
        $user       =   sanitize( $_POST['user'] ) ;
        $kind       =   intval( $_POST['kind'] ) ;
       
        

        if( !empty($user) ){
            $nameTable = ($user == 'rep') ? "reps" : "clients" ;
        }else{
            
            $this->terminate('error','عفوا يجب ادخال نوع المستخدم عميل او مندوب '.(11).' رقم ',7);
        }
        
        if (strlen( sanitize($_POST['mobile']) ) != (11) || !is_numeric( sanitize($_POST['mobile']) ) )
        {
            $this->terminate('error','عفواً رقم الجوال يجب أن يكون '.(11).' رقم ',7);
        }else
        {
            $system         = new SystemLogin();
            $mobileQuery    = $GLOBALS['db']->query(" SELECT * FROM $nameTable WHERE `mobile` = '".$mobile."' AND `id` !='".$tokenUserId."' LIMIT 1");
            $mobileCount    = $GLOBALS['db']->resultcount();
            if($mobileCount == 1)
            {
                $this->terminate('error','عفوأ هذا الهاتف مسجل به مسبقا',14);
            }else
            {
                
                    $mailQuery     = $GLOBALS['db']->query(" SELECT * FROM $nameTable WHERE `email` = '".$email."' AND `id` !='".$tokenUserId."' LIMIT 1");
                    $mailCount    = $GLOBALS['db']->resultcount();
                    if($mobileCount == 1)
                    {
                        $this->terminate('error','عفوأ هذا البريد مسجل به مسبقا',14);
                    }else
                    {
                        
                        if ( $name == "" )
                        {
                            $this->terminate('error','عفوأ يجب ادخال الاسم',7);
                        }else
                        {
                                if($this->checkMail($email) === "false")
                                {
                                    $this->terminate('error','عفواً يجب إدخال البريد الإلكتروني بشكل صحيح',3);
                                }else
                                {
                                    if ( $user == 'client' ){
                                        if($_POST['governorate'] && $_POST['city'] && $_POST['address']  || $_POST['lon']  && $_POST['lat'] )
                                        {
                                            if( $kind == '0' ){
                                                $this->terminate('error','عفوا يجب نوع العميل ',7);
                                            }else{
                                                $addKind = " ,`kind` = '".$kind."', `lon`  ='".$lon."',`lat`= '".$lat."' " ;
                                            }
                                        }else{
                                            $this->terminate('error',' عفوأ يجب ادخال العنوان او احداثيات الطول والعرض ',7);                                
                                            
                                        }
                                    }

                                    if( $user == 'rep' ){
                                        if($email == "" )
                                        {
                                            $this->terminate('error','عفوأ يجب ادخال البريد الالكترونى',7);
                                        }
                                    }
                                                            
                                    $GLOBALS['db']->query("UPDATE LOW_PRIORITY $nameTable SET
                                    `name`      = '".$name."',
                                    `email`     = '".$email."',
                                    `address`   = '".$address."',
                                    `mobile`    = '".$mobile."',
                                    `governorate`= '".$governorate."' ,
                                    `city`      = '".$city."' ,
                                    `address`   = '".$address."' $addKind
                                    WHERE `id`  = '".$tokenUserId."' LIMIT 1"); // AND `mobile_verified` = '1' AND `mail_verified` = '1'
  
                                    $userLoginQuery         = $GLOBALS['db']->query(" SELECT * FROM $nameTable WHERE `id`='".$tokenUserId."' LIMIT 1");

                                    $clientCredintials 	    = $GLOBALS['db']->fetchitem($userLoginQuery);
                                    $_clientCredintials     = $this->buildMembershipCredintials($user,$clientCredintials);
                                    $this->terminate('success',"",0,$_clientCredintials);
                                }
                            
                            
                        }

                    }
                
            }
        }
    }else{
        $this->terminate('error','invalid token',0);
    }
}


////////////////////////////////////////////////////////////

public function rep_edit_client()
{
    $tokenUserId  = $this->testToken();
    if($tokenUserId != 0)
    {
        $client_id  =   sanitize($_POST['client_id']);
        $name       =   sanitize($_POST['name']);
        $email      =   sanitize(strtolower($_POST['email']));
        $mobile     =   $_POST['mobile'];
        $job        =   sanitize( $_POST['job'] ) ;
        
       
        

        if( empty($name) ){
            $this->terminate('error','عفوا يجب ادخال اسم العميل ',7);
        }
        if( empty($client_id) || $client_id == 0 ){
            $this->terminate('error',' عفوا يجب ادخال كود العميل صحيح'.(11).' رقم ',7);
        }
        
        if (strlen( $mobile ) != '11'  )
        {
            $this->terminate('error','عفواً رقم الجوال يجب أن يكون '.(11).' رقم ',7);
        }else
        {
            $system         = new SystemLogin();
            $mobileQuery    = $GLOBALS['db']->query(" SELECT * FROM `clients` WHERE `id` = '".$client_id."'  AND `status` = 1 LIMIT 1");
            $clientCount    = $GLOBALS['db']->resultcount();
            if($clientCount == 0)
            {
                $this->terminate('error','عفوا لايوجد ف قاعده البيانات عميل بهذا الكود او لم يتم تفعيله من قبل لوحه التحكم',14);
            }else
            {
                    $mobileQuery     = $GLOBALS['db']->query(" SELECT * FROM `clients` WHERE `mobile` = '".$mobile."' AND `id` !='".$client_id."' LIMIT 1");
                    $mobileCount    = $GLOBALS['db']->resultcount();
                    if($mobileCount == 1)
                    {
                        $this->terminate('error','عفوأ هذا التليفون  مسجل به مسبقا',14);
                    }else
                    {
                        $mailQuery     = $GLOBALS['db']->query(" SELECT * FROM `clients` WHERE `email` = '".$email."' AND `id` !='".$client_id."' LIMIT 1");
                        $mailCount    = $GLOBALS['db']->resultcount();
                        if($mailCount == 1)
                        {
                            $this->terminate('error','عفوأ هذا البريد الالكتروني  مسجل به مسبقا',14);
                        }else
                        {
                            if ( $name == "" )
                            {
                                $this->terminate('error','عفوأ يجب ادخال الاسم',7);
                            }else
                            {
                                    if($this->checkMail($email) === "false")
                                    {
                                        $this->terminate('error','عفواً يجب إدخال البريد الإلكتروني بشكل صحيح',3);
                                    }else
                                    {
                                                                
                                        $GLOBALS['db']->query("UPDATE LOW_PRIORITY `clients` SET
                                        `name`      = '".$name."',
                                        `email`     = '".$email."',
                                        `mobile`    = '".$mobile."',
                                        `job`       = '".$job."'  
                                        WHERE `id`  = '".$client_id."' LIMIT 1"); 
    
                                        $this->terminate('success',"",0);
                                    }
                            
                            
                            }
                        }

                    }
                
            }
        }
    }else{
        $this->terminate('error','invalid token',0);
    }
}

//////////////////////////////////////////////////////////////
private function testToken()
{
    $staticToken = sanitize($_POST['static']);
    $udid = sanitize($_POST['udid']);
    if($staticToken == "" )
    {
          $this->terminate('error','unknown token parameters (POST:static or POST:udid )',3);
          ;
    }else
    { 
        $tokenQuery = $GLOBALS['db']->query(" SELECT * FROM `tokens` WHERE `token` = '".$staticToken."' AND `udid` = '".$udid."' LIMIT 1");
        $tokenValidity = $GLOBALS['db']->resultcount();
        if( $tokenValidity == 1 )
        {
            $tokenData    = $GLOBALS['db']->fetchitem($tokenQuery);
            $tokenUserId  = $tokenData['user_id'];
            $tokenType    = $tokenData['type'];
            if($tokenType == "rep")
            {
                $userQuery = $GLOBALS['db']->query(" SELECT * FROM `reps` WHERE `id` = '".$tokenUserId."' LIMIT 1");
                $usersCount = $GLOBALS['db']->resultcount();
                if($usersCount == 1)
                {
                    $userCredintials = $GLOBALS['db']->fetchitem($userQuery);
                    $status = $userCredintials['status'];
                    if($status == 0)
                    {
                          $this->terminate('error','this account is deactivated',6);
                          
                    }else
                    {
                        $verified = $userCredintials['mobile_verified'];
                        if($verified == 0)
                        {
                              $this->terminate('error','this account isn\'t verified',6);
                              
                        }else
                        {
                            return( $tokenUserId );
                            
                        }
                    }
                }else
                {
                      $this->terminate('error','This account has been deleted from our systems',6);
                      
                }
            }elseif($tokenType == "client")
            {
                $userQuery = $GLOBALS['db']->query(" SELECT * FROM `clients` WHERE `id` = '".$tokenUserId."' LIMIT 1");
                $usersCount = $GLOBALS['db']->resultcount();
                if($usersCount == 1)
                {
                    $userCredintials = $GLOBALS['db']->fetchitem($userQuery);
                    $status          = $userCredintials['status'];
                    if($status == 0)
                    {
                          $this->terminate('error','this account is deactivated',6);
                          
                    }else
                    {
                        $verified = $userCredintials['mobile_verified'];
                        if($verified == 0)
                        {
                              $this->terminate('error','this account isn\'t verified',6);
                              
                        }else
                        {
                            return($tokenUserId) ;
                        }
                    }
                }else
                {
                      $this->terminate('error','This account has been deleted from our systems',6);
                      
                }
            }
        }else
        {
            $this->terminate('error','invalid token',5);
              
        }
    }
}



//////////////////////////////////////////////////////////

private function testTokenPrivate()
{
    $staticToken = sanitize($_POST['static']);
    $udid = sanitize($_POST['udid']);
    if($staticToken == "" )
    {
          $this->terminate('error','unknown token parameters (POST:static or POST:udid )',3);
          ;
    }else
    { 
        $tokenQuery = $GLOBALS['db']->query(" SELECT * FROM `tokens` WHERE `token` = '".$staticToken."' AND `udid` = '".$udid."' LIMIT 1");
        $tokenValidity = $GLOBALS['db']->resultcount();
        if( $tokenValidity == 1 )
        {
            $tokenData    = $GLOBALS['db']->fetchitem($tokenQuery);
            $tokenUserId  = $tokenData['user_id'];
            $tokenType    = $tokenData['type'];
            if($tokenType == "client")
            {
                $userQuery = $GLOBALS['db']->query(" SELECT * FROM `clients` WHERE `id` = '".$tokenUserId."' LIMIT 1");
                $usersCount = $GLOBALS['db']->resultcount();
                
                if($usersCount == 1)
                {
                    $userCredintials = $GLOBALS['db']->fetchitem($userQuery);
                    $status          = $userCredintials['status'];
                    if($status == 0)
                    {
                        $this->terminate('error','this account is deactivated',6);
                        
                    }else
                    {    
                        // return $tokenUserId ;
                        return $tokenUserId ;
                        
                    
                    }
                }else
                {
                      $this->terminate('error','This account has been deleted from our systems',6);
                      
                }
            }
        }else
        {
            $this->terminate('error','invalid token',5);
              
        }
    }
}

/////////////////////////////////////////////////////////
public function authenticate()
	{
		$staticToken = sanitize($_POST['static']);
        $udid = sanitize($_POST['udid']);
        if($staticToken == "")
		{
            $this->terminate('error','token parameter not found',1);
              
		}else
		{
			$tokenQuery = $GLOBALS['db']->query(" SELECT * FROM `tokens` WHERE `token` = '".$staticToken."' AND `udid` = '".$udid."' LIMIT 1");
			$validToken = $GLOBALS['db']->resultcount();
			if( $validToken == 1 )
			{
				$tokenData = $GLOBALS['db']->fetchitem($tokenQuery);
				return $tokenData['type'];
			}else
			{
                $this->terminate('error','invalid token',2);
                  
			}
		}
	}
///////////-+//////////////////////////////////////////////
/////////////////////////////////////////////////////////
public function get_all_tasks()
{
    $tokenUserId  = $this->testToken();
    $now = time(); // or your date as well
    if($tokenUserId != 0)
    {
        $date  = $_POST['date'] ;
        if( !empty($date) ){
            $date = date('Y-m-d', $date);
            $addquery   = " AND `date` = '".$date."' ";
        }else{
            $date = date('Y-m-d') ; 
            $addquery   = " AND `date` = '".$date."' ";
        }
       if( intval($_POST['p']) ){
           $start 		      = ( intval($_POST['p']) == 0)? 0 : intval($_POST['p']);
           $queryLimit 	  = " LIMIT ".(intval($start) * $this->getDefaultPag("pagination")) ." , ". $this->getDefaultPag("pagination");
        }else{
            $queryLimit = " " ;
        }
           
        $_tasks         = $GLOBALS['db']->query("SELECT * FROM `tasks` WHERE `notifications_done` !='1' AND `postpone` ='0' AND `status` = '1' AND `rep_confirm` = '0' AND `rep_id` = '".$tokenUserId."' $addquery  ORDER BY `id` DESC ".$queryLimit);
        $_taskscounts   = $GLOBALS['db']->resultcount();
        if($_taskscounts > 0)
        {
            

            $_tasks_details = $GLOBALS['db']->fetchlist($_tasks);
            $tasks_details = [];
            foreach($_tasks_details as $tId => $tasks)
            {
                
                $_client         = $GLOBALS['db']->query("SELECT * FROM `clients` WHERE `status` = '1' AND `id` = '".$tasks['client_id']."' LIMIT 1");
                $_clientcounts   = $GLOBALS['db']->resultcount();
                $client          = $GLOBALS['db']->fetchitem($_client);

                $_kind = $GLOBALS['db']->query("SELECT `name_en` FROM `kind` WHERE `id` = '".$client['kind']."' LIMIT 1  ");
                $kind          = $GLOBALS['db']->fetchitem($_kind);

                $_gov = $GLOBALS['db']->query("SELECT `name_ar` FROM `governorates` WHERE `id` = '".$client['governorate']."' LIMIT 1  ");
                $gov          = $GLOBALS['db']->fetchitem($_kind);

                $_city = $GLOBALS['db']->query("SELECT `name_ar` FROM `cities` WHERE `id` = '".$client['city']."' LIMIT 1  ");
                $city          = $GLOBALS['db']->fetchitem($_kind);

                $last_order   = $GLOBALS['db']->query("SELECT `id` FROM `orders` WHERE `client_id` ='".$tasks['client_id']."' ORDER BY `id` DESC LIMIT 1 ");
                $last_ordercounts = $GLOBALS['db']->resultcount();
                if( $last_ordercounts > 0){
                    $fetch_last_order = $GLOBALS['db']->fetchitem($last_order);
                }

                $last_order   = $GLOBALS['db']->query("SELECT `date` ,`payment_type` FROM `orders` WHERE `client_id` ='".$tasks['client_id']."' ORDER BY `id` DESC LIMIT 1 ");
                $last_ordercounts = $GLOBALS['db']->resultcount();
                $_last_order = '';
                $last_bill   = '';
                if( $last_ordercounts > 0){
                    $fetch_last_order = $GLOBALS['db']->fetchitem($last_order);
                    $_d = $fetch_last_order['date'] ;
                    $your_date = strtotime($_d);
                    $datediff = $now - $your_date;
                    $years = floor($datediff / (365*60*60*24));
                    $months = floor(($datediff - $years * 365*60*60*24) / (30*60*60*24));
                    $days = floor(($datediff - $years * 365*60*60*24 - $months*30*60*60*24)/ (60*60*24));
                    $d_msg = " $days ايام " ;
                    $m_msg = " $months شهور " ;
                    $y_msg = " $years سنه " ;

                    if($y_msg > 0){
                        $_last_order = "منذ" . $y_msg . "و" . $m_msg. "و" . $d_msg ;
                    }elseif($m_msg > 0){
                        $_last_order =  "منذ" . $m_msg. "و" . $d_msg ;
                    }elseif($d_msg > 0){
                        $_last_order =  "منذ" . $d_msg ; 
                    }

                   

                    if( $fetch_last_order['payment_type'] == 'cash' ){
                        $_d = $fetch_last_order['date'] ;
                        $your_date = strtotime($_d);
                        $datediff = $now - $your_date;
                        $years = floor($datediff / (365*60*60*24));
                        $months = floor(($datediff - $years * 365*60*60*24) / (30*60*60*24));
                        $days = floor(($datediff - $years * 365*60*60*24 - $months*30*60*60*24)/ (60*60*24));
                        $d_msg = " $days ايام " ;
                        $m_msg = " $months شهور " ;
                        $y_msg = " $years سنه " ;

                        if($y_msg > 0){
                            $last_bill = "منذ" . $y_msg . "و" . $m_msg. "و" . $d_msg ;
                        }elseif($m_msg > 0){
                            $last_bill =  "منذ" . $m_msg. "و" . $d_msg ;
                        }elseif($d_msg > 0){
                            $last_bill =  "منذ" . $d_msg ; 
                        }

                    }else{
                        
                        $last_inst   = $GLOBALS['db']->query("SELECT `date` FROM `installments` WHERE `order_id` ='".$fetch_last_order[id]."' AND `installement` != 0  ORDER BY `id` DESC LIMIT 1 ");
                        $last_instcounts = $GLOBALS['db']->resultcount();
                        if( $last_instcounts > 0){
                            $fetch_last_ins = $GLOBALS['db']->fetchitem($last_inst);
                            $_d = $fetch_last_ins['date'] ;
                            $your_date = strtotime($_d);
                            $datediff = $now - $your_date;
                            $years = floor($datediff / (365*60*60*24));
                            $months = floor(($datediff - $years * 365*60*60*24) / (30*60*60*24));
                            $days = floor(($datediff - $years * 365*60*60*24 - $months*30*60*60*24)/ (60*60*24));
                            $d_msg = " $days ايام " ;
                            $m_msg = " $months شهور " ;
                            $y_msg = " $years سنه " ;

                            if($y_msg > 0){
                                $last_bill = "منذ" . $y_msg . "و" . $m_msg. "و" . $d_msg ;
                            }elseif($m_msg > 0){
                                $last_bill =  "منذ" . $m_msg. "و" . $d_msg ;
                            }elseif($d_msg > 0){
                                $last_bill =  "منذ" . $d_msg ; 
                            };

                        }
                    }

                }else{
                    $_last_order = 'لايوجد لديه طلبات سابقه' ;
                    $last_bill   = 'لايوجد لديه فواتير سابقه' ;
                }

                $tasks_details[$tId]['id']               = intval($tasks['id']) ;
                $tasks_details[$tId]['type']             = $tasks['type'] ?? '';
                $tasks_details[$tId]['type_id']          = $tasks['type_id'] ?? '';
                $tasks_details[$tId]['date']             = $tasks['date'] ?? '';
                $tasks_details[$tId]['client_id']        = $client['id']  ;
                $tasks_details[$tId]['client']           = $client['name'] . " ( " . $kind['name_en'] . " ) " ?? '';
                $tasks_details[$tId]['client_kind']      = $kind['name_en'] ?? '';
                $tasks_details[$tId]['last_order']       = $_last_order ;
                $tasks_details[$tId]['last_bill']        = $last_bill ;
                $tasks_details[$tId]['lon']              = $client['lon'] ?? '0';
                $tasks_details[$tId]['lat']              = $client['lat'] ?? '0';
                $tasks_details[$tId]['mobile']           = $client['mobile'] ?? '';
                $tasks_details[$tId]['address']          = $gov['name_ar'] . " - " .$city['name_ar']." - " . $client['address'] ?? '';
                $tasks_details[$tId]['note']             = $tasks['notes'] ?? '';
                $tasks_details[$tId]['start']            = $tasks['start'] ?? '0';
                $tasks_details[$tId]['start_time']       = $tasks['start_time'] ?? '';
                $tasks_details[$tId]['pause']            = $tasks['pause'] ?? '';
                $tasks_details[$tId]['pause_time']       = $tasks['pause_time'] ?? '';
                $tasks_details[$tId]['update']           = $tasks['update'] ?? '';
                $tasks_details[$tId]['update_time']      = $tasks['update_time'] ?? '';
               
        
                if($tasks['type'] =="installment")
                {
                    $_orders             = $GLOBALS['db']->query("SELECT * FROM `orders` WHERE `id` ='".$tasks[type_id]."' ");
                    $_orderscounts       = $GLOBALS['db']->resultcount();
                    if($_orderscounts > 0)
                    {
                        $_orders_details = $GLOBALS['db']->fetchlist($_orders);
                        $orders_details = [];
                        $tasks_details[$tId]['tital']   =   "installment";
                        foreach($_orders_details as $oId => $order)
                        {
                            
                            $_installments   = $GLOBALS['db']->query("SELECT * FROM `installments` WHERE `order_id` = '".$order['id']."' ");
                            $installCount = $GLOBALS['db']->resultcount($_installments) ;
                            $install = $GLOBALS['db']->fetchlist($_installments);
                            
                            if (is_array($install) ){

                                foreach( $install as $k_i=>$_ins ){                                  
                                    $_install[$k_i]['installment num'] =  $k_i + 1 ;
                                    $_install[$k_i]['payment_method'] =  $_ins['payment_method'] ;
                                    $_install[$k_i]['installment'] =  $_ins['installement'] ;
                                    $_install[$k_i]['num_month']       =  $order['number_of_month'] ;
                                    $_install[$k_i]['num_istall']      =  $order['number_of_installment'] ;
                                    $_install[$k_i]['date'] =  $_ins['date'] ;
                                    
                                }
                            }
                            

                            
                            $order_details[$oId]['order_id']       =   intval($order['id']) ;
                            $order_details[$oId]['date']           =   $order['date'] ;
                            $order_details[$oId]['total']          =   $order['total'] ;
                            $order_details[$oId]['payment_method'] =   $order['payment_method'] ;
                            $order_details[$oId]['paid']           =   $order['paid'] ?? '0';
                            $order_details[$oId]['remain']         =   $order['remain'] ;
                            $order_details[$oId]['number of installment']  =   $order['number_of_installment'] ;
                            $order_details[$oId]['installment']  =   $_install ?$_install : [] ;
                            
                            $_order_products         = $GLOBALS['db']->query("SELECT op.`id`,p.`price`, p.`name_ar` AS name ,op.`quantity` FROM `order_products` op INNER JOIN `products` p ON p.`id` = op.`product_id` WHERE op.`order_id` = '".$order['id']."'");
                            $_order_productscounts   = $GLOBALS['db']->resultcount();
                            if($_order_productscounts > 0)
                            { 
                                $_order_products_details    =   $GLOBALS['db']->fetchlist($_return_products);
                                $order_products     =   [];
                                foreach($_order_products_details as $pId => $product)
                                {
                                    $order_products[$pId]['id']                  =   intval($product['id']) ;
                                    $order_products[$pId]['name']                =   $product['name'] ;
                                    $order_products[$pId]['price']               =   $product['price'] ;
                                    $order_products[$pId]['img']                 =   ($product['img'] == "") ? $this->getDefaults("url").$this->getDefaults("img-default-product") : $this->getDefaults("url").$product['img'];
                                    $order_products[$pId]['quantity']            =   $product['quantity'] ;
                                    $order_products[$pId]['indications']          = $product['indications'] ?? ' ' ;
                                    $order_products[$pId]['composition']          = $product['composition'] ?? ' '  ;
                                    $order_products[$pId]['product_specification']= $product['product_specification'] ?? ' '  ;
                                    $order_products[$pId]['dose']                 = $product['dose'] ?? ' '  ;
                                    $order_products[$pId]['How_to_use']           = $product['How_to_use'] ?? ' '  ;
                                    $order_products[$pId]['the_expected_results'] = $product['the_expected_results'] ?? ' ' ;
                                    $order_products[$pId]['video']                = $product['video'] ? 'http://b-sfa.za3bot.com/inc/Classes/'.$_product['video'] : ' ' ;
                                       
                                    
                                }
                                // $order_details[$tId]['product']   =  $order_products ;
                                $tasks_details[$tId]['product']   =  $order_products ;
    
                            }
                            

                         }
                        // $arr_bills = $order_details ;
                        // $tasks_details[$tId]['bills']        =     $arr_bills;
                        $tasks_details[$tId]['bills']     =     $order_details;
                      
                    }
                    // else{
                    //     $this->terminate('error','invalid order id in installment',0);
                    // }

                }elseif($tasks['type'] =="return")
                {
                    $_return         = $GLOBALS['db']->query("SELECT * FROM `returns` WHERE `id` ='".$tasks[type_id]."' LIMIT 1");
                    $_returnscounts  = $GLOBALS['db']->resultcount();
                    if($_returnscounts > 0)
                    {
                        $_returns_details = $GLOBALS['db']->fetchitem($_return);
                        $tasks_details[$tId]['tital']          =   "return(".$_returns_details['id'].")";
                        $return   = array(
                            "id"            =>      intval($_returns_details['id']),
                            "date"          =>      $_returns_details['date'],
                            "total"         =>      $_returns_details['total'],
                            "paid"          =>      $_returns_details['paid'] ?? '0',
                            "bill_img"      =>      ($_returns_details["bill_img"] == "") ?   : $this->getDefaults("url").$_returns_details["bill_img"]
                        );
                        
                        $_return_products         = $GLOBALS['db']->query("SELECT rp.`id` ,p.`price`,p.`name_ar` AS name , p.`img` AS img ,rp.`quantity` FROM `returns_products` rp INNER JOIN `products` p ON p.`id` = rp.`product_id` WHERE rp.`return_id` = '".$_returns_details['id']."'");
                        $_return_productscounts   = $GLOBALS['db']->resultcount();

                        if($_return_productscounts > 0)
                        {
                            $_return_products_details    =   $GLOBALS['db']->fetchlist($_return_products);
                            $return_products_details     =   [];
                            foreach($_return_products_details as $pId => $product)
                            {
                                $return_products_details[$pId]['id']                  =   intval($product['id']) ;
                                $return_products_details[$pId]['name']                =   $product['name'] ;
                                $return_products_details[$pId]['price']               =   $product['price'] ;
                                $return_products_details[$pId]['img']                 =   ($product['img'] == "") ? $this->getDefaults("url").$this->getDefaults("img-default-product") : $this->getDefaults("url").$product['img'];
                                $return_products_details[$pId]['quantity']            =   $product['quantity'] ;
                            }
                            $tasks_details[$tId]['product']   =  $return_products_details ;
                            $return_products_details = [] ;

                            $arr_bills[] = $return  ;
                            $tasks_details[$tId]['bills']        =     $arr_bills;
                            // $tasks_details[$tId]['bills']    =     $return;
                        

                        }
                    }

                }elseif($tasks['type'] =="order")
                {        
                    $_order         = $GLOBALS['db']->query("SELECT * FROM `orders` WHERE `id` ='".$tasks[type_id]."' ");
                    $_orderscounts  = $GLOBALS['db']->resultcount();
                    if($_orderscounts ==1)
                    {
                        
                        $_order_details = $GLOBALS['db']->fetchitem($_order);
                        $tasks_details[$tId]['tital']          =   "order(".$_order_details['id'].")";

                        $_install        = $GLOBALS['db']->query("SELECT * FROM `installments` WHERE `order_id` ='".$tasks[type_id]."' ");
                        $_installcounts  = $GLOBALS['db']->resultcount();
                        if( $_installcounts > 0 ){
                            $fetch_inst = $GLOBALS['db']->fetchlist();
                            foreach( $fetch_inst as $k_i => $ins ){
                                $_install[$k_i]['installment num'] =  $k_i+1 ;
                                $_install[$k_i]['payment_method']  =  $ins['payment_method'] ;
                                $_install[$k_i]['installment']     =  $ins['installement'] ;
                                $_install[$k_i]['num_month']       =  $_order_details['number_of_month'] ;
                                $_install[$k_i]['num_istall']      =  $_order_details['number_of_installment'] ;
                                $_install[$k_i]['date']            =  $ins['date'] ;
                            }

                        }

                        $order[]   = [
                            "id"            =>      intval($_order_details['id']),
                            "date"          =>      $_order_details['date'],
                            "total"         =>      $_order_details['total'],
                            "paid"          =>      $_order_details['paid'] ?? '0' ,
                            "remain"        =>      $_order_details['remain'],
                            "installments"  =>      $_install ? $_install : [] 
                        ];
                        $_order_products         = $GLOBALS['db']->query("SELECT op.`id`,p.`price`, p.`name_ar` AS name ,op.`quantity` FROM `order_products` op INNER JOIN `products` p ON p.`id` = op.`product_id` WHERE op.`order_id` = '".$tasks['order_id']."'");
                        $_order_productscounts   = $GLOBALS['db']->resultcount();
                        if($_order_productscounts > 0)
                        {   
                            $_order_products_details    =   $GLOBALS['db']->fetchlist($_order_products);
                            // $order_products_details     =   [];
                            foreach($_order_products_details as $pId => $product)
                            {   
                                $order_products_details[$pId]['id']                  =   intval($product['id']) ;
                                $order_products_details[$pId]['name']                =   $product['name'] ;
                                $order_products_details[$pId]['price']               =   $product['price'] ;
                                $order_products_details[$pId]['img']                 =   ($product['img'] == "") ? $this->getDefaults("url").$this->getDefaults("img-default-product") : $this->getDefaults("url").$product['img'];
                                $order_products_details[$pId]['quantity']            =   $product['quantity'] ;
                                $order_products_details[$pId]['indications']          = $product['indications'] ?? ' ' ;
                                $order_products_details[$pId]['composition']          = $product['composition'] ?? ' '  ;
                                $order_products_details[$pId]['product_specification']= $product['product_specification'] ?? ' '  ;
                                $order_products_details[$pId]['dose']                 = $product['dose'] ?? ' '  ;
                                $order_products_details[$pId]['How_to_use']           = $product['How_to_use'] ?? ' '  ;
                                $order_products_details[$pId]['the_expected_results'] = $product['the_expected_results'] ?? ' ' ;
                                $order_products_details[$pId]['video']                = $product['video'] ? 'http://b-sfa.za3bot.com/inc/Classes/'.$_product['video'] : ' ' ;
                                   
                            }
                            // $order['product']   =  $order_products_details ;
                            $tasks_details[$tId]['product']   =  $order_products_details ? $order_products_details : [] ;

                        }

                        // $arr_bills[] = $order  ;
                        $tasks_details[$tId]['bills']        =     $order ;
                        $order = [] ;
                        // $tasks_details[$tId]['bills']        =     $arr_bills;
                        // $tasks_details[$tId]['bills']        =     $order ;
                        // $tasks_details[$tId]['product']        =     $order_products_details ;
                    }

                }elseif($tasks['type'] =="visit" || $tasks['type'] =="visit2" )
                {
                    $tasks_details[$tId]['tital']          =   "visit" ;
                    $bills_visit = $GLOBALS['db']->query("SELECT * FROM `installments` WHERE `client_id` = '".$tasks['client_id']."' AND `rep_id` = '".$tokenUserId."'  ");
                    $bills_visit_count = $GLOBALS['db']->resultcount();
                    if( $bills_visit_count > 0){
                        $bills_visit_data = $GLOBALS['db']->fetchlist();
                        $_visitInstall = [] ;
                        foreach( $bills_visit_data as $k_i=>$_ins ){   
                            $_order         = $GLOBALS['db']->query("SELECT * FROM `orders` WHERE `id` ='".$tasks[type_id]."' ");
                            $_orderscounts  = $GLOBALS['db']->resultcount();
                            if($_orderscounts ==1)
                            {
                                
                                $_order_details = $GLOBALS['db']->fetchitem($_order);

                                $_visitInstall[$k_i]['installment num'] =  $k_i+1 ;
                                $_visitInstall[$k_i]['payment_method']  =  $_ins['payment_method'] ;
                                $_visitInstall[$k_i]['installment']     =  $_ins['installement'] ;
                                $_visitInstall[$k_i]['num_month']            =  $_order_details['number_of_month'] ;
                                $_visitInstall[$k_i]['num_istall']           =  $_order_details['number_of_installment'] ;
                                $_visitInstall[$k_i]['date']            =  $_ins['date'] ;
                            
                            }
                            
                        }
                        // $arr_bills = $_visitInstall  ;
                    }
                    $tasks_details[$tId]['bills']        =     $_visitInstall ?? [] ;

                }elseif($tasks['type'] == "inventory"){
                    $_orders             = $GLOBALS['db']->query("SELECT * FROM `inventory` WHERE `id` ='".$tasks[type_id]."' ");
                    $_orderscounts       = $GLOBALS['db']->resultcount();
                    if($_orderscounts > 0)
                    {
                        $_orders_details = $GLOBALS['db']->fetchlist($_orders);
                        $orders_details = [];
                        $tasks_details[$tId]['tital']   =   "installment";
                        foreach($_orders_details as $oId => $order)
                        {
                            $order_details[$oId]['order_id']       =   intval($order['id']) ;
                            $order_details[$oId]['date']           =   $order['date'] ;
                            $order_details[$oId]['total']          =   $order['total'] ;
                            $order_details[$oId]['paid']           =   $order['paid'] ?? '0' ;
                            $order_details[$oId]['remain']         =   $order['remain'] ;

                            $_order_products         = $GLOBALS['db']->query("SELECT op.`id`,p.`price`, p.`name_ar` AS name ,op.`quantity` FROM `order_products` op INNER JOIN `products` p ON p.`id` = op.`product_id` WHERE op.`order_id` = '".$order['id']."'");
                            $_order_productscounts   = $GLOBALS['db']->resultcount();
                            if($_order_productscounts > 0)
                            {
                                $_order_products_details    =   $GLOBALS['db']->fetchlist($_return_products);
                                $order_products_details     =   [];
                                foreach($_order_products_details as $pId => $product)
                                {
                                    $order_products_details[$pId]['id']                  =   intval($product['id']) ;
                                    $order_products_details[$pId]['name']                =   $product['name'] ;
                                    $order_products_details[$pId]['price']               =   $product['price'] ;
                                    $order_products_details[$pId]['img']                 =   ($product['img'] == "") ? $this->getDefaults("url").$this->getDefaults("img-default-product") : $this->getDefaults("url").$product['img'];
                                    $order_products_details[$pId]['quantity']            =   $product['quantity'] ;
                                    $order_products_details[$pId]['indications']          = $product['indications'] ?? ' ' ;
                                    $order_products_details[$pId]['composition']          = $product['composition'] ?? ' '  ;
                                    $order_products_details[$pId]['product_specification']= $product['product_specification'] ?? ' '  ;
                                    $order_products_details[$pId]['dose']                 = $product['dose'] ?? ' '  ;
                                    $order_products_details[$pId]['How_to_use']           = $product['How_to_use'] ?? ' '  ;
                                    $order_products_details[$pId]['the_expected_results'] = $product['the_expected_results'] ?? ' ' ;
                                    $order_products_details[$pId]['video']                = $product['video'] ? 'http://b-sfa.za3bot.com/inc/Classes/'.$_product['video'] : ' ' ;
                                   
                                }
                                $order_details[$oId]['product']   =  $order_products_details ;
    
                            }
                            
                         }

                        $tasks_details[$tId]['bills']        =     $order_details;
                      
                    }
                }
            }

            $this->terminate('success','',0,$tasks_details);

        }else{
            $tasks_details = [];
            $this->terminate('success','',0,$tasks_details);
        }
        
    }else{
        $this->terminate('error','invalid token',0);
    }
    
}
///////////////////////////////////////////////////////////

    public function get_all_tasks_to_client()
    {
        $tokenUserId  = $this->testToken();
        $date = $_POST['date'];
        $type_visit = $_POST['type_visit'];
        if($tokenUserId != 0)
        {
            if( !empty($date) ){
                $dateQuery = " AND `date` = '".$date."' "  ;
                
            }else{
                $date = date('Y-m-d');
                $dateQuery = " AND `date` = '".$date."' " ;
            }

            if( $type_visit != ""){
                $typeQuery = " AND `type` = '".$type_visit."' "  ;
            }else{
                $typeQuery = " " ;
            }
            
            $_tasks         = $GLOBALS['db']->query("SELECT * FROM `tasks` WHERE `status` = '1' AND `client_id` = '".$tokenUserId."' " .$typeQuery ." ". $dateQuery );
            $_taskscounts   = $GLOBALS['db']->resultcount();
            if($_taskscounts > 0)
            {   
                
                $_tasks_details = $GLOBALS['db']->fetchlist($_tasks);
                $tasks_details = [];
                foreach($_tasks_details as $tId => $tasks)
                {   
                    $ratequery = $GLOBALS['db']->query("SELECT AVG(client_rate) FROM `tasks` WHERE `rep_id` = '".$tasks['rep_id']."' AND`client_rate` !=0 " ) ;
                    $rate =  $GLOBALS['db']->fetchitem() ;
                    $getRep = $GLOBALS['db']->query("SELECT * FROM `reps` WHERE `id` = '".$tasks['rep_id']."' ");
                    $repName='';
                    $repName = $GLOBALS['db']->fetchitem() ;
                    $checkRate = $GLOBALS['db']->query("SELECT * FROM `tasks` WHERE `id` = '".$tasks['id']."' AND`client_rate` = 0 LIMIT 1" ) ;
                    $_check    = $GLOBALS['db']->resultcount() ;
                    if( $_check == 1 ){
                        $_check_rate = '0' ; //client not rate
                    }else{
                        $_check_rate = '1' ; // client done  rate
                    }
                    
                    $tasks_details[$tId]['id']               = intval($tasks['id']) ;
                    $tasks_details[$tId]['type']             = $tasks['type'] ;
                    $tasks_details[$tId]['type_id']          = $tasks['type_id'] ;
                    $tasks_details[$tId]['date']             = $tasks['date'] ;
                    $tasks_details[$tId]['start']            = $tasks['start'] ??'0';
                    $tasks_details[$tId]['start_time']       = $tasks['start_time'] ??'' ;
                    $tasks_details[$tId]['pause']            = $tasks['pause'] ??'0';
                    $tasks_details[$tId]['pause_time']       = $tasks['pause_time'] ??'' ;
                    $tasks_details[$tId]['update']           = $tasks['update'] ??'0';
                    $tasks_details[$tId]['update_time']      = $tasks['update_time'] ??'';
                    $tasks_details[$tId]['postpone']         = $tasks['update_time'] ??'';
                    $tasks_details[$tId]['update_time']      = $tasks['update_time'] ??'';
                    $tasks_details[$tId]['rate']             = intval($rate[0]) ;
                    $tasks_details[$tId]['rep_name']         = $repName['name'] ;
                    $tasks_details[$tId]['rep_phone']        = $repName['mobile'] ;
                    $tasks_details[$tId]['check_rate']       = $_check_rate ;
                    $tasks_details[$tId]['done']             = $tasks['notifications_done'] ?? '0' ;
                    $tasks_details[$tId]['notes']           = $tasks['notes'] ?? " "  ;
                    $tasks_details[$tId]['status']           = $tasks['status'] ?? "0"  ;

               
                if($tasks['type'] =="installment")
                {
                    $_orders             = $GLOBALS['db']->query("SELECT * FROM `orders` WHERE `id` = '".$tasks[type_id]."' ");
                    $_orderscounts       = $GLOBALS['db']->resultcount();
                    if($_orderscounts > 0)
                    {
                        $_orders_details = $GLOBALS['db']->fetchlist($_orders);
                        $orders_details = [];
                        $tasks_details[$tId]['tital']   =   "installment";
                        foreach($_orders_details as $oId => $order)
                        {
                            
                            $_installments   = $GLOBALS['db']->query("SELECT * FROM `installments` WHERE `order_id` = '".$tasks[type_id]."' ");
                            $installCount = $GLOBALS['db']->resultcount($_installments) ;
                            $install = $GLOBALS['db']->fetchlist($_installments);
                            
                            if (is_array($install) ){

                                foreach( $install as $k_i=>$_ins ){                                  
                                    $_install[$k_i]['installment num'] =  $k_i + 1 ;
                                    $_install[$k_i]['payment_method'] =  $_ins['payment_method'] ;
                                    $_install[$k_i]['installment'] =  $_ins['installement'] ;
                                    $_install[$k_i]['date'] =  $_ins['date'] ;

                                    $order_details[$oId]['order_id']       =   intval($tasks[type_id]) ;
                                    $order_details[$oId]['date']           =   $order['date'] ;
                                    $order_details[$oId]['total']          =   $order['total'] ;
                                    $order_details[$oId]['payment_method'] =   $order['payment_method'] ;
                                    $order_details[$oId]['paid']           =   $order['paid'] ?? '0';
                                    $order_details[$oId]['remain']         =   $order['remain'] ;
                                    $order_details[$oId]['number of installment']  =   $order['number_of_installment'] ;
                                    $order_details[$oId]['installment']  =   $_install ?$_install : [] ;
                                    
                                }
                            }
                            
                            
                           
                            
                            $_order_products         = $GLOBALS['db']->query("SELECT op.`id`,p.`price`, p.`name_ar` AS name ,op.`quantity` FROM `order_products` op INNER JOIN `products` p ON p.`id` = op.`product_id` WHERE op.`order_id` = '".$order['id']."'");
                            $_order_productscounts   = $GLOBALS['db']->resultcount();
                            if($_order_productscounts > 0)
                            { 
                                $_order_products_details    =   $GLOBALS['db']->fetchlist($_return_products);
                                $order_products     =   [];
                                foreach($_order_products_details as $pId => $product)
                                {
                                    $order_products[$pId]['id']                  =   intval($product['id']) ;
                                    $order_products[$pId]['name']                =   $product['name'] ;
                                    $order_products[$pId]['price']               =   $product['price'] ;
                                    $order_products[$pId]['img']                 =   ($product['img'] == "") ? $this->getDefaults("url").$this->getDefaults("img-default-product") : $this->getDefaults("url").$product['img'];
                                    $order_products[$pId]['quantity']            =   $product['quantity'] ;
                                    $order_products[$pId]['indications']          = $product['indications'] ?? ' ' ;
                                    $order_products[$pId]['composition']          = $product['composition'] ?? ' '  ;
                                    $order_products[$pId]['product_specification']= $product['product_specification'] ?? ' '  ;
                                    $order_products[$pId]['dose']                 = $product['dose'] ?? ' '  ;
                                    $order_products[$pId]['How_to_use']           = $product['How_to_use'] ?? ' '  ;
                                    $order_products[$pId]['the_expected_results'] = $product['the_expected_results'] ?? ' ' ;
                                    $order_products[$pId]['video']                = $product['video'] ? 'http://b-sfa.za3bot.com/inc/Classes/'.$_product['video'] : ' ' ;
                                    
                                }
                                // $order_details[$tId]['products']   =  $order_products ;
    
                            }
                            

                         }
                        // $arr_bills = $order_details ;
                        // $tasks_details[$tId]['bills']        =     $arr_bills;
                        $tasks_details[$tId]['bills']     =     $order_details;
                        $order_details = [] ;
                      
                    }else{
                        $this->terminate('error','invalid order id in installment',0);
                    }

                }elseif($tasks['type'] =="return")
                {
                    $_return         = $GLOBALS['db']->query("SELECT * FROM `returns` WHERE `id` = '".$tasks[type_id]."' ");
                    $_returnscounts  = $GLOBALS['db']->resultcount();
                    if($_returnscounts > 0)
                    {
                        $_returns_details = $GLOBALS['db']->fetchitem($_return);
                        $tasks_details[$tId]['tital']          =   "return(".$_returns_details['id'].")";
                        
                        $return   = array(
                            "id"            =>      intval($_returns_details['id']),
                            "date"          =>      $_returns_details['date'],
                            "total"         =>      $_returns_details['total'] ?? '0',
                            "paid"          =>      $_returns_details['paid'] ?? '0',
                            "bill_img"      =>      ($_returns_details["bill_img"] == "") ?   : $this->getDefaults("url").$_returns_details["bill_img"]
                        );
                        
                        $_return_products         = $GLOBALS['db']->query("SELECT rp.`id` ,p.`price`,p.`name_ar` AS name , p.`img` AS img ,rp.`quantity` FROM `returns_products` rp INNER JOIN `products` p ON p.`id` = rp.`product_id` WHERE rp.`return_id` = '".$_returns_details['id']."'");
                        $_return_productscounts   = $GLOBALS['db']->resultcount();

                        if($_return_productscounts > 0)
                        {
                            $_return_products_details    =   $GLOBALS['db']->fetchlist($_return_products);
                            $return_products_details     =   [];
                            foreach($_return_products_details as $pId => $product)
                            {
                                $return_products_details[$pId]['id']                  =   intval($product['id']) ;
                                $return_products_details[$pId]['name']                =   $product['name'] ;
                                $return_products_details[$pId]['price']               =   $product['price'] ;
                                $return_products_details[$pId]['img']                 =   ($product['img'] == "") ? $this->getDefaults("url").$this->getDefaults("img-default-product") : $this->getDefaults("url").$product['img'];
                                $return_products_details[$pId]['quantity']            =   $product['quantity'] ;
                                $return_products_details[$pId]['indications']          = $product['indications'] ?? ' ' ;
                                $return_products_details[$pId]['composition']          = $product['composition'] ?? ' '  ;
                                $return_products_details[$pId]['product_specification']= $product['product_specification'] ?? ' '  ;
                                $return_products_details[$pId]['dose']                 = $product['dose'] ?? ' '  ;
                                $return_products_details[$pId]['How_to_use']           = $product['How_to_use'] ?? ' '  ;
                                $return_products_details[$pId]['the_expected_results'] = $product['the_expected_results'] ?? ' ' ;
                                $return_products_details[$pId]['video']                = $product['video'] ? 'http://b-sfa.za3bot.com/inc/Classes/'.$_product['video'] : ' ' ;
                                    
                            }
                            $tasks_details[$tId]['product']   =  $return_products_details ;

                            $arr_bills[] = $return  ;
                            $tasks_details[$tId]['bills']        =     $arr_bills;
                            $arr_bills = [] ;
                            // $tasks_details[$tId]['bills']    =     $return;
                        

                        }
                    }

                }elseif($tasks['type'] =="order")
                {
                    $_order         = $GLOBALS['db']->query("SELECT * FROM `orders` WHERE `id` = '".$tasks[type_id]."' ");
                    $_orderscounts  = $GLOBALS['db']->resultcount();
                    if($_orderscounts > 0)
                    {
                        
                        $_order_details = $GLOBALS['db']->fetchitem($_order);
                        $tasks_details[$tId]['tital']          =   "order(".$_order_details['id'].")";
                        $order   = array(
                            "id"            =>      intval($_order_details['id']),
                            "date"          =>      $_order_details['date'],
                            "total"         =>      $_order_details['total'] ?? '0' ,
                            "paid"          =>      $_order_details['paid'] ?? '0' ,
                            "remain"        =>      $_order_details['remain'] ?? '0',
                            "note"          =>      $_order_details['note'] ?? ' ' ,
                        );
                        $_order_products         = $GLOBALS['db']->query("SELECT op.`id`,p.`price`, p.`name_ar` AS name ,op.`quantity` FROM `order_products` op INNER JOIN `products` p ON p.`id` = op.`product_id` WHERE op.`order_id` = '".$tasks['order_id']."'");
                        $_order_productscounts   = $GLOBALS['db']->resultcount();
                        if($_order_productscounts > 0)
                        {
                            $_order_products_details    =   $GLOBALS['db']->fetchlist($_order_products);
                            $order_products_details     =   [];
                            foreach($_order_products_details as $pId => $product)
                            {
                                $order_products_details[$pId]['id']                  =   intval($product['id']) ;
                                $order_products_details[$pId]['name']                =   $product['name'] ;
                                $order_products_details[$pId]['price']               =   $product['price'] ;
                                $order_products_details[$pId]['img']                 =   ($product['img'] == "") ? $this->getDefaults("url").$this->getDefaults("img-default-product") : $this->getDefaults("url").$product['img'];
                                $order_products_details[$pId]['quantity']            =   $product['quantity'] ;
                                $order_products_details[$pId]['indications']          = $product['indications'] ?? ' ' ;
                                $order_products_details[$pId]['composition']          = $product['composition'] ?? ' '  ;
                                $order_products_details[$pId]['product_specification']= $product['product_specification'] ?? ' '  ;
                                $order_products_details[$pId]['dose']                 = $product['dose'] ?? ' '  ;
                                $order_products_details[$pId]['How_to_use']           = $product['How_to_use'] ?? ' '  ;
                                $order_products_details[$pId]['the_expected_results'] = $product['the_expected_results'] ?? ' ' ;
                                $order_products_details[$pId]['video']                = $product['video'] ? 'http://b-sfa.za3bot.com/inc/Classes/'.$_product['video'] : ' ' ;
                                    
                            }
                            // $order['product']   =  $order_products_details ;
                            $tasks_details[$tId]['product']   =  $order_products_details ;

                        }else{
                            $tasks_details[$tId]['product']       = [] ;
                            
                        }

                        $arr_bills[] = $order  ;
                        $tasks_details[$tId]['bills']        =     $arr_bills;
                        $arr_bills = [] ;
                        // $tasks_details[$tId]['bills']        =     $order ;
                        // $tasks_details[$tId]['product']        =     $order_products_details ;
                    }

                }elseif($tasks['type'] =="visit")
                {
                    $tasks_details[$tId]['tital']          =   "visit" ;
                    
                    $bills_visit = $GLOBALS['db']->query("SELECT * FROM `installments` WHERE `client_id` = '".$tokenUserId."' AND `rep_id` = '".$tasks[rep_id]."'  ");
                    $bills_visit_count = $GLOBALS['db']->resultcount();
                    if( $bills_visit_count > 0){
                        $bills_visit_data = $GLOBALS['db']->fetchlist();
                        $_visitInstall = [] ;
                        foreach( $bills_visit_data as $k_i=>$_ins ){   
                            
                            $_visitInstall[$k_i]['installment num'] =  $k_i+1 ;
                            $_visitInstall[$k_i]['payment_method']  =  $_ins['payment_method'] ;
                            $_visitInstall[$k_i]['installment']     =  $_ins['installement'] ;
                            $_visitInstall[$k_i]['date']            =  $_ins['date'] ;
                            
                        }
                        // $arr_bills = $_visitInstall  ;
                        $tasks_details[$tId]['bills']        =     $_visitInstall;
                    }

                    // if( $tasks['type'] == 'visit' ){
                        
                        $query_rep = $GLOBALS['db']->query("SELECT * FROM `reps` WHERE `id` = '".$tasks[rep_id]."' LIMIT 1 ");
                        $query_rep_count = $GLOBALS['db']->resultcount();
                        if( $query_rep_count > 0 ){
                            $fetch_rep = $GLOBALS['db']->fetchitem() ;
                            $data['rep_id'] = $fetch_rep['id'] ;
                            $data['name'] = $fetch_rep['name'] ;
                            $data['mobile'] = $fetch_rep['mobile'] ;
                            $data['email'] = $fetch_rep['email'] ;
                        } 
                        $tasks_details[$tId]['rep_details'] = $data ;
                        $arr_bills[] = $data   ;
                        $tasks_details[$tId]['bills']   =     $arr_bills;

                    // }
                    

                }elseif($tasks['type'] == "inventory"){
                    $_orders             = $GLOBALS['db']->query("SELECT * FROM `orders` WHERE `client_id` = '".$tokenUserId."' ");
                    $_orderscounts       = $GLOBALS['db']->resultcount();
                    if($_orderscounts > 0)
                    {
                        $_orders_details = $GLOBALS['db']->fetchlist($_orders);
                        $orders_details = [];
                        $tasks_details[$tId]['tital']   =   "installment";
                        foreach($_orders_details as $oId => $order)
                        {
                            $order_details[$oId]['order_id']       =   intval($order['id']) ;
                            $order_details[$oId]['date']           =   $order['date'] ;
                            $order_details[$oId]['total']          =   $order['total'] ?? '0' ;
                            $order_details[$oId]['paid']           =   $order['paid'] ?? '0' ;
                            $order_details[$oId]['remain']         =   $order['remain'] ;

                            $_order_products         = $GLOBALS['db']->query("SELECT op.`id`,p.`price`, p.`name_ar` AS name ,op.`quantity` FROM `order_products` op INNER JOIN `products` p ON p.`id` = op.`product_id` WHERE op.`order_id` = '".$order['id']."'");
                            $_order_productscounts   = $GLOBALS['db']->resultcount();
                            if($_order_productscounts > 0)
                            {
                                $_order_products_details    =   $GLOBALS['db']->fetchlist($_return_products);
                                $order_products_details     =   [];
                                foreach($_order_products_details as $pId => $product)
                                {
                                    $order_products_details[$pId]['id']                  =   intval($product['id']) ;
                                    $order_products_details[$pId]['name']                =   $product['name'] ;
                                    $order_products_details[$pId]['price']               =   $product['price'] ;
                                    $order_products_details[$pId]['img']                 =   ($product['img'] == "") ? $this->getDefaults("url").$this->getDefaults("img-default-product") : $this->getDefaults("url").$product['img'];
                                    $order_products_details[$pId]['quantity']            =   $product['quantity'] ;
                                    $order_products_details[$pId]['indications']          = $product['indications'] ?? ' ' ;
                                    $order_products_details[$pId]['composition']          = $product['composition'] ?? ' '  ;
                                    $order_products_details[$pId]['product_specification']= $product['product_specification'] ?? ' '  ;
                                    $order_products_details[$pId]['dose']                 = $product['dose'] ?? ' '  ;
                                    $order_products_details[$pId]['How_to_use']           = $product['How_to_use'] ?? ' '  ;
                                    $order_products_details[$pId]['the_expected_results'] = $product['the_expected_results'] ?? ' ' ;
                                    $order_products_details[$pId]['video']                = $product['video'] ? 'http://b-sfa.za3bot.com/inc/Classes/'.$_product['video'] : ' ' ;
                                       
                                }
                                $order_details[$oId]['product']   =  $order_products_details ;
    
                            }
                            
                         }

                        $tasks_details[$tId]['bills']        =     $order_details;
                      
                    }
                }

                }

                $this->terminate('success','',0,$tasks_details);

            }else{
                $tasks_details = [];
                $this->terminate('success','',0,$tasks_details);
            }
            
        }else{
            $this->terminate('error','invalid token',0);
        }
        
    }
 //////////////////////////////////////////////////////////
 public function contact_us(){
    $tokenUserId  = $this->testToken();
    if($tokenUserId != 0)
    {
        $userQuery = $GLOBALS['db']->query(" SELECT * FROM `clients` WHERE `id` = '".$tokenUserId."' LIMIT 1");
        $usersCount = $GLOBALS['db']->resultcount();
        if($usersCount == 1)
        {
            $content  = sanitize($_POST['content']);
            if ($content != ""){
                $GLOBALS['db']->query("INSERT INTO `contact_us` ( `id` ,`client_id` ,`content`,`date`)
                    VALUES ( NULL , ' ".$tokenUserId."' , '".$content."',NOW()) ");
                $this->terminate('success',"",0,['title'=>'done']);
            }else{
                $this->terminate('error',"من فضلك ادخل محتوى تريد ارساله");
            }
        }else{
            $this->terminate('error',"error in token");
        }
        }else{
            $this->terminate('error',"error in token");
            
        }
        
    }

////////////////////////////////////////////////////////////
    public function get_details(){

        $tokenUserId  = $this->testToken();

        if($tokenUserId != 0)
        {
            
            $ordersQuery   = $GLOBALS['db']->query(" SELECT COUNT(*) ,SUM(total) ,SUM(paid) , SUM(remain) FROM `orders` WHERE `client_id` = '".$tokenUserId."' AND `status` != 0  ");
            $validtaskCount   = $GLOBALS['db']->resultcount();
           
            
            if($validtaskCount > 0 ){
                
                $data =  $GLOBALS['db']->fetchitem($ordersQuery) ;
                $details['count_orders']        = $data[0] ;
                
                $details['total']        = $data[1] ;
                $details['paid']        = $data[2] ;
                $details['remain']      = $data[3] ;
            }
            
            $returnsQuery   = $GLOBALS['db']->query(" SELECT * FROM `returns` WHERE `client_id` = '".$tokenUserId."' AND `status` != 0 ");
            $returnsCount   = $GLOBALS['db']->resultcount();
            $details['count_returns']        = $returnsCount ;
            $this->terminate('success','',0,$details);
        }else{
        $this->terminate('error','invalid token',1);
        }



    }

    ////////////////////////////////////////////////
    public function get_all_visits(){

        $tokenUserId  = $this->testToken();
        
        if( $tokenUserId != 0){
            
            if(isset($_POST['pageno'])) {
                $pageno = $_POST['pageno'];
            } else {
                $pageno = 1;
            }
             
            $no_of_records = 10  ;
            $offset = ($pageno-1) * $no_of_records ; 
            $pag = $no_of_records *  $pageno ; 
            
            $_tasks         = $GLOBALS['db']->query("SELECT * FROM `tasks` WHERE  `type` = 'visit' ||`type` = 'visit2' AND  `rep_id` = '".$tokenUserId."' ORDER BY `id` DESC LIMIT $offset, $pag ");
            $_taskscounts   = $GLOBALS['db']->resultcount();
            if($_taskscounts > 0){
                $_tasks_details = $GLOBALS['db']->fetchlist($_tasks);
                $tasks_details = [];
                foreach( $_tasks_details as $tId => $tasks ){

                    $_client         = $GLOBALS['db']->query("SELECT * FROM `clients` WHERE `status` = '1' AND `id` = '".$tasks['client_id']."' LIMIT 1");
                    $_clientcounts   = $GLOBALS['db']->resultcount();
                    $client          = $GLOBALS['db']->fetchitem($_client);
                    $tasks_details[$tId]['id']               = intval($tasks['id']) ;
                    $tasks_details[$tId]['type']             = $tasks['type'] ?? '';
                    $tasks_details[$tId]['type_id']          = $tasks['type_id'] ?? '';
                    $tasks_details[$tId]['date']             = $tasks['date'] ?? '';
                    $tasks_details[$tId]['client']           = $client['name'] ?? '';
                    $tasks_details[$tId]['lon']              = $client['lon'] ?? '0';
                    $tasks_details[$tId]['lat']              = $client['lat'] ?? '0';
                    $tasks_details[$tId]['mobile']           = $client['mobile'] ?? '';
                    $tasks_details[$tId]['status']           = $client['status'] ?? '';
                }

                $this->terminate('success','',0,$tasks_details);
            }
        }
    }

//////////////////////////////////////////////////////////
    public function getNotification(){
        $tokenUserId  = $this->testToken();
        
        if( $tokenUserId != 0){
            $notificatonQuery = $GLOBALS['db']->query(" SELECT * FROM `notification` WHERE `user_id` = '".$tokenUserId."' ") ; 
            $notificCount     = $GLOBALS['db']->resultcount($notificatonQuery) ;
            
            if( $notificCount > 0 ){
                
                $notificList      = $GLOBALS['db']->fetchlist(); 
                foreach( $notificList as $k => $notific ){
                    
                    if( $notific['type_user'] == 'client' ){
                        $newquery  = $GLOBALS['db']->query(" SELECT * FROM `clients` WHERE `id` = '".$tokenUserId."' ") ;
                        $fetchName = $GLOBALS['db']->fetchitem() ;
                    }else{
                        $newquery = $GLOBALS['db']->query(" SELECT * FROM `reps` WHERE `id` = '".$tokenUserId."' ") ;
                        $fetchName = $GLOBALS['db']->fetchitem() ;
                    }
                    
                    
                    $all_notification[$k]['id']      =  $notific['id'] ;
                    $all_notification[$k]['user']    =  $fetchName['name'] ;
                    $all_notification[$k]['type']    =  $notific['type'] ;
                    $all_notification[$k]['type_id'] =  $notific['type_id'] ;
                    $all_notification[$k]['date']    =  $notific['date'] ;
                    $all_notification[$k]['time']    =  $notific['time'] ;
                    $all_notification[$k]['msg']     =  $notific['msg'] ;
                    $all_notification[$k]['id']      =  $notific['id'] ;
                }
                $this->terminate('success','',0,$all_notification);        

            }else{
                $this->terminate( "erorr" , "This user not have Notification " , 50 ) ;
            }

        }

    }
///////////////////////////////////////////////////////////
public function rep_start_task()
{
    $system = new SystemLogin();
    $tokenUserId  = $this->testToken();
    if($tokenUserId != 0)
    {
        $task 			        = intval($_POST['task_id']);
        $date 			        = sanitize($_POST['date']);
        $note 			        = sanitize($_POST['note']);
        $start_lat 			    = $_POST['start_lat'] ;
        $start_lon 			    = $_POST['start_lon'] ;

        if( $start_lat == "" ){
            $this->terminate('error','invalid start_lat',1);
        }

        if( $start_lon == "" ){
            $this->terminate('error','invalid start_lon',1);
        }

        if($task != 0)
        {
           
            $validtaskQuery   = $GLOBALS['db']->query(" SELECT * FROM `tasks` WHERE `id` = '".$task."' LIMIT 1");
            // $validtaskQuery   = $GLOBALS['db']->query(" SELECT * FROM `tasks` WHERE `id` = '".$task."' AND `rep_confirm` = '0' AND `update` = '0' LIMIT 1");
            $validtaskCount   = $GLOBALS['db']->resultcount();
            if($validtaskCount = 1)
            {
                
//					if($note != "")
//					{
                    $GLOBALS['db']->query("UPDATE `tasks` 
                                            SET `start` = '1' ,`pause` = '0', `start_time` = NOW() , `start_lat` = '".$start_lat."' ,`start_lon` = '".$start_lon."'  
                                            WHERE `id` = '".$task."'");
                    $this->terminate('success','',0);
                    

//					}else{
//						$this->terminate('error','you must insert note',1);
//					}

            }else{
                $this->terminate('error','invalid task id or task update before',1);
            }
        }else{
            $this->terminate('error','please insert task id',1);
        }


    }else
    {
        $this->terminate('error','invalid token',1);
    }

}


public function rep_arrive_task()
{
    $system = new SystemLogin();
    $tokenUserId  = $this->testToken();
    if($tokenUserId != 0)
    {
        $task 			        = intval($_POST['task_id']);
        $arrive_lat 			= $_POST['start_lat'] ;
        $arrive_lon 			= $_POST['start_lon'] ;

        if( $arrive_lat == "" ){
            $this->terminate('error','invalid arrive_lat',1);
        }

        if( $arrive_lon == "" ){
            $this->terminate('error','invalid arrive_lon',1);
        }

        if($task != 0)
        {
           
            $validtaskQuery   = $GLOBALS['db']->query(" SELECT * FROM `tasks` WHERE `id` = '".$task."' LIMIT 1");
            $validtaskCount   = $GLOBALS['db']->resultcount();
            if($validtaskCount = 1)
            {
                
                    $GLOBALS['db']->query("UPDATE `tasks` 
                                            SET `arrive_lat` = '".$arrive_lat."' ,`arrive_lon` = '".$arrive_lon."', `arrive_time` = NOW() 
                                            WHERE `id` = '".$task."'");
                    $this->terminate('success','',0);

            }else{
                $this->terminate('error','invalid task id or task update before',1);
            }
        }else{
            $this->terminate('error','please insert task id',1);
        }


    }else
    {
        $this->terminate('error','invalid token',1);
    }

}



public function get_version()
{
    $system = new SystemLogin();
    $tokenUserId  = $this->testToken();
    if($tokenUserId != 0)
    {
        $ver = ['version' => '2.1' ]  ;
        $this->terminate('success',"",0,$ver);

    }else
    {
        $this->terminate('error','invalid token',1);
    }

}


public function client_rate_task()
	{
		$tokenUserId  = $this->testToken();
		if($tokenUserId != 0)
		{
			$task_id   = intval($_POST['task_id']);
			$note      = sanitize($_POST['note']);
			$rate      = floatval($_POST['rate']);
            $paid      = floatval($_POST['paid']);
            
			if($task_id != 0)
			{
				if($note != "")
				{
					if($rate != 0)
					{
                            $task         = $GLOBALS['db']->query("SELECT * FROM `tasks` WHERE `id` = '".$task_id."'");
                            $taskcounts   = $GLOBALS['db']->resultcount();
                            if($taskcounts == 1 )
                            {
                                $GLOBALS['db']->query(" UPDATE `tasks` SET `c_confirm` = '1' , `client_rate`= '".$rate."' ,`client_note`= '".$note."' ,`paid`= '".$paid."' WHERE `id` = '".$task_id."' ");
                                $this->terminate('success',"",0);

                            }else{ $this->terminate('error','invald task id',0); }
                        
					}else{ $this->terminate('error','insert rate',0); }
				}else{ $this->terminate('error','insert note',0); }
			}else{ $this->terminate('error','insert task id',0); }
		}else{ $this->terminate('error','invalid token',0); }

	}
public function rep_pause_task()
{
    $system = new SystemLogin();
    $tokenUserId  = $this->testToken();
    if($tokenUserId != 0)
    {
        $task 			        = intval($_POST['task_id']);
        $note 			        = sanitize($_POST['note']);
        $pause_lat 			        = sanitize($_POST['pause_lat']);
        $pause_lon 			        = sanitize($_POST['pause_lon']);

        if($pause_lat == "" ){
            $this->terminate('error','you must insert lat',1);
        }

        if($pause_lon == "" ){
            $this->terminate('error','you must insert lon',1);
        }

        if($task != 0)
        {
            $validtaskQuery   = $GLOBALS['db']->query(" SELECT * FROM `tasks` WHERE `id` = '".$task."' AND `rep_confirm` = '0' AND `update` = 'not' LIMIT 1");
            $validtaskCount   = $GLOBALS['db']->resultcount();
            if($validtaskCount == 1)
            {

                if($note != "")
                {
                    $GLOBALS['db']->query("UPDATE `tasks` SET `start` = '0', `pause` = '1'  , `pause_time` = NOW() ,`pause_lat` = '".$pause_lat."',`pause_lon` = '".$pause_lon."', `reason` ='".$note."' WHERE `id` = '".$task."'");
                    
                    $message = " تم استئناف الطلب ";
                    $key = 'AAAAcoSecRw:APA91bETIMPBWpSW13Ig5uJ9XYGCuqxF8UtNojfm2dBFK6jso8JzCfQOwBZZq3r5nf0uidjFFrFcG7wk8lwv7_8fxOkONRx6BnCrtE5IIHDs2_JP5oxF6mfL0FzGl4WAaQOOhSamApe5';
                    $this->sent_notification('rep',$tokenUserId, $message ,$key ) ;

                    $this->terminate('success','',0);
                    
                }else{
                    $this->terminate('error','you must insert note',1);
                }

            }else{
                $this->terminate('error','invalid task id or task update before',1);
            }
        }else{
            $this->terminate('error','please insert task id ',1);
        }


    }else
    {
        $this->terminate('error','invalid token',1);
    }

}
public function rep_cancel_task()
{
    $system = new SystemLogin();
    $tokenUserId  = $this->testToken();
    if($tokenUserId != 0)
    {
        $task 			        = intval($_POST['task_id']);
        $note 			        = sanitize($_POST['note']);
        if($task != 0)
        {
            $validtaskQuery   = $GLOBALS['db']->query(" SELECT * FROM `tasks` WHERE `id` = '".$task."' AND `rep_confirm` = '0'  LIMIT 1");
            $validtaskCount   = $GLOBALS['db']->resultcount();
            if($validtaskCount = 1)
            {

                if($note != "")
                {
                    $GLOBALS['db']->query("UPDATE `tasks` SET `update` = 'rep' ,`rep_confirm` = '1' , `update_time` = NOW() , `notes` ='".$note."' WHERE `id` = '".$task."'");
                    $this->terminate('success','',0);
                    $message = "تم انهاء الطلب بنجاح";
                     $key = 'AAAAcoSecRw:APA91bETIMPBWpSW13Ig5uJ9XYGCuqxF8UtNojfm2dBFK6jso8JzCfQOwBZZq3r5nf0uidjFFrFcG7wk8lwv7_8fxOkONRx6BnCrtE5IIHDs2_JP5oxF6mfL0FzGl4WAaQOOhSamApe5';
                    $this->sent_notification('rep',$tokenUserId, $message ,$key ) ;

                }else{
                    $this->terminate('error','you must insert note',1);
                }

            }else{
                $this->terminate('error','invalid task id',1);
            }
        }else{
            $this->terminate('error','please insert task id',1);
        }


    }else
    {
        $this->terminate('error','invalid token',1);
    }
    
}

public function rep_postpone_task()
{
    $system = new SystemLogin();
    $tokenUserId  = $this->testToken();
    
    if($tokenUserId != 0)
    {
        $task 		=   intval($_POST['task_id']);
        $note 		=   sanitize($_POST['note']);
        $arrive     =   intval($_POST['arrive']);
        $pos_lat    =   floatval($_POST['lat']);
        $pos_lon    =   floatval($_POST['lon']);
        $postpone_date = intval($_POST['postpone_date']);

        // if($arrive == '' ){   $this->terminate('error','invalid arrive status',1); }
        if($pos_lat == 0 || empty($pos_lat) ){  $this->terminate('error','invalid lat',1);           }
        if($pos_lon == 0 || empty($pos_lon) ){  $this->terminate('error','invalid lon',1);           }
        if($postpone_date == 0 || empty($pos_lon) )
        {
            $this->terminate('error','postpone_date',1);        
        }else{
            $_date = date('Y-m-d', $postpone_date ) ;
        }
        
        if($task != 0)
        {
            
            $validtaskQuery   = $GLOBALS['db']->query(" SELECT * FROM `tasks` WHERE `id` = '".$task."' AND `rep_confirm` = '0'  LIMIT 1");
            $validtaskCount   = $GLOBALS['db']->resultcount();
            if($validtaskCount == 1)
            {
                $_task = $GLOBALS['db']->fetchitem($validtaskQuery) ;

                if($note != "")
                {
                    $GLOBALS['db']->query("INSERT INTO `tasks`
                    (`id`, `client_id`, `rep_id`, `type`, `type_id`, `date`, `lon`, `lat` ) 
                    VALUES 
                    (NULL ,'".$_task[client_id]."', '".$_task[rep_id]."' ,'".$_task[type]."','".$_task[type_id]."','".$_date."','".$_task[lat]."','".$_task[lon]."')");

                    $pos_task_id = $GLOBALS['db']->fetchLastInsertId();

                    $GLOBALS['db']->query("UPDATE `tasks` 
                    SET `postpone_id` = '".$pos_task_id."' , `update` = 'rep' ,`start` = '0' ,`pause` = '0' ,`rep_confirm` = '0',`c_confirm` = '0' , `postpone` = '1' , `postpone_time` = NOW() , `reason` ='".$note."' , `arrive`='".$arrive."',`pos_lat` = '".$pos_lat."' , `pos_lon`='".$pos_lon."' WHERE `id` = '".$task."'");
                    $this->terminate('success','',0);
                    $message = "تم تأجيل الطلب بنجاح";
                    $key = 'AAAAcoSecRw:APA91bETIMPBWpSW13Ig5uJ9XYGCuqxF8UtNojfm2dBFK6jso8JzCfQOwBZZq3r5nf0uidjFFrFcG7wk8lwv7_8fxOkONRx6BnCrtE5IIHDs2_JP5oxF6mfL0FzGl4WAaQOOhSamApe5';
                    $this->sent_notification('rep',$tokenUserId, $message ,$key ) ;

                }else{
                    $this->terminate('error','you must insert note',1);
                }
            }else{
                $this->terminate('error','invalid task id',1);
            }
        }else{
            $this->terminate('error','please insert task id',1);
        }


    }else
    {
        $this->terminate('error','invalid token',1);
    }
    
}
public function conclution_task(){
    $system = new SystemLogin();
    $tokenUserId  = $this->testToken();
    if($tokenUserId != 0){
        $task 			        = intval($_POST['task_id']);
        $conc 			        = sanitize($_POST['conc']);
        if( $conc == ""  ){
            $this->terminate('error','conc valid',1);        
        }

        if($task != 0)
        {
            $validtaskQuery   = $GLOBALS['db']->query(" SELECT * FROM `tasks` WHERE `id` = '".$task."' LIMIT 1");
            $task_details     = $GLOBALS['db']->fetchitem($validtaskQuery);
            $validtaskCount   = $GLOBALS['db']->resultcount();
            if($validtaskCount = 1){
                $GLOBALS['db']->query("UPDATE `tasks` SET `reason` ='".$conc."' WHERE `id` = '".$task."' ");
            }

            $this->terminate('success','',0);
        }

    }
}
public function rep_confirm_task()
{
    $system = new SystemLogin();
    $tokenUserId  = $this->testToken();
    if($tokenUserId != 0)
    {
        $task 			        = intval($_POST['task_id']);
        $conc 			        = sanitize($_POST['note']);
        $paid 			        = floatval($_POST['paid']);
        $con_lat 			    = floatval($_POST['conf_lat']);
        $con_lon 			    = floatval($_POST['conf_lon']);

        if($task != 0)
        {
            $validtaskQuery   = $GLOBALS['db']->query(" SELECT * FROM `tasks` WHERE `id` = '".$task."' AND `rep_confirm` = '0'  LIMIT 1");
            $task_details     = $GLOBALS['db']->fetchitem($validtaskQuery);
            $validtaskCount   = $GLOBALS['db']->resultcount();
            if($validtaskCount = 1)
            {
 
                if($con_lat == 0)
                {
                    $this->terminate('error','you must insert lat',1);
                }

                if($con_lon == 0)
                {
                    $this->terminate('error','you must insert lon',1);
                }

                $GLOBALS['db']->query("UPDATE `tasks` SET `rep_confirm` = '1' , `confirm_time` = NOW() ,`conf_lat` = '".$con_lat."',`conf_lon` = '".$con_lon."' , `reason` ='".$conc."' , `notifications_done` = 1  WHERE `id` = '".$task."'");
                if($task_details['type'] == "return" )
                {
                    $GLOBALS['db']->query("UPDATE `returns` SET `notifications_done` = 1   WHERE `id` = '".$task_details[type_id]."'");
                    $key = 'AAAAcoSecRw:APA91bETIMPBWpSW13Ig5uJ9XYGCuqxF8UtNojfm2dBFK6jso8JzCfQOwBZZq3r5nf0uidjFFrFcG7wk8lwv7_8fxOkONRx6BnCrtE5IIHDs2_JP5oxF6mfL0FzGl4WAaQOOhSamApe5';
                    $message = "تم استلام المرتجعات بنجاح";
                    $this->sent_notification('rep',$tokenUserId, $message ,$key ) ;
                }elseif($task_details['type'] == "visit" )
                {
                    $GLOBALS['db']->query("UPDATE `tasks` SET  `update_time` = NOW() ,`notifications_done` = 1  WHERE `id` = '".$task_details['type_id']."'");
                    $message = "تمت تعديل الزياره";
                    $key = 'AAAAcoSecRw:APA91bETIMPBWpSW13Ig5uJ9XYGCuqxF8UtNojfm2dBFK6jso8JzCfQOwBZZq3r5nf0uidjFFrFcG7wk8lwv7_8fxOkONRx6BnCrtE5IIHDs2_JP5oxF6mfL0FzGl4WAaQOOhSamApe5';
                    $this->sent_notification('rep',$tokenUserId, $message ,$key ) ;
                }elseif($task_details['type'] == "installment")
                {
                    if($paid !=0)
                    {
                        $orderQuery = $GLOBALS['db']->query(" SELECT * FROM `orders` WHERE `id` = '".$task_details['type_id']."' LIMIT 1");
                        $orderCount = $GLOBALS['db']->resultcount();
                        if($orderCount == 1)
                        {
                            $_order = $GLOBALS['db']->fetchitem($orderQuery);

                            if($paid > $_order['remain'])
                            {
                                $order_paid = $_order['paid']  + $paid ;
                                $remain     = $_order['total'] - $order_paid ;
                                $GLOBALS['db']->query("UPDATE `orders` SET `rep_confirm` = '1' ,`remain` = '".$remain."' ,`paid` = '".$order_paid."' , `date_recieved` = NOW()  WHERE `id` = '".$task_details['type_id']."'");
                
                                $GLOBALS['db']->query(" UPDATE `installments` 
                                SET `date`=now(), `installement`='".$paid."',`payment_method`='cash' 
                                WHERE `order_id` = '".$task_details['type_id']."' AND `installement` = 0 limit 1
                                ");

                                if($remain == 0 ){
                                    $GLOBALS['db']->query(" DELETE FROM `installments`
                                                                WHERE `order_id` = '".$task_details['type_id']."' AND `installement` = 0  ");
                                }

                                $message = "تم تعديل الاقساط بنجاح ";
                                $key='AAAAcoSecRw:APA91bETIMPBWpSW13Ig5uJ9XYGCuqxF8UtNojfm2dBFK6jso8JzCfQOwBZZq3r5nf0uidjFFrFcG7wk8lwv7_8fxOkONRx6BnCrtE5IIHDs2_JP5oxF6mfL0FzGl4WAaQOOhSamApe5';
                                $this->sent_notification('rep',$tokenUserId, $message ,$key) ;
                        }else{
                                $this->terminate('error',"money paid more than remain",1);
                            }

                        }else{
                            $this->terminate('error',"invaled order id",1);
                        }

                    }else{
                        $this->terminate('error','you must insert paid money',1);
                    }
                }elseif($task_details['type'] == "order")
                {
                    if($paid !=0)
                    {
                        $orderQuery = $GLOBALS['db']->query(" SELECT * FROM `orders` WHERE `id` = '".$task_details['type_id']."' LIMIT 1");
                        $orderCount = $GLOBALS['db']->resultcount();
                        if($orderCount == 1)
                        {
                            $_order = $GLOBALS['db']->fetchitem($orderQuery);

                            if($paid > $_order['remain'])
                            {
                                $order_paid = $_order['paid']  + $paid ;
                                $remain     = $_order['total'] - $order_paid ;
                                $GLOBALS['db']->query("UPDATE `orders` SET `rep_confirm` = '1' ,`remain` = '".$remain."' ,`paid` = '".$order_paid."' , `date_recieved` = NOW(), `status` = 2  WHERE `id` = '".$task_details['type_id']."'");
                                $message = " تمت العمليه بنجاح ";
                                $key='AAAAcoSecRw:APA91bETIMPBWpSW13Ig5uJ9XYGCuqxF8UtNojfm2dBFK6jso8JzCfQOwBZZq3r5nf0uidjFFrFcG7wk8lwv7_8fxOkONRx6BnCrtE5IIHDs2_JP5oxF6mfL0FzGl4WAaQOOhSamApe5';
                                $this->sent_notification('rep',$tokenUserId, $message,$key ) ;
                            }else{
                                $this->terminate('error',"money paid more than remain",1);
                            }

                        }else{
                            $this->terminate('error',"invaled order id",1);
                        }
                    }

                }elseif($task_details['type'] == "inventory"){

                    $item_id = intval( $_POST['item'] ) ;
                    if( $item_id > 0 ){
                        $orderQuery = $GLOBALS['db']->query(" SELECT * FROM `products` WHERE `id` = '".$item_id."' LIMIT 1 ");
                        $orderCount = $GLOBALS['db']->resultcount();
                        if( $orderCount > 0 ){
                            $orderDetails = $GLOBALS['db']->fetchitem($orderQuery) ;

                            $inventory['stock'] =  $orderDetails['stock'] ;
                            $inventory['remain'] =  $orderDetails['remain'] ;
                            $this->terminate('success','',0,$inventory);
                            $message = "لديك زيارده جرد ";
                            $key='AAAAcoSecRw:APA91bETIMPBWpSW13Ig5uJ9XYGCuqxF8UtNojfm2dBFK6jso8JzCfQOwBZZq3r5nf0uidjFFrFcG7wk8lwv7_8fxOkONRx6BnCrtE5IIHDs2_JP5oxF6mfL0FzGl4WAaQOOhSamApe5';
                            $this->sent_notification('rep',$tokenUserId, $message ,$key ) ;
                        }else{
                            $this->terminate('error','this item not correct',1);
                        }

                    }else{
                        $this->terminate('error','you must insert item',1);
                    }
                }

                $this->terminate('success','',0);

                

            }else{
                $this->terminate('error','invalid task id',1);
            }
        }else{
            $this->terminate('error','please insert task id',1);
        }


    }else
    {
        $this->terminate('error','invalid token',1);
    }
    
}
public function rep_pay_money()
{
    $tokenUserId  = $this->testToken();
    if($tokenUserId != 0)
    {
        $order_id    = intval($_POST['order_id']);
        $paid        = floatval($_POST['paid']);
        $type_method = sanitize($_POST['type_method']);
        $note = sanitize($_POST['note']);

        if($order_id == 0)
        {
            $this->terminate('error','you must insert order_id',1);
        }else
        {
            if($paid == 0 )
            {
                $this->terminate('error','you must paid > 0',1);
            }else
            {
                $orderQuery = $GLOBALS['db']->query(" SELECT * FROM `orders` WHERE `id` = '".$order_id."' LIMIT 1");
                $orderCount = $GLOBALS['db']->resultcount();
                if($orderCount == 1)
                {
                    $_order = $GLOBALS['db']->fetchitem() ;

                    $GLOBALS['db']->query(" UPDATE `installments` 
                    SET `date`=now(), `installement`='".$paid."',`payment_method`='".$type_method."' ,`status` = 1
                    WHERE `order_id` = '".$order_id."' AND `installement` = 0 AND `status` = 0 limit 1 ");

                    $total_paid = $_order['paid'] + $paid ;
                    $remain = $_order['total'] - $total_paid ;

                    if( $remain == 0 ){
                        
                        $GLOBALS['db']->query("UPDATE LOW_PRIORITY `orders` SET
                        `remain`     ='".$remain."' ,
                        `paid`       ='".$total_paid."',
                        `status` = '2'
                        WHERE `id` = '".$order_id."' ");
                    }else{
                        $GLOBALS['db']->query("UPDATE LOW_PRIORITY `orders` SET
                        `remain`     ='".$remain."' ,
                        `paid`       ='".$total_paid."'
                        WHERE `id` = '".$order_id."' ");
                    }
                    $client_query       = $GLOBALS['db']->query(" SELECT `credit` FROM `clients` WHERE `id` ='".$_order[client_id]."'  ");
                    $client_old_credit  = $GLOBALS['db']->fetchitem() ;
                    $client_new_credit  = $client_old_credit['credit'] - $total_paid ;
                    $update_credit      = $GLOBALS['db']->query(" UPDATE `clients` SET `credit` = '".$client_new_credit."' WHERE `id` = '".$_order[client_id]."' ");

                    if($remain == 0 ){
                        $GLOBALS['db']->query(" DELETE FROM `installments`
                                                WHERE `order_id` = '".$order_id."' AND `installement` = 0  AND `status` = 0 ");

                        $GLOBALS['db']->query(" DELETE FROM `tasks`
                        WHERE `type_id` = '".$order_id."' AND `notifications_done` = 0 AND `type` != 'order' ");

                        // $GLOBALS['db']->query(" UPDATE LOW_PRIORITY `orders`
                        // SET `status` = '2'
                        // WHERE `id`   = '".$order[id]."' LIMIT 1   ");
                    }

                    $install_query = $GLOBALS['db']->query("SELECT SUM(installement) AS total_install FROM `installments` WHERE `order_id` = '".$order_id."' AND `status` = 0 "); 
                    $ins_count    = $GLOBALS['db']->resultcount() ;
                    $fetch_ist = $GLOBALS['db']->fetchitem();
                    $total_installment = $fetch_ist;
                    
                    if(!$ins_count == NULL ){
                        
                        $total_installment = $fetch_ist['total_install'];

                        $orders_query = $GLOBALS['db']->query("SELECT `client_id`,`rep_id`,`total`, `paid` ,`remain` FROM `orders` WHERE `id`='".$order_id."' ");
                        $fetch_order  = $GLOBALS['db']->fetchitem();
                        $count_order  = $GLOBALS['db']->resultcount();
                        if( $count_order > 0 ){
                            $_total    = $fetch_order['total'] ;
                            $_client_id = $fetch_order['client_id'] ;
                            $_rep_id    = $fetch_order['rep_id'] ;
                            $date = date('Y-m-d',strtotime( '1 month',strtotime(date('Y-m-d')) ) ) ;
                            if( $_remain > $total_installment ){
                                $GLOBALS['db']->query("INSERT INTO `installments`
                                (`id`, `client_id`, `rep_id`, `order_id`, `date`, `installement`, `money_paid`, `payment_method`, `c_verified`, `c_paid`, `rep_confirm`, `c_confirm`, `invoice`, `notifications_done`, `view`, `status`)
                                VALUES ( NULL ,'".$_client_id."','".$_rep_id."','".$order_id."','".$date."',0,0,' ',0,0,0,0,' ',0,0,0)" ) ;
                            
                            }
                        }
                    
                    
                    }
                    

                    /////////
                    
                    $query 		= $GLOBALS['db']->query("SELECT * FROM `notifications` WHERE `user_type`  = 'client' AND `user_id` = '".$_order['client_id']."'");
                    $queryTotal = $GLOBALS['db']->resultcount();
                    if($queryTotal > 0){
                        $tokens = $GLOBALS['db']->fetchlist($query);
                        foreach( $tokens as $token){
                            $echo 	= 0;
                            $key 	= 'AAAAw6f14Jg:APA91bGswx0m3sjqrXgQ0aO8JzafYfyLQUlr-STzSmlKDwuBzvvaoRghJmrbF3sLZzR6XDZ_8gICtEOyoLU4QW_gEAhsxrDaHXrtWtdNoPyipJr91slP7d5MbwuKiu-w7tJJTzBFAxXK';
                            $msg 	= $_otherData;
    
                            $date = date('Y-m-d');
                            $fields = array
                                (
                                    'to'					=> $token[not_token],
                                    'data'					=> array
                                    (
                                        'type'				=> 'postpone',
                                        'postpone_date'	    => "انت دفعت للمندوب مبلغ بقيمه   ($paid)",
                                        
    
                                    ),
                                    'notification'          => array
                                    (
                                        'title'				=> 'SFA Client',
                                        'text'				=> " انت دفعت للمندوب مبلغ بقيمه  ($paid)" ,
                                        'click_action'		=> 'home_activity',
                                        'sound'				=> 'true',
                                        'icon'				=> 'logo'
                                    )
                                );
                            $headers = array
                            (
                                'Authorization: key='. $key,
                                'Content-Type: application/json'
                            );
                            $ch = curl_init();
                            curl_setopt( $ch,CURLOPT_URL, 'https://fcm.googleapis.com/fcm/send' );
                            curl_setopt( $ch,CURLOPT_POST, true );
                            curl_setopt( $ch,CURLOPT_HTTPHEADER, $headers );
                            curl_setopt( $ch,CURLOPT_RETURNTRANSFER, true );
                            curl_setopt( $ch,CURLOPT_SSL_VERIFYPEER, false );
                            curl_setopt( $ch,CURLOPT_POSTFIELDS, json_encode( $fields ) );
                            $result = curl_exec($ch );
                            curl_close( $ch );
                        }
            
                    }
                    /////////
                    $this->terminate('success','',0);
                }else
                {
                    $this->terminate('error','invalid order',1);
                }
            }
        }
    }
}

///////////////////////////////////////////////////////////
    public function get_order()
        {
            $tokenUserId  = $this->testToken();
            $lang = sanitize($_POST['lang']) ;
            $date = intval( $_POST['date'] ) ;

            if( $lang == ""){
                $this->terminate('error','',0,"Must Enter Laguage ");
            }
            if($tokenUserId != 0)
            {
                $complete           = intval($_POST['complete']);
                $queryStart 		= intval($_POST['p']);
                // $queryLimit 		= " LIMIT ".($queryStart * $this->getDefaults("pagination")) ." , ". $this->getDefaults("pagination");
                // $_orderquery         = $GLOBALS['db']->query("SELECT o.*  FROM `tasks` t INNER JOIN `orders` o ON t.`type_id` = o.`id` WHERE t.`status` = '1'AND  t.`type` = 'order' AND o.`delivered` = '".$complete."' AND t.`rep_id` = '".$tokenUserId."' ".$queryLimit);
                $user = sanitize($_POST['user']) ;
                if( $user == "client" ){
                    $addwhere2 = " `client_id` = '".$tokenUserId."' " ;
                    if( $date != 0  ){
                        $date = date("Y-m-d", $date);
                        $addwhere1 = " WHERE `date` = '".$date."' AND" ;
                    }else{
                        $addwhere1 = " WHERE " ;
                    }
            
                }elseif( $user == "rep" ){
                    // $addwhere2 = " ( `rep_id` = '".$tokenUserId."' AND `by` = 'rep' ) || ( `by` = 'client' ) " ;
                    $addwhere2 = " ( `rep_id` = '".$tokenUserId."' AND `by` = 'rep' ) ||  ( `rep_id` = '".$tokenUserId."' AND `by` = 'client' AND `status` =1  ) " ;
                    if( $date != 0  ){
                        $date = date("Y-m-d", $date);
                        $addwhere1 = " WHERE `date` = '".$date."' AND " ;
                    }else{
                        $addwhere1 = " WHERE " ;
                    }
                    
                }else{
                    $this->terminate('error','',0, "يجب اختيار نوع المستخدم مندوب او عميل ");
                }
                

                $_orderquery         = $GLOBALS['db']->query("SELECT * FROM `orders` $addwhere1 $addwhere2");
                $_orderscounts       = $GLOBALS['db']->resultcount();
                if($_orderscounts > 0)
                {
                    $_orders = $GLOBALS['db']->fetchlist();
                    $orders  = [];
                    
                    foreach($_orders as $oId => $order)
                    {
                        $or_id = $order['id'] ;
                        $_client         = $GLOBALS['db']->query("SELECT * FROM `clients` WHERE `status` = '1' AND `id` = '".$order['client_id']."' LIMIT 1");
                        $_clientcounts   = $GLOBALS['db']->resultcount();
                        $client          = $GLOBALS['db']->fetchitem($_client);
                        $inst = [] ;
                        if( $order['payment_type'] == 'installment' ){
                            
                            $_get_installments   = $GLOBALS['db']->query("SELECT * FROM `installments` WHERE `order_id` = '".$or_id."' ");
                            $install_Count       = $GLOBALS['db']->resultcount() ;
                            
                            if( $install_Count > 0 ){
                                $fetch_install  = $GLOBALS['db']->fetchlist($_get_installments);
                                foreach( $fetch_install as $ki => $_ins ){
                                    
                                    $_install[$ki]['installment_order_num'] =  $or_id ;
                                    $_install[$ki]['installment num'] =  $ki+1 ;
                                    $_install[$ki]['payment_method'] =  $_ins['payment_method'] ;
                                    $_install[$ki]['installment'] =  $_ins['installement'] ;
                                    $_install[$ki]['date'] =  $_ins['date'] ;
                                    
                                }
                                
                                
                            }else{
                                $_install = [];
                            }
                            
                            
                        }
                        
                        $_order_tasks = $GLOBALS['db']->query("SELECT `id` ,`client_rate` FROM `tasks` WHERE `type_id` ='".$or_id."' AND `type` ='order' LIMIT 1  ");
                        $fetch_task   = $GLOBALS['db']->fetchitem();
                        
                        
                        $orders[$oId]['order_id']           =   intval($or_id) ;
                        $orders[$oId]['task_id']            =   $fetch_task['id'] ?? 0  ;
                        $orders[$oId]['is rate']            =   $fetch_task['client_rate'] ? 1 : 0  ;
                        $orders[$oId]['client']             =   $client['name'] ;
                        $orders[$oId]['rep_id']             =   $client['rep_id'] ;
                        $orders[$oId]['address']            =   $client['address'] ;
                        $orders[$oId]['mobile']             =   $client['mobile'] ;
                        $orders[$oId]['date']               =   $order['date'] ;
                        $orders[$oId]['total']              =   $order['total'] ;
                        $orders[$oId]['paid']               =   $order['paid'] ;
                        $orders[$oId]['remain']             =   $order['remain'] ;
                        $orders[$oId]['payment_type']       =   $order['payment_type'] ;
                        $orders[$oId]['num_of_month']       =   $order['number_of_month'] ;
                        $orders[$oId]['note']               =   $order['note'] ;
                        $orders[$oId]['status']             =   $order['status'] ;

                        // $orders[$oId]['installment_details']  =   $inst ;
                        if( $order['payment_type'] == 'installment' ){
                            $orders[$oId]['num_of_installment'] =   $order['number_of_installment'] ;
                            $orders[$oId]['Num of installment paid'] =  $installCount ?? 0;
                            $orders[$oId]['installment_details']  =   $_install ;
                            $_install = [];
                        }                        
                        $_order_products         = $GLOBALS['db']->query("SELECT p.`id` ,p.`price`,p.`name_ar`,p.`name_en` AS name ,op.`quantity`,op.`status` FROM `order_products` op INNER JOIN `products` p ON p.`id` = op.`product_id` WHERE op.`order_id` = '".$order['id']."'  ");
                        $_order_productscounts   = $GLOBALS['db']->resultcount();
                        
                        if($_order_productscounts > 0)
                        {
                            $_order_products_details    =   $GLOBALS['db']->fetchlist();
                            
                            $order_products_details = [] ;
                            foreach($_order_products_details as $pId => $product)
                            {
                                $order_products_details[$pId]['id']       =   intval($product['id']) ;
                                // $order_products_details[$pId]['name']                =   ($lang == "en")? html_entity_decode($product['name_en']): html_entity_decode($product['name_ar']);
                                if( $lang == 'ar' ){ $order_products_details[$pId]['name'] = $product['name_ar'] ;
                                }else{ $order_products_details[$pId]['name'] = $product['name'] ; }
                                
                                $order_products_details[$pId]['price']               =   $product['price'] ;
                                $order_products_details[$pId]['img']                 =   ($product['img'] == "") ? $this->getDefaults("url").$this->getDefaults("img-default-product") : $this->getDefaults("url").$product['img'];
                                $order_products_details[$pId]['quantity']            =   $product['quantity'] ;
                                
                            }
                            $orders[$oId]['product']   =  $order_products_details ;
                            $order_products_details = [] ;
                        }else{
                            $orders[$oId]['product']   =  [] ;
                        }
                    }
          
                    $this->terminate('success','',0,$orders);
                    
        
                }else{
                    $orders = [];
                    $this->terminate('error','',0, $orders);
                      
                }
        
            }else{
                $this->terminate('error','invalid token',0);
                  
            }

            
            

        }


    
//////////////////////////////////////////////////////////////////////
public function get_returns()
{
    $tokenUserId  = $this->testToken();
    $lang = sanitize($_POST['lang']) ;
    $date = intval( $_POST['date'] ) ;

    if( $lang == ""){
        $this->terminate('error','',0,"Must Enter Laguage ");
    }
    if($tokenUserId != 0)
    {
        // $queryLimit 		= " LIMIT ".($queryStart * $this->getDefaults("pagination")) ." , ". $this->getDefaults("pagination");
        // $_orderquery         = $GLOBALS['db']->query("SELECT o.*  FROM `tasks` t INNER JOIN `orders` o ON t.`type_id` = o.`id` WHERE t.`status` = '1'AND  t.`type` = 'order' AND o.`delivered` = '".$complete."' AND t.`rep_id` = '".$tokenUserId."' ".$queryLimit);
        $user = sanitize($_POST['user']) ;
        if( $user == "client" ){
            $addwhere2 = " `client_id` = '".$tokenUserId."' " ;
            if( $date != 0  ){
                $date = date("Y-m-d", $date);
                $addwhere1 = " WHERE `date` = '".$date."' AND" ;
            }else{
                $addwhere1 = " WHERE " ;
            }
    
        }elseif( $user == "rep" ){
            $addwhere2 = " `rep_id` = '".$tokenUserId."' " ;
            if( $date != 0  ){
                $date = date("Y-m-d", $date);
                $addwhere1 = " WHERE `date` = '".$date."' " ;
            }else{
                $addwhere1 = " WHERE " ;
            }
            
        }else{
            $this->terminate('error','',0, "يجب اختيار نوع المستخدم مندوب او عميل ");
        }
        

        $_orderquery         = $GLOBALS['db']->query("SELECT returns.* , DATE(date) AS dateonly FROM `returns` $addwhere1 $addwhere2");
        $_orderscounts       = $GLOBALS['db']->resultcount();
        if($_orderscounts > 0)
        {
            $_returns = $GLOBALS['db']->fetchlist();
            $returns  = [];
            
            foreach($_returns as $rId => $return)
            {
                $_client         = $GLOBALS['db']->query("SELECT * FROM `clients` WHERE `status` = '1' AND `id` = '".$return['client_id']."' LIMIT 1");
                $_clientcounts   = $GLOBALS['db']->resultcount();
                $client          = $GLOBALS['db']->fetchitem($_client);
                
                $returns[$rId]['return_id']      =   $return['id'] ;
                $returns[$rId]['client']         =   $client['name']       ;
                $returns[$rId]['return_money']   =   $return['return_status_id']       ;
                $returns[$rId]['address']        =   $client['address']    ;
                $returns[$rId]['lat']            =   $client['lat']        ;
                $returns[$rId]['lon']            =   $client['lon']        ;
                $returns[$rId]['mobile']         =   $client['mobile']     ;
                $returns[$rId]['date']           =   $return['dateonly']       ;
                $returns[$rId]['status']         =   $return['status']     ;
                $returns[$rId]['return_status_id']  =   $return['return_status_id']     ;
                $returns[$rId]['note']           =   $return['note']   ?? " "  ;
                
 
                $_return_products         = $GLOBALS['db']->query("SELECT op.`id` ,p.`price`,p.`name_ar`,p.`name_en` AS name ,op.`quantity`,op.`status` FROM `returns_products` op INNER JOIN `products` p ON p.`id` = op.`product_id` WHERE op.`return_id` = '".$return['id']."'");
                $_return_productscounts   = $GLOBALS['db']->resultcount();
                if($_return_productscounts > 0)
                {
                    $fetch_return_products    =   $GLOBALS['db']->fetchlist();
                    foreach($fetch_return_products as $pId => $product)
                    {   
                        
                        $return_products_details[$pId]['id']       =   intval($product['id']) ;
                        if( $lang == 'ar' ){
                            $return_products_details[$pId]['name'] = $product['name_ar'] ;
                        }else{
                            $return_products_details[$pId]['name'] = $product['name_ar'] ;
                        }
                        $return_products_details[$pId]['price']               =   $product['price'] ;
                        $return_products_details[$pId]['img']                 =   ($product['img'] == "") ? $this->getDefaults("url").$this->getDefaults("img-default-product") : $this->getDefaults("url").$product['img'];
                        $return_products_details[$pId]['quantity']            =   $product['quantity'] ;
                    
                    }

                    $_return_products         = $GLOBALS['db']->query("SELECT SUM(total_price) AS total FROM `returns` WHERE `id` = '".$return['id']."'");
                    $_return_productscounts   = $GLOBALS['db']->resultcount();
                    $_return_total = $GLOBALS['db']->fetchitem() ;
                    $returns[$rId]['total']     =  $_return_total['total']  ;

                    $returns[$rId]['product']   =  $return_products_details ;
                    $return_products_details = [] ;
                }else{
                    $returns[$rId]['product']   = [] ;
                }
            }
            $this->terminate('success','',0,$returns);
            

        }else{
            $returns = [];
            $this->terminate('error','',0, "'".$user."' عفوا لا يوجد طلبات ف قاعده البيانات لذلك");
              
        }

    }else{
        $this->terminate('error','invalid token',0);
          
    }

    
    

}


//////////////////////////////////////////////////////////////////////
        public function setProduct_details(){

            $tokenUserId  = $this->testToken();
            $visit_id     = $_POST['visit_id'];
            $product_id   = $_POST['product_id'];
            $receive      = $_POST['receive'];
            $note         = $_POST['note'] ;

            if($tokenUserId != 0)
            {
                if( $visit_id != '' ){
                    if( $product_id != ''  ){

                        $items  = explode(",",$product_id);
                        if(is_array($items))
                        {
                            foreach( $items as $item_id ){
                                $query_insert = $GLOBALS['db']->query(" INSERT INTO `product_datails`
                                                                (`id`, `visit_id`, `product_id`, `rep_id`, `date`, `receive`,`note`)
                                                                VALUES 
                                                                (NULL,'".$visit_id."','".$item_id."','".$tokenUserId."',NOW(),'".$receive ."','note')  ");
                                
                            }
                            $this->terminate('success','',0);
                        }

                    }else{
                        $this->terminate('error','enter product_id ',0) ; 
                    }
                }else{
                    $this->terminate('error','enter visit_id ',0) ;    
                }
            }else
            {
                $this->terminate('error','invalid token',0);    
            }
        }
//////////////////////////////////////////////////////////////////////

    public function status_notification(){

        $tokenUserId  = $this->testToken();
        $status       = $_POST['status'] ;
        if( $status =='' ){
            $this->terminate('error','invalid token',0);  
        }else{
            $status_query = $GLOBALS['db']->query(" UPDATE `notifications` 
                                                SET `receive_status`='".$status."' 
                                                WHERE `user_id` = '".$tokenUserId."' AND `user_type` = 'client' ") ;
            $s = $status == 1 ? 'On' : 'Off' ;
            $msg = 'status notification '.$s ;
            $this->terminate('success',$msg,0);
        }
    }

// ///////////////////////////////////////////////////////////////////
public function get_rep_customers()
	{
        $tokenUserId  = $this->testToken();  
        $option_client = intval( $_POST['client_id'] ) ;
        if( $option_client != 0 ){
            $where2 = " AND `id` = '".$option_client."' " ;
        }

		if($tokenUserId != 0)
        {
            $start 		      = ( intval($_POST['p']) == 0)? 0 : intval($_POST['p']);
		    $queryLimit 	  = " LIMIT ".(intval($start) * $this->getDefaultPag("pagination")) ." , ". $this->getDefaultPag("pagination");

            $ddate = date('Y-m-d');
            $taskQuery        = $GLOBALS['db']->query("SELECT clients.`city` FROM `tasks` INNER JOIN `clients` ON clients.id = tasks.client_id WHERE tasks.rep_id = '".$tokenUserId."' AND tasks.`type` = 'visit2' AND DATE(tasks.date) = '".$ddate."' ORDER BY clients.id ASC LIMIT 1");
            $taskcounts   = $GLOBALS['db']->resultcount($taskQuery);
            if( $taskcounts  > 0){
                $_task_details = $GLOBALS['db']->fetchitem($taskQuery);
                $city          = $_task_details['city'] ;
                $where3        = " AND `city` = '".$city."'  " ; 
            }else{
                $where3          = "" ;
                $limit = " LIMIT 50 ";
            }

			$_clients         = $GLOBALS['db']->query("SELECT * FROM `clients` WHERE `status` = '1'".$where2.$where3." AND `governorate` IN ( SELECT `governorate_id` FROM `gonvernrate_reps`  where rep_id='".$tokenUserId."' group by governorate_id  ) $limit ");
            $_clientscounts   = $GLOBALS['db']->resultcount();
			if($_clientscounts > 0)
			{
                
				$_clients_details = $GLOBALS['db']->fetchlist($_clients);
				$client_details = [];
				foreach($_clients_details as $cId => $client)
				{
                    $_kind = $GLOBALS['db']->query("SELECT `name_en` FROM `kind` WHERE `id` = '".$client['kind']."' LIMIT 1  ");
                    $kind          = $GLOBALS['db']->fetchitem($_kind);

                    $_city = $GLOBALS['db']->query("SELECT `name_ar` FROM `cities` WHERE `id` = '".$client['city']."' LIMIT 1  ");
                    $city          = $GLOBALS['db']->fetchitem($_kind);

                    $govQuery = $GLOBALS['db']->query(" SELECT `name_ar` FROM `governorates` WHERE `id` = '".$client['governorate']."' ");
                    $gov		 = $GLOBALS['db']->fetchitem();

					$client_details[$cId]['id']             =     intval($client['id']);
					$client_details[$cId]['name']           =     $client['name'] . " ( " . $kind['name_en'] . " ) ";
					$client_details[$cId]['email']          =     $client['email'];
					$client_details[$cId]['kind']           =     $kind['name_en'];
					$client_details[$cId]['lat']            =     $client['lat'] ?? 0.00000000 ;
					$client_details[$cId]['lon']            =     $client['lon'] ?? 0.00000000 ;
					$client_details[$cId]['mobile']         =     $client['mobile'];
					$client_details[$cId]['governorate']    =     $gov['name_ar'] ;
					$client_details[$cId]['city']           =     $client['city'];
					$client_details[$cId]['avatar']         =     ($client["avatar"] == "") ? $this->getDefaults("url").$this->getDefaults("img-default-avatar") : $this->getDefaults("url").$client['avatar'];
					$client_details[$cId]['address']        =     $gov['name_ar'] . " - " .$city['name_ar']." - "  . $client['address'];
					$client_details[$cId]['block']          =     $client['block'];

					$_orders                                = $GLOBALS['db']->query("SELECT * FROM `orders` WHERE `client_id` = '".$client['id']."' AND `rep_id` = '".$tokenUserId."'");
					$_orderscounts                          = $GLOBALS['db']->resultcount();
					$client_details[$cId]['orders_number']  =     $_orderscounts;

                    $_returns                                = $GLOBALS['db']->query("SELECT SUM(`total_price`) FROM `returns` WHERE `client_id` = '".$client['id']."' AND `rep_id` = '".$tokenUserId."'");
                    $_returnscounts                          = $GLOBALS['db']->resultcount();
                    if( $_returnscounts > 0){
                        $_returns_details = $GLOBALS['db']->fetchlist($_returns);
                        $total_returns    = $_returns_details['total_price'] ;
                    }else{
                        $total_returns = 0 ;
                    }
                    
					if($_orderscounts > 0)
					{
						$_orders_details = $GLOBALS['db']->fetchlist($_orders);
						$orders_details = [];
						foreach($_orders_details as $oId => $order)
						{
							$orders_details[$oId]['id']            =   intval($order['id']) ;
							$orders_details[$oId]['date']          =   $order['date'] ;
							$total                                +=   $order['total'] ;
							$orders_details[$oId]['total']         =   $order['total'] ;
							$paid                                 +=   $order['paid'] ;
							$orders_details[$oId]['paid']          =   $order['paid'] ;
							$orders_details[$oId]['remain']        =   $order['remain'] ;
							$orders_details[$oId]['note']          =   $order['note'] ;
							$orders_details[$oId]['payment_type']  =   $order['payment_type'] ;
							$remain                               +=   $order['remain'] ;
							$status                                =   $order['status'] ;
							$_order_products         = $GLOBALS['db']->query("SELECT op.`id` , p.`name_ar`  AS name ,p.`price`,op.`quantity`, op.`status` FROM `order_products` op INNER JOIN `products` p ON p.`id` = op.`product_id` WHERE op.`order_id` = '".$order['id']."'");
							$_order_productscounts   = $GLOBALS['db']->resultcount();
							if($_order_productscounts > 0)
							{
								$_order_products_details    =   $GLOBALS['db']->fetchlist($_order_products);
						        $order_products_details     =   [];
								foreach($_order_products_details as $pId => $product)
								{
									$order_products_details[$pId]['id']                  =   intval($product['id']) ;
									$order_products_details[$pId]['name']                =   $product['name'] ;
									$order_products_details[$pId]['price']               =   $product['price'] ;
									$order_products_details[$pId]['img']                 =   ($product['img'] == "") ? $this->getDefaults("url").$this->getDefaults("img-default-product") : $this->getDefaults("url").$product['img'];
									$order_products_details[$pId]['quantity']            =   $product['quantity'] ;
									$order_products_details[$pId]['status']              =   $product['status'] ;
								}
                                
							}
                            $orders_details[$oId]['product']   =  $order_products_details ??  [] ;
						} 
						$client_details[$cId]['orders']           =  $orders_details ? $orders_details: [] ;
                        $client_details[$cId]['total_orders']     =  $total ?? 0;
                        $client_details[$cId]['total_returns']    =  $total_returns ?? 0;
                        $client_details[$cId]['total_after_calc'] =  $total - $total_returns ?? 0;
						$client_details[$cId]['paid']             =  $paid ?? 0;
						$client_details[$cId]['remain']           =  $remain ?? 0;
						$client_details[$cId]['status']           =  $status ?? 0;
					}else{
						$client_details[$cId]['orders']           =  [] ;
						$client_details[$cId]['total_orders']     =  0 ;
						$client_details[$cId]['total_returns']    =  0 ;
						$client_details[$cId]['total_after_calc'] =  0 ;
						$client_details[$cId]['paid']             =  0 ;
						$client_details[$cId]['remain']           =  0 ;
					}
					//////////////////////////////////////////////////////////////////////////
					$_returns         = $GLOBALS['db']->query("SELECT * FROM `returns` WHERE `client_id` = '".$client['id']."' AND `rep_id` = '".$tokenUserId."' ");
					$_returnscounts   = $GLOBALS['db']->resultcount();
					$client_details[$cId]['returns_number']        =     $_returnscounts;

					if($_returnscounts > 0)
					{
						$_returns_details = $GLOBALS['db']->fetchlist($_returns);
						$returns_details = [];
						foreach($_returns_details as $rId => $return)
						{
							$returns_details[$rId]['return_id']            =   intval($return['id']) ;
							$returns_details[$rId]['return_date']          =   $return['date'] ;
							$returns_details[$rId]['return_total']         =   $return['total'] ;
							$returns_details[$rId]['return_status_id']         =   $return['return_status_id'] ;
							$returns_details[$rId]['note']                 =   $return['note'] ;
							$total_return                          +=   $return['total'] ;
							$returns_details[$rId]['return_bill_img']      =   ($return["bill_img"] == "") ? "" : $this->getDefaults("url").$return["bill_img"];
							$_return_products         = $GLOBALS['db']->query("SELECT rp.`id` , p.`name_ar` AS name ,p.`price`, p.`img` AS img ,rp.`quantity` FROM `returns_products` rp INNER JOIN `products` p ON p.`id` = rp.`product_id` WHERE rp.`return_id` = '".$return['id']."'");
							$_return_productscounts   = $GLOBALS['db']->resultcount();
							if($_return_productscounts > 0)
							{
								$_return_products_details    =   $GLOBALS['db']->fetchlist($_return_products);
						        $return_products_details     =   [];
								foreach($_return_products_details as $pId => $product)
								{
									$return_products_details[$pId]['id']                  =   intval($product['id']) ;
									$return_products_details[$pId]['name']                =   $product['name'] ;
									$return_products_details[$pId]['price']               =   $product['price'] ;
									$return_products_details[$pId]['img']                 =   ($product['img'] == "") ? $this->getDefaults("url").$this->getDefaults("img-default-product") : $this->getDefaults("url").$product['img'];
									$return_products_details[$pId]['quantity']            =   $product['quantity'] ;
								}
								$returns_details[$rId]['product']   =  $return_products_details ? $return_products_details : [] ;

							}
						}
						$client_details[$cId]['returns']              =     $returns_details;
						$client_details[$cId]['returns_money']        =     $total_return;
					}else{
						$client_details[$cId]['returns']              = [];
						$client_details[$cId]['returns_money']        =     0;
					}

					$_installments                          = $GLOBALS['db']->query("SELECT * FROM `installments` WHERE `client_id` = '".$client['id']."' AND `rep_id` = '".$tokenUserId."' AND `installement` = 0 "); 
					$_installmentscounts                    = $GLOBALS['db']->resultcount();
					$client_details[$cId]['installment_number']  = $_installmentscounts;
					if($_installmentscounts > 0)
					{
						$_installment_details = $GLOBALS['db']->fetchlist($_installments);
						$installment_details = [];
						foreach($_installment_details as $sId => $install)
						{
                            $order_query = $GLOBALS['db']->query("SELECT * FROM `orders` WHERE `id` = '".$install['order_id']."' ");
                            $order_count  = $GLOBALS['db']->resultcount() ;
                            if( $order_count > 0){
                                $fetch_order = $GLOBALS['db']->fetchitem() ;
                                $installment_details[$sId]['id']            =   intval($install['id']) ;
                                $installment_details[$sId]['date']          =   $install['date'] ;
                                $installment_details[$sId]['order_id']      =   $install['order_id'] ;
                                $installment_details[$sId]['payment_type']  =   $fetch_order['payment_type'] ;
                                $installment_details[$sId]['total']         =   $fetch_order['total'] ;
                                $installment_details[$sId]['paid']          =   $fetch_order['paid'] ;
                                $installment_details[$sId]['remain']        =   $fetch_order['remain'] ;
                                $installment_details[$sId]['installment_value']  =   $install['installement'] ;
                            }
                            
						}
						$client_details[$cId]['installments']           =   $installment_details;
					}else{
						$client_details[$cId]['installments']           =   [];
					}

				}
				
				$this->terminate('success','',0,$client_details);
			}else
			{
				$tasks_details = [];
				$this->terminate('success','',0,$tasks_details);
			}


		}
		
	}
//////////////////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////

public function rep_add_to_cart()
	{
		$system = new SystemLogin();
		$tokenUserId  = $this->testToken();
		if($tokenUserId != 0)
        {
            $userQuery  = $GLOBALS['db']->query(" SELECT * FROM `reps` WHERE `id` = '".$tokenUserId."' LIMIT 1");
            $usersCount = $GLOBALS['db']->resultcount();
            if($usersCount == 1)
			{
				$repInfo 		        =   $GLOBALS['db']->fetchitem($userQuery);
				$_client 			    =   intval($_POST['client_id']);
				$_items 			    =   sanitize($_POST['items']);
				$_payment_type 		    =   sanitize($_POST['payment_type']);
				$_payment_method 	    =   sanitize($_POST['payment_method']);
				$_number_of_month 	    =   intval($_POST['number_of_month']);
				$_number_of_installment =   intval($_POST['number_of_installment']);
				$_note 		     	    =   sanitize($_POST['note']);
				

				// if($_number_of_installment !==0)
				// {
					// if($_number_of_month !==0)
					// {
						if($_payment_type != "")
						{   
							if($_payment_method != "")
							{
                                if( $_payment_type == "cash" || $_payment_type == "installment" ){
                                    
                                    if($_payment_type == "installment" ){
                                        if($_number_of_installment == 0){
                                            $this->terminate('error','Must Insert Number Of Installment',50);
                                        }
                                        if($_number_of_month == 0){
                                            $this->terminate('error','Must Insert Number Of Month',50);
                                        }
                                    }else{
                                        $_number_of_installment = "0" ;
                                        $_number_of_month       = "0" ;
    
                                    }
    
                                    if($_client !== 0)
                                    {
                                        $validclientQuery  = $GLOBALS['db']->query(" SELECT * FROM `clients` WHERE `id` = '".$_client."' AND `block` = 0  LIMIT 1");
                                        $validclientCount  = $GLOBALS['db']->resultcount();
                                        $fetch_client      = $GLOBALS['db']->fetchitem();

                                        if($validclientCount != 1)
                                        {
                                            $this->terminate('error','invalid client id Or this client blocked',50);
                                        }else
                                        {
                                            if($_items == "")
                                            {
                                                $this->terminate('error','you must insert items',50);
                                            }else
                                            {
                                                $items 				= explode(",",$_items);
                                                if(is_array($items))
                                                {
                                                    foreach($items as $item)
                                                    {
                                                        $itemInfo = explode("|",$item);
            //											if(intval($itemInfo[0]) != 0 || intval($itemInfo[1]) != 0)
            //											{
                                                            $validorderItemQuery  = $GLOBALS['db']->query(" SELECT * FROM `products`  WHERE `id` = '".intval($itemInfo[0])."' AND `status` = '1' ");
                                                            $product = $GLOBALS['db']->fetchitem($validorderItemQuery);
                                                            $validorderItemCount = $GLOBALS['db']->resultcount();
                                                            if($validorderItemCount == 1)
                                                            {
                                                                $finalItems[$itemInfo[0]] = $itemInfo;
                                                            }else
                                                            {
                                                                continue;
                                                            }
                                                            $total += $product['price'] * $itemInfo[1];
    
            //											}else
            //											{
            //												$this->terminate('error','you must insert product id and count > 0',50);
            //											}
                                                    }
                                                }else
                                                {
                                                    $this->terminate('error','you correct item syntax',50);
                                                }
                                                if(is_array($finalItems))
                                                {
                                                    $GLOBALS['db']->query( "INSERT LOW_PRIORITY INTO `orders` (`id`,`by`,`client_id`,`rep_id`,`total`,`remain`,`date`,`time`,`payment_type`,`payment_method`,`number_of_month`, `number_of_installment`,`paid`,`status`,`note`)
                                                                            VALUES (NULL,'rep', '".$_client."','".$tokenUserId."','".$total."','".$total."',NOW(),NOW(),'".$_payment_type."','".$_payment_method."','".$_number_of_month."','".$_number_of_installment."' ,'0','0','".$_note."' ) " );
                                                    $orderId = $GLOBALS['db']->fetchLastInsertId();
                                                    
                                                    if($_payment_type == "installment" ){
                                                        for($i = 0; $i < $_number_of_month ; $i++) {
                                                            $date = date('Y-m-d',strtotime( +$i.'month' ,strtotime(date('Y-m-d')) ) );
                                                            $z=$GLOBALS['db']->query("INSERT INTO `installments` 
                                                            ( `id` ,`client_id` ,`order_id`,`rep_id`, `installement`, `date` ) 
                                                            VALUES 
                                                            ( NULL , '".$_client."', '".$orderId."' ,'" .$tokenUserId. "', '0'  ,'".$date."' )");
                    
                                                        } 
                                                    }
                                                    

                                                    $i = 1;
                                                    foreach($finalItems as $finalItem)
                                                    {
                                                        $orderporductQuery    = $GLOBALS['db']->query(" SELECT * FROM `order_products` WHERE `order_id` = '".$orderId."' AND `product_id` = '".$finalItem[0]."' LIMIT 1");
                                                        $orderporductCount    = $GLOBALS['db']->resultcount();
                                                        if($orderporductCount == 1)
                                                        {
                                                            $this->terminate('error','duplication Priscription_item insert',50);
                                                        }else
                                                        {
                                                            $GLOBALS['db']->query( "INSERT LOW_PRIORITY INTO `order_products` (`id`, `order_id`,`product_id`, `quantity`,`status`,`order` , `discount`) VALUES ( NULL ,  '".$orderId."' , '".$finalItem[0]."' ,'".$finalItem[1]."','0','".($i)."' , '0' ) " );
                                                            
                                                       }
                                                        $i++;
                                                    }

                                                    
                                                    $client_old_credit  = $fetch_client['credit'];
                                                    $client_new_credit  = $client_old_credit + $total ;
                                                    $update_credit  = $GLOBALS['db']->query(" UPDATE `clients` SET `credit` = '".$client_new_credit."' WHERE `id` = '".$fetch_client['id']."' ");
                                                    

                                                    $this->terminate('success','',0);
                                                }
                                            }
                                        }
    
                                    }else
                                    {
                                        $this->terminate('error','Sorry , This Client Not Found IN Database ',50);
                                    }
    
                                }else{
                                    $this->terminate('error','you must insert payment_method',50);
                                }
    
                            }else{
                                $this->terminate('error','you must insert payment_type',50);
                            }
                        // }else{
                        // 	$this->terminate('error','please insert number of month',50);
                        // }
                    // }else{
                    // 	$this->terminate('error','please insert number of installment',50);
                    // }
    
                }
                else{
                 $this->terminate('error','insert client id ',50);
                }
            

                                }else{
                                    $this->terminate('error',' please enter correct payment_type',50);
                                }
}else{
			$this->terminate('error','invalid token',50);
		}
	}
//////////////////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////
public function rep_add_return()
{
    $system = new SystemLogin();
    $tokenUserId  = $this->testToken();
    if($tokenUserId != 0)
    {
        $userQuery  = $GLOBALS['db']->query(" SELECT * FROM `reps` WHERE `id` = '".$tokenUserId."' LIMIT 1");
        $usersCount = $GLOBALS['db']->resultcount();
        if($usersCount == 1)
        {
            $repInfo 		    =  $GLOBALS['db']->fetchitem($userQuery);
            $_client 			=  intval($_POST['client_id']);
            $_items 			=  sanitize($_POST['items']);
            $return_money       =  sanitize($_POST['return_money']) ;
            
            
            if($_client != 0)
            {
                $validclientQuery  = $GLOBALS['db']->query(" SELECT * FROM `clients` WHERE `id` = '".$_client."'  LIMIT 1");
                $validclientCount   = $GLOBALS['db']->resultcount();
                if($validclientCount != 1)
                {
                    $this->terminate('error','invalid client id',50);
                }else
                {
                    if( $return_money == ''){
                        $this->terminate('error','you must enter status return_money',50);
                    }
                    if($_items == "")
                    {
                        $this->terminate('error','you must insert items',50);
                    }else
                    {
                        $note = sanitize($_POST['note']) ;
                        if( $note =="" ){
                            $this->terminate('error','you must insert note',50);
                        }

                        $items 				= explode(",",$_items);
                        if(is_array($items))
                        {   
                            foreach($items as $item)
                            {
                                $itemInfo = explode("|",$item);
//									if(intval($itemInfo[0]) != 0 || intval($itemInfo[1]) != 0)
//									{
                                    $validorderItemQuery  = $GLOBALS['db']->query(" SELECT * FROM `products`  WHERE `id` = '".intval($itemInfo[0])."' AND `status` = '1' ");
                                    $product = $GLOBALS['db']->fetchitem($validorderItemQuery);
                                    $validorderItemCount = $GLOBALS['db']->resultcount();
                                    
                                    if($validorderItemCount == 1)
                                    {
                                        $finalItems[$itemInfo[0]] = $itemInfo;
                                    }else
                                    {
                                        continue;
                                    }
                                    $total += $product['price'] * $itemInfo[1];

//									}else
//									{
//										$this->terminate('error','you must insert product id and count > 0',50);
//									}
                            }
                        }else
                        {
                            $this->terminate('error','you correct item syntax',50);
                        }
                        if(is_array($finalItems))
                        {
                            
                            $GLOBALS['db']->query( "INSERT LOW_PRIORITY INTO `returns` (`id`, `by`, `client_id`, `rep_id`, `total_price`, `date`, `bill_img`,`status`,`return_status_id`,`note`) VALUES (NULL,'rep', '".$_client."','".$tokenUserId."','".$total."',NOW(),'".$imgUrl."','0','".$return_money."','".$note."' ) " );
                            $returnId = $GLOBALS['db']->fetchLastInsertId();
                            foreach($finalItems as $finalItem)
                            {
                                $returnporductQuery    = $GLOBALS['db']->query(" SELECT * FROM `returns_products`  WHERE `return_id` = '".$returnId."' AND `product_id` = '".$finalItem[0]."' LIMIT 1");
                                $returnporductCount    = $GLOBALS['db']->resultcount();
                                if($returnporductCount == 1)
                                {
                                    $this->terminate('error','duplication Priscription_item insert',50);
                                }else
                                {
                                    $returnporduct    = $GLOBALS['db']->query(" SELECT * FROM `products`  WHERE `id` = '".$finalItem[0]."' LIMIT 1");
                                    $all = $GLOBALS['db']->fetchitem($returnporduct);
                                    $price = $all['price'] ;
                                    $GLOBALS['db']->query( "INSERT LOW_PRIORITY INTO `returns_products` (`id`, `return_id`, `product_id`,`quantity`,`price`, `status`) VALUES ( NULL ,  '".$returnId."' , '".$finalItem[0]."' ,'".$finalItem[1]."','".$price."','1') " );
                                }
                            }

                            $this->terminate('success','',0);
                        }
                    }
                }
            }else{
                 $this->terminate('error','insert client id',1);
            }
        }else{
            $this->terminate('error','token rep id not found',1);
        }
    }
}
/////////////////////////////////////////

public function client_add_return()
{
    $system       = new SystemLogin();
    $tokenUserId  = $this->testToken();
    if($tokenUserId != 0)
    {
        $userQuery  = $GLOBALS['db']->query(" SELECT * FROM `clients` WHERE `id` = '".$tokenUserId."' LIMIT 1");
        $usersCount = $GLOBALS['db']->resultcount();
        if($usersCount == 1)
        {
            $clientInfo 		=  $GLOBALS['db']->fetchitem($userQuery);
            $_items 			=  sanitize($_POST['items']);
            $return_money       =  sanitize($_POST['return_money']) ;
            $note               =  sanitize($_POST['note']) ;
            if($_items == "")
            {
                $this->terminate('error','you must insert items',50);
            }else
            {
                $items 				= explode(",",$_items);

                if( $return_money == ''){
                    $this->terminate('error','you must enter status return_money',50);
                }

                if(is_array($items))
                {
                    foreach($items as $item)
                    {
                        $itemInfo = explode("|",$item);
                        if(intval($itemInfo[0]) != 0 || intval($itemInfo[1]) != 0)
                        {
                            $validorderItemQuery  = $GLOBALS['db']->query(" SELECT * FROM `products`  WHERE `id` = '".intval($itemInfo[0])."' AND `status` = '1' ");
                            $product = $GLOBALS['db']->fetchitem($validorderItemQuery);
                            $validorderItemCount = $GLOBALS['db']->resultcount();
                            if($validorderItemCount == 1)
                            {
                                $finalItems[$itemInfo[0]] = $itemInfo;
                            }else
                            {
                                continue;
                            }
                            $total += $product['price'] * $itemInfo[1];

                        }else
                        {
                            $this->terminate('error','you must insert product id and count > 0',50);
                        }
                    }
                }else
                {
                    $this->terminate('error','you correct item syntax',50);
                }
            if(is_array($finalItems))
            {

                $GLOBALS['db']->query( "INSERT LOW_PRIORITY INTO `returns` (`id`, `by`, `client_id`, `rep_id`,`return_status_id`, `total_price`, `date`, `bill_img`,`status` ,`note`) VALUES (NULL,'client', '".$tokenUserId."','".$clientInfo['rep_id']."','".$return_money."','".$total."',NOW(),'".$imgUrl."','0' ,'".$note."') " );
                $returnId = $GLOBALS['db']->fetchLastInsertId();
                foreach($finalItems as $finalItem)
                {
                    $returnporductQuery    = $GLOBALS['db']->query(" SELECT * FROM `returns_products` WHERE `return_id` = '".$returnId."' AND `product_id` = '".$finalItem[0]."' LIMIT 1");
                    $returnporductCount    = $GLOBALS['db']->resultcount();
                    if($returnporductCount == 1)
                    {
                        $this->terminate('error','duplication Priscription_item insert',50);
                    }else
                    {
                        $returnporduct    = $GLOBALS['db']->query(" SELECT * FROM `products`  WHERE `id` = '".$finalItem[0]."' LIMIT 1");
                        $all = $GLOBALS['db']->fetchitem($returnporduct);
                        $price = $all['price'] ;
                        $GLOBALS['db']->query( "INSERT LOW_PRIORITY INTO `returns_products` (`id`, `return_id`, `product_id`,`quantity`,`price`, `status`) VALUES ( NULL ,  '".$returnId."' , '".$finalItem[0]."' ,'".$finalItem[1]."','".$price."','0') " );
                    }
                }
                
                $this->terminate('success','',0);
            }
        }
        }else
        {
            $this->terminate('error','token client id not found',1);
        }
    }
}


////////////////////////////////////////

    public function rep_add_client(){

        $tokenUserId  = $this->testToken();
		if($tokenUserId != 0)
        {        
            $client_name 			= sanitize($_POST['client_name']);
            $email 			        = sanitize($_POST['email']);
            $lon 			        = sanitize($_POST['lon']);
            $lat 			        = sanitize($_POST['lat']);
            $address 			    = sanitize($_POST['address']);
            $phone 			        = sanitize($_POST['phone']);
            // $password 			    = sanitize($_POST['password']);
            $governorate 			= intval($_POST['governorate']);
            $city 			        = intval($_POST['city']);
            $kind                   = intval($_POST['kind']);
            $job                    = sanitize($_POST['job']) ?? ' ' ;
            if($client_name !== "")
            {
                if($phone !== "")
                {
                    if (strlen($phone) != (11) || !is_numeric($phone))
                    {
                        $this->terminate('error','عفواً رقم الهاتف يجب أن يكون '.(11).' رقم ',7);
                    }else
                    {
                        if( $_POST['governorate'] && $_POST['city']  || $_POST['lon']  && $_POST['lat'])
                        {
                            $validclientQuery    = $GLOBALS['db']->query(" SELECT * FROM `clients` WHERE `mobile` = '".$phone."' LIMIT 1");
                            $validclientCount    = $GLOBALS['db']->resultcount();
                            if($validclientCount == 1)
                            {
                                $this->terminate('error','عفوا ,لقد تم التسجيل بهذا الهاتف مسبقا ',50);
                            }else
                            {
                                // if($password !="")
                                // {
                                // $pass  = md5($password);
                                $GLOBALS['db']->query( "INSERT LOW_PRIORITY INTO `clients` (`id`, `name`,`mobile`,`email`,`rep_id`, `governorate`, `city`, `address`,`job`, `lon`, `lat`,`reg_time`,`kind`,`status` , `by`) VALUES (NULL,'".$client_name."','".$phone."','".$email."','".$tokenUserId."','".$governorate."','".$city."','".$address."','".$job."','".$lon."','".$lat."',NOW(),'".$kind."','1' ,'".$tokenUserId."' )");
                                $clientId = $GLOBALS['db']->fetchLastInsertId();

                                $data['msg'] = "Success Insert New Client" ;
                                $data['client_id'] = $clientId ;
                                $this->terminate('success','',0,$data);
                                // }else{
                                //     $this->terminate('error','insert password ',180);
                                // }
                            }

                                                            

                        }else
                        {
                            $this->terminate('error','عفوا يجب ادخال المحافظه والمدينه  او احداثيات الطول والعرض ',50);
                        }
                    }

                }else{
                    $this->terminate('error','insert phone',50);
                }

                        

                    
                

            }else{
                $this->terminate('error','insert client name',50);
            }

        }else{
            $this->terminate('error' , 'Udid Or Static Not Correct' ,50 );
        }

    }
///////////////////////////////////////

    public function setAvatar()
        {
            
            $tokenUserId  = $this->testToken();
            if($tokenUserId != 0)
            {
                $user = sanitize($_POST['user']) ;
                if( $user == "" ){
                    $this->terminate('error' , 'enter kind user ( REP or Client ) ' ,50 );
                }else{
                    if( $user == 'rep' ){
                        $table = 'reps' ;
                    }elseif( $user == 'client' ){
                        $table = 'clients' ;
                    }else{
                        $this->terminate('error' , 'user ( REP or Client ) Only' ,50 );
                    }
                }
                $userQuery = $GLOBALS['db']->query(" SELECT * FROM $table WHERE `id` = '".$tokenUserId."' LIMIT 1");
                $usersCount = $GLOBALS['db']->resultcount();
                
                if($usersCount == 1)
                {
                    
                    if($_FILES)
                    {
                        
                        if(!empty($_FILES['avatar']['error']))
                        {
                            //$this->terminate('success','',0);
                            switch($_FILES['avatar']['error'])
                            {
                                case '1':
                                    $this->terminate('error','عفوا حجم الملف أكبر من الحجم المسموح به',201);
                                    break;
                                case '2':
                                    $this->terminate('error','عفوا حجم الملف أكبر من الحجم المسموح به',202);
                                    break;
                                case '3':
                                    $this->terminate('error','عفوا لم نتمكن من تحميل الملف بالكامل',203);
                                    break;
                                case '4':
                                    $this->terminate('error','عفوا لم تقم باختيار الملف',204);
                                    break;
                                case '6':
                                    $this->terminate('error','هناك خطأ بالسيرفر مجلد التمب غير متوفر',205);
                                    break;
                                case '7':
                                    $this->terminate('error','عفوا لم نتمكن من تحميل الملف',206);
                                    break;
                                case '8':
                                    $this->terminate('error','عفوا الرجاء اعادة المحاولة تم ايقاف رفع الملف ربما بسبب انقطاع الخدمه',207);
                                    break;
                                case '999':
                                default:
                                    $this->terminate('error','خطأ غير معروف',208);
                            }
                        }
                        elseif(empty($_FILES['avatar']['tmp_name']) || $_FILES['avatar']['tmp_name'] == 'none')
                        {
                            $this->terminate('error','من فضلك قم باختيار ملف ليتم تحميله',209);
                        }else
                        {
                            $disallow_mime = array
                            (
                                "text/html",
                                "text/plain",
                                "magnus-internal/shellcgi",
                                "application/x-php",
                                "text/php",
                                "application/x-httpd-php" ,
                                "application/php",
                                "magnus-internal/shellcgi",
                                "text/x-perl",
                                "application/x-perl",
                                "application/x-exe",
                                "application/exe",
                                "application/x-java" ,
                                "application/java-byte-code",
                                "application/x-java-class",
                                "application/x-java-vm",
                                "application/x-java-bean",
                                "application/x-jinit-bean",
                                "application/x-jinit-applet",
                                "magnus-internal/shellcgi",
                                "image/svg",
                                "image/svg-xml",
                                "image/svg+xml",
                                "text/xml-svg",
                                "image/vnd.adobe.svg+xml",
                                "image/svg-xml",
                                "text/xml",
                            );
                            
                            include_once("upload.class.php");
                            $allow_ext = array("jpg","gif","png");
                            $upload    = new Upload($allow_ext,false,0,0,5000,"../uploads/",".","",false,'user_');
                            
                            $files[name] 	= addslashes($_FILES["avatar"]["name"]);
                            $files[type] 	= $_FILES["avatar"]['type'];
                            $files[size] 	= $_FILES["avatar"]['size']/1024;
                            $files[tmp] 	= $_FILES["avatar"]['tmp_name'];
                            $files[ext]		= $upload->GetExt($_FILES["avatar"]["name"]);
                            
                            
                            $upfile	= $upload->Upload_File($files);
                            //$this->terminate('success','',0); 
                            if($upfile)
                            {	
                                //$this->terminate('success','',0); 
                                $imgUrl =  "uploads/". $upfile[ext] . "/" .  $upfile[newname];

                            }else
                            {
                            $this->terminate('error','عفوا لم نتمكن من تحميل الملف',210);
                            }

                            @unlink($_FILES['avatar']);
                        }//					
                        
                        $GLOBALS['db']->query("UPDATE LOW_PRIORITY $table SET `img`='".$imgUrl."' WHERE `id` = '".$tokenUserId."' LIMIT 1");
                        $userQuery = $GLOBALS['db']->query(" SELECT * FROM $table WHERE `id` = '".$tokenUserId."' LIMIT 1");
                        $userCredintials = $GLOBALS['db']->fetchitem($userQuery);
                        $_clientCredintials = $this->buildMembershipCredintials($user,$userCredintials);
                                            
                        $this->terminate('success','',0,$_clientCredintials);

                    }else
                    {
                        $this->terminate('error','missing image data',100);
                    }
                }
            }
        }

/////////////////////////////////////////////
public function rep_setAvatar_client()
{
    
    $tokenUserId  = $this->testToken();
    if($tokenUserId != 0)
    {
        $client_id = sanitize($_POST['client_id']) ;
       
        $userQuery = $GLOBALS['db']->query(" SELECT * FROM `clients` WHERE `id` = '".$client_id."' LIMIT 1");
        $usersCount = $GLOBALS['db']->resultcount();        
        if($usersCount == 1)
        {
            if($_FILES)
            {
                
                if(!empty($_FILES['avatar']['error']))
                {
                    //$this->terminate('success','',0);
                    switch($_FILES['avatar']['error'])
                    {
                        case '1':
                            $this->terminate('error','عفوا حجم الملف أكبر من الحجم المسموح به',201);
                            break;
                        case '2':
                            $this->terminate('error','عفوا حجم الملف أكبر من الحجم المسموح به',202);
                            break;
                        case '3':
                            $this->terminate('error','عفوا لم نتمكن من تحميل الملف بالكامل',203);
                            break;
                        case '4':
                            $this->terminate('error','عفوا لم تقم باختيار الملف',204);
                            break;
                        case '6':
                            $this->terminate('error','هناك خطأ بالسيرفر مجلد التمب غير متوفر',205);
                            break;
                        case '7':
                            $this->terminate('error','عفوا لم نتمكن من تحميل الملف',206);
                            break;
                        case '8':
                            $this->terminate('error','عفوا الرجاء اعادة المحاولة تم ايقاف رفع الملف ربما بسبب انقطاع الخدمه',207);
                            break;
                        case '999':
                        default:
                            $this->terminate('error','خطأ غير معروف',208);
                    }
                }
                elseif(empty($_FILES['avatar']['tmp_name']) || $_FILES['avatar']['tmp_name'] == 'none')
                {
                    $this->terminate('error','من فضلك قم باختيار ملف ليتم تحميله',209);
                }else
                {
                    $disallow_mime = array
                    (
                        "text/html",
                        "text/plain",
                        "magnus-internal/shellcgi",
                        "application/x-php",
                        "text/php",
                        "application/x-httpd-php" ,
                        "application/php",
                        "magnus-internal/shellcgi",
                        "text/x-perl",
                        "application/x-perl",
                        "application/x-exe",
                        "application/exe",
                        "application/x-java" ,
                        "application/java-byte-code",
                        "application/x-java-class",
                        "application/x-java-vm",
                        "application/x-java-bean",
                        "application/x-jinit-bean",
                        "application/x-jinit-applet",
                        "magnus-internal/shellcgi",
                        "image/svg",
                        "image/svg-xml",
                        "image/svg+xml",
                        "text/xml-svg",
                        "image/vnd.adobe.svg+xml",
                        "image/svg-xml",
                        "text/xml",
                    );
                    
                    include_once("upload.class.php");
                    $allow_ext = array("jpg","gif","png");
                    $upload    = new Upload($allow_ext,false,0,0,5000,"../uploads/",".","",false,'user_');
                    
                    $files[name] 	= addslashes($_FILES["avatar"]["name"]);
                    $files[type] 	= $_FILES["avatar"]['type'];
                    $files[size] 	= $_FILES["avatar"]['size']/1024;
                    $files[tmp] 	= $_FILES["avatar"]['tmp_name'];
                    $files[ext]		= $upload->GetExt($_FILES["avatar"]["name"]);
                    
                    
                    $upfile	= $upload->Upload_File($files);
                    //$this->terminate('success','',0); 
                    if($upfile)
                    {	
                        //$this->terminate('success','',0); 
                        $imgUrl =  "uploads/". $upfile[ext] . "/" .  $upfile[newname];

                    }else
                    {
                    $this->terminate('error','عفوا لم نتمكن من تحميل الملف',210);
                    }

                    @unlink($_FILES['avatar']);
                }//					
                
                $GLOBALS['db']->query("UPDATE LOW_PRIORITY `clients` SET `img`='".$imgUrl."' WHERE `id` = '".$client_id."' LIMIT 1");
                                    
                $this->terminate('success','',0);

            }else
            {
                $this->terminate('error','missing image data',100);
            }
        }
    }
}

///////////////////////////////////////
public function rep_add_visit()
	{
		$tokenUserId  = $this->testToken();
		if($tokenUserId != 0)
		{
			$_client        = intval($_POST['client_id']);
            $_note	        = sanitize($_POST['note']);
            $_type_visit    = sanitize($_POST['type_visit']);
			if($_client !== 0)
			{
				    $validclientQuery  = $GLOBALS['db']->query(" SELECT * FROM `clients` WHERE `id` = '".$_client."'  LIMIT 1");
                    $validclientCount   = $GLOBALS['db']->resultcount();
					if($validclientCount != 1)
					{
						$this->terminate('error','invalid client id',50);
					}else
					{
						if($_type = "")
						{
							$this->terminate('error','insert note',50);
						}else
						{

						  $GLOBALS['db']->query( "INSERT LOW_PRIORITY INTO `tasks` (`id`, `client_id`, `rep_id`, `type`, `type_id`, `notes`, `date`,`status`) 
                                                                        VALUES (NULL,'".$_client."','".$tokenUserId."','".$_type_visit."',0,'".$_note."',NOW(),'1' ) " );
						  $visit = $GLOBALS['db']->fetchLastInsertId();
							if($visit)
							{
								 $this->terminate('success','',0);
							}else{
								 $this->terminate('error','failed in query',0);
							}

						}
				    }
			}else{
				$this->terminate('error','please insert client id',0);
			}
		}else{
			$this->terminate('error','invalid token',0);
		}

	}
////////////////////////////////////////////////
public function rep_add_location()
	{
		$tokenUserId  = $this->testToken();
		if($tokenUserId != 0)
		{
            $all_loc = $_POST['location'] ;
            $loc = explode( "," , $all_loc) ;
            foreach($loc as $_loc ){
                $locData =  explode( '|' , $_loc ) ;

                $_lat       =   floatval($locData[0]);
                $_lon       =   floatval($locData[1]);
                $_gps       =   sanitize($locData[2]);
                $_internet  =   sanitize($locData[3]);
                $_date      =   intval($locData[4]);
                
                $d = date( 'Y-m-d G:i:s',$_date );

                if( $_gps == '1'){
                    if( $_lat == 0  || $_lon == 0 ){
                        $this->terminate('error','invalid lat & lon',0);
                    }
                }
                
                $GLOBALS['db']->query( "INSERT LOW_PRIORITY INTO `locations` (`id`,`rep_id`, `lat`, `lon`, `date`,`gps` ,`internet`) 
                                                        VALUES (NULL,'".$tokenUserId."','".$_lat."','".$_lon."','".$d."','".$_gps."' ,'".$_internet."' ) " );
                
                $repQuery = $GLOBALS['db']->query(" UPDATE `reps` SET `location` = '".$_gps."' , `update_location_time` = now() WHERE `id` = '".$tokenUserId."' ");
            }

            $visit = $GLOBALS['db']->fetchLastInsertId();
            if($visit)
            {
                    $this->terminate('success','',0);
            }else{
                    $this->terminate('error','failed in query',0);
            }
			
			
		}else{
			$this->terminate('error','invalid token',0);
		}

    }
    
////////////////////////////////////////////////
        public function get_rep_govs(){

            $rep_id  = $this->testToken() ;
            $repQuery  = $GLOBALS['db']->query(" SELECT * FROM `reps` WHERE `id` = '".$rep_id."'  LIMIT 1  ");
            $repCount = $GLOBALS['db']->resultcount();
            if( $repCount == 1  ){
                $repQuery  = $GLOBALS['db']->query(" SELECT * FROM `gonvernrate_reps` INNER JOIN `governorates` ON  governorates.id = gonvernrate_reps.governorate_id  WHERE gonvernrate_reps.rep_id = '".$rep_id."' ");
                $rep_govCount = $GLOBALS['db']->resultcount();
                if( $rep_govCount != 0 ){
                    $reps_gov = $GLOBALS['db']->fetchlist();
                    foreach( $reps_gov as $k => $_rg ){

                        if($lang == "en")
                        {
                            $_cities = $GLOBALS['db']->query("SELECT id,name_en as `name` FROM `cities` WHERE `status` = '1' AND `governorate` = '".$_rg['id']."'");
                        }else{
                            $_cities = $GLOBALS['db']->query("SELECT id,name_ar as `name` FROM `cities` WHERE `status` = '1' AND `governorate` = '".$_rg['id']."'");
                        }
                        $_cities_details = $GLOBALS['db']->fetchlist($_cities);
                        $_cities_count = $GLOBALS['db']->resultcount();

                        if( $_cities_count > 0 ){

                            foreach($_cities_details as $tId => $city)
                            {
                                $cits[$tId]['id']             = intval($city['id']);
                                $cits[$tId]['name']     		= $city['name'];
                                
                            }
                            
                        } 

                        $arr[$k]['gov_id']			= 	$_rg['governorate_id'] ;
                        $arr[$k]['governorate'] 	= 	$_rg['name_ar'] ;
                        $arr[$k]['cities'] 	= 	(is_array($cits)) ? $cits : array() ;
                    }
 
                    
                    $this->terminate('success',"",0,$arr);
                }else{
                    $this->terminate('error',' no found Govs to this REPS',6);
                }
                
            }
        }

////////////////////////////////////////////////
        public function get_appiontments(){
                
            $rep_id        = $this->testToken() ;
            $current_date  = $_POST['current_date'];
            $current_month = date('m') ;
            
            $gov = intval($_POST['gov']) ;
            
            if( $_POST['gov'] == ""){
                $this->terminate('error',' must enter governorate',6);
            }

            // foreach( $ar_gov as $g ){
                
                // $clientQuery  = $GLOBALS['db']->query(" SELECT * FROM `gonvernrate_reps` INNER JOIN appointment ON appointment.rep_id = gonvernrate_reps.rep_id WHERE appointment.rep_id='".$rep_id."' AND gonvernrate_reps.governorate_id ='".$gov."'  ");
                $clientQuery  = $GLOBALS['db']->query(" SELECT * FROM `clients` WHERE `rep_id` = '".$rep_id."' AND `governorate` ='".$gov."'  ");
                $clientsCount = $GLOBALS['db']->resultcount();
                // echo $rep_id."401" ;
                if( $clientsCount > 0 ){
                    // echo "402" ;
                    $clients = $GLOBALS['db']->fetchlist(); 
                    $arr = [] ;
                    foreach( $clients as $app ){
                        // echo"404";
                        $GLOBALS['db']->query(" SELECT * FROM `tasks` WHERE `client_id` = '".$app['id']."' AND `rep_id` = '".$rep_id."' AND `type` = 'visit' AND `notifications_done` ='1' ") ;
                        $appCount = $GLOBALS['db']->resultcount() ;
                        $clientData = $GLOBALS['db']->fetchlist() ;
                        foreach( $clientData as $_data ){
                            
                            if( $app['kind'] == '1' || $app['kind'] == '2' ){
                                
                                if( $appCount != 0){
                                    
                                    $GLOBALS['db']->query("DELETE LOW_PRIORITY FROM `".tasks."` 
                                        WHERE 
                                        `client_id` = '".$app[id]."' AND `rep_id` = '".$rep_id."' AND `type` = 'visit' AND `notifications_done` ='0' ");
                                        // SELECT * FROM appointment WHERE date = DATE( DATE_SUB( NOW() , INTERVAL 7 DAY ) )
                                        // $date_of_visit = date('Y-m-'.$d.'',strtotime('+10 day',strtotime(date('Y-m-01')) ) );
                                    // $checkquery = $GLOBALS['db']->query("SELECT * FROM appointment WHERE date > DATE( DATE_SUB( NOW() , INTERVAL 7 DAY ) ) AND `type` ='visit' AND `notifications_done`=1 ");
                                    $checkquery = $GLOBALS['db']->query("SELECT DAY(date) FROM tasks WHERE `client_id` = '".$app[id]."' AND `rep_id` = '".$rep_id."' AND `type` ='visit' AND `notifications_done`=1 AND MONTH(date) ='".$current_month."' ORDER BY `id` DESC  ");
                                    $_checkCount= $GLOBALS['db']->resultcount() ;
                                    
                                    if($_checkCount != 0){
                                        $_checkDate = $GLOBALS['db']->fetchitem() ;
                                        $dateLastvisit =  $_checkDate[0] ;

                                        $week1 = [1,2,3,4,5,6,7] ;
                                        $week2 = [8,9,10,11,12,13,14,15] ;
                                        $week3 = [16,17,18,19,20,21,22] ;
                                        $week4 = [23,24,25,26,27,28,29,30] ;

                                        if( in_array($dateLastvisit ,$week1 )){
                                            // echo 1 ;
                                            $GLOBALS['db']->query("INSERT INTO `tasks` (`id`, `client_id`, `rep_id`, `type`, `type_id`, `date`, `lon`, `lat`, `client_rate`, `notes`, `update`, `reason`, `c_confirm`, `rep_confirm`, `confirm_time`, `notifications_done`, `status`) VALUES (NULL, '".$app[id]."', '".$rep_id."', 'visit', '0', NOW(), '0', '0', '', NULL,'not', '', '0', '0', '', '', '1') ") ;
                                            for($i =1 ; $i<3 ; $i++){
                                                $GLOBALS['db']->query("INSERT INTO `tasks` (`id`, `client_id`, `rep_id`, `type`, `type_id`, `date`, `lon`, `lat`, `client_rate`, `notes`, `update`, `reason`, `c_confirm`, `rep_confirm`, `confirm_time`,`notifications_done`, `status`) VALUES (NULL, '".$app[id]."', '".$rep_id."', 'visit', '0', ' ', '0', '0', '', NULL,'not', '', '0', '0', '', '', '1') ") ;
                                            }
                                            
                                        }elseif( in_array($dateLastvisit ,$week2 )){
                                            // echo 2 ;
                                            $GLOBALS['db']->query("INSERT INTO `tasks` (`id`, `client_id`, `rep_id`, `type`, `type_id`, `date`, `lon`, `lat`, `client_rate`, `notes`, `update`, `reason`, `c_confirm`, `rep_confirm`, `confirm_time`,  `notifications_done`, `status`) VALUES (NULL, '".$app[id]."', '".$rep_id."', 'visit', '0', NOW(), '0', '0', '', NULL,'not', '', '0', '0', '',  '', '1') ") ;
                                            // for($i =1 ; $i<=2 ; $i++){
                                            // 	echo 'x' ;
                                                $GLOBALS['db']->query("INSERT INTO `tasks` (`id`, `client_id`, `rep_id`, `type`, `type_id`, `date`, `lon`, `lat`, `client_rate`, `notes`,`update`, `reason`, `c_confirm`, `rep_confirm`, `confirm_time`, `notifications_done`, `status`) VALUES (NULL, '".$app[id]."', '".$rep_id."', 'visit', '0', ' ', '0', '0', '', NULL,'not', '', '0', '0', '',  '', '1') ") ;
                                            // }
                                        }elseif( in_array($dateLastvisit ,$week3 )){
                                            // echo 3 ;
                                            $GLOBALS['db']->query("INSERT INTO `tasks` (`id`, `client_id`, `rep_id`, `type`, `type_id`, `date`, `lon`, `lat`, `client_rate`, `notes`, `update`, `reason`, `c_confirm`, `rep_confirm`, `confirm_time`,  `notifications_done`, `status`) VALUES (NULL, '".$app[id]."', '".$rep_id."', 'visit', '0', NOW(), '0', '0', '', NULL, 'not', '', '0', '0', '',  '', '1') ") ;
                                        }elseif( in_array($dateLastvisit ,$week4 )){
                                            echo 'visits in this month completed';
                                        }else{
                                            $GLOBALS['db']->query("INSERT INTO `tasks` (`id`, `client_id`, `rep_id`, `type`, `type_id`, `date`, `lon`, `lat`, `client_rate`, `notes`, `update`, `reason`, `c_confirm`, `rep_confirm`, `confirm_time`,  `notifications_done`, `status`) VALUES (NULL, '".$app[id]."', '".$rep_id."', 'visit', '0', NOW(), '0', '0', '', NULL,'not', '', '0', '0', '', '', '1') ") ;
                                        
                                            for($i =1 ; $i<=3 ; $i++){
                                                $GLOBALS['db']->query("INSERT INTO `tasks` (`id`, `client_id`, `rep_id`, `type`, `type_id`, `date`, `lon`, `lat`, `client_rate`, `notes`, `update`, `reason`, `c_confirm`, `rep_confirm`, `confirm_time`, `notifications_done`, `status`) VALUES (NULL, '".$app[id]."', '".$rep_id."', 'visit', '0', ' ', '0', '0', '', NULL, 'not', '', '0', '0', '','', '1') ") ;
                                            }
                                        }
                                    }

                                    
                                }
                            }elseif( $app['kind'] == '3' ){
                                if( $appCount != 0 ){
                                    $GLOBALS['db']->query("DELETE LOW_PRIORITY FROM `".tasks."` WHERE `client_id` = '".$app[id]."' AND `rep_id` = '".$rep_id."' AND `type` = 'visit' AND `notifications_done` ='0' ");
                                    
                                    $checkquery = $GLOBALS['db']->query("SELECT DAY(date) FROM appointment WHERE  `client_id` = '".$app[id]."' AND `rep_id` = '".$rep_id."' AND `type` ='visit' AND `notifications_done`=1 AND MONTH(date) ='".$current_month."' ");
                                    $_checkCount= $GLOBALS['db']->resultcount() ;
                                    
                                    if($_checkCount != 0){
                                        $_checkDate = $GLOBALS['db']->fetchitem() ;
                                        $dateLastvisit =  $_checkDate[0] ;
                                        $week1 = [1,2,3,4,5,6,7,8,9,10,11,12,13,14,15] ;
                                        $week2 = [16,17,18,19,20,21,22,23,24,25,26,27,28,29,30] ;
                                        
                                        if( in_array($dateLastvisit ,$week1 )){
                                            $GLOBALS['db']->query("INSERT INTO `tasks` (`id`, `client_id`, `rep_id`, `type`, `type_id`, `date`, `lon`, `lat`, `client_rate`, `notes`,  `update`, `reason`, `c_confirm`, `rep_confirm`, `confirm_time`, `notifications_done`, `status`) VALUES (NULL, '".$app[id]."', '".$rep_id."', 'visit', '0', NOW(), '0', '0', '', NULL, 'not', '', '0', '0', '', '', '1') ") ;
                                        }elseif( in_array($dateLastvisit ,$week2 )){
                                            echo 'visits in this month completed';
                                        }else{
                                            $GLOBALS['db']->query("INSERT INTO `tasks` (`id`, `client_id`, `rep_id`, `type`, `type_id`, `date`, `lon`, `lat`, `client_rate`, `notes`, `update`, `reason`, `c_confirm`, `rep_confirm`, `confirm_time`, `notifications_done`, `status`) VALUES (NULL, '".$app[id]."', '".$rep_id."', 'visit', '0', NOW(), '0', '0', '', NULL, 'not', '', '0', '0', '', '', '1') ") ;
                                        
                                            for($i =1 ; $i<2 ; $i++){
                                                $GLOBALS['db']->query("INSERT INTO `tasks` (`id`, `client_id`, `rep_id`, `type`, `type_id`, `date`, `lon`, `lat`, `client_rate`, `notes`,`update`, `reason`, `c_confirm`, `rep_confirm`, `confirm_time`,`notifications_done`, `status`) VALUES (NULL, '".$app[id]."', '".$rep_id."', 'visit', '0', ' ', '0', '0', '', NULL,'not', '', '0', '0', '', '', '1') ") ;
                                            }
                                        }
                                    }
                                }
                            }
                            
                    }
                    }
                    $date = date('Y-m-d') ;
                    $GLOBALS['db']->query(" SELECT clients.kind, tasks.* FROM `tasks`
                                            INNER JOIN `clients` ON tasks.client_id=clients.id 
                                            WHERE 
                                            tasks.rep_id = '".$rep_id."' AND tasks.date = '".$date."' AND tasks.type = 'visit' AND tasks.notifications_done != '1'
                                            ORDER BY clients.kind ASC ") ;
                    $count = $GLOBALS['db']->resultcount() ;
                    if( $count != 0 ){
                        $_appData = $GLOBALS['db']->fetchlist() ;
                        foreach($_appData as  $k => $_app ){

                            $app_list[$k]['app_id'] 			= 	$_app['id'] ;
                            $app_list[$k]['rep_id']				= 	$_app['rep_id'] ;
                            $app_list[$k]['client_id'] 			= 	$_app['client_id'] ;
                            $app_list[$k]['type'] 				= 	$_app['type'] ;
                            $app_list[$k]['type_id'] 			= 	$_app['type_id'] ;
                            $app_list[$k]['date'] 				= 	$_app['date'] ;
                            $app_list[$k]['rate'] 				=	$_app['client_rate'] ; 
                            $app_list[$k]['comment'] 			=	$_app['comment'] ?? ' ';
                            $app_list[$k]['activate_function']  =	$_app['activate_function'] ;
                            $app_list[$k]['update'] 			=	$_app['update'] ;
                            $app_list[$k]['reason'] 			= 	$_app['reason'] ;
                            $app_list[$k]['c_confirm'] 			=	$_app['c_confirm'] ;
                            $app_list[$k]['rep_confirm']		=	$_app['rep_confirm'] ;
                            $app_list[$k]['date_confirm'] 		=	$_app['date_confirm'] ;
                            $app_list[$k]['notes'] 				=	$_app['notes'] ;
                            $app_list[$k]['notifications_done'] =	$_app['notifications_done'] ;
                            $app_list[$k]['status'] 			=	$_app['status'] ;
                            $app_list[$k]['start_time'] 		=	$_app['start_time'] ;
                            $app_list[$k]['end_time'] 			=	$_app['end_time'] ;
                            $app_list[$k]['starting_'] 			=	$_app['starting_'] ;
                            // $arr = ['type'=>'success',['data' => $app_list]] ;
                            // echo json_encode($arr);
                            
                            $clientQuery = $GLOBALS['db']->query(" SELECT * FROM `clients` WHERE `id` = '".$_app['client_id']."' ");
                            $clientsCount = $GLOBALS['db']->resultcount();
                            if( $clientsCount > 0 ){
                                $clientsData = $GLOBALS['db']->fetchitem() ;
                                
                                $govQuery = $GLOBALS['db']->query(" SELECT * FROM `governorates` WHERE `id` = '".$clientsData['governorate']."' ");
                                $gov		 = $GLOBALS['db']->fetchitem();

                                $kindQuery = $GLOBALS['db']->query(" SELECT * FROM `kind` WHERE `id` = '".$clientsData['kind']."' ");
                                $kind		 = $GLOBALS['db']->fetchitem();

                                $clData['client_id']  =	$clientsData['id'] ;
                                $clData['name'] 	  =	$clientsData['name'] ;
                                $clData['email']	  = $clientsData['email'] ;
                                $clData['phone'] 	  = $clientsData['mobile'] ;
                                $clData['job'] 		  = $clientsData['job'] ;
                                $clData['governorate']= $gov['name_ar'] ;
                                $clData['address'] 	  = $clientsData['address'] ;
                                $clData['kind']       = $kind['name_en'] ;
                                $clData['lat']        = $kind['lat'] ?? '0' ;
                                $clData['lon']        = $kind['lon'] ?? '0'  ;

                                $app_list[$k]['client_data'] = $clData ;

                        }
                    
                    }
                            }
                                    
                    $arr[] = $app_list ? $app_list : 'no found appionments' ;
                        
                    $this->terminate('success',"",0,$arr);
                }
            // }


        }
///////////////////////////////////////////////

        public function create_table(){
                        
            $rep_id        = $this->testToken() ;
            $current_date  = $_POST['current_date'];
            $current_month = date('m') ;
            
            $gov = intval($_POST['gov']) ;
            
            if( $_POST['gov'] == ""){
                $this->terminate('error',' must enter governorate',6);
            }
            
            $GLOBALS['db']->query("DELETE LOW_PRIORITY FROM `tasks` WHERE `rep_id` = '".$rep_id."' AND `type` = 'visit2' AND `notifications_done` ='0' ");
            $clientQuery  = $GLOBALS['db']->query(" SELECT * FROM `clients` WHERE `rep_id` = '".$rep_id."' AND `governorate` ='".$gov."'  ");
            $clientsCount = $GLOBALS['db']->resultcount();
            if( $clientsCount  > 0 ){
                $all_client = $GLOBALS['db']->fetchlist();
                foreach( $all_client as $client){
                   
                    $client_kind =  $client['kind'] ;
                    if( $client['kind'] == 1 || $client['kind'] == 2  ){

                        for( $i = 1 ; $i <= 3 ; $i++ ){
                            
                            $from =  date('Y-m-'.$i);
                            $i    += 6 ;  
                            $to   =  date('Y-m-'.$i); 
                            $query_done_task = $GLOBALS['db']->query(" SELECT * FROM `tasks` 
                            WHERE
                            `client_id` = '".$client['id']."' AND `rep_id` = '".$rep_id."' AND `type` = 'visit2'
                            AND `date` BETWEEN '".$from."' AND '".$to."' AND `notifications_done` ='1' LIMIT 1 ") ;
                            
                            $count_task = $GLOBALS['db']->resultcount();
                            if( $count_task  == 0 ){
                                $GLOBALS['db']->query("INSERT INTO `tasks` 
                                (`id`, `client_id`, `rep_id`, `type`, `type_id`, `date`, `notifications_done`, `status`)
                                VALUES 
                                (NULL, '".$client[id]."', '".$rep_id."', 'visit2', '0', NOW(), '0', '1' ) ") ;
                                 
                            }
                        }
                        
                    }elseif( $client['kind'] == 3 ){

                        for( $i = 1 ; $i <= 3 ; $i++ ){

                            $from =  date('Y-m-'.$i);
                            $i     += 15 ;  
                            $to   =  date('Y-m-'.$i); 
                            $query_done_task = $GLOBALS['db']->query(" SELECT * FROM `tasks` 
                            WHERE
                            `client_id` = '".$client['id']."' AND `rep_id` = '".$rep_id."' AND `type` = 'visit2'
                            AND `date` BETWEEN '".$from."' AND '".$to."' AND `notifications_done` ='1' LIMIT 1 ") ;
                            
                            $count_task = $GLOBALS['db']->resultcount();
                            if( $count_task  == 0 ){
                                $GLOBALS['db']->query("INSERT INTO `tasks` 
                                (`id`, `client_id`, `rep_id`, `type`, `type_id`, `date`, `notifications_done`, `status`)
                                VALUES 
                                (NULL, '".$client[id]."', '".$rep_id."', 'visit2', '0', NOW(), '0','1' ) ") ;
                            }
                        }
                    }

                    $current_date = date('Y-m-d') ;
                    $GLOBALS['db']->query(" SELECT clients.kind, tasks.* FROM `tasks`
                                            INNER JOIN `clients` ON tasks.client_id=clients.id 
                                            WHERE 
                                            tasks.rep_id = '".$rep_id."' AND tasks.date = '".$current_date."' AND tasks.type = 'visit2' AND tasks.notifications_done != '1'
                                            ORDER BY clients.kind ASC ") ;
                    $count = $GLOBALS['db']->resultcount() ;
                    if( $count != 0 ){
                        $_appData = $GLOBALS['db']->fetchlist() ;
                        foreach($_appData as  $k => $_app ){

                            $app_list[$k]['app_id'] 			= 	$_app['id'] ;
                            $app_list[$k]['rep_id']				= 	$_app['rep_id'] ;
                            $app_list[$k]['client_id'] 			= 	$_app['client_id'] ;
                            $app_list[$k]['type'] 				= 	$_app['type'] ;
                            $app_list[$k]['type_id'] 			= 	$_app['type_id'] ;
                            $app_list[$k]['date'] 				= 	$_app['date'] ;
                            $app_list[$k]['rate'] 				=	$_app['client_rate'] ?? ' '; 
                            $app_list[$k]['comment'] 			=	$_app['comment'] ?? ' ';
                            $app_list[$k]['activate_function']  =	$_app['activate_function'] ?? ' ';
                            $app_list[$k]['update'] 			=	$_app['update'] ?? ' ';
                            $app_list[$k]['reason'] 			= 	$_app['reason'] ?? ' ';
                            $app_list[$k]['c_confirm'] 			=	$_app['c_confirm'] ?? ' ';
                            $app_list[$k]['rep_confirm']		=	$_app['rep_confirm'] ?? ' ' ;
                            $app_list[$k]['date_confirm'] 		=	$_app['date_confirm'] ?? ' ';
                            $app_list[$k]['notes'] 				=	$_app['notes'] ?? ' ';
                            $app_list[$k]['notifications_done'] =	$_app['notifications_done'] ;
                            $app_list[$k]['status'] 			=	$_app['status'] ;
                            $app_list[$k]['start_time'] 		=	$_app['start_time'] ?? ' ' ;
                            $app_list[$k]['end_time'] 			=	$_app['end_time'] ?? ' ' ;
                            $app_list[$k]['starting'] 			=	$_app['starting_'] ?? ' ' ;
                            // $arr = ['type'=>'success',['data' => $app_list]] ;
                            // echo json_encode($arr);
                            $clientsQuery = $GLOBALS['db']->query(" SELECT * FROM `clients` WHERE `id` = '".$_app['client_id']."' ");
                            $_count = $GLOBALS['db']->resultcount();
                            if( $_count > 0 ){
                                $get_client		  = $GLOBALS['db']->fetchitem();

                                $govQuery = $GLOBALS['db']->query(" SELECT * FROM `governorates` WHERE `id` = '".$get_client['governorate']."' ");
                                $gov		 = $GLOBALS['db']->fetchitem();
    
                                $kindQuery = $GLOBALS['db']->query(" SELECT * FROM `kind` WHERE `id` = '".$get_client['kind']."' ");
                                $kind		 = $GLOBALS['db']->fetchitem();
    
                                $clData['client_id']  =	$get_client['id'] ;
                                $clData['name'] 	  =	$get_client['name'] ;
                                $clData['email']	  = $get_client['email'] ;
                                $clData['phone'] 	  = $get_client['mobile'] ;
                                $clData['job'] 		  = $get_client['job'] ;
                                $clData['governorate']= $gov['name_ar'] ;
                                $clData['address'] 	  = $get_client['address'] ;
                                $clData['kind']       = $kind['name_en'] ;
                                $clData['lat']        = $kind['lat'] ?? '0' ;
                                $clData['lon']        = $kind['lon'] ?? '0'  ;
    
                                $app_list[$k]['client_data'] = $clData ;
    
                            }                            
                    
                        }
                    }
                                    
                    
                    
                                        
                }//end foreach $all_client
                $arr[] = $app_list ? $app_list : $msg['msg']='no found appionments' ;                        
                $this->terminate('success',"",0,$arr);
            }else{
                $msg['msg']    = 'Sorry,do not have clients in this governorate ' ;
                $this->terminate('success',"",0, $msg );
            }
           

        }//end function create table
//////////////////////////////////////////////

    public function create_table2(){
                            
        $rep_id        = $this->testToken() ; 
        // $current_date  = $_POST['current_date'];
        $current_month = date('m') ;
        
        $gov = intval($_POST['gov']) ;
        
        if( $_POST['gov'] == ""){
            $this->terminate('error',' must enter governorate',6);
        }
        
        $GLOBALS['db']->query("DELETE FROM `tasks` WHERE `rep_id` = '".$rep_id."' AND `type` = 'visit2' AND `notifications_done` ='0' ");
        // rep_client_gov.`client_id` AS client_id ,clients.`rep_id` AS rep_id , clients.`governorate` AS client_gov , clients.`kind` AS client_kind , rep_client_gov.`id` AS gov_rep_id 
        $clientQuery  = $GLOBALS['db']->query(" SELECT DISTINCT 
                                                clients.`id` AS client_id ,clients.`rep_id` AS rep_id , clients.`governorate` AS client_gov , clients.`kind` AS client_kind 
                                                FROM `clients`
                                                WHERE clients.`governorate` IN ( SELECT `governorate_id` FROM gonvernrate_reps WHERE rep_id = '".$rep_id."' AND `governorate_id` = '".$gov."' ) ");
        $clientsCount = $GLOBALS['db']->resultcount();
        
        if( $clientsCount  > 0 ){
            
            $all_client = $GLOBALS['db']->fetchlist();
            foreach( $all_client as $client){

                $client_kind =  $client['client_kind'] ;
                if( $client['client_kind'] == 1 || $client['client_kind'] == 2  ){
                    for( $i = 1 ; $i <= 3 ; $i++ ){
                        
                        $from =  date('Y-m-'.$i);
                        $i    += 6 ;  
                        $to   =  date('Y-m-'.$i); 
                        $_d   = date('Y-m-d');
                        $notes = 'زياره مجدوله بتاريخ ('.$_d.')' ;
                        $query_done_task = $GLOBALS['db']->query(" SELECT * FROM `tasks` 
                        WHERE
                        `client_id` = '".$client['client_id']."' AND `rep_id` = '".$rep_id."' AND `type` = 'visit2'
                        AND `date` BETWEEN '".$from."' AND '".$to."' AND `notifications_done` ='1' LIMIT 1 ") ;
                        
                        $count_task = $GLOBALS['db']->resultcount();
                        if( $count_task  == 0 ){
                            $GLOBALS['db']->query("INSERT INTO `tasks` 
                            (`id`, `client_id`, `rep_id`, `type`, `type_id`, `date`, `notifications_done`, `status` , `notes`)
                            VALUES 
                            (NULL, '".$client['client_id']."', '".$rep_id."', 'visit2', '0', NOW(), '0', '1', '".$notes."' ) ") ;
                            
                        }
                    }
                    
                }elseif( $client['client_kind'] == 3 ){
                    
                    for( $i = 1 ; $i <= 3 ; $i++ ){

                        $from =  date('Y-m-'.$i);
                        $i     += 15 ;  
                        $to   =  date('Y-m-'.$i); 
                        $_d   = date('Y-m-d');
                        $notes = 'زياره مجدوله بتاريخ ('.$_d.')' ;
                        $query_done_task = $GLOBALS['db']->query(" SELECT * FROM `tasks` 
                        WHERE
                        `client_id` = '".$client[client_id]."' AND `rep_id` = '".$rep_id."' AND `type` = 'visit2'
                        AND `date` BETWEEN '".$from."' AND '".$to."' AND `notifications_done` ='1' LIMIT 1 ") ;
                        
                        $count_task = $GLOBALS['db']->resultcount();
                        if( $count_task  == 0 ){
                            $GLOBALS['db']->query("INSERT INTO `tasks` 
                            (`id`, `client_id`, `rep_id`, `type`, `type_id`, `date`, `notifications_done`, `status` , `notes`)
                            VALUES 
                            (NULL, '".$client[client_id]."', '".$rep_id."', 'visit2', '0', NOW(), '0','1' ,'".$notes."') ") ;
                        }
                    }
                }

                $current_date = date('Y-m-d') ;
                $GLOBALS['db']->query(" SELECT clients.kind, tasks.* FROM `tasks`
                                        INNER JOIN `clients` ON tasks.client_id=clients.id 
                                        WHERE 
                                        tasks.rep_id = '".$rep_id."' AND tasks.date = '".$current_date."' AND tasks.type = 'visit2' AND tasks.notifications_done != '1'
                                        ORDER BY clients.kind ASC ") ;
                $count = $GLOBALS['db']->resultcount() ;
                if( $count != 0 ){
                    $_appData = $GLOBALS['db']->fetchlist() ;
                    foreach($_appData as  $k => $_app ){

                        $app_list[$k]['app_id'] 			= 	$_app['id'] ;
                        $app_list[$k]['rep_id']				= 	$_app['rep_id'] ;
                        $app_list[$k]['client_id'] 			= 	$_app['client_id'] ;
                        $app_list[$k]['type'] 				= 	$_app['type'] ;
                        $app_list[$k]['type_id'] 			= 	$_app['type_id'] ;
                        $app_list[$k]['date'] 				= 	$_app['date'] ;
                        $app_list[$k]['rate'] 				=	$_app['client_rate'] ?? ' '; 
                        $app_list[$k]['comment'] 			=	$_app['comment'] ?? ' ';
                        $app_list[$k]['activate_function']  =	$_app['activate_function'] ?? ' ';
                        $app_list[$k]['update'] 			=	$_app['update'] ?? ' ';
                        $app_list[$k]['reason'] 			= 	$_app['reason'] ?? ' ';
                        $app_list[$k]['c_confirm'] 			=	$_app['c_confirm'] ?? ' ';
                        $app_list[$k]['rep_confirm']		=	$_app['rep_confirm'] ?? ' ' ;
                        $app_list[$k]['date_confirm'] 		=	$_app['date_confirm'] ?? ' ';
                        $app_list[$k]['notes'] 				=	$_app['notes'] ?? ' ';
                        $app_list[$k]['notifications_done'] =	$_app['notifications_done'] ;
                        $app_list[$k]['status'] 			=	$_app['status'] ;
                        $app_list[$k]['start_time'] 		=	$_app['start_time'] ?? ' ' ;
                        $app_list[$k]['end_time'] 			=	$_app['end_time'] ?? ' ' ;
                        $app_list[$k]['starting'] 			=	$_app['starting_'] ?? ' ' ;
                        // $arr = ['type'=>'success',['data' => $app_list]] ;
                        // echo json_encode($arr);
                        $clientsQuery = $GLOBALS['db']->query(" SELECT * FROM `clients` WHERE `id` = '".$_app['client_id']."' ");
                        $_count = $GLOBALS['db']->resultcount();
                        if( $_count > 0 ){
                            $get_client		  = $GLOBALS['db']->fetchitem();

                            $govQuery = $GLOBALS['db']->query(" SELECT * FROM `governorates` WHERE `id` = '".$get_client['governorate']."' ");
                            $gov		 = $GLOBALS['db']->fetchitem();

                            $kindQuery = $GLOBALS['db']->query(" SELECT * FROM `kind` WHERE `id` = '".$get_client['kind']."' ");
                            $kind		 = $GLOBALS['db']->fetchitem();

                            $clData['client_id']  =	$get_client['id'] ;
                            $clData['name'] 	  =	$get_client['name'] ;
                            $clData['email']	  = $get_client['email'] ;
                            $clData['phone'] 	  = $get_client['mobile'] ;
                            $clData['job'] 		  = $get_client['job'] ;
                            $clData['governorate']= $gov['name_ar'] ;
                            $clData['address'] 	  = $get_client['address'] ;
                            $clData['kind']       = $kind['name_en'] ;
                            $clData['lat']        = $kind['lat'] ?? '0' ;
                            $clData['lon']        = $kind['lon'] ?? '0'  ;

                            $app_list[$k]['client_data'] = $clData ;

                        }                            
                
                    }
                }
                                
                
                
                                    
            }//end foreach $all_client
            if( empty($app_list)  ){
                $msg['msg'] = 'no found appionments' ;
            }else{
                $msg['msg'] = 'success create tables' ;

            }
            $arr[] = $msg ;                        
            $this->terminate('success',"",0,$arr);
        }else{
            $msg['msg']    = 'Sorry,do not have clients in this governorate ' ;
            $this->terminate('success',"",0, $msg );
        }
    

    }
//////////////////////////////////////////////

public function create_table_city(){
                            
    $rep_id        = $this->testToken() ; 
    $current_month = date('m') ;
    
    $cities = $_POST['cities'] ;
    
    if( $_POST['cities'] == ""){
        $this->terminate('error',' must enter cities',6);
    }
    
    $list = explode(',' , $cities );
    foreach( $list as $city){
        $GLOBALS['db']->query("DELETE FROM `tasks` WHERE `rep_id` = '".$rep_id."' AND `type` = 'visit2' AND `notifications_done` ='0' ");
        $govQuery = $GLOBALS['db']->query("SELECT `governorate` FROM cities WHERE `id` = '".$city."' Limit 1 ");
        $govCount = $GLOBALS['db']->resultcount();
        if( $govCount  > 0 ){
            $gov_data = $GLOBALS['db']->fetchitem();
            $gov      = $gov_data['governorate'] ;
            $clientQuery  = $GLOBALS['db']->query(" SELECT DISTINCT 
            clients.`id` AS client_id ,clients.`rep_id` AS rep_id , clients.`governorate` AS client_gov , clients.`kind` AS client_kind 
            FROM `clients`
            WHERE clients.`city` = '".$city."' AND clients.`governorate` IN ( SELECT `governorate_id` FROM gonvernrate_reps WHERE rep_id = '".$rep_id."' AND `governorate_id` = '".$gov."' ) ");
            $clientsCount = $GLOBALS['db']->resultcount();
            if( $clientsCount  > 0 ){
                $all_client = $GLOBALS['db']->fetchlist();
            foreach( $all_client as $client){

                $client_kind =  $client['client_kind'] ;
                if( $client['client_kind'] == 1 || $client['client_kind'] == 2  ){
                    for( $i = 1 ; $i <= 3 ; $i++ ){
                        
                        $from =  date('Y-m-'.$i);
                        $i    += 6 ;  
                        $to   =  date('Y-m-'.$i); 
                        $_d   = date('Y-m-d');
                        $notes = 'زياره مجدوله بتاريخ ('.$_d.')' ;
                        $query_done_task = $GLOBALS['db']->query(" SELECT * FROM `tasks` 
                        WHERE
                        `client_id` = '".$client['client_id']."' AND `rep_id` = '".$rep_id."' AND `type` = 'visit2'
                        AND `date` BETWEEN '".$from."' AND '".$to."' AND `notifications_done` ='1' LIMIT 1 ") ;
                        
                        $count_task = $GLOBALS['db']->resultcount();
                        if( $count_task  == 0 ){
                            $GLOBALS['db']->query("INSERT INTO `tasks` 
                            (`id`, `client_id`, `rep_id`, `type`, `type_id`, `date`, `notifications_done`, `status` ,`notes`)
                            VALUES 
                            (NULL, '".$client['client_id']."', '".$rep_id."', 'visit2', '0', NOW(), '0', '1' , '".$notes."' ) ") ;
                            
                        }
                    }
                    
                }elseif( $client['client_kind'] == 3 ){
                    
                    for( $i = 1 ; $i <= 3 ; $i++ ){

                        $from =  date('Y-m-'.$i);
                        $i     += 15 ;  
                        $to   =  date('Y-m-'.$i); 
                        $_d   = date('Y-m-d');
                        $notes = 'زياره مجدوله بتاريخ ('.$_d.')' ;
                        $query_done_task = $GLOBALS['db']->query(" SELECT * FROM `tasks` 
                        WHERE
                        `client_id` = '".$client[client_id]."' AND `rep_id` = '".$rep_id."' AND `type` = 'visit2'
                        AND `date` BETWEEN '".$from."' AND '".$to."' AND `notifications_done` ='1' LIMIT 1 ") ;
                        
                        $count_task = $GLOBALS['db']->resultcount();
                        if( $count_task  == 0 ){
                            $GLOBALS['db']->query("INSERT INTO `tasks` 
                            (`id`, `client_id`, `rep_id`, `type`, `type_id`, `date`, `notifications_done`, `status` , `notes`)
                            VALUES 
                            (NULL, '".$client[client_id]."', '".$rep_id."', 'visit2', '0', NOW(), '0','1' ,'".$notes."' ) ") ;
                        }
                    }
                }
                
                                    
                }//end foreach $all_client     
                
                $current_date = date('Y-m-d') ;
                $GLOBALS['db']->query(" SELECT clients.kind, tasks.* FROM `tasks`
                                        INNER JOIN `clients` ON tasks.client_id=clients.id 
                                        WHERE 
                                        tasks.rep_id = '".$rep_id."' AND tasks.date = '".$current_date."' AND tasks.type = 'visit2' AND tasks.notifications_done != '1'
                                        ORDER BY clients.kind ASC ") ;
                $count = $GLOBALS['db']->resultcount() ;
                if( $count != 0 ){
                    $_appData = $GLOBALS['db']->fetchlist() ;                
                }

                if( empty($_appData)  ){
                    $msg['msg'] = 'no found appionments' ;
                }else{
                    $msg['msg'] = 'success create tables' ;
                }
                $arr[] = $msg ;                        
                $this->terminate('success',"",0,$arr);
            }else{
                $msg['msg']    = 'Sorry,do not have clients in this cities ' ;
                $this->terminate('success',"",0, $msg );
            } 
        }else{
            $msg['msg']    = 'Sorry,no found this cities ' ;
            $this->terminate('success',"",0, $msg );
        }
        


    }

    

}
//////////////////////////////////////////////
    public function check_in()
    {
        
        $tokenUserId  = $this->testToken();
        // $time_stamp  = sanitize($_POST['time_stamp']);
        $lon  = sanitize($_POST['lon']);
        $lat  = sanitize($_POST['lat']);
        
        // if ($time_stamp !=""){
            
            //$dt=date('d-m-Y', $time_stamp);
            
            // $d = date('Y-m-d', $time_stamp);
            // $t = date('H:i:s', $time_stamp);
            $d = date('Y-m-d');
            $t = date("H:i:s") ;
            
            if ($lon !="" && $lat !="" && $lon !=0 && $lat !=0){
                
                $x=$GLOBALS['db']->query("INSERT INTO `daily_working` 
                                            ( `id` , `rep_id`, `start_time` ,`date` ,`start_lon` , `start_lat` )
                                            VALUES 
                                            ( NULL  , '".$tokenUserId."' , '".$t."' , '".$d."' , '".$lon."' , '".$lat."')");
                $this->terminate('success',"");
            }else{
                $this->terminate('error',"lon and lat");
            }
        
            
        // $this->terminate('success',"");
        // }else{
        //     $this->terminate('error',"error");
        // }
    }
/////////////////////////////////////////////

    public function get_days(){
        $tokenUserId  = $this->testToken() ;
        $lang         = $_POST['lang'] ;

        if( $lang == ''){
            $this->terminate('error' , 'must enter lang ar or en ' ,50 );
        }
        
        $day_query = $GLOBALS['db']->query(" SELECT * FROM `work_days` WHERE `status` = 1 ") ;
        $day_count = $GLOBALS['db']->resultcount() ;
        if($day_count > 0 ){
            $fetch_day = $GLOBALS['db']->fetchlist() ;
            foreach( $fetch_day as $d_id => $_day){
                $list_days[$d_id]['id']    = $_day['id'] ;
                $list_days[$d_id]['name']  = ($lang == 'ar') ? $_day['name_ar'] : $_day['name_en'] ;
                $list_days[$d_id]['name_en']  = $_day['name_en'] ;
                $list_days[$d_id]['num_visit']= $_day['name_en'] ;
            }

            $this->terminate('success',"",0,$list_days);
        }
    }


    public function create_plan(){
        $tokenUserId  = $this->testToken();
        $plans = $_POST['plans'] ;
        
        if( $plans == '' ){
            $this->terminate('error' , 'must enter plan => day1|c1:c2:c3,day2|c1:c2:c3 ' ,50 );
        }else{
            //  day1|c1:c2:c3,day2|c1:c2:c3 
            $array_plan = explode( "," , $plans) ;
            foreach( $array_plan as $_plan){
                //  day1|c1:c2:c3
                $p1  = explode( "|" , $_plan) ;
                $day = sanitize($p1[0]);
                $clients = explode( ":" , $p1[1] ) ;
                
                foreach( $clients as $client ){
                    $day_date = date('Y-m-d',strtotime($day)) ;
                    $client_id = $client ;
                    $type = 'plan' ;
                    
                    $v = ($values != null ) ? $values.',' : $values ;
                    $values = $v ." (NULL ,'".$client_id."', '".$tokenUserId."' ,'".$type."','".$day_date."' ) "   ;

                }
                $GLOBALS['db']->query("INSERT INTO `tasks`
                        (`id`, `client_id`, `rep_id`, `type`, `date` ) 
                        VALUES $values ") ; 

                
            }
            $this->terminate('success',"");

        }
        

        
    }

    public function check_plan(){
        $tokenUserId  = $this->testToken() ; 
        // $dateParam = date('Y-m-d');
        // $week = date('w', strtotime($dateParam));
        // $date = new DateTime($dateParam);
        // $from  = $date->modify("-".$week." day")->format("Y-m-d") ;
        // $to    = $date->modify("+5 day")->format("Y-m-d") ;
        
        ////////////////////////////
        $date = time(); // Change to whatever date you need
        $dotw = $dotw = date('w', $date);
        $start = ($dotw == 6 /* Saturday */) ? $date : strtotime('last Saturday', $date);
        $end = ($dotw == 5 /* Friday */) ? $date : strtotime('next Friday', $date);
        $from =  date('l Y-m-d' , $start) ;
        $to =  date('l Y-m-d' , $end) ;
        ///////////////////////////
        $query = $GLOBALS['db']->query("SELECT * FROM `tasks` WHERE  `type` = 'plan' AND ((`date` <= '".$to."' ) &&(`date` >= '".$from."' ))  ");
        $queryCount = $GLOBALS['db']->resultcount() ;
        if( $queryCount > 0){
            $fetchData = $GLOBALS['db']->fetchlist($query) ;
            foreach( $fetchData as $k=>$task ){
                $client_id = $task['client_id'] ;
                $client_query =  $GLOBALS['db']->query("SELECT `name` FROM `clients` WHERE `id` = '".$client_id."' LIMIT 1 ") ;
                $clientCount = $GLOBALS['db']->resultcount() ;
                if( $clientCount > 0){
                    $fetchClient = $GLOBALS['db']->fetchitem($client_query) ;
                    $date = $task['date'] ;
                    $date_name = date('l', strtotime($date));
                    
                    if( $date_name == 'Saturday' ){
                        $first['Saturday']['day'] = 'Saturday' ;
                        $first['Saturday']['clients'][] = $fetchClient['name'] ;
                        $first['Saturday']['clients_count'] = count($first['Saturday']['clients']) ;
                    }elseif( $date_name == 'Sunday' ){
                        $first['Sunday']['day'] = 'Sunday' ;
                        $first['Sunday']['clients'][] = $fetchClient['name'] ;
                        $first['Sunday']['clients_count'] = count($first['Sunday']['clients']) ;
                    }elseif( $date_name == 'Monday' ){
                        $first['Monday']['day'] = 'Monday' ;
                        $first['Monday']['clients'][] = $fetchClient['name'] ;
                        $first['Monday']['clients_count'] = count($first['Monday']['clients']) ;
                    }elseif( $date_name == 'Tuesday' ){
                        $first['Tuesday']['day'] = 'Tuesday' ;
                        $first['Tuesday']['clients'][] = $fetchClient['name'] ;
                        $first['Tuesday']['clients_count'] = count($first['Tuesday']['clients']) ;
                    }elseif( $date_name == 'Wednesday' ){
                        $first['Wednesday']['day'] = 'Wednesday' ;
                        $first['Wednesday']['clients'][] = $fetchClient['name'] ;
                        $first['Wednesday']['clients_count'] = count($first['Wednesday']['clients']) ;
                    }elseif( $date_name == 'Thursday' ){
                        $first['Thursday']['day'] = 'Thursday' ;
                        $first['Thursday']['clients'][] =  $fetchClient['name'];
                        $first['Thursday']['clients_count'] =  count($first['Thursday']['clients']);
                    }elseif( $date_name == 'Friday' ){
                        $first['Friday']['day'] = 'Friday' ;
                        $first['Friday']['clients'][] = $fetchClient['name'] ;
                        $first['Friday']['clients_count'] = count($first['Friday']['clients']);
                    }

                    if( !isset($first['Saturday']) ){
                        $first['Saturday']['day'] = 'Saturday';
                        $first['Saturday']['clients'] = [];
                        $first['Saturday']['clients_count'] = 0;
                    }

                    if( !isset($first['Sunday']) ){
                        $first['Sunday']['day'] = 'Sunday';
                        $first['Sunday']['clients'] = [];
                        $first['Sunday']['clients_count'] = 0;
                    }

                    if( !isset($first['Monday']) ){
                        $first['Monday']['day'] = 'Monday';
                        $first['Monday']['clients'] = [];
                        $first['Monday']['clients_count'] = 0;
                    }

                    if( !isset($first['Tuesday']) ){
                        $first['Tuesday']['day'] = 'Tuesday';
                        $first['Tuesday']['clients'] = [];
                        $first['Tuesday']['clients_count'] = 0;
                    }

                    if( !isset($first['Wednesday']) ){
                        $first['Wednesday']['day'] = 'Wednesday';
                        $first['Wednesday']['clients'] = [];
                        $first['Wednesday']['clients_count'] = 0;
                    }

                    if( !isset($first['Thursday']) ){
                        $first['Thursday']['day'] = 'Thursday';
                        $first['Thursday']['clients'] = [];
                        $first['Thursday']['clients_count'] = 0;
                    }

                    if( !isset($first['Friday']) ){
                        $first['Friday']['day'] = 'Friday';
                        $first['Friday']['clients'] = [];
                        $first['Friday']['clients_count'] = 0;
                    }
                }
            }

            $this->terminate('success',' ',0, array_values($first));
        }else{
            $this->terminate('empty' , 0 , 'empty' ) ; 
        }
    }


    public function check_out()
    {
        $tokenUserId  = $this->testToken();
        // $time_stamp  = sanitize($_POST['time_stamp']);
        $lon  = sanitize($_POST['lon']);
        $lat  = sanitize($_POST['lat']);
        
        // if ($time_stamp !=""){
            
            //$dt=date('d-m-Y', $time_stamp);
            
            // $d = date('Y-m-d', $time_stamp);
            // $t = date('H:i:s', $time_stamp);
            $d = date('Y-m-d');
            $t = date('Y-m-d G:i:s') ;
            
            if ($lon !="" && $lat !="" && $lon !=0 && $lat !=0){
            
                $query = $GLOBALS['db']->query("SELECT `id` FROM `daily_working` WHERE  `rep_id` = '".$tokenUserId."' ORDER BY `id` DESC LIMIT 1 ");
                $queryCount = $GLOBALS['db']->resultcount() ;
                if( $queryCount == 1 ){
                    $queryfetch = $GLOBALS['db']->fetchitem() ;
                    $work_Id = $queryfetch['id'];
                    $x = $GLOBALS['db']->query("UPDATE `daily_working` set end_time = '".$t."' , end_lon = '".$lon."' , end_lat ='".$lat."' where id = '".$work_Id."' ");
                    $this->terminate('success',"");
                }
                
            }else{
                 $this->terminate('error',"lon and lat");
            }
        
            
        // $this->terminate('success',"");
        // }else{
        //     $this->terminate('error',"error");
        // }
    }

    public function check_rep_in_work()
    {
        $tokenUserId  = $this->testToken();

            $query = $GLOBALS['db']->query("SELECT * FROM `daily_working` WHERE  `rep_id` = '".$tokenUserId."' ORDER BY `id` DESC LIMIT 1 ");
            $queryCount = $GLOBALS['db']->resultcount() ;
            if( $queryCount == 1 ){
                $queryfetch = $GLOBALS['db']->fetchitem() ;
                if( $queryfetch['end_lon'] == 0 && $queryfetch['end_lat'] == 0    ){
                    $msg['msg'] = "rep in work" ;
                    $this->terminate('success',' ',0,$msg);
                }else{ 
                    $msg['msg'] = "rep out work" ;
                    $this->terminate('success',' ',0,$msg);                    
                }

            }else{
                $msg['msg'] = "rep out work" ;
                    $this->terminate('success',' ',0,$msg); 
            }
                
           
        
            
        // $this->terminate('success',"");
        
    }

///////////////////////////////////////////////
    public function change_location(){
        $tokenUserId  = $this->testToken();
		if($tokenUserId != 0){
            $client_id = intval($_POST['client_id']) ;
            $lat       = floatval($_POST['lat']);
            $lon       = floatval($_POST['lon']);
            
            $clientQuery = $GLOBALS['db']->query("SELECT * FROM `clients` WHERE `id`='".$client_id."' LIMIT 1 "); 
            $queryCount  = $GLOBALS['db']->resultcount() ;
            $queryFetch  = $GLOBALS['db']->fetchitem() ;
            $old_lat     = $queryFetch['lat'] ;
            $old_lon     = $queryFetch['lon'] ;


            if( $old_lat == 0 && $old_lon == 0 ){
                $GLOBALS['db']->query("UPDATE `clients` SET `lat`='".$lat."', `lon`='".$lon."' ,`update_location` =NOW()  WHERE `id` = '".$client_id."' LIMIT 1 ") ;
                
                
                // $list['id'] = $client_id ;
                // $list['lat'] = $lat  ;
                // $list['lon'] = $lon ;
                $this->terminate('success','',0) ;
            }else{
                $this->terminate('error' , 'cannot change location , location already exists' ,50 );
            }
            
        }else{
            $this->terminate('error' , 'Udid Or Static Not Correct' ,50 );
        }
    }
///////////////////////////////////////////////
    public function get_bills_to_rep(){
        $rep_id  = $this->testToken();
		if($rep_id != 0){

            $date = sanitize( $_POST['date'] );
            if( $date == '' ){
                $date = date('Y-m-d');
            }
            
            $query_bills = $GLOBALS['db']->query("SELECT COUNT(*) AS count_bills , SUM(total) AS total_price  FROM `orders` WHERE `rep_id`='".$rep_id."' AND `date` = '".$date."' AND `status` = 2 ");
            $query_count = $GLOBALS['db']->resultcount() ;
            if( $query_count > 0){
                $fetch_count = $GLOBALS['db']->fetchitem();

                $query = $GLOBALS['db']->query("SELECT * FROM `orders` WHERE `rep_id`='".$rep_id."' AND `date` = '".$date."' AND `status` = 2 ");
                $count = $GLOBALS['db']->resultcount() ;
                if( $count > 0){
                    $_fetch_order = $GLOBALS['db']->fetchlist();
                    foreach( $_fetch_order as $oId => $order ){

                    
                        $client_query = $GLOBALS['db']->query("SELECT `id`,`name`,`img` FROM `clients` WHERE `id`='".$order[client_id]."' ");
                        $client_count = $GLOBALS['db']->resultcount() ;
                        if( $client_count > 0){
                            $_fetch_client = $GLOBALS['db']->fetchitem();

                            if($order['payment_type'] == 'installment' ){
                                $inst_query = $GLOBALS['db']->query("SELECT `installement` FROM `installments` WHERE `order_id`='".$order[id]."' ORDER BY `id` DESC LIMIT 1 ");
                                $inst_count = $GLOBALS['db']->resultcount() ;
                                if( $inst_count == 1 ){
                                    $_fetch__install = $GLOBALS['db']->fetchitem();
                                    $_fetch_price    = $_fetch__install['installement'] ;
                                }

                            }else{
                                $_fetch_price = $order['total'] ;
                            }
                            


                            $order_details = array(
                                'order_id' =>   $order['id'] ,
                                'payment_type' => $order['payment_type'] ,
                                'client_id'    => $_fetch_client['id'] ,
                                'client_name'  => $_fetch_client['name'] ,
                                'client_img'   => $_fetch_client['img'] ?? ' ' ,
                                'price'        => $_fetch_price ,
                            );
                            
                        }

                        $bill_details[$oId] = $order_details ;
                    }
                    
                }

                $bills['total_bills'] = $fetch_count['count_bills'] ?? [] ;
                $bills['total_price_bills'] = $fetch_count['total_price'] ?? "0";
                $bills['bills'] = $bill_details ?? [] ;

                $this->terminate('success','',0,$bills) ;
            }

        }
    }
///////////////////////////////////////////////

///////////////////////////////////////////////
public function get_bills(){
    $rep_id  = $this->testToken();
    if($rep_id != 0){

        $date = sanitize( $_POST['date'] );

        if( $date == '' ){
            $date = date('Y-m-d');
        }

        
        $query_bills = $GLOBALS['db']->query("SELECT COUNT(*) AS count_bills , SUM(total) AS total_price  FROM `orders` WHERE `rep_id`='".$rep_id."' AND `date` = '".$date."' AND `status` = '2' ");
        $query_count = $GLOBALS['db']->resultcount() ;
        if( $query_count > 0){
            $fetch_count = $GLOBALS['db']->fetchitem();

            $query = $GLOBALS['db']->query("SELECT * FROM `orders` WHERE `rep_id`='".$rep_id."' AND `date` = '".$date."' ");
            $count = $GLOBALS['db']->resultcount() ;
            if( $count > 0){
                $_fetch_order = $GLOBALS['db']->fetchlist();
                foreach( $_fetch_order as $oId => $order ){
                
                    $client_query = $GLOBALS['db']->query("SELECT `id`,`name`,`img` FROM `clients` WHERE `id`='".$order[client_id]."' ");
                    $client_count = $GLOBALS['db']->resultcount() ;
                    if( $client_count > 0){
                        $_fetch_client = $GLOBALS['db']->fetchitem();

                        if($order['payment_type'] == 'installment' ){
                            $inst_query = $GLOBALS['db']->query("SELECT `installement` FROM `installments` WHERE `order_id`='".$order[id]."' ORDER BY `id` DESC LIMIT 1 ");
                            $inst_count = $GLOBALS['db']->resultcount() ;
                            if( $inst_count == 1 ){
                                $_fetch__install = $GLOBALS['db']->fetchitem();
                                $_fetch_price    = $_fetch__install['installement'] ;
                            }

                        }else{
                            $_fetch_price = $order['total'] ;
                        }
                        


                        $order_details = array(
                            'order_id' =>   $order['id'] ,
                            'status' =>   $order['status'] ,
                            'payment_type' => $order['payment_type'] ,
                            'client_id'    => $_fetch_client['id'] ,
                            'client_name'  => $_fetch_client['name'] ,
                            'client_img'   => $_fetch_client['img'] ?? ' ' ,
                            'price'        => $_fetch_price ,
                        );
                        
                    }

                    $bill_details[$oId] = $order_details ;
                }
                
            }

            $bills['total_bills'] = $fetch_count['count_bills'] ?? [] ;
            $bills['total_price_bills'] = $fetch_count['total_price'] ?? "0";
            $bills['bills'] = $bill_details ?? [] ;

            $this->terminate('success','',0,$bills) ;
        }

    }
}

//////////////////////////////////////////////////

    public function get_bills_to_client(){
        $client_id  = $this->testToken();
        if($client_id != 0){

            $month = sanitize( $_POST['month'] );
            if( $month == '' ){
                $month = date('m') ;
            }

            $query_bills = $GLOBALS['db']->query("SELECT COUNT(*) AS count_bills , SUM(total) AS total_price  FROM `orders` WHERE `client_id`='".$client_id."' AND MONTH(`date`) = '".$month."' AND `status` = 2 ");
            $query_count = $GLOBALS['db']->resultcount() ;
            if( $query_count > 0){
                $fetch_count = $GLOBALS['db']->fetchitem();

                $query = $GLOBALS['db']->query("SELECT * FROM `orders` WHERE `client_id`='".$client_id."' AND MONTH(`date`) = '".$month."'  AND `status` = 2 ");
                $count = $GLOBALS['db']->resultcount() ;
                if( $count > 0){
                    $_fetch_order = $GLOBALS['db']->fetchlist();
                    foreach( $_fetch_order as $oId => $order ){

                        if( $order['payment_type'] == 'installment' ){
                            $inst_query = $GLOBALS['db']->query("SELECT `installement` FROM `installments` WHERE `order_id`='".$order[id]."' ORDER BY `id` DESC LIMIT 1 ");
                            $inst_count = $GLOBALS['db']->resultcount() ;
                            if( $inst_count == 1 ){
                                $_fetch__install = $GLOBALS['db']->fetchitem();
                                $_fetch_price    = $_fetch__install['installement'] ;
                            }

                        }else{
                            $_fetch_price = $order['total'] ;
                        }
                        

                        $order_details = array(
                            'order_id' =>   $order['id'] ,
                            'payment_type' => $order['payment_type'] ,
                            'price'        => $_fetch_price ,
                        );
                            

                        $bill_details[$oId] = $order_details ;
                    }
                    
                }

                $bills['total_bills'] = $fetch_count['count_bills'] ?? [] ;
                $bills['total_price_bills'] = $fetch_count['total_price'] ?? [];
                $bills['bills'] = $bill_details ?? [] ;

                $this->terminate('success','',0,$bills) ;
            }

        }
    }


///////////////////////////////////////////////
    public function client_add_order(){
        $tokenUserId  = $this->testToken();
		if($tokenUserId != 0){
            
        $validclientQuery  = $GLOBALS['db']->query(" SELECT * FROM `clients` WHERE `id` = '".$tokenUserId."' AND `block` = 0   LIMIT 1");
        $validclientCount   = $GLOBALS['db']->resultcount();
        if($validclientCount != 1)
        {
            $this->terminate('error','invalid client id Or this client is blocked',50);
        }else
        {
            $clientInfo 		    =   $GLOBALS['db']->fetchitem($validclientQuery);

            $_rep 			        =   $clientInfo['rep_id'] ; 
            $_items 			    =   sanitize($_POST['items']);
            $_payment_type 		    =   sanitize($_POST['payment_type']);
            $_payment_method 	    =   sanitize($_POST['payment_method']);
            $_number_of_month 	    =   intval($_POST['number_of_month']);
            $_number_of_installment =   intval($_POST['number_of_installment']);
            $_note 		     	    =    sanitize($_POST['note']);

            if($_items == "")
            {
                $this->terminate('error','you must insert items',50);
            }else
            {
                $items 				= explode(",",$_items);
                if(is_array($items))
                {   
                    foreach($items as $item)
                    {
                        $itemInfo = explode("|",$item);
//											if(intval($itemInfo[0]) != 0 || intval($itemInfo[1]) != 0)
//											{
                            $validorderItemQuery  = $GLOBALS['db']->query(" SELECT * FROM `products`  WHERE `id` = '".intval($itemInfo[0])."' AND `status` = '1' ");
                            $product = $GLOBALS['db']->fetchitem($validorderItemQuery);
                            $validorderItemCount = $GLOBALS['db']->resultcount();
                            if($validorderItemCount == 1)
                            {
                                $finalItems[$itemInfo[0]] = $itemInfo;
                            }else
                            {
                                continue;
                            }
                            $total += $product['price'] * $itemInfo[1];

//											}else
//											{
//												$this->terminate('error','you must insert product id and count > 0',50);
//											}
                    }
                }else
                {
                    $this->terminate('error','you correct item syntax',50);
                }
                if(is_array($finalItems))
                {   
                    // echo $_number_of_installment ;
                    // echo $_number_of_month ;
                    // echo $_payment_method ;
                    $GLOBALS['db']->query( "INSERT LOW_PRIORITY INTO `orders` (`id`,`by`,`client_id`,`rep_id`,`total`,`remain`,`date`,`time`,`payment_method`,`payment_type`,`number_of_month`, `number_of_installment`,`paid`,`status` ,`note`)
                                            VALUES (NULL,'client', '".$tokenUserId."','".$_rep."','".$total."','".$total."',NOW(),NOW(),'".$_payment_method."','".$_payment_type."','".$_number_of_month."','".$_number_of_installment."' ,'0','0' ,'".$_note."' ) " );
                    $orderId = $GLOBALS['db']->fetchLastInsertId();

                    if($_payment_type == "installment" ){
                        for($i = 0; $i < $_number_of_month ; $i++) {
                            $date = date('Y-m-d',strtotime( +$i.'month' ,strtotime(date('Y-m-d')) ) );
                            $z=$GLOBALS['db']->query("INSERT INTO `installments` 
                            ( `id` ,`client_id` ,`order_id`,`rep_id`, `installement`, `date` ) 
                            VALUES 
                            ( NULL , '".$tokenUserId."', '".$orderId."' ,'" .$_rep. "', '0'  ,'".$date."' )");

                        } 
                    }

                    $i = 1;
                    foreach($finalItems as $finalItem)
                    {   
                        $orderporductQuery    = $GLOBALS['db']->query(" SELECT * FROM `order_products` WHERE `order_id` = '".$orderId."' AND `product_id` = '".$finalItem[0]."' LIMIT 1");
                        $orderporductCount    = $GLOBALS['db']->resultcount();
                        
                        if($orderporductCount == 1)
                        {
                            $this->terminate('error','duplication Priscription_item insert',50);
                        }else
                        {
                            // $finalItem[0]    product_id
                            // $finalItem[1]    quantity
                            $price_product = $GLOBALS['db']->query("SELECT `price` FROM `products` WHERE `id`='".$finalItem[0]."' ");
                            $fetch_price   = $GLOBALS['db']->fetchitem();
                            $price = $fetch_price['price'] ;
                            $total_price =  $price*$finalItem[1] ;

                            $GLOBALS['db']->query( "INSERT LOW_PRIORITY INTO `order_products` (`id`, `order_id`,`product_id`, `quantity`,`status`,`order` , `discount`) VALUES ( NULL ,  '".$orderId."' , '".$finalItem[0]."' ,'".$finalItem[1]."','0','".$i."' , '".$total_price."' ) " );
                        }
                        $i++;
                    }
                    
                    $this->terminate('success','',0);
                }
            }

            $client_old_credit  = $clientInfo['credit'];
            $client_new_credit  = $client_old_credit + $total ;
            $update_credit  = $GLOBALS['db']->query(" UPDATE `clients` SET `credit` = '".$tokenUserId."'WHERE `id`='".$clientInfo['id']."' ");
                                                    

        }
     }else{
        $this->terminate('error' , 'Udid Or Static Not Correct' ,50 );
    }

    }

//////////////////////////////////////
function checkMail($str)
{
    return ( ! preg_match("/^([a-z0-9\+_\-]+)(\.[a-z0-9\+_\-]+)*@([a-z0-9\-]+\.)+[a-z]{2,6}$/ix", $str)) ? 'false' : 'true';
}
    
////////////////////////////////////////
public function terminate($type,$title="",$code="",$additional = "",$_token = "")
{
    header('Content-Type: application/json');
        if($type == "error"){
            $errorData = array(
                'title'			=>			$title,
                'time'			=>			date("M j,Y \a\\t h:i A"),
                'timestamp'		=>			time(),
                'status'		=>			$code,
                'additional'	=>			$additional
            );
            $output = array(
                'type'		=> 				"error",
                'data'		=>				$errorData 				
            );
        }elseif($type == "success"){
            if($additional != "")
            {
                if(is_array($additional))
                {
                    if(array_values($additional) === $additional)
                    {
                        $output = array(
                            'type'		=> 		"success",
                            'data'		=> 		$additional
                        );
                    }else
                    {
                        $successAdditionalData = $additional;
                        $output = array(
                            'type'		=> 		"success",
                            'data'		=> 		$successAdditionalData
                        );
                    }
                }else
                {
                    $successAdditionalData = $additional;
                    $output = array(
                        'type'		=> 		"success",
                        'data'		=> 		$successAdditionalData
                    );
                }
            }else
            {
                $data = array(
                    'time'			=>			date("M j,Y \a\\t h:i A"),
                    'timestamp'		=>			time()
                );
                $output = array(
                    'type'		=> 		"success",
                    'data'		=> 		$data
                );
            }

        }elseif($type == "empty"){
            $emptyData = array();
            $emptyData[] = array(
                'title'			=>			$title,
                'time'			=>			date("M j,Y \a\\t h:i A"),
                'timestamp'		=>			time(),
                'status'		=>			$code
            );
            $output = array(
                'type'		=> 				"empty",
                'data'		=> 				$emptyData				
            );

        }
        die(json_encode($output));

}
////////////////////////////////////////////////////////////////////
    
    private function getDefaultPag($attribute = "unknown")	
    {
        $settings = array(
            "url"				=> "http://".$_SERVER['SERVER_NAME']."/SFA/",
            "pagination"		=> 5,
            "unknown"			=> "unknown",
        );
        $this->settings = $settings;
        return ($settings[$attribute]);
    }

    public function sent_notification($kind,$user_id, $message,$key){
        $query 		= $GLOBALS['db']->query("SELECT * FROM `notifications` WHERE `user_type`  = '".$kind."' AND `user_id` = '".$user_id."' AND `receive_status` =1 ");
        $queryTotal = $GLOBALS['db']->resultcount();
        if($queryTotal > 0){
            $token = $GLOBALS['db']->fetchitem($query);
       
            $fields = array
                (
                    'to'					=> $token[not_token],
                    'data'					=> array
                    (
                        'type'				=> 'postpone',
                        'postpone_date'	    => $message
                    ),
                    'notification'          => array
                    (
                        'title'				=> 'SFA',
                        'text'				=> $message,
                        'click_action'		=> 'home_activity',
                        'sound'				=> 'true',
                        'icon'				=> 'logo'
                    )
                );
            $headers = array
            (
                'Authorization: key='. $key,
                'Content-Type: application/json'
            );
            $ch = curl_init();
            curl_setopt( $ch,CURLOPT_URL, 'https://fcm.googleapis.com/fcm/send' );
            curl_setopt( $ch,CURLOPT_POST, true );
            curl_setopt( $ch,CURLOPT_HTTPHEADER, $headers );
            curl_setopt( $ch,CURLOPT_RETURNTRANSFER, true );
            curl_setopt( $ch,CURLOPT_SSL_VERIFYPEER, false );
            curl_setopt( $ch,CURLOPT_POSTFIELDS, json_encode( $fields ) );
            $result = curl_exec($ch );
            curl_close( $ch );

        }
    }












}

