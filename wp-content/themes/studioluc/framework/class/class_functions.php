<?php

   /*
   
   STEP 1
   INFO: THIS IS ACTIVATED ONCE THE USER SELECTS THE THEME
   
   */   
   function core_admin_0_theme_activated(){ global $wpdb;
   
		// CHECK IF THE DEFAULTS HAVE ALREADY BEEN INCLUDED
		$dd = get_option("core_admin_values");
		
		if(!isset($dd['template'])){
		
		// LOAD FRAMEWORK DEFAULTS
		$default_values = array();
		$default_values['template']			= "";
		$default_values['homepage_layout'] 	= "";
		$default_values['single_layout'] 	= "";
		$default_values['header_style_text'] = "";
		
		$default_values['register_securitycode'] = 1;
		$default_values['visitor_password'] = 1;
		
		$default_values['mailinglist']		= array("confirmation_title" => "Mailing List Confirmation", 
		"confirmation_message" => "Thank you for joining our mailing list.<br><br>Please click the link below to confirm your email address is valid:<br><br>(link)<br><br>Kind Regards<br><br>Management");
		$default_values['homepage'] 		= array("widgetblock1" => "");
		$default_values['widgetobject'] 	= array();
		$default_values['layout_columns'] 	= array('style' => 'fixed',  '2columns' => '0', 'homepage' => 1, 'search' => 1, 'single' => 1, 'page' => 1, 'search_2columns' => 2,  'page_2columns' => 2,  'single_2columns' => 2,  );
		$default_values['logo_url'] 		= "";
		$default_values['logo_text1'] 		= "Website Logo";
		$default_values['logo_text2'] 		= "Your company slogan here.";
		$default_values['logo_icon'] 		= "";
		$default_values['colors'] 			= array('body_text' => '',  'button' => '', 'breadcrumbs' => '', 'breadcrumbs_text' => '', 'header' => '',  'menubar' => '', 'adsearch' => '', 'adsearch_text' => '' );
		$default_values['copyright'] 		= "&copy; Copyright ".date("Y")." - ".get_home_url();
		$default_values['custom'] 			= array('head' => '',  'footer' => '' );
		$default_values['layout_contentwidth'] = 1;
		$default_values['home_section1'] 	= 1;
		$default_values['home_section2'] 	= 1;
		$default_values['home_section3'] 	= 1;
		$default_values['home_section4'] 	= 1;
		$default_values['home_section5'] 	= 1;
		$default_values['onelistingonly'] 	= 0;
		$default_values['search_sortby'] 	= 1;
		$default_values['layout_footer'] 	= 5;
		$default_values['language'] 		= "language_english";
		$default_values['itemcode'] 		= '[IMAGE]<div class="caption"><h1>[TITLE]</h1><div class="details"><span class="tagline">[tagline]</span><br /><div class="hidden_details">[EXCERPT]</div></div></div>'; 
		$default_values['noaccess'] 		= '<div class="well">
		<i class="fa fa-ban" style="color:red;font-size:100px;float:left; margin-right:40px;"></i>
		<div class="center"><h1 style="margin-top:0px;">No Access</h1><h4>Sorry your membership level prevents access to this listing.</h4>
		<p>Please upgrade your membership to gain access to this page.</p>
		</div></div>';  
		$default_values['listingcode']		= '';
		
		$default_values['fallback_image'] 	= FRAMREWORK_URI."img/demo/noimage.png";
		$default_values['home'] 			= array('slider' => '0');
		$default_values['responsive'] 		= 1;
		$default_values['packages'] 		= 1;
		$default_values['currency'] 		= array('symbol' => '$', 'code' => 'USD');
		$default_values['custom']['add_text'] = "";		
		
		$default_values['header_accountdetails'] = "";
		
		update_option("core_admin_values", $default_values, true);
		update_option("wlt_banners", "", true);
		 
		
		}
   
   }
   
   /*
   FUNCTION USED WHEN OUR THEME IS DEACTIVATED
   */
   function core_admin_01_theme_deactivated(){
   
    
   }
   
   
function core_admin_2_themeinstall($test=false){ global $wpdb, $CORE; $CORE->taxonomies(); $GLOBALS['theme_defaults'] = array();

 
 // NO RESET SELECTED
if($_POST['core_system_reset'] != "yes"){ 

	// FINALLY, SAVE IT ALL AND UPDATE DATABASE 		
	update_option( "core_admin_values",  array_merge((array)get_option("core_admin_values"), $_POST['admin_values'])); 	

	return; 
}
 
// SETUP A TEST ENVIROMENT FOR TESTING RESET TYPES
if(strlen($test) > 5){
	// RESET ALL CORE VALUES
	$_POST['admin_values']['template'] 		= $test;
	update_option('wlt_license_key','1234567');
	update_option("core_theme_defaults_loaded","");
	update_option("core_admin_values","");
}

// [MYSQL] DROP ALL OF THE TABLES LINKED TO OUR THEMES
$wpdb->query("delete a,b,c,d
			FROM ".$wpdb->prefix."posts a
			LEFT JOIN ".$wpdb->prefix."term_relationships b ON ( a.ID = b.object_id )
			LEFT JOIN ".$wpdb->prefix."postmeta c ON ( a.ID = c.post_id )
			LEFT JOIN ".$wpdb->prefix."term_taxonomy d ON ( d.term_taxonomy_id = b.term_taxonomy_id )
			LEFT JOIN ".$wpdb->prefix."terms e ON ( e.term_id = d.term_id )
			WHERE a.post_type ='".THEME_TAXONOMY."_type'");

// 2. DELETE ALL CATEGORIES
$terms = get_terms(THEME_TAXONOMY, 'orderby=count&hide_empty=0');	 
$count = count($terms);
if ( $count > 0 ){				
		foreach ( $terms as $term ) {
			wp_delete_term( $term->term_id, THEME_TAXONOMY );
		}
}

// [MYSQL] INSTALL MAILING LIST TABLE
$wpdb->query("DROP TABLE IF EXISTS `".$wpdb->prefix."core_log`");
$wpdb->query("CREATE TABLE IF NOT EXISTS `".$wpdb->prefix."core_log` (
	`autoid` INT( 10 ) NOT NULL AUTO_INCREMENT ,
	`datetime` DATETIME NOT NULL ,
	`userid` INT( 10 ) NOT NULL ,
	`postid` INT( 10 ) NOT NULL ,
	`link` VARCHAR( 255 ) NOT NULL ,
	`message` VARCHAR( 255 ) NOT NULL ,
	PRIMARY KEY (  `autoid` ))");
$wpdb->query("DROP TABLE IF EXISTS `".$wpdb->prefix."core_mailinglist`");
$wpdb->query("CREATE TABLE IF NOT EXISTS `".$wpdb->prefix."core_mailinglist` (
 `autoid` int(11) NOT NULL AUTO_INCREMENT,
  `email` varchar(255) NOT NULL,
  `email_hash` varchar(50) NOT NULL,
  `email_ip` varchar(50) NOT NULL,
  `email_date` datetime NOT NULL,
  `email_firstname` varchar(150) NOT NULL,
  `email_lastname` varchar(150) NOT NULL,
  `email_confirmed` int(11) NOT NULL,
  PRIMARY KEY (`autoid`),
  UNIQUE KEY `email` (`email`))");
// [MYSQL] INSTALL ORDERS TABLE
$wpdb->query("DROP TABLE IF EXISTS `".$wpdb->prefix."core_orders`");
$wpdb->query("CREATE TABLE IF NOT EXISTS `".$wpdb->prefix."core_orders` (
  `autoid` mediumint(10) NOT NULL AUTO_INCREMENT,
  `user_id` varchar(10) NOT NULL,
  `order_id` varchar(50) NOT NULL,
  `order_ip` varchar(100) NOT NULL,
  `order_date` date NOT NULL,
  `order_time` time NOT NULL,
  `order_data` longtext NOT NULL,
  `order_items` longtext NOT NULL,
  `order_email` varchar(255) NOT NULL,
  `order_shipping` varchar(10) NOT NULL,
  `order_tax` varchar(10) NOT NULL,
  `order_total` varchar(10) NOT NULL,
  `order_status` int(1) NOT NULL DEFAULT '0',
  `user_login_name` varchar(100) NOT NULL,
  `shipping_label` longtext NOT NULL,
  `payment_data` longtext NOT NULL,
  PRIMARY KEY (`autoid`));");
  
$wpdb->query("ALTER TABLE ".$wpdb->prefix."core_orders CONVERT TO CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;");

  // [MYSQL] INSTALL WITHDRAWAL TABLE
$wpdb->query("DROP TABLE IF EXISTS `".$wpdb->prefix."core_withdrawal`");
$wpdb->query("CREATE TABLE IF NOT EXISTS `".$wpdb->prefix."core_withdrawal` (
  `autoid` mediumint(10) NOT NULL AUTO_INCREMENT,
  `user_id` varchar(10) NOT NULL, 
  `user_ip` varchar(100) NOT NULL,
  `user_name` varchar(100) NOT NULL,
  `datetime` datetime NOT NULL,
  `withdrawal_comments` longtext NOT NULL,
  `withdrawal_status` int(1) NOT NULL DEFAULT '0', 
  `withdrawal_total` varchar(10) NOT NULL,  
  PRIMARY KEY (`autoid`));");

// [MYSQL] INSTALL SEARCH TABLE
$wpdb->query("DROP TABLE IF EXISTS ".$wpdb->prefix."core_search");
$wpdb->query("CREATE TABLE IF NOT EXISTS `".$wpdb->prefix."core_search` (`id` int(11) NOT NULL AUTO_INCREMENT,`label` varchar(50) NULL,`description` varchar(100) NULL,`type` varchar(10) NULL,`operator` varchar(10) NULL,`compare` varchar(10) NULL,`values` text NULL,`key` varchar(20) NULL,`alias` varchar(20) NULL,`field_type` varchar(15) NULL,`order` smallint(2) NULL,`link` varchar(100),PRIMARY KEY (`id`));");

$wpdb->query("ALTER TABLE ".$wpdb->prefix."core_search CONVERT TO CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;"); 

// [MYSQL] INSTALL SESSION TABLE FOR CART
 $wpdb->query("CREATE TABLE IF NOT EXISTS `".$wpdb->prefix."core_sessions` (
  `session_key` varchar(255) NOT NULL,
  `session_date` datetime NOT NULL,
  `session_userid` int(10) NOT NULL,
  `session_data` text NOT NULL,
  PRIMARY KEY (`session_key`));");

$wpdb->query("ALTER TABLE ".$wpdb->prefix."core_sessions CONVERT TO CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;");

	// SAMPLE DATA
	if($_POST['admin_values']['template'] != "template_dating_theme"){
	$wpdb->query("INSERT INTO ".$wpdb->prefix."core_search (`id`, `label`, `description`, `type`, `operator`, `compare`, `values`, `key`, `alias`, `field_type`, `order`, `link`) VALUES (2, 'Keyword', '', 'search', '', '', '', '', '', '', 0, NULL);");
	$wpdb->query("INSERT INTO ".$wpdb->prefix."core_search (`id`, `label`, `description`, `type`, `operator`, `compare`, `values`, `key`, `alias`, `field_type`, `order`, `link`) VALUES (3, 'Category', '', 'taxonomy', '', 'IN', '', 'listing', 'yes', 'link', 5, '');");
	}
	
	
	$no_showa = array('template_directory_theme','template_docs_theme','template_coupon_theme','template_dating_theme');
		if(!in_array($_POST['admin_values']['template'],$no_showa) ){
$wpdb->query("INSERT INTO ".$wpdb->prefix."core_search (`id`, `label`, `description`, `type`, `operator`, `compare`, `values`, `key`, `alias`, `field_type`, `order`, `link`) VALUES (4, 'Min.Price', '', 'custom', 'NUMERIC', '>=', '', 'price', 'yes', 'text', 2, NULL);");
$wpdb->query("INSERT INTO ".$wpdb->prefix."core_search (`id`, `label`, `description`, `type`, `operator`, `compare`, `values`, `key`, `alias`, `field_type`, `order`, `link`) VALUES (5, 'Max.Price', '', 'custom', 'NUMERIC', '<=', '', 'price', 'yes', 'text', 3, NULL);"); 
} 

if($_POST['admin_values']['template'] == "templater_dealer_theme"){

$wpdb->query("INSERT INTO ".$wpdb->prefix."core_search (`id`, `label`, `description`, `type`, `operator`, `compare`, `values`, `key`, `alias`, `field_type`, `order`, `link`) VALUES (6, 'Make', '', 'taxonomy', '', 'IN', '', 'make', 'yes', '', 3, 'model');"); 
$wpdb->query("INSERT INTO ".$wpdb->prefix."core_search (`id`, `label`, `description`, `type`, `operator`, `compare`, `values`, `key`, `alias`, `field_type`, `order`, `link`) VALUES (7, 'Model', '', 'taxonomy', '', 'IN', '', 'model', 'yes', '', 3, '');");

$wpdb->query("INSERT INTO ".$wpdb->prefix."core_search (`id`, `label`, `description`, `type`, `operator`, `compare`, `values`, `key`, `alias`, `field_type`, `order`, `link`) VALUES (8, 'Year', '', 'custom', 'NUMERIC', '=', '', 'year', 'yes', 'select', 3, NULL);"); 

$wpdb->query("INSERT INTO ".$wpdb->prefix."core_search (`id`, `label`, `description`, `type`, `operator`, `compare`, `values`, `key`, `alias`, `field_type`, `order`, `link`) VALUES (9, 'Type', '', 'custom', 'NUMERIC', '=', '', 'ctype', 'yes', 'select', 3, NULL);"); 

$wpdb->query("INSERT INTO ".$wpdb->prefix."core_search (`id`, `label`, `description`, `type`, `operator`, `compare`, `values`, `key`, `alias`, `field_type`, `order`, `link`) VALUES (10, 'Status', '', 'custom', 'NUMERIC', '=', '', 'cstatus', 'yes', 'select', 3, NULL);"); 

} 

if($_POST['admin_values']['template'] == "template_dating_theme"){

$wpdb->query("INSERT INTO ".$wpdb->prefix."core_search (`id`, `label`, `description`, `type`, `operator`, `compare`, `values`, `key`, `alias`, `field_type`, `order`, `link`) VALUES (2, 'I\'m a', '', 'custom', 'NUMERIC', '=', '', 'daseeking', 'yes', 'select', 3, NULL);"); 
$wpdb->query("INSERT INTO ".$wpdb->prefix."core_search (`id`, `label`, `description`, `type`, `operator`, `compare`, `values`, `key`, `alias`, `field_type`, `order`, `link`) VALUES (3, 'Seeking a', '', 'custom', 'NUMERIC', '=', '', 'dagender', 'yes', 'select', 3, NULL);");

$wpdb->query("INSERT INTO ".$wpdb->prefix."core_search (`id`, `label`, `description`, `type`, `operator`, `compare`, `values`, `key`, `alias`, `field_type`, `order`, `link`) VALUES (4, 'Aged Between', '', 'custom', 'NUMERIC', '>=', '', 'daage', 'yes', 'select', 4, NULL);"); 

$wpdb->query("INSERT INTO ".$wpdb->prefix."core_search (`id`, `label`, `description`, `type`, `operator`, `compare`, `values`, `key`, `alias`, `field_type`, `order`, `link`) VALUES (5, 'And', '', 'custom', 'NUMERIC', '<=', '', 'daage', 'yes', 'select', 5, NULL);"); 

} 
  
// [WORDPRESS] DEFAULT MEDIA OPTIONS
update_option('thumbnail_size_w', 300);
update_option('thumbnail_size_h', 350);
update_option('thumbnail_crop', 0);	 
update_option('core_post_types', ''); 
update_option('posts_per_page', '12');
update_option('recent_searches','');

// [PAGES] CREATE DEFAULT THEME PAGES
$page_links = array();
$theme_pages = array( "My Account" => "tpl-account.php", "Blog" => "tpl-blog.php", "Callback" => "tpl-callback.php", "Sample CSS" => "tpl-elements.php", "Contact" => "tpl-contact.php" );

if($_POST['admin_values']['template'] == "template_shop_theme"){
$theme_pages = array_merge($theme_pages, array("Checkout" => "tpl-checkout.php", "Contact" => "tpl-contact.php"));
}elseif($_POST['admin_values']['template'] == "template_dating_theme"){
$theme_pages =  array("My Account" => "tpl-account.php", "Blog" => "tpl-blog.php", "Callback" => "tpl-callback.php", "Add Profile" => "tpl-add.php", "Chat Room" => "tpl-chatroom.php", "Contact" => "tpl-contact.php" );
}else{
$theme_pages = array_merge($theme_pages, array("Add Listing" => "tpl-add.php", "Members" => "tpl-members.php", "Contact" => "tpl-contact.php" ));
}


foreach($theme_pages as $ntitle => $nkey){

	$page = array();
	$page['post_title'] 	= $ntitle;
	$page['post_content'] 	= '';
	$page['post_status'] 	= 'publish';
	$page['post_type'] 		= 'page';
	$page['post_author'] 	= 1;
	$page_id = wp_insert_post( $page );
	update_post_meta($page_id , '_wp_page_template', $nkey);
	$page_links[$nkey] = get_permalink($page_id);

}
if($_POST['admin_values']['template'] == "template_shop_theme"){
$GLOBALS['theme_defaults']['links']  = array('blog' => $page_links['tpl-blog.php'], 'myaccount' => $page_links['tpl-account.php'], 'callback' => $page_links['tpl-callback.php'], 'checkout' => $page_links['tpl-checkout.php'], "contact" =>  $page_links['tpl-contact.php'] );
}else{
$GLOBALS['theme_defaults']['links']  = array('blog' => $page_links['tpl-blog.php'],'myaccount' => $page_links['tpl-account.php'], 'add' => $page_links['tpl-add.php'], 'callback' => $page_links['tpl-callback.php'], 'members' => $page_links['tpl-members.php'], "contact" => $page_links['tpl-contact.php']  );
}

// [WIDGETS]
update_option('sidebars_widgets',''); $addWidget = array();
   
// FOOTER WIDGETS
$addWidget[0]['name'] = 'text';
$addWidget[0]['sidebar'] = 'sidebar-3';
$addWidget[0]['defaults'] = array('title'=>'Example Footer Widget', 'text'=>'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Praesent tempus eleifend risus ut congue. Pellentesque nec lacus elit. Pellentesque convallis nisi ac augue pharetra eu tristique neque consequat. Mauris ornare tempor nulla, vel sagittis diam convallis eget.');

$addWidget[1]['name'] = 'text';
$addWidget[1]['sidebar'] = 'sidebar-4';
$addWidget[1]['defaults'] = array('title'=>'Example Footer Widget', 'text'=>'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Praesent tempus eleifend risus ut congue. Pellentesque nec lacus elit. Pellentesque convallis nisi ac augue pharetra eu tristique neque consequat. Mauris ornare tempor nulla, vel sagittis diam convallis eget.');

$addWidget[2]['name'] = 'text';
$addWidget[2]['sidebar'] = 'sidebar-5';
$addWidget[2]['defaults'] = array('title'=>'Example Footer Widget', 'text'=>'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Praesent tempus eleifend risus ut congue. Pellentesque nec lacus elit. Pellentesque convallis nisi ac augue pharetra eu tristique neque consequat. Mauris ornare tempor nulla, vel sagittis diam convallis eget.');

$addWidget[3]['name'] = 'text';
$addWidget[3]['sidebar'] = 'sidebar-6';
$addWidget[3]['defaults'] = array('title'=>'Example Footer Widget', 'text'=>'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Praesent tempus eleifend risus ut congue. Pellentesque nec lacus elit. Pellentesque convallis nisi ac augue pharetra eu tristique neque consequat. Mauris ornare tempor nulla, vel sagittis diam convallis eget.');


// LEFT SIDEBAR WIDGET
/*
$addWidget[3]['name'] = 'core_author';
$addWidget[3]['sidebar'] = 'sidebar-2';
$addWidget[3]['defaults'] = array('title'=>'Author Widget', 'p' => true, 'e' => true, 'f2' => true, 'f1' => true, 'f3' => true, 'f4' => true);		


$addWidget[4]['name'] = 'core_widgets_listings';
$addWidget[4]['sidebar'] = 'sidebar-2';
$addWidget[4]['defaults'] = array('title'=>'Listings Widget', 'sq' => 'post_type=listing_type&posts_per_page=10', 'te' => '[TITLE]<div class="clearfix"></div>[EXCERPT size=60]', 'image' => true);		
*/

$addWidget[4]['name'] = 'advanced-search';
$addWidget[4]['sidebar'] = 'sidebar-2';
$addWidget[4]['defaults'] = array('title'=>'Advanced Search', 'submit' =>'Search');		


$addWidget[5]['name'] = 'core_widgets_categories';
$addWidget[5]['sidebar'] = 'sidebar-2';
$addWidget[5]['defaults'] = array('title'=>'Categories Widget', 'empty' => true);		


//$addWidget[7]['name'] = 'core_memberships';
//$addWidget[7]['sidebar'] = 'sidebar-2';
//$addWidget[7]['defaults'] = array('title'=>'Membership Widget');		
/*
$addWidget[8]['name'] = 'text';
$addWidget[8]['sidebar'] = 'sidebar-2';
$addWidget[8]['defaults'] = array('title'=>'Example Text Widget', 'text'=>'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Praesent tempus eleifend risus ut congue. Pellentesque nec lacus elit. Pellentesque convallis nisi ac augue pharetra eu tristique neque consequat. Mauris ornare tempor nulla, vel sagittis diam convallis eget.');		

*/

$addWidget[6]['name'] = 'core_widgets_mailinglist';
$addWidget[6]['sidebar'] = 'sidebar-2';
$addWidget[6]['defaults'] = array('title'=>'Example Newsletter Widget', 'te' => 'Your own text here to entice users to signup.', 'ff' => 2);		

// RIGHT SIDEBAR WIDGETS 
/*
$addWidget[7]['name'] = 'core_author';
$addWidget[7]['sidebar'] = 'sidebar-1';
$addWidget[7]['defaults'] = array('title'=>'Author Widget', 'p' => true, 'e' => true, 'f2' => true, 'f1' => true, 'f3' => true, 'f4' => true);		


$addWidget[11]['name'] = 'core_widgets_listings';
$addWidget[11]['sidebar'] = 'sidebar-1';
$addWidget[11]['defaults'] = array('title'=>'Listings Widget', 'sq' => 'post_type=listing_type&posts_per_page=10', 'te' => '<b>[TITLE]</b><div class="clearfix"></div> [EXCERPT size=100]', 'image' => true);		

*/

$addWidget[8]['name'] = 'advanced-search';
$addWidget[8]['sidebar'] = 'sidebar-1';
$addWidget[8]['defaults'] = array('title'=>'Advanced Search', 'submit' =>'Search');		


$addWidget[9]['name'] = 'core_widgets_categories';
$addWidget[9]['sidebar'] = 'sidebar-1';
$addWidget[9]['defaults'] = array('title'=>'Categories Widget', 'empty' => true);		


//$addWidget[14]['name'] = 'core_memberships';
//$addWidget[14]['sidebar'] = 'sidebar-1';
//$addWidget[14]['defaults'] = array('title'=>'Membership Widget');		
/*
$addWidget[10]['name'] = 'text';
$addWidget[10]['sidebar'] = 'sidebar-1';
$addWidget[10]['defaults'] = array('title'=>'Example Text Widget', 'text'=>'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Praesent tempus eleifend risus ut congue. Pellentesque nec lacus elit. Pellentesque convallis nisi ac augue pharetra eu tristique neque consequat. Mauris ornare tempor nulla, vel sagittis diam convallis eget.');		
*/

$addWidget[10]['name'] = 'core_widgets_mailinglist';
$addWidget[10]['sidebar'] = 'sidebar-1';
$addWidget[10]['defaults'] = array('title'=>'Example Newsletter Widget', 'te' => 'Your own text here to entice users to signup.', 'ff' => 2);		
 
	
	$sidebar_options = get_option('sidebars_widgets');
	
	$count=0;
	foreach($addWidget as $widget){    

		if(!isset($sidebar_options[$widget['sidebar']])){
			$sidebar_options[$widget['sidebar']] = array('_multiwidget'=>1);
		}
		$homepagewidget = get_option($widget['name']);
		
		if(!is_array($homepagewidget))$homepagewidget = array();
		$count = count($homepagewidget)+1;
		
		// add first widget to sidebar:
		$sidebar_options[$widget['sidebar']][] = $widget['name'].'-'.$count;
		
		$values[$count] = $widget['defaults'];
		
		update_option('widget_' .$widget['name'],$values);
		
		$count++;	
	}
	
	update_option('sidebars_widgets',$sidebar_options);
	
	// DEFAULT THEME SETUP
	
	/*** GEO LOCATION ***/
	$GLOBALS['theme_defaults']['geolocation'] = 1;
	
	/*** HEADER ***/
	$GLOBALS['theme_defaults']['header_welcometext']= "Your own text here.";
	//$GLOBALS['theme_defaults']['logo_url'] 			= THEME_URI."/templates/".$_POST['admin_values']['template']."/img/logo.png";
	
	/*** FOOTER ***/
	$GLOBALS['theme_defaults']['copyright'] 		= "&copy; Copyright ".date("Y")." - ".get_home_url();
	$GLOBALS['theme_defaults']['language'] 			= "language_english";
	$GLOBALS['theme_defaults']['social'] 			= array('twitter' => '##', 'facebook' => '##', 'youtube' => '##', 'dribble' => '##', 'linkedin' => '##', 'rss' => '##');
	
	/*** SEARCH/LISTINGS ***/
	$GLOBALS['theme_defaults']['display'] = array();
	$GLOBALS['theme_defaults']['display']['orderby'] = 'system';
	$GLOBALS['theme_defaults']['category_descrition'] = 1;
	$GLOBALS['theme_defaults']['related_perpage'] = 3;
	$GLOBALS['theme_defaults']['showlistingdetails'] = 1;
	$GLOBALS['theme_defaults']['layout_contentwidth'] = 1;
	
	/*** ADDTHIS SOCIAL ***/
	$GLOBALS['theme_defaults']['addthis'] = 1;
	$GLOBALS['theme_defaults']['addthis_name'] = "premiumpress";
	
	/*** INVOICE ***/
	$GLOBALS['theme_defaults']['invoice'] = array("name" => "My Company Name", "address" => "My Comapny Address");
	
	/*** RATING ***/
	$GLOBALS['theme_defaults']['rating'] = 1;
	$GLOBALS['theme_defaults']['rating_as'] = 0;
	$GLOBALS['theme_defaults']['rating_type'] = 1;
	if(defined('WLT_COUPON')){
	$GLOBALS['theme_defaults']['rating_type'] = 9;
	}
	if(defined('WLT_CART')){
	$GLOBALS['theme_defaults']['rating'] = 0;
	}
	/*** BREADCRUMBS ***/
	$GLOBALS['theme_defaults']['breadcrumbs_inner'] = 1;
	$GLOBALS['theme_defaults']['breadcrumbs_home'] = 0;
	$GLOBALS['theme_defaults']['breadcrumbs_userlinks'] = 1;
	
	/*** USER ACCOUNT SETTINGS ***/	
	$GLOBALS['theme_defaults']['show_account_edit'] 	= 1;
	$GLOBALS['theme_defaults']['message_system'] 		= 1;
	$GLOBALS['theme_defaults']['show_account_create'] 	= 1;
	$GLOBALS['theme_defaults']['show_account_viewing'] 	= 1;
	$GLOBALS['theme_defaults']['show_account_membership'] = 1;
	$GLOBALS['theme_defaults']['show_account_favs'] 	= 1;
	$GLOBALS['theme_defaults']['show_account_subscriptions'] 	= 1;
	$GLOBALS['theme_defaults']['show_account_names'] = 1;
	$GLOBALS['theme_defaults']['show_account_photo'] = 1;
	$GLOBALS['theme_defaults']['show_account_social'] = 1;
	$GLOBALS['theme_defaults']['show_profilelinks'] = 1;
	
	/**** MOBILE WEB ****/
	$GLOBALS['theme_defaults']['mobileweb_logo'] = "<span>Mobile</span> Web";
 
	
	/*** LYOUT ***/
	$GLOBALS['theme_defaults']["layout_columns"] = array('homepage' => '3', 'search' => '2', 'single' => 2, 'page' => '2', 'footer' => 5, '2columns' => '0', 'style' => 'fluid', '3columns' => '', 'contentwidth' => 1,
'homepage_2columns' => 2, 'search_2columns' => 2,  'page_2columns' => 2,  'single_2columns' => 2);
	$GLOBALS['theme_defaults']['layout_footer'] = 5;
	
 	/*** ADMIN OPTIONS ***/
	$GLOBALS['theme_defaults']['wordpress_welcomeemail'] = 0;
	$GLOBALS['theme_defaults']['admin_liveeditor'] 	= 0;
	$GLOBALS['theme_defaults']['colors'] 			= array('body_text' => '',  'button' => '', 'breadcrumbs' => '', 'breadcrumbs_text' => '', 'header' => '',  'menubar' => '', 'adsearch' => '', 'adsearch_text' => '' );
	$GLOBALS['theme_defaults']['custom'] 			= array('head' => '',  'footer' => '' );
	$GLOBALS['theme_defaults']['itemcode'] 			= '';		  
	$GLOBALS['theme_defaults']['listingcode']		= '';		
	$GLOBALS['theme_defaults']['fallback_image'] 	= FRAMREWORK_URI."img/img_fallback.jpg";
	$GLOBALS['theme_defaults']['responsive'] 		= 1;
	$GLOBALS['theme_defaults']['packages'] 			= 1;
	$GLOBALS['theme_defaults']['currency'] 			= array('symbol' => '$', 'code' => 'USD');
	$GLOBALS['theme_defaults']['mailinglist']		= array("confirmation_title" => "Mailing List Confirmation", 
		"confirmation_message" => "Thank you for joining our mailing list.<br><br>Please click the link below to confirm your email address is valid:<br><br>(link)<br><br>Kind Regards<br><br>Management");
	
	/*** PACKAGES AND MEMBERSHIPS ***/
	if(!defined('WLT_CART')){
	$GLOBALS['theme_defaults']['google'] 					= 0;
	$GLOBALS['theme_defaults']['search_sortby'] 			= 1;
	$GLOBALS['theme_defaults']['onelistingonly'] 			= 0;
	$GLOBALS['theme_defaults']['visitor_submission'] 		= 1;
	$GLOBALS['theme_defaults']['show_enhancements'] 		= 1;
	$GLOBALS['theme_defaults']['show_upgradeoptions'] 		= 1;
	$GLOBALS['theme_defaults']['default_listing_status'] 	= "publish";
	$GLOBALS['theme_defaults']['enhancement'] 		= array('1_price' => '10', '2_price' => '15', '3_price' => '10', '4_price' => '10', '5_price' => '5', '6_price' => '15');
	
	$GLOBALS['theme_defaults']['custom']['package_text'] 		= "Lorem ipsum dolor sit amet, consectetur adipiscing elit. Praesent tempus eleifend risus ut congue. Pellentesque nec lacus elit. Pellentesque convallis nisi ac augue pharetra eu tristique neque consequat. Mauris ornare tempor nulla, vel sagittis diam convallis eget.";
	
	/*** HOME PAGE OBJECTS ***/
	$GLOBALS['theme_defaults']['home_section1'] = 1;
	$GLOBALS['theme_defaults']['home_section2'] = 1;
	$GLOBALS['theme_defaults']['home_section3'] = 1;
	$GLOBALS['theme_defaults']['home_section4'] = 1;
	$GLOBALS['theme_defaults']['home_section5'] = 1;
	
	/*** TRUST AND FEEDBACK ***/
	$GLOBALS['theme_defaults']['feedback_enable'] = 1;
	$GLOBALS['theme_defaults']['feedback_trustbar'] = 1;
	
	// ADD IN USERS
	$users = array( 
	"1" => array("n" => "Mark", 	"i" => "1.jpg"),
	"2" => array("n" => "Karen", 	"i" => "2.jpg"),
	"3" => array("n" => "Jane", 	"i" => "3.jpg"),
	"4" => array("n" => "Jake", 	"i" => "4.jpg"),
	"5" => array("n" => "Frank", 	"i" => "5.jpg"),
	"6" => array("n" => "Gary", 	"i" => "6.jpg"),
	"7" => array("n" => "Sophie", 	"i" => "7.jpg"),
	"8" => array("n" => "Jamie", 	"i" => "8.jpg"),
	);
	foreach($users as $nu){
	
		// CREATE USER
		$userID = wp_create_user( $nu['n'], 'password', $nu['n'].'@hotmail.com' );
 		
		// DEFAULTS
		update_user_meta($userID, 'login_lastdate', date("Y-m-d H:i:s"));
		update_user_meta($userID, 'login_ip', $CORE->get_client_ip());
		update_user_meta($userID, 'login_count', 0);
	
		// SOCIAL
		update_user_meta($userID, 'phone', '(000) 1234 12345');		
		update_user_meta($userID, 'url', 'http://www.premiumpress.com');
		update_user_meta($userID, 'facebook', 'http://www.premiumpress.com');
		update_user_meta($userID, 'twitter', 'http://www.premiumpress.com');
		update_user_meta($userID, 'linkedin', 'http://www.premiumpress.com');
		update_user_meta($userID, 'skype', 'premiumpress');
	}
	
 	
	$pdata = array(
	"0" => array ( "enable_text" => 1, "expires" => "30", "multiple_cats_amount" => "30", "max_uploads" => "30", "ID"=>"0", "order" => "1", "price" => "10", "name" =>"Example Package 1", "subtext" => "Special Offer!", "description" => "Lorem ipsum dolor sit amet, consectetur adipiscing elit. Praesent tempus eleifend risus ut congue. Pellentesque nec lacus elit. Pellentesque convallis nisi ac augue pharetra eu tristique neque consequat. Mauris ornare tempor nulla, vel sagittis diam convallis eget.", "multiple_cats" => "1", "multiple_images" => "1",
	 "image" => FRAMREWORK_URI."img/img_package.jpg" ),
	"1" => array ( "enable_text" => 1, "expires" => "30", "multiple_cats_amount" => "30", "max_uploads" => "30", "ID"=>"1", "order" => "2", "price" => "20", "name" =>"Example Package 2", "subtext" => "Most Popular", "description" => "Lorem ipsum dolor sit amet, consectetur adipiscing elit. Praesent tempus eleifend risus ut congue. Pellentesque nec lacus elit. Pellentesque convallis nisi ac augue pharetra eu tristique neque consequat. Mauris ornare tempor nulla, vel sagittis diam convallis eget.", "multiple_cats" => "1", "multiple_images" => "1", "image" => FRAMREWORK_URI."img/img_package.jpg"  ),
	 "2" => array ( "enable_text" => 1, "expires" => "30", "multiple_cats_amount" => "30", "max_uploads" => "30", "ID"=>"2", "order" => "3", "price" => "30", "name" =>"Example Package 3", "subtext" => "Great Value!", "description" => "Lorem ipsum dolor sit amet, consectetur adipiscing elit. Praesent tempus eleifend risus ut congue. Pellentesque nec lacus elit. Pellentesque convallis nisi ac augue pharetra eu tristique neque consequat. Mauris ornare tempor nulla, vel sagittis diam convallis eget.", "multiple_cats" => "1", "multiple_images" => "1", "image" => FRAMREWORK_URI."img/img_package.jpg"  ),
	 "3" => array ( "enable_text" => 1, "expires" => "30", "multiple_cats_amount" => "30", "max_uploads" => "30", "ID"=>"3", "order" => "4", "price" => "100", "name" =>"Example Package 4", "subtext" => "Big Savings!", "description" => "Lorem ipsum dolor sit amet, consectetur adipiscing elit. Praesent tempus eleifend risus ut congue. Pellentesque nec lacus elit. Pellentesque convallis nisi ac augue pharetra eu tristique neque consequat. Mauris ornare tempor nulla, vel sagittis diam convallis eget.", "multiple_cats" => "1", "multiple_images" => "1", "image" => FRAMREWORK_URI."img/img_package.jpg"  ),
	); 
	update_option('packagefields',$pdata);

	$mdata = array(
	"0" => array ( "submissionamount" => "10", "ID"=>"0", "order" => "1", "price" => "20.99", "name" =>"Example Membership 1", "subtext" => "30 Day Membership", "description" => "Lorem ipsum dolor sit amet, consectetur adipiscing elit. Praesent tempus eleifend risus ut congue. Pellentesque nec lacus elit. Pellentesque convallis nisi ac augue pharetra eu tristique neque consequat. Mauris ornare tempor nulla, vel sagittis diam convallis eget.", "multiple_cats" => "1", "multiple_images" => "1",
	 "image" => FRAMREWORK_URI."img/img_package.jpg", "expires" => "30" ),
	"1" => array ( "submissionamount" => "20", "ID"=>"1", "order" => "2", "price" => "149.99", "name" =>"Example Membership 2", "subtext" => "90 Day Membership", "description" => "Lorem ipsum dolor sit amet, consectetur adipiscing elit. Praesent tempus eleifend risus ut congue. Pellentesque nec lacus elit. Pellentesque convallis nisi ac augue pharetra eu tristique neque consequat. Mauris ornare tempor nulla, vel sagittis diam convallis eget.", "multiple_cats" => "1", "multiple_images" => "1", "image" => FRAMREWORK_URI."img/img_package.jpg", "expires" => "90"  ),
	 "2" => array ( "submissionamount" => "30", "ID"=>"2", "order" => "3", "price" => "200", "name" =>"Example Membership 3", "subtext" => "180 Day Membership", "description" => "Lorem ipsum dolor sit amet, consectetur adipiscing elit. Praesent tempus eleifend risus ut congue. Pellentesque nec lacus elit. Pellentesque convallis nisi ac augue pharetra eu tristique neque consequat. Mauris ornare tempor nulla, vel sagittis diam convallis eget.", "multiple_cats" => "1", "multiple_images" => "1", "image" => FRAMREWORK_URI."img/img_package.jpg", "expires" => "180"  ),
	 "3" => array ( "submissionamount" => "40", "ID"=>"3", "order" => "4", "price" => "299", "name" =>"Example Membership 4", "subtext" => "1 Year Membership", "description" => "Lorem ipsum dolor sit amet, consectetur adipiscing elit. Praesent tempus eleifend risus ut congue. Pellentesque nec lacus elit. Pellentesque convallis nisi ac augue pharetra eu tristique neque consequat. Mauris ornare tempor nulla, vel sagittis diam convallis eget.", "multiple_cats" => "1", "multiple_images" => "1", "image" => FRAMREWORK_URI."img/img_package.jpg", "expires" => "365"  ),
	); 
	update_option('membershipfields',$mdata); 
	}

	// LOAD IN CORE RESET OPTIONS 
	if($_POST['admin_values']['template'] != "" && file_exists(str_replace("functions/","",THEME_PATH)."/templates/".$_POST['admin_values']['template']."/_reset.php") ){	
 
		// INCLUDE CUSTOM DATA FROM RESET FILE
		include(str_replace("functions/","",THEME_PATH)."/templates/".$_POST['admin_values']['template'].'/_reset.php');
		
		// LETS THE RESET FUNCTION HAPPEN
		do_action('hook_new_install'); 
 		
		// UPDATE BASE THEME
		update_option('wlt_base_theme',$GLOBALS['theme_defaults']['template']);
 		
	}// END IF	
	
	
	// FINALLY, SAVE IT ALL AND UPDATE DATABASE 		
	update_option( "core_admin_values",  array_merge((array)get_option("core_admin_values"), $GLOBALS['theme_defaults'])); 		
			
	$GLOBALS['error_message'] = "Example Information Installed";
 		
	 
}// END FUNCTION
   
   
   
   
   
   
   
 



	function IsNumericOnly($input)
	{
		/*  NOTE: The PHP function "is_numeric()" evaluates "1e4" to true
		 *        and "is_int()" only evaluates actual integers, not 
		 *        numeric strings. */

		return preg_match("/^[0-9]*$/", $input);
	}

	function GetAsRed($string, $inBold=false)
	{
		return GetAsColor($string, 'FF0000', $inBold);
	}

	function GetAsGreen($string, $inBold=false)
	{
		return GetAsColor($string, '279B00', $inBold);
	} 
	function GetAsColor($string, $colorHex, $inBold)
	{
		$string = ($string === false || $string === 0) ? '0' : $string;
		if($inBold) $string = '<b>'.$string.'</b>';
		return '<span style="color:#'.$colorHex.'">'.$string.'</span>';
	}
	function IsExtensionInstalled($moduleName)
	{
		// The faster "less-reliable" alternative which is not used because
		// a module (or extension) names could be in different casing, so
		// 'Mysql' should be approved even though only 'mysql' is loaded		
		## return extension_loaded($moduleName);

		// Set the module name to lower case and get all loaded extensions 
		$moduleName = strtolower($moduleName);
		$extensions = get_loaded_extensions();
		foreach($extensions as $ext)
		{
			if($moduleName == strtolower($ext))
				return true;
		}

		return false;
	}
	function wlt_system_check($echo = false, $extras=false){
	
	
		$php_extentions = array(
		'title'       =>  'PHP Requirements',
		'enabled'     =>  $extras,
		'extensions'  =>  array(
							'mysql'  => 'MySQL Databases',
							'mcrypt' => 'Encryption',
							'zlib'   => 'ZIP Archives',
							'GD'   => 'Image Editing',
							'ffmpeg'   => 'Video thumbnail Service',
							'cURL'   => 'Client URL Library', 
							'exif'   => 'Exchangeable image information',							  
							'Filter'   => 'Data Filtering', 
							'FTP'   => 'File Transfer Protocol', 
							'Hash'   => 'HASH Message Digest Framework', 
							'iconv'   => 'iconv', 
							'JSON'   => 'JavaScript Object Notation', 
							'libxml'   => 'libxml', 
							'mbstring'   => 'Multibyte String', 
							'OpenSSL'   => 'OpenSSL', 
							'PCRE'   => 'Regular Expressions (Perl-Compatible)', 
							'SimpleXML'   => 'SimpleXML', 
							'Sockets'   => 'Sockets', 
							'SPL'   => 'Standard PHP Library (SPL)', 
							'Tokenizer'   => 'Tokenizer', 
							 
		)
		);
	
		$php_directives = array
		(
			// --- BOOLEAN SETTINGS : On/Off ---
			array('title'  => 'Running Safe Mode',
				  'inikey' => 'safe_mode',
				  'mustbe' => 'Off',
				),
			array('title'  => 'Register Globals',
				  'inikey' => 'register_globals',
				  'mustbe' => 'Off',
				),
			array('title'  => 'Magic Quotes Runtime',
				  'inikey' => 'magic_quotes_runtime',
				  'mustbe' => 'Off',
				),
			 array('title'  => 'Display PHP Errors',
			 	  'inikey' => 'display_errors',
			 	  'mustbe' => 'On',
			 	),
			 //array('title'  => 'Short Open Tags',
			 //	  'inikey' => 'short_open_tag',
			 //	  'mustbe' => 'On',
			 //	),
			array('title'  => 'Automatic Session Start',
				  'inikey' => 'session.auto_start',
				  'mustbe' => 'Off',
				),
			array('title'  => 'File Uploading',
				  'inikey' => 'file_uploads',
				  'mustbe' => 'On',
				),
	
			// --- NUMERIC SETTINGS : Ints ---
			array('title'    => 'Maximum Upload File Size',
				  'inikey'   => 'upload_max_filesize',
				  'orhigher' => '10M',
				),
				
			array('title'    => 'Maximum Input Time',
				  'inikey'   => 'max_input_time',
				  'orhigher' => '60',
				),
								
			array('title'    => 'Max Simultaneous Uploads',
				  'inikey'   => 'max_file_uploads',
				  'orhigher'  => '2', 
				),
			array('title'    => 'Max Execution Time',
				  'inikey'   => 'max_execution_time',
				  'orhigher' => '100',
				),			
			array('title'    => 'Memory Capacity Limit',
				  'inikey'   => 'memory_limit',
				  'orhigher' => '32M',
				),
			array('title'    => 'POST Form Maximum Size',
				  'inikey'   => 'post_max_size',
				  'orhigher' => '16M',
				),
		);
		
	$output_string = ""; $passed_checks = true;	
	
	if($php_extentions['enabled']){
	foreach($php_extentions['extensions'] as $extKey=>$extTitle){
	
						$output_string .= '<tr>';
						$output_string .= '<td><strong>'.$extTitle.'</strong><br /><small>'.$extKey.'</small></td>';
						$output_string .= '<td>On</td>';
						if(IsExtensionInstalled($extKey)){
							$output_string .= '<td>'.GetAsGreen('On', true).'</td>';								
						}else{
							$output_string .= '<td>'.GetAsRed('Off', true).'</td>'; 
						}
						$output_string .= '</tr>';
	}
	}				
	foreach($php_directives as $idx=>$directive) {
	 
	// Prepair variables
							$current = ini_get($directive['inikey']);
							$required = '';
							$icon = 'okayico';
	
							// If this directive must be equal to something, works
							// with booleans, strings and numeric values
							if(isset($directive['mustbe']))
							{
								$required = $directive['mustbe']; 
								if($required == 'On' || $required == 'Off')
								{
									// Requirements are met
									if($current == '1' && $required == 'On')
										$current = GetAsGreen('On', true);
									else if($current != '1' && $required == 'Off')
										$current = GetAsGreen('Off', true);
	
									// Current switch is not correct
									else if($current == '1')
									{
										$current = GetAsRed('On', true);
										$icon = 'failico';
										$passed_checks = false;
									}
									else 
									{
										$current = GetAsRed('Off', true);
										$icon = 'failico';
										$passed_checks = false;
									}
								}
	
								// Any other value MUST be equal!
								else if($current == $required)
									$current = GetAsGreen($current, true);
								else
								{
									$current = GetAsRed($current, true);
									$icon = 'failico';
									$passed_checks = false;
								}
							}
	
							// or Higher/Lower only works with numeric values
							else if(isset($directive['orhigher']) || isset($directive['orlower']))
							{
							
								$current = ($current === '') ? 0 : $current;
								  
								$required = (isset($directive['orhigher'])) ? $directive['orhigher'] : $directive['orlower'];
								$reqInt = $required;
								$curInt = $current;
								settype($reqInt, 'integer');
								settype($curInt, 'integer');
	
								if(isset($directive['orhigher']))
								{
									$required = $required.' <span style="font-size:11px; color:#838383;">or more</span>';
									if($curInt >= $reqInt || $current == 0){
										$current = GetAsGreen($current, true);
									}else{								
										$current = GetAsRed($current, true);									
										$icon = 'failico';
										$passed_checks = false;
									}
								}
								else if(isset($directive['orlower']))
								{
									$required = $required.' <span style="font-size:11px; color:#838383;">or less</span>';
									if($curInt <= $reqInt){
									
										$current = GetAsGreen($current, true);
										
									}else{
									
										$current = GetAsRed($current, true);
										$icon = 'failico';
										$passed_checks = false;
									}
								}
							}
					
	
							
							$output_string .= '<tr>';
							$output_string .= '<td style="font-size:12px;"><strong title="'.$directive['inikey'].'">'.$directive['title'].'</strong><br /><small>'.$directive['inikey'].'</small></td>';
							$output_string .= '<td>'.$required.'</td>';
							$output_string .= '<td>'.$current.'</td>';	
							$output_string .= '</tr>';
									
	}	
	
	if($echo){
		echo '<table class="table table-bordered" style="background:#fff;">';
		echo '<tr><td><strong>Directive Title</strong></td><td>Required</td><td><span style="color:#279B00"><b>Current</b></span></td></tr>';
		echo $output_string;
		echo '</table>';
		if(!$passed_checks){
		echo "<p class='alert alert-warning'><b>Your hosting setup needs adjusting</b><br>Contact your webserver support (hosting service) to get the necessary PHP settings fixed.</p>";
		}
	}else{
		if($passed_checks){
		return true;
		}else{
		return false;
		}
	}
	}























class wlt_admin_paginator {
    var $items_per_page;
    var $items_total;
    var $current_page;
    var $num_pages;
    var $mid_range;
    var $low;
    var $high;
    var $limit;
    var $return;
	var $pagelink;
    var $default_ipp = 25;
 
    function Paginator()
    {
        $this->current_page = 1;
        $this->mid_range = 7;
        $this->items_per_page = (!empty($_GET['ipp'])) ? $_GET['ipp']:$this->default_ipp;
    }
 
    function paginate()
    {
		if(!isset($_GET['ipp'])){ $_GET['ipp'] = 20; }
		
        if(isset($_GET['ipp']) && $_GET['ipp'] == 'All')
        {
            $this->num_pages = ceil($this->items_total/$this->default_ipp);
            $this->items_per_page = $this->default_ipp;
        }
        else
        {
            if(!is_numeric($this->items_per_page) OR $this->items_per_page <= 0) $this->items_per_page = $this->default_ipp;
            $this->num_pages = ceil($this->items_total/$this->items_per_page);
        }
		if(!isset($_GET['cpage'])){ $_GET['cpage'] =1; }
		
        $this->current_page = (int) $_GET['cpage']; // must be numeric > 0
        if($this->current_page < 1 Or !is_numeric($this->current_page)) $this->current_page = 1;
        if($this->current_page > $this->num_pages) $this->current_page = $this->num_pages;
        $prev_page = $this->current_page-1;
        $next_page = $this->current_page+1;
 
        if($this->num_pages > 10)
        {
            $this->return = ($this->current_page != 1 And $this->items_total >= 10) ? "<a class=\"paginate\" href=\"".$this->pagelink."&cpage=$prev_page&ipp=$this->items_per_page\">Previous</a> ":"<a class=\"inactive\" href=\"#\">Previous</a>";
 
            $this->start_range = $this->current_page - floor($this->mid_range/2);
            $this->end_range = $this->current_page + floor($this->mid_range/2);
 
            if($this->start_range <= 0)
            {
                $this->end_range += abs($this->start_range)+1;
                $this->start_range = 1;
            }
            if($this->end_range > $this->num_pages)
            {
                $this->start_range -= $this->end_range-$this->num_pages;
                $this->end_range = $this->num_pages;
            }
            $this->range = range($this->start_range,$this->end_range);
 
            for($i=1;$i<=$this->num_pages;$i++)
            {
                if($this->range[0] > 2 And $i == $this->range[0]) $this->return .= " ... ";
                // loop through all pages. if first, last, or in range, display
                if($i==1 Or $i==$this->num_pages Or in_array($i,$this->range))
                {
                    $this->return .= ($i == $this->current_page And $_GET['cpage'] != 'All') ? "<a title=\"Go to page $i of $this->num_pages\" class=\"current\" href=\"#\">$i</a> ":"<a class=\"paginate\" title=\"Go to page $i of $this->num_pages\" href=\"".$this->pagelink."&cpage=$i&ipp=$this->items_per_page\">$i</a> ";
                }
                if($this->range[$this->mid_range-1] < $this->num_pages-1 And $i == $this->range[$this->mid_range-1]) $this->return;
            }
            $this->return .= (($this->current_page != $this->num_pages And $this->items_total >= 10) And ($_GET['cpage'] != 'All')) ? "<a class=\"paginate\" href=\"".$this->pagelink."&cpage=$next_page&ipp=$this->items_per_page\">Next</a>\n":"<a class=\"inactive\" href=\"#\">Next</a>\n";
            $this->return .= ($_GET['cpage'] == 'All') ? "<a class=\"current\" style=\"margin-left:10px\" href=\"#\">All</a> \n":"<a class=\"paginate\" href=\"".$this->pagelink."&cage=1&ipp=All\">All</a> \n";
        }
        else
        {
            for($i=1;$i<=$this->num_pages;$i++)
            {
                $this->return .= ($i == $this->current_page) ? "<a class=\"current\" href=\"#\">$i</a>":"<a class=\"btn btn-default\" href=\"".$this->pagelink."&cpage=$i&ipp=$this->items_per_page\">$i</a>";
            }
            $this->return .= "<a class=\"paginate\" href=\"".$this->pagelink."&cpage=1&ipp=All\">All</a> \n";
        }
        $this->low = ($this->current_page-1) * $this->items_per_page;
        $this->high = ($_GET['ipp'] == 'All') ? $this->items_total:($this->current_page * $this->items_per_page)-1;
        $this->limit = ($_GET['ipp'] == 'All') ? "":" LIMIT $this->low,$this->items_per_page";
    }
 
    function display_items_per_page()
    {
        $items = '';
        $ipp_array = array(10,25,50,100,'All');
        foreach($ipp_array as $ipp_opt)    $items .= ($ipp_opt == $this->items_per_page) ? "<option selected value=\"$ipp_opt\">$ipp_opt</option>\n":"<option value=\"$ipp_opt\">$ipp_opt</option>\n";
        return "<span class=\"btn btn-default\">Items per page:</span><select class=\"paginate\" onchange=\"window.location='".$this->pagelink."&cpage=1&ipp='+this[this.selectedIndex].value;return false\">$items</select>\n";
    }
 
    function display_jump_menu()
    {
        for($i=1;$i<=$this->num_pages;$i++)
        {
            $option .= ($i==$this->current_page) ? "<option value=\"$i\" selected>$i</option>\n":"<option value=\"$i\">$i</option>\n";
        }
        return "<span class=\"paginate\">Page:</span><select class=\"paginate\" onchange=\"window.location='".$this->pagelink."&cpage='+this[this.selectedIndex].value+'&ipp=$this->items_per_page';return false\">$option</select>\n";
    }
 
    function display_pages()
    {
        return $this->return;
    }
}




?>