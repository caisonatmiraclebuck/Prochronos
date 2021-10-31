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

<div class="row-fluid">

<div class="span8">
 
<!-- START ACCORDING --->
<div class="accordion style1" id="user_according">


<div class="accordion-group">
    <div class="accordion-heading" style="background:#fff;">
        <a class="accordion-toggle collapsed" data-toggle="collapse" data-parent="#user_according" href="#user2">
         <h4 style="margin:0xp;font-weight:bold;">
         
         <img src="<?php echo get_template_directory_uri(); ?>/framework/admin/img/icons/u4.png">
        Registration Fields <span style="font-size:12px;">(view/hide)</span></h4> 
        </a>
    </div>
    
    <div id="user2" class="accordion-body collapse">
    <div class="accordion-inner">
    <div class="innerwrap content">
    
    
    
   <?php if(!defined('WP_ALLOW_MULTISITE')){ ?>
   
   <div class="fieldbox">
   
       <div class="form-row control-group row-fluid ">
                            <label class="control-label span8">Enable Users Registrations</label>
                            <div class="controls span4">
                              <div class="row-fluid">
                                <div class="pull-left">
                                  <label class="radio off">
                                  <input type="radio" name="toggle" 
                                  value="off" onchange="document.getElementById('can_reg').value='0'">
                                  </label>
                                  <label class="radio on">
                                  <input type="radio" name="toggle"
                                  value="on" onchange="document.getElementById('can_reg').value='1'">
                                  </label>
                                  <div class="toggle <?php if(get_option('users_can_register') == '1'){  ?>on<?php } ?>">
                                    <div class="yes">ON</div>
                                    <div class="switch"></div>
                                    <div class="no">OFF</div>
                                  </div>
                                </div> 
                               </div>
                             </div>
                             
                             <input type="hidden" class="row-fluid" id="can_reg" name="adminArray[users_can_register]" 
                             value="<?php echo get_option('users_can_register'); ?>">
            </div>
            
            <p>Turn this ON if you want to allow visitors to register as members on your website. </p>
            
  </div>
            
            <?php }else{ ?>
            <p class="alert">Registration on/off options are part of <a href="<?php echo get_home_url(); ?>/wp-admin/network/settings.php" style="text-decoration:underline;">WordPress Network settings.</a></p>
            
             <input type="hidden" class="row-fluid" id="can_reg" name="adminArray[users_can_register]" 
                             value="1">
            <?php } ?>
          
      <div class="fieldbox">
        
          <div class="form-row control-group row-fluid ">
                            <label class="control-label span8">User Passwords</label>
                            <div class="controls span4">
                              <div class="row-fluid">
                                <div class="pull-left">
                                  <label class="radio off">
                                  <input type="radio" name="toggle" 
                                  value="off" onchange="document.getElementById('visitor_password').value='0'">
                                  </label>
                                  <label class="radio on">
                                  <input type="radio" name="toggle"
                                  value="on" onchange="document.getElementById('visitor_password').value='1'">
                                  </label>
                                  <div class="toggle <?php if($core_admin_values['visitor_password'] == '1'){  ?>on<?php } ?>">
                                    <div class="yes">ON</div>
                                    <div class="switch"></div>
                                    <div class="no">OFF</div>
                                  </div>
                                </div> 
                               </div>
                             </div>
                             
                             <input type="hidden" class="row-fluid" id="visitor_password" name="admin_values[visitor_password]" 
                             value="<?php echo $core_admin_values['visitor_password']; ?>">
            </div>  
            
     <p>Turn ON if you want users to choose their own password. If disabled WordPress will email a random password to the user.</p>
 </div>

        

    <div class="fieldbox">
               <div class="form-row control-group row-fluid ">
                            <label class="control-label span8">Security Code</label>
                            <div class="controls span4">
                              <div class="row-fluid">
                                <div class="pull-left">
                                  <label class="radio off">
                                  <input type="radio" name="toggle" 
                                  value="off" onchange="document.getElementById('register_securitycode').value='0'">
                                  </label>
                                  <label class="radio on">
                                  <input type="radio" name="toggle"
                                  value="on" onchange="document.getElementById('register_securitycode').value='1'">
                                  </label>
                                  <div class="toggle <?php if($core_admin_values['register_securitycode'] == '1'){  ?>on<?php } ?>">
                                    <div class="yes">ON</div>
                                    <div class="switch"></div>
                                    <div class="no">OFF</div>
                                  </div>
                                </div> 
                               </div>
                             </div>
                             
                             <input type="hidden" class="row-fluid" id="register_securitycode" name="admin_values[register_securitycode]" 
                             value="<?php echo $core_admin_values['register_securitycode']; ?>">
            </div> 
          
          <p>Turn ON if you want a security question added to help prevent user spam. </p>  
    </div>
            


<hr />
    
    <?php get_template_part('framework/admin/templates/admin', 'userfields' ); ?>
    
    
     
<div class="heading2" style="margin-top:20px;">Registration Page Text</div>
<p><small>Here you can add your own text which will be displayed at the top of the user registration page. </small></p>
<textarea id="default-textarea" style="height:100px; width:100%;" name="admin_values[register_text]"><?php echo stripslashes($core_admin_values['register_text']); ?></textarea>
  
    
    
    </div>
    </div>
    </div>
</div>


<div class="accordion-group">
    <div class="accordion-heading" style="background:#fff;">
        <a class="accordion-toggle collapsed" data-toggle="collapse" data-parent="#user_according" href="#user0">
         <h4 style="margin:0xp;font-weight:bold;">
         
         <img src="<?php echo get_template_directory_uri(); ?>/framework/admin/img/icons/u1.png">
        User Account <span style="font-size:12px;">(view/hide)</span></h4> 
        </a>
    </div>
    
    <div id="user0" class="accordion-body collapse <?php if(isset($_GET['showme']) && $_GET['showme'] == "user"){ echo "in"; }?>">
    <div class="accordion-inner">
    <div class="innerwrap content">
    <?php get_template_part('framework/admin/templates/admin', 'user-account' ); ?>
    </div>
    </div>
    </div>
</div>

<?php if(!defined('WLT_DATING') && !defined('WLT_CART') ){ ?>
<div class="accordion-group">
    <div class="accordion-heading" style="background:#fff;">
        <a class="accordion-toggle collapsed" data-toggle="collapse" data-parent="#user_according" href="#userp">
         <h4 style="margin:0xp;font-weight:bold;">
         
         <img src="<?php echo get_template_directory_uri(); ?>/framework/admin/img/icons/up.png">
       User Profile <span style="font-size:12px;">(view/hide)</span></h4> 
        </a>
    </div>
    
    <div id="userp" class="accordion-body collapse <?php if(isset($_GET['showme']) && $_GET['showme'] == "userp"){ echo "in"; }?>">
    <div class="accordion-inner">
    <div class="innerwrap content">
    <?php get_template_part('framework/admin/templates/admin', 'user-profile' ); ?>
    </div>
    </div>
    </div>
</div>
<?php }else{ ?>
<input type="hidden" name="admin_values[allow_profile]" value="0"  />
<?php } ?>

<div class="accordion-group">
    <div class="accordion-heading" style="background:#fff;">
        <a class="accordion-toggle collapsed" data-toggle="collapse" data-parent="#user_according" href="#user1">
         <h4 style="margin:0xp;font-weight:bold;">
         
         <img src="<?php echo get_template_directory_uri(); ?>/framework/admin/img/icons/u2.png">
        User Credit <span style="font-size:12px;">(view/hide)</span></h4> 
        </a>
    </div>
    
    <div id="user1" class="accordion-body collapse">
    <div class="accordion-inner">
    <div class="innerwrap content">
    <?php get_template_part('framework/admin/templates/admin', 'user-credit' ); ?>
    </div>
    </div>
    </div>
</div>



<div class="accordion-group">
    <div class="accordion-heading" style="background:#fff;">
        <a class="accordion-toggle collapsed" data-toggle="collapse" data-parent="#user_according" href="#user6">
         <h4 style="margin:0xp;font-weight:bold;">
         
         <img src="<?php echo get_template_directory_uri(); ?>/framework/admin/img/icons/u6.png">
        Social Login Buttons (Beta) <span style="font-size:12px;">(view/hide)</span></h4> 
        </a>
    </div>
    
    <div id="user6" class="accordion-body collapse">
    <div class="accordion-inner">
    <div class="innerwrap content">
    <?php get_template_part('framework/admin/templates/admin', 'user-socialogin' ); ?>
    </div>
    </div>
    </div>
</div>
<?php /* 
<input type="hidden"  name="admin_values[allow_socialbuttons]" value="0">
 */ ?>

</div>

  
 

 
</div>

<div class="span4">


<a data-toggle="modal" href="#VideoModelBox" class="btn btn-warning youtube" onclick="PlayPPTVideo('ruWeuHtRXnw','videoboxplayer','479','350');" style="width:100%; margin-bottom:10px; ">Watch Video Tutorial</a>

 
 
<div class="box gradient">
<div class="title"><div class="row-fluid"><h3>Website Users<h3></div></div> 
<div class="content">

<?php

$count_users	= count_users();
 
?>

<p>Registered users by role;</p>

<table class="table table-condensed">

<tr class="active">
<td>Total Users</td>
<td><b><?php echo $count_users['total_users']; ?></b></td>
</tr>


<tr class="active">
<td>administrator</td>
<td><?php echo $count_users['avail_roles']['administrator']; ?></td>
</tr>

<tr class="active">
<td>Subscribers</td>
<td><?php echo $count_users['avail_roles']['subscriber']; ?></td>
</tr>

<tr class="active">
<td>Contributors</td>
<td><?php echo $count_users['avail_roles']['contributor']; ?></td>
</tr> 

</table>

<a href="users.php" class="btn btn-success btn-lg" style="width:100%;">Manage Users</a>
     



</div></div>
 
 
</div>

</div>