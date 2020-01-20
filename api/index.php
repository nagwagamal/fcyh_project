<?php 
    ob_start("ob_gzhandler");
    define("inside",true);
	if (!session_id()) {
        session_start();
	} 
    
    include("../inc/fundamental.php");
    if($_POST)
    {

    if(($_POST['mode'] == "check") && ($_POST['type'] == "login" ) ) //glabsl login
    {
        $new_api->checkuserCredintials();

    }elseif(($_POST['mode'] == "set") && ($_POST['type'] == "register"))
    {
        $new_api->user_register();

    }elseif(($_POST['mode'] == "set") && ($_POST['type'] == "password")) //gloabal password
    {
        $new_api->setPassword();

    }elseif(($_POST['mode'] == "set") && ($_POST['type'] == "forget_password"))
    {
        $new_api->forgetPassword();
    // }elseif( ($_POST['mode'] == "set") && ($_POST['type'] == "forgetPassword") ){

    //     $new_api->forgetPassword();

    }elseif(($_POST['mode'] == "set") &&($_POST['type'] == "verified"))
    {
        $new_api->mobile_verified();

    }elseif( ($_POST['mode'] == "set") &&($_POST['type'] == "profile"))
    {
        $new_api->update_profile();
    }elseif( ($_POST['mode'] == "set") &&($_POST['type'] == "setAvatar"))
    {   
        $new_api->setAvatar();
    }elseif( ($_POST['mode'] == "get") && ($_POST['type'] == "phone_key") )
    {
        $new_api->getPhoneKey();

    }elseif( ($_POST['mode'] == "set") && ($_POST['type'] == "code") )
    {
        $new_api->checkCode();

    }elseif(($_POST['mode'] == "get") && ($_POST['type'] == "governorates"))   // global function.
    { 
        $new_api->GetGovernorates();

    }elseif(($_POST['mode'] == "get") && ($_POST['type'] == "get_kind_client"))   // global function.
    {
        $new_api->get_kind_client();

    }elseif(($_POST['mode'] == "get") && ($_POST['type'] == "products"))   // global function.
    {
        $new_api->GetProducts();

    }elseif(($_POST['mode'] == "get") && ($_POST['type'] == "get_all_Products"))   // global function.
    {
        $new_api->get_all_Products();

    }elseif(($_POST['mode'] == "get") && ($_POST['type'] == "offer"))   // global function.
    {
        $new_api->getOffer();

    }elseif(($_POST['mode'] == "get") && ($_POST['type'] == "getNotification"))   // global function.
    {
        $new_api->getNotification() ;        
    }

  
/////////
 
/////////


         
if( ($_POST['mode'] == "get") ){

    if(($_POST['type'] == "get_order"))
    {
        $new_api->get_order();

    }elseif( ($_POST['type'] == "get_returns") ){
        $new_api->get_returns();
    }
}

    
// if(($_POST['mode'] == "get") && ($_POST['type'] == "kinds")){
//     $new_api->get_kinds();

// }
    if($new_api->authenticate() == "rep"){
        
        if( ($_POST['mode'] == "get") ){

            if($_POST['type'] == "get_rep_customers")
            {                
                $new_api->get_rep_customers();

            }elseif(($_POST['type'] == "get_all_tasks"))
            {
                $new_api->get_all_tasks();

            }elseif($_POST['type'] == "get_user_data_for_rep"){	

                $new_api->get_user_data_for_rep();	

            }elseif($_POST['type'] == "getProducts_toRep"){	
                $new_api->getProducts_toRep();		

            }elseif($_POST['type'] == "get_clients"){	
                
                $new_api->get_clients();				
            }elseif($_POST['type'] == "get_rep_govs"){
                $new_api->get_rep_govs();
            }elseif($_POST['type'] == "get_appiontments"){
                
                $new_api->create_table2();
            
            }elseif($_POST['type'] == "create_table_city"){
                
                $new_api->create_table_city();
            
            }elseif($_POST['type'] == "get_all_visits"){
                
                $new_api->get_all_visits();
            }elseif($_POST['type'] == "get_bills_to_rep"){
                
                $new_api->get_bills_to_rep();
            
            }elseif($_POST['type'] == "get_bills"){
                
                $new_api->get_bills();
            
            }elseif($_POST['type'] == "get_version"){
                
                $new_api->get_version();
            
            }elseif($_POST['type'] == "get_days"){
                
                $new_api->get_days();

            }elseif($_POST['type'] == "check_plan"){
                
                $new_api->check_plan();
            
            }
        }elseif( ($_POST['mode'] == "set")  ){

            if( $_POST['type'] == "rep_add_to_cart" )
            {
                $new_api->rep_add_to_cart();

            }elseif(($_POST['type'] == "check_in"))
            {
                $new_api->check_in();

            }elseif(($_POST['type'] == "check_out"))
            {
                $new_api->check_out();

            }elseif(($_POST['type'] == "check_rep_in_work"))
            {
                $new_api->check_rep_in_work();

            }elseif( $_POST['type'] == "rep_add_client")
            {
                $new_api->rep_add_client();

            }elseif($_POST['type'] == "rep_add_return")
            {                
                $new_api->rep_add_return();

            }elseif(($_POST['type'] == "rep_add_visit"))
            {
                $new_api->rep_add_visit();

            }elseif(($_POST['type'] == "rep_add_location"))
            {
                $new_api->rep_add_location();
 
            }elseif(($_POST['type'] == "rep_start_task"))
            {
                $new_api->rep_start_task();

            }elseif(($_POST['type'] == "rep_arrive_task"))
            {
                $new_api->rep_arrive_task();

            }elseif(($_POST['type'] == "rep_pause_task"))
            {
                $new_api->rep_pause_task();

            }elseif(($_POST['type'] == "rep_postpone_task"))
            {
                $new_api->rep_postpone_task();

            }elseif(($_POST['type'] == "rep_cancel_task"))
            {
                $new_api->rep_cancel_task();

            }elseif(($_POST['type'] == "rep_confirm_task"))
            {
                $new_api->rep_confirm_task();

            }elseif(($_POST['type'] == "conclution_task"))
            {
                $new_api->conclution_task();

            }elseif(($_POST['type'] == "rep_pay_money"))
            {

                $new_api->rep_pay_money();
            }elseif(($_POST['type'] == "setInventory"))
            {
                $new_api->setInventory();

            }elseif(($_POST['type'] == "setProduct_details"))
            {
                $new_api->setProduct_details();
            }elseif(($_POST['type'] == "rep_edit_client"))
            {
                $new_api->rep_edit_client();
            }elseif(($_POST['type'] == "rep_setAvatar_client"))
            {
                $new_api->rep_setAvatar_client();

            }elseif(($_POST['type'] == "change_location"))
            {
                $new_api->change_location();

            }elseif(($_POST['type'] == "create_plan"))
            {   
                $new_api->create_plan();
            }
    
        }

        }elseif($new_api->authenticate() == "client"){
            
            if( ($_POST['mode'] == "set")  ){

                if( $_POST['type'] == "client_add_order" )
                {
                    $new_api->client_add_order();
    
                }elseif( $_POST['type'] == "client_add_return" ){
                    $new_api->client_add_return();

                }elseif(($_POST['type'] == "client_rate_task")){
					$new_api->client_rate_task();
				}elseif(($_POST['type'] == "status_notification")){
					$new_api->status_notification();
				}elseif($_POST['type'] == "contact_us"){	
					$new_api->contact_us();
				}
        
            
             
            
            }elseif(  ($_POST['mode'] == "get") ){
                
                if( $_POST['type'] == "get_all_tasks_to_client" )
                {
                    $new_api->get_all_tasks_to_client();
    
                }elseif( $_POST['type'] == "get_details" )
                {
                    $new_api->get_details();
    
                }elseif( $_POST['type'] == "get_inventory_to_client" )
                {
                    $new_api->get_inventory_to_client();
    
                }elseif($_POST['type'] == "get_bills_to_client"){
                   
                    $new_api->get_bills_to_client();
                }
            }




        }

    }






















?>