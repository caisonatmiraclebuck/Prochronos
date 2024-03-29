<?php
/* =============================================================================
   THIS FILE SHOULD NOT BE EDITED
   ========================================================================== */ 
class white_label_themes { 

	// SET THE ACCEPTED FILE TYPES
  	public $allowed_image_types = array('image/jpg','image/jpeg','image/gif','image/png');		
	public $allowed_video_types = array('video/x-flv', 'video/mp4', 'video/webm', 'video/ogg');
	public $allowed_music_types = array('audio/mpeg','audio/mp3');
	public $allowed_doc_types = array('application/pdf','application/msword','application/octet-stream');
	
	public $wlt_emails_alerts = array(
		
		"wlt_alert_login_success" 	=> array("n" => "User Login {success}"),
		"wlt_alert_login_failed" 	=> array("n" => "User Login {failed}"),
		"wlt_alert_register" 		=> array("n" => "User Register"),
		"wlt_alert_listing_new" 	=> array("n" => "Listing {new}"),
		"wlt_alert_listing_edit" 	=> array("n" => "Listing {edit}"),
		
	);
	
	// SELL SPACE AREAS
	public $sellspace = array(	
		"header468" => array(		 
			"n" => "Header",
			"sw" => "468",
			"sh" => "60",
			"p"	=> "header",
			"min" => 1,
			"max" => 1,
		),
		"under728" => array(		 
			"n" => "Premium Leaderboard",
			"sw" => "728",
			"sh" => "90",
			"p" => "full_top",
			"min" => 1,
			"max" => 1,
		),
		
		"undermiddle728" => array(		 
			"n" => "Content Top Leaderboard",
			"sw" => "728",
			"sh" => "90",
			"p" => "middle_top",
			"min" => 1,
			"max" => 1,
		),
 
		"sidebarright125bot" => array(		 
			"n" => "Sidebar Right Bottom",
			"sw" => "125",
			"sh" => "125",
			"p" => "sidebar_right_bottom",
			"min" => 4,
			"max" => 4,
		),	
		
	 
		"sidebarleft125bot" => array(		 
			"n" => "Sidebar Left Bottom",
			"sw" => "125",
			"sh" => "125",
			"p" => "sidebar_left_bottom",
			"min" => 4,
			"max" => 4,
		),	
		
		"sidebarleft290100top" => array(		 
			"n" => "Sidebar Left Top",
			"sw" => "290",
			"sh" => "100",
			"p" => "sidebar_left_top",
			"min" => 1,
			"max" => 1,
		),
		
		"sidebarright290100top" => array(		 
			"n" => "Sidebar Right Top",
			"sw" => "290",
			"sh" => "100",
			"p" => "sidebar_right_top",
			"min" => 1,
			"max" => 1,
		),
				
		"sidebarright360bot" => array(		 
			"n" => "Sidebar Right Bottom",
			"sw" => "360",
			"sh" => "300",
			"p" => "sidebar_right_bottom",
			"min" => 1,
			"max" => 1,
		),	 	
		
		"sidebarleft360bot" => array(		 
			"n" => "Sidebar Left Bottom",
			"sw" => "360",
			"sh" => "300",
			"p" => "sidebar_left_bottom",
			"min" => 1,
			"max" => 1,
		),	
		
		"sidebarright290bot" => array(		 
			"n" => "Sidebar Right Bottom",
			"sw" => "290",
			"sh" => "100",
			"p" => "sidebar_right_bottom",
			"min" => 1,
			"max" => 1,
		),	
		
		"sidebarleft290bot" => array(		 
			"n" => "Sidebar Left Bottom",
			"sw" => "290",
			"sh" => "100",
			"p" => "sidebar_left_bottom",
			"min" => 1,
			"max" => 1,
		),
				
	);
	 
	
	function my_theme_setup(){	
 	
		load_theme_textdomain('premiumpress', get_template_directory() . '/languages'); ///'.get_locale().'.mo'
	}
	
	// HOOKS EVERYTHING TOGETHER
	function __construct(){ global $wpdb;	
	  
		//CHECK FOR OUTBOUT LINKS		
		if(strpos($_SERVER['REQUEST_URI'], "/out/") !== false) {	
		 
			$bb = explode("out/",$_SERVER['REQUEST_URI']);
			$bb1 = explode("/",$bb[1]);
							
			if(strlen($bb1[1]) > 1){
				$GLOBALS['out_post_id'] = $bb1[0];
				 
				// UPDATE CLICK COUNTER
				update_post_meta($bb1[0], 'clicks', get_post_meta($bb1[0], 'clicks', true) + 1 );
				
				// GET LIST
				$link = get_post_meta($bb1[0], $bb1[1], true);		
				$link = hook_outbound_link($link);	
				
				
				if(strpos($link, "http") === false){
				$link = "http://".$link;
				}			
				 
				// REDIRECT				 
				header("location:".$link, true ,301);
				exit;
				
			}		 
		}elseif (strpos($_SERVER['REQUEST_URI'], "/confirm/") !== false) {
			$bb = explode("confirm/",$_SERVER['REQUEST_URI']);			
			if (strpos($bb[1], "unsubscribe/") !== false) {
			
				$be = explode("unsubscribe/",$bb[1]);
				$wpdb->query("DELETE FROM ".$wpdb->prefix."core_mailinglist WHERE email = ('".esc_sql(strip_tags($be[1]))."') LIMIT 1");
				// REDIRECT USER		
				header("location: ".get_option('mailinglist_unsubscribe_thankyou'));
				exit();
			}elseif (strpos($bb[1], "mailinglist/") !== false) {
				$be = explode("mailinglist/",$bb[1]);
				$wpdb->query("UPDATE ".$wpdb->prefix."core_mailinglist SET email_confirmed=1 WHERE email_hash = ('".esc_sql(strip_tags($be[1]))."') LIMIT 1");
				// REDIRECT USER		
				header("location: ".get_option('mailinglist_confirmation_thankyou'));
				exit();
			}		 
		}
	 
		// CORE DATE/TIMEZONE
		$TIMEZONE = get_option('timezone_string');
		if(strlen($TIMEZONE) > 1){
		date_default_timezone_set($TIMEZONE);
		}		
		// REMOVE OPEN SANDS
		add_action( 'wp_enqueue_scripts', array($this, 'wp_enqueue_scripts') );		
		add_action( 'admin_enqueue_scripts', array($this, 'wp_enqueue_scripts') );
		// SETUP LANGUAGE SUPPORT
		add_action('after_setup_theme', array($this, 'my_theme_setup' ));
		//REMOVE HEADER DISPLAYS
		remove_action( 'wp_head', 'feed_links_extra', 3 ); //Extra feeds such as category feeds
		remove_action( 'wp_head', 'feed_links', 2 ); // General feeds: Post and Comment Feed
		remove_action( 'admin_enqueue_scripts', 'wp_auth_check_load' );
		remove_action( 'wp_head', 'rsd_link' );
		remove_action( 'wp_head', 'wp_generator');
		remove_action( 'wp_head', 'start_post_rel_link' ,10, 0 );
		remove_action( 'wp_head', 'adjacent_posts_rel_link' ,10, 0 );
		remove_action( 'wp_head', 'wlwmanifest_link' );		
		remove_action( 'wp_head', 'print_emoji_detection_script', 7 ); 
		remove_action( 'wp_print_styles', 'print_emoji_styles' );		
		remove_action( 'wp_head', 'adjacent_posts_rel_link_wp_head', 10, 0);		
		remove_action( 'woocommerce_sidebar', 'woocommerce_get_sidebar', 10); //  WooCommerce	
		// ADD ON AJAX CALLS
		add_action( 'init', 'wlt_ajax_calls'  );
		// HOOK UPLOAD AND PRICE FOR AJAX CALLS
		add_action( 'hook_custom_queries', array($this, 'CUSTOMQUERY') );
		add_action( 'hook_wlt_core_search', array($this, '_core_search_extras' ) );
   		add_action( 'hook_upload', array($this, 'UPLOAD') );
 		add_action( 'hook_price', array($this, 'PRICE') );
 		add_action( 'hook_date', array($this, 'DATE') );
		add_action( 'hook_logo', array($this, 'Logo') );	
		// EMAIL SETTINGS
		add_filter('wp_mail_from_name', array($this, '_fromname' ));
		add_filter('wp_mail_from', array($this, '_fromemail' ));
		// COMMENTS PROCESSING
		add_action('wp_insert_comment',  array($this, 'insert_comment_extra') ); 
		add_filter('comment_post_redirect', array( $this, 'redirect_after_comment' ) );
		add_filter( 'preprocess_comment', array($this, '_preprocess_comment' ) );	
		// PRESS THIS TYPE
		add_filter('shortcut_link', array($this, 'press_this_ptype') , 11);		
		// HIDE ADMIN
		if(isset($_GET['hideadminbar'])){
		add_filter( 'show_admin_bar', '__return_false' );
		}
		// FIX TEXT WIDGET TITLE;
		add_filter( 'widget_title', array($this, 'widget_title_link' ) );
		// Take over the update check
		add_filter('pre_set_site_transient_update_plugins', array($this,'check_for_plugin_update' ));
		add_filter('pre_set_site_transient_update_themes', array($this,'check_for_theme_update' ));		
		// Take over the Plugin info screen
		add_filter('plugins_api', array($this, 'plugin_api_call' ), 10, 3);			 	
 		add_filter('themes_api', array($this, 'themes_api_call' ), 10, 3);
		// ADD ON MENU EDITOR 
		add_action('admin_bar_menu', array($this, 'wlt_adminbar_menu_items' ), 50);
		// ADD IN DEFAULTS FOR MOBILE DISPLAY
		add_action('hook_mobile_content_listing_output', array($this, 'mobilelistingcotent' ) );
		add_action('hook_mobile_content_output', array($this, 'mobilesearchcontent' ) );	
		add_action('hook_mobile_header', array($this, 'mobile_header' ) );
		add_action('hook_mobile_footer', array($this, 'mobile_footer' ) );
		// REGISTER CUSTOMIZER
		add_action( 'customize_register' , array( 'wlt_core_customerize' , 'register' ), 20 );	
		add_action( 'wp_head' , array( 'wlt_core_customerize' , 'header_output' ) ); 
		// LOAD IN CONFIG AND CORE WORDPRESS FUNCTIONALITY
		$this->constants();
		$this->globals();
		$this->functions();
		$this->theme_support();	
		$this->register_widgets();
		$this->taxonomies();
		$this->default_filters(); 
		 
	} 
	// REMOVE UNWANTED QUERIES
	function fix_queries_2( $query ) { global $wpdb;
	 
		if ( is_home() && strpos($query,"SELECT $wpdb->posts.*") !== false){
		 
			$query = false;
		} 
		return $query;
	}
	
 
	// START CONSTANTANTS	 
	function constants(){ 	
		
		$f = wp_get_theme();	
		// GET THE MAIN THEME SETTINGS
		if(!isset($GLOBALS['CORE_THEME'])){		 
		$GLOBALS['CORE_THEME'] = get_option("core_admin_values");			
			// SOME DEFAULTS
			if(!isset($GLOBALS['CORE_THEME']['content_layout'])){ $GLOBALS['CORE_THEME']['content_layout'] = "listing"; }
			if(!isset($GLOBALS['CORE_THEME']['single_layout'])){ $GLOBALS['CORE_THEME']['single_layout'] = "listing"; }
			
			
			// CHECK FOR MOBILE VIEW		 
			if( defined('WLT_ENABLE_MOBILEWEB') && isset($GLOBALS['CORE_THEME']['mobileweb']) && $GLOBALS['CORE_THEME']['mobileweb'] == '1' && $this->isMobileDevice() ){
				define('IS_MOBILEVIEW', true);
			}
			
			// DEMO CONTENT	 
			if(defined('WLT_DEMOMODE') &&  ( $GLOBALS['CORE_THEME']['template'] != "template_video_theme"  ) ){
		 		 
					$demopath = "http://wlthemes.com/democontent/".$GLOBALS['CORE_THEME']['template']."/";
					
					if(defined('WLT_CHILDTHEME') && isset($GLOBALS['CORE_THEME']['sampledata']) ){
					
					}else{
					$GLOBALS['CORE_THEME']['sampledata'] = array(		
					"1" => array("t" => $demopath."1.jpg", "f" => $demopath."1.jpg"),
					"2" => array("t" => $demopath."2.jpg", "f" => $demopath."2.jpg"),
					"3" => array("t" => $demopath."3.jpg", "f" => $demopath."3.jpg"),
					"4" => array("t" => $demopath."4.jpg", "f" => $demopath."4.jpg"),
					"5" => array("t" => $demopath."5.jpg", "f" => $demopath."5.jpg"),
					"6" => array("t" => $demopath."6.jpg", "f" => $demopath."6.jpg"),
					"7" => array("t" => $demopath."7.jpg", "f" => $demopath."7.jpg"),
					"8" => array("t" => $demopath."8.jpg", "f" => $demopath."8.jpg"),
					"9" => array("t" => $demopath."9.jpg", "f" => $demopath."9.jpg"),
					"10" => array("t" => $demopath."10.jpg", "f" => $demopath."10.jpg"),
					"11" => array("t" => $demopath."11.jpg", "f" => $demopath."11.jpg"),
					"12" => array("t" => $demopath."12.jpg", "f" => $demopath."12.jpg"),
					"13" => array("t" => $demopath."13.jpg", "f" => $demopath."13.jpg"),
					"14" => array("t" => $demopath."14.jpg", "f" => $demopath."14.jpg"),
					"15" => array("t" => $demopath."15.jpg", "f" => $demopath."15.jpg"),
					"16" => array("t" => $demopath."16.jpg", "f" => $demopath."16.jpg"),			
					); 
					}
				
			}
			
		}
		// THEME VERSION 
		define("THEME_VERSION", "8.9.5");		
		// RELEASE DATE
		define("THEME_VERSION_DATE", "20th Aug, 2016");		
		// THEME INSTALL LINK
		define("THEME_URI", get_template_directory_uri() );		
		// THEME INSTALL PATH
		define("THEME_PATH", TEMPLATEPATH."/");	  
		// FRAMEWORK LINKS	 
		define("FRAMREWORK_URI", get_template_directory_uri()."/framework/" );			  	
		// ACTIVE THEME LINK
		if(isset($GLOBALS['CORE_THEME']) && isset($GLOBALS['CORE_THEME']['template']) ){
		define("ACTIVE_THEME_URI", get_template_directory_uri()."/templates/".$GLOBALS['CORE_THEME']['template']."/" ); 
	 	}
		// SLOW QUERY CACHING
		if(isset($GLOBALS['CORE_THEME']['querycaching']) && $GLOBALS['CORE_THEME']['querycaching'] == 1){
		define('WLT_CACHING',true); 
		}else{
		define('WLT_CACHING',false); 
		}		 
		// CHILD THEME NAME	
		if(isset($GLOBALS['CORE_THEME']['template']) && $f->stylesheet != $GLOBALS['CORE_THEME']['template'] && strlen($f->stylesheet) > 3 && $f->stylesheet != "WLTHEMES"){		 
			define("CHILD_THEME_NAME", $f->stylesheet);				
			define("CHILD_THEME_PATH_URL", get_home_url().'/wp-content/themes/'.CHILD_THEME_NAME.'/');
			define("CHILD_THEME_PATH_IMG", get_home_url().'/wp-content/themes/'.CHILD_THEME_NAME.'/img/');
			define("CHILD_THEME_PATH_JS", get_home_url().'/wp-content/themes/'.CHILD_THEME_NAME.'/js/');
			define("CHILD_THEME_PATH_CSS", get_home_url().'/wp-content/themes/'.CHILD_THEME_NAME.'/css/');		
			define("CHILD_THEME_APTH", get_home_url().'/wp-content/themes/'.CHILD_THEME_NAME.'/css/');	 	 
		}elseif(isset($GLOBALS['CORE_THEME']['template'])){			 
			define("CORE_THEME_PATH_URL", get_template_directory_uri()."/templates/".$GLOBALS['CORE_THEME']['template']."/");
			define("CORE_THEME_PATH_IMG", get_template_directory_uri()."/templates/".$GLOBALS['CORE_THEME']['template']."/img/");
			define("CORE_THEME_PATH_JS", get_template_directory_uri()."/templates/".$GLOBALS['CORE_THEME']['template']."/js/");
			define("CORE_THEME_PATH_CSS", get_template_directory_uri()."/templates/".$GLOBALS['CORE_THEME']['template']."/css/");	
		}
		// CHECK FOR CUSTOM LANGUAGE FILE
		if(file_exists($f->theme_root."/".$f->stylesheet."/language_english.php")){
		define("CUSTOM_LANGUAGE_FILE", $f->theme_root."/".$f->stylesheet."/language_english.php");	
		}	 
		
	}
	
	
	function mobile_header(){ }
	function mobile_footer(){ }
	function mobilelistingcotent(){ 
	if(isset($GLOBALS['CUSTOMMOBILECONTENT'])){ return; }	
	global $post, $userdata, $CORE; 
	 
		// CAN WE DISPLAY LINK BOX
		if( get_post_meta($post->ID,'url',true) != ""){
			$canShowLink = true;
		}
	
	?>
	
	<?php if($post->post_author == $userdata->ID){ ?><a href="[EDIT]">Edit</a><?php } ?>
	
	<div class="listingblock"> 
	
        <h1>[TITLE]</h1>
         
        <div class="text-center">[IMAGES]</div>
        
    	<ul class="menulist">
            
            <?php if($canShowLink){ ?>                
            <li><a href="<?php echo home_url(); ?>/out/<?php echo $post->ID; ?>/url/" rel="noindex" target="_blank"><?php echo $CORE->_e(array('button','12')); ?></a></li>
            <?php } ?>
                        
            <li>[FAVS]</li>                  
            
            <?php if(!defined('WLT_COMPARISON')){ ?>             
            <li>[CONTACT style=1 class=""]</li>
            <?php } ?> 
           
        
        </ul>
        
        <hr />
        
        <?php if(defined('WLT_MICROJOB')){ ?>
        <style>
		#infobarbox li { width:100% !important;}
		</style>
        [INFOBAR]
    	<hr />
     	[BUYBAR]
        <hr />
        
        <?php }elseif(defined('WLT_COMPARISON')){ ?>
        [COMPARISONTABLE] 
        <?php }else{ ?>
        [FIELDS]
        <?php } ?>
        
        <b>{Description}</b>
        
        [CONTENT] 
        
        [GOOGLEMAP]
	
	</div>
	
	<?php } 
	function mobilesearchcontent(){	
	if(isset($GLOBALS['CUSTOMMOBILECONTENT'])){ return; }
	?>
    
	<div class="wrap">
    
    	[IMAGE]
    
		<h2>[TITLE]</h2>
        
        [LOCATION] 
    	
        <?php if(defined('WLT_CART')){ ?> <div> [price]</div> <?php } ?>
        
    	[EXCERPT size=60]
        
        
       
	
	</div>
    
    <div class="clearfix"></div>
    
	<div class="bmbox">
    
    <?php if(defined('WLT_MICROJOB')){ ?>
     
     
       <div class="row">
       		<div class="col-md-5 col-xs-5">[price] </div>
        	<div class="col-md-7 col-xs-7 text-right">  [SALES] Sales </div> 
        </div>
    
    <?php }elseif(defined('WLT_DATING')){?>
    [GENDER] / [daage] / [COUNTRY] [ONLINESTATUS]
    <?php }else{ ?>
        <div class="row">
       		<div class="col-md-5 col-xs-5"> <?php if(defined('WLT_CLASSIFIEDS') || defined('WLT_REALTOR') ){ ?> [price]  <?php }else{ ?> [RATING size=16 style=1] <?php } ?> </div>
        	<div class="col-md-7 col-xs-7 text-right">[DISTANCE] </div> 
        </div>
    <?php } ?>
	</div>
    
	<?php }
	
	
	
	
	
	
	// DEBUG EMAIL OPTION
	function debug_wpmail($query){
	if(defined('WLT_DEBUG_EMAIL')){
		echo "<div style='background:#fafafa; border:1px solid #ddd; padding:15px;'>";
		foreach($query as $k=>$p){
			if(is_array($p)){
			print_r($p);
			}else{
			echo $k.": ".$p."<br />";
			}
		}
		echo "</div>";
		die();
	}
	return $query;
	} 
	

	
	
	
	
	function googlelink(){
	
	$region = "us"; $lang = "en"; $extra = "";
	if(isset($GLOBALS['CORE_THEME']['google_lang'])){
		$region = $GLOBALS['CORE_THEME']['google_region'];
		$lang = $GLOBALS['CORE_THEME']['google_lang'];
	}
	if(isset($GLOBALS['tpl-add'])){
	$extra = "&v=3.exp&libraries=places";
	}
	
	return 'https://maps.googleapis.com/maps/api/js?language='.$lang.'&amp;region='.$region.$extra."&key=".trim(stripslashes($GLOBALS['CORE_THEME']['googlemap_apikey']));

	}
	
	function wp_enqueue_scripts(){	
	
	// REMOVE OPEN SANDS FONTS
	wp_deregister_style( 'open-sans' );
    wp_register_style( 'open-sans', false );
    wp_enqueue_style('open-sans','');
	
	}
	// ADDED FOR ADMIN EDITING BUT MAYBE USEFUL ELSEWHERE
	function randattachmentid(){
		global $wpdb;
		$id = (int)$wpdb->get_var("SELECT ID FROM $wpdb->posts WHERE post_type =  'attachment' ORDER BY rand() LIMIT 1");
		return $id;
	}

 	// EMAIL FROM
	function _fromname($email){
		return get_option('emailfrom');
	}
	function _fromemail($email){
		$admin_email = get_option('admin_email');
		if($admin_email == ""){
			return $email;
		}else{
			return $admin_email;
		}		
	}
 	// SUPPORT MINE TYPES
	function my_myme_types($mime_types){
			$mime_types['flv'] 	= 'video/x-flv';
			$mime_types['mp4'] 	= 'video/mp4';
			$mime_types['webm'] = 'video/webm';
			$mime_types['mpeg'] = 'audio/mpeg';
			$mime_types['mp3'] 	= 'audio/mp3';				
			$mime_types['ogg'] 	= 'video/ogg';
			$mime_types['pdf'] 	= 'application/pdf';	
			$mime_types['zip']  = 'application/octet-stream';			
			$mime_types['doc']  = 'application/msword';					 		
			//unset($mime_types['flv']); //Removing the pdf extension		
			return $mime_types;
	}
	// START GLOBALS
	function globals() {
	 
		// GET THE MAIN THEME SETTINGS
		if(!isset($GLOBALS['CORE_THEME'])){
		$GLOBALS['CORE_THEME'] = get_option("core_admin_values");
		}
		// DEMO OPTIONS FOR DEVELOPERS
		if(defined('WLT_DEMOMODE')){
			//@session_destroy();
			// SET SESSION TO CARRY STHEME SESSION VALUE
			@session_start();
			// SET DEFAULT SKIN
			if(!isset($_SESSION['default_skin'])){ $_SESSION['default_skin'] = $GLOBALS['CORE_THEME']['template']; }
			// DEMO THEME SETUP
			if(isset($_REQUEST['skin'])){	
				$GLOBALS['CORE_THEME']['template'] 			= "template_".strip_tags($_REQUEST['skin']);
				$_SESSION['skin'] 							= $GLOBALS['CORE_THEME']['template'];
			}elseif(isset($_SESSION['skin'])){
				$GLOBALS['CORE_THEME']['template'] 			= strip_tags($_SESSION['skin']);				 
			}
		 
			// PATHS FOR CHILD THEMES			
			if(isset($GLOBALS['CORE_THEME']['template']) && strlen($GLOBALS['CORE_THEME']['template']) > 1){
			define("CHILD_THEME_PATH_URL", get_home_url().'/wp-content/themes/'.$GLOBALS['CORE_THEME']['template'] .'/');
			define("CHILD_THEME_PATH_IMG", get_home_url().'/wp-content/themes/'.$GLOBALS['CORE_THEME']['template'] .'/img/');
			define("CHILD_THEME_PATH_JS", get_home_url().'/wp-content/themes/'.$GLOBALS['CORE_THEME']['template'] .'/js/');
			define("CHILD_THEME_PATH_CSS", get_home_url().'/wp-content/themes/'.$GLOBALS['CORE_THEME']['template'] .'/css/');	
			}
			  
			if($_SESSION['default_skin'] == "template_classifieds_theme"){
				define('WLT_CLASSIFIEDS',true);	
							
			}elseif($_SESSION['default_skin'] == "template_coupon_theme"){						 
				// HIDE PRICE SEARCH
				define('DEFAULTS_PRICE_SEARCH',true);
				// INCLUDE THE CORE COUPON TOOLS
				define('WLT_COUPON',true);				
			}elseif($_SESSION['default_skin'] == "template_shop_theme"){
				// INCLUDE THE CORE CART TOOLS
				define('WLT_CART',true);			
			}elseif($_SESSION['default_skin'] == "template_music_theme"){
				// ADD IN AUDIO BOX		
			}elseif($_SESSION['default_skin'] == "template_auction_theme"){						
				// INCLUDE THE CORE AUCTION TOOLS
				define('WLT_AUCTION',true);
			}elseif($_SESSION['default_skin'] == "template_comparison_theme"){						
				// INCLUDE THE CORE COMPARISON TOOLS
				define('WLT_COMPARISON',true);
			}elseif($_SESSION['default_skin'] == "template_ideas_theme"){						
				// INCLUDE THE CORE COMPARISON TOOLS
				define('WLT_IDEAS',true);
			}elseif($_SESSION['default_skin'] == "template_docs_theme"){						
				// INCLUDE THE CORE COMPARISON TOOLS
				define('WLT_DOCS', true);		
				// DISABLE ADMIN EDIT FILES COLUMN
				define('WLT_DISABLE_ADMIN_EDIT_FILES', true); 		
			}elseif($_SESSION['default_skin'] == "template_joboard_theme"){						
				// INCLUDE THE CORE COMPARISON TOOLS
				define('WLT_JOBS',true);
				define('DEFAULTS_IMAGE_UPLOAD', false);
			}elseif($_SESSION['default_skin'] == "template_dealer_theme"){						
				// INCLUDE THE CORE DEALER TOOLS
				define('WLT_DEALER',true);
			}elseif($_SESSION['default_skin'] == "template_microjob_theme"){				
				define('WLT_MICROJOB',true);
			}elseif($_SESSION['default_skin'] == "template_directory_theme"){				
				define('WLT_DIRECTORY',true);
			}elseif($_SESSION['default_skin'] == "template_business_theme"){				
				define('WLT_BUSINESS',true);
			}elseif($_SESSION['default_skin'] == "template_realestate_theme"){				
				define('WLT_REALTOR',true);
			}elseif($_SESSION['default_skin'] == "template_classifieds_theme"){				
				define('WLT_CLASSIFIEDS',true);
			}elseif($_SESSION['default_skin'] == "template_dating_theme"){				
				define('WLT_DATING',true);				
			}elseif($_SESSION['default_skin'] == "template_software_theme"){						
				// INCLUDE THE CORE DEALER TOOLS
				define('WLT_DOWNLOADTHEME',true);
			}// end if				
						 
		}	// end if	
			 
	}
	// START FUNCTION CALLS
	function functions() {
  	
		// BRING IN GLOBALS
		//$this->globals(); 
		$f = wp_get_theme();
	 
		
		// CHECK FOR A THEME FUNCTION FILE		
		if(isset($GLOBALS['CORE_THEME']['template']) && $GLOBALS['CORE_THEME']['template'] != "" ){	
		  
			// FIRST CHECK CHILD THEME FUNCTIONS
			if(!defined('WLT_DEMOMODE') && defined('CHILD_THEME_NAME') && file_exists(WP_CONTENT_DIR."/themes/".CHILD_THEME_NAME."/_functions.php")){			
				include(WP_CONTENT_DIR."/themes/".CHILD_THEME_NAME."/_functions.php");
			
			// NEXT CHECK THE DEMO
			}elseif( defined('WLT_DEMOMODE') && isset($_SESSION['skin']) && file_exists(WP_CONTENT_DIR."/themes/".$_SESSION['skin']."/_functions.php") ){				
				include(WP_CONTENT_DIR."/themes/".$_SESSION['skin']."/_functions.php");
				$GLOBALS['CORE_THEME']['template'] = $_SESSION['skin'];
			
			// NEXT CHECK THE DEMO
			}elseif( defined('WLT_DEMOMODE') && isset($_SESSION['skin']) && file_exists(WP_CONTENT_DIR."/themes/".$_SESSION['skin']."/functions.php") ){				
				include(WP_CONTENT_DIR."/themes/".$_SESSION['skin']."/functions.php");
				$GLOBALS['CORE_THEME']['template'] = $_SESSION['skin'];
				
			// NOW CHECK THE CORE THEME
			}elseif(!defined('CHILD_THEME_NAME') && file_exists(str_replace("functions/","",THEME_PATH)."/templates/".$GLOBALS['CORE_THEME']['template']."/_functions.php") ){		
				include(str_replace("functions/","",THEME_PATH)."/templates/".$GLOBALS['CORE_THEME']['template'].'/_functions.php');			
			}// end if
 			 	 
		} 
		
		
	
		// CORE TAXONOMY NAME
		if(!defined('THEME_TAXONOMY') || (defined('THEME_TAXONOMY') && THEME_TAXONOMY < 2 )){
				 	
			$ThisTheme = trim(get_option('wlt_base_theme'));
		 
			switch($ThisTheme){
					
					case "template_classifieds_theme": {
						if(!defined('WLT_CLASSIFIEDS')){ define('WLT_CLASSIFIEDS',true); }									 			
					} break;
					case "template_coupon_theme": {
						if(!defined('WLT_COUPON')){ define('WLT_COUPON',true); }
					} break;
					case "template_video_theme": {
						if(!defined('WLT_VIDEO')){ define('WLT_VIDEO',true); }			 			
					} break;
					case "template_auction_theme": {
						if(!defined('WLT_AUCTION')){ define('WLT_AUCTION',true); }			 			
					} break;					
					case "template_comparison_theme":{
						if(!defined('WLT_COMPARISON')){ define('WLT_COMPARISON',true); }						
					} break;					
					case "template_shop_theme":{
						if(!defined('WLT_CART')){ define('WLT_CART',true); }			 		 
					} break;					
					case "template_docs_theme":{
						if(!defined('WLT_DOCS')){ define('WLT_DOCS', true); }
						define('WLT_DISABLE_ADMIN_EDIT_FILES', true);			 			
					} break;					
					case "template_directory_theme":{
						if(!defined('WLT_DIRECTORY')){ define('WLT_DIRECTORY',true); }							
					} break;					
					case "template_joboard_theme":{
						if(!defined('WLT_JOBS')){ define('WLT_JOBS',true); }						
					} break;					
					case "template_dating_theme":{
						if(!defined('WLT_DATING')){ define('WLT_DATING',true); }							
					} break;					
					case "template_dealer_theme":{
						if(!defined('WLT_DEALER')){ define('WLT_DEALER',true); }							
					} break;					
					case "template_business_theme":{
						if(!defined('WLT_BUSINESS')){ define('WLT_BUSINESS',true); }						
					} break;					
					case "template_realestate_theme":{
						if(!defined('WLT_REALTOR')){ define('WLT_REALTOR',true); }							
					} break;					
					case "template_classifieds_theme":{
						if(!defined('WLT_CLASSIFIEDS')){ define('WLT_CLASSIFIEDS',true); }						
					} break;					
					case "template_microjob_theme": {
						if(!defined('WLT_MICROJOB')){ define('WLT_MICROJOB',true); }						
					} break;					
					case "template_dating_theme":{
						if(!defined('WLT_DATING')){ define('WLT_DATING',true); }						
					} break;					
					case "template_software_theme":{
						if(!defined('WLT_DOWNLOADTHEME')){ define('WLT_DOWNLOADTHEME',true); }						
					} break;
				 	 
				} 
			 
		}		
		// LOAD IN GATEWAYS
		require_once TEMPLATEPATH ."/framework/class/class_gateways.php";
		// SEARCH CLASS
		require_once TEMPLATEPATH ."/framework/class/class_search.php";

	} 
	// START THEME SUPPORT	
	function theme_support() { 	 
		// MENU
		add_theme_support('nav_menus');
		register_nav_menu( 'top-navbar', 'Top Navigation');
		register_nav_menus( array('primary' => 'Main Navigation' ) );	
		register_nav_menu( 'footer-menu', 'Footer Links' );		
		// THUMBNAILS
		add_theme_support( 'post-thumbnails' );			 
		// CUSTOM BACKGROUNDS 
		//add_theme_support( 'custom-background' );	
		//add_theme_support( 'custom-header' );		 
		// GLOBAL SUPPORT FOR SELECTIVE WIDGET MENUS
		add_action('init', array('wf_wn', 'init')); 
		// MEMBERSHIPS ON REGISTRATION PAGE
		add_action('register_form', array($this,'_show_memberships_on_registration'));
 	
	}
 
	// REGISTER WIDGETS
	function register_widgets(){ global $pagenow, $page;
	  
 		// ADD IN ADVANCED SEARCH
		add_action( 'widgets_init', create_function( '', "register_widget('Core_Advanced_Search_Widget');" ) );
		
		if ( function_exists('register_sidebar') ){		
			//RIGHTSIDEBAR
			register_sidebar(array('name'=>'Right Column',
				'before_widget' => '<div class="panel panel-default">',
				'after_widget' 	=> '<div class="clearfix"></div></div></div>',
				'before_title' 	=> '<div class="panel-heading">',
				'after_title' 	=> '</div><div class="panel-body widget">',
				'description' => '',
				'id'            => 'sidebar-1',
			));
			// LEFT SIDEBAR
			register_sidebar(array('name'=>'Left Column',
				'before_widget' => '<div class="panel panel-default">',
				'after_widget' 	=> '<div class="clearfix"></div></div></div>',
				'before_title' 	=> '<div class="panel-heading">',
				'after_title' 	=> '</div><div class="panel-body widget">',
				'description' => '',
				'id'            => 'sidebar-2',
			));
			// FOOTER COLUMN WIDGETS
			register_sidebar(array('name'=>'Footer Left',
				'before_widget' => '<div class="footer-block">',
				'after_widget' 	=> '</div></div>',
				'before_title' 	=> '<div class="footer-block-title">',
				'after_title' 	=> '</div><div class="footer-block-content">',
				'description' => '',
				'id'            => 'sidebar-3',
			));
			// FOOTER
			register_sidebar(array('name'=>'Footer Middle',
				'before_widget' => '<div class="footer-block">',
				'after_widget' 	=> '</div></div>',
				'before_title' 	=> '<div class="footer-block-title">',
				'after_title' 	=> '</div><div class="footer-block-content">',
				'description' => '',
				'id'            => 'sidebar-4',
			));
			// FOOTER
			register_sidebar(array('name'=>'Footer Right',
				'before_widget' => '<div class="footer-block">',
				'after_widget' 	=> '</div></div>',
				'before_title' 	=> '<div class="footer-block-title">',
				'after_title' 	=> '</div><div class="footer-block-content">',
				'description' => '',
				'id'            => 'sidebar-5',
			));
			// FOOTER
			register_sidebar(array('name'=>'Forth Right (if enabled)',
				'before_widget' => '<div class="footer-block">',
				'after_widget' 	=> '</div></div>',
				'before_title' 	=> '<div class="footer-block-title">',
				'after_title' 	=> '</div><div class="footer-block-content">',
				'description' => '',
				'id'            => 'sidebar-6',
			)); 
			
			// SET THE UNREGISTER WIDGET FLAG
			add_action( 'widgets_init', array($this, 'unregister_widgets' ) );	
		
		}	
	}
	// START REMOVING WIDGETS FROM WP
	function unregister_widgets() {	 global $wpdb;
 		
		// SAVE QUERIES // DISABLE WIDGETS HOME PAGE PAGE
		if ( isset($GLOBALS['flag-home']) && $GLOBALS['CORE_THEME']['layout_columns']['homepage'] != 3 ) { 	

			// UNREGISTER ALL WP QUERIES AND SAVE 5+ QUERIES
			unregister_widget('WP_Widget_Pages');
			unregister_widget('WP_Widget_Calendar');
			unregister_widget('WP_Widget_Archives');
			unregister_widget('WP_Widget_Links');
			unregister_widget('WP_Widget_Meta');
			unregister_widget('WP_Widget_Search');
			unregister_widget('WP_Widget_Categories');
			unregister_widget('WP_Widget_Recent_Posts');
			unregister_widget('WP_Widget_Recent_Comments');
			unregister_widget('WP_Widget_Tag_Cloud');
			unregister_widget('WP_Widget_RSS');
			unregister_widget('WP_Widget_Akismet');
			unregister_widget('WP_Nav_Menu_Widget');			
		
		}else{
		
			//unregister_widget('WP_Widget_Pages');
			unregister_widget('WP_Widget_Calendar');
			unregister_widget('WP_Widget_Archives');
			unregister_widget('WP_Widget_Links');
			unregister_widget('WP_Widget_Meta');
			//unregister_widget('WP_Widget_Search');
			//unregister_widget('WP_Widget_Categories');
			//unregister_widget('WP_Widget_Recent_Posts');
			//unregister_widget('WP_Widget_Recent_Comments');
			unregister_widget('WP_Widget_Tag_Cloud');
			//unregister_widget('WP_Widget_RSS');
			unregister_widget('WP_Widget_Akismet');
			unregister_widget('WP_Nav_Menu_Widget');
				
			// REGISTER CORE WIDGETS
			register_widget( 'core_widgets_blank' );
			register_widget( 'core_widgets_categories' );
			register_widget( 'core_widgets_listings' );	
			register_widget( 'core_widgets_mailinglist' );			
			register_widget( 'core_widgets_comments' );
			register_widget( 'core_widgets_blogposts' );
			register_widget( 'core_widgets_googlemap' );
			register_widget( 'core_widgets_tabs' );
			register_widget( 'core_widgets_displayextras' );
			
			if(!defined('WLT_CART')){
			register_widget( 'core_widgets_author' ); 
			}	
		}
 
		 
	}	
	// START TAXONOMIES
	function taxonomies(){
		// CHECK WE HAVE ENABLED THEME SETTINGS
		if(is_array($GLOBALS['CORE_THEME'])){	
		 
		
			// CUSTOM SLUG
			if(strlen(get_option('premiumpress_custompermalink')) > 1){ $listing_slug_name = get_option('premiumpress_custompermalink'); }else{ $listing_slug_name = THEME_TAXONOMY; }	
		 
	 		if(strlen(get_option('premiumpress_customcategorypermalink')) > 1){ $cat_slug_name = get_option('premiumpress_customcategorypermalink'); }else{ $cat_slug_name = $listing_slug_name."-category"; }	
			
			// REGISTER MAIN LISTING TAXONOMY			
			$listing_title = "Listing";
			if(isset($GLOBALS['CORE_THEME']['template'])){
				switch($GLOBALS['CORE_THEME']['template']){				
					case "template_coupon_theme": {
						 $listing_title = "Coupon"; 
					} break;
					case "template_shop_theme": {
						 $listing_title = "Product"; 
					} break;
					case "template_auction_theme": {
						 $listing_title = "Auction"; 
					} break;
					case "template_video_theme": {
						 $listing_title = "Video"; 
					} break;
				}
			}
			
			// SHOW UI OPTIONS
			$showUI = true;
			if(get_option('wlt_license_key') == ""){ $showUI = false; }			
			
			// WP CODE TO REGISTER 			 
			register_taxonomy( THEME_TAXONOMY, THEME_TAXONOMY.'_type', array( 	
			 
			'labels' => array(
				'name' => 'Categories' ,
				'singular_name' =>  $listing_title.' Category',
				'search_listings' =>   'Search '.$listing_title.' Categorys' ,
				'popular_listings' =>  'Popular '.$listing_title.' Categorys' ,
				'all_listings' => 'All '.$listing_title.' Categorys' ,
				'parent_listing' => null,
				'parent_listing_colon' => null,
				'edit_listing' =>'Edit '.$listing_title.' Category' , 
				'update_listing' =>  'Update '.$listing_title.' Category' ,
				'add_new_listing' =>  'Add '.$listing_title.' Category' ,
				'new_listing_name' => 'New '.$listing_title.' Category Name' ,
				'separate_listings_with_commas' => 'Separate '.$listing_title.' Categorys with commas' ,
				'add_or_remove_listings' =>  'Add or remove '.$listing_title.' Categorys',
				'choose_from_most_used' =>  'Choose from the most used '.$listing_title.' Categorys' 
				) , 
					'hierarchical' => true,	
					'query_var' => true,
					'show_ui' => $showUI,
					'has_archive' => true, 
					'rewrite' => array('slug' => $cat_slug_name) ) ); 
	 
			// CORE LISTING POST TYPE			
			register_post_type( THEME_TAXONOMY.'_type',
				array(
				  'labels' 				=> array('name' => $listing_title.' Manager', 'singular_name' => 'listings' ), 
				  'rewrite'				=>  array('slug' => $listing_slug_name ),
				  'public' 				=> true,
				  'publicly_queryable'  => true,
				  'supports' 			=> array ( 'title', 'editor','author', 'post-formats', 'comments','excerpt', 'thumbnail', 'custom-fields', 'publicize', 'wpcom-markdown' ),
				  'taxonomies' => array('category', 'post_tag'),
				  'menu_icon' 			=> get_template_directory_uri()."/framework/admin/img/icons/listing.png", 
				  'show_ui'             => $showUI,
				  'menu_position'		=> 4,
				  'show_in_menu'        => true,
        		  'show_in_nav_menus'   => true,
				 				  
				)
			  );
			 
			// MESSAGES POST TYPE
			register_post_type( 'wlt_message', 
			array(
			'hierarchical' => true,	
			  'labels' => array('name' => 'Messages'),
			  'public' => false,
			  'query_var' => true,
			  'show_ui' => false,
			  'exclude_from_search' => true,
			  'rewrite' => array('slug' => 'message'),
			  'supports' => array (  'custom-fields' ),	    
	 
			) );
			
			
			if(isset($GLOBALS['CORE_THEME']['sellspace_enable']) && $GLOBALS['CORE_THEME']['sellspace_enable'] == 1){ $canShowAds = true; }else{  $canShowAds = false; }
			 // MESSAGES POST TYPE
			register_post_type( 'wlt_banner', 
			array(
			'hierarchical' => true,	
			  'labels' => array('name' => 'Banners'),
			  'public' => false,
			  'query_var' => true,
			  'show_ui' => $canShowAds,
			  'exclude_from_search' => true,
			  'menu_icon' 	=> get_template_directory_uri()."/framework/admin/img/icons/banners.png",
			  'rewrite' => array('slug' => 'banner'),
			  'supports' => array (  'custom-fields','author' ),	    
	 
			) );
			
			register_post_type( 'wlt_campaign', 
			array(
			'hierarchical' => true,	
			  'labels' => array('name' => 'Campaigns'),
			  'public' => false,
			  'query_var' => true,
			  'show_ui' => $canShowAds,
			  'menu_icon' 	=> get_template_directory_uri()."/framework/admin/img/icons/campaign.png",
			  'exclude_from_search' => true,
			  //'rewrite' => array('slug' => 'campaign'),
			  'supports' => array (  'custom-fields','author'  ),	    
	 
			) );
			
			// FEEDBACK POST TYPE
			if(!defined('WLT_CART')){
			
			if(ISSET($GLOBALS['CORE_THEME']['feedback_enable']) && $GLOBALS['CORE_THEME']['feedback_enable'] == 1){ $canShowAds = true; }else{  $canShowAds = false; }
			
			register_post_type( 'wlt_feedback', 
			array(
			'hierarchical' => true,	
			  'labels' => array('name' => 'User Feedback'),
			  'public' => false,
			  'query_var' => true,
			  'show_ui' => false,
			  'menu_icon' 	=> "dashicons-heart",
			  'exclude_from_search' => true,
			  'rewrite' => array('slug' => 'feedback'),
			  'supports' => array (  'title', 'editor', 'author', 'custom-fields' ),	    
	 
			) );
			}		 
			
						  
	}// END IF	
	
	}
	// WORDPRESS FLTERS
	function default_filters() {
	
		// PAGE TITLE FILTER
		add_filter( 'wp_title', array( $this, 'TITLE' ), 10, 2 );
		add_filter('wpseo_title', array( $this, 'TITLE' ), 10, 2 );
		// DEBUG EMAIL
		add_filter('wp_mail', array($this,'debug_wpmail') ); 
		// CUSTOM MIME TYPES
		add_filter('upload_mimes', array($this, 'my_myme_types')  );		
		// REMOVE ADMIN BAR FROM NON-ADMINS
		if(!current_user_can('administrator')){
		add_filter( 'show_admin_bar', '__return_false' );
		}		
		// ONLY INCLUDE POSTS IN YOUR SEARCH RESULTS 
		add_filter( 'pre_get_posts', array($this, '_pre_get_posts'),999 );
		add_filter( 'posts_orderby', array($this, '_posts_orderby') , 999);		
		// FIX QUERIES 
		add_action( 'posts_request', array($this, 'fix_queries_2' ) );		
		// EXTRA SEARCH QUERY	
		add_filter( 'posts_distinct', array($this, '_distinct_sql'),  20 );
		add_filter( 'posts_where', array($this, '_posts_where') ); 
		add_filter( 'posts_join', array($this, 'query_join') );
		add_filter( 'request', array($this, 'my_request_filter' ) );		
		// SETUP FOR EDITING POSTS
		add_action( 'init', array($this, 'wlt_edit_own_caps') );	
		// Disables Kses only for textarea saves
		foreach (array('pre_term_description', 'pre_link_description', 'pre_link_notes') as $filter) {
			remove_filter($filter, 'wp_filter_kses');
		}
		// Disables Kses only for textarea admin displays
		foreach (array('term_description', 'link_description', 'link_notes') as $filter) {
			remove_filter($filter, 'wp_kses_data');
		}
		// ADJUST BODY CLASS
		add_filter('body_class', array($this, 'BODYCLASS' ));
	}
 	
	
	// PRESS THIS CHANGE
	function press_this_ptype($link) {		
		$link = str_replace('press-this.php', "post-new.php?post_type=".THEME_TAXONOMY."_type", $link);
		$link = str_replace('?u=', '&u=', $link);	
		return $link;
	}
	
	function CUSTOMFIELD_LIST($field,$selected="",$isTranslation=1){ global $wpdb, $CORE; $STRING = ""; $in_array = array(); $statesArray = array();	
 						
				$SQL = "SELECT DISTINCT ".$wpdb->postmeta.".meta_value FROM ".$wpdb->postmeta." 
				INNER JOIN ".$wpdb->posts." ON (".$wpdb->postmeta.".post_id = ".$wpdb->posts.".ID AND ".$wpdb->posts.".post_type = 'listing_type' AND ".$wpdb->posts.".post_status='publish'  )
				WHERE ".$wpdb->postmeta.".meta_key = ('".strip_tags($field)."') LIMIT 0,100";
				
				if ( WLT_CACHING == false || ( $query = get_transient( 'customfieldlist_query2_'.$field) ) === false   ) {
 
					$query = $wpdb->get_results($SQL, OBJECT);
					set_transient( 'customfieldlist_query2_'.$field, $query, 24 * HOUR_IN_SECONDS );
				}
				
				if(!empty($query)){
				
					// LOOK DATA
					foreach($query as $val){
				 
							// ADD TO ARRAY
							$in_array[] 	= $val->meta_value;
							$statesArray[] .= $val->meta_value;
					 
					}				 						  
					
					// NOW RE-ORDER AND DISPLAY				
					asort($statesArray);					 
					foreach($statesArray as $state){ 
							if(strlen($state) < 2){ continue; }
							if($isTranslation != 1){ $label = $CORE->_e(array($isTranslation,$state)); }else{ $label = $state; }
							
							if($field == "map-country" && isset($GLOBALS['core_country_list'][$state]) ){ $label = $GLOBALS['core_country_list'][$state]; }
							
							if($selected != "" &&  $state == $selected){							
							$STRING .= "<option value='".$state."' selected=selected>". $label."</option>";
							}else{
							$STRING .= "<option value='".$state."'>". $label."</option>";
							} // end if	
					}					
					
				}
				
				return $STRING;	
	
	}
	// ADDITONAL SQL FOR QUERY
	function _distinct_sql( $val ) { global $wpdb;
	 	
		  
		
		// DEFAULTS
		if(isset($_SESSION['mylocation']['lat']) && strlen($_SESSION['mylocation']['lat']) > 0 && strlen($_SESSION['mylocation']['log']) > 0 ){				
			$lat = strip_tags($_SESSION['mylocation']['lat']);
			$log = strip_tags($_SESSION['mylocation']['log']);
		}else{				
			$lat = "0";
			$log = "0";
		}
		
		if(isset($GLOBALS['CORE_THEME']['geolocation']) && $GLOBALS['CORE_THEME']['geolocation'] != "" && !isset($_GET['favs']) && isset($_GET['orderby']) && $_GET['orderby'] == "distance"  ){
		 	  
				return "DISTINCT $wpdb->posts.ID, IFNULL( 3956 * 2 * ASIN(SQRT( POWER(SIN((t1.meta_value - ".$lat." ) *  pi()/180 / 2), 2) +COS(t1.meta_value * pi()/180) * COS(".$lat." * pi()/180) * POWER(SIN((t2.meta_value - ".$log.") * pi()/180 / 2), 2) )), 999999) as distance, ";
			 
		}
		
		if(isset($_GET['zipcode']) && isset($_GET['radius']) && is_numeric($_GET['radius']) ){
		
		return "DISTINCT"; 
		}
		
	 
		return $val;		
	}
	// WORDPRESS JOIN QUERY
	function query_join($arg) {
	global $wpdb, $query, $userdata; 
	  
		// ADD-ON BID APPLY
		if(isset($_GET['bidapply']) && $_GET['bidapply'] == 1){	
		$arg .= "INNER JOIN $wpdb->postmeta AS wlt1 ON (  $wpdb->posts.ID = wlt1.meta_value AND wlt1.meta_key = 'bida_".$userdata->ID."'  ) ";
		}	
		 
		// ADD-ON ZIP CODE SEARCH 
		if(isset($_GET['zipcode']) && ( strlen($_GET['zipcode']) > 2 && strlen($_GET['zipcode']) < 9 ) ){
			
			// CLEANUP
			$thisZip = esc_attr($_GET['zipcode']);
			
			// SAVED ZIP DATA
			$saved_searches = get_option('wlt_saved_zipcodes');
			
			if(isset($saved_searches[$thisZip]) && strlen($saved_searches[$thisZip]['log']) < 1 && strlen($saved_searches[$thisZip]['lat']) < 1){			
					 		
			}else{
			 
				$arg .= "INNER JOIN $wpdb->postmeta AS wlt1 ON ( $wpdb->posts.ID = wlt1.post_id ) ";
				
				if(isset($_GET['radius']) && is_numeric($_GET['radius']) && $_GET['radius'] != 0){
					$arg .= "INNER JOIN $wpdb->postmeta AS wlt2 ON ( $wpdb->posts.ID = wlt2.post_id ) ";
				}	
			
			} 
		}
		 
		// ADD-ON DISTANCE		
		if( isset($GLOBALS['CORE_THEME']['geolocation']) && $GLOBALS['CORE_THEME']['geolocation'] != "" && !isset($_GET['favs']) && isset($_GET['orderby']) && $_GET['orderby'] == "distance"  ){
 
				$arg .= "INNER JOIN $wpdb->postmeta AS t1 ON ($wpdb->posts.ID = t1.post_id AND t1.meta_key = 'map-lat' ) ";
				$arg .= "INNER JOIN $wpdb->postmeta AS t2 ON ($wpdb->posts.ID = t2.post_id AND t2.meta_key = 'map-log') ";	

		}
	 
	return $arg; 	
	}		
 

	// WORDPRESS WHERE QUERY
	function _posts_where($q){ global $wpdb; $GLOBALS['this_query_where'] = $q;	
 
		// DONT PERFORM ON ADMIN SEARCHES
		if(is_admin()){ return $q; }
	
		// SLOW QUERY REMOVE PRIVATE
		$q = str_replace("OR $wpdb->posts.post_status = 'private'","", $q);
		
		// FIX FOR LISTING WITH A SINGLE TITLE AND NOT FOUND IN SEARCH RESULTS
		$q = str_replace("$wpdb->posts.post_title LIKE '% %'","$wpdb->posts.post_title LIKE '%%'", $q);
		
		// ADD-ON FOR GEO LOCATION
		if(isset($GLOBALS['CORE_THEME']['geolocation']) && $GLOBALS['CORE_THEME']['geolocation'] != "" && !isset($_GET['favs']) && isset($_GET['orderby']) && $_GET['orderby'] == "distance"  ){
	
				  $q .= " AND (   t1.post_id IS NULL   OR  t1.meta_key = 'map-lat' )"; 
				  $q .= " AND (   t2.post_id IS NULL   OR  t2.meta_key = 'map-log' )"; 		
		}
  
	 	// ADD-ON FOR AUTHOR SEARCHES
		if(isset($_GET['s']) && is_numeric($_GET['s']) ){
			$q .= " OR $wpdb->posts.ID ='".strip_tags($_GET['s'])."' 
			OR ( $wpdb->posts.post_author ='".strip_tags($_GET['s'])."' AND $wpdb->posts.post_type = '".THEME_TAXONOMY."_type' AND $wpdb->posts.post_status = 'publish' )";
		}
		
		// ADD-ON FOR ZIPCODE SEARCHES
		if(isset($_GET['zipcode']) && ( strlen($_GET['zipcode']) > 2 && strlen($_GET['zipcode']) < 9 ) ){	 
		
			// CLEANUP
			$thisZip = esc_attr($_GET['zipcode']);
			
			// SAVED DATA
			$saved_searches = get_option('wlt_saved_zipcodes');
			$range = 0; // range in KM	
			
			if(isset($_GET['radius']) && is_numeric($_GET['radius']) && $_GET['radius'] != 0){
			$range = $_GET['radius'];
			}
			
			if($range > 0){
						 
				if(isset($saved_searches[$thisZip]) && strlen($saved_searches[$thisZip]['log']) > 1 && strlen($saved_searches[$thisZip]['lat']) > 1){			
					$longitude 	= $saved_searches[$thisZip]['log'];
					$latitude 	= $saved_searches[$thisZip]['lat'];				
				}else{
					// INCLUDE COUNTRY IF AVAILABLE 
					$extra = "";
					if(isset($_GET['map-country'])){
					$extra = ", ".strip_tags($_GET['map-country']);
					}
					// REGION/LANGUAGE ADDONS
					$region = "us"; $lang = "en";
					if(isset($GLOBALS['CORE_THEME']['google_lang'])){
						$region = $GLOBALS['CORE_THEME']['google_region'];
						$lang = $GLOBALS['CORE_THEME']['google_lang'];
					}
					
					if($region != "us"){ $extra .= "+".$region; } 
					
					$geocode = file_get_contents('https://maps.google.com/maps/api/geocode/json?address='. urlencode($thisZip.$extra) .'&sensor=false&region='.$region.'&language='.$lang.'&key='.trim(stripslashes($GLOBALS['CORE_THEME']['googlemap_apikey'])));
					
					$output = json_decode($geocode); 
					 
					if(isset($output->error_message) && current_user_can('administrator')){	
						$GLOBALS['error_message'] = $output->error_message;
					}else{		
					$longitude =  $output->results[0]->geometry->location->lng;
					$latitude =  $output->results[0]->geometry->location->lat;
						
						// SAVE ONLY IF BOTH NOT EQUAL 0
						if($longitude == 0 && $latitude == 0){
						
						}else{ 		
						$saved_searches[$thisZip] = array("log" => $longitude, "lat" => $latitude);		
						update_option('wlt_saved_zipcodes', $saved_searches);
						}
					
					}
				}
				
				 
				/*** validate ***/
				if(is_numeric($longitude) && is_numeric($latitude)){				
					// Find Max - Min Lat / Long for Radius and zero point and query  
					$lat_range = $range/69.172;  
					 
					$lon_range = abs($range/(cos($latitude) * 69.172));  
					$min_lat = number_format($latitude - $lat_range, "4", ".", "");  
					$max_lat = number_format($latitude + $lat_range, "4", ".", "");  
					$min_lon = number_format($longitude - $lon_range, "4", ".", "");  
					$max_lon = number_format($longitude + $lon_range, "4", ".", "");  
					 
					//die("lat: ".$latitude." ($min_lat - $max_lat) / log:".$longitude." ($min_lon - $max_lon)");  
									
					$q .= "AND ( ( wlt1.meta_key = 'map-lat' AND wlt1.meta_value	BETWEEN  ".$min_lat." AND  ".$max_lat."	) ";					
					$q .= " AND ( wlt2.meta_key = 'map-log' AND wlt2.meta_value	BETWEEN  ".$min_lon." AND  ".$max_lon." ) ";
					$q .= " OR ( wlt2.meta_key = 'map-zip' AND wlt2.meta_value	= '".$thisZip."' 
					OR wlt2.meta_key =  'map-zip' AND wlt2.meta_value	= '".trim(chunk_split($thisZip, 3, ' '))."' ) ";			 
					$q .= " AND ( ( wlt2.post_id IS NULL OR wlt2.meta_key = 'map-zip' ) ) )";				 
				  		
					return $q;	
						
				}else{
				
				
					$q .= "AND (wlt1.meta_key = 'map-zip' AND wlt1.meta_value = ('".$thisZip."') 
					OR wlt2.meta_key = 'map-zip' AND wlt2.meta_value = ('".trim(chunk_split($thisZip, 4, ' '))."')	) ";
				 
				}
			
			}else{ // SAME ZIP ONLY
				$q .= "AND (wlt1.meta_key = 'map-zip' AND wlt1.meta_value = ('".$thisZip."') 
				OR wlt1.meta_key = 'map-zip' AND wlt1.meta_value = ('".trim(chunk_split($thisZip, 4, ' '))."')	) ";
			}
				
		} // end if	  		 
  
		return $q;	
	}
	
	// LET USERS EDIT THEIR OWN POSTS
	function wlt_edit_own_caps() {  global $userdata;
 		
		 // ADD ON TAG SUPPORT
		register_taxonomy_for_object_type('post_tag', THEME_TAXONOMY.'_type');
			
		if(isset($userdata->ID) && $userdata->ID > 0){
			// gets the author role
			$role = get_role( 'subscriber' );
			$role->add_cap( 'edit_posts' ); 
			//upload_files ??
		}
	} 
	// SETS THE DEFAULT SEARCH QUERY TO POSATIVE IF NO SEARCH KEYWORD IS ENTERED
	function my_request_filter( $query_vars ) {
	 
	 	if( isset( $_GET['s'] ) && empty( $_GET['s'] ) ) {
			$query_vars['s'] = " ";
		}
		return $query_vars;
	}
	
	function expirycustomquery(){ 
	
	// NOT USED IN AT THEME
	if(isset($_GET['orderby']) && ( $_GET['orderby'] == "bidwin"  || $_GET['orderby'] == "bidding" ) ){ return; } 
 
	 	if(defined('WLT_CART') || is_admin() || isset($_GET['uid']) || isset($GLOBALS['alreadysetexpiry']) ){ return; } 
		
		if(isset($GLOBALS['CORE_THEME']['hide_expired']) && $GLOBALS['CORE_THEME']['hide_expired'] == '1'  ){	
	
		if(defined('WLT_COUPON')){
		
								$pushme  = array( 			
										/*
										array(					 
												'key' => 'expiry_date',											
												'compare' => 'NOT EXISTS',				 				
											),	
											'relation' => 'OR', 			
											*/	 
										array( 
												'key' => 'expiry_date',
												'orderby' => 'meta_value',						 
												'compare' => '>=',
												'value' => date('Y-m-d H:i:s'),
												'type' => 'DATETIME'							 
											),			
									);
									
							}else{
							
								$pushme  = array( 			
										/*array(					 
												'key' => 'listing_expiry_date',											
												'compare' => 'NOT EXISTS',				 				
											),	
											'relation' => 'OR', 
											*/				 
										array( 
												'key' => 'listing_expiry_date',																
												'orderby' => 'meta_value',						 
												'compare' => '>=',
												'value' => date('Y-m-d H:i:s'),
												'type' => 'DATETIME'							 
											),			
									);
							}
		
					if(!isset($GLOBALS['custom'])){ $GLOBALS['custom'] = ""; }
					if(!is_array($GLOBALS['custom'])){ $GLOBALS['custom'] = $pushme; }elseif(is_array($GLOBALS['custom'])){ array_push($GLOBALS['custom'],$pushme); }
					
					$GLOBALS['orderby'] = "meta_value"; 
					$GLOBALS['alreadysetexpiry'] = true;
		}	
				
	
	}
	
	function orderbyoptions($val){ global $userdata;
	
			switch($val){
				case "distance": {  $GLOBALS['orderby'] 	= 'distance';  } break;
				case "ID": {  		$GLOBALS['orderby'] 	= 'ID'; } break;
				case "post_title":
				case "title": { 	$GLOBALS['orderby'] 	= 'title'; } break;	
				case "name": { 		$GLOBALS['orderby'] 	= 'name'; } break;	
				case "post_date":
				case "date": { 		$GLOBALS['orderby'] 	= 'date'; } break;	
				case "comments": { 	$GLOBALS['orderby'] 	= 'comment_count'; } break;					 
				case "rating": {
						
							if(isset($GLOBALS['CORE_THEME']['rating_type']) && $GLOBALS['CORE_THEME']['rating_type'] == 1 && !defined('WLT_MICROJOB') ){
								
								if(WLT_CACHING){
								
									$pushme  = array( 
								 		array(
										'key' => 'starrating',																
										'orderby' => 'meta_value_num'
										),							 
									);
								}else{
								
									$pushme  = array( 
										array(			
											array(					 
													'key' => 'starrating',											
													'compare' => 'NOT EXISTS',				 				
												),	
												'relation' => 'OR', 				 
											array( 
													'key' => 'starrating',																
													'orderby' => 'meta_value_num'							 
												),
										)		
									);
								}
							
							}else{
								 
								if(WLT_CACHING){
								
									$pushme  = array( 	array(	
										 'key' => 'rating_total',																
										'orderby' => 'meta_value_num'							 
									)  );
								
								}else{
								
								
									$pushme  = array( 	
										array(		
											array(					 
													'key' => 'rating_total',											
													'compare' => 'NOT EXISTS',				 				
												),	
												'relation' => 'OR', 				 
											array( 
													'key' => 'rating_total',																
													'orderby' => 'meta_value_num'							 
												),
										)		
									);
								 
								}
								
							}
							 
							$GLOBALS['orderby'] = "meta_value_num";
							if(!isset($GLOBALS['custom']) || (isset($GLOBALS['custom']) && !is_array($GLOBALS['custom']) ) ){ 
							$GLOBALS['custom'] = $pushme;  }elseif(is_array($GLOBALS['custom'])){ array_push($GLOBALS['custom'],$pushme); }
						  
						} break;
						case "hits": {
							
							if(WLT_CACHING){
							
								$pushme  = array( array(									 
									'key' => 'hits',								 														
									'orderby' => 'meta_value_num',	
								) );
								
							}else{
							
								$pushme  = array( 
								array(			
									array(					 
											'key' => 'hits',											
											'compare' => 'NOT EXISTS',				 				
										),	
										'relation' => 'OR', 				 
									array( 
											'key' => 'hits',																
											'orderby' => 'meta_value_num',	
											  					 
										),	
								)		
								);
									
							}							
							
							$GLOBALS['orderby'] = "meta_value_num";
							if(!isset($GLOBALS['custom']) || (isset($GLOBALS['custom']) && !is_array($GLOBALS['custom']) ) ){ 
							$GLOBALS['custom'] = $pushme; 
							}elseif(is_array($GLOBALS['custom'])){ array_push($GLOBALS['custom'],$pushme); }
						 	
							
						} break;
						case "votes": {
							$GLOBALS['custom'][] = array(
								'key' => 'votes',														
								'orderby' => 'meta_value_num'									 
							);						
						} break;
						case "sale": {
							$GLOBALS['custom'][] = array(
								'key' => 'old_price',	
								'compare' => '!=',	
								'value'	=> '',												
								'orderby' => 'meta_value_num'									 
							);						
						} break;
						case "price": {
						
						if(defined('WLT_AUCTION')){
						  
								$pushme  = array(
								array( 			
									array( 
											'key' => 'price_bid',											 																
											'orderby' => 'meta_value_num'							 
										),
										'relation' => 'OR', 				 
										array(					 
											'key' => 'price_current',											
											'orderby' => 'meta_value_num'			 				
										),	
								),		
								);
								
							if(!isset($GLOBALS['custom']) || (isset($GLOBALS['custom']) && !is_array($GLOBALS['custom']) ) ){ 
								$GLOBALS['custom'] = $pushme;  
							}elseif(is_array($GLOBALS['custom'])){ array_push($GLOBALS['custom'],$pushme); }
							 
							
						}else{						
							$GLOBALS['custom'][] = array(
								'key' => 'price',														
								'orderby' => 'meta_value_num'									 
							);							
						}
							$GLOBALS['orderby'] = "meta_value_num";					
						} break;
						
						case "expires": {						
						
								$this->expirycustomquery();
								 
						
						} break;
						 case "featured": {						 
						 
						 	if(WLT_CACHING){
						 
								$pushme  = array( array(								 
									'key' => 'featured',	
									'value' => 'yes',	
									'compare' => '=', 				
								) );
								
							}else{
							
								$pushme  = array(
								array( 			
									array(					 
											'key' => 'featured',											
											'compare' => 'NOT EXISTS',				 				
										),	
										'relation' => 'OR', 				 
									array( 
											'key' => 'featured',											 																
											'orderby' => 'meta_value'							 
										),	
								),		
								);
							} 
							 
							if(!isset($GLOBALS['custom']) || (isset($GLOBALS['custom']) && !is_array($GLOBALS['custom']) ) ){ 
							$GLOBALS['custom'] = $pushme;  
							}elseif(is_array($GLOBALS['custom'])){ array_push($GLOBALS['custom'],$pushme); }
							
							//$_GET['orderby'] = "custom"; // fix for 
						 	 										
						} break;
						case "bidwinner": {						
							$GLOBALS['custom'][] = array(
								'key' => 'bidwinner',
								'value' => $userdata->ID,
								'compare' => '=',
								'orderby' => 'meta_value'									 
							);						
						} break;
						
						
						case "bidwin": {	
											
							$GLOBALS['custom'][] = array(
								'key' => 'bidwinnerstring',
								'value' => "-".$userdata->ID."-",
								'compare' => 'LIKE',
								'orderby' => 'meta_value'									 
							);						
						} break;
						case "bidding": {						 		 
							$GLOBALS['custom'][] = array(
								'key' => 'bidstring',
								'value' => "-".$userdata->ID."-",
								'compare' => 'LIKE',
								'orderby' => 'meta_value'									 
							);						
						} break;
							
						default: {
							 
							// CHECK IF ITS A NUMERICAL VALUE
							$ntype = "meta_value";
							if(isset($_GET['num'])){ 
							$ntype = "meta_value_num";
							}
							
							// CHECK FOR SET VALUE
							if(isset($_GET['meta_value'])){							
								$GLOBALS['custom'][] = array(
									'key' => strip_tags($_GET['orderby']),
									'value' => $_GET['meta_value'],								
									'orderby' => $ntype									 
								);
							}else{
								$GLOBALS['custom'][] = array(
									'key' => strip_tags($_GET['orderby']),
									'orderby' => $ntype									 
								);							
							}
							 						
							$_GET['orderby'] = "custom"; // fix for 
						}		
			}// END SWITCH
	
	}
	
	function core_customorderby(){ global $userdata;	
	 
		// ORDER BY FOR SEARCH RESULTS
		if(isset($_GET['orderby']) && strlen($_GET['orderby']) > 1 ){
			
			$this->orderbyoptions($_GET['orderby']); 
		
			$GLOBALS['order'] = $this->core_order();	
			
		}// END IF  
	
	}
	function core_order(){
		// ORDER
		$order = "asc";
		if(isset($_GET['order'])){		
			switch($_GET['order']){
				case "asc": {  $order = "asc"; } break;
				case "desc": { $order = "desc";  } break;								
			}
		}else{
		 $f = $GLOBALS['CORE_THEME']['display']['orderby'];
		 
		 $g = explode("*",$f);
		 if(isset($g[1])){
		 switch($g[1]){
				case "asc": {  $order = "asc"; } break;
				case "desc": { $order = "desc";  } break;
				default: {  $order = "asc"; } break;								
			}
		}
		}
		 
		return $order;
	}
	function get_db_key_ref($string,$key){
	
		$pix = "mt1";
	
		// CHECK IF THE VALUE IS FOUND IN THE STRING
		if(strpos($string,$key) !== false){
		
			$bits = explode("AND",$string);			
			//print_r($bits.$string);
			foreach($bits as $innerstr){
				
				if(strpos($innerstr,"'".$key."'") !== false){					
					$gg = explode(".",$innerstr);					 
					$pix = $gg[0]; 				
				}
			}		
		}
		
		return str_replace("(","",str_replace(")","",$pix));	
	}
	function _posts_orderby($orderby) { global $wpdb;	
	
	 	// DONT USE ON ADMIN QUERIES
	 	if  ( is_admin() || !is_main_query()  ) {	
		
		return $orderby;
		
		}else{
		
		 
		
			if ( isset($_GET['orderby']) ) {
				
				switch($_GET['orderby']){
				
					case "featured": { $orderby = $wpdb->prefix . "postmeta.meta_value ".$this->core_order();	 } break;
					case "price":
					case "votes":
					case "hits":
					case "price_current": { $orderby = $wpdb->prefix . "postmeta.meta_value+0 ".$this->core_order(); } break;
					case "bidwinner": { $orderby = $wpdb->prefix . "postmeta.meta_value ".$this->core_order();	 } break;
					case "distance": { $orderby = "distance ".$this->core_order();} break;					
					case "custom": { 
						if(isset($_GET['num'])){
						$orderby = $wpdb->prefix . "postmeta.meta_value+0 ".$this->core_order();	
						}else{
						$orderby = $wpdb->prefix . "postmeta.meta_value ".$this->core_order();	
						}
					} break; 
				
				}// end switch
			
		    
			// FIX FOR FEATURED ORDER BY	
			}elseif(isset($GLOBALS['CORE_THEME']['display']) && isset($GLOBALS['CORE_THEME']['display']['orderby']) && strpos($GLOBALS['CORE_THEME']['display']['orderby'],"featured") !== false && isset($GLOBALS['CORE_INNER_SEARCH']) ){			  
			$orderby = $wpdb->prefix . "postmeta.meta_value ".$this->core_order();
			}elseif(isset($GLOBALS['CORE_THEME']['display']) && isset($GLOBALS['CORE_THEME']['display']['orderby']) && strpos($GLOBALS['CORE_THEME']['display']['orderby'],"price") !== false && isset($GLOBALS['CORE_INNER_SEARCH']) ){			  
			$orderby = $wpdb->prefix . "postmeta.meta_value+0 ".$this->core_order();
				// ADJUST QUERY IF WE ARE SEARCHING MULTIPLE FIELDS
				if(isset($GLOBALS['CORE_THEME']['hide_expired']) && $GLOBALS['CORE_THEME']['hide_expired'] == '1' && !defined('WLT_COUPON') && !defined('WLT_CART') && !is_admin() && !isset($_GET['uid']) ){		
				$orderby = $this->get_db_key_ref($GLOBALS['this_query_where'],"price").".meta_value+0 desc";				 
				}
			}elseif(isset($GLOBALS['CORE_THEME']['display']) && isset($GLOBALS['CORE_THEME']['display']['orderby']) && strpos($GLOBALS['CORE_THEME']['display']['orderby'],"votes") !== false && isset($GLOBALS['CORE_INNER_SEARCH']) ){			  
			$orderby = $wpdb->prefix . "postmeta.meta_value+0 ".$this->core_order();
				// ADJUST QUERY IF WE ARE SEARCHING MULTIPLE FIELDS
				if(isset($GLOBALS['CORE_THEME']['hide_expired']) && $GLOBALS['CORE_THEME']['hide_expired'] == '1' && !defined('WLT_COUPON') && !defined('WLT_CART') && !is_admin() && !isset($_GET['uid']) ){		
				$orderby = $this->get_db_key_ref($GLOBALS['this_query_where'],"price").".meta_value+0 desc";				 
				}
			}elseif(isset($GLOBALS['CORE_THEME']['geolocation']) && $GLOBALS['CORE_THEME']['geolocation'] != "" && !isset($_GET['favs']) && isset($_GET['orderby']) && $_GET['orderby'] == "distance" && isset($_SESSION['mylocation']['lat']) && strlen($_SESSION['mylocation']['lat']) > 0 && strlen($_SESSION['mylocation']['log']) > 0 ){
				$orderby = "distance ".$this->core_order();			
			}else{
			 
			 	// DEFAULT TO POSTID NOT DATE
				if ( WLT_CACHING ){
				
				$orderby = str_replace($wpdb->prefix."posts.post_date", $wpdb->prefix."posts.ID", $orderby );
				
				}elseif(isset($GLOBALS['CORE_THEME']['display']['orderby']) && strlen($GLOBALS['CORE_THEME']['display']['orderby']) > 1 && $GLOBALS['CORE_THEME']['display']['orderby'] !="system"){
					 $dorder = explode("*",$GLOBALS['CORE_THEME']['display']['orderby']);
					 if(substr($dorder[0],0,4) == "meta"){
					 }else{
					 $orderby 	= $dorder[0]." ".$dorder[1];				 
					 }
				}
			} 
			
			 
		}// is not admin	 
		 
		 
		return str_replace("LIKE '% %' DESC","",$orderby);
	
	}	
	function core_searchdefault(){ global $wp_the_query;
	 
	
		// ONLY PERFORM ON MAIN SEARCH 
		if ( !$wp_the_query->is_main_query() || isset($_GET['orderby']) ) {  return; } 
 
 			// WORK OUT DEFAULTS FOR CORE SEARCH
			if(isset($GLOBALS['CORE_THEME']['display']['orderby']) && !isset($GLOBALS['core_searchdefault_isset']) ){
			
				// SET DEFAULT ORDER FOR POSTS				 
				$GLOBALS['core_searchdefault_isset'] = true;
				
				// DEFAULT FALLBACK 
				$dorder = explode("*",$GLOBALS['CORE_THEME']['display']['orderby']);	
						 
						 if(isset($dorder[1])){
						  
							 if(substr($dorder[0],0,4) == "meta"){
							  
							 $bb = explode("&",$dorder[0]);	
							 
							 $this->orderbyoptions($bb[1]);
							  
								$GLOBALS['order'] 		= $dorder[1];
								$GLOBALS['orderby'] 	= 'meta_value'; 
								
							 }else{
							 	$GLOBALS['orderby'] 	= $dorder[0];
								$GLOBALS['order'] 		= $dorder[1];							  
							 }
						}
					 
			} // end if
			 
	}
 	
	function _core_search_extras(){	global $wp_query;
	
		// ONLY PERFORM ON MAIN SEARCH 
		if ( !is_main_query() ) {  return; } 
		
		$this->expirycustomquery();			 
		
	}
	
	// CORE THEME SEARCH FILTER
	function _pre_get_posts($query) { global $userdata, $wpdb; $canset = false;
 
		
		// REDUCE WP QUERIES FOR HOMEPAGE SINCE WE DONT USE POST ELEMENTS
		if(is_home() && isset($query->request) ){		 
			if(strpos($query->request,"SELECT $wpdb->posts.*") === false){ $query->query_vars['no_found_rows'] = 1; return $query; }		
		}		
		
		// DONT DO ANYTHING WITH ADMIN QUERY
		if(is_admin() || ! $query->is_main_query() ){ 		
		
			return $query; 
		
		// ADD-ON TAG SUPPORT IN 6.4+
		}elseif( is_tag() && empty( $query->query_vars['suppress_filters'] ) ) {

			$post_types = get_post_types();
			$query->set( 'post_type', $post_types );
		
			return $query;
		
		}elseif ( ( $query->is_search ) && !is_admin() && !isset($query->query['post_type']) ) { 		
		  
		 	// SET FLAG
			$canset = true;		 
			 
			// SHOW USER OSTS ONLY
			if(isset($_GET['uid']) && is_numeric($_GET['uid']) ){			  
				$query->set('author', $_GET['uid']);
				// SHOW ONLY PENDING ITEMS IF LOGGED IN AS THIS USER
				if(isset($userdata->ID) && $userdata->ID == $_GET['uid'] ){
					 $query->set('post_status', array("pending","publish","draft"));
					 $query->set( 'post_type', THEME_TAXONOMY.'_type' );
				}				 			
			}
 		 
			// SET POST TYPES FOR SEARCH 
			$GLOBALS['post_type'] = array( THEME_TAXONOMY.'_type' );			
			if(isset($GLOBALS['CORE_THEME']['dstypes']) && is_array($GLOBALS['CORE_THEME']['dstypes']) && !empty($GLOBALS['CORE_THEME']['dstypes'])){
			$GLOBALS['post_type'] = $GLOBALS['CORE_THEME']['dstypes'];		 
			} 
			
			// CUSTOM TAX QUERY FOR STORES AND CATEGORIES USING ID			 
			if(isset($_GET['favs']) && is_numeric($_GET['favs']) ){ 
					
					$extn = "_list";
					if(defined('WP_ALLOW_MULTISITE')){
						$extn .= get_current_blog_id();
					}						 
					$my_list = get_user_meta($userdata->ID, 'favorite'.$extn,true);	
			
					//$my_list = get_user_meta($userdata->ID, 'favorite_list',true);	
					if(is_array($my_list) && !empty($my_list)){			 
						$GLOBALS['post_in'] =  $my_list;
					}else{
						$GLOBALS['post_in'] =  array("99");
					}  
			} 
			 
			// CUSTOM TAX QUERY FOR STORES AND CATEGORIES USING ID			 
			if(isset($_GET['cat1']) && is_numeric($_GET['cat1']) ){ 				 
					$GLOBALS['taxonomies'][] = array(
							'taxonomy' => THEME_TAXONOMY,
							'field' => 'term_id',
							'terms' => array( $_GET['cat1'] ),
							'operator'=> 'IN'						
					);					
					 
			}
			
			// CUSTOM TAX QUERY FOR STORES AND CATEGORIES USING ID			 
			if(isset($_GET['storeid']) && is_numeric($_GET['storeid']) ){ 				 
					$GLOBALS['taxonomies'][] = array(
							'taxonomy' => 'store',
							'field' => 'term_id',
							'terms' => array( $_GET['storeid'] ),
							'operator'=> 'IN'						
					);					
				 
			} 
			if(isset($_GET['stype']) && is_numeric($_GET['stype']) ){ 				 
					$GLOBALS['custom'][] = array(							
							'key' => 'coupon_type',
							'value' => strip_tags($_GET['stype']),
							'compare'=> '='						
					);						
			}
			// CUSTOM TAX QUERY FOR STORES AND CATEGORIES USING ID			 
			if(isset($_GET['dagender']) && is_numeric($_GET['dagender']) ){ 				 
					$GLOBALS['custom'][] = array(							
							'key' => 'dagender',
							'value' => strip_tags($_GET['dagender']),
							'compare'=> '='						
					);						
			}
			// CUSTOM TAX QUERY FOR STORES AND CATEGORIES USING ID			 
			if(isset($_GET['daage']) && is_numeric($_GET['daage']) ){ 				 
					$GLOBALS['custom'][] = array(							
							'key' => 'daage',
							'value' => array(substr($_GET['daage'],0,2), substr($_GET['daage'],2,2)),
							'compare' => 'BETWEEN',					
					);						
			}			
			// CUSTOM TAX QUERY FOR LOCATIONS USING COUNTRY NAME	 
			if(isset($_GET['location1']) && strlen($_GET['location1']) > 1 ){ 				 
					$GLOBALS['custom'][] = array(							
							'key' => 'map-country',
							'value' => strip_tags($_GET['location1']),
							'compare'=> '='						
					);					
			}
			// CUSTOM TAX QUERY FOR LOCATIONS USING CITY NAME	 
			if(isset($_GET['city1']) && strlen($_GET['city1']) > 1 ){ 				 
					$GLOBALS['custom'][] = array(							
							'key' => 'map-city',
							'value' => strip_tags($_GET['city1']),
							'compare'=> '='						
					);					
			}		
			// CUSTOM TAX QUERY FOR LOCATIONS USING PRICE	 
			if(isset($_GET['price1']) && is_numeric($_GET['price1']) ){
			if(!is_numeric($_GET['price2'])){ $_GET['price2'] = 100000; } 				 
					$GLOBALS['custom'][] = array(							
							'key' => 'price',
							'type' => 'NUMERIC',
							'value' => array($_GET['price1'],$_GET['price2']),
							'compare'=> 'BETWEEN'						
					);					
			}		
			// LOAD IN CUSTOM SEARCH 
			$GLOBALS['CORE_INNER_SEARCH'] = true;
			$this->core_searchdefault();
			$this->core_customorderby();			
	 
		 // END MAIN SEARCH
		 }elseif( isset($query->tax_query->queries[0]['taxonomy']) && ( $query->tax_query->queries[0]['taxonomy'] == THEME_TAXONOMY || $query->tax_query->queries[0]['taxonomy'] == "store" ) ){
			 
			// SET FLAG
			$canset = true;
			
			// SET POST TYPES FOR SEARCH 
			$GLOBALS['post_type'] = array( THEME_TAXONOMY.'_type' );			
			if(is_array($GLOBALS['CORE_THEME']['dstypes']) && !empty($GLOBALS['CORE_THEME']['dstypes'])){
			$GLOBALS['post_type'] = $GLOBALS['CORE_THEME']['dstypes'];		 
			} 
						
			// LOAD IN CUSTOM SEARCH
			$GLOBALS['CORE_INNER_SEARCH'] = true;
			$this->core_searchdefault();
			$this->core_customorderby();
			
			 
		 }
		 
		 	 
		 // CHECK FOR CUSTOM QUERIES		 
		 if ( ( $query->is_search ||  $query->is_tax ) && !is_admin()  ) { 
		 hook_wlt_core_search();
		 }		
	  
		 if($canset){
		     
			// LOAD ALL CUSTOM DATA			
			if ( isset($GLOBALS['post_type']) && $GLOBALS['post_type'] != "forum"  ) {
				$query->set( 'post_type', $GLOBALS['post_type'] );
			}			
				
			if ( isset($GLOBALS['post_in'])  ) {
				$query->set('post__in', $GLOBALS['post_in']);			
			}
			
			if ( isset($GLOBALS['post_author'])  ) {
				$query->set('author', $GLOBALS['post_author']);			
			}
					
			if ( isset($GLOBALS['taxonomies']) &&  count( $GLOBALS['taxonomies'] ) ) {
				$query->set( 'tax_query', $GLOBALS['taxonomies'] );
			}
			
			if ( isset($GLOBALS['custom_or']) && count( $GLOBALS['custom_or'] ) ) {		
				if(!is_array($GLOBALS['custom'])){ $GLOBALS['custom'] = array(); }		 
				$GLOBALS['custom'] = array_merge($GLOBALS['custom'],$GLOBALS['custom_or']);
			}
		 
			if ( isset($GLOBALS['custom']) && count( $GLOBALS['custom'] ) ) {			
				$query->set( 'meta_query', $GLOBALS['custom'] );
			} 
			 
			if ( isset( $GLOBALS['orderby'] ) ) {			 
				$query->set( 'orderby', $GLOBALS['orderby'] );				
			}
			 
			if ( isset( $GLOBALS['order'] ) ) {
				$query->set( 'order', $GLOBALS['order'] );				 
			}
			  	 
		}		
	 
		// FIX FOR SLOW QUERY SQL_CALC_FOUND_ROWS
	 
		if ( WLT_CACHING && empty($query->tax_query->queries) ){
		
			$query->query_vars['no_found_rows'] = 1;
		 
			// GET THE EXISTING SAVED OPTIONS
			$EXISTNGDATA = get_option('wlt_existing_founddata');		
			if( strtotime($EXISTNGDATA['date']) < strtotime(current_time( 'mysql' )) ) {		
				$founddata = $wpdb->get_var( "SELECT COUNT(*) FROM $wpdb->posts WHERE 1=1 AND $wpdb->posts.post_type = '".THEME_TAXONOMY."_type' AND $wpdb->posts.post_status = 'publish' " );			 	 
				update_option("wlt_existing_founddata", array("date" => date('Y-m-d H:i:s', strtotime(date('Y-m-d H:i:s'). "+24 hours") ), "values" => $founddata), true);		 	 
			}else{
				$founddata = $EXISTNGDATA['values'];			
			}
			
			$query->found_posts = $founddata;
			$query->found_posts = apply_filters_ref_array( 'found_posts', array( $query->found_posts, &$query ) );
		 
			$posts_per_page = ( ! empty( $query->query_vars['posts_per_page'] ) ? $query->query_vars['posts_per_page'] : get_option( 'posts_per_page' ) );
			$query->max_num_pages = ceil( $query->found_posts / $posts_per_page );
		
		} 
	 	
		// RETURN MODIFIED QUERY
		return $query;
	}
	
	function CUSTOMLIST($key,$selected){ global $wpdb, $CORE;
	
		$selected = $_GET['sel']; $in_array = array();	$STRING = "";			
		$SQL = "SELECT DISTINCT ".$wpdb->postmeta.".meta_value FROM ".$wpdb->postmeta." 
				INNER JOIN ".$wpdb->posts." ON ( ".$wpdb->postmeta.".post_id = ".$wpdb->posts.".ID AND ".$wpdb->posts.".post_status='publish')
				WHERE ".$wpdb->postmeta.".meta_key = ('".strip_tags($key)."') LIMIT 0,100";
		$result = mysql_query($SQL, $wpdb->dbh) or die(mysql_error().' on line: '.__LINE__);					 
		if (mysql_num_rows($result) > 0) {
			while ($val = mysql_fetch_object($result)){
				
				$txt = $val->meta_value;
				$value = $val->meta_value;
				
				if($key == "map-country"){
					$c_text = $GLOBALS['core_country_list'][$val->meta_value];
					if($c_text == ""){ continue; }
					$txt = $c_text;
				}				
				
				if($selected != "" &&  $val == $selected){
					$STRING .= "<option value='".$value."' selected=selected>".$txt."</option>";
				}else{
					$STRING .= "<option value='".$value."'>".$txt."</option>";
				} // end if	
			} // end while
		} // end if
	return $STRING;
	}

/* ========================================================================
 [WLT FRAMEWORK] - HEADER
========================================================================== */ 
function CUSTOMHEADER(){ global $wpdb, $pagenow; $STRING = ""; 
 
	// BOOTSTRAP
	if(!wp_style_is( 'bootstrap', 'registered' ) ){
	
		if(isset($GLOBALS['CORE_THEME']['responsive']) && $GLOBALS['CORE_THEME']['responsive'] == 0 ){
		wp_register_style( 'bootstrap',  FRAMREWORK_URI.'css/css.bootstrap-nonresponsive.css');	 
		}else{
		wp_register_style( 'bootstrap',  FRAMREWORK_URI.'css/css.bootstrap.css');		
		}	
	
		wp_enqueue_style( 'bootstrap' ); 
	
	}
	
	// ADD-ON PLAYER FILES ENCASE WE HAVE VIDEO
	if(isset($GLOBALS['flag-single']) ){
	wp_enqueue_script('video', FRAMREWORK_URI.'player/mediaelement-and-player.min.js',1);
	wp_enqueue_script('video'); 
	}
	
	// MOBILE VIEW
	if(defined('IS_MOBILEVIEW')){	
		wp_register_style( 'mobilestyles',  FRAMREWORK_URI.'css/css.mobile.css');	
		wp_enqueue_style( 'mobilestyles' );	
		return;
	}
	
	// ADD ON VISUAL EDITOR
	if( isset($GLOBALS['CORE_THEME']['admin_liveeditor']) && $GLOBALS['CORE_THEME']['admin_liveeditor'] == 1 && current_user_can('administrator') ){
	wp_register_style( 'bootstrap-editable',  '//cdnjs.cloudflare.com/ajax/libs/x-editable/1.5.0/bootstrap3-editable/css/bootstrap-editable.css');
	wp_enqueue_style( 'bootstrap-editable' );
	}
 
	// LOAD IN FRAMEWORK CSS FILES
	if(!defined('DISABLE_CORE_CSS')){
	wp_register_style( 'wlt_core',  FRAMREWORK_URI.'css/css.core.css');
	wp_enqueue_style( 'wlt_core' ); 
	}	
	
	// LOAD IN FRAMEWORK CSS FILES
	if(!defined('DISABLE_CORE_CSS')  && isset($GLOBALS['flag-home']) && isset($GLOBALS['CORE_THEME']['homeeditor']) && $GLOBALS['CORE_THEME']['homeeditor'] == 1){
	wp_register_style( 'wlt_homeobjects',  FRAMREWORK_URI.'css/css.homeobject_styles.css');
	wp_enqueue_style( 'wlt_homeobjects' ); 
	}
	if(defined('CHILD_THEME_NAME') || defined('WLT_CHILDTHEME') || defined('WLT_DEMOMODE') ){
	// LOAD IN FRAMEWORK CSS FILES FOR CHILD THEMES
	wp_register_style( 'wlt_core_extra',  get_template_directory_uri().'/templates/'.get_option('wlt_base_theme').'/style_childtheme.css');
	wp_enqueue_style( 'wlt_core_extra' );	 
	}
 
	// LOAD IN THEME FILES
	if(isset($GLOBALS['CORE_THEME']['template']) && strlen($GLOBALS['CORE_THEME']['template']) > 1){
	 
		if(defined('CHILD_THEME_NAME') && !defined('WLT_DEMOMODE')){
		
		wp_register_style( 'wlt_child-theme1', get_bloginfo('stylesheet_url'));
		wp_enqueue_style( 'wlt_child-theme1' ); 
		
		}elseif(defined('WLT_DEMOMODE') && isset($_SESSION['skin'])){
			 	
		wp_register_style( 'wlt_child-theme2', WP_CONTENT_URL.'/themes/'.$GLOBALS['CORE_THEME']['template'].'/style.css');
		wp_enqueue_style( 'wlt_child-theme2' );		 
		
		}else{
		
		wp_register_style( 'wlt_child-theme3', get_template_directory_uri().'/templates/'.$GLOBALS['CORE_THEME']['template'].'/style.css');
		wp_enqueue_style( 'wlt_child-theme3' );	
			 
		}
 			 
	}elseif( !isset($GLOBALS['CORE_THEME']['template']) ||  ( isset($GLOBALS['CORE_THEME']['template']) && $GLOBALS['CORE_THEME']['template'] == "") ){
		wp_register_style( 'wlt_sampletheme-styles', get_template_directory_uri().'/framework/css/css.framework.css');
		wp_enqueue_style( 'wlt_sampletheme-styles' );	
 
	
	}// END IF
	
	// NON RESPONSIVE
	if(isset($GLOBALS['CORE_THEME']['responsive']) && $GLOBALS['CORE_THEME']['responsive'] == 0){
		wp_register_style( 'nonresponsive', get_template_directory_uri().'/framework/css/css.bootstrap-nonresponsive.css');
		wp_enqueue_style( 'nonresponsive' );	
	}
	
	// CHECK FOR ALTERNATIVE CHILD THEME
	if(!defined('WLT_DEMOMODE') && isset($GLOBALS['CORE_THEME']['colorstyle_file']) && $GLOBALS['CORE_THEME']['colorstyle_file'] != "" && strlen($GLOBALS['CORE_THEME']['colorstyle_file']) > 1 && !defined('CHILD_THEME_NAME') ){
	wp_register_style( 'wlt_core_'.$GLOBALS['CORE_THEME']['colorstyle_file'],  get_template_directory_uri().'/templates/'.$GLOBALS['CORE_THEME']['template'].'/alternative/'.$GLOBALS['CORE_THEME']['colorstyle_file'].'.css');
	wp_enqueue_style( 'wlt_core_'.$GLOBALS['CORE_THEME']['colorstyle_file'] );	
	}	
 	
	// NOINDEX FOR SOME PAGES
	$no_index_pages = array("wp-login.php");
	if(isset($_GET['home_paged']) || isset($_GET['orderby']) || in_array($pagenow, $no_index_pages) ){
	echo '<meta name="robots" content="noindex">';
	}
	
	// RESPONSIVE DESIGN
	if(!isset($GLOBALS['CORE_THEME']['responsive']) || ( isset($GLOBALS['CORE_THEME']['responsive']) && $GLOBALS['CORE_THEME']['responsive'] == 1 ) ){  
    echo '<meta name="viewport" content="width=device-width, initial-scale=1" />';
    }else{
    echo '<meta name="viewport" content="width=1170" />';
    }
 
}

function make_stylesheet_alt( $tag ) {
 
 $tag = preg_replace( "/='stylesheet' id='__/", "='stylesheet alternate' id='X1", $tag );
 $tag = str_replace("X1", "' title='", $tag );
 $tag = str_replace("id=''", "", $tag );
 $tag = str_replace("__X2-css'", "'", $tag );
 return $tag;
 
}
/* ========================================================================
 [WLT FRAMEWORK] - META TAGS
========================================================================== */ 
function CUSTOMMETA(){ global $wpdb, $CORE; $STRING = "";
 	
	// DISPLAY CUSTOM HEADER CODE
	$custom_head_data = get_option('custom_head');
	if(strlen($custom_head_data) > 1){
		echo stripslashes($custom_head_data);
	} 
	// DISPLAY CUSTOM HEADER CODE
	$custom_css = hook_custom_css(get_option('custom_css'));	 
	if(strlen($custom_css) > 1){
		
		// QUICK FIX FOR V6.6.5 UPDATE
		$custom_css = str_replace(".block .block-content",".panel",$custom_css);
		$custom_css = str_replace(".block .block-title h1",".block .block-title h1, .panel-default > .panel-heading",$custom_css);
		$custom_css = str_replace("#core_header_navigation .breadcrumb","#core_header_navigation .nav",$custom_css);
 		$custom_css = str_replace(".item.featured",".itemdata.featured",$custom_css);
		echo "<style type='text/css'>".stripslashes($custom_css)."</style>";		 
	}
 	
	// DISPLAY MISSING BACKGROUND IMAGE FOR LOGIN PAGES
	if(isset($GLOBALS['flag-register']) || isset($GLOBALS['flag-login']) || isset($GLOBALS['flag-password'])){
	echo _custom_background_cb();
	}
	
	// CUSTOM HEADER IMAGE
	$cheader = get_custom_header();
	if(strlen($cheader->url) > 1){
	ob_start();
	?>
    <style>
	 .overlay { background:url('<?php echo $cheader->url; ?>'); background-size:cover; }
	</style>
	<?php 
	echo ob_get_clean(); 
	}
	
		
	// ADDITIONAL MAP ICON STYLES
	if(isset($GLOBALS['CORE_THEME']['googlemap_icon']) && strlen($GLOBALS['CORE_THEME']['googlemap_icon']) > 10){ 	
	ob_start();
	?>
    <style>
	 .map-icon { background:url('<?php echo $GLOBALS['CORE_THEME']['googlemap_icon']; ?>') !important; }
	</style>
	<?php 
	echo ob_get_clean(); 
	}
	
	
	
	if(is_single()){
	// CUSTOM IMAGE SRC FOR SOCIAL BUTTONS
	$thumb_id = get_post_thumbnail_id();
	$thumb_url = wp_get_attachment_image_src($thumb_id,'thumbnail', true);
	 
		if(isset($thumb_url[0]) && $thumb_url[0] != ""){
		echo '<link rel="image_src" href="'.$thumb_url[0].'" />';
		}
	}
	
	if(isset($_GET['mediaonly'])){
	echo "<style>#main-searchbox, .bs-callout, #steps_left_column, #wpadminbar, #core_header_wrapper, #core_main_breadcrumbs_wrapper, #core_footer_wrapper, #core_menu_wrapper, #core_left_column, #core_right_column, #core_new_header_wrapper, header { display:none; }</style>";	
	}
	
	// COMMENT FORM
    if(isset($_GET['newcomment'])){
	$GLOBALS['error_message'] = $CORE->_e(array('comment','13'));
	$GLOBALS['newcomment'] = true;
	}
}
/* ========================================================================
 [WLT FRAMEWORK] - FOOTER
========================================================================== */ 
function CUSTOMFOOTER(){

	global $wpdb, $post, $userdata, $CORE; $STRING = "";

	echo $CORE->BANNER('footer'); 
 
	// DISPLAY CUSTOM FOOTER CODE
	$custom_footer_data = get_option('custom_footer');
	if(isset($custom_footer_data) && strlen($custom_footer_data) > 1){
		$STRING .=  stripslashes($custom_footer_data);
	} 
	
	// LOAD IN CART JS
	if(defined('WLT_CART')){ 
	wp_enqueue_script('core.cart', FRAMREWORK_URI.'js/core.cart.js','','',true); 
	}	
 
	// LOAD IN FRAMEWORK JS	
	wp_enqueue_script('core.ajax', FRAMREWORK_URI.'js/core.ajax.js','','',true); 
	
	// LOAD IN CORE JAVASCRIPT COMPONENTS
	wp_enqueue_script('core.jquery', FRAMREWORK_URI.'js/core.jquery.js','','',true);
  	
	// ADD ON VISUAL EDITOR
	if( isset($GLOBALS['CORE_THEME']['admin_liveeditor']) && $GLOBALS['CORE_THEME']['admin_liveeditor'] == 1 && current_user_can('administrator') ){	
	wp_enqueue_script('bootstrap-editable', '//cdnjs.cloudflare.com/ajax/libs/x-editable/1.5.0/bootstrap3-editable/js/bootstrap-editable.min.js','','',true);
 	}
	
	 
	if(isset($GLOBALS['flag-single'])  ){
	if( strpos($post->post_content, "[video ") !== false || strpos($post->post_content, "[audio ") !== false ){
	
		echo hook_single_javascript('');
	
	}else{ 
	 
	 
		$vs = "<script>
		jQuery(document).ready(function(){ jQuery('video,audio').mediaelementplayer({
		 
		success: function (mediaElement, domObject) {
			mediaElement.addEventListener('timeupdate', function(e) { 
			jQuery('.videotime".$post->ID."').val(mediaElement.currentTime);
			jQuery('.videotime".$post->ID."').trigger('change');
		}, false);
		
		mediaElement.addEventListener('ended', function(e) { 
			if(jQuery('.videonextup".$post->ID."').length){	
				setTimeout(function () {window.location.href = jQuery('.videonextup".$post->ID."').val();}, 500);
			}
		});
		
		[fff]
		
		},
		});});</script>";
		
		// ON/OFF FOR AUTO START
		if($GLOBALS['CORE_THEME']['media_autostart'] == 1){
		$vs = str_replace("[fff]","mediaElement.play();", $vs);		
		}else{
		$vs = str_replace("[fff]","", $vs);	
		}
	 	
		echo hook_single_javascript($vs);
	} 
		
	  echo '<script type="text/javascript">
	  jQuery(\'a[data-toggle="tab"]\').on(\'shown\', function (e) {
	  e.target
	  e.relatedTarget;
	  equalheight(\'.grid_style .itemdata .thumbnail\');
	  });';
	  
	  if(isset($GLOBALS['newcomment'])){
	  echo  "jQuery(window).load(function() { jQuery('#Tabs a[href=\"#t4\"]').tab('show'); });";
	  }
	  echo '</script>';
	}	
	
	// NEW GOOGLE MAPS API KEY
	if(isset($GLOBALS['CORE_THEME']['googlemap_apikey']) && strlen($GLOBALS['CORE_THEME']['googlemap_apikey']) > 2 && $GLOBALS['CORE_THEME']['google'] == 1){
	?>
    <input type="hidden" value="<?php echo trim(stripslashes($GLOBALS['CORE_THEME']['googlemap_apikey'])); ?>" id="newgooglemapsapikey" />
    <?php
	}
	
	// GOOGLE ANALYTICS
	if(isset($GLOBALS['CORE_THEME']['google_tracking']) && $GLOBALS['CORE_THEME']['google_tracking'] == '1'){
	ob_start();
	?>
	<script>
      (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
      (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
      m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
      })(window,document,'script','//www.google-analytics.com/analytics.js','ga');
    
      ga('create', '<?php echo stripslashes(get_option('google_trackingcode')); ?>', 'auto');
      ga('send', 'pageview');
    
    </script>
    <?php
	echo ob_get_clean(); 
	}
 
	
	// DISPLAY MY LOCATION OPTIONS !defined('IS_MOBILEVIEW') &&
	if( !defined('WLT_CART') && isset($GLOBALS['CORE_THEME']['geolocation']) && $GLOBALS['CORE_THEME']['geolocation'] != ""){
	 
	// MY LOCATION SETUP
	if(isset($_SESSION['mylocation'])){
		$country 	= $_SESSION['mylocation']['country'];
		$address 	= $_SESSION['mylocation']['address'];
		$lat 		= $_SESSION['mylocation']['lat'];
		$log 		= $_SESSION['mylocation']['log'];
		$zip 		= $_SESSION['mylocation']['zip'];
	}else{
		$address 	= "";
		$country 	= "GB";
		$lat		= "";
		$log 		= "";
		$zip 		= "";
	}

ob_start();		
?>		
 
<!-- My Location Modal -->
<div class="modal fade" id="MyLocationModal" tabindex="-1" role="dialog" aria-hidden="true"><div class="modal-dialog"><div class="modal-content">
<div class="modal-body">	  
	  
	<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
	
	<h3 class="modal-title"><?php echo $CORE->_e(array('widgets','9')); ?></h3>
			
	<p><?php echo $CORE->_e(array('widgets','10')); ?></p>
			
	<hr />
	
	<div id="wlt_google_mylocation_map" style="height:300px; width:100%;"></div>

</div>

<div class="modal-footer">
        
		
	<form method="post" action="#" name="mylocationsform" id="mylocationsform">
	<input type="hidden" name="updatemylocation" value="1" />
	<input type="hidden" name="log" value="<?php echo $log; ?>" id="mylog" />
	<input type="hidden" name="lat" value="<?php echo $lat; ?>" id="mylat" />
	<input type="hidden" name="country" value="<?php echo $country; ?>" id="myco" />
	<input type="hidden" name="zip" value="<?php echo $zip; ?>" id="myzip" />
				 
				
				<div class="row" id="addressbox">
				
					<div class="col-md-10 col-xs-8">
					
					<input type="text" placeholder="<?php echo $CORE->_e(array('add','54','flag_noedit')); ?>" onChange="getAddressLocation(this.value);" name="myaddress" id="myaddress" class="form-control input-lg" tabindex="14" value="<?php echo $address; ?>">
					
					</div>
					
					<div class="col-md-2 col-xs-4">
					
					<button type="button" class="btn btn-lg"><?php echo $CORE->_e(array('widgets','19','flag_noedit')); ?></button>
					
					</div>
				
				</div>
				
				<div class="clearfix"></div>		 
				
				<div id="savemylocationbox" style="display:none">
				
				<div style="border-top:1px solid #ddd; padding-top:10px; padding-bottom:10px; margin-top:10px; margin-left:-15px; margin-right:-15px;"></div>
				
				<button class="btn btn-info btn-lg col-md-12" id="updatelocation"><?php echo $CORE->_e(array('widgets','11')); ?></button>
				
				</div>
				
		</form>
</div>


    </div>
  </div>
</div>
<?php


 if(!isset($_SESSION['mylocation']) || ( isset($_SESSION['mylocation']) && empty($_SESSION['mylocation']) ) ){ 

  echo '<script>jQuery(document).ready(function(){ getCurrentLocation() ; });  </script>';
  
  }
  
$STRING .= ob_get_clean(); 
  
  
}
 
	
	// HOOK INTO FOOTER OUTPUT
	echo hook_includes($STRING);
 
}
/* ========================================================================
 [WORDPRESS INIT] - LOADS WHEN THE PAGE LOADS
========================================================================== */ 
function INIT(){	
		global $wpdb, $CORE, $post, $userdata, $pagenow;
		 		
		// DELETE MEDIA OPTIONS	
		if(isset($_POST['core_delete_attachment']) && $_POST['core_delete_attachment'] == "gogo"){	 
			$CORE->UPLOAD_DELETE($_POST['attachement_id']);
			die();		
		} 
		
		//UPLOAD MEDIA UPLOADS
		if(isset($_FILES['core_attachments']) && !empty($_FILES['core_attachments']) && isset($_POST['value']) && is_numeric($_POST['value']) ){ 	 
			$responce = hook_upload($_POST['value'], $_FILES['core_attachments'], false);		 
			echo json_encode($responce); 
			die();				
		}		
		
		/// SET USER LOCATION
		if(isset($_POST['updatemylocation'])){
				
				$_SESSION['mylocation']['log'] = strip_tags($_POST['log']);
				$_SESSION['mylocation']['lat'] = strip_tags($_POST['lat']);
				$_SESSION['mylocation']['zip'] = strip_tags($_POST['zip']);
				$_SESSION['mylocation']['country'] = strip_tags($_POST['country']);
				$_SESSION['mylocation']['address'] = strip_tags($_POST['myaddress']);

		}
		// CUSTOM COMMENTS SHORTCODE
		if(isset($_POST['commentsform']) && isset($_POST['pid']) && is_numeric($_POST['pid']) && $userdata ){
		
			if(strlen($_POST['comment']) > 0 ){
			 
			$time = current_time('mysql');	
			$data = array(
				'comment_post_ID' => $_POST['pid'],
				'comment_author' => $userdata->display_name,
				'comment_author_email' => 'admin@admin.com',
				'comment_author_url' => 'http://',
				'comment_content' => strip_tags($_POST['comment']),
				'comment_type' => '',
				'comment_parent' => 0,
				'user_id' => $userdata->ID,
				'comment_author_IP' => $this->get_client_ip(),
				'comment_agent' => 'Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US; rv:1.9.0.10) Gecko/2009042316 Firefox/3.0.10 (.NET CLR 3.5.30729)',
				'comment_date' => $time,
				'comment_approved' => 0,
			);
			
			wp_insert_comment($data);			 
			
			}
		
		}
		
		// LIVE EDITOR FOR ADMIN
		if(isset($_POST['pk']) && $_POST['pk'] == "19912" && current_user_can('administrator')){
		
			// GET NAME
			$vv = explode("_",$_POST['name']);
			 
			// GET THE EDITOR TYPE
			if($vv[0] == "posttitle"){
			
				$my_post = array();
				$my_post['ID'] 					= $vv[1];
				$my_post['post_title']			= $_POST['value'];
				wp_update_post( $my_post  );
			
			}elseif($vv[0] == "customfield"){
				
				if(isset($vv[2]) && $vv[2] == "price"){ $_POST['value'] = preg_replace("/\D/", "", $_POST['value']); }
			
				update_post_meta($vv[1], str_replace("xxx","_",$vv[2]), $_POST['value']);
			
			
			}else{
				// GET CURRENT LANGUAGE DATA
				$get_current_languagechanges = get_option('core_language');
				
				// UNFORMAT FORMATted ITEMS
				$vv[0] = str_replace("xxx","_",$vv[0]);
				$vv[1] = str_replace("xxx","_",$vv[1]);
		 
				// SET NEW VALUE
				$get_current_languagechanges['english'][$vv[0]][$vv[1]] = $_POST['value'];
				
				// SAVE CHANGES
				update_option("core_language",$get_current_languagechanges);				
			}
			// DONE
			die("complete");
		 
		}
		
		
		// PRINT PAGE OPTIONS
		if(isset($_GET['print']) && is_numeric($_GET['pid'])){
		$this->PRINTPAGE();
		}		
		// LOAD IN LANGUAGE FILE SYSTEM
		if(is_object($CORE)){
		$CORE->Language();	
		add_filter('language_attributes', array($this, '_language_attr' ) );
		}
		
		// LOAD IN JQUERY
		//wp_deregister_script( 'jquery' );
		wp_enqueue_script('jquery');
		wp_enqueue_script( 'jquery-ui-draggable' );		
		
 
		
		// JQUERY MOBILE
		if(defined('IS_MOBILEVIEW')){
		wp_register_script( 'core.mobile',  FRAMREWORK_URI.'js/core.mobile.js');
		wp_enqueue_script( 'core.mobile' ); 
		} 
		
		// DATE PICKER
		//wp_register_script( 'datetimepicker',  FRAMREWORK_URI.'js/bootstrap-datetimepicker.js');
		//wp_enqueue_script( 'datetimepicker' );			
		// LOAD IN NEW PAGE SETUP FOR LOGIN SYSTEM
		if(!defined('WLT_CUSTOMLOGINFORM')){			
			if($pagenow == "wp-login.php" ){
				if(!isset($_GET['action'])){ $act = "login"; }else{ $act = strip_tags($_GET['action']); }
				if(in_array($act,array('login','register', 'lostpassword','resetpass','rp'))){
				add_action('init', array( $CORE, 'LOGIN' ) , 98); 	
				}	
			}		
		}		
		// LOAD IN CUSTOM STYLES		
		add_action('wp_head',array($CORE, 'CUSTOMHEADER'),1);
		add_action('wp_head',array($CORE, 'CUSTOMMETA') );
		add_action('wp_footer',array($CORE, 'CUSTOMFOOTER'));
				
		// CHECK CART
		if(defined('WLT_CART')){
		global $CORE_CART;	
		$CORE_CART->UPDATECART();
		}
		
		// COUPON CODE CHECKER
		if(isset($_POST['wlt_couponcode']) && strlen($_POST['wlt_couponcode']) > 0 ){			
			// DEFAULT RETURN
		  	$GLOBALS['error_message'] = $CORE->_e(array('checkout','71'))."<script>jQuery(document).ready(function() {jQuery('#myPaymentOptions').modal('show'); });</script>";		
			// CHECK THE CODES
			$wlt_coupons = get_option("wlt_coupons");
			// CHECK WE HAVE SUCH A CODE
			if(is_array($wlt_coupons) && count($wlt_coupons) > 0 ){
				foreach($wlt_coupons as $key=>$field){
					if($_POST['wlt_couponcode'] == $field['code']){					 	
						
						// WORK OUT DISCOUNT AMOUNT
						$discount = $field['discount_percentage'];
						if($discount != ""){
							
							if(defined('WLT_CART')){
							global $CORE_CART;					
							$cart = $CORE_CART->GETCART();							
							$GLOBALS['CODECODES_DISCOUNT'] = str_replace(",","",$cart['total'])/100*$discount;	
							
							//die($discount."% of ".str_replace(",","",$cart['total'])." = ".$GLOBALS['CODECODES_DISCOUNT']);
							}else{
								// MEMBERSHIP PRICES
								if(isset($_POST['membershipID']) && is_numeric($_POST['membershipID']) ){
									$membershipfields 	= get_option("membershipfields");
									$payment_due = $membershipfields[$_POST['membershipID']]['price'];															
									// LISTING PRICES
								}else{
									if(isset($post->ID)){
									$postIDDD = $post->ID;
									}else{
									$postIDDD = $_GET['p'];
									}
									$payment_due = get_post_meta($postIDDD,'listing_price_due',true);									 	
									 					
								}
								$GLOBALS['CODECODES_DISCOUNT'] = $payment_due/100*$discount;
								 
									
							}
							
						}else{
							$GLOBALS['CODECODES_DISCOUNT'] = $field['discount_fixed']; 
						}
						 
						// HOOK INTO CART
						if(defined('WLT_CART')){
							global $CORE_CART;
							$_SESSION['discount_code'] 			= strip_tags($_POST['wlt_couponcode']);
							$_SESSION['discount_code_value'] 	= $GLOBALS['CODECODES_DISCOUNT'];
							add_action('hook_cart_data', array( $CORE_CART, 'CODECODES_APPLYCART') );
						}else{						 
							add_action('hook_payment_package_price', array( $this, 'CODECODES_APPLYLISTING') );
						}
						 						
						// UPDATE THE USAGE COUNTER	
						$wlt_coupons[$key]['used']++;
						
						// LEAVE ERROR MESSAGE
						$GLOBALS['error_message'] = $CORE->_e(array('checkout','72'));
					}			
				} // end foreach
				// UPDATE THE USAGE COUNTER	
				update_option( "wlt_coupons", $wlt_coupons);
			} // end if			
		 }// end if
		
		
		
		// SAVE CUSTOM SEARCHES
		if(isset($_GET['s']) && strlen($_GET['s']) > 2){
		
		$saved_searches_array = get_option('recent_searches');
		
		if(!is_array($saved_searches_array)){ $saved_searches_array = array(); }
	 	
			// STOP HEAVY DATA QUERY
			if(count($saved_searches_array) > 500){
				$saved_searches_array = array();
			}
		
			if(isset($saved_searches_array[strip_tags(str_replace(" ","_",$_GET['s']))])){ 
				
				$views = $saved_searches_array[strip_tags(str_replace(" ","_",$_GET['s']))]['views'];
				$views++;
				$saved_searches_array[strip_tags(str_replace(" ","_",$_GET['s']))] = 
				array(
				"views" => $views, 
				"first_view" => $saved_searches_array[strip_tags(str_replace(" ","_",$_GET['s']))]['first_view'], 
				"last_view" => date('Y-m-d H:i:s') 
				); 
			
			}else{ 
			
				$saved_searches_array[strip_tags(str_replace(" ","_",$_GET['s']))] = 
				array(
				"views" => 1, 
				"first_view" => date('Y-m-d H:i:s'), 
				"last_view" => ""
				);			
			}
					 
		update_option('recent_searches',$saved_searches_array);
		}
		
		/* =============================================================================
		   PAGE ACTIONS
		   ========================================================================== */
		 
			if(isset($_POST['action'])){
			
				switch($_POST['action']){
				
					case "contactform": {
					
						// CHECK VALIDATE CODE IS CORRECT
						if(	isset($_POST['contact_code']) && $_POST['contact_code'] == $_POST['code_value'] && isset($_POST['pid']) && is_numeric($_POST['pid']) ){
						 
							// SAVE MESSAGE
							$Message = "
							".$CORE->_e(array('single','26')).": ".strip_tags($_POST['contact_n1'])."\r\n
							".$CORE->_e(array('single','27')).": ".strip_tags($_POST['contact_e1'])."\r\n
							".$CORE->_e(array('single','28')).": ".strip_tags($_POST['contact_p1'])." \r\n
							".$CORE->_e(array('single','29')).": ".strip_tags($_POST['contact_m1'])."\r\n
							".$CORE->_e(array('single','30')).": <a href='".get_permalink($_POST['pid'])."'>".get_permalink($_POST['pid'])."</a>\r\n"; 
						 
							// GET POST DATA
							$post = get_post($_POST['pid']);				 
							if(!$userdata->ID){	$userid = 1;}else{	$userid = $userdata->ID; }
							$user_info = get_userdata($post->post_author);
							
							$my_post = array();
							$my_post['post_title'] 		= "RE:".$post->post_title;
							$my_post['post_content'] 	= $Message;
							$my_post['post_excerpt'] 	= "";
							$my_post['post_status'] 	= "publish";
							$my_post['post_type'] 		= "wlt_message";
							$my_post['post_author'] 	= $userid;
							$POSTID 					= wp_insert_post( $my_post );
							
							// ADD SOME EXTRA CUSTOM FIELDS
							add_post_meta($POSTID, "username", $user_info->user_login );	
							add_post_meta($POSTID, "userID", $user_info->ID);	
							add_post_meta($POSTID, "status", "unread" );
							add_post_meta($POSTID, "ref", get_permalink($_POST['pid']) );
					
							// SEND EMAIL						 
							$_POST['message'] 	= $_POST['contact_m1'];
							$_POST['phone'] 	= $_POST['contact_p1'];
							$_POST['email'] 	= $_POST['contact_e1'];
							$_POST['name'] 		= $_POST['contact_n1'];
							$_POST['link'] 		= get_permalink($_POST['pid']);
							$CORE->SENDEMAIL($post->post_author,'contact');
							 
							// ADD LOG ENTRY
							$CORE->ADDLOG("<a href='(ulink)'>".$userdata->user_nicename.'</a> used the listing contact form: <a href="(plink)"><b>['.$post->post_title.']</b></a>.', $userdata->ID, $_POST['pid'] ,'label-info');
							
							// SET FLAG
							$GLOBALS['contactformsent'] = true;
							 
							// LEAVE MSG	
							$GLOBALS['error_message'] = $CORE->_e(array('single','8'));	
								
						}else{
						
						$GLOBALS['error_message'] = $CORE->_e(array('single','9'));
						
						}
					
					} break;
				
				}	
			
			}
		
				
	} // END FUN 
/* ========================================================================
 [COUPONS]
========================================================================== */ 
 
	function CODECODES_APPLYLISTING($c){
 
	$c = $c - $GLOBALS['CODECODES_DISCOUNT'];
	if($c < 0){ $c = 0; }
	return $c;	
	}
	
	function _language_attr($language_attributes){	
	 if(isset($GLOBALS['_LANG']['language_attributes'])){
	 	return 'lang="'.$GLOBALS['_LANG']['language_attributes'][1].'"';
	 }else{
		 return $language_attributes;
	 }		 
	}
/* ========================================================================
 GET USER IP
========================================================================== */ 

	function get_client_ip(){
		if (isset($_SERVER['HTTP_CLIENT_IP']) && !empty($_SERVER['HTTP_CLIENT_IP'])){
		  return $_SERVER['HTTP_CLIENT_IP'];
		}
		if (isset($_SERVER['HTTP_X_FORWARDED_FOR']) && !empty($_SERVER['HTTP_X_FORWARDED_FOR'])){
		  return strtok($_SERVER['HTTP_X_FORWARDED_FOR'], ',');
		}
		if (isset($_SERVER['HTTP_PROXY_USER']) && !empty($_SERVER['HTTP_PROXY_USER'])){
		  return $_SERVER['HTTP_PROXY_USER'];
		}
		if (isset($_SERVER['REMOTE_ADDR']) && !empty($_SERVER['REMOTE_ADDR'])){
		  return $_SERVER['REMOTE_ADDR'];
		}else{
		  return "invalid";//"0.0.0.0";
		}
	} 
	/* =============================================================================
	   ORDER BY RESULTS FOR SEARCH PAGE
	   ========================================================================== */
	function format_webpath($extra){ global $post, $query;
	 $start_bit = "&"; $rr = $_SERVER["REQUEST_URI"]; $extra1 = str_replace("&","&amp;",$extra);
	 
	 if(substr($_SERVER["REQUEST_URI"],-1) == "/"){	
	 $start_bit = "?";
	 }	
	 
	 // CHECK IF WE CAN DO IT
	 if( has_term( '', THEME_TAXONOMY ) && is_category() ) {
	 
		 $term_list = wp_get_post_terms($post->ID, THEME_TAXONOMY, array("fields" => "all"));
		 if(isset($term_list[0])){
		 $link = get_term_link($term_list[0], THEME_TAXONOMY);
		 }
		 if(is_string($link)){
		 	$rr = $link;
			$start_bit = "?";
		 }
	 } 
	 
 
	 return str_replace($extra,"",$rr).$start_bit.$extra1; 
	
	}
	function OrderBy(){ global $CORE, $wpdb; $STRING = "";
	
	// GET CURRENT DISPLAY AND CHANGE IT
	if(isset($_GET['order'])){
	
		if($_GET['order'] == "asc"){ $order = "desc"; }else{ $order = "asc"; }
	
	}else{
	$order = "asc";
	}
	
	// BUILD DEFAULT OPTIONS
	$default_orderby_list[] = array(
	//"0" => array("text"=>"ID","query"=>"orderby=ID&order=asc"),
 	"1" => array("text"=>$CORE->_e(array('gallerypage','10')),"query"=>"orderby=post_title&order=asc"),
	"2" => array("text"=>$CORE->_e(array('gallerypage','13')),"query"=>"orderby=post_date&order=asc"),	 
	"3" => array("text"=>$CORE->_e(array('gallerypage','32')),"query"=>"orderby=hits&order=desc"), 
	"4" => array("text"=>$CORE->_e(array('gallerypage','34')),"query"=>"orderby=featured&order=desc"),
 	); 
	
	// REMOVE SLOW QUERIES
	if(WLT_CACHING){ 
	unset($default_orderby_list[0][1]);
	unset($default_orderby_list[0][3]);
	unset($default_orderby_list[0][4]);
	}
	
	
	// STAR RATING SYSTEM
	if( WLT_CACHING == false && isset($GLOBALS['CORE_THEME']['rating']) && $GLOBALS['CORE_THEME']['rating'] == 1 ){
	$default_orderby_list[] = array( 
	"5" => array("text"=>$CORE->_e(array('gallerypage','33')),"query"=>"orderby=rating&order=asc"),
	);
	}
	
	// GEO LOCATION
	if(!defined('WLT_CART') && WLT_CACHING == false && isset($GLOBALS['CORE_THEME']['geolocation']) && $GLOBALS['CORE_THEME']['geolocation'] != "" ){
		$default_orderby_list[] = array( 
		"6" => array("text"=>$CORE->_e(array('gallerypage','21')),"query"=>"orderby=distance&order=asc"),
		);
	}	
	
	// COUPON THEME
	if(defined('WLT_COUPON')  && WLT_CACHING == false){
		$default_orderby_list[] = array( 
		"6" => array("text"=> $CORE->_e(array('single','20')) ,"query"=>"orderby=expires&order=desc"),
		);
	}
	
	// ACTION THEME
	if(defined('WLT_AUCTION') && WLT_CACHING == false ){
		$default_orderby_list[] = array( 	
		"7" => array("text"=>$CORE->_e(array('gallerypage','15')),"query"=>"orderby=price&order=desc"),  	
		"6" => array("text"=> $CORE->_e(array('single','20')) ,"query"=>"orderby=expires&order=desc"), 
		);	
	}
 
	if(in_array(get_option('wlt_base_theme'), array('template_classifieds_theme','template_shop_theme', 'template_microjobs_theme', 'template_comparison_theme' )) && WLT_CACHING == false  ){ 
	$default_orderby_list[] = array( 
	"10" => array("text"=>$CORE->_e(array('gallerypage','15')),"query"=>"orderby=price&order=desc"),  
	);
	}
	 
	
	/*** add-on any custom ones ***/
	$custom = explode(PHP_EOL,stripslashes($GLOBALS['CORE_THEME']['orderbydata'])); 
	if(is_array($custom)){ 
		$cc = 7;
		foreach($custom as $nc){
		$b = explode("[",$nc);
		if(!isset($b[1])){ continue; }
		 
		$default_orderby_list[] = array( $cc => array ("text" => $b[0], "query" => str_replace("]","",$b[1]))  );
		 
		$cc++;
		}
	} 
	
	/*** apply filter ***/
	$default_orderby_list = hook_orderby_list($default_orderby_list);
	/*** unset for price values ***/
	 
	/*** loop and create dislay data ***/
	foreach($default_orderby_list as $vv){
	foreach($vv as $v){
	if(!isset($v['query'])){ continue; }
	
	
		if(isset($_GET['orderby']) && strpos($v['query'], $_GET['orderby'] )  !== false){ 
	
		if($_GET['order'] == "asc"){ $v['query'] = str_replace("asc","desc", $v['query']); }else{ $v['query'] = str_replace("desc","asc", $v['query']); }
		
		$cl = "class='active'"; 
			if($_GET['order'] == "asc"){
			$icon = ' <i class="fa fa-long-arrow-up"></i>'; 
			}else{
			$icon = ' <i class="fa fa-long-arrow-down"></i>'; 
			}
		}else{ 
		
		$cl = ""; 
		$icon = "";
		} 
		 
	
	$STRING .= '<li '.$cl.'><a href="'.$this->format_webpath($v['query']).'" rel="nofollow">'.$v['text'].''.$icon.'</a></li>';
	}
	}
	return $STRING; 
	
}
function check_for_theme_update($theme_data) {
	//
	global $wp_version, $theme_version, $theme_base; $user_ip = $this->get_client_ip(); 
	 
	//Comment out these two lines during testing.
	if (empty($theme_data->checked)){ return $theme_data; }
 	
	if(get_option('wlt_license_key') == ""){ return $theme_data; }
	
	if($this->UPDATE_CHECK() == "0.0.0"){ return $theme_data; }
	
	// NOW LOOP THROUGH ALL OUR PLUGINS TO CHECK FOR UPDATES
	if(is_array($theme_data->checked)){ 	
		
		// LOOP ALL THEMES
		foreach($theme_data->checked as $key => $version){
			// check theme name
			if(substr($key,0,9) != "template_" && !in_array($key,array('AT','CP','CT','DT','RT','ST','VT','CM','MT','JB','KB','DL','DA','SO','MJ','BT')) ){ continue; }
			// build request
			$request = array( 'slug' => $key, 'version' => $version  );
			// Start checking for an update
			$send_for_check = array(
				'body' => array(
					'action' => 'theme_update', 
					'request' => serialize($request),
					'api-key' => md5(get_bloginfo('url'))
				),
				'user-agent' => 'WordPress/' . $wp_version . '; ' . get_bloginfo('url')
			);
			// EXECUTE 
			$raw_response = wp_remote_post("http://www.premiumpress.com/_themes/", $send_for_check);
			 
			if (!is_wp_error($raw_response) && ($raw_response['response']['code'] == 200))
				$response = unserialize($raw_response['body']);
		 
			// Feed the update data into WP updater
			if (isset($response['package'])){		 
				$theme_data->response[$key] = $response;
			}		
		
		} // end foreach
	}// end if 
	
	return $theme_data;
}
function check_for_plugin_update($plugin_data) {
	global $wp_version;	 
	
	// DONT CHECK FOR LOCALHOST
	if($this->get_client_ip() == "127.0.0.1" &&  WP_CONTENT_DIR == "F:\SERVER\htdocs\WP/wp-content"){ return; }
	
	//Comment out these two lines during testing.
	if (empty($plugin_data->checked)){ return $plugin_data; }
	
	// NOW LOOP THROUGH ALL OUR PLUGINS TO CHECK FOR UPDATES
	if(is_array($plugin_data->checked)){
		foreach($plugin_data->checked as $key => $version){
			// ONLY CHECK OUR PLUGINS FOR UPDATES
			if(substr($key,0,4) == "wlt_"){
				
				$bits = explode("/",$key);		 
				$args = array(
					'slug' => $bits[0],
					'version' => $version,
				);
				$request_string = array(
						'body' => array(
							'action' => 'basic_check', 
							'request' => serialize($args),
							'api-key' => md5(get_bloginfo('url'))
						),
						'user-agent' => 'WordPress/' . $wp_version . '; ' . get_bloginfo('url')
				);			 
				// SEND REQUEST TO OUR PLUGINS SERVER
				$raw_response = wp_remote_post("http://www.premiumpress.com/_plugins/", $request_string);				
		 
				if (!is_wp_error($raw_response) && ($raw_response['response']['code'] == 200)){
					$response = unserialize($raw_response['body']);					 
				}
				// Feed the update data into WP updater
				if (is_object($response) && !empty($response)){
					$plugin_data->response[$key] = $response;
				}
			
			}// END IF	
		} // END FOREACH
	} // END IF	
	 
	return $plugin_data;
}

/* =============================================================================
   CORE SYSTEM PLUGIN UPDATE TOOL
   ========================================================================== */
function themes_api_call($def, $action, $args) {
	global $theme_base, $api_url, $theme_version, $wp_version, $api_url;
 
	if($action == "theme_information"){
 
		 
		// SET SITE SO IT KNOWS WERE GOING TO UPDATE
		$plugin_info = get_site_transient('update_themes');
		  
		$request = array(
		'slug' => $args->slug,
		'version' => $theme_version 
		);
		 	 
		// BUILD STRING
		$request_string = array(
					'body' => array(
						'action' => $action, 
						'request' => serialize($request),
						'api-key' => md5(get_bloginfo('url')),
					),
					'user-agent' => 'WordPress/' . $wp_version . '; ' . get_bloginfo('url')
				);				
			
		 
		// MAKE REQUEST
		$request = wp_remote_post("http://www.premiumpress.com/_childthemes/", $request_string);

		// PROCESS AND DISPLAY
		if (is_wp_error($request)) {
		
				$res = new WP_Error('themes_api_failed', 'An Unexpected HTTP Error occurred during the API request.</p> <p><a href="?" onclick="document.location.reload(); return false;">Try again</a>', 
				$request->get_error_message());
		
		} else {			
			
				$res = unserialize($request['body']);
				
				if ($res === false)
					$res = new WP_Error('themes_api_failed', 'An unknown error occurred', $request['body']);
		}
			
		return $res;
	
	
	}elseif($action == "query_themes"){
	
		if($args->browse == "premiumpress"){
		 
		// BUILD STRING
		$request_string = array(
					'body' => array(
						'action' => "query_themes", 
						'request' => serialize( array("theme" => $GLOBALS['CORE_THEME']['template'],"version" => THEME_VERSION, "pagenum" => $_POST['request']['page'])),
						'api-key' => md5(get_bloginfo('url')),
					),
					'user-agent' => 'WordPress/' . $wp_version . '; ' . get_bloginfo('url')
				);				
			 
		// MAKE REQUEST
		$request = wp_remote_post("http://www.premiumpress.com/_childthemes/", $request_string);
	 
		 // PROCESS AND DISPLAY
		if (is_wp_error($request)) {
				$res = new WP_Error('themes_api_failed', 'An Unexpected HTTP Error occurred during the API request.</p> <p><a href="?" onclick="document.location.reload(); return false;">Try again</a>', 
				$request->get_error_message());
		} else {
			
			$res = unserialize($request['body']);
				
			if ($res === false)
					$res = new WP_Error('themes_api_failed', 'An unknown error occurred', $request['body']);
			}
		 
		 	// RETURN DATA
			return $res;				
		}
	
	}	 
	
	// RETURN
	return $def;

}  
function plugin_api_call($def, $action, $args) {
	global  $wp_version;
	
	// RETURN IF INVALID		 
	if (!isset($args->slug)){ return false; } 
	if(substr($args->slug,0,4) != "wlt_"){ return $def; }
	// SET SITE SO IT KNOWS WERE GOING TO UPDATE
	$plugin_info = get_site_transient('update_plugins');
	// GET THE CURRENT VERSION 
	$current_version = $plugin_info->checked[$args->slug .'/'.$args->slug.'.php'];
	$args->version = $current_version;
	// BUILD STRING
	$request_string = array(
			'body' => array(
				'action' => $action, 
				'request' => serialize($args),
				'api-key' => md5(get_bloginfo('url'))
			),
			'user-agent' => 'WordPress/' . $wp_version . '; ' . get_bloginfo('url')
		);
	 // MAKE REQUEST
	$request = wp_remote_post("http://www.premiumpress.com/_plugins/", $request_string);
 	// PROCESS AND DISPLAY
	if (is_wp_error($request)) {
		$res = new WP_Error('plugins_api_failed', 'An Unexpected HTTP Error occurred during the API request.</p> <p><a href="?" onclick="document.location.reload(); return false;">Try again</a>', $request->get_error_message());
	} else {
		$res = unserialize($request['body']);
		
		if ($res === false)
			$res = new WP_Error('plugins_api_failed', 'An unknown error occurred', $request['body']);
	}
	// RETURN
	return $res;
}
/* =============================================================================
  COUNT USER POSTS
   ========================================================================== */

function count_user_posts_by_type( $userid, $post_type = 'post', $EXTRA = "", $include_membershipdate = true ) {
	global $wpdb, $userdata;

	$where = get_posts_by_author_sql( $post_type, true, $userid );
	
	// CHECK IF USER IS ASSIGNED TO A MEMBERSHIP AND SO ONLY COUNT LISTINGS AFTER THEIR MEMBERSHIP WAS ASSIGNED
	if($userid == $userdata->ID && $include_membershipdate){
		
		$mem_startdate = get_user_meta($userid, 'wlt_membership_started', true);
		if(strlen($mem_startdate) > 1){
			$where .= " AND post_date > '".$mem_startdate."'";
		}
	
	}
	
	// ADD IN PENDING LISTINGS TOO
	
	$where = str_replace("post_status = 'publish'","post_status = 'publish' OR post_status = 'pending'", $where);
 
	$count = $wpdb->get_var( "SELECT COUNT(*) FROM ".$wpdb->prefix."posts $where $EXTRA" );
	
 
  	return apply_filters( 'get_usernumposts', $count, $userid );
}
/* =============================================================================
   COUNT USER META SYSTEM
   ========================================================================== */
function COUNTUSER($key,$val,$extra=true){ global $wpdb, $core, $userdata;
 	if($key == ""){ return 0; }
	$SQL = "SELECT count(*) AS total FROM  $wpdb->usermeta AS mt2
	WHERE mt2.meta_key = '".$key."'";
	if(!is_array($val) && strlen($val) > 0){
		if($extra){
		$SQL .= "  AND mt2.meta_value = '".$val."'";
		}else{
		$SQL .= "  AND mt2.meta_value != '".$val."'";
		}
	}elseif(is_array($val)){
		foreach($val as $k){
		if($extra){
		$SQL .= "  AND mt2.meta_value = '".$k."'";
		}else{
		$SQL .= "  AND mt2.meta_value != '".$k."'";
		}
		}	
	} 
	 
	$result = $wpdb->get_results($SQL);
	return $result[0]->total;
}
/* =============================================================================
   COUNT LISTING DATA SYSTEM
   ========================================================================== */
function COUNT($key,$val,$extra=true){ global $wpdb, $core, $userdata; $skey = "";
 	if($key == ""){ return 0; }
	
	$SQL = "SELECT count(*) AS total FROM ".$wpdb->prefix."posts 
	INNER JOIN ".$wpdb->prefix."postmeta AS mt2 ON (".$wpdb->prefix."posts.ID = mt2.post_id) 
	WHERE ".$wpdb->prefix."posts.post_type = '".THEME_TAXONOMY."_type' 
	AND (  ".$wpdb->prefix."posts.post_status = 'publish' ) 
	AND mt2.meta_key = '".$key."'";
	if(!is_array($val) && strlen($val) > 0){
		if($extra){
		$SQL .= "  AND mt2.meta_value = '".$val."'";
		}else{
		$SQL .= "  AND mt2.meta_value != '".$val."'";
		}
	}elseif(is_array($val)){
		foreach($val as $k){
		if($extra){
		$SQL .= "  AND mt2.meta_value = '".$k."'";
		}else{
		$SQL .= "  AND mt2.meta_value != '".$k."'";
		}
		}	
	}
	
	if(is_array($val)){
	foreach($val as $k){ $skey .= "_".$k; }
	}else{
	$skey = $val;
	}
	
	
		// GET THE EXISTING SAVED OPTIONS
		$EXISTNGCOUNT = get_option('wlt_existing_count_'.$key.'_'.$skey);
		
		if(WLT_CACHING == false || ( strtotime($EXISTNGCOUNT['date']) < strtotime(current_time( 'mysql' )) ) ) {
		
			$result = $wpdb->get_results($SQL);
			if(WLT_CACHING == true){			 
			update_option('wlt_existing_count_'.$key.'_'.$skey, array("date" => date('Y-m-d H:i:s', strtotime(date('Y-m-d H:i:s'). "+24 hours") ), "values" => $result), true);
		 	}
		}else{
			$result = $EXISTNGCOUNT['values'];			
	}
	
	 
 
	
	return $result[0]->total;
}
/* =============================================================================
   MESSAGES
   ========================================================================== */
   
function FAVSCOUNT(){ global $userdata; 

if(!$userdata->ID){ return 0; }

$extn = "_list";
if(defined('WP_ALLOW_MULTISITE')){
	$extn .= get_current_blog_id();
}	

$my_list = get_user_meta($userdata->ID, 'favorite'.$extn,true);
if(!is_array($my_list)){ $my_list = array(); }
foreach($my_list as $hk => $hh){ if($hh == 0 || $hh == ""){ unset($my_list[$hk]); } }

if(empty($my_list)){ return 0; }

return count($my_list);   
   
}
function MESSAGECOUNT($userlogin){ global $wpdb, $core, $userdata;

	if($userlogin == ""){ return 0; }
	
	$SQL = "SELECT count(*) AS total FROM ".$wpdb->prefix."posts 
	INNER JOIN ".$wpdb->prefix."postmeta AS mt1 ON (".$wpdb->prefix."posts.ID = mt1.post_id) 
	INNER JOIN ".$wpdb->prefix."postmeta AS mt2 ON (".$wpdb->prefix."posts.ID = mt2.post_id) 
	WHERE 1=1 
	AND mt1.meta_key = 'username' AND mt1.meta_value = ('".$userlogin."')
	AND mt2.meta_key = 'status' AND mt2.meta_value = 'unread'
	AND ".$wpdb->prefix."posts.post_status = 'publish'	";
	
	
	$EXISTINGDATA = get_option('wlt_system_counts');
	if(!is_array($EXISTINGDATA)){ $EXISTINGDATA = array(); }
		
 	if(WLT_CACHING == false || ( !isset($EXISTINGDATA['msgcount']['date']) || ( isset($EXISTINGDATA['msgcount']['date']) && strtotime($EXISTINGDATA['msgcount']['date']) < strtotime(current_time( 'mysql' )) ) ) ) {
	
		$result = $wpdb->get_results($SQL);	
		$EXISTINGDATA['msgcount'] = array("date" => date('Y-m-d H:i:s', strtotime(date('Y-m-d H:i:s'). "+10 minutes")), "count" => $result[0]->total );		
		update_option("wlt_system_counts", $EXISTINGDATA , true);		
		return $result[0]->total;
	
	}else{
	
		return $EXISTINGDATA['msgcount']['count'];
		
	}	 
	
}
function MESSAGELIST($userlogin){

global $wpdb, $CORE, $userdata; $STRING = ""; $i=1; $tcount = 0; $membershipfields = get_option("membershipfields");
 
 	$SQL = "SELECT * FROM ".$wpdb->prefix."posts 
	INNER JOIN ".$wpdb->prefix."postmeta AS mt1 ON (".$wpdb->prefix."posts.ID = mt1.post_id) 
	
	WHERE mt1.meta_key = 'username' AND mt1.meta_value = ('".$userlogin."')
	
	AND ".$wpdb->prefix."posts.post_status = 'publish'	ORDER BY ".$wpdb->prefix."posts.post_date DESC"; 
	//INNER JOIN ".$wpdb->prefix."postmeta AS mt2 ON (".$wpdb->prefix."posts.ID = mt2.post_id) 	
	//AND mt2.meta_key = 'status' AND mt2.meta_value = 'unread'
	$posts = $wpdb->get_results($SQL);
 
	 
	foreach($posts as $post){ 
		
		// STATUS
		$status = get_post_meta($post->ID, "status", true);	
		if($status == "delete"){ continue; }
		
		//SETUP BOX COLOR
		if($status == "unread"){ $bc = "label-success"; $txt = $CORE->_e(array('account','76')); }else{ $bc = "label-default"; $txt = $CORE->_e(array('account','75')); }
		
		// GET AUTHOR
		if($post->post_author == 0){
		$author = '';
		$user_info = "";
		}else{
		$user_info = get_userdata($post->post_author);
		$author = '<p style="font-size:11px;">'.$user_info->display_name.' '.$CORE->_e(array('author','26')).';</p>';		 
		}
	 
		
		// NEW MEMBERSHIP FEATURE
		$msgLink = 'onclick="WLTChangeMsgStatus(\''.str_replace("https://","",str_replace("http://","",get_home_url())).'\', \''.$post->ID.'\', \'msgAjax\');" href="#my'.$post->ID.'" id="#my'.$post->ID.'_link" data-toggle="modal" style="text-decoration:underline;"';	
		 
		if($GLOBALS['current_membership'] != "" && is_numeric($GLOBALS['current_membership']) && is_array($membershipfields) ){
			 
			// DOES THIS MEMBERSHIP ALLOW READ ACCESS?
			if($membershipfields[$GLOBALS['current_membership']]['can_read'] == "no"){
			$msgLink = "";
			$msgLink = 'onclick="alert(\''.$CORE->_e(array('account','80')).'\');" href="javascript:void(0);"  style="text-decoration:underline;"';	
			}
			
		} 
		
		
		$STRING .= '<tr>
		<td><input class="checkbox1" type="checkbox" name="check[]" value="'.$post->ID.'"></td>
		
                    <td style="text-align:center"><span class="label '.$bc.'">'.$txt.'</span></td>
                    <td>
					<a '.$msgLink.'>'.stripslashes($post->post_title).'</a> 
					<a href="javascript:void(0);" onClick="document.getElementById(\'messageID\').value='.$post->ID.';messageDel.submit();" style="font-size:11px; float:right;"><i class="glyphicon glyphicon-trash"></i> '.$CORE->_e(array('button','3')).'</a>';
				 
			
			$STRING .= '<div id="my'.$post->ID.'" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
			<div class="modal-dialog"><div class="modal-content">
				  <div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
					<h3><b>'.stripslashes($post->post_title).'</b></h3>
				  </div>
				  <div class="modal-body">
				  '.$author.'
				  <p>'.wpautop(stripslashes($post->post_content)).'</p>
				  <textarea id="msg_content_'.$post->ID.'" style="display:none;">

------------- '.hook_date($post->post_date).' ------------------
 '.stripslashes(strip_tags($post->post_content)).'</textarea>
				  </div>
				  <div class="modal-footer">';
				   
				  //if($post->post_author != 0 && $post->post_author != 1){
				  $STRING .= '<a class="btn btn-primary" data-dismiss="modal" aria-hidden="true" style="float:left;" onclick="jQuery(\'#sendmsgform\').show();jQuery(\'#usernamefield\').val(\''.$user_info->user_login.'\');jQuery(\'#sendMsgContent\').val(jQuery(\'#msg_content_'.$post->ID.'\').text());jQuery(\'#subjectfield\').val(\'RE:'.strip_tags(addslashes($post->post_title)).'\');">'.$CORE->_e(array('button','9')).'</a>';
				 // }
				  
			    
					$STRING .= '<a class="btn btn-default" data-dismiss="modal" aria-hidden="true">'.$CORE->_e(array('button','7')).'</a>
				  </div>
				</div>	</div></div>				
				';
					
		$STRING .= '</td>
                    <td style="text-align:center"><small>'.hook_date($post->post_date).'</small></td>
                  </tr>';
	$tcount++;	
	} // end foreach  
	
   wp_reset_postdata();
  
	// EMPTY INBOX
	if($tcount == 0){	
		$STRING = '<tr><td colspan=4 style="text-align:center">'.$CORE->_e(array('account','39')).' <script> jQuery(document).ready(function() { jQuery(\'.selectionbox\').hide(); }); </script></td></tr>';	
	}
      
    return  $STRING;

}
/* =============================================================================
	GALLERY PAGE
	========================================================================== */
 
function ValidateCSS($tag){ 
	if(strpos($tag, "http") !== false){	return " url(".$tag.")";}else{	return $tag;}
}

/* =============================================================================
	BANNER DISPLAY SYSTEM
	========================================================================== */
function BANNER($location){ 
 
global $wpdb, $wp_query;
 
$STRING = ""; $wlt_banners = get_option("wlt_banners"); $expired = array(); $bbb = 0;

// CHECK FOR SELLSPACE ADVERTISING
if(isset($GLOBALS['CORE_THEME']['sellspace_enable']) && $GLOBALS['CORE_THEME']['sellspace_enable'] == 1){
$spa = hook_sellspace($this->sellspace);
$sellspacedata = $GLOBALS['CORE_THEME']['sellspace'];

foreach($spa as $key => $sp){ $bbb++;

	if($sp['p'] == $location && $sellspacedata[$key] == '1'){
		
		$OUTPUTSTRING = "";
		$OUTINNER = "";
		// MIN COUNT
		$mindisplay = 0;
		
	 	// NOW LETS SEE IF WE HAVE ANYONE ADVERITISNG IN THIS SPACE
		$SQL = "SELECT p.ID AS campaignID, pm1.meta_value AS bannerID,  pm2.meta_value AS bannerIMG, pm3.meta_value AS impressions, pm4.meta_value AS impressions_array, pm5.meta_value AS listing_expiry_date  
		FROM ".$wpdb->posts." AS p
		INNER JOIN ".$wpdb->postmeta." ON ( ".$wpdb->postmeta.".post_id = p.ID)		
		INNER JOIN ".$wpdb->postmeta." pm1 ON ( pm1.post_id = p.ID AND pm1.meta_key = 'bannerid' AND pm1.meta_value != '' )	
		INNER JOIN ".$wpdb->postmeta." pm2 ON ( pm2.post_id = pm1.meta_value AND pm2.meta_key = 'img' )
		INNER JOIN ".$wpdb->postmeta." pm3 ON ( pm3.post_id = p.ID AND pm3.meta_key = 'impressions')	
		LEFT JOIN ".$wpdb->postmeta." pm4 ON ( pm4.post_id = p.ID AND pm4.meta_key = 'impressions_array')
		INNER JOIN ".$wpdb->postmeta." pm5 ON ( pm5.post_id = p.ID AND pm5.meta_key = 'listing_expiry_date')
		WHERE p.post_title LIKE ('%".$key."%') 
		AND pm1.meta_value != '' AND pm1.meta_value != 0	 
		AND p.post_type = 'wlt_campaign'
		AND p.post_status = 'publish'
		GROUP BY bannerID 
		ORDER BY rand() LIMIT ".$spa[$key]['max']*2; 		
		
		
		// GET THE EXISTING SAVED OPTIONS
		$EXISTNGBANNERDATA = get_option('wlt_existing_bannerdata');
		
		if(WLT_CACHING == false || ( strtotime($EXISTNGBANNERDATA['date']) < strtotime(current_time( 'mysql' )) ) ) {
		
			$wpdb->query('SET OPTION SQL_BIG_SELECTS = 1');
			$bannerdata = $wpdb->get_results($SQL, OBJECT); 
			
			if(WLT_CACHING == true){			 
			update_option("wlt_existing_bannerdata", array("date" => date('Y-m-d H:i:s', strtotime(date('Y-m-d H:i:s'). "+24 hours") ), "values" => $bannerdata), true);
		 	}
		}else{
			$bannerdata = $EXISTNGBANNERDATA['values'];			
		}
		
		// RANDOMLY PICK FROM SAVED DATA		 
		while(count($bannerdata) > $spa[$key]['max']){
			shuffle($bannerdata);
			unset($bannerdata[0]);			 
		}
		 
   		// DISPLAY DATA
		if (!empty($bannerdata)){
		 
		 	foreach($bannerdata as $banner){ 
			 
		 	
				// CHECK IF CAMPAIGN HAS EXPIRED
				$listing_expiry_date = $banner->listing_expiry_date;
				if($listing_expiry_date == "" || ( strtotime($listing_expiry_date) < strtotime(current_time( 'mysql' )) )){ 
					$expired[] = $banner->campaignID;
				}
			 	
				// MAKE SURE BANNER IS VALID
				if(is_numeric($banner->bannerID) && $banner->bannerID != 0){
				 
					if($banner->bannerIMG == ""){ continue; }	  
					
					// OUTPUT 
					$OUTINNER .= "<a href='".home_url()."/out/".$banner->campaignID."/url/' rel='nofollow' target='_blank'><img src='".$banner->bannerIMG."' class='sellspace_banner' alt='".$key."'></a>";
				
					$data = $banner	->impressions_array;
					if(!is_array($data)){ $data = array(); }
					
					// GET IP ADDRESS
					$user_ip = $this->get_client_ip(); 
					$date_now = date('Y-m-d');
					 
					if(isset($data[$date_now]) && isset($data[$date_now][$user_ip])){
					
						// UPDATE EXISTING ENTRY	
						$data[$date_now][$user_ip] = array("date" => $data[$date_now][$user_ip]['date'],"hits" => $data[$date_now][$user_ip]['hits']+1, "last_visit" => date('Y-m-d H:i:s') );
					
					}else{
					
						$data[$date_now][$user_ip] = array("date" => date('Y-m-d H:i:s'), "hits" => 1);
									
					}
					 
					// PERFORM  MULTIPLE UPDATE		
					$newhits = $banner->impressions + 1 ; 
					update_post_meta( $banner->campaignID, 'impressions', $newhits );
					update_post_meta( $banner->campaignID, 'impressions_array', serialize($data) );
					 
					//UPDATE COUNTER
					$mindisplay++;
				
				}
			
			}
		
		}
	 	
		// CHECK IF ITS EXPIRED
		if(!empty($expired)){
			foreach($expired as $eid){ if(is_numeric($eid)){
				$my_post = array();
				$my_post['ID'] 			= $eid;
				$my_post['post_status'] = "draft";
				wp_update_post( $my_post );						
			} }
		}
		
		
		// DISPLAY SAMPLE BANNERS IF REQUIRED
		if($sellspacedata[$key."_sample"] == '1' && $mindisplay < $sp['min']){
		
			while($mindisplay < $sp['min']){
				
				// CHECK FOR A CUSTOM LINK
				if(isset($GLOBALS['CORE_THEME']['links']['sellspace']) && $GLOBALS['CORE_THEME']['links']['sellspace'] != ""){
				$adlink = $GLOBALS['CORE_THEME']['links']['sellspace'];
				}else{
				$adlink = $GLOBALS['CORE_THEME']['links']['myaccount']; 
				}
			
				$OUTINNER .= '<a href="'.$adlink.'?selladd=1&amp;ad='.$key.'">
				<div class="sellspace_banner banner_'.$sp['sw'].'_'.$sp['sh'].' text-center hidden-xs hidden-sm" style="width:'.$sp['sw'].'px; height:'.$sp['sh'].'px">
				<div class="title">Advertise Here</div> <div class="pricing">view pricing</div>
				</div>
				</a>';
				$mindisplay++;
			}
		}		
				
		$OUTPUTSTRING .= $OUTINNER;
		if($OUTINNER != ""){
		return "<div class='wlt_sellspace ".$location."'>".$OUTPUTSTRING."</div>";
		}
		 
	}
}
}


// SKIP FOR HOME PAGE
if($location == "middle_top" && isset($GLOBALS['flag-home']) ){ return; }

if(isset( $GLOBALS['CORE_THEME']['banners'][$location] ) && is_array($GLOBALS['CORE_THEME']['banners'][$location]) && !empty($GLOBALS['CORE_THEME']['banners'][$location]) ){

	// NOW WE HAVE A LIST OF BANNERS WE NEED TO FIND ONE THAT MATCHES THE CATEGORY WERE IN
	$category = $wp_query->get_queried_object(); $possible_banners = array();
 
	// LOOP THROUGH ALL BANNERS IN THIS LOCATION
	foreach($GLOBALS['CORE_THEME']['banners'][$location] as $k=>$bannerID){
	$bannerID = str_replace("banner_","",$bannerID);
		if(isset($wlt_banners[$bannerID]['category']) && is_array($wlt_banners[$bannerID]['category']) && !empty($wlt_banners[$bannerID]['category'])){
			foreach($wlt_banners[$bannerID]['category'] as $kg=>$kk){
				if(isset($category->term_id) && $kk == $category->term_id){
					$possible_banners = array_merge($possible_banners,array($bannerID));
				}			
			}
		}else{
		$possible_banners = array_merge($possible_banners,array($bannerID));
		}
	 
	}
	// NOW WE HAVE ALL POSSIBLE BANNERS, LETS SELECT A RANDOM ONE
	if(!empty($possible_banners)){
		$rk = array_rand($possible_banners, 1);
		$rk = $possible_banners[$rk];
		if(!isset($wlt_banners[$rk]['code'])){ $wlt_banners[$rk]['code'] = ""; }
		$STRING = do_shortcode(stripslashes($wlt_banners[$rk]['code']));
		// NOW LETS UPDATE THIS BANNER VIEWS
		$wlt_new_banners = $wlt_banners;
		if($wlt_new_banners[$rk]['views'] == ""){ $wlt_new_banners[$rk]['views'] = 0; }
		$wlt_new_banners[$rk]['views']++;
		 update_option("wlt_banners",$wlt_new_banners, true);  
	}
 
}
return $STRING;
}

function packagedata($id, $key=""){
	
	if(isset($GLOBALS['packagefields'])){
		$packagefields 		= $GLOBALS['packagefields'];
	}else{
		$packagefields 		= get_option('packagefields');
	}
		 
	$packagefields = $this->multisort( $packagefields , array('order') );	
	foreach($packagefields as $field){
		if($field['ID'] == $id){
			if( $key == ""){
			return $field;
			}else{
			return $field[$key];
			}
		}
	}

}
function packageenhancements(){ global $CORE, $userdata; $STRING = ""; $packagefields = get_option("packagefields"); $membershipfields = get_option("membershipfields");

	$earray = array(
 
	'2' => array('dbkey'=>'featured',		'text'=>$CORE->_e(array('add','41')),'desc'=>$CORE->_e(array('add','41d')) ),
	'3' => array('dbkey'=>'html',			'text'=>$CORE->_e(array('add','42')),'desc'=>$CORE->_e(array('add','42d')) ), 
	'4' => array('dbkey'=>'visitorcounter',	'text'=>$CORE->_e(array('add','43')),'desc'=>$CORE->_e(array('add','43d')) ),
	'5' => array('dbkey'=>'topcategory',	'text'=>$CORE->_e(array('add','44')),'desc'=>$CORE->_e(array('add','44d')) ),
	'6' => array('dbkey'=>'showgooglemap',	'text'=>$CORE->_e(array('add','45')),'desc'=>$CORE->_e(array('add','45d')) ),
	); 
	
	
	$STRING .= '<ul class="list-group">';
	
	foreach($earray as $key=>$val){
	
		if($GLOBALS['CORE_THEME']['enhancement'][$key.'_price'] > 0 ){ 
	
			if(isset($_GET['eid']) && get_post_meta($_GET['eid'], $val['dbkey'],true) == "yes" && !isset($_GET['upgradepakid'])){ $checked1="checked=checked";  }else{ $checked1=""; }
			
			// CHECK IF ITS INCLUDED IN THE PACKAGE PRICE
			$isFree = false;
			if(isset($_POST['packageID']) && 
			(isset($packagefields[$_POST['packageID']]['enhancement'][$key]) && $packagefields[$_POST['packageID']]['enhancement'][$key] == "1") 
			
			 
			){ 
			$isFree = true;
			$checked1 = "checked=checked disabled"; 
			} 
		
			$STRING .= '<li><div class="checkbox"> ';
			
			if($key == 3 && !$userdata->ID  ){ $extra = "jQuery('.stepblock2').collapse('show');"; }else{ $extra = ""; }
			
			if($isFree){
			$STRING .= '<input checked=checked disabled type="checkbox" name="enhancement['.$key.']" id="exh'.$key.'">
			<input type="hidden" name="enhancement['.$key.']" value="on">
			<span class="badge badge-success"> <strike>'.hook_price($GLOBALS['CORE_THEME']['enhancement'][$key.'_price']).'</strike></span> <span class="label label-success">'.$CORE->_e(array('add','55')).'</span>'; 
			}else{
			$STRING .= '<input '.$checked1.' type="checkbox" name="enhancement['.$key.']" onclick="'.$extra.'listingenhancement(\'exh'.$key.'\','.$GLOBALS['CORE_THEME']['enhancement'][$key.'_price'].')" id="exh'.$key.'">
			<span class="badge exh'.$key.'_b"> '.hook_price($GLOBALS['CORE_THEME']['enhancement'][$key.'_price']).'</span>'; 
			}
			
			$STRING .= ' '.$val['text'].' 
			 <span class="fa fa-info-circle pull-right eninfo'.$key.'" style="cursor:pointer"></span> 
			 
			 <script>

jQuery(\'.eninfo'.$key.'\').hover(function () {
    jQuery(\'#myeninfo'.$key.'\').modal({
        show: true
    });
});

</script>
			 
			 ';
			
			$STRING .= '<div id="myeninfo'.$key.'" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
			<div class="modal-dialog"><div class="modal-content">
				  <div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
					<h3><b>'.$val['text'].'</b></h3>
				  </div>
				  <div class="modal-body">
					<p>'.$val['desc'].'</p>
				  </div>
				  <div class="modal-footer">
					<a class="btn btn-default" data-dismiss="modal" aria-hidden="true">'.$CORE->_e(array('single','14')).'</a>
				  </div>
				</div></div></div> </div>';
		}
		
		
	
	}
	
	$STRING .= '</ul>';
	
	return $STRING;

}


function packageblock($type="1",$data="packagefields", $package=1){ global $wpdb, $CORE, $userdata; get_currentuserinfo(); $counter =1;  $STRING = "";  $infobox = "";
	
	// PACKAGE /MEMEBERSHIP DATA
	$packagefields 		= get_option($data);	 
    $packagefields = $CORE->multisort( $packagefields , array('order') );	
	$TOTALCOUNT = count($packagefields);
	
	// CHECK FOR CURRENT MEMBERSHIP AND REDUCE COUNT
	if(isset($GLOBALS['current_membership']) && is_numeric($GLOBALS['current_membership']) ){
	$TOTALCOUNT=$TOTALCOUNT-1;
	}
	
	foreach($packagefields as $field){
	
	if(isset($field['hidden']) && $field['hidden'] == "yes"){ continue; }
	 
	if(isset($GLOBALS['current_membership']) && is_numeric($GLOBALS['current_membership']) && $GLOBALS['current_membership'] == $field['ID']){  continue; }
	
	// CHANGE DISPLAY TYPE
	
	if($type == 1){		   
	$STRING .='<div class="col-md-3 package package'.$package.'">
	
		<div class="thumbnail">';
	
			 if(strlen($field['image']) > 1){ $STRING .='<img src="'.$field['image'].'" alt="'.$field['name'].'">'; }
		
			$STRING .='<div class="caption">
		
				<h3>'.stripslashes($field['name']).'</h3>
			
				<p>'.stripslashes($field['subtext']).'</p>';
				
            $STRING .='<hr />
                <a class="btn btn-default" href="#myModal'.$package.'" role="button"  data-toggle="modal">'.$CORE->_e(array('add','2')).'</a>
					
				<a class="btn btn-primary" href="javascript:void(0);" onclick="document.getElementById(\'packageID\').value=\''.$field['ID'].'\';document.PACKAGESFORM.submit();">'.$CORE->_e(array('add','3')).'</a>
				 
			</div>    
	
		</div>
		
	</div>';
	
	}elseif($type == 2){
	
	
	if($data == "packagefields"){ $labelc = "s";  }else{ $labelc = "w"; }
	
		$STRING .='<li class="list-group-item">';
		
		if($field['price'] != "" && $field['price'] != 0){
		$STRING .='<h3 class="pull-right"><span class="label label-'.$labelc.'">'.hook_price($field['price']).'</span></h3>';
		}
		
		$STRING .='<h4>'.$field['name'].'</h4><p>'.$field['subtext'].'</p>';
		
		if($data == "packagefields"){
		$STRING .='<a class="btn btn-primary" href="javascript:void(0);" onclick="document.getElementById(\'packageID\').value=\''. $field['ID'].'\';document.PACKAGESFORM.submit();">'.$CORE->_e(array('account','4')).'</a>';
		}else{
			if(!$userdata->ID && !isset($GLOBALS['flag-register']) ){
			$STRING .= '<a class="btn btn-primary btn-right" href="'.site_url('wp-login.php?action=login&amp;redirect_to='.$GLOBALS['CORE_THEME']['links']['add'], 'login_post').'">'.$CORE->_e(array('button','21')).'</a>&nbsp;';
			}else{
			
			if($field['price'] > 0){
			$btn_text = $CORE->_e(array('button','21'))."";
			}else{
			$btn_text = $CORE->_e(array('add','56'));
			}
			$STRING .='<a class="btn btn-primary" href="javascript:void(0);" onclick="document.getElementById(\'membershipID\').value=\''. $field['ID'].'\';document.MEMBERSHIPFORM.submit();">'.$btn_text.'</a>&nbsp;';
			 
			}
		}
		
		$STRING .='<a class="btn btn-default" href="#myModal'.$package.'" role="button"  data-toggle="modal">'.$CORE->_e(array('add','2')).'</a> ';
		
		
		$STRING .= '<div class="clearfix"></div></li>';
		
	}elseif($type == 3){
	
	
	if($data == "packagefields"){
	$tt = '34';
		$buybtn ='<a class="btn btn-lg btn-primary" href="javascript:void(0);" onclick="document.getElementById(\'packageID\').value=\''. $field['ID'].'\';document.PACKAGESFORM.submit();">'.$CORE->_e(array('account','4')).'</a>';
	}else{
	$tt = '34a';
			if(!$userdata->ID && !isset($GLOBALS['flag-register']) ){
			$buybtn = '<a class="btn btn-lg btn-primary" href="'.home_url().'/wp-login.php?action=login&amp;redirect_to='.$GLOBALS['CORE_THEME']['links']['add'].'">'.$CORE->_e(array('button','21')).'</a>';
			}else{
			
			if($field['price'] > 0){
			$btn_text = $CORE->_e(array('button','21'));
			}else{
			$btn_text = $CORE->_e(array('add','56'));
			}
			$buybtn = '<a class="btn btn-lg btn-primary" href="javascript:void(0);" onclick="document.getElementById(\'membershipID\').value=\''. $field['ID'].'\';document.MEMBERSHIPFORM.submit();">'.$btn_text.'</a>';
			
			}
	}
	
	if($field['price'] != "" && $field['price'] != 0){
		$price = hook_price($field['price']);
	}else{
	
	$price = $CORE->_e(array('button','19'));
	}
	
 	// class for display
	switch($TOTALCOUNT){
		case "1": { $fclass = "col-md-6 col-sm-6 col-md-offset-3"; } break;
		case "2": { $fclass = "col-md-6 col-sm-6"; } break;
		case "3": { $fclass = "col-md-4 col-sm-6"; } break;
		default: {$fclass = "col-md-3 col-sm-6";  }
	}
	
	$STRING .= ' <div class="'.$fclass.'">
          <div class="panel panel-default text-center">
            <div class="panel-heading">
              <h5>'.$field['name'].' </h5>
			  </div>
			
            <div class="panel-body">
			<span class="panel-title price">'.$price.'</span>';
			
			 if(defined('WLT_AUCTION') ){	
				 if($GLOBALS['CORE_THEME']['auction_theme_usl'] == '1'){			 
				 }else{
				 	$STRING .= '<span class="days">'.str_replace("%a", $field['expires'] ,$CORE->_e(array('add',$tt))).'</span>';
				 }
			 }else{			 
			 $STRING .= '<span class="days">'.str_replace("%a", $field['expires'] ,$CORE->_e(array('add',$tt))).'</span>';
			 }              
			  
            $STRING .= '</div>';
			
			if(strlen($field['subtext']) > 1){
			$STRING .= '<p>'.stripslashes($field['subtext']).'</p>';
			}
			
           $STRING .= ' <ul class="list-group">';
			
			
			// LIST PACKAGE FEATURES
			if(!isset($field['enable_text']) || (isset($field['enable_text']) && $field['enable_text'] == "1" ) ){
				if($data == "packagefields"){
				$earray = array(
			 
				'2' => array('dbkey'=>'featured',		'text'=>$CORE->_e(array('add','41')),'desc'=>$CORE->_e(array('add','41d')) ),
				'3' => array('dbkey'=>'html',			'text'=>$CORE->_e(array('add','42')),'desc'=>$CORE->_e(array('add','42d')) ), 
				'4' => array('dbkey'=>'visitorcounter',	'text'=>$CORE->_e(array('add','43')),'desc'=>$CORE->_e(array('add','43d')) ),
				'5' => array('dbkey'=>'topcategory',	'text'=>$CORE->_e(array('add','44')),'desc'=>$CORE->_e(array('add','44d')) ),
				'6' => array('dbkey'=>'showgooglemap',	'text'=>$CORE->_e(array('add','45')),'desc'=>$CORE->_e(array('add','45d')) ),
				);
				$i=0;
				foreach($earray as $key=>$enhance){
					// CHECK WE ARE USING THIS FEATURE
					 if(defined('WLT_DEMOMODE') || $GLOBALS['CORE_THEME']['enhancement'][$key.'_price'] > 0){
						// NOW CHECK IF ITS PART OF THE PACKAGE
						if($i%2){ $bit = "even"; }else{ $bit = 'odd'; }
						if(isset($field['enhancement'][$key]) && $field['enhancement'][$key] == "1"){
						$STRING .= '<li class="list-group-item row-'.$bit.'">
						<span class="col-md-2"><i class="glyphicon glyphicon-ok"></i></span>
						<span class="col-md-10">'.$enhance['text'].'</span>
						<div class="clearfix"></div>
						</li>';
						}else{ 
						$STRING .= '<li class="list-group-item row-'.$bit.'">
						<span class="col-md-2"><i class="glyphicon glyphicon-remove"></i></span>
						<span class="col-md-10">'.$enhance['text'].'</span>
						<div class="clearfix"></div>
						</li>';
						 
						}// END IF
						$i++;
					 } // END IF		
				} // END FOREACH
				
				
				// LIST MEMBERSHIP FEATURES
				} 
			}// end if default text
			
			
			// ADD ON EXTRAS DEFINED BY THE USER
		 $i=1; 
		 while($i < 10){
		 if(isset($field['etext'.$i]) && strlen($field['etext'.$i]) > 1){
			 if($i%2){ $bit = "even"; }else{ $bit = 'odd'; }
			 $STRING .= '<li class="list-group-item row-'.$bit.'">
						'.$field['etext'.$i].'
						</li>';
			}
			$i++; 
		}  
			
			
			
			// ADD ON INFO BOX
			if(strlen($field['description']) > 5){
			$infobox = '<div class="clearfix"></div><div class="moreinfo"><a href="#myModal'.$package.'" role="button"  data-toggle="modal">'.$CORE->_e(array('add','2')).'</a></div>';
			}
			
            $STRING .= '<li class="list-group-item panel-footer"> '.$buybtn.$infobox.' </li>
			
            </ul> 
          </div>          
        </div>';
	
	
	}
	  
	 
		$STRING .= '<!----------------------- PACKAGE DESCRIPTION ------------------------->
		<div id="myModal'.$package.'" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
		<div class="modal-dialog"><div class="modal-content">
		  <div class="modal-header">
			<button type="button" class="close" data-dismiss="modal" aria-hidden="true">x</button>
			<h4 class="modal-title">'.$field['name'].'</h4>
		  </div>
		  <div class="modal-body">
			<p>'.stripslashes($field['description']).'</p>			
		  </div>
		  
		</div>
		</div></div> 		
		<!----------------------- end PACKAGE DESCRIPTION -------------------------> ';   
			 
		if($counter==4 && $type == 1){$STRING .='</div><div class="row">'; $counter=0; } $counter++; $package++; } 
		
		return hook_packages_block($STRING);

}
/* =============================================================================
	LOG ENTRY FUNCTION
	========================================================================== */

function ADDLOG($message='',$userid='',$postid='',$link='label-success'){ global $wpdb;

$sql = "INSERT INTO  ".$wpdb->prefix."core_log (`datetime` ,`userid` ,`postid` ,`link` ,`message`)
VALUES ( NOW(),  '".$userid."',  '".$postid."',  '".esc_sql($link)."',  '".esc_sql($message)."');";
$wpdb->query($sql);

}
/* =============================================================================
	 COUPON CODES
	========================================================================== */

function COUPONCODES(){ global $CORE, $wpdb; $STRING = "";
 
if(isset($GLOBALS['CORE_THEME']['couponcodes']) && $GLOBALS['CORE_THEME']['couponcodes'] == '1'){  $wlt_coupons = get_option("wlt_coupons");
$STRING .= '
<form  name="couponcodes" id="couponcodesform" method="post">';
// ADD IN EXTRA BIT FOR MEMBERSHIP AREA
if(isset($_POST['membershipID']) && is_numeric($_POST['membershipID']) ){
	$STRING .= '<input type="hidden" name="membershipID" value="'.$_POST['membershipID'].'" />';
}

// ERROR MESSAGE
if(isset($GLOBALS['flag-single']) && isset($GLOBALS['error_message']) && strlen($GLOBALS['error_message']) > 2){
$STRING .= $CORE->ERRORCLASS($GLOBALS['error_message'],'info');
}
// end
$STRING .= '<fieldset>	  
<div class="panel-group" id="CouponCodes">
<div class="panel panel-default">

	<div class="panel-heading">
        <a class="panel-toggle" data-toggle="collapse" data-parent="#CouponCodes" href="#collapseOne">
        <b>'.$CORE->_e(array('checkout','73')).'</b>
        </a>
     </div>
    
    <div id="collapseOne" class="panel-body collapse in" style="height: auto;">
        <div class="panel-inner">
            <div class="control-group">
            <label for="input01" class="control-label">'.$CORE->_e(array('checkout','74')).' </label>
                <div class="controls">
                <input type="text" id="wlt_couponcode" name="wlt_couponcode" class="form-control input-lg" placeholder="'.$CORE->_e(array('checkout','75','flag_noedit')).'">
                <p class="help-block">'.$CORE->_e(array('checkout','76')).'</p>
				 
				 <button class="btn btn-default" type="submit">'.$CORE->_e(array('checkout','77')).'</button>
                </div>
            </div>        
        </div>
	</div>
	
</div>
</fieldset>
</form>
<script>
jQuery(document).ready(function() {
jQuery("#collapseOne").collapse("hide");
});
</script>
';
}
 return $STRING;

}
/* =============================================================================
	 FEATURED
	========================================================================== */

function FEATURED($postid){
	$featured = get_post_meta($postid,'featured',true);		
	if($featured == "yes"){ $featured_class = " featured";  }else{ $featured_class = ""; }
	return hook_css_featured($featured_class);
}

/* =============================================================================
	 USEFUL BLANK ME FUNCTION
	========================================================================== */

function BLANK($c=""){
return "";
}
/* =============================================================================
	 DATE FORMATTING
	========================================================================== */

function DATETIME($extratime = ""){

	if($extratime !=""){
	return date('Y-m-d H:i:s', strtotime(current_time( 'mysql' ) . $extratime) );
	}else{
	return get_the_date(date('Y-m-d H:i:s', strtotime(current_time( 'mysql' )) ));
	}
	
}
function DATE($date){
	global $wpdb;
	if($date == "" || is_array($date) ){return; }	
	 	
	$date_format = get_option('date_format') . ' ' . get_option('time_format');		
	 
	return mysql2date($date_format,$date);
}
/* =============================================================================
	GET IMAGE STANDARD
	========================================================================== */

function FALLBACK_IMAGE($postid){ global $MEDIA;

	return $MEDIA->_FALLBACK($postid);
	
}
function GETIMAGE($postID, $link=true, $atrs = array()){ global $wpdb, $post, $CORE; if(!is_numeric($postID)){ return; } $image = "";
 
// CHECK IF WE HAVE A THUMBNAIL
if ( has_post_thumbnail($postID) ) { 					
	if(isset($GLOBALS['flag-single'])){ 
	$image .= hook_image_display(get_the_post_thumbnail($postID, 'full', array('class'=> "wlt_thumbnail")));
	}else{
	if($link){	$permalink = get_permalink($postID); $image .= '<a href="'.$permalink.'" class="frame">'; }
	$image .= hook_image_display(get_the_post_thumbnail($postID, array(183,110), array('class'=> "wlt_thumbnail")));	 	
	if($link){ $image .= '<div class="clearfix"></div></a>'; }	
	} 
// CHECK FOR FALLBACK IMAGE				
}else{
	 
	$fimage = $this->FALLBACK_IMAGE($postID); 	
	if($fimage != ""){ 
		 
			if($link){ $permalink = get_permalink($postID); $image .= '<a  href="'.$permalink.'" class="frame">'; }
			$image .= $fimage; 
			if($link){ $image .= '<div class="clearfix"></div></a>'; }
		 
	}
}
if(isset($atrs['pathonly'])){ 
$array = array();
preg_match( '/src="([^"]*)"/i', $image, $array ) ;
return $array[1];
}
return preg_replace('/\\<(.*?)(width="(.*?)")(.*?)(height="(.*?)")(.*?)\\>/i', '<$1$4$7>', $image);
}
 
/* =============================================================================
	 OBJECT EXTRAS
	========================================================================== */
function _custom_query_selection($key){ $STRING = "";

$g = array(
"meta_key=featured&meta_value=yes" => "Only Featured Listings", 
 
"orderby=IDorder=desc" => "Latest Listings", 
"orderby=rand" => "Random Listings",

);

$STRING .= '<select onchange="jQuery(\'#'.$key.'\').val(this.value);"><option value="">--- sample query strings ---</option>';
foreach($g as $k=>$v){
$STRING .= "<option value='".$k."'>".$v."</option>";
}
$STRING .= "</select>";
return $STRING;
}	
/* =============================================================================
	 RESTRICT PAGE ACCESS BASED ON MEMBERSHIP PACKAGE
	========================================================================== */

function MEMBERSHIPACCESS($post_id){

global $wpdb, $userdata, $post;

	$current_access = get_post_meta($post_id, "access", true);

	if(!is_array($current_access)){ return true; }
	
	if(isset($userdata) && $userdata->ID){
	
		$current_membership	= get_user_meta($userdata->ID,'wlt_membership',true);		
		
		if(in_array($current_membership,$current_access) || in_array(99,$current_access) ){ return true; }		
		
		if(isset($post->post_author) && $post->post_author == $userdata->ID){ return true; }
		
		return false;
	
	}else{
	
		if(in_array(99,$current_access)){ return true; }else{ return false; }
	
	}	

}

function TIMEOUTACCESS($post_id){ global $userdata;

	/// CHECK FOR TIMEOUT ACCESS
	$current_access = get_post_meta($post_id, "timeaccess", true);
	if(!is_array($current_access)){ return true; }

	if(isset($userdata) && $userdata->ID){
	
		$current_membership	= get_user_meta($userdata->ID,'wlt_membership',true);
		
		// 100 is member access id
		if($current_membership == ""){
			$current_membership = "100";
		}
		
		// CHECK
		if(isset($current_access[$current_membership]) ){		
			$time = $current_access[$current_membership]['time'];
			$redirect = $current_access[$current_membership]['link'];		
		}
	
	}else{
		
		// CHECK FOR GUESS ACCESS ID: 99
		if(isset($current_access[99]) ){		
			$time = $current_access[99]['time'];
			$redirect = $current_access[99]['link'];		
		}
	
	}	

	if(isset($time) && is_numeric($time) ){
	
	//CUSTOMIZE REDIRECT
	$GLOBALS['wlt_timeoutacess_redirect'] = str_replace("[ID]",$post_id,$redirect);
	$GLOBALS['wlt_timeoutacess_time'] = $time;
	
	// HOOK META AND REDIRECT	 
	add_action('wp_head',array($this, 'rrddff'));

	}	
	
}

function rrddff(){ echo '<meta http-equiv="refresh" content="'.$GLOBALS['wlt_timeoutacess_time'].'; url='.$GLOBALS['wlt_timeoutacess_redirect'].'">'; }

/* =============================================================================
	 CORE HIT COUNTER / VISITOR COUNTER
	========================================================================== */
	
function RECENTLYVIEWED($post_id, $userid = "", $get = false){ global $post, $userdata, $wpdb;

if(!$userdata->ID){ return; }

	if($userid == ""){ $userid = $userdata->ID; }
	 
	$recent = get_user_meta($userid, "recentlyviewed",true);
	
	if(!array($recent)){ $recent = array(); } 
	
	if($get){
	 
 		return $recent ;
	  
	}else{
		
		// RESET
		if(count($recent) > 50){
		update_user_meta($userid, "recentlyviewed", "");
		}
		
		$recent[] 	= $post_id;		
		update_user_meta($userid, "recentlyviewed", $recent);
	
	}

}
function HITCOUNTER($post_id, $output = false){ global $post, $wpdb;
 
 
 	if( !isset($GLOBALS['CORE_THEME']['hitcounter']) || ( isset($GLOBALS['CORE_THEME']['hitcounter']) && $GLOBALS['CORE_THEME']['hitcounter'] != 1 ) ){
	
		// CHECK FOR SLOW QUERY
		$hits = get_post_meta($post->ID,'hits',true);
		if($hits == "" || !is_numeric($hits)){
		
			update_post_meta($post->ID,'hits',1);
		
		}else{		
			 
			$newhits  = $hits+1;
			$sql = " UPDATE " . $wpdb->postmeta . " SET meta_value = '".$newhits."' WHERE meta_key = 'hits' AND post_id = ".$post->ID." ";
			$wpdb->query(  $sql );
		
		}		
		
		// ADD ON DATA ARRAY date('Y-m-d H:i:s
		$data = get_post_meta($post->ID,'hits_array',true);
		if(!is_array($data)){ $data = array(); }
		// GET IP ADDRESS
		$user_ip = $this->get_client_ip(); 
		$country = "";
		$city = "";
		$date_now = date('Y-m-d');
		 
		if(isset($data[$date_now]) && isset($data[$date_now][$user_ip])){
		
			// UPDATE EXISTING ENTRY	
			$data[$date_now][$user_ip] = array("date" => $data[$date_now][$user_ip]['date'],"hits" => $data[$date_now][$user_ip]['hits']+1, "last_visit" => date('Y-m-d H:i:s'), 
			"country" => $data[$date_now][$user_ip]['country'], "city" => $data[$date_now][$user_ip]['city']);
		
		}else{	  
		
			$data[$date_now][$user_ip] = array("date" => date('Y-m-d H:i:s'),"hits" => 1, "country" => "UK", "city" => "London");
		}
		
		update_post_meta($post->ID,'hits_array',$data);
		
	
	}else{
	
		// ADD ON DATA ARRAY date('Y-m-d H:i:s
		$data = get_post_meta($post->ID,'hits_array',true);
		if(!is_array($data)){ $data = array(); }
		// GET IP ADDRESS
		$user_ip = $this->get_client_ip(); 
		$country = "";
		$city = "";
		$date_now = date('Y-m-d');
		 
		if(isset($data[$date_now]) && isset($data[$date_now][$user_ip])){
		
			// UPDATE EXISTING ENTRY	
			$data[$date_now][$user_ip] = array("date" => $data[$date_now][$user_ip]['date'],"hits" => $data[$date_now][$user_ip]['hits']+1, "last_visit" => date('Y-m-d H:i:s'), 
			"country" => $data[$date_now][$user_ip]['country'], "city" => $data[$date_now][$user_ip]['city']);
		
		}else{
	 
	 
			// FIND THE USERS COUNTRY AND DATA
			if( $user_ip != "127.0.0.1" && strlen($user_ip) > 4   ){ // block local host calls	
				
				$countrydata = wp_remote_get( 'http://www.ipaddresslocation.org/ip-address-locator.php?lookup='.$user_ip, array( 'timeout' => 120, 'httpversion' => '1.1' ) );	
				 
				if ( !is_wp_error($countrydata) ) {
					if(strlen($countrydata['body']) > 1){			
						$c1 = explode('<i>IP Country:</i>',$countrydata['body']);
						$c2 = explode("</b>",$c1[1]);				
						$s1 = explode('IP City:',$countrydata['body']);
						$s2 = explode("</b>",$s1[1]);
						$country 	= esc_attr(trim(strip_tags($c2[0])));
						$city 		= esc_attr(trim(strip_tags($s2[0])));	
						//echo $country." -- ".$city;		
					} 
				}// end if
							
			} // end if
		
			$data[$date_now][$user_ip] = array("date" => date('Y-m-d H:i:s'),"hits" => 1, "country" => $country, "city" => $city);
		}
	 
		
		// CHECK KEY EXISTS IN THE DATABASE
		$hits = get_post_meta($post->ID,'hits',true);
		 
		if(!empty($hits)){
		
			 $newhits  = $hits+1;
			 $sql = " UPDATE " . $wpdb->postmeta . " AS t1
			 INNER JOIN " . $wpdb->postmeta . " t2 ON ( t2.meta_key = 'hits' AND t2.post_id = t1.post_id)		
			 INNER JOIN " . $wpdb->postmeta . " t4 ON ( t4.meta_key = 'hits_array' AND t4.post_id = t1.post_id)
			 SET t2.meta_value = '".$newhits."',  t4.meta_value = '".serialize($data)."'	 
			 WHERE t1.post_id = ".$post->ID." ";
			 
			 //	 INNER JOIN " . $wpdb->postmeta . " t3 ON ( t3.meta_key = 'last_visitor' AND t3.post_id = t1.post_id)
		 
			 $wpdb->query(  $sql ); 
			 
			 update_post_meta($post_id,'hits_array',$data);
		
		}else{
			// UPDATE HITS
			update_post_meta($post->ID,'hits', 1);
			// UPDATE LAST VISITED
			//update_post_meta($post->ID,'last_visitor',date('Y-m-d H:i:s'));
			// UPDATE HITS ARRAY
			update_post_meta($post_id,'hits_array',$data);
		}
	
	}
 
	return;
 
	
}

/* =============================================================================
	 CORE ITEM DISPLAY SETTINGS
	========================================================================== */
function STICKER($id){ global $wpdb, $CORE;

if(isset($GLOBALS['fsticker'.$id])){ return; }else{ $GLOBALS['fsticker'.$id] = true; }

//1. check if featured
$featured = get_post_meta($id,'featured',true);
$c_sticker = get_post_meta($id,'listing_sticker',true);

if($featured ==  "yes" && ( $c_sticker == "" || $c_sticker == 0 )){
	return '<span class="featuredsticker"></span>';
}else{	
	if(is_numeric($c_sticker) && $c_sticker > 0){
	return '<span class="sticker sticker'.$c_sticker.'"></span>';
	}
}
return "";

}
function ITEM_CLEANUP($STRING){
	// CLEAN UP EVERYTHING ELSE - cannot due to hook calls
	//$STRING = preg_replace('/###[^>]+\###/i', "", $STRING);
	return $STRING;
}
function ADDONEDITOR($text, $data){

	// 0 = ID
	// 1 = ID
	// 2 = FLAG
	// 3 = TEXT

	// ADD ON VISUAL EDITOR FOR ADMIN
    if( isset($GLOBALS['CORE_THEME']['admin_liveeditor']) && $GLOBALS['CORE_THEME']['admin_liveeditor'] == 1  && current_user_can('administrator') ){ //$_GET['wlt_editor'] == 1 &&
		if(isset($data[2])){ $extra = "_".str_replace("_","xxx",$data[2]); }else{ $extra = ""; } 
		
		if(!isset($GLOBALS['editor_id_counter'])){ $GLOBALS['editor_id_counter'] = 0; }else{  $GLOBALS['editor_id_counter']++; }

 	
		return '<span href="#" id="'.$data[0].'_'.$data[1].$extra.'_'.$GLOBALS['editor_id_counter'].'" data-type="text" data-send="always" data-pk="19912" data-placement="right" data-title="Change Value" data-url="'.get_home_url().'/">'.$text.'<i  class="glyphicon glyphicon-zoom-in wlt_runeditor" alt="'.$data[0].'_'.$data[1].$extra.'_'.$GLOBALS['editor_id_counter'].'" style="cursor: help;"></i></span>';
	
	}else{
		// RETURN DEFAULT
		return $text;
	}

}
// CORE ITEM FUNCTION
function ITEM_CONTENT($post,$custom_string = ""){ global $CORE, $THEME_SHORTCODES, $userdata, $wpdb; $STRING = ""; $data = array(); $permalink = get_permalink($post->ID);
	 
 	if(!isset($post->ID)){ return; } 	 
	
	// ONLY FILTER FOR THIS POST TYPE
	if($post->post_type != THEME_TAXONOMY."_type" && $custom_string == ""){ $custom_string = $GLOBALS['CORE_THEME']['itemcode_fallback']; }	

	// MAKE DEFAULT DISPLAY MATCH
	if(isset($GLOBALS['flag-single'])){ 
	
	$ifd = "listingcode"; 
	
		// SINGLE PAGE LISTING CONTENT ONLY
		if(isset($GLOBALS['flag_single_content'])){
		
			// CHECK USER ACCESS FOR MEMBERSHIP LEVELS			 
			if(!$this->MEMBERSHIPACCESS($post->ID)){
			$custom_string = stripslashes($GLOBALS['CORE_THEME']['noaccesscode']);
			}
		}
	
	
	}else{ $ifd = "itemcode"; }
 
	// PROCESS FOR STRING DATA	
	if($custom_string == "" && ( !isset($GLOBALS['CORE_THEME'][$ifd]) || strlen($GLOBALS['CORE_THEME'][$ifd]) < 2 ) ){
		$STRING = ""; 
	}else{
	
 		
		// GET THE CUSTOM STRING FROM THE END
		if($custom_string !=""){
		$STRING = stripslashes($custom_string);
		}else{
		$STRING = stripslashes($GLOBALS['CORE_THEME'][$ifd]);
		} 
 
		//ADD IN CUSTOM FIELDS
		$custom_fields = get_post_custom($post->ID);
	 
		foreach ( $custom_fields as $key => $value ){			
			if($key == "hits"){
			if($value[0] == "" || !is_numeric($value[0]) ){ $value[0] =0; }
			$data[$key] = number_format($value[0]);
			}else{
			$data[$key] = $value[0];
			}			  
		}// end foreach
	}
	
	 
	// HOOK PRE CHANGES	
	if(!isset($GLOBALS['CORE_THEME']['content_layout']) || (isset($GLOBALS['CORE_THEME']['content_layout']) && substr($GLOBALS['CORE_THEME']['content_layout'], 0, 7) == "listing") ){
	$STRING = hook_item_pre_code($STRING);
	}
	
	// CHECK FOR DEFAULTS
	if(strpos($STRING, "[DEFAULTLISTINGPAGE1]") !== false){
	$STRING = str_replace("[DEFAULTLISTINGPAGE1]",DEFAULTLISTINGPAGE1(), $STRING);
	}
	// CHECK FOR DEFAULTS
	if(strpos($STRING, "[DEFAULTLISTINGPAGE2]") !== false){
	$STRING = str_replace("[DEFAULTLISTINGPAGE2]",DEFAULTLISTINGPAGE2(), $STRING);
	}
	
	// CHECK FOR THEME EXTRAS
	if(strpos($STRING, "[THEMEEXTRA]") !== false){
	
		if(defined('WLT_DOWNLOADTHEME')){
			$STRING = str_replace("[THEMEEXTRA]","[DOWNLOADS]",$STRING);
		}elseif(defined('WLT_COMPARISON')){	
			$STRING = str_replace("[THEMEEXTRA1]","[COMPARISONTABLE]",$STRING);
		}elseif(defined('WLT_CART')){
			$STRING = str_replace("[FIELDS smalllist=1]","",$STRING);
			$STRING = str_replace("[THEMEEXTRA]","<hr />[ADDBIG]",$STRING);
		}
		
		$data['THEMEEXTRA'] = "";
		$data['THEMEEXTRA1'] = "";
	
	} 
 	 
	// GET LIST OF SHORTCODES FROM CLASS FILE
	$RUN_SHORTCODES = $THEME_SHORTCODES->shortcodelist();	 			
 
 	// LOOP LIST
	foreach($RUN_SHORTCODES as $code => $code_data){
	
		// CHECK IF ITS SET IN THE CODE
		if(strpos($STRING, "[".$code."]") !== false && $code_data['type'] == "inner"){	
			 
			switch($code){			
			
			case "FEEDBACK": { 
				if(isset($GLOBALS['CORE_THEME']['feedback_enable']) && $GLOBALS['CORE_THEME']['feedback_enable'] == '1' && $userdata->ID != $post->post_author){ 
			 
					$data['FEEDBACK'] = "<a href='".$GLOBALS['CORE_THEME']['links']['myaccount']."?fdid=".$post->ID."' class='wlt_shortcode_feedback'>".$CORE->_e(array('feedback','1'))."</a>";
				}else{
					$data['FEEDBACK'] = "";
				}			
			} break;
			case "ID": { $data['ID'] = $post->ID; } break;
			case "LINK": { $data['LINK'] = $permalink; } break;
			case "TITLE": { 
			if(isset($GLOBALS['CORE_THEME']['google_tracking']) && $GLOBALS['CORE_THEME']['google_tracking'] == '1'){
				$data['TITLE']	= $this->ADDONEDITOR('<a href="'.$permalink.'" onclick="ga(\'send\', \'event\', \'LISTING\', \'SEARCH\', \''.stripslashes($post->post_title).'\');" '.$this->ITEMSCOPE("itemprop","url").'><span '.$this->ITEMSCOPE("itemprop","name").'>'.$post->post_title.'</span></a>',array('posttitle',$post->ID));
			}else{
				$data['TITLE']	= $this->ADDONEDITOR('<a href="'.$permalink.'" '.$this->ITEMSCOPE("itemprop","url").'><span '.$this->ITEMSCOPE("itemprop","name").'>'.$post->post_title.'</span></a>',array('posttitle',$post->ID));
			}			
			 
			} break;			
			case "TITLE-NOLINK": { 
			$data['TITLE-NOLINK'] = $this->ADDONEDITOR($post->post_title,array('posttitle',$post->ID));
			} break;
			case "DATE": { $data['DATE'] = hook_date($post->post_date); } break;
			case "DATESMALL": { $data['DATESMALL'] = date('M d', strtotime($post->post_date));  } break;
			
			
			case "BUTTON": { $data['BUTTON'] = '<a href="'.$permalink.'" class="btn btn-primary hidden-xs">'.$CORE->_e(array('button','4')).'</a>'; } break;
			case "AUTHOR": { $data['AUTHOR'] = "<span class='wlt_shortcode_author'><a href='".get_author_posts_url( $post->post_author )."'>".get_the_author_meta( 'display_name', $post->post_author)."</a></span>"; } break;
			
			case "MODIFIED": { $data['MODIFIED'] = "<span class='wlt_shortcode_modified'>".hook_date($post->post_modified)."</span>"; } break;
			case "COMMENT_COUNT": { $data['COMMENT_COUNT'] = get_comments_number( $post->ID );	 } break;
			case "COMMENT": {			
				$num = get_comments_number( $post->ID );
				if($num == 0){
				$text = $CORE->_e(array('comment','9'));
				}elseif($num == 1){
				$text = $CORE->_e(array('comment','10'));
				}else{
				$text = $num." ".$CORE->_e(array('comment','11'));
				}
			  $data['COMMENT'] = $text;	
			} break;
			 
			 
			case "FEATUREDSPAN": { $data['FEATUREDSPAN'] 	= $this->FEATURED($post->ID);  } break;
			case "STICKER": {  $data['STICKER'] 	= $this->STICKER($post->ID);  } break;
			case "AUTHORIMAGE-LCIRCLE": {
			$data['AUTHORIMAGE-LCIRCLE'] 	= "<a href='".get_author_posts_url( $post->post_author )."' class='hidden-xs'>".str_replace("avatar ","avatar img-circle ",get_avatar($post->post_author,100))."</a>";
			} break;
			case "AUTHORIMAGE-CIRCLE": {
			$data['AUTHORIMAGE-CIRCLE'] 	= str_replace("avatar ","avatar img-circle ",get_avatar($post->post_author,100));
			} break;
			case "AUTHORIMAGE": {
			$data['AUTHORIMAGE'] 	= get_avatar($post->post_author,100);
			} break;
			case "LAST_REPLY": { 
				$data['LAST_REPLY'] = "";
				$args = array(
					'status' => 'approve',
					'number' => '1',
					'post_id' => $post->ID,  
				);
				$comments = get_comments($args);
				foreach($comments as $comment) :
					 $data['LAST_REPLY'] .= "<span class='wlt_shortcode_lastreply'> ".str_replace("avatar ","avatar img-circle ",get_avatar($post->post_author,45))." <blockquote> &quot;". $comment->comment_content."&quot; - <span class='author'>".$comment->comment_author ."</span> </blockquote> </span>";
				endforeach;			
			} break;
			case "ADDTHIS":
			case "SOCIAL": {
				$data['SOCIAL'] = '<!-- AddThis Button BEGIN -->
				<a class="addthis_button" href="'.get_permalink($post->ID).'">
				<img src="http://s7.addthis.com/static/btn/v2/lg-share-en.gif" width="125" height="16" alt="Bookmark and Share" style="border:0">
				</a>
				<script type="text/javascript">var addthis_config = {"data_track_addressbar":false};</script>
				<script type="text/javascript" src="//s7.addthis.com/js/300/addthis_widget.js#pubid='.$GLOBALS['CORE_THEME']['addthis_name'].'"></script>
				<!-- AddThis Button END -->';
				if(isset($GLOBALS['CORE_THEME']['addthis']) && $GLOBALS['CORE_THEME']['addthis'] == "0"){
				$data['SOCIAL'] = "";
				}
				$data['ADDTHIS'] = $data['SOCIAL'];
			} break;
	 
			case "MODIFIED": { } break;
			 
			case "EDIT": {
			
				$data['EDIT'] 	= ""; 
				if($userdata->ID == $post->post_author ){
					// BUILD EDIT LINK // DELETE LINK
					if(isset($GLOBALS['CORE_THEME']['links']['add']) && substr($GLOBALS['CORE_THEME']['links']['add'],-1) != "/"){ 
						$editlink = $GLOBALS['CORE_THEME']['links']['add']."&eid=".$post->ID;
					}else{
						if(isset($GLOBALS['CORE_THEME']['links']['add'])){
						$editlink = $GLOBALS['CORE_THEME']['links']['add']."?eid=".$post->ID;
						}else{
						$editlink = "";
						}
					}	
					$data['EDIT'] = $editlink;			 
				} // end if
			
			} break;
			
			case "LISTINGSTATUS": { $data['LISTINGSTATUS'] = "";
			
				$listing_status = get_post_meta($post->ID,'listing_status',true);		
				if($listing_status != 0 && $listing_status != ""){		
				if($listing_status == "10"){ $text = get_post_meta($post->ID,'listing_status_msg',true); }else{ $text = $CORE->_e(array('listvalues',$listing_status)); }
					$data['LISTINGSTATUS'] = '<span class="label label-info">'.$text.'</span>';
				}
					
			} break;
			
			 
			case "CATEGORYLIST": {
			
			$data['CATEGORYLIST'] = get_the_term_list( $post->ID, THEME_TAXONOMY, "", '</li><li>', '' );	
	  
			} break;			
			
			
			case "AUTHOR-FLAG": { $data['AUTHOR-FLAG'] = "";
			 
			$mapc =  get_user_meta($post->post_author,'country',true);
			if( $mapc != ""){			
			$data['AUTHOR-FLAG'] = '<div class="flag flag-'.strtolower($mapc).' wlt_locationflag"></div>'; 			
			}
			
			} break;
			
			case "LOCATION-FLAG": { $data['LOCATION-FLAG'] = "";
			 
			$mapc = get_post_meta($post->ID,'map-country',true);
			if( $mapc != ""){			
			$data['LOCATION-FLAG'] = '<div class="flag flag-'.strtolower($mapc).' wlt_locationflag"></div>'; 			
			}
			
			} break;
			case "LOCATION": {
			
			$data['LOCATION'] 	= ""; 
			if(get_post_meta($post->ID,'map_location',true) != ""){
	
				
				if(isset($GLOBALS['flag-home'])){
				$data['LOCATION'] 	= "<span class='wlt_shortcode_location'>".$this->ADDONEDITOR(get_post_meta($post->ID,'map_location',true),array('customfield',$post->ID,'map_location')).'</span>';
				}else{
				
				
				$data['LOCATION'] 	= "<span class='wlt_shortcode_location'>".$this->ADDONEDITOR(get_post_meta($post->ID,'map_location',true),array('customfield',$post->ID,'map_location')).' <i class="fa fa-info-circle wlt_pop_location_'.$post->ID.'" 
				style="cursor:pointer;"  
				rel="popover" 
				data-placement="top"
				data-original-title="'.$CORE->_e(array('gallerypage','20')).'" 
				data-trigger="hover"></i>	
				</span>	
				
				<div id="wlt_pop_location_'.$post->ID.'_content" style="display:none;">	
				<a href="https://www.google.com/maps/dir//'.str_replace(",","",str_replace(" ","+",get_post_meta($post->ID,'map_location',true))).'" target="_blank">'.$CORE->_e(array('gallerypage','18')).'</a> | 	
				<a href="'.get_home_url().'/?s=&amp;zipcode='.str_replace(" ","%20",get_post_meta($post->ID,'map-zip',true)).'&amp;radius=50&amp;showmap=1&amp;orderby=distance&amp;order=desc">'.$CORE->_e(array('gallerypage','19')).'</a> 
				</div>';	
				
				$data['LOCATION'] 	.= "<script>jQuery(document).ready(function(){
				
				jQuery('.wlt_pop_location_".$post->ID."').popover({ 
					html: true,
					trigger: 'manual',
					container: jQuery(this).attr('id'),
					placement: 'top',
					content: function () {
						return jQuery('#wlt_pop_location_".$post->ID."_content').html();
					}
				}).on('mouseover', function(){
				
			   
				}).on('mouseenter', function () {
					var _this = this;
					jQuery(this).popover('show');
					jQuery(this).siblings('.popover').on('mouseleave', function () {
						jQuery(_this).popover('hide');
					});
				}).on('mouseleave', function () {
					var _this = this;
					setTimeout(function () {
						if (!jQuery('.popover:hover').length) {
							jQuery(_this).popover('hide')
						}
					}, 100);
				});});</script>";
				}
				}			
			
			} break;
			
			
			
			} // end switch
		} // end if
	
	}// end
	
		
	if(isset($GLOBALS['flag-single'])){

		// TEST TRANSLATIONS
		$STRING = str_replace("{Description}",$CORE->_e(array('single','34')),$STRING);
		$STRING = str_replace("{Details}",$CORE->_e(array('single','35')),$STRING);
		$STRING = str_replace("{Contact}",$CORE->_e(array('single','36')),$STRING);
		$STRING = str_replace("{Comments}",$CORE->_e(array('single','37')),$STRING);
		$STRING = str_replace("{Related}",$CORE->_e(array('single','0')),$STRING);
		$STRING = str_replace("{Comparisons}",$CORE->_e(array('single','38')),$STRING);
		$STRING = str_replace("{Attachments}",$CORE->_e(array('single','39')),$STRING);
	} 	
	 
	// ADD A DEFAULT VALUE FOR SOME CUSTOM FIELDS
	if(!array_key_exists('bidcount',$data)){  $data = array_merge($data,array('bidcount' => 0));   } 
	if(!array_key_exists('download_count',$data)){  $data = array_merge($data,array('download_count' => 0));   } 
	if(!array_key_exists('hits',$data)){  $data = array_merge($data,array('hits' => 0));   } 
	if(!array_key_exists('price',$data)){  $data = array_merge($data,array('price' => ""));   } 
	if(!array_key_exists('phone',$data)){  $data = array_merge($data,array('phone' => ""));   } 
	 
 
	// LOOP THROUGH EACH CUSTOM FIELD AND DATA KEY TO REPLACE THE DISPLAY STRING
	foreach($data as $key => $value){	
  
		switch(strtolower($key)){
			case "price_bin":
			case "price_current":
			case "old_price":
			case "price": {
			$extra = "";
			
				if( isset($GLOBALS['CORE_THEME']['itemscope']) && $GLOBALS['CORE_THEME']['itemscope'] == '1'){
				$extra = 	'<span itemprop="offers" itemscope itemtype="http://schema.org/Offer">
				<meta itemprop="availability" content="InStock">
				<meta itemprop="itemCondition" content="NewCondition">
				<meta itemprop="priceCurrency" content="'.$GLOBALS['CORE_THEME']['currency']['code'].'">
				<meta itemprop="price" content="'.$value.'"> 
				</span> ';				
				}
				
				$STRING =  str_replace('[' . $key . ']', $this->ADDONEDITOR("<span class=\"wlt_shortcode_" . $key . "\">".hook_price($value).$extra."</span>" ,array('customfield',$post->ID, $key ) ), $STRING);
				
				
				
				
			} break;
			default: {
				if( ( strpos($value, "http") !== false && $key != "AUTHORIMAGE-CIRCLE" ) ||  $key == "FEATUREDSPAN" || $key == "CONTENT" || $key == "IMAGE" || $key == "IMAGES" || $key == "link" || $key == "url" ||  $key == "RELATED" || $key == "COMMENTS" || $key == "EXCERPT" || $key == "IMAGE-NOLINK" || $key == "CATEGORY" || $key == "BUTTON" || $key == "VIDEO" || $key == "STICKER" || $key == "LOCATION" || $key == "price_current"){
				
				$STRING = str_replace('[' . $key . ']', "".$value."", $STRING);
				
				}else{
				
				$itemprop = "";
				if($key == "TITLE"){ $itemprop = $this->ITEMSCOPE("itemprop","name"); }
				if($key == "sku"){ $itemprop = $this->ITEMSCOPE("itemprop","sku"); }
				
					 
					if(strlen($value) == 0){
						$STRING = str_replace('[' . $key . ']', "", $STRING);
					}else{
						$STRING = str_replace('[' . $key . ']', $this->ADDONEDITOR("<span class='wlt_shortcode_" . $key . "' ".$itemprop.">".$value."</span>",array('customfield',$post->ID, str_replace("xxx","",$key) )), $STRING);
					}
				}				
			}
		}
	}	 
	
	// NOW WE NEED TO CLEANUP ANY LEFT OVERS
	$complete_list_of_custom_fields = $this->CUSTOMFIELDLIST('array');
	foreach($complete_list_of_custom_fields as $cleanme){
	$STRING = str_replace('[' . $cleanme . ']', "", $STRING);
	}
 
 	// RETURN DATA 
	return hook_item_pre_code_out(do_shortcode($STRING));

}

/* =============================================================================
 MY FAVS
========================================================================== */
function MYFAVLIST($userid){ global $CORE, $userdata, $wpdb; $STRING = ""; $i=1; 

$extn = "_list";
if(defined('WP_ALLOW_MULTISITE')){
	$extn .= get_current_blog_id();
}						 
$my_list = get_user_meta($userid, 'favorite'.$extn,true);	
if(!is_array($my_list)){ $my_list = array(); }
return $my_list;
					
					
}
/* =============================================================================
 ORDER CLASS
========================================================================== */
function MYORDERS(){ global $CORE, $userdata, $wpdb; $STRING = ""; $i=1; 

$SQL = "SELECT * FROM `".$wpdb->prefix."core_orders` WHERE user_id = ('".$userdata->ID."') "; 
 
$orders = (array)$wpdb->get_results($SQL);
if(!empty($orders)){
	foreach($orders as $order){
 	
	/*
	
			 
			 stdClass Object
	(
		[autoid] => 1
		[user_id] => 1
		[order_id] => 1235671359186214
		[order_ip] => ::1
		[order_date] => 2013-01-26
		[order_time] => 07:43:36
		[order_data] => Example Listing 6
		[order_items] => 354
		[order_email] => test@test.com
		[order_shipping] => 
		[order_tax] => 
		[order_total] => 340
		[order_status] => 3
		[user_login_name] => admin
		[shipping_label] =>   
	*/
	
	$STRING .= "  <tr>
					  <td>".$i."</td>
					  <td><a href='".get_template_directory_uri()."/_invoice.php?invoiceid=".$order->autoid."' target='_blank' style='text-decoration:underline;'>#0000".$order->autoid."</a>
				 	  </td>
					  <td>".hook_date($order->order_date)." @ ".$order->order_time."</td>
					  <td><span class='label label-success'>".hook_order_status($this->ORDER_STATUS($order->order_status))."</span></td>
					  <td>".hook_price($order->order_total)."</td>
					  <td></td>
					</tr>"; 
	if(defined('WLT_CART')){
		$obits = explode("-",$order->order_id); $DOWNLOACODE = "";
		// CHECK IF THE ORDER INCLUDES ANY DOWNLOADS
		$SQL = "SELECT session_data	FROM ".$wpdb->prefix."core_sessions WHERE session_key = ('".strip_tags($obits[1])."') LIMIT 1";
		$hassession = $wpdb->get_results($SQL, OBJECT);
		 
		if(!empty($hassession)){
				// RESTORE THE CART DATA
				$cart_data = unserialize($hassession[0]->session_data);				
				// NOW WE LOOP ALL ITEMS AND REMOVE THE QTY IF REQUIRED
					if(isset($cart_data['items']) && is_array($cart_data['items'])){
						foreach($cart_data['items'] as $key=>$item){
							foreach($item as $mainitem){
								// UPDATE STOCK COUNT
								 								
								if(get_post_meta($key,'type',true) == "1"){
								
								$DOWNLOACODE .= '<form method="post" action="'.$GLOBALS['CORE_THEME']['links']['myaccount'].'" style="margin:0px;">
								<input type="hidden" name="pid" value="'.$key.'" />
								<input type="hidden" name="free" value="1" />
								<input type="hidden" name="purchased" value="1" />
								<input type="hidden" name="downloadproduct" value="1" />';
								$DOWNLOACODE .= "<button type='submit' class='btn btn-primary' onclick=\"".$CORE_btn_add.";\">".$CORE->_e(array('checkout','18'))." (".$mainitem['name'].")</button>";
								$DOWNLOACODE .= '</form>'; 
								 
								}
							
							}// end foreach
						}// end foreach
					}// end if
			}// end if
	
		if(strlen($DOWNLOACODE) > 1){				
		$STRING .= "<tr><td colspan=6>".$DOWNLOACODE."</td></tr>";
		}
	}
	 
	$i++;
	} // end foreach
	
	return $STRING;
} // end if
return hook_account_orders_table($STRING);

}

function ORDER_STATUS($id){ global $CORE;
 
if(is_numeric($id)){
	switch($id){
	case "1": { $id = $CORE->_e(array('order_status','1')); } break;
	case "2": { $id = $CORE->_e(array('order_status','2')); } break;
	case "3": { $id = $CORE->_e(array('order_status','3')); } break;
	case "4": { $id = $CORE->_e(array('order_status','4')); } break;
	case "5": { $id = $CORE->_e(array('order_status','5')); } break;
	}
}
return hook_order_status($id);

}

function ORDER($action='add', $order_data){

global $userdata, $wpdb;

	switch($action){
	
		case "add": {
	
		// END ORDER DATA
		$oData 					= array();
		$oData["userID"] 		= $order_data['userid'];//$userdata->ID;
		$oData["username"] 		= $order_data['username'];//$userdata->user_login;	
		$oData["IP"] 			= $_SERVER['REMOTE_ADDR'];
		$oData["date"] 			= date("Y-m-d");		
		$oData["time"] 			= date("H:i:s");
		
		$oData["orderID"] 		= $order_data['orderid'];	
		$oData["data"] 			= $order_data['description'];
		$oData["items"] 		= $order_data['items'];
		
		$oData["shipping"] 		= $order_data['shipping'];
		$oData["tax"] 			= $order_data['tax'];
		$oData["total"] 		= $order_data['total'];
		$oData["status"] 		= $order_data['status'];
		
		$oData["email"] 		= $order_data['email'];	
		$oData["shipping_label"]= $order_data['shipping_label'];
		$oData["paydata"] 		= $order_data['paydata'];
	
		// CLEAN THE ORDER DATA
		foreach($oData as $key=>$val){			 
		$oData[$key] =  esc_sql($val);				 
		}// end foreach
		
		// CHECK IF THIS ORDER ID ALREADY EXISTS
		
		$ores = $wpdb->get_results("SELECT count(*) as total, autoid FROM ".$wpdb->prefix."core_orders WHERE order_id = ('".$oData["orderID"]."')");

		if($ores[0]->total == 0){	 
		
			// END SQL	
			$SQL ="INSERT INTO `".$wpdb->prefix."core_orders` (`user_id`, `order_id`, `order_ip`, `order_date`, `order_time`, `order_data`, `order_items`, `order_email`, order_shipping, order_tax, `order_total`, `order_status`, `user_login_name`, shipping_label, payment_data) VALUES ('".$oData["userID"]."', '".$oData["orderID"]."', '".$oData["IP"]."', '".$oData["date"]."', '".$oData["time"]."', '".$oData["data"]."', '".$oData["items"]."', '".$oData["email"]."', '".$oData["shipping"]."', '".$oData["tax"]."', '".$oData["total"]."', '".$oData["status"]."', '".$oData["username"]."', '".$oData["shipping_label"]."', '".$oData["paydata"]."')";
		 
			// SAVE DATA
			$wpdb->query($SQL); 
			
			// GET THE AUTOID FOR ORDER ID
			$GLOBALS['new_orderid'] = $wpdb->insert_id;
		
		}else{
		
		$GLOBALS['new_orderid'] = $ores[0]->autoid;
		}
	 
		} break ; // end add
		
	} // end switch

}

function ORDEREXISTS($orderID){ global $wpdb;

	$ores = $wpdb->get_results("SELECT count(*) as total FROM ".$wpdb->prefix."core_orders WHERE order_id = ('".strip_tags($orderID)."')");
	if($ores[0]->total == 0){	
		return false;
	}else{
		return true;
	}	
}

function ORDERTOTAL($userid){ global $wpdb;

	$ores = $wpdb->get_results("SELECT count(*) as total FROM ".$wpdb->prefix."core_orders WHERE user_id = ('".strip_tags($userid)."')");
 
	if($ores[0]->total == 0){	
		return 0;
	}else{
		return $ores[0]->total;
	}	
}
 
function FEEDBACKEXISTS($postid, $userid){ global $wpdb;

	if(!is_numeric($postid)){ return false; }

	// CHECK IF WE HAVE ALREADY LEFR FEEDBACK FOR THIS USER + ITEM
	$SQL = "SELECT ".$wpdb->postmeta.".post_id, ".$wpdb->posts.".post_author, ".$wpdb->postmeta.".meta_value FROM ".$wpdb->postmeta." 
				INNER JOIN ".$wpdb->posts." ON ( ".$wpdb->postmeta.".post_id = ".$wpdb->posts.".ID  AND ".$wpdb->posts.".post_author='".$userid."' )
				WHERE ".$wpdb->postmeta.".meta_key = 'pid' AND ".$wpdb->postmeta.".meta_value= ('".$postid."') AND ".$wpdb->posts.".post_type = 'wlt_feedback' LIMIT 0,100";
 
	$result = $wpdb->get_results($SQL);
	 
	if(empty($result)){
		return false;
	}else{
		return true;
	}
		 
}

function FEEDBACKSCORE($pid, $hasPaid = false){ global $wpdb; $score = 0; $votes = 0;

	if(!is_numeric($pid)){ return false; }
	
	// GET USER FEEDBACK
	//$feedback = new WP_Query('no_found_rows=1&posts_per_page=200&post_type=wlt_feedback&meta_key=pid&meta_value='.$pid);
	 
$SQL = "SELECT ".$wpdb->prefix."posts.ID
FROM ".$wpdb->prefix."posts
INNER JOIN ".$wpdb->prefix."postmeta AS at ON ( ".$wpdb->prefix."posts.ID = at.post_id ) 
WHERE 1 =1
AND (
at.meta_key =  'pid' AND at.meta_value =  '".$pid."'
)
AND ".$wpdb->prefix."posts.post_type =  'wlt_feedback'
AND (
".$wpdb->prefix."posts.post_status =  'publish'
) LIMIT 200";
		 
	$feedback = $wpdb->get_results($SQL); 
	 
	if(!empty($feedback->posts)){
			
		foreach($feedback->posts as $ff){
		
			// GET SCORE
			$score1 = get_post_meta($ff->ID,'score',true);
			if($score1 != ""){ $score += $score1; }
			
			// ADD VOTE
			$votes++;
		
		}
		
		// DO THE MATHS
		$total_score = $score / 5 * 100;
		$score = $total_score;
	}
	
	// RESET
	wp_reset_postdata(); 					
	
	// RETURN DATA
	return array("score" => $score, "votes" => $votes); 
		 
}

function curPageURL() {
$isHTTPS = (isset($_SERVER["HTTPS"]) && $_SERVER["HTTPS"] == "on");
$port = (isset($_SERVER["SERVER_PORT"]) && ((!$isHTTPS && $_SERVER["SERVER_PORT"] != "80") || ($isHTTPS && $_SERVER["SERVER_PORT"] != "443")));
$port = ($port) ? ':'.$_SERVER["SERVER_PORT"] : '';
$url = ($isHTTPS ? 'https://' : 'http://').$_SERVER["SERVER_NAME"].$port.$_SERVER["REQUEST_URI"];
return $url;
}

/* =============================================================================
  FILE UPLOAD TOOL
 ========================================================================== */
 

 
function reArrayFiles(&$file_post) {

    $file_ary = array();
    $file_count = count($file_post['name']);
    $file_keys = array_keys($file_post);

    for ($i=0; $i<$file_count; $i++) {
        foreach ($file_keys as $key) {
            $file_ary[$i][$key] = $file_post[$key][$i];
        }
    }

    return $file_ary;
}
function SINGLE_IMAGES($postID, $tabbed=false, $return=false, $type="allbutmusic"){ global $wpdb, $post; $STRING = ""; 
 

 	// NO MEDIA FOUND SO LETS TRY OUR CUSTOM UPLOAD TOOL
	$user_attachments = $this->UPLOAD_GET($postID,0,array('type' => $type)); 
   
		// CHECK FOR OLD SYSTEM IMAGES		
		$old_imgs_system = get_post_meta($postID,'images',true);
		if($old_imgs_system != ""){
			if(!is_array($user_attachments)){ $user_attachments = array(); }
			$imgs = explode(",",$old_imgs_system);
			foreach($imgs as $old_img){					
				$old_img = trim($old_img);
				$imgPath = $old_img;				
				if(strlen($imgPath) < 2){ continue; }	
		 
				$user_attachments[] = array("src" => $imgPath, "thumbnail" => $imgPath);					
			} 
			
			$showFallback = false;		
		}
 
 
// CHECK FOR IMAGES WITHIN THE LISTING CONTENT
// SO THE USER CAN STILL UPLOAD AS NORMAL VIA THE ADMIN INTERFACE 
$wordpress_default_gallery_ids = array();
if (strpos($post->post_content,"gallery ids") != false || strpos($post->post_content,"gallery column") != false || strpos($post->post_content,"gallery link") != false){
 
		// GET THE ATTACHMENT IDS TO BUILD THE NEW GALLERY
		preg_match('/\[gallery.*ids=.(.*).\]/', $post->post_content, $ids);
		$wordpress_default_gallery_ids = explode(",", $ids[1]);
		
		// GET THE CURRENT WP UPLOAD DIR
		$uploads = wp_upload_dir(); $user_attachments = array(); $i=0;
		foreach($wordpress_default_gallery_ids as $img_id){
			if(is_numeric($img_id)){
			
				$f = wp_get_attachment_metadata($img_id);	 	
				if(isset($f['file'])){	
		  
				$user_attachments[$i]['src'] 		= $uploads['baseurl']."/".$f['file'];			
				$user_attachments[$i]['thumbnail'] 	= $user_attachments[$i]['src']; //$uploads['url']."/".$f['sizes']['thumbnail']['file'];
				$user_attachments[$i]['name'] 		= $f['image_meta']['title'];
				$user_attachments[$i]['id'] 		= $img_id;
				}
				//die(print_r($user_attachments).print_r($uploads));
				$i++;
			}
		}
 
} 
 

// RETURN IF SET
if($return){ return $user_attachments; }
 
 
// DISPLAY THE USER GALLERY BLOCK
if(is_array($user_attachments) && count($user_attachments) > 0 && $user_attachments[0]['src'] != "" && $user_attachments[1]['src'] != "" ){ 
	
	// GALLERY
	if(!isset($WPGallery)){
	$user_attachments = $this->multisort( $user_attachments , array('order') );
	} 
	
	 // TOP SLIDER BOX  
	if(count($user_attachments) > 1 && isset($user_attachments[1]['thumbnail'])){
		$STRING .= ' <div id="slider" class="flexslider" style="margin: 0 0 10px;"><ul class="slides">';	  
		foreach($user_attachments as $img){ 
		   
				// NOW WE NEED TO BUILD THE CONTENT DISPLAY FOR THIS MEDIA TYPE			
				if(in_array($img['type'],$this->allowed_image_types)){
					$STRING .= '<li style="min-height:200px;"><a href="'.$img['src'].'" data-gal="prettyPhoto[ppt_gal]"><img src="'.$img['src'].'" alt="'.get_the_title($img['id']).'" class="'. $img['id'].'"  /></a></li>';		
				}elseif(in_array($img['type'],$this->allowed_video_types) && $type != "images"){
					$STRING .= '<li style="min-height:200px;">'.$this->UPLOAD_GET($postID, $format=2, $options = array("type" => "video"), $img['id'] ).'</li>';
				}elseif(in_array($img['type'],$this->allowed_music_types) && $type != "images" && $type != "allbutmusic"){
					$STRING .= '<li style="min-height:200px;">'.$this->UPLOAD_GET($postID, $format=2, $options = array("type" => "music"), $img['id'] ).'</li>';				
				}elseif(in_array($img['type'],$this->allowed_doc_types) && $type != "images" ){
					$STRING .='<li style="min-height:200px;">'. $this->UPLOAD_GET($postID, $format=2, $options = array("type" => "doc"), $img['id'] ).'</li>';
				}else{
					// FIX FOR YOUTUBE LINKS
					if(strpos($img['src'],"watch?v=") !== false && $type != "images" ){
					$STRING .= $this->UPLOAD_GET($postID, $format=2, $options = array("type" => "video"), $img['id'] );
					}else{
					if(strlen($img['src']) < 5){ continue; }
					$STRING .= '<li style="min-height:200px;"><a href="'.$img['src'].'" data-gal="prettyPhoto[ppt_gal]"><img src="'.$img['src'].'" alt="'.get_the_title($img['id']).'" class="'. $img['id'].'" /></a></li>';	
					}
				}
		  
		}	               
		$STRING .='</ul></div>';
		 
	}elseif(isset($user_attachments[0]['thumbnail'])){
		$showPrettyPhoto = true;
		$STRING .= '<a href="'.$user_attachments[0]['src'].'" data-gal="prettyPhoto[ppt_gal]"><img src="'.$user_attachments[0]['src'].'" alt="'.$user_attachments[0]['name'].'" /></a>';
 
	}
 
 
	 // BOTTOM CAROUSEL BOX
	 
	if(count($user_attachments) > 1 && isset($user_attachments[1]['thumbnail'])){ 
	 
		$STRING .= '<div id="carousel" class="flexslider hidden-xs" style="margin: 0 0 0px; margin-bottom:20px"><ul class="slides">';	  
		foreach($user_attachments as $img){
	  	if(strlen($img['thumbnail']) > 1){
			if(strlen($img['thumbnail']) < 5){ continue; }
			$img['thumbnail'] = str_replace(" ", "-", $img['thumbnail']);
        	$STRING .='<li><img src="'.$img['thumbnail'].'" alt="'. $img['name'].'" class="'. $img['id'].'" /></li>';
     	} // end if
	  }// end foreach
	  $STRING .= '</ul></div>';
	} // end if
	        
	$STRING .= '<!-- end main slider -->';

if(count($user_attachments) > 1 && isset($user_attachments[1]['thumbnail'])){	  
if(!$tabbed){
$STRING .="<script>
   
jQuery(window).load(function(){
      jQuery('#carousel').flexslider({
        animation: 'slide',
        controlNav: false,
        animationLoop: true,
        slideshow: true,
        itemWidth: 158,
        itemMargin: 20,
 
         asNavFor: '#slider'
      });
      
      jQuery('#slider').flexslider({
        animation: 'slide',
        controlNav: false,
        animationLoop: false,
        slideshow: false,
		lightbox: true,
        sync: '#carousel',
        start: function(slider){
          jQuery('body').removeClass('loading');
        } 
		 
      });	
	  
	jQuery(\".slides li:not(.clone) a[data-gal^='prettyPhoto']\").prettyPhoto({
	animation_speed: 'normal',
	autoplay_slideshow: true,
	slideshow: 3000, deeplinking: false,
	});
	
});


</script>";

}else{
 
$STRING .= "<script type='application/javascript'>
   
function tabexecuteslider(){
jQuery('#carousel').flexslider({
        animation: 'slide',
        controlNav: false,
        animationLoop: true,
        slideshow: true,
        itemWidth: 115,
        itemMargin: 20,
        asNavFor: '#slider',
      });
      
      jQuery('#slider').flexslider({
        animation: 'slide',
        controlNav: false,
        animationLoop: false,
        slideshow: false,
        sync: '#carousel',
        start: function(slider){
          jQuery('body').removeClass('loading');
        }
      });	
}
</script>";
}
}	  
 
	  
}else{ // END IF	
	
	
	/***
	
	OK THIS IS WHERE WE FALLBACK TO THE DEFAULT CONTENT
	ONLY HERE IF NO IMAGE GALLERY OR MULTIPLE IMAGE CONTENT WAS DETECTED
	
	***/
	
	// CHECK FOR A SINGLE IMAGE DISPLAY
	$image = hook_image_display(get_the_post_thumbnail($postID, 'full', array('class'=> "wlt_thumbnail img-responsive")));
 
	$showSingleImage = true;
	// CHECK FOR FALLBACK IMAGE
	if($image == ""){
		$showSingleImage = false;
		 
		// NOW LETS SEE IF THE USER UPLOADED SOMETHING ELSE INSTEAD 
		$get_type = array("video_array", "music_array");
		$showFallback = true;
		foreach($get_type as $type){
			$g = get_post_meta($postID,$type, true); 
			if(is_array($g) && !empty($g) ){
				$image .= $this->UPLOAD_GET($postID,2, array("type" => str_replace("_array","",$type), "limit" => 1 ));				
			}
		}
		if(strlen($image) > 0){
			$showFallback = false;
		}
		 
		// FINAL CHECK IF THEY HAVE ADDED AN IMAGE USING THE MEDIA SYSTEM INSTEAD
		if($showFallback){
			$g = get_post_meta($postID, "image_array", true);
			if(is_array($g) && !empty($g) ){
				$image .= '<a  href="'.$g[0]['src'].'" class="frame" data-gal="prettyPhoto">';
				$image .= '<img class="wlt_thumbnail img-responisve" src="'.$g[0]['src'].'" alt="&nbsp;" />'; 
				$image .= '</a>';
				$showFallback = false;
			
			}	 
		}
		// FALLBACK TO FALLBACK IMAGE IF NOTHING WAS FOUND
		if($showFallback){		 
			//if(isset($GLOBALS['CORE_THEME']['listing']['fallback']) && $GLOBALS['CORE_THEME']['listing']['fallback'] == '1'){	
			
				$fimage = $this->FALLBACK_IMAGE($postID);
				 
				if($fimage !=""){ //&& !isset($GLOBALS['flag-single'])
					$image .= '<a  href="'.get_permalink($postID).'" class="frame">';
					$image .= $fimage; 
					$image .= '</a>';
				}
			
			//}else{
			//$image = "";
			//}
		}
		
	}else{
	$fimage = $this->get_the_post_thumbnail_src($image);
	}
	
	// ITEMSCOPE
	$image = str_replace("<img ","<img ".$this->ITEMSCOPE("itemprop","image")." ",$image);
	 
	// CHECK IF WE ARE SHOWING AN IMAGE OR MEDIA CONTENT 
	$STRING .= "<div id='SINGLEIMAGEDISPLAY'>";
	if($showFallback){
		if(strpos($fimage, "wlt_thumbnail") !== false) {
			$STRING .= strip_tags($image, '<img>');
		}else{
			$STRING .= "<a href='".$fimage."' data-gal='prettyPhoto'>".$image." <div id='mousetrap'></div></a>";
				
			$STRING .='<script type="text/javascript" charset="utf-8"> jQuery(document).ready(function(){ jQuery("a[data-gal^=\'prettyPhoto\']").prettyPhoto({deeplinking: false});});</script>';
		}		
	}else{
	 	if($showSingleImage){
			$STRING .= "<a href='".$fimage."' data-gal='prettyPhoto'>".$image." <div id='mousetrap'></div> </a>";			
			$STRING .='<script type="text/javascript" charset="utf-8"> jQuery(document).ready(function(){ jQuery("a[data-gal^=\'prettyPhoto\']").prettyPhoto({deeplinking: false});});</script>';		
		}else{
			$STRING .= $image;	
		}
	}
	
	$STRING .= "</div>";

} // END IF	

// ADD-ON EXTRA FOR MUSIC FILES
if($type == "music" || $type == ""){
$STRING .= do_shortcode('[FILES type=music]');
}

 return $STRING;

}
function get_the_post_thumbnail_src($img)
{
  return (preg_match('~\bsrc="([^"]++)"~', $img, $matches)) ? $matches[1] : '';
}

function UPLOAD_GET($postID, $format=0, $options = array(), $id=0 ){ global $CORE;
 
$STRING = ""; $get_type = array(); if(!isset($GLOBALS['media_id'])){ $GLOBALS['media_id'] =0; }else{ $GLOBALS['media_id']++; } 

 
// GET POSSIBLE OPTIONS
if(isset($options['type']) && strlen($options['type']) > 1){ $type = $options['type'];}else{ $type = "all"; }
if(isset($options['limit']) && is_numeric($options['limit']) ){ $limit = $options['limit'];}else{ $limit = 100; }

// VIDEO
if(isset($options[0]) && $options[0] == "video"){ $limit = 1; $type = "video"; }

 
// GET THE FILE TYPE STORAGE KEY
if($type == "image" || $type == "images"){
	$get_type = array("image_array");			
}elseif($type == "video"){
	$get_type = array("video_array");
}elseif($type == "music"){
	$get_type = array("music_array");					
}elseif($type == "doc"){
	$get_type = array("doc_array");		
}elseif($type == "allbutmusic"){
	$get_type = array("image_array", "video_array", "doc_array");		
}elseif($type == "all"){
	$get_type = array("image_array", "video_array", "doc_array", "music_array");				
}else{
	return; //$get_type = array("image_array", "video_array", "doc_array", "music_array");
}


 
// ADD TO MY IMAGE GALLERY ARRAY
$my_existing_images = array();
foreach($get_type as $type){
	$g = get_post_meta($postID,$type, true); 
	if(is_array($g)){	
	$my_existing_images = array_merge($my_existing_images, $g);
	}
}
 
if(!is_array($my_existing_images)){ return; }
 
// CHECK IF ITS EMPTY
if(empty($my_existing_images)){
	// CHECK TO SEE IF THE CONTENT CONTAINS A VIDEO LINK AND USE THIS AS THE VIDEO
	preg_match_all('!http://[a-z0-9\-\.\/]+\.(?:jpe?g|flv)!Ui', get_the_content($postID), $matches);
	if(is_array($matches)){
		foreach($matches as $mm){	
			if(!isset($mm[0]) || ( isset($mm[0]) && $mm[0] == "") ){ continue; }
			
			$my_existing_images = array( array("src" => $mm[0], "thumbnail" => str_replace(" ", "-",$mm[0]))); 	 
		}
	} 	
}
 
// ONLY SHOW THE DEFAULT ONE
if($id == "default"){ foreach($my_existing_images as $gg){ if(isset($gg['default']) && $gg['default'] == 1){ $id = $gg['id']; } } }

 
switch($format){

	// BUILD DISPLAY FOR ADD/EDIT LISTING PAGE
	case "1": {
	
	$counter=1;
	 
	// GET THE POST THUMBNAIL
	$GG = get_post_thumbnail_id($postID);
	
	$canContinue = true; 
	foreach($my_existing_images as $img){
		if($img['id'] == $GG){
		 $canContinue = false;
		} 
	}
 
	// CHECK FOR DISPLAY IMAGE FIRST 
	if ( has_post_thumbnail($postID) && $canContinue ) {			
	
		$large_image_url =  wp_get_attachment_image_src( $GG, 'full');
		
		$showme = '<a href="'.$large_image_url[0].'" rel="gallery"><img src="'.$large_image_url[0].'" class="img-responsive"></a>';
		
		$STRING .= '
				<tr id="imgshow'.$counter.'" class="displayimagebox"><td class="preview">
				   '.$showme.' 
				</td>
				<td class="name" style="overflow:hidden;">
					'.the_title_attribute('echo=0').'  </small>
				</td>
				 
				<td colspan="2"></td>
			
			
			<td> 
			
			</td>
			<td class="delete"> 
			
			 <button class="btn btn-danger" data-type="DELETE" data-url="'.$postID.'---'.$GG.'"  onclick="jQuery(\'.displayimagebox\').hide();">
				<i class="glyphicon glyphicon-trash icon-white"></i>                
			 </button>
				 
			</td>
		</tr>';	
		
		   
	
	$counter++;
	}
	
 
	foreach($this->multisort( $my_existing_images , array('order') ) as $img){
 
		if(strlen($img['src']) > 1){
 
		// WORK OUT DISPLAY TYPE
		if(in_array($img['type'], $this->allowed_video_types)){		
		$showme = $this->UPLOAD_GET($postID,2,array("type" => "video"),$img['id']);	
		}elseif(in_array($img['type'], $this->allowed_music_types)){		
		$showme = '<div class="txtonly"><a href="'.$img['src'].'" target="_blank">'.$img['name']."</a></div>";		
		}elseif(in_array($img['type'], $this->allowed_doc_types)){
		$showme = '<div class="txtonly"><a href="'.$img['src'].'" target="_blank">'.$img['name']."</a></div>";							
		}else{
			
			if(isset($img['thumbnail']) && $img['thumbnail'] != ""){
			$showme = '<img src="'.str_replace(" ", "-",$img['thumbnail']).'" class="img-responsive">';
			}else{
			$showme = '<img src="'.str_replace(" ", "-",$img['src']).'" class="img-responsive">';
			}
		}
		
		if($GG == $img['id']){ $ess = "featureditem"; }else{  $ess = "";  }
		
		ob_start();
	  	?>
 
<div class="col-md-4 item ftype_<?php echo substr($img['type'],0,5); ?> imgshow<?php echo $counter; ?>">
            
<div class="itmbox <?php echo $ess ; ?>" >
                  
<?php echo $showme; ?>

    <div class="bits delete">
    	
        <div class="btn btn-success wlt_tooltip" 		
        data-placement="top"
        data-original-title="<?php echo $CORE->_e(array('button','2','flag_noedit')); ?>" 
        data-trigger="hover"
        onclick="WLTEDITMEDIA('<?php echo str_replace("https://","",str_replace("http://","",get_home_url())); ?>', '<?php echo $postID.'---'.$img['id']; ?>', 'editmediaboxcontent' );">
        <i class="glyphicon glyphicon-pencil icon-white"></i>
        </div> 
        
        <?php if($GG != $img['id']){ ?>
        <button class="btn btn-warning wlt_tooltip"
        data-placement="top"
        data-original-title="<?php echo $CORE->_e(array('add','68','flag_noedit')); ?>" 
        data-trigger="hover"
        onclick="WLTSetFeatured('<?php echo str_replace("https://","",str_replace("http://","",get_home_url())); ?>', '<?php echo $img['postID']; ?>', '<?php echo $img['id']; ?>', 'core_ajax_callback');
        jQuery('.itmbox').removeClass('featureditem');jQuery('.imgshow<?php echo $counter; ?> .itmbox').addClass('featureditem');" >		
        <i class="glyphicon glyphicon-star icon-white"></i>
        </button>
        <?php } ?>
    	
        <button class="btn btn-danger wlt_tooltip" 		
        data-placement="top"
        data-original-title="<?php echo $CORE->_e(array('button','3','flag_noedit')); ?>" 
        data-trigger="hover"
        data-type="DELETE" data-url="<?php echo $postID.'---'.$img['id']; ?>" onClick="jQuery('.imgshow<?php echo $counter; ?>').hide();">
        <i class="glyphicon glyphicon-remove icon-white"></i>
        </button> 
    
    </div>
</div>     
        
</div>
     
      	<?php 
		$STRING .= ob_get_clean();	
		$counter++;
		
		}	
		
	}	
	
	} break;
	// VIDEO
	case "2": { 
	  	
		$displaycount = 0;  if(!isset($GLOBALS['vboxID'])){ $GLOBALS['vboxID'] = 1; }else{  $GLOBALS['vboxID']++; }
		
		// AJAX VIDEO DISPLAY
		$ajax_query = "onclick=\"WLTAjaxVideobox('".
			  str_replace("https://","",str_replace("http://","",get_home_url()))."','".$postID."', '[field]', '[type]', 'wlt_videobox_ajax_".$GLOBALS['vboxID'].$postID."');\"";
		
		// IF EMPTY, CHECK FOR YOUTUBE LINK
		if(empty($my_existing_images)){
		
			// CHECK IF YOUTUBE LINK IS PRESENT
			$youtubelink = get_post_meta($postID,'Youtube_link',true);
			
			if($youtubelink != ""){
						
			$l = str_replace("[field]", "Youtube_link", str_replace("[type]", "",  $ajax_query));
						
			$STRING .= "<div id='wlt_videobox_ajax_".$GLOBALS['vboxID'].$postID."' class='videobox'><a href='javascript:void(0);' ".$l." class='frame'><img src='".get_post_meta($postID,'image',true)."' alt='video' style='width: 100%; height: 100%; max-height:450px;'><div class='overlay-video overlay-video-active fa fa-play'></div></a></div>";
		 	
			}// end if	
				
		}// end if
		
		
 		foreach($my_existing_images as $video){
		
		if(!isset($GLOBALS['vboxID'])){ $GLOBALS['vboxID'] = 1; }else{  $GLOBALS['vboxID']++; }
		
		// AJAX VIDEO DISPLAY
		$ajax_query = "onclick=\"WLTAjaxVideobox('".
			  str_replace("https://","",str_replace("http://","",get_home_url()))."','".$postID."', '[field]', '[type]', 'wlt_videobox_ajax_".$GLOBALS['vboxID'].$postID."');\"";
		
		
		// REACHED LIMIT ?
		if($displaycount >= $limit){ continue; }
		 
		// CHECK FOR DEAD LINKS 
		if(strlen($video['src']) < 5){ continue; }
	 
		// CHECK IF ITS THE ID WERE LOOKING FOR
		if(!is_array($id) && $id !=0 && $video['id'] != $id && $video['type'] != "youtube" ){ continue; }
		//if($id == "default" && $video['default'] != 1  && $video['type'] != "youtube"  ){ continue; } 	
		
		// youtube video	
		if($video['type'] == "youtube"){ 		 
			 
			$l = str_replace("[field]", "Youtube_link", str_replace("[type]", "",  $ajax_query));
						
			$STRING .= "<div id='wlt_videobox_ajax_".$GLOBALS['vboxID'].$postID."' class='videobox'><a href='javascript:void(0);' ".$l." class='frame'><img src='".get_post_meta($postID,'image',true)."' alt='video' style='width: 100%; height: 100%; max-height:450px;'><div class='overlay-video overlay-video-active fa fa-play'></div></a></div>";
		
		}elseif($video['type'] == "audio/mp3" || $video['type'] == "audio/mpeg"){
		 
			$STRING .= '<audio id="audio_id_'.$GLOBALS['media_id'].'" style="margin:0 auto;" preload="none"><source type="'.$video['type'].'" src="'.$video['src'].'" /></audio>';
  
		}elseif($video['type'] == "application/pdf"){
		
			$STRING .= '<a href="'.$video['src'].'" target="_blank"><img src="'.FRAMREWORK_URI.'img/icons/pdf.png" alt="pdf"></a>';
		
		}elseif($video['type'] == "application/octet-stream"){
		
			$STRING .= '<a href="'.$video['src'].'" target="_blank"><img src="'.FRAMREWORK_URI.'img/icons/compress.png" alt="zip"> </a>';
			
		}elseif($video['type'] == "application/msword"){
		
			$STRING .= '<a href="'.$video['src'].'" target="_blank"><img src="'.FRAMREWORK_URI.'img/icons/doc.png" alt="doc"></a>';			
			
		}else{
			if(isset($GLOBALS['tpl-add'])){
			$STRING .= '<img src="'.$video['thumbnail'].'" alt="video">';	
			}else{	
			
				// CHECK FOR FEATURED IMAGE
				if (strpos($video['thumbnail'], "featured") === false) {
					if ( has_post_thumbnail($post->ID) ) { 
					 $gg = wp_get_attachment_image_src(get_post_thumbnail_id($post->ID), "full");				
					 $video['thumbnail'] = $gg[0];
					}
				}
			
			 
				$l = str_replace("[field]", str_replace("http://","",$video['src']), str_replace("[type]", $video['type'], $ajax_query ));
								
				$STRING .= "<div id='wlt_videobox_ajax_".$GLOBALS['vboxID'].$postID."' class='videobox'>
				<a href='javascript:void(0);' ".$l." class='frame'>
				<img src='".$video['thumbnail']."' alt='video' style='width: 100%; height: 100%; max-height:450px;'><div class='overlay-video overlay-video-active fa fa-play'></div>
				</a>
				</div> <input value='0' class='videotime".$postID."' type='hidden'>";
			 
			 
			}
		}
	
		$GLOBALS['media_id']++; 	$displaycount++;
		
		}// end foreach	 
	 	 
	
	} break;
	
	case "3": {
	 
	$OUTTERSTRING = ""; $STRING = ""; $uploads_dir = wp_upload_dir();
	 
	if(!isset($my_existing_images[0]['src']) || isset($my_existing_images[0]['src']) && $my_existing_images[0]['src'] == ""){ return; }
	
	$OUTTERSTRING .= '<table class="table table-bordered ">
              <thead>
                <tr>
                  <th class="hidden-xs">#</th>                 
                  <th class="hidden-xs">Size</th>
                  <th>Title</th>';
				if(is_admin()){  $OUTTERSTRING .= '<th>Actions</th>'; }
               $OUTTERSTRING .= ' </tr>
              </thead>
			  			  
              <tbody>%%STRING%%';
			  $innercount=1;
			 
			  foreach($my_existing_images as $media){
			  
			  // CHECK FILE EXISTS FIRST IF VIEWING AS THE ADMIN
			  if(is_admin() && !file_exists($uploads_dir['path']."/".$media['name'])){				  
				//continue; // doesnt work for all clients.
			  } 
			  
				if(is_array($this->allowed_music_types) && in_array($media['type'],$this->allowed_music_types)){
						
						$media_display = ''.$media['name'];
						if(!is_admin()){
						$media_display .= '<br /><audio id="audio_id_'.$GLOBALS['media_id'].'_'.$innercount.'" preload="none"><source type="'.$media['type'].'" src="'.$media['src'].'" /></audio>
						<script type="application/javascript">jQuery(\'#audio_id_'.$GLOBALS['media_id'].'_'.$innercount.'\').mediaelementplayer({audioWidth: \'100%\', audioHeight: 30,});</script>';
						}
				}elseif(is_array($this->allowed_video_types) && in_array($media['type'],$this->allowed_video_types)){
								
						$media_display = '
						<div class="videobox'.$post->ID.'">
						<video id="video_id_'.$GLOBALS['media_id'].'_'.$innercount.'" width="100%" height="300" style="width: 100%; height: 100%;" controls="controls" preload="none">
						<source type="'.$media['type'].'" src="'.$media['src'].'" />
						<!-- Flash fallback for non-HTML5 browsers without JavaScript -->
						<object width="100%" height="300" style="width: 100%; height: 100%;" type="application/x-shockwave-flash" data="'.get_template_directory_uri().'/framework/slider/flashmediaelement.swf">
							<param name="movie" value="'.get_template_directory_uri().'/framework/slider/flashmediaelement.swf" />
							<param name="flashvars" value="controls=true&file='.$media['src'].'" />							 
							<img src="'.$media['src'].'"  title="No video playback capabilities" />
						</object>
						</video><input value="0" class="videotime'.$post->ID.'" type="hidden">
						</div>';
						
				}elseif(is_array($this->allowed_doc_types) && in_array($media['type'],$this->allowed_doc_types)){
						
						$media_display = "";				
						if( $media['type'] == "application/octet-stream"){
						$media_display .= '<img src="'.FRAMREWORK_URI.'img/icons/compress_small.png" alt="zip"> ';
						}elseif($media['type'] == "application/pdf"){		
						$media_display .= '<img src="'.FRAMREWORK_URI.'img/icons/pdf_small.png" alt="pdf"> ';
						}elseif($media['type'] == "application/msword"){		
						$media_display .= '<img src="'.FRAMREWORK_URI.'img/icons/doc_small.png" alt="doc"> ';
						}
						
						$media_display .= '<a href="'.$media['src'].'" target="_blank">'.$media['name'].'</a>';	
						
				}elseif(is_array($this->allowed_image_types) && in_array($media['type'],$this->allowed_image_types)){
				
					// FIX FOR GIF THUMBANILS
					if (strpos($media['thumbnail'], $media['name']) === false) {
					$media['thumbnail'] = $media['src'];
					}					
									
					$media_display = '<a href="'.$media['src'].'" data-gal="prettyPhoto[ppt_gal]"><img src="'.$media['thumbnail'].'" alt="'.$media['name'].'" /></a>';			
					 
				}
				
				// HIDE IF NOTTHING TO SHOW
				if($media_display == ""){ continue; }
			   
                   $STRING .= '<tr id="atfile_'. $innercount.'">
                  <td class="hidden-xs">'.$innercount.'</td>
                  <td class="hidden-xs">'.$media['size'].'</td>
                  <td>'.$media_display.'</td>'; 
				  
                 $STRING .= '</tr>';				 
				$innercount++;			
			}
               
            $OUTTERSTRING .= '</tbody></table>';
			
			if(strlen($STRING) > 5){			
			$STRING = str_replace("%%STRING%%",$STRING,$OUTTERSTRING);
			}
	
	} break;
	case "4": {
	
	$STRING = ""; $uploads_dir = wp_upload_dir();
	 
	if(!isset($my_existing_images[0]['src']) || isset($my_existing_images[0]['src']) && $my_existing_images[0]['src'] == ""){ return; }
	
		$STRING .= '<ul>';
		foreach($my_existing_images as $media){
		
			// WORK OUT ICON
			if( $media['type'] == "application/octet-stream"){
				$icon = '<img src="'.FRAMREWORK_URI.'img/ext/file_extension_zip.png" alt="zip">';
			}elseif($media['type'] == "application/pdf"){		
				$icon = '<img src="'.FRAMREWORK_URI.'img/ext/file_extension_pdf.png" alt="pdf">';
			}elseif($media['type'] == "application/msword"){		
				$icon = '<img src="'.FRAMREWORK_URI.'img/ext/file_extension_doc.png" alt="doc">';
			}elseif($media['type'] == "image/png"){		
				$icon = '<img src="'.FRAMREWORK_URI.'img/ext/file_extension_png.png" alt="png">';
			}elseif($media['type'] == "image/jpeg"){		
				$icon = '<img src="'.FRAMREWORK_URI.'img/ext/file_extension_jpg.png" alt="jpg">';
			}elseif($media['type'] == "image/gif"){		
				$icon = '<img src="'.FRAMREWORK_URI.'img/ext/file_extension_gif.png" alt="jpg">';
			}elseif($media['type'] == "video/x-flv"){		
				$icon = '<img src="'.FRAMREWORK_URI.'img/ext/file_extension_flv.png" alt="x-flv">';
			}elseif($media['type'] == "video/mp4"){		
				$icon = '<img src="'.FRAMREWORK_URI.'img/ext/file_extension_mp4.png" alt="mp4">';
			}elseif($media['type'] == "video/webm"){		
				$icon = '<img src="'.FRAMREWORK_URI.'img/ext/file_extension_flv.png" alt="webm">';
			}elseif($media['type'] == "video/ogg"){		
				$icon = '<img src="'.FRAMREWORK_URI.'img/ext/file_extension_ogg.png" alt="ogg">';
			}elseif($media['type'] == "audio/mpeg"){		
				$icon = '<img src="'.FRAMREWORK_URI.'img/ext/file_extension_mpeg.png" alt="ogg">';
			}elseif($media['type'] == "audio/mp3"){		
				$icon = '<img src="'.FRAMREWORK_URI.'img/ext/file_extension_mp3.png" alt="ogg">';
			}else{
				$icon = '<img src="'.FRAMREWORK_URI.'img/ext/file_extension_jpeg.png" alt="doc"> ';
			}

 
        	$STRING .= '<li>
			<span class="filename">'.$icon.' <a href="'.$media['src'].'" rel="nofollow" target="_blank">'.$media['name'].'</a></span>
            <span class="size">'.$media['size'].'</span>
			</li>';		
		}
               
		$STRING .= '</ul>';
	
	} break;	
	
	default: {
  
		return $my_existing_images;
	
	}	

}
 
return $STRING;

}   
/* ========================================================================
 CONVERTS QUERY STRING INTO ARRAY
========================================================================== */
function CUSTOMQUERY($c){
 
	if(is_string($c)){
		$tt = explode("&",$c); $nArray = array();
		foreach($tt as $g){
			$ff = explode("=",$g);
			if(isset($ff[1])){
				$nArray[str_replace("amp;","",$ff[0])] = $ff[1];
			}
		}
		if(is_array($nArray) && !empty($nArray)){
		
		// add in core search hook
		hook_wlt_core_search();
		
		if(isset($nArray['taxonomy']) && isset($nArray['terms'])){
		
			$nArray['tax_query'][] =  array( 'taxonomy' => $nArray['taxonomy'], 'field' => 'term_id', 'terms' => $nArray['terms'], 'operator'=> 'IN'  );
			// CLEAN UP	
			unset($nArray['taxonomy']);
			unset($nArray['terms']);		 
		}
		
		// CHECK IF CUSTOM FILTERS EXIST
		if(isset($GLOBALS['custom']) && is_array($GLOBALS['custom'])){
			$subArray = array(); $keystack = array(); 
			foreach($GLOBALS['custom'] as $j){
				if(isset($j['key']) && !in_array($j['key'],$keystack)){
				$subArray[]	= $j;
				array_push($keystack,$j['key']);
				}
			}
			if(is_array($subArray) && !empty($subArray)){
			$nArray['meta_query'] =	 $subArray;
			}
		}
		
		$c = $nArray;
		}
	}
		 
	return $c;
}




/* ========================================================================
 UPLOAD OPTIONS
========================================================================== */
function UPLOAD_DELETEALL($postid){
 
	// GET EXISTS MEDIA ARRAYS
	$get_type = array("image_array", "video_array", "doc_array", "music_array");			
	// LOOP ARRAYS TO GET ALL MEDIA DATA
	foreach($get_type as $type){		
		// GET THE MEDIA DATA FOR THIS ARRAY
		$data = get_post_meta($postid,$type,true);	 
		
		if(is_array($data)){
		// LOOP THROUGH, CHECK AND DELETE		
			foreach($data as $media){
				if(isset($media['filepath'])){
					@unlink($media['filepath']);					
				}
			}// end foreach
		
			// EMPTY THE TYPE DATA
			update_post_meta($postid,$type,'');	
			
		}// end if
	} // end foreach
	// LOOP THROUGH AND REMOVE THE ONE WE DONT WANT
	
	// DELETE FILE FROM WORDPRESS MEDIA LIBUARY
	wp_delete_attachment($postid, true);
 

}
function UPLOAD_DELETE($id){
 
	// DATA IS STORED AS POSTid---ATTACHMENTID	
	$bits = explode("---",$id);
	// GET EXISTS MEDIA ARRAYS
	$get_type = array("image_array", "video_array", "doc_array", "music_array");			
	// LOOP ARRAYS TO GET ALL MEDIA DATA
	foreach($get_type as $type){		
		// GET THE MEDIA DATA FOR THIS ARRAY
		$data = get_post_meta($bits[0],$type,true);	 
		if(is_array($data)){
		// LOOP THROUGH, CHECK AND DELETE
			$new_array = array();			
			foreach($data as $media){
				if($media['id'] != $bits[1]){
					$new_array[] = $media;
				}else{
					$delsrc 	= $media['filepath'];
					$delthumbsrc = $media['thumbnail'];				
					
				}// end if
			}// end foreach	
			// UPDATE MEDIA FILE ARRAY
			update_post_meta($bits[0],$type,$new_array);	
		}// end if
	} // end foreach
	// LOOP THROUGH AND REMOVE THE ONE WE DONT WANT
	
	// DELETE FILE FROM WORDPRESS MEDIA LIBUARY
	if ( false === wp_delete_attachment($bits[1], true) ){	
		//die("could not delete file");
	} 
	
	// FALLBACK IF SYSTEM IS NOT DELETING IMAGES
	if(strlen($delsrc) > 1 && file_exists($delsrc)){ @unlink($delsrc); } 
	if(strlen($delthumbsrc) > 1){ 	
		$ff = explode("/",$delsrc);
		$fg = explode($ff[count($ff)-1],$delsrc);
		$fd = explode("/",$delthumbsrc);
		$thumbspath = $fg[0].$fd[count($fd)-1]; 
		if(file_exists($thumbspath)){					
		@unlink($thumbspath);
		}
	} 

}
function UPLOADSPACE($postID){
	
	global $wpdb;

	// COUNT THE TOTAL UPLOADS FOR THIS LSITING
	$get_type = array("image_array", "video_array", "doc_array", "music_array"); $COUNT = 0;
	
	foreach($get_type as $type){
		$g = get_post_meta($postID,$type, true); 
		if(is_array($g) && !empty($g) ){	
		$COUNT += count($g);
		}
	}
	return round($COUNT,0);

}

function UPLOAD($data){
 
	if(!is_array($data)){ return $data; }
	
	//SPLIT THE DATA	
	$postID 	= $data[0];
	$file 		= $data[1];	
	$featured 	= $data[2];

	global $wpdb, $userdata; get_currentuserinfo();
	
	// MAKE USER ID
	if(isset($userdata->data->ID) && is_numeric($userdata->data->ID)){
		$userID = $userdata->data->ID;
	}elseif(isset($userdata->ID) && is_numeric($userdata->ID)){
		$userID = $userdata->ID;
	}
	
	// VERIFY THIS POST ID BELONGS TO THIS AUTHOR
	$verify_post = get_post($postID);
 
	if(!isset($userID) || ( $verify_post->post_author != $userID && $userdata->roles[0] != "administrator" )){
		$e = array();
		return $e['error'] = "INVALID USER";
	}
	
	// LOAD IN WORDPRESS FILE UPLOAOD CLASSES
	$dir_path = str_replace("wp-content","",WP_CONTENT_DIR);
	if(!function_exists('get_file_description')){
	require $dir_path . "/wp-load.php";
	require $dir_path . "/wp-admin/includes/file.php";
	require $dir_path . "/wp-admin/includes/media.php";	
	}
	if(!function_exists('wp_generate_attachment_metadata') ){
	require $dir_path . "/wp-admin/includes/image.php";
	}
	// required for wp_handle_upload() to upload the file
	$upload_overrides = array( 'test_form' => FALSE );
 
	// load up a variable with the upload direcotry
	$uploads = wp_upload_dir();
  
	// create an array of the $_FILES for each file
	$file_array = array(
		'name' 		=> $file['name'],
		'type'		=> $file['type'],
		'tmp_name'	=> $file['tmp_name'],
		'error'		=> $file['error'],
		'size'		=> $file['size'],
	);
 
	// check to see if the file name is not empty
	if ( !empty( $file_array['name'] ) ) {
	
		// checks the file type and stores in in a variable
	    $wp_filetype = wp_check_filetype( basename( $file_array['name'] ), null );	
 
  		// Set an array containing a list of acceptable formats
		$allowed_file_types = $this->allowed_image_types;
	
		if($GLOBALS['CORE_THEME']['allow_video'] == 1){
		$allowed_file_types = array_merge($allowed_file_types,$this->allowed_video_types);
		}
		if($GLOBALS['CORE_THEME']['allow_docs'] == 1){
		$allowed_file_types = array_merge($allowed_file_types,$this->allowed_doc_types);
		}
        if($GLOBALS['CORE_THEME']['allow_audio'] == 1){
		$allowed_file_types = array_merge($allowed_file_types,$this->allowed_music_types);
		}
		// die(print_r($allowed_file_types));
        // If the uploaded file is the right format
        if(in_array($file_array['type'], $allowed_file_types)) {
		
			// upload the file to the server
			$uploaded_file = wp_handle_upload( $file_array, $upload_overrides );
	 	
			// CHECK FOR ERRORS
			if(isset($uploaded_file['error']) ){		
				return $uploaded_file;
			}
			
			// set up the array of arguments for "wp_insert_post();"
			$attachment = array(
			 
				'post_mime_type' => $wp_filetype['type'],
				'post_title' => preg_replace('/\.[^.]+$/', '', basename( $file['name'] ) ),
				'post_content' => '',
				'post_author' => $userID,
				'post_status' => 'inherit',
				'post_type' => 'attachment',
				'post_parent' => $postID,
				'guid' => $uploaded_file['url']
			);			  
	
			// insert the attachment post type and get the ID
			$attachment_id = wp_insert_post( $attachment );
	
			// generate the attachment metadata
			$attach_data = wp_generate_attachment_metadata( $attachment_id, $uploaded_file['file'] );
	  
			// update the attachment metadata
			$rr = wp_update_attachment_metadata( $attachment_id,  $attach_data );
			
			// ADD IN MISSING DATABASE TABLE KEY			
			add_post_meta($attachment_id,'_wp_attached_file',$attach_data['file']);
				
			 
			if(isset($attach_data['sizes']['thumbnail']['file'])){
				$thumbnail = $uploads['url']."/".$attach_data['sizes']['thumbnail']['file'];
			}else{
				$thumbnail = $uploads['url']."/".$file['name'];
			}
				
				// BUILD ARRAY TO SAVE IMAGE INTO DATABASE
				$save_file_array = array(
						'name' 		=> $file['name'],
						'type'		=> $file['type'],
						'tmp_name'	=> $file['tmp_name'],
						'postID'	=> $postID,
						'size'		=> $this->_format_bytes($file['size']),
						'src' 		=> $uploaded_file['url'],
						'thumbnail' => str_replace(" ", "-",addslashes($thumbnail)),
						'filepath' 	=> addslashes($uploaded_file['file']),
						'id'		=> $attachment_id,
						'default' 	=> $featured,
						'order'		=> 0,
				);			
				
				// AUTO DETECT FILE TYPE AND ADD TO CORRECT ARRAY
				// WE NEED TO ADD NICER THUMBNAILS FOR NON-IMAGE TYPES (VIDEOS ETC)
				if(in_array($file['type'],$this->allowed_image_types)){ 

					$storage_key = "image_array";			
					
					
					// RESIZE ALL OVERLY LARGE IMAGES TO MAX OF 10000
					$image_resize = wp_get_image_editor( addslashes($uploaded_file['file']) ); // Return an implementation that extends WP_Image_Editor

					if ( ! is_wp_error( $image_resize ) ) {	
						
						$img_size = $image_resize->get_size();
					 
						if($GLOBALS['CORE_THEME']['wlt_core_imgcrop'] == 1 && ( $img_size['width'] > 900 || $img_size['height'] > 900 ) ){ 
							$image_resize->resize( 900, 900, true );
							$image_resize->save( addslashes($uploaded_file['file']) );
						}
					}
										
						
				}elseif(in_array($file['type'],$this->allowed_video_types)){
					$storage_key = "video_array";
					$save_file_array["thumbnail"] = get_template_directory_uri()."/framework/img/video_fallback.jpg";
					
					// BUILD IN SUPPORT FOR FFMEG AND THUMBNAIL CREATION
					if (exec('/usr/local/bin/ffmpeg -version') != 127){ 
					
						$video  = $save_file_array['src'];
						$thumbnail  = "/".str_replace(".","_",str_replace(" ","",$file['name']))."_ffmpeg.jpg";														
						if (file_exists($out)) { unlink($out); }						
						$g = shell_exec("/usr/local/bin/ffmpeg -i ".$video." -s 480x360 -cropleft 4 -cropright 4 -croptop 12 -cropbottom 12 -ss 00:00:06.000 -vframes 1 ".$uploads['path'].$thumbnail." 2> ffmepeg_errorlog.txt");							 
						
						if (file_exists($uploads['url'].$thumbnail)) { 	
							$save_file_array["thumbnail"] =  $uploads['url'].$thumbnail; 
						}
					}	 
									
					
				}elseif(in_array($file['type'],$this->allowed_music_types)){
					$storage_key = "music_array";	
					$save_file_array["thumbnail"] = get_template_directory_uri()."/framework/img/music_fallback.jpg";				
				}elseif(in_array($file['type'],$this->allowed_doc_types)){
					$storage_key = "doc_array";		
					$save_file_array["thumbnail"] = get_template_directory_uri()."/framework/img/doc_fallback.jpg";	
				}else{
					$storage_key = "image_array"; // fallback to image array
				} 
				
				// ADD TO MY IMAGE GALLERY ARRAY
				$my_existing_images = get_post_meta($postID,$storage_key, true);
				if(is_array($my_existing_images)){
					
					$new_array = array();
					$new_array[] = $save_file_array;
					foreach($my_existing_images as $img ){ $new_array[] = $img; }						
				}else{				
					$new_array = array();
					$new_array[] = $save_file_array;									
				}				 		
				// SAVE
				update_post_meta($postID,$storage_key,$new_array);	
				
				// CHECK FOR FEATURED
				if($featured && in_array($file_array['type'], $this->allowed_image_types) ){
				set_post_thumbnail($postID, $attachment_id);
				}
			
			
			// format responce
			$responce = array();
			$responce["name"] 				= $file_array['name'];
			$responce["size"] 				= $file['size'];
			$responce["url"] 				= $uploads['url']."/".$attach_data['sizes']['thumbnail']['file'];
			$responce["thumbnail_url"] 		= $save_file_array["thumbnail"];
			$responce["delete_url"] 		= $postID."---".$attachment_id; // CUSTOM FOR DELETION SCRIPT
			$responce["delete_type"] 		= "DELETE";
			$responce["aid"] 				= $attachment_id;
		 
			return hook_upload_return(array($responce));
			  
		}else{
		//print_r($file_array);
		return "INVALID FORMAT";
		
		}
 
	} // end if		 

}
 
function _format_bytes($a_bytes)
{
    if ($a_bytes < 1024) {
        return $a_bytes .' B';
    } elseif ($a_bytes < 1048576) {
        return round($a_bytes / 1024, 2) .' KiB';
    } elseif ($a_bytes < 1073741824) {
        return round($a_bytes / 1048576, 2) . ' MiB';
    } elseif ($a_bytes < 1099511627776) {
        return round($a_bytes / 1073741824, 2) . ' GiB';
    } elseif ($a_bytes < 1125899906842624) {
        return round($a_bytes / 1099511627776, 2) .' TiB';
    } elseif ($a_bytes < 1152921504606846976) {
        return round($a_bytes / 1125899906842624, 2) .' PiB';
    } elseif ($a_bytes < 1180591620717411303424) {
        return round($a_bytes / 1152921504606846976, 2) .' EiB';
    } elseif ($a_bytes < 1208925819614629174706176) {
        return round($a_bytes / 1180591620717411303424, 2) .' ZiB';
    } else {
        return round($a_bytes / 1208925819614629174706176, 2) .' YiB';
    }
}
/* =============================================================================
	GLOBAL ERROR CLASS
========================================================================== */
function ERRORCLASS($msg="",$type=""){
$STRING = "";
 
if(( isset($GLOBALS['error_message']) || strlen($msg) > 1 ) && ( !isset($GLOBALS['error_message_set']) ) ){

	if(strlen($msg) > 1){ $error_message = $msg; }else{ $error_message = $GLOBALS['error_message']; }
	if(strlen($type) > 1){ $error_type = $type; }else{ if(!isset($GLOBALS['error_type'])){ $error_type = "success"; }else{ $error_type = $GLOBALS['error_type']; } }
	
	$STRING = '<div class="alert alert-'.$error_type.'">
	  <button type="button" class="close" data-dismiss="alert">x</button>
	  '.$error_message.'
	</div>';
	
	$GLOBALS['error_message_set'] = 1;
}
return $STRING;
}
/* =============================================================================
	  COMMENT PROCESSING
	========================================================================== */
function insert_comment_extra($cid) { global $post;
    
	if(isset($_POST['score']) && is_numeric($_POST['score']) ){
	
		// SAVE SCORE IN COMMENT DATA
		add_post_meta($cid,'score',$_POST['score']);
		
		// SAVE FOR FEEDBACK SCORE
		$totalvotes = get_post_meta($post->ID, 'feedbackrating_votes', true);
		$totalamount = get_post_meta($post->ID, 'feedbackrating_total', true);
		if(!is_numeric($totalamount)){ $totalamount = $_POST['score']; }else{ $totalamount += $_POST['score']; }
		if(!is_numeric($totalvotes)){ $totalvotes = 1; }else{ $totalvotes++; }	
		$save_rating = round(($totalamount/$totalvotes),2);		
		update_post_meta($post->ID, 'feedbackrating', $save_rating);
		update_post_meta($post->ID, 'feedbackrating_total', $totalamount);
		update_post_meta($post->ID, 'feedbackrating_votes', $totalvotes);
		
		// SAVE STAR RATING VALUE
		$totalvotes = get_post_meta($post->ID, 'starrating_votes', true);
		$totalamount = get_post_meta($post->ID, 'starrating_total', true);
		if(!is_numeric($totalamount)){ $totalamount = $_POST['score']; }else{ $totalamount += $_POST['score']; }
		if(!is_numeric($totalvotes)){ $totalvotes = 1; }else{ $totalvotes++; }	
		$save_rating = round(($totalamount/$totalvotes),2);	
		update_post_meta($post->ID, 'starrating', $save_rating);
		update_post_meta($post->ID, 'starrating_total', $totalamount);
		update_post_meta($post->ID, 'starrating_votes', $totalvotes);
					
	}
}

function redirect_after_comment($location){
	$newurl = substr($location, 0, strpos($location, "#comment"));
	return $newurl . '?newcomment=1';
}

function _preprocess_comment( $comment_data ) { global $CORE, $userdata, $post;	 
	 
	// BASIC FORM VALIDATION
	if(!is_admin()){
		if( !isset($GLOBALS['CORE_THEME']['comment_captcha']) || (  isset($GLOBALS['CORE_THEME']['comment_captcha']) && $GLOBALS['CORE_THEME']['comment_captcha'] == 1 ) ){
			if( !isset($_POST['reg1']) ||  ( isset($_POST['reg1']) && ( $_POST['reg1'] + $_POST['reg2'] ) != $_POST['reg_val'] ) ){		
			wp_die( '<strong>ERROR</strong>: '.$CORE->_e(array('login','21')) );
			}
		}
	}
	
 
	
	// RETURN COMMENT DATA
    return $comment_data;
}
 
/* =============================================================================
	  REGISTER /LISTING FIELDS
	========================================================================== */
function BUILD_FIELDS($fields,$data=""){

global $wpdb, $CORE, $userdata; get_currentuserinfo(); $i = 0; $FIELDVALUE = ""; $STRING = ""; $EXTRA = ""; $FIELDVALUE="";  $VALIDATION = ""; $show_count = 0; $hideempty = 0;

	if(isset($_GET['eid'])){ $_GET['eid'] = strip_tags($_GET['eid']); }
	// TABBING ORDER
	if(!isset($GLOBALS['TABORDER'])){$GLOBALS['TABORDER'] = 10;	}
	// IF NOT ARRAY, RETURN
	if(!is_array($fields)){ return; }	
	// LOOP THROUGH THE FIELDS AND BUILD DISPLAY
	foreach($fields as $field){	
 
		// SPAN SIZES
		if(isset($field['ontop'])){
			$spans1 = "col-md-12";
			$spans2 = "col-md-12";
		}else{
			$spans1 = "col-md-4";
			$spans2 = "col-md-8";
		}
		
		// ADD IN VALIDATE CODE
		if(isset($field['required']) && $field['required'] == "yes" &&  !in_array($field['name'], array('post_title','post_content', 'category') )  && $field['type'] != "image"  ){
			 
			if(isset($field['taxonomy']) && strlen($field['taxonomy']) > 2){
			$eth = "_tax";
			}else{
			$eth = "";
			}
			
			if($eth != "_tax"){
			 
			 	$VALIDATION .= " var cus".$GLOBALS['TABORDER']." = document.getElementById(\"form".$eth."_".trim($field['name'])."\");
					  if(cus".$GLOBALS['TABORDER'].".value == '-------'){
						alert('".$CORE->_e(array('validate','0'))."');
						cus".$GLOBALS['TABORDER'].".style.border = 'thin solid green';
						cus".$GLOBALS['TABORDER'].".focus();
						XXX
						return false;
					}
					if(cus".$GLOBALS['TABORDER'].".value == ''){
						alert('".$CORE->_e(array('validate','0'))."');
						cus".$GLOBALS['TABORDER'].".style.border = 'thin solid green';
						cus".$GLOBALS['TABORDER'].".focus();
						XXX
						return false;
					}";
			}
			
				if(isset($GLOBALS['tpl-add'])){
					$VALIDATION = str_replace("XXX", "colAll(); jQuery('.stepblock5').collapse('show');", $VALIDATION);
				}else{
					$VALIDATION = str_replace("XXX", "", $VALIDATION);
				}
				
				$GLOBALS['core_theme_validation_listing'] = $VALIDATION;			
		}

		 
		// BUILD OUTPUT - DONT SHOW FOR HIDDEN FIELDS		
		if($field['type'] == "title"){
		
			$STRING .= '<div class="form-group clearfix customfield"><h4 class="fieldtitle">'.stripslashes($field['title']).'</h4><div>';
		
		}elseif($field['type'] == "post_content"){
		
		$STRING .= '<div class="form-group clearfix col-md-12" id="form-row-rapper-'.$field['name'].'"><label class="control-label">';
		$STRING .= stripslashes($field['title']);
		$STRING .= ' <span class="required">*</span></label><div class="field_wrapper">';
		
		}elseif($field['type'] !="hidden"  && $field['type'] != "category" ){
		 				
			$STRING .= '<div class="form-group clearfix" id="form-row-rapper-'.$field['name'].'"><label class="control-label '.$spans1.'">';
			$STRING .= stripslashes($field['title']);
			// IS IT REQUIRED?
			if(isset($field['required']) && $field['required'] == "yes"){
			$STRING .= " <span class='required'>*</span>";
			}
			$STRING .= '</label><div class="field_wrapper '.$spans2.'">';
		}
		
		// CHECK FOR FIELD VALUES
		if($field['name'] == "post_tags" && isset($_GET['eid']) ){
		$FIELDVALUE = "";
		$tfs = wp_get_post_tags($_GET['eid']);
		if(!empty($tfs)){
			foreach($tfs as $ta){ $FIELDVALUE .= $ta->name.", "; }
		}else{
		$FIELDVALUE = "";
		}
		
		}elseif(isset($data[$field['name']])){ 
			$FIELDVALUE = $data[$field['name']]; 	
		}elseif(isset($_POST['action']) && isset($_POST['form'][$field['name']]) ){ 		
			$FIELDVALUE = esc_attr($_POST['form'][$field['name']]); 		 			
		}else{		
			if(isset($field['defaultvalue'])){
			$FIELDVALUE = $field['defaultvalue'];
			}else{
			$FIELDVALUE = "";
			}		
		}
		
		// DETERMINE THE FORM TYPE (FORM OR CUSTOM)
		if(in_array($field['name'],array("post_title","post_content","category","new_username","new_password","email") )){ $formType = "form"; }else{ $formType = "custom"; }
		
		// DISPLAY FIELD TYPES
		switch($field['type']){
			
			case "title":
			case "map": {
			} break;
			case "tags": {
			} break;
			case "upload": {
			} break;
			case "image": {	
			
			ob_start(); 
			?>
           
            <div class="row uploadiconbox">         
               
            <div class="col-md-3"><a href="javascript:void(0);" onClick="enableUploadForm('.jpg/.gif/.png');" class="c1">
            <span><i class="fa fa-file-image-o"></i></span> <?php echo $CORE->_e(array('add','84')); ?></a> </div>
            
            <?php if(isset($GLOBALS['CORE_THEME']['allow_video']) && $GLOBALS['CORE_THEME']['allow_video'] == 1){ ?>
         	<div class="col-md-3"><a href="javascript:void(0);" onClick="enableUploadForm('.flv/.mp4');" class="c2">
            <span><i class="fa fa-file-video-o"></i></span> <?php echo $CORE->_e(array('add','85')); ?></a> </div>
            <?php } ?>
            
            <?php if(isset($GLOBALS['CORE_THEME']['allow_audio']) && $GLOBALS['CORE_THEME']['allow_audio'] == 1){ ?>
         	<div class="col-md-3"><a href="javascript:void(0);" onClick="enableUploadForm('.mp3');" class="c3">
            <span><i class="fa fa-file-sound-o"></i></span> <?php echo $CORE->_e(array('add','86')); ?></a> </div>
            <?php } ?>
            
            <?php if(isset($GLOBALS['CORE_THEME']['allow_docs']) && $GLOBALS['CORE_THEME']['allow_docs'] == 1){ ?>
         	<div class="col-md-3"><a href="javascript:void(0);" onClick="enableUploadForm('.pdf');" class="c4">
            <span><i class="fa fa-file-word-o"></i></span> <?php echo $CORE->_e(array('add','87')); ?></a> </div>
            <?php } ?>
            
            </div>            
            <hr />
            
            <?php echo str_replace("%a",$GLOBALS['default_upload_space'], $CORE->_e(array('add','83'))); ?>
            
            <script>			 
			function enableUploadForm(vv){
				jQuery('.allowed').html(vv);
				jQuery('.uploadiconboxform').show();						
			}
			
			</script>            
            
            <?php
			$STRING .= ob_get_clean();
			 
					
				if(isset($_GET['eid']) && is_numeric($_GET['eid'])){
				 if ( has_post_thumbnail($_GET['eid'])) {
				   $large_image_url = wp_get_attachment_image_src( get_post_thumbnail_id($_GET['eid']), 'full');
				   
				   $STRING .= '<div id="image_single_1"><a href="' . $large_image_url[0] . '" title="' . the_title_attribute('echo=0') . '" style="float:right;" class="wlt_thumbnail" target="_blank">';
				   $STRING .= hook_image_display(get_the_post_thumbnail($_GET['eid'], 'thumbnail')); 
				   $STRING .= '</a>';				   
				   $STRING .= '<div class="clearfix"></div><button class="pull-right" type="button" onclick="document.getElementById(\'image_single_1\').style.display=\'none\';document.getElementById(\'attachement_id\').value=\''.$_GET['eid'].'---'.get_post_thumbnail_id($_GET['eid']).'\';jQuery(\'button.start\').hide();document.core_delete_attachment.submit();">'.$CORE->_e(array('button','3')).'</button></div>';
				 }
				}elseif(!isset($_GET['eid']) && is_numeric($GLOBALS['default_upload_space']) ){ // display multiple upload form elements
				
					if($GLOBALS['default_upload_space'] > 0){ 
						$NEW_STRING = "";
						while($i < $GLOBALS['default_upload_space']-1 && $i < 20){
						 
						$GLOBALS['TABORDER']++;
						if($i > 2){ $vis = "none"; }else{ $vis = "visible"; }
						$l = $i+1;
						$NEW_STRING .= '<div id="uploadform'.$i.'" style="display:'.$vis.'">
						<input onChange="jQuery(\'#uploadform'.$l.'\').show();" type="file" name="image[]"  class="fileinput" id="fileupload'.$i.'" tabindex="'.$GLOBALS['TABORDER'].'">
						</div>';
						$i++;
						}
					}			 
				}
				
				
				$STRING .= '<div class="uploadiconboxform well"><div class="allowed">jpeg/ gif</div><input type="file" name="image[]"  class="fileinput" id="fileupload" tabindex="'.$GLOBALS['TABORDER'].'">'.$NEW_STRING."</div>";
				
				//$field['help'] = $CORE->_e(array('add','61'));
				
			
			} break;
			case "hidden": {
			$STRING .= '<input type="hidden" name="'.$formType.'['.$field['name'].']" id="form_'.$field['name'].'" value="'.$field['values'].'"  '.$EXTRA.'/>';	
			} break;
			case "price": {	
			$STRING .= '<div class="input-group col-md-4">
			<input type="text" name="'.$formType.'['.$field['name'].']" maxlength="255" id="form_'.$field['name'].'" class="'.$field['class'].'" tabindex="'.$GLOBALS['TABORDER'].'" value="'.$FIELDVALUE.'"  '.$EXTRA.'/>
			<span class="input-group-addon">'.$GLOBALS['CORE_THEME']['currency']['symbol'].'</span></div> ';
			
						
			} break;
			case "longtext": 
			case "text": {	
			
			if(isset($field['password'])){ $tt = "password"; }else{ $tt = "text"; }
			if(isset($field['placeholder'])){ $PLACEHOLDER = $field['placeholder']; }else{ $PLACEHOLDER = ""; }
			
			$STRING .= '<input type="'.$tt.'" name="'.$formType.'['.$field['name'].']" placeholder="'.$PLACEHOLDER.'" maxlength="255" id="form_'.$field['name'].'" class="'.$field['class'].'" tabindex="'.$GLOBALS['TABORDER'].'" value="'.$FIELDVALUE.'"  '.$EXTRA.'/>';			
			} break;
			case "textarea": {
			$STRING .= '<textarea class="'.$field['class'].'" rows="4" name="form['.$field['name'].']" id="form_'.$field['name'].'" tabindex="'.$GLOBALS['TABORDER'].'" '.$EXTRA.'>'.$FIELDVALUE.'</textarea>';						
			} break;
			case "post_content": {
		 	
			$STRING .= hook_add_form_post_content('<textarea class="form-control" rows="10" name="'.$formType.'['.$field['name'].']" id="form_'.$field['name'].'" tabindex="'.$GLOBALS['TABORDER'].'" '.$EXTRA.'>'.$FIELDVALUE.'</textarea>', $FIELDVALUE);	
			ob_start();
			?>
            
            <?php if(isset($field['showlimit'])){  ?>
<script>

jQuery(document).ready(function() {
textarealimit();
});
function textarealimit(){

  text_max = <?php if(!isset($GLOBALS['CORE_THEME']['descmin'])){ $GLOBALS['CORE_THEME']['descmin'] = 200; } echo $GLOBALS['CORE_THEME']['descmin']; ?>;
  var text_length = jQuery('#form_post_content').val().length;
  var text_remaining = text_max - text_length;
  if(text_remaining < 0){
  jQuery('#textarea_feedback').hide();
  }

  jQuery('#textarea_feedback span').html( '<b>' + text_remaining + '</b> <?php echo $CORE->_e(array('add','96')); ?>');

   jQuery('#form_post_content').keyup(function() {
	
        var text_length = jQuery('#form_post_content').val().length;
        var text_remaining = text_max - text_length; 

        jQuery('#textarea_feedback span').html( '<b>' + text_remaining + '</b> <?php echo $CORE->_e(array('add','96')); ?>');
		
		if(text_remaining < 0){
			jQuery('#textarea_feedback').hide();
		}else{
			jQuery('#textarea_feedback').show();
		}
		
   });
	
};

</script>

<div id="textarea_feedback" style="font-size: 12px;  color: #999;  padding-top: 5px;"> <i class="glyphicon glyphicon-tasks" ></i> <?php echo str_replace("%a", $GLOBALS['CORE_THEME']['descmin'], $CORE->_e(array('add','95')) ); ?>   <span></span> </div>

<?php } ?>

            
            <?php
			$STRING .= ob_get_clean(); 	
					
			} break;					
			case "select": {
			 
				 $value = "";
				 if(isset($_GET['eid'])){
				 $value = get_post_meta($_GET['eid'],$field['name'],true);
				 }
				 $STRING .= '<select name="'.$formType.'['.$field['name'].']" tabindex="'.$GLOBALS['TABORDER'].'" id="form_'.$field['name'].'" '.$EXTRA.' class="'.$field['class'].'">';					
					foreach($field['listvalues'] as $key=>$val){							
						
						// HIDE IF BLANK
						$val = trim($val);
						if($val == ""){ continue; }
						
						if($value == $key){
								$STRING .= '<option value="'.$key.'" selected=selected>'.$val.'</option>';
						}else{
								$STRING .= '<option value="'.$key.'">'.$val.'</option>';
						}
					}// end foreach
				$STRING .= '</select>';
			} break;	
			case "taxonomy": {
			   
			 	// FORMAT VALUES SO WE CAN CHECK IF THEY ARE SELECTED
				//if(is_array($value)){
				//$selected_array = array();
				//foreach($value as $vv){ $selected_array[] = $vv->term_id; }
				//}
				
				// GET SELECTED VALUE
				if(isset($_GET['eid'])){	 
				$selected_array = wp_get_post_terms($_GET['eid'], $field['taxonomy'], array("fields" => "ids"));					 
				}
					
			 	// START BUILDING THE LIST
				$terms = get_terms($field['taxonomy'],'hide_empty=0&parent=0');
				$selec = (isset( $_GET['pr'] )) ? $_GET['pr'] : '';		 
				$count = count($terms);	
				if($count > 0){		 
						 
					// ADD ON CODE FOR LINKAGE
					$ex = ""; $taxlink = false;
					if(isset($field['taxonomy_link']) && strlen($field['taxonomy_link']) > 2 && $field['taxonomy_link'] != "store"){
						$taxlink = true;
						
						if(isset($GLOBALS['tpl-add'])){
						$canAdd = 1;
						}else{
						$canAdd = 0;
						}
						$ex = "onChange=\"ChangeSearchValues('".str_replace("https://","",str_replace("http://","",get_home_url()))."',this.value,'".$field['taxonomy_link']."__".$field['taxonomy']."','tx_".$field['taxonomy_link']."[]','-1','".$canAdd."', 'reg_field_tax_".$field['taxonomy_link']."')\"";
					}
					
					
					 
					$STRING .= '<div class="input-group col-md-10"><select name="tax['.$field['taxonomy'].']" class="'.$field['class'].'" tabindex="'.$GLOBALS['TABORDER'].'" id="reg_field_tax_'.$field['taxonomy'].'" '.$ex.'>';
					$STRING .="<option value=''></option>";
					
					
					foreach ( $terms as $term ) {
						
						// SETUP VALUE FOR LISTBOX
						if($taxlink){ $tvg = $term->term_id;  }else{ $tvg = $term->term_id; }
						
						// SETUP SELECTED VALUE						
					 	if(is_array($selected_array) && in_array($term->term_id,$selected_array)){ $a = "selected=selected"; }else{ $a= ""; }
						
						// SPACING
						if($term->parent == 0){ $spp = ""; }else{ $spp = "&nbsp;&nbsp;&nbsp;"; }
						
						// OUTPUT
						$STRING .="<option value='".$tvg."' ".$a.">" . $spp . $term->name . " (".$term->count.") </option>";
						
						 
						// GET INNER CHILD ITEMS
						/*
						$terms_inner = get_terms($field['taxonomy'],'hide_empty=0&child_of='.$term->term_id);
						if(count($terms_inner) > 0){
						
							foreach ( $terms_inner as $term_inn ) {
							
								// SETUP VALUE FOR LISTBOX
								if($taxlink){ $tvg1 = $term_inn->term_id; }else{ $tvg1 = $term_inn->term_id; }
								
								// SETUP SELECTED VALUE
								if(is_array($selected_array) && in_array($tvg1,$selected_array)){ $b = "selected=selected"; }else{ $b= ""; }
								
								$STRING .= "<option value='".$tvg1."' ".$b."> -- " . $term_inn->name . " (".$term_inn->count.") </option>";
							}
						}	
						*/				 		   
													   				
					 }
					 
					$STRING .= '</select>';
					
					$STRING .= '<span class="input-group-addon">';
					
					$STRING .= "<a href='#step4' onclick=\"TaxNewValue('reg_field_tax_".$field['taxonomy']."', '".$CORE->_e(array('add','72'))."')\"> <i class='fa fa-plus-square'></i> </a>"; 
					
					$STRING .= '</span></div>';
					
					
					 
				}
				
			} break;
			
			
			case "category": {
			
			// DEFAULT CATS
			$catstring = "";
			if(isset($data) && isset($data['cats']) && isset($data['cats'][0]->term_id) ){ $cats =  $data['cats'][0]->term_id; }else{ $cats = 0;  } 
			if(isset($data['cats']) && !empty($data['cats']) ){ foreach($data['cats'] as $cata){ $catstring .= $cata->term_id.','; } }
			
			// SINGLE OR MULTIPLE CATEGORIES	
			$maxCats = 1;		
			if(isset($field['multi'])){		
				$maxCats = $field['max'];	 
				echo '<input type="hidden" id="check_multi" value="1" name="check_multi" />';
			}else{			
		 		echo '<input type="hidden" id="check_multi" value="0" name="check_multi" />';		
			}
				
			
			// CATEGORY LIST
			$DISPLAYCATS = explode(",",$catstring);
				
				// CHECK IF WE HAVE DISABLED THE PARENT CATEGORY
				// IF SO GET THE PARENT CAT FROM THE FIRST CHILD VALUE
				if(isset($GLOBALS['tpl-add']) && isset($GLOBALS['CORE_THEME']['disablecategory']) && $GLOBALS['CORE_THEME']['disablecategory'] == 1){			
					$term = get_term( $DISPLAYCATS[0], THEME_TAXONOMY );				
					$catstring = $term->parent.",".$catstring;			
				}			 
				
				// CLEAN UP
				if(substr($catstring,-1) == ","){
				$catstring = substr($catstring,0, -1);
				}
								
				$cats = wp_list_categories(array('walker'=> new Walker_CategorySelection, 'taxonomy' => THEME_TAXONOMY, 'show_count' => $show_count, 'hide_empty' => $hideempty, 'echo' => 0, 'title_li' =>  false, 'selected' => $catstring ) ); 
		 		
				?>
<script type="text/javascript"> 
  
  	function HasTooMany(div){  
 
		var countCats = 0;	
		countCats = jQuery('input[type="checkbox"]').filter(function() {		return !this.disabled && this.checked;		}).length;
		 
		jQuery('#SelCatCount').html(countCats);
		
		if(countCats == <?php echo $maxCats; ?>){ 
		 
		
		}else if(countCats > <?php echo $maxCats; ?>){
		 
		 //
		 //alert('<?php echo str_replace("%a", $maxCats,$CORE->_e(array('add','80')) ); ?>');
		  
		 jQuery('#SelCountPre').css( "background", "red" );
		 jQuery('#SelCountPre').css( "color", "white" );
		  
		 // jQuery('.tcheckbox').attr('disabled', true);
		 
		 if(countCats > <?php echo $maxCats*2; ?>){
		 	jQuery('.tcheckbox').prop( "checked", false );
		 }
		  
		 jQuery(div).prop( "checked", false );
		  
		} else {
		  jQuery('#SelCountPre').css( "background", "#fafafa" );
		  jQuery('#SelCountPre').css( "color", "#444" );
		}
	   
  	} 
	
	jQuery(document).ready(function() {
	
	// SET CURRENT COUNT
	HasTooMany();
	
	// COUNT SELECTED ON CHANGE
	jQuery('.stepblock3 :checkbox').on('change', function (e) { HasTooMany(this); });	
		
  	});
    </script>
            
            
                <pre id="SelCountPre"><?php echo $maxCats; ?> <?php echo $CORE->_e(array('add','81')); ?> <span id="SelCatCount">0</span> <?php echo $CORE->_e(array('add','82')); ?></pre>
                <?php
				echo $cats; 
			
			
			} break; 
				
			 
			case "date": {
			 $db = explode(" ",$FIELDVALUE);
			$STRING .= '<script>jQuery(function(){ jQuery(\'#reg_field_'.$field['name'].'_date\').datetimepicker(); }); </script>
			
			 <div class="input-group date col-md-6" id="reg_field_'.$field['name'].'_date" data-date="'.$db[0].'" data-date-format="yyyy-MM-dd hh:mm:ss">
			<span class="add-on input-group-addon"><i class="glyphicon glyphicon-calendar"></i></span>
				<input type="text" class="form-control" name="'.$formType.'['.$field['name'].']" value="'.$FIELDVALUE.'" id="reg_field_'.$field['name'].'" tabindex="'.$GLOBALS['TABORDER'].'" data-format="yyyy-MM-dd hh:mm:ss" />
				
			  </div>
			<div class="clearfix"></div>
			';	
			} break;
			
			default:{
			 
			$STRING .= hook_core_fields_switch($field);
			
			} break;
					
		}	
		
		if(isset($field['help']) && strlen($field['help']) > 1){
			$STRING .= "<p class='description'>".stripslashes($field['help'])."</p>";
		}
		// DONT SHOW FOR HIDDEN FIELDS
		if($field['type'] !="hidden"  && $field['type'] != "category" ){ 
			$STRING .= '</div></div>';
		}
			
		// INCREMENT TAB ORDER
		$GLOBALS['TABORDER']++;
		
	}// end foreach
	
	return hook_add_build_field($STRING);


}
function CORE_FIELDS($show=false,$addlisting=false){

	global $wpdb, $CORE, $userdata; $STRING = ""; $packageID = ""; $VALIDATION = '<script type="text/javascript"> function ValidateCoreRegFields(){ ';
	
	if(isset($GLOBALS['core_theme_validation_listing'])){ $VALIDATION .= $GLOBALS['core_theme_validation_listing']; }
	
	// CHECK FOR PACKAGE ID // IF WERE ADDING A NEW LISTING
	if(isset($_POST['packageID']) && is_numeric($_POST['packageID']) ){
	//$packagefields = get_option("packagefields");
	//$packageID = $packagefields[$_POST['packageID']]['ID'];
	$packageID = $_POST['packageID'];
	}
	// TABBING ORDER
	if(!isset($GLOBALS['TABORDER'])){$GLOBALS['TABORDER'] = 3;	}
	// WHICH SET OF FIELDS TO DISPLAy
	if($addlisting){
	$regfields = get_option("submissionfields");
	}else{
	$regfields = get_option("regfields");
	}
	
	// ADD ON BASIC FIELDS FOR REGISTRATION
	if(!$addlisting && !isset($GLOBALS['flag-myaccount']) ){
	
	$VALIDATION .= "var b1 = document.getElementById(\"user_login\");if(b1.value == ''){alert('".str_replace("'","",$CORE->_e(array('validate','0')))."');b1.style.border = 'thin solid red';b1.focus();return false;};";
	$VALIDATION .= "var b2 = document.getElementById(\"user_email\");if(b2.value == ''){alert('".str_replace("'","",$CORE->_e(array('validate','0')))."');b2.style.border = 'thin solid red';b2.focus();return false;};";
	$VALIDATION .= "if( !isValidEmail( b2.value ) ) { alert('".str_replace("'","",$CORE->_e(array('validate','23')))."'); b2.style.border = 'thin solid red'; b2.focus(); return false; }";
	}
	
	
	if(isset($GLOBALS['CORE_THEME']['show_mem_registraion']) && $GLOBALS['CORE_THEME']['show_mem_registraion'] == '1' && !isset($GLOBALS['tpl-add']) && $GLOBALS['nosidebar-right'] == true && $GLOBALS['nosidebar-left'] == true){
	$VALIDATION .= "var mm1 = document.getElementById(\"membershipID\"); if(mm1.value == ''){alert('".str_replace("'","",$CORE->_e(array('login','32')))."'); return false;};";
	}
	
 	if(is_array($regfields)){
	
		//PUT IN CORRECT ORDER
		$regfields = $this->multisort( $regfields , array('order') );
		$regfields = hook_custom_fields_filter($regfields);
		foreach($regfields as $field){
		
		 
			// EXIST IF KEY DOESNT EXIST
			if($field['fieldtype'] == "taxonomy" && is_admin() ){ continue; }
			if($field['key'] == "" && ( $field['fieldtype'] != "taxonomy" && $field['fieldtype'] != "title" ) ){ continue; }
	 
			$canContinue = false;
			// CHECK MEMBERSIP HAS ACCESS TO THIS FIELD
			if(isset($field['membership']) && is_array($field['membership']) && count($field['membership']) > 0){
				if( isset($GLOBALS['current_membership']) && in_array($GLOBALS['current_membership'], $field['membership'])  ){
				$canContinue = true; 
				}else{
				$canContinue = false;
				}
			}else{
			$canContinue = true; 
			}
			 
			// CHECK PACKAGE HAS ACCESS TO THIS FIELD
			if(isset($field['package']) && is_array($field['package']) && count($field['package']) > 0){
				if(is_numeric($packageID) && in_array($packageID, $field['package']) ){ 
				$canContinue = true;
				}else{
				$canContinue = false;
				}
			}else{
			/** add an extra check because the membersips might return false above ***/
			if($canContinue){
				$canContinue = true;
			} 
			}
			
			// NOW GET THE RESULT
			if(!$canContinue && !is_admin()){ continue; } // 
			 
			
			// CHECK IF WE ARE GETTING VALUES
			if($show){				
				// CAN WE DISPLAY THIS ON OUR PROFILE??
				if(isset($field['display_profile']) && $field['display_profile'] == "no"){ continue; } // SKIP FIELD
				
				if($addlisting){				
					if($field['fieldtype'] == "taxonomy"){					
					$value = get_the_terms( $_GET['eid'], $field['taxonomy'] );
					}else{
					$value = get_post_meta($_GET['eid'], $field['key'], true);
					}				
				}else{
				$value = get_user_meta($userdata->ID, $field['key'], true);
				}
				
			}else{
				if(isset($_POST['custom'][$field['key']])){
					// GET THE POST DATA AFTER FORM WAS SUBMITTED
					if(is_array($_POST['custom'][$field['key']])){
					$value = $_POST['custom'][$field['key']];
					}else{
					$value = esc_attr($_POST['custom'][$field['key']]);
					}				
				}else{
					// GET LISTING DATA
					if($addlisting && isset($_GET['eid']) && $field['fieldtype'] == "taxonomy"){					
					$value = get_the_terms( $_GET['eid'], $field['taxonomy'] );
					}elseif($addlisting && isset($_GET['eid']) ){
					$value = get_post_meta($_GET['eid'], $field['key'], true);
					}else{
					$value = "";
					}				
				}
			}
			
			
			if($field['fieldtype'] == "title" ){
			
				if(is_admin()){
				$STRING .= '<tr style="text-align:left"><th colspan=2><b>'.stripslashes($field['name']).'</b><hr/></th></tr>';
				}else{
				$STRING .= '<div class="form-group clearfix customfield"><h4 class="fieldtitle">'.stripslashes($field['name']).'</h4><div>';
				}
			
			
			}else{			
				 
				
				if(is_admin()){
 
					$STRING .= '<tr>
					<td  style="width:250px;">
					<img src="'.THEME_URI.'/framework/admin/img/info.png" class="infoimg" role="button" aria-pressed="false" style="cursor:pointer;margin-right:10px;" align="absmiddle" title="'.$field['help'].'" />'.stripslashes($field['name']).'</td>
					<td>';
				
				}else{
				
					$STRING .= '<div class="form-group clearfix customfield">
					  <label class="control-label col-md-4">'.stripslashes($field['name']);
					  if(isset($field['required']) && $field['required'] == "yes"){ $STRING .= ' <span class="required">*</span>'; }
					$STRING .= '</label><div class="field_wrapper col-md-8">';
				}
				
				
			}
			
			// ADD IN VALIDATE CODE
			if(isset($field['required']) && $field['required'] == "yes" && $field['fieldtype'] != "checkbox" && $field['fieldtype'] != "radio"){
			 
			if(isset($field['taxonomy']) && strlen($field['taxonomy']) > 2){
			$eth = "_tax";
			}else{
			$eth = "";
			}
			
			if($eth != "_tax"){
			
			$VALIDATION .= " var cus".$GLOBALS['TABORDER']." = document.getElementById(\"reg_field".$eth."_".trim($field['key'])."\");
					 if(cus".$GLOBALS['TABORDER'].".value == '-------'){
						alert('".$CORE->_e(array('validate','0'))."');
						cus".$GLOBALS['TABORDER'].".style.border = 'thin solid red';
						cus".$GLOBALS['TABORDER'].".focus();
						XXX
						return false;
					}
					if(cus".$GLOBALS['TABORDER'].".value == ''){
						alert('".$CORE->_e(array('validate','0'))."');
						cus".$GLOBALS['TABORDER'].".style.border = 'thin solid red';
						cus".$GLOBALS['TABORDER'].".focus();
						XXX
						return false;
					}";
			}
			
				if(isset($GLOBALS['tpl-add'])){
					$VALIDATION = str_replace("XXX", "colAll(); jQuery('.stepblock5').collapse('show');", $VALIDATION);
				}else{
					$VALIDATION = str_replace("XXX", "", $VALIDATION);
				}
			
			}
			
			
			if($field['key'] == "country"){
						 		 
				$STRING .= sprintf( '<select class="form-control" name="custom['.$field['key'].']" id="reg_field_'.$field['key'].'">', "" );
                foreach ($GLOBALS['core_country_list'] as $key=>$option) {				 				
                	$STRING .= sprintf( '<option value="%1$s"%3$s>%2$s</option>', trim( $key  ), $option, selected( $value, $key, false ) );
                }
                $STRING .= '</select>';
				
			}elseif($field['key'] == "state"){
				
				// SELECT AND STRING				
                $selected = isset( $_GET['custom']['state'] ) ? $_GET['custom']['state'] : '';				 
				
					$STRING .= sprintf( '<select class="form-control" name="custom['.trim($field['key']).']" id="reg_field_'.trim($field['key']).'">', "" );
					foreach ($GLOBALS['core_country_list'] as $key=>$option) {				 				
						$STRING .= sprintf( '<option value="%1$s" disabled id="'.$key.'_key">%2$s</option>', trim( $key  ), $option);
					 
						if(isset($GLOBALS['core_state_list'][$key])){						
							$state_list = explode("|",$GLOBALS['core_state_list'][$key]);						 
							foreach($state_list as $state){							
									$STRING .= sprintf( '<option value="%1$s"%3$s>-- %2$s</option>', trim( $state  ), $state, selected( $value, $state, false ) );
							} // end foreach					
						}// end if			
					} // end foreach
                	$STRING .= '</select>';
                	$STRING .=  '<script> jQuery(\'#core_country_dropdown1\').change(function() { jQuery(\'#core_state_dropdown1\').val(this.value); } ); </script>';	
			
			}else{
			 
			// SWITCH TYPES
			switch($field['fieldtype']){ 
			
			case "input": { 	
			
			if($field['key'] == "price"){
			
				$STRING .='<div class="input-group date col-md-4">
				<input type="text" name="custom['.$field['key'].']" value="'.$value.'"  tabindex="'.$GLOBALS['TABORDER'].'" id="reg_field_'.$field['key'].'" class="form-control" />
				<span class="input-group-addon">'.$GLOBALS['CORE_THEME']['currency']['symbol'].'</span>
			  </div> <div class="clearfix"></div> ';
			  
			  $STRING .= "<script>jQuery('#reg_field_".$field['name']."').change(function(e) { 
			  if(!isNaN(jQuery('#reg_field_".$field['name']."').val())){ }else{ jQuery('#reg_field_".$field['name']."').val(''); } }); </script>";
			  
			}else{
			$STRING .='<input type="text" name="custom['.$field['key'].']" value="'.$value.'" id="reg_field_'.$field['key'].'" tabindex="'.$GLOBALS['TABORDER'].'" class="form-control" />';	
			}
			  
						
			} break;
			case "textarea": { 
				$STRING .= '<textarea name="custom['.$field['key'].']" class="form-control" id="reg_field_'.$field['key'].'" tabindex="'.$GLOBALS['TABORDER'].'">'.$value.'</textarea>';
			} break;

			case "select": {
			
			 			
			 $options = explode( PHP_EOL, $field['values'] );			 
			 $STRING .= '<select name="custom['.$field['key'].']" class="form-control" tabindex="'.$GLOBALS['TABORDER'].'" id="reg_field_'.$field['key'].'">';					
				foreach($options as $val){
					
					$val = trim($val);
					
					if($value == $val){
							$STRING .= '<option value="'.$val.'" selected=selected>'.$val.'</option>';
					}else{
							$STRING .= '<option value="'.$val.'">'.$val.'</option>';
					}
				}// end foreach
			$STRING .= '</select>';
			} break;
			case "date": {
			 $db = explode(" ",$value);
			 
			 if(is_admin()){
			 $calbtnclass = "dashicons dashicons-calendar";
			 }else{
			 $calbtnclass = "glyphicon glyphicon-calendar";
			 }
			 
			$STRING .= '<script>jQuery(function(){ jQuery(\'#reg_field_'.$field['key'].'_date\').datetimepicker(); }); </script>
			
			 <div class="input-group date col-md-6" id="reg_field_'.$field['key'].'_date" data-date="'.$db[0].'" data-date-format="yyyy-MM-dd hh:mm:ss">
			<span class="add-on input-group-addon"><i class="'.$calbtnclass.'"></i></span>
				<input type="text" class="form-control" name="custom['.$field['key'].']" value="'.$value.'" id="reg_field_'.$field['key'].'" tabindex="'.$GLOBALS['TABORDER'].'" data-format="yyyy-MM-dd hh:mm:ss" />
				
			  </div>
			<div class="clearfix"></div>';	
			
			} break;			
			case "taxonomy": {
			 
		 
			 	// FORMAT VALUES SO WE CAN CHECK IF THEY ARE SELECTED
				if(is_array($value)){
				$selected_array = array();
				foreach($value as $vv){ $selected_array[] = $vv->term_id; }
				}
				
			 	// START BUILDING THE LIST 
				 
				$terms = get_terms($field['taxonomy'],"orderby=count&order=desc&get=all");
			 
				$selec = (isset( $_GET['pr'] )) ? $_GET['pr'] : '';		 
				$count = count($terms);	
				if($count > 0){		 
						 
					// ADD ON CODE FOR LINKAGE
					$ex = ""; $taxlink = false;
					if(isset($field['taxonomy_link']) && strlen($field['taxonomy_link']) > 2 && $field['taxonomy_link'] != "store"){
						$taxlink = true;
						if(isset($GLOBALS['tpl-add'])){
						$canAdd = 1;
						}else{
						$canAdd = 0;
						}
						$ex = "onChange=\"ChangeSearchValues('".str_replace("http://","",get_home_url())."',this.value,'".$field['taxonomy_link']."__".$field['taxonomy']."','tx_".$field['taxonomy_link']."[]','-1','".$canAdd."','reg_field_tax_".$field['taxonomy_link']."')\"";
					}
						 
					$STRING .= '<select name="tax['.$field['taxonomy'].']" class="form-control" tabindex="'.$GLOBALS['TABORDER'].'" id="reg_field_tax_'.$field['taxonomy'].'" '.$ex.'>';
					
					$STRING .="<option value=''></option>";
					 
					
					// COUNT TERMS AND					
					foreach ( $terms as $term ) {					
						
						// SETUP VALUE FOR LISTBOX
						if($taxlink){ $tvg = $term->term_id;  }else{ $tvg = $term->term_id; }
						
						// SETUP SELECTED VALUE						
					 	if(is_array($selected_array) && in_array($term->term_id,$selected_array)){ $a = "selected=selected"; }else{ $a= ""; }						
						
						// SPACING
						if($term->parent == 0){ $spp = ""; }else{ $spp = "&nbsp;&nbsp;&nbsp;"; }
						
						// OUTPUT
						$STRING .="<option value='".$tvg."' ".$a.">" . $spp . $term->name . " (".$term->count.") </option>";
						
						// GET INNER CHILD ITEMS
						/*
						$terms_inner = get_terms($field['taxonomy'],'hide_empty=0&child_of='.$term->term_id);
						if(count($terms_inner) > 0){						
						
							foreach ( $terms_inner as $term_inn ) {
							
								// SETUP VALUE FOR LISTBOX
								if($taxlink){ $tvg1 = $term_inn->term_id; }else{ $tvg1 = $term_inn->term_id; }
								
								// SETUP SELECTED VALUE
								if(is_array($selected_array) && in_array($tvg1,$selected_array)){ $b = "selected=selected"; }else{ $b= ""; }
								
								$STRING .= "<option value='".$tvg1."' ".$b."> -- " . $term_inn->name . " (".$term_inn->count.") </option>";
							}
						} 		
						*/		 		   
													   				
					 }
					 
					 
					$STRING .= '</select>';
				}
				
			} break;					
			case "checkbox": { 
			 $options = explode( PHP_EOL, $field['values'] ); $bb ="";
			 	
				$hasSetValue = false;
				foreach($options as $val){ $val = trim($val);				 		
					if((is_array($value) && in_array($val,$value)) || $value == $val ){
							$bb = 'checked=checked';
							$hasSetValue = true;
					}else{
							$bb = '';
					}
					$STRING .= '<label class="checkbox"> <input type="checkbox" 
					'.$bb.' name="custom['.$field['key'].'][]" class="reg_form_'.$field['key'].'" value="'.$val.'" tabindex="'.$GLOBALS['TABORDER'].'" />'.$val.'</label>';
				}// end foreach
				// THIS EXTRA VALUE WAS ADDED SO THAT THE FORM DATA WILL COMPLETE WITHOUT ANY VALUES CHECKED
				// OTHERWISE IT WOULD NOT SAVE
				$STRING .= '<input type="hidden"  name="custom['.$field['key'].'][]"  value="--" />';
				
				if(isset($field['required']) && $field['required'] == "yes"){
				
					// FORM NAME
					if(isset($GLOBALS['flag-myaccount'])){ $formname = "#myaccountdataform"; }else{ $formname = "form"; }
					
					
					$STRING .= "<script>
					 jQuery(document).ready(function(){ 
					 ";
					 
					 
					if(!isset($_GET['eid'])){  if(!$hasSetValue){ 
					$STRING .= " jQuery('".$formname." .btn-primary').attr('disabled', true); ";
					} }
					 
					$STRING .= " jQuery('".$formname." .reg_form_".$field['key']."').on('change', function (e) {
					
						isChecked = false; 						
						jQuery('".$formname." .reg_form_".$field['key']."').each(function(){				 
							 
							if(jQuery(this).is(\":checked\")){
								isChecked = true;							
							}													
						});
						
						if(isChecked){
						jQuery('".$formname." .btn-primary').attr('disabled', false);
						}else{
						jQuery('".$formname." .btn-primary').attr('disabled', true);
						}
						"; 
						
					$STRING .= "}); });</script>";
					
				}
				
			} break;			
			case "radio": { 
			 $options = explode( PHP_EOL, $field['values'] ); $bb =""; $rc = 0;
				foreach($options as $val){		$val = trim($val);		 		
					if( $value == $val || ( $value =="" && $rc==0 ) ){
							$bb = 'checked=checked';
					}else{
							$bb = '';
					}
					$STRING .= '<label class="radio"><input type="radio" 
					'.$bb.' name="custom['.$field['key'].']" id="reg_form_'.$field['key'].'" value="'.$val.'" tabindex="'.$GLOBALS['TABORDER'].'" />'.$val.'</label>';
					$rc++;
				}// end foreach			
			} break;	
			
			} // end if is country/state					
			
			}	
			$GLOBALS['TABORDER']++;
			
			if(isset($field['help']) && strlen($field['help']) > 1 && !is_admin()){
			$STRING .= "<p class='description'>".$field['help']."</p>";
			}
			
			
			
			if(is_admin()){			
				$STRING .= '</td></tr>';			
			}else{
				$STRING .= '</div></div>';	
			}
			
			
		}	// end foreach	
	}// end if
	
	if(isset($GLOBALS['CORE_THEME']['visitor_password']) && $GLOBALS['CORE_THEME']['visitor_password'] == '1' && !isset($GLOBALS['tpl-add']) && !isset($GLOBALS['flag-myaccount']) ){
	
	$VALIDATION .= "var pass1 = document.getElementById(\"pass1\"); var pass2 = document.getElementById(\"pass2\");
					if(pass1.value == ''){
						alert('".$CORE->_e(array('validate','0'))."');
						pass1.style.border = 'thin solid red';
						pass1.focus();
						return false;
					}
					if(pass2.value == ''){
						alert('".$CORE->_e(array('validate','0'))."');
						pass2.style.border = 'thin solid red';
						pass2.focus();
						return false;
					}
					if(pass2.value != pass1.value){
						alert('".$CORE->_e(array('validate','0'))."');
						pass1.style.border = 'thin solid red';
						pass2.style.border = 'thin solid red';
						pass2.focus();
						return false;
					}
					";
					
					// ADD ON MEMBERSHIP REQUIRMENT
					//if($GLOBALS['CORE_THEME']['show_mem_registraion'] == '1'){
					//	$VALIDATION .= "var mem = document.getElementById(\"membershipID\");
					//	if(mem.value == ''){
					//		alert('".$CORE->_e(array('validate','31'))."');							
					//		return false;
					//	}";					
					//}
	}
 
	
	$VALIDATION .= ' }</script>';
	
	if(is_admin()){
	$STRING = str_replace("custom[","wlt_field[",$STRING);
	}
 	
	return $STRING.$VALIDATION;

}   
/* =============================================================================
	SCHEMA DATA
========================================================================== */
function ITEMSCOPE($type = "", $val = ""){
	
	if(!isset($GLOBALS['noschema']) && isset($GLOBALS['CORE_THEME']['itemscope']) && $GLOBALS['CORE_THEME']['itemscope'] == '1'){
		
			switch($type){
				
				case "webpage": {
				
				return 'itemscope itemtype="http://schema.org/WebPage"';
				
				} break;
				
				case "itemprop": {
				
				return "itemprop='".$val."'";
				
				} break;				
			
				case "itemtype": {
				
					if(defined('WLT_CART') || defined('WLT_AUCTION') || defined('WLT_AUCTION') ){
					
					return 'itemscope itemtype="http://schema.org/Product"';
					
					}else{
				
					return 'itemscope itemtype="http://schema.org/LocalBusiness"';
					
					}
					
				} break;
			
			}// end switch
	}// end if		
}

/* =============================================================================
	  LOGIN FUNCTION 
	========================================================================== */
	
function LOGIN() {
 
	if(!isset($_GET["action"])){ $_GET["action"] =""; }
	 if(get_option('users_can_register') == 1){ $GLOBALS['nosidebar-right'] = true; $GLOBALS['nosidebar-left'] = true; }
	switch($_GET["action"]) {
			case 'lostpassword' :
			case 'retrievepassword' :
				$GLOBALS['flag-password'] = true;
				$this->_show_password(); 
				break;
			case 'register': {
				$GLOBALS['flag-register'] = true;			
				$this->_show_register();
			} break;
			case 'resetpass':
			case 'rp': {
				$GLOBALS['flag-resetpassword'] = true;
				$this->_show_resetpass();
			} break;
			case 'login':
			default: {
				$GLOBALS['flag-login'] = true;			
				$this->_show_login();				
			} break;
	}
	die();
} // END LOGIN	

function _show_resetpass(){

global $CORE, $wp_error; $string = ""; 

	$user = check_password_reset_key($_GET['key'], $_GET['login']);

	if ( is_wp_error($user) ) {
		wp_redirect( site_url('wp-login.php?action=lostpassword&amp;error=invalidkey') );
		exit;
	}

	$errors = new WP_Error();

	if ( isset($_POST['pass1']) && $_POST['pass1'] != $_POST['pass2'] )
		$errors->add( 'password_reset_mismatch', 'The passwords do not match.'  );

	do_action( 'validate_password_reset', $errors, $user );

	if ( ( ! $errors->get_error_code() ) && isset( $_POST['pass1'] ) && !empty( $_POST['pass1'] ) ) {
		reset_password($user, $_POST['pass1']);
		wp_redirect( site_url('wp-login.php?action=login') );
		exit;
	}

	wp_enqueue_script('utils');
	wp_enqueue_script('user-profile');
	
	// CHECK FOR ERRORS		
	if(isset($_POST['pass1'])){
	$string .= $this->_show_errors($errors);
	} 
	
	// LOAD IN PAGE TEMPLATE
	get_template_part( 'page', 'reset' );
 
}

function _show_password(){ global $CORE, $errortext;

	if ( isset($_POST['user_login']) && $_POST['user_login'] ) {
 
		$errors = new WP_Error();
		$errors = retrieve_password();
		 
		// ADD LOG ENTRY AND REDIRECT USER
		if ( !is_wp_error($errors) ) {
			$CORE->ADDLOG("<a href='(ulink)'>".$_POST['user_login'].'</a> forgot their password.', '','','label-inverse');		
			wp_redirect('wp-login.php?checkemail=confirm');
			exit();
		}
		
		do_action('lostpassword_post');
		
	}
	
	// CHECK FOR ERRORS
	if ( $_GET['error'] == 'invalidkey'   ){
		$errors = new WP_Error();
		$errors->add('invalidkey', $CORE->_e(array('login','_zz6')),'cp');
		$errors->add('registermsg', $CORE->_e(array('login','_zz5')), 'message');
	}
 
	if(!isset($_POST['user_login'])){ $_POST['user_login']=""; }
	
	if(!isset($errors)){ $errors=""; }
 
	if(isset($_POST['user_login'])){ $errortext = $this->_show_errors($errors); }	
	
	// LOAD IN PAGE TEMPLATE
	get_template_part( 'page', 'forgottenpassword' );

} 

function USER_LOGIN($user, $pass){ global $CORE, $errortext;


		$creds = array();
		$creds['user_login'] 	= $user;
		$creds['user_password'] = $pass;
		$creds['remember'] 		= true;
 
		$user = wp_signon('', $secure_cookie);
 
		// SEE IF LOGIN WAS SUCCESSFULL
		if ( !is_wp_error($user) ) {
		
			// UPDATE LAST LOGINS
			update_user_meta($user->ID, 'login_lastdate', current_time( 'mysql' ));
			
			// LOGIN IP
			update_user_meta($user->ID, 'login_ip', $this->get_client_ip());
			
			// UPDATE LOGIN COUNT
			$ll = get_user_meta($user->ID, 'login_count', true);
			if($ll == ""){ $ll = 1; }else{ $ll++; }
			update_user_meta($user->ID, 'login_count', $ll);
			
			// CLEAN-UP FAVS LIST
			$extn = "_list";
			if(defined('WP_ALLOW_MULTISITE')){
				$extn .= get_current_blog_id();
			}	
			$my_list = get_user_meta($user->ID, 'favorite'.$extn,true);
		 
			if(!is_array($my_list)){ $my_list = array(); }
			foreach($my_list as $hk => $hh){ if($hh == 0 || $hh == ""){ unset($my_list[$hk]); }elseif ( get_post_status ( $hh ) != 'publish'  && get_post_type( $hh ) != THEME_TAXONOMY."_type" ) {  unset($my_list[$hk]); } }			  
			update_user_meta($user->ID, 'favorite'.$extn, $my_list);			
			
		    // ADMIN LINK
			$admin_link =  admin_url();
			
			// REDIRECT USER TO ACCOUNT PAGE
			if(isset($_POST['redirect_to']) && strlen($_POST['redirect_to']) > 1 ){
								
				$redirect_to 		= $_POST['redirect_to'];
				
			}elseif(user_can($user->ID, 'administrator') || user_can($user->ID, 'contributor') || ( defined('WLT_DEMOMODE') && $_POST['log'] == "admindemo" ) ){	
			
				if(user_can($user->ID, 'administrator')){
				$redirect_to = $admin_link."admin.php?page=premiumpress";
				}else{
				$redirect_to = $admin_link."";
				}
					 
				 
			}else{			
				$redirect_to 		= $GLOBALS['CORE_THEME']['links']['myaccount'];
			}
			 
			if($redirect_to == ""){ $redirect_to = get_home_url(); }
			
			// ADD LOG ENTRY
			$CORE->ADDLOG("<a href='(ulink)'>".$user->data->user_nicename.'</a> logged into their account.', $user->data->ID,'','label-inverse');
			
			// SEND EMAIL ALERT
			$CORE->SENDEMAILALERT("wlt_alert_login_success");
			
			header("location: ".$redirect_to);
			exit();
			
		}else{ 
			// SEND EMAIL ALERT
			$CORE->SENDEMAILALERT("wlt_alert_login_failed");
			
			return $user;
		}
		
}
function USER_REGISTER($user, $pass, $email, $autosignin = 0, $redirectout = 1, $redirecturl = ""){

	global $CORE, $wpdb;
	
	// REGISTER THE NEW USER			 
	$errors = wp_create_user( $user, $pass, $email ); 
 	
	// CHECK FOR ERRORS	 
	if ( is_wp_error($errors) ) {
	
		return $errors;
	
	}else{
			 
				// REGISTER ANY NEW CUSTOM REGISTRATION FIELDS
				if(isset($_POST['custom'])){ 
					foreach($_POST['custom'] as $key=>$val){
						if(!is_array($val)){
						add_user_meta( $errors, $key, esc_html(strip_tags($val)), true);
						}else{
						add_user_meta( $errors, $key, esc_html($val), true);
						}
						
						// ADDITIONAL FOR CORE FIELDS
						if($key == "first_name"){
						$data = array();
						$data['ID'] 			= $errors;
						$data['first_name'] 	= esc_html(strip_tags($val));						 	
						wp_update_user( $data );
						}
						
						if($key == "last_name"){
						$data = array();
						$data['ID'] 			= $errors;
						$data['last_name'] 	= esc_html(strip_tags($val));						 	
						wp_update_user( $data );
						}
						
					} 
				}
				
				// CHECK FOR MEMBERSHIP
				if(isset($_POST['membershipID']) && is_numeric($_POST['membershipID']) ){
				
				
					// IF THIS MEMBERSHIP IS FREE SET IT NOT OTHERWISE SET A TEMP VALUE
					$membershipfields = get_option("membershipfields"); 
					
					if(isset($membershipfields[$_POST['membershipID']]['price']) && $membershipfields[$_POST['membershipID']]['price'] == "0"){
					
						update_user_meta( $errors, 'wlt_membership', $_POST['membershipID'] );
					
						if($membershipfields[$_POST['membershipID']]['expires'] == ""){ 
						$expire_days = 30;  
						}else{ 
						$expire_days = $membershipfields[$_POST['membershipID']]['expires']; 
						}
			
						update_user_meta($errors, 'wlt_membership_expires', date("Y-m-d H:i:s", strtotime(current_time( 'mysql' ) . " +".$expire_days." days")) );	
					
					}else{
					add_user_meta( $errors, "new_memID", $_POST['membershipID']);
					}
				}
				
				$_POST['username'] = $user;
				$_POST['user_login'] = $user;
				// SEND WELCOME EMAIL
				global $CORE;
				$CORE->SENDEMAIL($errors,'welcome');
				$CORE->SENDEMAIL('admin','admin_welcome');								
				// SEND THE NEW USER THEIR LOGIN DETAILS
				if($GLOBALS['CORE_THEME']['wordpress_welcomeemail'] == '1'){
				wp_new_user_notification( $errors, $pass );	
				}
				// ADD LOG ENTRY
				$CORE->ADDLOG("<a href='(ulink)'>".$user.'</a> joined your website. ['.$email.']', $errors,'','label-inverse');				

				// AUTO LOGIN NEW USER IF THEY SETUP A PASSWORD
				if($autosignin == 1){	
					$creds = array();
					$creds['user_login'] 	= $user;
					$creds['user_password'] = $pass;
					$creds['remember'] 		= true;
					$user = wp_signon( $creds, false );
				}
				
				// SEND EMAIL ALERT
				$CORE->SENDEMAILALERT("wlt_alert_register");
				
				
			// REDIRECT USER TO ACCOUNT PAGE	
			if($redirectout == 1){
				if($redirecturl != ""){	
							
				 	$redirect_to 		= $redirecturl;
					
				}elseif(isset($_POST['redirect_to']) ){					
					 
						$redirect_to 		= $_POST['redirect_to'];	
										
				}else{
						$redirect_to = site_url('wp-login.php?fr=1', 'login_post'); // NEW ACCOUNTS
				}	
							 
				header("location: ".$redirect_to);
				exit();
			}
				
		}
				
	
}

function _show_register(){

	global $CORE, $errortext; $user_login = ''; $user_email = ''; 

 	// CHECK IF REGISTRATION IS ENABLED
	if ( !get_option('users_can_register') && !defined('WLT_DEMOMODE') ) {
		wp_redirect(get_bloginfo('wpurl').'/wp-login.php?registration=disabled');
		exit();
	}
	
	// LOAD IN ERRORS
	$errors = new WP_Error(); 
 
	// PERFORM ACTION AFTER USER SUBMISSION
	if ( isset($_POST['user_login']) && strlen($_POST['user_login']) > 1 && empty($errors->errors) ) { 
		
		// INCLUDE REGISTRATION FUNCTIONALITY
		require_once( ABSPATH . WPINC . '/registration.php');	
		
		// CLEAN UP USER INPUT
		$sanitized_user_login = sanitize_user( $_POST['user_login'] );
		$user_email = apply_filters( 'user_registration_email', $_POST['user_email'] );
 
		// BASIC FORM VALIDATION
		if( $GLOBALS['CORE_THEME']['register_securitycode'] == 1 && ( $_POST['reg1'] + $_POST['reg2'] ) != $_POST['reg_val'] ){		
		$errors->add('registered', $CORE->_e(array('login','21')), 'error');		
		}	 	 
		
		// CHECK FOR PLUGIN ERRORS
		$errors = apply_filters( 'registration_errors', $errors, $sanitized_user_login, $user_email );
		
		// CONTINUE ONTO STEP 1
		if ( $errors->get_error_code() ) {
		
		}else{
					 
			// GENERATE PASSWORD
			if($GLOBALS['CORE_THEME']['visitor_password'] == '1' && $_POST['pass2'] !=""){			
				$_POST['password'] = strip_tags($_POST['pass2']);			
			}else{
				$random_password = wp_generate_password( $length=12, $include_standard_special_chars=false );
				$_POST['password'] = $random_password;	
			}
			
			// CREATE NEW USER
			$errors = $this->USER_REGISTER($sanitized_user_login, $_POST['password'], $user_email, $GLOBALS['CORE_THEME']['visitor_password']);	
			 
		} // END ERROR CHECK 1	
		
			
	}// END PERFORM ACTION

	// CHECK FOR ERRORS 
	if(isset($sanitized_user_login)){
	$errortext = $this->_show_errors($errors);
	}
	
	// LOAD IN PAGE TEMPLATE
	get_template_part( 'page', 'register' );

}
function _show_login() {

	global $CORE, $errortext;  $errors = new WP_Error();
	
	if	( isset($_GET['fr']) && ( isset($GLOBALS['CORE_THEME']['visitor_password']) && $GLOBALS['CORE_THEME']['visitor_password'] == '1' ) ){
		$errors->add('loggedout', $CORE->_e(array('login','_zz11')), 'message'); 
	}elseif(isset($_GET['fr'])){	
		$errors->add('loggedout', $CORE->_e(array('login','_zz9')), 'message'); 
	}

	// PERFORM LOGIN CHECKS // ACCESS DETAILS
	if(isset($_GET['noaccess'])){
	$errors->add('loggedout', $CORE->_e(array('validate','30')), 'message');
	}elseif(isset($_GET['socialloginerror'])){
	$errors->add('loggedout', $CORE->_e(array('validate','31')), 'message');
	}elseif	( isset($_GET['loggedout']) && TRUE == $_GET['loggedout'] )	
	$errors->add('loggedout', $CORE->_e(array('login','_zz7') ), 'message');
	elseif	( isset($_GET['registration']) && 'disabled' == $_GET['registration'] )	
	$errors->add('registerdisabled',  "".$CORE->_e(array('login','_zz8')));
	elseif	( isset($_GET['checkemail']) && 'confirm' == $_GET['checkemail'] )	
	$errors->add('confirm', $CORE->_e(array('login','_zz9')), 'message');
	elseif	( isset($_GET['checkemail']) && 'newpass' == $_GET['checkemail'] )	
	$errors->add('newpass',  $CORE->_e(array('login','_zz10')), 'message');
	elseif	( isset($_GET['checkemail']) && 'registered' == $_GET['checkemail'] )	
	$errors->add('registered', $CORE->_e(array('login','_zz11')), 'message'); 
	
	// CHECK FOR PLUGIN ERRORS 
	if(isset($_POST['log']) && strlen($_POST['log']) > 1 ){
		$plugin_error = apply_filters('login_errors','');
		 if(strlen($plugin_error) > 5){
			$errors->add('registered', $plugin_error, 'error');
		 }
	}
	 
 	// CHECK FOR BASIC ERRORS AND THAT THE FORUM HAS BEEN PRESSED
	if ( empty($errors->errors) && isset($_POST['log'])  ) {
 
 		// CHECK FOR SECURE LOGINS
		if ( is_ssl() && force_ssl_login() && !force_ssl_admin() 
		&& ( 0 !== strpos($redirect_to, 'https') ) && ( 0 === strpos($redirect_to, 'http') ) ){
			$secure_cookie = false;
		}else{
			$secure_cookie = '';
		}
		
		// LOGIN USER
		$errors = $this->USER_LOGIN($_POST['log'], $_POST['pwd']);		
 
	
	} // end basic validation		

	// CHECK FOR ERRORS	
	$errortext = $this->_show_errors($errors);
	
	// LOAD IN REGISTER PAGE TEMPLATE
	get_template_part( 'page', 'login' );
	
}
function _show_errors($wp_error) {

	global $error, $CORE;
	
	if ( !empty( $error ) ) {
		$wp_error->add('error', $error);
		unset($error);
	}

	if ( !empty($wp_error) ) {
		if ( $wp_error->get_error_code() ) {
			$errors = '';
			$messages = '';
			
			foreach ( $wp_error->get_error_codes() as $code ) {			
			
				$severity = $wp_error->get_error_data($code);
				
				
				if($code == "incorrect_password" || $code == "invalid_username"){
					return $CORE->_e(array('login','33'));
				}else{
						// disable default WP error message
					foreach ( $wp_error->get_error_messages($code) as $error ) {
						if ( 'message' == $severity )

							$messages .= $error ;
						else
							$errors .= $error;
					}
				}
			}
			if ( !empty($errors) )
				//echo $COREDesign->GL_ALERT( $errors ,"error");
				return $errors;
			if ( !empty($messages) ) 	
				//echo $COREDesign->GL_ALERT( $messages ,"success");
				return $messages;
		}
	}
}

/* ========================================================================
 CORE BODY CSS TAGS
========================================================================== */ 
function BODYCLASS($classes){

	global $wpdb, $post, $pagenow; $c = ""; $extra = "";
	 
	// CHECK FOR A BASE THEME FOR CHILD THEME STYES
	$base_theme = get_option('wlt_base_theme');
	if($base_theme == ""){ update_option('wlt_base_theme',$GLOBALS['CORE_THEME']['template']); }
	
	// ADDON NEW CLASS
	if(defined('CHILD_THEME_NAME') || defined('WLT_DEMOMODE') ){
	$classes[] = "wlt_".str_replace("template_","",$base_theme);
	$classes[] = "core_".str_replace("template_","",$base_theme);
	}else{
	$classes[] = "core_".str_replace("template_","",$base_theme);
	}
	if($pagenow == "wp-login.php"){
	 $GLOBALS['nosidebar-right'] = true; $GLOBALS['nosidebar-left'] = true;
	$classes[] = "wlt_login";
	}
	// NOT HOME PAGE
	if(!isset($GLOBALS['flag-home'])){
	$classes[] = "innerpage";
	}
	
	if(defined('IS_MOBILEVIEW')){
	$classes[] = "wlt_mobileweb";
	}
	
	//WIDTH LAYOUTS
	if(isset($GLOBALS['CORE_THEME']['layout_layoutwidth']) && $GLOBALS['CORE_THEME']['layout_layoutwidth'] == 1){
	$classes[] = "wlt_fullwidth";
	}
	
	return $classes;	
}
/* ========================================================================
 CORE BODY COLUMN LAYOUTS
========================================================================== */ 
function BODYCOLUMNS(){ global $post;

 	$c = "";
	// DETERMINE CURRENT PAGE TYPE
	if(is_search()){ $c = 'search'; 
	}elseif(is_archive()){ $c = 'search'; 
	}elseif(is_home() || is_front_page()){ $c = 'homepage'; 
	}elseif(is_single()){ 
	
	if($post->post_type == "post"){  $c = 'page'; }else{ $c = 'single'; }
	
	}else{ $c = 'page'; }
	
 
	// GET WEBSITE COLUMN LAYOUTS
	if($c != "" && isset($GLOBALS['CORE_THEME']['layout_columns'][$c])){
			switch($GLOBALS['CORE_THEME']['layout_columns'][$c]){			
				case "1": { $GLOBALS['nosidebar-left'] =1; } break;
				case "2": { $GLOBALS['nosidebar-right'] =1; } break;
				case "4": {  } break;
				case "3": 
				default: { $GLOBALS['nosidebar-right'] =1; $GLOBALS['nosidebar-left'] =1; }
			}
	} 
 
	// GET THE WIDTHS FOR INNER CONTENT
	if($c != "" && isset($GLOBALS['CORE_THEME']['layout_columns'][$c."_2columns"]) && $GLOBALS['CORE_THEME']['layout_columns'][$c] != 4 ){
			switch($GLOBALS['CORE_THEME']['layout_columns'][$c."_2columns"]){		
				
				case "1": { $GLOBALS['CORE_THEME']['layout_columns']['2columns'] = 1; } break;
				case "2": { $GLOBALS['CORE_THEME']['layout_columns']['2columns'] = 2; } break;
				default: { $GLOBALS['CORE_THEME']['layout_columns']['2columns'] = 0; }
			}
	} 
	
	// GET THE WIDTHS FOR INNER CONTENT
	if($c != "" && isset($GLOBALS['CORE_THEME']['layout_columns'][$c."_3columns"]) && $GLOBALS['CORE_THEME']['layout_columns'][$c] == 4){
			switch($GLOBALS['CORE_THEME']['layout_columns'][$c."_3columns"]){		
				
				case "1": { $GLOBALS['CORE_THEME']['layout_columns']['3columns'] = 1;  } break;
				 
				default: { $GLOBALS['CORE_THEME']['layout_columns']['3columns'] = 0; }
			}
	} 
	
	// FIX FOR 8.4 HOME PAGES AND CHILD THEME TEMPLATES
	if(defined('WLT_DEMOMODE') && $c == "homepage"){
	 $GLOBALS['nosidebar-right'] =1; $GLOBALS['nosidebar-left'] =1; 
	}	

}
/* ========================================================================
 CORE LAYOUT CSS TAGS
========================================================================== */
function CSS($tag,$return=false){

	global $wpdb, $userdata; $STRING = "";  
	
	
	 if($tag == "colnum"){
	
	if(isset($GLOBALS['CORE_THEME']['layout_columns']['3columns']) && $GLOBALS['CORE_THEME']['layout_columns']['3columns'] == "1"){
	$STRING .= 'wlt_main_3cols'; 
	}else{
	
		if(isset($GLOBALS['nosidebar-left'])){
		$STRING .= 'wlt_main_2colsright'; 
		}else{
		$STRING .= 'wlt_main_2colsleft'; 
		}	
	}
	
	
	}elseif($tag == "mode"){
	
	if(defined('WLT_DEMOMODE')){  $STRING .= ' demomode'; } 
		
		// DISABLE RESPONSIVE THEME
		if(isset($GLOBALS['CORE_THEME']['layout_layoutwidth']) && $GLOBALS['CORE_THEME']['layout_layoutwidth'] == 1){
		
		}else{
		$STRING .= ' container'; 
		}
	
	}elseif($tag == "container"){
	
		$STRING = "container"; // fallback		
		
		if(isset($GLOBALS['CORE_THEME']['layout_contentwidth']) && $GLOBALS['CORE_THEME']['layout_contentwidth'] == 1){
			
			$STRING = "container-fluid";			
		}		
		
	}elseif($tag == "2columns"){
	
	if(!isset($GLOBALS['nosidebar-left']) && isset($GLOBALS['CORE_THEME']['layout_columns']['2columns']) && $GLOBALS['CORE_THEME']['layout_columns']['2columns'] == "1"){
	$STRING = " twocolshort";
	}
	
	if($GLOBALS['CORE_THEME']['layout_layoutwidth'] == 1 && $GLOBALS['CORE_THEME']['layout_contentwidth'] == 0){
	$STRING .= " container widecontainer";	
	}else{
	$STRING .= " container-fluid";	
	}
		
	}elseif($tag == "columns-left"){	
		
		if( (isset($GLOBALS['nosidebar-right']) || isset($GLOBALS['nosidebar-left']) ) && isset($GLOBALS['CORE_THEME']['layout_columns']['2columns']) && $GLOBALS['CORE_THEME']['layout_columns']['2columns'] == "0"){
		$STRING = "col-md-4 col-sm-4";
		}else{
			if(isset($GLOBALS['CORE_THEME']['layout_columns']['3columns']) && $GLOBALS['CORE_THEME']['layout_columns']['3columns'] == "1"){			
			$STRING = "col-md-2 col-sm-2";
			}else{
			$GLOBALS['3COLUMNS_FLAG'] = true;
			$STRING = "col-md-3 col-sm-3";
			}
		}
		
	
	}elseif($tag == "columns-right"){
	
		if((isset($GLOBALS['nosidebar-right']) || isset($GLOBALS['nosidebar-left']) ) && isset($GLOBALS['CORE_THEME']['layout_columns']['2columns']) && $GLOBALS['CORE_THEME']['layout_columns']['2columns'] == "0"){
		$STRING = "col-md-4 col-sm-4";
		}else{
		
			if($GLOBALS['CORE_THEME']['layout_columns']['2columns'] == 2){
			$STRING = "col-md-300 col-sm-300";			
			}elseif(isset($GLOBALS['CORE_THEME']['layout_columns']['3columns']) && $GLOBALS['CORE_THEME']['layout_columns']['3columns'] == "1"){		
			$STRING = "col-md-2 col-sm-2";
			}else{
			$GLOBALS['3COLUMNS_FLAG'] = true;
			$STRING = "col-md-3 col-sm-3";
			}
		}
	
	}elseif($tag == "columns-middle"){
	
		if(isset($GLOBALS['nosidebar-left']) && isset($GLOBALS['nosidebar-right'])){
			$STRING = "col-md-12";
		}elseif(isset($GLOBALS['nosidebar-left']) || isset($GLOBALS['nosidebar-right'])){
		
			if(isset($GLOBALS['CORE_THEME']['layout_columns']['2columns']) && $GLOBALS['CORE_THEME']['layout_columns']['2columns'] == "0"){
				$STRING = "col-md-8 col-sm-8";
			
			}elseif($GLOBALS['CORE_THEME']['layout_columns']['2columns'] == 2){
			
			$STRING = "col-md-820 col-sm-820";			
			
			}else{
				$STRING = "col-md-9 col-sm-9";
			}
		}else{
		
			if(isset($GLOBALS['CORE_THEME']['layout_columns']['2columns']) && $GLOBALS['CORE_THEME']['layout_columns']['2columns'] == "0"){
			
				if($GLOBALS['CORE_THEME']['layout_columns']['3columns'] == "1"){				
				$STRING = "col-md-8 col-sm-8";
				}else{
				$STRING = "col-md-6 col-sm-6 wlt_3_columns";
				}

			}else{
				if($GLOBALS['CORE_THEME']['layout_columns']['3columns'] == "1"){				
				$STRING = "col-md-8 col-sm-8 wlt_3_columns";
				}else{
				$GLOBALS['3COLUMNS_FLAG'] = true;
				$STRING = "col-md-6 col-sm-6 wlt_3_columns";
				}
			}
			
		}
	
	}
	 
 	// RETURN
	if($return){return $STRING; }else{ echo $STRING; }
}
 
/* =============================================================================
   CORE LANGUAGE FILTER
   ========================================================================== */
function _e($text,$lang ="", $textdomain="premiumpress"){
	
	
	// GET KEY
	if(!isset($GLOBALS['_LANG']) || !is_array($GLOBALS['_LANG']) ){ return; }
	$lang = array_keys($GLOBALS['_LANG']);
	$lang = $lang[1];

	global $wpdb, $userdata; $ct = get_option("core_language"); $outtext = "";
	
	if(is_array($text)){
	
		if(isset($text[1])){
			  
			$outtext = (isset($ct[$lang][$text[0]][$text[1]]) && $ct[$lang][$text[0]][$text[1]] !="" ? $ct[$lang][$text[0]][$text[1]] : $GLOBALS['_LANG'][$lang][$text[0]][$text[1]] );		 
		
		}else{
		 
			$outtext = $GLOBALS['_LANG'][$lang][$text[0]];	
		}
	
	
	}else{ // if array
	
		$outtext = $text;
	}
	
	// ADJUST FOR DATING THEME
	if(defined('WLT_DATING')){
	$outtext = str_replace("listing"," profile",$outtext);
	$outtext = str_replace("Listing"," Profile",$outtext);
	$outtext = str_replace("items"," profiles",$outtext);
	}
	
	// ADD ON VISUAL EDITOR FOR ADMIN
    if( isset($GLOBALS['CORE_THEME']['admin_liveeditor']) && $GLOBALS['CORE_THEME']['admin_liveeditor'] == 1 && $text[0] != "validate" && current_user_can('administrator') ){ // $_GET['wlt_editor'] == 1 &&
	if(!isset($GLOBALS['editor_id_counter'])){ $GLOBALS['editor_id_counter'] = 0; }else{  $GLOBALS['editor_id_counter']++; }
		
		// RETURN IF NO EDITOR FLAG IS SET
		if(isset($text[2]) && $text[2] == "flag_noedit"){ return stripslashes($outtext); }
 		
		// FORMAT ITEMS
		$text[0] = str_replace("_","xxx",$text[0]);
		$text[1] = str_replace("_","xxx",$text[1]);
		
		return '<span href="#" id="'.$text[0].'_'.$text[1].'_'.$GLOBALS['editor_id_counter'].'" data-type="text" data-send="always" data-pk="19912" data-placement="right" data-title="Change Text" data-url="'.get_home_url().'/">		'.stripslashes(strip_tags($outtext)).'<i  class="glyphicon glyphicon-zoom-in wlt_runeditor" alt="'.$text[0].'_'.$text[1].'_'.$GLOBALS['editor_id_counter'].'" style="cursor: help;"></i></span>';
	 
	
	}else{
	
	if(is_array($outtext)){ return ""; }
	
	return stripslashes($outtext);
	}
}
function Language(){
 
	// CHECK AND RESET IF NOT SENT
	if(!isset($GLOBALS['CORE_THEME'])){
	$GLOBALS['CORE_THEME'] = get_option("core_admin_values");
 	}
	
  
if(!isset($GLOBALS['_LANG'])){
 
	if(!isset($GLOBALS['CORE_THEME']['language']) || $GLOBALS['CORE_THEME']['language'] ==""){ 
			
		define("THEME_LANG","language_english");
				
	}else{
		 
		if ( !isset($_SESSION['lang'] ) && !isset($_REQUEST['l']) ){
				
			// SAVE SESSON FOR LANG
			define("THEME_LANG",$GLOBALS['CORE_THEME']['language']);
			$_SESSION['lang'] = $GLOBALS['CORE_THEME']['language'];		
		
		}else{		
		 
			if (isset($_REQUEST['l'])){ 
				unset($_SESSION['lang']);
			}
			if (isset($_SESSION['lang']) && !isset($_REQUEST['l'])){
								
				$_REQUEST['l'] = $_SESSION['lang'];
				define('THEME_LANG',str_replace("language_language","language","language_".$_REQUEST['l'])); 
			
			}elseif (isset($_SESSION['lang'] ) && isset($_REQUEST['l'])){
			
				unset($_SESSION['lang']);
				$_SESSION['lang'] = $_REQUEST['l']; 
				define('THEME_LANG',str_replace("language_language","language","language_".$_REQUEST['l'])); 
				
			}else{	
			 
				if(file_exists(str_replace("functions/","",THEME_PATH) . "/templates/".$GLOBALS['CORE_THEME']['template']."/language_".strtolower(strip_tags($_REQUEST['l'])).'.php')){
										 
					$_SESSION['lang'] = $_REQUEST['l'];
					define('THEME_LANG',"language_".$_REQUEST['l']);
								 
					} else {
						define('THEME_LANG',$GLOBALS['CORE_THEME']['language']);
					}				
				}		
		}			
			 
	}
	
 

// CHECK IF WE HAVE A CUSTOM LANGUAGE FILE FOR THIS COUNTRY
if(!isset($GLOBALS['CORE_THEME']['geolanguage'])){ $GLOBALS['CORE_THEME']['geolanguage'] = 0; }
if(isset($_SESSION['mylocation']['lat']) && strlen($_SESSION['mylocation']['lat']) > 0 && strlen($_SESSION['mylocation']['log']) > 0 && isset($GLOBALS['CORE_THEME']['geolocation']) && $GLOBALS['CORE_THEME']['geolocation'] != "" && $GLOBALS['CORE_THEME']['geolanguage'] == 1){			
		 
	if(file_exists(THEME_PATH . "/framework/_language_".$_SESSION['mylocation']['country'].".php")){
 
		$ThisLanguage = "_language_".$_SESSION['mylocation']['country'];
		
	}
	

}else{

$ThisLanguage = THEME_LANG; 

}
 

	
	$ThisLanguage = str_replace("language__","_", $ThisLanguage);	
 
	// LOAD IN LANGUAGE FILE 
	if(defined('CUSTOM_LANGUAGE_FILE')){	
	
		require_once (CUSTOM_LANGUAGE_FILE);  
		$GLOBALS['_LANG'] = $LANG_;	 
		
	}elseif(substr($ThisLanguage,0,10) == "_language_" && file_exists(THEME_PATH . "/framework/".$ThisLanguage.'.php')){
	
 		require_once (THEME_PATH . "framework/".$ThisLanguage.'.php');  
		$GLOBALS['_LANG'] = $LANG_;	 
 	
	}elseif(isset($GLOBALS['CORE_THEME']['template']) && file_exists(THEME_PATH . "/templates/".$GLOBALS['CORE_THEME']['template']."/".$ThisLanguage.'.php') ){
	
		require_once (THEME_PATH . "/templates/".$GLOBALS['CORE_THEME']['template']."/".$ThisLanguage.'.php');
  
		$GLOBALS['_LANG'] = $LANG_;	 
			
	}else{
	
		// NOW LETS CHECK FOR A CUSTOM LANGUAGE FILE
		$wlt_languagefiles = get_option("wlt_languagefiles");
		if(!is_array($wlt_languagefiles)){ update_option("wlt_languagefiles", "", true); $wlt_languagefiles = array(); }
		
		 
		if(isset($GLOBALS['CORE_THEME']['language']) && is_numeric($GLOBALS['CORE_THEME']['language']) && !empty($wlt_languagefiles)){
			
			// CHECK IF FILE EXISTS
			if(file_exists($wlt_languagefiles[$GLOBALS['CORE_THEME']['language']]['path'])){
				require_once ($wlt_languagefiles[$GLOBALS['CORE_THEME']['language']]['path']);
			}else{
				// LOAD IN DEFAULT FRAMEWORK LANGUAGR FILE
				require_once (str_replace("//","/",THEME_PATH . "/framework/_language.php"));  	
			}
		
		}else{
		
			// LOAD IN DEFAULT FRAMEWORK LANGUAGR FILE
			require_once (str_replace("//","/",THEME_PATH . "/framework/_language.php"));  					
		}
		 	
		$GLOBALS['_LANG'] = $LANG_;	 
		
	}
	
	$GLOBALS['_LANG'] = hook_language_array($GLOBALS['_LANG']);
		
		
	} 	
}
/* =============================================================================
   BREADCRUMBS 
   ========================================================================== */		

function BREADCRUMBS($before = '', $after = '') {
 
 global $CORE, $post, $wp_query;
 
  $delimiter = ''; 
 
  $STRING = "";

    $homeLink = get_bloginfo('url');
    $STRING .= $before .' <a href="' . $homeLink . '" class="bchome">'.$CORE->_e(array('head','1')).'</a> ' . $delimiter . ' '. $after;
 	
	if ( is_category() ) {
 
      $cat_obj = $wp_query->get_queried_object();
      $thisCat = $cat_obj->term_id;
      $thisCat = get_category($thisCat);
      $parentCat = get_category($thisCat->parent);
	 
      if ($thisCat->parent != 0 && is_numeric($parentCat) ) $STRING .=(get_category_parents($parentCat, TRUE, ' ' . $delimiter . ' '));
	  
      $STRING .= $before . '<a href="'.$GLOBALS['CORE_THEME']['links']['blog'].'">'.$CORE->_e(array('button','55')).'</a> <a href="#"  >' . single_cat_title('', false) . '</a>' . $after;
 
    } elseif ( is_author() ) {
	
       global $author, $authorID;
      $userdata = get_userdata($author);
      $STRING .= $before . "<a href='#' rel='nofollow' >".get_the_author_meta( 'display_name', $authorID)."</a>" . $after;
 
 
    } elseif ( is_day() ) {
      $STRING .= '<a href="' . get_year_link(get_the_time('Y')) . '"  >' . get_the_time('Y') . '</a> ' . $delimiter . ' ';
      $STRING .= '<a href="' . get_month_link(get_the_time('Y'),get_the_time('m')) . '" >' . get_the_time('F') . '</a> ' . $delimiter . ' ';
      $STRING .= $before . get_the_time('d') . $after;
 
    } elseif ( is_month() ) {
      $STRING .= '<a href="' . get_year_link(get_the_time('Y')) . '" >' . get_the_time('Y') . '</a> ' . $delimiter . ' ';
      $STRING .= $before . get_the_time('F') . $after;
 
    } elseif ( is_year() ) {
      $STRING .= $before . get_the_time('Y') . $after;
 
    } elseif ( is_single() && !is_attachment() ) {
	
      if ( get_post_type() != 'post' ) {
	  // ADD IN FIRST CATEGORY TO THE BREADCRUMBS FOR USER TO RETURN TO
	    $term_list = wp_get_post_terms($post->ID, THEME_TAXONOMY, array("fields" => "all"));
		if(isset($term_list[0]->name)){
		 $STRING .=  $before ."<a href='".get_term_link($term_list[0]->slug, THEME_TAXONOMY)."' >".$term_list[0]->name.'</a> '.$after;
		}

        //$post_type = get_post_type_object(get_post_type());
       // $slug = $post_type->rewrite;
       // $STRING .=  $delimiter . ' ';
       // $STRING .= $before . get_the_title() . $after;
      } else {
	  
        $cat = get_the_category();
		if(!empty($cat)){
		$cat = $cat[0];
		
		$STRING .= $before .'<a href="'.$GLOBALS['CORE_THEME']['links']['blog'].'"  >'.$CORE->_e(array('button','55')).'</a>'. $after; 
		$STRING .= $before . "".str_replace("<a ","<a ",get_category_parents($cat, TRUE, ''))."". $after;
        $STRING .= $before . "<a href='#' rel='nofollow' >".get_the_title()."</a>" . $after;
		}
      }
 	
	} elseif (isset($_GET['s']) || isset($_GET['advanced_search']) ){
	
	$STRING .= $before . "<a href='#' rel='nofollow' >".$CORE->_e(array('gallerypage','0')) ."</a>" . $after;//$post_type->labels->singular_name
	
    } elseif ( !is_single() && !is_page() && get_post_type() != 'post' && !is_404() ) {
	
	// CHECK IF ITS A CATEGORY FOR OUR CUSTOM POST TYPE	
	$category = $wp_query->get_queried_object();
	 
	
	 if(isset($category->taxonomy) && $category->taxonomy != THEME_TAXONOMY){

	  if(isset($category->term_taxonomy_id)){
			 $pterm = get_term_by('id', $category->term_id, $category->taxonomy);
			 $gg1 = get_term_link($pterm->slug, $category->taxonomy);
			 if( !is_wp_error( $gg1 ) ) {
			  $STRING .= $before . "<a href='".$gg1."' >".str_replace("_"," ",str_replace("-"," ",$pterm->taxonomy)). "</a>". $before." <a href='".$gg1."' >".$pterm->name ."</a>" . $after;
			 }		 
		 }
	 
	 }elseif(isset($category->name)){
	 
	 
		 $gg = get_term_link($category);
			 
		 if( !is_wp_error( $gg ) ) {		 
		 // CHECK FOR PARENT CATEGORY
		 if($category->parent != "0"){
			 $pterm = get_term_by('id', $category->parent, $category->taxonomy);
			 $gg1 = get_term_link($pterm->slug, $category->taxonomy);
			 if( !is_wp_error( $gg1 ) ) {
				 // CHECK FOR PARENT CATEGORY
				 if($pterm->parent != "0"){
					 $pterm2 = get_term_by('id', $pterm->parent, $pterm->taxonomy);
					 $gg2 = get_term_link($pterm2->slug, $pterm2->taxonomy);
					 if( !is_wp_error( $gg2 ) ) {
					 	$STRING .= $before . "<a href='".$gg2."' >".$pterm2->name ."</a>" . $after;
					 }		 
				 }
			 
			  $STRING .= $before . "<a href='".$gg1."' >".$pterm->name ."</a>" . $after;
			 }		 
		 }		 
	 	 $STRING .= $before . "<a href='".$gg."' >".$category->name ."</a>" . $after;
		 }
	 }elseif(!isset($GLOBALS['flag-home'])){	
		 $post_type = get_post_type_object(get_post_type());
		 if(isset($post_type->labels->singular_name)){
		 $STRING .= $before ."<a href='#' >".$CORE->_e(array('add','13'))."</a>" . $after; //$post_type->labels->singular_name
		 }	  
	  }
 
    } elseif ( is_attachment() ) {
      $parent = get_post($post->post_parent);
      $cat = get_the_category($parent->ID); $cat = $cat[0];
	  
      //$STRING .= get_category_parents($cat, TRUE, ' ' . $delimiter . ' ');
      $STRING .= $before .'<a href="' . get_permalink($parent) . '" >' . $parent->post_title . '</a>'. $after;
	  
      $STRING .= $before . "<a href='#' >".get_the_title()."</a>" . $after;
 
    } elseif ( is_page() && !$post->post_parent ) {
      $STRING .= $before . "<a href='#' >".get_the_title()."</a>" . $after;
 
    } elseif ( is_page() && $post->post_parent ) {
      $parent_id  = $post->post_parent;
      $breadcrumbs = array();
      while ($parent_id) {
	  if(!is_object($parent_id)){
        $page = get_page($parent_id);
        $breadcrumbs[] = $before .'<a href="' . get_permalink($page->ID) . '">' . get_the_title($page->ID) . '</a>'. $after;
        $parent_id  = $page->post_parent;
		}
      }
      $breadcrumbs = array_reverse($breadcrumbs);
      foreach ($breadcrumbs as $crumb){
		  $STRING .= $crumb . ' ' . $delimiter . '';
	  }
      $STRING .= $before ."<a href='#' >" . get_the_title() . "</a>". $after;
 
    } elseif ( is_search() ) {
      $STRING .= $before . 'Search results for "' . get_search_query() . '"' . $after;
 
    } elseif ( is_tag() ) {
      $STRING .= $before . 'Posts tagged "' . single_tag_title('', false) . '"' . $after;
 

    } elseif ( is_404() ) {
      $STRING .= $before . "<a href='#' rel='nofollow' >".'Error 404'.'</a>' . $after;
    }else{
	
	}
 
    if ( get_query_var('paged') ) {
      if ( is_category() || is_day() || is_month() || is_year() || is_search() || is_tag() || is_author() ) $STRING .= '  ';
      $STRING .= $before . "<a href='#' >".$CORE->_e(array('button','27')) . ' ' . get_query_var('paged')."</a>". $after;
      if ( is_category() || is_day() || is_month() || is_year() || is_search() || is_tag() || is_author() ) $STRING .= ' ';
    }
  
  //}
  
  return $STRING;
}
/* ========================================================================
 PAGE NAVIGATION BUTTONS
========================================================================== */
function PAGENAV($return="") { global $wpdb, $wp_query; $return=""; $pages = "";
if (!is_single()) {
		
		$request = $wp_query->request;	 
		$posts_per_page = intval(get_query_var('posts_per_page'));
		 
		$paged = intval(get_query_var('paged'));
	
		$pagenavi_options['pages_text'] = $this->_e(array('gallerypage','6'));
		$pagenavi_options['current_text'] = "%PAGE_NUMBER%";
		$pagenavi_options['page_text'] = "%PAGE_NUMBER%";
		$pagenavi_options['first_text'] = $this->_e(array('gallerypage','7'));
		$pagenavi_options['last_text'] = $this->_e(array('gallerypage','8'));
		$pagenavi_options['prev_text'] = "<<";//"";
		$pagenavi_options['next_text'] = ">>";//"";
		$pagenavi_options['num_pages'] = "2";
		    
		$numposts = $wp_query->found_posts;
		 
		$max_page = $wp_query->max_num_pages;
		if(empty($paged) || $paged == 0) {
			$paged = 1;
		}
		
		$pages_to_show = intval(5);
		$larger_page_to_show = intval(1);
		$larger_page_multiple = intval(1);
		$pages_to_show_minus_1 = $pages_to_show - 1;
		$half_page_start = floor($pages_to_show_minus_1/2);
		$half_page_end = ceil($pages_to_show_minus_1/2);
		$start_page = $paged - $half_page_start;
		if($start_page <= 0) {
			$start_page = 1;
		}
		$end_page = $paged + $half_page_end;
		if(($end_page - $start_page) != $pages_to_show_minus_1) {
			$end_page = $start_page + $pages_to_show_minus_1;
		}
		if($end_page > $max_page) {
			$start_page = $max_page - $pages_to_show_minus_1;
			$end_page = $max_page;
		}
		if($start_page <= 0) {
			$start_page = 1;
		}
		$larger_per_page = $larger_page_to_show*$larger_page_multiple;
		$larger_start_page_start = ($this->n_round($start_page, 10) + $larger_page_multiple) - $larger_per_page;
		$larger_start_page_end = $this->n_round($start_page, 10) + $larger_page_multiple;
		$larger_end_page_start = $this->n_round($end_page, 10) + $larger_page_multiple;
		$larger_end_page_end = $this->n_round($end_page, 10) + ($larger_per_page);
		if($larger_start_page_end - $larger_page_multiple == $start_page) {
			$larger_start_page_start = $larger_start_page_start - $larger_page_multiple;
			$larger_start_page_end = $larger_start_page_end - $larger_page_multiple;
		}
		if($larger_start_page_start <= 0) {
			$larger_start_page_start = $larger_page_multiple;
		}
		if($larger_start_page_end > $max_page) {
			$larger_start_page_end = $max_page;
		}
		if($larger_end_page_end > $max_page) {
			$larger_end_page_end = $max_page;
		}
		if($max_page > 1 || intval(1) == 1) {
		
		if($max_page == 0 && $paged > 0){ $max_page=1; }
			$pages_text = str_replace("%CURRENT_PAGE%", number_format_i18n($paged), $pagenavi_options['pages_text']);
			$pages_text = str_replace("%TOTAL_PAGES%", number_format_i18n($max_page), $pages_text);	
  		
					// PAGES COUNT
					if(!empty($pages_text)) {
						$pages .= '<li class="pages"><a>'.$pages_text.'</a></li>';
					}
					if ($start_page >= 2 ) {	//&& $pages_to_show < $max_page				
						$first_page_text = str_replace("%TOTAL_PAGES%", number_format_i18n($max_page), $pagenavi_options['first_text']);						
						if($paged > 1 ){							
							/*** get link for formatting ***/						
							if(isset($GLOBALS['flag-home'])){
							$link = get_home_url()."/?home_paged=".($paged-5);
							}else{
							$link = esc_url(get_pagenum_link($paged-5));
							}
							/*** build string ***/				
							$return .= '<li><a href="'.$link.'" class="first" rel="nofollow">&lt;&lt;</a></li>';						
						} 
					}
				  	//  PREVIOUS
					for($i = $start_page; $i  <= $end_page; $i++) {	
						/*** get link for formatting ***/						
						if(isset($GLOBALS['flag-home'])){
						$link = get_home_url()."/?home_paged=".$i;
						}else{
						$link = esc_url(get_pagenum_link($i));
						}
						/*** build string ***/
						if($i == $paged) {
							$current_page_text = str_replace("%PAGE_NUMBER%", number_format_i18n($i), $pagenavi_options['current_text']);
							$return .= '<li class="active"><a href="'.$link.'" rel="nofollow">'.$current_page_text.'</a></li>';
						} else {
							$page_text = str_replace("%PAGE_NUMBER%", number_format_i18n($i), $pagenavi_options['page_text']);
							$return .= '<li><a href="'.$link.'" class="page" rel="nofollow">'.$page_text.'</a></li>';
						}
					}
					 
			 		// FIRST BUTTON
					if($paged > 0 && $paged+3 < $max_page){	
						/*** get link for formatting ***/						
						if(isset($GLOBALS['flag-home'])){
						$link = get_home_url()."/?home_paged=".($paged+4);
						}else{
						$link = esc_url(get_pagenum_link($paged+4));
						}
						/*** build string ***/					
						$return .= '<li><a href="'.$link.'" class="first" rel="nofollow">&gt;&gt;</a></li>';						
					}
		}
	}
	
	// ADD ON STYLE WRAPPER
	$return = '<div class="pagnavbar">
	<ul class="pagination">'.$return.'</ul>
	<ul class="pager pull-right">'.$pages.'</ul>
	</div>
	<div class="clearfix"></div>';
	 
	// RETURN VALUE
	if($return){	return $return;	}else{	echo $return;	}
}
function n_round($num, $tonearest) {  return floor($num/$tonearest)*$tonearest;}

/* =============================================================================
	 LOGO // CREATE WEBSITE LOGO  // TEXT OR IMAGE
	========================================================================== */
function Logo($return=""){ 
 		
		// LOGO DATA
		$logoTXT = "";
		$logo 		= $GLOBALS['CORE_THEME']['logo_url'];
		$logo_icon 	= $GLOBALS['CORE_THEME']['logo_icon'];
		$logo_text1	= $GLOBALS['CORE_THEME']['logo_text1'];
		$logo_text2	= $GLOBALS['CORE_THEME']['logo_text2'];		
		
		if(strpos($logo, "http") !== false ){ 
				
			if(substr($logo,0,1) == ","){
				$logo = substr($logo,1);
			}
			
			$logoTXT = "<img src='".$logo."' alt='logo' class='img-responsive' />";			 
		
		}elseif($logo_text1 != ""){
		
			if($logo_icon != "" && $logo_icon != 0){
			$logoTXT .= '<div class="iconwrap hidden-sm hidden-xs"><img src="'.get_template_directory_uri().'/framework/img/logo/'.$logo_icon.'.png" alt="'. get_bloginfo('name') .'" id="logoicon" /></div>';
			}
			$logoTXT .= "<div class='logowrapper'><span class='main'>".stripslashes($logo_text1)."</span> <span class='submain'>".stripslashes($logo_text2)."</span></div>";
		 
		}
		
		return $logoTXT;	
}	
	
/* =============================================================================
	PAGE TITLE ADJUSTMENTS
========================================================================== */

function TITLE( $title, $sep = "" ) {
	global $paged, $page, $CORE; $extra = "";
	
	// HOME PAGE OBJECTS
	if(isset($_GET['home_paged'])){
		$extra .= " | ".$CORE->_e(array('button','27'))." ".$_GET['home_paged'];
	}
 
    return $title.$extra;
}
/* =============================================================================
  SORT FUNCTION USED TO RE-ORDER FIELD/PACKAGES
  ========================================================================== */
function multisort($array, $sort_by) {
 
 		if(!is_array($array)){ return; }
		$estr = '';
		
		foreach ($array as $key => $value) {
			$estr = '';
			foreach ($sort_by as $sort_field) {
				$tmp[$sort_field][$key] = $value[$sort_field];	
				$estr .= '$tmp[\'' . $sort_field . '\'], ';
			}
		}
		
		$estr .= '$array';
		$estr = 'array_multisort(' . $estr . ');';
		eval($estr);
	
		return $array;
}
function multisortkey($array, $skey, $svalue){

	if(!is_array($array)){ return; }
	foreach ($array as $key => $value) {
		if($svalue == $value[$skey]){
			return $key;
		} // end if
	}// end foreach
}

/* =============================================================================
   POPULAR SEARCH
   ========================================================================== */

function POPULARSEARCHES($limit=10){ $STRING = "";

	$saved_searches_array = get_option('recent_searches');
	if(is_array($saved_searches_array) && !empty($saved_searches_array)){
	
	$ss = array_reverse( $this->multisort( $saved_searches_array, array('views') ), true );
	$i =0;
	foreach($ss  as $key => $searchdata){ 
	if($i > $limit){ continue; }
	
	$term = esc_attr(str_replace("_"," ",$key));
	
	$STRING .= "<a href='" . home_url(). "/?s=" . $term . "'>". $term."</a>";
	$i ++;
	}
}

return $STRING;
}

/* =============================================================================
  SIDEBAR CONTENT
   ========================================================================== */

function SIDEBARCONTENT($type, $num = 10, $mainargs = array()){ global $wpdb; $STRING = ""; $extra = ""; $SavedContent = "";
 
 
	switch($type){
	
		case "comments": {
		
			// COMMENTS		
			$SQL = "SELECT *, comment_post_ID AS ID FROM ".$wpdb->prefix."comments WHERE comment_approved=1 ORDER BY comment_ID DESC LIMIT ".$num;	 
		 
			$result = $wpdb->get_results($SQL);
			if(!empty($result)){
		
				$STRING .= "<ul class='list-group'>";
		
				foreach($result as $data){
				ob_start();
				?>
                <li class="list-group-item sidelist">
				<a href="<?php echo get_permalink($data->comment_post_ID); ?>">
					<div class="row clearfix commentbit">
					<div class="col-md-3 hidden-sm hidden-xs"><?php echo get_avatar( $data->user_id, 100 ); ?></div>
					<div class="col-md-9 col-sm-12">
					<?php echo $data->comment_title; ?>
					<div class="clearfix"></div>
					<div class="quote"><?php echo substr(strip_tags($data->comment_content),0,80); ?></div>
					<div class="author">- <?php echo $data->comment_author; ?></div>
					</div>
					</div>
				</a>
                </li>
				<?php
				$STRING .= ob_get_contents();
				ob_end_clean();
				}
				
				$STRING .= "</ul>";
			}		
			return $STRING;
			
		} break;
		case "blog": {
 		
		$args = array( 'post_type' => 'post', 'posts_per_page' => $num, 'orderby' => 'post_date', 'order' => 'desc','no_found_rows' => true );
			
		} break;
		default: { 
	 
			$args = array( 'post_type' => THEME_TAXONOMY.'_type', 'posts_per_page' => $num, 'orderby' => 'ID', 'order' => 'desc' ,'no_found_rows' => true  );
			 
			if(isset($mainargs['type'])){
				switch($mainargs['type']){
		 
					case "featured": {
						
						$args = array( 'post_type' => THEME_TAXONOMY.'_type', 'posts_per_page' => $num, 'orderby' => 'rand', 'meta_key' => 'featured', 'meta_value' => 'yes','no_found_rows' => true );									
					
					} break;
					case "random": {	
						 
						$args = array( 'post_type' => THEME_TAXONOMY.'_type', 'posts_per_page' => $num, 'orderby' => 'rand','no_found_rows' => true );		
					
					} break;		
				}	
			}		
			
		} break;  
		
	}  // END SWITCH
	
	// HIDE EXPIRED
	if(isset($GLOBALS['CORE_THEME']['hide_expired']) && $GLOBALS['CORE_THEME']['hide_expired'] == 1 ){	 
			 
			 if(defined('WLT_COUPON')){
		 $expkey = "expiry_date";
		 }else{
		 $expkey = "listing_expiry_date";
		 }
			 
				$args = array_merge($args, 	
				
					array( 'meta_query' => array (
							array( 
								'key' => $expkey,																
								'orderby' => 'meta_value',						 
								'compare' => '>=',
								'value' => date('Y-m-d H:i:s'),
								'type' => 'DATETIME'							 
							),
						  ), )   );
	}	
 
	// PERFORM LOOP
	query_posts($args);
 
	if (have_posts()){
	 
	 $STRING .= "<ul class='list-group'>";
	  
		while (have_posts()){ the_post(); 
		
			switch($type){

			case "blog": {			
			
				ob_start();
				?>
                <li class="list-group-item sidelist">
                
                <div class="row clearfix blogbit">
                <div class="col-md-3 hidden-sm hidden-xs">[IMAGE]</div>
                <div class="col-md-9 col-sm-12">     
                 <a href="<?php the_permalink(); ?>">
                    <div class="title"><span><?php the_title(); ?></span></div>
                 </a>
                <div class="clearfix"></div>
                <div class="desc"><?php the_excerpt(); ?></div>
               
                </div>
                </div> 
                
                </li> 
                <?php
				$STRING .= do_shortcode(ob_get_contents());
				ob_end_clean();
			
			} break;
			default: {
		  
				ob_start(); ?>
				
				<li class="list-group-item sidelist">
				
				<div class="clearfix listingbit">
				<div class="col-md-3 hidden-sm hidden-xs nopadding">[IMAGE]</div>
				<div class="col-md-9 col-sm-12">
                
				<a href="<?php the_permalink(); ?>">
					<div class="title"><span><?php the_title(); ?></span></div>
				</a>
				
                <?php if(!defined('WLT_DATING') ){ ?>
                
				<div class="desc">[CATEGORY] </div>
					
				<div class="rating">[RATING style=1 readonly=1 small=1]</div>
                
                <?php }else{ ?>
                <div class="desc"> [GENDER-ICON] [GENDER] / [AGE]  </div>
                <?php } ?>
					
				</div>
				</div>
				
				</li>
				 
				<?php
				$STRING .= do_shortcode(ob_get_contents());				 
				ob_end_clean();
				
			} }
 		 				
		}
		
	$STRING .= "</ul>"; 
	
	} 
	// END QUERY
	wp_reset_query();

	// RETURN
	return $STRING;
 

}

function PAGEEXISTS($page){
return;
$page_exists = false; $core_admin_values = get_option("core_admin_values");  

switch($page){
	
	case "home":
	case "homepage": {
	
		if(file_exists(str_replace("functions/","",THEME_PATH)."/templates/".$core_admin_values['template']."/_homepage.php") 
		
		|| ( defined('CHILD_THEME_NAME') && file_exists(WP_CONTENT_DIR."/themes/".CHILD_THEME_NAME."/_homepage.php") ) ){
		
		return true;
		
		}
		
		if(file_exists(str_replace("functions/","",THEME_PATH)."/templates/".$core_admin_values['template']."/home.php") 
		
		|| ( defined('CHILD_THEME_NAME') && file_exists(WP_CONTENT_DIR."/themes/".CHILD_THEME_NAME."/home.php") ) ){
		
		return true;
		
		}
	
	
	} break;

}


return $page_exists;

}
 
/* =============================================================================
   SELL SPACE
   ========================================================================== */

function SELLSPACE($type=1, $userid="", $size=""){ global $wpdb;
	
	$esp = array();
	$spa = hook_sellspace($this->sellspace);

	switch($type){
	
	case "1": { return $spa; } break; // return array
	case "2": { 	
	
		$sellspacedata = $GLOBALS['CORE_THEME']['sellspace'];
		foreach($spa as $key => $sp){
			if(isset($sellspacedata[$key]) && $sellspacedata[$key] == 1){
				$esp[$key] =  $sp;	
			}
		}	
	
		return $esp; 
		 
	} break; // return enabled array
	
	case "3": {  // return user banners
	
		$mybanners = array();
		
		if(is_array($size) && $size[0] != ""){		
		$SQL = "SELECT ".$wpdb->posts.".* FROM ".$wpdb->posts."
				INNER JOIN ".$wpdb->postmeta." AS t1 ON ( t1.post_id = ".$wpdb->posts.".ID AND t1.meta_key = 'width' AND t1.meta_value = '".$size[0]."')
				INNER JOIN ".$wpdb->postmeta." AS t2 ON ( t2.post_id = ".$wpdb->posts.".ID AND t2.meta_key = 'height' AND t2.meta_value = '".$size[1]."')
				WHERE ".$wpdb->posts.".post_status= 'publish' AND ".$wpdb->posts.".post_author = ".$userid."  LIMIT 0,50";	
 
		}else{
		$SQL = "SELECT * FROM ".$wpdb->prefix."posts WHERE post_type = 'wlt_banner' AND post_author = ".$userid." ORDER BY post_date DESC"; 
		}
	  
		$posts = $wpdb->get_results($SQL);	 
		foreach($posts as $post){ 
		$mybanners[] = array('id' => $post->ID, 'name' => $post->post_title, 'img' => $post->post_excerpt, 'w' => get_post_meta($post->ID, 'width', true), 'h' => get_post_meta($post->ID, 'height', true)  );
		}
	 
		return $mybanners;	
	
	} break;
	default: { } break;
	
	}

}

/* =============================================================================
   DISPLAY CATEGORIES
   ========================================================================== */

function CategoryList($data){

if(!is_array($data)){ return $data; }
 

$id				=$data[0];
$showAll		=$data[1];
$showExtraPrice	=$data[2]; 
$TaxType		=$data[3];
if(isset($data[4])){ $ChildOf	= $data[4];  }else{$ChildOf="";  }
if(isset($data[5])){ $hideExCats	= $data[5];  }else{ $hideExCats=""; }
if(isset($data[6])){$ShowCatPrice	= $data[6];   }else{ $ShowCatPrice	= "";  }

 
global $wpdb; $exclueMe=array(); $extra = ""; $count=0; $limit = 200; $STRING = ""; $ShowCatCount = get_option("display_categories_count");	$exCats=0;  $largelistme = false; $opgset = false;

// IF WE ARE GOING TO SHOW THE CATPRICE, LETS INCLUDE THE CAT PRICE ARRAY
if($ShowCatPrice){ $current_catprices = get_option('wlt_catprices'); }


 
// WHICH TYPE OF CATEGORY LIST TO DISPLAY?
if($showAll == "toponly"){
		
		if($TaxType == "category"){
			$args = array(
			'taxonomy'              => $TaxType,
			'child_of'              => $ChildOf,
			'hide_empty'            => $largelistme,
			'hierarchical'          => 0,
			'use_desc_for_title'	=> 1,
			'pad_counts'			=> 1,
			'exclude'               => $exCats,
			);			
		}else{
			$args = array(
			'taxonomy'              => $TaxType,
			'child_of'              => $ChildOf,
			'hide_empty'            => $largelistme,
			'hierarchical'          => 0,
			'use_desc_for_title'	=> 1,
			'pad_counts'			=> 1,
			);			
		}
		 
			$categories = get_categories($args);  
			
		 	if(is_array($categories)){
			foreach($categories as $category) {
			 	// SKIP	
				if ($category->parent > 0 && $ChildOf == 0) { continue; }
				if($ChildOf > 0 && $ChildOf != $category->parent){ continue; }				
				// BUILD DISPLAY				
				$STRING .= '<option value="'.$category->cat_ID.'" ';
				if( ( is_array($id) && in_array($category->cat_ID,$id) ) ||  ( !is_array($id) && $id == $category->cat_ID ) ){
				$STRING .= 'selected=selected';
				}
				$STRING .= '>';
				$STRING .= $category->cat_name;
				// SHOW PRICE
				if($ShowCatPrice && isset($current_catprices[$category->cat_ID]) 
				&& ( isset($current_catprices[$category->cat_ID]) && is_numeric($current_catprices[$category->cat_ID]) && $current_catprices[$category->cat_ID] > 0 ) ){ 
				 	$STRING .= " (".hook_price($current_catprices[$category->cat_ID]).')'; 
				}
				// SHOW COUNT
				if($ShowCatCount =="yes"){ $STRING .= " (".$category->count.')'; }			 
				$STRING .= '</option>';
		
			}			
			}
			return $STRING;	
		
/* =============================================================================
   DISPLAY ALL CATEGORIES
   ========================================================================== */
		
		}else{
 		
		$args = array(
		'taxonomy'                 => $TaxType,
		'child_of'                 => $ChildOf,
		'hide_empty'               => $largelistme,
		'hierarchical'             => true,
		'exclude'                  => $exCats);
 	
		$cats  = get_categories( $args );
 
		$newcatarray = array(); $addedAlready = array(); $opgset = false;
		
		// SHOW OPTGROUP
		if(isset($GLOBALS['tpl-add']) && isset($GLOBALS['CORE_THEME']['disablecategory']) && $GLOBALS['CORE_THEME']['disablecategory'] == 1){
		$showopg = true;
		}else{
		$showopg = false;
		}
	
		// NOW WE BUILD A CLEAN ARRAY OF VALUES
		foreach($cats as $cat){	
		 
			if($cat->parent != 0){ continue; }		
			$newcatarray[$cat->term_id]['term_id'] 	=  $cat->term_id;
			$newcatarray[$cat->term_id]['name'] 	=  $cat->cat_name;
			// SHOW PRICE
			if($ShowCatPrice && isset($current_catprices[$cat->term_id]) 
				&& ( isset($current_catprices[$cat->term_id]) && is_numeric($current_catprices[$cat->term_id]) && $current_catprices[$cat->term_id] > 0 ) ){ 
				 	$newcatarray[$cat->term_id]['name'] .= " (".hook_price($current_catprices[$cat->term_id]).')'; 
			}
			$newcatarray[$cat->term_id]['parent'] 	=  $cat->parent;
			$newcatarray[$cat->term_id]['slug'] 	=  $cat->slug;
			$newcatarray[$cat->term_id]['count'] 	=  $cat->count;
		}
		// SECOND LOOP TO GET CHILDREN
		foreach($cats as $cat){
	 
			if($cat->parent == 0){ continue; }		
			$newcatarray[$cat->parent]['child'][] = $cat;		 
		}
 		 // NOW BUILD THE MAIN ARRAY
		foreach($newcatarray as $cat){
		  	
			if(!isset($cat['term_id'])){ continue; }
			
			// CHECK IF THIS IS SELECTED
			if( ( is_array($id) && in_array($cat['term_id'],$id) ) ||  ( !is_array($id) && $id == $cat['term_id'] ) ){ $EX1 = 'selected=selected'; }else{ $EX1 = ""; }
						
			if(!$showopg && !in_array($cat['term_id'], $addedAlready) && $cat['name'] !=""){ 	 
			
			$STRING .= '<option value="'.$cat['term_id'].'" '.$EX1.'>'.$cat['name'].'</option>';
			
			}elseif($showopg && !in_array($cat['term_id'], $addedAlready) && $cat['name'] !=""){ 			
					if(isset($opgset)){ $STRING .= '</optgroup>'; }
					$opgset = true;					
					$STRING .= '<optgroup data-parent="optiongroup" label="'.$cat['name'].'">';
			}
			
			
			$addedAlready[] = $cat['term_id'];
			 	
			if(!empty($cat['child'])){	
				foreach($cat['child'] as $sub1){ 
				 			
							// CHECK IF THIS IS SELECTED
							if( ( is_array($id) && in_array($sub1->term_id,$id) ) ||  ( !is_array($id) && $id == $sub1->term_id ) ){ $EX2 = 'selected=selected'; }else{ $EX2 = ""; }
							
							// SHOW PRICE
							if($ShowCatPrice && isset($current_catprices[$sub1->term_id]) 
								&& ( isset($current_catprices[$sub1->term_id]) && is_numeric($current_catprices[$sub1->term_id]) && $current_catprices[$sub1->term_id] > 0 ) ){ 
									$sub1->name .= " (".hook_price($current_catprices[$sub1->term_id]).')'; 
							}
														
							// OUTPUT
							if(!in_array($sub1->term_id, $addedAlready)){ 
							$STRING .= '<option value="'.$sub1->term_id.'" '.$EX2.'> -- '.$sub1->name.'</option>';
							}
							$addedAlready[] = $sub1->term_id;
							 
							// CHECK FOR SUB CATS LEVEL 2
							if(!empty($newcatarray[$sub1->term_id]['child'])){  
							 
								foreach($newcatarray[$sub1->term_id]['child'] as $sub2){
									
									// CHECK IF THIS IS SELECTED
									if( ( is_array($id) && in_array($sub2->term_id,$id) ) ||  ( !is_array($id) && $id == $sub2->term_id ) ){ $EX3 = 'selected=selected'; }else{ $EX3 = ""; }
																		
									// OUTPUT
									if(!in_array($sub2->term_id, $addedAlready)){ 
									$STRING .= '<option value="'.$sub2->term_id.'" '.$EX3.'> ---- '.$sub2->name.'</option>';	
									}
									$addedAlready[] = $sub2->term_id;						
									 
									// CHECK FOR SUB CATS LEVEL 2
								 
									if(!empty($newcatarray[$sub2->term_id]['child'])){ 
										foreach($newcatarray[$sub2->term_id]['child'] as $sub3){
									
											// CHECK IF THIS IS SELECTED
											if( ( is_array($id) && in_array($sub3->term_id,$id) ) ||  ( !is_array($id) && $id == $sub3->term_id ) ){ $EX4 = 'selected=selected'; }else{ $EX4 = ""; }
																						
											// OUTPUT
											if(!in_array($sub3->term_id, $addedAlready)){ 
											$STRING .= '<option value="'.$sub3->term_id.'" '.$EX4.'> ------ '.$sub3->name.'</option>';	
											}
											$addedAlready[] = $sub3->term_id;	
											
											
											// CHECK FOR SUB CATS LEVEL 2
											if(!empty($newcatarray[$sub3->term_id]['child'])){ 
												foreach($newcatarray[$sub3->term_id]['child'] as $sub4){										
										
													// CHECK IF THIS IS SELECTED
													if( ( is_array($id) && in_array($sub4->term_id,$id) ) ||  ( !is_array($id) && $id == $sub4->term_id ) ){ $EX4 = 'selected=selected'; }else{ $EX4 = ""; }
												
													
													// OUTPUT
													if(!in_array($sub4->term_id, $addedAlready)){ 
													$STRING .= '<option value="'.$sub4->term_id.'" '.$EX4.'> ------ '.$sub4->name.'</option>';	
													}
													$addedAlready[] = $sub4->term_id;	
																							
												}
											} 
										 									
										}										
									}
									
								}
						}
							
				}
			}
			 	
		
		} // end foreach
		
		if($opgset){ $STRING .= '</optgroup>'; }
  	
		return $STRING;		

	}
}

 /* =============================================================================
   CUSTOM FIELD DISPLAY FUNCTION
   ========================================================================== */

function CUSTOMFIELDLIST($value1="", $key="meta_key"){
	
		global $wpdb; $STRING = ""; $STRING1 = ""; $cleanArray = array(); $removeValues = array('map-country','map-state','map-city');		
		
		// GET THE EXISTING SAVED OPTIONS
		$EXISTINDATA = get_option('wlt_customfieldlist');
		
		// FORCE ADMIN TO REFRESH
		if(isset($_GET['page']) && $_GET['page'] == "1" && is_admin() ){
		$EXISTINDATA['date'] = "";			
		}
		
		if(  strtotime($EXISTINDATA['date']) < strtotime(current_time( 'mysql' ))   ) {
		
			//$SQL = "SELECT DISTINCT ".$key." FROM $wpdb->postmeta 
			//WHERE ".$key." NOT IN('_edit_last', '_edit_lock', '_encloseme', '_pingme', '_".$wpdb->prefix."page_template') AND ".$key." NOT LIKE '%menu%' AND ".$key." NOT LIKE '%wp_%' ORDER BY meta_value ASC";
		 	
			$SQL = "SELECT DISTINCT ".$key." FROM $wpdb->postmeta LIMIT 100";
		 	 
			$last_posts = (array)$wpdb->get_results($SQL);
			$savestring = array();
			foreach($last_posts as $value){			
			$savestring[] = $value->meta_key;		
			}
			
			asort($savestring);			
			 
			update_option("wlt_customfieldlist", array("date" => date('Y-m-d H:i:s', strtotime(date('Y-m-d H:i:s'). "+24 hours") ), "values" => $savestring), true);
		 	 
		}
 
		$STRING .= "<option value='title' ";if((is_array($value1) && in_array("title",$value1)) || ( !is_array($value1) && $value1 == "title") ){$STRING .= "selected"; } $STRING .= ">Post Title</option>";
		$STRING .= "<option value='author'";if( (is_array($value1) && in_array("author",$value1)) || ( !is_array($value1) && $value1 == "author") ){$STRING .= "selected"; } $STRING .= ">Post Author</option>";
		$STRING .= "<option value='modified'";if( (is_array($value1) && in_array("modified",$value1)) || ( !is_array($value1) && $value1 == "modified") ){$STRING .= "selected"; } $STRING .= ">Last Modified</option>";
		$STRING .= "<option value='comment_count'";if( (is_array($value1) && in_array("comment_count",$value1)) || ( !is_array($value1) && $value1 == "comment_count") ){$STRING .= "selected"; } $STRING .= ">Comment Count</option>";
		$STRING .= "<option value='post_date'";if( (is_array($value1) && in_array("post_date",$value1)) || ( !is_array($value1) && $value1 == "post_date") ){$STRING .= "selected"; } $STRING .= ">Post Date</option>";
		 
		 
		if($value1 == "nono"){ $STRING = ""; }
		if(is_array($EXISTINDATA['values'])){
		
		asort($EXISTINDATA['values']);
		
		foreach($EXISTINDATA['values'] as $value){	 	
		
			/*** REMOVE ANY WE DONT WANT ***/
			if(in_array($value,$removeValues) || substr($value,0,1) == "_"){ continue; }
			/*** used for returning an array ***/
			if($value1 == "array"){		
				$cleanArray[] = $value;
			/** used for returning a custom string ***/		
			}elseif($value1 == "nono"){				 
				$STRING1 .= "[".$value."]<br />";			 
			/*** default for everything else ***/		 	
			}else{		
				if(is_array($value1) && in_array($value,$value1)){
					$STRING .= "<option value='".$value."' selected>".$value."</option>";
				}elseif(!is_array($value1) && $value1 == $value){
					$STRING .= "<option value='".$value."' selected>".$value."</option>";
				}else{
					$STRING .= "<option value='".$value."'>".$value."</option>";
				}			
			} // end if		
		} // end loop
		}
	if($value1 == "array"){
		return $cleanArray;
	}else{
		return $STRING.$STRING1;
	}
}


/* =============================================================================
	 DATE FORMATTING
	========================================================================== */

function format_date($date){
return mysql2date(get_option('date_format') . ' ' . get_option('time_format'),  $date, false);
}

/* =============================================================================
  Time Difference (now and date entered) / V7 / 25th Feb 
   ========================================================================== */
 
function TimeDiff($end_date, $start_date = '', $array=false ){ global $post, $CORE;
		 
		if($end_date == ""){ return; }
		if($start_date == ""){ $start_date = current_time( 'mysql' ); }
		
		// MAKE SURE ITS A DATE STRING		
		$end_date = date( "Y-m-d H:i:s", strtotime( $end_date ) );
		
		// CHECK FOR INVALID DATE/TIME // AUTO SET TO FOR EXTRA 30 DAYS JUST ENCASE
		if( $end_date == "1970-01-01 00:00:00"){
		return;
		}
		
		if(!function_exists('date_diff')){
		return $this->format_date($end_date);
		}	
			 
        $intervalo = date_diff(date_create($start_date), date_create($end_date));
	 
	   
        if($CORE->_e(array('date','years')) == ""){
		
		 $out = $intervalo->format("Years:%Y,Months:%M,Days:%d,Hours:%H,Minutes:%i,Seconds:%s");
		 
		}else{
		
		 $out = $intervalo->format($CORE->_e(array('date','years','flag_noedit')).":%Y,".$CORE->_e(array('date','months','flag_noedit')).":%M,".$CORE->_e(array('date','days','flag_noedit')).":%d,".$CORE->_e(array('date','hours','flag_noedit')).":%H,".$CORE->_e(array('date','minutes','flag_noedit')).":%i,".$CORE->_e(array('date','seconds','flag_noedit')).":%s");
 		 
		}
		
		 	
		$v1 = explode(',',$out); $a_out = array();
 
		foreach($v1 as $k){
			$g = explode(":",$k);
			$a_out[$g[0]] = $g[1];
		}
		
		// IF WE WANT TO RETURN ARRAY ONLY
		if($array){ return array_change_key_case($a_out, CASE_LOWER); }	 
	 
	 	// ELSE CREATE DISPLAY
		$string = "  "; $returnstring = "";
 
		foreach($a_out as $key => $val){ $canShow = true;
		
			// SKIP FOR STRING
			if(is_array($returnstring) && !in_array($key, $returnstring)){ continue; }
			 
			if($val != "00" && $val != ""){
			  
				// CHOP OF SECONDS OF MINUTES IS SET
				if($key == "seconds" && $a_out['minutes'] != ""){ $canShow = false;  } 
				
				if($canShow){
				$string .= "<span class='wlt_time_key_".$key."'>".$val." ".$key."</span> ";
				}
				
			}
		}
		
		 
		// CHECK IF EXPIRED
		if( strtotime($end_date) < strtotime(current_time( 'mysql' ))  ){			
			// ITS EXPIRED
			$expired = true;
		}else{
			// NOT EXPIRED
			$expired = false;
		}		
 		
	 	// RETURN STRING
		return array("date" => $string, "expired" => $expired, "array" => $array );
		
}
/* =============================================================================
  EXPIRES FUNCTION
   ========================================================================== */
   
function RENEWAL($id = ''){ global $wpdb, $CORE, $userdata; $STRING =""; $packagefields = get_option("packagefields"); $renewal = array('price'=>0,'days'=>0);

	//0. ONLY DISPLAY RENEWAL OPTIONS FOR PAID LISTINGS
	$hasPaid =  get_post_meta($id,'listing_price_paid',true);
	if($hasPaid == ""){ return $renewal; }
	
	// CHECK THIS LISTING IS NOT ON A SUBSCRIPTION
	//$is_subscription = get_post_meta($id,'subscription',true);
	//if($is_subscription == "yes"){ return $renewal; }
	
	// 1. FIND OUT EXISTING PACKAGE ID
	$packageID =  get_post_meta($id,'packageID',true);	
	
	// DEFAULTS
	$renewal['price'] 	= get_post_meta($id, 'listing_price', true);
	$renewal['days'] 	= 30;
	
	// ADD-ON FOR EXTRA PRICE CHECK
	if(is_numeric($packageID) && ( $renewal['price'] == "" || $renewal['price'] < 1 ) && isset($packagefields[$packageID]) ){
		$renewal['price'] = $packagefields[$packageID]['price'];		
	}elseif($renewal['price'] 	==""){
		$renewal['price'] 	= 0;
	}
 	 
	// 2. GET PRICE AND DATE 
	if(isset($packagefields[$packageID]['expires']) && is_numeric($packagefields[$packageID]['expires']) ){	
	$renewal['days'] = $packagefields[$packageID]['expires'];	
	}
 	 
	// CHECK FOR CUSTOM THEME CHANGES
	if(defined('WLT_AUCTION') && !isset($GLOBALS['orderid']) ){	
		// GET EXPIRY DATE AND CREATION DATE AND WORK OUT THE DIFFERENCE
		$expires = get_post_meta($id, 'listing_expiry_date',true);
		$gg = get_post($id);
		$dif = $this->TimeDiff($expires, $gg->post_date, true);
		$renewal['days'] =  $dif['days'];	
	}
	
	// CHECK IF THE USER HAS A MEMBERSHIP ON THEIR ACCOUNT
	$current_membership			= get_user_meta($userdata->ID,'wlt_membership',true);
    if($current_membership != "" && is_numeric($current_membership)){
		$renewal['price'] 	= 0;
	}
 	
	return $renewal;


}
function EXPIRED($id = '', $type=""){ global $wpdb, $userdata, $post, $CORE; $STRING ="";
 
 	
	// CHECK IF WE HAVE DISABLED EXPIRRY ACTIOSN
	if(isset($GLOBALS['CORE_THEME']['stop_expired']) && 
	$GLOBALS['CORE_THEME']['stop_expired'] == 1){ 	
		return;		
	}
 
	if(is_numeric($id)){ $checkID = $id; }else{ $checkID = $post->ID; }
	 
 	// MEMBERSHIP TYPE OR LISTING TYPE
 	if($type == "membership"){ 
	
		
		hook_expiry_membership();
	 	
		$expires = get_user_meta($userdata->ID,'wlt_membership_expires',true);
	 
		if($expires == ""){ return; }
		
		// ADD-ON 24 HOUR FREE ENCASE ITS A SUBSCRIPTION	
		$_POST['expires']		= hook_date($expires);	 
		//$expires = date('Y-m-d H:i:s',strtotime($expires . "+1 days"));
	 	 
		// GET ARRAY OF DATE/TIME VALUES		
		$ff = $this->TimeDiff($expires,'',true);
		
		// SET EXTRA VALUES FOR EMAIL SHORTCODES		
		$GLOBALS['username'] 	= $userdata->display_name;
		$_POST['username'] 		= $GLOBALS['username'];
 		$_POST['title']		 	= $post->post_title;		
 		$_POST['post_date'] 	= hook_date($post->post_date); 
		
		// LINE UP 30 DAY EMAIL REMINDER (GIVE 2 DAYS JUST ENCASE CRON ISNT WORKING)
		if( ( $ff['days'] == 30 || $ff['days'] == 29 ) && $ff['months'] == "00" && $ff['years'] == "00" && get_user_meta($userdata->ID,'email_sent_mem_30dayreminder',true) == ""){
			$CORE->SENDEMAIL($userdata->user_email,'mem_reminder_30');
			update_user_meta($userdata->ID,'email_sent_mem_30dayreminder',current_time( 'mysql' ));			
		}
		
		// LINE UP 15 DAY EMAIL REMINDER (GIVE 2 DAYS JUST ENCASE CRON ISNT WORKING)
		if( ( $ff['days'] == 15 || $ff['days'] == 14 ) && $ff['months'] == "00" && $ff['years'] == "00" && get_user_meta($userdata->ID,'email_sent_mem_15dayreminder',true) == ""){
			$CORE->SENDEMAIL($userdata->user_email,'mem_reminder_15');
			update_user_meta($userdata->ID,'email_sent_mem_15dayreminder',current_time( 'mysql' ));			
		}	
		
		// LINE UP 1 DAY EMAIL REMINDER (GIVE 2 DAYS JUST ENCASE CRON ISNT WORKING)
		if( ( $ff['days'] == 01 || $ff['days'] == 00 ) && $ff['months'] == "00" && $ff['years'] == "00" && get_user_meta($userdata->ID,'email_sent_mem_1dayreminder',true) == ""){
			$CORE->SENDEMAIL($userdata->user_email,'mem_reminder_1');
			update_user_meta($userdata->ID,'email_sent_mem_1dayreminder',current_time( 'mysql' ));		
		}
		 
		
		// IF COMPLETELY EXPIRED, REMOVE ALL LISTINGS THIS USER HAS AND CLEAR MEMBERSHIP DATA
		if(strtotime($expires) < strtotime(current_time( 'mysql' )) ) {
		  
			$SQL = "UPDATE $wpdb->posts SET post_status='draft' WHERE post_author='".$userdata->ID."' AND post_type='".THEME_TAXONOMY."_type'";
			$wpdb->query($SQL);
			 
			$CORE->SENDEMAIL($userdata->user_email,'mem_expired');
			update_user_meta($userdata->ID,'wlt_membership','');
			update_user_meta($userdata->ID,'wlt_membership_expires','');
			update_user_meta($userdata->ID,'email_sent_mem_expired',current_time( 'mysql' ));
			
			// ADD LOG ENTRY
			$CORE->ADDLOG("<a href='(ulink)'>".$userdata->user_nicename.'</a> membership expired. ['.$userdata->user_email.']', $userdata->ID,'','label-inverse');				

		}

	}else{
		
		hook_expiry_listing();
		
		 
		// CHECK IF THIS IS A SUBSCRIPTION
		$is_subscription = get_post_meta($checkID,'subscription',true);
		if($is_subscription == "yes"){ return; } 

		// GET THE LISTING EXPIRY DATE
		$expires = get_post_meta($checkID, 'listing_expiry_date',true);
		if($expires == ""){ return; }
		 
		// CREATE SHORTCODES FOR EMAIL
		if(is_array($post)){
		foreach($post as $k=>$v){$_POST[$k] = $v;}	
		}
	 	
		$_POST['title'] 		= $post->post_title;		
		$_POST['link'] 			= get_permalink($checkID);
		$_POST['expired'] 		= hook_date($expires);
		$_POST['post_date'] 	= hook_date($post->post_date);
		$_POST['expires']		= hook_date($expires);

		// GET ARRAY OF DATE/TIME VALUES
		$ff = $this->TimeDiff($expires,'',true);
 
		if(isset($ff['days'])){
			// LINE UP 30 DAY EMAIL REMINDER (GIVE 2 DAYS JUST ENCASE CRON ISNT WORKING)
			if( ( $ff['days'] == 30 || $ff['days'] == 29 ) && $ff['months'] == "00" && get_post_meta($checkID,'email_sent_30dayreminder',true) == ""){ // 
				$CORE->SENDEMAIL($post->post_author,'reminder_30');
				update_post_meta($checkID,'email_sent_30dayreminder',current_time( 'mysql' ));
				
			}
			// LINE UP 15 DAY EMAIL REMINDER (GIVE 2 DAYS JUST ENCASE CRON ISNT WORKING)			
			if( ( $ff['days'] == 15 || $ff['days'] == 14 ) && $ff['months'] == "00" && get_post_meta($checkID,'email_sent_15dayreminder',true) == ""){ //
				$CORE->SENDEMAIL($post->post_author,'reminder_15');
				update_post_meta($checkID,'email_sent_15dayreminder',current_time( 'mysql' ));
			}	
			
			// LINE UP 1 DAY EMAIL REMINDER (GIVE 2 DAYS JUST ENCASE CRON ISNT WORKING)
			if( ( $ff['days'] == 02 || $ff['days'] == 01 || $ff['days'] == 00 ) && $ff['months'] == "00" && get_post_meta($checkID,'email_sent_1dayreminder',true) == ""){	// 	 
				$CORE->SENDEMAIL($post->post_author,'reminder_1');
				update_post_meta($checkID,'email_sent_1dayreminder',current_time( 'mysql' ));
			}	
		}
	 
		// IF COMPLETELY EXPIRED, DRAFT IT
		if(strtotime($expires) < strtotime(current_time( 'mysql' )) ) { 
		 	
			 
		 	$finish_early = hook_expiry_listing_action($checkID); 
			if($finish_early == "stop"){ return; }
			 
		 	// INCLUDE PACKAGE OPTIONS FOR CUSTOM MOVES
			$packagefields = get_option("packagefields");
			if(!is_array($packagefields)){ $packagefields = array(); }
			$packageID = get_post_meta($checkID, 'packageID',true); 
			
			// CHECK IF THE PACKAGE ID HAS A CUSTOM MOVE
			if(isset($packagefields[$packageID]['action']) && strlen($packagefields[$packageID]['action']) > 0){
			
			switch($packagefields[$packageID]['action']){
			
				case "0": { // DO NOTHING
					return; 
				} break;
				case "1": { // SET TO DRAFT
					$my_post['ID'] 			= $checkID;
					$my_post['post_status'] = "draft";
					wp_update_post( $my_post );	
				} break;
				case "2": { // DELETE
					wp_delete_post( $checkID, true ); return true; 
				} break;
				case "3": { // SET TO PENDING
					$my_post['ID'] 			= $checkID;
					$my_post['post_status'] = "pending";
					wp_update_post( $my_post );	
				} break;
				default: { // CHECK FOR CUSTOM MOVE				
					$df = explode("move-",$packagefields[$packageID]['action']);
					if(is_numeric($df[1])){ // MOVE TO CUSTOM PACKAGE
						update_post_meta($checkID,'packageID',$df[1]);						
						// CLEAR EXPIRY DATE 
						update_post_meta($checkID,'listing_expiry_date', '');
						
					}				
				}// end default			
			}// end switch			
			
			}else{
				// DEFAULT 
				$my_post['ID'] 			= $checkID;
				$my_post['post_status'] = "draft";
				wp_update_post( $my_post );	
						
			}
 			
			// SEND EMAIL ONLY IF PAYPAL RECURRING PAYMENTS INST SET
			$last_sent = get_post_meta($checkID,'email_sent_expired',true);
			//$last_sent_date = date('Y-m-d H:i:s',strtotime($last_sent . "+2 days"));
			// || ( strtotime(current_time( 'mysql' )) > strtotime($last_sent_date) )
			if( $last_sent == ""  ){ 
			
				// NOW REMOVE ALL THE FEATURE ENHANCEMENTS
				update_post_meta($checkID, 'featured', 'no'); // featured
				update_post_meta($checkID, 'html', 'no'); // html content
				update_post_meta($checkID, 'visitorcounter', 'no'); // visitor counter
				update_post_meta($checkID, 'topcategory', 	'no'); // visitor counter
				update_post_meta($checkID, 'showgooglemap', 'no'); // visitor counter
						 
				$CORE->SENDEMAIL($post->post_author,'expired');			 
				update_post_meta($checkID,'email_sent_expired',current_time( 'mysql' ));			 
			} 
			
			// ADD LOG ENTRY
			$CORE->ADDLOG("<a href='(plink)'>".$post->post_title.'</a> listing expired.', $checkID,'','label-inverse');				

		
		}
	}
	return;
}
/* =============================================================================
  Price Display
   ========================================================================== */
function PRICE($data){  $curreny = true; $val = $data;

	// CHECK FOR ARRAY WITH CURRENY OFF
	if(is_array($data)){
		$val = $data[0];
		$curreny  = $data[1];
	}

	// RETURN IF NOT NUMERIC
	if(!is_numeric($val) && defined('WLT_JOBS') ){ return $val; }  

	if(isset($GLOBALS['CORE_THEME']['currency'])){	
		$seperator = "."; $sep = ","; $digs = 2; 
		
		// DECIMAL PLACES
		if(isset($GLOBALS['CORE_THEME']['currency']['dec']) && is_numeric($GLOBALS['CORE_THEME']['currency']['dec'])){
		$digs = $GLOBALS['CORE_THEME']['currency']['dec'];
		}
		
		// FORMAT NUMBER
		if(is_numeric($val)){		
		$val = number_format($val,$digs, $seperator, $sep); 
		}
		$val = hook_price_filter($val);
		
		// RETURN IF EMPTY
		if($val == ""){ return $val; }
		
		// LEFT/RIGHT POSITION
		if($curreny){
			if(isset($GLOBALS['CORE_THEME']['currency']['position']) && $GLOBALS['CORE_THEME']['currency']['position'] == "right"){ 
				if(substr($val,-3) == ".00"){ $val = substr($val,0,-3); }
				$val = $val.$GLOBALS['CORE_THEME']['currency']['symbol'];
			}else{
				$val = $GLOBALS['CORE_THEME']['currency']['symbol'].$val;
			}
		}	
	}

	// CHOP OF THE END TO MAKE IT LOOK NICER
	if($digs == 2 && substr($val,-3) == ".00"){ $val = substr($val,0,-3); }

// RETURN
return $val;
}
	
function AUTHOR_TOOLBOX(){ global $userdata, $post, $CORE; $STRING =""; } // rmeoved in 6.4

 
function RENEW_TOOLBOX($pid, $paymentformonly=false){ global $userdata, $post, $CORE; $STRING =""; $expires = get_post_meta($pid, 'listing_expiry_date',true);

$renewal = $this->RENEWAL($pid); $STRING = ""; $post = get_post($pid);

if($renewal['price'] > -1){




if($renewal['price'] == 0){

	// CHECK IF THIS HAS ALREADY BEEN RENEWED TODAY
	$lastnewed = get_post_meta($post->ID, 'listing_renewed_dated', true);
	if($lastnewed != date("Y-m-d")){
	
	ob_start(); ?>
	
    <hr /><h4><?php echo $CORE->_e(array('single','31')); ?></h4>
    
	<p><?php echo str_replace("%a", $CORE->_e(array('button','19')) ,str_replace("%b",$renewal['days'],$CORE->_e(array('single','32')))); ?></p>
	
	<div class="alert alert-info text-center">
    <form method="post">
    <input type="hidden" name="action" value="renewalfree">
    <input type="hidden" name="pid" value="<?php echo $post->ID; ?>">
	<button type="submit" class="btn btn-lg btn-info"><?php echo $CORE->_e(array('account','67')); ?></button> 
    </form>
	</div>    
    
	<?php
	
	$STRING .= ob_get_clean(); 
	}
	
}else{
	$STRING .= '<hr /> <h4>'.$CORE->_e(array('single','31')).'</h4>';
	$STRING .= '<p>'.str_replace("%a",hook_price($renewal['price']),str_replace("%b",$renewal['days'],$CORE->_e(array('single','32')))).'</p>';
	
	$STRING .= '<div class="alert alert-info text-center">
	<button href="#myPaymentOptions" role="button" type="button" class="btn btn-lg btn-info" data-toggle="modal">'.$CORE->_e(array('account','67')).'</button> 
	</div>';
}



if($paymentformonly && $renewal['price'] > 0){

return '<!-- Modal --> 
<div id="myPaymentOptions" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
<div class="modal-dialog"><div class="modal-content">
  <div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">x</button>
    <h4 class="modal-title">'.$CORE->_e(array('single','13')).' (<span id="totalpricevalue">'.hook_price($renewal['price']).'</span>)</h4>
  </div>
  <div class="modal-body">'.$this->PAYMENTS(round($renewal['price'],2), "REW-".$post->ID."-".$userdata->ID."-".date("Ymd"), $post->post_title, $post->ID, $subscription = false).'</div>
  <div class="modal-footer">
  '.$this->admin_test_checkout().'
  <button type="button" class="btn btn-default" data-dismiss="modal" aria-hidden="true">'.$CORE->_e(array('single','14')).'</button></div></div>
  </div></div>
<!-- End Modal -->';
}


}elseif($expires == "" || ( strtotime(current_time( 'mysql' )) > strtotime($expires) ) ){ 
 
	// FREE LISTING RENEWAL	
	$packagefields = get_option("packagefields");
	
	// 1. FIND OUT EXISTING PACKAGE ID
	$packageID =  get_post_meta($post->ID,'packageID',true);	
	$renewal_days 	= 30;
	
	// 2. GET PRICE AND DATE 
	if(isset($packagefields[$packageID]['expires']) && is_numeric($packagefields[$packageID]['expires']) ){	
	$renewal_days = $packagefields[$packageID]['expires'];	
	}

	$STRING .= '<hr /> <h4>'.$CORE->_e(array('single','31')).'</h4>
	
	<p>'.str_replace("%a",$CORE->_e(array('single','31')),str_replace("%b",$renewal_days,$CORE->_e(array('single','32')))).'</p>
	
	<div class="alert alert-info text-center">
	<button href="javascript:void(0);" role="button" type="button" class="btn btn-info" onclick="document.renewalfree.submit();">'.$CORE->_e(array('account','67')).'</button>
	</div> ';

}

if($paymentformonly){ return; }

echo $STRING;

}

function TOOLBOX(){ global $userdata, $post, $CORE; $STRING ="";  $listinghasexpired = false;

// RETURN FOR CART
if(defined('WLT_CART')){ return; }
 
// CHECK POST STATUS AND SEE IF THIS CHANGED
$listing_status = get_post_meta($post->ID,'listing_status',true);
if($listing_status != 0 && $listing_status != ""){
	if($listing_status == "10"){ $text = get_post_meta($post->ID,'listing_status_msg',true); }else{ $text = $CORE->_e(array('listvalues',$listing_status)); }
	$STRING = '<div class="alert alert-block alert-info fade in"><span class="right label label-info">'.$text.'</span>'.$CORE->_e(array('account','66')).'</div>';
}
 
// ONLY PERFORM IF IS A VALID LOGGED IN USER
if(isset($userdata) && $post->post_author == $userdata->ID ){ 

	// BUILD EDIT LINK // DELETE LINK
	if(substr($GLOBALS['CORE_THEME']['links']['add'],-1) != "/"){ 
		$editlink = $GLOBALS['CORE_THEME']['links']['add']."&eid=".$post->ID;
		$deletelink = $GLOBALS['CORE_THEME']['links']['myaccount']."&did=".$post->ID;
	}else{
		$editlink = $GLOBALS['CORE_THEME']['links']['add']."?eid=".$post->ID;
		$deletelink = $GLOBALS['CORE_THEME']['links']['myaccount']."?did=".$post->ID;
	}
	
	// GET THE LISTING EXPIRY DATE 
	$selected_packageID = get_post_meta($post->ID,'packageID',true);
	
if($selected_packageID != ""){

	// GET DATE
	$listing_expiry_date = get_post_meta($post->ID,'listing_expiry_date',true); 
	if($listing_expiry_date == "" || ( strtotime($listing_expiry_date) < strtotime(current_time( 'mysql' )) )){ $listinghasexpired = true; }	
	
	// GET THE AMOUNT PAID PREVIOUSLY
	$listing_price_paid = get_post_meta($post->ID,'listing_price_paid',true);
	
	// GET THE PRICE DUE
	$payment_due = get_post_meta($post->ID,'listing_price_due',true);
	
	// GET FINAL PRICE AFTER COUPONS ETC
	$final_payment_due = hook_payment_package_price($payment_due); 
	
	// EXTRA FOR COUPON CHANGES
	if(isset($_POST['wlt_couponcode']) &&  $final_payment_due == 0){
	$post->post_status = "publish"; $listing_price_paid = "";
	}
	
	if($listing_price_paid != "" && $final_payment_due == "" && ( $post->post_status == "pending" || $post->post_status == "draft" )   ){
		
		$final_payment_due = hook_payment_package_price($listing_price_paid); 	
	
	}else{
	
		if($final_payment_due < 1 && $listing_price_paid == "" ){
		
			// RETURN IF PENDING REVIEW
			if($post->post_status == "pending" && $GLOBALS['CORE_THEME']['default_listing_status'] == "pending"){
				// DO NOTHING HERE
			}elseif($final_payment_due == 0){
			
				// SET THE LISTING PRICE TO NOTHING SO ITS FREE
				update_post_meta($post->ID,'listing_price_due','0');
				if($listing_price_paid == ""){
					update_post_meta($post->ID,'listing_price_paid',0);	
				}			
				update_post_meta($post->ID,'listing_price_paid_date',date("Y-m-d-H:i:s")); 
				// CHECK IF WE NEED TO UPDATE XPIRY DATE
				if($listinghasexpired){
				$ff = $this->RENEWAL($post->ID);
				if(isset($ff['days']) && strlen($ff['days']) > 0){ $extdasy = $ff['days']; }else{ $extdasy = 30; }
				update_post_meta($post->ID,'listing_expiry_date', date("Y-m-d H:i:s", strtotime(current_time( 'mysql' ) . " +".$extdasy." days")) );  
				}
				 
				// ADJUST STATUS
				$my_post = array();
				$my_post['ID'] 					= $post->ID;
				$my_post['post_status']			= "publish";
				$my_post['post_author']			= $userdata->ID;	
				wp_update_post( $my_post  );
				
			}	
			
		}// end if
		
	}// end if

}
 
/*---------------- EDIT OPTIONS FOR POST AUTHOR -----------------*/
// $showeditbox = true; $showpayment = true; $showpending = true;
$showeditbox = false; $showpayment = false; $showpending = false;
switch($post->post_status){

	case "pending": {
		$showpending = true;
		// ADJUSTMENT IF PAYMENT IS DUE
		if($final_payment_due > 0){ $showpending = false; $showpayment = true; }else{  $showeditbox = true; }
	} break;
	case "draft": {
		// ADJUSTMENT IF PAYMENT IS DUE
		if($final_payment_due > 0){   $showpending = false; $showpayment = true; }else{  $showeditbox = true; }
	} break;
	default: {
	 	if($final_payment_due > 0){   $showpending = false; $showpayment = true; }else{  $showeditbox = true; }	
	} break;
	
}// end switch

 
 
// NOW LETS SHOW THE BOXES

if($showpending){
	$admin_message = get_post_meta($post->ID,'pending_message',true);
	if(strlen($admin_message) > 2){ 
		$STRING .= '<div class="bs-callout bs-callout-alert" style="margin-top:0px;"> '.$CORE->_e(array('account','64')).'';
		$STRING .= "<hr /><p>".stripslashes($admin_message)."</p></div>";
	}else{
		$STRING .= '<div class="alert alert-block alert-info fade in"> '.$CORE->_e(array('account','65')).'</p></div>';
	} // end if
}// end show pending

if($showpayment){
$STRING .= '<div class="bs-callout bs-callout-alert">
<div class="pull-right" style="margin-top:-5px;">
<a class="btn btn-warning"  href="'.$deletelink.'"  onclick="return confirm(\''.$CORE->_e(array('validate','5')).'\');">'.$CORE->_e(array('button','3')).'</a>
<a class="btn btn-warning" href="'.$editlink.'">'.$CORE->_e(array('single','10')).'</a> 
<a href="#myPaymentOptions" role="button" class="btn btn-danger" data-toggle="modal">'. $CORE->_e(array('single','11')).'</a>
</div><h4>'.$CORE->_e(array('single','12')).'</h4></div>

<!-- Modal -->
<div id="myPaymentOptions" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
<div class="modal-dialog"><div class="modal-content">
  <div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">x</button>
    <h4 class="modal-title">'.$CORE->_e(array('single','13')).' (<span id="totalpricevalue">'.hook_price($final_payment_due).'</span>)</h4>
  </div>
  <div class="modal-body">';	 	
		$STRING .= $this->PAYMENTS(round($payment_due,2), "LST-".$post->ID."-".$userdata->ID."-".date("Ymdhis"), $post->post_title, $post->ID, $subscription = true);
		$STRING .= $CORE->COUPONCODES();		 
	   $STRING .= '</div><div class="modal-footer">'.$this->admin_test_checkout().'<button class="btn btn-default" data-dismiss="modal" aria-hidden="true">'.$CORE->_e(array('single','14')).'</button></div></div>
</div></div>';
}// end for dont show payment

 
if($showeditbox){
$STRING .= '<div class="alert bs-callout bs-callout-alert" id="editlistingbox">
<button type="button" class="close" data-dismiss="alert">&nbsp; x</button>
<div class="pull-right" style="margin-top:-10px;" >
<a class="btn btn-warning" href="'.$deletelink.'" onclick="return confirm(\''.$CORE->_e(array('validate','5')).'\');">'.$CORE->_e(array('button','3')).'</a>  
<a class="btn btn-warning" href="'.$editlink.'">'.$CORE->_e(array('single','10')).'</a> 
</div>
';

$expires = get_post_meta($post->ID, 'listing_expiry_date',true);
if($expires != ""){

	$xp = $this->TimeDiff($expires);
	if(!$xp['expired']){
	$STRING .= $CORE->_e(array('single','48')). $xp['date'];
	}
	
}else{
$STRING .= '<h4>'.$CORE->_e(array('single','15')).' </h4>';
} 


$STRING .= '</p></div>';
} // end edit bar for user post 


/*---------------- EDIT OPTIONS FOR POST AUTHOR -----------------*/
}


// CLAIM LISTING FUNCTION 
if(isset($GLOBALS['CORE_THEME']['visitor_claimme']) && $GLOBALS['CORE_THEME']['visitor_claimme'] == '1' && get_post_meta($post->ID, 'claimme',true) != "yes"){
	$user = get_userdata($post->post_author);
	if( (is_array($user->roles) && in_array('administrator', $user->roles) ) || $post->post_author == 1){
	$STRING .= '<div class="bs-callout bs-callout-info"> '.$CORE->_e(array('single','22')).'  <a class="btn btn-info pull-right" style="margin-top:-5px;" href="'.$GLOBALS['CORE_THEME']['links']['myaccount'].'?claime='.$post->ID.'">'.$CORE->_e(array('single','23')).'</a></div> ';
	}
}  


echo hook_single_toolbox($STRING);

} // END FUNCTION

function PAYMENTS($amount, $orderID, $description, $postid, $subscription = true  ){ global $userdata, $post, $CORE; $STRING ="";  $packagefields = get_option("packagefields");

	// HOOK INTO THE PAYMENT GATEWAY ARRAY 
	$gatway = hook_payments_gateways($GLOBALS['core_gateways']);
	
	// MAKE SURE PACKAGES ARE ENABLED, OTHERWISE WE CANNOT GET THE PAYMENT DATA	
	if(is_array($gatway) ){
		
		// CHECK FOR A PACKAGE ID
		$selected_packageID			= get_post_meta($postid,"packageID",true);
	 
		if( isset($packagefields[$selected_packageID]) && !defined('WLT_AUCTION') ){
		$GLOBALS['description'] 		= $packagefields[$selected_packageID]['name'];
		$GLOBALS['days_till_expire'] 	= $packagefields[$selected_packageID]['expires'];
		}else{
		$GLOBALS['description'] 		= $description;
		}
 
		
		if(!$subscription){ // UNSEET TO STOP SUBSCRIPTION PAYMENTS
		unset($GLOBALS['days_till_expire']);
		}
		
	 	// CREATE ORDER ID	
		$GLOBALS['orderid'] 	= $orderID;	
		$GLOBALS['total'] 		= hook_payment_package_price($amount);
		$GLOBALS['subtotal'] 	= 0;
		$GLOBALS['shipping'] 	= 0;
		$GLOBALS['tax'] 		= 0;
		$GLOBALS['discount'] 	= 0;
		$GLOBALS['items'] 		= "";		
	 
		// LOOP AND DISPLAY GATEWAYS
		foreach($gatway as $Value){
		
			// GATEWAY IS ENABLED 		 
			if(get_option($Value['function']) == "yes" ){
		 
				// TEXT ONLY
				if( $Value['function'] == "gateway_bank" ){ 
					echo wpautop(get_option('bank_info'));				
				// NOT BIG FORMS
				}elseif( !isset($Value['ownform']) ){
				
				   $rannum = rand();
				 					 
				   $STRING .= '<div class="row-old">
				   <div class="col-md-8"><b>'.get_option($Value['function']."_name").'</b></div>
				   <div class="col-md-4">'.str_replace("gateway_","gateway_".$rannum."_",$Value['function']($_POST)).'</div>
				   </div>
				   <div class="clearfix"></div><hr />'; 
				   
				// NORMAL FORMS	
				}else{					
					$STRING .= ''.$Value['function']($_POST).'<div class="clearfix"></div>';						
				}// END IF
				
			}// end if			
		} // end foreach
		// ADD IN TEST FOR ADMIN
		
		
		// ADD ON PAYMENT BY USER CREDIT
		$usercredit = get_user_meta($userdata->ID,'wlt_usercredit',true);
		if(isset($usercredit) && is_numeric($usercredit) && $usercredit >= $GLOBALS['total']){ 
		
		if(!isset($GLOBALS['uccount'])){ $GLOBALS['uccount'] = 1; }else{ $GLOBALS['uccount']++; }
		
		
		$STRING .= '<div class="row-old">
				   <div class="col-md-8"><b>'.$CORE->_e(array('checkout','60')).'</b><br> <small>'.$CORE->_e(array('checkout','61')).' '.hook_price($usercredit).'</small></div>
				   <div class="col-md-4">
				   
				   <form method="post" style="margin:0px !important;" action="'.$GLOBALS['CORE_THEME']['links']['callback'].'" name="checkout_usercredit'.$GLOBALS['uccount'].'">
				 	<input type="hidden" name="credit_total" id="credit_total" value="'.$GLOBALS['total'].'" />
					<input type="hidden" name="custom" value="'.$GLOBALS['orderid'].'" class="paymentcustomfield">		
					<input type="hidden" name="item_name" value="'.strip_tags($GLOBALS['description']).'">			 
					'.MakePayButton('javascript:document.checkout_usercredit'.$GLOBALS['uccount'].'.submit()').'</form>
	
				   </div>
				   </div>
				   <div class="clearfix"></div><hr />'; 
		}
			
		
	} // end if
	
	return $STRING;

}

function admin_test_checkout(){ global $userdata, $post; $string = ""; 
if(user_can($userdata->ID, 'administrator')){
$string .= '<form style="margin:0px;padding:0px;" method="post" action="'.$GLOBALS['CORE_THEME']['links']['callback'].'">
<input type="hidden" name="admin_test_callback" value="1" />
<input type="hidden" name="mc_gross" value="'.$GLOBALS['total'].'" id="admin_test_total" />
<input type="hidden" name="custom" value="'.$GLOBALS['orderid'].'" class="paymentcustomfield" />
<input type="hidden" name="payment_status" value="Completed" />
<input type="hidden" name="c_currency" value="'.$GLOBALS['CORE_THEME']['currency']['code'].'" />
<input type="hidden" name="txn_id" value="123567'.time().'" />
<input type="hidden" name="payer_email" value="test@test.com" />
<input type="hidden" name="item_name" value="'.strip_tags($GLOBALS['description']).'">
<button class="btn btn-info" type="submit" style="float:left;">Admin Test Callback</button>
</form>';
}
return $string;
}


 
/* =============================================================================
  PAGE ACCESS
   ========================================================================== */

function Authorize() {
 
	global $wpdb, $post;

	$user = wp_get_current_user();
	if ( $user->ID == 0 ) {
		nocache_headers();
		wp_redirect(hook_redirectlink(get_option('siteurl') . '/wp-login.php?noaccess=1&redirect_to=' . urlencode($_SERVER['REQUEST_URI'])));
		exit();
	}
}

/* =============================================================================
  GOOGLE MAP DISPLAY FUNCTION FOR SEARCH RESULTS PAGE
   ========================================================================== */

function MilesToMeters($num){
if($num == "" || $num == 0){ return 0; }
 
	$unit = strtoupper($GLOBALS['CORE_THEME']['geolocation_unit']);
	
	if ($unit == "K") {	
		return $num/0.001;  // 1 meters = 0.001 KM;
	} else {
		return $num/0.00062137119; // 1 meters = 0.00062137119 miles; 
	}

} 
function wlt_google_getradius(){

if(!isset($_GET['zipcode'])){ return; }

$saved_searches = get_option('wlt_saved_zipcodes');

$longitude 	= $saved_searches[$_GET['zipcode']]['log'];
$latitude 	= $saved_searches[$_GET['zipcode']]['lat'];
$radius = 1;
if(isset($_GET['radius']) && is_numeric($_GET['radius']) ){
$radius = $_GET['radius'];
}

return array("zip" => $_GET['zipcode'], "long"  => $longitude, "lat"  => $latitude, "dis" => $this->MilesToMeters($radius) );

} 
function wlt_google_getdefaults(){	
	
	// REGION
	$region = "us"; $lang = "en"; 
	if(isset($GLOBALS['CORE_THEME']['google_lang'])){
		$region = $GLOBALS['CORE_THEME']['google_region'];
		$lang = $GLOBALS['CORE_THEME']['google_lang'];
	}

	// GET DEFAULT ROOM AND COORDS FROM ADMIN
	if(isset($GLOBALS['CORE_THEME']['google_coords1']) && $GLOBALS['CORE_THEME']['google_coords1'] != ""){ 
		$ff = explode(",",$GLOBALS['CORE_THEME']['google_coords1']);
		$latitude =  $ff[1];
		$longitude = $ff[0];
	}
	if(isset($GLOBALS['CORE_THEME']['google_zoom1'])){ $default_zoom = $GLOBALS['CORE_THEME']['google_zoom1']; }
	
	
	// CHECK IF THIS IS A ZIPODE SEARCH
	if(isset($_GET['zipcode']) && ( strlen($_GET['zipcode']) > 2 && strlen($_GET['zipcode']) < 9 ) ){
	
		$saved_searches = get_option('wlt_saved_zipcodes');
		
		if(isset($saved_searches[$_GET['zipcode']]['log'])){
		$longitude 	= $saved_searches[$_GET['zipcode']]['log'];
		}else{ $longitude =0; }
		
		if(isset($saved_searches[$_GET['zipcode']]['lat'])){
		$latitude 	= $saved_searches[$_GET['zipcode']]['lat'];
		}else{ $latitude =0; }	 
			
	}
	
	// SET COORDS TO USERS LOCATION IF ORDERING BY DISTANCE
	if(isset($_SESSION['mylocation']['lat']) && strlen($_SESSION['mylocation']['lat']) > 0 && strlen($_SESSION['mylocation']['log']) > 0 && isset($GLOBALS['CORE_THEME']['geolocation']) && $GLOBALS['CORE_THEME']['geolocation'] != ""){

		$latitude =  strip_tags($_SESSION['mylocation']['lat']);
		$longitude = strip_tags($_SESSION['mylocation']['log']);
	}
	
	// CHECK AND VALDATE
	if($longitude == ""){ $longitude = 0; }
	if($latitude == ""){ $latitude = 0; }
	
	$default_zoom = 7;
	
	return array("region" => $region, "lang" => $lang, "zoom" => $default_zoom, "long" => $longitude, "lat" => $latitude  );
}

function wlt_googlemap_html($showboxopen = false ){ 

ob_start(); ?>

<div id="wlt_google_map_wrapper" style="display:none;">
	
	<div id="wlt_google_map">&nbsp;</div> 
  
        <div id="wlt_map_toolbox" class="ui-widget-content hidden-xs"> 
    
            <div class="pull-right closewin" onClick="jQuery('#wlt_map_toolbox').hide(); jQuery('.wlt_map1_controls').show();"><i class="fa fa-close"></i></div>
     
            <ul class="nav nav-tabs" role="tablist">
                <li class="active"><a href="#gm1" role="tab" data-toggle="tab">Search</a></li>
                <li><a href="#gm2" role="tab" data-toggle="tab">Settings</a></li>   
            </ul>
     
            <div class="tab-content">
                
                <div role="tabpanel" class="tab-pane active" id="gm1">  
                  
                <span class="pull-right myl"><a href="javascript:void(0);" onClick="MapMyLocation(true);"><i class="fa fa-location-arrow"></i> my location</a></span>
                
                <label> Location </label>    
                <input name="custom[map_location]" id="form_map_location" class="form-control" type="text" value="<?php if(isset($_GET['eid'])){ echo get_post_meta($_GET['eid'],'map_location',true); } ?>">
         
                <ul id="mapcatlist">
                <li><input type="checkbox" checked="checked" value="1"  onclick="toggleMarkers(this, 0);" />    Show/Hide All</li>    
                </ul>    
            </div>
            
            <div role="tabpanel" class="tab-pane" id="gm2">
        
                <ul class="list-inline mapids">
                <li class="col-md-6"><a href="javascript:void(0);" onClick="MapSetTypeID('satellite');">satellite</a></li>
                <li class="col-md-6"><a href="javascript:void(0);" onClick="MapSetTypeID('roadmap');">Roadmap</a></li>
                <li class="col-md-6"><a href="javascript:void(0);" onClick="MapSetTypeID('terrain');">terrain</a></li>
                <li class="col-md-6"><a href="javascript:void(0);" onClick="MapSetTypeID('hybrid');">Hybrid</a></li>
                </ul>
        
            </div>    
        </div>

</div> 

    <div class="wlt_map1_controls hidden-xs">
        <ul>
         <li class="icon a1"><a href="javascript:void(0);" onClick="MapMyLocation(true);"><i class="fa fa-location-arrow"></i></a></li>
        <li class="icon a2"><a href="javascript:void(0);" onClick="jQuery('.wlt_map1_controls').hide(); jQuery('#wlt_map_toolbox').show();"><i class="fa fa-cogs"></i></a></li>
        </ul>
    </div>
 
    
</div> 


<?php if($showboxopen){ ?>

<script>
jQuery(document).ready(function() { 
jQuery('.wlt_map1_controls').hide();
jQuery('#wlt_map_toolbox').show();
});
</script>

<?php }else{ ?>

<script>
jQuery(document).ready(function() { 
jQuery('.wlt_map1_controls').show();
jQuery('#wlt_map_toolbox').hide();
});
</script>

<?php } ?>

<?php return ob_get_clean(); } 

 
function wlt_googlemap_data($output = false){ $g=0; $HasIconArray = array();  $json = array();
 
 global $wpdb, $wp_query;
 
 if($GLOBALS['CORE_THEME']['google'] != 1){ return; }
 
  
	if(isset($wp_query->request) && !empty($wp_query->request) && ( 
	( substr($GLOBALS['CORE_THEME']['display']['orderby'],0,4) == "meta" ) || 
	( strpos($wp_query->request,"mt1") === false ) || 
	isset($_GET['advanced_search']) ) ){ 
 	 
		$gg = explode("LIMIT ",$wp_query->request);	
		 
		$gg[0] = str_replace("".$wpdb->posts.".ID FROM", "".$wpdb->posts.".ID,
		".$wpdb->posts.".post_title, 
		".$wpdb->posts.".guid AS plink,		 		
		pm0.meta_value AS lat, 
		pm0.meta_key AS lat_key,
		pm1.meta_value AS log, 
		pm1.meta_key AS log_key, 		
		pm2.meta_value AS pic, 
		pm2.meta_key AS pic_key, 		
		b.guid AS photo,
		".$wpdb->posts.".post_content FROM", $gg[0]);
				
		$gg[0] = str_replace("WHERE 1=1", 		
		"INNER JOIN ".$wpdb->postmeta." pm0 ON (".$wpdb->posts.".ID = pm0.post_id AND pm0.meta_key ='map-lat' AND pm0.meta_value !='' )		
		INNER JOIN ".$wpdb->postmeta." pm1 ON (".$wpdb->posts.".ID = pm1.post_id AND pm1.meta_key ='map-log'  AND pm1.meta_value !='' ) 		
		LEFT JOIN ".$wpdb->postmeta." pm2 ON (".$wpdb->posts.".ID = pm2.post_id AND pm2.meta_key ='_thumbnail_id'  )		
		LEFT JOIN (SELECT t1.* FROM ".$wpdb->posts." AS t1 WHERE t1.post_type='attachment' LIMIT 1 ) AS b ON b.ID = pm2.meta_value 		
		WHERE 1=1", $gg[0]); 
		
		$gg[0] = str_replace("ORDER BY post_date", "ORDER BY ".$wpdb->posts.".post_date",$gg[0]);
		$gg[0] = str_replace("SELECT", "SELECT DISTINCT",$gg[0]);
		$gg[0] = str_replace("post_type = 'post'", "post_type =  'listing_type'",$gg[0]);		
		$gg[0] = str_replace("ORDER BY wp_postmeta.meta_value+0", "ORDER BY ".$wpdb->posts.".post_date",$gg[0]);
		$gg[0] = str_replace("ORDER BY wp_postmeta.meta_value", "ORDER BY ".$wpdb->posts.".post_date",$gg[0]);
		$gg[0] = str_replace(" AND post_status = 'publish'", " ", $gg[0]);
		 	 
		// GET THE EXISTING SAVED OPTIONS
		$EXISTNGBANNERDATA = get_option('wlt_existing_mapdata');		
		if(isset($_GET['advanced_search']) || ( WLT_CACHING == false || ( strtotime($EXISTNGBANNERDATA['date']) < strtotime(current_time( 'mysql' )) ) ) ) {		
		 
			$mapdata = $wpdb->get_results($gg[0]." LIMIT 500" , OBJECT);
			 
			if( WLT_CACHING ){	 
			update_option("wlt_existing_mapdata", array("date" => date('Y-m-d H:i:s', strtotime(date('Y-m-d H:i:s'). "+24 hours") ), "values" => $mapdata), true);
			}
		 
		}else{
			$mapdata = $EXISTNGBANNERDATA['values'];			
		}
	 	
		$SETUP = 1;	
 
 		 
	}else{
	 
		$args = array(
		'post_type' => THEME_TAXONOMY.'_type',
		'orderby' => 'ID',
		'order' => 'desc',
		'no_found_rows' => true,
		'posts_per_page' => 490,
			'meta_query' => array (
				array (
				'key' => 'map-lat',
				'value' => '',
				 'compare' => '!='
				)		 
			),
		); 
		
		if ( WLT_CACHING == false ||  ( $mapdata = get_transient( 'googlemapdata_query_results1' ) ) === false  ) {
		 
			$my_query = new WP_Query($args); 
			$mapdata = $my_query->posts; 
		 	set_transient( 'googlemapdata_query_results1', $mapdata, 24 * HOUR_IN_SECONDS );
		}
		
		$SETUP = 2;
	}
	 
  
	if( is_array($mapdata) ) {	
						
		foreach($mapdata as $map){
		 
			 if($SETUP == 1){
			 
			 	$permalink 	= $map->plink;
				$long 		= $map->log;
				$lat 		= $map->lat;
				$image 		= $map->photo;
				$catID 		= 0;	
				$catName 	= "";
				
				if($image == ""){
					// GET IMAGE
					$image = $this->GETIMAGE($map->ID, false, array('pathonly' => true) ); 
				}
			 
			 }elseif($SETUP == 2){
			 
				// GET CATEGORY ID
				 $catID = 0; $catName = "none";
				$cat =  wp_get_object_terms( $map->ID , THEME_TAXONOMY );
				if(isset($cat[0])){
					$catID = $cat[0]->term_id;
					$catName = $cat[0]->name;		
				}		
			  
				// GET LISTING DATA
				$permalink 	= get_permalink($map->ID);
				$long 		= get_post_meta($map->ID,'map-log',true);	
				$lat 		= get_post_meta($map->ID,'map-lat',true);					
				
				// GET IMAGE
				$image = $this->GETIMAGE($map->ID, false, array('pathonly' => true) ); 
				
			}
			
			// SETUP JASON DATA
			$json[] = array(	
			"id"	=> $map->ID,	
			"lat" 	=> $lat,
			"long" 	=> $long, 
			"url"  	=> $permalink,
			"title" => esc_html(str_replace("'","",substr(strip_tags($map->post_title),0,28))),
			"desc" 	=> esc_html(str_replace("'","",substr(strip_tags($map->post_content),0,110))),
			"img" 	=> $image,
			"catid" => $catID,	
			"catname" => $catName,	 
			);	
		}
 
	}  
 
	// RETURN JASON OUTPUT
	if($output){
		if(empty($json)){ return ""; }else{ return json_encode($json);  }
	}else{
		if(empty($json)){ return ""; }else{ return $json; }
	}
}

function wlt_googlemap_search(){ global $post, $query, $wpdb, $CORE;  

	// DONT SHOW FOR CART
	if(defined('WLT_CART')){ return; }
	
	// DISLPAY MAP CODE
	if(!isset($GLOBALS['CORE_THEME']['display_search_map'] ) || ( isset($GLOBALS['CORE_THEME']['display_search_map'] ) && $GLOBALS['CORE_THEME']['display_search_map']  == "")){ ?>
	
	<?php echo $this->wlt_googlemap_html(false); ?>
	
	<?php } ?>
 
<?php }


	
	// BUILDS THE PAYMENT OPTONS FORM
	function PAYMENTOPTIONS($data){
 	
	// HOOK INTO THE PAYMENT GATEWAY ARRAY 
	$gatway = hook_payments_gateways($GLOBALS['core_gateways']); $STRING = "";
	
		// MAKE SURE WE HAVE GATEWAYS AVAILABLE 
		if(is_array($gatway) ){	 
			// CREATE ORDER ID 
			 
			$GLOBALS['total'] 		= $data['total'];
			$GLOBALS['subtotal'] 	= $data['subtotal'];
			$GLOBALS['shipping'] 	= $data['shipping'];
			$GLOBALS['tax'] 		= $data['tax'];
			$GLOBALS['discount'] 	= $data['discount'];
			$GLOBALS['items'] 		= $data['items'];
			
			$GLOBALS['orderid'] 	= "CART-".$data['session'];
			$GLOBALS['description'] = ""; 
			
			$STRING .= '<div id="wlt_paymentoptionsbox">';
			
			// LOOP AND DISPLAY GATEWAYS		 
			foreach($gatway as $Value){
			 
				if(get_option($Value['function']) == "yes" ){ // GATEWAY IS ENABLED 	
						
					if( $Value['function'] == "gateway_bank" ){ 
					
					$STRING .= wpautop(get_option('bank_info'));
					
					// NOT BIG FORMS
					}elseif( !isset($Value['ownform']) ){
						
						// MAIN GATEWAY CONTENT	 
					   $STRING .= '
					   <div class="row-old">
					   <div class="col-md-8"><b>'.get_option($Value['function']."_name").'</b></div>
					   <div class="col-md-4">'.($Value['function']($_POST)).'</div>
					   <div class="clearfix"></div>
					   </div>
					   <hr />'; 
						
					}else{						
						$STRING .= ''.$Value['function']($_POST).'<div class="clearfix"></div>'; 								
					} // end if		
				}// end if				
			} // end foreach	
			
			$STRING .= '</div>';
					
			return $STRING;			
		} // end if	
	}
	
	
	function PRINTPAGE(){ global $wpdb,$CORE;
	
	$GLOBALS['flag-single'] = TRUE;
	// GET THE POST DATA FOR PRINT
	$post = get_post($_GET['pid']);
	$GLOBALS['post'] = $post;
	
 	// GET THE SYSTEM DATE FORMAT SET BY WP
	$date_format = get_option('date_format') . ' ' . get_option('time_format');
	$date = mysql2date($date_format, $post->post_date, false);
	/*** get image ***/
	$image = hook_image_display(get_the_post_thumbnail($post->ID, 'thumbnail', array('class'=> "wlt_thumbnail")));	 		
 
	$fields = do_shortcode('[FIELDS postid="'.$post->ID.'"]');
	
	$sc = array( 
	'[FIELDS]' => $fields,
	);
	
	$BODY_CONTENT = stripslashes($GLOBALS['CORE_THEME']['printcode']);
	
	// FALLBACK TO DEFAULTS
	if($BODY_CONTENT == ""){
	$BODY_CONTENT = '<div class="center">
	<p id="postTitle">[TITLE]</p>
	<p id="postMeta">Date:<strong>[DATE]</strong>  </p>
	<p id="postLink">[LINK]</p>   
	<div id="postContent">[CONTENT]</div>     
    <div id="postFields">[FIELDS]</div>
	<p id="printNow"><a href="#print" onClick="window.print(); return false;" title="Click to print">Print</a></p>
	</div>';
	}
	
	foreach($sc as $k=>$v){
	$BODY_CONTENT = str_replace($k,$v,$BODY_CONTENT);
	}
	// INCLUDE CORE HOOK FUNCTION
	$BODY_CONTENT = hook_item_cleanup($CORE->ITEM_CONTENT($post,hook_content_single_listing_print($BODY_CONTENT)));
	
	?>
	 	
	<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN">
	<html xmlns="http://www.w3.org/1999/xhtml" dir="ltr" lang="en-US">
	<head>	
		<title><?php echo $TITLE; ?></title>
		<meta name="Robots" content="noindex, nofollow" />
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
		<link rel="stylesheet" href="<?php echo FRAMREWORK_URI; ?>css/css.core_print.css" media="screen" />
	</head>
	<body id="<?php echo THEME_TAXONOMY; ?>_printstyles">
	<?php echo $BODY_CONTENT; ?>
	</body>
	</html>	
	<?php	
	die();
	} 
 
/* =============================================================================
	  UPDATE FUNCTIONALITY
========================================================================== */
function UPDATE_CHECK(){
	
	global $wpdb; $canContinue=true;	 
	
	// DONT CHECK FOR LOCALHOST 
	if($this->get_client_ip() == "127.0.0.1"){ return; }
 
		// CHECK FOR UPDATES
		$updateserver = 'http://www.premiumpress.com/_themes/';
		$estr = '?t='.$GLOBALS['CORE_THEME']['template']."&v=".THEME_VERSION."&l=".get_option("wlt_license_key")."&w=".get_site_url()."&e=".get_option('wlt_license_email');
		 
		$response = wp_remote_get( $updateserver . 'version_check.php'.$estr );
		 	
		// CHECK RESPONSE
		if( !is_wp_error( $response ) ) {
				$newversion = $response['body'];
		} else {
			return false;
		}
		// SEE IF WE HAVE UPDATES AVAILABLE
		if($newversion == "0.0.0"){
			// FLUSH CACHE FOR FREE UPGRADE
			update_option("wlt_license_key","");
			update_option("wlt_license_upgrade","1");
			return "0.0.0";
		}				 
		// return
		return;	 
} 
/* =============================================================================
  EMAIL FUNCTION
   ========================================================================== */
   
function SENDSMS($msg, $from = "ALERT"){

	$url = "https://rest.nexmo.com/sms/json?api_key=".$GLOBALS['CORE_THEME']['wlt_nexmo_api'].
				"&api_secret=".$GLOBALS['CORE_THEME']['wlt_nexmo_se'].
				"&from=".$from.
				"&to=".$GLOBALS['CORE_THEME']['wlt_nexmo_c'].$GLOBALS['CORE_THEME']['wlt_nexmo_num'].
				"&text=".urlencode($msg);
		 
	$response = wp_remote_post( $url );
	if ( is_wp_error( $response ) ) {
		$error_message = $response->get_error_message();
		echo "Something went wrong: $error_message";
	}
				


}
function SENDEMAILALERT($alert){ global $post, $userdata; $sms_msg = ""; 

 
	foreach($this->wlt_emails_alerts as $key => $field){
	
	if(!isset($GLOBALS['CORE_THEME'][$key]) || ( isset($GLOBALS['CORE_THEME'][$key]) && $GLOBALS['CORE_THEME'][$key] != 1 ) ){ continue; }
	
		if($alert == $key){
		
			switch($key){
			
				case "wlt_alert_login_failed": {
				
					$message = "Email Alert Triggered<br>";
					$message .= "<br>Type: <b>".$field['n']."</b>"; 
					$message .= "<br>Date: ".hook_date(date('Y-m-d H:i:s'))."<br>"; 
					$message .= "<br>Username: ".esc_attr($_POST['log']);
					$message .= "<br>User IP: ".$this->get_client_ip()."<br>";
					
					$message .= "<br>Page: http://" . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
					
					$sms_msg = $field['n']." / ".$_SERVER['HTTP_HOST']." / User: ".esc_attr($_POST['log']);
					
				} break;
				case "wlt_alert_login_success": {
				 
					$message = "Email Alert Triggered<br>";
					$message .= "<br>Type: <b>".$field['n']."</b>"; 
					$message .= "<br>Date: ".hook_date(date('Y-m-d H:i:s'))."<br>"; 
					$message .= "<br>User: ".esc_attr($_POST['log']); 
					$message .= "<br>User IP: ".$this->get_client_ip()."<br>";					
					$message .= "<br>Page: http://" . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
					
					$sms_msg = $field['n']." / ".$_SERVER['HTTP_HOST']." / User: ".esc_attr($_POST['log']);
				  
				} break;
				case "wlt_alert_register": {
				  
					$message = "Email Alert Triggered<br>";
					$message .= "<br>Type: <b>".$field['n']."</b>"; 
					$message .= "<br>Date: ".hook_date(date('Y-m-d H:i:s'))."<br>"; 
					$message .= "<br>User: ".esc_attr($_POST['user_login']).""; 
					$message .= "<br>User IP: ".$this->get_client_ip()."<br>";					
					$message .= "<br>Page: http://" . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
					
					$sms_msg = $field['n']." / ".$_SERVER['HTTP_HOST']." / User: ".esc_attr($_POST['user_login']);
				  
				} break;
				
				case "wlt_alert_listing_new": {
				
					$message = "Email Alert Triggered<br>";
					$message .= "<br>Type: <b>".$field['n']."</b>"; 
					$message .= "<br>Date: ".hook_date(date('Y-m-d H:i:s'))."<br>"; 
					$message .= "<br>User: ".$userdata->data->display_name." (".$userdata->data->ID.")"; 
					$message .= "<br>User IP: ".$this->get_client_ip()."";
					$message .= "<br>Listing: <a href='".get_permalink($GLOBALS['PID'])."'>".esc_attr($_POST['form']['post_title'])."</a><br>"; 					
					$message .= "<br>Page: http://" . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
					
					$sms_msg = $field['n']." / ".$_SERVER['HTTP_HOST']." / User: ".$userdata->data->display_name." / Title: ".esc_attr($_POST['form']['post_title'])." / Link: ".get_permalink($GLOBALS['PID']).""; 
				
				
				} break;
				
				case "wlt_alert_listing_edit": {
				
					$message = "Email Alert Triggered<br>";
					$message .= "<br>Type: <b>".$field['n']."</b>"; 
					$message .= "<br>Date: ".hook_date(date('Y-m-d H:i:s'))."<br>"; 
					$message .= "<br>User: ".$userdata->data->display_name." (".$userdata->data->ID.")"; 
					$message .= "<br>User IP: ".$this->get_client_ip()."";
					$message .= "<br>Listing: <a href='".get_permalink($GLOBALS['PID'])."'>".esc_attr($_POST['form']['post_title'])."</a><br>"; 					
					$message .= "<br>Page: http://" . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
					
					$sms_msg = $field['n']." / ".$_SERVER['HTTP_HOST']." / User: ".$userdata->data->display_name." / Title: ".esc_attr($_POST['form']['post_title'])." / Link: ".get_permalink($GLOBALS['PID']).""; 
				
				
				} break;
			
			}
			
			//die($message);
 
			// SEND TO EMAIL
			if($GLOBALS['CORE_THEME']['wlt_email_alert_sendemail'] == 1){
			
				// EMAIL FILTERS		 
				add_filter('wp_mail_content_type',create_function('', 'return "text/html";'));	
				apply_filters( 'wp_mail_content_type', "text/html" );
			
			
				$message .= "<br><br>This email was sent from your website (".$_SERVER['HTTP_HOST'].") by the Email Alert system built into the PremiumPress theme.";
				$message .= "<br>If you do not wish to receive this email please login and disable the email alert tool.";
		
				wp_mail(
				$GLOBALS['CORE_THEME']['wlt_email_alert_email'],
				"EMAIL ALERT {".$field['n']."}", 
				stripslashes(wpautop($message))); 
			
			}
			
			// SEND SMS OPTION
			if($GLOBALS['CORE_THEME']['wlt_email_alert_sendsms'] == 1){
		 	
				$this->SENDSMS($sms_msg);
				
			}
		
		}
	}
 
}   

function SENDEMAIL($emailAddress,$emailID, $custom_title = "", $custom_msg =""){

	global $CORE, $post, $userdata, $wpdb; $extra_shortcodes = array();
	// CHECK IF THE ADMIN AS ASSIGNED AN EMAIL FOR THIS ACTION
	if($emailID != "custom"){
		if(!is_numeric($emailID) && is_string($emailID) && !isset($GLOBALS['CORE_THEME']['emails'][$emailID]) ){ 
			return; 
		}elseif(!is_numeric($emailID) && is_string($emailID)){
			$emailID = $GLOBALS['CORE_THEME']['emails'][$emailID];
		}
	}	
	// CONFIRM EMAIL TYPE
	if($emailAddress == "admin"){	
		$emailTo = get_option('admin_email');
		 	 
	}elseif(is_numeric($emailAddress)){	
		$user_info = get_userdata($emailAddress); 		
		$emailTo = $user_info->user_email;
		
			// LOOP IN ADDITIONA DATA
			foreach($user_info->data as $key => $val){	
			$extra_shortcodes[$key] = $val;
			}
			// TO-DO LOOP IN REG FIELD DATA			
	}else{	
		$emailTo = $emailAddress;
	}
 	// HEADERS
	$headers[] = "Content-Type: text/html; charset=\"" .get_option('blog_charset') . "\"\n"; 
			
	// CHECK IF THE EMAIL ASSIGNED EXISTS
	if($emailID == "custom"){	
		$subject = $custom_title;
		$message = $custom_msg;	
		if($emailAddress != "admin" && !is_numeric($emailAddress)){
		$emailTo = $emailAddress;	
		}	
		$unsubscriptlink = get_home_url()."/confirm/unsubscribe/".$emailTo;
		$message = str_replace("(unsubscribe)",$unsubscriptlink,$message);
			 
	}else{
		// GET ARRAY OF EMAIL DAYA
		$wlt_emails = get_option("wlt_emails");
		if(!isset($wlt_emails[$emailID])){ return; /*die("No email configured for this form.");*/ }	
	 	
		// MESSAGE CONTENT
		$subject = $wlt_emails[$emailID]['subject'];
		$message = $wlt_emails[$emailID]['message'];

		// ADJUSTMENT FOR LISTING CONTACT FORM
		if(isset($_POST['email']) && strlen($_POST['email']) > 4){			
			//MESSAGE HEADERS		 
			$headers[] = 'From: '.$_POST['name'].' <'.$_POST['email'].'>';			 
		}else{		
			// DEFAULT MESSAGE HEADERS
			$from_name = $wlt_emails[$emailID]['from_name'];
			if(strlen($from_name) > 2){ 
			$headers[] = 'From: '.$from_name.' <'.$wlt_emails[$emailID]['from_email'].'>';
			}else{ 
			$headers[] = 'From: '.get_option('emailfrom').' <'.get_option('admin_email').'>';
			}		
		}		
		 
		$bbc_name = $wlt_emails[$emailID]['bcc_name'];
		if(strlen($bbc_name) > 1){ 
		$headers[] .= 'Bcc: '.$bbc_name.' <'.$wlt_emails[$emailID]['bcc_email'].'>';
		}
	}
	
	// USERNAME
	if(!isset($_POST['username']) && !isset($GLOBALS['username']) && $userdata->ID){
	$_POST['username'] = $userdata->display_name;
	}
	
	// FIRST LAST NAME
	if(isset($userdata->first_name)){
	$_POST['firstname'] 		= $userdata->first_name;
	}
	if(isset($userdata->last_name)){
	$_POST['lastname'] 		= $userdata->last_name;
	}
	
	// DISPLAY NAME
	$_POST['displayname'] 		= $userdata->display_name;
	if(!isset($_POST['user_email'])){
	$_POST['user_email'] 		= $userdata->user_email;
	}
	
	// REGISTERED DATE
	if(!isset($_POST['user_registered']) && isset($userdata->user_registered) ){
	$_POST['user_registered'] 	= hook_date($userdata->user_registered);
	}else{
	$_POST['user_registered'] 	= hook_date(date('Y-m-d'));
	}
	if(!isset($_POST['link'])){
	$extra_shortcodes['link'] 		= get_bloginfo('siteurl'); 
	}
	// ADD IN ADDITONAL SHORTCODES 
	$extra_shortcodes['blog_name'] 	= get_bloginfo('name');	
	$extra_shortcodes['date'] 		= date('Y-m-d'); 
	$extra_shortcodes['post_date'] 	= hook_date(date('Y-m-d')); 
	$extra_shortcodes['time'] 		= date('h:i:s A');

	// PERFORM STRING REPLACE ON ENTIRE MESSAGE CONTENT	
	if(is_array($_POST)){
		foreach($_POST as $key=>$value){
			if(is_array($value)){
				foreach($value as $key1=>$val1){
					if(is_array($val1)){
					
					}else{
					$message = str_replace("(".$key1.")",$val1,$message);
					$subject = str_replace("(".$key1.")",$val1,$subject);
					}// end if
				} // end foreach			
			}else{
			if(!is_object($value)){
			$message = str_replace("(".$key.")",$value,$message);
			$subject = str_replace("(".$key.")",$value,$subject);
			}
			}		 
		}// end foreach
	}// end if
	
	// CHECK EXTRA SHORTCODES
	foreach($extra_shortcodes as $key=>$val){
	$message = str_replace("(".$key.")",$val,$message);
	$subject = str_replace("(".$key.")",$val,$subject);
	}
	
	// CLEAN UPDATE EMPTY TAGS
	if(is_admin()){
	$message = preg_replace("/\([^)]+\)/", '******', $message);
	}else{
	if (strpos($message, '(seller_name)') !== false) {
		$id = get_the_ID();
		$author_id=$id->post_author; 
		$user= get_user_by('id', $id);
		$name = $user->display_name;
		$message =   str_replace('(seller_name)',$name,$message);
		
	}else{
		$message = preg_replace("/\([^)]+\)/", '', $message);
	}
	}	
	
	// EMAIL FILTERS		 
	add_filter('wp_mail_content_type',create_function('', 'return "text/html";'));	
	apply_filters( 'wp_mail_content_type', "text/html" );	
	
	// ADD LOG
	$CORE->ADDLOG("Email Sent (".$emailTo.") (".$emailID.") - ".stripslashes($subject), $userdata->ID, 0 ,'label-info');
	
	if(isset($GLOBALS['CORE_THEME']['wordpress_autopdisable']) && $GLOBALS['CORE_THEME']['wordpress_autopdisable'] == 1){	
	
		// SEND MESSAGE	
		wp_mail($emailTo,stripslashes($subject), "<html><body>".stripslashes($message)."</body></html>", $headers); 
	
	}else{
	
		// SEND MESSAGE	
		wp_mail($emailTo,stripslashes($subject), "<html><body>".stripslashes(wpautop($message))."</body></html>", $headers); 
	
	}
	
	 
}

function SLIDERS(){  return ""; /** REMOVED IN 6.4 ***/ }

// RETUNS A COUNT FOR HOW MANY PACKAGES ARE VISIBLE (NOT HIDDEN)
function _PACKNOTHIDDEN($c){ $count = 0;
if(is_array($c) && !empty($c) ){
	foreach($c as $v){
		if( ( !isset($v['hidden']) ) || ( isset($v['hidden']) && $v['hidden'] != "yes" )){
		$count++;
		}
	}
}
return $count;
} 

// PUTS THE MEMBERSHIP PACKAGES ON THE REGISTRATION PAGE
function _show_memberships_on_registration(){ global $CORE;

if($GLOBALS['CORE_THEME']['show_mem_registraion'] != '1'){ return; }

echo  '<h4>'.$CORE->_e(array('login','30')).'</h4><p>'.$CORE->_e(array('login','31')).'</p><input type="hidden" name="membershipID" id="membershipID" value="" />';

echo '<div class="packagesblock"><ul class="packagelistitems list-group">'.str_replace($CORE->_e(array('button','21')),$CORE->_e(array('login','19')),str_replace("document.MEMBERSHIPFORM.submit();","jQuery('.btn').removeClass('btn-success');jQuery(this).removeClass('btn-primary').addClass('btn-success');",$CORE->packageblock(2,'membershipfields',10))).'</ul></div><hr />';

}

// FIX BLANK TEXT WIDGET TITLES
function widget_title_link( $title ) {
	return $title."&nbsp;";
}
 
function get_comment_form($postid,$tabbed=false) { global $CORE, $wpdb, $post, $userdata; $comment_count = get_comments_number( $postid );
		   
			ob_start();
			try {
			 
			comments_template();  // GET THE DEFAULT WORDPRESS TEMPLATE FOR COMMENTS
			
			}
			catch (Exception $e) {
				ob_end_clean();
				throw $e;
			}  
			$comment_form = ob_get_clean();
	 
	 		// CUSTOM CODE BUTTON
			$reg_nr1 = rand("0", "9"); $reg_nr2 = rand("0", "9"); $bb = "";
			 	 
			// STAR RATING SYSTEM
			if(isset($GLOBALS['CORE_THEME']['rating']) && $GLOBALS['CORE_THEME']['rating'] == 1){
			
			$bb .= " <script type='text/javascript'>jQuery(document).ready(function(){ jQuery('#wlt_star_".$post->ID."').raty({path: '".FRAMREWORK_URI."img/rating/',score: 0,size: 24, }); }); </script>";
				
			$bb .= ' <hr /> <div class="form-group clearfix">
				 <label class="control-label col-md-5">'.$CORE->_e(array('single','50')).'</label>
				 <div class="input-group controls col-md-6">		
				 
				<div id="wlt_star_'.$post->ID.'" class="wlt_starrating"></div>
				
				 </div>
			</div>';
			}	
			
			ob_start(); ?>
			<?php comment_id_fields(); 
			
			$bb .= ob_get_clean();		
			
			if( !isset($GLOBALS['CORE_THEME']['comment_captcha']) || (  isset($GLOBALS['CORE_THEME']['comment_captcha']) && $GLOBALS['CORE_THEME']['comment_captcha'] == 1 ) ){	
			$bb .= '
			
			<hr />
			
			<div class="form-group clearfix">
				 <label class="control-label col-md-5">'.$CORE->_e(array('single','5')).'</label>
				 <div class="input-group controls col-md-3">		
				 
				 	<span class="input-group-addon"> '.$reg_nr1.' + '.$reg_nr2.' = </span>
						 
					<input type="text" name="reg_val" tabindex="500" class="form-control"> 
					
					<input type="hidden" name="reg1" value="'.$reg_nr1.'" />
					<input type="hidden" name="reg2" value="'.$reg_nr2.'" />
				 </div>
			</div>
			
			<hr />
			
			<div class="clearfix"></div>';
			
			}
			
				
			$comment_form = preg_replace('/<input name="submit" type="submit" id="submit"(.+)>/', $bb.'<div class="btnbox"><button name="submit" class="btn btn-success btn-lg" type="submit" id="submit"(.+)>'.
			$CORE->_e(array('comment','7')).'</button></div>', $comment_form);
		  
			// RETURN CODE		
			return $comment_form;
	}

function reports($date1, $date2, $runnow=false, $returnSQL=false){ global $wpdb, $CORE, $userdata; $SQL = array(); $core_admin_values = get_option("core_admin_values");

	// IF ITS A CRON, MAKE SURE THE USER HAS ENABLED THE REPORT AND EMAIL
	if(!$runnow){
		if(!isset($core_admin_values['wlt_report']) || isset($core_admin_values['wlt_report']['email']) && $core_admin_values['wlt_report']['email'] == ""  ){
		return "";
		}
	}
 		
 	// DEFAULTS FOR DATES
	if($date1 == ""){ $date1 = date('Y-m-d', strtotime('-7 days')); }
	if($date2 == ""){ $date2 = date('Y-m-d'); }
	 	
		// TOP 10 RECENT LISTINGS
		if($core_admin_values['wlt_report']['f1'] == 1 || $returnSQL == true){
			 
			$SQL[] = array(
					"sql" => "SELECT ID, post_title, post_date FROM ".$wpdb->posts." 
					WHERE ".$wpdb->posts.".post_status='publish'
					AND ".$wpdb->posts.".post_type='".THEME_TAXONOMY."_type'
					AND ".$wpdb->posts.".post_date >= '" .$date1. "' AND ".$wpdb->posts.".post_date < '".$date2."'
					ORDER BY ".$wpdb->posts.".ID DESC
					LIMIT 0,10", 
			"title" => "10 MOST RECENT LISTINGS",
			"date" => true,					
			);		
		 
		}// end f1
				
		// TOP 10 POPULAR LISTING
		if($core_admin_values['wlt_report']['f2'] == 1 || $returnSQL == true){
				
			$SQL[] = array(
					"sql" => "SELECT ".$wpdb->posts.".ID, ".$wpdb->posts.".post_title, ".$wpdb->postmeta.".meta_value FROM ".$wpdb->posts." 
					INNER JOIN ".$wpdb->postmeta." ON ( ".$wpdb->postmeta.".post_id = ".$wpdb->posts.".ID AND ".$wpdb->posts.".post_status='publish' AND ".$wpdb->posts.".post_type='".THEME_TAXONOMY."_type')
					WHERE ".$wpdb->postmeta.".meta_key = ('hits')
					AND ".$wpdb->posts.".post_date >= '" . $date1 . "' AND ".$wpdb->posts.".post_date < '".$date2."'
					ORDER BY ".$wpdb->postmeta.".meta_value+0 DESC
					LIMIT 0,10",
			"title" => "10 MOST POPULAR LISTINGS",
			"hits" => true,
			);	
				
		} // end f2
				
		// TOP 10 USER RATED LISTINGS
		if($core_admin_values['wlt_report']['f3'] == 1 || $returnSQL == true){
				
			$SQL[] = array(
					"sql" => "SELECT ".$wpdb->posts.".ID, ".$wpdb->posts.".post_title, ".$wpdb->postmeta.".meta_value FROM ".$wpdb->posts." 
					INNER JOIN ".$wpdb->postmeta." ON ( ".$wpdb->postmeta.".post_id = ".$wpdb->posts.".ID AND ".$wpdb->posts.".post_status='publish' AND ".$wpdb->posts.".post_type='".THEME_TAXONOMY."_type')
					WHERE ".$wpdb->postmeta.".meta_key = ('starrating_votes')
					AND ".$wpdb->posts.".post_date >= '" . $date1 . "' AND ".$wpdb->posts.".post_date < '".$date2."'
					ORDER BY ".$wpdb->postmeta.".meta_value+0 DESC
					LIMIT 0,10",
			"title" => "10 MOST RATED LISTINGS",
			"rating" => true,
			);	
				
		} // end f3
				
		// TOP 10 ORDERS
		if($core_admin_values['wlt_report']['f4'] == 1 || $returnSQL == true){
				
			$SQL[] = array(
					"sql" => "SELECT order_id as post_title, order_total as meta_value, autoid as meta_value1 FROM `".$wpdb->prefix."core_orders`
					WHERE ".$wpdb->prefix."core_orders.order_date >= '" . $date1 . "' AND ".$wpdb->prefix."core_orders.order_date < '".$date2."'
					ORDER BY ".$wpdb->prefix."core_orders.autoid DESC LIMIT 0,10",
			"title" => "10 MOST RECENT ORDERS",
			"orders" => true,
			); 
				
		} // end f4
				
		// TOP 10 SEARCH TERMS
		if($core_admin_values['wlt_report']['f5'] == 1 || $returnSQL == true){
				
			$saved_searches_array = get_option('recent_searches');
			if(is_array($saved_searches_array) && !empty($saved_searches_array) ){ 
						 
						$saved_searches_array = $CORE->multisort( $saved_searches_array, array('views') ); $jj = array(); $i =0;
						foreach($saved_searches_array  as $key=>$searchdata){ if($i > 11){ continue; }
						
							if(strtotime($searchdata['first_view']) >= strtotime( date('Y-m-d H:i:s', strtotime('-7 days')) ) ){							
								$jj[$i]['post_title'] = str_replace("_"," ",$key);
								$jj[$i]['views'] = $searchdata['views'];
								$i++;
							}
						} // foreach
						
						$SQL[] = array(
						"sql" => "none",
						"title" => "10 MOST SEARCHED KEYWORDS",
						"array" => $jj
						);
											
			}
				
		} // end f5
 								
		// TOP 10 COMMENTS
		if($core_admin_values['wlt_report']['f6'] == 1 || $returnSQL == true){
				
			$SQL[] = array(
				 	
				"sql" => "SELECT DISTINCT ".$wpdb->comments.".comment_ID, ".$wpdb->comments.".comment_content AS post_title  
					FROM ".$wpdb->comments."
					LEFT OUTER JOIN $wpdb->posts ON ($wpdb->comments.comment_post_ID = $wpdb->posts.ID) 
					WHERE comment_approved = '1' AND comment_type = '' AND post_password = '' AND ".$wpdb->comments.".comment_date >= '" . $date1 . "' AND ".$wpdb->comments.".comment_date < '".$date2."'
					ORDER BY comment_date_gmt DESC LIMIT 10",
				"title" => "10 LATEST COMMENTS"
				); 
				 
			} // end f6
				
		// TOP 10 AUTHORS
		if($core_admin_values['wlt_report']['f7'] == 1 || $returnSQL == true){
			 
			$SQL[] = array(
					"sql" => "SELECT count(".$wpdb->posts.".ID) AS meta_value, ".$wpdb->users.".user_nicename AS post_title, ".$wpdb->posts.".post_author FROM ".$wpdb->posts." 
					INNER JOIN ".$wpdb->users." ON ( ".$wpdb->posts.".post_author = ".$wpdb->users.".ID )
					WHERE ".$wpdb->posts.".post_date >= '" . $date1 . "' AND ".$wpdb->posts.".post_date < '".$date2."'
					AND ".$wpdb->posts.".post_status='publish' AND ".$wpdb->posts.".post_type='".THEME_TAXONOMY."_type' 
					GROUP BY ".$wpdb->users.".user_nicename
					LIMIT 0,10",
				"title" => "10 MOST ACTIVE AUTHORS",
				"users" => true,
				); 
					 	 
		}// end f1
		
		if($returnSQL){ return $SQL; };
	 	
		// LOOP THROUGH AND RUN THE SQL QUERIES
		if(is_array($SQL)){ $STRING = "";
			
			foreach($SQL as $querystr){
				 
				if($querystr['sql'] == "none"){
						
							$STRING .= "<h4>".$querystr['title']."</h4><hr />";						
							$STRING .= '<div id="tb1" style="padding:20px; background:#fafafa"><table>';
								foreach ( $querystr['array'] as $r ) {									 
									$STRING .= "<tr>
										<td>".$r['post_title']."</td>
										<td>".$r['views']." Searches</td>
										<td><a href='".get_home_url().'/?s='.$r['post_title']."' style='text-decoration:none;background-color:#CC0000;color:#fff;padding:5px;'>Link</a><br></td>
									  </tr>";
								} // end foreach		
							$STRING .= "</table></div>";
						
										
				}else{ 
					$results = $wpdb->get_results($querystr['sql']);						
					$STRING .= "<h4>".$querystr['title']."</h4>";	
					if(!empty($results)){						
							$STRING .= '<div id="tb1"><table>';
								foreach ( $results as $r ) {
									 $hits = "";
									if($querystr['hits']){
										$hits = get_post_meta($r->ID,'hits',true);
										if($hits == ""){ $hits = "0 views"; }else{ $hits = $hits." views"; }
									}
									if($querystr['date']){
										$hits = hook_date($r->post_date);
									}
									if($querystr['rating']){
										$hits = $r->meta_value ." votes";
									}
									if($querystr['users']){
										$hits = $r->meta_value ." listings";
										$link = get_home_url()."/?s=&uid=".$r->post_author;
									}elseif($querystr['orders']){
										$hits = $GLOBALS['CORE_THEME']['currency']['symbol']."".$r->meta_value ."";
										$link = get_home_url()."/wp-admin/admin.php?page=6&id=".$r->meta_value;
									}else{
										$link = get_permalink($r->ID);
									}
									
									$STRING .= "<tr>
										<td>".$r->post_title."</td>
										<td>".$hits."</td>
										<td><a href='".$link."' style='text-decoration:none;background-color:#CC0000;color:#fff;padding:5px;'>Link</a><br></td>
									  </tr>";
								} // end foreach		
							$STRING .= "</table></div>";	
					}else{
					$STRING .= "No record found";
					}		
				} // end if	
			}// end foreach	
			 
			if(strlen($STRING) > 5){					
						// include pdf class 
						require_once (TEMPLATEPATH ."/framework/pdf/config/tcpdf_config_alt.php");
						require_once (TEMPLATEPATH ."/framework/pdf/tcpdf.php");
						// create new PDF document
						$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
						// set document information
						$pdf->SetCreator(PDF_CREATOR);
						$pdf->SetAuthor('Mark Fail');
						$pdf->SetTitle(get_bloginfo('name'));
						$pdf->SetSubject("Report Period (".$date1." - ".$date2.")");
						$pdf->SetKeywords('premiumpress, wordpress, themes ');
						// set default header data
						$pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, get_bloginfo('name'), "Report Period (".$date1." - ".$date2.")", array(0,64,255), array(0,64,128));
						$pdf->setFooterData(array(0,64,0), array(0,64,128));
						// set header and footer fonts
						$pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
						$pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));
						// set default monospaced font
						$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);
						// set margins
						$pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
						$pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
						$pdf->SetFooterMargin(PDF_MARGIN_FOOTER);
						// set auto page breaks
						$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);
						// set image scale factor
						$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);
						// set some language-dependent strings (optional)
						if (@file_exists(dirname(__FILE__).'/lang/eng.php')) {
							require_once(dirname(__FILE__).'/lang/eng.php');
							$pdf->setLanguageArray($l);
						}
						$pdf->setFontSubsetting(true);
						$pdf->SetFont('helvetica', '', 10);
						$pdf->AddPage();						
						$html = $STRING;
						$pdf->writeHTMLCell(0, 0, '', '', $html, 0, 1, 0, true, '', true);						
						// SAVE FILDE TO UPLAODS FIR
						$uploads = wp_upload_dir(); 						
						if($runnow){
							$saveDir = "pdf_website_report.pdf";
							$pdf->Output($saveDir, 'D');
						}else{
						$saveDir = $uploads['path']."/pdf_website_report.pdf";
						$saveDir1 = $uploads['url']."/pdf_website_report.pdf";
						$pdf->Output($saveDir, 'F');
						// EMAIL FILTERS		 
						add_filter('wp_mail_content_type',create_function('', 'return "text/html";'));	
						apply_filters( 'wp_mail_content_type', "text/html" );
						wp_mail(get_option('admin_email'),"Daily Website Report", "Report Link: ".$saveDir1." "); 
						}
					
				} // end if			
				
		} // end if 
	
	} // end report function 
 
/* =============================================================================
ADMIN MENU BAR EXTRAS
========================================================================== */

	// CUSTOM EDIT BAR OPTIONS
	function wlt_adminbar_menu_items($wp_admin_bar){
 
 
		$wp_admin_bar->add_node(array(
			'id' => 'wlt_adminbar_editor',
			'title' => '<i class="dashicons dashicons-dashboard" style="font-family: dashicons; font-size:18px;"></i>  Theme Quick Links',
			'meta'  => array( 'class' => 'quicklinksbtn' )
			));
			
		$wp_admin_bar->add_node(array(
			'id' => 'e0002',
			'title' => 'Overview',
			'parent' => 'wlt_adminbar_editor',
			'href' => home_url().'/wp-admin/admin.php?page=premiumpress',
		));				
			
		$wp_admin_bar->add_node(array(
			'id' => 'e0001',
			'title' => '--------------------------',
			'parent' => 'wlt_adminbar_editor',
			'href' => home_url().'/wp-admin/admin.php?page=1',
		));	

		$wp_admin_bar->add_node(array(
			'id' => 'e0',
			'title' => 'Manage Listings',
			'parent' => 'wlt_adminbar_editor',
			'href' => home_url().'/wp-admin/edit.php?post_type='.THEME_TAXONOMY.'_type',
		));	
		
		$wp_admin_bar->add_node(array(
			'id' => 'e00',
			'title' => '--------------------------',
			'parent' => 'wlt_adminbar_editor',
			'href' => home_url().'/wp-admin/admin.php?page=1',
		));	
						
		$wp_admin_bar->add_node(array(
			'id' => 'e1',
			'title' => 'Design Setup',
			'parent' => 'wlt_adminbar_editor',
			'href' => home_url().'/wp-admin/admin.php?page=15',
		));	
		
		$wp_admin_bar->add_node(array(
			'id' => 'e1c',
			'title' => 'Theme Setup',
			'parent' => 'wlt_adminbar_editor',
			'href' => home_url().'/wp-admin/admin.php?page=1',
		));	
  
		
		$wp_admin_bar->add_node(array(
			'id' => 'e3c',
			'title' => 'Language Setup',
			'parent' => 'wlt_adminbar_editor',
			'href' => home_url().'/wp-admin/admin.php?page=16',
		));	
  
		$wp_admin_bar->add_node(array(
			'id' => 'e4',
			'title' => 'Email Setup',
			'parent' => 'wlt_adminbar_editor',
			'href' => home_url().'/wp-admin/admin.php?page=3',
		));
		
		if(!defined('WLT_CART')){
		
		$wp_admin_bar->add_node(array(
			'id' => 'e5',
			'title' => 'Listing Setup',
			'parent' => 'wlt_adminbar_editor',
			'href' => home_url().'/wp-admin/admin.php?page=5',
		));
		
		}elseif(defined('WLT_CART')){
		
		$wp_admin_bar->add_node(array(
			'id' => 'e5',
			'title' => 'Tax &amp; Shipping',
			'parent' => 'wlt_adminbar_editor',
			'href' => home_url().'/wp-admin/admin.php?page=9',
		));
		}
		
		$wp_admin_bar->add_node(array(
			'id' => 'e6',
			'title' => 'Advertising Setup',
			'parent' => 'wlt_adminbar_editor',
			'href' => home_url().'/wp-admin/admin.php?page=7',
		));
		
		$wp_admin_bar->add_node(array(
			'id' => 'e7',
			'title' => 'Orders &amp; Payments',
			'parent' => 'wlt_adminbar_editor',
			'href' => home_url().'/wp-admin/admin.php?page=6',
		));
		
	}
	
/* =============================================================================
MOBILE OPTIONS
========================================================================== */

	
	function pageswitch(){
	
		if(defined('IS_MOBILEVIEW')){
			return 'mobile';
		}	
	}
	
	// FUNCTION TO CHECK THE USERS BROWSER TYPE FOR MOBILE DEVICES
	function isMobileDevice(){
	 
		// DEBUG
		if(defined('WLT_DEBUG_MOBILE')){
		 
			define('IS_MOBILEVIEW', true); 
		}

		// GET THE BROWSER AGENTS
        $agent = $_SERVER["HTTP_USER_AGENT"]; 	
 
		// CHECK FOR FACEBOOK
		if (strpos(strtolower($agent), "facebook") === false) { }else{ return false;}	
		 
        $mobile = false;
        $agents = array("Alcatel", "Blackberry", "HTC",  "LG", "Motorola", "Nokia", "Palm", "Samsung", "SonyEricsson", "ZTE", "Mobile", "iPhone", "iPod", "Mini", "Playstation", "DoCoMo", "Benq", "Vodafone", "Sharp", "Kindle", "Nexus", "Windows Phone");
        foreach($agents as $a){
		 
            if(stripos($agent, $a) !== false){
			
				// SET CONSTANT
				define('IS_MOBILEVIEW', true); 
				                
                return true;
            }
        }
        return false;
	}	
	
	
 	
	
}// END CLASS










































/* =============================================================================
CRON JOBS
========================================================================== */

function wlt_hourly_event_hook_do(){ global $CORE;

	// EXPIRY EMAILS
	$CORE->EXPIRED();
	
	// ADD LOG ENTRY
	$CORE->ADDLOG("{cron job} hourly event completed", 0, $_POST['pid'] ,'label-info');

}
function wlt_twicedaily_event_hook_do(){

}
function wlt_daily_event_hook_do(){ global $CORE;
	
	// EMAIL THE REPORT DAILY
	$CORE->reports(date('Y-m-d H:i:s'),date('Y-m-d H:i:s' , strtotime('-2 days')),false);
 
}
add_action( 'wlt_hourly_event_hook', 'wlt_hourly_event_hook_do' );
add_action( 'wlt_twicedaily_event_hook', 'wlt_twicedaily_event_hook_do' );
add_action( 'wlt_daily_event_hook', 'wlt_daily_event_hook_do' );


/* =============================================================================
WALKER CLASSES
========================================================================== */

class Walker_CategorySelection extends Walker_Category {  


     function start_el(&$output, $item, $depth=0, $args=array(), $id = 0) { global $CORE; 
	 
		// CAT PRICES
		if(!isset($GLOBALS['catprices'])){
		$GLOBALS['catprices'] = get_option('wlt_catprices'); 
		if(!is_array($GLOBALS['catprices'])){ $GLOBALS['catprices'] = array(); }
	 	}
		
		$GLOBALS['thiscatitemid'] = $item->term_id; 
		  
		// CHECK IF WE HAVE AN ICONS
		$image = "";		
		if(isset($GLOBALS['CORE_THEME']['category_icon_small_'.$item->term_id]) && strlen($GLOBALS['CORE_THEME']['category_icon_small_'.$item->term_id]) > 1){			
			$image = "<i class='fa ".$GLOBALS['CORE_THEME']['category_icon_small_'.$item->term_id]."'></i>"; 
		}		 
		
        $output .= "<li class=\"list-group-item\">";
		
		// CATEGORY VIEW
		$output .= "<a href='".esc_url( get_term_link( $item ) )."' class='pull-right hidden-xs' target='_blank'><small>".' (' . number_format( $item->count ) . ')'. " ".$CORE->_e(array('button','35'))."</small> </a>";
		
		// CHECK IF PARENT CAT IS DISABLED
		$disableParent = "";
		if(isset($GLOBALS['tpl-add']) && isset($GLOBALS['CORE_THEME']['disablecategory']) && $GLOBALS['CORE_THEME']['disablecategory'] == 1 && $item->parent == 0 ){	
		$disableParent = "disabled=disabled";
		}
		
		// CHECK FOR CAT PRICE
		$eprice = ""; $ejquery = "";
		if(isset($GLOBALS['catprices'][$item->term_id]) && is_numeric($GLOBALS['catprices'][$item->term_id]) && !in_array($item->term_id, explode(",",$args['selected']))  ){ 
				$eprice = " (+".hook_price($GLOBALS['catprices'][$item->term_id]).')'; 
				
				if($GLOBALS['CORE_THEME']['show_enhancements'] == 1){
				$ejquery = "onclick=\"listingenhancement('catb".$item->term_id."',".$GLOBALS['catprices'][$item->term_id].")\"id='catb".$item->term_id."'";
				}
		}
		
		// TEXT AND LINKS 
		if(in_array($item->term_id, explode(",",$args['selected']))){
		$output .= " <div class='tcbox'><input type='checkbox' class='tcheckbox' name='form[category][]' value='".$item->term_id."' ".$ejquery." checked=checked ".$disableParent."></div>";
		}else{
		$output .= " <div class='tcbox'><input type='checkbox' class='tcheckbox' name='form[category][]' value='".$item->term_id."' ".$ejquery." ".$disableParent."></div>";
		}		
		
		// DISPLAY
		$output .= "<span class='twrap'> ".$image." <strong>".esc_attr( $item->name )."</strong> ".$eprice." </span>";	 
		
		// FLAG
		$GLOBALS['lastparent_id'] = $item->term_id;
		 
		
    }  

    function end_el(&$output, $item, $depth=0, $args=array(), $id = 0) {  
        $output .= "</li>\n";  
    }  
	
	function start_lvl( &$output,  $depth = 0, $args = array(), $id = 0 ) { global $item;
 	 
		if ( 'list' != $args['style'] )
			return;

		$indent = str_repeat("\t", $depth);		
		
		// HIDE CATS
		$output .= '<a href="javascript:void(0);" class="label label-default hidesub'. $GLOBALS['thiscatitemid'].'" style="display:none;"  
		onclick="jQuery(\'.hidesub'. $GLOBALS['thiscatitemid'].'\').hide(); jQuery(\'.showsub'. $GLOBALS['thiscatitemid'].'\').show(); jQuery(\'.subcats_'.$GLOBALS['thiscatitemid'].'\').hide();"> <i class="glyphicon glyphicon-chevron-up"></i> </a>';
		
		$output .= ' <a href="javascript:void(0);" style="background:#ddd" class="label label-warning showsub'. $GLOBALS['thiscatitemid'].'"  
		onclick="jQuery(\'.hidesub'. $GLOBALS['thiscatitemid'].'\').show(); jQuery(\'.showsub'. $GLOBALS['thiscatitemid'].'\').hide(); jQuery(\'.subcats_'.$GLOBALS['thiscatitemid'].'\').show();"><i class="glyphicon glyphicon-chevron-down"></i></a> ';
		
		$output .= "<div  class='subcats_".$GLOBALS['thiscatitemid']."' style='display:none;'>";		
	
		// WRAPPER
		$output .= "<div style='max-height:600px; margin:0px; margin-top:10px; padding:0px; overflow: scroll;padding-right:10px;padding-bottom:10px;border-top:1px solid #ddd;padding-bottom:5px;'>";
 		
		// LIST
		$output .= "$indent<ul class='children' style='margin:0px;padding:0px; margin-top:10px; background:#fafafa;'>\n";
	}
	
	function end_lvl( &$output, $depth = 0, $args = array(), $id = 0 ) {
		if ( 'list' != $args['style'] )
			return;

		$indent = str_repeat("\t", $depth);
		$output .= "$indent</ul></div></div>\n";
	}
	
	
}



 
?>
