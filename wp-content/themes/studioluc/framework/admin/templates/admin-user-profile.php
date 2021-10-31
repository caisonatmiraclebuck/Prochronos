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


 <div class="heading2">Display Options</div> 
 
 
  <div class="form-row control-group row-fluid ">
                                <label class="control-label span5 offset3" rel="tooltip" data-original-title="This will prevent users from accessing the user profile page." data-placement="top">Enable User Profiles</label>
                                <div class="controls span4">
                                  <div class="row-fluid">
                                    <div class="pull-left">
                                      <label class="radio off">
                                      <input type="radio" name="toggle" 
                                      value="off" onchange="document.getElementById('allow_profile').value='0'">
                                      </label>
                                      <label class="radio on">
                                      <input type="radio" name="toggle"
                                      value="on" onchange="document.getElementById('allow_profile').value='1'">
                                      </label>
                                      <div class="toggle <?php if($core_admin_values['allow_profile'] == '1'){  ?>on<?php } ?>">
                                        <div class="yes">ON</div>
                                        <div class="switch"></div>
                                        <div class="no">OFF</div>
                                      </div>
                                    </div> 
                                   </div>
                                 </div>
                                 
                                 <input type="hidden" class="row-fluid" id="allow_profile" name="admin_values[allow_profile]" 
                                 value="<?php if($core_admin_values['allow_profile'] == ""){ echo 1; }else{ echo $core_admin_values['allow_profile']; } ?>">
    </div> 
    
     