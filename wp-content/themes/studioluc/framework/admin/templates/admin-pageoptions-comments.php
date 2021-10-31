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
 
 
<div class="heading2">Comment Settings</div>

 
 <div class="fieldbox">

                  <div class="form-row control-group row-fluid ">
                            <label class="control-label span6" >Comment Captcha</label>
                            <div class="controls span5">
                              <div class="row-fluid">
                                <div class="pull-left">
                                  <label class="radio off">
                                  <input type="radio" name="toggle" 
                                  value="off" onchange="document.getElementById('comment_captcha').value='0'">
                                  </label>
                                  <label class="radio on">
                                  <input type="radio" name="toggle"
                                  value="on" onchange="document.getElementById('comment_captcha').value='1'">
                                  </label>
                                  <div class="toggle <?php if($core_admin_values['comment_captcha'] == '1'){  ?>on<?php } ?>">
                                    <div class="yes">ON</div>
                                    <div class="switch"></div>
                                    <div class="no">OFF</div>
                                  </div>
                                </div> 
                               </div>
                             </div>
                             
                             <input type="hidden" class="row-fluid" id="comment_captcha" name="admin_values[comment_captcha]" 
                             value="<?php echo $core_admin_values['comment_captcha']; ?>">
            </div> 
<p>Turn ON if you want the theme comment captcha to appear on your website.</p>      
</div>