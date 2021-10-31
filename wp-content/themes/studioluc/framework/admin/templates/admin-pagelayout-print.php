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


 <div class="heading2">Page Layout </div> 
 

 
  
        <p>Enter your own combination of html and PremiumPress shortcodes to achieve your desired layout.</p>  
          <?php  if(!isset($core_admin_values['printcode']) || (isset($core_admin_values['printcode']) && $core_admin_values['printcode'] == "") ){  
          $core_admin_values['printcode'] = '<div class="center">
            <p id="postTitle">[TITLE-NOLINK]</p>
            <p id="postMeta">Date:<strong>[DATE]</strong>  </p>
            <p id="postLink">[LINK]</p>   
            <div id="postContent">[IMAGE] [CONTENT]</div>     
            <div id="postFields">[FIELDS]</div>
            <p id="printNow"><a href="#print" onClick="window.print(); return false;" title="Click to print">Print</a></p>
            </div>';}?>
        <textarea class="row-fluid" id="printpagecode" name="admin_values[printcode]" style="height:200px;background:#E8FDE9"><?php echo stripslashes($core_admin_values['printcode']); ?></textarea>
 