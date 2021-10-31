<?php
 

class wlt_admin { 
 
	function __construct(){ global $pagenow, $CORE, $userdata;
 	 	
		// 0. SWITCHED THEME
		add_action('switch_theme', 			array($this,'_theme_deactivated') );
		add_action('after_switch_theme', 	array($this,'_theme_activated') );
		
		// 0.1 CHILD THEME INSTALLATION
		add_action('upgrader_post_install', array( $this, 'childtheme_installation' ));
		
		// 1. ADMIN STYLES IN HEADER/FOOTER
		add_action('admin_head', 	array($this, '_admin_head' ) );
		add_action('admin_footer', 	array($this, '_admin_footer') );
		add_action('admin_enqueue_scripts', array($this, '_admin_enqueue_scripts') );
		
		// REMOVE PASSWORD FROM ADMIN
		if( !current_user_can( 'edit_user', $userdata->ID ) ) {
			add_filter( 'show_password_fields', '__return_false' );			
		}
		
		// 2. LOAD IN ADMIN MENU
		add_action('admin_menu', 	array($this, '_admin_menu' ) ); 
		add_action('admin_menu', 	array($this, '_admin_menu_plugins' ) );
		// 3. MAIN INIT
		add_action('init',	array($this, '_init' ) );
		
		// 3. ADMIN INIT
		add_action('admin_init',	array($this, '_admin_init' ) );
		
		// EDITING LISTINGS
		add_action('admin_menu', array($this, '_custom_metabox' ) );
		add_action('add_meta_boxes', array($this, '_add_meta_boxes' ) );
		add_filter('tiny_mce_before_init', array( $this, 'myformatTinyMCE' ) );
		add_filter('wp_dropdown_users', array($this, '_wp_dropdown_users' ) );
		add_action('post_submitbox_misc_actions', array( $this, '_edit_listing_sideoptions' ) );	
		add_action('admin_head-edit.php', array( $this, '_edit_listing_quick_add_script' ) );
		
		// LISTING CATEGORY
		add_filter('edited_terms', array( $this, 'wlt_update_icon_field' )); 
			 
		// REMOVE/ CHANGE WP INTERFACE ITEMS
		//add_action('customize_register', array($this, 'themename_customize_register')); 
		
		// ADMIN SAVE DATA
		add_action('save_post',  array( $this, '_save_post' ), 10, 2);
		
			// CUSTOMIZE - POSTS DISPLAY PAGE
			add_filter('manage_posts_columns', array( $this, '_admin_remove_columns' ));
			add_filter('manage_posts_columns', array( $this, '_admin_custom_columns' ) );	
			add_action('manage_posts_custom_column', array( $this, '_admin_custom_column_data' ), 10, 2);
			add_filter('manage_edit-listing_type_sortable_columns', array( $this, '_admin_column_register_sortable' ) );
			add_filter('request', array( $this, '_admin_column_orderby' ) ); 
		
			// CUSTOMIZE - USERS
			add_filter('manage_users_columns', array($this, 'contributes' ) );
			add_action('manage_users_custom_column', array($this, 'contributes_columns' ) , 10, 3);		
			add_filter( 'manage_users_sortable_columns', array($this, 'contributes_sortable_columns' ) );
			
			// CUSTOMIZE - BANNERS
			add_filter('manage_wlt_banner_posts_columns', array( $this, '_admin_remove_columns' ));			
			add_filter('manage_wlt_banner_posts_columns',  array( $this, '_admin_custom_columns' )  );	
			add_action('manage_wlt_banner_posts_custom_column',  array( $this, '_admin_custom_column_data') , 10, 3  );	
		
			// CUSTOMIZE - CAMPAIGN
			add_filter('manage_edit-wlt_campaign_sortable_columns', array( $this, '_admin_column_register_sortable' ) );
			add_filter('manage_wlt_campaign_posts_columns', array( $this, '_admin_remove_columns' ));			
			add_filter('manage_wlt_campaign_posts_columns',  array( $this, '_admin_custom_columns' )  );	
			add_action('manage_wlt_campaign_posts_custom_column',  array( $this, '_admin_custom_column_data')  , 10, 3  );	
 	
			// ADMIN USER FIELDS
			add_filter('user_contactmethods', array($this,'userfields'),10,1); 
			add_action('show_user_profile', array($this,'extra_user_profile_fields') );
			add_action('edit_user_profile', array($this,'extra_user_profile_fields') );
			add_action('personal_options_update', array($this,'save_extra_user_profile_fields') );
			add_action('edit_user_profile_update', array($this,'save_extra_user_profile_fields') );	
		 	
			// QUICK EDIT LINKS
			add_filter('post_row_actions', array($this, 'extra_post_row_actions' ));
			
			// SLOW QUERY FIX
			add_action('admin_menu', array($this, 'remove_metaboxes' ) );
 
	}	
	// SLOW QUERY - REMOVE META BOX IN EDITING LISTINGS
	function remove_metaboxes() {
	 
		if(WLT_CACHING){
			 remove_meta_box( 'postcustom', 'listing_type', 'normal' );
			 remove_meta_box( 'postcustom', 'page', 'normal' );
			 remove_meta_box( 'postcustom', 'post', 'normal' );
		}
	}
	// THEME IS ACTIVATED 
	function _theme_activated(){
		core_admin_0_theme_activated();
	}
	// THEME IS DEACTIBATED
	function _theme_deactivated(){
		core_admin_01_theme_deactivated();
	}
	// LOAD IN STYLES
	function _admin_enqueue_scripts(){ global $post;	
	  
		wp_register_style( 'wlt_admin_styles', FRAMREWORK_URI.'admin/css/wpglobal.css');
		wp_enqueue_style( 'wlt_admin_styles' ); 
 	
		if( ( isset($_GET['post_type']) && $_GET['post_type'] == "listing_type" ) || (isset($post->post_type) && $post->post_type == "listing_type" ) ){
		
			// TOOLTIP
			wp_enqueue_script('jquery-ui-tooltip');
 	
			// LOAD IN BOOTSTRAP STYLES FOR EDITOR	
			add_editor_style( FRAMREWORK_URI.'/css/css.bootstrap.css' );			
			// CORE FRAMEWORK SCRIPTS
			wp_register_script( 'wlt_admin_scripts',  FRAMREWORK_URI.'admin/js/scripts.js');
			wp_enqueue_script( 'wlt_admin_scripts' );	
						
		}		
	
	}
	// THEME HEADER STYLES
	function _admin_head(){ global $pagenow, $post;
 
		switch($pagenow){
			
			case "edit.php": {
				
				// FOR POP-UP EDITORS ON LISTING RESULTS SCREEN
				wp_enqueue_script('media-upload');
				wp_enqueue_script('thickbox');
				wp_enqueue_style('thickbox'); 
			
			} break;
			case "theme-install.php":
			case "themes.php": {		
				// ADD IN EXTRAS
				wp_register_script( 'ex1',  FRAMREWORK_URI.'admin/js/extra1.js');
				wp_enqueue_script( 'ex1' );
			} break;
			case "widgets.php": {
			
				wp_enqueue_script('wf_wn_common', THEME_URI .'/framework/widgets/js/wn-common.js', array(), '1.0');
				wp_enqueue_script('wf_wn_tipsy', THEME_URI .'/framework/widgets/js/jquery.tipsy.js', array(), '1.0');
				wp_enqueue_script('jquery-ui-dialog');
				
				wp_enqueue_style('wp-jquery-ui-dialog');
				wp_enqueue_style('wn-style', THEME_URI .'/framework/widgets/css/wn-style.css', array(), '1.0');
		
				// only for IE, no comment :(
				add_action('admin_head', array('wf_wn', 'admin_header'));
		
				// help content for tooltips
				add_action('admin_footer', array('wf_wn', 'admin_footer'));
				wp_register_style( 'extended-tags-widget', THEME_URI .'/framework/widgets/css/widget.css' );
				wp_enqueue_style( 'extended-tags-widget' );	 
				wp_enqueue_style( 'extended-tags-widget', THEME_URI .'/framework/widgets/css/widget-admin.css', false, 0.7, 'screen' );
				
			} break;
			
			default: {
			
  	
	  		    // DISPLAY WELCOME POINTER
				if(isset($_GET['firstinstall'])){	
				wp_enqueue_style( 'wp-pointer' );
				wp_enqueue_script( 'jquery-ui' );
				wp_enqueue_script( 'wp-pointer' );
				wp_enqueue_script( 'utils' );
				add_action('admin_footer', array($this, 'pointer_intro') );
				}
		 
			} break;
			
		} // END SWITCH
		
		
		 echo "<script type='text/javascript'>
                  jQuery(document).ready(function(){
                      jQuery('#post').attr('enctype','multipart/form-data');
                  });
              </script>";
			  
			 
			  
		// STYLES FOR POP-UP EDITOR	  
		if(isset($_GET['smalleditor']) ){
			echo "<style>#adminmenuback, #adminmenuwrap,#wpadminbar,#screen-options-link-wrap,#message, #wpfooter { display:none; } #wpcontent { margin-left:0px !important; padding-left:20px; background:#fff; } #wp-content-editor-tools { background:#fff; }</style>";
	 
			if(isset($_GET['att']) ){
				echo "<style>.postbox, #post-body-content, h1 { display:none; } #wlt_listingattachments { display:block; }</style>";
			}
		
		}
		
		// REMOVE INVALID TEXT FOR CHILD THEME UPLOADS
		if ( is_admin() && ( isset($_GET['action']) && $_GET['action'] == "upload-theme" )  && $pagenow == 'update.php'  ) { 	
			echo "<style>#wpbody-content p strong { display:none; }</style>";	
		}
		
		// ADD SHORTCODE FOR PAGE OPTIONS
		if( ( isset($_GET['post_type']) && $_GET['post_type'] == "page") || (isset($post->post_type) && $post->post_type == "page" ) ){?>
			
			
		<script language="javascript">
		function wltpopup(linka){
		tb_show("[WLT] Shortcode List",linka+"TB_iframe=true&height=600&width=900&modal=false", null);
					 return false;
		}
		 
		</script>	
	
		<?php }elseif( ( isset($_GET['post_type']) && $_GET['post_type'] == THEME_TAXONOMY."_type") || (isset($post->post_type) && $post->post_type == THEME_TAXONOMY."_type" ) ){
 
 
        ?>
	<script language="javascript">
    jQuery(function(){
 
    <?php if(isset($post->post_status) && $post->post_status == "pending" && !defined('WLT_CART') ){ $wlt_emails = get_option("wlt_emails"); ?>
    jQuery('#titlediv').before('<div id="message" class="updated below-h2" style="padding:10px;"><b style="font-size:18px;line-height:30px;">Listing Pending Approval</b><br /> If you are unhappy with this listing or require the user to provide more information, enter the reasons below;   <br><br><b>Comments:</b><br><textarea name="wlt_field[pending_message]" style="width:100%;height:50px;padding:5px;"><?php echo addslashes(get_post_meta($post->ID,'pending_message',true)); ?></textarea><br><br>Select an email to send to the lising author; <br> <select name="send_pending_email"><option value="">-- dont send any email --</option><?php 
        if(is_array($wlt_emails)){ 
            foreach($wlt_emails as $key=>$field){ 
                if(isset($core_admin_values['emails']) && $core_admin_values['emails'][$key1] == $field['ID']){	$sel = " selected=selected ";	}else{ $sel = ""; }
                echo '<option value="'.$field['ID'].'" '.$sel.'>'.stripslashes($field['subject']).'</option>'; 
            } 
        } 
        ?></select> <input type="submit" name="save" id="save-post" value="Save as Pending" class="button" style="float:right;"></div>');
    <?php } ?>
    
    });
    </script> 
     <?php }
			   
			  
	
	}
	// THEME FOOTER STYLES
	function _admin_footer(){ global $pagenow;
	
		if($pagenow == "options-permalink.php" ){  
		
			$default_perm = get_option('premiumpress_custompermalink');
			$default_perm1 = get_option('premiumpress_customcategorypermalink');
			if($default_perm == ""){
			$default_perm = THEME_TAXONOMY;
			}
			if($default_perm1 == ""){
			$default_perm1 = $default_perm."-category";
			}
		  
			echo "<script> 
			jQuery(document).ready(function(){
				jQuery('table.permalink-structure').prepend( '<tr><th><label><input type=\"hidden\" name=\"submitted\" value=\"yes\">PremiumPress Custom Slugs</label></th><td> <b> Listing Slug Name</b><br /><input name=\"adminArray[premiumpress_custompermalink]\" type=\"text\" value=\"".$default_perm."\" class=\"regular-text code\"><br><b> Category Slug Name</b><br /><input name=\"adminArray[premiumpress_customcategorypermalink]\" type=\"text\" value=\"".$default_perm1."\" class=\"regular-text code\"><p><p>IMPORTANT. This option will let you change the slug display name from /listing/ to your chosen value however doing so will change all of your existing listing permalinks. <br />This option is not recommend for established website as it will result in many 404 errors for existing listing.</p></td></tr>' );
			});
			</script>";		
		
		}
	}

 
	
	function _admin_menu(){ global $wpdb, $user, $menu, $submenu; $userdata = wp_get_current_user(); $license = get_option('wlt_license_key'); 

	
	// ADMIN DISPLAY OPTION
	$DEFAULT_STATUS = "activate_plugins"; // <-- SET FOR PERMISSION
	if(defined('WLT_DEMOMODE')  && !user_can($userdata->ID, 'administrator') ){
		$DEFAULT_STATUS = "edit_posts";
		$this->_admin_remove_menus();
	}
 	 
 	// CHANGE LABEL TO BLOG
    $menu[5][0] = 'Blog Manager';
    $submenu['edit.php'][5][0] = 'All Blog Posts';
    $submenu['edit.php'][10][0] = 'Add Blog Post';
	
	
	
	// HIDE IF THIS IS THE INITIAL SETUP
	if($license == ""){
		 
	add_menu_page('', "Installation", $DEFAULT_STATUS, 'premiumpress', array($this, '_admin_page_0' ), ''.get_bloginfo('template_url').'/framework/admin/img/menu/0.png', 3); 
  
	}else{
	
	add_theme_page( 'Child Themes', 'Child Themes',  $DEFAULT_STATUS, 'premiumpresschildthemes', 'theme-install.php?browse=premiumpress', 12 );
 
	// SITE OVERVIEW	 
	add_menu_page('', "Overview", $DEFAULT_STATUS, 'premiumpress', array($this, '_admin_page_0' ), ''.get_bloginfo('template_url').'/framework/admin/img/menu/1.png', '2'); 
   
	 	add_submenu_page('premiumpress', "PremiumPress Themes", 'Download Reports', 
		$DEFAULT_STATUS, '13', array($this, '_admin_page_13') );
	 
	 	if(!defined('WP_ALLOW_MULTISITE')){
		
		add_submenu_page('premiumpress', "PremiumPress Themes", 'Check Updates', 
		$DEFAULT_STATUS, 'update-core.php', '' );
		
		}
		
	
	add_menu_page('15', "Design Setup", $DEFAULT_STATUS, '15', array($this, '_admin_page_15' ), ''.get_bloginfo('template_url').'/framework/admin/img/menu/2.png', '3'); 
  
  		add_submenu_page('15', "PremiumPress Themes", 'Color Tool', 
		$DEFAULT_STATUS, 'customizeme', 'customizeme' ); 
		
		// SLIDER PLUGIN
		if(isset($GLOBALS['WLT_REVSLIDER'])  ){ 		
		add_submenu_page('15', "PremiumPress Themes", ' Home Page Slider', 
		$DEFAULT_STATUS, 'revslider' ); 
		}
	
		add_submenu_page('15', "PremiumPress Themes", 'Child Themes', 
		$DEFAULT_STATUS, 'theme-install.php?browse=premiumpress', '' );
			
		add_submenu_page('15', "PremiumPress Themes", 'Create Child Theme', 
		$DEFAULT_STATUS, '14', array($this, '_admin_page_14') );
		
		add_submenu_page('15', "PremiumPress Themes", 'Old Home Page Editor', 
		$DEFAULT_STATUS, '11', array($this, '_admin_page_11') ); 
		
	   	 	
	// HIDE IF THIS IS THE INITIAL SETUP	 
	add_menu_page('1', "Theme Setup", $DEFAULT_STATUS, '1', array($this, '_admin_page_1' ), ''.get_bloginfo('template_url').'/framework/admin/img/menu/3.png', '3.1'); 
  	 	
		if(!defined('WLT_HIDE_ADMIN_16')){ 
		add_submenu_page('1', "PremiumPress Themes", ' Language Setup', 
		$DEFAULT_STATUS, '16', array($this, '_admin_page_16') );
		}
		
		if(!defined('WLT_HIDE_ADMIN_3')){ 
		add_submenu_page('1', "PremiumPress Themes", ' Email Setup', 
		$DEFAULT_STATUS, '3', array($this, '_admin_page_3') );
		}
		
	 
		add_submenu_page('1', "PremiumPress Themes", ' User Setup', 
		$DEFAULT_STATUS, '1&tab=usersettings', array($this, '_admin_page_1') );
		 
		
		if(!defined('WLT_HIDE_ADMIN_5') &&  !defined('WLT_CART')){
		add_submenu_page('1', "PremiumPress Themes", ' Listing Setup', 
		$DEFAULT_STATUS, '5', array($this, '_admin_page_5') );
		}
	 	
		add_submenu_page('1', "PremiumPress Themes", ' Advertising Setup', 
		$DEFAULT_STATUS, '7', array($this, '_admin_page_7') );
		
	 
		if(defined('WLT_CART')){
		add_submenu_page('1', "PremiumPress Themes", ' Tax &amp; Shipping', 
		$DEFAULT_STATUS, '9', array($this, '_admin_page_9') );
		}  
	  
		add_submenu_page('1', "PremiumPress Themes", 'Toolbox', 
		$DEFAULT_STATUS, '4', array($this, '_admin_page_4') );
 
		
		if(!defined('WP_ALLOW_MULTISITE')){
		
		add_submenu_page('1', "PremiumPress Themes", 'Plugins', 
		$DEFAULT_STATUS, '10', array($this, '_admin_page_10') );
		 
		} 		
			
	// ORDER MANAGER	 
	add_menu_page('', "Order Manager", $DEFAULT_STATUS, '6', array($this, '_admin_page_6' ), ''.get_bloginfo('template_url').'/framework/admin/img/menu/5.png', '3.4'); 
    
		add_submenu_page('6', "PremiumPress Themes", 'Payment Gateways', $DEFAULT_STATUS, 
		'6&tab=gateways', array($this, '_admin_page_13') );
		
		add_submenu_page('6', "PremiumPress Themes", 'Coupon Codes', $DEFAULT_STATUS, 
		'6&tab=coupons', array($this, '_admin_page_13') ); 
		
		
	} 
	
	}
	// EXTRA MENU ITEMS FROM PLUGINS
	function _admin_menu_plugins(){
 
		$DEFAULT_STATUS = "activate_plugins";
		// ADD-ON FOR NEW MENU ITEMS
		if(!defined('WLT_DEMOMODE') && isset($GLOBALS['new_admin_menu']) && is_array($GLOBALS['new_admin_menu']) ){
			$sk = 3.5;
		 
			foreach($GLOBALS['new_admin_menu'] as $newmenu){ 
				foreach($newmenu as $key=>$menu){
					add_menu_page('', $menu['title'], $DEFAULT_STATUS, $key, $menu['function'],'dashicons-none', ''.$sk.'' );
					$sk = $sk  + 0.1;
				}
			}
		}	
	}
	// TEMPLATE HEADER
	function HEAD(){
	get_template_part('framework/admin/templates/admin', 'header' );		
	}
	// LOAD IN TEMPLATE FOOTER	
	function FOOTER(){	
	get_template_part('framework/admin/templates/admin', 'footer' );
	}
	// TEMPLATE PAGES
	function _admin_page_0() 		{  			include(TEMPLATEPATH . '/framework/admin/_0.php');  }
	function _admin_page_1() 		{  			include(TEMPLATEPATH . '/framework/admin/_1.php');  }	
	function _admin_page_2() 		{  			include(TEMPLATEPATH . '/framework/admin/_2.php');  }	 
	function _admin_page_3() 		{  			include(TEMPLATEPATH . '/framework/admin/_3.php');  }
	function _admin_page_4() 		{  			include(TEMPLATEPATH . '/framework/admin/_4.php');  }
	function _admin_page_5() 		{  			include(TEMPLATEPATH . '/framework/admin/_5.php');  }
	function _admin_page_6() 		{  			include(TEMPLATEPATH . '/framework/admin/_6.php');  }
	function _admin_page_7() 		{  			include(TEMPLATEPATH . '/framework/admin/_7.php');  }
	function _admin_page_8() 		{  			include(TEMPLATEPATH . '/framework/admin/_8.php');  }
	function _admin_page_9() 		{  			include(TEMPLATEPATH . '/framework/admin/_9.php');  }
	function _admin_page_10() 		{  			include(TEMPLATEPATH . '/framework/admin/_10.php');  }
	function _admin_page_11() 		{  			include(TEMPLATEPATH . '/framework/admin/_11.php');  }	 
	function _admin_page_13() 		{  			include(TEMPLATEPATH . '/framework/admin/_13.php');  }
	function _admin_page_14() 		{  			include(TEMPLATEPATH . '/framework/admin/_14.php');  }
	function _admin_page_15() 		{  			include(TEMPLATEPATH . '/framework/admin/_15.php');  }
	function _admin_page_16() 		{  			include(TEMPLATEPATH . '/framework/admin/_16.php');  }
	// MAIN WORDPRESS INIT
	function _init(){	global $CORE, $userdata;
		// SWITCH PAGES
		if(isset($_GET['page']) && user_can($userdata->ID, 'administrator') ){
		
			switch($_GET['page']){
			
				case "premiumpresschildthemes": {
				header("location: ".home_url()."/wp-admin/theme-install.php?browse=premiumpress");
				exit();	
				}
				
				case "13": {
				 		
				if( $_POST['runreportnow'] == "yes"){  $CORE->reports($_POST['date1'],$_POST['date2'],true); }			
				} break;
				
				case "supportcenter": {			
				header("location: http://www.premiumpress.com/forums/?theme=".$GLOBALS['CORE_THEME']['template']."&key=".get_option('wlt_license_key'));
				exit();			
				} break; 
				
				case "videotutorials": {						
				header("location: http://www.premiumpress.com/videos/?theme=".$GLOBALS['CORE_THEME']['template']."&key=".get_option('wlt_license_key'));
				exit();			
				} break;
				
				case "childthemes": {			
				header("location: http://childthemes.premiumpress.com/?responsive=1&theme=".$GLOBALS['CORE_THEME']['template']."&key=".get_option('wlt_license_key'));
				exit();			
				} break;	
				
				case "customizeme": {			
				header("location: ". home_url().'/wp-admin/customize.php?url='. home_url().'/?s=');
				exit();			
				} break;		
			
			}	
		} // end switch
	}
	
	// THIS FUNCTION IS USED TO UPDATE CHILD THEME STYLESHEET FILES
	function UPDATECHILDTHEME(){ global $wpdb, $CORE;  $f = wp_get_theme(); $user_ip = $CORE->get_client_ip(); 
	 
		// DONT CHECK FOR LOCALHOST
		
		if($user_ip == "127.0.0.1" &&  WP_CONTENT_DIR == "F:\SERVER\htdocs\WP/wp-content"){ return; }
		 
		$HandlePath = WP_CONTENT_DIR."/themes/";
		if($themes = opendir($HandlePath)) {      
			while(false !== ($theme = readdir($themes))){ 		
				if(strpos($theme,".") === false && substr($theme,0,9) == "template_" && file_exists($HandlePath.$theme."/style.css") ){	
				
					// OPEN THE CHILD THEME AND REPLACE THE THEME NAME WITH OUR SETUP ONE
					$file = $HandlePath.$theme."/style.css";				
					$file_contents = file_get_contents($file);			
					$fh = @fopen($file, "w");
					$file_contents = str_replace('[XXX]',$f->template,$file_contents);
					@fwrite($fh, $file_contents);
					@fclose($fh);				
				   
				}
			}			
		}
	
	} 
	function childtheme_installation( $ggg ){   
	   if(isset($_GET['action']) &&  $_GET['action'] == "install-theme"){	   
	   	die("<p>Child theme installed successfully.</p><p>Please activate, please click <a href='".get_home_url()."/wp-admin/themes.php'>here</a></p>");	   
	   } 
	}
	// ADMIN INIT
	function _admin_init(){ global $CORE, $userdata, $pagenow, $userdata, $wp_post_types; 
		
		
		// ON THEME OVERVIEW PAGE		 
		if ( user_can($userdata->ID, 'administrator') && $pagenow == 'themes.php'  ) {
		$this->UPDATECHILDTHEME();
		}
		
		// CUSTOM LABEL FOR BLOG
        $labels = &$wp_post_types['post']->labels;
        $labels->name = 'Blog Manager';
        $labels->singular_name = 'Blog';
		$labels->menu_icon		= ''; 
        $labels->add_new = 'Add Blog';
        $labels->add_new_item = 'Add Blog';
        $labels->edit_item = 'Edit Blog';
        $labels->new_item = 'Blog';
        $labels->view_item = 'View Blog';
        $labels->search_items = 'Search Blog Post';
        $labels->not_found = 'No Blog Post found';
        $labels->not_found_in_trash = 'No Blog Post found in Trash';
		
		
		// FIX FOR ADMIN QUERY
		if (strpos(strtolower($_SERVER['REQUEST_URI']), '/wp-admin') !== false && $userdata->ID)  {
				 
			$userdata = wp_get_current_user(); 
					
			if( !user_can($userdata->ID, 'administrator') &&  !user_can($userdata->ID, 'contributor') &&   !user_can($userdata->ID, 'editor')  ){
					  
				  wp_die(__('Oops! You do not have sufficient permissions to access this page.'));		 
				
			}
		}		
	
		// CUSTOM CATEGORY EDITS 
		if( isset($_GET['taxonomy']) && isset($_GET['post_type']) && ( $_GET['post_type'] == THEME_TAXONOMY."_type" ||  $_GET['post_type'] == "cproduct_type"  ) && $_GET['taxonomy'] != "post_tag" ){			
		
				// Load the pop-up for admin image uploads	
				wp_enqueue_script('media-upload');
				wp_enqueue_script('thickbox');
				wp_enqueue_style('thickbox');				
			 
				add_filter($_GET['taxonomy'].'_edit_form_fields', array( $this, 'my_category_fields'  ) );				 				
				add_filter( 'manage_edit-'.$_GET['taxonomy'].'_columns', array( $this, 'category_id_head' ) );
				add_filter( 'manage_'.$_GET['taxonomy'].'_custom_column', array( $this, 'category_id_row' ), 10, 3 );			
		} // end if
	
 
		// switch 
		if(isset($_GET['core_admin_aj']) && user_can($userdata->ID, 'administrator') ){
	
			if(isset($_GET['act']) && strlen($_GET['act']) > 1){
			 		
			update_post_meta($_GET['pid'],$_GET['act'],$_GET['value']);
			if($_GET['value'] == "yes"){
			echo "<a href='javascript:void(0);' onclick=\"WLTSaveAdminOp(".$_GET['pid'].",'no','".$_GET['act']."', '".$_GET['pid']."_yn');\"><img src='".get_template_directory_uri()."/framework/admin/img/yes.png' alt='' align='middle'></a>";
			}else{
			echo "<a href='javascript:void(0);' onclick=\"WLTSaveAdminOp(".$_GET['pid'].",'yes','".$_GET['act']."','".$_GET['pid']."_yn');\"><img src='".get_template_directory_uri()."/framework/admin/img/no.png' alt='' align='middle'></a>";
			}
			die();
			}	 
		}
	 	// EXPORT EMAIL ADDRESSES
		if(isset($_GET['exportall']) && is_numeric($_GET['exportall']) ){
				global $wpdb;
				$csv_output = ''; $ex  = ''; $dont_show_fields = array('autoid','payment_data','');
				
				if($_GET['exportall'] == 1){
					
					$file_name = "mailinglist";	
					$table = $wpdb->prefix."core_mailinglist";	  
					$RUNTHISSQL = "SELECT * FROM ". $wpdb->prefix."core_mailinglist";
				
				}elseif($_GET['exportall'] == 2){
							
					$file_name = "orderhistory";		
					$table = $wpdb->prefix."core_orders";	 
					$RUNTHISSQL = "SELECT * FROM ". $wpdb->prefix."core_orders GROUP BY order_id ORDER BY order_date";
				 
				}else{
					die("no table set");
				}			
		 
				// RUN QUERIES
				
				$headers = $wpdb->get_results("SHOW COLUMNS FROM ".$table."", ARRAY_A);
				$values = $wpdb->get_results($RUNTHISSQL, ARRAY_N);
				
				// GET HEADERS
				$csv_headers = array();
				if (!empty($headers)) {
					foreach($headers as $row){					
						$csv_headers[] =  $row['Field'];
					}				
				}
				
				// GET VALUES
				$csv_values = array();
				if (!empty($values)) {				
					foreach($values as $k => $row){				 			 
						$csv_values[] =  $row;					
					}				
				}			
				 
				// ADD-ON HEADERS
				foreach($csv_headers as $col_V){
					if(in_array($col_V,$dont_show_fields) ){ continue; }					 
					$csv_output .= str_replace("_"," ",$col_V).",";				 
				}
				
				// NEW LINE				
				$csv_output .= "\n";
				
				// ADD-ON VALUES
				foreach($csv_values as $vv){	
			 
					foreach($vv as $vk => $v){	
						if(in_array($csv_headers[$vk],$dont_show_fields)){ continue; }				 
						$csv_output .= $v.",";					
					}
					$csv_output .= "\n";
				}	 
				header("Pragma: public");
				header("Expires: 0");
				header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
				header("Cache-Control: private", false);
				header("Content-Type: application/octet-stream");
				header("Content-Disposition: attachment; filename=\"".$file_name.".csv\";" );
				header("Content-Transfer-Encoding: binary");
				echo $csv_output;
				die();
		}
		// CREATE CHILD THEME
		if(isset($_POST['dsample']) && current_user_can( 'edit_user', $userdata->ID ) ){
		  
		  //1. INCLUDE ZIP FEATURE
		  include(TEMPLATEPATH."/framework/class/class_pclzip.php");
		  $uploads = wp_upload_dir();
		  $template_name = "template_".str_replace(" ","_",strip_tags($_POST['name']));		  
		  
		  // 2. REMOVE OLD FILES
		  if (file_exists($uploads['path']."/".$template_name.".zip")) {
			@unlink($uploads['path']."/".$template_name.".zip"); 
		  }
		  
		  // 3. CREATE NEW STYLE.CSS
$cssContent = "/*
Theme Name: ".strip_tags($_POST['name'])."
Theme URI: http://www.premiumpress.com
Description: PremiumPress Child Theme
Author: ".get_option('admin_email')."
Author URI: ".get_home_url()."
Template: [XXX]
Version: 1.0
*/

";	
		  
		  	//3a. add-on core theme css
			if(isset($_POST['e3']) && $_POST['e3'] == 1 && $GLOBALS['CORE_THEME']['template'] != "" ){
			$core_css = file_get_contents(str_replace("functions/","",THEME_PATH)."/templates/".$GLOBALS['CORE_THEME']['template'].'/style.css');
			$cssContent .= $core_css;			
			}
			//3b. add-on custom css
			if(isset($_POST['e2']) && $_POST['e2'] == 1){
			$cssContent .= stripslashes(get_option('custom_css'));			
			}
			
			// SAVE THE NEW STYLE FILE		   
			$handle = fopen($uploads['path']."/style.css", "w");
			if (fwrite($handle, $cssContent) === FALSE) {
				echo "Cannot write to styles";
				die();
			 } 
		 
		  fclose($handle);
		  
		  // ADD IN CUSTOM FUNCTIONS DATA
		  if(isset($_POST['e1']) && $_POST['e1'] == 1){
		  
			// LOAD IN MAIN DEFAULTS
			$core_admin_values = get_option("core_admin_values"); 
			// SETUP CONTENT FOR HOME PAGE OBJECTS
			$block1 	= explode(",",$core_admin_values['homepage']['widgetblock1']);
			$EXPORTSTRING = "";
			foreach($block1 as $key => $it){
			// BREAK UP THE STRING				
			$ff 		= explode("_",$it);						
			$gg 		= explode("-", $ff[1]);
			$nkey		= $ff[0];
			$nrefid 	= $gg[0];
			$nvalue 	= $gg[1];
			$innerda = $core_admin_values['widgetobject'][$nkey][$nrefid];
			if(is_array($innerda) && !empty($innerda)) {
				$EXPORTSTRING .= "\n&#36;core_admin_values['widgetobject']['".$nkey."']['".$nrefid."'] = array(\n";
				foreach($innerda as $kk => $jj){
				if(!is_object($jj)){
				$EXPORTSTRING .= "'".$kk."' => \"".trim(preg_replace('/\r|\n/', '',str_replace('"',"'",$jj)))."\",\n";
				}
				}
				$EXPORTSTRING .= ");";
				$EXPORTSTRING = str_replace("&#36;",'$',$EXPORTSTRING);
			}
			}
		  		
			$funContent = '<?php
// TELL THE CORE THIS IS A CHILD THEME
define("WLT_CHILDTHEME", true);

// CHILD THEME LAYOUT SETTINGS
function childtheme_designchanges(){
				
				// LOAD IN CORE STYLES AND UNSET THE LAYOUT ONES SO OUR CHILD THEME DEFAULT OPTIONS CAN WORK
				$core_admin_values = get_option("core_admin_values"); 
			 
					// SET HEADER
					$core_admin_values["layout_header"] = "'.$core_admin_values['layout_header'].'";
					// SET MENU
					$core_admin_values["layout_menu"] = "'.$core_admin_values['layout_menu'].'";
					// SET RESPONISVE DESIGN
					$core_admin_values["responsive"] = "'.$core_admin_values["responsive"].'";
					// SET COLUMN LAYOUTS
					$core_admin_values["layout_columns"] = array(\'homepage\' => \''.$core_admin_values["layout_columns"]["homepage"].'\', \'search\' => \''.$core_admin_values["layout_columns"]["search"].'\', \'single\' => \''.$core_admin_values["layout_columns"]["single"].'\', \'page\' => \''.$core_admin_values["layout_columns"]["page"].'\', \'footer\' => \''.$core_admin_values["layout_columns"]["footer"].'\', \'2columns\' => \''.$core_admin_values["layout_columns"]["2columns"].'\', \'style\' => \''.$core_admin_values["layout_columns"]["style"].'\', \'3columns\' => \''.$core_admin_values["layout_columns"]["3columns"].'\');
					// SET WELCOME TEXT
					$core_admin_values["header_welcometext"] = "'.str_replace('"',"'",$core_admin_values["header_welcometext"]).'";        
					// SET RATING
					$core_admin_values["rating"] 		= "'.$core_admin_values["rating"].'";
					$core_admin_values["rating_type"] 	= "'.$core_admin_values["rating_type"].'";
					// BREADCRUMBS
					$core_admin_values["breadcrumbs_inner"] 	= "'.$core_admin_values["breadcrumbs_inner"].'";
					$core_admin_values["breadcrumbs_home"] 		= "'.$core_admin_values["breadcrumbs_home"].'"; 
					// TURN OFF CATEGORY DESCRIPTION
					$core_admin_values["category_descrition"] 	= "'.$core_admin_values["category_descrition"].'";	
					// GEO LOCATION
					$core_admin_values["geolocation"] 	= "'.$core_admin_values["geolocation"].'";
					$core_admin_values["geolocation_flag"] 	= "'.$core_admin_values["geolocation_flag"].'";
					// FOOTER SOCIAL ICONS
					$core_admin_values["social"] 	= array(
					\'twitter\' => \''.$core_admin_values["social"]["twitter"].'\', \'twitter_icon\' => \''.$core_admin_values["social"]["twitter_icon"].'\', 
					\'facebook\' => \''.$core_admin_values["social"]["facebook"].'\', \'facebook_icon\' => \''.$core_admin_values["social"]["facebook_icon"].'\', 
					\'dribbble\' => \''.$core_admin_values["social"]["dribbble"].'\', \'dribbble_icon\' => \''.$core_admin_values["social"]["dribbble_icon"].'\', 
					\'linkedin\' => \''.$core_admin_values["social"]["linkedin"].'\', \'linkedin_icon\' => \''.$core_admin_values["social"]["linkedin_icon"].'\', 
					\'youtube\' => \''.$core_admin_values["social"]["youtube"].'\', \'youtube_icon\' => \''.$core_admin_values["social"]["youtube_icon"].'\', 
					\'rss\' => \''.$core_admin_values["social"]["rss"].'\', \'rss_icon\' => \''.$core_admin_values["social"]["rss_icon"].'\',         
					);
					// FOOTER COPYRIGHT TEXT
					$core_admin_values["copyright"] 	= "'.str_replace('"',"'",$core_admin_values["copyright"]).'";
					// HOME PAGE OBJECT SETUP
					$core_admin_values["homepage"]["widgetblock1"] = "'.$core_admin_values["homepage"]["widgetblock1"].'";	
					'.$EXPORTSTRING.'	
					// SET ITEMCODE
					$core_admin_values["itemcode"] 	= "'.trim(preg_replace('/\r|\n/', '',str_replace("\'","'",str_replace('"',"'",$core_admin_values["itemcode"])))).'";
					// SET LISTING PAGE CODE
					$core_admin_values["listingcode"] 	= "'.trim(preg_replace('/\r|\n/', '',str_replace("\'","'",str_replace('"',"'",$core_admin_values["listingcode"])))).'";
					// SET PRINT PAGE CODE
					$core_admin_values["printcode"]  = "'.trim(preg_replace('/\r|\n/', '',str_replace("\'","'",str_replace('"',"'",$core_admin_values["printcode"])))).'";						
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
}?>';
	  
		  }else{
		  
			$funContent = '<?php
// TELL THE CORE THIS IS A CHILD THEME
define("WLT_CHILDTHEME", true);			
/*
			
Below are a handful of useful variables for you to use.
			
CHILD_THEME_NAME 		=  name of your theme
CHILD_THEME_PATH_URL 	= path to your child theme folder
CHILD_THEME_PATH_IMG 	= path to your child theme /img/ folder
CHILD_THEME_PATH_JS 	= path to your child theme /js/ folder
CHILD_THEME_PATH_CSS 	= path to your child theme /css/ folder
			
example usage;
			
<img src="<?php echo CHILD_THEME_PATH_URL; ?>screenshot.png" />
			 
			
// ADD ANY OF YOUR OWN FUNCTIONS BELOW
*/?>';
		  
		  }
		  
		  // SAVE CONTENT TO FUNCTIONS FILE
		   $handle = fopen($uploads['path']."/functions.php", "w");
			  if (fwrite($handle, $funContent) === FALSE) {
				echo "Cannot write to functions file";
				die();
			  } 
			  fclose($handle);	
 		
		  // 4. ZIP EVERYTHING TOGETHER	  
		  $zip = new PclZip($uploads['path']."/".$template_name.".zip");
		  $v_list = $zip->add($uploads['path']."/style.css,".$uploads['path']."/functions.php,".TEMPLATEPATH.'/framework/sampletheme/',PCLZIP_OPT_REMOVE_ALL_PATH, PCLZIP_OPT_ADD_PATH, $template_name);
		  
		  if ($v_list == 0) {
			die("Error : ".$zip->errorInfo(true));
		  } 
	
		$file = $uploads['path']."/".$template_name.".zip";
		$file_download = $uploads['url']."/".$template_name.".zip";
		?>
        <h1>Download Ready</h1>
        <p>Use the link below to download your child theme.</p>
        <p><a href="<?php echo $file_download; ?>"><?php echo $file_download; ?></a>
        <?php 
		die(); 
		if(file_exists($file)) {
				header('Content-Description: File Transfer');
				header('Content-Type: application/octet-stream');
				header('Content-Disposition: attachment; filename='.basename($file));
				header('Content-Transfer-Encoding: binary');
				header('Expires: 0');
				header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
				header('Pragma: public');
				header('Content-Length: ' . filesize($file));
				ob_clean();
				flush();
				readfile($file);
				exit;
		}else{
		die("Theme file unavailable.");
		} 	 
		} 
	
		// FIRST TIME INSTALLATION
		if(get_option("core_theme_defaults_loaded") == "" && isset($_POST['adminArray']['wlt_license_key']) ){	
		  
				$GLOBALS['CORE_THEME']['template'] = $_POST['admin_values']['template'];
				if(!isset($_POST['adminArray']['wlt_license_key_error'])){				
				core_admin_2_themeinstall();		 
				}				
				// SET LICENSE KEY
		 		update_option('wlt_license_key', $_POST['adminArray']['wlt_license_key'], true);
				// MAKE CHECKES
				if($CORE->UPDATE_CHECK() == "0.0.0"){
					header("location: ".get_home_url().'/wp-admin/admin.php?page=premiumpress');
					exit();
				}else{
					header("location: ".get_home_url().'/wp-admin/admin.php?page=1&firstinstall=1');
					exit();
				}// END IF
		}// END FIRST INSTALLATION
		
		// SYSTEM RESET
		if(isset($_POST['core_system_reset']) && $_POST['core_system_reset'] == "new"){		 	
			
			if(current_user_can( 'edit_user', $userdata->ID ) ){
			
			// RESET ALL CORE VALUES
			update_option('wlt_license_key','');
			update_option('wlt_license_upgrade', '');
			update_option("core_theme_defaults_loaded","");
			update_option("core_admin_values","");
			// REDIRECT TO DASHBOARD
			header("location: ".get_home_url().'/wp-admin/index.php');
			exit();
			
			}
		} // END SYSTEM RESET
		
		// SAVE ADMIN OPTIONS
		if(isset($_POST['submitted']) && $_POST['submitted'] == "yes" && !defined('WLT_DEMOMODE') ){
				
				// GET OLD OPTIONS
				$existing_values = get_option("core_admin_values");		 		
				
				// NEW CUSTOM LAYOUT BITS		 
				if(isset($_POST['customsearchpage']) && strlen($_POST['customsearchpage']) > 3 && file_exists(TEMPLATEPATH."/".$_POST['customsearchpage'].'.php') ){
				 
				$filec = file_get_contents(TEMPLATEPATH."/".$_POST['customsearchpage'].'.php', true);				
				$clean = preg_replace('#<\?.*?(\?>|$)#s', '', $filec);
				$_POST['admin_values']['itemcode'] = trim($clean);
				
				}
				
				if(isset($_POST['customlistingpage']) && strlen($_POST['customlistingpage']) > 3 && file_exists(TEMPLATEPATH."/".$_POST['customlistingpage'].'.php')  ){				
				
				$filec = file_get_contents(TEMPLATEPATH."/".$_POST['customlistingpage'].'.php', true);
				$clean = preg_replace('#<\?.*?(\?>|$)#s', '', $filec);		 
				$_POST['admin_values']['listingcode'] = trim($clean);
				
				}
			 
				// CHECK FOR TEMPLATE CHANGE AND ACTIVATE CHILD THEME HOOKS
				if(!isset($_POST['adminArray']['wlt_license_key']) && isset($_POST['admin_values']['template']) && $_POST['admin_values']['template'] != $GLOBALS['CORE_THEME']['template']){
				
					//if(file_exists(str_replace("functions/","",THEME_PATH)."/templates/".$_POST['admin_values']['template']."/_functions.php") ){		
					//include(str_replace("functions/","",THEME_PATH)."/templates/".$_POST['admin_values']['template'].'/_functions.php');
					//}
					// SET A FLAG SO WE KNOW WHAT THE THEME WAS
					$core_themes = array('template_coupon_theme','template_directory_theme','template_video_theme',
					'template_shop_theme','template_joboard_theme','template_realestate_theme','template_ideas_theme','template_classifieds_theme');
					if(in_array($GLOBALS['CORE_THEME']['template'],$core_themes)){
					update_option('wlt_base_theme',$GLOBALS['CORE_THEME']['template']);
					} 
				 								 
				}				
								
				if(isset($_POST['admin_values'])){	
				// GET THE CURRENT VALUES
				$existing_values = get_option("core_admin_values");
				// MERGE WITH EXISTING VALUES
				$new_result = array_merge((array)$existing_values, (array)$_POST['admin_values']);
				// UPDATE DATABASE 		
				update_option( "core_admin_values", $new_result, true);
				// LEAVE FRIENDLY MESSAGE
				$GLOBALS['error_message'] = "Changes Saved Successfully";
				} 
				
				// SAVE EXTRA DATA
				if(isset($_POST['adminArray'])){
		 
					$update_options = $_POST['adminArray']; 
					 
					foreach($update_options as $key => $value){
						if(is_array($value)){			 
							update_option( trim($key), $value, true);			 
						}else{ 		
							update_option( trim($key), trim($value), true);
						}		
					}
				
				}
				
				// NEW INSTALL REDIRECT
				if(isset($_POST['newinstall']) && $_POST['newinstall'] == "premiumpress"){				
				header("location: ".get_home_url().'/wp-admin/admin.php?page=premiumpress');
				exit();
				} 
				 					
			}// END SAVE ADMIN OPTION		
	}	
	// ADDS ALL USERS TO THE EDIT BOX IN WORDPRESS WHEN EDITING LISTINGS
	function _wp_dropdown_users($output){
    global $post, $wpdb;
	
  
	 
	if($post->post_type == "listing_type" && isset($_GET['action']) ){ 
	
		$wp_user_query =  new WP_User_Query( array(   'number' => 15, 'orderby' => 'post_count' ) ); //'role' => 'administrator',
		$users = $wp_user_query->get_results();		
 

		$output = "<select id=\"post_author_override\" name=\"post_author_override\" class=\"\">";
	
		//Leave the admin in the list
		if(isset($_GET['action']) && $_GET['action'] == "edit"){
		$output .= "<option value=\"".$post->post_author."\" selected=selected>User ID: ".$post->post_author."</option>";
		}
		if(is_array( $users )){
		foreach($users as $user)
		{
			$sel = ($post->post_author == $user->ID)?"selected='selected'":'';
			$output .= '<option value="'.$user->ID.'" '.$sel.'>'.$user->user_login.'</option>';
		}
		}
		$output .= "</select>";
	
	}
	 
	
    return $output;	
	}	
	// REMOVE MENU ITEMS FROM ADMIN 
	function _admin_remove_menus() {
		global $menu;
			$restricted = array('Dashboard','Media','Profile','Links','Pages','Appearance','Tools','Users','Settings','Comments','Plugins','Tools');
			end ($menu);
			while (prev($menu)){
				$value = explode(' ',$menu[key($menu)][0]);
				if(in_array($value[0] != NULL?$value[0]:"" , $restricted)){unset($menu[key($menu)]);}
			}
	}
	
	
	// POINTERS FOR INSTALLATION
	function pointer_welcome(){
			global $CORE_ADMIN;		 
			$id      = 'li.toplevel_page_premiumpress';
			$content = '<h3>' . 'Congratulations!' . '</h3>';
			$content .= '<p>' .  'You\'ve just activated your PremiumPress theme.' . '</p>';
			$opt_arr  = array(
						'content'  => $content,
						'position' => array( 'edge' => 'top', 'align' => 'center' )
					);
			$button2  =  "Begin Setup";
			$function = 'document.location="' . admin_url( 'admin.php?page=premiumpress' ) . '";';
			$this->print_scripts( $id, $opt_arr, "Close", $button2, $function );
	}
	function pointer_intro(){
			global $CORE_ADMIN;
			$id      = '#gotobtn';
			$content = '<h3>' .'Remember!'. '</h3>';
			$content .= '<p>' . 'Watch the video tutorial first then click here!' . '</p>';
			$opt_arr  = array(
						'content'  => $content,
						'position' => array( 'edge' => 'top', 'align' => 'center' )
					);
			$button2  = "";
			$function = 'document.location="' . admin_url( 'admin.php?page=premiumpress' ) . '";';
			$this->print_scripts( $id, $opt_arr, "Close", $button2, $function );
			
	}	
	function print_scripts( $selector, $options, $button1, $button2 = false, $button2_function = '', $button1_function = '' ) {
			?>
		<script type="text/javascript">
			//<![CDATA[
			(function ($) {
				var premiumpress_pointer_options = <?php echo json_encode( $options ); ?>, setup;
	
				function premiumpress_store_answer( input, nonce ) {
					var premiumpress_tracking_data = {
						action : 'premiumpress_allow_tracking',
						allow_tracking : input,
						nonce: nonce
					}
					jQuery.post( ajaxurl, premiumpress_tracking_data, function() {
						jQuery('#wp-pointer-0').remove();
					} );
				}
	
				premiumpress_pointer_options = $.extend(premiumpress_pointer_options, {
					buttons:function (event, t) {
						button = jQuery('<a id="pointer-close" style="margin-left:5px" class="button-secondary">' + '<?php echo $button1; ?>' + '</a>');
						button.bind('click.pointer', function () {
							t.element.pointer('close');
						});
						return button;
					},
					close:function () {
					}
				});
	
				setup = function () {
					$('<?php echo $selector; ?>').pointer(premiumpress_pointer_options).pointer('open');
					<?php if ( $button2 ) { ?>
						jQuery('#pointer-close').after('<a id="pointer-primary" class="button-primary">' + '<?php echo $button2; ?>' + '</a>');
						jQuery('#pointer-primary').click(function () {
							<?php echo $button2_function; ?>
						});
						jQuery('#pointer-close').click(function () {
							<?php if ( $button1_function == '' ) { ?>
								//premiumpress_setIgnore("tour", "wp-pointer-0", "<?php echo wp_create_nonce( 'premiumpress-ignore' ); ?>");
								<?php } else { ?>
								<?php echo $button1_function; ?>
								<?php } ?>
						});
						<?php } ?>
				};
	
				if (premiumpress_pointer_options.position && premiumpress_pointer_options.position.defer_loading)
					$(window).bind('load.wp-pointers', setup);
				else
					$(document).ready(setup);
			})(jQuery);
			//]]>
		</script>
		<?php
	}
 	
	
// FUNCTION CALLED WHEN SAVING THE ICON
	function wlt_update_icon_field($term_id) {
		
		if(isset($_POST['caticon'])){		   
		   
		    if(defined('WLT_COUPON') || defined('WLT_COMPARISON') ){ 
		    $_POST['admin_values']['category_website_'.$term_id] = strip_tags($_POST['websitelink']);	
		    }
			$_POST['admin_values']['category_icon_'.$term_id] = strip_tags($_POST['caticon']);	
			$_POST['admin_values']['category_icon_small_'.$term_id] = strip_tags($_POST['caticon1']);
				
			// GET THE CURRENT VALUES
			$existing_values = get_option("core_admin_values");
			// MERGE WITH EXISTING VALUES
			$new_result = array_merge((array)$existing_values, (array)$_POST['admin_values']);
			// UPDATE DATABASE 		
			update_option( "core_admin_values", $new_result, true);
			 
		} // end if
	}	
	
	// FUNCTION ADDS THE CATEGORY ICON TO THE ADMIN VIEW
	function category_id_head( $columns ) {		 
		//unset($columns['title']);	 
		unset($columns['description']);
		unset($columns['slug']);	
    	$columns['icon'] = 'Icon';		 
		$columns['id'] = 'ID';		 
    	return $columns;
		
	}	
	
	// FUNCTION ADDS IN AN EXTRA FIELD TO THE CATEGORY CREATION SO YOU CAN
	function category_id_row( $output, $column, $term_id ){
	
		global $wpdb; $icon ="";
 
		if( $column == 'id'){
		
			return $term_id;
		
		}elseif( $column == 'description'){
		
			return strip_tags(substr($output,0,100));
		
		}elseif( $column == 'icon'){	
			
			if(isset($GLOBALS['CORE_THEME']['category_icon_'.$term_id])){
			$imgPath = $GLOBALS['CORE_THEME']['category_icon_'.$term_id];
			}else{
			$imgPath = "";
			}
			
			if(strlen($imgPath) > 5){	 
			$icon = "<img src='".$imgPath."' style='max-width:50px; max-height:50px;' />";	
			}	 
			return $icon;
		
		}else{
		
			return $output;
		
		}
	 
	}
	function my_category_fields($tag) { global $wpdb;
	
		// LOAD IN MAIN DEFAULTS
		$core_admin_values = get_option("core_admin_values"); 
		
		?>
            <input type="hidden" value="" name="imgIdblock" id="imgIdblock" />
            
            <script type="text/javascript">
			
			function ChangeImgBlock(divname){ document.getElementById("imgIdblock").value = divname; }

            function ChangeCatIcon(){			
             ChangeImgBlock('caticon');
             formfield = jQuery('#caticon').attr('name');
             tb_show('', 'media-upload.php?type=image&amp;TB_iframe=true');
             return false;             
            }
			
			jQuery(document).ready(function() {			 
						
			window.send_to_editor = function(html) {
			
				var regex = /src="(.+?)"/;
				var rslt =html.match(regex);
				var imgurl = rslt[1];
			 
			 jQuery('#'+document.getElementById("imgIdblock").value).val(imgurl);
			 tb_remove();
			} 
			
			});
            
            </script>
		
            <table class="form-table">
            
            
            <tr class="form-field">
                    
                    <?php if(defined('WLT_COUPON') || defined('WLT_COMPARISON')){ ?>
                    
                       <th scope="row" valign="top"><label>Website Link</label></th>
                        <td><input name="websitelink" id="websitelink" type="text" size="40" style="width:300px;" aria-required="false" value="<?php echo $core_admin_values['category_website_'.$_GET['tag_ID']]; ?>" />   
                           </td>
                    </tr>
                    
                    <?php } ?>
            
                    <tr class="form-field">
                    
                       <th scope="row" valign="top"><label>CSS Icon (e.g: fa-cogs)</label></th>
                        <td><input name="caticon1" id="caticon1" type="text" size="40" style="width:300px;" aria-required="false" value="<?php echo $core_admin_values['category_icon_small_'.$_GET['tag_ID']]; ?>" />   
                        
                        <p>This icon is only used in the category widget list and only the icon name should be entered. e.g: fa-cogs</p> 
                        <p>Full icon list is found here: <a href="http://fortawesome.github.io/Font-Awesome/icons/" target="_blank">http://fortawesome.github.io/Font-Awesome/icons/</a>                    
                          </td>
                    </tr>
                     
                    
                        <th scope="row" valign="top"><label>Big Icon Path (http://..)</label></th>
                        <td><input name="caticon" id="caticon" type="text" size="40" aria-required="false" value="<?php echo $core_admin_values['category_icon_'.$_GET['tag_ID']]; ?>" />                        
                       <input type="button" size="36" name="upload_caticon" value="Upload Icon" onclick="ChangeCatIcon();" class="button" style="width:100px;">                   
                        
                        <div style="background:#efefef;border:1px solid #ddd; padding:20px; margin-top:20px;">
                        <p>Click any of the icons below to use it as your category image;</p>
                        <p><b>Large Icons</b></p>
                        <hr />
                           <?php
						
						$i=1;
	while($i < 57){
	
	echo "<img src='".get_template_directory_uri()."/framework/img/icons/".$i.".png' style='float:left; border:1px solid #ddd; background:#fff; padding:3px; margin-right:10px; margin-bottom:10px; cursor:pointer;' onclick=\"document.getElementById('caticon').value='".get_template_directory_uri()."/framework/img/icons/".$i.".png'\">";
	$i++;
	}
						
						?>
                        <div style="clear:both;"></div>
                        <hr />
                        <p><b>Small Icons</b></p>
                        <hr />
                         <?php
						
						$i=1;
	while($i < 57){
	
	echo "<img src='".get_template_directory_uri()."/framework/img/icons/".$i."s.png' style='float:left; border:1px solid #ddd; background:#fff; padding:3px; margin-right:10px; margin-bottom:10px; cursor:pointer;' onclick=\"document.getElementById('caticon').value='".get_template_directory_uri()."/framework/img/icons/".$i."s.png'\">";
	$i++;
	}
						
						?>
                          <div style="clear:both;"></div>
                         <hr />
                        <p><b>General Icons Pack 1</b></p>
                        <hr />
                        <div style="position:relative;">
                         <?php
						
						$i=1;
		while($i < 85){
	
	echo "<img src='".get_template_directory_uri()."/framework/img/iconpack1/".$i.".png' style='float:left; border:1px solid #ddd; background:#fff; padding:3px; margin-right:10px; margin-bottom:10px; cursor:pointer;' onclick=\"document.getElementById('caticon').value='".get_template_directory_uri()."/framework/img/iconpack1/".$i.".png'\">";
	$i++;
	}
						
						?>
                        </div>
 
                        
                        
                         <div style="clear:both;"></div>
                        </div>
                        </td>
                    </tr>
                     
            </table>
		
			 
	<?php }	
	
	function _save_post(){
	
	global $wpdb, $post, $CORE;	
 
		if(isset($_POST['post_type']) && ( $_POST['post_type'] == THEME_TAXONOMY."_type" || $_POST['post_type'] == "page" ) && isset($_POST['wlt_field']) && !empty($_POST['wlt_field']) ){
		 	
			// CHECK FOR FILE UPLOADS
			if(isset($_FILES['wlt_attachfile']) && is_array($_FILES['wlt_attachfile']) ){	 // && 
				$u=0;
				foreach($CORE->reArrayFiles($_FILES['wlt_attachfile']) as $file_upload){			
					if(strlen($file_upload['name']) > 1){
						 
						$responce = hook_upload($post->ID, $file_upload);
						 
						if(isset($responce['error'])){
							$canContinue = false;			
							$errorMsg = $responce['error'];
						}// end if
						$u++;
					} // end if			
				} // end foeach
			} // end if
			
			// CHECK FOR FILE DELETING
			if(isset($_POST['wlt_attachdelete']) && is_array($_POST['wlt_attachdelete'])){ 			
				foreach($_POST['wlt_attachdelete'] as $fileid){	
					$CORE->UPLOAD_DELETE($post->ID.'---'.$fileid);
				}			
			}
			
			// SAVE CUSTOM META DATA
			foreach($_POST['wlt_field'] as $key=>$val){
			update_post_meta($post->ID,$key,$val);	
			}
			
			
		}
		
		// UPDATE POST TYPE
		if(isset($_POST['hidden_post_type']) && $_POST['hidden_post_type'] != $_POST['hidden_post_type_old'] ){
		$SQL = "UPDATE ".$wpdb->prefix."posts SET ".$wpdb->prefix."posts.post_type='".$_POST['hidden_post_type']."' WHERE ID = '".$post->ID."' LIMIT 1";	
		$wpdb->query($SQL);		
		}
		
		// SEND OUT PENDING EMAIL IF SET
		if(isset($_POST['send_pending_email']) && $_POST['send_pending_email'] != ""){
		
		// ADD LOG ENTRY
		$CORE->ADDLOG('Admin sent an email regarding listing (<a href="(plink)"><b>['.$post->post_title.']</b></a>.', $userdate->ID,$post->ID,'label-info');
		
		
		$_POST['title'] 	 = $post->post_title;
			
		$CORE->SENDEMAIL($post->post_author,  $_POST['send_pending_email']);
		
		}
	}

	
 
	
	





/* =============================================================================
  [PREMIUMPRESS FRAMEWORK] VIEW/EDIT LISTING DISPLAY SETUP
   ========================================================================== */
   
function _admin_remove_columns($defaults) {
	
	if(isset($_GET['post_type']) && ( $_GET['post_type'] == THEME_TAXONOMY."_type" ||  $_GET['post_type'] == "cproduct_type"  )  ){  
	unset($defaults['tags']); 
	unset($defaults['title']); 
	unset($defaults['author']);
	unset($defaults['comments']);
	unset($defaults['date']);
	}
 
	return $defaults;
}
function _admin_column_register_sortable( $columns ) {
	$columns['price'] 		= 'Price'; 
	$columns['featured'] 	= 'Featured'; 
	$columns['hits'] 		= 'Views';  
	$columns['clicks'] 		= 'Clicks';
	$columns['qty'] 		= 'Quantity';
	$columns['expires'] 	= 'Expires';	
	$columns['impressions'] = 'Impressions';	
	return $columns;
}

function _admin_custom_columns($defaults) { global $post;

	if(isset($_GET['post_type']) && $_GET['post_type'] == "wlt_campaign"  ){
	
	$defaults['clicks'] 		= 'Clicks';  
	$defaults['impressions'] 	= 'Impression';  	
	$defaults['expires'] 		= 'Expires'; 
	
	}
	
	if(isset($_GET['post_type']) && $_GET['post_type'] == "wlt_banner"  ){
	$defaults['banner_img'] 		= 'Image';  
	}
	
	if(isset($_GET['post_type']) && $_GET['post_type'] == THEME_TAXONOMY."_type"  ){ 
	
		// TITLE
		$defaults['title'] 		= 'Listing Options';	 
		
		// PHOTO
		if(!defined('WLT_DISABLE_ADMIN_EDIT_FILES')){	 
			//$defaults['image'] 		= '<i class="dashicons dashicons-images-alt2 ppttooltip"><span>Display Photo</span> </i>';
		}
		
		// HITS		
		$defaults['hits'] 		= '<i class="dashicons dashicons-visibility ppttooltip"><span>Views</span></i>'; 
		
		// FEATURED
		$defaults['featured'] 	= '<i class="dashicons dashicons-star-filled ppttooltip"><span>Featured</span></i>';	
		
			if(defined('WLT_AUCTION')){		
				$defaults['bids'] 		= 'Bids'; 		
			}		
				
				
			if(defined('WLT_COUPON')){		
				$defaults['clicks'] 	= 'Clicks';		
			}
				
			if(defined('WLT_CART') ){
				$defaults['price'] 		= 'Price';
				//$defaults['qty'] 		= 'Quantity';
			}else{
				$defaults['expires'] 	= '<i class="dashicons dashicons-backup ppttooltip"><span>Expires</span></i>';
			}	
						
		//DATE	
		$defaults['date'] 		= 'Date';	
		
		// COMMENTS
		$defaults['comments'] 		= '<i class="dashicons dashicons-admin-comments ppttooltip"><span>Comments</span></i>';	
				
	}
	
	return $defaults;
	
}


function _admin_custom_column_data($column_name, $post_id ) {
 
global $wpdb, $CORE, $post; 
 
	switch($column_name){ 	
	
		case "banner_img": {
			$img = get_post_meta($post_id, 'img', true);
			if($img != ""){
			echo '<img src="'.$img.'" style="max-width:100%">';
			}
		} break;	
	
 		case "impressions": {
		$clicks = get_post_meta($post_id,"impressions",true);
		if($clicks == ""){ echo 0; }else{ echo $clicks; }
		} break;
		
		case "clicks": {
		$clicks = get_post_meta($post_id,"clicks",true);
		if($clicks == ""){ echo 0; }else{ echo $clicks; }
		} break;	
		
		case "bids": {
			$bidding_history = get_post_meta($post_id,'current_bid_data',true);
			if(is_array($bidding_history) && !empty($bidding_history) ){
				echo count($bidding_history);
			}else{
				echo 0;
			}
		} break;	
		case "qty": {
		echo get_post_meta($post_id,"qty",true);
		} break;	
		case "price": {
			$p = get_post_meta($post_id,"price",true);
			if($p == ""){
			echo "not set";
			}else{
			echo hook_price($p);
			}
		} break;
		
		case "expires": {
		 if(defined('WLT_COUPON')){
			$p = "expiry_date";
		}else{
			$p = "listing_expiry_date";
		}
		echo do_shortcode('[TIMELEFT postid="'.$post->ID.'" layout="2" text_before="" text_ended="Not Set" key="'.$p.'"]');
		 
		} break;
		case "featured": {
			$is_featured = get_post_meta($post_id,"featured",true);
		 
			echo "<span id='".$post_id."_yn'>";
				if($is_featured == "yes"){
				echo "<a href='javascript:void(0);' onclick=\"WLTSaveAdminOp(".$post_id.",'no','featured','".$post_id."_yn');\"><img src='".get_template_directory_uri()."/framework/admin/img/yes.png' alt='' align='middle'></a>";
				}else{
				echo "<a href='javascript:void(0);' onclick=\"WLTSaveAdminOp(".$post_id.",'yes','featured', '".$post_id."_yn');\"><img src='".get_template_directory_uri()."/framework/admin/img/no.png' alt='' align='middle'></a>";
				}
			echo "</span>";
			
		} break;
		case "image": {
		 
			$img = hook_image_display(get_the_post_thumbnail($post_id, array(100,80), array('class'=> "img-polaroid")));
			if($img == ""){
			$img = hook_fallback_image_display($CORE->FALLBACK_IMAGE($post_id)); 
			}
			if($img != ""){
		 
			echo "<a href='post.php?post=".$post_id."&action=edit'>".$img."</a>";
			}
		 
		} break;		
		case "hits": {
		$hits = get_post_meta($post_id,"hits",true);	
		if($hits == "" || !is_numeric($hits)){ $hits =0; }	
		echo number_format($hits);
		}	 	
	}	 // end switch
} 


function _admin_column_orderby( $vars ) {

	if ( isset( $vars['orderby'] ) ) {	
		if('Views' == $vars['orderby'] ){		
			$vars = array_merge( $vars, array(	'meta_key' => 'hits','orderby' => 'meta_value_num',	'order' => $_GET['order']) );	
		}elseif ( 'Price' == $vars['orderby'] ){		
			$vars = array_merge( $vars, array(	'meta_key' => 'price', 'orderby' => 'meta_value', 'order' => $_GET['order']) );				
		}elseif ( 'Clicks' == $vars['orderby'] ){		
			$vars = array_merge( $vars, array(	'meta_key' => 'clicks', 'orderby' => 'meta_value', 'order' => $_GET['order']) );				
		
		
		
		}elseif ( 'impressions' == $vars['orderby'] ){		
			$vars = array_merge( $vars, array(	'meta_key' => 'impressions','orderby' => 'meta_value',	'order' => $_GET['order']) );
		}elseif ( 'Featured' == $vars['orderby'] ){		
			$vars = array_merge( $vars, array(	'meta_key' => 'featured','orderby' => 'meta_value',	'order' => $_GET['order']) );
		}elseif ( 'Quantity' == $vars['orderby'] ){		
			$vars = array_merge( $vars, array(	'meta_key' => 'qty','orderby' => 'meta_value_num',	'order' => $_GET['order']) );		
		}elseif ( 'Expires' == $vars['orderby'] ){	
			if(defined('WLT_COUPON')){
				$vars = array_merge( $vars, array(	'meta_key' => 'expiry_date','orderby' => 'meta_value',	'order' => $_GET['order']) );	
			}else{
				$vars = array_merge( $vars, array(	'meta_key' => 'listing_expiry_date','orderby' => 'meta_value',	'order' => $_GET['order']) );	
			}	
				
		}			
	}
 
	return $vars;
}	
	
 
	function _edit_listing_quick_add_script() { 
	  
	 // include globals for display elements
	 if(isset($_GET['post_type']) && $_GET['post_type'] == THEME_TAXONOMY."_type"){
	 $GLOBALS['wlt_packages'] = get_option("packagefields"); 
	 }
	 
	 ?>  
        <script src="<?php echo FRAMREWORK_URI; ?>admin/js/scripts.js" type="text/javascript"></script>    
 	<script src="<?php echo FRAMREWORK_URI; ?>js/core.ajax.js" type="text/javascript"></script>
		<script type="text/javascript">
		jQuery(document).ready(function() {	
			jQuery('a.wlt_editpop').live('click', function() {
				 tb_show('', this.href+'&amp;TB_iframe=true');
				 return false;		   
			});
			
		});
		function WLTSaveAdminOp(postid,val,act,div){
		 
		CoreDo('<?php echo str_replace("https://","",str_replace("http://","",get_home_url())); ?>/wp-admin/edit.php?core_admin_aj=1&act='+act+'&pid='+postid+'&value='+val, div);
		}
		</script>
		
		<?php
	} 

/* =============================================================================
  [PREMIUMPRESS FRAMEWORK] DISPLAY EDIT FIELDS
   ========================================================================== */

// REMOVE OPTIONS WE DONT NEED
function _add_meta_boxes() {
		global $_wp_post_type_features;
		if (isset($_wp_post_type_features[THEME_TAXONOMY.'_type']['editor']) && $_wp_post_type_features[THEME_TAXONOMY.'_type']['editor']) {
			//unset($_wp_post_type_features[THEME_TAXONOMY.'_type']['editor']);	
			//remove_meta_box('postexcerpt', THEME_TAXONOMY.'_type', 'normal');
			remove_meta_box('trackbacksdiv', THEME_TAXONOMY.'_type', 'normal');
			//remove_meta_box('postcustom', THEME_TAXONOMY.'_type', 'normal');
			//remove_meta_box('commentstatusdiv', THEME_TAXONOMY.'_type', 'normal');
			//remove_meta_box('commentsdiv', THEME_TAXONOMY.'_type', 'normal');
			remove_meta_box('revisionsdiv', THEME_TAXONOMY.'_type', 'normal');
			//remove_meta_box('authordiv', THEME_TAXONOMY.'_type', 'normal');
			//remove_meta_box('sqpt-meta-tags', THEME_TAXONOMY.'_type', 'normal'); 
		} 
}
// STOP HTML BEING STRIPPED FROM THE EDITOR BOXES
function myformatTinyMCE($in) {$in['verify_html']=false; return $in; }
function _custom_metabox(){ 
 	
	// LISTING DATA META BOX
	add_meta_box( 'wlt_listingdata',  "Listing Details", array($this, '_listing_details' ), THEME_TAXONOMY.'_type', 'normal', 'high' );
 	
	add_meta_box( 'wlt_listingattachments',  "Images/ Video/ Music", array($this, '_listing_attachments' ), THEME_TAXONOMY.'_type', 'normal', 'high' );
 	 
	
	if(!defined('WLT_CART')){ 
	add_meta_box( 'wlt_pagedata',"Page Access", array($this, '_page_details' ), 'page', 'normal', 'high' );
	}
	
}

function buildadminfields($full_list_of_fields){ global $post, $CORE, $wpdb; $tabbedarea = 0; $core_admin_values = get_option("core_admin_values"); 
	
	
	 ?>
    
    <table style="width:100%;">
	
<?php foreach($full_list_of_fields as $key=>$val){ $e_value = get_post_meta($post->ID,$key,true); 

// FIX FOR SKU
if($key == "sku" &&  $e_value == ""){ $e_value = get_post_meta($post->ID,"SKU",true);  }

// CHECK FOR DEFAULT FIELD VALUE
if($e_value == "" && isset($val['default'])){ $e_value = $val['default']; }  

// CHECK IF THIS IS A NEW TAB
if(isset($val['tab'])){ $tabbedarea = $key; ?>
<tr class="fieldset_<?php echo $tabbedarea; ?>">
    <td colspan="2">
     <div style='font-weight:bold; padding:10px; padding-left:0px; border-bottom:1px solid #ddd; color:#666;'><?php echo $val['title']; ?></div>
    </td>
</tr>

<?php }else{ ?>
<tr style="line-height:35px;" id="table_row_<?php echo $key; ?>" class="fieldset_<?php echo $tabbedarea; ?>">
    <td style="width:250px;"><img src="<?php echo THEME_URI; ?>/framework/admin/img/info.png" class="infoimg" role="button" aria-pressed="false" style="cursor:pointer;margin-right:10px;" align="absmiddle" title="<?php echo $val['desc']; ?>" /><label><?php echo $val['label']; ?></label>  </td>
    <td>
 
    <?php if(isset($val['combo'])){ ?>
 
    
  <input type="text" id="autocompleteme" style="width:300px;" placeholder="Enter product title here.." /> 
  
  <?php if($key != "related"){ ?>
  <!-- HERE WE GET AND SAVE THE OLD VALUES ENCASE THEY CHANGED -->
  <?php
	$options1 = get_post_meta($post->ID,$key,true); $oldIds = "";
	if(is_array($options1) && !empty($options1)){				
		foreach($options1 as $val1){
		$oldIds .= $val1.",";
		}			 				 
	}// end foreach
  ?>
   <input type="hidden" name="wlt_field[<?php echo $key; ?>_old]" value="<?php echo $oldIds; ?>" /> 
    <?php } ?>
	
	
	<?php } ?>
    
    
    <?php if(isset($val['values'])){ ?>
    <select name="wlt_field[<?php echo $key; ?>]<?php if(isset($val['multi'])){ ?>[]<?php }?>" id="field_<?php echo $key; ?>" <?php if(isset($val['multi'])){ ?>multiple="multiple" style="height:100px;width:300px;"<?php } ?>>
    
    
     <?php if(isset($val['combo'])){  ?><option value=""> </option><?php } ?>
    <?php if($key == "packageID"){ ?><option value="">----- no package assigned -----</option><?php } ?>
    <?php 
	
	if($key == "related"){
		foreach($val['values'] as $k=>$val){ 			
			$val = trim($val);
			if(strlen($val) > 0 && is_numeric($val)){
			echo '<option value="'.$val.'" selected=selected>'.get_the_title($val).'</option>';	
			}		
		}
	}else{
		foreach($val['values'] as $k=>$o){ 
		
		if(is_array($e_value) && isset($val['multi']) && in_array($k, $e_value) ){ $f = "selected=selected"; }elseif($e_value != "" && $e_value == $k){ $f = "selected=selected"; }else{ $f=""; }?>
		
		<?php if(is_array($o) && $key == "packageID"){ $o = $o['name']; } 
		if($o == ""){ continue; }
		?>
		<option value="<?php echo $k; ?>" <?php echo $f; ?>><?php echo $o; ?></option>
		<?php }?>
    
    <?php } ?>
    
    </select>
    <?php }else{ ?>
    
    <?php 
	 
	if(isset($val['dateitem'])){ 
			 $db = explode(" ",$e_value);
			echo ' 
			<script>jQuery(function(){ jQuery(\'#reg_field_'.$key.'_date\').datetimepicker(); }); </script>
			
			 
			<div style="width:30%; float:left;">
			
			
			<div class="input-prepend date span6" id="reg_field_'.$key.'_date" data-date="'.$db[0].'" data-date-format="yyyy-MM-dd hh:mm:ss">
			<span class="add-on"><i class="dashicons dashicons-calendar-alt" style="cursor:pointer"></i></span>
				<input type="text" name="wlt_field['.$key.']" value="'.$e_value.'" id="reg_field_'.$key.'"  data-format="yyyy-MM-dd hh:mm:ss" />
			 </div>
			 
			 
			 </div>';
		 
			 
	}elseif($key == "price" || isset($val['price'])){ echo $core_admin_values['currency']['symbol']; } ?>
    
    <?php if(!isset($val['dateitem'])){ ?>
    <input type="text" name="wlt_field[<?php echo $key; ?>]" value="<?php echo $e_value; ?>" id="<?php echo $key; ?>" /> 
    <?php } ?>
    
    <?php } ?>
    
    <?php if($key == "listing_expiry_date"){ ?>
    <a href="javascript:void(0);" onclick="jQuery('#reg_field_listing_expiry_date').val('<?php echo date('Y-m-d H:i:s', strtotime('+5 minutes', strtotime($CORE->DATETIME()))); ?>');" style="float:right;margin-top:5px;" class="button">Set Date Now (+5 mins)</a>  
    <?php } ?>
    
    
<?php if($key == "download_path"){ ?>
  <a href="javascript:void(0);" class="button" id="upload_logo">Select File</a>


<input type="hidden" value="" name="imgIdblock" id="imgIdblock" />

<script type="text/javascript">

 function ChangeImgBlock(divname){
	document.getElementById("imgIdblock").value = divname;
} 
 
	jQuery('#upload_logo').click(function() {	
	 
	window.send_to_editor = function(html) {	
	var regex = /src="(.+?)"/;
    var rslt =html.match(regex);
    var imgurl = rslt[1];
	 jQuery('#'+document.getElementById("imgIdblock").value).val(imgurl);
	 tb_remove();
	} 
	
	 ChangeImgBlock('download_path'); 
	 formfield = jQuery('#download_path').attr('name');
	 tb_show('', 'media-upload.php?type=image&amp;TB_iframe=true');
	 return false; 
	 }); 
</script>  
  



<?php  }// end if this field is a tab ?>
 
     
    </td>
</tr>
<?php } } ?>  
</table>


<script type="application/javascript">
jQuery(document).ready(function(){	

	jQuery( "#field_listing_status" ).change(function() {
		var sdt = jQuery( "#field_listing_status" ).val();
		if(sdt == 10){
			 jQuery( "#table_row_listing_status_msg" ).show(0);
		}else{
			 jQuery( "#table_row_listing_status_msg" ).hide(0);
		} 
	});	
	var sdt = jQuery( "#field_listing_status" ).val();
	if(sdt == 10){
		jQuery( "#table_row_listing_status_msg" ).show(0);
	}else{
		jQuery( "#table_row_listing_status_msg" ).hide(0);
	} 
	
});
</script>
<?php if(defined('WLT_CART')){ ?> 
<script type="application/javascript">
jQuery(document).ready(function(){	

	jQuery( "#field_tax_required" ).change(function() {
		var sdt = jQuery( "#field_tax_required" ).val();
		if(sdt == 0){
		 jQuery( ".fieldset_tab7" ).hide(0);
		}else if(sdt == 1){
		 jQuery( ".fieldset_tab7" ).show(0);
		} 
	});	 
	jQuery( "#field_type" ).change(function() {
		var sdt = jQuery( "#field_type" ).val();
		if(sdt == 0){
		jQuery( ".fieldset_tab4" ).hide(0);jQuery( ".fieldset_tab5" ).hide(0);jQuery( ".fieldset_tab6" ).show(0);
		}else if(sdt == 1){
		jQuery( ".fieldset_tab4" ).show(0);jQuery( ".fieldset_tab5" ).hide(0);jQuery( ".fieldset_tab6" ).hide(0);
		}else if(sdt == 2){
		jQuery( ".fieldset_tab4" ).hide(0);jQuery( ".fieldset_tab5" ).show(0);jQuery( ".fieldset_tab6" ).hide(0);
		}
	});
<?php
$selected_tax = get_post_meta($post->ID,'tax_required',true);
switch($selected_tax){
	case "1": {
	echo 'jQuery( ".fieldset_tab7" ).show(0);';
	} break;
 
	default: {
	echo 'jQuery( ".fieldset_tab7" ).hide(0);';
	} break;
}
$selected_type = get_post_meta($post->ID,'type',true);
switch($selected_type){
	case "1": {
	echo 'jQuery( ".fieldset_tab4" ).show(0);jQuery( ".fieldset_tab5" ).hide(0);jQuery( ".fieldset_tab6" ).hide(0);';
	} break;
	case "2": {
	echo 'jQuery( ".fieldset_tab4" ).hide(0);jQuery( ".fieldset_tab5" ).show(0);jQuery( ".fieldset_tab6" ).hide(0);';
	} break;

	default: {
	echo 'jQuery( ".fieldset_tab4" ).hide(0);jQuery( ".fieldset_tab5" ).hide(0);jQuery( ".fieldset_tab6" ).show(0);';
	} break;
}
?>
});
</script>

<?php } 

}

function _listing_attachments(){

get_template_part('/framework/admin/templates/admin', 'edit-tab-files' ); 

}

function _listing_details(){ global $post, $CORE; $core_admin_values = get_option("core_admin_values"); $packagefields = get_option("packagefields"); ?>

<script>

jQuery(document).ready(function(){

 jQuery( document ).tooltip({
  tooltipClass: "wlt_admin_tooltip",
      position: {
        my: "right-50 top-20",
        at: "right+5 top-5"
      },
      show: {
        duration: "fast"
      },
      hide: {
        effect: "hide"
      }
	  
    });
  

});


(function($) {
	
	$(document).on( 'click', '.nav-tab-wrapper a', function() {
		$('section').hide();
		$('#'+$(this).attr("data-id")).show();
		return false;
	})
	
})( jQuery ); 
</script>


 <div id="wlt_admin_editmenu_wrap">

<h2 class="nav-tab-wrapper" id="wlt_admin_editmenu">
	<a href="#" data-id="tab-details" class="nav-tab  nav-tab-active">Details</a>
	 
    <?php if(!defined('WLT_CART')){ ?>
    
    <a href="#" data-id="tab-enhance" class="nav-tab">Enhancements</a>      
	<a href="#" data-id="tab-expiry" class="nav-tab">Expiry Date</a> 
    <a href="#" data-id="tab-timeout" class="nav-tab">Timeout</a> 
    <a href="#" data-id="tab-access" class="nav-tab">Page Access</a>  
     
    <?php if(isset($GLOBALS['CORE_THEME']['google']) && $GLOBALS['CORE_THEME']['google'] ==  1){ ?>
    <a href="#" data-id="tab-map" class="nav-tab" onclick="loadGoogleMapsApi();">Map Location</a> 
 	<?php } ?>
    
    <?php }else{ ?>  
    
    <a href="#" data-id="tab-shop-attr" class="nav-tab">Attributes</a>
    <a href="#" data-id="tab-shop-dis" class="nav-tab">Discount</a>
    
    <?php } ?>
    
    <?php if(defined('WLT_MICROJOB')){ ?>
    <a href="#" data-id="tab-attr" class="nav-tab">Add-Ons</a>
    <?php } ?>
    
    <a href="#" data-id="tab-visitors" class="nav-tab mapmebox">Visitor History</a>    

</h2>


<div id="sections" class="wlt_edit_section"> 

<section id="tab-details">

<?php get_template_part('/framework/admin/templates/admin', 'edit-tab-details' );  ?>
 
</section> 

<section id="tab-enhance" style="display:none;">

<?php get_template_part('/framework/admin/templates/admin', 'edit-tab-enhance' );  ?>
 
</section>

<section id="tab-expiry" style="display:none;">

<?php get_template_part('/framework/admin/templates/admin', 'edit-tab-expiry' );  ?>
 
</section>


<?php if(isset($GLOBALS['CORE_THEME']['google']) && $GLOBALS['CORE_THEME']['google'] ==  1){ ?>
<section id="tab-map" style="display:none;">

<?php get_template_part('/framework/admin/templates/admin', 'edit-tab-map' );  ?>
 
</section>
<?php } ?>

<section id="tab-access" style="display:none;">

<?php get_template_part('/framework/admin/templates/admin', 'edit-tab-access' );  ?>
 
</section>

<section id="tab-timeout" style="display:none;">

<?php get_template_part('/framework/admin/templates/admin', 'edit-tab-timeout' );  ?>
 
</section>

<?php if(defined('WLT_MICROJOB')){ ?>
<section id="tab-attr" style="display:none;">

<?php get_template_part('/framework/admin/templates/admin', 'edit-tab-micojob-attr' );  ?>
 
</section>
<?php } ?>


 
<?php if(defined('WLT_CART')){ ?>
<section id="tab-shop-attr" style="display:none;">

<?php get_template_part('/framework/admin/templates/admin', 'edit-tab-shop-attr' );  ?>
 
</section>

<section id="tab-shop-dis" style="display:none;">

<?php get_template_part('/framework/admin/templates/admin', 'edit-tab-shop-dis' );  ?>
 
</section>
<?php  } ?> 

<section id="tab-visitors" style="display:none;">

<?php get_template_part('/framework/admin/templates/admin', 'edit-tab-visitors' );  ?>
 
</section>


<div class="clear"></div>

<hr />

<input name="save" type="submit" class="button button-primary button-large" id="publish" accesskey="p" value="Save Changes" style="margin-top:10px;">   
</div>

<div class="clear"></div>


</div>
<?php
}
		
	function _edit_listing_sideoptions(){  global $post;
 
	// Allow to be filtered, just incase you really need to switch between
	// those crazy types of posts
	$args =						apply_filters( 'pts_metabox', array( 'public' => true, 'show_ui' => true )  );

	// Get the post types based on the above arguments
	$post_types =				get_post_types( (array)$args );
 	// Populate necessary post_type values
	$cur_post_type =			$post->post_type;
	$cur_post_type_object =		get_post_type_object( $cur_post_type );

	// Make sure the currently logged in user has the power
	$can_publish =				current_user_can( $cur_post_type_object->cap->publish_posts );
	?>
	<script>
	jQuery(document).ready(function() { 
		 
			jQuery('#post-type-select').siblings('a.edit-post-type').click(function() {
						if (jQuery('#post-type-select').is(":hidden")) {
							jQuery('#post-type-select').slideDown("normal");
							jQuery(this).hide();
						}
						return false;
			});
		
			jQuery('.save-post-type', '#post-type-select').click(function() {
						jQuery('#post-type-select').slideUp("normal");
						jQuery('#post-type-select').siblings('a.edit-post-type').show();
						pts_updateText();
						return false;
			});
		
			jQuery('.cancel-post-type', '#post-type-select').click(function() {
						jQuery('#post-type-select').slideUp("normal");
						jQuery('#pts_post_type').val(jQuery('#hidden_post_type').val());
						jQuery('#post-type-select').siblings('a.edit-post-type').show();
						pts_updateText();
						return false;
			});
		
			function pts_updateText() {
						jQuery('#post-type-display').html( jQuery('#pts_post_type :selected').text() );
						jQuery('#hidden_post_type').val(jQuery('#pts_post_type').val());
						jQuery('#post_type').val(jQuery('#pts_post_type').val());
						return true;
			}
		});
	</script>
	<div class="misc-pub-section post-type-switcher">
	
		<label for="pts_post_type">
        
        <i class="dashicons dashicons-format-aside" style="color:#82878C; font-size:16px;"></i>
        
        Type:</label>
		
		<span id="post-type-display" style="font-weight:bold;"><?php echo $cur_post_type_object->label; ?></span>
		
	<?php	if ( $can_publish ) : ?>
		<a href="javascript:void(0);" class="edit-post-type hide-if-no-js" onClick="jQuery('#post-type-select').show();">Edit</a>
		<div id="post-type-select" style="display:none;">
			<select name="pts_post_type" id="pts_post_type">
	<?php foreach ( $post_types as $post_type ) {
			
			if($post_type == "ppt_alert" || $post_type == "ppt_message"){ continue; }
				$pt = get_post_type_object( $post_type );
				if ( current_user_can( $pt->cap->publish_posts ) ) : ?>
				<option value="<?php echo $pt->name; ?>"<?php if ( $cur_post_type == $post_type ) : ?>selected="selected"<?php endif; ?>><?php echo $pt->label; ?></option>
	<?php endif; } ?>
			</select>
			<input type="hidden" name="hidden_post_type" id="hidden_post_type" value="<?php echo $cur_post_type; ?>" />
            <input type="hidden" name="hidden_post_type_old" value="<?php echo $cur_post_type; ?>" />
			<a href="#pts_post_type" class="save-post-type hide-if-no-js button" onClick="jQuery('#post-type-select').hide();alert('This will be updated when you save the post.')">OK</a>
			<a href="javascript:void(0);" onClick="jQuery('#post-type-select').hide();">Cancel</a>
	 
	
	<?php endif; ?></div></div>
    
    <?php 
if($post->post_type == THEME_TAXONOMY.'_type' ){


$basic_list = array (
"tab10" => array("tab" => true, "title" => "Display Extras" ),
 
"listing_status_msg" => array("label" => "Custom Message", "desc" => "Here you can enter your own custom message. This will only be displayed if the listing status is set to 10." ), 	
"listing_sticker" => array("label" => "Sticker", "desc" => "If set, this will place a red sticker icon on the search results page.", "values" =>  array(	
		"0" 		=> "----- dont show -----",
		"1" 		=> "Great Value",
		"2" 		=> "Available Soon",
		"3" 		=> "Ask For Details",		
		"4" 		=> "Deal of the Month",
		"5" 		=> "Amazing!",		
		"6" 		=> "Hot Item",		
		"7" 		=> "New",		
		"8" 		=> "Popular", 
		"9" 		=> "Under Review",
		"10" 		=> "Completed", 
	) ), 
 
); 
if(defined('WLT_CART') ){
unset($basic_list['listing_status']);
unset($basic_list['listing_status_msg']);

}
 
	// DISPLAY OUTPPIT
$this->buildadminfields($basic_list); 
}	
	
	
		if($post->post_type == "page"){ // end if post type == post  	
	
			$page_width 		= get_post_meta($post->ID, 'width', true);
			if($page_width == ""){ $a1 = 'selected'; $a2=""; }else{$a1 = ''; $a2="selected"; } 
	 
	 		$page_body 		= get_post_meta($post->ID, 'body', true);
			if($page_body == ""){ $b1 = 'selected'; $b2=""; }else{$b1 = ''; $b2="selected"; } 
	 
			echo '<style>#visibility { display:none; } </style>';
	 
			echo '<div class="misc-pub-section misc-pub-section-last">Page Width: </span>';
			echo '<select name="wlt_field[width]" id="fullpagewidth" style="font-size:11px;">
			<option value="" '.$a1.'>inherit from theme</option>
			<option value="full" '.$a2.'>full page</option></select></div>';
			
			echo '<div class="misc-pub-section misc-pub-section-last">Page Body: </span>';
			echo '<select name="wlt_field[body]" id="fullpagewidth" style="font-size:11px;">
			<option value="" '.$b1.'>inherit from theme</option>
			<option value="remove" '.$b2.'>remove header/footer</option></select></div>';
		
		}
    
	} 

    function extra_post_row_actions($actions){ global $post, $CORE;
	
	
	// ONLY DO THIS FOR LISTING TYPE
	if($post->post_type != "listing_type"){ return $actions; }

	// CREATE IMAGE
	$img = hook_image_display(get_the_post_thumbnail($post->ID, array(100,80), array('class'=> "img-polaroid")));
	if($img == ""){
		$img = hook_fallback_image_display($CORE->FALLBACK_IMAGE($post->ID)); 
	}	
	echo "
	<a href='post.php?post=".$post->ID."&action=edit'>
	<div style='border:1px solid #ddd; padding:2px; width:100px; height:75px; background:#fff; float:left; margin-right:20px; text-align:center; overflow:hidden;'>";
	echo "".$img."";	
	echo "</div></a>";
	
	// DISPLAY TITLE
	echo "<div style='font-size:16px; margin-bottom:10px;'><a href='post.php?post=".$post->ID."&action=edit'>".$post->post_title."</a></div>";	
	
	// LAST USER VISIT	
	echo '<small style="color:grey;"><b>ID:</b> '.$post->ID.' ';
		
		// LAST VISITOR
		$lastv = get_post_meta($post->ID,'last_visitor', true);	
		if(strlen($lastv) > 1){
		echo "<img src='".get_template_directory_uri()."/framework/admin/img/icons/27.png' alt='' align='absmiddle'> Last Viewed ".hook_date($lastv)."";
		}
		
		// PACKAGE DATA	
	echo '</small>';
 
		  
		  $ST1 = ""; $ST2 = ""; $ST3 = "";
		  
		 	  // 1. BUILD PACKAGE STRING
			  $packages = get_option('packagefields');
			  $gg = get_post_meta($post->ID,'packageID',true);
			  
			  if(is_numeric( $gg )){			  
				  $ps = $packages[$gg]['name']; 
				  if(strlen($ps) > 1){
				  $ST1 = "<span><b>Package:</b> ".$ps."</span>";
				  }
		      }
			  
			  // 2. BUILD AMOUNT PAID
			  if(get_post_meta($post->ID,'listing_price_paid',true) != ""){
			  $ST2 = "<span><b>Amount Paid:</b> ".hook_price(get_post_meta($post->ID,'listing_price_paid',true))."</span>";
			  }
			  
			  // 3. ID		  
			  $ST3 = "".'';
			 	  
				$actions = array_merge($actions, 
				  array(
				'update' => 
				@sprintf('<a href="'.get_home_url().'/wp-admin/post.php?post='.$post->ID.'&action=edit&smalleditor=1" class="wlt_editpop">Pop-up Editor</a> | <a href="%s&mediaonly=1" class="wlt_editpop">Attachments</a> | <b><a href="'.get_home_url().'/wp-admin/edit.php?post_type='.THEME_TAXONOMY.'_type&author='.$post->post_author.'" style="text-decoration:underline;">'.get_the_author_meta('display_name', $post->post_author).'</a></b>'.do_shortcode('<div class="btdata">'.$ST3.' '.$ST1.' '.$ST2.' </div>').'<br/>',
					wp_nonce_url(get_home_url().'/wp-admin/post.php?post='.$post->ID.'&action=edit&smalleditor=1&att=1',  'abc') 
					)
				));	
	 
   		return $actions;      
    }
 
/* =============================================================================
	USER DISPLAY PAGE CHANGES
	========================================================================== */
 
	function contributes_sortable_columns( $columns ) {
		$columns['c1'] = "Listings";
		$columns['c2'] = "Credit";
		return $columns;
	}
	function contributes($columns) {
			$columns['c1'] = "Listings";
			$columns['c2'] = "Credit";
			return $columns;
	}		
	function contributes_columns( $value, $column_name, $user_id ) { global $wp_query;
			
			if ( 'c1' != $column_name && 'c2' != $column_name ){ return $value; }
 			
			if($column_name == "c1"){
			
				$column_title = "Listings";
				$column_slug = THEME_TAXONOMY;
				$posts = query_posts('post_type='.$column_slug.'_type&author='.$user_id.'&order=ASC&posts_per_page=30');//Replace post_type=contribute with the post_type=yourCustomPostName
				$posts_count = "<a href='edit.php?post_type=".THEME_TAXONOMY."_type&author=".$user_id."' style='text-decoration:underline; font-weight:bold;'>".count($posts)."</a>";			 
				return $posts_count;
			
			}elseif($column_name == "c2"){
			
				$user_balance = get_user_meta($user_id,'wlt_usercredit',true);
				if($user_balance == ""){ $user_balance = 0; }
				return hook_price($user_balance);
			
			}
	}	
	function save_extra_user_profile_fields( $user_id ) {
	global $CORE;
	if ( !current_user_can( 'edit_user', $user_id ) ) { return false; }
	
		update_user_meta( $user_id, 'wlt_customtext',$_POST['customtext']);
		update_user_meta( $user_id, 'wlt_usercredit',$_POST['wlt_usercredit']);

		// CHECK EMAIL IS VALID			
		update_user_meta($user_id, 'url', strip_tags($_POST['url']));
		update_user_meta($user_id, 'phone', strip_tags($_POST['phone']));
			
		// SOCIAL
		update_user_meta($user_id, 'facebook', strip_tags($_POST['facebook']));
		update_user_meta($user_id, 'twitter', strip_tags($_POST['twitter']));
		update_user_meta($user_id, 'linkedin', strip_tags($_POST['linkedin']));
		update_user_meta($user_id, 'skype', strip_tags($_POST['skype']));
		
		// USER PHOTO		 
		if(isset($_FILES['wlt_userphoto']) && strlen($_FILES['wlt_userphoto']['name']) > 2 && in_array($_FILES['wlt_userphoto']['type'],$CORE->allowed_image_types) ){
				 
				// INCLUDE UPLOAD SCRIPTS
				if(!function_exists('wp_handle_upload')){
				$dir_path = str_replace("wp-content","",WP_CONTENT_DIR);
				require $dir_path . "/wp-admin/includes/file.php";
				}
				
				// GET WORDPRESS UPLOAD DATA
				$uploads = wp_upload_dir();
				
				// UPLOAD FILE 
				$file_array = array(
					'name' 		=> $_FILES['wlt_userphoto']['name'], //$userdata->ID."_userphoto",//
					'type'		=> $_FILES['wlt_userphoto']['type'],
					'tmp_name'	=> $_FILES['wlt_userphoto']['tmp_name'],
					'error'		=> $_FILES['wlt_userphoto']['error'],
					'size'		=> $_FILES['wlt_userphoto']['size'],
				);
				//die(print_r($file_array));
				$uploaded_file = wp_handle_upload( $file_array, array( 'test_form' => FALSE ));
	 	
				// CHECK FOR ERRORS
				if(isset($uploaded_file['error']) ){		
					$GLOBALS['error_message'] = $uploaded_file['error'];
				}else{
			 	 
				// NOW LETS SAVE THE NEW ONE	
				update_user_meta($user_id, "userphoto", array('img' => $uploads['url']."/".$file_array['name'], 'path' => $uploads['path']."/".$file_array['name'] ) );
				
				}
			}

	
	if(isset($_POST['membership'])){
	
	 $bits = explode("*",$_POST['membership']);	
	 if(!is_numeric($bits[1])){ $bits[1] = 30; }	 	 
	    update_user_meta( $user_id, 'wlt_membership', $bits[0] );
		if($_POST['wlt_membership_expires'] == "" && $bits[0] != ""){
		update_user_meta( $user_id, 'wlt_membership_expires', date("Y-m-d H:i:s", strtotime(date("Y-m-d H:i:s") . " +".$bits[1]." days")) );
		}else{
		update_user_meta( $user_id, 'wlt_membership_expires',$_POST['wlt_membership_expires']);
		}
		
 	}
	
	// CART DELIVERY DATA
	 if(defined('WLT_CART') && is_array($_POST['delivery']) ){
		 foreach($_POST['delivery'] as $kk => $vv){
		 update_user_meta( $user_id, $kk, $vv);
		 }     
     }
	
	}
	// USER FIELDS FOR THE ADMIN TO EDIT
	function userfields( $contactmethods ) { global $wpdb, $CORE;
	
	$regfields = get_option("regfields");
	if(is_array($regfields)){
		//PUT IN CORRECT ORDER
		$regfields = $CORE->multisort( $regfields , array('order') );
		foreach($regfields as $field){
		
			// EXIST IF KEY DOESNT EXIST
			if($field['key'] == "" && $field['fieldtype'] !="taxonomy" ){ continue; }
			$contactmethods[$field['key']]             = $field['name'];
		}		
	}
    
    return $contactmethods;
   }
   
   function extra_user_profile_fields( $user ) { global $wpdb, $CORE; ?>
   
   <h3>User Login Information</h3>
   
   
   <table class="form-table">
	<tr>
	<th><label for="text">Login count</label></th>
	<td>

<?php echo get_user_meta($user->ID,'login_count',true); ?>
	</td>
	</tr> 
    
    <tr>
	<th><label for="text">Last Login Date</label></th>
	<td>

<?php echo get_user_meta($user->ID,'login_lastdate',true); ?>
	</td>
	</tr> 
    
    <tr>
	<th><label for="text">Last Login IP</label></th>
	<td>
<?php echo get_user_meta($user->ID,'login_ip',true); ?>

	</td>
	</tr> 
    
    
    
    </table>
   
   	
    
    <h3>Custom Text</h3>
    <p>This text will appear on the users account area.</p>
	<table class="form-table">
	<tr>
	<th><label for="text">Text</label></th>
	<td>
    <textarea name="customtext"><?php echo stripslashes(get_user_meta($user->ID,'wlt_customtext',true)); ?></textarea>
	</td>
	</tr> 
    
    
    <tr>
    <th><label>Phone</label></th>
    <td>
    <input type="text" name="phone" value="<?php echo get_user_meta($user->ID,'phone',true); ?>" class="regular-text" />     
    </td>
    </tr> 
    
    <tr>
    <th><label>Website </label></th>
    <td>
    <input type="text" name="url" value="<?php echo get_user_meta($user->ID,'url',true); ?>" class="regular-text" />     
    </td>
    </tr> 
    
    <tr>
    <th><label>Facebook</label></th>
    <td>
    <input type="text" name="facebook" value="<?php echo get_user_meta($user->ID,'facebook',true); ?>" class="regular-text" />     
    </td>
    </tr>  
    
    <tr>
    <th><label>Twitter</label></th>
    <td>
    <input type="text" name="twitter" value="<?php echo get_user_meta($user->ID,'twitter',true); ?>" class="regular-text" />     
    </td>
    </tr> 
    
    <tr>
    <th><label>LinkedIn</label></th>
    <td>
    <input type="text" name="linkedin" value="<?php echo get_user_meta($user->ID,'linkedin',true); ?>" class="regular-text" />     
    </td>
    </tr> 
    
    <tr>
    <th><label>Skype</label></th>
    <td>
    <input type="text" name="skype" value="<?php echo get_user_meta($user->ID,'skype',true); ?>" class="regular-text" />     
    </td>
    </tr>  
    
    
    
    
	</table>
    
    <?php 
	$membershipfields = get_option("membershipfields");
	if(is_array($membershipfields) && count($membershipfields) > 0 ){ 
	$membershipfields = $CORE->multisort( $membershipfields , array('order') );	 ?>
    
    
    
    <?php if(defined('WLT_CART')){ ?>
    <h3>Shipping Address</h3>
    
    <?php global $CORE_CART; $CORE->Language();	$CORE_CART->_userfields($user->ID); ?>
    
    <?php } ?>
 
    
    
        
    <h3>Membership Information</h3>
	<table class="form-table">
	<tr>
	<th><label for="membership">Membership</label></th>
	<td>
    <?php $current_membership = get_user_meta($user->ID,'wlt_membership',true); ?>
	<select name="membership">
    
	<?php 
	foreach($membershipfields as  $field){ if($current_membership == $field['ID']){ $sel = "selected='selected'"; }else{ $sel = ""; } ?>
	<option value="<?php echo $field['ID']; ?>" <?php echo $sel; ?>><?php echo $field['name']; ?></option>
	<?php } ?>
    <option value="" <?php if($current_membership == ""){ echo "selected='selected'"; } ?>>------ no membership -------</option>
	</select>
	</td>
	</tr> 
    
    <tr>
    <th><label for="expires">Membership Expiry Date</label></th>
    <td>
    <input type="text" name="wlt_membership_expires" id="field_expiry_date" value="<?php echo get_user_meta($user->ID,'wlt_membership_expires',true); ?>" class="regular-text" /> <a href="javascript:void(0);" onclick="jQuery('#field_expiry_date').val('<?php echo date('Y-m-d H:i:s'); ?>');">Set</a>
    
    <br />
    <span class="description">Enter the date which the membership will expire. Format: Y-m-d h:i:s</span>
    </td>
    </tr> 

	</table>
    <?php } ?>
    
    
    <h3>User Credit</h3>
    <p>Here you can set an amount in monies that will be credited to the users account. Options to contact you regarding withdrawal will appear if the amount below is positive.</p>
	<table class="form-table">
	<tr>
	<th><label for="text">Amount</label></th>
	<td>
    <?php echo $GLOBALS['CORE_THEME']['currency']['symbol']; ?> <input type="text" name="wlt_usercredit" id="field_expiry_date" value="<?php echo get_user_meta($user->ID,'wlt_usercredit',true); ?>" class="regular-text" style="width:100px;" /> 
	</td>
	</tr> 
 </table>
 
 
     <h3>User Photo</h3>
    <p>Users can upload and manage their photo via their members area. This section is for admins.</p>
	<table class="form-table">
	<tr>
	<th><label for="text">Current Photo</label></th>
	<td>
     <?php echo get_avatar( $user->ID, 180 ); ?>
	</td>
	</tr> 
    
    	<tr>
	<th><label for="text">Upload/Change Photo</label></th>
	<td>
    <input type="file" name="wlt_userphoto" />
	</td>
	</tr> 
 </table>
 	<script type="text/javascript">
	var form = document.getElementById('your-profile');
	//form.enctype = "multipart/form-data"; //FireFox, Opera, et al
	form.encoding = "multipart/form-data"; //IE5.5
	form.setAttribute('enctype', 'multipart/form-data'); //required for IE6 (is interpreted into "encType")
	</script>

	<?php  }



/* =============================================================================
	PAGE EDITING OPTIONS
	========================================================================== */
	function _page_details(){ global $post, $CORE; $core_admin_values = get_option("core_admin_values"); $packagefields = get_option("packagefields"); 
	
 ?>
<div id="tabs-1c">
    <?php 
	$membershipfields 	= get_option("membershipfields");	
	if(is_array($membershipfields) && !empty($membershipfields)){ 
	
	$current_access = get_post_meta($post->ID, "access", true);
	if(!is_array($current_access)){ $current_access = array(99); }	
	?>
    
 
   <p>Here you can restrict access to this page based on a users membership.</p>
   
   	<select name="wlt_field[access][]" size="2" style="font-size:14px;padding:5px; width:100%; height:150px; background:#e7fff3;" multiple="multiple"  > 
  	<option value="99" <?php if(in_array(99,$current_access)){ echo "selected=selected"; } ?>>All Membership Access</option>
    <?php 
	$i=0;
	
	foreach($membershipfields as $mID=>$package){	
		
		if(is_array($current_access) && in_array($package['ID'],$current_access)){ 
		echo "<option value='".$package['ID']."' selected=selected>".$package['name']."</option>";
		}else{ 
		echo "<option value='".$package['ID']."'>".$package['name']."</option>";		
		}
		
	$i++;		
	} // end foreach
	
    ?>
	</select>
    <br /><small>Hold CTRL to select multiple memberships.</small> 
   <?php } ?>
 </div>
 <?php }
 
	
} // END CORE ADMIN CLASS



 
?>