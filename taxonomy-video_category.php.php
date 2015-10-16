<?php
/*

Template Name: Home
 */

get_header(); ?>

    <div class="main_wrapper">
        <!-- C O N T E N T -->
        <div class="content_wrapper">
            <div class="page_title_block">
                <div class="container">
                    <h2 class="title"><?php the_archive_title(); ?></h2>
                </div>
            </div>        
            <div class="container">
                <div class="content_block no-sidebar row">
                    <div class="fl-container span12">
                        <div class="row">
                            <div class="posts-block span12">
                                <div class="contentarea">

                                    <div class="row-fluid">
                                        <div class="span12 module_cont module_portfolio module_none_padding">
                                            <div class="filter_block">
                                                <div class="filter_navigation">
                                                    <ul id="options" class="splitter">
                                                        <li>
                                                        <?php wp_nav_menu( array('theme_location' =>   'secondary', 'items_wrap' => '<ul class="optionset">%3$s</ul>' )); ?>
                                                        </li>
                                                    </ul>
                                                </div><!-- .filter_navigation -->
                                            </div><!-- .filter_block -->
    
                                            <div class="portfolio_block image-grid columns4" id="list">
                                            <?php if ( have_posts() ) : ?>
                                            <?php
                                                while ( have_posts() ) : the_post(); ?>     
                                            
                                                <div data-category="bollywood" class="bollywood element">
                                                    <div class="filter_img gallery_item">
                                                        <a href="<?php the_permalink();?>"><?php the_post_thumbnail();?>
                                                            <div class="gallery_fadder"></div>
                                                            <div class="gallery_descr">
                                                                <p><?php the_title();?></p>
                                                            </div>
                                                        </a>
                                                    </div>
                                                </div><!-- .element -->
                                           <?php endwhile; ?>                                            
                                           <?php endif; ?>     
                                            </div><!-- .portfolio_block -->
                                            <div class="clear"></div>
                                            <div class="load_more_cont"><a href="javascript:void(0)" class="btn_load_more get_portfolio_works_btn shortcode_button btn_small btn_type2">Load more<span></span></a></div>
                                            
                                        </div><!-- .module_portfolio -->
                                    </div><!-- .row-fluid -->
                                    
                                </div><!-- .contentarea -->
                            </div>
                            <div class="left-sidebar-block span3">
                                <aside class="sidebar">
                                    //Sidebar Text
                                </aside>
                            </div><!-- .left-sidebar -->
                        </div>
                        <div class="clear"><!-- ClearFix --></div>
                    </div><!-- .fl-container -->
                    <div class="right-sidebar-block span3">
                        <aside class="sidebar">

                        </aside>
                    </div><!-- .right-sidebar -->
                    <div class="clear"><!-- ClearFix --></div>
                </div>
            </div><!-- .container -->
        </div><!-- .content_wrapper -->
    
    </div><!-- .main_wrapper -->

<?php get_footer(); ?>
