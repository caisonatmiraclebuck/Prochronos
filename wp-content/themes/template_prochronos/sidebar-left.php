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
?>

<?php global $CORE; ?>
<?php 
$title = get_the_title();
$page_template = get_post_meta(get_the_id(),'_wp_page_template', true);
if($title !== 'Leave Request' && $page_template !== 'tpl-fastauction.php' && $page_template !== 'tpl-slowauction.php') {?>
<aside class="core_sidebar <?php $CORE->CSS("columns-left"); ?> <?php if(isset($GLOBALS['CORE_THEME']['mobileview']['sidebars']) && $GLOBALS['CORE_THEME']['mobileview']['sidebars'] == '1'){ ?><?php }else{ ?>hidden-xs<?php } ?>" id="core_left_column">
        
	<?php hook_core_columns_left_top(); ?>
 
    <?php dynamic_sidebar('Left Column'); ?>
             
    <?php hook_core_columns_left_bottom(); ?>
            
</aside>
<?php } ?>
