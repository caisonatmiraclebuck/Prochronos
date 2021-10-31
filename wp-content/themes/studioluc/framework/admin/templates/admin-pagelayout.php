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

// CHECK IF HOME PAGE IS SET
$HOMEPAGESET = $CORE->PAGEEXISTS('homepage');
 
// GET THE DEFAULT HOME PAGE OPTIONS
$homepageID = get_option('show_on_front');

// LOAD IN MAIN DEFAULTS 
$core_admin_values = get_option("core_admin_values");  

// TEMPLATE CHOICE
$selected_template = $core_admin_values['template']; 

$HandlePath = TEMPLATEPATH . '/templates/';
	    $count=1; $TemplateString = "";
		if($handle1 = opendir($HandlePath)) {      
			while(false !== ($file = readdir($handle1))){			
				if(strpos($file,".") ===false && ( strpos($file,strtolower('template')) !== false  ) ){	
			 					
					$TemplateString .= "<option "; 
					if ($selected_template == $file) { $TemplateString .= ' selected="selected"'; }   
					$TemplateString .= 'value="'.$file.'">'; 					
					$TemplateString .= str_replace("basic","[CHILD]",str_replace("_"," ",str_replace("-"," ",str_replace(strtolower('template'),"",$file)))); 										
					$TemplateString .= "</option>";			
   
				}
			}
			
		}


  
?>
 
<div class="row-fluid">

<div class="span8">


<?php if(defined('ADMIN_HIDE_HOMEPAGE')){ ?>

<div class="alert alert-error fade in">

<img src="<?php echo get_template_directory_uri(); ?>/framework/admin/img/icons/cross.png" width="60px" style="float:right;" />   

<p><b style="font-size:20px;">Child Theme Homepage Detected</b></p>

<p>Your child theme has its own _homepage.php file and therefore the core theme functions are disabled. </p>
<p> If you wish to use the core theme homepage functionality, please delete the _homepage.php file from your child theme.</p>
</div>

<hr />
<?php } ?> 

<!-- START ACCORDING --->
<div class="accordion style1" id="pagelayout_according">

<div class="accordion-group">
    <div class="accordion-heading" style="background:#fff;">
    
  
    

<a href="<?php if($homepageID == "posts"){ ?>javascript:void(0);<?php }else{ ?>post.php?post=<?php echo get_option('page_on_front'); ?>&action=edit<?php } ?>" style="float:right;margin-top:20px; margin-right:10px;" class="btn btn-default btn-success" id="edithome">Edit Page Content</a>
 
   
    
    
        <a class="accordion-toggle collapsed" data-toggle="collapse" data-parent="#pagelayout_according" href="#layout0">
         <h4 style="margin:0xp;font-weight:bold;">
         <img src="<?php echo get_template_directory_uri(); ?>/framework/admin/img/icons/8.png">
         Home Page <span style="font-size:12px;">(view/hide)</span></h4> 
        </a>
    </div>
    
    <div id="layout0" class="accordion-body collapse <?php if(isset($_GET['showme']) && $_GET['showme'] == "home"){ echo "in"; }?>">
    <div class="accordion-inner">
    <div class="innerwrap">
    <?php  get_template_part('framework/admin/templates/admin', 'pagelayout-home' ); ?>
    </div>
    </div>
    </div>
</div>


<div class="accordion-group">
    <div class="accordion-heading" style="background:#fff;">
    
    
        <a class="accordion-toggle collapsed" data-toggle="collapse" data-parent="#pagelayout_according" href="#layout1">
         <h4 style="margin:0xp;font-weight:bold;">
         <img src="<?php echo get_template_directory_uri(); ?>/framework/admin/img/icons/9.png">
         Search Page <span style="font-size:12px;">(view/hide)</span></h4> 
        </a>
    </div>
    
    <div id="layout1" class="accordion-body collapse <?php if(isset($_GET['showme']) && $_GET['showme'] == "search"){ echo "in"; }?>">
    <div class="accordion-inner">
    <div class="innerwrap content">
    <?php get_template_part('framework/admin/templates/admin', 'pagelayout-search' ); ?>
    </div>
    </div>
    </div>
</div>

<div class="accordion-group">
    <div class="accordion-heading" style="background:#fff;">
        <a class="accordion-toggle collapsed" data-toggle="collapse" data-parent="#pagelayout_according" href="#layout2">
         <h4 style="margin:0xp;font-weight:bold;">
         <img src="<?php echo get_template_directory_uri(); ?>/framework/admin/img/icons/10.png">
         Listing Page <span style="font-size:12px;">(view/hide)</span></h4> 
        </a>
    </div>
    
    <div id="layout2" class="accordion-body collapse <?php if(isset($_GET['showme']) && $_GET['showme'] == "listing"){ echo "in"; }?>">
    <div class="accordion-inner">
    <div class="innerwrap content">
    <?php  get_template_part('framework/admin/templates/admin', 'pagelayout-listing' ); ?>
    </div>
    </div>
    </div>
</div>

<div class="accordion-group">
    <div class="accordion-heading" style="background:#fff;">
        <a class="accordion-toggle collapsed" data-toggle="collapse" data-parent="#pagelayout_according" href="#layout3">
         <h4 style="margin:0xp;font-weight:bold;">
         <img src="<?php echo get_template_directory_uri(); ?>/framework/admin/img/icons/11.png">
         Normal Pages <span style="font-size:12px;">(view/hide)</span></h4> 
        </a>
    </div>
    
    <div id="layout3" class="accordion-body collapse <?php if(isset($_GET['showme']) && $_GET['showme'] == "page"){ echo "in"; }?>">
    <div class="accordion-inner">
    <div class="innerwrap content">
    <?php  get_template_part('framework/admin/templates/admin', 'pagelayout-page' ); ?>
    </div>
    </div>
    </div>
</div>


<div class="accordion-group">
    <div class="accordion-heading" style="background:#fff;">
        <a class="accordion-toggle collapsed" data-toggle="collapse" data-parent="#pagelayout_according" href="#layout5">
         <h4 style="margin:0xp;font-weight:bold;">
         <img src="<?php echo get_template_directory_uri(); ?>/framework/admin/img/icons/12.png">
         Print Page <span style="font-size:12px;">(view/hide)</span></h4> 
        </a>
    </div>
    
    <div id="layout5" class="accordion-body collapse <?php if(isset($_GET['showme']) && $_GET['showme'] == "print"){ echo "in"; }?>">
    <div class="accordion-inner">
    <div class="innerwrap content">
    <?php  get_template_part('framework/admin/templates/admin', 'pagelayout-print' ); ?>
    </div>
    </div>
    </div>
</div>

<div class="accordion-group">
    <div class="accordion-heading" style="background:#fff;">
        <a class="accordion-toggle collapsed" data-toggle="collapse" data-parent="#pagelayout_according" href="#layout4">
         <h4 style="margin:0xp;font-weight:bold;">
         <img src="<?php echo get_template_directory_uri(); ?>/framework/admin/img/icons/13.png">
         Misc <span style="font-size:12px;">(view/hide)</span></h4> 
        </a>
    </div>
    
    <div id="layout4" class="accordion-body collapse">
    <div class="accordion-inner">
    <div class="innerwrap">
    <?php  get_template_part('framework/admin/templates/admin', 'pagelayout-misc' ); ?>
    </div>
    </div>
    </div>
</div>


</div>



<script type="text/javascript">

	jQuery("#edithome").click(function() {
   
		tb_show('', 'admin.php?page=1&tab=homepage&nolayoutbody=1&amp;TB_iframe=true');
		return false;
	});
                 
</script>  

 



</div>

<div class="span4">

 <a data-toggle="modal" href="#VideoModelBox" class="btn btn-warning youtube" onclick="PlayPPTVideo('U-qYp90Scfw','videoboxplayer','479','350');" style="width:100%; margin-bottom:10px; ">Watch Video Tutorial</a>


<?php if($HOMEPAGESET){ ?>

<div style="padding:10px; background:#fff; border:1px dashed green; font-size:11px; margin-bottom:10px;">
<b>Note</b> Your child theme has it's own homepage file therefore these options may not function correctly.
</div>
<?php } ?>



 

<div class="box gradient">

      <div class="title">
            <div class="row-fluid"><h3><i class="gicon-folder-open"></i>Current Design</h3></div>
        </div> 
        
        <div class="content"> 
        
<?php if(defined('CHILD_THEME_NAME')){ ?>
<img src="<?php echo CHILD_THEME_PATH_URL; ?>/screenshot.png" />
 <input type="hidden" name="admin_values[template]" value="<?php echo $core_admin_values['template']; ?>" />
<?php }else{ ?>
       
        
<!-- WEBSITE SCREENSHOT // PREVIEW -->          
<script type="text/javascript">
jQuery(document).ready(function() { 
   jQuery("#themepreview").change(function() {
     jQuery("#imagePreview").empty();
	 if(jQuery("#themepreview").val() != ""){
	 jQuery('#previewbox').show();
        jQuery("#imagePreview").append("<img src=\"<?php echo get_template_directory_uri(); ?>/templates/" + jQuery("#themepreview").val()  + "/screenshot.png\" />");	
	} else {
		jQuery('#previewbox').hide();
	}
   });   
 }); 
</script>   

<div id="imagePreview" style="margin-bottom:5px; border:2px solid #ddd;"><?php if($core_admin_values['template'] != ""){ ?><img src="<?php echo get_template_directory_uri(); ?>/templates/<?php echo $core_admin_values['template']; ?>/screenshot.png" /><?php } ?></div>

 
<select name="admin_values[template]" style="width:100%;" id="themepreview">
        <option value="">None</option>
        <?php echo $TemplateString; ?>
</select>

<input type="hidden" name="current_template_save" value="<?php echo $selected_template; ?>" />
      
<?php } ?>
 


        </div>
        
</div>













 

</div>

</div>



 