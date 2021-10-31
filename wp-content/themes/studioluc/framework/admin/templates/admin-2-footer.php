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
 <div class="heading2">Footer Layout <span><a href="<?php echo home_url(); ?>/wp-admin/nav-menus.php" style="color:blue; text-decoration:underline;">set menu items here</a></span> </div>

    
 <div class="row-fluid">
      
            <div class="span4 well  pagination-centered">
            <a href="javascript:void(0);" onclick="document.getElementById('layout_footer').value='1';document.admin_save_form.submit();">
            <img src="<?php echo get_template_directory_uri(); ?>/framework/admin/img/core/l1.png" style="border:1px solid #ccc; padding:4px;background:#fff;<?php if($core_admin_values['layout_footer'] == "1"){ echo "border:2px solid red;";} ?>" />
            </a>  
            </div>

            <div class="span4 well pagination-centered"> 
            <a href="javascript:void(0);" onclick="document.getElementById('layout_footer').value='2';document.admin_save_form.submit();">
            <img src="<?php echo get_template_directory_uri(); ?>/framework/admin/img/core/l2.png" style="border:1px solid #ccc; padding:4px;background:#fff;<?php if($core_admin_values['layout_footer'] == "2"){ echo "border:2px solid red;";} ?>" />
            </a>
            </div>

            <div class="span4 well pagination-centered">   
            <a href="javascript:void(0);" onclick="document.getElementById('layout_footer').value='3';document.admin_save_form.submit();">
            <img src="<?php echo get_template_directory_uri(); ?>/framework/admin/img/core/l3.png" style="border:1px solid #ccc; padding:4px;background:#fff;<?php if($core_admin_values['layout_footer'] == "3"){ echo "border:2px solid red;";} ?>" />
            </a>
            </div>
            
     </div> <div class="row-fluid">
            
             <div class="span4 well pagination-centered">
             <a href="javascript:void(0);" onclick="document.getElementById('layout_footer').value='4';document.admin_save_form.submit();">
            <img src="<?php echo get_template_directory_uri(); ?>/framework/admin/img/core/l4.png" style="border:1px solid #ccc; padding:4px;background:#fff;<?php if($core_admin_values['layout_footer'] == "4"){ echo "border:2px solid red;";} ?>" />
            </a>
            </div> 
            
             <div class="span4 well pagination-centered">
             <a href="javascript:void(0);" onclick="document.getElementById('layout_footer').value='5';document.admin_save_form.submit();">
            <img src="<?php echo get_template_directory_uri(); ?>/framework/admin/img/core/l5.png" style="border:1px solid #ccc; padding:4px;background:#fff;<?php if($core_admin_values['layout_footer'] == "5"){ echo "border:2px solid red;";} ?>" />
            </a> 
            </div> 
            
    </div>
                      
      
  <input type="hidden" name="admin_values[layout_footer]" id="layout_footer" value="<?php echo $core_admin_values['layout_footer']; ?>" />         
        
        
<!------------ FIELD -------------->          
<div class="fieldbox">

	<p><b>Copyright Text</b></p>   
   
    <textarea class="row-fluid" style="height:60px; font-size:11px;" name="admin_values[copyright]"><?php echo stripslashes($core_admin_values['copyright']); ?></textarea>    	 

<p>The copyright text appears at the very bottom of your website.</p>
   
</div>








<div class="fieldbox">
  <div class="heading2">Social Buttons</div>
 
 <p>Leave blank to disable the icon display.</p>
   
   <p>You can change the icons and/or use alternative social networks by using a different icon. <a href="http://fortawesome.github.io/Font-Awesome/icons/" target="_blank" style="color:blue; text-decoration:underline;">Icons Here</a>  </p>
   
 <div class="row-fluid">
 <?php $type = array(
 "twitter" => array("n" => "Twitter", "icon" => "fa-twitter"),
 "dribbble" => array("n" => "Google", "icon" => "fa-google-plus"),
 "facebook" => array("n" => "Facebook", "icon" => "fa-facebook"),
 "linkedin" => array("n" => "Linked-in", "icon" => "fa-linkedin"),
 "youtube" => array("n" => "Youtube", "icon" => "fa-youtube"),
 "rss" => array("n" => "RSS Feed", "icon" => "fa-rss"), 
  ); 
 
foreach($type as $k1=>$v1){ ?>
 <div class="span6" style="margin-left:0px;">
   <!------------ FIELD -------------->          
<div class="form-row control-group row-fluid" id="myaccount_page_select">
	<label class="control-label span4" for="normal-field"><?php echo $v1['n']; ?></label>
    <div class="controls span6">         
     <div class="input-prepend">
      <span class="add-on">#</span>
      <input type="text"  name="admin_values[social][<?php echo $k1; ?>]" value="<?php echo $core_admin_values['social'][$k1]; ?>" class="span11">
    </div>  
    <input type="text"  name="admin_values[social][<?php echo $k1; ?>_icon]" value="<?php if($core_admin_values['social'][$k1.'_icon'] == ""){ 
	echo $v1['icon'];
	}else{ echo $core_admin_values['social'][$k1.'_icon']; } ?>" class="span11" style="height:25px;">      
    </div>
</div>
<!------------ END FIELD -------------->
</div>
<?php } ?> 

</div>
 
   
</div> 