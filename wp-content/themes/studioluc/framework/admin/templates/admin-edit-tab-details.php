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
if (!defined('THEME_VERSION')) {	header('HTTP/1.0 403 Forbidden'); exit; } global $CORE_ADMIN, $CORE;


// LOAD IN MAIN DEFAULTS 
$core_admin_values = get_option("core_admin_values");    $packagefields = get_option("packagefields"); if(!is_array($packagefields)){ $packagefields = array(); }
  
?> 
 
<?php if(!defined('WLT_CART')){ ?>
<a href="admin.php?page=5&tab=submission"  class="button" style="float:right;margin-bottom:-30px; font-weight:bold;">Add Custom Field</a>	
<?php } ?>
<?php
$basic_list = array (
"tab10" => array("tab" => true, "title" => "Listing Package" ), 
"packageID" => array("label" => "Listing Package", "desc" => "This is the listing package value.", "values" => $packagefields ),  
); 
$full_list_of_fields = hook_fieldlist_0($basic_list);

$expiry_list = array ( 
"tab3" => array("tab" => true, "title" => "Claim Listing Feature" ),
	"claimme" => array("label" => "Hide Claim Option?", "desc" => "Set this value to no if you want to <u>hide</u> the claim listing button on this listing.",  "values" =>array("no"=>"no", "yes"=>"yes" ) ),
	
);
$full_list_of_fields = array_merge($full_list_of_fields,hook_fieldlist_1($expiry_list));

 
// REMOVE CLAIM LISTING IF NOT ENABLED WITHIN THE SYSTEM
if(isset($core_admin_values['visitor_claimme']) && $core_admin_values['visitor_claimme'] != 1){
	unset($full_list_of_fields['tab3']);
	unset($full_list_of_fields['claimme']);
}

// DISPLAY OUTPPIT
$CORE_ADMIN->buildadminfields($full_list_of_fields);
?> 
 



<?php if(!defined('WLT_CART')){ ?>
<table style="width:100%;"> 
<tbody>    
<?php $_GET['eid'] = $post->ID; echo $CORE->CORE_FIELDS(false,true); ?> 
</tbody></table>
<?php } ?> 