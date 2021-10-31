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
}?>