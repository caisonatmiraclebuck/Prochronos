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

global $CORE, $LAYOUT, $wpdb;
?>

<?php get_header($CORE->pageswitch());  ?>

<?php hook_gallerypage_before(); ?>

<div class="_searchresultsblock">

<?php if(!defined('HIDE_SEARCHRESULTS_BOX')){ ?>    
    
    <?php if(!defined('HIDE_SEARCHRESULTS_HEAD')){ ?>
    
    <h1><?php echo hook_gallerypage_results_title(''); ?></h1>
    
    <?php if($GLOBALS['CORE_THEME']['querycaching'] != 1){ ?>
    <h4><?php echo hook_gallerypage_results_text(str_replace("%a",number_format($wp_query->found_posts),$CORE->_e(array('gallerypage','1')))); ?></h4>
    <?php } ?>
 
<?php } ?>
 

<?php if(!isset($GLOBALS['CORE_THEME']['search_searchbar']) || isset($GLOBALS['CORE_THEME']['search_searchbar']) && $GLOBALS['CORE_THEME']['search_searchbar'] == 1){ ?>

<div class="row">

    <div class="col-md-6 col-sm-12 col-xs-12">
        
        <form action="<?php echo get_home_url(); ?>/" method="get" class="form-inline" role="search">
        
        <input type="text" class="form-control " name="s" placeholder="<?php echo $CORE->_e(array('homepage','7')); ?>">
        
      	<?php hook_gallerypage_searchform(); ?>
        
        <button type="submit" class="btn btn-primary"><?php echo $CORE->_e(array('button','11')); ?></button> 
              
        </form>
    
    </div>
    
    <div class="col-md-6 col-sm-12 col-xs-12">
 
        <ul class="list-inline ext1">
        
        <li class="sf"><a href="javascript:void(0);" onclick="jQuery('#s1').show(); ShowAdSearch('<?php echo str_replace("http://","",get_home_url()); ?>','advancedsearchformajax');"><?php echo $CORE->_e(array('head','2')); ?></a></li>
        
        <?php if($GLOBALS['CORE_THEME']['show_account_favs'] == '1'){ ?>
                
        <li class="fac"><a href="<?php echo home_url().'/?s=&amp;favs=1'; ?>"><?php echo $CORE->_e(array('account','46')); ?> (<?php echo $CORE->FAVSCOUNT(); ?>)</a></li>
                
        <?php } ?>
        
        <?php if(isset($GLOBALS['CORE_THEME']['geolocation']) && $GLOBALS['CORE_THEME']['geolocation'] != "" && $GLOBALS['CORE_THEME']['google'] == 1){ 
		
				if(isset($_SESSION['mylocation'])){
				$country = $_SESSION['mylocation']['country'];
				$addresss = $_SESSION['mylocation']['address'];
				}else{
				$address = "";
				$country = $GLOBALS['CORE_THEME']['geolocation_flag'];
				}
			 
		?>
        
        <li class="cff"><a href="javascript:void(0);" onclick="GMApMyLocation();" data-toggle="modal" data-target="#MyLocationModal"><div class="flag flag-<?php echo strtolower($country); ?> wlt_locationflag"></div><?php echo $CORE->_e(array('widgets','16')); ?></a></li>
        
        <?php } ?>
        
        </ul>
    
    </div>
 
</div>

<div class="clearfix"></div>

<hr />

<?php } ?>

<div id="s1" style="display:none">

    <div class="box1" >
    
    <a href="javascript:void(0);" onclick="jQuery('#s1').hide();" class="badge pull-right" ><?php echo $CORE->_e(array('single','14')); ?></a>
  
    <div id="advancedsearchformajax"></div>
   
    </div>
    
    <hr />
    
</div>  

<?php } ?>

<?php if(have_posts() && $GLOBALS['CORE_THEME']['search_sortby'] == '1'){ ?>
 
<ul class="list-inline orderby clearfix">

    <li><strong><?php echo $CORE->_e(array('gallerypage','9')); ?>: </strong></li>
    
    <?php echo $CORE->OrderBy(); ?>
    
    <li class="pull-right hidden-xs hidden-sm">
    
     <a href="#" id="wlt_search_tab1" class="btn btn-default btn-sm <?php if($GLOBALS['CORE_THEME']['display']['default_gallery_style'] == "list"){ echo "active"; }?>">
                    <i class="fa fa-list"></i> <?php echo $CORE->_e(array('button','50')); ?></a>
                    
                    <?php if($GLOBALS['CORE_THEME']['display']['default_gallery_style'] != "listonly"){ ?>
                    <a href="#" id="wlt_search_tab2" class="btn btn-default btn-sm <?php if($GLOBALS['CORE_THEME']['display']['default_gallery_style'] == "grid"){ echo "active"; }?>">
                    <i class="fa fa-th-large"></i> <?php echo $CORE->_e(array('button','51')); ?></a>
                    <?php } ?>
                    
                    <?php if($GLOBALS['CORE_THEME']['display']['default_gallery_style'] != "listonly" && $GLOBALS['CORE_THEME']['google'] == 1){ ?>
                    <a href="#" id="wlt_search_tab3" class="btn btn-default btn-sm"><span class="glyphicon glyphicon-map-marker"></span> <?php echo $CORE->_e(array('button','52')); ?></a>
                    <?php } ?> 
                    
                    <?php hook_gallerypage_results_btngroup(); ?>    
    </li>
    
</ul>
 
<?php } ?>  

<div class="clearfix"></div>  

</div>


<?php hook_gallerypage_results_before(); ?> 

<?php get_template_part( 'search', 'results' ); ?>

<?php hook_gallerypage_results_after(); ?>

<?php get_footer($CORE->pageswitch()); ?>