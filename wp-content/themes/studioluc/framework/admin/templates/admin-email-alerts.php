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

global $CORE;

// LOAD IN MAIN DEFAULTS 
$core_admin_values = get_option("core_admin_values");  
 
  
?>

<p>Email alerts are sent to the admin when an event happens below;</p>

 
         <table id="datatable_example" class="responsive table table-striped table-bordered" style="width:100%;margin-bottom:0; ">
            <thead>
            <tr>
              <th class="no_sort">Event Description</th>
                            
              <th class="no_sort" style="width:110px;text-align:center;">Send Alert</th>
              
            </thead>
            <tbody>
            
        <?php
		
		
 	  
		foreach($CORE->wlt_emails_alerts as $key=>$field){ 
		
		
		if(!isset($core_admin_values[$key])){ $core_admin_values[$key] = 0; }
		?>
		<tr>
         <td><?php echo stripslashes($field['n']); ?></td>         
        
         <td class="ms controls content">
                          <label class="radio off">
                                  <input type="radio" name="toggle" 
                                  value="off" onchange="document.getElementById('<?php echo $key; ?>').value='0'">
                                  </label>
                                  <label class="radio on">
                                  <input type="radio" name="toggle"
                                  value="on" onchange="document.getElementById('<?php echo $key; ?>').value='1'">
                                  </label>
                                  <div class="toggle <?php if($core_admin_values[$key] == '1'){  ?>on<?php } ?>">
                                    <div class="yes">ON</div>
                                    <div class="switch"></div>
                                    <div class="no">OFF</div>
                                  </div>
                                </div> 
                               </div>
                             </div>
                             
                             <input type="hidden" class="row-fluid" id="<?php echo $key; ?>" name="admin_values[<?php echo $key; ?>]" 
                             value="<?php echo $core_admin_values[$key]; ?>">
            </td>
            </tr>
            <?php  }   ?> 
 
            </tbody>
            </table>
          
          
          
 <div class="box gradient" style="margin-top:30px;"> 
 
          <div class="title">
            <h3> <span>Alert Settings</span> </h3>
          </div>
  		<div class="content">
        
        
<label class="control-label span5"   style="line-height: 30px; text-align:right">Send alerts via email;</label>
<div class="controls span2">
 
                                <div class="pull-left">
                                  <label class="radio off">
                                  <input type="radio" name="toggle" 
                                  value="off" onchange="document.getElementById('wlt_email_alert_sendemail').value='0'">
                                  </label>
                                  <label class="radio on">
                                  <input type="radio" name="toggle"
                                  value="on" onchange="document.getElementById('wlt_email_alert_sendemail').value='1'">
                                  </label>
                                  <div class="toggle <?php if($core_admin_values['wlt_email_alert_sendemail'] == '1'){  ?>on<?php } ?>">
                                    <div class="yes">ON</div>
                                    <div class="switch"></div>
                                    <div class="no">OFF</div>
                                  </div>
                                </div> 
                               </div>
                           
                             
                             <input type="hidden" class="row-fluid" id="wlt_email_alert_sendemail" name="admin_values[wlt_email_alert_sendemail]" 
                             value="<?php echo $core_admin_values['wlt_email_alert_sendemail']; ?>">
         
<div class="clearfix"></div>

            
            
        
        <div class="form-row control-group row-fluid">
        <label class="control-label span5" style="line-height: 30px;text-align:right;">My email address: </label>
        <div class="controls span6">
        <input type="text"  name="admin_values[wlt_email_alert_email]" class="row-fluid"  value="<?php if($core_admin_values['wlt_email_alert_email'] == ""){ echo get_option('admin_email'); }else{ echo $core_admin_values['wlt_email_alert_email']; } ?>">            
        </div>
        </div>
        
        
        
        <hr />
        

 <label class="control-label span5"   style="line-height: 30px; text-align:right">Send alerts via SMS;</label>
<div class="controls span2">
 
                                <div class="pull-left">
                                  <label class="radio off">
                                  <input type="radio" name="toggle" 
                                  value="off" onchange="document.getElementById('wlt_email_alert_sendsms').value='0'">
                                  </label>
                                  <label class="radio on">
                                  <input type="radio" name="toggle"
                                  value="on" onchange="document.getElementById('wlt_email_alert_sendsms').value='1'">
                                  </label>
                                  <div class="toggle <?php if($core_admin_values['wlt_email_alert_sendsms'] == '1'){  ?>on<?php } ?>">
                                    <div class="yes">ON</div>
                                    <div class="switch"></div>
                                    <div class="no">OFF</div>
                                  </div>
                                </div> 
                               </div>
                           
                             
                             <input type="hidden" class="row-fluid" id="wlt_email_alert_sendsms" name="admin_values[wlt_email_alert_sendsms]" 
                             value="<?php echo $core_admin_values['wlt_email_alert_sendsms']; ?>">
         
<div class="clearfix"></div>
       
       <?php if(!defined('WLT_DEMOMODE')){ ?>
       
         <div class="form-row control-group row-fluid">
            <label class="control-label span5" style="line-height: 30px;text-align:right;">NEXMO API Key </label>
            <div class="controls span6">
            <input type="text" name="admin_values[wlt_nexmo_api]" class="row-fluid"  value="<?php echo $core_admin_values['wlt_nexmo_api']; ?>">            
            </div>
        </div>
        
         <div class="form-row control-group row-fluid">
            <label class="control-label span5" style="line-height: 30px;text-align:right;">NEXMO Secret Key </label>
            <div class="controls span6">
            <input name="admin_values[wlt_nexmo_se]" class="row-fluid" type="text"  value="<?php echo $core_admin_values['wlt_nexmo_se']; ?>">            
            </div>
        </div> 
               
        <div class="form-row control-group row-fluid">
            <label class="control-label span5" style="line-height: 30px;text-align:right;">My country calling code: </label>
            <div class="controls span6">
            + <input type="text"  name="admin_values[wlt_nexmo_c]" class="row-fluid"  value="<?php echo $core_admin_values['wlt_nexmo_c']; ?>" style="width:50px;">  <a href="https://en.wikipedia.org/wiki/List_of_mobile_phone_number_series_by_country" target="_blank" style="text-decoration:underline; color:blue;">more info</a>          
            </div>
        </div>
        
        <div class="form-row control-group row-fluid">
            <label class="control-label span5" style="line-height: 30px;text-align:right;">My mobile number: </label>
            <div class="controls span6">
            <input type="text"  name="admin_values[wlt_nexmo_num]" class="row-fluid"  value="<?php echo $core_admin_values['wlt_nexmo_num']; ?>">            
            </div>
        </div>        
      
        
        <?php }else{ ?>
        
        <div class="alert alert-success">Disabled in demo mode</div>
        
        <?php } ?>
		
        
        
        
   <div class="well">
        
<p>We have integrated the NEXMO SMS API which allows you to receive SMS alerts to your mobile phone. You will need an account with credit to use this feature.</p>

<p>More info: <a href="https://www.nexmo.com/" target="_blank">https://www.nexmo.com/</a></p>

</div>

      
 </div>
 
 
 <div class="form-actions row-fluid">
<div class="span7 offset5">
<button type="submit" class="btn btn-primary">Save Changes</button> 
</div>
</div> 
 
 
 </div>