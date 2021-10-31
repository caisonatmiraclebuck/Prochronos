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
$core_admin_values = get_option("core_admin_values"); $current_discount_data = get_post_meta($post->ID,"wlt_productdiscounts",true);
  
?> 
<div style='font-weight:bold; padding:10px; padding-left:0px; border-bottom:1px solid #ddd; color:#666;'>
<a href="javascript:void(0);" onClick="jQuery('#wlt_shop_discount_fields').clone().appendTo('#wlt_shop_discountlist');" class="button">Add New Discount</a>	
</div>

<div  class="postbox meta-box-sortables ui-sortable" style="border:0px;">
<ul id="wlt_shop_discountlist">
<?php if(is_array($current_discount_data)){ $i=0; foreach($current_discount_data['min'] as $data){ if($current_discount_data['min'][$i] !=""){ ?>
<li class="postbox closed" id="dff<?php echo $i; ?>" style="border-left: 4px solid #7ad03a;">
<div title="Click to toggle" class="handlediv"></div>

    <h3 class="hndle">Discount: <?php echo "Order more than <b>".$current_discount_data['min'][$i]."</b> and less than <b>".$current_discount_data['max'][$i]."</b> the new item price is: ".hook_price($current_discount_data['price'][$i]); ?></h3>
    <div class="inside">       
        <p>Min: Quantity <small>(e.g 1)</small></p>
        <input type="text" name="wlt_productdiscounts[min][]" id="dff<?php echo $i; ?>_d1" value="<?php echo $current_discount_data['min'][$i]; ?>"  style="width:50%; font-size:11px;"  />  
        <p>Max: Quantity (e.g 10)</p>
        <input type="text" name="wlt_productdiscounts[max][]" id="dff<?php echo $i; ?>_d2" value="<?php echo $current_discount_data['max'][$i]; ?>"  style="width:50%; font-size:11px;"  />  
        <p>New Price Per Item (e.g. $100)</p>
        <input type="text" name="wlt_productdiscounts[price][]" id="dff<?php echo $i; ?>_f3" value="<?php echo $current_discount_data['price'][$i]; ?>"  style="width:50%; font-size:11px;"  />  
       
    
        <a href="javascript:void(0);" onClick="jQuery('#dff<?php echo $i; ?>_d1').val('');jQuery('#dff<?php echo $i; ?>').hide();" style="background:#7ad03a;color:#fff;padding:3px;float:right">Remove Field</a>
        <div class="clear"></div>
    </div>    
 
</li>
<?php }  $i++; } } ?>
</ul>
</div>
<div style="display:none"><div id="wlt_shop_discount_fields">
    <li class="postbox"><div title="Click to toggle" class="handlediv"></div>
    <h3 class="hndle">New Product Discount</h3>
    <div class="inside">       
         <p>Min: Quantity <small>(e.g 1)</small></p>
        <input type="text" name="wlt_productdiscounts[min][]"   style="width:50%; font-size:11px;"  />  
        <p>Max: Quantity (e.g 10)</p>
        <input type="text" name="wlt_productdiscounts[max][]"  style="width:50%; font-size:11px;"  />  
        <p>New Price Per Item (e.g. $100)</p>
        <input type="text" name="wlt_productdiscounts[price][]"  style="width:50%; font-size:11px;"  />  
       
    </div>
    </li>    
</div></div>