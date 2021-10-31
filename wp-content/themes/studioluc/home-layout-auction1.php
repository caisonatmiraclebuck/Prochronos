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

global $CORE;
 

// GET HOME PAGE CUSTOM DATA
$HDATA = $GLOBALS['CORE_THEME']['hdata'];

// GET CATEGORIES
$i=1;
$args = array(
				  'taxonomy'     => THEME_TAXONOMY,
				  'orderby'      => 'ID',
				  'order'		=> 'asc',
				  'show_count'   => 1,
				  'pad_counts'   => 0,
				  'hierarchical' => 0,
				  'title_li'     => '',			 
				  'hide_empty'   => 0,				 
); 
$categories = get_categories($args); 



function _hook_header_after(){ global $CORE, $post; $HDATA = $GLOBALS['CORE_THEME']['hdata']; ?>


<?php if(!isset($GLOBALS['CORE_THEME']['home_section1']) || (isset($GLOBALS['CORE_THEME']['home_section1']) && $GLOBALS['CORE_THEME']['home_section1'] == '1' ) ){  ?>
 
<?php if(isset($GLOBALS['CORE_THEME']['homesliderid']) && $GLOBALS['CORE_THEME']['homesliderid'] != "" && $GLOBALS['CORE_THEME']['homeslider'] == 1 ){  

echo do_shortcode(stripslashes("[rev_slider ".$GLOBALS['CORE_THEME']['homesliderid']."]")); 

}else{ ?>

<div class="greby hidden-xs">
    
<div class="<?php $CORE->CSS("container"); ?>">
<div class="wrap1">
<div class="row">
<div class="col-md-3">

<?php echo do_shortcode('[D_CATEGORIES limit=7]'); ?>

</div>

<div class="col-md-9 hidden-sm">

<div class="jumbostyle1 cols<?php echo $GLOBALS['CORE_THEME']['layout_columns']['homepage']; ?>" <?php if(isset($HDATA['j1']['img']) && $HDATA['j1']['img'] != ""){ echo 'style="background-image: url(\''.$HDATA['j1']['img'].'\'); background-size: cover;"'; } ?>>

    <div class="jumbotron">
    
    <div class="inner">
            
            <h1><?php echo stripslashes($HDATA['j1']['title1']); ?></h1>
            
            <h2><?php echo stripslashes($HDATA['j1']['title2']); ?></h2>
            
            <?php echo wpautop(stripslashes($HDATA['j1']['title3'])); ?>
                    
            <p><a href="<?php echo $GLOBALS['CORE_THEME']['links']['myaccount']; ?>" class="btn btn-lg btn-primary"><?php echo $CORE->_e(array('button','59')); ?></a>  
            
            <a href="<?php echo home_url(); ?>/?s=" class="btn btn-lg btn-primary"><?php echo $CORE->_e(array('button','60')); ?></a></p>
    </div>
     
    </div>

</div>

</div>
</div>
</div>
</div>

</div>

<div class="clearfix"></div>
 
<?php } ?> 


<?php } ?>
<?php
}
add_action('hook_header_after','_hook_header_after');
 
// HEADER
get_header($CORE->pageswitch()); 

?>




 













 

<?php if(!isset($GLOBALS['CORE_THEME']['home_section2']) || (isset($GLOBALS['CORE_THEME']['home_section2']) && $GLOBALS['CORE_THEME']['home_section2'] == '1' ) ){  ?>
 
<div class="row boxes1" style="margin-top:15px;">
 <?php
		$i = 1;	 $cat = 1;
		foreach ($categories as $category) { 

		// HIDE PARENT
		if($category->parent != 0){ continue; }
		if($i > 4){  continue; }
 		
		// IMAGE
		if(defined('WLT_DEMOMODE') ){		
		$image = "http://wlthemes.com/democontent/".$GLOBALS['CORE_THEME']['template']."/c".$cat.".jpg";
		$cat++;
		}elseif(isset($category->term_id) && isset($GLOBALS['CORE_THEME']['category_icon_'.$category->term_id])   ){
		$image = $GLOBALS['CORE_THEME']['category_icon_'.$category->term_id];
		}else{
		$image = get_template_directory_uri()."/framework/img/demo/noimage.png"; 
		}		
	 
?>
  
 
<div class="col-md-3 col-sm-6 col-xs-12"> 
    <div class="imgwrap box<?php echo $i; ?>" style="background-image:url(<?php echo $image; ?>);">
        <div class="wrap" >
        	<a href="<?php echo get_term_link($category); ?>"><?php echo substr($category->name,0,101); ?></a>
        </div>
    </div>
</div>
<?php $i++; } ?> 
</div>


<?php } ?>
  





















<?php if(!isset($GLOBALS['CORE_THEME']['home_section3']) || (isset($GLOBALS['CORE_THEME']['home_section3']) && $GLOBALS['CORE_THEME']['home_section3'] == '1' ) ){  ?>
 
<div id="car1" class="owl-carousel wlt_search_results grid_style style1">
<?php echo do_shortcode('[LISTINGS dataonly=1 show=8 custom="endsoon"]'); ?> 
</div> 
<script>
jQuery(document).ready(function() { 
  jQuery("#car1").owlCarousel({ items : 4, autoPlay : true, rtl: true  }); 
});
</script>

<?php } ?>




















<?php if(!isset($GLOBALS['CORE_THEME']['home_section4']) || (isset($GLOBALS['CORE_THEME']['home_section4']) && $GLOBALS['CORE_THEME']['home_section4'] == '1' ) ){  ?>

 
<div class="row boxes1">
 <?php
		$i = 0; $cat = 5;
		foreach ($categories as $category) { 

		// HIDE PARENT
		if($category->parent != 0){ continue; }
		if($i < 4){ $i++; continue; }
		if($i > 7){ $i++; continue; }
		
		// IMAGE
		if(defined('WLT_DEMOMODE') ){		
		$image = "http://wlthemes.com/democontent/".$GLOBALS['CORE_THEME']['template']."/c".$cat.".jpg";
		$cat++;
		}elseif(isset($category->term_id) && isset($GLOBALS['CORE_THEME']['category_icon_'.$category->term_id])   ){
		$image = $GLOBALS['CORE_THEME']['category_icon_'.$category->term_id];
		}else{
		$image = get_template_directory_uri()."/framework/img/demo/noimage.png";
		}		
	 
?>
  
 
<div class="col-md-3 col-sm-6 col-xs-12"> 
    <div class="imgwrap box<?php echo $i; ?>" style="background-image:url(<?php echo $image; ?>);">
        <div class="wrap" >
        	<a href="<?php echo get_term_link($category); ?>"><?php echo substr($category->name,0,101); ?></a>
        </div>
    </div>
</div>
<?php $i++; } ?> 
</div>

<?php } ?>














<?php if(!isset($GLOBALS['CORE_THEME']['home_section5']) || (isset($GLOBALS['CORE_THEME']['home_section5']) && $GLOBALS['CORE_THEME']['home_section5'] == '1' ) ){  ?>

<div id="car2" class="owl-carousel wlt_search_results grid_style style1">
<?php echo do_shortcode('[LISTINGS dataonly=1 show=8 custom="popular"]'); ?> 
</div>
<script>
jQuery(document).ready(function() {   
  jQuery("#car2").owlCarousel({ items : 4, autoPlay : true,  });  
});
</script>
<?php } ?> 










<?php get_footer($CORE->pageswitch()); ?>