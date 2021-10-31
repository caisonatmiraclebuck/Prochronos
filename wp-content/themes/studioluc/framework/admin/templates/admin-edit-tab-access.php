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
$core_admin_values = get_option("core_admin_values");  $membershipfields 	= get_option("membershipfields"); 
  
?> 
     <?php 
		
	if(is_array($membershipfields) && !empty($membershipfields)){ 
	
	$current_access = get_post_meta($post->ID, "access", true);
	if(!is_array($current_access)){ $current_access = array(99); }	
	?>
    
   <div style='font-weight:bold; padding:10px; padding-left:0px; border-bottom:1px solid #ddd; color:#666;'> Membership Access </div> 
   <p>Here you can restrict access to this listing based on a users membership.</p>
   
   	<select name="wlt_field[access][]" size="2" style="font-size:14px;padding:5px; width:100%; height:150px; background:#e7fff3;" multiple="multiple"  > 
  	<option value="99" <?php if(in_array(99,$current_access)){ echo "selected=selected"; } ?>>All Membership Access</option>
    <?php 
	$i=0;
	
	foreach($membershipfields as $mID=>$package){	
		
		if(is_array($current_access) && in_array($package['ID'],$current_access)){ 
		echo "<option value='".$package['ID']."' selected=selected>".$package['name']."</option>";
		}else{ 
		echo "<option value='".$package['ID']."'>".$package['name']."</option>";		
		}
		
	$i++;		
	} // end foreach
	
    ?>
	</select>
    <br /><small>Hold CTRL to select multiple memberships.</small> 
   <?php } ?>
 
<div id="message" class="updated below-h2" style="margin-top:30px;"><b>Remember:</b> You can limit content based on membership access using the shortcode: [MEMBERSHIP] <br><br><b>Example:</b><br><textarea style="width:100%;height:50px;padding:10px;">[MEMBERSHIP ID="1,2,3"] Your content here will show only for membership ID 1,2 and 3[/MEMBERSHIP] </textarea> <br><br>Use ID 0 for non-registered users or non-members. </div> 