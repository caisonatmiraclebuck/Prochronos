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

global $CORE, $post;

ob_start(); ?>

<div class="itemdata icons auction itemid<?php echo $post->ID; ?> <?php hook_item_class(); ?>" <?php echo $CORE->ITEMSCOPE('itemtype'); ?>>

<div class="thumbnail clearfix"> 

   [IMAGE gallery=1][/IMAGE] 
   
    <div class="content">  
      
    <h3>[TITLE] [RATING style=1 small=1 class="pull-right"]</h3>
    
    <div class="row">
    <div class="col-md-6 col-sm-6 col-xs-6"> [price_current]  </div>
    <div class="col-md-6 col-sm-6 col-xs-6 text-right"> [CATEGORY] <span class="bids">[BIDS] <?php echo $CORE->_e(array('auction','88')); ?></span>    </div>
    </div>
    
 	<div class="line1"></div> 
       
    [EXCERPT]
    
    [BIDDINGTIMELEFT]
    
    </div>
       
    </div> 
 
</div>
 
<?php 
$SavedContent = ob_get_clean(); 
?>
<?php echo hook_item_cleanup($CORE->ITEM_CONTENT($post, hook_content_listing($SavedContent))); ?>  
