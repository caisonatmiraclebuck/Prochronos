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

if(!defined('WLT_DEMOMODE')){

// LOAD IN MAIN DEFAULTS 
$core_admin_values = get_option("core_admin_values");  
 
 
$providers = array(

	"twitter" => array(
		"name" => "Twitter",
		"help" => "http://hybridauth.sourceforge.net/userguide/IDProvider_info_Twitter.html",
	),

	"facebook" => array(
		"name" => "Facebook",
		"help" => "http://hybridauth.sourceforge.net/userguide/IDProvider_info_Facebook.html",
	),
	
	"google" => array(
		"name" => "Google",
		"help" => "http://hybridauth.sourceforge.net/userguide/IDProvider_info_Google.html",
	),
	
	"linkedin" => array(
		"name" => "LinkedIn",
		"help" => "http://hybridauth.sourceforge.net/userguide/IDProvider_info_LinkedIn.html",
	),

);
 
?> 

 
 <div class="heading2">Setup Options</div> 
 
 <p><b>Note</b> Please note this section is still currently in beta testing and may not work on all hosting accounts.</p>
 
 
  <div class="form-row control-group row-fluid ">
                                <label class="control-label span5 offset3">Enable Social Login Buttons</label>
                                <div class="controls span4">
                                  <div class="row-fluid">
                                    <div class="pull-left">
                                      <label class="radio off">
                                      <input type="radio" name="toggle" 
                                      value="off" onchange="document.getElementById('allow_socialbuttons').value='0'">
                                      </label>
                                      <label class="radio on">
                                      <input type="radio" name="toggle"
                                      value="on" onchange="document.getElementById('allow_socialbuttons').value='1'">
                                      </label>
                                      <div class="toggle <?php if($core_admin_values['allow_socialbuttons'] == '1'){  ?>on<?php } ?>">
                                        <div class="yes">ON</div>
                                        <div class="switch"></div>
                                        <div class="no">OFF</div>
                                      </div>
                                    </div> 
                                   </div>
                                 </div>
                                 
                                 <input type="hidden" class="row-fluid" id="allow_socialbuttons" name="admin_values[allow_socialbuttons]" 
                                 value="<?php if($core_admin_values['allow_socialbuttons'] == ""){ echo 0; }else{ echo $core_admin_values['allow_socialbuttons']; } ?>">
    </div> 
    
<?php foreach($providers as $key => $pro){ ?>
    
<div class="fieldbox">

  <div class="form-row control-group row-fluid ">
                                <label class="control-label span4">Enable <?php echo $pro['name']; ?> <br /> (<a href="<?php echo $pro['help']; ?>" target="_blank">learn more</a>)</label>
                                <div class="controls span4">
                                  <div class="row-fluid">
                                    <div class="pull-left">
                                      <label class="radio off">
                                      <input type="radio" name="toggle" 
                                      value="off" onchange="document.getElementById('social_<?php echo $key; ?>').value='0'">
                                      </label>
                                      <label class="radio on">
                                      <input type="radio" name="toggle"
                                      value="on" onchange="document.getElementById('social_<?php echo $key; ?>').value='1'">
                                      </label>
                                      <div class="toggle <?php if($core_admin_values['social_'.$key.''] == '1'){  ?>on<?php } ?>">
                                        <div class="yes">ON</div>
                                        <div class="switch"></div>
                                        <div class="no">OFF</div>
                                      </div>
                                    </div> 
                                   </div>
                                 </div>
                                 
                                 <input type="hidden" class="row-fluid" id="social_<?php echo $key; ?>" name="admin_values[social_<?php echo $key; ?>]" 
                                 value="<?php if($core_admin_values['social_'.$key.''] == ""){ echo 0; }else{ echo $core_admin_values['social_'.$key.'']; } ?>">
    </div> 

<div class="form-row control-group row-fluid">
                <label class="control-label span4" for="normal-field">App Key</label>
                <div class="controls span8">
                  <input type="text" class="row-fluid" name="admin_values[social_<?php echo $key; ?>_key1]" value="<?php echo $core_admin_values['social_'.$key.'_key1']; ?>" />
     
                </div>
            </div>
 
<div class="form-row control-group row-fluid">
                <label class="control-label span4" for="normal-field">App Secret Key</label>
                <div class="controls span8">
                  <input type="text" class="row-fluid" name="admin_values[social_<?php echo $key; ?>_key2]" value="<?php echo $core_admin_values['social_'.$key.'_key2']; ?>" />
     
                </div>
            </div>
</div>
    
<?php } } ?>