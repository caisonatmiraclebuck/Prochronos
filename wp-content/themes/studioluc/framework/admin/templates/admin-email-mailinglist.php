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

global $CORE, $wpdb;

// LOAD IN MAIN DEFAULTS 
$core_admin_values = get_option("core_admin_values");  
 
  
?>
<div class="tabbable tabs-left" >
<ul id="tabExample4" class="nav nav-tabs" style="height:680px">
<li class="active"><a href="#shiptab1" data-toggle="tab"><img  src="<?php echo get_template_directory_uri(); ?>/framework/admin/img/icons/36.png" align="absmiddle" style="float:left;padding-right:10px; margin-top: 3px;"> Confirmed Users</a></li>
<li><a href="#shiptab2" data-toggle="tab"><img  src="<?php echo get_template_directory_uri(); ?>/framework/admin/img/icons/35.png" align="absmiddle" style="float:left;padding-right:10px; margin-top: 3px;"> Email Settings</a></li>
<li><a href="#shiptab3" data-toggle="tab"><img  src="<?php echo get_template_directory_uri(); ?>/framework/admin/img/icons/37.png" align="absmiddle" style="float:left;padding-right:10px; margin-top: 3px;"> Import Subscribers</a></li>
<li><a href="#shiptab4" data-toggle="tab"><img  src="<?php echo get_template_directory_uri(); ?>/framework/admin/img/icons/34.png" align="absmiddle" style="float:left;padding-right:10px; margin-top: 3px;"> Send Email</a></li> 
</ul>
<div class="tab-content"  style="background:#fff;height:680px">
    <div class="tab-pane fade in active" id="shiptab1">
    
    <div class="well">
        
        <a href="javascript:void(0);" onclick="jQuery('table .unconfirmed').hide();" style="text-decoration:underline;">Hide</a> / <a href="javascript:void(0);" onclick="jQuery('table .unconfirmed').show();" style="text-decoration:underline;">Show</a> Un-confirmed Emails (<span class="label label-warning"><i class="gicon-remove"></i></span>) |  
        
        
      <a href="javascript:void(0);" onclick="jQuery('table .confirmed').hide();" style="text-decoration:underline;">Hide</a> / <a href="javascript:void(0);" onclick="jQuery('table .confirmed').show();" style="text-decoration:underline;">Show</a> Confirmed Emails <span class="label label-success"><i class="gicon-ok"></i></span>
        
    </div>
    
    <?php 
	
	$mailinglist = $wpdb->get_results("SELECT * FROM ".$wpdb->prefix."core_mailinglist" );  // WHERE email_confirmed=1
	 
	
	if ( $mailinglist ) { ?>
     <table class="table table-hover">
                  <thead>
                    <tr>
                      <th> </th>
                      <th>Email</th>
                      <th>Date</th>
                      <th>Name</th>
                    </tr>
                  </thead>
                  <tbody>              
    <?php  foreach ( $mailinglist as $maild ) {  ?>
                    <tr class="<?php if($maild->email_confirmed == 1){ echo "confirmed"; }else{ echo "unconfirmed"; } ?>">
                      <td><a href="admin.php?page=3&delm=<?php echo $maild->autoid;?>" class="label label-important" style="color:#fff;">Delete</a></td>
                      <td><?php echo $maild->email." "; if($maild->email_confirmed == 1){ echo '<span class="label label-success"><i class="gicon-ok"></i></span>'; }else{ echo '<span class="label label-warning"><i class="gicon-remove"></i></span>'; } ?></td>
                      <td><?php echo $CORE->format_date($maild->email_date);?></td>
                      <td><?php echo $maild->email_firstname." ".$maild->email_lastname;?></td>
                    </tr>
    <?php }   ?>
                  </tbody>
                </table>   
                
              <hr />
              
             <a href="admin.php?page=3&delall=1" class="btn btn-info confirm" style="float:right;">Delete All Emails</a>
              <a href="admin.php?page=3&exportall=1" class="btn btn-success">Export All Emails</a>
             
            
              
    <?php }else{ ?>
    <div class="alert">You have no confirmed users in your mailing list. Try using the mailing list widget to generate new subscribers.</div>
    <?php } ?>
    
    </div>
    
    <div class="tab-pane fade in" id="shiptab2">
    
    	<div class="box gradient">
        <div class="title"><h4><i class="gicon-email"></i><span>Confirmation  Email</span></h4></div>
            <div class="content top">
            <p>This email is sent to the user once they subscribe to your mailing list and requires them to confirm their email address.</p>
            <hr />
             <input type="text" class="span7"  name="admin_values[mailinglist][confirmation_title]" value="<?php echo stripslashes($core_admin_values['mailinglist']['confirmation_title']); ?>">  
            <textarea class="row-fluid" style="height:200px; font-size:12px;" name="admin_values[mailinglist][confirmation_message]"><?php echo stripslashes($core_admin_values['mailinglist']['confirmation_message']); ?></textarea>   	 
    <p><span class="label">Remember</span> use (link) for the confirmation link in your email.</p>
    
     <hr />
            <label>&nbsp;&nbsp; Thank You Page Link (user is sent to after they confirm email)</label>
              <input type="text"  class="span8" name="adminArray[mailinglist_confirmation_thankyou]" placeholder="http://mywebiste.com/thankyou" value="<?php echo get_option('mailinglist_confirmation_thankyou'); ?>">
            <hr />
            <label>&nbsp;&nbsp; Unsubscribe Page Link (user is sent to after they unsubscribe from your mailing list)</label>
              <input type="text"  class="span8" name="adminArray[mailinglist_unsubscribe_thankyou]" placeholder="http://mywebiste.com/thankyou" value="<?php echo get_option('mailinglist_unsubscribe_thankyou'); ?>">
             
            </div>             
            
               
            
            
            <div class="form-actions row-fluid"><div class="span7 offset4"><button type="submit" class="btn btn-primary">Save Email</button></div></div>     
        </div>  
    
    </div>
    
    <div class="tab-pane fade in" id="shiptab3">
    <div class="row-fluid">    
        <div class="span12">    
          
        <div class="box gradient">
        <div class="title"><h4><i class="gicon-user"></i><span>Bulk Import Subscribers</span></h4></div>
            <div class="content top">
            <p>Enter email addresses below, each on a new line with optional name values. <br /> Import format is: <b> example@hotmail.com [John Doe]</b></p>
            <textarea class="row-fluid" id="import_emails_data" style="height:400px;" name="import_emails"></textarea>        
            </div>             
            <div class="form-actions row-fluid"><div class="span7 offset4"><button type="button" class="btn btn-success" onclick="jQuery('#import_emails_data1').val(jQuery('#import_emails_data').val());document.importemails_email.submit();">Start Import</button></div></div>     
        </div>          
        </div>        
    </div>
    </div>
    
    <div class="tab-pane fade in" id="shiptab4">
    <div class="row-fluid">    
        <div class="span12">    
        <input type="hidden" name="action" value="sendemail" />    
        <div class="box gradient">
        <div class="title"><h4><i class="gicon-user"></i><span>Send Email</span></h4></div>
            <div class="content top">
            <p>The message you send below will be emailed to ALL of your active subscribers.</p>
            <input type="text" name="subject" class="span12" placeholder="Subject Here" />
            <textarea class="row-fluid span12" style="height:350px;" name="message" placeholder="Message Here"></textarea> 
            <p>Use (unsubscribe) to include an unsubscribe link in your email.</p>     
            </div>             
            <div class="form-actions row-fluid"><div class="span7 offset4"><button type="submit" class="btn btn-primary">Send Email</button></div></div>     
        </div>          
        </div>        
    </div>
	</div>
    
</div>
</div>