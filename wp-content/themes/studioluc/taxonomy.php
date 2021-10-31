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

$GLOBALS['flag-search'] = 1;

$term = get_term_by('slug', get_query_var( 'term' ), get_query_var( 'taxonomy' ) );
 
/*
stdClass Object
(
    [term_id] => 1879
    [name] => Ann Summers
    [slug] => ann-summers
    [term_group] => 0
    [term_taxonomy_id] => 1879
    [taxonomy] => store
    [description] => 
    [parent] => 0
    [count] => 0
    [filter] => raw
)      
*/
?>

<?php get_header($CORE->pageswitch());  ?>

<?php ob_start(); ?>

<?php hook_taxonomy_title_before(); ?>

<div class="taxonomytitle">

    <h1><?php echo $term->name; ?></h1>
  
    <h4><?php echo hook_gallerypage_results_text(str_replace("%a",number_format($wp_query->found_posts),$CORE->_e(array('gallerypage','1')))); ?></h4>
    
    <?php if(strlen($term->description) > 3){ echo wpautop(do_shortcode($term->description)); } ?>
    
    <?php echo hook_taxonomy_content_top(ob_get_clean()); ?>

</div>

<div class="clearfix"></div>

<?php hook_taxonomy_title_after(); ?>

<hr />

<?php get_template_part( 'search', 'results' ); ?>


<?php get_footer($CORE->pageswitch()); ?>