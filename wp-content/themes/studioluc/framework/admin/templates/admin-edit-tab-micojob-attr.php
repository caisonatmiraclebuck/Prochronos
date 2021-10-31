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
$core_admin_values = get_option("core_admin_values"); $current_data = get_post_meta($post->ID,"customextras",true); 
 
?> 
<div style='font-weight:bold; padding:10px; padding-left:0px; border-bottom:1px solid #ddd; color:#666;'>
<a href="javascript:void(0);" onClick="jQuery('#wlt_shop_attribute_fields').clone().appendTo('#wlt_shop_attributelist');" class="button">Add New Add-on</a>	
</div>

<div class="clear"></div>
 
<div  class="postbox meta-box-sortables ui-sortable" style="border:0px;">
<ul id="wlt_shop_attributelist">
<?php if(is_array($current_data)){ $i=0; foreach($current_data['name'] as $data){ if($current_data['name'][$i] !=""){ ?>
<li class="postbox closed" id="ff<?php echo $i; ?>" style="border-left: 4px solid #D03AB2;"><div title="Click to toggle" class="handlediv"></div>
    <h3 class="hndle"><?php echo $current_data['name'][$i]; ?></h3>
    <div class="inside">       
        <p><b>Display Text</b> </p>
        
        <input type="text" name="wlt_productattributes[name][]" id="ff<?php echo $i; ?>_title" value="<?php echo $current_data['name'][$i]; ?>"  style="width:100%; font-size:11px;"  />  
        
        <p><b>Description</b> </p>
        <textarea name="wlt_productattributes[value][]" style="width:100%;height:100px;"><?php echo trim($current_data['value'][$i]); ?></textarea>  
       
        <p><b>Price</b> </p>
           
   <?php echo $GLOBALS['CORE_THEME']['currency']['symbol']; ?> <input type="text" name="wlt_productattributes[price][]" id="ff<?php echo $i; ?>_price" value="<?php echo $current_data['price'][$i]; ?>"  style="width:20%; font-size:11px;"  />  
        
        
        
       
   
       
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
        <p>Display Text </p>
        <input type="text" name="wlt_productattributes[name][]" value=""  style="width:100%; font-size:11px;"  />  
        <p>Description</p>
        <textarea name="wlt_productattributes[value][]" style="width:100%;height:100px;"></textarea>  
        <hr />
        <p>Price <?php echo $GLOBALS['CORE_THEME']['currency']['symbol']; ?> <input name="wlt_productattributes[price][]" type="text" value="" /> </p>
         
    </div>
    </li>    
</div></div>