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

global $CORE, $userdata; 
 
if(defined('WLT_DEMOMODE') && isset($_SESSION['skin']) && file_exists(WP_CONTENT_DIR."/themes/".$_SESSION['skin']."/footer-menu.php") ){

	include(WP_CONTENT_DIR."/themes/".$_SESSION['skin']."/footer-menu.php");
	
}elseif(file_exists(str_replace("functions/","",THEME_PATH)."/templates/".$GLOBALS['CORE_THEME']['template']."/_footer.php") ){
		
		include(str_replace("functions/","",THEME_PATH)."/templates/".$GLOBALS['CORE_THEME']['template'].'/_footer.php');
 		
}else{
	

if(!isset($GLOBALS['CORE_THEME']['layout_footer'])){ $footerwidths = 0; }else{ $footerwidths = $GLOBALS['CORE_THEME']['layout_footer']; }
switch($footerwidths){
	case "1": {
	$col1 = "col-md-8";
	$col2 = "col-md-4";
	$col3 = "hide";		
	} break;
	case "2": {
	$col1 = "col-md-4";
	$col2 = "col-md-8";
	$col3 = "hide";		
	} break;
	case "3": {
	$col1 = "col-md-12";
	$col2 = "hide";
	$col3 = "hide";		
	} break;
	
	case "5": {
	$col1 = "col-md-3";
	$col2 = "col-md-3";
	$col3 = "col-md-3";		
	$col4 = "col-md-3";	
	} break;	
	
	default: {	
	$col1 = "col-md-4";
	$col2 = "col-md-4";
	$col3 = "col-md-4";
	} break;
}// end switcj

?>
<!-- [WLT] FRAMRWORK // FOOTER -->

<p id="back-top"> <a href="#top"><span></span></a> </p>

<footer id="footer">
	
    <div id="footer_content">
    
        <div class="<?php $CORE->CSS("container"); ?>">
        
            <div class="row clearfix">
                
                    <div class="<?php echo $col1; ?>"><?php dynamic_sidebar('sidebar-3'); ?></div>
                    
                    <div class="<?php echo $col2; ?> hidden-xs"><?php dynamic_sidebar('sidebar-4'); ?></div>
                    
                    <div class="<?php echo $col3; ?> hidden-xs"><?php dynamic_sidebar('sidebar-5'); ?></div>
                    
                    <?php if($GLOBALS['CORE_THEME']['layout_footer'] == 5){ ?>
                    <div class="<?php echo $col4; ?> hidden-xs"><?php dynamic_sidebar('sidebar-6'); ?></div>
                    <?php } ?>
                
            </div>
       
       </div>
   
   </div>
   
   <div id="footer_bottom">
   
   <div class="<?php $CORE->CSS("container"); ?>">
    
    <div class="row clearfix">
    
    
   	 <div class="pull-left copybit"> <?php echo stripslashes($GLOBALS['CORE_THEME']['copyright']); ?> </div>   
            
            <?php
			
			// GET MENU DATA
			$locations = get_nav_menu_locations();
			$menu_name = 'footer-menu';		
			if ( ( $locations ) && isset( $locations[ $menu_name ] ) && $locations[ $menu_name ] != 0 ) {
			
			$nav_menu = wp_get_nav_menu_object($locations[$menu_name]);
			
			echo  wp_nav_menu( array( 
						'container' => '',
						'container_class' => '',
						'menu' => $nav_menu->term_id,
						'menu_class' => 'list-inline pull-left',
						'fallback_cb'     => '',
						'echo'            => false,
						'walker' => new Bootstrap_Walker(),									
						) );
			
			} ?> 
              
                <?php
                $si = ""; $sb = "";
                if(isset($GLOBALS['CORE_THEME']['social'])){
                $si = "<ul class='socialicons list-inline pull-right'>";
                    
                        if(strlen($GLOBALS['CORE_THEME']['social']['twitter']) > 1){ 						 
						$sb .= "<li><a href='".$GLOBALS['CORE_THEME']['social']['twitter']."' class='twitter' rel='nofollow' target='_blank'>
						<i class='fa ".$GLOBALS['CORE_THEME']['social']['twitter_icon']."'></i>
						</a></li>"; } 
                        if(strlen($GLOBALS['CORE_THEME']['social']['dribbble']) > 1){ 
						$sb .= "<li><a href='".$GLOBALS['CORE_THEME']['social']['dribbble']."' class='dribbble' rel='nofollow' target='_blank'>
						<i class='fa ".$GLOBALS['CORE_THEME']['social']['dribbble_icon']."'></i>
						</a></li>"; } 
                        if(strlen($GLOBALS['CORE_THEME']['social']['facebook']) > 1){ 
						$sb .= "<li><a href='".$GLOBALS['CORE_THEME']['social']['facebook']."' class='facebook' rel='nofollow' target='_blank'>
						<i class='fa ".$GLOBALS['CORE_THEME']['social']['facebook_icon']."'></i>
						</a></li>"; } 
                        if(strlen($GLOBALS['CORE_THEME']['social']['linkedin']) > 1){ 
						$sb .= "<li><a href='".$GLOBALS['CORE_THEME']['social']['linkedin']."' class='linkedin' rel='nofollow' target='_blank'>
						<i class='fa ".$GLOBALS['CORE_THEME']['social']['linkedin_icon']."'></i>
						</a></li>"; } 
                        if(strlen($GLOBALS['CORE_THEME']['social']['youtube']) > 1){ 
						$sb .= "<li><a href='".$GLOBALS['CORE_THEME']['social']['youtube']."' class='youtube' rel='nofollow' target='_blank'>
						<i class='fa ".$GLOBALS['CORE_THEME']['social']['youtube_icon']."'></i>
						</a></li>"; } 
                        if(strlen($GLOBALS['CORE_THEME']['social']['rss']) > 1){ 
						$sb .= "<li><a href='".$GLOBALS['CORE_THEME']['social']['rss']."' class='rss' rel='nofollow' target='_blank'>
						<i class='fa ".$GLOBALS['CORE_THEME']['social']['rss_icon']."'></i>
						</a></li>"; } 
                        
                $si .= $sb."</ul>";
                if($sb == ""){ $si = ""; }
                }
                echo hook_footer_socialicons($si);
                ?>
        
    </div> 
    
    </div>
    
    </div>

</footer>
<div id="freeow" class="freeow freeow-top-right"></div>
<?php } ?>