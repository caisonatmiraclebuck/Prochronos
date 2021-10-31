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
 
<a href="admin.php?page=1&delrating=1" class="btn btn-info" style="float:right;    margin-top: 4px;    margin-right: 10px;">Delete All Rating Data</a>
        
 
<div class="heading2">Star Rating Settings</div>

 
<div class="fieldbox">

                  <div class="form-row control-group row-fluid ">
                            <label class="control-label span6" rel="tooltip" data-original-title="Turn on/off if you want the star rating to appear on your website." data-placement="top">Enable Star Rating</label>
                            <div class="controls span5">
                              <div class="row-fluid">
                                <div class="pull-left">
                                  <label class="radio off">
                                  <input type="radio" name="toggle" 
                                  value="off" onchange="document.getElementById('rating').value='0'">
                                  </label>
                                  <label class="radio on">
                                  <input type="radio" name="toggle"
                                  value="on" onchange="document.getElementById('rating').value='1'">
                                  </label>
                                  <div class="toggle <?php if($core_admin_values['rating'] == '1'){  ?>on<?php } ?>">
                                    <div class="yes">ON</div>
                                    <div class="switch"></div>
                                    <div class="no">OFF</div>
                                  </div>
                                </div> 
                               </div>
                             </div>
                             
                             <input type="hidden" class="row-fluid" id="rating" name="admin_values[rating]" 
                             value="<?php echo $core_admin_values['rating']; ?>">
            </div> 
            
          <p>Turn ON to enable the star rating feature.</p>  
            
            
          <div class="form-row control-group row-fluid ">
                            <label class="control-label span6"  data-placement="top">Show Star Rating</label>
                            <div class="controls span5">
                              <div class="row-fluid">
                                <div class="pull-left">
                                  <label class="radio off">
                                  <input type="radio" name="toggle" 
                                  value="off" onchange="document.getElementById('rating_as').value='0'">
                                  </label>
                                  <label class="radio on">
                                  <input type="radio" name="toggle"
                                  value="on" onchange="document.getElementById('rating_as').value='1'">
                                  </label>
                                  <div class="toggle <?php if($core_admin_values['rating_as'] == '1'){  ?>on<?php } ?>">
                                    <div class="yes">ON</div>
                                    <div class="switch"></div>
                                    <div class="no">OFF</div>
                                  </div>
                                </div> 
                               </div>
                             </div>
                             
                             <input type="hidden" class="row-fluid" id="rating_as" name="admin_values[rating_as]" 
                             value="<?php echo $core_admin_values['rating_as']; ?>">
            </div> 
     
     <p>Turn ON to display a ratings box within the advanced search widget.</p>

       
            
            
        <div class="form-row control-group row-fluid">
        <label class="control-label span5" for="style">Rating Display Type</label>
        <div class="controls span6">
        <select name="admin_values[rating_type]" class="chzn-select" id="rt1">
          <option value=""></option>
          <option value="1" <?php if($core_admin_values['rating_type'] == "1"){ echo "selected=selected"; } ?>>Stars</option>
          <option value="2" <?php if($core_admin_values['rating_type'] == "2"){ echo "selected=selected"; } ?>>Thumbs Basic (Horizontal)</option> 
          <option value="4" <?php if($core_admin_values['rating_type'] == "4"){ echo "selected=selected"; } ?>>Thumbs Basic (Vertical)</option> 
          <option value="5" <?php if($core_admin_values['rating_type'] == "5"){ echo "selected=selected"; } ?>>Thumbs Icon (Vertical)</option> 
         <option value="6" <?php if($core_admin_values['rating_type'] == "6"){ echo "selected=selected"; } ?>>Thumbs Icon (Horizontal)</option> 
         
          
      <option value="3" <?php if($core_admin_values['rating_type'] == "3"){ echo "selected=selected"; } ?>>Vote Up/ Vote Down</option>
      <option value="3a" <?php if($core_admin_values['rating_type'] == "3a"){ echo "selected=selected"; } ?>>Vote Up/ Vote Down with icon</option> 
      <option value="7" <?php if($core_admin_values['rating_type'] == "7"){ echo "selected=selected"; } ?>>Text Only</option> 
      <option value="8" <?php if($core_admin_values['rating_type'] == "8"){ echo "selected=selected"; } ?>>Success Meter (big)</option> 
      <option value="9" <?php if($core_admin_values['rating_type'] == "9"){ echo "selected=selected"; } ?>>Success Meter (small)</option> 
        </select>
        </div>
        </div>
        

</div>

        
<div class="heading2">Feedback</div>


  
             <p>The feedback system allows members to leave feedback about other members listings.</p>
             
             <p>Members can leave 1 feedback per listing and the listing author can delete the feedback at any time.</p>
             
             <p>Feedback is displayed on the users profile page.</p>
             
        
             
             
               <div class="form-row control-group row-fluid ">
                                <label class="control-label span7" data-placement="top">Enable Feedback System</label>
                                <div class="controls span4">
                                  <div class="row-fluid">
                                    <div class="pull-left">
                                      <label class="radio off">
                                      <input type="radio" name="toggle" 
                                      value="off" onchange="document.getElementById('feedback_enable').value='0'">
                                      </label>
                                      <label class="radio on">
                                      <input type="radio" name="toggle"
                                      value="on" onchange="document.getElementById('feedback_enable').value='1'">
                                      </label>
                                      <div class="toggle <?php if($core_admin_values['feedback_enable'] == '1'){  ?>on<?php } ?>">
                                        <div class="yes">ON</div>
                                        <div class="switch"></div>
                                        <div class="no">OFF</div>
                                      </div>
                                    </div> 
                                   </div>
                                 </div>
                                 
                                 <input type="hidden" class="row-fluid" id="feedback_enable" name="admin_values[feedback_enable]" 
                                 value="<?php echo $core_admin_values['feedback_enable']; ?>">
         </div>
         
         
        
               <div class="form-row control-group row-fluid ">
                                <label class="control-label span7" data-placement="top">Show Trust Bar</label>
                                <div class="controls span4">
                                  <div class="row-fluid">
                                    <div class="pull-left">
                                      <label class="radio off">
                                      <input type="radio" name="toggle" 
                                      value="off" onchange="document.getElementById('feedback_trustbar').value='0'">
                                      </label>
                                      <label class="radio on">
                                      <input type="radio" name="toggle"
                                      value="on" onchange="document.getElementById('feedback_trustbar').value='1'">
                                      </label>
                                      <div class="toggle <?php if($core_admin_values['feedback_trustbar'] == '1'){  ?>on<?php } ?>">
                                        <div class="yes">ON</div>
                                        <div class="switch"></div>
                                        <div class="no">OFF</div>
                                      </div>
                                    </div> 
                                   </div>
                                 </div>
                                 
                                 <input type="hidden" class="row-fluid" id="feedback_trustbar" name="admin_values[feedback_trustbar]" 
                                 value="<?php echo $core_admin_values['feedback_trustbar']; ?>">
         </div>