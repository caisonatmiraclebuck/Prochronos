<?php
/*
Template Name: [Blog]
*/

global $wpdb, $wp_query;

if (!defined('THEME_VERSION')) {	header('HTTP/1.0 403 Forbidden'); exit; }

$GLOBALS['flag-blog'] = true;
?>

<?php get_header($CORE->pageswitch()); ?>
		
		<div class="panel panel-default"> 
		
			<div class="panel-heading"><?php the_title(); ?></div>
            
            <div class="panel-body">
            
            <?php echo $post->post_content; ?>
		  
       		<div class="list_style row">
            
			<?php	
			
			$paged = ( get_query_var( 'paged' ) ) ? absint( get_query_var( 'paged' ) ) : 1;
			
			$args = array(
				'post_type' 		=> 'post',
				'posts_per_page' 	=> 3,
				'paged' 			=> $paged,
			);
			$wp_query = new WP_Query($args);
			 
			if ( $wp_query->have_posts() ) :
												 
			while ( $wp_query->have_posts() ) :  $wp_query->the_post(); 
			 
			?>
             
			<?php get_template_part( 'content', 'post' ); ?>
			 
			<?php endwhile; endif; ?>
           
           </div>
           
           </div>       
            
            <div class="clearfix"></div>
		   
		</div>
		
		<?php echo $CORE->PAGENAV(); ?>
        
        <?php wp_reset_query(); ?>
		
<?php get_footer($CORE->pageswitch()); ?>