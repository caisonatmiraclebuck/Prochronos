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
 
 <div class="heading2">Column Layout </div> 
 
 <div class="fieldbox">
 
<div class="form-row control-group row-fluid">
<label class="control-label span6">Columns</label>
<div class="controls row-fluid span6">
      
            <div class="span3">
            <a href="javascript:void(0);" onclick="document.getElementById('layout_body3').value='1';document.admin_save_form.submit();">
            <img src="<?php echo get_template_directory_uri(); ?>/framework/admin/img/core/l1.png" style="border:1px solid #ccc; padding:4px;background:#fff;<?php if($core_admin_values['layout_columns']['page'] == "1"){ echo "border:2px solid red;";} ?>" />
            </a>
                 
            </div>

            <div class="span3"> 
            <a href="javascript:void(0);" onclick="document.getElementById('layout_body3').value='2';document.admin_save_form.submit();">
            <img src="<?php echo get_template_directory_uri(); ?>/framework/admin/img/core/l2.png" style="border:1px solid #ccc; padding:4px;background:#fff;<?php if($core_admin_values['layout_columns']['page'] == "2"){ echo "border:2px solid red;";} ?>" />
            </a>
            
            </div>

            <div class="span3">   
            <a href="javascript:void(0);" onclick="document.getElementById('layout_body3').value='3';document.admin_save_form.submit();">
            <img src="<?php echo get_template_directory_uri(); ?>/framework/admin/img/core/l3.png" style="border:1px solid #ccc; padding:4px;background:#fff;<?php if($core_admin_values['layout_columns']['page'] == "3"){ echo "border:2px solid red;";} ?>" />
            </a>                               
                
            </div>
            
             <div class="span3">
             <a href="javascript:void(0);" onclick="document.getElementById('layout_body3').value='4';document.admin_save_form.submit();">
            <img src="<?php echo get_template_directory_uri(); ?>/framework/admin/img/core/l4.png" style="border:1px solid #ccc; padding:4px;background:#fff;<?php if($core_admin_values['layout_columns']['page'] == "4"){ echo "border:2px solid red;";} ?>" />
            </a>                             
                
            </div> 
                      
</div>
  <input type="hidden" name="admin_values[layout_columns][page]" id="layout_body3" value="<?php echo $core_admin_values['layout_columns']['page']; ?>" /> 
               
</div>

<div class="form-row control-group row-fluid">
    <label class="control-label span6" for="style">2 Column Width</label>
                <div class="controls span6">
                  <select name="admin_values[layout_columns][page_2columns]" class="chzn-select" id="2stylepage">
                    <option value=""></option>
                    
                    <option value="0" <?php selected( $core_admin_values['layout_columns']['page_2columns'], 0 ); ?>>
                    363px X 757px</option>
                    
                    <option value="1" <?php selected( $core_admin_values['layout_columns']['page_2columns'], 1 ); ?>>
                    265px X 885px</option>   
                    
                     <option value="2" <?php selected( $core_admin_values['layout_columns']['page_2columns'], 2 ); ?>>
                    300px X 868px</option>                   
                  </select>
                </div>
</div>
<div class="form-row control-group row-fluid" <?php if($core_admin_values['layout_columns']['page'] != "4"){ echo 'style="display:none;"'; } ?>>
                <label class="control-label span6" for="style">3 Column Width</label>
                <div class="controls span6">
                  <select name="admin_values[layout_columns][page_3columns]" class="chzn-select" id="3stylepage">
                    <option value=""></option>
                    <option value="0" <?php selected( $core_admin_values['layout_columns']['page_3columns'], 0 ); ?>>
                    250px / 500px / 250px </option>
                    <option value="1" <?php selected( $core_admin_values['layout_columns']['page_3columns'],1 ); ?>>
                    150px / 700px / 150px </option>                     
                  </select>
                </div>
</div>

<div class="clearfix"></div>
 

 <p>Choose the display setup for standard WordPress pages and set the column widths.</p>

</div>