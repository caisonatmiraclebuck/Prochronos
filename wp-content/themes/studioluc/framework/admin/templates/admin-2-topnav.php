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

<?php do_action('hook_admin_1_topnav_top'); ?>



<?php if(!defined('WLT_CART')){ ?>



<div class="heading2">Top Navigation  <span><a href="<?php echo home_url(); ?>/wp-admin/nav-menus.php" style="color:blue; text-decoration:underline;">set menu items here</a></span> </div>



<div class="fieldbox">

 <div class="form-row control-group row-fluid">
                                <label class="control-label span7" data-placement="top">Login/Logout Buttons</label>
                                <div class="controls span4">
                                  <div class="row-fluid">
                                    <div class="pull-left">
                                      <label class="radio off">
                                      <input type="radio" name="toggle" 
                                      value="off" onchange="document.getElementById('header_accountdetails').value='0'">
                                      </label>
                                      <label class="radio on">
                                      <input type="radio" name="toggle"
                                      value="on" onchange="document.getElementById('header_accountdetails').value='1'">
                                      </label>
                                      <div class="toggle <?php if($core_admin_values['header_accountdetails'] == '1'){  ?>on<?php } ?>">
                                        <div class="yes">ON</div>
                                        <div class="switch"></div>
                                        <div class="no">OFF</div>
                                      </div>
                                    </div> 
                                   </div>
                                 </div>
                                 
                                 <input type="hidden" class="row-fluid" id="header_accountdetails" name="admin_values[header_accountdetails]" 
                                 value="<?php echo $core_admin_values['header_accountdetails']; ?>">
         </div>
         
 <p>Turn ON if you want login buttons to be displated at the top right of your website.</p>
         
</div>
    
     
     
     <div class="form-row control-group row-fluid offset2" <?php if($core_admin_values['header_accountdetails'] == '1'){ echo "style='display:none;'"; } ?>>
       
                   <p>Custom Text (top right)</p>
                  <textarea  name="admin_values[header_welcometext]" style="width:400px; height:60px;"><?php echo stripslashes($core_admin_values['header_welcometext']); ?></textarea>
                  
            </div>
            <!------------ END FIELD -------------->
      <?php }else{ ?>
      <input type="hidden" name="admin_values[header_welcometext]" value="">
      <input type="hidden" name="admin_values[header_accountdetails]" value="0">
      <?php } ?>



<div class="heading2">Header Layout <span>Click a layout below;</span> </div>

           <input type="hidden" name="admin_values[layout_header]" id="layout_header" value="<?php echo $core_admin_values['layout_header']; ?>" />     
   
     <div class="row-fluid">
            <div class="span4 well  pagination-centered">
            <a href="javascript:void(0);" onclick="document.getElementById('layout_header').value='1';document.admin_save_form.submit();">
            <img src="<?php echo get_template_directory_uri(); ?>/framework/admin/img/core/h1.png" style="border:1px solid #ccc; padding:4px;background:#fff;<?php if($core_admin_values['layout_header'] == "1"){ echo "border:2px solid red;";} ?>" />
            </a>                 
            </div>

            <div class="span4 well pagination-centered"> 
            <a href="javascript:void(0);" onclick="document.getElementById('layout_header').value='2';document.admin_save_form.submit();">
            <img src="<?php echo get_template_directory_uri(); ?>/framework/admin/img/core/h2.png" style="border:1px solid #ccc; padding:4px;background:#fff;<?php if($core_admin_values['layout_header'] == "2"){ echo "border:2px solid red;";} ?>" />
            </a>            
            </div>            
 
            <div class="span4 well pagination-centered">   
            <a href="javascript:void(0);" onclick="document.getElementById('layout_header').value='3';document.admin_save_form.submit();">
            <img src="<?php echo get_template_directory_uri(); ?>/framework/admin/img/core/h3.png" style="border:1px solid #ccc; padding:4px;background:#fff;<?php if($core_admin_values['layout_header'] == "3"){ echo "border:2px solid red;";} ?>" />
            </a>  
            </div>
            
     </div><div class="row-fluid">
             
            <div class="span4 well pagination-centered">   
            <a href="javascript:void(0);" onclick="document.getElementById('layout_header').value='4';document.admin_save_form.submit();">
            <img src="<?php echo get_template_directory_uri(); ?>/framework/admin/img/core/h4.png" style="border:1px solid #ccc; padding:4px;background:#fff;<?php if($core_admin_values['layout_header'] == "4"){ echo "border:2px solid red;";} ?>" />
            </a>             
            </div>
            

            <div class="span4 well pagination-centered">   
            <a href="javascript:void(0);" onclick="document.getElementById('layout_header').value='5';document.admin_save_form.submit();">
            <img src="<?php echo get_template_directory_uri(); ?>/framework/admin/img/core/h5.png" style="border:1px solid #ccc; padding:4px;background:#fff;<?php if($core_admin_values['layout_header'] == "5"){ echo "border:2px solid red;";} ?>" />
            </a>  
            </div>
             
          
            <div class="span4 well pagination-centered">   
            <a href="javascript:void(0);" onclick="document.getElementById('layout_header').value='6';document.admin_save_form.submit();">
            <img src="<?php echo get_template_directory_uri(); ?>/framework/admin/img/core/h6.png" style="border:1px solid #ccc; padding:4px;background:#fff;<?php if($core_admin_values['layout_header'] == "6"){ echo "border:2px solid red;";} ?>" />
            </a>
            </div> 
       </div>              
     
        
        
        <div class="clearfix"></div>
 
  <?php if($core_admin_values['layout_header'] == "5" || ( !defined('WLT_CART') && $core_admin_values['layout_header'] == "6" ) ){ ?>
  
  <div class="well" style="background-color: #F4FFF3; border-radius:0px;">
      
     <p>Header Text (Accepts HTML)</p>           
    
            <!------------ FIELD -------------->          
            <div class="row-fluid">
                             
                  <textarea  name="admin_values[header_style_text]" style="width:100%; height:100px;"><?php echo stripslashes($core_admin_values['header_style_text']); ?></textarea>
              </div>    
 </div>
  <?php } ?>  
        
        
        
