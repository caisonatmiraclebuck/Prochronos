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
		if(substr($HandlePath,-1) != "/"){
		$HandlePath = $HandlePath . "/";
		}
	    $count=1; $TemplateString = "";
		if($handle1 = opendir($HandlePath)) {      
			while(false !== ($file = readdir($handle1))){			 		
				if(strpos($file,"content-single-") !== false ){ if(strpos($file, $THEMESTUB) !== false ){
				$file_name = str_replace(".php","",str_replace("content-single-","",$file)); 
				$layouts[] = $file_name;
				}
			}
		} }
		
 
?>
   
 
<?php 

// DONT SHOW HOME PAGE OPTIONS IF ALREADY SET WITHIN CHILD THEME
if(file_exists(THEME_PATH."/templates/".$core_admin_values['template']."/_single.php") ){ }else{

?>



<div class="heading2">Column Layout</div> 
 

<?php /* 
<div class="form-row control-group row-fluid">
<label class="control-label span6">Design Layout</label>
<div class="controls span6">
<select name="admin_values[single_layout]" class="chzn-select">
 
<?php $l=1; foreach($layouts as $f){ ?>
<option <?php selected( $core_admin_values['single_layout'], $f );  ?> value="<?php echo $f; ?>" >Layout <?php echo $l; ?></option>
<?php $l++; } ?>
</select>  
</div>                
</div>

*/ ?>
<input type="hidden" name="admin_values[single_layout]" value="<?php echo $layouts[0]; ?>" />


 <div class="fieldbox">
 
<div class="form-row control-group row-fluid">
<label class="control-label span6">Columns</label>



<div class="controls row-fluid span6">
      
            <div class="span3">
            <a href="javascript:void(0);" onclick="document.getElementById('layout_body2').value='1';document.admin_save_form.submit();">
            <img src="<?php echo get_template_directory_uri(); ?>/framework/admin/img/core/l1.png" style="border:1px solid #ccc; padding:4px;background:#fff;<?php if($core_admin_values['layout_columns']['single'] == "1"){ echo "border:2px solid red;";} ?>" />
            </a>
                 
            </div>

            <div class="span3"> 
            <a href="javascript:void(0);" onclick="document.getElementById('layout_body2').value='2';document.admin_save_form.submit();">
            <img src="<?php echo get_template_directory_uri(); ?>/framework/admin/img/core/l2.png" style="border:1px solid #ccc; padding:4px;background:#fff;<?php if($core_admin_values['layout_columns']['single'] == "2"){ echo "border:2px solid red;";} ?>" />
            </a>
            
            </div>

            <div class="span3">   
            <a href="javascript:void(0);" onclick="document.getElementById('layout_body2').value='3';document.admin_save_form.submit();">
            <img src="<?php echo get_template_directory_uri(); ?>/framework/admin/img/core/l3.png" style="border:1px solid #ccc; padding:4px;background:#fff;<?php if($core_admin_values['layout_columns']['single'] == "3"){ echo "border:2px solid red;";} ?>" />
            </a>                               
                
            </div>
            
             <div class="span3">
             <a href="javascript:void(0);" onclick="document.getElementById('layout_body2').value='4';document.admin_save_form.submit();">
            <img src="<?php echo get_template_directory_uri(); ?>/framework/admin/img/core/l4.png" style="border:1px solid #ccc; padding:4px;background:#fff;<?php if($core_admin_values['layout_columns']['single'] == "4"){ echo "border:2px solid red;";} ?>" />
            </a>                             
                
            </div> 
                      
</div>
<input type="hidden" name="admin_values[layout_columns][single]" id="layout_body2" value="<?php echo $core_admin_values['layout_columns']['single']; ?>" /> 
</div>                
 

<div class="form-row control-group row-fluid">
    <label class="control-label span6" for="style">2 Column Width</label>
                <div class="controls span6">
                  <select name="admin_values[layout_columns][single_2columns]" class="chzn-select" id="2stylesingle">
                    <option value=""></option>
                    
                    <option value="0" <?php selected( $core_admin_values['layout_columns']['single_2columns'], 0 ); ?>>
                    363px X 757px</option>
                    
                    <option value="1" <?php selected( $core_admin_values['layout_columns']['single_2columns'], 1 ); ?>>
                    265px X 885px</option>   
                    
                     <option value="2" <?php selected( $core_admin_values['layout_columns']['single_2columns'], 2 ); ?>>
                    300px X 868px</option>                   
                  </select>
                </div>
</div>
<div class="form-row control-group row-fluid" <?php if($core_admin_values['layout_columns']['single'] != "4"){ echo 'style="display:none;"'; } ?>>
                <label class="control-label span6" for="style">3 Column Width</label>
                <div class="controls span4">
                  <select name="admin_values[layout_columns][single_3columns]" class="chzn-select" id="3stylesingle">
                    <option value=""></option>
                    <option value="0" <?php selected( $core_admin_values['layout_columns']['single_3columns'], 0 ); ?>>
                    250px / 500px / 250px </option>
                    <option value="1" <?php selected( $core_admin_values['layout_columns']['single_3columns'],1 ); ?>>
                    150px / 700px / 150px </option>                     
                  </select>
                </div>
</div>

<div class="clearfix"></div>


<p>Choose the display setup for your listing page and set the column widths.</p>

</div>
 
<?php } ?>
 
 
 
 
 
 
 
 
 <div class="heading2">Page Display Options</div> 
   
   
   
 <div class="fieldbox">
 
          <div class="form-row control-group row-fluid ">
                            <label class="control-label span6">Require Login To View</label>
                            <div class="controls span5">

                              <div class="row-fluid">
                                <div class="pull-left">
                                  <label class="radio off">
                                  <input type="radio" name="toggle" 
                                  value="off" onchange="document.getElementById('requirelogin').value='0'">
                                  </label>
                                  <label class="radio on">
                                  <input type="radio" name="toggle"
                                  value="on" onchange="document.getElementById('requirelogin').value='1'">
                                  </label>
                                  <div class="toggle <?php if($core_admin_values['requirelogin'] == '1'){  ?>on<?php } ?>">
                                    <div class="yes">ON</div>
                                    <div class="switch"></div>
                                    <div class="no">OFF</div>
                                  </div>
                                </div> 
                               </div>
                             </div>
                             
                             <input type="hidden" class="row-fluid" id="requirelogin" name="admin_values[requirelogin]" 
                             value="<?php echo $core_admin_values['requirelogin']; ?>">
            </div>
            
<p>Turn ON to force visitors to login/register before they can view the listing page.</p>
            
</div>
         
       

  <div class="fieldbox">
 
          <div class="form-row control-group row-fluid ">
                            <label class="control-label span6">Auto Start Media (Video/Music)</label>
                            <div class="controls span5">

                              <div class="row-fluid">
                                <div class="pull-left">
                                  <label class="radio off">
                                  <input type="radio" name="toggle" 
                                  value="off" onchange="document.getElementById('media_autostart').value='0'">
                                  </label>
                                  <label class="radio on">
                                  <input type="radio" name="toggle"
                                  value="on" onchange="document.getElementById('media_autostart').value='1'">
                                  </label>
                                  <div class="toggle <?php if($core_admin_values['media_autostart'] == '1'){  ?>on<?php } ?>">
                                    <div class="yes">ON</div>
                                    <div class="switch"></div>
                                    <div class="no">OFF</div>
                                  </div>
                                </div> 
                               </div>
                             </div>
                             
                             <input type="hidden" class="row-fluid" id="media_autostart" name="admin_values[media_autostart]" 
                             value="<?php if(!isset($core_admin_values['media_autostart'])){ echo 1; }else{ echo $core_admin_values['media_autostart']; } ?>">
            </div>
            
<p>Turn ON to auto start video/music files on the listing page.</p>
            
</div>           
       
     
        
        
    <?php if(defined('WLT_DIRECTORY') || defined('WLT_BUSINESS') ){ ?>
         
  
               <div class="form-row control-group row-fluid ">
                            <label class="control-label span6" rel="tooltip" data-original-title="Turn ON to display a claim listing button on all admin created listings." data-placement="top">Allow Claim Listings</label>
                            <div class="controls span4">
                              <div class="row-fluid">
                                <div class="pull-left">
                                  <label class="radio off">
                                  <input type="radio" name="toggle" 
                                  value="off" onchange="document.getElementById('visitor_claimme').value='0'">
                                  </label>
                                  <label class="radio on">
                                  <input type="radio" name="toggle"
                                  value="on" onchange="document.getElementById('visitor_claimme').value='1'">
                                  </label>
                                  <div class="toggle <?php if($core_admin_values['visitor_claimme'] == '1'){  ?>on<?php } ?>">
                                    <div class="yes">ON</div>
                                    <div class="switch"></div>
                                    <div class="no">OFF</div>
                                  </div>
                                </div> 
                               </div>
                             </div>
                             
                             <input type="hidden" class="row-fluid" id="visitor_claimme" name="admin_values[visitor_claimme]" 
                             value="<?php echo $core_admin_values['visitor_claimme']; ?>">
            </div>     
 
 
 
 <?php }else{ ?>
 <input type="hidden" id="visitor_claimme" name="admin_values[visitor_claimme]"  value="0">
 <?php } ?>
 
 
 
<div class="heading2">Customized Display Code </div> 

<p style="padding:10px; background:#fff; border:1px dashed green;">Here you can use your own combination of shortcodes and HTML to create your own listing page layout. </p>

          <div class="form-row control-group row-fluid ">
                            <label class="control-label span4"> Enable Custom Display</label>
                            <div class="controls span5">
                              <div class="row-fluid">
                                <div class="pull-left">
                                  <label class="radio off">
                                  <input type="radio" name="toggle" 
                                  value="off" onchange="document.getElementById('customlisting_enable').value='0'">
                                  </label>
                                  <label class="radio on">
                                  <input type="radio" name="toggle"
                                  value="on" onchange="document.getElementById('customlisting_enable').value='1'">
                                  </label>
                                  <div class="toggle <?php if($core_admin_values['customlisting_enable'] == '1'){  ?>on<?php } ?>">
                                    <div class="yes">ON</div>
                                    <div class="switch"></div>
                                    <div class="no">OFF</div>
                                  </div>
                                </div> 
                               </div>
                             </div>
                             
                             <input type="hidden" class="row-fluid" id="customlisting_enable" name="admin_values[customlisting_enable]" 
                             value="<?php echo $core_admin_values['customlisting_enable']; ?>">
            </div>  
 
 <textarea class="row-fluid" id="listingcode" style="height:300px;background:#E8FDE9" name="admin_values[listingcode]"><?php echo stripslashes($core_admin_values['listingcode']); ?></textarea>
        


<a href="javascript:void(0);" class="btn btn-info" onclick="jQuery('#spbuts4').show();">Show Shortcodes</a>




       
          <input type="hidden" name="customlistingpage" id="customlistingpage" value="" />
          <?php if($core_admin_values['single_layout'] != "" && $core_admin_values['single_layout'] != "listing"){ ?>
        <a href="javascript:void(0);" onclick="document.getElementById('customlistingpage').value='content-single-<?php echo $core_admin_values['single_layout']; ?>';document.admin_save_form.submit();" class="btn btn-default" style="float:right; margin-top:-5px;">
       Get Codes from Default Layout
        </a> 
        <?php } ?>
      
     
           
           
<div style="display:none;" id="spbuts4">
<hr />
<a href="javascript:void(0);" onclick="jQuery('#spbuts4').hide();" class="label">Hide Shortcodes</a>
 <div class='well'>
			   <?php $btnArray = array(
               'ID' =>'post ID',
               'IMAGE' =>'display image',	
			   'IMAGES' =>'display image gallery', 
			   'TAB_IMAGES' =>'display image gallery within a tab', 
			   'FILES' =>'all media files', 
               'TITLE' =>'title with link to listing page',
               'TITLE-NOLINK' =>'title without link',
               'EXCERPT' =>'short content',
               'BUTTON' =>'more info button',
               'DATE' =>' listing creation date',
               'AUTHOR' =>'author',
               'CATEGORY' =>'category',
               'LISTINGSTATUS' =>'listing status',
               'LOCATION' =>'listing location',
               'AUTHORIMAGE' =>'author image',
               'AUTHORIMAGE-CIRCLE' =>'author image with circular background',
               'TIMESINCE' =>'',
               'RATING' =>'star rating',
			   
			   'SOCIAL' =>'social buttons',
			   'GOOGLEMAP' =>'Google Map',
			   'RATING' =>'Star Rating',
			   'FAVS' =>'Add/Remove from favourites',
			   'FIELDS' =>'custom fields',
			   'TOOLBOX' =>'small box with a few items',
			   'TOOLBAR' =>'bar with category and tags',
			   'RELATED' =>'related items',
			   'CONTACT' =>'contact form',
			   'COMMENTS' =>'comments form',						     
				   
               ); 
			   
			 
			   
               foreach( $btnArray as $k => $b){
                echo "<a href='javascript:void(0);' onclick=\"AddthisShortC('".$k."','listingcode');\" class='btn' style='margin-right:10px; margin-bottom:5px;' rel='tooltip' data-original-title='".$b."' data-placement='bottom'>".$k."</a>";
               }
               
               ?>
</div>
</div>
