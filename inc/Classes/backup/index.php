<?php
    ob_start("ob_gzhandler");
    define("inside",true);
	if (!session_id()) {
		session_start();
	}

	include("../inc/fundamental.php");



	if(($_GET['mode'] == "about"))
	{
		$api->getAboutPageInHTML();

	}elseif(($_GET['mode'] == "privacy"))
	{
		$api->getPrivacyPageInHTML();
	}elseif(($_GET['mode'] == "register"))  // done but without sending sms , sending mail , finishing log.
	{
		$api->AddNewPatientRegisterar();

	}elseif(($_GET['mode'] == "countries"))  // done.
	{
		$api->GetCountries();

	}elseif(($_GET['mode'] == "login")) //done
	{
		$api->checkPatientCredintials();

	}elseif(($_GET['mode'] == "activate_mobile")) //done
	{
		$api->activateNewPatientRegisterar();

	}
    if($_POST)
	{
		if(($_POST['mode'] == "set") && ($_POST['type'] == "resetpass"))
        {
            $api->doResetPatientPassword();
        }

		if($api->authenticate("patient") == true)
		{
			if(($_GET['mode'] == "avatar")) //done
            {
              $api->setPatientAvatar();

            }elseif(($_GET['mode'] == "password"))
            {
                $api->setPatientPassword();

            }elseif(($_GET['mode'] == "logout"))
            {
                $api->doLogOut();

            }elseif(($_GET['mode'] == "push"))
            {
                $api->setPatientPushId();

            }elseif(($_GET['mode'] == "credintials") )
            {
                $api->getPatientCredintials();

            }elseif(($_GET['mode'] == "set_patient_credintials"))
            {
                $api->setPatientCredintials();

            }elseif(($_GET['mode'] == "offers"))
            {
                $api->GetPatientOffers();

            }elseif(($_GET['mode'] == "departments") )
            {
                $api->getDepartments();

            }elseif(($_GET['mode'] == "consultant") )
            {
				$api->addNewconsultation();

            }elseif(($_GET['mode'] == "reservation") )
            {
                $api->addNewReservation();

            }elseif(($_GET['mode'] == "consultations") )
            {
                $api->getPatientConsultations();

            }elseif(($_GET['mode'] == "contact"))
            {
                $api->setcontact();

            }elseif(($_GET['mode'] == "mydoctors"))
            {
                $api->getMyDoctors();

            }elseif(($_GET['mode'] == "prescriptions"))
            {
                $api->getMyPrescriptions();

            }
		}
	}else
	{
		$api->terminate('error','unknown POST parameters',6);
	}


/*-----------------------------------------------|
|mode :: get   	   type ::	                     |
|=====================  --                       |
|   					-- credintials           |

|------------------------------------------------|
|mode :: set       type ::                       |
|=====================  -- credintials           |
|                       -- password              |
|                       -- avatar                |
|                       -- register              |
|                       -- activate_mobile       |
|                       -- resetAccount          |
|------------------------------------------------|
|mode :: check     type ::                       |
|=====================	-- login                 |
|-----------------------------------------------*/



/*---------------------------------------------------------------
     Messages
   			5   	unknown parameters
   			6   	unknown get parameters
   			7 		unknown set parameters
   			8 		unknown parameter d_user or d_pass
   			99 		success login data
   			90		invalid staff login data
   			100 	successful subjects list
   			101		success staff login data with empty subjects list
   			102		unknown subject_id parameter
   			103		invalid subject_id parameter
   			104		wrong permission to subject
   			105     successful students list
   			106		success staff login data but empty students list
   			107		invalid students ids & bluetooth data
   			108		empty students ids & bluetooth data
   			109		empty or wrong students ids & bluetooth data
   			110		successfull students bluetooth data insert
   			111		wrong subject_id parameter
   			112		wrong type_id parameter
   			113		wrong date_id parameter
   			114		invalid students ids & absence data
   			115		empty students ids & absence data
   			116		empty or wrong students ids & absence data
   			117		successfull students absence data insert

---------------------------------------------------------------*/
?>
