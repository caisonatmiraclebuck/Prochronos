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

global $CORE, $userdata;  $showBreadcrumbs = true; $isTop = false;
	

	if(!isset($GLOBALS['flag-home']) && $GLOBALS['CORE_THEME']['breadcrumbs_inner'] != '1'){
	$showBreadcrumbs = false;
	}elseif(isset($GLOBALS['flag-home']) && $GLOBALS['CORE_THEME']['breadcrumbs_home'] != '1'){
	$showBreadcrumbs = false;
	}
 	
	if( $showBreadcrumbs ){ 	
	$STRING = '<!-- FRAMRWORK // BREADCRUMBS --> 
	 
	<div id="core_breadcrumbs" class="clearfix">
	<div class="'.$CORE->CSS("container", true).'">
		<div class="row"> 
		 
			<ul class="breadcrumb pull-left">  
			'.hook_breadcrumbs_func($CORE->BREADCRUMBS('<li>','</li>')).'
			</ul>	 
		
			<ul class="breadcrumb pull-right">';
			
			// ACCOUNT LINKS
			if(isset($GLOBALS['CORE_THEME']['header_accountdetails']) && $GLOBALS['CORE_THEME']['header_accountdetails'] != 1){
			$STRING .= _accout_links();
			}
			
			// SOCIAL ICONS
			if(!$isTop && isset($GLOBALS['CORE_THEME']['social']) && isset($GLOBALS['CORE_THEME']['breadcrumbs_social']) && $GLOBALS['CORE_THEME']['breadcrumbs_social'] == 1){   
			
			$blog_title = get_bloginfo('name');            
						   
			$STRING .= '<li>
			
			<a href="https://api.addthis.com/oexchange/0.8/forward/facebook/offer?url='.home_url().'&amp;pubid=ra-53d6f43f4725e784&amp;ct=1&amp;title='.$blog_title.'&amp;pco=tbxnj-1.0" target="_blank">
<img src="'.get_template_directory_uri().'/framework/img/social/facebook16.png" alt="Facebook"/></a>
<a href="https://api.addthis.com/oexchange/0.8/forward/twitter/offer?url='.home_url().'&amp;pubid=ra-53d6f43f4725e784&amp;ct=1&amp;title='.$blog_title.'&amp;pco=tbxnj-1.0" target="_blank">
<img src="'.get_template_directory_uri().'/framework/img/social/twitter16.png" alt="Twitter"/></a>
<a href="https://api.addthis.com/oexchange/0.8/forward/linkedin/offer?url='.home_url().'&amp;pubid=ra-53d6f43f4725e784&amp;ct=1&amp;title='.$blog_title.'&amp;pco=tbxnj-1.0" target="_blank">
<img src="'.get_template_directory_uri().'/framework/img/social/linkedin16.png"  alt="LinkedIn"/></a>
<a href="https://api.addthis.com/oexchange/0.8/forward/google_plusone_share/offer?url='.home_url().'&amp;pubid=ra-53d6f43f4725e784&amp;ct=1&amp;title='.$blog_title.'&amp;pco=tbxnj-1.0" target="_blank"><img src="'.get_template_directory_uri().'/framework/img/social/googleplus16.png"  alt="Google+"/></a>
			</li>';
													   
			}
	
		$STRING .= '</ul>
		</div>
	</div> 
	</div>';	


echo hook_breadcrumbs($STRING);
}
	
?>