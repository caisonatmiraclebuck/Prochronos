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

 
if(defined('WLT_DEMOMODE') && isset($_SESSION['skin']) && file_exists(WP_CONTENT_DIR."/themes/".$_SESSION['skin']."/home.php") ){

	include(WP_CONTENT_DIR."/themes/".$_SESSION['skin']."/home.php");	
	
}elseif(isset($GLOBALS['CORE_THEME']['homepage']) 
&& strlen($GLOBALS['CORE_THEME']['homepage']['widgetblock1']) > 1 
&& ( isset($GLOBALS['CORE_THEME']['homeeditor']) && $GLOBALS['CORE_THEME']['homeeditor'] == 1 )){

	get_header($CORE->pageswitch());

	// HOOK BEFORE OBJECT OUTPUT
	hook_homepage_before();	 
	 	
		// GET HOME PAGE OBJECTS FROM THE ADMIN
		global $OBJECTS;
		echo $OBJECTS->WIDGETBLOCKS($GLOBALS['CORE_THEME']['homepage']['widgetblock1'], $fullwidth=false);		
						
	//HOOK AFTER OUTPUT
	hook_homepage_after(); 

	get_footer($CORE->pageswitch());	

}elseif(isset($_POST['homelayoutid']) && strlen($_POST['homelayoutid']) > 1 && defined('WLT_DEMOMODE') ){  
 
	get_template_part( 'home', $_POST['homelayoutid'] );

}elseif(isset($GLOBALS['CORE_THEME']['homepage_layout']) && $GLOBALS['CORE_THEME']['homepage_layout'] != "" ){
	 
	get_template_part( 'home', $GLOBALS['CORE_THEME']['homepage_layout'] );
		
}else{ 

	get_header($CORE->pageswitch());

	// HOOK BEFORE OBJECT OUTPUT
	hook_homepage_before();	 
	 	
		// GET HOME PAGE OBJECTS FROM THE ADMIN		
		echo "no home page set";		
						
	//HOOK AFTER OUTPUT
	hook_homepage_after(); 

	get_footer($CORE->pageswitch());

} ?>