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
$core_admin_values = get_option("core_admin_values");  

// DEFAULT ITEM
$THEMESTUB = str_replace("_theme","",str_replace("template_","",$GLOBALS['CORE_THEME']['template']));
if($THEMESTUB == ""){ $THEMESTUB = "framework"; }
 

		$i=1; $layouts = array();
		$selected_template = $core_admin_values['template']; 
		$HandlePath = TEMPLATEPATH;
	    $count=1; $TemplateString = "";
		if($handle1 = opendir($HandlePath)) {      
			while(false !== ($file = readdir($handle1))){	
			 
				if(strpos($file,"home-") !== false ){ if(strpos($file, $THEMESTUB) !== false ){
				$file_name = str_replace(".php","",str_replace("home-","",$file)); 
				$layouts[] = $file_name;
				}
			}
		}
		
		}

?>
 
<?php /*
<div class="form-row control-group row-fluid">
<label class="control-label span6">Layout Style </label>
<div class="controls span6">
<select name="admin_values[homepage_layout]" class="chzn-select" >
 
<?php $l =1; foreach($layouts as $k => $f){ ?>
<option <?php selected( $core_admin_values['homepage_layout'], $f );  ?> value="<?php echo $f; ?>" >Layout Style <?php echo $l; ?></option>
<?php $l++; } ?>
</select>  
</div>                
</div>
*/ ?>
<input type="hidden" name="admin_values[homepage_layout]" value="<?php echo $layouts[0]; ?>" />



<div class="heading2">Column Layout</div> 
 
 <div class="fieldbox"  style="margin-bottom:50px;">
 
<div class="form-row control-group row-fluid">
<label class="control-label span6">Columns</label>
<div class="controls row-fluid span6">
      
            <div class="span3">
            <a href="javascript:void(0);" onclick="document.getElementById('layout_body0').value='1';document.admin_save_form.submit();">
            <img src="<?php echo get_template_directory_uri(); ?>/framework/admin/img/core/l1.png" style="border:1px solid #ccc; padding:4px;background:#fff;<?php if($core_admin_values['layout_columns']['homepage'] == "1"){ echo "border:2px solid red;";} ?>" />
            </a>
                 
            </div>

            <div class="span3"> 
            <a href="javascript:void(0);" onclick="document.getElementById('layout_body0').value='2';document.admin_save_form.submit();">
            <img src="<?php echo get_template_directory_uri(); ?>/framework/admin/img/core/l2.png" style="border:1px solid #ccc; padding:4px;background:#fff;<?php if($core_admin_values['layout_columns']['homepage'] == "2"){ echo "border:2px solid red;";} ?>" />
            </a>
            
            </div>

            <div class="span3">   
            <a href="javascript:void(0);" onclick="document.getElementById('layout_body0').value='3';document.admin_save_form.submit();">
            <img src="<?php echo get_template_directory_uri(); ?>/framework/admin/img/core/l3.png" style="border:1px solid #ccc; padding:4px;background:#fff;<?php if($core_admin_values['layout_columns']['homepage'] == "3"){ echo "border:2px solid red;";} ?>" />
            </a>                               
                
            </div>
            
             <div class="span3">
             <a href="javascript:void(0);" onclick="document.getElementById('layout_body0').value='4';document.admin_save_form.submit();">
            <img src="<?php echo get_template_directory_uri(); ?>/framework/admin/img/core/l4.png" style="border:1px solid #ccc; padding:4px;background:#fff;<?php if($core_admin_values['layout_columns']['homepage'] == "4"){ echo "border:2px solid red;";} ?>" />
            </a>                             
                
            </div> 
                      
</div>
<input type="hidden" name="admin_values[layout_columns][homepage]" id="layout_body0" value="<?php echo $core_admin_values['layout_columns']['homepage']; ?>" /> 
</div>                
 

<div class="form-row control-group row-fluid">
    <label class="control-label span6" for="style">2 Column Width</label>
                <div class="controls span6">
                  <select name="admin_values[layout_columns][homepage_2columns]" class="chzn-select" id="2stylehomepage">
                    <option value=""></option>
                    
                    <option value="0" <?php selected( $core_admin_values['layout_columns']['homepage_2columns'], 0 ); ?>>
                    363px X 757px</option>
                    
                    <option value="1" <?php selected( $core_admin_values['layout_columns']['homepage_2columns'], 1 ); ?>>
                    265px X 885px</option>   
                    
                     <option value="2" <?php selected( $core_admin_values['layout_columns']['homepage_2columns'], 2 ); ?>>
                    300px X 868px</option>                   
                  </select>
                </div>
</div>
<div class="form-row control-group row-fluid" <?php if($core_admin_values['layout_columns']['homepage'] != "4"){ echo 'style="display:none;"'; } ?>>
                <label class="control-label span6" for="style">3 Column Width</label>
                <div class="controls span4">
                  <select name="admin_values[layout_columns][homepage_3columns]" class="chzn-select" id="3stylehomepage">
                    <option value=""></option>
                    <option value="0" <?php selected( $core_admin_values['layout_columns']['homepage_3columns'], 0 ); ?>>
                    250px / 500px / 250px </option>
                    <option value="1" <?php selected( $core_admin_values['layout_columns']['homepage_3columns'],1 ); ?>>
                    150px / 700px / 150px </option>                     
                  </select>
                </div>
</div>

 <p>Choose the display setup for your home page and set the column widths.</p>

</div>