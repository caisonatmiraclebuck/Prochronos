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

$page_body 		= get_post_meta($post->ID, 'body', true);
if($page_body == "remove"){
$GLOBALS['wlt_remove_body'] = true;
}

// MOBILE VIEW HOME PAGE
if(defined('IS_MOBILEVIEW')){ 

include("home-mobile.php");

}else{
?>

<?php get_header($CORE->pageswitch()); ?>

	<?php hook_page_before(); ?>
    
    <?php if (have_posts()) : while (have_posts()) : the_post(); ?>    

	<?php 

    if(defined('WLT_PAGE_BUILDER') && strpos($post->post_content, "[pt_section") !== false	){
     
        the_content(); 
    
    }else{
	
    ?>
 
	<div class="panel panel-default">
	 
	<div class="panel-heading"><?php the_title(); ?></div>
	 
	<div class="panel-body">  
		
		<?php if ( has_post_thumbnail() ) { ?> <?php the_post_thumbnail('full',array("class" => "img-polaroid")); ?> <hr /> <?php } ?>
	
		<?php the_content(); ?>
 
	</div>
	 
	</div>
    
	<?php } ?>
 	
	<?php hook_page_after(); ?>
	
	<?php endwhile; endif; ?>
	 
<?php get_footer($CORE->pageswitch());


} ?>
