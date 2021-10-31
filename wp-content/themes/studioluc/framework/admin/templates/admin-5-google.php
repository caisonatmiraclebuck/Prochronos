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

 
            
            

            
            



<div class="heading2"> Google Maps</div>     
             
 
       <div class="form-row control-group row-fluid ">
                            <label class="control-label span4 offset2" rel="tooltip" data-original-title="Turn ON this feature to display a Google map on submission pages to collect long/lat data for mapping user listings. *recommended*" data-placement="top">Enable Maps</label>
                            <div class="controls span4">
                              <div class="row-fluid">
                                <div class="pull-left">
                                  <label class="radio off">
                                  <input type="radio" name="toggle" 
                                  value="off" onchange="document.getElementById('google').value='0'">
                                  </label>
                                  <label class="radio on">
                                  <input type="radio" name="toggle"
                                  value="on" onchange="document.getElementById('google').value='1'">
                                  </label>
                                  <div class="toggle <?php if($core_admin_values['google'] == '1'){  ?>on<?php } ?>">
                                    <div class="yes">ON</div>
                                    <div class="switch"></div>
                                    <div class="no">OFF</div>
                                  </div>
                                </div> 
                               </div>
                             </div>
                             
                             <input type="hidden" class="row-fluid" id="google" name="admin_values[google]" 
                             value="<?php echo $core_admin_values['google']; ?>">
            </div>  
                  
            
     <div class="form-row control-group row-fluid ">
                            <label class="control-label span4 offset2" rel="tooltip" data-original-title="Turn ON to require the user to select a map location otherwise it can be ignored." data-placement="top">Map Required</label>
                            <div class="controls span4">
                              <div class="row-fluid">
                                <div class="pull-left">
                                  <label class="radio off">
                                  <input type="radio" name="toggle" 
                                  value="off" onchange="document.getElementById('google_required').value='0'">
                                  </label>
                                  <label class="radio on">
                                  <input type="radio" name="toggle"
                                  value="on" onchange="document.getElementById('google_required').value='1'">
                                  </label>
                                  <div class="toggle <?php if($core_admin_values['google_required'] == '1'){  ?>on<?php } ?>">
                                    <div class="yes">ON</div>
                                    <div class="switch"></div>
                                    <div class="no">OFF</div>
                                  </div>
                                </div> 
                               </div>
                             </div>
                             
                             <input type="hidden" class="row-fluid" id="google_required" name="admin_values[google_required]" 
                             value="<?php echo $core_admin_values['google_required']; ?>">
            </div>  
            
            
            
  
            <?php 
			
			if($core_admin_values['google_region'] == ""){ $core_admin_values['google_region'] = "us"; } 
			if($core_admin_values['google_lang'] == ""){ $core_admin_values['google_lang'] = "en"; }
			?>
            
            <!------------ FIELD -------------->          
            <div class="row-fluid" >
          
                <label class="control-label span4 offset2">Region Code <br /><small style="color: #ccc;">list at bottom <a href="http://en.wikipedia.org/wiki/CcTLD" target="_blank" >here</a></small></label>
                <div class="controls span4">         
                
                  <input type="text"  name="admin_values[google_region]" value="<?php echo $core_admin_values['google_region']; ?>" style="width:100%">
                       
                </div>
             
            </div>
            <!------------ END FIELD -------------->
            
        
            
            <!------------ FIELD -------------->          
            <div class="row-fluid" >
                <label class="control-label span4 offset2">Language Code <br /><small style="color: #ccc;">list found <a href="https://spreadsheets.google.com/pub?key=p9pdwsai2hDMsLkXsoM05KQ&gid=1" target="_blank">here</a></small></label>
                <div class="controls span4">         
                
                  <input type="text"  name="admin_values[google_lang]" value="<?php echo $core_admin_values['google_lang']; ?>" style="width:100%">
                       
                </div>
            </div>
            <!------------ END FIELD -------------->
         
             
            
            <?php 
			
			if($core_admin_values['google_coords'] == ""){ $core_admin_values['google_coords'] = "0,0"; } 
			if($core_admin_values['google_zoom'] == ""){ $core_admin_values['google_zoom'] = 8; }
			?>
            
            <!------------ FIELD -------------->          
            <div class="row-fluid" >
                <label class="control-label span4 offset2">Map Zoom <br /><small style="color: #ccc;">value between 0 - 20</small> </label>
                <div class="controls span4">         
                 <div class="input-prepend">
                  <span class="add-on">#</span>
                  <input type="text"  name="admin_values[google_zoom]" value="<?php echo $core_admin_values['google_zoom']; ?>" style="width:60px;">
                </div>        
                </div>
            </div>
            <!------------ END FIELD -------------->
            
        
            
            <!------------ FIELD -------------->          
            <div class="row-fluid" >
                <label class="control-label span4 offset2">Map Cords <br /><small style="color: #ccc;">numeric values only</small></label>
                <div class="controls span3">         
                 <div class="input-prepend">
                  <span class="add-on">lat,long</span>
                  <input type="text"  name="admin_values[google_coords]" value="<?php echo $core_admin_values['google_coords']; ?>" style="width:200px; text-align:right">
                </div>        
                </div>
            </div>
            <!------------ END FIELD -------------->
            





 