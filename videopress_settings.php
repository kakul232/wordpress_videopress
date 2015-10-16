<?php
/**************************************************************************************************************\
@ This Page is use to display the setting page
@# Register User , #Other Comment enable disable settiong
***************************************************************************************************************/ 
 add_action( 'admin_menu', 'videopress_settins_menu' );
 add_action( 'admin_enqueue_scripts', 'my_vc_adminscripts_main' ); 
 add_action('bootsrtap_hook', 'add_bootstrap_vc_admin');


 function videopress_settins_menu() {
        add_menu_page( 
            __( 'videopress Settings Menu', 'textdomain' ),
            'videopress Settings',
            'manage_options',
            'videopress_settings',
            'videopress_settings_callback',
            plugins_url( '/images/icon.png', __FILE__  ),
            33
        ); 
    }


  //  wp_enqueue_script for Admin

        function my_vc_adminscripts_main() {

            wp_enqueue_style( 'poll_style', plugins_url( '/css/admin-style.css' , __FILE__ ) );
            wp_enqueue_script( 'jquery' );
            wp_enqueue_script('bootstrap',plugins_url( '/js/bootstrap.min.js' , __FILE__ ),array( 'jquery' ));
                  
        }


//  Create hook for admin bootstrap



        function add_bootstrap_vc_admin()
        {
            wp_enqueue_style( 'bootstrap', plugins_url( '/css/bootstrap.min.css' , __FILE__ ) );
        }


function videopress_settings_callback(){
/***********************************************************************************
@
@ user Not login With frankly Me  
@
*************************************************************************************/

if(!get_user_meta (get_current_user_id(), 'frankly', true ))
    {
        require_once('frankly_login.php');
    }
    else{
    	require_once('videopress_settings_dashboard.php');
    }
}






/***************************************************************


@   Save Setting 


**************************************************************/


	if(isset($_POST['save_frankly']))
	{
		print_r($_POST);
		$need_video_comment=$_POST['need_video_comment'];
		$need_askme=$_POST['need_askme'];
		$need_itro=$_POST['need_itro'];


			update_user_meta( get_current_user_id(), 'need_video_comment', 'dshfbdsnfsdbnfbdsf' );
	        update_user_meta( get_current_user_id(), 'need_askme', $need_askme );
	        update_user_meta( get_current_user_id(), 'need_itro',  $need_itro );

	}





































/***************************************************************
@ login Function  Ajax callback 
**************************************************************/

 add_action( 'wp_ajax_my_login', 'frankly_login_callback' );


function frankly_login_callback() {


    // HTTP REQUEST TO LOGIN API 

    $url='https://frankly.me/auth/local';
    $response = wp_remote_post( $url, array(
        'method' => 'POST',
        'timeout' => 45,
        'redirection' => 5,
        'httpversion' => '1.0',
        'blocking' => true,
        'headers' => array(),
        'body' => array( 'username' => $_POST['frankly_uname'], 'password' => $_POST['frankly_pass'] ),
        'cookies' => array()
        )
    );

    // DECODE RESPONDSE 
   //print_r($response);
   $data= json_decode($response['body'] ,true);
   
    if(isset($data['user']))
    {
         $user=$data['user']['username'];
         $token=$data['user']['token'];
         $id =$data['user']['id'];

        update_user_meta( get_current_user_id(), 'frankly', $user );
        update_user_meta( get_current_user_id(), 'frankly_id', $id );
        update_user_meta( get_current_user_id(), 'frankly_token',  $token );

        $json = array('flag' => 1);                      //  Login Successfull Collect token
     }else{
         $json = array('flag' => 0);                       //  Login failed
     }
     echo json_encode($json);
    wp_die();
}

/***************************************************************
@ logout Function  Ajax callback 
**************************************************************/

 add_action( 'wp_ajax_my_logout', 'frankly_logout_callback' );


function frankly_logout_callback() {
    delete_user_meta( get_current_user_id(), 'frankly');
    delete_user_meta( get_current_user_id(), 'frankly_id');
    delete_user_meta( get_current_user_id(), 'frankly_token');
    $json=array('flag' => 1 );

     echo json_encode($json);
    wp_die();
}





