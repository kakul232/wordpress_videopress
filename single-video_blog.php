<?php
/*
 * Template Name: Custom Full Width
 * Description: Page template without sidebar
 */

get_header(); ?>

<div id="primary" class="site-content-fullwidth">
  <div id="content" role="main">

    <?php while ( have_posts() ) : the_post(); ?>
      <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
    <?php
        // Page thumbnail and title.
        the_title( '<header class="entry-header"><h1 class="entry-title">', '</h1></header><!-- .entry-header -->' );
        if ( has_post_thumbnail() ) {
                the_post_thumbnail();
            } 
    ?>


    <div class="entry-content">
        <?php
          $unify=rawurlencode($_SERVER['HTTP_HOST'].'POST'.get_the_ID());
          $url='http://api.frankly.me/post/get?page_url='.$unify.'&filter_type=post';
         $response = wp_remote_get( $url,array( 'timeout' => 120, 'httpversion' => '1.1' ) ) ;
         $rs=json_decode($response['body'],true);
          print_r(get_post_format($GLOBALS['post']));
         if(isset($rs['stream']['0']['post']['answer']['media_urls'])){

 ?><style>
video { 
  -webkit-transform: scaleX(2); 
  -moz-transform: scaleX(2);
}
</style>
                 <video height="500" width="300" align="center" controls>
                    <source src="<?php echo $rs['stream']['0']['post']['answer']['media_urls']['200'];?>" type="video/mp4">
                        <source src="<?php echo $rs['stream']['0']['post']['answer']['media_urls']['webm'];?>" >
                        <source src="<?php echo $rs['stream']['0']['post']['answer']['media_urls']['original'];?>" >
                        Your browser does not support the video.
                </video>
              <video id="MY_VIDEO_1" class="video-js vjs-default-skin" controls
              preload="auto" width="640" height="264" poster="MY_VIDEO_POSTER.jpg"
              data-setup="{}">
              <source src="<?php echo $rs['stream']['0']['post']['answer']['media_urls']['200'];?>" type="video/mp4">
                        <source src="<?php echo $rs['stream']['0']['post']['answer']['media_urls']['webm'];?>" >
                        <source src="<?php echo $rs['stream']['0']['post']['answer']['media_urls']['original'];?>" >
                        Your browser does not support the video.
              </video>
              <link href="http://vjs.zencdn.net/4.12/video-js.css" rel="stylesheet">
              <script src="http://vjs.zencdn.net/4.12/video.js"></script>

    <?php }

            the_content(); 
           
            edit_post_link( __( 'Edit'), '<span class="edit-link">', '</span>' );
        ?>
    </div><!-- .entry-content -->

      <?php 

      do_action('video_comment');
      comments_template( '', true ); ?>
</article><!-- #post-## -->
    
    <?php endwhile; // end of the loop. ?>

  </div><!-- #content -->

</div><!-- #primary -->

<?php get_footer(); ?>