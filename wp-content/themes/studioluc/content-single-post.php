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

global $post, $CORE;


?>

<div class="panel panel-default">
	 
	<div class="panel-heading"><?php echo $CORE->_e(array('button','55')); ?></div>
	 
	 <div class="panel-body">  
     
     	<h1><?php the_title(); ?></h1>
        
        <hr />
        
        <p> <span class="label label-default"><?php the_date(); ?></span>  <?php echo do_shortcode('[D_SOCIAL size=16]'); ?>  <span class="pull-right"> <i class="fa fa-code"></i> <?php the_category(','); ?></span> </p>
        
        <hr />
		
		<?php if ( has_post_thumbnail() ) { ?> <?php the_post_thumbnail('full',array("class" => "img-polaroid")); ?> <hr /> <?php } ?>
	
		<?php the_content(); ?>
	   
		 
	</div>
	 
</div>
		
	 
<?php if ( comments_open() ){ ?>
    
        <div class="panel panel-default">
         
         <div class="panel-heading"><?php echo $CORE->_e(array('comment','11')); ?></div>
         
         <div class="panel-body"> 
        
            <?php echo $CORE->get_comment_form($post->ID,true); ?> 
            
            <div class="clearfix"></div>
            
         </div>
         
        </div>
 
<?php } ?>