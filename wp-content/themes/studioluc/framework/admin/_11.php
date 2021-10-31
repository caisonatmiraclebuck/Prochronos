<?php
// CHECK THE PAGE IS NOT BEING LOADED DIRECTLY
if (!defined('THEME_VERSION')) {	header('HTTP/1.0 403 Forbidden'); exit; }
// SETUP GLOBALS
global $wpdb, $CORE, $OBJECTS, $userdata, $CORE_ADMIN;
// LOAD IN MAIN DEFAULTS 
$core_admin_values = get_option("core_admin_values");  

// ADMIN ITEM HOOKS FOR OBJECT CLASS
add_action('hook_object_list', array($OBJECTS,'DEFAULT_WIDGETBLOCKS_LIST'));	
add_action('hook_object_settings', array($OBJECTS,'DEFAULT_WIDGETBLOCKS_SETTINGS'));

// INCLUDE POP-UP MEDIA BOX
wp_enqueue_script('media-upload');
wp_enqueue_script('thickbox');
wp_enqueue_style('thickbox'); 

// LOAD IN OPTIONS FOR ADVANCED SEARCH
wp_enqueue_script( 'jquery-ui-sortable' );
wp_enqueue_script( 'jquery-ui-draggable' );
wp_enqueue_script( 'jquery-ui-droppable' );


// LOAD IN BOOTSTRAP STYLES FOR EDITOR	
add_editor_style( FRAMREWORK_URI.'/css/css.core.css' );

// LOAD IN HEADER
echo $CORE_ADMIN->HEAD(); ?>

<ul id="tabExample1" class="nav nav-tabs">
 
                     
</ul>

<div class="tab-content">

 

<?php do_action('hook_object_settings'); ?>





<div class="btn-success" style="padding: 10px;    font-weight: bold;">




<a data-toggle="modal" href="#VideoModelBox" class="btn btn-warning youtube" onclick="PlayPPTVideo('yP3e5krJIW8','videoboxplayer','479','350');" style="float:right; margin-right:5px; margin-top:-5px;">Watch Video</a>

Home Page Editor</div>

<div class="content" style="    padding: 10px;    background: #ECF5E2;">
    <div class="form-row control-group row-fluid ">
                            <label class="control-label span9">
                            <b>Show old home page design</b>
                            
                            
                            <p>This tool has been discontinued in favor of the new page builder plugin.</p>
                            
                            </label>
                            <div class="controls span2">
                              <div class="row-fluid">
                                <div class="pull-left"> 
                                  <label class="radio off">
                                  <input type="radio" name="toggle" 
                                  value="off" onchange="document.getElementById('homeeditor').value='0'">
                                  </label>
                                  <label class="radio on">
                                  <input type="radio" name="toggle"
                                  value="on" onchange="document.getElementById('homeeditor').value='1'">
                                  </label>
                                  <div class="toggle <?php if($core_admin_values['homeeditor'] == '1'){  ?>on<?php } ?>">
                                    <div class="yes">ON</div>
                                    <div class="switch"></div>
                                    <div class="no">OFF</div>
                                  </div>
                                </div> 
                               </div>  
                             </div>
                             
                             <input type="hidden" class="row-fluid" id="homeeditor" name="admin_values[homeeditor]" value="<?php echo $core_admin_values['homeeditor']; ?>">
            </div> 
</div>

<div style="border:1px solid #ddd; padding:20px; background:#fff;">


 


<div class="row-fluid">
 
<div class="span7"> 
<style>

.accordion-heading { border-color: #dddddd;  
 background: #f7f7f7;
border: 1px solid transparent;
border-radius: 4px;
-webkit-box-shadow: 0 1px 1px rgba(0, 0, 0, 0.05);
box-shadow: 0 1px 1px rgba(0, 0, 0, 0.05); }

.accordion-heading a { color:#269ccb; font-weight:bold; }
   
.collapse.in {
height: auto;
overflow:visible !important;
}

 
</style>  


<!-- WIDGET LIST BOX -->
<div  id="wlt_widget_list">

<?php 

$object_listtypes = hook_object_listtypes(
array(

//'section' => array("n" => "Section Blocks"),


'slider' => array("n" => "Sliders"),

'head' => array("n" => "Top Elements"),

'content' => array("n" => "Content Elements"),

'text' => array("n" => "Text Blocks"),

'cols2' => array("n" => "2 Column Text Blocks"),

'cols3' => array("n" => "3 Column Text Blocks"),

'cols4' => array("n" => "4 Column Text Blocks"),

'search' => array("n" => "Search Blocks"),

'footer' => array("n" => "Bottom Elements"),

'image' => array("n" => "Image Placement Blocks"),

'' => array("n" => "Everything Else"),



));
$object_items = hook_object_list(array()); 
 

foreach($object_listtypes as $tk => $type){ ?>


  <div class="accordion-group">
    <div class="accordion-heading">
      <a class="accordion-toggle" data-toggle="collapse" data-parent="#wlt_widget_list" href="#collapse<?php echo $tk; ?>">
      <img src="<?php echo get_template_directory_uri(); ?>/framework/img/a3.png" style="float:right;margin-top:3px;">
        <?php echo $type['n']; ?>
      </a>
    </div>
    <div id="collapse<?php echo $tk; ?>" class="accordion-body collapse">
      <div class="accordion-inner">
      <ul>
      <?php
 
	foreach($object_items as $item){
	
	// ADD IN SLIDER
	if($tk == "slider" && !isset($REVSERT) ){ 
		$REVSERT = true;
		if(isset($GLOBALS['WLT_REVSLIDER'])  ){ 	
		
		}else{	
		
		echo '<li class="external-event1 span6" style="background:#fff; border:1px dashed #666;">
	
		<a href="'.home_url().'/wp-admin/plugin-install.php?tab=plugin-information&plugin=wlt_revslider&TB_iframe=true&width=640&height=799" target="_blank"> <span class="title">Revolution Slider</span> <span class="desc">Download this plugin here.</span></a> 
		
		</li> ';
		
		}
	}// END SLIDER
	
	
	
	
	if(isset($item['type']) && $item['type'] !=  $tk){ continue; } 
	 	 
		if(strpos($item['icon'],"http") !== false){ 
		$iig = $item['icon'];
		}else{
		$iig = FRAMREWORK_URI."/admin/img/core/preview/".$item['icon'];
		}
		echo "<li id='".$item['id']."' class='external-event1 span6'> 
		<img src='".$iig."' class='previewobject'>
		<a href=\"javascript:void(0);\" onclick=\"AddObj('".$item['id']."', '".$item['name']."');\">  <span class='title'>".$item['name']."</span> <span class='desc'>".$item['desc']."</span> </a>
		</li>"; 
	 
	} 
	
	
	?>
    </ul>
    <div class="clearfix"></div>
    
     </div>
    </div>
  </div>
    <?php
	
}
?>
 

</ul><div class="clearfix"></div>
</div> 
<!-- END WIDGET LIST BOX -->
</div>
 
<div class="span5">

<?php
function getObjectName($object_items, $key ){
	foreach($object_items as $obj){
		if($obj['id'] == $key){ return $obj['name']; }
	}
}
// CALCULATE THE DEFAULT ITEMS WITHIN EACH ARRAY
$block1 	= explode(",",$core_admin_values['homepage']['widgetblock1']);
 
$blockdata 	= $core_admin_values['widgetobject'];
$EXPORTSTRING = "";
$block1_string = "";
$block1_string_formatted = ""; 
$v=1; 

if(isset($block1[0]) && strlen($block1[0]) > 1){ 
foreach($block1 as $key => $it){
	
	// BREAK UP THE STRING				
	$ff 		= explode("_",$it);						
	$gg 		= explode("-", $ff[1]);
	$nkey		= $ff[0];
	$nrefid 	= $gg[0];
	$nvalue 	= $gg[1];
	
	// CHECK IF ITS INLINE OR FULL WITH
	$kk = $blockdata[$nkey][$nrefid]['fullw'];
	if($kk == "yes"){ 
	$fwt = "<i class='gicon-align-justify' rel='tooltip' data-original-title='Full Width' data-placement='top'></i>"; 
	}elseif($kk == "no"){ 
	$fwt = "<i class='gicon-indent-left' rel='tooltip' data-original-title='Inline' data-placement='top'></i>"; 	
	}elseif($kk == "underheader"){ 
	$fwt = "<i class='gicon-fullscreen' rel='tooltip' data-original-title='Under Header' data-placement='top'></i>"; 	
	
	
	}else{ 
	$fwt = "<i class='gicon-flag' rel='tooltip' data-original-title='Object Not Setup' data-placement='top'></i>";   
	}
	// MAKE SURE THE OBJECT IS VALID BY CHECKING ITS NAME
	$objectName = getObjectName($object_items,$nkey);

	if($objectName != ""){ 
	
	$block1_string .= "<li id='".$nkey."_".$nrefid."' class='external-event widget objid".$nkey.$v."'><a href=\"javascript:void(0);\" onclick=\"objRemoveMe('".$nkey."_".$nrefid."');jQuery('.objid".$nkey.$v."').hide();\" class='removesobg'>&nbsp;&nbsp;</a>".$fwt."
	<a href=\"JavaScript:void(0);\" onclick=\"jQuery('#ObjOptions_".$nrefid."').show();\"><span class='settingsobg'>&nbsp;&nbsp;</span></a>".$objectName."</li>"; 
	
	// FORMAT FOR SAVING
	$block1_string_formatted .= $nkey."_".$nrefid.","; 
	
	
		
	
	}// end if
	$v++;
}// end foreach
}

$block1_string_formatted = rtrim(preg_replace("/[^[:space:]a-zA-Z0-9-,_-]/e", "",$block1_string_formatted));
 
?>         
<div class="row-fluid">          
<img src="<?php echo get_template_directory_uri(); ?>/framework/admin/img/core/mm.png" />                    
<ul id="dragable_col1" class=" span12" style="min-height:300px; border:1px solid #ddd;margin-left:0px;padding:20px;margin-bottom:20px;background:#F7F7F7;"><?php echo $block1_string; ?></ul>  
</div>

<p><i class='gicon-flag'></i> Objects Not Setup<br />
<i class='gicon-indent-left'></i> Inline <br />
<i class='gicon-align-justify'></i> Full Width  <br />
<i class='gicon-fullscreen'></i> Under Header
</p> 



 
</div>
 
</div>

<hr />
<p><label class="label label-warning">Remember</label> Full width objects will always appear above inline content on your home page. <label class="label label-info">Info</label> For all HTML codes visit the <a href="http://getbootstrap.com/" target="_blank" style="text-decoration:underline;">bootstrap website.</a></p>

 
<textarea style="display:none;" name="admin_values[homepage][widgetblock1]" type="hidden" id="dragable_col1_hidden" /><?php echo $block1_string_formatted; ?></textarea> 
<input name="widgetblock1_backup" type="hidden" id="widgetblock1_backup" value="<?php echo $block1_string_formatted; ?>" /> 
<input name="widgetobject11" id="widgetobject11" type="hidden" value="" /> 
<input name="adminArray[wlt_objectscounter]" id="wlt_objectscounter" type="hidden" value="<?php $cc = get_option('wlt_objectscounter'); if($cc == ""){ echo 0; }else{ echo $cc; } ?>" />  
 




 
<div class="clearfix"></div>


</div>

<style>
.colorpicker, #TB_window {
  z-index: 9999;
}
.mce_fullscreen { background:rgb(236, 168, 168); color:#fff; }
.wp-switch-editor, .tmce-active .switch-tmce, .html-active .switch-html { height:27px !important; }

.wp-editor-container iframe, .wp-editor-container textarea { min-height:500px !important;}
 

.previewobject { color:red; }
#preview{
	position:absolute;
	border:1px solid #ccc;
	background:#333;
	padding:5px;
	display:none;
	color:#fff;
	}
 
</style>
<script>

this.imagePreview = function(){	
	/* CONFIG */
		
		xOffset = 10;
		yOffset = 30;
		
		// these 2 variable determine popup's distance from the cursor
		// you might want to adjust to get the right result
		
	/* END CONFIG */
	jQuery(".previewobject").hover(function(e){	 
		
		jQuery("body").append("<p id='preview'><img src='"+ this.src +"' alt='Image preview' /></p>");								 
		jQuery("#preview")
			.css("top",(e.pageY - xOffset) + "px")
			.css("left",(e.pageX + yOffset) + "px")
			.fadeIn("fast");						
    },
	function(){	
		jQuery("#preview").remove();
    });	
	jQuery("a.preview").mousemove(function(e){
		jQuery("#preview")
			.css("top",(e.pageY - xOffset) + "px")
			.css("left",(e.pageX + yOffset) + "px");
	});			
};
// starting the script on page load
jQuery(document).ready(function(){
	imagePreview();
	
	
});


</script>



<script type="application/javascript">

jQuery(function() {
 	
	 	
	jQuery( "#dragable_col1" ).droppable({
			accept: "#wlt_widget_list li",
            drop: function( event, ui ) {		
			
			// MAKE A UNIQUE REFERENCE ID FOR THIS OBJECT
			var refid = jQuery('#wlt_objectscounter').val();
			jQuery('#wlt_objectscounter').val(parseFloat(refid)+1);

			// LETS ADD THE ITEM ID TO THE COLUMN HIDDEN FIELD
			jQuery( "<li class='external-event widget' id='"+ui.draggable.attr("id")+"_"+refid+"'></li>" ).html( '<i class="gicon-signin"></i>'+ui.draggable.text() ).appendTo( this );
	 
			// NOW LETS GET A LIST OF IDS FROM THE COLUMN BOX AND SAVE IT
			UpdateFieldObject();
            }
     });
	 
	 jQuery( "#dragable_col1" ).sortable({ 
		revert: true ,	
		update: function (event, ui) {
            var currPos2 = ui.item.index();
			UpdateFieldObject();
        }
	});
	
	 	
	jQuery("#wlt_widget_list li" ).draggable({
           // containment: "#containment-wrapper",
            revert: "invalid", // when not dropped, the item will revert back to its initial position
            containment: "document",
            cursor: "move",
			connectToSortable: "#dragable_col",
            helper: "clone",
     });	
	
	
	// REMOVE ITEM WHEN DRAGGED BACK TO THE MAIN LIST
	jQuery( "#wlt_widget_list_remove" ).droppable({	
		accept: "#dragable_col1 li",
	 	drop: function( event, ui ) {		
         		ui.draggable.fadeOut();				
				jQuery("#dragable_col1_hidden").val(jQuery("#dragable_col1_hidden").val().replace(ui.draggable.attr('id'), ''));				
           }	
	}); 
	
	function UpdateFieldObject(){
	
		var liIds = jQuery('#dragable_col1 li').map(function(i,n) { 
		 
			if( jQuery(n).attr('id') == "undefined" ){				 
				return "";
			} else {
				return jQuery(n).attr('id')+'-'+jQuery(n).text();
			}
		}).get().join(',');				 
		
		jQuery("#dragable_col1_hidden").val(liIds);
	
	} 
	 
});
function AddObj(oid, text){

	// MAKE A UNIQUE REFERENCE ID FOR THIS OBJECT
	var refid = jQuery('#wlt_objectscounter').val();
	jQuery('#wlt_objectscounter').val(parseFloat(refid)+1);

	// LETS ADD THE ITEM ID TO THE COLUMN HIDDEN FIELD
	jQuery( "<li class='external-event widget' id='"+oid+"_"+refid+"'></li>" ).html( '<i class="gicon-signin"></i>'+text ).appendTo( '#dragable_col1' );
	
	// NOW LETS GET A LIST OF IDS FROM THE COLUMN BOX AND SAVE IT
	var liIds = jQuery('#dragable_col1 li').map(function(i,n) { 		 
			if( jQuery(n).attr('id') == "undefined" ){				 
					return "";
			} else {
				return jQuery(n).attr('id'); //-'+jQuery(n).text()
			}
		}).get().join(',');				 
		
		jQuery("#dragable_col1_hidden").val(liIds);	
		document.admin_save_form.submit();
	}
function objRemoveMe(me){
	jQuery("#dragable_col1_hidden").val(jQuery("#dragable_col1_hidden").val().replace(me, ''));
	document.admin_save_form.submit();
	
	}
</script>
<script>
function AddthisShortC(code, box){		   
	jQuery('#'+box).val('['+ code +']'+jQuery('#'+box).val()); 
}
</script>


<!-- start save button -->
<div class="form-actions row-fluid">
<div class="span7 offset5">
<button type="submit" class="btn btn-primary">Save Changes</button> 
</div>
</div> 
<!-- end save button -->  

</div><!-- end tab --> 



<?php // LOAD IN FOOTER
echo $CORE_ADMIN->FOOTER(); ?>