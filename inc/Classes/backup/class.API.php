<?php if(!defined("inside")) exit;

//echo '<meta charset="utf-8">';

class API
{
	var $host = "";
	var $settings = array();

	private function getDefaults($attribute = "unknown")
	{
		$settings = array(
			"url"				=> "http://".$_SERVER['SERVER_NAME']."/eTTamin/patient/",
			"pagination"		=> 10,
			"unknown"			=> "unknown",
		);
		$this->settings = $settings;
		return ($settings[$attribute]);
	}

	private function format_distance ($distance)
    {
        $distance = $distance * 1000;
        if($distance < 1000 )
        {
            $fullDistance = "~ ".ceil($distance). " M";
        }elseif($distance > 1000 )
        {
            $distance = $distance / 1000 ;
            $fullDistance = "~ ".ceil($distance). " Km";
        }
        return ($fullDistance);
        return ($distance);
    }

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

	private function is_timestamp($timestamp)
	{
		// trim the last three zeros if 13.
		if(ctype_digit($timestamp) && strtotime(date('Y-m-d H:i:s',$timestamp)) === (int)$timestamp)
		{
			return true;
		}else
		{
			return false;
		}
	}

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

	private function updateLoginTime($in,$who)
	{
		$GLOBALS['db']->query("UPDATE LOW_PRIORITY `".$in."` SET `log_time`= now() WHERE `id` = '".$who."' LIMIT 1");
	}

	private function updateToken($in,$who,$udid)
	{
		$GLOBALS['db']->query("DELETE LOW_PRIORITY FROM `tokens` WHERE `user_id` = '".$who."' AND `udid` = '".($udid)."' ");

		$staticKey = $this->generateKey(20);

		$GLOBALS['db']->query("INSERT LOW_PRIORITY INTO `tokens` ( `id` , `token` , `type` , `user_id` , `udid` , `time` ) VALUES ( NULL ,  '".$staticKey."' ,  'patient' ,  '".$who."', '".$udid."', '".time()."' ) ");
		return $staticKey;
	}

	private function buildMembershipCredintials($in="",$credintials="",$token="",$addons = array())
	{
		if($in == "patient")
		{
			$userData = array(
				"id"				=>		$credintials["id"],
				"facebook"			=>		$credintials["facebook"],
				"fb_id"				=>		$credintials["fb_id"],
				"google"			=>		$credintials["google"],
				"google_id"			=>		$credintials["google_id"],
				"name"				=>		$credintials["name"],
				"address"			=>		$credintials["address"],
				"email"				=>		$credintials["email"],
				"email_verified"	=>		$credintials["email_verified"],
				"mobile"			=>		$credintials["mobile"],
				"mobile_verified"	=>		$credintials["mobile_verified"],
				"verified"			=>		$credintials["verified"],
				"avatar"			=>		($credintials["avatar"] == "") ? $this->getDefaults("url")."uploads/defaults/user.png" : $this->getDefaults("url").$credintials["avatar"],
				"status"			=>		$credintials["status"],
				"allow_sms"			=>		$credintials["allow_sms"],
				"reg_time"			=>		$credintials["reg_time"],
				"log_time"			=>		$credintials["log_time"],
			);
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
		}
		return $userData;
	}

	public function GetCountries()
    {
        $_countries = $GLOBALS['db']->query("SELECT * FROM `countries` WHERE `status` = '1'");
		$_countries_details = $GLOBALS['db']->fetchlist($_countries);
		if($_countries_details)
		{
			foreach($_countries_details as $cId => $country)
			{
				$_cities = $GLOBALS['db']->query("SELECT id,name FROM `cities` WHERE `status` = '1' AND `country` = '".$country['id']."'");
				$_cities_details = $GLOBALS['db']->fetchlist($_countries);

				$_countries_details[$cId]['id']             = $country['id'];
				$_countries_details[$cId]['name']     		= html_entity_decode($country['name']);
				$_countries_details[$cId]['flag']        	= ($country["flag"] == "") ? $this->getDefaults("url")."uploads/defaults/flags/eg.png" : $this->getDefaults("url").$country['flag'];
				$_countries_details[$cId]['key']      		= $country['key'];
				$_countries_details[$cId]['cities']      	= (is_array($_cities_details)) ? $_cities_details : array();
			}
			$this->terminate('success','',0,$_countries_details);
		}else
		{
			$this->terminate('error','empty json data',50);
		}
    }

	public function AddNewPatientRegisterar($type = "normal")
	{
		if(sanitize($_POST['email']) == "")
		{
			$this->terminate('error','عفواً يجب إدخال البريد الإلكتروني',3);
		}else
		{
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
					if(checkMail($_POST['email']) === "false")
					{
						$this->terminate('error','عفواً يجب إدخال البريد الإلكتروني بشكل صحيح',3);
					}else
					{
						if(intval($_POST['country']) == 0)
						{
							$this->terminate('error','عفواً يجب إختيار الدولة',3);
						}else
						{
							if(intval($_POST['city']) == 0)
							{
								$this->terminate('error','عفواً يجب إختيار المدينة',3);
							}else
							{
								$countrynCityQuery = $GLOBALS['db']->query(" SELECT * FROM `cities` WHERE  `status` = '1' AND `id` = '".intval($_POST['city'])."' AND `country` = '".intval($_POST['country'])."' LIMIT 1");
								$countrynCityQueryCount = $GLOBALS['db']->resultcount();
								if($countrynCityQueryCount != 1)
								{
									$this->terminate('error','عفواً يجب إختيار المدينة والدولة بشكل صحيح',12);
								}else
								{
									$countryQuery = $GLOBALS['db']->query(" SELECT * FROM `countries` WHERE  `status` = '1' AND `id` = '".intval($_POST['country'])."' LIMIT 1");
									$countryQueryCount = $GLOBALS['db']->resultcount();
									if($countryQueryCount != 1)
									{
										$this->terminate('error','عفواً يجب إختيار الدولة بشكل صحيح',12);
									}else
									{
										$countryData = $GLOBALS['db']->fetchitem($countryQuery);
										if($type == "normal")
										{
											if(sanitize($_POST['pass']) == "" || sanitize($_POST['pass2']) == "" )
											{
												$this->terminate('error','عفواً يجب إدخال كلمة المرور وتأكيد كلمة المرور',11);
											}else
											{
												if( $_pass != $_pass2 )
												{
													$this->terminate('error','عفواً كلمتي المرور غير متطابقتان',12);
												}else
												{
													if (strlen(sanitize($_POST['mobile'])) != $countryData['length'] || !is_numeric(sanitize($_POST['mobile'])) )
													{
														$this->terminate('error','عفواً رقم الجوال يجب أن يكون '.$countryData['length'].' رقم ',7);
													}else
													{
														$_mail 			= 		sanitize(strtolower($_POST['email']));
														$_mobile 		= 		sanitize($_POST['mobile']);
														$_name 			= 		sanitize($_POST['name']);
														$_country 		= 		intval($_POST['country']);
														$_city 			= 		intval($_POST['city']);
														$_pass 			= 		sanitize($_POST['pass']);
														$_pass2 		=		sanitize($_POST['pass2']);

														$GLOBALS['db']->query(" SELECT * FROM `patients` WHERE `email` = '".($_mail)."' OR `mobile` = '".($_mobile)."' ");
														$prevReg = $GLOBALS['db']->resultcount();
														if($prevReg > 0 )
														{
															$this->terminate('error','عفواً البريد الإلكتروني أو رقم الهاتف تم إستخدامهم مسبقاً لحساب آخر',13);
														}else
														{
															$system = new SystemLogin();
															$mobileRandomKey 	= $this->generateKey(5);
															$mailRandomKey 		= $this->generateKey(5);
															$GLOBALS['db']->query
																("
																	INSERT INTO `patients`
																	(
																		`name` , `password`  , `email` , `email_key` , `mobile` , `mobile_key` , `group` , `avatar` , `status` , `reg_time` , `allow_sms` , `address`, `country`, `city`
																	) VALUES
																	(
																		'".$_name."' , '".md5($system->salt.$_pass.$system->salt)."' ,  '".$_mail."'  ,  '".$mailRandomKey."'  ,  '".$_mobile."' , '".$mobileRandomKey."' ,  '1' , '' , '1' , '".date("Y-m-d H:i:s")."' ,  '1'  ,  '' ,  '".$_country."',  '".$_city."'
																	)
																");
															$pid = $GLOBALS['db']->fetchLastInsertId();

															// send sms with $mobileRandomKey for activation.
															// send mail with $mailRandomKey for activation.
															// insert log
															$this->terminate('success',"",0);
														}
													}
												}
											}
										}elseif($type == "facebook")
										{
											if (strlen(sanitize($_POST['mobile'])) != $countryData['length'] || !is_numeric(sanitize($_POST['mobile'])) )
											{
												$this->terminate('error','عفواً رقم الجوال يجب أن يكون '.$countryData['length'].' رقم ',7);
											}else
											{
												$_mail 			= 		sanitize(strtolower($_POST['email']));
												$_mobile 		= 		sanitize($_POST['mobile']);
												$_name 			= 		sanitize($_POST['name']);
												$_country 		= 		intval($_POST['country']);
												$_city 			= 		intval($_POST['city']);
												$_fbId 			= 		sanitize($_POST['fb_id']);
												$_fbToken 		= 		sanitize($_POST['fb_token']);

												$GLOBALS['db']->query(" SELECT * FROM `patients` WHERE `email` = '".($_mail)."' OR `mobile` = '".($_mobile)."' ");
												$prevReg = $GLOBALS['db']->resultcount();
												if($prevReg > 0 )
												{
													$this->terminate('error','عفواً البريد الإلكتروني أو رقم الهاتف تم إستخدامهم مسبقاً لحساب آخر',13);
												}else
												{
													$system = new SystemLogin();
													$mobileRandomKey 	= $this->generateKey(5);
													$mailRandomKey 		= $this->generateKey(5);
													$GLOBALS['db']->query
														("
															INSERT INTO `patients`
															(
																`name` , `facebook`  ,`fb_id`  ,`fb_secret`  , `email` , `email_key` , `mobile` , `mobile_key` , `group` , `avatar` , `status` , `reg_time` , `allow_sms` , `address`, `country`, `city`
															) VALUES
															(
																'".$_name."' , '1' , '".$_fbId."' , '".$_fbToken."' ,  '".$_mail."'  ,  '".$mailRandomKey."'  ,  '".$_mobile."' , '".$mobileRandomKey."' ,  '1' , '' , '1' , '".date("Y-m-d H:i:s")."' ,  '1'  ,  '' ,  '".$_country."',  '".$_city."'
															)
													");
													$pid = $GLOBALS['db']->fetchLastInsertId();

													// send sms with $mobileRandomKey for activation.
													// send mail with $mailRandomKey for activation.
													// insert log
													$this->terminate('success',"",0,array("fb"=>1));
												}
											}
										}elseif($type == "google")
										{
											if (strlen(sanitize($_POST['mobile'])) != $countryData['length'] || !is_numeric(sanitize($_POST['mobile'])) )
											{
												$this->terminate('error','عفواً رقم الجوال يجب أن يكون '.$countryData['length'].' رقم ',7);
											}else
											{
												$_mail 			= 		sanitize(strtolower($_POST['email']));
												$_mobile 		= 		sanitize($_POST['mobile']);
												$_name 			= 		sanitize($_POST['name']);
												$_country 		= 		intval($_POST['country']);
												$_city 			= 		intval($_POST['city']);
												$_googleId 		= 		sanitize($_POST['google_id']);
												$_googleToken 	= 		sanitize($_POST['google_token']);

												$GLOBALS['db']->query(" SELECT * FROM `patients` WHERE `email` = '".($_mail)."' OR `mobile` = '".($_mobile)."' ");
												$prevReg = $GLOBALS['db']->resultcount();
												if($prevReg > 0 )
												{
													$this->terminate('error','عفواً البريد الإلكتروني أو رقم الهاتف تم إستخدامهم مسبقاً لحساب آخر',13);
												}else
												{
													$system = new SystemLogin();
													$mobileRandomKey 	= $this->generateKey(5);
													$mailRandomKey 		= $this->generateKey(5);
													$GLOBALS['db']->query
														("
															INSERT INTO `patients`
															(
																`name` , `google`  ,`google_id`  ,`google_secret`  , `email` , `email_key` , `mobile` , `mobile_key` , `group` , `avatar` , `status` , `reg_time` , `allow_sms` , `address`, `country`, `city`
															) VALUES
															(
																'".$_name."' , '1' , '".$_googleId."' , '".$_googleToken."' ,  '".$_mail."'  ,  '".$mailRandomKey."'  ,  '".$_mobile."' , '".$mobileRandomKey."' ,  '1' , '' , '1' , '".date("Y-m-d H:i:s")."' ,  '1'  ,  '' ,  '".$_country."',  '".$_city."'
															)
													");
													$pid = $GLOBALS['db']->fetchLastInsertId();

													// send sms with $mobileRandomKey for activation.
													// send mail with $mailRandomKey for activation.
													// insert log
													$this->terminate('success',"",0,array("gogole"=>1));
												}
											}
										}else
										{
											$this->terminate('error','عفواً طريقة إضافة عضو خاطئة',13);
										}
									}
								}
							}
						}
					}
				}
			}
		}
	}

	public function checkPatientCredintials()
	{
		$_fbId 					= sanitize($_POST['fb_id']);
		$_fbToken 				= sanitize($_POST['fb_token']);
		$udid 					= sanitize($_POST['udid']);
		if ( $_fbId != "" && $_fbToken != "" )
		{
			$GLOBALS['db']->query(" SELECT * FROM `patients` WHERE `fb_id` = '".$_fbId."' AND `facebook` = 1 LIMIT 1 ");
			$oldRegFB = $GLOBALS['db']->resultcount();

			if( $oldRegFB == 1 )
			{
				$userCredintials = $GLOBALS['db']->fetchitem($userLoginQuery);
				$staticKey 				= $this->updateToken("patients",$userCredintials['id'],$udid);
				$this->updateLoginTime("patients",$userCredintials['id']);
				$GLOBALS['db']->query("UPDATE LOW_PRIORITY `pushs` SET `out` = '0'  WHERE `type` = 'patient' AND `user_id` = '".$userCredintials['id']."' ");
				$_patientCredintials 	= $this->buildMembershipCredintials("patient",$userCredintials,$staticKey);
				// insert log
				$this->terminate('success',"",0,$_patientCredintials);
			}else
			{
				// register this user.
				$this->AddNewPatientRegisterar("facebook");
			}
		}else
		{
			$_googleId 			= sanitize($_POST['google_id']);
			$_googleToken 		= sanitize($_POST['google_token']);
			$udid 				= sanitize($_POST['udid']);
			if ( $_googleId != "" && $_googleToken != "" )
			{
				$GLOBALS['db']->query(" SELECT * FROM `patients` WHERE `google_id` = '".$_googleId."' AND `google` = 1 LIMIT 1 ");
				$oldRegGoogle = $GLOBALS['db']->resultcount();

				if( $oldRegGoogle == 1 )
				{
					$userCredintials = $GLOBALS['db']->fetchitem($userLoginQuery);
					$staticKey 				= $this->updateToken("patients",$userCredintials['id'],$udid);
					$this->updateLoginTime("patients",$userCredintials['id']);
					$GLOBALS['db']->query("UPDATE LOW_PRIORITY `pushs` SET `out` = '0'  WHERE `type` = 'patient' AND `user_id` = '".$userCredintials['id']."' ");
					$_patientCredintials 	= $this->buildMembershipCredintials("patient",$userCredintials,$staticKey);
					// insert log
					$this->terminate('success',"",0,$_patientCredintials);
				}else
				{
					// register this user.
					$this->AddNewPatientRegisterar("google");
				}
			}else
			{
				if(sanitize($_POST['empho']) == "" || sanitize($_POST['pass']) == "" )
				{
					$this->terminate('error','عفواً يجب إدخال البريد الإلكتروني أو رقم الهاتف وكلمة المرور',1);
				}else
				{
					$_empho = sanitize(strtolower($_POST['empho']));
					$_pass = sanitize($_POST['pass']);
					$udid = sanitize($_POST['udid']);
					$system = new SystemLogin();

					$userLoginQuery = $GLOBALS['db']->query(" SELECT * FROM `patients` WHERE ( `email` = '".$_empho."' OR `mobile` = '".$_empho."' ) AND `password` = '".md5($system->getSalt().$_pass.$system->getSalt())."' LIMIT 1");
					$userCount = $GLOBALS['db']->resultcount();
					if($userCount == 1)
					{
						$PatientCredintials 	= $GLOBALS['db']->fetchitem($userLoginQuery);
						$staticKey 				= $this->updateToken("patients",$PatientCredintials['id'],$udid);
						$this->updateLoginTime("patients",$PatientCredintials['id']);
						$GLOBALS['db']->query("UPDATE LOW_PRIORITY `pushs` SET `out` = '0'  WHERE `type` = 'patient' AND `user_id` = '".$PatientCredintials['id']."' ");
						$_patientCredintials 	= $this->buildMembershipCredintials("patient",$PatientCredintials,$staticKey);
						// insert log
						$this->terminate('success',"",0,$_patientCredintials);
					}else
					{
						$this->terminate('error','عفواً بيانات الدخول خاطئة',2);
					}
				}
			}
		}
	}

	public function activateNewPatientRegisterar()
	{
		if(sanitize($_POST['empho']) == "" || sanitize($_POST['key']) == "" || sanitize($_POST['udid']) == "" )
		{
			$this->terminate('error','عفواً يجب إدخال البريد الإلكتروني أو رقم الهاتف والرقم المختصر ومعرف الجهاز',33);
		}else
		{
			$_empho     = sanitize(strtolower($_POST['empho']));
			$_key      = sanitize($_POST['key']);
            $udid      = sanitize($_POST['udid']);

			if (strlen($_key) != 5)
			{
				$this->terminate('error','عفواً يجب أن يكون الرقم مكون من خمس أرقام',34);
			}else
			{
                $keyUserQuery = $GLOBALS['db']->query(" SELECT * FROM `patients` WHERE ( `email`='".$_empho."' OR `mobile`='".$_empho."' )  AND `mobile_key` = '".($_key)."' LIMIT 1 ");
	            $prevReg = $GLOBALS['db']->resultcount();
                if($prevReg == 1 )
	            {
					$userCredintials = $GLOBALS['db']->fetchitem($keyUserQuery);

					$GLOBALS['db']->query("UPDATE LOW_PRIORITY `patients` SET `mobile_verified` = '1' , `mobile_key` = '' WHERE `id` = '".$userCredintials['id']."' LIMIT 1");

					$staticKey = $this->updateToken("patients",$PatientCredintials['id'],$udid);

					$this->updateLoginTime("patients",$userCredintials['id']);

					$_userCredintials 	= $this->buildMembershipCredintials("patient",$userCredintials,$staticKey);
					// insert log
					$this->terminate('success',"",0,$_userCredintials);
	            }else
	            {
	            	$this->terminate('error','wrong key !',1282);
	            }
			}
		}
	}

	public function setPatientAvatar()
	{
        $tokenUserId  = $this->testToken();
        if($tokenUserId != 0)
        {
            $userQuery = $GLOBALS['db']->query(" SELECT * FROM `patients` WHERE `id` = '".$tokenUserId."' LIMIT 1");
            $usersCount = $GLOBALS['db']->resultcount();
            if($usersCount == 1)
            {
                if($_FILES)
				{
                    if(!empty($_FILES['avatar']['error']))
					{
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
					}elseif(empty($_FILES['avatar']['tmp_name']) || $_FILES['avatar']['tmp_name'] == 'none')
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
					    $upload    = new Upload($allow_ext,false,0,0,5000,"../uploads/",".","",false,'patient_');
			       		$files[name] 	= addslashes($_FILES["avatar"]["name"]);
						$files[type] 	= $_FILES["avatar"]['type'];
						$files[size] 	= $_FILES["avatar"]['size']/1024;
						$files[tmp] 	= $_FILES["avatar"]['tmp_name'];
			        	$files[ext]		= $upload->GetExt($_FILES["avatar"]["name"]);


			        	$upfile	= $upload->Upload_File($files);

			        	if($upfile)
						{
			                $imgUrl =  "uploads/". $upfile[ext] . "/" .  $upfile[newname];

						}else
						{
			               $this->terminate('error','عفوا لم نتمكن من تحميل الملف',210);
						}

						@unlink($_FILES['avatar']);
					}

					$userQuery = $GLOBALS['db']->query(" SELECT * FROM `patients` WHERE `id` = '".$tokenUserId."' LIMIT 1");
					$userCredintials = $GLOBALS['db']->fetchitem($userQuery);
					if($userCredintials['avatar'] != "")
					{
						@unlink("../".$userCredintials['avatar']);
						$userCredintials['avatar'] = $imgUrl;
					}

                    $GLOBALS['db']->query("UPDATE LOW_PRIORITY `patients` SET `avatar`='".$imgUrl."' WHERE `id` = '".$tokenUserId."' LIMIT 1");

					$_userCredintials 	= $this->buildMembershipCredintials("patient",$userCredintials,"");
					// insert log
					$this->terminate('success','',0,$_userCredintials);
				}else
                {
                    $this->terminate('error','missing image data',100);
                }
            }
        }
	}

	public function setPatientPassword()
	{
        $tokenUserId  = $this->testToken();
        if($tokenUserId != 0)
        {
            $userQuery = $GLOBALS['db']->query(" SELECT * FROM `patients` WHERE `id` = '".$tokenUserId."' LIMIT 1");
            $usersCount = $GLOBALS['db']->resultcount();
            if($usersCount == 1)
            {
                $userCredintials = $GLOBALS['db']->fetchitem($userQuery);
                $system = new SystemLogin();

				if($userCredintials['facebook'] == 1)
				{
					$this->terminate('error','facebook users have no passwords !',180);
				}elseif($userCredintials['google'] == 1)
				{
					$this->terminate('error','google users have no passwords !',180);
				}else
				{
					$_newPassword = sanitize($_POST['new_password']);
					$_newPassword2 = sanitize($_POST['new_password2']);
					$_oldPassword = sanitize($_POST['old_password']);

					if(  $userCredintials['password']  != md5($system->getSalt().$_oldPassword.$system->getSalt() )  )
					{
						$this->terminate('error','invalid password ',180);
					}else
					{
						if( ($_newPassword != "") && ($_newPassword2 != "") && ($_newPassword == $_newPassword2) )
						{
							$newHashedPassword = md5(($system->salt.$_newPassword.$system->salt));

							$system->setPassword($_newPassword);

							$GLOBALS['db']->query("UPDATE LOW_PRIORITY `patients` SET `password`='".$newHashedPassword."',`chng_time` = now() WHERE `id` = '".$userCredintials['id']."' LIMIT 1");

							// insert log
							$this->terminate('success','',0,"");
						}else
						{
							$this->terminate('error','wrong password match ',180);
						}
					}
				}
            }
        }
	}

	public function setPatientPushId()
	{
		$tokenUserId  = $this->testToken();
        if($tokenUserId != 0){
			$userQuery = $GLOBALS['db']->query(" SELECT * FROM `patients` WHERE `id` = '".$tokenUserId."' LIMIT 1");
			$usersCount = $GLOBALS['db']->resultcount();
			if($usersCount == 1)
			{
				$userCredintials = $GLOBALS['db']->fetchitem($userQuery);
				if(sanitize($_POST['kind']) == "" || sanitize($_POST['pushid']) == "" )
				{
					$this->terminate('error','عفواً يجب إدخال نوع الهاتف ورقم البوش',19);
				}else
				{
					$_kind 		= sanitize($_POST['kind']);
					$_pushid 	= sanitize($_POST['pushid']);
					$_udid 		= sanitize($_POST['udid']);
					if($_pushid == "")
					{
						$this->terminate('error','عفواً يجب إدخال رقم البوش',20);
					}else
					{
						if($_kind != "ios" && $_kind !="android")
						{
							$this->terminate('error','عفواً يجب إدخال نوع الهاتف أولاً',21);
						}else
						{
							$pushQuery = $GLOBALS['db']->query("SELECT * FROM `pushs` WHERE `user_id` = '".$userCredintials['id']."' AND `type` = 'patient' AND `mobile` = '".$_kind."' AND `udid` = '".$_udid."' LIMIT 1");
							$pushCount = $GLOBALS['db']->resultcount();
							if($pushCount == 1)
							{
								$pushData = $GLOBALS['db']->fetchitem($pushQuery);
								$GLOBALS['db']->query("UPDATE LOW_PRIORITY `pushs` SET `pushid` = '".$_pushid."'  WHERE `id` = '".$pushData['id']."' LIMIT 1");
								$this->terminate('success',"",0);
							}else
							{
								$GLOBALS['db']->query( "INSERT LOW_PRIORITY INTO `pushs` ( `id` , `type` , `user_id` , `mobile` , `pushid` , `udid`, `out`) VALUES ( NULL ,  'patient' , '".$userCredintials['id']."' ,  '".$_kind."' , '".$_pushid."', '".$_udid."',  '0') " );
								$this->terminate('success',"",0);
							}
						}
					}
				}
			}else
			{
            	$this->terminate('error','عفواً البيانات خاطئة ( البريد الإلكتروني أو رقم الهاتف )',18);
			}
		}
	}

	public function doLogOut()
	{
		$tokenUserId  = $this->testToken();
        if($tokenUserId != 0)
        {
            $userQuery = $GLOBALS['db']->query(" SELECT * FROM `patients` WHERE `id` = '".$tokenUserId."' LIMIT 1");
            $usersCount = $GLOBALS['db']->resultcount();
            if($usersCount == 1)
            {
                $userCredintials = $GLOBALS['db']->fetchitem($userQuery);
				$GLOBALS['db']->query("UPDATE LOW_PRIORITY `pushs` SET `out` = '1'  WHERE `type` = 'patient' AND `user_id` = '".$userCredintials['id']."' ");
            	$this->terminate('success',"",0);
			}
        }
	}

	public function getPatientCredintials()
	{
        $tokenUserId  = $this->testToken();
        if($tokenUserId != 0)
        {
            $userQuery = $GLOBALS['db']->query(" SELECT * FROM `patients` WHERE `id` = '".$tokenUserId."' LIMIT 1");
            $usersCount = $GLOBALS['db']->resultcount();
            if($usersCount == 1)
            {
                $userCredintials = $GLOBALS['db']->fetchitem($userQuery);
				$_userCredintials 	= $this->buildMembershipCredintials("patient",$userCredintials,"");
				$this->terminate('success','',0,$_userCredintials);
				// insert log

				/*$privacy = '';
				if($_POST['privacy']) // privacy = 1 , not privacy = 0
				{
					$privacy = $_POST['privacy'];
					$_privacy = " AND `patient_histories`.`privacy` = $privacy ";
				}

                $_hestories = $GLOBALS['db']->query("SELECT * FROM `patient_histories` left JOIN attaches ON patient_histories.attach = attaches.id WHERE `patient_histories`.`patient_id` = '".$tokenUserId."' $_privacy ");
                $_hestories_details = $GLOBALS['db']->fetchlist($_hestories);

                $_userCredintials['hestories'] = $_hestories_details;
				*/


            }else
            {
                $this->terminate('error','invalid user login data',50);
            }
        }
	}

	public function setPatientCredintials()
	{
        $tokenUserId  = $this->testToken();
        if($tokenUserId != 0)
        {
            $userQuery = $GLOBALS['db']->query(" SELECT * FROM `patients` WHERE `id` = '".$tokenUserId."' LIMIT 1");
            $usersCount = $GLOBALS['db']->resultcount();
            if($usersCount == 1)
            {
                $system 			= new SystemLogin();
                $userCredintials 	= $GLOBALS['db']->fetchitem($userQuery);
                $_name 				= sanitize($_POST['name']);
                $_mail 				= sanitize(strtolower($_POST['email']));
                $_mobile 			= sanitize($_POST['mobile']);
                $_address 			= sanitize($_POST['address']);
                $_allow_sms 		= intval($_POST['allow_sms']);

                if($_mail != $userCredintials['email'] && $_mail != "")
			 	{
					if(checkMail($_mail) === "false")
					{
						$this->terminate('error','عفواً يجب إدخال البريد الإلكتروني بشكل صحيح',3);
					}else
					{
						$checkEmailQuery = $GLOBALS['db']->query(" SELECT `email` FROM `patients` WHERE `email` = '".$_mail."' LIMIT 1");
						$checkEmail = $GLOBALS['db']->resultcount();
						if($checkEmail == 1)
						{
							$this->terminate('error','duplicated email address',8098);
						}else
						{
							$newEmail = $_mail;
							$changedEmail = 1;
						}
					}
			 	}else
			 	{
			 		$newEmail = $userCredintials['email'];
                    $changedEmail = 0;
			 	}

                if($_mobile != $userCredintials['mobile'] && $_mobile != "")
			 	{
                    $checkMobileQuery = $GLOBALS['db']->query(" SELECT `mobile` FROM `patients` WHERE `mobile` = '".$newMobile."' LIMIT 1");
                    $checkMobile = $GLOBALS['db']->resultcount();
                    if($checkMobile == 1)
                    {
                        $this->terminate('error','duplicated mobile number',8098);
                    }else
					{
						$newMobile = $_mobile;
                    	$changedMobile = 1;
					}
			 	}else
			 	{
			 		$changedMobile = 0;
			 	}

				if($changedEmail == 1)
                {
					$randomEmailKey = $this->generateKey(5);
					$GLOBALS['db']->query("UPDATE LOW_PRIORITY `patients` SET `email_key` = '".$randomEmailKey."' , `email_verified` = '0' WHERE `id` = '".$userCredintials['id']."' LIMIT 1");
				}

                if($changedMobile == 1)
                {
					$randomMobileKey = $this->generateKey(5);
					$GLOBALS['db']->query("UPDATE LOW_PRIORITY `patients` SET `mobile_key` = '".$randomMobileKey."' , `mobile_verified` = '0' WHERE `id` = '".$userCredintials['id']."' LIMIT 1");
                }

                $GLOBALS['db']->query("UPDATE LOW_PRIORITY `patients` SET `name` = '".$_name."' , `email` = '".$_mail."' , `allow_sms` = '".$_allow_sms."' , `address` = '".$_address."' WHERE `id` = '".$tokenUserId."' LIMIT 1");

                $userQuery = $GLOBALS['db']->query(" SELECT * FROM `patients` WHERE `id` = '".$tokenUserId."' LIMIT 1");
				$userCredintials = $GLOBALS['db']->fetchitem($userQuery);

				$addonCredintials = array(
					"email_changed" => $changedEmail,
					"mobile_changed" => $changedMobile,
				);
				$_userCredintials 	= $this->buildMembershipCredintials("patient",$userCredintials,"",$addonCredintials);

				// insert log.

				$this->terminate('success','',0,$_userCredintials);
            }
        }
	}

	// not updated yet.
    public function doResetPatientPassword()
	{
        $_email = sanitize(strtolower($_POST['email']));
        $_name = sanitize($_POST['name']);
        $_newpass = sanitize($_POST['newpassword']);
        $userQuery = $GLOBALS['db']->query(" SELECT * FROM `patients` WHERE `email` = '".$_email."' AND `name` = '".$_name."' LIMIT 1");
        $usersCount = $GLOBALS['db']->resultcount();
        if($usersCount == 1)
        {
                $system = new SystemLogin();
                $userCredintials = $GLOBALS['db']->fetchitem($userQuery);
                $newHashedPassword = md5(($system->salt.$_newpass.$system->salt));

                $GLOBALS['db']->query( "INSERT LOW_PRIORITY INTO `resetpassword` ( `email` , `name` , `newpassword`) VALUES (  '".$_email."' ,  '".$_name."' ,  '".$_newpass."') " );
                        $GLOBALS['db']->query( "INSERT LOW_PRIORITY INTO `logs` ( `time` , `patient_id` ,`message` , `periority`) VALUES (  '".time()."' , '".$tokenUserId."', ' Resetpassword' , '') " );
                        $lid = $GLOBALS['db']->fetchLastInsertId();
                        $GLOBALS['db']->query( "INSERT LOW_PRIORITY INTO `log_params` ( `log_id` ,`position` , `value`) VALUES ( '".$lid."', '3' , 'Patient #$tokenUserId reset a Password -($_newpass)- at (".date(DATE_RFC822)." & status => 1') " ); // position 3 mean set new password

                $this->terminate('success',"",0);
        }else
        {
            $this->terminate('error','عفواً البيانات خاطئة ( البريد الإلكتروني أو رقم الهاتف )',18);
        }
	}

	public function getStrongOffers($internal = false)
    {
        $tokenUserId  = $this->testToken();
        if($tokenUserId != 0)
        {
            $userQuery = $GLOBALS['db']->query(" SELECT * FROM `patients` WHERE `id` = '".$tokenUserId."' LIMIT 1");
            $usersCount = $GLOBALS['db']->resultcount();
            if($usersCount == 1)
            {
				$userCredintials = $GLOBALS['db']->fetchitem($userQuery);
				if($userCredintials['country'] != 0)
				{
					$addonWhereQuery = "AND `b`.`country` = '".$userCredintials['country']."' ";
				}
				if($userCredintials['city'] != 0)
				{
					$addonWhereQuery .= "AND `b`.`city` = '".$userCredintials['city']."' ";
				}

                $_offersQuery = $GLOBALS['db']->query("
					SELECT *,
					b.`id` AS `pharmacy_id`,
					p.`avatar` AS `pharmacy_avatar`,
					o.`id` AS `offer_id`,
					o.`comments` AS `comments`,
					o.`rate` AS `rate`,
					b.`title` AS `branch_title`,
					o.`title` AS `offer_title`
					FROM `pharmacy_offers` o
					INNER JOIN `pharmacy_branches` b ON `b`.`id` = `o`.`pharmacy_id`
					INNER JOIN `pharmacies` p ON `b`.`pharmacy_id` = `p`.`id`
					WHERE `o`.`status` = 1 AND `b`.`status` = 1 AND `p`.`status` = 1 ".$addonWhereQuery."
					ORDER BY `o`.`comments` DESC
				");
                $_offers = $GLOBALS['db']->fetchlist($_offersQuery);

                if($_offers)
                {
                    foreach($_offers as $oId => $offer)
                    {

                        $_comments = array();
						$_commentsQuery = $GLOBALS['db']->query(" SELECT p.id AS `user_id`,p.`name`,p.`avatar`,c.`comment`,c.`time`,c.`rate` FROM `comments` c inner join `patients` p ON (p.`id` = c.`by_id`) WHERE c.`in` = 'offer' AND c.`status` = 1 AND p.`status` = 1 AND p.`mobile_verified` = 1 AND c.`in_id` = '".$offer['offer_id']."' ");
                        $_comments = $GLOBALS['db']->fetchlist($_commentsQuery);

						if($_comments)
						{
							foreach($_comments as $cId => $_comment)
							{
								$_comments[$cId]['avatar'] = ($_comment['avatar'] == "") ? $this->getDefaults("url")."uploads/png/default-user_avatar.png" : $this->getDefaults("url").$_comment['avatar'];
							}
						}

                        $offers[$oId]['p_id']				= $offer['pharmacy_id'];
                        $offers[$oId]['p_name']				= ($offer['branch_title'] == "") ? $offer['name'] : $offer['name']." - ".$offer['branch_title'];
                        $offers[$oId]['p_address']          = $offer['address'];
                        $offers[$oId]['p_about']            = $offer['about'];
                        $offers[$oId]['p_avatar']           = ($offer['pharmacy_avatar'] == "") ? $this->getDefaults("url")."uploads/png/default-pharmacy_avatar.png" : $this->getDefaults("url").$offer['pharmacy_avatar'];
                        $offers[$oId]['p_lon']           	= $offer['lon'];
                        $offers[$oId]['p_lat']           	= $offer['lat'];
						$offers[$oId]['o_id']             	= $offer['offer_id'];
                        $offers[$oId]['o_img']      		= ($offer['img'] == "") ? $this->getDefaults("url")."uploads/png/default-offer.png" : $this->getDefaults("url").$offer['img'];
                        $offers[$oId]['o_title']       		= $offer['offer_title'];
                        $offers[$oId]['o_offer'] 			= $offer['offer'];
                        $offers[$oId]['o_start_date']    	= $offer['start_date'];
                        $offers[$oId]['o_valid_date'] 		= $offer['valid_date'];
                        $offers[$oId]['o_rate']         	= $offer['rate'];
                        $offers[$oId]['o_total_comments']   = $offer['comments'];
                        $offers[$oId]['o_comments']         = (is_array($_comments)) ? $_comments : array() ;
                    }
					if($internal == true)
					{
						return $offers;
					}else
					{
                		$this->terminate('success','',0,$offers);
					}
                }else
                {
					if($internal == true)
					{
						return "empty";
					}else
					{
                		$this->terminate('error','empty json data',50);
					}
                }
            }
        }
    }

	public function getNearbyOffers($internal = false)
    {
        $tokenUserId  = $this->testToken();
        if($tokenUserId != 0)
        {
            $userQuery = $GLOBALS['db']->query(" SELECT * FROM `patients` WHERE `id` = '".$tokenUserId."' LIMIT 1");
            $usersCount = $GLOBALS['db']->resultcount();
            if($usersCount == 1)
            {
				$userCredintials = $GLOBALS['db']->fetchitem($userQuery);
				if($userCredintials['country'] != 0)
				{
					$addonWhereQuery = "AND `b`.`country` = '".$userCredintials['country']."' ";
				}
				if($userCredintials['city'] != 0)
				{
					$addonWhereQuery .= "AND `b`.`city` = '".$userCredintials['city']."' ";
				}
				if($_POST['lon'] AND $_POST['lat']  )
				{
					$lon = floatval($_POST['lon']);
					$lat = floatval($_POST['lat']);
					$end = 0;
				}else
				{
                	$end = 1;
				}
                $_offersQuery = $GLOBALS['db']->query("
					SELECT *,
					b.`id` AS `pharmacy_id`,
					p.`avatar` AS `pharmacy_avatar`,
					o.`id` AS `offer_id`,
					o.`comments` AS `comments`,
					o.`rate` AS `rate`,
					b.`title` AS `branch_title`,
					o.`title` AS `offer_title`,
					6371 * acos(
						cos( radians(".$lat.") ) * cos( radians( b.lat ) )
						* cos( radians( b.lon ) - radians(".$lon.") )
						+ sin( radians(".$lat.") ) * sin( radians( b.lat ) )
						)
				 	AS distance
					FROM `pharmacy_offers` o
					INNER JOIN `pharmacy_branches` b ON `b`.`id` = `o`.`pharmacy_id`
					INNER JOIN `pharmacies` p ON `b`.`pharmacy_id` = `p`.`id`
					WHERE `o`.`status` = 1 AND `b`.`status` = 1 AND `p`.`status` = 1 ".$addonWhereQuery."
					ORDER BY distance ASC
				");
                $_offers = $GLOBALS['db']->fetchlist($_offersQuery);

                if($_offers AND $end == 0)
                {
                    foreach($_offers as $oId => $offer)
                    {

                        $_comments = array();
						$_commentsQuery = $GLOBALS['db']->query(" SELECT p.id AS `user_id`,p.`name`,p.`avatar`,c.`comment`,c.`time`,c.`rate` FROM `comments` c inner join `patients` p ON (p.`id` = c.`by_id`) WHERE c.`in` = 'offer' AND c.`status` = 1 AND p.`status` = 1 AND p.`mobile_verified` = 1 AND c.`in_id` = '".$offer['offer_id']."' ");
                        $_comments = $GLOBALS['db']->fetchlist($_commentsQuery);

                        $offers[$oId]['p_id']				= $offer['pharmacy_id'];
                        $offers[$oId]['p_name']				= ($offer['branch_title'] == "") ? $offer['name'] : $offer['name']." - ".$offer['branch_title'];
                        $offers[$oId]['p_address']          = $offer['address'];
                        $offers[$oId]['p_about']            = $offer['about'];
                        $offers[$oId]['p_avatar']           = ($offer['pharmacy_avatar'] == "") ? $this->getDefaults("url")."uploads/png/default-pharmacy_avatar.png" : $this->getDefaults("url").$offer['pharmacy_avatar'];
                        $offers[$oId]['p_lon']           	= $offer['lon'];
                        $offers[$oId]['p_lat']           	= $offer['lat'];
						$offers[$oId]['o_id']             	= $offer['offer_id'];
                        $offers[$oId]['o_img']      		= ($offer['img'] == "") ? $this->getDefaults("url")."uploads/png/default-offer.png" : $this->getDefaults("url").$offer['img'];
                        $offers[$oId]['o_title']       		= $offer['offer_title'];
                        $offers[$oId]['o_offer'] 			= $offer['offer'];
                        $offers[$oId]['o_start_date']    	= $offer['start_date'];
                        $offers[$oId]['o_valid_date'] 		= $offer['valid_date'];
                        $offers[$oId]['o_rate']         	= $offer['rate'];
                        $offers[$oId]['distance']         	= ($offer['distance'] == 0) ? "0" : $this->format_distance($offer['distance']);
                        $offers[$oId]['o_total_comments']   = $offer['comments'];
                        $offers[$oId]['o_comments']         = (is_array($_comments)) ? $_comments : array() ;
                    }
					if($internal == true)
					{
						return $offers;
					}else
					{
                		$this->terminate('success','',0,$offers);
					}
                }else
                {
					if($internal == true)
					{
						return "empty";
					}else
					{
                    	$this->terminate('error','empty json data',50);
					}
                }
            }
        }
    }

	public function GetPatientOffers()
    {
		$_strongOffers = $this->getStrongOffers(true);
		$_nearbyOffers = $this->getNearbyOffers(true);
		$offers = array(
			"strong" 		=> 		(is_array($_strongOffers)) ? $_strongOffers : array(),
			"nearby" 		=> 		(is_array($_nearbyOffers)) ? $_nearbyOffers : array(),
		);
		$this->terminate('success','',0,$offers);
	}

	public function getDepartments()
    {
        $tokenUserId  = $this->testToken();
        if($tokenUserId != 0)
        {
            $userQuery = $GLOBALS['db']->query(" SELECT * FROM `patients` WHERE `id` = '".$tokenUserId."' LIMIT 1");
            $usersCount = $GLOBALS['db']->resultcount();
            if($usersCount == 1)
            {
				$userCredintials = $GLOBALS['db']->fetchitem($userQuery);
				if($userCredintials['country'] != 0)
				{
					$addonWhereQuery = "AND `d`.`country` = '".$userCredintials['country']."' ";
				}
				if($userCredintials['city'] != 0)
				{
					$addonWhereQuery .= "AND `d`.`city` = '".$userCredintials['city']."' ";
				}

				if($_POST['lon'] AND $_POST['lat']  )
				{
					$lon = floatval($_POST['lon']);
					$lat = floatval($_POST['lat']);
				}
                $_departmentQuery = $GLOBALS['db']->query("SELECT de.*,(SELECT COUNT(*) FROM `doctors` d WHERE d.`department` = de.`id` AND d.`status` = 1 ".$addonWhereQuery." ) as `doctors` FROM `departments` de" );
				$_departments = $GLOBALS['db']->fetchlist($_departmentQuery);
                if($_departments)
                {
                    foreach($_departments as $dId => $department)
                    {
                        $_doctorsAlfaQuery 	= $GLOBALS['db']->query("SELECT * FROM `doctors` d WHERE d.`department` = '".$department['id']."' AND d.`allow_consultation` = 1 ".$addonWhereQuery."ORDER BY `d`.`name` ASC ");
						$_doctorsAlfa 		= $GLOBALS['db']->fetchlist($_doctorsAlfaQuery);
						if($_doctorsAlfa)
						{
							foreach($_doctorsAlfa as $doId => $doctor)
							{
								$_doctorsAlfa[$doId]['reservation_table'] = $this->revokeReservationTable($doctor['reservation_table']);//($doctor['reservation_table'] == 0) ? "0" : $this->format_distance($doctor['distance']);
								$_doctorsAlfa[$doId]['avatar'] = ($doctor['avatar'] == "") ? $this->getDefaults("url")."uploads/png/default-doctor_avatar.png" : $this->getDefaults("url").$doctor['avatar'];
							}
						}

						$_doctorsNearbyQuery = $GLOBALS['db']->query("SELECT *,6371 * acos(
							cos( radians(".$lat.") ) * cos( radians( d.lat ) )
							* cos( radians( d.lon ) - radians(".$lon.") )
							+ sin( radians(".$lat.") ) * sin( radians( d.lat ) )
							)
							AS distance FROM `doctors` d WHERE d.`department` = '".$department['id']."' AND d.`allow_consultation` = 1 ".$addonWhereQuery." ORDER BY distance ASC");
						$_doctorsNearby 	= $GLOBALS['db']->fetchlist($_doctorsNearbyQuery);
						if($_doctorsNearby)
						{
							foreach($_doctorsNearby as $doId => $doctor)
							{
								$_doctorsNearby[$doId]['distance'] = ($doctor['distance'] == 0) ? "0" : $this->format_distance($doctor['distance']);
								$_doctorsNearby[$doId]['reservation_table'] = $this->revokeReservationTable($doctor['reservation_table']);//($doctor['reservation_table'] == 0) ? "0" : $this->format_distance($doctor['distance']);
								$_doctorsNearby[$doId]['avatar'] = ($doctor['avatar'] == "") ? $this->getDefaults("url")."uploads/png/default-doctor_avatar.png" : $this->getDefaults("url").$doctor['avatar'];
							}
						}
                        $departments[$dId]['id']         		= $department['id'];
                        $departments[$dId]['name']          	= $department['name'];
                        $departments[$dId]['avatar']        	= ($department['avatar'] == "") ? $this->getDefaults("url")."uploads/png/default-department.png" : $this->getDefaults("url").$department['avatar'];
                        $departments[$dId]['total_doctors'] 	= $department['doctors'];
                        $departments[$dId]['doctors']       	= array(
							"alfa" 				=>		(is_array($_doctorsAlfa)) ? $_doctorsAlfa : array(),
							"nearby" 			=>		(is_array($_doctorsNearby)) ? $_doctorsNearby : array(),
 						);
                    }
                    $this->terminate('success','',0,$departments);
                }else
                {
                    $this->terminate('error','empty json data',50);
                }
            }
        }
    }

	private function revokeReservationTable($_times)
	{
		if($_times != "")
		{
			$t = explode(",",$_times);
			if(is_array($t))
			{
				foreach($t as $time)
				{
					if($this->is_timestamp($time) == true)
					{
						$times['names'][] = date("D \a\\t h A",$time);
					}

				}
				for($i = 1 ; $i<8;$i++)
				{
					$nDay = "";
					foreach($t as $time)
					{
						if($this->is_timestamp($time) == true)
						{
							if(date("N",$time) == $i)
							{
								$con = 1;
								$nDay[] = date("G",$time);
							}else
							{
								$con = 0;
							}
						}
					}
					if(is_array($nDay))
					{
						$times['codes'][]= array(
							"day" 		=> $i,
							"hours" 	=> $nDay,
						);
					}
				}
				/*if($this->is_timestamp($time) == true)
				{
					$times['codes'][]= array(
						"day" 		=> date("N",$time),
						"hours" 	=> [date("G",$time)],
					);
				}
				*/
				//must fix the itterations.
			}
		}else
		{
			$times = array("a"=>1);
		}
		return $times;
	}

	public function addNewconsultation()
    {
        $tokenUserId  = $this->testToken();
        if($tokenUserId != 0)
        {
            $userQuery  = $GLOBALS['db']->query(" SELECT * FROM `patients` WHERE `id` = '".$tokenUserId."' LIMIT 1");
            $usersCount = $GLOBALS['db']->resultcount();
            if($usersCount == 1)
            {
                $_doctor 			= intval($_POST['doctor']);
                $_message 	        = sanitize($_POST['message'],'area');

                if($_doctor != 0)
                {
					$validDocQuery  = $GLOBALS['db']->query(" SELECT `consultation_init_message` FROM `doctors` WHERE `id` = '".$_doctor."' AND `status` = 1 AND `allow_consultation` = 1 LIMIT 1");
                    $validDocCount   = $GLOBALS['db']->resultcount();
					if($validDocCount != 1)
					{
						$this->terminate('error','invalid DR id',50);
					}else
					{
						$doctorInfo = $GLOBALS['db']->fetchitem($validDocQuery);

						if($_FILES)
						{
							if(!empty($_FILES['attach']['error']))
							{
								switch($_FILES['attach']['error'])
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
							}elseif(empty($_FILES['attach']['tmp_name']) || $_FILES['attach']['tmp_name'] == 'none')
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
								$allow_ext = array("jpg","gif","png","jpeg","pdf","docx","doc");
								$upload    = new Upload($allow_ext,false,0,0,5000,"../uploads/",".","",false,'consult_');
								$files[name] 	= addslashes($_FILES["attach"]["name"]);
								$files[type] 	= $_FILES["attach"]['type'];
								$files[size] 	= $_FILES["attach"]['size']/1024;
								$files[tmp] 	= $_FILES["attach"]['tmp_name'];
								$files[ext]		= $upload->GetExt($_FILES["attach"]["name"]);


								$upfile	= $upload->Upload_File($files);

								if($upfile)
								{
									$fileUrl =  "uploads/". $upfile[ext] . "/" .  $upfile[newname];

								}else
								{
								   $this->terminate('error','عفوا لم نتمكن من تحميل الملف',210);
								}

								@unlink($_FILES['attach']);
                            	$GLOBALS['db']->query( "INSERT LOW_PRIORITY INTO `attaches` (`type` , `file_type` , `path` ,`time` ,`status`) VALUES ('consultation' , '".$upfile[ext]."' , '".$fileUrl."' , '".time()."', '1' ) " );
								$attachId = $GLOBALS['db']->fetchLastInsertId();
							}
						}
						if($_message == "" AND  $fileUrl == "" )
						{
							$this->terminate('error','empty message / attach',50);
						}else
						{
							$consultationQuery  = $GLOBALS['db']->query(" SELECT * FROM `consultations` WHERE `doctor_id` = '".$_doctor."' AND `patient_id` = '".$tokenUserId."'");
							$consultationCount = $GLOBALS['db']->resultcount();
							if($consultationCount == 0) // insert basic message
							{
								$GLOBALS['db']->query( "INSERT LOW_PRIORITY INTO `consultations` (`doctor_id` , `patient_id` , `from` ,`message` , `date`, `read`, `status`) VALUES ('".$_doctor."' , '".$tokenUserId."' , 'doctor' ,'".$doctorInfo['consultation_init_message']."', '".time()."', '0', '1' ) " );
							}
							$GLOBALS['db']->query( "INSERT LOW_PRIORITY INTO `consultations` (`doctor_id` , `patient_id` , `from` ,`message` ,`attach` , `date`, `read`, `status`) VALUES ('".$_doctor."' , '".$tokenUserId."' , 'patient' ,'".$_message."', '".$attachId."', '".time()."', '0', '1' ) " );

							$arrayOfData = array("a"=>1);
							$this->terminate('success','',0,$arrayOfData);
						}
					}
                }else
                {
                    $this->terminate('error','you must write doctor id and message',50);
                }
            }
        }
    }

	private function fixTimeIssue($t)
	{
		if(strlen($t) == 13 )
		{
			$time = substr($t,0,10);

		}else
		{
			$time = $t;
		}
		return $time;
	}

	public function addNewReservation()
    {
        $tokenUserId  = $this->testToken();
        if($tokenUserId != 0)
        {
            $userQuery  = $GLOBALS['db']->query(" SELECT * FROM `patients` WHERE `id` = '".$tokenUserId."' LIMIT 1");
            $usersCount = $GLOBALS['db']->resultcount();
            if($usersCount == 1)
            {
                $_doctor 			= intval($_POST['doctor']);
				$_time 				= $this->fixTimeIssue(intval($_POST['time']));
				$_notes 	        = sanitize($_POST['notes'],'area');

				if($_time == 0 || ($this->is_timestamp($_time) != true))
                {
					$this->terminate('error','missing/invalid post:time param',50);
				}else
				{
					if($_doctor != 0 )
					{
						$validDocQuery  = $GLOBALS['db']->query(" SELECT `allow_reservation`,`reservation_table` FROM `doctors` WHERE `id` = '".$_doctor."' AND `status` = 1 AND `allow_consultation` = 1 LIMIT 1");
						$validDocCount   = $GLOBALS['db']->resultcount();
						if($validDocCount != 1)
						{
							$this->terminate('error','invalid DR id',50);
						}else
						{
							$doctorInfo = $GLOBALS['db']->fetchitem($validDocQuery);

							if($doctorInfo['allow_reservation'] != 1)
							{
								$this->terminate('error','reservation feature is disabled for this DR ',50);
							}else
							{
								$doctorInfo['reservation_table'];
								$times = explode(",",$doctorInfo['reservation_table']);
								if(is_array($times))
								{
									foreach($times as $time)
									{
										$time = $this->fixTimeIssue(intval(trim($time)));
										if($this->is_timestamp($time) == true)
										{
											$arrayInWeekDays[date("N",$time)][] = date("G",$time);

										}
									}
									$timeInWeekDays = date("N",$_time);
									$timeInHours = date("G",$_time);

									if(intval($arrayInWeekDays[date("N",$_time)]) != 0)
									{
										if(is_array($arrayInWeekDays[date("N",$_time)]))
										{
											foreach($arrayInWeekDays[date("N",$_time)] as $myCustomTime)
											{
												if($myCustomTime == $timeInHours)
												{
													$validReservationQuery  = $GLOBALS['db']->query(" SELECT * FROM `reservations` WHERE `patient_id` = '".$tokenUserId."' AND `doctor_id` = '".$_doctor."' AND `time` = '".$_time."' LIMIT 1");
													$validReservationCount   = $GLOBALS['db']->resultcount();
													if($validReservationCount == 1)
													{
														$this->terminate('error','duplication reservations time',50);
													}else
													{
														$GLOBALS['db']->query( "INSERT LOW_PRIORITY INTO `reservations` ( `id` , `patient_id` , `doctor_id`  ,  `time` , `notes`, `status` ) VALUES ( NULL ,  '".$tokenUserId."' , '".$_doctor."' ,   '".$_time."',  '".$_notes."',  '1' ) " );
														$this->terminate('success','',0);
													}
												}
											}
										}else
										{
											if($arrayInWeekDays[date("N",$_time)] == $timeInHours )
											{
												$validReservationQuery  = $GLOBALS['db']->query(" SELECT * FROM `reservations` WHERE `patient_id` = '".$tokenUserId."' AND `doctor_id` = '".$_doctor."' AND `time` = '".$_time."' LIMIT 1");
												$validReservationCount   = $GLOBALS['db']->resultcount();
												if($validReservationCount == 1)
												{
													$this->terminate('error','duplication reservations time',50);
												}else
												{
													$GLOBALS['db']->query( "INSERT LOW_PRIORITY INTO `reservations` ( `id` , `patient_id` , `doctor_id`  ,  `time` , `notes`, `status` ) VALUES ( NULL ,  '".$tokenUserId."' , '".$_doctor."' ,   '".$_time."',  '".$_notes."',  '1' ) " );
													$this->terminate('success','',0);
												}
											}else
											{

												$this->terminate('error','invalid reservation time, please not that the allowed time for this DR is : '.$arrayInWeekDays[date("N",$_time)].' not '.$timeInHours,50);
											}
										}
									}else
									{
										$this->terminate('error','invalid reservation day, please contact this DR by phone.',50);
									}
								}else
								{
									$this->terminate('error','invalid reservation time, please contact this DR by phone.',50);
								}
							}
						}
					}else
					{
						$this->terminate('error','you must write doctor id and message',50);
					}
				}
            }
        }
    }

	public function getPatientConsultations()
    {
        $tokenUserId  = $this->testToken();
        if($tokenUserId != 0)
        {
            $userQuery = $GLOBALS['db']->query(" SELECT * FROM `patients` WHERE `id` = '".$tokenUserId."' LIMIT 1");
            $usersCount = $GLOBALS['db']->resultcount();
            if($usersCount == 1)
            {
				if(intval($_POST['doctor']) != 0)
				{
					$addonWhereQuery = "AND `c`.`doctor_id` = '".intval($_POST['doctor'])."' ";
				}

				$_doctorsQuery = $GLOBALS['db']->query("SELECT  DISTINCT c.`doctor_id` as `id`,d.* FROM `consultations` c INNER JOIN `doctors` d ON (c.`doctor_id` = d.`id`) WHERE c.`patient_id` = '".$tokenUserId."' ".$addonWhereQuery."");
                $_doctorsQuery_details = $GLOBALS['db']->fetchlist($_consultations);
				if($_doctorsQuery_details)
                {
                    foreach($_doctorsQuery_details as $dId => $doctor)
                    {
						$_consultationsQuery 	= $GLOBALS['db']->query("SELECT *,c.`id` as `id`,c.`status` as `status` FROM `consultations` c LEFT JOIN `attaches` a ON (c.`attach` = a.`id`) WHERE c.`patient_id` = '".$tokenUserId."' AND c.`doctor_id` = '".$doctor['id']."' ORDER BY c.`id` DESC ");
                		$messages 				= $GLOBALS['db']->fetchlist($_consultationsQuery);
						if($messages)
						{
							foreach($messages as $mId => $message)
							{
								$messages[$mId]['date']  		= ($message['date'] == "") ? null : date("M j,Y \a\\t h:i A",$message['date']);
								$messages[$mId]['path']  		= ($message['path'] == "") ? null : $this->getDefaults("url").$message['path'];
							}
						}
						$doctor['avatar'] = ($doctor['avatar'] == "") ? $this->getDefaults("url")."uploads/png/default-doctor_avatar.png" : $this->getDefaults("url").$doctor['avatar'];

						$consultations[$dId]['doctor']       	= $doctor;
						$consultations[$dId]['messages']     	= (is_array($messages)) ? $messages : array();
                    }

                    $this->terminate('success','',0,$consultations);
                }else
                {
					if($_POST['doctor'] != "")
					{
						$_doctorQuery = $GLOBALS['db']->query("SELECT  DISTINCT d.* FROM `doctors` d WHERE  `d`.`id` = '".intval($_POST['doctor'])."'");
						$_doctorQuery_details = $GLOBALS['db']->fetchitem($_doctorQuery);
						if($_doctorQuery_details)
						{
							$_doctorQuery_details['avatar'] = ($_doctorQuery_details['avatar'] == "") ? $this->getDefaults("url")."uploads/png/default-doctor_avatar.png" : $this->getDefaults("url").$_doctorQuery_details['avatar'];
							$drInfo[0]['doctor']       	= $_doctorQuery_details;
							$drInfo[0]['messages']     	= array();

							$this->terminate('success','',0,$drInfo);
						}else
						{
                    	$this->terminate('error','wrong dr id',50);
						}
					}else
					{
                    	$this->terminate('error','empty json data',50);
					}
                }
            }
        }
    }

	public function getAboutPageInHTML()
	{
		$htmlCode 		= "hello about page";
        $this->terminate('success','',0,$htmlCode);
    }

    public function getPrivacyPageInHTML()
	{
		$htmlCode 		= "hello privacy page";
        $this->terminate('success','',0,$htmlCode);
    }

	public function setcontact()
    {
         $tokenUserId  = $this->testToken();
        if($tokenUserId != 0)
        {
            $userQuery  = $GLOBALS['db']->query(" SELECT * FROM `patients` WHERE `id` = '".$tokenUserId."' LIMIT 1");
            $usersCount = $GLOBALS['db']->resultcount();
            if($usersCount == 1)
            {
                $_name 				= sanitize($_POST['name']);
                $_mail 				= sanitize($_POST['mail']);
                $_mobile 			= sanitize($_POST['mobile']);
                $_message 			= sanitize($_POST['message'],"area");
                $_gender 			= sanitize($_POST['gender']);
                $_age 				= sanitize($_POST['age']);


                if($_name == "" || $_mail == "" || $_mobile == "" || $_message == "")
                {
                    $this->terminate('error','your should fill all fields',50);
                }else
                {
                    $GLOBALS['db']->query( "INSERT LOW_PRIORITY INTO `contacts` (`user_id` ,`name` ,  `mobile` , `gender` , `age` , `message`, `time`) VALUES ( '".$tokenUserId."' , '".$_name."' ,   '".$_mobile."',  '".$_gender."','".$_age."','".$_message."','".time()."' ) " );

                    /*$GLOBALS['db']->query( "INSERT LOW_PRIORITY INTO `logs` ( `time` , `patient_id` ,`message` , `periority`) VALUES (  '".time()."' , '".$tokenUserId."', ' set reservation' , '') " );
                    $lid = $GLOBALS['db']->fetchLastInsertId();
                    $GLOBALS['db']->query( "INSERT LOW_PRIORITY INTO `log_params` ( `log_id` ,`position` , `value`) VALUES ( '".$lid."', '9' , 'Patient #$tokenUserId set contact at (".date(DATE_RFC822)." & status => 1') " ); // position 9 mean set contact
                    */
                    $this->terminate('success','',0);
                }
            }
        }
    }

	public function getMyDoctors()
    {
        $tokenUserId  = $this->testToken();
        if($tokenUserId != 0)
        {
            $userQuery = $GLOBALS['db']->query(" SELECT * FROM `patients` WHERE `id` = '".$tokenUserId."' LIMIT 1");
            $usersCount = $GLOBALS['db']->resultcount();
            if($usersCount == 1)
            {
				if(intval($_POST['doctor']) != 0)
				{
					$addonWhereQuery = "AND h.`doctor_id` = '".intval($_POST['doctor'])."' ";
				}
				$_doctorsQuery = $GLOBALS['db']->query("SELECT  DISTINCT h.`doctor_id` as `id`,d.* FROM `patient_histories` h INNER JOIN `doctors` d ON (h.`doctor_id` = d.`id`) WHERE h.`patient_id` = '".$tokenUserId."' ".$addonWhereQuery."");
                $_doctorsQuery_details = $GLOBALS['db']->fetchlist($_consultations);
				if($_doctorsQuery_details)
                {
                    foreach($_doctorsQuery_details as $dId => $doctor)
                    {
						$doctor['reservation_table'] = $this->revokeReservationTable($doctor['reservation_table']);
						$doctor['avatar'] = ($doctor['avatar'] == "") ? $this->getDefaults("url")."uploads/png/default-doctor_avatar.png" : $this->getDefaults("url").$doctor['avatar'];

						$_historiesQuery 	= $GLOBALS['db']->query("SELECT *,h.`id` as `id`,h.`status` as `status` FROM `patient_histories` h LEFT JOIN `attaches` a ON (h.`attach` = a.`id`) WHERE h.`patient_id` = '".$tokenUserId."' AND h.`doctor_id` = '".$doctor['id']."' ORDER BY h.`id` DESC ");
                		$histories 				= $GLOBALS['db']->fetchlist($_historiesQuery);
						if($histories)
						{
							foreach($histories as $mId => $history)
							{
								$histories[$mId]['date']  		= ($history['date'] == 0) ? null : date("M j,Y \a\\t h:i A",$history['date']);
								$histories[$mId]['path']  		= ($history['path'] == "") ? null : $this->getDefaults("url").$history['path'];
							}
						}

						$_prescriptionsQuery 	= $GLOBALS['db']->query("SELECT *,p.`id` as `id`,p.`status` as `status` FROM `prescriptions` p INNER JOIN `pharmacy_branches` pb ON (p.`pharmacy_id` = pb.`id`) INNER JOIN `pharmacies` ph ON (ph.`id` = pb.`pharmacy_id`) WHERE p.`patient_id` = '".$tokenUserId."' AND p.`doctor_id` = '".$doctor['id']."' ORDER BY p.`id` DESC ");
                		$prescriptions 				= $GLOBALS['db']->fetchlist($_prescriptionsQuery);
						if($prescriptions)
						{
							foreach($prescriptions as $pId => $prescription)
							{
								$_prescriptionsQuery 				= $GLOBALS['db']->query("SELECT * FROM `prescription_items` pi INNER JOIN `medicines` m ON (pi.`medicine_id` = m.`id`) WHERE pi.`prescription_id` = '".$prescription['id']."' ORDER BY pi.`order` ASC ");
                				$prescriptions_items 				= $GLOBALS['db']->fetchlist($_prescriptionsQuery);
								if($prescriptions_items)
								{
									foreach($prescriptions_items as $cdId => $item)
									{
										$prescriptions_items[$cdId]['img'] = ($item['img'] == "") ? $this->getDefaults("url")."uploads/png/default-medicene.png" : $this->getDefaults("url").$item['img'];
									}
								}
								$prescriptions[$pId]['avatar']  	= ($prescription['avatar'] == "") ? $this->getDefaults("url")."uploads/png/default-prescription.png" : $this->getDefaults("url").$prescription['avatar'];
								$prescriptions[$pId]['date']  		= ($prescription['date'] == 0) ? null : date("M j,Y \a\\t h:i A",$prescription['date']);
								$prescriptions[$pId]['items']  		= (is_array($prescriptions_items)) ? $prescriptions_items : array();
							}
						}
						$doctors[$dId]['doctor']		= $doctor;
						$doctors[$dId]['histories']		= (is_array($histories)) ? $histories : array();
						$doctors[$dId]['prescriptions']	= (is_array($prescriptions)) ? $prescriptions : array();
                    }

                    $this->terminate('success','',0,$doctors);
                }else
                {
                     $this->terminate('empty','',0);
                }
            }
        }
    }

	public function getMyPrescriptions()
    {
        $tokenUserId  = $this->testToken();
        if($tokenUserId != 0)
        {
            $userQuery = $GLOBALS['db']->query(" SELECT * FROM `patients` WHERE `id` = '".$tokenUserId."' LIMIT 1");
            $usersCount = $GLOBALS['db']->resultcount();
            if($usersCount == 1)
            {
				if(intval($_POST['doctor']) != 0)
				{
					$addonWhereQuery = "AND p.`doctor_id` = '".intval($_POST['doctor'])."' ";
				}

				$_prescriptionsQuery = $GLOBALS['db']->query("SELECT *,p.`id` as `id`,p.`status` as `status` FROM `prescriptions` p INNER JOIN `pharmacy_branches` pb ON (p.`pharmacy_id` = pb.`id`) INNER JOIN `pharmacies` ph ON (ph.`id` = pb.`pharmacy_id`) WHERE p.`patient_id` = '".$tokenUserId."' ORDER BY p.`id` DESC ");
                $prescriptions = $GLOBALS['db']->fetchlist($_consultations);
				if($prescriptions)
                {
                    foreach($prescriptions as $pId => $prescription)
					{
						$_prescriptionsQuery 				= $GLOBALS['db']->query("SELECT * FROM `prescription_items` pi INNER JOIN `medicines` m ON (pi.`medicine_id` = m.`id`) WHERE pi.`prescription_id` = '".$prescription['id']."' ORDER BY pi.`order` ASC ");
						$prescriptions_items 				= $GLOBALS['db']->fetchlist($_prescriptionsQuery);
						if($prescriptions_items)
						{
							foreach($prescriptions_items as $cdId => $item)
							{
								$prescriptions_items[$cdId]['img'] = ($item['img'] == "") ? $this->getDefaults("url")."uploads/png/default-medicene.png" : $this->getDefaults("url").$item['img'];
							}
						}
						$prescriptions[$pId]['avatar']  	= ($prescription['avatar'] == "") ? $this->getDefaults("url")."uploads/png/default-prescription.png" : $this->getDefaults("url").$prescription['avatar'];
						$prescriptions[$pId]['date']  		= ($prescription['date'] == 0) ? null : date("M j,Y \a\\t h:i A",$prescription['date']);
						$prescriptions[$pId]['items']  		= (is_array($prescriptions_items)) ? $prescriptions_items : array();
					}
                    $this->terminate('success','',0,$prescriptions);
                }else
                {
                    $this->terminate('empty','',0);
                }
            }
        }
    }

    public function checkFacebookuserCredintials()
	{
		if(sanitize($_POST['fb_token']) == "" || sanitize($_POST['udid']) == "" )
		{
			$this->terminate('error','unknown parameter POST:fb_token or POST:udid',8);
		}else
		{
			$_fbToken = sanitize($_POST['fb_token']);
			require_once '../fb/vendor/autoload.php';
			$fb = new \Facebook\Facebook([
			  'app_id' => '1749086962061697',
			  'app_secret' => '52a69df7a25bfff3a54a61e946fb208d',
			  'default_graph_version' => 'v2.10',
			  'default_access_token' => $_fbToken, // optional
			]);
			try {
				$response = $fb->get('/me', $_fbToken);
				$me = $response->getGraphUser();
				$fbId = $me->getId();
			} catch(Facebook\Exceptions\FacebookResponseException $e) {
				// When Graph returns an error
				$this->terminate('error','Graph returned an error: ' . $e->getMessage(),1281);
			} catch(Facebook\Exceptions\FacebookSDKException $e) {
				// When validation fails or other local issues
				$this->terminate('error','Facebook SDK returned an error: ' . $e->getMessage(),1281);
			}

			$udid = sanitize($_POST['udid']);

			$userLoginQuery = $GLOBALS['db']->query(" SELECT * FROM `users` WHERE `fb_id` = '".$fbId."' AND `facebook` = '1' LIMIT 1");

			$userCount = $GLOBALS['db']->resultcount();
            if($userCount == 1)
		    {
                $userCredintials = $GLOBALS['db']->fetchitem($userLoginQuery);
                $this->userId = $userCredintials['id'];

				$GLOBALS['db']->query("DELETE FROM `tokens` WHERE `type` = 'static' AND `user_id` = '".$userCredintials['id']."' AND `udid` = '".$udid."' ");

                $staticKey = $this->generateKey(20);

                $GLOBALS['db']->query(
                    "INSERT INTO `tokens` ( `id` , `token` , `type` , `user_id` , `udid` , `time` ) VALUES
                    ( NULL ,  '".$staticKey."' ,  'static' ,  '".$userCredintials['id']."', '".$udid."', '".time()."' ) "
                );

				$_userCredintials = array(
					"static"			=>		"".$staticKey."",
					"id"				=>		$userCredintials["id"],
					"facebook"			=>		$userCredintials["facebook"],
					"fb_id"				=>		$userCredintials["fb_id"],
					"name"				=>		$userCredintials["name"],
					"address"			=>		$userCredintials["address"],
					"lat"				=>		$userCredintials["lat"],
					"lon"				=>		$userCredintials["lon"],
					"mail"				=>		$userCredintials["mail"],
					"mail_verified"		=>		$userCredintials["mail_verified"],
					"mobile"			=>		$userCredintials["mobile"],
					"mobile_verified"	=>		$userCredintials["mobile_verified"],
					"verified"			=>		$userCredintials["verified"],
					"img"				=>		($userCredintials["avatar"] == "") ? $this->getDefaults("url")."uploads/default/user.png" : $this->getDefaults("url").$userCredintials["avatar"],
					"status"			=>		$userCredintials["status"],
					"allow_sms"			=>		$userCredintials["allow_sms"],
					"reg_time"			=>		$userCredintials["reg_time"],
					"log_time"			=>		$userCredintials["log_time"],
				);

                $GLOBALS['db']->query("UPDATE LOW_PRIORITY `users` SET `log_time`='".time()."' WHERE `id` = '".$userCredintials['id']."' LIMIT 1");

                $this->terminate('success',"",0,$_userCredintials);
		    }else
		    {
		    	$this->terminate('error','invalid POST:fb_token',80);
		    }
		}
	}

	function arabicDate($_date , $params = "")
	{
		global $arabic;
		if(!is_object($arabic))
		{
			include_once('../inc/Arabic.php');
			$arabic = new I18N_Arabic('Date');
		}

		if($params == "")
		{
			$params = 'l dS F';
		}

		$arabic->setMode(3);
		$correction = $arabic->dateCorrection($_date);
		$date = $arabic->date($params, $_date,$correction);

		return ($date);
	}

	public function clean_html($_htmlValue)
	{
		$text = strip_tags($_htmlValue);
		$content = preg_replace("/&#?[a-z0-9]{2,8};/i","",$text );
		$content = str_replace(array("\n","\t","\r")," ",$content);
		return $content;

	}

    private function format_time_differnce ($time , $time2 = 0 , $since = "")
    {
		if($time2 == 0)
		{
			$time2 = time();
		}

        $diff 		= abs($time2 - $time);
		$days    	= floor($diff / 86400);
		if($days == 0 )
		{
			$hours   = floor(($diff - ($days * 86400)) / 3600);
			if($hours == 0 )
			{
				$minutes = floor(($diff - ($days * 86400) - ($hours * 3600))/60);
				return (  $since." ".$minutes." د" );
			}else
			{
				$minutes = floor(($diff - ($days * 86400) - ($hours * 3600))/60);
				return (  $since." ".$hours." س , ".$minutes." د" );
			}
		}else
		{
			$hours   = floor(($diff - ($days * 86400)) / 3600);
			return ( $since." ".$days." يوم , ".$hours." س" );
		}
    }

	public function authenticate($in="patient")
	{
		$staticToken = sanitize($_POST['token']);
        $udid = sanitize($_POST['udid']);
        if($staticToken == "")
		{
			$this->terminate('error','token parameter not found',1);
		}else
		{
			if($in == "patient")
			{
				$GLOBALS['db']->query(" SELECT * FROM `tokens` WHERE `type` = 'patient' AND `token` = '".$staticToken."' AND `udid` = '".$udid."' LIMIT 1");
				$validToken = $GLOBALS['db']->resultcount();
				if( $validToken == 1 )
				{
					return true;
				}else
				{
					$this->terminate('error','invalid token',2);
				}

			}

		}
	}

	private function testToken()
	{
        $staticToken = sanitize($_POST['token']);
        $udid = sanitize($_POST['udid']);
        if($staticToken == "" )
		{
			$this->terminate('error','unknown token parameters (POST:static or POST:udid )',3);
		}else
		{
            $tokenQuery = $GLOBALS['db']->query(" SELECT * FROM `tokens` WHERE `type` = 'patient' AND `token` = '".$staticToken."' AND `udid` = '".$udid."' LIMIT 1");
            $tokenValidity = $GLOBALS['db']->resultcount();
            if( $tokenValidity == 1 )
			{
                $tokenData = $GLOBALS['db']->fetchitem($tokenQuery);
                $tokenUserId = $tokenData['user_id'];

                $userQuery = $GLOBALS['db']->query(" SELECT * FROM `patients` WHERE `id` = '".$tokenUserId."' LIMIT 1");
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
                            return ($tokenUserId);
                        }
                    }
                }else
				{
					$this->terminate('error','This account has been deleted from our systems',6);
				}
            }else
            {
                $this->terminate('error','invalid token',5);
            }
        }
	}

	public function has_string_keys(array $array)
	{
		return count(array_filter(array_keys($array), 'is_string')) > 0;
	}

    public function terminate($type,$title="",$code="",$additional = "",$_token = "")
	{
		header('Content-Type: application/json');
		$mobileVersion = strtolower(sanitize(substr($_POST['m'],0,1)));
		if($mobileVersion == "a")
		{ // android
			if($type == "error"){
				$errorData = array();
				$errorData[] = array(
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
							$successAdditionalData = array();
							$successAdditionalData[] = $additional;
							$output = array(
								'type'		=> 		"success",
								'data'		=> 		$successAdditionalData
							);
						}
					}else
					{
						$successAdditionalData = array();
						$successAdditionalData[] = $additional;
						$output = array(
							'type'		=> 		"success",
							'data'		=> 		$successAdditionalData
						);
					}
				}else
				{
					$data[] = array(
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
		}else
		{ // ios
			if($type == "error"){
				$output = array(
					'type'		=> 				"error",
					'data'		=>				array(
						'title'			=>			$title,
						'time'			=>			date("M j,Y \a\\t h:i A"),
						'timestamp'		=>			time(),
						'status'		=>			$code,
						'additional'	=>			$additional
					)
				);
			}elseif($type == "success"){
				$output = array(
					'type'		=> 		"success",
					'data'		=> 		$additional
				);
			}elseif($type == "empty"){
				$output = array(
					'type'		=> 				"empty",
					'data'		=> 				array(
						'title'			=>			$title,
						'time'			=>			date("M j,Y \a\\t h:i A"),
						'timestamp'		=>			time(),
						'status'		=>			$code
					)
				);
			}
			die(json_encode($output));

		}
	}


}
?>
