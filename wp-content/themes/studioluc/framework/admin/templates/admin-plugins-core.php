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


<div class="heading2">Recommended Core Plugins </div>

 
<?php

$plugins = array(


0 => array("title" => "Design Tool Add-ons"),


	"wlt_builder" => array("t" => "Page Builder", "d" => "This plugin allows you to create your own page layouts.", "i" => "pagebuilder.png",  ),

	"wlt_revslider" => array("t" => "Slider Plugin", "d" => "This plugin will add new slider options to your PremiumPress website.", "i" => "slider.png",  ),

 
1 => array("title" => "Import Tool Add-ons"),

	"wlt_csv" => array("t" => "CSV Import Plugin", "d" => "This plugin will let you import/export listing data via CSV.", "i" => "csv.png",  ),
	
	"wlt_youtube" => array("t" => "YouTube Video Import Plugin", "d" => "This plugin lets you import Youtube videos into your website.", "i" => "youtube.png",  ),
	
	"wlt_icodes" => array("t" => "iCodes Coupon Plugin", "d" => "This plugin lets you import coupon codes from icodes.", "i" => "icodes.png",  ),

	"wlt_amazon" => array("t" => "Amazon Import Plugin", "d" => "This plugin lets you import products from Amazon.", "i" => "amazon.png",  ),

	"wlt_ebay" => array("t" => "eBay Import Plugin", "d" => "This plugin lets you import items from eBay", "i" => "ebay.png",  ),
	
	
	"wlt_prosperent" => array("t" => "Prosperent Import Tool", "d" => "This plugin lets you import items using the Prosperent API.", "i" => "pro.png",  ),
	
	
	"wlt_datafeedrv4" => array("t" => "Prosperent Import Tool", "d" => "This plugin lets you import items using the Datafeedr v4 API.", "i" => "df.png",  ),
	
	
	"wlt_indeed" => array("t" => "Indeed Jobs Import Tool", "d" => "This plugin lets you import jobs using the Indeed API.", "i" => "indeed.png",  ),
	
	

2 => array("title" => "MISC Add-ons"),

	"wlt_terms_and_conditions" => array("t" => "Terms &amp; Conditions Plugin", "d" => "This plugin will add a terms and conditions box to your registration, login and add-listing page.", "i" => "1.png",  ),

	"wlt_website_thumbnails" => array("t" => "Website Screenshot Capture", "d" => "Capture website thumbnails for listings images with this plugin.", "i" => "2.png",  ),


	"wlt_taxonomies" => array("t" => "Taxonomies Plugin", "d" => "This plugin will add taxonomy options to your theme.", "i" => "3.png",  ),

	"wlt_shipping_ups" => array("t" => "UPS Shipping", "d" => "This plugin lets you use the UPS shipping API.", "i" => "ups.png",  ),



);


if(defined('WLT_CART')){
unset($plugins['wlt_website_thumbnails']);
unset($plugins['wlt_youtube']);
}else{
unset($plugins['wlt_shipping_ups']);
}

if(!defined('WLT_JOBS')){	
unset($plugins['wlt_indeed']);
}
 
if(!defined('WLT_COUPON')){
unset($plugins['wlt_icodes']);
}


foreach($plugins as $key => $p){ ?>

<?php if(isset($p['title'])){ ?>

<div class="heading">
<h4 class="clear heading1"><?php echo $p['title']; ?></h4>
</div>

<?php }else{ ?>

 
<div class="thumbnail1" style="  padding-bottom:10px;">

<div style="float:left; margin:10px; margin-right:20px; ">
<img src="<?php echo get_template_directory_uri(); ?>/framework/admin/img/gateways/<?php echo $p['i']; ?>" style="width:80px;" />
</div>

<h4 style="margin-top:0px;margin-bottom:0px; font-weight:bold;"><?php echo $p['t']; ?></h4>

<p><?php echo $p['d']; ?></p>
 

<a href="<?php echo home_url(); ?>/wp-admin/plugin-install.php?tab=plugin-information&plugin=<?php echo $key; ?>&TB_iframe=true&width=772&height=513" class="button btn" style="margin-top:10px;">Install Now</a>

</div>
<div class="clearfix"></div>

<?php }?>

<?php } ?>