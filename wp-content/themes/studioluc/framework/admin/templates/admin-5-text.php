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

global $wpdb, $CORE, $userdata, $CORE_ADMIN;

// LOAD IN MAIN DEFAULTS 
$core_admin_values = get_option("core_admin_values");  
  
?> 
 

<div class="heading2">  Additional Text </div>    

    
<div class="fieldbox">

<label><b>Add Listing Text</b></label>

<textarea class="row-fluid" id="default-textarea" style="height:140px;" name="admin_values[custom][add_text]"><?php echo stripslashes($core_admin_values['custom']['add_text']); ?></textarea> 

<p>Text you enter here will display under the header of the submission form when a user is creating a new listing.</p>

</div>                     
    
    
    
<div class="fieldbox">

<label><b>Edit Listing Text</b></label>

<textarea class="row-fluid" id="default-textarea" style="height:140px;" name="admin_values[custom][edit_text]"><?php echo stripslashes($core_admin_values['custom']['edit_text']); ?></textarea> 

<p>Text you enter here will display under the header of the submission form when a user is editing an existing listing.</p>

</div>  

<div class="fieldbox">

<label><b>Pricing Table Text</b></label>
        
            
  <textarea class="row-fluid" id="default-textarea" style="height:140px;" name="admin_values[custom][package_text]"><?php echo stripslashes($core_admin_values['custom']['package_text']); ?></textarea>
  
 <p>Text you enter here will display above listing packages on the pricing table. (if enabled) </p>
      
 
</div>  