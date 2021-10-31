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
if (!defined('THEME_VERSION')) {	header('HTTP/1.0 403 Forbidden'); exit; } global $CORE_ADMIN, $CORE, $post;


// LOAD IN MAIN DEFAULTS 
$core_admin_values = get_option("core_admin_values");    $myPakID = get_post_meta($post->ID,'packageID',true); $packagefields = get_option("packagefields"); 

// GET EXPIRY
$e_value = get_post_meta($post->ID,'listing_expiry_date',true);
  
?> 


<div style="font-weight:bold; padding:10px; padding-left:0px; border-bottom:1px solid #ddd; color:#666; margin-bottom: 20px;">Listing Expiry</div>
 
<script type="text/javascript">
jQuery(document).ready(function($) {
	jQuery('#expirydate').datetimepicker();
});
</script>
 
<a href="javascript:void(0);" style="float:right;" onclick="jQuery('#listing_expiry_date').val('<?php echo $CORE->DATETIME("+1 minute"); ?>');">Time Now + 1 minute</a>

<div id="expirydate" data-date="<?php echo $e_value; ?>" data-date-format="yyyy-MM-dd hh:mm:ss">
<span class="add-on"><i class="dashicons dashicons-calendar-alt" style="cursor:pointer"></i></span>
<input type="text" class="custom_date" name="wlt_field[listing_expiry_date]" id="listing_expiry_date" value="<?php echo $e_value; ?>"  data-format="yyyy-MM-dd hh:mm:ss"/>
</div>

 
<p> Time Now: <?php echo current_time( 'mysql' ); ?></p>
 
 <hr style="margin-bottom:30px;" />
 
 
<?php if(strlen($e_value) > 1){ ?>

<div id="message" class="updated below-h2">

<p>Listing Expires:  <?php  echo do_shortcode('[TIMELEFT postid="'.$post->ID.'" layout="1" text_before="" text_ended="Not Set" key="listing_expiry_date"]'); ?></p>

</div>
		
        <?php if(is_numeric($myPakID)){  ?>
        
        <p>What happens when it expires?</p>
        <div id="message" class="error below-h2">
        
		
        <?php  
		switch($packagefields[$myPakID]['action']){		
			case "0": { echo "Nothing Happens."; } break;
			case "1": { echo "Listing status changed to draft"; } break;
			case "3": { echo "Listing status changed to pending"; } break;
			case "2": { echo "Listing is deleted"; } break;
			default: { 
			if(is_array(get_option("packagefields"))){ 

				foreach($packagefields as $field){ 
						if(!is_numeric($field['ID'])){ echo "Package incorrectly set."; continue; } 
						if($packagefields[$myPakID]['action'] == "move-".$field['ID']){ echo "Listing package is changed to: ".$field['name']; }
				} // end foreach
			}
						
			}// end default
		}// end switch
		
		?>
        <p>Email Sent: <?php 
		$sentE = $core_admin_values['emails']['expired']; 
		if(is_numeric($sentE)){ $wlt_emails = get_option("wlt_emails"); echo $wlt_emails[$sentE]['subject']; 
		}else{ echo "<b style='color:red;'>No email set.</b>"; } 
		?></p>
         </div> 
        
        
        <?php }else{ ?>
        Nothing. (no package set)
        <?php } ?> 
       
          
<?php } ?>
 