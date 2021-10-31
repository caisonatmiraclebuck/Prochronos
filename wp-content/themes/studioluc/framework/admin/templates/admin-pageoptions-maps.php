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
  
?> 
 
 
<div class="heading2">Enable Google Maps</div>  
       

       <div class="form-row control-group row-fluid ">
                            <label class="control-label span6" >Google Maps</label>
                            <div class="controls span4">
                              <div class="row-fluid">
                                <div class="pull-left">
                                  <label class="radio off">
                                  <input type="radio" name="toggle" 
                                  value="off" onchange="document.getElementById('google').value='0'">
                                  </label>
                                  <label class="radio on">
                                  <input type="radio" name="toggle"
                                  value="on" onchange="document.getElementById('google').value='1'">
                                  </label>
                                  <div class="toggle <?php if($core_admin_values['google'] == '1'){  ?>on<?php } ?>">
                                    <div class="yes">ON</div>
                                    <div class="switch"></div>
                                    <div class="no">OFF</div>
                                  </div>
                                </div> 
                               </div>
                             </div>
                             
                             <input type="hidden" class="row-fluid" id="google" name="admin_values[google]" 
                             value="<?php echo $core_admin_values['google']; ?>">
            </div>  
            
            
            
   <div class="form-row control-group row-fluid">
                     <label class="control-label span4">API Key (<a href="https://developers.google.com/maps/documentation/javascript/get-api-key#get-an-api-key" target="_blank">get one here</a>)</label>
                     
                     <div class="controls span7"> 
                     <div class="input-append color row-fluid">
                     <input name="admin_values[googlemap_apikey]" id="googlemap_apikey" type="text" value="<?php echo trim(stripslashes($core_admin_values['googlemap_apikey'])); ?>" class="row-fluid" <?php if(isset($_GET['enterkey'])){ ?>style="border:2px solid red;"<?php } ?>>
                  
                     </div>
                     
                     </div>
                </div>           
            
            
            
            
<div class="heading2"> Search Results Page Settings </div>          
        
        
<div class="fieldbox">
        
           <div class="form-row control-group row-fluid ">
                            <label class="control-label span6">Show Map Open</label>
                            <div class="controls span5">
                              <div class="row-fluid">
                                <div class="pull-left">
                                  <label class="radio off">
                                  <input type="radio" name="toggle" 
                                  value="off" onchange="document.getElementById('default_gallery_map').value='0'">
                                  </label>
                                  <label class="radio on">
                                  <input type="radio" name="toggle"
                                  value="on" onchange="document.getElementById('default_gallery_map').value='1'">
                                  </label>
                                  <div class="toggle <?php if($core_admin_values['default_gallery_map'] == '1'){  ?>on<?php } ?>">
                                    <div class="yes">ON</div>
                                    <div class="switch"></div>
                                    <div class="no">OFF</div>
                                  </div>
                                </div> 
                               </div>
                             </div>
                             
                             <input type="hidden" class="row-fluid" id="default_gallery_map" name="admin_values[default_gallery_map]" 
                             value="<?php echo $core_admin_values['default_gallery_map']; ?>">
            </div> 
            
            

<p>Turn ON to display Google maps visible by default on the serarch results page.</p>

 
 
        <div class="form-row control-group row-fluid">
        <label class="control-label span6" for="style">Google Map Position</label>
        <div class="controls span5">
        <select name="admin_values[display_search_map]" class="chzn-select" id="display_search_map">      
          <option value="" <?php selected( $core_admin_values['display_search_map'], "" );  ?>>Top of Page</option>
           <option value="1" <?php selected( $core_admin_values['display_search_map'], "1" );  ?>>Left Sidebar</option>
          <option value="2" <?php selected( $core_admin_values['display_search_map'], "2" );  ?>>Right Sidebar</option>
          <option value="3" <?php selected( $core_admin_values['display_search_map'], "3" );  ?>>Above Search Results</option>
        </select>
        </div>
        </div>
        
        
        
               <div class="form-row control-group row-fluid">
        <label class="control-label span6" for="style">Google Map Color</label>
        <div class="controls span5">
        <select name="admin_values[display_mapcolor_search]" class="chzn-select" id="display_mapcolor_search">
      
          <option value="" <?php selected( $core_admin_values['display_mapcolor_search'], "" );  ?>>Default Color</option>
           <option value="grey" <?php selected( $core_admin_values['display_mapcolor_search'], "grey" );  ?>>Grey</option>
 <option value="green" <?php selected( $core_admin_values['display_mapcolor_search'], "green" );  ?>>Green</option>
 <option value="blue" <?php selected( $core_admin_values['display_mapcolor_search'], "blue" );  ?>>Blue</option>
        </select>
        </div>
        </div>
        



           <div class="form-row control-group row-fluid ">
                            <label class="control-label span6">Map Cluster Markers</label>
                            <div class="controls span5">
                              <div class="row-fluid">
                                <div class="pull-left">
                                  <label class="radio off">
                                  <input type="radio" name="toggle" 
                                  value="off" onchange="document.getElementById('googlemap_cluster').value='0'">
                                  </label>
                                  <label class="radio on">
                                  <input type="radio" name="toggle"
                                  value="on" onchange="document.getElementById('googlemap_cluster').value='1'">
                                  </label>
                                  <div class="toggle <?php if($core_admin_values['googlemap_cluster'] == '1'){  ?>on<?php } ?>">
                                    <div class="yes">ON</div>
                                    <div class="switch"></div>
                                    <div class="no">OFF</div>
                                  </div>
                                </div> 
                               </div>
                             </div>
                             
                             <input type="hidden" class="row-fluid" id="googlemap_cluster" name="admin_values[googlemap_cluster]" 
                             value="<?php echo $core_admin_values['googlemap_cluster']; ?>">
            </div> 
            
<p>Turn ON if you want the map icons to be clustered, recommended for larger websites.</p> 
           
 </div>  
 
 
      <div class="fieldbox">
     
                <div class="form-row control-group row-fluid">
                     <label class="control-label span4">Marker Icon</label>
                     
                     <div class="controls span7"> 
                     <div class="input-append color row-fluid">
                     <input name="admin_values[googlemap_icon]" id="googlemap_icon" type="text" value="<?php echo stripslashes($core_admin_values['googlemap_icon']); ?>" class="row-fluid">
                     <span class="add-on" style="margin-right: -30px;" id="upload_googlemap_icon"><i class="gicon-search"></i></span>                  
                     </div>
                     
                     </div>
                </div>
                
                
                
                 <div style="text-align:center; border:1px solid #ddd; padding:20px; margin-left:100px;margin-bottom:30px;margin-right:100px;">
                
                <?php if(strlen($core_admin_values['googlemap_icon']) > 10){ 
				
				echo '<img src="'.$core_admin_values['googlemap_icon'].'" style="max-width:250px; max-height:250px;" /> '; 
				
				}else{
				
				echo '<img src="'.get_template_directory_uri().'/framework/img/map/icon.png" style="max-width:250px; max-height:250px;" /> ';   
				
				} ?>
                 
                </div> 
                
               
                
                <input type="hidden" value="" name="imgIdblock" id="imgIdblock" />

				<script type="text/javascript">
                
                jQuery('#upload_googlemap_icon').click(function() {
                 ChangeImgBlock('googlemap_icon'); 
                 formfield = jQuery('#googlemap_icon').attr('name');
                 tb_show('', 'media-upload.php?type=image&amp;TB_iframe=true');
                 return false;
                });
                 
                </script>   

<p>This will be used as your Google map location marker. The icon must be .png size: 32px width and 37px height. Leave blank to use the default.</p>

</div>
   
            
            <?php 
		 
			if($core_admin_values['google_coords1'] == ""){ $core_admin_values['google_coords1'] = "0,0"; } 
			if($core_admin_values['google_zoom1'] == ""){ $core_admin_values['google_zoom1'] = 8; }
			?>
            
                
            <div class="row-fluid">
                <label class="control-label span6">Default Map Zoom (0-20)</label>
                <div class="controls span4">         
                 <div class="input-prepend">
                  <span class="add-on">#</span>
                  <input type="text"  name="admin_values[google_zoom1]" value="<?php echo $core_admin_values['google_zoom1']; ?>" style="width:60px;">
                </div>        
                </div>
            </div>
            
            <div class="row-fluid">
                <label class="control-label span6">Default Map Cords <br /><small>numeric values only</small></label>
                <div class="controls span3">         
                 <div class="input-prepend">
                  <span class="add-on">lat,long</span>
                  <input type="text"  name="admin_values[google_coords1]" value="<?php echo $core_admin_values['google_coords1']; ?>" style="width:200px; text-align:right">
                </div>        
                </div>
            </div>
            
            
            
 <div class="heading2"> Listing Page Settings </div>          
           
<div class="fieldbox">

             <div class="form-row control-group row-fluid">
        <label class="control-label span6" for="style">Map Color</label>
        <div class="controls span5">
        <select name="admin_values[display_mapcolor_listing]" class="chzn-select" id="display_mapcolor_listing">
      
          <option value="" <?php selected( $core_admin_values['display_mapcolor_listing'], "" );  ?>>Default</option>
           <option value="grey" <?php selected( $core_admin_values['display_mapcolor_listing'], "grey" );  ?>>Grey</option>
 <option value="green" <?php selected( $core_admin_values['display_mapcolor_listing'], "green" );  ?>>Green</option>
 <option value="blue" <?php selected( $core_admin_values['display_mapcolor_listing'], "blue" );  ?>>Blue</option>
        </select>
        </div>
        </div>
      
      <p>Set the color of the map displayed on the listing page.</p>
        
</div>
 
 
  <?php if(!defined('WLT_CART')){ ?>
            
<div class="heading2">GEO Location</div>  

 <p>GEO location is where the system will try and get the visitors location so you can provide more accurate data to them. </p>
 
<div class="fieldbox">
             
             
       <div class="form-row control-group row-fluid">
        <label class="control-label span5" for="style">Enable GEO Location</label>
        <div class="controls span6">
        <select name="admin_values[geolocation]" class="chzn-select" id="geo1">

          <option value="" <?php if($core_admin_values['geolocation'] == ""){ echo "selected=selected"; } ?>>Disable</option>
          <option value="1" <?php if($core_admin_values['geolocation'] == "1"){ echo "selected=selected"; } ?>>Enable in Top Menu</option> 
          
        </select>
        </div>
        </div> 
        
        
       
        
        <div class="form-row control-group row-fluid">
        <label class="control-label span5" for="style">Display GEO Flag</label>
        <div class="controls span6">
        <select name="admin_values[geolocation_flag]" class="chzn-select" id="geo2">

         <?php
		 
		  $selected = $core_admin_values['geolocation_flag'];
				 
                 foreach ($GLOBALS['core_country_list'] as $key=>$option) {				 				
                 	printf( '<option value="%1$s"%3$s>%2$s</option>', trim( $key  ), $option, selected( $selected, $key, false ) );
                 }
		 
		 ?> 
         
        </select>
        </div>
        </div> 
        
        
        <div class="form-row control-group row-fluid">
        <label class="control-label span5" for="style">Distance Unit</label>
        <div class="controls span6">
        <select name="admin_values[geolocation_unit]" class="chzn-select" id="geo3">

          <option value="" <?php if($core_admin_values['geolocation_unit'] == ""){ echo "selected=selected"; } ?>>Miles</option>
          <option value="K" <?php if($core_admin_values['geolocation_unit'] == "K"){ echo "selected=selected"; } ?>>Kilometers</option> 
          <option value="N" <?php if($core_admin_values['geolocation_unit'] == "N"){ echo "selected=selected"; } ?>>Nautical Miles</option> 
         
         
        </select>
        </div>
        </div> 
        
        
</div>
        
        
        <?php }else{ ?>

<input name="admin_values[geolocation]" value="" type="hidden">
		<?php } ?>



      