<?php
    ob_start("ob_gzhandler");
    define("inside",true);
	if (!session_id()) {
		session_start();
	}

	include("../inc/fundamentals_api.php");

   
        

    if($_POST)
	{
        if($_POST['mode'] == "register")//user_registertion /without send verified Sms
        {
            $api->AddNewuserRegister();
        }elseif($_POST['mode'] == "login")
        {
            $api->checkCredintials();
        }elseif($_GET['mode'] == "logout")
        {
            $api->user_doLogOut();
        }elseif($_POST['mode'] == "avater")
        {
            $api->user_setAvater();
            
        }elseif($_GET['mode'] == "profile"){
            $api->user_getCredintials();
            
        }elseif($_POST['mode'] == "edit_profile"){
            
            $api->user_edit_profile();
        }elseif($_POST['mode'] == "recovery_pass"){
            
            $api->user_recovery_pass();
        }

        if($api->authenticat() == 'client')
        {
            if($_POST['mode'] == "push")
            {
                $api->user_setclientPushId();
            }elseif($_POST['mode'] == "rate")
            {
                $api->client_set_rate();
            }
        }
	}elseif($_GET){
        
        if($_GET['mode'] == 'salon_details')
        {
            $api->client_get_salon();
        }elseif($_GET['mode'] == 'salon_branches'){
            $api->client_get_salon_branch();
        }elseif($_GET['mode'] == 'branches_services'){
            $api->client_get_services_branch();
        }elseif($_GET['mode'] == 'products'){
            $api->client_get_products();
        }elseif($_GET['mode'] == 'category_product'){
            $api->client_get_category_products();
        }elseif($_GET['mode'] == 'gallery'){
            $api->client_get_gallery();
        }elseif($_GET['mode'] == 'best_saller'){
            $api->client_get_best_saller();
        }elseif($_GET['mode'] == 'branch_staff'){
            $api->client_get_branch_staff();
        }elseif($_GET['mode'] == 'active'){
            $api->user_activemail();
        }
        
    }else{
		$api->terminate('error','unknown POST parameters',6);
	}

?>
