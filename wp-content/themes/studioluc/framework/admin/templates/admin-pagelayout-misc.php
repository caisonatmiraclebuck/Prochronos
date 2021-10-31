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


// LOAD IN MAIN DEFAULTS 
$core_admin_values = get_option("core_admin_values");  
  
?> 
 

      
         <div class="heading2">No Access Layout</div>
         
         <p>Here you can enter your own combination of html and PremiumPress shortcodes to create the display a user will see when they do not membership access to view a listing.</p>          
          <?php  if(!isset($core_admin_values['noaccesscode']) || (isset($core_admin_values['noaccesscode']) && $core_admin_values['noaccesscode'] == "") ){
          $core_admin_values['noaccesscode'] = '<div class="well">
<i class="fa fa-ban" style="color:red;font-size:100px;float:left; margin-right:40px;"></i>
<div class="center"><h1 style="margin-top:0px;">No Access</h1><h3>Sorry your membership level prevents access to this listing.</h3>
<p>Please upgrade your membership to gain access to this page.</p>
</div></div>';}?>
          <textarea class="row-fluid" id="printpagecode" name="admin_values[noaccesscode]" style="height:200px;background:#E8FDE9"><?php echo stripslashes($core_admin_values['noaccesscode']); ?></textarea>        
 
     
        

<div class="heading2">Fallback Results Layout</div>
    
             <p>Fallback - used for all non-<?php echo THEME_TAXONOMY."_type"; ?> listings.</p>
             
            <textarea class="row-fluid" id="default-textarea"  style="height:100px;background:#E8FDE9" name="admin_values[itemcode_fallback]"><?php 
            
            if($core_admin_values['itemcode_fallback'] == ""){ echo '[IMAGE]<h1>[TITLE]</h1>[EXCERPT]'; }else{ echo stripslashes($core_admin_values['itemcode_fallback']); } ?></textarea>
 

 