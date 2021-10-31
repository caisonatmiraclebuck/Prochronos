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
<div class="itemdata <?php hook_item_class(); ?>" >

<article class="blogitem" id="post-<?php the_ID(); ?>" itemscope itemtype="http://schema.org/Blog">

<?php if ( has_post_thumbnail() ) { ?>

    <a href="<?php the_permalink(); ?>" class="imgframe">
    
		<?php the_post_thumbnail(array(350,350, 'class'=> " img-responsive")); ?>
        
        <div class="label-wrap">
        
            <span class="label date"><?php $dd = hook_date($post->post_date); $f = explode(",",$dd); echo $f[0]; ?></span>
            
        </div>
    
    </a>

<?php }else{ ?>


<?php } ?>

    <div class="blog-content">
    
        <h5><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h5>
        
        <div class="small"><?php if ( !has_post_thumbnail() ) { the_date(); } ?> <?php the_category(','); ?> </div>
        
        <?php echo do_shortcode('[EXCERPT size=200 text_after="..." striptags=true]'); ?>
        
        <a href="<?php the_permalink(); ?>" class="more">Read More</a>
        
    </div>
    
    <div class="clearfix"></div>

</article>

</div>