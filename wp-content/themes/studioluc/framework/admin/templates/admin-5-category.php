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
 
 
                
<div class="heading2"> Category Selection</div>     



 <div class="fieldbox">
           
            
                              <div class="form-row control-group row-fluid ">
                            <label class="control-label span6">Display Categories</label>
                            <div class="controls span6">
                              <div class="row-fluid">
                                <div class="pull-left">
                                  <label class="radio off">
                                  <input type="radio" name="toggle" 
                                  value="off" onchange="document.getElementById('listingcats').value='0'">
                                  </label>
                                  <label class="radio on">
                                  <input type="radio" name="toggle"
                                  value="on" onchange="document.getElementById('listingcats').value='1'">
                                  </label>
                                  <div class="toggle <?php if($core_admin_values['listingcats'] == '1'){  ?>on<?php } ?>">
                                    <div class="yes">ON</div>
                                    <div class="switch"></div>
                                    <div class="no">OFF</div>
                                  </div>
                                </div> 
                               </div>
                             </div>
                             
                             <input type="hidden" class="row-fluid" id="listingcats" name="admin_values[listingcats]" 
                             value="<?php echo $core_admin_values['listingcats']; ?>">
            </div>
            
<p>Turn ON to display category selection options during a users listing submission.</p>
            
</div>   
      
<div class="fieldbox"> 

               <div class="form-row control-group row-fluid ">
                            <label class="control-label span6" rel="tooltip" data-original-title="Turn ON to stop users from select the parent category as a listing option." data-placement="top">Disable Parent Category</label>
                            <div class="controls span6">
                              <div class="row-fluid">
                                <div class="pull-left">
                                  <label class="radio off">
                                  <input type="radio" name="toggle" 
                                  value="off" onchange="document.getElementById('disablecategory').value='0'">
                                  </label>
                                  <label class="radio on">
                                  <input type="radio" name="toggle"
                                  value="on" onchange="document.getElementById('disablecategory').value='1'">
                                  </label>
                                  <div class="toggle <?php if($core_admin_values['disablecategory'] == '1'){  ?>on<?php } ?>">
                                    <div class="yes">ON</div>
                                    <div class="switch"></div>
                                    <div class="no">OFF</div>
                                  </div>
                                </div> 
                               </div>
                             </div>
                             
                             <input type="hidden" class="row-fluid" id="disablecategory" name="admin_values[disablecategory]" 
                             value="<?php echo $core_admin_values['disablecategory']; ?>">
            </div>  
            
<p>Turn ON if you want to prevent users selecting the parent category.</p>
  
</div>


   <div class="heading2"> Extra Category Price</div>     
           
<div class="fieldbox"> 
  <div class="form-row control-group row-fluid">
  
 

<div class=" offset2">
<select multiple="multiple" style="height:200px; width:300px;     margin-left: -10px;" onclick="jQuery('#updatedcatalert').html('');jQuery('#catid').val(this.value); WLTCatPrice('<?php echo str_replace("http://","",get_home_url()); ?>', this.value, 'currentpricebox');">
<?php echo $CORE->CategoryList(array(0,false,0,THEME_TAXONOMY,0,0,true)); ?>
</select>
 

<div class="controls">         
     <div class="input-prepend">
      <span class="add-on"><?php echo $core_admin_values['currency']['code']; ?></span>
      <span id="currentpricebox"><input type="text" name="catprice" class="span8" style="margin-right:15px;text-align:right;" id="catprice"></span> 
      <a href="javascript:void(0);" onclick="SaveCatPrice();" class="btn">save</a>  
      <input type="hidden" name="catid" value="" id="catid"> 
    </div>        
</div>
</div>   
</div> 

<script>
function SaveCatPrice(){
var catid = jQuery('#catid').val();
var price = jQuery('#catprice').val();
WLTCatPriceUpdate('<?php echo str_replace("http://","",get_home_url()); ?>', catid, price, 'updatedcatalert');
}
</script>
<script src="<?php echo FRAMREWORK_URI.'js/core.ajax.js'; ?>" type="text/javascript"></script>
<span id="updatedcatalert"></span>            
            
            
<p>Enter an amount you want the user to pay extra for selecting this category.</p>
  
</div>     
        
            
            
    <?php 
	$membershipfields 	= get_option("membershipfields");	
	if(is_array($membershipfields) && !empty($membershipfields)){ 
	
	$current_access = $core_admin_values['default_access'];
	if(!is_array($current_access)){ $current_access = array(99); }	
	?>
    
   <div class="heading2"> Membership Access </div> 
   
   
   
 <div class="fieldbox">
           
            
                              <div class="form-row control-group row-fluid ">
                            <label class="control-label span6">Require Membership To Add Listings</label>
                            <div class="controls span6">
                              <div class="row-fluid">
                                <div class="pull-left">
                                  <label class="radio off">
                                  <input type="radio" name="toggle" 
                                  value="off" onchange="document.getElementById('requiremembership').value='0'">
                                  </label>
                                  <label class="radio on">
                                  <input type="radio" name="toggle"
                                  value="on" onchange="document.getElementById('requiremembership').value='1'">
                                  </label>
                                  <div class="toggle <?php if($core_admin_values['requiremembership'] == '1'){  ?>on<?php } ?>">
                                    <div class="yes">ON</div>
                                    <div class="switch"></div>
                                    <div class="no">OFF</div>
                                  </div>
                                </div> 
                               </div>
                             </div>
                             
                             <input type="hidden" class="row-fluid" id="requiremembership" name="admin_values[requiremembership]" 
                             value="<?php echo $core_admin_values['requiremembership']; ?>">
            </div>
            
            <p>Stop members who have not purchased a membership package from submitting listings.</p>
            
    </div>
   
<div class="fieldbox"> 
   
   <p>Here you can set the default access for newly created listings added by <b>users</b>.</p>
   
   	<select name="admin_values[default_access][]" size="2" style="font-size:14px;padding:5px; width:100%; height:150px; background:#e7fff3;" multiple="multiple"  > 
  	<option value="99" <?php if(in_array(99,$current_access)){ echo "selected=selected"; } ?>>All Membership Access</option>
    <?php 
	$i=0;
	
	foreach($membershipfields as $mID=>$package){	
		
		if(is_array($current_access) && in_array($package['ID'],$current_access)){ 
		echo "<option value='".$package['ID']."' selected=selected>".$package['name']."</option>";
		}else{ 
		echo "<option value='".$package['ID']."'>".$package['name']."</option>";		
		}
		
	$i++;		
	} // end foreach
	
    ?>
	</select>
    <p style="margin-bottom:10px;">Hold CTRL to select multiple memberships.</p>
    
    
    </div>
   <?php } ?>



 