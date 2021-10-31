<?php
/*
Template Name: [SINGLE DEALER]
*/
/* =============================================================================
   [PREMIUMPRESS FRAMEWORK] THIS FILE SHOULD NOT BE EDITED
   ========================================================================== */
if (!defined('THEME_VERSION')) {	header('HTTP/1.0 403 Forbidden'); exit; }
/* ========================================================================== */
global  $userdata, $CORE; get_currentuserinfo();  $GLOBALS['flag-members'] = 1; 
/* =============================================================================
   LOAD PAGE TEMPLATE
   ========================================================================== */
   
// RANDOM NUMBERS


/* =============================================================================
   PAGE ACTIONS // 
   ========================================================================== */

// no index for report page

// LOAD HEADER   
get_header($CORE->pageswitch()); 

$dealer = $_GET['dealer_id'];
$dealer = get_user_by('id', $dealer);
//echo "<pre>"; print_r($dealer); echo "</pre>";
//echo $dealer->ID; 

?>
<?php if(isset($GLOBALS['cerror_type'])){ echo $CORE->ERRORCLASS($GLOBALS['cerror_msg'], $GLOBALS['cerror_type']); } ?>
<?php if (have_posts()) : while (have_posts()) : the_post(); ?>

<!-- START CONTENT BLOCK -->

	<div class="panel panel-default">
		<div class="panel-heading">
			<?php the_title(); ?>
		</div>
		<div class="panel-body">
			<div class="col-md-12 delar_info">
				<h2><?php echo get_user_meta($dealer->ID,'company_name',true); ?></h2>
				
				<?php echo get_user_meta($dealer->ID,'additional_info',true); ?>
				
				<p>Please do not hesitate to contact us with any questions!</p>
				
				<p>Team <?php echo get_user_meta($dealer->ID,'company_name',true);?>:</p>
				
				<address>
					<?php  if(get_user_meta($dealer->ID,'house_no',true) !=''){
						echo get_user_meta($dealer->ID,'house_no',true).',';
					}
					if(get_user_meta($dealer->ID,'street_name',true) !=''){
						echo get_user_meta($dealer->ID,'street_name',true).',';
					}
					if(get_user_meta($dealer->ID,'company_city',true) !=''){
						echo get_user_meta($dealer->ID,'company_city',true).',';
					} ?>
					<br>
					<?php if(get_user_meta($dealer->ID,'company_country',true) !=''){
						echo get_user_meta($dealer->ID,'company_country',true).',';
					} 
					if(get_user_meta($dealer->ID,'postcode',true) !=''){
						echo get_user_meta($dealer->ID,'postcode',true).',';
					} ?>
					<br>
					<?php $company_pohone = get_user_meta($dealer->ID,'company_phone',true); 
					if($company_pohone != '' && $company_pohone !== NULL){
						echo "Tel: ".$company_pohone; 
					} ?></p><br>
					<!--Fax: <?php //echo get_user_meta($dealer->ID,'company_phone',true);?></p><br>-->
					<?php echo get_user_meta($dealer->ID,'company_link',true);?><br>
					<?php echo get_user_meta($dealer->ID,'company_mail',true);?>
				</address>

				<a href="<?php echo site_url();?>/watch-dealers" class="bk_button right">Go Back</a>
			</div>
		</div>
	</div>
<?php endwhile; endif; ?>
<?php

get_footer($CORE->pageswitch());
	
// THAT'S ALL FOLKS! 
 
/* =============================================================================
   -- END FILE
   ========================================================================== */
?>
