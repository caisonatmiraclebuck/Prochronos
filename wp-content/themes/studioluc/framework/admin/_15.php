<?php
// CHECK THE PAGE IS NOT BEING LOADED DIRECTLY
if (!defined('THEME_VERSION')) {	header('HTTP/1.0 403 Forbidden'); exit; }
// SETUP GLOBALS
global $wpdb, $CORE, $userdata, $CORE_ADMIN;
// LOAD IN MAIN DEFAULTS 
$core_admin_values = get_option("core_admin_values");  

if(!defined('WLT_DEMOMODE') && current_user_can('administrator')){

if(isset($_POST['page_on_front'])){
	if($_POST['page_on_front'] == 1){
				update_option( 'show_on_front', 'posts' );
				update_option( 'page_on_front', $_POST['page_on_front'] );
			}else{
				update_option( 'show_on_front', 'page' );
				update_option( 'page_on_front', $_POST['page_on_front'] );
			}			
}

}
 
// LOAD IN HEADER
echo $CORE_ADMIN->HEAD(); ?>


<div class="alert alert-block">

<div class="row-fluid">
<div class="span7">

<h4 style="color: #c09853;font-size:30px;font-weight:bold;margin-top:10px;">Design Tools &amp; Quick Links</h4>
 
<p style="font-size:16px; margin-bottom:20px;">Here you'll find useful links and tools to help you get started customizing your PremiumPress theme.</p>

 
 
<a href="admin.php?page=customizeme" class="btn btn-large btn-warning">Customize Colors</a> or  <a href="theme-install.php?browse=premiumpress" class="btn btn-large btn-warning">Browse Child Themes</a>

<div class="clearfix"></div>

<div style="margin-top:10px; font-size:11px; ">
<a href="admin.php?page=4&amp;task=resetcustomizer&amp;TB_iframe=true&amp;width=640&amp;height=100" class="alertme" style="text-decoration:underline;" >Reset Colors &amp; Modifications</a> 
</div>
<script type="text/javascript" language="javascript">
jQuery(window).load(function(){
jQuery('.alertme').click(function(e)
{
    if(confirm("Are you sure?"))
    {
       
	
    }
    else
    {
 
        e.preventDefault();
    }
});
});
</script> 


<?php if(!defined('CHILD_THEME_NAME') && strlen($GLOBALS['CORE_THEME']['template']) > 1){

if(!isset($core_admin_values['colorstyle_file'])){ $core_admin_values['colorstyle_file'] = ""; }
 ?>
 
<div class="heading2" style="margin-top:20px;">Available Color Schemes</div>

<input type="hidden" name="admin_values[colorstyle_file]" id="colorstyle_file" value="<?php echo $core_admin_values['colorstyle_file']; ?>">
<div class="row-fluid">
<div class="span12 " >   
    
 <div style="background:#fff; 
 <?php if($core_admin_values['colorstyle_file'] == ""){ ?>border: 2px solid black;<?php }else{ ?>border: 1px solid #DACE91;<?php } ?> 
 padding: 1px; 
 margin-right:15px;
 cursor:pointer;
  margin-bottom:0px; 
  float:left;
  width:45px; 
  height:45px;
  line-height: 40px;
  text-align: center;
  margin-bottom:10px;
  color: #000;
 font-size:11px; " 
   class="img-circle" onclick="document.getElementById('colorstyle_file').value='';document.admin_save_form.submit();">none</div>
   
<?php 

$colorarrays = array('blue' => "278fce",'yellow' => 'f4d925','pink' => 'e94d81','green' => '87c623','purple' => '9546b1','red' => 'c20307','grey' => '444444' );

foreach($colorarrays as $cc => $ddd){ ?>
 <div style="
 background:#<?php echo $ddd; ?>; 
 <?php if($core_admin_values['colorstyle_file'] == $cc){ ?>border: 2px solid black;<?php }else{ ?>border: 1px solid #DACE91;<?php } ?> 
 padding: 1px; 
 margin-right:12px;
 cursor:pointer;
  margin-bottom:0px; 
  float:left;
  width:45px; 
  height:45px;
  line-height: 50px;
  margin-bottom:10px;
  text-align: center;
  color: #000;" 
  class="img-circle" onclick="document.getElementById('colorstyle_file').value='<?php echo $cc; ?>';document.admin_save_form.submit();">&nbsp;</div>
<?php } ?>
</div>
<div class="clearfix"></div>

  
</div>

 
<?php } ?>


<p></p>
</div>
<div class="span5">

 

<?php if(defined('CHILD_THEME_NAME')){ ?>
<img src="<?php echo CHILD_THEME_PATH_URL; ?>/screenshot.png" />
 
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

<?php } ?>

</div>
</div>
</div>


 

 

<div style="background:#E0E0E0;padding:10px;color: #A0A0A0;    font-weight: bold;">


<a data-toggle="modal" href="#VideoModelBox" class="btn btn-warning youtube" onclick="PlayPPTVideo('44qmjx6TDBI','videoboxplayer','479','350');" style="float:right; margin-right:5px; margin-top:-5px;">Watch Video Tutorial</a>


Quick links to page settings 
</div>
<div style="padding:20px; background:#efefef;">

<style>

.haa { text-align:center;  padding:2px; }
.haa .heading { font-size:20px; margin-bottom:10px; margin-top:10px; }
.haa .bo { padding:10px; }
.chzn-single { font-size:12px; }
</style>

 
<div class="box gradient span3 haa" style="margin-left:<?php if(!defined('WLT_PAGE_BUILDER') ){  ?>230px; <?php }else{ ?>330px<?php } ?> ">
 
   
    <div class="heading">Home Page</div>
    <div class="desc">your front page design</div>
    
    <?php $homepageID = get_option('show_on_front'); ?>
    <div class="bo">
    <a href="<?php if($homepageID == "posts"){ ?>javascript:void(0);<?php }else{ ?>post.php?post=<?php echo get_option('page_on_front'); ?>&action=edit<?php } ?>" class="btn btn-success" id="edithome">Customize</a> | <a href="admin.php?page=1&tab=maintab2&showme=home" class="btn btn-info">Settings</a>
    
    <hr />
     
    
    <div style="text-align:left;margin-top:-15px;">
    <small>Select Homepage;</small>
     <?php wp_dropdown_pages( array( 'name' => 'page_on_front', 'echo' => 1,  "class" => "chzn-select input-sm", 'show_option_none' => __( 'Use Theme Default Layout' ), 'option_none_value' => '1', 'selected' => get_option( 'page_on_front' ) ) ); ?> 
    </div>
     
    
    </div>
 
 
<script type="text/javascript">

	jQuery("#edithome").click(function() {
   
		tb_show('', 'admin.php?page=1&tab=homepage&nolayoutbody=1&amp;TB_iframe=true');
		return false;
	});
	
jQuery( "#page_on_front" ).change(function() {
 
	jQuery("#admin_save_form").submit();
});
                 
</script>    
    
</div>

<?php if(!defined('WLT_PAGE_BUILDER') ){  ?>

<div class="box gradient span3 haa" style="border: 1px dashed #ddd;  background: #F4FFF9; padding:10px; color: #0F9E50;">
 
   <div style="font-size:16px;font-weight:bold;">Design It Yourself!</div>
    <div class="desc">You can design your own home page layout and content pages using the new PremiumPress <a href="admin.php?page=10" style="color:green; text-decoration:underline;">page designer plugin.</a></div>
  
</div>
<?php } ?>




 


<div class="clearfix"></div>


 

 
<div class="row-fluid" style="margin-top:20px;">

<div class="box gradient span3 haa" style="margin-left:120px;"  >
 
    <div class="heading">Normal Page</div>
	
    <div class="desc">standard WordPress page</div>
 
 
    <div class="bo">
     <a href="admin.php?page=1&tab=maintab2&showme=page" class="btn btn-info">Settings</a>
    </div>

</div>


<div class="box gradient span3 haa" >
 
    <div class="heading">Search Page</div>
    
    <div class="desc">displaying search results</div>
 
    <div class="bo">
     <a href="admin.php?page=1&tab=maintab2&showme=search" class="btn btn-info">Settings</a>
    </div>

</div>



<div class="box gradient span3 haa" >
 
    <div class="heading">Listing Page</div>
    
    <div class="desc">single listing page</div>
 
    <div class="bo">
     <a href="admin.php?page=1&tab=maintab2&showme=listing" class="btn btn-info">Settings</a>
    </div>

</div>

 
</div>



<?php if(!defined('WLT_CART')){ ?>
<div class="row-fluid" style="margin-top:20px;">

<div class="box gradient span3 haa" style="margin-left:320px;"  >
 
    <div class="heading">Add Listing</div>
    
    <div class="desc">user submission form</div>
    
 
    <div class="bo">
     <a href="admin.php?page=5" class="btn btn-info">Settings</a>
    </div>

</div>
 
 
 
</div>


<hr />
<?php } ?>



<div class="row-fluid" style="margin-top:20px;">

<div class="box gradient span3 haa" style="margin-left:220px;"  >
 
    <div class="heading">My Account</div>
    
    <div class="desc">user account area</div>
 
    <div class="bo">
     <a href="admin.php?page=1&tab=usersettings&showme=user" class="btn btn-info">Settings</a>
    </div>

</div>

 
<div class="box gradient span3 haa" >
 
    <div class="heading">User Profile</div>
    
    <div class="desc">WordPress author page</div>
 
    <div class="bo">
     <a href="admin.php?page=1&tab=usersettings&showme=userp" class="btn btn-info">Settings</a>
    </div>

</div>

 
 
</div>




 






<hr />




<div class="row-fluid" style="margin-top:20px;">

<div class="box gradient span3 haa" style="margin-left:220px;"  >
 
    <div class="heading">User Register</div>
    
    <div class="desc">WordPress register page</div>
    
 
    <div class="bo">
     <a href="admin.php?page=1&tab=usersettings" class="btn btn-info">Settings</a>
    </div>

</div>


<div class="box gradient span3 haa" >
 
    <div class="heading">User Login</div>
    
    <div class="desc">WordPress login page</div>
    
 
    <div class="bo">
     <a href="admin.php?page=1&tab=usersettings" class="btn btn-info">Settings</a>
    </div>

</div>

 
 
</div>




<?php if(isset($GLOBALS['CORE_THEME']['homeeditor']) && strlen($GLOBALS['CORE_THEME']['homepage']['widgetblock1']) > 1 ){ ?>
    
<div class="box gradient content haa" style="border: 1px dashed #F58437;
    background: #FFF1E8;
    padding: 10px;
    color: #0C0C0C;
    text-align: left;">
 
<img src="<?php echo get_bloginfo('template_url'); ?>/framework/admin/img/gateways/4.png" style="float:left; width:150px;margin-right:20px; margin-bottom: 80px;" />

<h2>Homepage Editor Discontinued</h2>
 

<p style="font-size: 18px;">The  homepage editor from earlier versions of PremiumPress themes has been discontinued in favor of the new homepage builder plugin.</p>

<p> We strongly recommend you create a new homepage using the new homepage builder plugin and swap your homepage before the next update. Turn off the option below once you've created a new homepage.</p> 
    
  
</div>

<?php } ?>


</div>

    
<?php // LOAD IN FOOTER
echo $CORE_ADMIN->FOOTER(); ?>