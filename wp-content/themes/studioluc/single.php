<?php
/* 
* Theme: PREMIUMPRESS CORE FRAMEWORK FILE
* Url: www.premiumpress.com
* Author: Mark Fail
*
* THIS FILE WILL BE UPDATED WITH EVERY UPDATE
* IF YOU WANT TO MODIFY THIS FILE, CREATE A CHILD THEME
*
* http://codex.wordpress.org/Child_Themes
*/
if (!defined('THEME_VERSION')) {	header('HTTP/1.0 403 Forbidden'); exit; }


get_header($CORE->pageswitch()); ?>
 
<a name="toplisting"></a>
	
	<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
	 
		<?php hook_single_before(); ?>
        
        <?php if(defined('WLT_DEMOMODE') && isset($_SESSION['skin']) && file_exists(WP_CONTENT_DIR."/themes/".$_SESSION['skin']."/content-single-".hook_listing_templatename($post->post_type).".php") ){

		include(WP_CONTENT_DIR."/themes/".$_SESSION['skin']."/content-single-".hook_listing_templatename($post->post_type).".php");
		
		?>	
		
		<?php }else{ ?>
    
        <?php get_template_part( 'content-single', hook_listing_templatename($post->post_type) ); ?> 
        
        <?php } ?>
        
        <?php hook_single_after(); ?>
	
	<?php endwhile; endif; ?>
	 
<?php get_footer($CORE->pageswitch()); ?> 