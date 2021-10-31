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
$core_admin_values = get_option("core_admin_values");  global $wpdb; 
 
?>
 

<div class="tab-content" style="border:0px;">

    <div class="tab-pane fade in active" id="f1">
    
 
 

<h2 style="color:#666;">Default Home Page Design Editor</h2>

<p>The default home page comes with pre-defined options that you can turn on/off below.</p>

<p>Simply fill in the blanks and/or turn off blocks you do not want displayed.</p>
 
<div class="heading2">Turn on/off display blocks</div>


<?php $i=1; while($i < 6){ 

if(defined('ADMIN_REMOVE_HOMEBLOCK'.$i)){ $i++;  continue; }

?>



      <div class="form-row control-group row-fluid content">
                                <label class="control-label span4 offset2" data-placement="top">Display Block <?php echo $i; ?></label>
                                <div class="controls span4">
                                  <div class="row-fluid">
                                    <div class="pull-left">
                                      <label class="radio off">
                                      <input type="radio" name="toggle" 
                                      value="off" onchange="document.getElementById('home_section<?php echo $i; ?>').value='0'">
                                      </label>
                                      <label class="radio on">
                                      <input type="radio" name="toggle"
                                      value="on" onchange="document.getElementById('home_section<?php echo $i; ?>').value='1'">
                                      </label>
                                      <div class="toggle <?php if(!isset($core_admin_values['home_section'.$i]) || (isset($core_admin_values['home_section'.$i]) && $core_admin_values['home_section'.$i] == '1' ) ){  ?>on<?php } ?>">
                                        <div class="yes">ON</div>
                                        <div class="switch"></div>
                                        <div class="no">OFF</div>
                                      </div>
                                    </div> 
                                   </div>
                                 </div>
                                 
                                 <input type="hidden" class="row-fluid" id="home_section<?php echo $i; ?>" name="admin_values[home_section<?php echo $i; ?>]" 
                                 value="<?php if(!isset($core_admin_values['home_section'.$i])){ echo 1; }else{ echo $core_admin_values['home_section'.$i]; } ?>">
         </div>

<?php $i++; } ?>

<p>A display block refers to each feature on your home page, for example the banner is one block, categories is another block. Count from the top down.</p>
 

<hr />

<?php 


$homedata = array( 


'j1' => array(
	"n" => "Main Banner Block", 
	"data" => array(
		"title1" 	=> array( "t" => "Title Text", "d" => "Hello! &amp; Welcome" ),
		"title2" 	=> array( "t" => "Sub title text", "d" => "We hope you enjoy our new website" ),
		"title3" 	=> array( "t" => "Short Description", 	"type" => "textarea", "d" => "You can edit this text via the admin area under the page setup." ),
		"img" 		=> array( "t" => "Background Image <br><small>(size: 1150px / 400px )</small>", 	"type" => "upload", "d" => "" ),
	),
),

't1' => array(
	"n" => "Title Block 1", 
	"data" => array(
		"title1" 	=> array( "t" => "Title Text" , "d" => "Your Amazing Title Here"),
		"title2" 	=> array( "t" => "Sub Title Text", "d" => "" ),
	),
),
't2' => array(
	"n" => "Title Block 2", 
	"data" => array(
		"title1" 	=> array( "t" => "Title Text", "d" => "" ),
		"title2" 	=> array( "t" => "Sub Title Text", "d" => "" ),
	),
),

't3' => array(
	"n" => "Image Block 1", 
	"data" => array(
		"img1" 	=> array( "t" => "Image 1","type" => "upload", "d" => ""  ),
		"img2" 	=> array( "t" => "Image 2", "type" => "upload", "d" => ""  ),
		"img3" 	=> array( "t" => "Image 3", "type" => "upload", "d" => ""  ),
		
		
	),
),
 
);

// HOME EDIT
$homedata = hook_admin_2_homeedit($homedata);
 
// LOOK HOME DATA
$i=1;
foreach($homedata as $key => $data){ ?>


  <div class="accordion-group">
  
    <div class="accordion-heading btn-success">
      <a class="accordion-toggle" data-toggle="collapse" data-parent="#wlt_widget_list" href="#collapse<?php echo $key; ?>" style="color:#fff; font-weigt:bold;">
      <img src="<?php echo get_template_directory_uri(); ?>/framework/img/a3.png" style="float:right;margin-top:3px;">
        <?php echo $data['n']; ?> &nbsp;
      </a>
    </div>
    
    <div id="collapse<?php echo $key; ?>" class="accordion-body collapse <?php if($i == 1){ ?>in<?php } ?>" style="background:#F1FFF1;">
      <div class="accordion-inner">
      <ul>
      <?php foreach($data['data'] as $key1 => $item){  if(!isset($item['type'])){ $item['type'] = ""; }  ?>
	
<li>

<?php  if($item['t'] == "break"){  if(isset($item['txt'])){ echo "<hr /><strong>".$item['txt']."</strong>"; }else{ echo "<hr />"; } continue; } ?>

<div class="row-fluid clearfix">
          
                <label class="control-label span4"><?php echo $item['t']; ?></label>
                <div class="controls span8">    
                
                <?php switch($item['type']){ 
				
				case "textarea": { ?>
                
                <textarea name="admin_values[hdata][<?php echo $key; ?>][<?php echo $key1; ?>]" style="height:150px; width:100%;"/><?php if($core_admin_values['hdata'][$key][$key1] == ""){ echo $item['d']; }else{ echo stripslashes($core_admin_values['hdata'][$key][$key1]); } ?></textarea> 
                
                <?php } break; 
				
				case "upload": { ?> 
                
                
                <div class="input-append row-fluid" style="width:90%;">
    
    			<input name="admin_values[hdata][<?php echo $key; ?>][<?php echo $key1; ?>]" type="text" id="up_<?php echo $key; ?><?php echo $key1; ?>" value="<?php if($core_admin_values['hdata'][$key][$key1] == ""){ echo $item['d']; }else{  echo stripslashes($core_admin_values['hdata'][$key][$key1]); } ?>" class="row-fluid">
   
   				<span class="add-on" style="margin-right: -30px; cursor:pointer;" id="upload_<?php echo $key; ?><?php echo $key1; ?>"><i class="gicon-search"></i></span>   
  
    			</div>
                
               <script type="text/javascript">
			   
				jQuery(document).ready(function () {
			  
				   jQuery('#upload_<?php echo $key."".$key1; ?>').click(function() {           
			  
					 ChangeImgBlock('up_<?php echo $key."".$key1; ?>');
					 formfield = jQuery('#up_<?php echo $key."".$key1; ?>').attr('name');
					 tb_show('', 'media-upload.php?type=image&amp;TB_iframe=true');
					 return false;
					});
					
				});	
				
				</script>
            
                <?php } break; ?>
                
                <?php default: { ?>    
                
                  <input type="text" name="admin_values[hdata][<?php echo $key; ?>][<?php echo $key1; ?>]" value="<?php if($core_admin_values['hdata'][$key][$key1] == ""){ echo $item['d']; }else{ echo stripslashes($core_admin_values['hdata'][$key][$key1]); } ?>" style="width:100%">
                  
                <?php } } ?>
                
                </div>             
</div>
<div class="clearfix"></div></li>
	<?php } ?>    
  </ul>
  </div>
   </div>  </div>
 

<?php $i++; } ?>


 

 
<script type="text/javascript">
function DisplayFormValues(type){
	var elem = document.getElementById(type).elements;
	for(var i = 0; i < elem.length; i++){
		jQuery("#up_"+elem[i].name).val(elem[i].value);
	}
	 
	jQuery('#custom_css_box').val('');
	jQuery('#shownewcode').val('save');	
	document.admin_save_form.submit(); 
}
 
</script>



 


    </div>
    
 

</div>

<hr />
 