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
 

<div class="heading2">  Media Uploading </div>     
        
                    
                    
<div class="fieldbox">
       
        <div class="form-row control-group row-fluid ">
                            <label class="control-label span6" rel="tooltip" data-original-title="Turn ON if you want to force the users to upload an image with their listing." data-placement="top">Require Image Upload</label>
                            <div class="controls span6">
                              <div class="row-fluid">
                                <div class="pull-left">
                                  <label class="radio off">
                                  <input type="radio" name="toggle" 
                                  value="off" onchange="document.getElementById('require_image').value='0'">
                                  </label>
                                  <label class="radio on">
                                  <input type="radio" name="toggle"
                                  value="on" onchange="document.getElementById('require_image').value='1'">
                                  </label>
                                  <div class="toggle <?php if($core_admin_values['require_image'] == '1'){  ?>on<?php } ?>">
                                    <div class="yes">ON</div>
                                    <div class="switch"></div>
                                    <div class="no">OFF</div>
                                  </div>
                                </div> 
                               </div>
                             </div>
                             
                             <input type="hidden" class="row-fluid" id="require_image" name="admin_values[require_image]" value="<?php echo $core_admin_values['require_image']; ?>">
            </div>    
            
            
                    
        <div class="form-row control-group row-fluid ">
                            <label class="control-label span6" rel="tooltip" data-original-title="Turn ON to allow video uploads." data-placement="top">Allow Video Files</label>
                            <div class="controls span6">
                              <div class="row-fluid">
                                <div class="pull-left">
                                  <label class="radio off">
                                  <input type="radio" name="toggle" 
                                  value="off" onchange="document.getElementById('allow_video').value='0'">
                                  </label>
                                  <label class="radio on">
                                  <input type="radio" name="toggle"
                                  value="on" onchange="document.getElementById('allow_video').value='1'">
                                  </label>
                                  <div class="toggle <?php if($core_admin_values['allow_video'] == '1'){  ?>on<?php } ?>">
                                    <div class="yes">ON</div>
                                    <div class="switch"></div>
                                    <div class="no">OFF</div>
                                  </div>
                                </div> 
                               </div>
                             </div>
                             
                             <input type="hidden" class="row-fluid" id="allow_video" name="admin_values[allow_video]" value="<?php echo $core_admin_values['allow_video']; ?>">
            </div>                  
                    
        <div class="form-row control-group row-fluid ">
                            <label class="control-label span6" rel="tooltip" data-original-title="Turn ON to allow doc uploads." data-placement="top">Allow Document Files</label>
                            <div class="controls span6">
                              <div class="row-fluid">
                                <div class="pull-left">
                                  <label class="radio off">
                                  <input type="radio" name="toggle" 
                                  value="off" onchange="document.getElementById('allow_docs').value='0'">
                                  </label>
                                  <label class="radio on">
                                  <input type="radio" name="toggle"
                                  value="on" onchange="document.getElementById('allow_docs').value='1'">
                                  </label>
                                  <div class="toggle <?php if($core_admin_values['allow_docs'] == '1'){  ?>on<?php } ?>">
                                    <div class="yes">ON</div>
                                    <div class="switch"></div>
                                    <div class="no">OFF</div>
                                  </div>
                                </div> 
                               </div>
                             </div>
                             
                             <input type="hidden" class="row-fluid" id="allow_docs" name="admin_values[allow_docs]" value="<?php echo $core_admin_values['allow_docs']; ?>">
            </div>                  
                     
                    
                    
        <div class="form-row control-group row-fluid ">
                            <label class="control-label span6" rel="tooltip" data-original-title="Turn ON to allow audio uploads." data-placement="top">Allow Audio Files</label>
                            <div class="controls span6">
                              <div class="row-fluid">
                                <div class="pull-left">
                                  <label class="radio off">
                                  <input type="radio" name="toggle" 
                                  value="off" onchange="document.getElementById('allow_audio').value='0'">
                                  </label>
                                  <label class="radio on">
                                  <input type="radio" name="toggle"
                                  value="on" onchange="document.getElementById('allow_audio').value='1'">
                                  </label>
                                  <div class="toggle <?php if($core_admin_values['allow_audio'] == '1'){  ?>on<?php } ?>">
                                    <div class="yes">ON</div>
                                    <div class="switch"></div>
                                    <div class="no">OFF</div>
                                  </div>
                                </div> 
                               </div>
                             </div>
                             
                             <input type="hidden" class="row-fluid" id="allow_audio" name="admin_values[allow_audio]" value="<?php echo $core_admin_values['allow_audio']; ?>">
            </div>            

</div>   
 