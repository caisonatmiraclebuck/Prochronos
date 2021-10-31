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

global $wpdb;


// LOAD IN MAIN DEFAULTS 
$core_admin_values = get_option("core_admin_values");  

// EMAILS
$wlt_emails = get_option("wlt_emails");

// DEFAULT CORE EMAILS
$default_email_array = array(

"welcome" => array('name' => 'Welcome Email',  'shortcodes' => array( 'email' => 'user_email', 'password' => 'password') , 'label'=>'label-success', 'desc' => 'This email is sent to the user when they register on the website.'),
"newlisting" => array('name' => 'New Listing',  'shortcodes' => array('title' => 'title','link' => 'link','date' => 'post_date'), 'label'=>'label-success', 'desc' => 'This email is sent to the user after they create a new listing.'),
"contact" => array('name' => 'Listing Contact Form',   'shortcodes' => array('name' => 'name', 'email' => 'email', 'phone' => 'phone', 'link' => 'link', 'message' => 'message'), 'label'=>'label-success', 'desc' => 'This email is sent to the listing author when someone uses the listing page contact form.'),
"subscription_email" => array('name' => 'Email Subscription', 'shortcodes' => array('title' => 'title','link' => 'link','date' => 'post_date'), 'label'=>'label-success', 'desc' => 'This email is sent to members who have subscribed to a category and a new listing has just been created within that category.'),

"newfeedback" => array('name' => 'New Feedback', 'shortcodes' => array('title' => 'title','link' => 'link','date' => 'post_date'), 'label'=>'label-success', 'desc' => 'This email is sent to members who recieve new feedback.'),



"n1" => array('break' => 'Listing Expiry Emails'),


"expired" => array('name' => 'Listing Expired',   'shortcodes' => array('title' => 'title','link' => 'link','date' => 'post_date','expired' => 'expired'), 'label'=>'label-info', 'desc' => 'These emails are sent to the user when their listings are due to expire.'),

	"reminder_30" => array('name' => '30 day renewal reminder',   'shortcodes' => array('title' => 'title','link' => 'link','date' => 'post_date','expired' => 'expired'), 'label'=>'label-info'
	 
	),
	
	
	"reminder_15" => array('name' => '15 day renewal reminder',   'shortcodes' => array('title' => 'title','link' => 'link','date' => 'post_date','expired' => 'expired'), 'label'=>'label-info'),
	"reminder_1" => array('name' => '1 day renewal reminder',   'shortcodes' => array('title' => 'title','link' => 'link','date' => 'post_date','expired' => 'expired'), 'label'=>'label-info'),
	

"n2" => array('break' => 'Membership Expiry Emails'),

"mem_expired" => array('name' => 'Membership Expired',  'shortcodes' => array('expired' => 'expired'), 'label' =>'label-important', 'desc' => 'These emails are sent to the user when their membership is due to expire.'),


	"mem_reminder_30" => array('name' => '30 day renewal reminder',   'shortcodes' => array('expired' => 'expired'), 'label'=>'label-important'),
	"mem_reminder_15" => array('name' => '15 day renewal reminder',   'shortcodes' => array('expired' => 'expired'), 'label'=>'label-important'),
	"mem_reminder_1" => array('name' => '1 day renewal reminder',   'shortcodes' => array('expired' => 'expired'), 'label'=>'label-important'),
	
 

"n4" => array('break' => 'Message System'),
	"msg_new" => array('name' => 'New Message',  'shortcodes' => array('to username' => 'username','from username' => 'from_username','subject' => 'subject','message' => 'message'), 'label'=>'label-inverse',  'desc' => 'This email is sent to the user when they receieve a new message.'),

"n5" => array('break' => 'New Order'),
 	"order_new_sccuess" => array('name' => 'New Successful Order',  'shortcodes' => array('username' => 'username'), 'label'=>'label-info' , 'desc' => 'This email is sent to the user when they successfully place a new order.'),
	"order_new_failed" => array('name' => 'New Failed Order',  'shortcodes' => array('username' => 'username'), 'label'=>'label-info', 'desc' => 'This email is sent to the user when an error occured during checkout.'),

"n3" => array('break' => 'Admin Emails'),
	"admin_welcome" => array('name' => 'User Registration',  'shortcodes' => array('username' => 'user_login','email' => 'user_email','password' => 'password'), 'label'=>'label-warning'),
	"admin_newlisting" => array('name' => 'New Listing',  'shortcodes' => array('title' => 'title','link' => 'link','date' => 'post_date'), 'label'=>'label-warning'),
	"admin_newclaim" => array('name' => 'New Listing Claim',  'shortcodes' => array('title' => 'title','link' => 'link','date' => 'post_date'), 'label'=>'label-warning'),
	"admin_order_new" => array('name' => 'New Order',  'shortcodes' => array('order status' => 'payment_status','order ID' => 'orderid','order data' => 'order_data'), 'label'=>'label-warning'),
	
);


if(defined('WLT_CART')){

unset($default_email_array['newlisting']);
unset($default_email_array['subscription_email']);
unset($default_email_array['n1']);
unset($default_email_array['reminder_30']);
unset($default_email_array['reminder_15']);
unset($default_email_array['reminder_1']);
unset($default_email_array['expired']);
unset($default_email_array['n2']);
unset($default_email_array['mem_reminder_30']);
unset($default_email_array['mem_reminder_15']);
unset($default_email_array['mem_reminder_1']);
unset($default_email_array['mem_expired']);
unset($default_email_array['n4']);
unset($default_email_array['msg_new']);
unset($default_email_array['admin_newclaim']);
unset($default_email_array['admin_newlisting']);
unset($default_email_array['contact']);
}

// TURN OFF EMAILS IF NOT USED
if($core_admin_values['show_account_subscriptions'] != '1'){ 
unset($default_email_array['subscription_email']);
}

$default_email_array = hook_email_list_filter($default_email_array);
  
?>

   <p>Select an email to be used for each of the actions below.</p>
     
        <table class="table  table-striped table-bordered">
            <thead>
              <tr>
                <th >Action</th>
                <th>Assigned Email</th>
              </tr>
            </thead>
            <tbody>
            
        
<!------------ FIELD -------------->      
<?php if(is_array($default_email_array)){ foreach($default_email_array as $key1=>$val1){ 


if(isset($val1["break"])){ ?>
 
              <tr>
                <th><?php echo $val1["break"]; ?></th>
                <th>&nbsp;</th>
              </tr>
           
<?php }else{ ?>
<tr><td>
<span class="label <?php echo $val1['label']; ?>" style="font-size: 16px;    font-weight: normal;    padding: 5px;"><?php echo $val1['name']; ?></span>

<br />  
<?php if(isset($core_admin_values['emails'][$key1]) && is_numeric($core_admin_values['emails'][$key1])){ ?>
<a style="font-size:11px;" href="admin.php?page=3&test_email=<?php echo $key1; ?>&emailid=<?php echo $core_admin_values['emails'][$key1]; ?>"><i class="gicon-plus-sign"></i> send test email</a>
<?php } ?>
</td>
<td>
<select data-placeholder="Choose a an email..." class="chzn-select" name="admin_values[emails][<?php echo $key1; ?>]">

	<?php 
	if(is_array($wlt_emails)){ 
		foreach($wlt_emails as $key=>$field){ 
			if(isset($core_admin_values['emails']) && $core_admin_values['emails'][$key1] == $key){	$sel = " selected=selected ";	}else{ $sel = ""; }
			echo "<option value='".$key."' ".$sel.">".stripslashes($field['subject'])."</option>"; 
		} 
	} 
	?> 
    
     <option value="" <?php if($core_admin_values['emails'][$key1] == ""){ echo " selected=selected "; } ?>>--- do not send --- </option>
</select>  
</td></tr>   


<?php if(isset($val1['desc'])){ ?>
<tr>
<td colspan="2" style="font-size:12px;"><?php echo $val1['desc']; ?></td>
</tr>
<?php } ?>
 
<?php } ?>
<?php } } ?>
</div>
 
<!------------ END FIELD -------------->  
 </tr> </tbody> </table>       
        
 
<div class="form-actions row-fluid">
<div class="span7 offset5">
<button type="submit" class="btn btn-primary">Save Changes</button> 
</div>
</div> 