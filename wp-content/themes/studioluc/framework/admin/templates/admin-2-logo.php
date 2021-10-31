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

<?php do_action('hook_admin_1_logo_top'); ?>

<div class="heading2">Website Logo  </div>
       
 
     <div class="fieldbox">
     
                <div class="form-row control-group row-fluid">
                     <label class="control-label span4">Logo Image</label>
                     
                     <div class="controls span7"> 
                     <div class="input-append color row-fluid">
                     <input name="admin_values[logo_url]" id="logo" type="text" value="<?php echo stripslashes($core_admin_values['logo_url']); ?>" class="row-fluid">
                     <span class="add-on" style="margin-right: -30px;" id="upload_logo"><i class="gicon-search"></i></span>                  
                     </div>
                     
                     </div>
                </div>
                
                <?php 	if(strpos($core_admin_values['logo_url'], "http") !== false){ ?>
                
                 <div style="text-align:center; border:1px solid #ddd; padding:20px; margin-left:100px;margin-bottom:30px;margin-right:100px;">
                <?php if(strlen($core_admin_values['logo_url']) > 10){ echo '<img src="'.$core_admin_values['logo_url'].'" style="max-width:250px; max-height:250px;" /> '; }else{ echo "<h1>".$core_admin_values['logo_url']."</h1>";  }?>
                </div> 
                
                <?php } ?>
                
                <input type="hidden" value="" name="imgIdblock" id="imgIdblock" />

				<script type="text/javascript">
                
                jQuery('#upload_logo').click(function() {
                 ChangeImgBlock('logo'); 
                 formfield = jQuery('#logo').attr('name');
                 tb_show('', 'media-upload.php?type=image&amp;TB_iframe=true');
                 return false;
                });
                 
                </script>   

<p>Select the image you want to use as your logo <b>or</b> leave blank and enter text below. <br /> 
Recommended logo image dimensions are: PNG/JPG/ 300px width/ 100px height.</p>

</div>








<div class="fieldbox">

  <div class="form-row control-group row-fluid">
  <label class="control-label span4">Logo Title Text</label>
                     
                     <div class="controls span7"> 
                     <div class="input-append color row-fluid">
                     <input name="admin_values[logo_text1]" type="text" value="<?php echo stripslashes($core_admin_values['logo_text1']); ?>" class="row-fluid">
                                     
                     </div>
                    
  </div>
  </div>
    
  <div class="form-row control-group row-fluid">
  	<label class="control-label span4">Logo Slogan Text</label>
                     
                     <div class="controls span7"> 
                     <div class="input-append color row-fluid">
                     <input name="admin_values[logo_text2]" type="text" value="<?php echo stripslashes($core_admin_values['logo_text2']); ?>" class="row-fluid">
                                     
                     </div>
                    
    </div>
    </div>
    
</div> 


<input type="hidden" name="admin_values[logo_icon]" id="logo_icon" value="<?php echo $core_admin_values['logo_icon']; ?>">
  <div class="form-row control-group row-fluid">
                     <label class="control-label span4">Logo Text Icon</label>
                     <div class="input-append color row-fluid">
                     
                     <?php if(strlen($core_admin_values['logo_icon']) > 0){ ?>
                     <div style="text-align:center;"><img src="<?php echo get_template_directory_uri(); ?>/framework/img/logo/<?php echo $core_admin_values['logo_icon']; ?>.png" style="max-width:100px; "/></div>
                     <?php } ?>
                     <a href="">Show More Icons</a>
                     </div>
                     
      <div style="height:400px; overflow:scroll; background:#fff; border:1px solid #ddd; padding:20px;">
      <table>
      <?php $i=0; $n=0; while($i < 40){ 
	  
	  if($n == 0){ echo '<div class="row-fluid">'; } 
	  ?>
            <div class="span3  pagination-centered" <?php if($core_admin_values['logo_icon'] == $i){ echo "style='  border: 1px solid rgb(108, 182, 108);  background: rgb(172, 236, 172);'"; } ?>>
            <a href="javascript:void(0);" onclick="document.getElementById('logo_icon').value='<?php echo $i; ?>';document.admin_save_form.submit();">
          
            <img src="<?php echo get_template_directory_uri(); ?>/framework/img/logo/<?php echo $i; ?>.png" style="padding:4px;background:#fff; max-width:60px; max-height:60px; margin-bottom:20px;" />
            </a>
                 
            </div>
        <?php $i++; $n++; if($n == 4){ echo "</div><div class='clearfix'></div>"; $n = 0;   } } ?> 
       </table>
       </div>      
 
  </div>