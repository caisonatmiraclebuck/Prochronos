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


 <div class="heading2">Display Layout</div> 
 
 
    
    
          <div class="form-row control-group row-fluid ">
                                <label class="control-label span5 offset3"    data-placement="top">Default User Country</label>
                                <div class="controls span4">
                                   <select name="admin_values[account_usercountry]" class="chzn-select" id="ul1">

         <?php
		 
		  $selected = $core_admin_values['account_usercountry'];
				 
                 foreach ($GLOBALS['core_country_list'] as $key=>$option) {				 				
                 	printf( '<option value="%1$s"%3$s>%2$s</option>', trim( $key  ), $option, selected( $selected, $key, false ) );
                 }
		 
		 ?> 
         
        </select>
        
        </div>
                                 
                                 
    </div>  
    
    
 <div class="heading2">Display Options</div> 
 
 

    
    <?php
	
	if($core_admin_values['show_account_edit'] == ""){ 		$core_admin_values['show_account_edit'] = 1; }
	if($core_admin_values['show_account_create'] == ""){ 	$core_admin_values['show_account_create'] = 1; }
 
	?>
    
    <?php if(!defined('WLT_DATING') && !defined('WLT_CART') ){ ?>
    <div class="form-row control-group row-fluid ">
                                <label class="control-label span5 offset3" rel="tooltip"  data-placement="top">Display Profile Links</label>
                                <div class="controls span4">
                                  <div class="row-fluid">
                                    <div class="pull-left">
                                      <label class="radio off">
                                      <input type="radio" name="toggle" 
                                      value="off" onchange="document.getElementById('show_profilelinks').value='0'">
                                      </label>
                                      <label class="radio on">
                                      <input type="radio" name="toggle"
                                      value="on" onchange="document.getElementById('show_profilelinks').value='1'">
                                      </label>
                                      <div class="toggle <?php if($core_admin_values['show_profilelinks'] == '1'){  ?>on<?php } ?>">
                                        <div class="yes">ON</div>
                                        <div class="switch"></div>
                                        <div class="no">OFF</div>
                                      </div>
                                    </div> 
                                   </div>
                                 </div>
                                 
                                 <input type="hidden" class="row-fluid" id="show_profilelinks" name="admin_values[show_profilelinks]" 
                                 value="<?php echo $core_admin_values['show_profilelinks']; ?>">
    </div> 
    <?php }else{ ?>
    
    <input type="hidden"  name="admin_values[show_profilelinks]"   value="0">
     
    <?php } ?>
	
	
    
    <div class="form-row control-group row-fluid ">
                                <label class="control-label span5 offset3" rel="tooltip" data-original-title="This will turn on/off the display block for my account section of the users account page." data-placement="top">Display My Account</label>
                                <div class="controls span4">
                                  <div class="row-fluid">
                                    <div class="pull-left">
                                      <label class="radio off">
                                      <input type="radio" name="toggle" 
                                      value="off" onchange="document.getElementById('show_account_edit').value='0'">
                                      </label>
                                      <label class="radio on">
                                      <input type="radio" name="toggle"
                                      value="on" onchange="document.getElementById('show_account_edit').value='1'">
                                      </label>
                                      <div class="toggle <?php if($core_admin_values['show_account_edit'] == '1'){  ?>on<?php } ?>">
                                        <div class="yes">ON</div>
                                        <div class="switch"></div>
                                        <div class="no">OFF</div>
                                      </div>
                                    </div> 
                                   </div>
                                 </div>
                                 
                                 <input type="hidden" class="row-fluid" id="show_account_edit" name="admin_values[show_account_edit]" 
                                 value="<?php echo $core_admin_values['show_account_edit']; ?>">
    </div>  
    
    <?php if(!defined('WLT_CART')){ ?>	
    <div class="form-row control-group row-fluid ">
                                <label class="control-label span5 offset3" rel="tooltip" data-original-title="This will allow users to send messages to each other." data-placement="top">Display Private Messages</label>
                                <div class="controls span4">
                                  <div class="row-fluid">
                                    <div class="pull-left">
                                      <label class="radio off">
                                      <input type="radio" name="toggle" 
                                      value="off" onchange="document.getElementById('message_system').value='0'">
                                      </label>
                                      <label class="radio on">
                                      <input type="radio" name="toggle"
                                      value="on" onchange="document.getElementById('message_system').value='1'">
                                      </label>
                                      <div class="toggle <?php if($core_admin_values['message_system'] == '1'){  ?>on<?php } ?>">
                                        <div class="yes">ON</div>
                                        <div class="switch"></div>
                                        <div class="no">OFF</div>
                                      </div>
                                    </div> 
                                   </div>
                                 </div>
                                 
                                 <input type="hidden" class="row-fluid" id="message_system" name="admin_values[message_system]" 
                                 value="<?php echo $core_admin_values['message_system']; ?>">
    </div>  
     
    <div class="form-row control-group row-fluid ">
                                <label class="control-label span5 offset3" rel="tooltip" data-original-title="This will turn on/off the display block for creating a new listing." data-placement="top">Display Create Listing</label>
                                <div class="controls span4">
                                  <div class="row-fluid">
                                    <div class="pull-left">
                                      <label class="radio off">
                                      <input type="radio" name="toggle" 
                                      value="off" onchange="document.getElementById('show_account_create').value='0'">
                                      </label>
                                      <label class="radio on">
                                      <input type="radio" name="toggle"
                                      value="on" onchange="document.getElementById('show_account_create').value='1'">
                                      </label>
                                      <div class="toggle <?php if($core_admin_values['show_account_create'] == '1'){  ?>on<?php } ?>">
                                        <div class="yes">ON</div>
                                        <div class="switch"></div>
                                        <div class="no">OFF</div>
                                      </div>
                                    </div> 
                                   </div>
                                 </div>
                                 
                                 <input type="hidden" class="row-fluid" id="show_account_create" name="admin_values[show_account_create]" 
                                 value="<?php echo $core_admin_values['show_account_create']; ?>">
    </div>  
    
    <div class="form-row control-group row-fluid ">
                                <label class="control-label span5 offset3" rel="tooltip" data-original-title="This will turn on/off the display block for viewing existing listings." data-placement="top">Display My Listing</label>
                                <div class="controls span4">
                                  <div class="row-fluid">
                                    <div class="pull-left">
                                      <label class="radio off">
                                      <input type="radio" name="toggle" 
                                      value="off" onchange="document.getElementById('show_account_viewing').value='0'">
                                      </label>
                                      <label class="radio on">
                                      <input type="radio" name="toggle"
                                      value="on" onchange="document.getElementById('show_account_viewing').value='1'">
                                      </label>
                                      <div class="toggle <?php if($core_admin_values['show_account_viewing'] == '1'){  ?>on<?php } ?>">
                                        <div class="yes">ON</div>
                                        <div class="switch"></div>
                                        <div class="no">OFF</div>
                                      </div>
                                    </div> 
                                   </div>
                                 </div>
                                 
                                 <input type="hidden" class="row-fluid" id="show_account_viewing" name="admin_values[show_account_viewing]" 
                                 value="<?php echo $core_admin_values['show_account_viewing']; ?>">
    </div> 
    
        <div class="form-row control-group row-fluid ">
                                <label class="control-label span5 offset3" rel="tooltip" data-original-title="This will turn on/off the display block for creating a new listing." data-placement="top">Display Membership Packages</label>
                                <div class="controls span4">
                                  <div class="row-fluid">
                                    <div class="pull-left">
                                      <label class="radio off">
                                      <input type="radio" name="toggle" 
                                      value="off" onchange="document.getElementById('show_account_membership').value='0'">
                                      </label>
                                      <label class="radio on">
                                      <input type="radio" name="toggle"
                                      value="on" onchange="document.getElementById('show_account_membership').value='1'">
                                      </label>
                                      <div class="toggle <?php if($core_admin_values['show_account_membership'] == '1'){  ?>on<?php } ?>">
                                        <div class="yes">ON</div>
                                        <div class="switch"></div>
                                        <div class="no">OFF</div>
                                      </div>
                                    </div> 
                                   </div>
                                 </div>
                                 
                                 <input type="hidden" class="row-fluid" id="show_account_membership" name="admin_values[show_account_membership]" 
                                 value="<?php echo $core_admin_values['show_account_membership']; ?>">
    </div>  
    
     
    
    <div class="form-row control-group row-fluid ">
                                <label class="control-label span5 offset3" rel="tooltip" data-original-title="This will turn on/off the display block for subscriptions" data-placement="top">Display Email Subscriptions</label>
                                <div class="controls span4">
                                  <div class="row-fluid">
                                    <div class="pull-left">
                                      <label class="radio off">
                                      <input type="radio" name="toggle" 
                                      value="off" onchange="document.getElementById('show_account_subscriptions').value='0'">
                                      </label>
                                      <label class="radio on">
                                      <input type="radio" name="toggle"
                                      value="on" onchange="document.getElementById('show_account_subscriptions').value='1'">
                                      </label>
                                      <div class="toggle <?php if($core_admin_values['show_account_subscriptions'] == '1'){  ?>on<?php } ?>">
                                        <div class="yes">ON</div>
                                        <div class="switch"></div>
                                        <div class="no">OFF</div>
                                      </div>
                                    </div> 
                                   </div>
                                 </div>
                                 
                                 <input type="hidden" class="row-fluid" id="show_account_subscriptions" name="admin_values[show_account_subscriptions]" 
                                 value="<?php echo $core_admin_values['show_account_subscriptions']; ?>">
    </div>
    
    

    
    
    <?php } ?> 
     <div class="form-row control-group row-fluid ">
                                <label class="control-label span5 offset3" rel="tooltip" data-original-title="This will turn on/off the display block for favorites" data-placement="top">Display My Favorites</label>
                                <div class="controls span4">
                                  <div class="row-fluid">
                                    <div class="pull-left">
                                      <label class="radio off">
                                      <input type="radio" name="toggle" 
                                      value="off" onchange="document.getElementById('show_account_favs').value='0'">
                                      </label>
                                      <label class="radio on">
                                      <input type="radio" name="toggle"
                                      value="on" onchange="document.getElementById('show_account_favs').value='1'">
                                      </label>
                                      <div class="toggle <?php if($core_admin_values['show_account_favs'] == '1'){  ?>on<?php } ?>">
                                        <div class="yes">ON</div>
                                        <div class="switch"></div>
                                        <div class="no">OFF</div>
                                      </div>
                                    </div> 
                                   </div>
                                 </div>
                                 
                                 <input type="hidden" class="row-fluid" id="show_account_favs" name="admin_values[show_account_favs]" 
                                 value="<?php echo $core_admin_values['show_account_favs']; ?>">
    </div> 
    
    
  <div class="heading2">Extras</div>   
    
    <div class="form-row control-group row-fluid ">
                                <label class="control-label span5 offset3" rel="tooltip" data-original-title="This will turn on/off the display block for latest news" data-placement="top">Display Latest News</label>
                                <div class="controls span4">
                                  <div class="row-fluid">
                                    <div class="pull-left">
                                      <label class="radio off">
                                      <input type="radio" name="toggle" 
                                      value="off" onchange="document.getElementById('show_account_latestnews').value='0'">
                                      </label>
                                      <label class="radio on">
                                      <input type="radio" name="toggle"
                                      value="on" onchange="document.getElementById('show_account_latestnews').value='1'">
                                      </label>
                                      <div class="toggle <?php if($core_admin_values['show_account_latestnews'] == '1'){  ?>on<?php } ?>">
                                        <div class="yes">OFF</div>
                                        <div class="switch"></div>
                                        <div class="no">ON</div>
                                      </div>
                                    </div> 
                                   </div>
                                 </div>
                                 
                                 <input type="hidden" class="row-fluid" id="show_account_latestnews" name="admin_values[show_account_latestnews]" 
                                 value="<?php echo $core_admin_values['show_account_latestnews']; ?>">
    </div>

    
    
    <div class="heading2">My Details Tab</div> 
    
      <div class="form-row control-group row-fluid ">
                                <label class="control-label span5 offset3" rel="tooltip" data-original-title="This will turn on/off the display of the default first and last name field boxes." data-placement="top">Show First/Last Name Fields</label>
                                <div class="controls span4">
                                  <div class="row-fluid">
                                    <div class="pull-left">
                                      <label class="radio off">
                                      <input type="radio" name="toggle" 
                                      value="off" onchange="document.getElementById('show_account_names').value='0'">
                                      </label>
                                      <label class="radio on">
                                      <input type="radio" name="toggle"
                                      value="on" onchange="document.getElementById('show_account_names').value='1'">
                                      </label>
                                      <div class="toggle <?php if($core_admin_values['show_account_names'] == '1'){  ?>on<?php } ?>">
                                        <div class="yes">ON</div>
                                        <div class="switch"></div>
                                        <div class="no">OFF</div>
                                      </div>
                                    </div> 
                                   </div>
                                 </div>
                                 
                                 <input type="hidden" class="row-fluid" id="show_account_names" name="admin_values[show_account_names]" 
                                 value="<?php echo $core_admin_values['show_account_names']; ?>">
    </div>   
    
    
    
    
      <div class="form-row control-group row-fluid ">
                                <label class="control-label span5 offset3" rel="tooltip" data-original-title="This will turn on/off the display of the default first and last name field boxes." data-placement="top">Show User Photo Upload</label>
                                <div class="controls span4">
                                  <div class="row-fluid">
                                    <div class="pull-left">
                                      <label class="radio off">
                                      <input type="radio" name="toggle" 
                                      value="off" onchange="document.getElementById('show_account_photo').value='0'">
                                      </label>
                                      <label class="radio on">
                                      <input type="radio" name="toggle"
                                      value="on" onchange="document.getElementById('show_account_photo').value='1'">
                                      </label>
                                      <div class="toggle <?php if($core_admin_values['show_account_photo'] == '1'){  ?>on<?php } ?>">
                                        <div class="yes">ON</div>
                                        <div class="switch"></div>
                                        <div class="no">OFF</div>
                                      </div>
                                    </div> 
                                   </div>
                                 </div>
                                 
                                 <input type="hidden" class="row-fluid" id="show_account_photo" name="admin_values[show_account_photo]" 
                                 value="<?php echo $core_admin_values['show_account_photo']; ?>">
    </div>  
    


          <div class="form-row control-group row-fluid ">
                                <label class="control-label span5 offset3" rel="tooltip" data-original-title="This will turn on/off the display of the social media input boxes." data-placement="top">Show Social Media Options</label>
                                <div class="controls span4">
                                  <div class="row-fluid">
                                    <div class="pull-left">
                                      <label class="radio off">
                                      <input type="radio" name="toggle" 
                                      value="off" onchange="document.getElementById('show_account_social').value='0'">
                                      </label>
                                      <label class="radio on">
                                      <input type="radio" name="toggle"
                                      value="on" onchange="document.getElementById('show_account_social').value='1'">
                                      </label>
                                      <div class="toggle <?php if($core_admin_values['show_account_social'] == '1'){  ?>on<?php } ?>">
                                        <div class="yes">ON</div>
                                        <div class="switch"></div>
                                        <div class="no">OFF</div>
                                      </div>
                                    </div> 
                                   </div>
                                 </div>
                                 
                                 <input type="hidden" class="row-fluid" id="show_account_social" name="admin_values[show_account_social]" 
                                 value="<?php echo $core_admin_values['show_account_social']; ?>">
    </div>  
  