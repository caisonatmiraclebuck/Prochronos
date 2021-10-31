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

<div class="heading2"> Display Options </div> 

<div class="fieldbox">

<div class="form-row control-group row-fluid ">
                            <label class="control-label span6">Pricing Table</label>
                            <div class="controls span6">
                              <div class="row-fluid">
                                <div class="pull-left">
                                  <label class="radio off">
                                  <input type="radio" name="toggle" 
                                  value="off" onchange="document.getElementById('pricing_table').value='0'">
                                  </label>
                                  <label class="radio on">
                                  <input type="radio" name="toggle"
                                  value="on" onchange="document.getElementById('pricing_table').value='1'">
                                  </label>
                                  <div class="toggle <?php if($core_admin_values['pricing_table'] == '1'){  ?>on<?php } ?>">
                                    <div class="yes">ON</div>
                                    <div class="switch"></div>
                                    <div class="no">OFF</div>
                                  </div>
                                </div> 
                               </div>
                             </div>
                             
                             <input type="hidden" class="row-fluid" id="pricing_table" name="admin_values[pricing_table]" 
                             value="<?php echo $core_admin_values['pricing_table']; ?>">
            </div>

<p>This will display a pricing table for the user to select a listing package before they start completing the submission form.</p>

</div>



  

 


<div class="heading2"> Form Display Options</div>  


<div class="fieldbox">


        
 
 <div class="form-row control-group row-fluid">
                <label class="control-label span6" for="normal-field">Form Design</label>
                <div class="controls span6">
                  <select name="admin_values[listing_form]" class="chzn-select">
                  
                   <option value="" <?php selected( $core_admin_values['listing_form'], ""); ?>>Compact Layout</option>
                   <option value="small" <?php selected( $core_admin_values['listing_form'], "small" ); ?>>Full Layout</option>
                   
                                      
                    </select>
     
                </div>
            </div>                  
            
<p>Compact design will seperate sections into seperate blocks for easier navigation, full layout will put all fields in one big list.</p> 
                
</div>  


<div class="fieldbox">
      


<div class="form-row control-group row-fluid ">
                            <label class="control-label span6">Visitor Submissions</label>
                            <div class="controls span6">
                              <div class="row-fluid">
                                <div class="pull-left">
                                  <label class="radio off">
                                  <input type="radio" name="toggle" 
                                  value="off" onchange="document.getElementById('visitor_submit').value='0'">
                                  </label>
                                  <label class="radio on">
                                  <input type="radio" name="toggle"
                                  value="on" onchange="document.getElementById('visitor_submit').value='1'">
                                  </label>
                                  <div class="toggle <?php if($core_admin_values['visitor_submission'] == '1'){  ?>on<?php } ?>">
                                    <div class="yes">ON</div>
                                    <div class="switch"></div>
                                    <div class="no">OFF</div>
                                  </div>
                                </div> 
                               </div>
                             </div>
                             
                             <input type="hidden" class="row-fluid" id="visitor_submit" name="admin_values[visitor_submission]" 
                             value="<?php echo $core_admin_values['visitor_submission']; ?>">
            </div>
            
<p>Turn OFF if you want all users to register before submitting listings otherwise the system will auto create a new account for the visitor based on their email address.</p>
       
</div>
            



<div class="fieldbox">
            
               <div class="form-row control-group row-fluid ">
                            <label class="control-label span6">One Listing Only</label>
                            <div class="controls span6">
                              <div class="row-fluid">
                                <div class="pull-left">
                                  <label class="radio off">
                                  <input type="radio" name="toggle" 
                                  value="off" onchange="document.getElementById('onelistingonly').value='0'">
                                  </label>
                                  <label class="radio on">
                                  <input type="radio" name="toggle"
                                  value="on" onchange="document.getElementById('onelistingonly').value='1'">
                                  </label>
                                  <div class="toggle <?php if($core_admin_values['onelistingonly'] == '1'){  ?>on<?php } ?>">
                                    <div class="yes">ON</div>
                                    <div class="switch"></div>
                                    <div class="no">OFF</div>
                                  </div>
                                </div> 
                               </div>
                             </div>
                             
                             <input type="hidden" class="row-fluid" id="onelistingonly" name="admin_values[onelistingonly]" 
                             value="<?php echo $core_admin_values['onelistingonly']; ?>">
            </div>
            

<p>Turn ON to prevent users from being able to create multiple listings.</p>

</div>




<div class="fieldbox">
                           <div class="form-row control-group row-fluid ">
                            <label class="control-label span6">Listing Renewals</label>
                            <div class="controls span6">
                              <div class="row-fluid">
                                <div class="pull-left">
                                  <label class="radio off">
                                  <input type="radio" name="toggle" 
                                  value="off" onchange="document.getElementById('renewlisting').value='0'">
                                  </label>
                                  <label class="radio on">
                                  <input type="radio" name="toggle"
                                  value="on" onchange="document.getElementById('renewlisting').value='1'">
                                  </label>
                                  <div class="toggle <?php if($core_admin_values['renewlisting'] == '1'){  ?>on<?php } ?>">
                                    <div class="yes">ON</div>
                                    <div class="switch"></div>
                                    <div class="no">OFF</div>
                                  </div>
                                </div> 
                               </div>
                             </div>
                             
                             <input type="hidden" class="row-fluid" id="renewlisting" name="admin_values[renewlisting]" 
                             value="<?php echo $core_admin_values['renewlisting']; ?>">
            </div>
            
      
<p>Turn ON if you want users to be able to renew their listings.</p>
     
</div>

            


<div class="fieldbox"> 
        <div class="row-fluid">
<div class="span6"><label>Min. Description Length</label></div>
<div class="span6">
    <div class="input-prepend row-fluid span6">
        <input type="text" name="admin_values[descmin]" style="width:100px;text-align:right;" class="row-fluid" value="<?php if($core_admin_values['descmin'] == ""){ echo 200; }else{ echo $core_admin_values['descmin']; } ?>">
        <span class="add-on ">#</span>
    </div>
	</div>
</div>

<p>Here you can set a minimum number of characters a user must enter for their listing description.</p>
</div>
            
            
            
                  
            
         

