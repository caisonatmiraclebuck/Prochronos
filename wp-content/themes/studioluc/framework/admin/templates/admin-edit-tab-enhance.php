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
if (!defined('THEME_VERSION')) {	header('HTTP/1.0 403 Forbidden'); exit; } global $CORE_ADMIN;


// LOAD IN MAIN DEFAULTS 
$core_admin_values = get_option("core_admin_values");  
  
?> 
 
<?php
$features_list = array (
"tab2" => array("tab" => true, "title" => "Listing Enhancements" ),
 
	"topcategory" => array("label" => "Top of category", "desc" => "This will place the listing at the top of its respective category.",  "values" =>array("no"=>"no", "yes"=>"yes" ) ), 	
	"featured" => array("label" => "Featured", "desc" => "This will highlight the listing in the search resilts page.",  "values" =>array("no"=>"no", "yes"=>"yes" ) ), 	
	"html" => array("label" => "HTML Listings", "desc" => "This will enable the listing to be edited using the HTML editor.",  "values" =>array("no"=>"no", "yes"=>"yes" ) ), 	
	"visitorcounter" => array("label" => "Show Visitor Graph", "desc" => "This will show a visitor graph at the bottom of the listing page for the author of the listing.",  "values" =>array("no"=>"no", "yes"=>"yes" ) ), 	
	"showgooglemap" => array("label" => "Google Map", "desc" => "This will show the Google map on the listing page if a valid map location is set below (see google map).",  "values" =>array("no"=>"no", "yes"=>"yes" ) ), 	
 	
);
 

$features_list  = hook_fieldlist_2($features_list);
// DISPLAY OUTPPIT
$CORE_ADMIN->buildadminfields($features_list);
?>
 