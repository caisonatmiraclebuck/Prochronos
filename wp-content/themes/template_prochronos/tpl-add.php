<?php
/*
Template Name: [Add Listing]
*/
/* =============================================================================
   [PREMIUMPRESS FRAMEWORK] THIS FILE SHOULD NOT BE EDITED
   ========================================================================== */
if (!defined('THEME_VERSION')) {	header('HTTP/1.0 403 Forbidden'); exit; }
/* ========================================================================== */

global $CORE, $userdata; $GLOBALS['tpl-add'] = true;

// PACKAGE IF
if(!isset($_POST['packageID'])){ $_POST['packageID'] = ""; } 


// GET PACKAGES / MEMBERSHIP LIST DATA
$packagefields 		= get_option("packagefields"); 
$GLOBALS['packagefields'] = $packagefields;
if(!is_array($GLOBALS['packagefields'])){ $GLOBALS['packagefields'] = array(); }

$membershipfields 	= get_option("membershipfields");
$GLOBALS['membershipfields'] = $membershipfields;

// CHECK IF WE ARE FORCING USERS TO REGISTER
if($userdata->ID){

	$GLOBALS['current_membership']			= get_user_meta($userdata->ID,'wlt_membership',true);
    $GLOBALS['current_membership_expires'] 	= get_user_meta($userdata->ID,'wlt_membership_expires',true);
	
	// CHECK IF USER MUST HAVE A MEMBERSHIP PACKAGE ASSIGNED
	if(isset($GLOBALS['CORE_THEME']['requiremembership']) && $GLOBALS['CORE_THEME']['requiremembership'] == 1){
	
		if($GLOBALS['current_membership'] == "" || $GLOBALS['current_membership'] == 0){
			header("location: ".$GLOBALS['CORE_THEME']['links']['myaccount']."/?submissionlimit=1");
			exit();
		}
	}
	
	// CHECK IF WE HAVE ASSIGNED A PACKAGE ID AS PART OF THE USERS MEMBERSHIP
	if(is_numeric($GLOBALS['current_membership']) ){
 
		if(isset($GLOBALS['membershipfields'][$GLOBALS['current_membership']]['package']) && is_numeric($GLOBALS['membershipfields'][$GLOBALS['current_membership']]['package']) ){
		$_POST['packageID'] = $GLOBALS['membershipfields'][$GLOBALS['current_membership']]['package'];
		$GLOBALS['packagefields'][$_POST['packageID']]['price'] = 0; // SET THE PRICE FOR THIS PACKAGE TO 0
		}
	}
 
}

if(get_option('users_can_register') != 1){ $CORE->Authorize(); }

// CHECK FOR 1 LISTING ONLY, IF SO REDIRECT
if(isset($GLOBALS['CORE_THEME']['onelistingonly']) && $GLOBALS['CORE_THEME']['onelistingonly'] == 1 && $userdata->ID && !isset($_GET['eid']) && !isset($_POST['action']) ){

	// SEE IF WE HAVE ANY OTHER LISTINGS ALREADY
	$SQL = "SELECT ID FROM ".$wpdb->prefix."posts WHERE post_type='".THEME_TAXONOMY."_type' and post_status='publish' AND post_author='".$userdata->ID."' ORDER BY ID DESC LIMIT 1";	
	$result = $wpdb->get_results($SQL);
	if(!empty($result)){	
	header("location: ".$GLOBALS['CORE_THEME']['links']['add']."/?eid=".$result[0]->ID);
	exit();
	}
}

 

// CHECK IF WE HAVE ENABLED VISITOR SUBMISSIONS
if(isset($GLOBALS['CORE_THEME']['visitor_submission']) && ( $GLOBALS['CORE_THEME']['visitor_submission'] == 0 && isset($_POST['packageID']) || $GLOBALS['CORE_THEME']['visitor_submission'] == 0 && $CORE->_PACKNOTHIDDEN($packagefields) == 0 ) && !isset($_POST['pakid']) ){ $CORE->Authorize(); } 

//STOP MEMBERSHIPS NON-PAID FOR CREATING LISTINGS
if(isset($GLOBALS['CORE_THEME']['show_mem_registraion']) && $GLOBALS['CORE_THEME']['show_mem_registraion'] == '1' && !isset($_POST['membershipID']) ){
	$TEMPMEMID = get_user_meta($userdata->ID,'new_memID',true);
	if(isset($TEMPMEMID) && is_numeric($TEMPMEMID) && isset($GLOBALS['membershipfields'][$TEMPMEMID]['price']) && $GLOBALS['membershipfields'][$TEMPMEMID]['price'] > 0){
		wp_redirect( $GLOBALS['CORE_THEME']['links']['myaccount']."?submissionlimit=1" ); exit;	
	}
}
 
 
// CHECK IF THE USER HAS REACHED THEIR SUBMISSION LIMIT
if($userdata->ID && !isset($_POST['eid']) && !isset($_GET['eid']) && isset($GLOBALS['current_membership']) && isset($GLOBALS['membershipfields'][$GLOBALS['current_membership']]['submissionamount']) && !isset($_POST['membershipID']) ){
	// COUNT USER SUBMISSIONS
	$current_submissions = $CORE->count_user_posts_by_type( $userdata->ID, THEME_TAXONOMY."_type" );
 
	if( $current_submissions >= $GLOBALS['membershipfields'][$GLOBALS['current_membership']]['submissionamount']){	
	wp_redirect( $GLOBALS['CORE_THEME']['links']['myaccount']."?submissionlimit=1" ); exit;	
	}	 
}

// CHECK FOR CUSTOM LINKS
if(isset($_GET['pakid']) && is_numeric($_GET['pakid'])){ $_POST['packageID'] = $_GET['pakid']; }
 

/* =============================================================================
   USER ACTIONS
   ========================================================================== */ 
if(isset($_POST['action']) && $_POST['action'] !=""){
	switch($_POST['action']){	
 
		case "renewalfree": {
 		
		// 1. GET PACKAGE DATA
		$packagefields = get_option("packagefields");
		
		// 2. FIND OUT EXISTING PACKAGE ID
		$packageID =  get_post_meta($_POST['pid'],'packageID',true);	
		$renewal_days 	= 30;
		
		// 3. GET PRICE AND DATE 
		if(isset($packagefields[$packageID]['expires']) && is_numeric($packagefields[$packageID]['expires']) ){	
			$renewal_days = $packagefields[$packageID]['expires'];	
			if($renewal_days == ""){ $renewal_days = 30; }
		}
		
		// GET CURRENT DATE
		$currentdate = get_post_meta( $_POST['pid'], 'listing_expiry_date', true);
		if($currentdate == ""){ $currentdate = date("Y-m-d H:i:s"); }
		 
		// 3. UPDATE LISTING
		update_post_meta( $_POST['pid'], 'listing_expiry_date', date("Y-m-d H:i:s", strtotime($currentdate . " +".$renewal_days." days")) );
		update_post_meta( $_POST['pid'], 'listing_renewed_dated', date("Y-m-d") );
		if(defined('WLT_AUCTION')){	
		update_post_meta( $_POST['pid'], 'current_bid_data', '' );
		update_post_meta( $_POST['pid'], 'price_current', '0' );
		}
		
		// UPDATE THE LISTING TO MAKE IT ACTIVE
		$my_post = array();
		$my_post['ID'] 			= $_POST['pid'];
		$my_post['post_status'] = "publish";
		wp_update_post( $my_post );	
 		
		// 4. LEAVE A MESSAGE
		$GLOBALS['error_message'] 	= $CORE->_e(array('account','74'));	
		
		} break;
	
		case "save": {
	  
	     // VALIDATION
		if(strlen($_POST['form']['post_title']) < 2){ 		
			$GLOBALS['error_message'] = $CORE->_e(array('add','23')); 		
		}else{
		
		// START FLAG 
		$canContinue = true; $packagefields = get_option("packagefields");
		
		// BLANK OUT THE PACKAGE PRICE FOR MEMBERSHIP LISTINGS
		if(isset($GLOBALS['current_membership']) && !is_string($GLOBALS['current_membership']) && is_numeric($GLOBALS['current_membership'])){
		
			$_POST['packageID'] = $GLOBALS['membershipfields'][$GLOBALS['current_membership']]['package'];
			$packagefields[$_POST['packageID']]['price'] = 0; // SET THE PRICE FOR THIS PACKAGE TO 0
		}		 
		
		// START BUILDING ARRAY OF DATA
		$my_post					= array(); 
		$my_post['post_type']		= THEME_TAXONOMY."_type";
		$my_post['post_title'] 		= esc_html($_POST['form']['post_title']);
		$my_post['post_modified'] 	= date("Y-m-d h:i:s");
		// STRIP TAGS FROM NON-HTML CONTENT LISTINGS
		 
		if( (isset($_POST['eid']) && get_post_meta($_POST['eid'],'html',true) == "yes" ) || 
		( isset($_POST['packageID']) && 
		is_array($packagefields) && 
		!empty($packagefields) && 
		isset($packagefields[$_POST['packageID']]['enhancement']['3']) && 
		$packagefields[$_POST['packageID']]['enhancement']['3'] == 1 ) || 
		( isset($_POST['enhancement'][3]) && $_POST['enhancement'][3] == "on")  ){
		
		$my_post['post_content'] 	= stripslashes($_POST['form']['post_content']);	
		}else{
		
		$my_post['post_content'] 	= stripslashes(strip_tags(str_replace("http://","",str_replace("https://","",$_POST['form']['post_content']))));	
		
		}
		 
  			
		// REMOVE OPTION GROUP
		$newca = array();
		if(is_array($_POST['form']['category'])){
		foreach($_POST['form']['category'] as $cat){
			if(!is_numeric($cat) ){ continue; }
			$newca[] = $cat;
		}
		}
			
		// SAVE	
		$my_post['post_category'] = $newca;	

		// WORK OUT PACKAGE PRICE AND SAVE THIS FOR LATER PAYMENT
		$total_price_due = 0;		
		if(is_array($_POST['enhancement'])){		
			foreach($_POST['enhancement'] as $key=>$val){
			 
				if($val == "on" && is_numeric($GLOBALS['CORE_THEME']['enhancement'][$key.'_price']) ){
					 
					// NOW CHECK ITS NOT INCLUDED IN THE PACKAGE PRICE
					if(isset($packagefields[$_POST['packageID']]['enhancement'][$key]) && 
					$packagefields[$_POST['packageID']]['enhancement'][$key] == "1"  ){}else{
					
					$total_price_due += $GLOBALS['CORE_THEME']['enhancement'][$key.'_price'];
					
					}
				}
			} // end foreach
		}// end if		 
		 
		// WORK OUT ANY ADDITIONAL PRICE PER CATEGORY ITEMS		
		$extra_price_due = 0; $total_price_removed = 0;  $current_catprices = get_option('wlt_catprices'); 
		if(is_array($current_catprices)){	 
			/** work out price before (with newly selected cats) ***/
			foreach($my_post['post_category'] as $kk=>$catID){ 
				if(isset($current_catprices[$catID]) 
					&& ( isset($current_catprices[$catID]) && is_numeric($current_catprices[$catID]) && $current_catprices[$catID] > 0 ) ){				
						$extra_price_due += $current_catprices[$catID];
				}
			}
			
			/*** if were editing we need to remove cats already paid for ***/
			if(isset($_POST['eid'])){		
				$term_list = wp_get_post_terms($_POST['eid'], THEME_TAXONOMY, array("fields" => "ids"));			
				/*** now remove existing ones ***/
				foreach($term_list as $k=>$pc) { 
					if(isset($current_catprices[$pc]) 
						&& ( isset($current_catprices[$pc]) && is_numeric($current_catprices[$pc]) && $current_catprices[$pc] > 0 ) ){
							$total_price_removed += $current_catprices[$pc];
					}
				/*** unset from array ***/
				unset($checkcatsArray[$pk]); 
				} // end foreach				
			}	 
			/*** update the total price with the new amount ***/
			$total_price_due += $extra_price_due;
			 //die("new price: ".$extra_price_due." // price removed:".$total_price_removed);					 
		}// end if
		
		// PACKAGE PRICE ON TOP
		if(isset($_POST['packageID']) && is_numeric($_POST['packageID']) && $_POST['packageID'] != 99){				
			// DONT ADD PRICE ON IF ITS IN MEMBERSHIP			 
			if($GLOBALS['current_membership'] != "" && is_numeric($GLOBALS['current_membership']) && is_array($GLOBALS['membershipfields']) ){	
				if($GLOBALS['membershipfields'][$GLOBALS['current_membership']]['package'] == $_POST['packageID']){					
				}else{
					$total_price_due += $packagefields[$_POST['packageID']]['price'];
				}				
			}else{			
			$total_price_due += $packagefields[$_POST['packageID']]['price'];			
			}
			
			// REDUNCE CATEGORIES IF EXCEEDING AMOUNT
			if($packagefields[$_POST['packageID']]['multiple_cats'] == 0){
			
			$my_post['post_category'] = array($my_post['post_category'][0]);
			
			}elseif(is_numeric($packagefields[$_POST['packageID']]['multiple_cats_amount']) && count($my_post['post_category']) > $packagefields[$_POST['packageID']]['multiple_cats_amount']){
			
				$ecats = $my_post['post_category']; $ncats = array(); $i =0;
				while($i < $packagefields[$_POST['packageID']]['multiple_cats_amount']){				
				$ncats[] = $ecats[$i];
				$i++;
				}			
				$my_post['post_category'] = $ncats;
			}				
		}
		 
		// CHECK AND SET POST STATUS
		if(!isset($_POST['eid'])){
			if( $total_price_due == "" || $total_price_due < 1 ){
			
				$admin_default_status = $GLOBALS['CORE_THEME']['default_listing_status'];
				if($admin_default_status == "pending"){
				$my_post['post_status'] 	= "pending";			
				}else{
				$my_post['post_status'] 	= "publish";
				}
				
			}else{
				$my_post['post_status'] 	= "pending";
			}
		}// end if no edit	
		
		if(isset($GLOBALS['CORE_THEME']['default_listing_approval']) && $GLOBALS['CORE_THEME']['default_listing_approval'] == 1){		
			$my_post['post_status'] 	= "pending";
		}
		
		 
		// IF WE ARE NOT LOGGED IN AND THIS IS A GUEST SUBMISSION
		// CREATE THEM AN ACCOUNT AND ASSIGN THE LISTING TO THEM
		if(!isset($_POST['adminedit'])){
			if( ( !isset($userdata) ) ||  ( isset($userdata) && !$userdata->ID ) ){
			
				// CHECK IF THE USER EXISTS ALREADy
				if ( email_exists($_POST['form']['email']) ){
							
						$user = get_user_by('email', $_POST['form']['email']);
						$user_ID = $user->data->ID;	
						$userdata = $user_ID;
						$canContinue = false;			
						$errorMsg	= $CORE->_e(array('add','52'));
				}else{
				
					// CHECK IF WE HAVE A VALID EMAIL OTHERWISE ASSIGN POST TO ADMIN
					$user_email = $_POST['form']['email'];				
					// CHECK IF USERNAME EXISTS
					$new_user_name = $_POST['form']['new_username']; 
					if ( username_exists( $new_user_name ) ){
					$new_user_name = $_POST['form']['new_username'].date('d'); 
					}				
					// SETUP NEW PASSWORD
					if(isset($_POST['form']['new_password']) && strlen($_POST['form']['new_password']) > 2	){
					$random_password = $_POST['form']['new_password'];
					}else{
					$random_password = wp_generate_password( 12, false );
					}			
				
					// CREATE NEW USER
					$user_ID = wp_create_user( $new_user_name, $random_password, $user_email );
			
					if (!is_wp_error($user_ID)){
						// AUTO LOGIN NEW USER
						$creds = array();
						$creds['user_login'] 	= $new_user_name;
						$creds['user_password'] = $random_password;
						$creds['remember'] 		= true;
						$userdata = wp_signon( $creds, false );	
						 
					}else{
						$errorMsg = $user_ID->get_error_message();
						$canContinue = false;
					}			
				}				
				$my_post['post_author'] 		= $user_ID;
				
				// SEND THE NEW USER THEIR LOGIN DETAILS
				wp_new_user_notification( $user_ID, $random_password );
				// SEND WELCOME EMAIL
				$_POST['password'] = $random_password;
				$CORE->SENDEMAIL($user_ID,'welcome');
				
			}else{
				$my_post['post_author'] 		= $userdata->ID;
			}
		}	// end if is not admin edit
 
		// SAVE THE DATA
		if(isset($_POST['eid'])){
 			$my_post['ID'] 			= $_POST['eid'];
			wp_update_post( hook_add_form_post_save_data($my_post) );	
			$POSTID 				= $_POST['eid'];
			$GLOBALS['PID'] 		= $POSTID;			
			// ADD LOG ENTRY
			$CORE->ADDLOG("<a href='(ulink)'>".$userdata->user_nicename.'</a> update their listing <a href="(plink)"><b>['.$my_post['post_title'].']</b></a>.', $userdate->ID,$_POST['eid'],'label-success');
			
			update_post_meta($POSTID,'pending_message',''); // CLEAR ANY ADMIN MESSAGES SINCE WE'VE EDITED	
			
			// SEND EMAIL ALERT
			$CORE->SENDEMAILALERT("wlt_alert_listing_edit");			
			 
		}else{
			$POSTID 				= wp_insert_post( hook_add_form_post_save_data($my_post) );
			$GLOBALS['PID'] 		= $POSTID;
			// ADD IN DEFAULT ACCES IF SET
			if(isset($GLOBALS['CORE_THEME']['default_access']) && is_array($GLOBALS['CORE_THEME']['default_access'])){
			add_post_meta($POSTID, 'access', $GLOBALS['CORE_THEME']['default_access']);
			}
			// DEFAULT FOR NEW LISTINGS
			add_post_meta($POSTID, 'hits', 0);			
			// CREATE SHORTCODES FOR EMAIL			 
			$_POST['title'] 	= $_POST['form']['post_title'];
			$_POST['link'] 		= get_permalink($POSTID);
			$_POST['post_date'] = hook_date(date("Y-m-d h:i:s"));
			 				
			// SEND NEW LISTING EMAIL
			$CORE->SENDEMAIL($userdata->user_email,'newlisting');	
			$CORE->SENDEMAIL('admin','admin_newlisting');
			
			// SEND EMAIL ALERT
			$CORE->SENDEMAILALERT("wlt_alert_listing_new");
			
			// CHECK FOR USER SUBSCRIPTION EMAILS
			if(is_array($my_post['post_category']) && $userdata->ID ){			 
			foreach($my_post['post_category'] as $kk=>$catID){
				$SQL = "SELECT user_id FROM $wpdb->usermeta WHERE meta_value LIKE ('%*".strip_tags($catID)."*%') AND meta_key='email_subscriptions'";				 		
				$sub_results = $wpdb->get_results($SQL);
				 
				if (!empty($sub_results) ) {				
					foreach($sub_results as $val){
						$user_info = get_userdata($val->user_id);
						$_POST['username'] = $user_info->first_name . ' ' . $user_info->last_name;				
						$CORE->SENDEMAIL($val->user_id,'subscription_email');				
					}				
				}
			}
			}
			
			// ADD LOG ENTRY
			$CORE->ADDLOG("<a href='(ulink)'>".$userdata->user_nicename.'</a> added a new listing <a href="(plink)"><b>['.$my_post['post_title'].']</b></a>.', $userdata->ID, $POSTID ,'label-info');					 		
		}
		
		// IF ITS PENDING SEND THE ADMIN AN EMAIL
		if($my_post['post_status'] == "pending"){
		$CORE->SENDEMAIL('admin','custom',"Listing Pending Approval", "Dear Admin, You have listings pending approval. Please login to your WordPress admin area and approval pending listings.");
		}
		
		// POST TAGS 
		wp_set_post_tags( $POSTID, strip_tags($_POST['custom']['post_tags']), false);		 
 
		// ADD HOOK FOR ANY PLUGIN OPTIONS
		hook_add_form_post_save_extra($POSTID);
		
		// UPDATE CAT LIST
		wp_set_post_terms( $POSTID, $my_post['post_category'], THEME_TAXONOMY );		
		
		// ADD IN CUSTOM FIELDS		
		update_post_meta($POSTID, 'packageID', $_POST['packageID']);
		update_post_meta($POSTID, 'listing_price', $total_price_due);
		
		// IF IS MEMBERSHIP THEN SET THE PRICE TO 0
		if(is_numeric($GLOBALS['current_membership']) && $total_price_due == 0){
		update_post_meta($POSTID, 'listing_price_paid', 0);
		}
		
		// MAKE THIS GLOBAL FOR BOTH EDIT AND NON-EDITS BELOW
		$earray = array(				 
				'2' => array('dbkey'=>'featured',		'text'=>'Highlighted Listing'),
				'3' => array('dbkey'=>'html',			'text'=>'HTML Listing Content'), 
				'4' => array('dbkey'=>'visitorcounter',	'text'=>'Visitor Counter'),
				'5' => array('dbkey'=>'topcategory',	'text'=>'Top of Category Results Page'),
				'6' => array('dbkey'=>'showgooglemap',	'text'=>'Google Map'),
		);	
	 
		// CUSTOM FIELDS FOR enhancementS
		if(!isset($_POST['eid'])){		
		
			$onoff = array();
			if(is_array($_POST['enhancement']) && isset($_POST['enhancement'][1]) && $_POST['enhancement'][1] == "on" ){ $onoff[1] = "yes"; }else{ $onoff[1] = "no"; }
			if(is_array($_POST['enhancement']) && isset($_POST['enhancement'][2]) && $_POST['enhancement'][2] == "on" ){ $onoff[2] = "yes"; }else{ $onoff[2] = "no"; }
			if(is_array($_POST['enhancement']) && isset($_POST['enhancement'][3]) && $_POST['enhancement'][3] == "on" ){ $onoff[3] = "yes"; }else{ $onoff[3] = "no"; }
			if(is_array($_POST['enhancement']) && isset($_POST['enhancement'][4]) && $_POST['enhancement'][4] == "on" ){ $onoff[4] = "yes"; }else{ $onoff[4] = "no"; }
			if(is_array($_POST['enhancement']) && isset($_POST['enhancement'][5]) && $_POST['enhancement'][5] == "on" ){ $onoff[5] = "yes"; }else{ $onoff[5] = "no"; }
			if(is_array($_POST['enhancement']) && isset($_POST['enhancement'][6]) && $_POST['enhancement'][6] == "on" ){ $onoff[6] = "yes"; }else{ $onoff[6] = "no"; }
			// LETS CHECK TO SEE IF WE HAVE ANY ENABLED BY DEFAULT AND IF THE DISPLAY IT TURNED OFF
			if( $GLOBALS['CORE_THEME']['show_enhancements'] != '1' && isset($_POST['packageID']) ){ // display is off so we do it manually
				foreach($earray as $key=>$val){
					if(is_array($packagefields) && !empty($packagefields) && isset($packagefields[$_POST['packageID']]['enhancement'][$key]) && $packagefields[$_POST['packageID']]['enhancement'][$key] == "1"){ 
					$onoff[$key] = "yes";
					}elseif( is_numeric($GLOBALS['current_membership']) && isset($GLOBALS['membershipfields'][$GLOBALS['current_membership']]['enhancement'][$key]) && $GLOBALS['membershipfields'][$GLOBALS['current_membership']]['enhancement'][$key] == "1"){
					$onoff[$key] = "yes";
					}
				}
			}			
		 
			// NOW LETS UPDATE THE POST FIELDS	 
			update_post_meta($POSTID, 'featured', 		$onoff[2]); // featured
			update_post_meta($POSTID, 'html', 			$onoff[3]); // html content
			update_post_meta($POSTID, 'visitorcounter', $onoff[4]); // visitor counter
			update_post_meta($POSTID, 'topcategory', 	$onoff[5]); // visitor counter
			update_post_meta($POSTID, 'showgooglemap', 	$onoff[6]); // visitor counter
			
			update_post_meta($POSTID, 'listing_price_due', $total_price_due);
			 
		}else{
	 
			// UPDATING AND POSSIBLY ADDING EXTRA FEATURES TO AN EXISTING LISTING
			if(isset($_POST['upgradepakid']) && is_numeric($_POST['upgradepakid'])){
				$existing_total_due = $total_price_due;
			}else{
				$existing_total_due = get_post_meta($POSTID,'listing_price_due',true);
				// NOW REMOVE ANY CHANGES MADE BY THE USER
				$existing_total_due = $existing_total_due -$total_price_removed;	 
				// NOW LETS ADD-ON ANY CHANGES MADE BY THE USER
				$existing_total_due = $existing_total_due + $extra_price_due;				
			}	
							
			// LOOP PACKAGE DATA WHEN THE enhancement ARE VISIBLE
			// TO THE USER AND THEREFORE STORED IN POST DATA  
			if(is_array($_POST['enhancement']) && !isset($_POST['upgradepakid']) ){	 
				
				foreach($earray as $key=>$val){ 		
					if(is_array($_POST['enhancement']) && isset($_POST['enhancement'][$key]) && $_POST['enhancement'][$key] == "on" && get_post_meta($POSTID, $val['dbkey'], true) != "yes" ){ 
						update_post_meta($POSTID, $val['dbkey'], 'yes');
						$existing_total_due += $GLOBALS['CORE_THEME']['enhancement'][$key.'_price'];						
					}elseif( is_array($_POST['enhancement']) && isset($_POST['enhancement'][$key]) && $_POST['enhancement'][$key] == "on" && get_post_meta($POSTID, $val['dbkey'], true) == "yes" ){
										 
					}elseif( !isset($_POST['enhancement'][$key])  && get_post_meta($POSTID, $val['dbkey'], true) == "yes" ){ 
						update_post_meta($POSTID, $val['dbkey'], 'no');
						$existing_total_due -= $GLOBALS['CORE_THEME']['enhancement'][$key.'_price'];
					}
				} // end foreach				
			 
			 }elseif(isset($_POST['upgradepakid']) ){ //!is_array($_POST['enhancement']) && 
			  
			 	foreach($earray as $key=>$val){ 	
			 
					if($packagefields[$_POST['upgradepakid']]['enhancement'][$key] == 1){
					update_post_meta($POSTID, $val['dbkey'], 'yes');
					}else{
					update_post_meta($POSTID, $val['dbkey'], 'no');
					}
				} // end foreach				  
			 
			 }		
			 
			// JUST ENCASE
			if($existing_total_due < 0){ $existing_total_due = 0; }
			// SAVE NEW PRICE
			update_post_meta($POSTID, 'listing_price_due', $existing_total_due);			
			// SET LISTING TO PENDING PAYMENT
			 	 
			if(is_numeric($existing_total_due) && $existing_total_due > 0){
				$new_status = "pending";
			}else{
				if(get_post_status ( $_POST['eid'] ) == "pending"){
				$new_status = "pending";
				}else{
				$new_status = "publish";
				}
				
			}

			$my_post = array();
			$my_post['ID'] 					= $POSTID;
			$my_post['post_status']			= $new_status;		
			wp_update_post( $my_post  );			 
		}
		
		// SET EXPIRY DATE
	 //echo "<pre>"; print_r($packagefields); echo "</pre>";
		if(isset($_POST['custom']['listing_expiry_date']) && is_numeric($_POST['custom']['listing_expiry_date'])){
		
			update_post_meta($POSTID, 'listing_expiry_date', date("Y-m-d H:i:s", strtotime(date("Y-m-d H:i:s") . " +".$_POST['custom']['listing_expiry_date']." days")));
			update_post_meta($POSTID, 'listing_expiry_days', $_POST['custom']['listing_expiry_date']);
		
		}elseif(isset($_POST['packageID']) && $_POST['packageID'] != 99 && isset($packagefields[$_POST['packageID']]) && is_numeric($packagefields[$_POST['packageID']]['expires']) && !isset($_POST['eid']) ){
			$length = $_POST['custom']['auctionlength'];
			$length = explode(' ',$length);
			if($packagefields[$_POST['packageID']]['name'] === 'Fast Auction'){
				update_post_meta($POSTID, 'listing_expiry_date', date("Y-m-d H:i:s", strtotime(date("Y-m-d H:i:s") . " +".$length[0]." hours")));
			} else {
				update_post_meta($POSTID, 'listing_expiry_date', date("Y-m-d H:i:s", strtotime(date("Y-m-d H:i:s") . " +".$length[0]." days")));
			}
			//update_post_meta($POSTID, 'listing_expiry_date', date("Y-m-d H:i:s", strtotime(date("Y-m-d H:i:s") . " +".$packagefields[$_POST['packageID']]['expires']." days")));
		}		

 		// SAVE THE CUSTOM DATA
		if(isset($_POST['custom']) && is_array($_POST['custom'])){ 		 
			foreach($_POST['custom'] as $key=>$val){ if($key == "listing_expiry_date"){ continue; }
				// CLEAN SOME ATTRIBUTES
				if(substr($key,0,5) == "price"){
					$val = preg_replace('/[^\da-z.]/i', '', $val);
				}
				// SAVE DATA
				if(is_array($val)){
						update_post_meta($POSTID, strip_tags($key), $val);
				}else{
						update_post_meta($POSTID, strip_tags($key), esc_html(strip_tags($val)));
				}
			}
		}
		 
			
		// SAVE THE TAXONOMY DATA
		if(isset($_POST['tax']) && is_array($_POST['tax'])){ 		 
			foreach($_POST['tax'] as $key=>$val){
			
				// CHECK IF ITS A NEW VALUE
				if(substr($val,0,11) == "newtaxvalue" ){
			
					$newcatID = str_replace("newtaxvalue_","", $val);
				
					if ( is_term( $newcatID , $key ) ){				 
						 $term = get_term_by('name', str_replace("_"," ",$newcatID), $key);
						 $val = $term->term_id;						 
					}else{
					
						// FIX FOR MAKE/MODEL GET PARENT ID
						$parentID = 0;
						if($key == "model"){						
							$parentID = $_POST['tax']['make'];
						}
						
						$args = array('cat_name' => str_replace("_"," ",$newcatID), "parent" => $parentID  ); 
						$term = wp_insert_term( str_replace("_"," ",$newcatID), $key, $args);
						if(isset($term['term_id'])){
							$val = $term['term_id'];
						}else{
							$val = $term->term_id;
						}
					}					
										
				}			
				
				// SAVE DATA
				wp_set_post_terms( $POSTID, $val, $key );
			}
		}
	 
		// CHECK FOR FILE UPLOAD
		if(isset($_FILES['image']) && is_array($_FILES['image']) ){	 // && 
		 	$u=0;
			foreach($CORE->reArrayFiles($_FILES['image']) as $file_upload){			
				if(strlen($file_upload['name']) > 1){
					if(isset($_POST['eid']) || $u == 0){
						$responce = hook_upload($POSTID, $file_upload,true);
					}else{
						$responce = hook_upload($POSTID, $file_upload);
					}
					if(isset($responce['error'])){
						$canContinue = false;			
						$errorMsg = $responce['error'];
					}// end if
					$u++;
				} // end if			
			} // end foeach
		} // end if
		
		$GLOBALS['POSTID'] = $POSTID;
		do_action('hook_add_form_post_save');		
		
		// REDIRECT LINK 	
  		$redirect = get_permalink($POSTID);
				 
		// REDIRECT TO NEXT PAGE
 		if($canContinue && $redirect != ""){
			header("location: ".$redirect);
			exit();
		}else{
		
			$GLOBALS['error_message'] = $errorMsg;
		
		}
		
		} // end invalid listing 	
					
		} break;
	
	}// end switch

}// end if
   


/* =============================================================================
  end  USER ACTIONS
   ========================================================================== */    

 

// REMOVE SIDEBARS
$GLOBALS['nosidebar-left'] = true; $GLOBALS['nosidebar-right'] = true;

// ADD-ON PLAYER FILES ENCASE WE HAVE VIDEO
wp_enqueue_script('video', FRAMREWORK_URI.'player/mediaelement-and-player.min.js');
wp_enqueue_script('video');

wp_register_script( 'googlemap',  $CORE->googlelink());
wp_enqueue_script( 'googlemap' ); 
 
//DISPLAY HEADER
get_header($CORE->pageswitch());

// HOOK PACKAGES BEFORE
hook_packages_before();
 
?>


 
<?php if($_POST['packageID'] == "" && $GLOBALS['current_membership'] == "" && !isset($_GET['eid']) && $GLOBALS['CORE_THEME']['pricing_table'] ==1 ){ ?>

	<?php get_template_part('add', 'table' ); ?>

<?php }else{ ?>

<div class="row">

    <div class="col-md-4 col-sm-4 pull-left adminedit1">
    
        <?php get_template_part('add', 'packages' ); ?>  
    
    </div>
    
    <div class="col-md-8 col-sm-8 col-xs-12 pull-right adminedit2">
    
        <?php get_template_part('add', 'form' ); ?>    
    
    </div>
    
</div>
<?php } ?>

<?php if(isset($_GET['mediaonly'])){ ?>
<style>
.savebuttonarea, .adminedit1, #footer { display:none; }
.adminedit2 { width:100%; }
</style>
<?php } ?> 

<?php 

// DISPLAY FOOTER
get_footer($CORE->pageswitch()); ?>
