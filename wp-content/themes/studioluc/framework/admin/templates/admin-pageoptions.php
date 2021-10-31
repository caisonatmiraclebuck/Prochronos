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
  
?> 

<div class="row-fluid">

<div class="span8">



<!-- START ACCORDING --->
<div class="accordion style1" id="pageoptions_according">





<div class="accordion-group">
    <div class="accordion-heading" style="background:#fff;">
        <a class="accordion-toggle collapsed" data-toggle="collapse" data-parent="#pageoptions_according" href="#op0">
         <h4 style="margin:0xp;font-weight:bold;">
         
         <img src="<?php echo get_template_directory_uri(); ?>/framework/admin/img/icons/40.png">
         Mobile Setup <span style="font-size:12px;">(view/hide)</span></h4> 
        </a>
    </div>
    
    <div id="op0" class="accordion-body collapse">
    <div class="accordion-inner">
    <div class="innerwrap content">
    <?php get_template_part('framework/admin/templates/admin', 'pageoptions-mobile' ); ?>
    </div>
    </div>
    </div>
</div>

<?php if(!defined('WLT_CART')){ ?> 

<div class="accordion-group">
    <div class="accordion-heading" style="background:#fff;">
        <a class="accordion-toggle <?php if(!isset($_GET['enterkey'])){ ?>collapsed<?php } ?>" data-toggle="collapse" data-parent="#pageoptions_according" href="#op2">
         <h4 style="margin:0xp;font-weight:bold;">
         <img src="<?php echo get_template_directory_uri(); ?>/framework/admin/img/icons/44.png">
         GEO Location &amp; Google Maps <span style="font-size:12px;">(view/hide)</span></h4> 
        </a>
    </div>
    
    <div id="op2" class="accordion-body <?php if(!isset($_GET['enterkey'])){ ?>collapse<?php } ?>">
    <div class="accordion-inner">
    <div class="innerwrap content">
    <?php get_template_part('framework/admin/templates/admin', 'pageoptions-maps' ); ?>
    </div>
    </div>
    </div>
</div>

<?php } ?>


<div class="accordion-group">
    <div class="accordion-heading" style="background:#fff;">
        <a class="accordion-toggle collapsed" data-toggle="collapse" data-parent="#pageoptions_according" href="#op1">
         <h4 style="margin:0xp;font-weight:bold;">
         <img src="<?php echo get_template_directory_uri(); ?>/framework/admin/img/icons/39.png">
         Images &amp; Uploads <span style="font-size:12px;">(view/hide)</span></h4> 
        </a>
    </div>
    
    <div id="op1" class="accordion-body collapse">
    <div class="accordion-inner">
    <div class="innerwrap content">
    <?php get_template_part('framework/admin/templates/admin', 'pageoptions-images' ); ?>
    </div>
    </div>
    </div>
</div>


<div class="accordion-group">
    <div class="accordion-heading" style="background:#fff;">
        <a class="accordion-toggle collapsed" data-toggle="collapse" data-parent="#pageoptions_according" href="#op3">
         <h4 style="margin:0xp;font-weight:bold;">
         <img src="<?php echo get_template_directory_uri(); ?>/framework/admin/img/icons/42.png">
         Analytics &amp; Tracking <span style="font-size:12px;">(view/hide)</span></h4> 
        </a>
    </div>
    
    <div id="op3" class="accordion-body collapse">
    <div class="accordion-inner">
    <div class="innerwrap content">
    <?php get_template_part('framework/admin/templates/admin', 'pageoptions-analytics' ); ?>
    </div>
    </div>
    </div>
</div>


<div class="accordion-group">
    <div class="accordion-heading" style="background:#fff;">
        <a class="accordion-toggle collapsed" data-toggle="collapse" data-parent="#pageoptions_according" href="#op38">
         <h4 style="margin:0xp;font-weight:bold;">
         <img src="<?php echo get_template_directory_uri(); ?>/framework/admin/img/icons/38.png">
         Comments <span style="font-size:12px;">(view/hide)</span></h4> 
        </a>
    </div>
    
    <div id="op38" class="accordion-body collapse">
    <div class="accordion-inner">
    <div class="innerwrap content">
    <?php get_template_part('framework/admin/templates/admin', 'pageoptions-comments' ); ?>
    </div>
    </div>
    </div>
</div>

<?php if(!defined('WLT_CART')){ ?>
<div class="accordion-group">
    <div class="accordion-heading" style="background:#fff;">
        <a class="accordion-toggle collapsed" data-toggle="collapse" data-parent="#pageoptions_according" href="#op4">
         <h4 style="margin:0xp;font-weight:bold;">
         <img src="<?php echo get_template_directory_uri(); ?>/framework/admin/img/icons/41.png">
         Star Rating &amp; Feedback System <span style="font-size:12px;">(view/hide)</span></h4> 
        </a>
    </div>
    
    <div id="op4" class="accordion-body collapse">
    <div class="accordion-inner">
    <div class="innerwrap content">
    <?php get_template_part('framework/admin/templates/admin', 'pageoptions-rating' ); ?>
    </div>
    </div>
    </div>
</div>
<?php } ?>

</div>


</div> 
<div class="span4">


 <a data-toggle="modal" href="#VideoModelBox" class="btn btn-warning youtube" onclick="PlayPPTVideo('U-qYp90Scfw','videoboxplayer','479','350');" style="width:100%; margin-bottom:10px; ">Watch Video Tutorial</a>



	<div class="box gradient">

      <div class="title">
            <div class="row-fluid"><h3> ItemScope <a href="http://schema.org/" target="_blank" class="label label-info pull-right" style="margin-top:8px; margin-right:8px;">More Info</a>  </h3></div>
        </div> 
        
        <div class="content">
        
        <div style="padding:10px; background:#fff; border:1px dashed green; font-size:11px; margin-bottom:10px;">
         Here you can enable/disable ItemScope tags from being added to your website.
         </div>
         
          	<div class="form-row row-fluid span12 clearfix" >
                            <label class="control-label span4" data-placement="top">Enable</label>
                            <div class="controls span5">
                              <div class="row-fluid">                              
                                  <label class="radio off">
                                  <input type="radio" name="toggle" 
                                  value="off" onchange="document.getElementById('itemscope').value='0'">
                                  </label>
                                  <label class="radio on">
                                  <input type="radio" name="toggle"
                                  value="on" onchange="document.getElementById('itemscope').value='1'">
                                  </label>
                                  <div class="toggle <?php if($core_admin_values['itemscope'] == '1'){  ?>on<?php } ?>">
                                    <div class="yes">ON</div>
                                    <div class="switch"></div>
                                    <div class="no">OFF</div>
                                  </div>
                                </div> 
                               </div>
                            
                             
                             <input type="hidden" class="row-fluid" id="itemscope" name="admin_values[itemscope]" 
                             value="<?php echo $core_admin_values['itemscope']; ?>">
            </div>
             <div class="clearfix"></div>
        
        
        </div>
        
    </div>
    
    
    
    
    
 


 
 
 
 

    
    
    
    
    
    
    
    	<div class="box gradient">

      <div class="title">
            <div class="row-fluid"><h3> Addthis.com <a href="http://Addthis.com" target="_blank" class="label label-info pull-right" style="margin-top:8px; margin-right:8px;">More Info</a>  </h3></div>
        </div> 
        
        <div class="content">
        
        
         <div style="padding:10px; background:#fff; border:1px dashed green; font-size:11px; margin-bottom:10px;">
         AddThis is a free service we have integrated for adding social media links to your website.
         </div>
    
    
        
          
              <div class="clearfix"></div>
            
                			<div class="form-row row-fluid span11 " style="margin-top:10px;">
                            <label class="control-label span4" rel="tooltip" data-original-title="This will turn on/off the AddThis social icons features." data-placement="top">Enable</label>
                            <div class="controls span5">
                              <div class="row-fluid">                              
                                  <label class="radio off">
                                  <input type="radio" name="toggle" 
                                  value="off" onchange="document.getElementById('addthis').value='0'">
                                  </label>
                                  <label class="radio on">
                                  <input type="radio" name="toggle"
                                  value="on" onchange="document.getElementById('addthis').value='1'">
                                  </label>
                                  <div class="toggle <?php if($core_admin_values['addthis'] == '1'){  ?>on<?php } ?>">
                                    <div class="yes">ON</div>
                                    <div class="switch"></div>
                                    <div class="no">OFF</div>
                                  </div>
                                </div> 
                               </div>
                            
                             
                             <input type="hidden" class="row-fluid" id="addthis" name="admin_values[addthis]" 
                             value="<?php echo $core_admin_values['addthis']; ?>">
            </div>
             <div class="clearfix"></div>
            
                     <!------------ FIELD -------------->          
            <div class="form-row control-group row-fluid" style="margin-top:10px;">
                <label class="control-label">Username</label>
                <div class="controls">              
                  <input type="text" class="form-control" style="width:100%;"  name="admin_values[addthis_name]" value="<?php echo $core_admin_values['addthis_name']; ?>">
                       
                </div>
            </div>
            <!------------ END FIELD -------------->
    
            </div>
        
    </div>
    



</div>

</div>