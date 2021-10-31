<?php
/*
Template Name: [Fast Auction]
*/
/* =============================================================================
   [PREMIUMPRESS FRAMEWORK] THIS FILE SHOULD NOT BE EDITED
   ========================================================================== */
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
	
	<?php
	$args = array(
			'post_type' => 'listing_type', 
			'posts_per_page' => '-1',
			'meta_key' => 'listing_expiry_date_timestamp',
			'orderby' => 'meta_value_num',
			'order' => 'ASC',
			'meta_query' => array(
				'relation' => 'AND',
					array(
						'key' => 'packageID',
						'value' => 1,
						'compare' => '='
					),
					array(
						'key' => 'listing_expiry_date_timestamp',
						'value' => strtotime(date('Y-m-d H:i:s')),
						'compare' => '>='
					)
				)
			);

		$the_query = new WP_Query( $args );  ?>
		<div class="wlt_search_results grid_style" id="slowAuct">

			<?php hook_items_before(); ?>
		<?php 
		if ( $the_query->have_posts() ) : while ( $the_query->have_posts() ) : $the_query->the_post(); ?>	 
					<?php $listing_expiry_date = get_post_meta(get_the_id(), 'listing_expiry_date', true);
						if($listing_expiry_date){
							update_post_meta(get_the_id(), 'listing_expiry_date_timestamp', strtotime($listing_expiry_date));
						} ?>
					<?php get_template_part( 'content', hook_content_templatename($post->post_type) ); ?> 
					
					<?php wp_reset_postdata(); ?>
		 
				<?php endwhile; ?>
			<?php else: ?>
				No Watches Published Yet
			<?php endif; ?> 
			<?php hook_items_after(); ?>

			<div class="clearfix"></div>

		</div>
   
    <?php /* if (have_posts()) : while (have_posts()) : the_post(); ?>    

	<?php 

    if(defined('WLT_PAGE_BUILDER') && strpos($post->post_content, "[pt_section") !== false	){
		//echo $post->post_content;
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
    
	<?php } */ ?>
 	
	<?php hook_page_after(); ?>
	
	<?php //endwhile; endif; ?>

<script>
jQuery(document).ready(function(){
	jQuery('#slowAuct.wlt_search_results div.itemdata').addClass('col-md-3 col-sm-6');
});
</script> 

	 
<?php get_footer($CORE->pageswitch());


} ?>
