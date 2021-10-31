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
if (!defined('THEME_VERSION')) {	header('HTTP/1.0 403 Forbidden'); exit; } global $CORE_ADMIN;


// LOAD IN MAIN DEFAULTS 
$core_admin_values = get_option("core_admin_values"); 
  
?> 

<div style='font-weight:bold; padding:10px; padding-left:0px; border-bottom:1px solid #ddd; color:#666;'>Visitor History</div>

<script>
jQuery(document).ready(function(){
	jQuery( ".mapmebox" ).click(function() {
	  setTimeout(function () {
	  drawChart();
	  drawRegionsMap();
	  }, 500);
	  
	}); 
});
</script>

<?php echo do_shortcode('[VISITORCHART postid="'.$post->ID.'"]'); ?>