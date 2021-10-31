<?php
// CHECK THE PAGE IS NOT BEING LOADED DIRECTLY
if (!defined('THEME_VERSION')) {	header('HTTP/1.0 403 Forbidden'); exit; }
// SETUP GLOBALS
global $wpdb, $CORE, $userdata, $CORE_ADMIN;
// LOAD IN MAIN DEFAULTS 
$core_admin_values = get_option("core_admin_values");  


// DEFAULT CORE EMAILS
$default_email_array = array(

"welcome" => array('name' => 'Welcome Email',  'shortcodes' => array( 'email' => 'user_email', 'password' => 'password') , 'label'=>'label-success', 'desc' => 'This email is sent to the user when they register on your website.'),
"newlisting" => array('name' => 'New Listing',  'shortcodes' => array('title' => 'title','link' => 'link','date' => 'post_date'), 'label'=>'label-success', 'desc' => 'This email is sent to the user after they create a new listing.'),
"contact" => array('name' => 'Listing Contact Form',   'shortcodes' => array('name' => 'name', 'email' => 'email', 'phone' => 'phone', 'link' => 'link', 'message' => 'message'), 'label'=>'label-success', 'desc' => 'This email is sent to the listing author when someone uses the listing page contact form.'),
"subscription_email" => array('name' => 'Email Subscription', 'shortcodes' => array('title' => 'title','link' => 'link','date' => 'post_date'), 'label'=>'label-success', 'desc' => 'This email is sent to members who have subscribed to a category and a new listing has just been created within that category.'),

"newfeedback" => array('name' => 'New Feedback', 'shortcodes' => array('title' => 'title','link' => 'link','date' => 'post_date'), 'label'=>'label-success', 'desc' => 'This email is sent to members who recieve new feedback.'),



"n1" => array('break' => 'Listing Expiry Emails'),
	"reminder_30" => array('name' => '30 day renewal reminder',   'shortcodes' => array('title' => 'title','link' => 'link','date' => 'post_date','expired' => 'expired'), 'label'=>'label-info'),
	"reminder_15" => array('name' => '15 day renewal reminder',   'shortcodes' => array('title' => 'title','link' => 'link','date' => 'post_date','expired' => 'expired'), 'label'=>'label-info'),
	"reminder_1" => array('name' => '1 day renewal reminder',   'shortcodes' => array('title' => 'title','link' => 'link','date' => 'post_date','expired' => 'expired'), 'label'=>'label-info'),
	"expired" => array('name' => 'Listing Expired',   'shortcodes' => array('title' => 'title','link' => 'link','date' => 'post_date','expired' => 'expired'), 'label'=>'label-info'),


"n2" => array('break' => 'Membership Expiry Emails'),
	"mem_reminder_30" => array('name' => '30 day renewal reminder',   'shortcodes' => array('expired' => 'expired'), 'label'=>'label-important'),
	"mem_reminder_15" => array('name' => '15 day renewal reminder',   'shortcodes' => array('expired' => 'expired'), 'label'=>'label-important'),
	"mem_reminder_1" => array('name' => '1 day renewal reminder',   'shortcodes' => array('expired' => 'expired'), 'label'=>'label-important'),
	"mem_expired" => array('name' => 'Listing Expired',  'shortcodes' => array('expired' => 'expired'), 'label' =>'label-important'),

"n3" => array('break' => 'Admin Emails'),
	"admin_welcome" => array('name' => 'User Registration',  'shortcodes' => array('username' => 'user_login','email' => 'user_email','password' => 'password'), 'label'=>'label-warning'),
	"admin_newlisting" => array('name' => 'New Listing',  'shortcodes' => array('title' => 'title','link' => 'link','date' => 'post_date'), 'label'=>'label-warning'),
	"admin_newclaim" => array('name' => 'New Listing Claim',  'shortcodes' => array('title' => 'title','link' => 'link','date' => 'post_date'), 'label'=>'label-warning'),
	"admin_order_new" => array('name' => 'New Order',  'shortcodes' => array('order status' => 'payment_status','order ID' => 'orderid','order data' => 'order_data'), 'label'=>'label-warning'),
	 

"n4" => array('break' => 'Message System'),
	"msg_new" => array('name' => 'New Message',  'shortcodes' => array('to username' => 'username','from username' => 'from_username','subject' => 'subject','message' => 'message'), 'label'=>'label-inverse'),

"n5" => array('break' => 'New Order'),
 	"order_new_sccuess" => array('name' => 'New Successful Order',  'shortcodes' => array('username' => 'username'), 'label'=>'label-info'),
	"order_new_failed" => array('name' => 'New Failed Order',  'shortcodes' => array('username' => 'username'), 'label'=>'label-info'),


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

// REMOVE REGISTRATION FIELD
if(!defined('WLT_DEMOMODE')){


// DEFAULT EMAIL TEMPLATES

if(isset($_GET['et']) && $_GET['et'] == 1){

	$wlt_emails = get_option("wlt_emails");
	 
	$ce = count($wlt_emails);
	$ce++;
	
	// WELCOME EMAIL
	$wlt_emails[$ce] = array( 
		"subject" => "Welcome to our website",
		"message" => "Dear User<br><br>Thanks for joining our website.<br><br>Your Login details are: <br><br>&nbsp;&nbsp;&nbsp;Email: (user_email) <br>&nbsp;&nbsp;&nbsp;Password: (password) <br><br>Kind Regards<br>Management.",
		"from_name" => "",
	);
	$ce++;
	
	// NEW LISTINGS
	$wlt_emails[$ce] = array( 
		"subject" => "New Listing Added",
		"message" => "Dear User<br><br>Thank you for creating a new listing on our website.<br><br>Listing Details: <br><br>&nbsp;&nbsp;&nbsp;Title: (title) <br>&nbsp;&nbsp;&nbsp;Link: (link) <br>&nbsp;&nbsp;&nbsp;Date: (post_date) <br><br>Kind Regards<br>Management.",
		"from_name" => "",
	);
	$ce++;
	
	
	// NEW LISTINGS
	$wlt_emails[$ce] = array( 
		"subject" => "New Message Received",
		"message" => "Dear User<br><br>You have received a message regarding your listing at: (link)<br><br>&nbsp;&nbsp;&nbsp;Name: (name) <br>&nbsp;&nbsp;&nbsp;Email: (email) <br>&nbsp;&nbsp;&nbsp;Phone: (phone) <br>&nbsp;&nbsp;&nbsp;Message: (message) <br><br>Kind Regards<br>Management.",
		"from_name" => "",
	);
	$ce++;
	
	
	// EXPIRY NOTICE 30
	$wlt_emails[$ce] = array( 
		"subject" => "Listing Expiring - 30 Day Notice",
		"message" => "Dear User<br><br>Your listing is due to expire within 30 days.  <br><br>Listing Details: <br><br>&nbsp;&nbsp;&nbsp;Title: (title) <br>&nbsp;&nbsp;&nbsp;Link: (link) <br>&nbsp;&nbsp;&nbsp;Date: (expired) <br><br>Kind Regards<br>Management.",
		"from_name" => "",
	);
	$ce++;
	
	// EXPIRY NOTICE 15
	$wlt_emails[$ce] = array( 
		"subject" => "Listing Expiring - 15 Day Notice",
		"message" => "Dear User<br><br>Your listing is due to expire within 30 days.  <br><br>Listing Details: <br><br>&nbsp;&nbsp;&nbsp;Title: (title) <br>&nbsp;&nbsp;&nbsp;Link: (link) <br>&nbsp;&nbsp;&nbsp;Date: (expired) <br><br>Kind Regards<br>Management.",
		"from_name" => "",
	);
	$ce++;
	
	// EXPIRY NOTICE 1
	$wlt_emails[$ce] = array( 
		"subject" => "Listing Expiring - 1 Day Notice",
		"message" => "Dear User<br><br>Your listing is due to expire within 30 days.  <br><br>Listing Details: <br><br>&nbsp;&nbsp;&nbsp;Title: (title) <br>&nbsp;&nbsp;&nbsp;Link: (link) <br>&nbsp;&nbsp;&nbsp;Date: (expired) <br><br>Kind Regards<br>Management.",
		"from_name" => "",
	);
	$ce++;
	
	// EXPIRED NOTICE
	$wlt_emails[$ce] = array( 
		"subject" => "Listing Expired - Act Now!",
		"message" => "Dear User<br><br>Your listing has expired. <br><br>Listing Details: <br><br>&nbsp;&nbsp;&nbsp;Title: (title) <br>&nbsp;&nbsp;&nbsp;Link: (link) <br>&nbsp;&nbsp;&nbsp;Date: (expired) <br><br>Kind Regards<br>Management.",
		"from_name" => "",
	);
	$ce++;
	
	
	// MEMBERSHIP EXPIRED NOTICE
	$wlt_emails[$ce] = array( 
		"subject" => "Membership Expiry Notice",
		"message" => "Dear User<br><br>Your membership is due to expiry on: (expired) <br><br>Kind Regards<br>Management.",
		"from_name" => "",
	);
	$ce++;	
	
	// ADMIN - 1
	$wlt_emails[$ce] = array( 
		"subject" => "Admin - User Registration",
		"message" => "Dear Admin<br><br>A new user has joined your website (blog_name). <br><br> Username: (user_login) <br><br>(link)<br><br>Kind Regards<br>Management.",
		"from_name" => "",
	);
	$ce++;	
	
	// ADMIN NEW LISTINGS
	$wlt_emails[$ce] = array( 
		"subject" => "Admin - New Listing Added",
		"message" => "Dear Admin<br><br>A new listing has been added to your website (blog_name).<br><br>Listing Details: <br><br>&nbsp;&nbsp;&nbsp;Title: (title) <br>&nbsp;&nbsp;&nbsp;Link: (link) <br>&nbsp;&nbsp;&nbsp;Date: (post_date) <br><br>Kind Regards<br>Management.",
		"from_name" => "",
	);
	$ce++;
	
	// ADMIN NEW LISTINGS
	$wlt_emails[$ce] = array( 
		"subject" => "Admin - New Order",
		"message" => "Dear Admin<br><br>A new order has been processed on your website (blog_name).<br><br>Order Details: <br><br>&nbsp;&nbsp;&nbsp;OrderID: (orderid) <br>&nbsp;&nbsp;&nbsp;Status: (payment_status) <br>&nbsp;&nbsp;&nbsp;Data: (order_data) <br><br>Kind Regards<br>Management.",
		"from_name" => "",
	);
	$ce++;
	
	// SAVE ARRAY DATA		 
	update_option( "wlt_emails", $wlt_emails);
	
	$GLOBALS['error_message'] = "Sample Emails Added Successfully.";
}


if(isset($_GET['delm']) && is_numeric($_GET['delm']) ){
$wpdb->query("DELETE FROM ".$wpdb->prefix."core_mailinglist WHERE autoid = ('".$_GET['delm']."') LIMIT 1");
$GLOBALS['error_message'] = "Mailing List Updated";

}elseif(isset($_GET['delall']) && is_numeric($_GET['delall']) ){
$wpdb->query("DELETE FROM ".$wpdb->prefix."core_mailinglist");
$GLOBALS['error_message'] = "Mailing List Updated";
}

 



 

if(isset($_POST['action'])){

	switch($_POST['action']){
	
	case "testemail": {
 
		$CORE->SENDEMAIL($_POST['toemail'],'custom', $_POST['subject'], $_POST['message']);
		
		$GLOBALS['error_message'] = "Email sent.";
		
	} break;
	
	case "sendemail": {
	if(strlen($_POST['subject']) > 2){
		$mailinglist = $wpdb->get_results("SELECT * FROM ".$wpdb->prefix."core_mailinglist WHERE email_confirmed=1"); 
		if ( $mailinglist ) {
			foreach ( $mailinglist as $maild ) {
				if(strlen($maild->email) > 1){
				$CORE->SENDEMAIL($maild->email,'custom',$_POST['subject'],$_POST['message']);
				}
			}
		}
		$GLOBALS['error_message'] = "Email sent.";
	}
	} break;
	
	case "importemails": {
 		 
		$emails = explode(PHP_EOL,$_POST['import_emails_data1']);
	  
		if(is_array($emails)){
			foreach($emails as $email){			 
			 $bits = explode("[",$email); 
			 $fname = ""; $lname = "";
			 if(strpos($bits[1], "]") !== false){
			 	$ib = explode(" ",$bits[1]);
				$fname = str_replace("]","",$ib[0]); 
				$lname = str_replace("]","",$ib[1]);
			 }			 
			// ADD DATABASE ENTRY
			if(strlen($bits[0]) > 2){
			$hash = md5($_GET['eid'].rand());
			$SQL = "INSERT INTO ".$wpdb->prefix."core_mailinglist (`email`, `email_hash`, `email_ip`, `email_date`, `email_firstname`, `email_lastname`, email_confirmed) 
			VALUES ('".strip_tags(trim($bits[0]))."', '".$hash."', '".$CORE->get_client_ip()."', now(), '".trim($fname)."', '".trim($lname)."','1');";			
			$wpdb->query($SQL);
			
			}
				
			} // end foreach
		}// end if
		
		$GLOBALS['error_message'] = "Mailing List Updated";
		
		} break;
	
	}
} 


if(isset($_POST['newemail'])){
			
	// GET EXISTING FIELDS THEN ADD-ON THE NEW ONE
	$wlt_emails = get_option("wlt_emails");
	if(!is_array($wlt_emails)){ $wlt_emails = array(); }
	// ADD ONE NEW FIELD 
	if(!isset($_POST['eid'])){
		array_push($wlt_emails, $_POST['wlt_email']);		
		$GLOBALS['error_message'] = "Email Created Successfully";
	}else{
		$wlt_emails[$_POST['eid']] = $_POST['wlt_email'];		
		$GLOBALS['error_message'] = "Email Updated Successfully";
	}
	// SAVE ARRAY DATA		 
	update_option( "wlt_emails", $wlt_emails);
				
}elseif(isset($_GET['delete_email']) && is_numeric($_GET['delete_email'] )){

	// GET EXISTING FIELDS THEN ADD-ON THE NEW ONE
	$wlt_emails = get_option("wlt_emails");
	if(!is_array($wlt_emails)){ $wlt_emails = array(); }
	
	// LOOK AND SEARCH FOR DELETION
	foreach($wlt_emails as $key=>$pak){
		if($key == $_GET['delete_email']){
			unset($wlt_emails[$key]);	 
		}
	}
	
	// SAVE ARRAY DATA
	update_option( "wlt_emails", $wlt_emails);
	
	$_POST['tab'] = "email";
	$GLOBALS['error_message'] = "Email Deleted Successfully";

}
}

$wlt_emails = get_option("wlt_emails");

// LOAD IN HEADER
echo $CORE_ADMIN->HEAD(); ?>

 <a data-toggle="modal" href="#VideoModelBox" class="btn btn-warning youtube" onclick="PlayPPTVideo('28YqgwjLJIU','videoboxplayer','479','350');" style="float:right; ">Watch Video Tutorial</a>

<ul id="tabExample1" class="nav nav-tabs">

<?php
// HOOK INTO THE ADMIN TABS
function _3_tabs(){ $STRING = ""; global $wpdb; $core_admin_values = get_option("core_admin_values");

	if(isset($_GET['tab'])){ $_POST['tab'] = $_GET['tab']; }
	
	$pages_array = array( 
	"1" => array("t" => "System Emails", "k"=>"email"),
	"2" => array("t" => "Mailing List Widget", "k"=>"mailinglist"),
 
 	);
	foreach($pages_array as $page){
	
	if( ( isset($_POST['tab']) && $_POST['tab'] == $page['k'] ) || ( !isset($_POST['tab']) && $page['k'] == "email" ) ){ $class = "active"; }else{ $class = ""; }
	
		$STRING .= '<li class="'.$class.'"><a href="#'.$page['k'].'" onclick="document.getElementById(\'ShowTab\').value=\''.$page['k'].'\'" data-toggle="tab">'.$page['t'].'</a></li>';		
	}
 
	return $STRING;

}
echo hook_admin_3_tabs(_3_tabs());
// END HOOK
?>  
                     
</ul>

<div class="tab-content">

 
 

<?php if(isset($_GET['edit_email']) && is_numeric($_GET['edit_email']) ){ 
$wlt_emails = get_option("wlt_emails");

?>
 
</form>


<form method="post" name="admin_email" id="admin_email" action="admin.php?page=3" class="well">
<input type="hidden" name="newemail" value="yes" />
<input type="hidden" name="tab" value="email" />
<?php if(isset($_GET['edit_email']) && $_GET['edit_email'] != -1){ ?>
<input type="hidden" name="eid" value="<?php echo $_GET['edit_email']; ?>" />
<input type="hidden" name="wlt_email[ID]" value="<?php echo $_GET['edit_email']; ?>" />
<?php } ?>

               
          	 <div class="form-row control-group row-fluid">
                <label class="control-label span3" for="normal-field"><b>Subject</b></label>
                <div class="controls span9">
                  <input type="text"  name="wlt_email[subject]" class="row-fluid" value="<?php if(isset($_GET['edit_email'])){ echo stripslashes($wlt_emails[$_GET['edit_email']]['subject']); }?>">
                   
                </div>
              </div> 
              
              
              <div class="form-row control-group row-fluid">
                <style>
				.wp-switch-editor, .tmce-active .switch-tmce, .html-active .switch-html { height:27px !important; }
				</style>
                 
                 
                 <?php
				 
				 // LOAD UP EDITOR
	if(isset($_GET['edit_email']) && $_GET['edit_email'] != -1 ){ $content = stripslashes($wlt_emails[$_GET['edit_email']]['message']); }else{ $content = ""; }
	echo wp_editor( $content, 'wlt_email', array( 'textarea_name' => 'wlt_email[message]') ); 
				 
				 ?>
                             
                
              </div> 
              
<hr />
              
<div id="wlt_email_extras">
 
  <div class="accordion-group">
    <div class="accordion-heading">
      <a class="accordion-toggle collapsed" data-toggle="collapse" data-parent="#wlt_email_extras" href="#col1"> 
      <img src="<?php echo get_template_directory_uri(); ?>/framework/img/a3.png">
      Global Email Shortcodes    </a>
    </div>
    <div id="col1" class="accordion-body collapse" style="height: 0px;">
      <div class="accordion-inner">
    
      <p>These are email shortcodes that are available for all emails.</p>
              
              <div class="well" style="background: #fff;">
              <?php
			  
			  $btnArray = array(
			  
			  "link" 		=> "Website Link",
			  "blog_name" 	=> "Blog Name",
			  "date" 		=> "Date & Time",
			  "time" 		=> "Time",
			  "username" 	=> "Username",
			  "user_email" 	=> "User Email",
			  "user_registered" => "User Registered Date"
			  
			  );
			  foreach( $btnArray as $k => $b){
			   echo "<a href='javascript:void(0);' onclick=\"AddthisShortC('".$k."','wlt_email');\" class='btn' style='margin-right:10px; margin-bottom:5px;'>(".$k.")</a>";
			   }
			  
			  ?>
              </div>
              
        
    
     </div>
    </div>
  </div>
  
  
   <div class="accordion-group">
    <div class="accordion-heading">
      <a class="accordion-toggle collapsed" data-toggle="collapse" data-parent="#wlt_email_extras" href="#col3"> 
      <img src="<?php echo get_template_directory_uri(); ?>/framework/img/a3.png">
      Special Email Shortcodes  </a>
    </div>
    <div id="col3" class="accordion-body collapse" style="height: 0px;">
      <div class="accordion-inner">
    
      <p>These shortcodes are only available when a set email is sent such as the welcome email or the renewal email.</p>
      
      
<?php if(is_array($default_email_array)){ foreach($default_email_array as $key1=>$val1){ 


if(isset($val1["break"])){ }else{ 
	echo '<div class="well" style="background: #fff;"><span class="label '.$val1['label'].'">'.$val1['name']."</span> - ";
		if(is_array($val1['shortcodes'])){
			foreach( $val1['shortcodes'] as $k => $b){
			echo "<a href='javascript:void(0);' onclick=\"AddthisShortC('".$b."','wlt_email');\" class='btn' style='margin-right:10px; margin-bottom:5px;'>(".$b.")</a>";
			}
		}
	echo "</div>";
}} }
?>

 
    
     </div>
    </div>
  </div>
  
  
  
  <div class="accordion-group">
    <div class="accordion-heading">
      <a class="accordion-toggle collapsed" data-toggle="collapse" data-parent="#wlt_email_extras" href="#col2"> 
       <img src="<?php echo get_template_directory_uri(); ?>/framework/img/a3.png">
      Email Headers  </a>
    </div>
    <div id="col2" class="accordion-body collapse" style="height: 0px;">
      <div class="accordion-inner">
    
 <div class="form-row control-group row-fluid">
                <label class="control-label span3" for="normal-field"><b>Email From</b></label>
                <div class="controls span9">
                <div class="row-fluid">
                    <div class="span5">
                    <input type="text"  name="wlt_email[from_name]" class="row-fluid" value="<?php if(isset($_GET['edit_email'])){ echo $wlt_emails[$_GET['edit_email']]['from_name']; }?>" placeholder="Name">
                    </div>                
                    <div class="span5">
                    <input type="text"  name="wlt_email[from_email]" class="row-fluid" value="<?php if(isset($_GET['edit_email'])){ echo $wlt_emails[$_GET['edit_email']]['from_email']; }?>" placeholder="Email">
                    </div>
                </div> 
                   
                </div>
              </div> 
            
              
              
              <div class="form-row control-group row-fluid">
                <label class="control-label span3" for="normal-field"><b>BCC:</b></label>
                <div class="controls span9">
                <div class="row-fluid">
                    <div class="span5">
                    <input type="text"  name="wlt_email[bcc_name]" class="row-fluid" value="<?php if(isset($_GET['edit_email'])){ echo $wlt_emails[$_GET['edit_email']]['bcc_name']; }?>" placeholder="Your Name">
                    </div>                
                    <div class="span5">
                    <input type="text"  name="wlt_email[bcc_email]" class="row-fluid" value="<?php if(isset($_GET['edit_email'])){ echo $wlt_emails[$_GET['edit_email']]['bcc_email']; }?>" placeholder="Your Email">
                    </div>
                </div> 
                   
                </div>
              </div> 
    
     </div>
    </div>
  </div>     

<div class="clearfix"></div>
</div>
              
           <script>
function AddthisShortC(code, box){		   
	jQuery('#'+box).val(jQuery('#'+box).val()+'('+ code +')'); 
}
</script>          
        
              
              
           
           
              <hr />
              <button class="btn btn-primary" type="submit">Save Email</button>
</form>
<?php } ?>


















<?php do_action('hook_admin_3_content'); ?> 

<div class="tab-pane fade <?php if( ( isset($_POST['tab']) &&  $_POST['tab'] =="mailinglist"   )){ echo "active in"; } ?>" id="mailinglist">

<?php get_template_part('framework/admin/templates/admin', 'email-mailinglist' );  ?>     
        
</div>


<div class="tab-pane fade <?php if(!isset($_POST['tab']) || ( isset($_POST['tab']) && ( $_POST['tab'] =="" || $_POST['tab'] =="email" ) )){ echo "active in"; } ?>" id="email">

 
    <div class="tabbable tabs-left" >
    
    <ul id="tabExample2" class="nav nav-tabs">
    
    <li class="active"><a href="#e1" data-toggle="tab"><img  src="<?php echo get_template_directory_uri(); ?>/framework/admin/img/icons/30.png" align="absmiddle" style="float:left;padding-right:10px; margin-top: 3px;"> System Emails</a></li>
    
    <li><a href="#e2" data-toggle="tab"><img  src="<?php echo get_template_directory_uri(); ?>/framework/admin/img/icons/31.png" align="absmiddle" style="float:left;padding-right:10px; margin-top: 3px;"> Email Assignment</a></li>
    
    <li><a href="#e3" data-toggle="tab"><img  src="<?php echo get_template_directory_uri(); ?>/framework/admin/img/icons/32.png" align="absmiddle" style="float:left;padding-right:10px; margin-top: 3px;"> Email Alerts</a></li>
    
    
    <li <?php if(isset($_GET['delrs'])){ echo 'class="active"'; } ?>><a href="#e4" data-toggle="tab"><img  src="<?php echo get_template_directory_uri(); ?>/framework/admin/img/icons/33.png" align="absmiddle" style="float:left;padding-right:10px; margin-top: 3px;"> Email Settings</a></li>     
     
    </ul>
    
    <div class="tab-content">
    
        <div class="tab-pane fade in active" id="e1">
 
           <a href="admin.php?page=3&edit_email=-1" class="btn btn-success" style="float:right;margin-bottom:10px; margin-top:-10px; margin-right:0px;">Create New Email</a>
    
            <?php get_template_part('framework/admin/templates/admin', 'email-core' );  ?>     
        
        </div>
        
        <div class="tab-pane fade" id="e2">    
            
            <?php get_template_part('framework/admin/templates/admin', 'email-assignment' );  ?>     
        
        </div>
        
        <div class="tab-pane fade" id="e3">    
            
            <?php get_template_part('framework/admin/templates/admin', 'email-alerts' );  ?>     
        
        </div>
        
        <div class="tab-pane fade" id="e4">    
            
            <?php get_template_part('framework/admin/templates/admin', 'email-settings' );  ?>     
        
        </div>
    
    </div>
 
</div>

</div><!-- end tab --> 

</form>

               
 
 



<form method="post" name="importemails_email" id="importemails_email" action="admin.php?page=3">
<input type="hidden" name="tab" value="mailinglist" />
<input type="hidden" name="import_emails_data1" id="import_emails_data1" />
<input type="hidden" name="action" value="importemails" />  
</form>






 

<?php if(isset($_GET['test_email']) && strlen($_GET['test_email']) > 3 ){ 
$wlt_emails = get_option("wlt_emails");

?>
<script type="text/javascript">
jQuery(document).ready(function () { jQuery('#TestEmailModal').modal('show'); })
</script>
<?php } ?>

<form method="post" name="admin_email" id="admin_email" action="admin.php?page=3" >
<input type="hidden" name="action" value="testemail" />
<input type="hidden" name="tab" value="email" />
<input type="hidden" name="emailid" value="<?php if(isset($_GET['emailid'])){ echo $_GET['emailid']; } ?>" />
<input type="hidden" name="locationid" value="<?php if(isset($_GET['test_email'])){ echo $_GET['test_email']; } ?>" />

<div id="TestEmailModal" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="TestEmailModalLabel" aria-hidden="true">
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal" aria-hidden="true">x</button>
              <h3 id="myModalLabel">Test Email</h3>
            </div>
            <div class="modal-body">
            
            
                
               <div class="form-row control-group row-fluid">
                <label class="control-label span3" for="normal-field"><b>To</b></label>
                <div class="controls span9">
                  <input type="text"  name="toemail" class="row-fluid" value="<?php echo get_option('admin_email'); ?>">
                   
                </div>
              </div> 
               
          	 <div class="form-row control-group row-fluid">
                <label class="control-label span3" for="normal-field"><b>Subject</b></label>
                <div class="controls span9">
                  <input type="text"  name="subject" id="esubject" class="row-fluid" value="<?php if(isset($_GET['emailid'])){ echo stripslashes($wlt_emails[$_GET['emailid']]['subject']); }?>">
                   
                </div>
              </div> 
              
              
              <div class="form-row control-group row-fluid">
                <style>
				.wp-switch-editor, .tmce-active .switch-tmce, .html-active .switch-html { height:27px !important; }
				 
				#TestEmailModal .wp-editor-area { height:250px; }
                </style>
                 
                 
                 <?php
				 
				 // LOAD UP EDITOR
	if(isset($_GET['emailid'])){ $content = stripslashes($wlt_emails[$_GET['emailid']]['message']); }else{ $content = ""; }
	echo wp_editor( $content, 'message' ); 
				 
				 ?>
                             
                
              </div> 
              

            </div>
            
            <div class="modal-footer">
            
            <div class="pull-left"><b>Note</b> live data is not added to test emails.</div>
            
            
              <a class="btn" type="button" class="close" data-dismiss="modal" aria-hidden="true">Close</a>
              <button class="btn btn-primary">Send Test</button>
            </div>
</div>
</form>


<?php // LOAD IN FOOTER
echo $CORE_ADMIN->FOOTER(); ?>