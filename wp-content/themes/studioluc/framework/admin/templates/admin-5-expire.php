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
 

 

<div class="fieldbox">

              <div class="form-row control-group row-fluid ">
                            <label class="control-label span6">Hide Expired Listings</label>
                            <div class="controls span5">
                              <div class="row-fluid">
                                <div class="pull-left">
                                  <label class="radio off">
                                  <input type="radio" name="toggle" 
                                  value="off" onchange="document.getElementById('hide_expired').value='0'">
                                  </label>
                                  <label class="radio on">
                                  <input type="radio" name="toggle"
                                  value="on" onchange="document.getElementById('hide_expired').value='1'">
                                  </label>
                                  <div class="toggle <?php if($core_admin_values['hide_expired'] == '1'){  ?>on<?php } ?>">
                                    <div class="yes">ON</div>
                                    <div class="switch"></div>
                                    <div class="no">OFF</div>
                                  </div>
                                </div> 
                               </div>
                             </div>
                             
                             <input type="hidden" class="row-fluid" id="hide_expired" name="admin_values[hide_expired]" 
                             value="<?php echo $core_admin_values['hide_expired']; ?>">
            </div>  
            
            
<p> Turn ON to hide the display of all expired listings from your website.</p>

        
     
</div>
           
            
<div class="fieldbox">
            
            
                        <div class="form-row control-group row-fluid ">
                            <label class="control-label span6">Disable Expired Actions </label>
                            <div class="controls span5">
                              <div class="row-fluid">
                                <div class="pull-left">
                                  <label class="radio off">
                                  <input type="radio" name="toggle" 
                                  value="off" onchange="document.getElementById('stop_expired').value='0'">
                                  </label>
                                  <label class="radio on">
                                  <input type="radio" name="toggle"
                                  value="on" onchange="document.getElementById('stop_expired').value='1'">
                                  </label>
                                  <div class="toggle <?php if($core_admin_values['stop_expired'] == '1'){  ?>on<?php } ?>">
                                    <div class="yes">ON</div>
                                    <div class="switch"></div>
                                    <div class="no">OFF</div>
                                  </div>
                                </div> 
                               </div>
                             </div>
                             
                             <input type="hidden" class="row-fluid" id="stop_expired" name="admin_values[stop_expired]" 
                             value="<?php echo $core_admin_values['stop_expired']; ?>">
            </div>
             
  
   
<p>Turn ON to stop the theme from performing any expiry actions stopping listings from ever expiring.</p>

</div>
        