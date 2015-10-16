<?php
/*
Plugin Name: Videopress
Plugin URI: http://frankly.me/
Description: Declares a plugin that will create a custom post type displaying movie reviews.
Version: 1.0
Author: kakul Sarma
Author URI: http://frankly.me/
License: GPLv2
*/
class frankly_videopress{


/***************************************************************************************************\

@  Hook

****************************************************************************************************/
function __construct(){

	add_action( 'init', array($this,'creat_frankly_videopress' ));
	add_action( 'init', array($this,'create_video_blog_taxonomies'), 0 );
	add_action( 'admin_init', array($this,'register_vidopress_metabox' ));
	add_filter( 'template_include', array($this,'video_blog_frankly_tamplate_fun_single'), 1 );
	add_filter( 'archive_template', array($this,'video_blog_frankly_tamplate_fun_archive') ) ;
	add_action( 'pre_get_posts', array($this,'add_my_post_types_to_query' ));
	add_action('save_post_video_blog', array($this,'add_movie_review_fields'), 1, 2); // save the custom fields
}

/***************************************************************************************************\

@  Register Custum Field

****************************************************************************************************/

function creat_frankly_videopress() {
    register_post_type( 'video_blog',
        array(
            'labels' => array(
                'name' => 'Videopress',
                'singular_name' => 'Videopress',
                'add_new' => 'Add New',
                'add_new_item' => 'Add New Video Blog',
                'edit' => 'Edit',
                'edit_item' => 'Edit Video Blog',
                'new_item' => 'New Video Blog',
                'view' => 'View',
                'view_item' => 'View Video Blog',
                'search_items' => 'Search Video Blog',
                'not_found' => 'No Video Blog found',
                'not_found_in_trash' => 'No Video Blog found in Trash',
                'parent' => 'Parent Video Blog'
            ),

   			'public' => true,
    		'publicly_queryable' => true,
    		'show_in_nav_menus'=>true,
    		'show_ui' => true,
    		'query_var' => true,
    		'has_archive' => true,
    		'rewrite' => array( 'slug' => 'video' ),
    		'capability_type' => 'post',
    		//'hierarchical' => true,
   			'menu_position' => 12,
    		'menu_icon' => plugins_url( '/images/icon.png', __FILE__ ),
   			'taxonomies' => array( 'post_tag', 'category '),
  			'supports' => array('title','editor','author','thumbnail','excerpt','comments', 'thumbnail','page-attributes')

        )
    );


}

/***************************************************************************************************\

@  Register taxonomies

****************************************************************************************************/




function create_video_blog_taxonomies() {
    $labels = array(
        'name'              => _x( 'Video Categories', 'taxonomy general name' ),
        'singular_name'     => _x( 'Category', 'taxonomy singular name' ),
        'search_items'      => __( 'Search Categories' ),
        'all_items'         => __( 'All Categories' ),
        'parent_item'       => __( 'Parent Category' ),
        'parent_item_colon' => __( 'Parent Category:' ),
        'edit_item'         => __( 'Edit Category' ),
        'update_item'       => __( 'Update Category' ),
        'add_new_item'      => __( 'Add New Category' ),
        'new_item_name'     => __( 'New Category Name' ),
        'menu_name'         => __( 'Video Categories' ),
    );

    $args = array(
        'hierarchical'      => true, // Set this to 'false' for non-hierarchical taxonomy (like tags)
        'labels'            => $labels,
        'show_ui'           => true,
        'show_admin_column' => true,
        'query_var'         => true,
        'rewrite'           => array( 'slug' => 'categories' ),
    );

    register_taxonomy( 'video_blog_categories', array( 'video_blog' ), $args );
}




/***************************************************************************************************\

@ Display Custum POst  Meta Box (Video Recording)
@ Dashboard
****************************************************************************************************/



function register_vidopress_metabox() {


    add_meta_box( 'frankly_Video_Blog_meta_box',
        'Add Video',
        array($this,'add_frankly_Video_Blog_meta_box'),
        'video_blog', 'normal', 'high'
    );

    add_meta_box( 'frankly_Video_Blog_setting_meta_box',
        'Additional Feature',
        array($this,'add_frankly_Video_Blog_setting_meta_box'),
        'video_blog', 'normal', 'high'
    );


}


function add_frankly_Video_Blog_meta_box( $video_blog ) {
	$title= get_the_title( $video_blog->ID );
	if($title=='Auto Draft'){
		$title='blogfeed';
	}
    $short_id_ifram=substr(str_shuffle("AblogIS10OnlyHowDOrGODhelPMe323223"),0,6);

	if(!get_user_meta (get_current_user_id(), 'frankly', true ))
    {
        echo "PLease Goto the Settings Page To enable Video Recording feature";
    }
    else{

    	$unify=rawurlencode($_SERVER['HTTP_HOST'].'POST'.$video_blog->ID );



	//  Video Recorer Start From HEre

?>
	<script type="text/javascript">
	(function($){


		// On Change Title

		$("#titlxxe").bind("input", function(e){
		var url="https://frankly.me/recorder/recorder?type=blog&resourceId=";
			var caption=$(this).val();

				url=url+caption;
				$('.recorder').attr("src",url);

		})




	})(jQuery);

	</script>

<!-- Recorder Iframe -->

    <iframe class="recorder" src="https://frankly.me/recorder/recorder?type=blog&resourceId=&sourceUrl=<?php echo $unify; ?> " width="300" height="500"></iframe>

 <!-- Recorder Iframe -->
  <?php
  		//get User Profie Id

       $franky_user_id=get_user_meta (get_current_user_id(), 'frankly_id', true );

      	$url='http://api.frankly.me/post/get?page_url='.$unify.'&filter_type=post';
       	$response = wp_remote_get( $url,array( 'timeout' => 120, 'httpversion' => '1.1' ) ) ;
       	$rs=json_decode($response['body'],true);


         if(isset($rs['stream']['0']['post']['answer']['media_urls'])){

 ?>
                 <video height="500" width="300" controls>
                    <source src="<?php echo $rs['stream']['0']['post']['answer']['media_urls']['200'];?>" type="video/mp4">
                    <source src="<?php echo $rs['stream']['0']['post']['answer']['media_urls']['webm'];?>" >
                    <source src="<?php echo $rs['stream']['0']['post']['answer']['media_urls']['original'];?>" >
                        Your browser does not support the video.
                </video>

    <?php }
	} // if uID end
}


function add_frankly_Video_Blog_setting_meta_box($video_blog){

	?>
<table >

	<tr>
		<td><label class="col-xs-12 col-sm-4 col-md-3 col-lg-2">Need Video Comment :</label></td>
		<td><input type="hidden" name="need_video_comment" value="">
		<input class="video_checkbox" type="checkbox" name="need_video_comment" <?php echo (get_post_meta($video_blog->ID,'need_video_comment',true)=='on'? 'checked' : '');?>  id="need_video_comment"></td>
	</tr>

	<tr>
		<td><label class="col-xs-12 col-sm-4 col-md-3 col-lg-2">Display Ask me Widget :</label></td>
		<td><input type="hidden" name="need_askme" value="">
		<input class="video_checkbox" type="checkbox" name="need_askme" <?php echo (get_post_meta($video_blog->ID,'need_askme',true)=='on' ? 'checked' : '');?> id="need_askme"></td>
	</tr>

	<!-- <tr>
		<td><label class="col-xs-12 col-sm-4 col-md-3 col-lg-2">Display Intro Video :</label></td>
		<td><input type="hidden" name="need_itro" value="">
		<input class="video_checkbox" type="checkbox" name="need_itro" <?php // echo (get_post_meta($video_blog->ID,'need_itro',true)=='on' ? 'checked' : '');?> id="need_itro"></td>
	</tr> -->

</table>
<?php
}

/***************************************************************************************************
@ Custum Theme

****************************************************************************************************/


function video_blog_frankly_tamplate_fun_single( $template_path ) {
    if ( get_post_type() == 'video_blog' ) {
        if ( is_single() ) {
            // checks if the file exists in the theme first,
            // otherwise serve the file from the plugin
            if ( $theme_file = locate_template( array ( 'single-video_blog.php' ) ) ) {
                $template_path = $theme_file;
            } else {
                $template_path = plugin_dir_path( __FILE__ ) . '/single-video_blog.php';
            }
        }
    }
    return $template_path;
}



function video_blog_frankly_tamplate_fun_archive( $archive_template ) {
     global $post;

     if ( is_post_type_archive ( 'video_blog' ) ) {
          $archive_template = dirname( __FILE__ ) . '/arcive-video_blog.php';
     }
     return $archive_template;
}




/***************************************************************************************************\

@ Display Custum POst To Home Page

****************************************************************************************************/


function add_my_post_types_to_query( $query ) {
  if ( is_home() && $query->is_main_query() )
    $query->set( 'post_type', 'video_blog' );
  return $query;
}




/*********************   saving meta box data  ****************************/

    function add_movie_review_fields($video_blog_id,$video_blog ) {
    // Check post type for movie reviews
       echo $video_blog_id;
    if ( $video_blog->post_type == 'video_blog' ) {

        // update intro
        if ( isset( $_POST['need_itro'] ) && $_POST['need_itro'] != '' ) {
            update_post_meta( $video_blog_id, 'need_itro', $_POST['need_itro'] );
        }else{
            update_post_meta( $video_blog_id, 'need_itro', '' );
        }
        // update askme
        if ( isset( $_POST['need_askme'] ) && $_POST['need_askme'] != '' ) {
            update_post_meta( $video_blog_id, 'need_askme', $_POST['need_askme'] );
        }else{
            update_post_meta( $video_blog_id, 'need_askme', '' );
        }
        // update comment
        if ( isset( $_POST['need_video_comment'] ) && $_POST['need_video_comment'] != '' ) {
            update_post_meta( $video_blog_id, 'need_video_comment', $_POST['need_video_comment'] );
        }else{
            update_post_meta( $video_blog_id, 'need_video_comment', '' );
        }
    }
}



} // Class Frankly_videopress End Here


$vp = new frankly_videopress;




//////////////////////////////////////     Additional Hook /////////////////////////////////////////



/***************************************************************************************************\

@ Display Video Comment

****************************************************************************************************/


add_action('the_content','frankly_video_comment');


function frankly_video_comment($content){
        if ( is_single() ) {

    $current_stat= get_post_meta(get_the_ID(),'need_video_comment');

            if(isset($current_stat[0]))
            {
                if($current_stat[0]=='on')
                {
                     $video_comment= '<div class="franklywidget" data-user="" data-widget="videoComment" data-query="" data-height="40" data-width="240" style="margin: auto"><a href="https://frankly.me">Frankly.me</a></div>

                      <div class="franklywidget" data-user="" data-widget="viewComment" data-query="" data-height="340" data-width="100%" style="margin: auto"><a href="https://frankly.me">Frankly.me</a></div>

                      <script src="https://frankly.me/js/franklywidgets.js"> </script>


                      ';
                      return $content.$video_comment;
                }
                else
                {
                     return $content;
                }
            }


}

if(is_page())
{
      return $content;
}
}




/***************************************************************************************************\

@ Display Ask Me button

****************************************************************************************************/

add_action('the_content','frankly_askme_button');

    function frankly_askme_button($content){
        $unify=rawurlencode($_SERVER['HTTP_HOST'].'POST'.get_the_ID());
        if ( is_single() ) {

    $current_stat= get_post_meta(get_the_ID(),'need_video_comment');

            if(isset($current_stat[0]))
            {
                if($current_stat[0]=='on')
                {
                     $url='http://api.frankly.me/post/get?page_url='.$unify.'&filter_type=post';
                     $response = wp_remote_get( $url,array( 'timeout' => 120, 'httpversion' => '1.1' ) ) ;
                     $rs=json_decode($response['body'],true);
                     if(isset($rs['stream']['0']['post'])){
                     $user_name=$rs['stream']['0']['post']['question_author']['username'];
                     $askme_button= '<iframe frameborder="0" height="100%" width="100%" src="https://frankly.me/widgets/askButtonLg/'.$user_name.'?flagRedirect=false&amp;url=http://embed.frankly.me/v2/"></iframe>';
                      return $askme_button.$content;
                  }else{
                    return $content;
                  }
                }
                else
                {
                     return $content;
                }
            }


}

if(is_page())
{
      return $content;
}
}

//require_once('videopress_settings.php');
?>
