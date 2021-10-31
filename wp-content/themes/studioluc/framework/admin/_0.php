<?php
// CHECK THE PAGE IS NOT BEING LOADED DIRECTLY
if (!defined('THEME_VERSION')) {	header('HTTP/1.0 403 Forbidden'); exit; }
// SETUP GLOBALS
global $wpdb, $CORE, $CORE_ADMIN, $userdata;
// LOAD IN MAIN DEFAULTS
$core_admin_values = get_option("core_admin_values"); $license = get_option('wlt_license_key');
// UPGRADE SYSTEM
if(isset($_POST['adminArray']['wlt_license_email'])){
	update_option("wlt_license_upgrade",""); // CLEAR
}
 
if(function_exists('current_user_can') && current_user_can('administrator')){
	// DELETE THE RECENT SEARCHES
	if(isset($_GET['delrs']) && isset($_GET['key']) ){
		$saved_searches_array = get_option('recent_searches');
		unset($saved_searches_array[str_replace(" ","_",$_GET['key'])]);
		update_option('recent_searches',$saved_searches_array);
	}elseif(isset($_GET['delrsall'])){
		update_option('recent_searches','');
	}
}// end if
// POST TYPE CHANGE IN 8.3
if(get_option('wlt_db_update_87') == ""){
	 
 	$wpdb->query("UPDATE ".$wpdb->posts." SET ".$wpdb->posts.".post_type = 'listing_type' WHERE ".$wpdb->posts.".post_type = 'coupon_type' OR ".$wpdb->posts.".post_type = 'product_type'");
 	$wpdb->query("UPDATE ".$wpdb->prefix."term_taxonomy SET taxonomy = 'listing' WHERE taxonomy = 'coupon' OR taxonomy = 'product'");
 
	update_option("wlt_db_update_87","complete");
}
 
// DATABASE UPDATE FOR VERSION 6.2
if(get_option('wlt_db_update_62') == ""){
	wp_schedule_event( time(), 'hourly', 'wlt_hourly_event_hook' );
	wp_schedule_event( time(), 'twicedaily', 'wlt_twicedaily_event_hook' );
	wp_schedule_event( time(), 'daily', 'wlt_daily_event_hook' );	
	update_option("wlt_db_update_62","complete");
}
if(get_option('wlt_db_update_65') == ""){
	$wpdb->query("CREATE TABLE IF NOT EXISTS `".$wpdb->prefix."core_withdrawal` (
	  `autoid` mediumint(10) NOT NULL AUTO_INCREMENT,
	  `user_id` varchar(10) NOT NULL, 
	  `user_ip` varchar(100) NOT NULL,
	  `user_name` varchar(100) NOT NULL,
	  `datetime` datetime NOT NULL,
	  `withdrawal_comments` longtext NOT NULL,
	  `withdrawal_status` int(1) NOT NULL DEFAULT '0', 
	  `withdrawal_total` varchar(10) NOT NULL,  
	  PRIMARY KEY (`autoid`))");
	update_option("wlt_db_update_65","complete");
}
// GOOGLE MAP UPDATES FOR 6.X+
//if(get_option('wlt_db_update_644') == ""){
 	
	//echo "UPDATE $wpdb->postmeta SET meta_value='US' WHERE meta_key='map_country' AND meta_value LIKE '%United States%'";
	
	foreach($GLOBALS['core_country_list'] as $key=>$val){
		//$wpdb->query("UPDATE $wpdb->postmeta SET meta_value='".$key."' WHERE meta_key='map_country' AND meta_value LIKE '%".$val."%'");
	}
	//update_option("wlt_db_update_644","complete");
//}


// LOAD IN HEADER
echo $CORE_ADMIN->HEAD(); ?>
 
    
    
     
<ul id="tabExample1" class="nav nav-tabs">

<?php
// HOOK INTO THE ADMIN TABS
function _0_tabs(){ $STRING = ""; global $wpdb; $core_admin_values = get_option("core_admin_values");
 	
	//$STRING .= '<li class="active"><a href="#home" data-toggle="tab">Dashboard</a></li>';
	//$STRING .= '<li><a href="#updates" data-toggle="tab">Framework Details</a></li>';
	 

	return $STRING;

}
if($license != ""){  echo hook_admin_0_tabs(_0_tabs()); }
// END HOOK
?>
 

<!--<li class=""><a href="#updates" data-toggle="tab">Theme Updates</a></li>-->

                 
</ul>   
 
<div class="tab-content" style="min-height:auto;">


<?php
// IF WE ARE ON THE LICENSE ENTERING PHASE

 if($license == ""){  ?> 
 
<?php if(get_option('wlt_license_upgrade') == 1){ ?>
<div class="alert alert-block alert-error fade in">
<h4 class="alert-heading" style="color:#b94a48; font-size:18px; font-weight:bold;">License Key Error</h4>
<p>The license key you entered during installation was either invalid or has expired. Please re-enter your license key below.</p>         
</div>
 <input type="hidden"  name="adminArray[wlt_license_key_error]"  value="1">
<?php } ?>
 
<div class="row-fluid">
<div class="span6">
<div class="box gradient">
<div class="title"><h3><i class="gicon-lock"></i><span> License &amp; Account</span></h3>
</div>
<div class="content">
 
<p>Please enter your software licence key and PremiumPress customer login email below. These can be <a href="http://www.premiumpress.com/account/" style="text-decoration:underline;" target="_blank">found here.</a> </p>           
<hr /> 

<div class="form-row control-group row-fluid">
<label class="control-label span4" for="style"><b>License Key</b></label>
<div class="controls span7">
 <input type="text"  name="adminArray[wlt_license_key]" id="license_key" class="row-fluid"  value="">
</div>
</div>

<div class="form-row control-group row-fluid">
<label class="control-label span4" for="style"><b>Email Address</b></label>
<div class="controls span7">
 <input type="text"  name="adminArray[wlt_license_email]" class="row-fluid" id="license_email" value="">
</div>
</div>

 
		<?php

		$HandlePath = TEMPLATEPATH . '/templates/'; $TemplateString = "";
	    $count=1;
		if($handle1 = opendir($HandlePath)) {      
			while(false !== ($file = readdir($handle1))){			
				if(strpos($file,".") ===false && strpos($file,"basic_") ===false && ( strpos($file,strtolower("template")) !== false  ) ){	
			 					
					$TemplateString .= '<option value="'.$file.'">'; 
					$TemplateString .= str_replace("_"," ",str_replace("-"," ",str_replace(strtolower('template'),"",$file)));									
					$TemplateString.= "</option>";			
   
				}
			}
		}
		
?> 
<?php if(strlen($TemplateString) > 1){ ?>
<hr />
<div class="form-row control-group row-fluid">
<label class="control-label span4" for="default-select"><b>Template</b></label>
<div class="controls span7">
<?php $selected_template = ""; ?>
<select name="admin_values[template]" class="chzn-select">
<?php echo $TemplateString; ?>
<!--<option value="">Framework - No Template</option>-->
</select>
</div>           
</div> 

 

<div class="form-row control-group row-fluid">
<label class="control-label span4" for="style"><b>Sample Data</b></label>
<div class="controls span7">
<select name="core_system_reset" id="core_system_reset1" class="chzn-select" >  
  <option value="yes">Yes - Install Sample Data</option>   
  <option <?php if(get_option('wlt_license_upgrade') == 1){ ?>selected=selected<?php } ?>>No Thanks</option>
                       
</select>
</div>
</div>
 
<?php } ?>
<hr />

  <div class="well">
             
             <textarea style="height:250px;width:100%;"><?php include("terms.txt"); ?></textarea>
             
             </div>
               <label class="checkbox" style="background:transparent;"><input type="checkbox" value="" onchange="UnDMe()" /> I agree to the terms of usage/disclaimer.</label>
 
<hr />
<div class="row-fluid">
<div class="span7 offset4"><button type="submit" class="btn btn-primary" id="installbtn">Save &amp; Continue</button></div>
</div> 
 


</div>   
 
 






            
        </div>
        <!-- End .box -->
        
        
        
      </div>
      <!-- End .span6 -->


    
      <div class="span6">
        <div class="box gradient">
          <div class="title">
            <h3><i class="gicon-info-sign"></i><span>Hosting Check (Pre-Installation)</span></h3>
          </div>
          <div class="content">
             
             <?php wlt_system_check(true); ?> 
          
        </div>  
        
    
          
            
        </div>
        <!-- End .box -->
        
      
     
<script type="text/javascript"> 
 
function isValidEmailAddress(emailAddress) {
    var pattern = new RegExp(/^(("[\w-+\s]+")|([\w-+]+(?:\.[\w-+]+)*)|("[\w-+\s]+")([\w-+]+(?:\.[\w-+]+)*))(@((?:[\w-+]+\.)*\w[\w-+]{0,66})\.([a-z]{2,6}(?:\.[a-z]{2})?)$)|(@\[?((25[0-5]\.|2[0-4][\d]\.|1[\d]{2}\.|[\d]{1,2}\.))((25[0-5]|2[0-4][\d]|1[\d]{2}|[\d]{1,2})\.){2}(25[0-5]|2[0-4][\d]|1[\d]{2}|[\d]{1,2})\]?$)/i);
    return pattern.test(emailAddress);
};
function VALIDATE_INSTALL_DATA(){
 
var de4 	= document.getElementById("license_key");
if(de4.value == ''){
	alert('License Key Missing');
	de4.style.border = 'thin solid red';
	de4.focus();
	return false;
}
 
if(de4.value.length  < 5){
	alert('Invalid License Key');
	de4.style.border = 'thin solid red';
	de4.focus();
	return false;
}
var de5 	= document.getElementById("license_email");
if( !isValidEmailAddress( de5.value ) ) {	
alert('Invalid Email Address');
de5.style.border = 'thin solid red';
de5.focus();
return false;
}

}
jQuery(document).ready(function() { 
jQuery('#installbtn').attr('disabled', true);  }); 
function UnDMe(){
if ( jQuery('#installbtn').is(':disabled') === false) { jQuery('#installbtn').attr('disabled', true);  
} else {jQuery('#installbtn').attr('disabled', false);  }}
</script>
























































<?php }else{






 
 
$count_posts 	= wp_count_posts(THEME_TAXONOMY.'_type'); 
$count_users	= count_users();
$comments 		= $wpdb->get_row("SELECT count(*) as count FROM $wpdb->comments");
$order_total 	= $wpdb->get_row("SELECT sum(order_total) AS total FROM ".$wpdb->prefix."core_orders");

?> 
 
 
 <ul class="row-fluid general_statistics to_hide">
  <li class="box gradient span3">
    <a>
    <div class="icon">
        <img src="<?php echo get_template_directory_uri(); ?>/framework/admin/img/icons/a1.png">
        <img class="hover" src="<?php echo get_template_directory_uri(); ?>/framework/admin/img/icons/a2.png">
    </div>
    <div class="heading"><?php echo $count_users['total_users']; ?></div>
    <div class="desc">Registered Members</div>
  </a>
  </li>
 <li class="box gradient span3">
   <a>
    <div class="icon">
        <img src="<?php echo get_template_directory_uri(); ?>/framework/admin/img/icons/b1.png">
        <img class="hover" src="<?php echo get_template_directory_uri(); ?>/framework/admin/img/icons/b2.png">
     </div>
    <div class="heading"><?php echo number_format($count_posts->publish+$count_posts->draft+$count_posts->pending+$count_posts->trash,0); ?></div>
    <div class="desc">Website Listings</div>
      </a>
  </li>
  <li class="box gradient span3">
     <a>
    <div class="icon">
        <img src="<?php echo get_template_directory_uri(); ?>/framework/admin/img/icons/d1.png">
        <img class="hover" src="<?php echo get_template_directory_uri(); ?>/framework/admin/img/icons/d2.png">
     </div>
    <div class="heading"><?php echo $comments->count; ?></div>
    <div class="desc">Website Comments</div>
      </a>
  </li>
  <?php if(!isset($core_admin_values['currency'])){ $core_admin_values['currency']['symbol'] = "$"; } ?>
   <li class="box gradient span3">
     <a>
    <div class="icon">
        <img src="<?php echo get_template_directory_uri(); ?>/framework/admin/img/icons/c1.png">
        <img class="hover" src="<?php echo get_template_directory_uri(); ?>/framework/admin/img/icons/c2.png">
     </div>
    <div class="heading"><?php if($order_total->total < 1){ echo "0"; }else{ echo hook_price(round($order_total->total,2)); } ?></div>
    <div class="desc">Total Earned</div>
      </a>
  </li>
 

 </ul>
 
 
 
 


<div class="tabbable" >

 <a data-toggle="modal" href="#VideoModelBox" class="btn btn-warning youtube" onclick="PlayPPTVideo('r8frKyvrLM4','videoboxplayer','479','350');" style="float:right;">Watch Video Tutorial</a>


<ul id="tabExample2" class="nav nav-tabs">

<li class="active"><a href="#home" data-toggle="tab"><img  src="<?php echo get_template_directory_uri(); ?>/framework/admin/img/icons/23.png" align="absmiddle" style="float:left;padding-right:10px; margin-top: 3px;"> Performance</a></li> 


<li><a href="#recentactivity" data-toggle="tab"><img  src="<?php echo get_template_directory_uri(); ?>/framework/admin/img/icons/25.png" align="absmiddle" style="float:left;padding-right:10px; margin-top: 3px;"> Recent Activity</a></li>

<li><a href="#recentsearchs" data-toggle="tab"><img  src="<?php echo get_template_directory_uri(); ?>/framework/admin/img/icons/24.png" align="absmiddle" style="float:left;padding-right:10px; margin-top: 3px;"> Recent Searches</a></li>
 
 
</ul>

<div class="tab-content">
 


<div class="tab-pane fade in <?php if( !isset($_GET['delrs']) ){ ?>active<?php } ?>" id="home">

<?php get_template_part('framework/admin/templates/admin', 'report-graph' );  ?>

</div>



<div class="tab-pane fade in <?php if(isset($_GET['delrs'])){ echo "active"; } ?>" id="recentsearchs">
<?php
$saved_searches_array = get_option('recent_searches');
if(is_array($saved_searches_array) && !empty($saved_searches_array) ){ 

$saved_searches_array = $CORE->multisort( $saved_searches_array, array('views') );
$saved_searches_array = array_reverse($saved_searches_array, true);
?>
<table class="table table-bordered table-striped">
<thead>
              <tr>
                <th>#</th>
                <th>Keyword</th>
                <th></th>
                 <th></th>
              </tr>
            </thead>
            <tbody>
<?php $f=1; foreach($saved_searches_array  as $key=>$searchdata){ ?>            
<tr>
<td style="width:30px;"><span class="label"><?php echo $f; ?></span></td>
<td><a href="<?php echo get_home_url(); ?>/?s=<?php echo str_replace("_"," ",$key); ?>" target="_blank"><?php echo str_replace("_"," ",$key); ?></a></td>
<td> <span class="label label-info"><?php echo $searchdata['views']; ?> Total Searches</span> / <small><?php echo hook_date($searchdata['first_view']); ?></small>
<!-- / Last Searched: <?php echo hook_date($searchdata['last_view']); ?> -->  </td>
<td> <a href="admin.php?page=premiumpress&delrs=1&key=<?php echo str_replace("_"," ",$key); ?>" class="btn">Delete</a>  </td>
</tr>
<?php $f++; } ?>
 
</tbody> </table>
<hr />
<a href="admin.php?page=premiumpress&delrsall" class="btn btn-info">Delete All Searches</a>
<?php }else{ ?>
No search data recorded.
<?php } ?>

</div>

<div class="tab-pane fade in" id="recentactivity">

<table class="table table-bordered table-striped">
<thead>
              <tr>
                <th>#</th>
                <th>Log Entry Message</th>
              </tr>
            </thead>
            <tbody>
 
<?php
// COUNT HOW MANY MESSAGES USER HAS UNREAD
$SQL = "SELECT * FROM ".$wpdb->prefix."core_log ORDER BY autoid DESC LIMIT 30";
$result = $wpdb->get_results($SQL);
foreach( $result as $log ) {
?> 
 <tr><td style="width:30px;">
<span class="label <?php echo $log->link; ?>"><?php echo $log->autoid; ?></span>

</td>
<td>
<?php
$logmessage = ""; $plink = ""; $ulink = "";
if($log->postid != ""){ 	$plink = get_permalink($log->postid); }
if($log->userid != ""){ $ulink = 'user-edit.php?user_id='.$log->userid; }

$logmessage .= str_replace("(plink)",$plink, str_replace("(ulink)",$ulink,$log->message));
echo $logmessage." <small>(".hook_date($log->datetime).")</small>"; ?>
</td></tr>

<?php }  ?>
</tbody> </table> 



</div>

 
 

</div>
</div>
              
             

<?php } ?>           
             
             
             
             
             
             
             
             
             
             
             
             
             
             
             
             
             
             
             
             
             
             
             
             
             
                            

                            
                        </div><!-- End .box -->
        </div> <!-- End span12 -->
</div>     
      
      
 







 
 
 
<?php hook_admin_0_content(); ?>

</div>  
      
<?php // LOAD IN FOOTER
echo $CORE_ADMIN->FOOTER(); 

  
?>