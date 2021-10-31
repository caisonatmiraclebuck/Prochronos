<?php
// TELL THE CORE THIS IS A CHILD THEME
define("WLT_CHILDTHEME", true);

// CHILD THEME LAYOUT SETTINGS
function childtheme_designchanges(){
				
				// LOAD IN CORE STYLES AND UNSET THE LAYOUT ONES SO OUR CHILD THEME DEFAULT OPTIONS CAN WORK
				$core_admin_values = get_option("core_admin_values"); 
			 
					// SET HEADER
					$core_admin_values["layout_header"] = "4";
					// SET MENU
					$core_admin_values["layout_menu"] = "4";
					// SET RESPONISVE DESIGN
					$core_admin_values["responsive"] = "1";
					// SET COLUMN LAYOUTS
					$core_admin_values["layout_columns"] = array('homepage' => '3', 'search' => '2', 'single' => '2', 'page' => '2', 'footer' => '5', '2columns' => '0', 'style' => 'fluid', '3columns' => '');
					// SET WELCOME TEXT
					$core_admin_values["header_welcometext"] = "Your own text here.";        
					// SET RATING
					$core_admin_values["rating"] 		= "1";
					$core_admin_values["rating_type"] 	= "1";
					// BREADCRUMBS
					$core_admin_values["breadcrumbs_inner"] 	= "0";
					$core_admin_values["breadcrumbs_home"] 		= "0"; 
					// TURN OFF CATEGORY DESCRIPTION
					$core_admin_values["category_descrition"] 	= "1";	
					// GEO LOCATION
					$core_admin_values["geolocation"] 	= "1";
					$core_admin_values["geolocation_flag"] 	= "";
					// FOOTER SOCIAL ICONS
					$core_admin_values["social"] 	= array(
					'twitter' => '##', 'twitter_icon' => '', 
					'facebook' => '##', 'facebook_icon' => '', 
					'dribbble' => '', 'dribbble_icon' => '', 
					'linkedin' => '##', 'linkedin_icon' => '', 
					'youtube' => '##', 'youtube_icon' => '', 
					'rss' => '##', 'rss_icon' => '',         
					);
					// FOOTER COPYRIGHT TEXT
					$core_admin_values["copyright"] 	= "&copy; Copyright 2017 - http://prochronos.studioluc.nl";
					// HOME PAGE OBJECT SETUP
					$core_admin_values["homepage"]["widgetblock1"] = "image3_0,tabs_1";	
					
$core_admin_values['widgetobject']['image3']['0'] = array(
'text' => "<div class='row'><div class='col-md-3 col-sm-3'>[D_CATEGORIES title='Categories' show_count='1']</div><div class='col-md-9 col-sm-9 hidden-xs'><a href='http://www.premiumpress.com/wordpress-auction-theme/'><img src='http://prochronos.studioluc.nl/wp-content/themes/studioluc/templates/template_auction_theme/img/demo/slide1.jpg' alt='join' class='img-responsive wltatt_id'></a><div class='row' style='margin-top:20px;'><div class='col-md-6 col-sm-6'><a href='http://prochronos.studioluc.nl/?wp-login.php?action=register'><img src='http://prochronos.studioluc.nl/wp-content/themes/studioluc/templates/template_auction_theme/img/demo/a1.jpg' alt='' class='img-responsive wltatt_id' style='border:1px solid #ddd;' /></a></div><div class='col-md-6 col-sm-6'><a href='http://prochronos.studioluc.nl/?wp-login.php?action=register'><img src='http://prochronos.studioluc.nl/wp-content/themes/studioluc/templates/template_auction_theme/img/demo/a2.jpg' alt='' class='img-responsive wltatt_id' style='border:1px solid #ddd;' /></a></div></div></div></div>",
'fullw' => "yes",
);
$core_admin_values['widgetobject']['tabs']['1'] = array(
'title1' => "Recently Added",
'query1' => "order=desc&orderby=rand&posts_per_page=10",
'spanclass1' => "span3",
'title2' => "Going Soon",
'query2' => "order=desc&orderby=rand&posts_per_page=10",
'title3' => "Most Popular",
'query3' => "order=desc&orderby=rand&posts_per_page=10",
'fullw' => "yes",
'perrow' => "5",
);	
					// SET ITEMCODE
					$core_admin_values["itemcode"] 	= "";
					// SET LISTING PAGE CODE
					$core_admin_values["listingcode"] 	= "";
					// SET PRINT PAGE CODE
					$core_admin_values["printcode"]  = "";						
					// RETURN VALUES
					return $core_admin_values;
}
// FUNCTION EXECUTED WHEN THE THEME IS CHANGED
function _after_switch_theme(){
	// SAVE VALUES
	update_option("core_admin_values",childtheme_designchanges());		
}
add_action("after_switch_theme","_after_switch_theme");
// DEMO MODE
if(defined("WLT_DEMOMODE")){ 
	$GLOBALS["CORE_THEME"] = childtheme_designchanges();
}
/*
 * Adding the column
 */
function rd_user_id_column( $columns ) {
	$columns['user_id'] = 'ID';
	return $columns;
}
add_filter('manage_users_columns', 'rd_user_id_column');
 
/*
 * Column content
 */
function rd_user_id_column_content($value, $column_name, $user_id) {
	if ( 'user_id' == $column_name )
		return $user_id;
	return $value;
}
add_action('manage_users_custom_column',  'rd_user_id_column_content', 10, 3);
 
/*
 * Column style (you can skip this if you want)
 */
function rd_user_id_column_style(){
	echo '<style>.column-user_id{width: 5%}</style>';
}
add_action('admin_head-users.php',  'rd_user_id_column_style');


// HOOK IN LANGUAGE TEXT
	add_action('hook_language_array', '_hook_language_array_cust' );
	
		function _hook_language_array_cust($c){
			$d = array(
			"1" 			=> __("Listing Packages","premiumpress"),
			"2" 			=> __("More Info","premiumpress"),		
			"3" 			=> __("Subscribe","premiumpress"),		
			"4" 			=> __("Close","premiumpress"),		
			"5" 			=> __("Listing Details","premiumpress"),			
			"6" 			=> __("Package","premiumpress"),		
			"7" 			=> __("How does this work?","premiumpress"),
			"8" 			=> __("Once you have completed the options below your new listing will be created but <b>will not go live</b> until payment has been received. This gives you time to check, modify and preview the listing before payment.","premiumpress"),		
			"9" 			=> __("Contact Email","premiumpress"),		
			"10" 			=> __("Title","premiumpress"),
			"11" 			=> __("Tag line","premiumpress"),
			"12" 			=> __("Description","premiumpress"),
			"13" 			=> __("Category","premiumpress"),
			"14" 			=> __("Display File","premiumpress"),
			"15" 			=> __("<strong>Notice</strong>  Once your listing has been saved you will be able to upload additional images.","premiumpress"),
			"16" 			=> __("Publish listing","premiumpress"),			
			"17" 			=> __("Media Manager","premiumpress"),		
			"18" 			=> __("Add files...","premiumpress"),
			"19" 			=> __("Upload All","premiumpress"),
			"20" 			=> __("Start","premiumpress"),		
			"21"			=> __("Cancel","premiumpress"),		
			"22"			=> __("Error","premiumpress"),
			"23"			=> __("Please provide more details, your listing is too short.","premiumpress"),		
			"24"			=> __("Membership Packages","premiumpress"),		
			"25"			=> __("Our membership packages let you submit multiple listings.","premiumpress"),		
			"26"			=> __("Per Listing Packages","premiumpress"),		
			"27"			=> __("Our per listing packages let you pay for each listing separately.","premiumpress"),		
			"28"			=> __("All listings are removed once the listing or membership has expired unless renewed beforehand.","premiumpress"),		
			"29"			=> __("Saving Your Changes","premiumpress"),		
			"30"			=> __("This may take a few minutes so please wait...","premiumpress"),		
			"31"			=> __("Listing Enhancements","premiumpress"),		
			"32"			=> __("Enhance your listing with any of the additional features below;","premiumpress"),		
			"33"			=> __("Total Payment","premiumpress"),		
			"34"			=> __("for a %a day listing.","premiumpress"),	
			"34b"			=> __("for an <b>extra</b> %a day listing.","premiumpress"),	
			"34a"			=> __("for a %a day membership.","premiumpress"),	
			"35"			=> __("Account Creation","premiumpress"),		
			"36"			=> __("If you are already a member please login otherwise we will auto create a new account for you with the email address you provide above.","premiumpress"),		
			"37"			=> __("Location","premiumpress"),		
			"38"			=> __("Click on the map below to zoom in and place a market on the location of your item or company.","premiumpress"),		
			"39"			=> __("Please select a valid location on the map.","premiumpress"),		
			"40"			=> __("Front Page Exposure","premiumpress"),			
			"41"			=> __("Featured Listing","premiumpress"),
			"42"			=> __("HTML Listing Content","premiumpress"),
			"43"			=> __("Visitor Counter","premiumpress"),
			"44"			=> __("Top of Category","premiumpress"),
			"45"			=> __("Google Map","premiumpress"),				
			"40d"			=> __("Purchase this listing enhancement and see your listing featured on our home page! 
				<p> Our home page listings generate 60% more exposure and is a great way to get your listing seen by more visitors.</p>","premiumpress"),			
			"41d"			=> __("Purchase this listing enhancement and see your listing highlighted in search results! <p> What better way to get your listing seen by visitors searching the website than with a highlighted listing standing out above the rest!</p>","premiumpress"),
			"42d"			=> __("Purchase this listing enhancement and bring your listing to life with HTML content! <p> Customize your listing description with your own formatting, content and images with this feature.</p>","premiumpress"),
			"43d"			=> __("Purchase this listing enhancement and we'll monitor your listing visits. <p>Find out which of your listings is performing better with our visitor counter which will record all clicks on your listings and display then to you (visible to you only) at the bottom of your listings.</p>","premiumpress"),
			"44d"			=> __("Purchase this listing enhancement and we'll feature your listing at the top of your chosen category pages.<p> This great feature will bring more exposure to your listing. Whenever a user searches a chosen category your listing will appear before all others at the top.</p>","premiumpress"),
			"45d"			=> __("Purchase this listing enhancement and we'll display a map on your listing page.","premiumpress"),
			"46"			=> __("You current map location is;","premiumpress"),
			"47"			=> __("Country","premiumpress"),
			"48"			=> __("State/Province","premiumpress"),
			"49"			=> __("City","premiumpress"),
			"50"			=> __("<b>File Attachments</b> <br /> 
			Once saved, new options will be available for you to upload file attachments.","premiumpress"),		
			"51"			=> __("Please enter your location.","premiumpress"),
			"52"			=> __("We have detected you already have an account with us. Please login to your existing account to edit/modify your listings.","premiumpress"),		
			"53"			=> __("Select Payment Method","premiumpress"), 
			"54"			=> __("Enter your physical location here.","premiumpress"), 
			"55"			=> __("included","premiumpress"), 
			"56"			=> __("Free","premiumpress"),		
			"57"			=> __("Account Upgraded","premiumpress"), 
			"58"			=> __("Your account has been upgraded to this new membership.","premiumpress"), 
			"59"			=> __("Never Expires","premiumpress"), 
			"60"			=> __("Upgrade Options","premiumpress"),
			"61"			=> __("Acceptable File Formats: jpg/.gif/.png/.pdf/.flv/.mp4/.mp3","premiumpress"), 
			"62"			=> __("Upto %a Listings","premiumpress"),
			"63"			=> __("Listing Description","premiumpress"),
			"64"			=> __("Listing Category","premiumpress"),
			"65"			=> __("Listing Attachments","premiumpress"),
			"66"			=> __("Listing Details","premiumpress"),
			"67"			=> __("Listing Location","premiumpress"),
			"68"			=> __("Display Image","premiumpress"),
			"69"			=> __("Listing Information","premiumpress"),
			"70"			=> __("None Set","premiumpress"),
			"71"			=> __("Keywords","premiumpress"),
			"72"			=> __("Enter a value below to create a new option.","premiumpress"),
			"73"			=> __("Separate each keyword with a comma.","premiumpress"),
			"74"			=> __("Display Order","premiumpress"),		
			"75"			=> __("Parent Category <small class='right'>Hold CTRL to select multiple categories</small>","premiumpress"),
			"76"			=> __("Sub Category","premiumpress"),
			"77"			=> __("Sub Sub Category","premiumpress"),
			"78"			=> __("Sub Sub Sub Category","premiumpress"),
			"79"			=> __("<b>Parent Category Disabled.</b> Listings will only appear in sub categories.","premiumpress"),
			"80"			=> __("You have selected too many categories. Only the first %a will be saved.","premiumpress"),
			"81"			=> __("maximum categories.","premiumpress"),
			"82"			=> __("selected.","premiumpress"),
			"83"			=> __("You can select up to %a media files.","premiumpress"),		
			"84"			=> __("add images","premiumpress"),
			"85"			=> __("add videos","premiumpress"),
			"86"			=> __("add music","premiumpress"),
			"87"			=> __("add docs","premiumpress"),
			"88"			=> __("Edit Media","premiumpress"),
			"89"			=> __("all files","premiumpress"),
			"90"			=> __("images only","premiumpress"),
			"91"			=> __("videos only","premiumpress"),
			"92"			=> __("music only","premiumpress"),
			"93"			=> __("docs only","premiumpress"),
			"94"			=> __("Listing:","premiumpress"),		
			"95"			=> __("Minimum of %a characters.","premiumpress"),	
			"96"			=> __("characters remaining.","premiumpress"),		
			"97"			=> __("Edit Listing","premiumpress"),	
			"98"			=> __("You can edit your details listing below.","premiumpress"),	
			"99"			=> __("Type in a title that best describes your watch, this title will appear on the display of the listing","premiumpress"),
			"100"			=> __("Type in any specific information that buyers need to know about this watch.","premiumpress"),
		); 
	
		$c['english']['add'] = $d;
		
		$l = array(	
			"1" 		=> __("Member Login","premiumpress"),
			"2" 		=> __("Not yet a member?","premiumpress"),
			"3" 		=> __("Click here to register a new account.","premiumpress"),
			"4" 		=> __("Submit","premiumpress"),
			"5" 		=> __("Forgotten Password?","premiumpress"),
			"6" 		=> __("Register New Account","premiumpress"),
			"7" 		=> __("A password will be emailed to you.","premiumpress"),
			"8" 		=> __("Enter your username or email below;","premiumpress"),
			"9" 		=> __("Send me a new password","premiumpress"),
			"10" 		=> __("Username","premiumpress"),		
			"11" 		=> __("<h1>Account Pending</h1><p>Your account is still under review, once approved you will be able to login.</p>","premiumpress"),
			"12" 		=> __("<h1>Account Suspended</h1><p>We are sorry but your account has been suspended.</p>","premiumpress"),
			"13" 		=> __("<h1>You're Fired!!</h1><p>We are sorry but your account has been terminated and you are now fired.</p>
			","premiumpress"),		
			"14" 		=> __("<strong>ERROR</strong>: You didn't correctly enter the captcha, please try again.","premiumpress"),		
			"15" 		=> __("Enter your account username or email below and we will send you a new password.","premiumpress"),	 	 
			"16" 		=> __("Complete the fields below to register a new account. Your login username and password will be sent to the email address you enter below.","premiumpress"),			
			"17" 		=> __("Please Try Again","premiumpress"),
			"18" 		=> __("Create Account","premiumpress"),		
			"19" 		=> __("Select","premiumpress"),				
			"20" 		=> __("Selected","premiumpress"),						
			"_zz1" 					=> __("Type the code above:","premiumpress"),
			"_zz2" 					=> __("A password will be e-mailed to you.","premiumpress"),
			"_zz3" 					=> __("Username or Email:","premiumpress"),
			"_zz4" 					=> __("Get New Password","premiumpress"),
			"_zz5" 					=> __("Please enter your username or e-mail address. You will receive a new password via e-mail.","premiumpress"),
			"_zz6" 					=> __("Sorry, that key does not appear to be valid.","premiumpress"),
			"_zz7" 					=> __("You are now logged out.","premiumpress"),
			"_zz8" 					=> __("User registration is currently not allowed.","premiumpress"),
			"_zz9" 					=> __("Check your e-mail for the confirmation link.","premiumpress"),
			"_zz10" 				=> __("Check your e-mail for your new password.","premiumpress"),
			"_zz11" 				=> __("Registration Successfull.<br>An email has been sent to the site administrator. The administrator will review the information that has been submitted. You will receive an email with instructions on what you will need to do next. Thank you for your patience.","premiumpress"),
			"reg1" 		=> __("Account Login Details","premiumpress"),
			"21" 		=> __("The validation answer is incorrect","premiumpress"),
			"22" 		=> __("We are protecting ourselves from spam,<a href='%a'> please click here to register. </a>","premiumpress"),
			
			"23" 		=> __("Already a Member?","premiumpress"),	
			"24" 		=> __("Get started now. Login to your account.","premiumpress"),	
			"25" 		=> __("New to our website?","premiumpress"),	
			"26" 		=> __("Get started now. It's fast and easy.","premiumpress"),	
			"27" 		=> __("New Password","premiumpress"),
			
			"28" 		=> __("Confirm new password","premiumpress"),	
			"29" 		=> __("Reset Password","premiumpress"),
			
			"30" 		=> __("Membership Options","premiumpress"),
			"31" 		=> __("Please select a membership package from the list below.","premiumpress"),
			"32" 		=> __("Please select a membership package.","premiumpress"),
			"33" 		=> __("The login credentials you entered were incorrect.","premiumpress"), 				
		);
		
		$c['english']['login'] = $l;
		return $c;
	
	}
	
	
/****************** N-GYS ***********************/	
	// Hook For Removing some of default fields
	function remove_parent_function(){
		remove_action('init', '_hook_customfields',1,1);
		remove_action('hook_add_fieldlist', '_hook_customfields',1,1);
	}
	add_action('after_setup_theme', 'remove_parent_function',1,0);
	
	
	function _hook_customfields_cust($c){ 
		global $CORE;
		$o = 50;
		$canEditPrice = true;
		//print_r($_GET['eid']);
		if(isset($_GET['eid'])){ 
		
			// CHECK FOR BIDDING SO WE CAN DISABLE FIELDS
			$current_bidding_data = get_post_meta($_GET['eid'],'current_bid_data',true); 
			if(is_array($current_bidding_data) && !empty($current_bidding_data) ){ $canEditPrice = false; }
		
		}
		

		
		if(isset($GLOBALS['CORE_THEME']['auction_buynow']) && $GLOBALS['CORE_THEME']['auction_buynow'] == '1'){ 
		
			$c[$o]['title'] 	= $CORE->_e(array('auction','4'));
			$c[$o]['name'] 		= "auction_type";
			$c[$o]['type'] 		= "select";
			$c[$o]['class'] 	= "form-control";
			$c[$o]['listvalues'] 	= array("1" => $CORE->_e(array('auction','5')), "2" => $CORE->_e(array('auction','6')));
			$c[$o]['help'] 		= $CORE->_e(array('auction','7'))." <script type='text/javascript'>jQuery(document).ready(function(e){
			jQuery('#form-row-rapper-price_bin').find('.required').css('display','none');
			jQuery('#form_auction_type').change(function(e) { if(jQuery('#form_auction_type').val() == '2'){ jQuery('#form-row-rapper-price_current').hide(); jQuery('#form-row-rapper-price_reserve').hide(); jQuery('#form-row-rapper-price_bin').css('display','block');} else { jQuery('#form-row-rapper-price_reserve').show();  jQuery('#form-row-rapper-price_current').show(); jQuery('#form-row-rapper-price_bin').css('display','none'); } }); }); </script> ";
			//$c[$o]['required'] 	= true;
			$c[$o]['defaultvalue'] 	= "0";
		
		}else{
		
			$c[$o]['title'] 	= $CORE->_e(array('auction','4'));
			$c[$o]['name'] 		= "auction_type";
			$c[$o]['type'] 		= "hidden";
			$c[$o]['class'] 	= "form-control";
			$c[$o]['values'] 	= 1;
					
		}
		
		$o++;

		
		if($canEditPrice){
			$c[$o]['title'] 	= $CORE->_e(array('auction','74'));
			$c[$o]['name'] 		= "price_current";
			$c[$o]['type'] 		= "price";
			$c[$o]['class'] 	= "form-control";
			$c[$o]['help'] 		= $CORE->_e(array('auction','75'));
			$c[$o]['required'] 	= true;	
			$c[$o]['defaultvalue'] 	= "0";	
			$o++;
		}
		 
		
		if(isset($GLOBALS['CORE_THEME']['auction_buynow']) && $GLOBALS['CORE_THEME']['auction_buynow'] == '1'){
		
		if($canEditPrice){
			$c[$o]['title'] 	= $CORE->_e(array('auction','8'));
			$c[$o]['name'] 		= "price_bin";
			$c[$o]['type'] 		= "price";
			$c[$o]['class'] 	= "form-control";
			$c[$o]['help'] 		= $CORE->_e(array('auction','9'));
			//$c[$o]['required'] 	= true;
			$c[$o]['defaultvalue'] 	= "0";
			$o++;
		}
		
		$c[$o]['title'] 	= $CORE->_e(array('auction','95'));
			$c[$o]['name'] 		= "qty";
			$c[$o]['type'] 		= "text";
			$c[$o]['class'] 	= "form-control";
			$c[$o]['help'] 		= $CORE->_e(array('auction','96'));
			//$c[$o]['help'] 		= $CORE->_e(array('auction','96'))."<style>#form_qty{ width:100px }</style>";
			$c[$o]['required'] 	= true;
			$c[$o]['defaultvalue'] 	= "1";
			$o++;
		}
		
		/*if($canEditPrice){
		$c[$o]['title'] 	= $CORE->_e(array('auction','10'));
		$c[$o]['name'] 		= "price_reserve";
		$c[$o]['type'] 		= "price";
		$c[$o]['class'] 	= "form-control";
		$c[$o]['help'] 		= $CORE->_e(array('auction','11'));
		$c[$o]['required'] 	= true;	
		$c[$o]['defaultvalue'] 	= "0";	
		$o++;
		}*/
		
		if(isset($GLOBALS['CORE_THEME']['auction_shipping']) && $GLOBALS['CORE_THEME']['auction_shipping'] == '1'){ 
		
			if($canEditPrice){
				$c[$o]['title'] 	= $CORE->_e(array('auction','67'));
				$c[$o]['name'] 		= "price_shipping";
				$c[$o]['type'] 		= "price";
				$c[$o]['class'] 	= "form-control";
				$c[$o]['help'] 		= $CORE->_e(array('auction','68'));
				$c[$o]['required'] 	= true;	
				$c[$o]['defaultvalue'] 	= "0";	
				$o++; 
			}
		
		}
		
		/*if($GLOBALS['CORE_THEME']['auction_theme_usl'] == '1' && !isset($_GET['eid'])){ 
		$c[$o]['title'] 	= $CORE->_e(array('auction','12'));
		$c[$o]['name'] 		= "listing_expiry_date";
		$c[$o]['type'] 		= "select";
		$c[$o]['class'] 	= "form-control";
		$c[$o]['listvalues'] 	= array("1" => "1 ".$CORE->_e(array('date','1')), "3" => "3 ".$CORE->_e(array('date','1')),"5" => "5 ".$CORE->_e(array('date','1')),"7" => "7 ".$CORE->_e(array('date','2')), "14" => "14 ".$CORE->_e(array('date','2')), "21" => "21 ".$CORE->_e(array('date','2')), "30" => "30 ".$CORE->_e(array('date','2')));
		$c[$o]['help'] 		= $CORE->_e(array('auction','13'));
		$c[$o]['required'] 	= true;
		$o++;
		}*/
		
		
		$c[$o]['title'] 	= $CORE->_e(array('auction','91'));
		$c[$o]['name'] 		= "condition";
		$c[$o]['type'] 		= "select";
		$c[$o]['class'] 	= "form-control";
		$c[$o]['listvalues'] 	= array("1" => $CORE->_e(array('auction','92')), "2" => $CORE->_e(array('auction','93')));		
		//echo "<pre>";print_r($c);echo "</pre>";
		return $c;
	}
		add_action('hook_add_fieldlist', '_hook_customfields_cust',1);
		
		
	/************** Adding Custom Script ***************************/
	add_action( 'wp_enqueue_scripts', 'my_custom_script_file' );
	function my_custom_script_file(){
		wp_enqueue_script( 'my-custom-script', get_stylesheet_directory_uri() . '/custom.js' );
		wp_enqueue_script( 'my-custom-pagination', get_stylesheet_directory_uri() . '/imtech_pager.js' );
		wp_enqueue_style( 'my-custom-admin-css', get_stylesheet_directory_uri() . '/admin.css' );
	}
		
	/************************* Custom Bidding Form ***********************/
		
	add_shortcode( 'BIDDINGFORM_CUSTOM', 'bidding_form');	
	function bidding_form(){
		global $CORE, $post, $userdata, $wpdb;	
		
		// GET BASIC BIDDING DATA FOR DISPLAY
		$reserve_price = get_post_meta($post->ID,'price_reserve',true);
		$price_current = get_post_meta($post->ID,'price_current',true);
		$price_shipping = get_post_meta($post->ID,'price_shipping',true);
		if($price_shipping == "" || !is_numeric($price_shipping)){$price_shipping = 0; }
		$price_bin = get_post_meta($post->ID,'price_bin',true);	
		$auction_type = get_post_meta($post->ID,'auction_type',true);
		$condition = get_post_meta($post->ID,'condition',true);


		// GET HITS
		$hits = get_post_meta($post->ID,'hits',true);
		if($hits == ""){ $hits = 0; }

			// GET CURRENT BIDING DATA
			$current_bidding_data = get_post_meta($post->ID,'current_bid_data',true);
			if(!is_array($current_bidding_data)){ $current_bidding_data = array(); }
		 
				//2. ORDER IT BY KEY (WHICH HOLDS THE BID AMOUNT)
				krsort($current_bidding_data);
				
				$bid_count = count($current_bidding_data);
				
				//3. GET THE CURRENT BIDDING DATA	
				$checkme = current($current_bidding_data);
				if(isset($checkme['username']) ){	
					
					// SHOW TEXT FOR CURRENT HIGHEST BIDDER
					if($userdata->data->ID == $checkme['userid']){
					
						$current_bidder_amount 	= "<i class='fa fa-check-square-o'></i> ".$CORE->_e(array('auction','33'))." ".hook_price($checkme['max_amount'])."";
						// CHECK IF ITS LOWER THAN THE RESERVER PRICE
						if($price_current != "" && $checkme['max_amount'] >= $reserve_price && is_numeric($reserve_price) && $reserve_price != "0"){
						
						$current_bidder_amount .= " ".$CORE->_e(array('auction','34'))." ".hook_price($reserve_price).". <span>".$CORE->_e(array('auction','35'))."</span>";
						}elseif($reserve_price > $price_current){ 
						$current_bidder_amount .= " ".$CORE->_e(array('auction','36'))." ".hook_price($reserve_price).". <span>".$CORE->_e(array('auction','37'))."</span>";
						}
						
						//$current_bidder_amount .= "</pre>";
					
					} 
				 
			}else{
				// DEFAULTS			 
				$current_bidder_amount 	= "";
				
				$bid_count = 0 ;
			}
				
			//2. GET THE CURRENT PRICE
			$current_price = get_post_meta($post->ID,'price_current',true);
			if($current_price == ""){ $current_price = 0; }
				 //<-- add one onto the existing price so the bidder doesnt bid nothing
				
			//3. GET EXPIRY DATE
			$expiry_date = get_post_meta($post->ID,'listing_expiry_date',true);
			
			//4. CHECK FOR BIN QTY
			$bin_qty = get_post_meta($post->ID,'qty',true);
		 
			if(!empty($current_bidding_data)){
				foreach($current_bidding_data as $gg){
					if($gg['userid'] == $userdata->ID && $gg['bid_type'] == "buynow"){
				
						$SHOWPAYMENTFORM = true;
						// CHECK IFHAS PAID				
						if(strtotime(get_post_meta($post->ID,'auction_price_paid_date',true)) > strtotime($gg['date'])){
						$SHOWPAYMENTFORM = false;
						}
					}
				}
			}


			// CHECK IF THIS IS AN AFFILIATE PRODUCT OR NOT
			$aff_p = get_post_meta($post->ID,'buy_link',true);
			if(strlen($aff_p) > 1){
				$link_l = get_home_url()."/out/".$post->ID."/buy_link/";
				$bid_btn = "<a href='".$link_l."' class='btn btn-primary right'>".$CORE->_e(array('auction','53'))."</a>";
			}elseif($userdata->ID == $post->post_author){ // STOP BIDDING ON OWN ITEMS
				$bid_btn = "<button class='btn btn-primary btn-lg' href='javascript:void(0);' onclick=\"alert('".$CORE->_e(array('auction','54','flag_noedit'))."');\">".$CORE->_e(array('auction','70'))."</button>";	
			}elseif(!$userdata->ID){
				$bid_btn = "<button class='btn btn-primary btn-lg' href='javascript:void(0);' onclick=\"alert('".$CORE->_e(array('auction','56','flag_noedit'))."');\">".$CORE->_e(array('auction','70'))."</button>";
			}else{
				$bid_btn = "<button class='btn btn-primary btn-lg' href='javascript:void(0);' onclick=\"jQuery('.biddingbox').show();\">".'Make Max Bid'."</button>";//$CORE->_e(array('auction','70'))."</button>";
			}
			
			// GET BUY NOW BUTTON
			$buynow_btn = "";
			if(!$userdata->ID){		
				$buynow_btn = "<button class='btn btn-primary btn-lg' href='javascript:void(0);' onclick=\"alert('".$CORE->_e(array('auction','56','flag_noedit'))."');\">".$CORE->_e(array('auction','55'))."</button>";	
			}elseif($userdata->ID == $post->post_author){ 
				$buynow_btn = "<button class='btn btn-primary btn-lg' href='javascript:void(0);' onclick=\"alert('".$CORE->_e(array('auction','54','flag_noedit'))."');\">".$CORE->_e(array('auction','55'))."</button>";	
			}else{ 
				$buynow_btn = "<button class='btn btn-primary btn-lg' href='javascript:void(0);' onclick=\"jQuery('.buynowbox').show();\">".$CORE->_e(array('auction','55'))."</button>";
			}
			
			// GET SELLER DETAILS
			$user_info = get_userdata($post->post_author); 
		 
			// START OUTPUT 
			ob_start();
		 
			?>
			
		<div id="auctionbidform">
		<ul class="list-group">

			<li class="list-group-item item1">
				<span class="pull-right"> <?php echo do_shortcode('[D_SOCIAL size=16]'); ?></span>
				ID: #<?php echo $post->ID; ?>
			</li>

			<li class="list-group-item item1">
			
			<?php if($bid_count > 0){ ?> <i class="fa fa-search bidhistoryicon"></i>
			
			<!-----------------------  POPUP ------------------------->
					<div id="bidhistory" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
				<div class="modal-dialog"><div class="modal-content">
				  <div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-hidden="true">x</button>
					<h4 class="modal-title"><?php echo $CORE->_e(array('auction','18')); ?></h4>
				  </div>
				  <div class="modal-body">
				  
				  <script>

				jQuery('.bidhistoryicon').hover(function () {
					jQuery('#bidhistory').modal({
						show: true
					});
				});
				
				</script>
			<?php echo do_shortcode('[BIDDINGHISTORY]'); ?>
			
			
					  </div>
				  
				</div>
				</div></div> 		
				<!----------------------- end POPUP ------------------------->
			 
			<?php } ?>
			
			<?php echo $CORE->_e(array('auction','97')); ?>: <strong><?php echo $bid_count; ?>    

			</strong>  
			
			   <?php if(isset($checkme['username']) && $checkme['username'] != "" && is_numeric($checkme['userid'])){ ?>
		 
				<span class="pull-right">
				
				<small><?php echo $CORE->_e(array('auction','32')); ?></small>:  <i class="fa fa-user"></i> <a href="<?php echo get_author_posts_url( $checkme['userid']); ?>"><?php echo $checkme['username']; ?></a>	
				 
				</span>
				
			   <?php } ?>
			   
			</li>	
			<li class="list-group-item item3">
			
			<span class="pull-right"> <i class="fa fa-line-chart"></i>  <?php echo $CORE->_e(array('single','19')); ?>: <strong><?php echo number_format($hits); ?></strong> </span>
			
			<?php echo $CORE->_e(array('auction','91')); ?>: <strong><?php if($condition == 1){ echo $CORE->_e(array('auction','92')); }else{ echo $CORE->_e(array('auction','93')); } ?></strong>
			</li>

			<li class="list-group-item item4">
			
			<div class="row">
			
			<div class="col-md-7">
			
			<?php echo $CORE->_e(array('auction','71')); ?>: <i class="fa fa-user"></i> <strong><a style="text-decoration:underline;" href="<?php echo get_author_posts_url( $post->post_author ); ?>"><?php echo $user_info->data->display_name; ?></a> </strong>
		   
			</div>
			
			<?php if(isset($GLOBALS['CORE_THEME']['feedback_enable']) && $GLOBALS['CORE_THEME']['feedback_enable'] == '1'){ ?>
			<div class="col-md-5">
			
			<?php echo _user_trustbar($post->post_author, 'inone'); ?>
			
			</div>
			
			<?php } ?>
			
			</div>
			
			
			</li>
			
			<li class="list-group-item item4">
			<?php echo $CORE->_e(array('author','9')); ?>: <strong><?php echo hook_date($post->post_date); ?></strong> 
			</li>
			
				
			
			
			<?php 
			
			
			// CHECK IF THE LISTING HAS ENDED AND THE ITE HAS BEEN WON
			if(  ( $expiry_date == "" || strtotime($expiry_date) < strtotime(current_time( 'mysql' )) ) || isset($SHOWPAYMENTFORM) ){  if($userdata->ID){ ?>
				
			  <li class="list-group-item paybits">      
			  
				<h4 class="text-center"><?php echo $CORE->_e(array('auction','39')); ?></h4>	 
			 
				<div>
				
					<?php if($bid_count > 0 && is_numeric($reserve_price) && $reserve_price != "0" && $price_current < $reserve_price){ ?>
			
					<div class="alert alert-danger"><?php echo $CORE->_e(array('auction','38')); ?></div>
						 
					<?php }	?>

			
				
				<?php
				
				

		// CHECK IF THEY CAN RELIST
		if($bid_count > 0 && is_numeric($reserve_price) && $reserve_price != "0" && $price_current < $reserve_price){ }else{
			 
			if(isset($GLOBALS['CORE_THEME']['auction_relist']) && $GLOBALS['CORE_THEME']['auction_relist'] == '1' && get_post_meta($post->ID, 'bidwinnerstring', true) == "" ){ 
							
				$days_renew = get_option($post->ID, 'listing_expiry_days', true);
				
				// GET DAYS FROM THE PACKAGE
				if(!is_numeric($days_renew)){
					$packageID =  get_post_meta($post->ID,'packageID',true);	
					$packagefields = get_option("packagefields");
					if(isset($packagefields[$packageID]['expires']) && is_numeric($packagefields[$packageID]['expires']) ){	
					$days_renew = $packagefields[$packageID]['expires'];	
					}
				}					
				
				if(!is_numeric($days_renew)){ $days_renew = 30; }
				
				// RE-LIST BUTTON
				if($userdata->ID == $post->post_author && !isset($_GET['relistme']) ){
				
					$STRING .= " 
					<h4>".$CORE->_e(array('auction','80'))."</h4>
					<p>".str_replace("%a",$days_renew,$CORE->_e(array('auction','81')))."</p>
					<a href='".get_permalink($post->ID)."?relistme=1' class='btn btn-success'>".$CORE->_e(array('auction','82'))."</a>";
				
				}elseif($userdata->ID == $post->post_author && isset($_GET['relistme']) ){
				
					update_post_meta($post->ID, 'listing_expiry_date', date("Y-m-d H:i:s", strtotime( current_time( 'mysql' ) . " +".$days_renew." days")));
					update_post_meta($post->ID, 'current_bid_data', '');
					update_post_meta($post->ID,	'bidstring', ''); 
					
					update_post_meta($post->ID,	'relisted', current_time( 'mysql' ) ); 
					
					// UPDATE LISTING DATE
					$my_post = array();
					$my_post['ID'] 					= $post->ID;
					$my_post['post_date']			= current_time( 'mysql' );
					wp_update_post( $my_post  );
					//echo current_time( 'mysql' ); die();
					$STRING .= '<script>jQuery(document).ready(function() { location.reload(); });</script>';
					
					// SEND OUT EMAIL TO OLD BIDDERS
				
				}
							
			}// end renew
		}
				 
				
				// CHECK IF IM THE WINNING BIDDER THEN DISPLAY PAYMENT BUTTONS
				
				if($checkme['userid'] == $userdata->ID && $price_current >= $reserve_price && ( get_post_meta($post->ID,'auction_price_paid',true) == "" || ( isset($SHOWPAYMENTFORM) && $SHOWPAYMENTFORM != false) ) ){ 
						
						// IF THE SELLER IS THE ADMIN, THEN ACCEPT ANY ADMIN PAMENT
						if(user_can($post->post_author, 'administrator')){
						
						//$STRING .= '<button href="#myPaymentOptions" role="button" class="btn btn-info btn-lg" data-toggle="modal">'.$CORE->_e(array('button','22')).'</button> 
						$STRING .= '<!-- Modal -->
						<div id="myPaymentOptions" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
						   <div class="modal-dialog"><div class="modal-content">
						  <div class="modal-header">
							<button type="button" class="close" data-dismiss="modal" aria-hidden="true">x</button>
							<h4 id="myModalLabel">'.$CORE->_e(array('single','13')).' ('.hook_price($current_price+$price_shipping).')</h4>
						  </div>
						  <div class="modal-body">'.$CORE->PAYMENTS($current_price+$price_shipping, "CART-".$post->ID."-".$userdata->ID."-".date("Ymdi"), $post->post_title, $post->ID, $subscription = false).'</div>
						  <div class="modal-footer">
						  '.$CORE->admin_test_checkout().'
						  <button class="btn" data-dismiss="modal" aria-hidden="true">'.$CORE->_e(array('single','14')).'</button></div></div></div></div>
						<!-- End Modal -->';
						}else{
						// CHECK IF THIS IS A USER AUCTION AND THEY HAVE SET A PAYPAL EMAIL
						$paypalemail = get_user_meta($post->post_author,'user_paypalemail',true);
						if($paypalemail == ""){
							$STRING .= "<br /><div class='well'>".$CORE->_e(array('auction','79'))."</div>";
						}else{
							
							$GLOBALS['A_TOTAL'] 	= $current_price+$price_shipping;
							$GLOBALS['A_ORDERID']	= 'USERPAYMENT-'.$post->ID.'-'.date('Ydm');
							$GLOBALS['A_DESC']	 	= strip_tags($post->post_title);

							
							$STRING .= hook_custom_paypal_payment('<form method="post"  action="https://www.paypal.com/cgi-bin/webscr" name="checkout_paypal" class="pull-left">	 
							<input type="hidden" name="lc" value="US">
							<input type="hidden" name="return" value="'.$GLOBALS['CORE_THEME']['links']['callback'].'/?status=thankyou">
							<input type="hidden" name="cancel_return" value="'.$GLOBALS['CORE_THEME']['links']['callback'].'">
							<input type="hidden" name="notify_url" value="'.$GLOBALS['CORE_THEME']['links']['callback'].'">
							<input type="hidden" name="discount_amount_cart" value="0">
							<input type="hidden" name="cmd" value="_xclick">
							<input type="hidden" name="amount" value="'.$GLOBALS['A_TOTAL'].'">
							<input type="hidden" name="item_name" value="'.$GLOBALS['A_DESC'].'">
							<input type="hidden" name="item_number" value="'.$GLOBALS['A_ORDERID'].'">
							<input type="hidden" name="business" value="'.$paypalemail.'">
							<input type="hidden" name="currency_code" value="'.$GLOBALS['CORE_THEME']['currency']['code'].'">
							<input type="hidden" name="charset" value="utf-8">
							<input type="hidden" name="custom" value="'.$GLOBALS['A_ORDERID'].'">
							<button  class="btn btn-lg btn-info">'.$CORE->_e(array('button','21')).'</button></form>');					
						}
						
				}
						
				// CONTACT SELLER & BUYER BUTTONS
				if(isset($GLOBALS['CORE_THEME']['message_system']) && $GLOBALS['CORE_THEME']['message_system'] != '0'){ 
						
							if($userdata->ID == $checkme['userid']){
								//$STRING .= '<a href="'.$GLOBALS['CORE_THEME']['links']['myaccount'].'/?u='.$author_info->user_login.'&tab=msg&show=1" class="btn btn-info btn-lg pull-right">'.$CORE->_e(array('auction','41')).'</a>';
								//$STRING .= '<a href="'.$GLOBALS['CORE_THEME']['links']['myaccount'].'/?u='.$author_info->user_login.'&tab=msg&show=1" class="btn btn-info btn-lg ">'.$CORE->_e(array('auction','41')).'</a>';
								$STRING .= '<a href="'.get_author_posts_url( $post->post_author ).'" class="btn btn-info btn-lg ">'.$CORE->_e(array('auction','41')).'</a>';
							}else{
								$STRING .= '<a href="'.$GLOBALS['CORE_THEME']['links']['myaccount'].'/?u='.$checkme['username'].'&tab=msg&show=1" class="btn btn-info btn-lg pull-right">'.$CORE->_e(array('auction','42')).'</a>';
							}
						
				}
				
				if($checkme['userid'] == $userdata->ID &&  $CORE->FEEDBACKEXISTS($post->ID, $userdata->ID) === false){ 
						  
					 $STRING .= '<div class="clearfix"></div><hr><div class="text-center"><a href="'.$GLOBALS['CORE_THEME']['links']['myaccount']."/?fdid=".$post->ID.'" class="btn btn-success">'.$CORE->_e(array('auction','23')).'</a></div>';
						   
				}
						
						
		}elseif($checkme['userid'] == $userdata->ID && get_post_meta($post->ID,'auction_price_paid',true) != ""){

			// LEAVE FEEDBACK
			if($CORE->FEEDBACKEXISTS($post->ID, $userdata->ID) == false){ 
							
				$STRING .= "<div class='text-center'><a href='".$GLOBALS['CORE_THEME']['links']['myaccount']."/?fdid=".$post->ID."' class='btn btn-lg btn-info'>".$CORE->_e(array('feedback','1'))."</a></div>";
							
			}
		}


		// OUTPUT BUTTONS
		echo $STRING;
		?>
				
		  
				</div>
				
				</li> 
				
				
				<?php  } }else{ // START BIDDING AREA ?>
			 
			   
				<?php if($auction_type != 2){ ?>
				
			  <li class="list-group-item pricebits">     
				 
			  <div class="row">
			  
				  <div class="col-md-6">
				  
					<?php echo $CORE->_e(array('auction','84')); ?>: <strong> <?php if($price_current !=0){echo  hook_price($price_current+10); }else{echo  hook_price($price_current);} ?></strong>
					
					<div class="clearfix"></div>
					
					<?php if(is_numeric($price_shipping)  && $price_shipping > 0){ ?>
					<small> <i class="fa fa-codepen"></i> <?php echo $CORE->_e(array('auction','67')); ?>: <?php echo hook_price($price_shipping); ?> </small>
					<?php } ?>
					
					<?php 
					if(strlen($reserve_price) > 0 && $reserve_price != "0" && $price_bin < 1 ){
					if(is_numeric($reserve_price) && $reserve_price != "0" && $price_current < $reserve_price){
					?>
					
					<span class="priceextra"><i class="fa fa-times"></i> <?php echo $CORE->_e(array('auction','57')); ?></span>
					
					<?php }else{ ?>  
					   
					<span class="priceextra"><i class="fa fa-check"></i> <?php echo $CORE->_e(array('auction','69')); ?></span>
					 
					<?php } } ?>
				  
				  </div>
				  
				  <div class="col-md-6 text-right">
				  
				  <?php echo $bid_btn; ?>             
					
				  </div>
					
			  </div>        
				
			   </li>
			   
			   
			   
			   <?php 
			   
			   // RESEVR PRICE NOT YET MET
			   
			   if(strlen($current_bidder_amount) > 4){ ?>
			   <li class="list-group-item">
			   
				<?php echo $current_bidder_amount; ?>
			   </li>
			   <?php } ?>
				
			   
			   <li class="list-group-item biddingbox" style="display:none;">
			  
			   <span class="label label-default pull-right" onclick="jQuery('.biddingbox').hide();" ><?php echo $CORE->_e(array('account','48')); ?></span>
				 
				<form method="post" action="" class="row clearfix bidd_frm" onsubmit="return CheckBidding();">
				<input type="hidden" name="auction_action" value="newbid" />
				<input type="hidden" name="bidtype" value="bid" />
				<input type='hidden' name='hidden_cp' id='hidden_cp' value='<?php echo $current_price; ?>' />
				
				 <div class="col-md-12">
				 
				 <h4><?php echo $CORE->_e(array('auction','89')); ?></h4>
				 
				 </div>
			
				 <div class="col-md-12 formErrorClass ">          
					<div class='input-group'>
					<input type='text' class='form-control input-lg' id='bid_amount' name="bidamount"  placeholder='<?php echo hook_price($current_price+10); ?>' /> 
					<span class='input-group-addon'><?php echo $GLOBALS['CORE_THEME']['currency']['symbol']; ?></span>
					</div>          
					<div class='input-group'>
					<input type='text' class='form-control input-lg' id='cbid_amount' name="cbidamount"  placeholder='<?php echo hook_price($current_price+10); ?>' /> 
					<span class='input-group-addon'><?php echo $GLOBALS['CORE_THEME']['currency']['symbol']; ?></span>
					</div>          
				</div>        
				<div class="col-md-12">        
					<button class="btn btn-lg btn-primary cnfm_bid" type="submit"><?php echo $CORE->_e(array('auction','66')); ?></button>        
				</div>
			  
				</form>
				
				<script>
				function CheckBidding(){		
				<?php 
				
				if($userdata->ID && ($userdata->ID == $post->post_author && $userdata->ID != 1) ){ ?> 
				
				alert("<?php echo $CORE->_e(array('auction','72','flag_noedit')); ?>"); return false; 
				
				<?php }elseif($userdata->ID){ ?>
				
					var bidprice = jQuery('#bid_amount').val();
					var ecp = jQuery('#hidden_cp').val();	
					var ecp = Math.round(parseFloat(ecp)*100)/100;
					var bidprice = Math.round(parseFloat(bidprice)*100)/100;
				
					if(jQuery.isNumeric(bidprice) && bidprice > ecp){	
						return true;
					}else{
					alert('<?php echo $CORE->_e(array('auction','73','flag_noedit')).' '.$GLOBALS['CORE_THEME']['currency']['symbol']; ?>'+ecp+'');
					return false;
					}
								
				<?php }else{ ?>
				
					alert("<?php echo $CORE->_e(array('auction','56','flag_noedit')); ?>"); return false;
				
				<?php } ?>
				
				};
				</script>
				
				<hr />
				
				<h4><?php echo $CORE->_e(array('auction','20')); ?></h4>
				
				<?php echo $CORE->_e(array('auction','90')); ?>
				 
				<p><?php echo $CORE->_e(array('auction','65')); ?></p>
					
				<textarea><?php echo stripslashes($GLOBALS['CORE_THEME']['auction_terms']); ?></textarea>
					
			
				</li>       
				
				<?php } ?>
				
				
				
				
				<?php if($price_bin != "" && is_numeric($price_bin) && $price_bin > 0 && ( $price_current <= $price_bin ) ){ ?>  
		  
				
				<li class="list-group-item pricebits">
			 

				  <div class="row">
				  
					  <div class="col-md-6">
					  
					  <?php echo $CORE->_e(array('auction','8')); ?>: <strong><?php echo hook_price($price_bin); ?></strong>
					  
					   <?php 
							 // SHOW SHIPPING IF CLASSIFIEDS IT ON
							 if($auction_type == 2){ ?>
							<?php if(is_numeric($price_shipping)  && $price_shipping > 0){ ?>
							<span class="priceextra"> <i class="fa fa-codepen"></i> <?php echo $CORE->_e(array('auction','67')); ?>: <?php echo hook_price($price_shipping); ?></span>
							<?php } ?>
							<?php } ?>
							
							  <?php
						
						if(is_numeric($bin_qty) && $bin_qty > 1){
						$bin_qty_sold = get_post_meta($post->ID,'qty_sold',true);
						if($bin_qty_sold == ""){ $bin_qty_sold = 0; }
						?>
						<br /> <?php echo $bin_qty-$bin_qty_sold; ?>/<?php echo $bin_qty; ?> <?php echo $CORE->_e(array('auction','94')); ?>.
						<?php } ?>
					  
					  </div>
					  
					  
					   <div class="col-md-6 text-right">
					  
					  <?php echo $buynow_btn; ?>
					  </div>  
							 
				  </div>
				  
				
				</li>
				
				<li class="list-group-item buynowbox" style="display:none;">
				
					<span class="label label-default pull-right" onclick="jQuery('.buynowbox').hide();" ><?php echo $CORE->_e(array('account','48')); ?></span>
					
					 
				   <h4>Buy Now</h4>          
					<div class="formError_Class">
					<p><?php echo $CORE->_e(array('auction','65')); ?></p>
					<input type ="hidden" class="CurrntBuyNow" value=<?php $price = hook_price($price_bin); 
					$price = str_replace("€","",$price);
					$price = str_replace(",","",$price);
					echo $price;
					 ?>>
					<!--<textarea><?php echo stripslashes($GLOBALS['CORE_THEME']['auction_terms']); ?></textarea>-->
					<input type ="text" name="bid_price" class="BuyNowBidPrice">
					</div>
					<hr />
					<form method="post" action="" name="buynowform" id="buynowform">
					<input type="hidden" name="auction_action" value="buynow" />
					<div class="text-center"><button class="btn btn-lg btn-primary cnfmBuy" type="submit"><?php echo $CORE->_e(array('auction','66')); ?></button></div>
					</form> 
			   
			   
			   </li>
				<?php } ?>
				
				
				
				
				<?php } // END BIDDING AREA ?>
				
				
				
				
				 
		</ul>
		</div>
			
			<?php 
			// RETURN OUTPUT
			$output = ob_get_contents();
			ob_end_clean();
			return $output;
			
		}	


/********** Custom Register redirection **************/

add_filter('user_register','login_redirect'); 
function login_redirect($redirect_to) {
	error_reporting(0);
    wp_redirect( home_url().'/register-thankyou/' );
    ?>
	 <div class="registerContainer">
	  <div id="login">
		<div class="loginMid">
		  <div class="loginInner">
			<h1><a href="<?php echo site_url();?>" title="Powered by WordPress" tabindex="-1"><img src="<?php $dir= wp_upload_dir(); echo $dir['baseurl'];?>/2017/07/lg.png"></a></h1>
			<p class="message register">Registration successful.</p>
			<p class="message"> An email has been sent to the site administrator. The administrator will review the information that has been submitted. You will receive an email with instructions on what you will need to do next. Thank you for your patience.<br>
			</p>
			<p id="backtoblog"><a href="<?php echo site_url();?>">← Back to Prochronos</a></p>
		  </div>
		</div>
	  </div>
	</div>
    <script type="text/javascript">
		$(document).ready(function(e) {
			var current_buy_now  = jQuery('.CurrntBuyNow').val();
			jQuery('.cnfmBuy').attr('disabled','');
			jQuery('.BuyNowBidPrice').keyup(function(){
			//	alert(jQuery(this).val());
			//alert(current_buy_now);
				var CbidAmt = jQuery(this).val();
				
				if (current_buy_now <= CbidAmt) {
					alert('Gereter then Fn');
					jQuery('.bidmssg').html('Your bidding amount matched.');
					jQuery('.bidmssg').css('color','green');
					jQuery('.cnfm_bid').removeAttr('disabled');
					return true;
				}else{
					alert('less then Fn');
					jQuery('.bidmssg').html('Your bidding amount is less than Buy Now Price. Please enter a greater or equal amount of Buy Now Price ');
					jQuery('.bidmssg').css('color','red');
					return false;
				}
			});
		});
	</script>
	<style>
		.registerContainer { width: 100%; height: 100vh; display: table; text-align: center; background: #F1F1F1; }
		#login { display: inline-block; margin: 0 auto; max-width: 500px; text-align: center; vertical-align: middle; width: 500px; height: 100vh; }
		.loginInner { display: table-cell; vertical-align: middle; width: 100%; height: auto; }
		.message { width: 100%; padding: 10px 15px; position: relative; background: #fff; margin-bottom: 20px; color: #4b4b4b; text-align: left; }
		.message:after { width: 4px; height: 100%; content: ''; position: absolute; left: -5px; top: 0; background: #00a0d2; }
		#backtoblog a { color: #4b4b4b; }
		.loginInner h1 a { color: #4b4b4b; }
		#backtoblog { text-align: left; }
		.loginMid { width: 100%; vertical-align: middle; display: table; height: 100vh; }
		*{margin : 0 ; padding: 0 ;}
	</style>
  <?php 
}

/************** Adding Brand taxononomy *********/ 
//hook into the init action and call create_book_taxonomies when it fires
add_action( 'init', 'create_topics_hierarchical_taxonomy', 0 );
 
//create a custom taxonomy name it topics for your posts
 
function create_topics_hierarchical_taxonomy() {
 
// Add new taxonomy, make it hierarchical like categories
//first do the translations part for GUI
 
  $labels = array(
    'name' => _x( 'Brands', 'taxonomy general name' ),
    'singular_name' => _x( 'Brand', 'taxonomy singular name' ),
    'search_items' =>  __( 'Search Brands' ),
    'all_items' => __( 'All Brands' ),
    'parent_item' => __( 'Parent Brand' ),
    'parent_item_colon' => __( 'Parent Brand:' ),
    'edit_item' => __( 'Edit Brand' ), 
    'update_item' => __( 'Update Brand' ),
    'add_new_item' => __( 'Add New Brand' ),
    'new_item_name' => __( 'New Brand Name' ),
    'menu_name' => __( 'Brands' ),
  );    
 
// Now register the taxonomy
 
  register_taxonomy('brands','listing_type', array(
    'hierarchical' => true,
    'labels' => $labels,
    'show_ui' => true,
    'show_admin_column' => true,
    'query_var' => true,
    'rewrite' => array( 'slug' => 'brand' ),
  ));
 
}

add_shortcode( '(seller_link)',  'seller_link');
function seller_link(){
	$id = GET_THE_ID();
	//$author = get_the_author($id);
	$author = 'Test Author';
	return $author;
}	




 /************************ Mail On Request Matching ********************/
add_action('save_post','request_mail_sending_on_adding_list');
function request_mail_sending_on_adding_list($post_id){
    global $post, $wpdb, $table_prefix; 
    if ($post->post_type == 'listing_type'){

		$listing_expiry_date = get_post_meta($post->ID, 'listing_expiry_date', true);
		if($listing_expiry_date){
			update_post_meta($post->ID, 'listing_expiry_date_timestamp', strtotime($listing_expiry_date));
		}
		/*$date  = date('d-m-Y');
		$date = strtotime($date);
		$result = $wpdb->get_results('select * from '.$table_prefix.'request_management' );
		$listing_id = $_POST['tax']['listing'];
		$brand = $_POST['tax']['brands'];
		$model = $_POST['custom']['modelofwatch'];
		$ref_no = $_POST['custom']['referencenumber'];
		$year = $_POST['custom']['yearofwatch'];
		$gender = $_POST['custom']['genderofwatch'][0];
		$condition = $_POST['custom']['conditionofwatch'][0];
		//$res->brand == $brand

		foreach($result as $res){
			//echo $res->type_of_watch.'<br>';
			if($listing_id === $res->type_of_watch && $brand === $res->brand && $model === $res->model && $ref_no === $res->ref_no && $year === $res->year && $gender == $res->gender){
				//echo $res->type_of_watch;
				 $email = $res->requester_email;
				 //$email = 'nrawat@getyoursolutions.com';
				 $message = "<b>Dear Requester</b><br> ";
				 $message .= "<b>Your Request has been matched Please check the following url: </b><br>";
				 $message .= get_permalink($post_id); 
				 $message .= "<br><br>";
				 $message .= "Kindly Regards<br> Prochronos Team";
				 $header = "From: example@example.com\r\n";
				// $header .= "Cc:afgh@somedomain.com \r\n";
				 $header .= "MIME-Version: 1.0\r\n";
				 $header .= "Content-type: text/html\r\n";
				 $retval = wp_mail($email,$subject,$message,$header);
			
			}
				
		}
		//echo "<pre>";print_r($listing_id);echo "</pre>";
		 if($retval == true){
					echo "Email Sent Successfully";
				 }else{
					echo "Email Not Sent";
				 }*/
	//	exit;
	
	
	
	
		$andset = false;
		$q = 'select * from '.$table_prefix.'request_management WHERE req_status=1';
		$condition = get_post_meta($post_id,'condition',true);
		if(isset($condition) && $condition != ''){
			$q .= ' AND watch_condition = '.$condition;  
			$andset = true;
		}
		
		$modelofwatch = get_post_meta($post_id,'modelofwatch',true);
		if(isset($modelofwatch) && $modelofwatch != ''){
			$q .= ' AND model = '.$modelofwatch;  
			$andset = true;
		}
		
		$referencenumber = get_post_meta($post_id,'referencenumber',true);
		if(isset($referencenumber) && $referencenumber != ''){
			$q .= ' AND ref_no = '.$referencenumber;  
			$andset = true;
		}
		
		$yearofwatch = get_post_meta($post_id,'yearofwatch',true);
		if(isset($yearofwatch) && $yearofwatch != ''){
			$q .= ' AND year = '.$yearofwatch;  
			$andset = true;
		}
		
		
		$brand = get_post_meta($post_id,'brand',true);
		if(isset($brand) && $brand != ''){
			$brandInfo = get_term_by('name', $brand, 'brands');
			if(!empty($brandInfo)){
				$q .= ' AND brand = '.$brandInfo->term_id;  
				$andset = true;
			}
		}
		
		$typeofwatch = get_post_meta($post_id,'typeofwatch',true);
		if(isset($typeofwatch) && $typeofwatch != ''){
			$CatInfo = get_term_by('name', $typeofwatch, 'listing');
			if(!empty($CatInfo)){
				$q .= ' AND type_of_watch = '.$CatInfo->term_id;  
				$andset = true;
			}
		}
		
		$genderofwatch = get_post_meta($post_id,'genderofwatch',true);
		if(!empty($genderofwatch)){
			$q .= ' AND gender IN ("'.implode('","', $genderofwatch).'")';  
			$andset = true;
		}
		
		$conditionofwatch = get_post_meta($post_id,'conditionofwatch',true);
		if(!empty($conditionofwatch)){
			$q .= ' AND request_condition IN ("'.implode('","', $conditionofwatch).'")';  
			$andset = true;
		}
		
		if($andset === true){
			$matchedRequests = $wpdb->get_results($q);
			if(!empty($matchedRequests)){
				foreach($matchedRequests as $request){
					$subject = 'Listing matched notification';
					$email = $request->requester_email;
					//$email = 'kdogra@getyoursolutions.com';
					$message = "<b>Dear Requester</b><br> ";
					$message .= "<b>Your Request has been matched Please check the following url: </b><br>";
					$message .= get_permalink($post_id); 
					$message .= "<br><br>";
					$message .= "Kindly Regards<br> Prochronos Team";
					$header = "From: example@example.com\r\n";
					// $header .= "Cc:afgh@somedomain.com \r\n";
					$header .= "MIME-Version: 1.0\r\n";
					$header .= "Content-type: text/html\r\n";
					$retval = wp_mail($email,$subject,$message,$header);
				}
				
				if($retval == false){
					echo "Error in sending email. Please contact administrator.";
				}
			}
		}
	}
    //if you get here then it's your post type so do your thing....
}
// My function to modify the main query object
function my_modify_main_query( $query ) {
	//if ( $query->is_home() && $query->is_main_query() ) { // Run only on the homepage
	if ( $query->is_search()) { // Run only on the homepage
		//$query->query_vars[‘cat’] = -2; // Exclude my featured category because I display that elsewhere
		//$query->query_vars['posts_per_page'] = 5; // Show only 5 posts on the homepage only
		/*$query->query_vars['meta_query'] = array(
							'key' => 'listing_expiry_date_timestamp',
							'value' => strtotime(date('Y-m-d H:i:s')),
							'compare' => '>='
						);*/ // Show only 5 posts on the homepage only
						
			$query->set('meta_query', [
            [
                'key' => 'listing_expiry_date_timestamp',
                'value' => strtotime(date('Y-m-d H:i:s')),
                'compare' => '>='
            ]
        ]);
	}
}
// Hook my above function to the pre_get_posts action
add_action( 'pre_get_posts', 'my_modify_main_query' ); 


  /*  //2. Add validation. In this case, we make sure first_name is required.
    add_filter( 'registration_errors', 'myplugin_registration_errors', 10, 3 );
    function myplugin_registration_errors( $errors, $sanitized_user_login, $user_email ) {
        
        if ( empty( $_POST['first_name'] ) || ! empty( $_POST['first_name'] ) && trim( $_POST['first_name'] ) == '' ) {
            $errors->add( 'first_name_error', __( '<strong>ERROR</strong>: You must include a first name.', 'mydomain' ) );
        }

        return $errors;
    }*/

    //3. Finally, save our extra registration user meta.
    add_action( 'user_register', 'myplugin_user_register' );
    function myplugin_user_register( $user_id ) {
		//	echo "<pre>"; print_r($_POST); echo "</pre>"; die();
       // if ( ! empty( $_POST['company_name'] ) ) {
            update_user_meta( $user_id, 'nickname',  $_POST['company_name']  );
            /*$args = array(
				'ID'         => $user_id,
				'user_login' => $_POST['company_name'] 
			);
			wp_update_user( $args );*/
            
            
       // }
    }
/*******************************Code to validate company name instead of username on send message page [START]********************************************/
function your_function() { ?>
    <script>
		function customCoreDo(e, t) {
			var a = new AjaxRequest;
			alert(a.mRequest);
			if (a.mRequest) {
				"https:" == document.location.protocol ? e.indexOf("https:") > -1 || (e = "https://" + e) : e = "http://" + e, a.mFileName = e;
				var o = document.getElementById(t);
				a.mRequest.open("GET", e), a.mRequest.onreadystatechange = function() {
					4 == a.mRequest.readyState && 200 == a.mRequest.status && (o.innerHTML = a.mRequest.responseText)
				}
			}
			a.mRequest.send(null)
		}
		function customValidateUsername(e, t, a) {
			customCoreDo(e + "/?core_aj=1&action=ValidateUsername&id=" + t, a)
		}
    </script>

<?php }
add_action( 'wp_footer', 'your_function' );


add_action( 'init', 'custom_wlt_ajax_calls'  );



function custom_wlt_ajax_calls(){ global $wpdb, $post, $userdata, $CORE;

if(isset($_GET['core_aj']) && $_GET['core_aj'] == 1){
	
			switch($_GET['action']){

				// VALIDATE USERNAME ON THE MESSAGES PAGE
				case "ValidateUsername": {				
					if(strlen($_GET['id']) > 3){
						$dd1 = get_users(array('meta_key' => 'company_name', 'meta_value' => $_POST['username']));
						$dd = get_userdata( $dd1[0]->ID );
						
						if(isset($dd->ID)){
							echo '<img src="'.FRAMREWORK_URI.'admin/img/yes.png">';
						}else{
							echo '<img src="'.FRAMREWORK_URI.'admin/img/no.png">';
						}
					}							
				} break;					
				
			}
		
			die();	
		}
		//////////////////////////////////////////////////////////////////////////////////////	

}


/*******************************Code to validate company name instead of username on send message page [END]********************************************/
?>

