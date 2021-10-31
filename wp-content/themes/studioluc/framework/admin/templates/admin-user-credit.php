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

    <div class="heading2">User Credit Options</div> 
    
    <div style="padding:10px; background:#fff; border:1px dashed green; font-size:11px; margin-bottom:10px;">
    
    User credit is added or removed by editing a users profile in the admin area. Users can use credit to purchase listings or requests for credit withdrawal can be found in the order manager section.
    
    </div>
    
   
         <div class="form-row control-group row-fluid ">
                                <label class="control-label span4 offset3" rel="tooltip" data-original-title="Turn on/off user credit withdrawal options." data-placement="top">Display Withdrawal Box</label>
                                <div class="controls span4">
                                  <div class="row-fluid">
                                    <div class="pull-left">
                                      <label class="radio off">
                                      <input type="radio" name="toggle" 
                                      value="off" onchange="document.getElementById('show_account_withdraw').value='0'">
                                      </label>
                                      <label class="radio on">
                                      <input type="radio" name="toggle"
                                      value="on" onchange="document.getElementById('show_account_withdraw').value='1'">
                                      </label>
                                      <div class="toggle <?php if($core_admin_values['show_account_withdraw'] == '1'){  ?>on<?php } ?>">
                                        <div class="yes">ON</div>
                                        <div class="switch"></div>
                                        <div class="no">OFF</div>
                                      </div>
                                    </div> 
                                   </div>
                                 </div>
                                 
                                 <input type="hidden" class="row-fluid" id="show_account_withdraw" name="admin_values[show_account_withdraw]" 
                                 value="<?php echo $core_admin_values['show_account_withdraw']; ?>">
    </div>    
     