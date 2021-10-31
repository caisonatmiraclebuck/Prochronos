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


<div class="heading2">Main Menu Layout <span><a href="<?php echo home_url(); ?>/wp-admin/nav-menus.php" style="color:blue; text-decoration:underline;">set menu items here</a></span> </div>


      <input type="hidden" name="admin_values[layout_menu]" id="layout_menu" value="<?php echo $core_admin_values['layout_menu']; ?>" />  
     <div class="row-fluid">
      
            <div class="span4 well  pagination-centered">
            <a href="javascript:void(0);" onclick="document.getElementById('layout_menu').value='1';document.admin_save_form.submit();">
            <img src="<?php echo get_template_directory_uri(); ?>/framework/admin/img/core/tm1.png" style="border:1px solid #ccc; padding:4px;background:#fff;<?php if($core_admin_values['layout_menu'] == "1"){ echo "border:2px solid red;";} ?>" />
            </a>
                 
            </div>

            <div class="span4 well pagination-centered"> 
            <a href="javascript:void(0);" onclick="document.getElementById('layout_menu').value='2';document.admin_save_form.submit();">
            <img src="<?php echo get_template_directory_uri(); ?>/framework/admin/img/core/<?php if(defined('WLT_CART')){ ?>tm6.png<?php }else{ ?>tm2.png<?php } ?>" style="border:1px solid #ccc; padding:4px;background:#fff;<?php if($core_admin_values['layout_menu'] == "2"){ echo "border:2px solid red;";} ?>" />
            </a>
            
            </div>

            <div class="span4 well pagination-centered">   
            <a href="javascript:void(0);" onclick="document.getElementById('layout_menu').value='3';document.admin_save_form.submit();">
            <img src="<?php echo get_template_directory_uri(); ?>/framework/admin/img/core/tm3.png" style="border:1px solid #ccc; padding:4px;background:#fff;<?php if($core_admin_values['layout_menu'] == "3"){ echo "border:2px solid red;";} ?>" />
            </a>                               
                
            </div> 
            
       </div>
       <div class="row-fluid">
            
        <?php if(!defined('WLT_CART')){ ?>
       
       <div class="span4 well pagination-centered">   
            <a href="javascript:void(0);" onclick="document.getElementById('layout_menu').value='4';document.admin_save_form.submit();">
            <img src="<?php echo get_template_directory_uri(); ?>/framework/admin/img/core/tm4.png" style="border:1px solid #ccc; padding:4px;background:#fff;<?php if($core_admin_values['layout_menu'] == "4"){ echo "border:2px solid red;";} ?>" />
            </a>                               
                
      </div>
            
      <div class="span4 well pagination-centered">   
       
            <a href="javascript:void(0);" onclick="document.getElementById('layout_menu').value='5';document.admin_save_form.submit();">
            <img src="<?php echo get_template_directory_uri(); ?>/framework/admin/img/core/tm5.png" style="border:1px solid #ccc; padding:4px;background:#fff;<?php if($core_admin_values['layout_menu'] == "5"){ echo "border:2px solid red;";} ?>" />
            </a>                               
                
       </div>  
       
       <?php } ?>     
                
    </div>
    