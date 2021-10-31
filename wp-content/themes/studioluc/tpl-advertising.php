<?php
/*
Template Name: [Advertising]
*/

if (!defined('THEME_VERSION')) {	header('HTTP/1.0 403 Forbidden'); exit; }

$GLOBALS['flag-blog'] = true;
?>

<?php get_header($CORE->pageswitch()); ?>
		
	<div class="panel panel-default">
	 
	<div class="panel-heading"><?php the_title(); ?></div>
	 
	<div class="panel-body">  
    
	 	<?php if (have_posts()) : while (have_posts()) : the_post(); ?>   
        
		<?php the_content(); ?>
        
        <?php echo do_shortcode('[SELLSPACE]'); ?>
 		
		<?php endwhile; endif; ?>
 
	</div>
	 
	</div> 
		
<?php get_footer($CORE->pageswitch()); ?>