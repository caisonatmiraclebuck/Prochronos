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



 

 <div class="box gradient"> 
 
          <div class="title">
            <h3> <span> Email Settings</span> </h3>
          </div>
  		<div class="content">
        
        
 
        <div class="form-row control-group row-fluid">
            <label class="control-label span5">From Email</label>
            <div class="controls span6">
            <input type="text"  name="adminArray[admin_email]" class="row-fluid"  value="<?php echo get_option('admin_email'); ?>">            
            </div>
        </div>
    
        <div class="form-row control-group row-fluid">
            <label class="control-label span5" rel="tooltip" data-original-title="This will display as the sender on all emails sent from your website." data-placement="top">From Name</label>
            <div class="controls span6">
            <input type="text"  name="adminArray[emailfrom]" class="row-fluid"  value="<?php echo get_option('emailfrom'); ?>">            
            </div>
        </div> 
        
<hr />
        
        
        <div class="form-row controls row-fluid ">
<label class="control-label span9"  style="line-height: 30px;" rel="tooltip" data-original-title="Turn off if you dont want WordPress to add paragraphs to your emails." data-placement="top">Disable Auto-Paragraphs</label>
<div class="controls span2" style="margin: 0px;">
 <div class="row-fluid">
                                <div class="pull-left">
                                  <label class="radio off">
                                  <input type="radio" name="toggle" 
                                  value="off" onchange="document.getElementById('wordpress_autopdisable').value='0'">
                                  </label>
                                  <label class="radio on">
                                  <input type="radio" name="toggle"
                                  value="on" onchange="document.getElementById('wordpress_autopdisable').value='1'">
                                  </label>
                                  <div class="toggle <?php if($core_admin_values['wordpress_autopdisable'] == '1'){  ?>on<?php } ?>">
                                    <div class="yes">ON</div>
                                    <div class="switch"></div>
                                    <div class="no">OFF</div>
                                  </div>
                                </div> 
                               </div>
                             </div>
                             
                             <input type="hidden" class="row-fluid" id="wordpress_autopdisable" name="admin_values[wordpress_autopdisable]" 
                             value="<?php echo $core_admin_values['wordpress_autopdisable']; ?>">
            </div>
 
      
        <div class="form-row controls row-fluid ">
<label class="control-label span9"  style="line-height: 30px;" rel="tooltip" data-original-title="Turn off if you dont want WordPress to send new users a welcome email." data-placement="top">Send WordPress Registration Email</label>
<div class="controls span2" style="margin: 0px;">
 <div class="row-fluid">
                                <div class="pull-left">
                                  <label class="radio off">
                                  <input type="radio" name="toggle" 
                                  value="off" onchange="document.getElementById('wordpress_welcomeemail').value='0'">
                                  </label>
                                  <label class="radio on">
                                  <input type="radio" name="toggle"
                                  value="on" onchange="document.getElementById('wordpress_welcomeemail').value='1'">
                                  </label>
                                  <div class="toggle <?php if($core_admin_values['wordpress_welcomeemail'] == '1'){  ?>on<?php } ?>">
                                    <div class="yes">ON</div>
                                    <div class="switch"></div>
                                    <div class="no">OFF</div>
                                  </div>
                                </div> 
                               </div>
                             </div>
                             
                             <input type="hidden" class="row-fluid" id="wordpress_welcomeemail" name="admin_values[wordpress_welcomeemail]" 
                             value="<?php echo $core_admin_values['wordpress_welcomeemail']; ?>">
            </div>
</div> 




 



 <div class="form-actions row-fluid">
<div class="span7 offset5">
<button type="submit" class="btn btn-primary">Save Changes</button> 
</div>
</div>  
            
            
</div>




 

<div class="clearfix"></div>









        
        
        
        
  
