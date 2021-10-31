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
if (!defined('THEME_VERSION')) {	header('HTTP/1.0 403 Forbidden'); exit; } global $CORE_ADMIN;


// LOAD IN MAIN DEFAULTS 
$core_admin_values = get_option("core_admin_values"); $current_data = get_post_meta($post->ID,"wlt_productattributes",true);  

// FALLBACK FOR OLD CART ATTERIBUTES
$has_already_set = get_post_meta($post->ID,'has_already_set_attributes',true);
if($has_already_set == ""){
$ia = 1; $g = array();
while($ia < 8){
	$att = get_post_meta($post->ID,'customlist'.$ia,true);
	if($att != ""){
	// CHECK FOR CUSTOM TITLE
	$old_title = get_option('custom_field'.$ia);
	if(strlen($old_title) > 1){
	$current_data['name'][] 	=  $old_title;
	}else{
	$current_data['name'][] 	=  "Select Value";
	}
	$current_data['value'][] 	= str_replace(",","\n",$att);
	}
$ia++;
} 
echo '<input type="hidden" name="wlt_field[has_already_set_attributes]" value="1" />';
}
  
?> 
<div style='font-weight:bold; padding:10px; padding-left:0px; border-bottom:1px solid #ddd; color:#666;'>
<a href="javascript:void(0);" onClick="jQuery('#wlt_shop_attribute_fields').clone().appendTo('#wlt_shop_attributelist');" class="button">Add New Attribute</a>	
</div>

<div class="clear"></div>
<?php do_action('hook_admin_cartfields'); ?>  
<div  class="postbox meta-box-sortables ui-sortable" style="border:0px;">
<ul id="wlt_shop_attributelist">
<?php if(is_array($current_data)){ $i=0; foreach($current_data['name'] as $data){ if($current_data['name'][$i] !=""){ ?>
<li class="postbox closed" id="ff<?php echo $i; ?>" style="border-left: 4px solid #D03AB2;"><div title="Click to toggle" class="handlediv"></div>
    <h3 class="hndle"><?php echo $current_data['name'][$i]; ?></h3>
    <div class="inside">       
        <p><b>Display Text</b> <small>(e.g size)</small></p>
        <input type="text" name="wlt_productattributes[name][]" id="ff<?php echo $i; ?>_title" value="<?php echo $current_data['name'][$i]; ?>"  style="width:100%; font-size:11px;"  />  
        <p><b>Selection Values</b> (1 per line) <b>Special Formatting:</b> Name [value] - example: Extra Large[x-large]</p>
        <textarea name="wlt_productattributes[value][]" style="width:100%;height:100px;"><?php echo trim($current_data['value'][$i]); ?></textarea>  
        <hr />
        <p><input name="colorpick<?php echo $i; ?>" type="checkbox" onchange="changeboxme('colorpick<?php echo $i; ?>');" value="1" <?php if(isset($current_data['color'][$i]) && $current_data['color'][$i] == "1"){ echo "checked=checked"; } ?> /> Tick if this is a color selection.</p>        
        <input name="wlt_productattributes[color][]" type="hidden" id="colorpick<?php echo $i; ?>"  value="<?php if(isset($current_data['color'][$i]) && $current_data['color'][$i] == "1"){ echo 1; }else{ echo 0;} ?>" />
        
        <p><input name="requiredfield<?php echo $i; ?>" type="checkbox"  onchange="changeboxme('requiredfield<?php echo $i; ?>');" value="1" <?php if(isset($current_data['required'][$i]) && $current_data['required'][$i] == "1"){ echo "checked=checked"; } ?> /> Required?</p>
       
       <input name="wlt_productattributes[required][]" type="hidden" id="requiredfield<?php echo $i; ?>"  value="<?php if(isset($current_data['required'][$i]) && $current_data['required'][$i] == "1"){ echo 1; }else{ echo 0;} ?>" />
       
        <a href="javascript:void(0);" onClick="jQuery('#ff<?php echo $i; ?>_title').val('');jQuery('#ff<?php echo $i; ?>').hide();" style="background:#D03AB2;color:#fff;padding:3px;float:right">Remove Field</a>
        <div class="clear"></div>
    </div>    
    </li>
<?php }  $i++; } } ?>
</ul>
</div>
<script>
function changeboxme(id){

 var v = jQuery("#"+id).val();
 if(v == 1){
 jQuery("#"+id).val('0');
 }else{
 jQuery("#"+id).val('1');
 }
 
}
</script>

<div style="display:none"><div id="wlt_shop_attribute_fields">
    <li class="postbox"><div title="Click to toggle" class="handlediv"></div>
    <h3 class="hndle">New Attribute</h3>
    <div class="inside">       
        <p>Display Text <small>(e.g size)</small></p>
        <input type="text" name="wlt_productattributes[name][]" value=""  style="width:100%; font-size:11px;"  />  
        <p>Selection Values (1 per line)</p>
        <textarea name="wlt_productattributes[value][]" style="width:100%;height:100px;"></textarea>  
        <hr />
        <p><input name="wlt_productattributes[color][]" type="checkbox" value="1" /> Tick if this is a color section.</p>
         <p><input name="wlt_productattributes[required][]" type="checkbox" value="1" /> Required? </p>
    </div>
    </li>    
</div></div>