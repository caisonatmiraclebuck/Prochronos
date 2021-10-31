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

   <div class="heading2">Fallback Image</div> 
   
<div class="fieldbox">
   

        <div class="form-row control-group row-fluid">
                <label class="control-label span4">'No Image' Icon</label>
                <div class="controls span7">
                <div class="input-append row-fluid">
                  <input type="text"  name="admin_values[fallback_image]" id="upload_pak" class="row-fluid" 
                  value="<?php echo $core_admin_values['fallback_image']; ?>">
                  <span class="add-on" id="upload_pakimage" style="cursor:pointer;"><i class="gicon-search"></i></span>
                  </div>
                </div>
       </div> 
      
   <p>This is the image that will be displayed when no other image is assigned to the listing.</p>   
       
</div>
       
       
       <div style="text-align:center; border:1px solid #ddd; padding:20px; margin-left:100px;margin-bottom:30px;margin-right:100px;">
                <?php if(strlen($core_admin_values['fallback_image']) > 10){ echo '<img src="'.$core_admin_values['fallback_image'].'" style="max-width:250px; max-height:250px;" /> '; }else{ echo "<h1>".$core_admin_values['fallback_image']."</h1>";  }?>
                </div> 
        
    
			<script type="text/javascript">
             
                    jQuery('#upload_pakimage').click(function() {                      
                     ChangeImgBlock('upload_pak');
                     formfield = jQuery('#upload_pak').attr('name');
                     tb_show('', 'media-upload.php?type=image&amp;TB_iframe=true');
                     return false;
                    });
				
            </script> 
            
            
            
            
            
<div class="heading2"> Image Settings </div>  
 
            
<div class="fieldbox">
       
       <div class="form-row control-group row-fluid ">
                            <label class="control-label span6" rel="tooltip" data-original-title="This will crop images that are over 900px" data-placement="top">Image Cropping</label>
                            <div class="controls span6">
                              <div class="row-fluid">
                                <div class="pull-left">
                                  <label class="radio off">
                                  <input type="radio" name="toggle" 
                                  value="off" onchange="document.getElementById('wlt_core_imgcrop').value='0'">
                                  </label>
                                  <label class="radio on">
                                  <input type="radio" name="toggle"
                                  value="on" onchange="document.getElementById('wlt_core_imgcrop').value='1'">
                                  </label>
                                  <div class="toggle <?php if($core_admin_values['wlt_core_imgcrop'] == '1'){  ?>on<?php } ?>">
                                    <div class="yes">ON</div>
                                    <div class="switch"></div>
                                    <div class="no">OFF</div>
                                  </div>
                                </div> 
                               </div>
                             </div>
                             
                             <input type="hidden" class="row-fluid" id="wlt_core_imgcrop" name="admin_values[wlt_core_imgcrop]" 
                             value="<?php echo $core_admin_values['wlt_core_imgcrop']; ?>">
            </div> 
        
        
<p>Turn ON if you want the system to crop images that are larger than 900px. This is useful for saving space and faster loading times.</p>  
</div>