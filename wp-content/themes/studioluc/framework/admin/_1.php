<?php
// CHECK THE PAGE IS NOT BEING LOADED DIRECTLY
if (!defined('THEME_VERSION')) {	header('HTTP/1.0 403 Forbidden'); exit; }
// SETUP GLOBALS
global $wpdb, $CORE, $userdata, $THEME_SHORTCODES, $CORE_ADMIN;



// INCLUDE POP-UP MEDIA BOX
wp_enqueue_script('media-upload');
wp_enqueue_script('thickbox');
wp_enqueue_style('thickbox'); 

// LOAD IN OPTIONS FOR ADVANCED SEARCH
wp_enqueue_script( 'jquery-ui-sortable' );
wp_enqueue_script( 'jquery-ui-draggable' );
wp_enqueue_script( 'jquery-ui-droppable' );



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

	if(isset($_GET['delrating'])){
	
	$wpdb->query("DELETE FROM ".$wpdb->prefix."postmeta WHERE meta_key='starrating' ");
	$wpdb->query("DELETE FROM ".$wpdb->prefix."postmeta WHERE meta_key='starrating_total' ");
	$wpdb->query("DELETE FROM ".$wpdb->prefix."postmeta WHERE meta_key='starrating_votes' ");
	$wpdb->query("DELETE FROM ".$wpdb->prefix."postmeta WHERE meta_key='ratingup' ");
	$wpdb->query("DELETE FROM ".$wpdb->prefix."postmeta WHERE meta_key='ratingdown' ");
	$wpdb->query("DELETE FROM ".$wpdb->prefix."postmeta WHERE meta_key='rating_total' ");
	
	update_option('rated_user_ips','');
	$GLOBALS['error_message'] = "Rating Data Removed";
	}
	
	
	if(isset($_POST['newregfield'])){
					
		// GET EXISTING FIELDS THEN ADD-ON THE NEW ONE
		$regfields = get_option("regfields");
		if(!is_array($regfields)){ $regfields = array(); }
		// ADD ONE NEW FIELD 
		if(!isset($_POST['eid'])){
			$_POST['regfield']['ID'] = count($regfields);
			array_push($regfields, $_POST['regfield']);
			
			$GLOBALS['error_message'] = "Registration Field Added Successfully";
		}else{
			$regfields[$_POST['eid']] = $_POST['regfield'];
			
			$GLOBALS['error_message'] = "Registration Field Updated Successfully";
		}
		// SAVE ARRAY DATA		 
		update_option( "regfields", $regfields);
							
	}elseif(isset($_GET['delete_reg_field']) && is_numeric($_GET['delete_reg_field'] )){	
		// GET EXISTING FIELDS THEN ADD-ON THE NEW ONE
		$regfields = get_option("regfields");
		if(!is_array($regfields)){ $regfields = array(); }
 		
		// DELETE SELECTED VALUE
		unset($regfields[$_GET['delete_reg_field']]);	
 	
		// SAVE ARRAY DATA
		update_option( "regfields", $regfields);		
		$_POST['tab'] = "registration";
		$GLOBALS['error_message'] = "Registration Field Removed Successfully";	
 
	} 
 
}


// RESET
if(isset($_POST['admin_values']['google_coords']) && $_POST['admin_values']['google_coords'] != "0,0"){
delete_option('wlt_saved_zipcodes');
}

// SEARCH FUNCTIONALITY
$SS = new Core_Advanced_Search; 
if(isset($_POST['searchform']) && !defined('WLT_DEMOMODE') ){
$SS->save_options();
}

// LOAD IN BOOTSTRAP STYLES FOR EDITOR	
add_editor_style( FRAMREWORK_URI.'/css/css.core.css' );

// LOAD IN MAIN DEFAULTS 
$core_admin_values = get_option("core_admin_values");  

// LOAD IN LANGUAGE FILES
$wlt_languagefiles = get_option("wlt_languagefiles");
if(!is_array($wlt_languagefiles)){ $wlt_languagefiles = array(); }

// SORT TABBING
if(isset($_GET['edit_reg_field']) && is_numeric($_GET['edit_reg_field']) ){ 
$_POST['tab'] = "usersettings";
}

 

// LOAD IN HEADER
echo $CORE_ADMIN->HEAD(); ?>

<?php if(isset($_GET['firstinstall']) && !isset($_POST['adminArray']) ){ 

$link = "http://www.premiumpress.com/videos/?responsive=1&theme=".$GLOBALS['CORE_THEME']['template']."&key=".get_option('wlt_license_key')."&welcomevideo=1";

?>

<div class="alert alert-block">

<div class="row-fluid">
<div class="span7">

<h4 style="color: #c09853;font-size:20px;font-weight:bold;margin-top:20px;">New Installation - Welcome to your new website!</h4>
<p><b class="label label-warning">You will only see this once! Don't miss it!</b> </p>  
<p>Please take a few moments to watch the introductory video tutorial opposite. <br/> 
It will help you understand the admin layout, options and general work flow so you can get started as quick as possible without any unnecessary set backs.</p>

<p>Should you require any further help or support, use the 'support center' option on the top menu bar to be redirected to the theme support and information pages.</p>

<p>Thank you and good luck!</p>

<button type="submit" class="btn btn-large btn-warning"  onclick="document.getElementById('ShowTab').value='home';alert('It\'s all you now! Good luck!');">Click here to continue</button><span id="gotobtn"></span>

<p></p>
</div>
<div class="span5"><a href="<?php echo $link; ?>" target="_blank"><img src="<?php echo get_template_directory_uri(); ?>/framework/admin/img/icons/v1.jpg" /></a></div>
</div>
</div>
<input type="hidden" name="newinstall" value="premiumpress" />
<?php } ?>

<?php if( $core_admin_values['google'] == 1 && $core_admin_values['googlemap_apikey'] == "" && !isset($_GET['firstinstall']) ){ ?>

<div class="alert alert-error" style="max-width:930px; margin-top:20px; height:50px; font-size: 20px;    line-height: 30px;">
<b>Google Maps :: API Key Missing</b> 
<a href="<?php echo admin_url(); ?>/admin.php?page=1&tab=maintab3&enterkey=1" class="btn btn-danger" style="float:right;"> <b>Enter Now</b></a>
</div>

<?php } ?>

 
<ul id="tabExample1" class="nav nav-tabs">
<?php
// HOOK INTO THE ADMIN TABS
function _1_tabs(){ $STRING = ""; global $wpdb; $core_admin_values = get_option("core_admin_values");
	
	if(isset($_GET['tab'])){ $_POST['tab'] = $_GET['tab']; }
	
	$pages_array = array(  
	
	"1" => array("t" => "General Setup", 	"k"=>	"maintab1", "d" => true), 
	"2" => array("t" => "Page Setup", 		"k"=>	"maintab2", ), 
 	"3" => array("t" => "Content Setup", 	"k"=>	"maintab3", ), 
	"4" => array("t" => "Search Setup", 	"k"=>	"maintab4", ), 
	"5" => array("t" => "User Setup", 		"k" => 	"usersettings"),	
	);
 
	
	
	foreach($pages_array as $page){	
	if( ( isset($_POST['tab']) && $_POST['tab'] == $page['k']  ) || ( !isset($_POST['tab']) && $page['k'] == "maintab1" )  ){ $class = "active"; }else{ $class = ""; }	
		if(isset($_POST['tab']) && $_POST['tab'] == "" && isset($page['d']) ){ $class = "active"; }
		$STRING .= '<li class="'.$class.'"><a href="#'.$page['k'].'"  onclick="document.getElementById(\'ShowTab\').value=\''.$page['k'].'\'" data-toggle="tab">'.$page['t'].'</a></li>';		
	} 
	return $STRING;

} 

echo hook_admin_1_tabs(_1_tabs());
// END HOOK
?>                         
</ul>


<?php do_action('hook_admin_1_tab1_newsubtab'); ?>  
     
 
<div class="tab-content">

<?php do_action('hook_admin_1_content'); ?>


<div class="tab-pane fade <?php if(!isset($_POST['tab']) || ( isset($_POST['tab']) && $_POST['tab'] =="" ) || ( isset($_POST['tab']) && $_POST['tab'] == "maintab1" ) ){ echo "active in"; } ?>" id="maintab1" >

    <?php get_template_part('framework/admin/templates/admin', 'pagesetup' ); ?>

</div>

<div class="tab-pane fade <?php if(isset($_POST['tab']) && $_POST['tab'] == "maintab2"){ echo "active in"; } ?>" id="maintab2" > 

	<?php get_template_part('framework/admin/templates/admin', 'pagelayout' ); ?>

</div>

<div class="tab-pane fade <?php if(isset($_POST['tab']) && $_POST['tab'] == "maintab3"){ echo "active in"; } ?>" id="maintab3" > 

	<?php get_template_part('framework/admin/templates/admin', 'pageoptions' ); ?>

</div>

<div class="tab-pane fade <?php if(isset($_POST['tab']) && $_POST['tab'] == "usersettings"){ echo "active in"; } ?>"  id="usersettings">

<?php get_template_part('framework/admin/templates/admin', 'usersettings' ); ?>

</div>

<div class="tab-pane fade <?php if(isset($_POST['tab']) && $_POST['tab'] == "homepage"){ echo "active in"; } ?>"  id="homepage">

<?php get_template_part('framework/admin/templates/admin', 'pagelayout-home-edit' );  ?>

</div>

 

<div class="tab-pane fade <?php if(isset($_POST['tab']) && $_POST['tab'] == "maintab4"){ echo "active in"; } ?>" id="maintab4" > 

	<?php $SS->plugin_page(); ?>
    
<script>
jQuery(document).ready(function(e){var s={init:function(){var s=e("ul.asw-form-elements"),a=e("#asw-custom-template").html(),t=e("#asw-tax-template").html();searchbox=e("#asw-search-template").html(),head=e("#asw-head-template").html(),e(".asw-form-elements").sortable({handle:".hndle"}),e(".asw-form-elements").on("click",".handlediv",this.toggleElement),e(".asw-elements").on("click","#asw-search-add-btn",function(e){e.preventDefault(),s.append(searchbox).slideDown("slow")}),e(".asw-elements").on("click","#asw-head-add-btn",function(e){e.preventDefault(),s.append(head).slideDown("slow")}),e(".asw-elements").on("click","#asw-custom-add-btn",function(e){e.preventDefault(),s.append(a).slideDown("slow")}),e(".asw-elements").on("click","#asw-tax-add-btn",function(e){e.preventDefault(),s.append(t).slideDown()}),e(".asw-form-elements").on("click",".asw-remove-el",function(s){s.preventDefault(),e(this).parents("li").slideUp("slow").remove()}),e("#asw-form").on("submit",this.saveOptions),e("#asw-form").on("change",".asw-custom-type",this.toggleValues)},toggleElement:function(s){s.preventDefault();var a=e(this).parents(".postbox");a.toggleClass("closed")},saveOptions:function(){var s=e(this),a=s.serialize()+"&action=asw_save_options",t=!1;return s.find("input.required").each(function(s,a){var n=e(a).val();""===n&&(e(a).addClass("asw-error"),t=!0),""!==n&&e(a).hasClass("asw-error")&&e(a).removeClass("asw-error")}),t||(s.find("img.ajax-feedback").css("visibility","visible"),e.post(ajaxurl,a,function(a){var t=e.parseJSON(a);s.find("img.ajax-feedback").css("visibility","hidden"),t&&(e("#asw-ajax-response").html(t.nag),e("#asw-preview-content").html(t.form_preview),e(".asw-form-elements").html(t.builder))})),!1},toggleValues:function(){var s=e(this),a=s.val();"select"===a?s.parent().next(".show-if-select").slideDown("fast"):s.parent().next(".show-if-select").slideUp("fast")}};s.init()});	
</script>


</div>

  
 

<div class="form-actions row-fluid">
<div class="span7 offset5">
	<button type="submit" class="btn btn-primary">Save Changes</button> 
</div>
</div> 
 

</form> 


<script>
function AddthisShortC(code, box){		   
	jQuery('#'+box).val('['+ code +']'+jQuery('#'+box).val()); 
}
</script>

<?php if(isset($_GET['edit_reg_field']) && is_numeric($_GET['edit_reg_field']) ){ 
$regfields = get_option("regfields");
?>
<script type="text/javascript">
jQuery(document).ready(function () { jQuery('#myModal').modal('show'); })
</script>
<?php } ?>

<form method="post" name="admin_reg_field" id="admin_reg_field" action="admin.php?page=1" onsubmit="return ValidateRegFields();">
<input type="hidden" name="newregfield" value="yes" />
<input type="hidden" name="tab" value="usersettings" />
<?php if(isset($_GET['edit_reg_field'])){ ?>
<input type="hidden" name="eid" value="<?php echo $_GET['edit_reg_field']; ?>" />
<input type="hidden" name="regfield[ID]" value="<?php echo $regfields[$_GET['edit_reg_field']]['ID']; ?>" />
<?php } ?>


<script type="text/javascript"> 
function ValidateRegFields(){ 

	var cus0 	= document.getElementById("dbkey1");
	if(cus0.value == ''){
		alert('Please enter a unique database key. (lowecase, no spaces)');
		cus0.style.border = 'thin solid red';
		cus0.focus();
		return false;
	} 
 	
	return true;					
}
</script> 

<div id="myModal" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal" aria-hidden="true">x</button>
              <h3 id="myModalLabel">Registration Field</h3>
            </div>
            <div class="modal-body" style="min-height:350px;">
              
               
           <div class="form-row control-group row-fluid">
                <label class="control-label span3" for="normal-field"><b>Display Caption</b></label>
                <div class="controls span7">
                  <input type="text"  name="regfield[name]" class="row-fluid" value="<?php if(isset($_GET['edit_reg_field'])){ echo $regfields[$_GET['edit_reg_field']]['name']; }?>">
                   
                </div>
              </div>
           

            
            
           <div class="form-row control-group row-fluid">
                <label class="control-label span3" for="normal-field">Field Type</label>
                <div class="controls span7">
                  <select name="regfield[fieldtype]" id="reg_new_1" class="chzn-select" onchange="showhideextrafield(this.value)">
                  
                    <option value="input" <?php if(isset($_GET['edit_reg_field'])){ if($regfields[$_GET['edit_reg_field']]['fieldtype'] == "input"){echo "selected=selected"; } }?>>Input Field</option>
                    <option value="textarea" <?php if(isset($_GET['edit_reg_field'])){ if($regfields[$_GET['edit_reg_field']]['fieldtype'] == "textarea"){echo "selected=selected"; } }?>>Text Area</option>
                    <option value="checkbox" <?php if(isset($_GET['edit_reg_field'])){ if($regfields[$_GET['edit_reg_field']]['fieldtype'] == "checkbox"){echo "selected=selected"; } }?>>Checkbox</option>
                    <option value="radio" <?php if(isset($_GET['edit_reg_field'])){ if($regfields[$_GET['edit_reg_field']]['fieldtype'] == "radio"){echo "selected=selected"; } }?>>Radio Button</option> 
                    <option value="select" <?php if(isset($_GET['edit_reg_field'])){ if($regfields[$_GET['edit_reg_field']]['fieldtype'] == "select"){echo "selected=selected"; } }?>>Selection Box</option>                                          
                    </select>
     
                </div>
            </div>
            
            <script>
			
			function showhideextrafield(val){
				if(val == "checkbox" || val =="radio" || val =="select" ){
				jQuery('#extrafieldvalues').show();
				} else {
				jQuery('#extrafieldvalues').hide();
				}			
			}
			 
			</script>
            
            
           <div class="form-row control-group row-fluid" id="extrafieldvalues" 
		   <?php if(isset($_GET['edit_reg_field'])){ if($regfields[$_GET['edit_reg_field']]['fieldtype'] == "select" || $regfields[$_GET['edit_reg_field']]['fieldtype'] == "radio" || $regfields[$_GET['edit_reg_field']]['fieldtype'] == "checkbox"){ }else{ echo 'style="display:none;"'; } }else{ echo 'style="display:none;"'; } ?>>
                <label class="control-label span3" for="normal-field">Field Values</label>
                <div class="controls span7">
                   
                 <textarea class="row-fluid"  name="regfield[values]" placeholder="One value per line" style="border:1px solid orange;height:100px;"><?php if(isset($_GET['edit_reg_field'])){ echo $regfields[$_GET['edit_reg_field']]['values']; }?></textarea>
                   
                </div>
              </div>

          <div class="form-row control-group row-fluid">
                <label class="control-label span3" for="normal-field">Database Key <small>(lowecase, no spaces)</small></label>
                <div class="controls span7">
                  <input type="text" name="regfield[key]" class="row-fluid" id="dbkey1" value="<?php if(isset($_GET['edit_reg_field'])){ echo $regfields[$_GET['edit_reg_field']]['key']; }?>">
                </div>
            </div> 
           
             
            
           <div class="form-row control-group row-fluid">
                <label class="control-label span3" for="normal-field">Display Order</label>
                <div class="controls span7">
                
                <div class="span3" style="margin-left: 0px;">
                  <input type="text" name="regfield[order]" class="row-fluid" style="width:50px;" value="<?php if(isset($_GET['edit_reg_field'])){ echo $regfields[$_GET['edit_reg_field']]['order']; }?>">
                 </div> 
                 <div class="span7">
                 Required? 
                 <select name="regfield[required]"  style="width:100px;">
                    <option value="yes" <?php if(isset($_GET['edit_reg_field'])){ if($regfields[$_GET['edit_reg_field']]['required'] == "yes"){echo "selected=selected"; } }?>>yes</option>
                    <option value="no" <?php if(isset($_GET['edit_reg_field'])){ if($regfields[$_GET['edit_reg_field']]['required'] == "no"){echo "selected=selected"; } }?>>no</option>                   </select>
                 </div>
                    
                </div>
            </div> 
                        
            
           <div class="form-row control-group row-fluid">
                <label class="control-label span3" for="normal-field">User Can Edit?</label>
                <div class="controls span7">
                  <select name="regfield[display_profile]" id="reg_new_2" class="chzn-select">
               
                   <option value="yes" <?php if(isset($_GET['edit_reg_field'])){ if($regfields[$_GET['edit_reg_field']]['display_profile'] == "yes"){echo "selected=selected"; } }?>>yes</option>
                    <option value="no" <?php if(isset($_GET['edit_reg_field'])){ if($regfields[$_GET['edit_reg_field']]['display_profile'] == "no"){echo "selected=selected"; } }?>>no</option>                      
                    </select>
     
                </div>
                <div class="clearfix"></div>
                <small style="padding-left:130px;">Allow user to edit this on their 'my account' screen.</small>
            </div> 
           
              
            </div>
            
            <div class="modal-footer">
              <button class="btn" data-dismiss="modal">Close</button>
              <button class="btn btn-primary">Save changes</button>
            </div>
</div>

</form>
 
<?php // LOAD IN FOOTER
echo $CORE_ADMIN->FOOTER(); ?>