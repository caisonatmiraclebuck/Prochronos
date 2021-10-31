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

// LOAD IN MAIN DEFAULTS 
$core_admin_values = get_option("core_admin_values");  

 
// LOAD IN MAIN DEFAULTS 
$core_admin_values = get_option("core_admin_values");  
  
?> 

<div class="row-fluid">

<div class="span8">

 
<!-- START ACCORDING --->
<div class="accordion  style1" id="pagesetup_according">
 
<?php do_action('hook_admin_1_tab1_tablist'); ?> 

<?php do_action('hook_admin_1_pagesetup'); ?>


 



 





<div class="accordion-group">
    <div class="accordion-heading" style="background:#fff;">
        <a class="accordion-toggle collapsed" data-toggle="collapse" data-parent="#pagesetup_according" href="#item7">
         <h4 style="margin:0xp;font-weight:bold;">
         
         <img src="<?php echo get_template_directory_uri(); ?>/framework/admin/img/icons/43.png">
         
          Page &amp; Button Links <span style="font-size:12px;">(view/hide)</span></h4> 
        </a>
    </div>
    
    <div id="item7" class="accordion-body collapse">
    <div class="accordion-inner">
    <div class="innerwrap">
    <?php get_template_part('framework/admin/templates/admin', 'pagesetup-links' ); ?>
    </div>
    </div>
    </div>
</div>


<div class="accordion-group">
    <div class="accordion-heading" style="background:#fff;">
        <a class="accordion-toggle collapsed" data-toggle="collapse" data-parent="#pagesetup_according" href="#item0">
         <h4 style="margin:0xp;font-weight:bold;">
         <img src="<?php echo get_template_directory_uri(); ?>/framework/admin/img/icons/2.png">
         Website Logo <span style="font-size:12px;">(view/hide)</span></h4> 
        </a>
    </div>
    
    <div id="item0" class="accordion-body collapse">
    <div class="accordion-inner">
    <div class="innerwrap content">
    <?php get_template_part('framework/admin/templates/admin', '2-logo' ); ?>
    </div>
    </div>
    </div>
</div>





<?php if(!defined('NONAVOPTIONS')){ ?>

<div class="accordion-group">
    <div class="accordion-heading" style="background:#fff;">
        <a class="accordion-toggle collapsed" data-toggle="collapse" data-parent="#pagesetup_according" href="#item1">
         <h4 style="margin:0xp;font-weight:bold;">
         <img src="<?php echo get_template_directory_uri(); ?>/framework/admin/img/icons/3.png">
         Top Navigation <span style="font-size:12px;">(view/hide)</span></h4> 
        </a>
    </div>
    
    <div id="item1" class="accordion-body collapse">
    <div class="accordion-inner">
    <div class="innerwrap content">
    <?php get_template_part('framework/admin/templates/admin', '2-topnav' ); ?>
    </div>
    </div>
    </div>
</div>


<div class="accordion-group">
    <div class="accordion-heading" style="background:#fff;">
        <a class="accordion-toggle collapsed" data-toggle="collapse" data-parent="#pagesetup_according" href="#item2">
         <h4 style="margin:0xp;font-weight:bold;">
         <img src="<?php echo get_template_directory_uri(); ?>/framework/admin/img/icons/4.png">
         Main Menu <span style="font-size:12px;">(view/hide)</span></h4> 
        </a>
    </div>
    
    <div id="item2" class="accordion-body collapse">
    <div class="accordion-inner">
    <div class="innerwrap content">
    <?php get_template_part('framework/admin/templates/admin', '2-mainmenu' ); ?>
    </div>
    </div>
    </div>
</div>

<?php } ?>


<div class="accordion-group">
    <div class="accordion-heading" style="background:#fff;">
        <a class="accordion-toggle collapsed" data-toggle="collapse" data-parent="#pagesetup_according" href="#item3">
         <h4 style="margin:0xp;font-weight:bold;">
         <img src="<?php echo get_template_directory_uri(); ?>/framework/admin/img/icons/5.png">
         Breadcrumbs <span style="font-size:12px;">(view/hide)</span></h4> 
        </a>
    </div>
    
    <div id="item3" class="accordion-body collapse">
    <div class="accordion-inner">
    <div class="innerwrap content">
    <?php get_template_part('framework/admin/templates/admin', '2-breadcrumbs' ); ?>
    </div>
    </div>
    </div>
</div>


<div class="accordion-group">
    <div class="accordion-heading" style="background:#fff;">
        <a class="accordion-toggle collapsed" data-toggle="collapse" data-parent="#pagesetup_according" href="#item4">
         <h4 style="margin:0xp;font-weight:bold;">
         <img src="<?php echo get_template_directory_uri(); ?>/framework/admin/img/icons/6.png">
         Footer <span style="font-size:12px;">(view/hide)</span></h4> 
        </a>
    </div>
    
    <div id="item4" class="accordion-body collapse">
    <div class="accordion-inner">
    <div class="innerwrap content">
    <?php get_template_part('framework/admin/templates/admin', '2-footer' ); ?>
    </div>
    </div>
    </div>
</div>


<div class="accordion-group">
    <div class="accordion-heading" style="background:#fff;">
        <a class="accordion-toggle collapsed" data-toggle="collapse" data-parent="#pagesetup_according" href="#item5">
         <h4 style="margin:0xp;font-weight:bold;">
         <img src="<?php echo get_template_directory_uri(); ?>/framework/admin/img/icons/7.png">
         Custom CSS/Javascript <span style="font-size:12px;">(view/hide)</span></h4> 
        </a>
    </div>
    
    <div id="item5" class="accordion-body collapse">
    <div class="accordion-inner">
    <div class="innerwrap content">
    <?php get_template_part('framework/admin/templates/admin', 'item-customcss' ); ?>
    </div>
    </div>
    </div>
</div>



</div><!-- END ACCORDING -->



















	

</div>

<div class="span4">






 <a data-toggle="modal" href="#VideoModelBox" class="btn btn-warning youtube" onclick="PlayPPTVideo('U-qYp90Scfw','videoboxplayer','479','350');" style="width:100%; margin-bottom:10px; ">Watch Video Tutorial</a>




 
 

<div class="box gradient">

      <div class="title">
            <div class="row-fluid"><h3> Responisve Design</h3></div>
        </div> 
        
        <div class="content">
        
        
      
            <div class="form-row control-group row-fluid ">
                            <label class="control-label span7" rel="tooltip" data-original-title="Enable this option if you want the website to become fluid and resizable. This option is recommended if you want your site to appear resized for mobile and tablet devices." data-placement="top">Responsive Design</label>
                            <div class="controls span5">
                              <div class="row-fluid">
                                <div class="pull-left">
                                  <label class="radio off">
                                  <input type="radio" name="toggle" 
                                  value="off" onchange="document.getElementById('display_responsive').value='0'">
                                  </label>
                                  <label class="radio on">
                                  <input type="radio" name="toggle"
                                  value="on" onchange="document.getElementById('display_responsive').value='1'">
                                  </label>
                                  <div class="toggle <?php if($core_admin_values['responsive'] == '1'){  ?>on<?php } ?>">
                                    <div class="yes">ON</div>
                                    <div class="switch"></div>
                                    <div class="no">OFF</div>
                                  </div>
                                </div> 
                               </div>
                             </div>
                             
                             <input type="hidden" class="row-fluid" id="display_responsive" name="admin_values[responsive]" 
                             value="<?php echo $core_admin_values['responsive']; ?>">
            </div>
        
        
<script>

function changelayoutstyle(t){

if(t == 1){
	jQuery('#lw').val(0);
	jQuery('#lc').val(1);
}else{
	jQuery('#lw').val(1);
	jQuery('#lc').val(0);
}

document.admin_save_form.submit();
}

</script>

<input id="lw" class="hidden" name="admin_values[layout_layoutwidth]" value="<?php echo $core_admin_values['layout_layoutwidth']; ?>">
<input id="lc" class="hidden" name="admin_values[layout_contentwidth]" value="<?php echo $core_admin_values['layout_contentwidth']; ?>">
        
      
<div class="well row-fluid" style="border-radius: 0px;">        
    <div class="span6">
               
                <a href="javascript:void(0);" onclick="changelayoutstyle(1);">
                <img src="<?php echo get_template_directory_uri(); ?>/framework/admin/img/core/boxed.png" style="border:1px solid #ccc; padding:4px;background:#fff; <?php if($core_admin_values['layout_layoutwidth'] ==  0){ echo "border:1px solid red;"; } ?>">
                </a>
                     
    </div>        
    <div class="span6">
                <a href="javascript:void(0);" onclick="changelayoutstyle(2);">
                <img src="<?php echo get_template_directory_uri(); ?>/framework/admin/img/core/wide.png" style="border:1px solid #ccc; padding:4px;background:#fff; <?php if($core_admin_values['layout_layoutwidth'] == 1){ echo "border:1px solid red;"; } ?>">
                </a>
                     
    </div>
</div>

</div>
        
        
    </div>





	<div class="box gradient">

      <div class="title">
            <div class="row-fluid"><h3> Large Site Caching  </h3></div>
        </div> 
        
        <div class="content">
        
        <div style="padding:10px; background:#fff; border:1px dashed green; font-size:11px; margin-bottom:10px;">
         <b>Recommended for sites with 10,000+ listings.</b> This will cache slow queries for 24 hours speeding up your website.
         </div>
         
          	<div class="form-row row-fluid span12 clearfix" >
                            <label class="control-label span4" data-placement="top">Enable</label>
                            <div class="controls span5">
                              <div class="row-fluid">                              
                                  <label class="radio off">
                                  <input type="radio" name="toggle" 
                                  value="off" onchange="document.getElementById('querycaching').value='0'">
                                  </label>
                                  <label class="radio on">
                                  <input type="radio" name="toggle"
                                  value="on" onchange="document.getElementById('querycaching').value='1'">
                                  </label>
                                  <div class="toggle <?php if($core_admin_values['querycaching'] == '1'){  ?>on<?php } ?>">
                                    <div class="yes">ON</div>
                                    <div class="switch"></div>
                                    <div class="no">OFF</div>
                                  </div>
                                </div> 
                               </div>
                            
                             
                             <input type="hidden" class="row-fluid" id="querycaching" name="admin_values[querycaching]" 
                             value="<?php echo $core_admin_values['querycaching']; ?>">
            </div>
             <div class="clearfix"></div>
        
        
        </div>
        
    </div>
 





</div>

</div>
 