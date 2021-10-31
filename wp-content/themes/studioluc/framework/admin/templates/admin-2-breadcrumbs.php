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


<div class="heading2">Breadcrumbs Layout <span>Choose options below;</span> </div>



<div class="fieldbox">
  
         <div class="form-row control-group row-fluid offset3">
                                <label class="control-label span5" data-placement="top">Website Breadcrumbs</label>
                                <div class="controls span4">
                                  <div class="row-fluid">
                                    <div class="pull-left">
                                      <label class="radio off">
                                      <input type="radio" name="toggle" 
                                      value="off" onchange="document.getElementById('breadcrumbs_inner').value='0'">
                                      </label>
                                      <label class="radio on">
                                      <input type="radio" name="toggle"
                                      value="on" onchange="document.getElementById('breadcrumbs_inner').value='1'">
                                      </label>
                                      <div class="toggle <?php if($core_admin_values['breadcrumbs_inner'] == '1'){  ?>on<?php } ?>">
                                        <div class="yes">ON</div>
                                        <div class="switch"></div>
                                        <div class="no">OFF</div>
                                      </div>
                                    </div> 
                                   </div>
                                 </div>
                                 
                                 <input type="hidden" class="row-fluid" id="breadcrumbs_inner" name="admin_values[breadcrumbs_inner]" 
                                 value="<?php echo $core_admin_values['breadcrumbs_inner']; ?>">
         </div>
             

<p>Turn ON if you want to display breadcrumb navigation on your website.</p>

</div>
        
      
<div class="fieldbox">

              <div class="form-row control-group row-fluid offset3">
                                <label class="control-label span5" data-placement="top">Show On Home Page</label>
                                <div class="controls span4">
                                  <div class="row-fluid">
                                    <div class="pull-left">
                                      <label class="radio off">
                                      <input type="radio" name="toggle" 
                                      value="off" onchange="document.getElementById('breadcrumbs_home').value='0'">
                                      </label>
                                      <label class="radio on">
                                      <input type="radio" name="toggle"
                                      value="on" onchange="document.getElementById('breadcrumbs_home').value='1'">
                                      </label>
                                      <div class="toggle <?php if($core_admin_values['breadcrumbs_home'] == '1'){  ?>on<?php } ?>">
                                        <div class="yes">ON</div>
                                        <div class="switch"></div>
                                        <div class="no">OFF</div>
                                      </div>
                                    </div> 
                                   </div>
                                 </div>
                                 
                                 <input type="hidden" class="row-fluid" id="breadcrumbs_home" name="admin_values[breadcrumbs_home]" 
                                 value="<?php echo $core_admin_values['breadcrumbs_home']; ?>">
         </div>

<p>Turn ON if you want breadcrumbs to also be displayed on your home page. <br />
(requires breadcrumbs to be enabled above)</p>

</div>
 


<div class="fieldbox">

         <div class="form-row control-group row-fluid offset3">
                                <label class="control-label span5" data-placement="top">Show Social Buttons (right)</label>
                                <div class="controls span4">
                                  <div class="row-fluid">
                                    <div class="pull-left">
                                      <label class="radio off">
                                      <input type="radio" name="toggle" 
                                      value="off" onchange="document.getElementById('breadcrumbs_social').value='0'">
                                      </label>
                                      <label class="radio on">
                                      <input type="radio" name="toggle"
                                      value="on" onchange="document.getElementById('breadcrumbs_social').value='1'">
                                      </label>
                                      <div class="toggle <?php if($core_admin_values['breadcrumbs_social'] == '1'){  ?>on<?php } ?>">
                                        <div class="yes">ON</div>
                                        <div class="switch"></div>
                                        <div class="no">OFF</div>
                                      </div>
                                    </div> 
                                   </div>
                                 </div>
                                 
                                 <input type="hidden" class="row-fluid" id="breadcrumbs_social" name="admin_values[breadcrumbs_social]" 
                                 value="<?php echo $core_admin_values['breadcrumbs_social']; ?>">
         </div>
             
<p>Turn ON if you want social media buttons to be included on the right of the breadcrumbs. (requires breadcrumbs to be enabled above)</p>

</div>