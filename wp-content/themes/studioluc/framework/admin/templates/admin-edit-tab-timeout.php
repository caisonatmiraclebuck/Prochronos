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
$core_admin_values = get_option("core_admin_values");   $current_access = get_post_meta($post->ID, "timeaccess", true); $membershipfields 	= get_option("membershipfields");	
  
?> 


   <div style='font-weight:bold; padding:10px; padding-left:0px; border-bottom:1px solid #ddd; color:#666;'> Timeout Access </div> 
   <p>Timeout access lets you set a time period the listing can viewed for before being redirected elsewhere.</p>
   
<?php


if(!is_array($current_access)){ $current_access = array(); }

?>
 <table  border="0" style="width:100%;text-align:left" class="table">
  <tr>
    <th>Name</th>
    <th>Timeout (seconds)</th>
    <th>Redirect (http://)</th>
  </tr>
  <tr>
    <td>Guest Access</td>
    <td><input name="wlt_field[timeaccess][99][time]" type="text" value="<?php if(is_array($current_access) && isset($current_access[99])){ echo $current_access[99]['time']; } ?>" /></td>
    <td><input name="wlt_field[timeaccess][99][link]" type="text" value="<?php if(is_array($current_access) && isset($current_access[99])){ echo $current_access[99]['link']; } ?>" /></td>
	</tr>
    <td>Member (no membership)</td>
    <td><input name="wlt_field[timeaccess][100][time]" type="text" value="<?php if(is_array($current_access) && isset($current_access[100])){ echo $current_access[100]['time']; } ?>" /></td>
    <td><input name="wlt_field[timeaccess][100][link]" type="text" value="<?php if(is_array($current_access) && isset($current_access[100])){ echo $current_access[100]['link']; } ?>" /></td>
	</tr>
    <?php 
	$i=0;
	if(is_array($membershipfields)){
	foreach($membershipfields as $mID=>$package){	
 
	?>
    <tr>
    <td><?php echo $package['name']; ?></td>
    <td><input name="wlt_field[timeaccess][<?php echo $package['ID']; ?>][time]" type="text" value="<?php if(is_array($current_access) && isset($current_access[$package['ID']]) ){ echo $current_access[$package['ID']]['time']; } ?>" /></td>
    <td><input name="wlt_field[timeaccess][<?php echo $package['ID']; ?>][link]" type="text" value="<?php if(is_array($current_access) && isset($current_access[$package['ID']])){ echo $current_access[$package['ID']]['link']; } ?>" /></td>
	</tr>
    <?php
		
	$i++;		
	} // end foreach
	}
    ?>

  
</table>

<hr />
<p><b class="label" style="background:#666;color:#fff;padding:4px;">Note</b> Use the value [ID] in your redirect string to include the listing ID. Redirecting to your registration page will display an image preview. </p>
<p>Example Link: <?php echo home_url(); ?>/wp-login.php?action=register&amp;pid=[ID]</p>