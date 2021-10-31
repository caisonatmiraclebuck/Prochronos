<?php
// CHECK THE PAGE IS NOT BEING LOADED DIRECTLY
if (!defined('THEME_VERSION')) {	header('HTTP/1.0 403 Forbidden'); exit; }
// SETUP GLOBALS
global $wpdb, $CORE, $userdata, $CORE_ADMIN;
// LOAD IN MAIN DEFAULTS 
$core_admin_values = get_option("core_admin_values");  

// LOAD IN HEADER
echo $CORE_ADMIN->HEAD(); ?>







<div class="row-fluid">

<div class="span8">
 
<div class="tab-content" style="border-top:1px solid #ddd;">

<div class="accordion  style1" id="pagesetup_according">


<div class="accordion-group">
    <div class="accordion-heading" style="background:#fff;">
        <a class="accordion-toggle collapsed" data-toggle="collapse" data-parent="#pagesetup_according" href="#item1">
         <h4 style="margin:0xp;font-weight:bold;">
         <img src="<?php echo get_template_directory_uri(); ?>/framework/admin/img/icons/19.png">
         Core Theme Plugins <span style="font-size:12px;">(view/hide)</span></h4> 
        </a>
    </div>
    
    <div id="item1" class="accordion-body collapse">
    <div class="accordion-inner">
    <div class="innerwrap content">
    <?php get_template_part('framework/admin/templates/admin', 'plugins-core' ); ?>
    </div>
    </div>
    </div>
</div>

<div class="accordion-group">
    <div class="accordion-heading" style="background:#fff;">
        <a class="accordion-toggle collapsed" data-toggle="collapse" data-parent="#pagesetup_according" href="#item2">
         <h4 style="margin:0xp;font-weight:bold;">
         <img src="<?php echo get_template_directory_uri(); ?>/framework/admin/img/icons/paypal.png">
         Core Payment Gateway Plugins <span style="font-size:12px;">(view/hide)</span></h4> 
        </a>
    </div>
    
    <div id="item2" class="accordion-body collapse">
    <div class="accordion-inner">
    <div class="innerwrap content">
    <?php get_template_part('framework/admin/templates/admin', 'plugins-gateways' ); ?>
    </div>
    </div>
    </div>
</div>


<div class="accordion-group">
    <div class="accordion-heading" style="background:#fff;">
        <a class="accordion-toggle collapsed" data-toggle="collapse" data-parent="#pagesetup_according" href="#item89">
         <h4 style="margin:0xp;font-weight:bold;">
         <img src="<?php echo get_template_directory_uri(); ?>/framework/admin/img/icons/89.png">
         Popular WordPress Plugins <span style="font-size:12px;">(view/hide)</span></h4> 
        </a>
    </div>
    
    <div id="item89" class="accordion-body collapse">
    <div class="accordion-inner">
    <div class="innerwrap content">
    <?php get_template_part('framework/admin/templates/admin', 'plugins' ); ?>
    </div>
    </div>
    </div>
</div>



</div>

</div>

</div>



 
 



<div class="span4">

<div class="infobox">

    <div class="left-arrow">
    
    <div style="line-height:50px;  font-weight:bold;font-size:20px;">How does it work?</div>
    
    <p style=" font-size:16px;">Plugins are extra features you can choose to install to add-on new functionality to your website.</p>
    
    <p style=" font-size:16px;">To help keep your website running at optimal speeds only the basic features are built into the theme, you can therefore choose to add-on extra features if you wish too.</p>
      
    </div>
    
    
</div>

  
 

 
 
 

</div></div>




<?php // LOAD IN FOOTER
echo $CORE_ADMIN->FOOTER(); ?>