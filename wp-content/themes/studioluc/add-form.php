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

global $CORE, $userdata;
 
// GET DISPLAY STYLE
$DISPLAYSTYLE = $GLOBALS['CORE_THEME']['listing_form'];



/* =============================================================================
   EDIT LISTING DATA
   ========================================================================== */ 

$data = "";
// CHECK IF WE ARE EDITING A LISTING
if(isset($_GET['eid']) && is_numeric($_GET['eid']) ){

	// GET POST DATA	
	$edit_data = get_post($_GET['eid']);
 	
	// CHECK WE ARE THE AUTHOR
	if($edit_data->post_author != $userdata->ID && !current_user_can('administrator') ){
	die("Not your post!");
	}
 	// GET CATEGORY LIST FROM TERMS OBJEC
	$categories 	= wp_get_object_terms( $_GET['eid'], THEME_TAXONOMY );	
	// GET CUSTM FIELD DATA 
	$custom_fields 	= get_post_custom($_GET['eid']);
	foreach ( $custom_fields as $key => $value ){	
		$data[$key] =  $value[0];	
	}
	// STORE DATA IN ARRAY TO BE PASSED TO OUR CORE FUNCTIONS
	$data['post_title'] 	=  $edit_data->post_title;
	$data['post_excerpt'] 	=  $edit_data->post_excerpt;
	$data['post_content'] 	=  $edit_data->post_content;
	$data['cats'] 			=  $categories;	  
	// GET THE PACKAGE ID
	$_POST['packageID'] = get_post_meta($_GET['eid'], 'packageID', true);
	if($_POST['packageID'] == ""){ $_POST['packageID'] =- 1; }
	
	if(isset($_GET['upgradepakid']) && is_numeric($_GET['upgradepakid']) ){
	$_POST['packageID'] = $_GET['upgradepakid'];
	}	
 
}

/* =============================================================================
   end EDIT LISTING DATA
   ========================================================================== */ 


// ADJUST DEFAULT UPLOAD IF PACKAGES ARE ENABLED
if(isset($_POST['packageID']) && $_POST['packageID'] != "99" && $GLOBALS['packagefields'][$_POST['packageID']]['multiple_images'] == "1" && isset($GLOBALS['packagefields'][$_POST['packageID']]['max_uploads']) && is_numeric($GLOBALS['packagefields'][$_POST['packageID']]['max_uploads'])){
$GLOBALS['default_upload_space'] = $GLOBALS['packagefields'][$_POST['packageID']]['max_uploads'];
}elseif($CORE->_PACKNOTHIDDEN($GLOBALS['packagefields']) == 0 && $GLOBALS['CORE_THEME']['default_submission_fileuploads'] > 0){
$GLOBALS['default_upload_space'] = $GLOBALS['CORE_THEME']['default_submission_fileuploads'];
}elseif($GLOBALS['default_upload_space'] == 0){
$GLOBALS['default_upload_space'] = 0;
}else{
$GLOBALS['default_upload_space'] = 5;
} 

/* =============================================================================
   END USER ACTIONS
   ========================================================================== */ 
 

$steps = array(
 
'2' => array('title' => $CORE->_e(array('add','63')) ),   	// TITLE
'5' => array('title' => $CORE->_e(array('add','66')) ),  	// CUSTOM FIELDS
'3' => array('title' => $CORE->_e(array('add','64')) ), 	// CATEGORY
'4' => array('title' => $CORE->_e(array('add','65')) ), 	// UPLOADS
'6' => array('title' => $CORE->_e(array('add','67')) ), 	// MAP
);
$steps = hook_add_listtitles($steps);

// REMOVE STEPS IF NOT NEEDED
if( ( !isset($userdata) ) ||  ( isset($userdata) && !$userdata->ID ) ){ }else{ unset($steps[1]); } 
if(isset($GLOBALS['CORE_THEME']['google']) && $GLOBALS['CORE_THEME']['google'] == 1){ }else{  unset($steps[6]);  }
if($GLOBALS['default_upload_space'] > 0 ){ }else{ unset($steps[4]);  }
if(isset($_GET['eid'])){ unset($steps[4]); }

if(isset($GLOBALS['CORE_THEME']['listingcats']) && $GLOBALS['CORE_THEME']['listingcats'] != 1){ unset($steps[3]); }
 
?>



 
 


<?php if(isset($_GET['eid'])){ echo $CORE->RENEW_TOOLBOX($_GET['eid'], true); } ?> 

<form action="<?php echo $GLOBALS['CORE_THEME']['links']['add']; ?>" method="post" enctype="multipart/form-data" onsubmit="return VALIDATE_FORM_DATA();" id="SUBMISSION_FORM" >
<input type="hidden" name="action" value="save" />
<input type="hidden" name="packageID" value="<?php if(!isset($_POST['packageID']) && !is_numeric($_POST['packageID'])){ echo "-1"; }else{ echo $_POST['packageID']; } ?>" />

<?php if(isset($_GET['eid']) && is_numeric($_GET['eid']) ){ ?>
<input type="hidden" name="eid" value="<?php echo $_GET['eid']; ?>" />
<?php }elseif(isset($_POST['eid']) && is_numeric($_POST['eid']) ){ ?>
<input type="hidden" name="eid" value="<?php echo $_POST['eid']; ?>" />
<?php } ?>

<?php if(isset($_GET['adminedit']) && is_numeric($_GET['adminedit']) ){ ?>
<input type="hidden" name="adminedit" value="1" />
<?php } ?>
<?php if(isset($_GET['upgradepakid']) && is_numeric($_GET['upgradepakid']) ){ ?>
<input type="hidden" name="upgradepakid" value="<?php echo $_GET['upgradepakid']; ?>" />
<?php } ?>

 



<div id="wlt_stepswizard" class="panel-group <?php if($DISPLAYSTYLE == "small"){ ?>compactdisplay<?php } ?>">

  

<?php $i=1; foreach($steps as $k => $step){ ?>
<!--- STEP <?php echo $k; ?> --->


<div class="panel panel-default" <?php if(isset($_GET['mediaonly'])){ echo "style='display:none;'"; } ?> id="panel_section<?php echo $k; ?>">
            
            
<?php if($DISPLAYSTYLE == ""){ ?>

<div class="panel-heading">
               
                <span class="step-number"><?php echo $i; ?></span>
                <?php
				
				// ADD-ON TEXT FOR TOP BOX
				if($i == 1 && !isset($_GET['eid']) ){
				
				// TOTAL NUMBER OF SUBMISSIONS
				if(isset($current_submissions)){
				echo "<div class='pull-right'><span class='label label-info'>".$CORE->_e(array('add','94'))." ".$current_submissions."/".$GLOBALS['membershipfields'][$GLOBALS['current_membership']]['submissionamount']."</span></div>";
				}

				if(isset($GLOBALS['packagefields'][$_POST['packageID']]['name']) && $GLOBALS['packagefields'][$_POST['packageID']]['name'] != ""){ echo '<div class="pull-right"><span class="label label-default" style="text-shadow:none">'.strip_tags($GLOBALS['packagefields'][$_POST['packageID']]['name'])."</span></div>"; }
				
				}
				
				?>
                <a href="#step<?php echo $i; ?>" class="astep<?php echo $i; ?> <?php if($k == 6){ echo 'mapboxlink'; } ?>" data-parent="#wlt_stepswizard" data-toggle="collapse"><?php echo $step['title'] ?></a>
             
            </div>
            <div id="step<?php echo $i; ?>" class="stepblock<?php echo $k; ?> panel-collapse collapse <?php if($i ==1){ echo "in"; } ?>">
              <div class="panel-body">

<?php } ?>
              
              <?php 
			  
			  $field = array(); $o=0;  
			  
			  // SWITCH CONTENT BASED ON STEP
			  switch($k){
			  
			 
				case "2": { // LISTING DESCRIPTION
				
					if(isset($_GET['eid'])){
					
						// TITLE
						echo "<h1>".$CORE->_e(array('add','97'))."</h1>"; 
						
						// CUSTOM TEXT
						if(isset($GLOBALS['CORE_THEME']['custom']['edit_text']) && strlen($GLOBALS['CORE_THEME']['custom']['edit_text']) > 2 ){ 
							echo wpautop(stripslashes($GLOBALS['CORE_THEME']['custom']['edit_text'])); 
						}else{
							echo $CORE->_e(array('add','98'));
						}
						// SPACER
						echo "<hr />";
					 					
					}else{
					
						// TITLE
						echo "<h1>".$CORE->_e(array('homepage','4'))."</h1>"; 
						
						// CUSTOM TEXT
						if(isset($GLOBALS['CORE_THEME']['custom']['add_text']) && strlen($GLOBALS['CORE_THEME']['custom']['add_text']) > 2 ){ 
							echo wpautop(stripslashes($GLOBALS['CORE_THEME']['custom']['add_text'])); 
						}else{ 
							echo $CORE->_e(array('add','8')); 
						}
						
						// SPACER
						echo "<hr />"; 
						
 
					}
					
					if(!$userdata->ID){
					
						$field = array();
						echo "<div class='bs-callout' id='new_user_registration'>";					
						$field[$o]['title'] 	= $CORE->_e(array('login','10'));
						$field[$o]['name'] 		= "new_username";
						$field[$o]['type'] 		= "text";
						$field[$o]['class'] 	= "form-control";
						$field[$o]['required'] 	= true;
						if(isset($GLOBALS['CORE_THEME']['visitor_password']) && $GLOBALS['CORE_THEME']['visitor_password'] == '1'){
							$o++;
							$field[$o]['title'] 	= $CORE->_e(array('account','10'));
							$field[$o]['name'] 		= "new_password";
							$field[$o]['type'] 		= "text";
							$field[$o]['class'] 	= "form-control";
							$field[$o]['required'] 	= true;
							$field[$o]['password'] 	= true;
						}
						$o++;
						$field[$o]['title'] 	= $CORE->_e(array('account','9'));
						$field[$o]['name'] 		= "email";
						$field[$o]['type'] 		= "text";
						$field[$o]['class'] 	= "form-control";
						$field[$o]['required'] 	= true;
						echo $CORE->BUILD_FIELDS($field,$data);
						
						echo "<p>".$CORE->_e(array('add','36'))."</p>";
						echo '</div>'; 
						$o++;
					
					}
					
					
				    $field = array();
					$field[$o]['title'] 	= $CORE->_e(array('add','10'));
					$field[$o]['name'] 		= "post_title";
					$field[$o]['type'] 		= "text";
					$field[$o]['class'] 	= "form-control";
					$field[$o]['required'] 	= true;
					$field[$o]['ontop'] 	= true;
					$field[$o]['placeholder'] = hook_add_post_title_text("");
					
					$o++;
					$field[$o]['title'] 	= $CORE->_e(array('add','12'));
					$field[$o]['name'] 		= "post_content";
					$field[$o]['type'] 		= "post_content";
					$field[$o]['class'] 	= "form-control";
					$field[$o]['ontop'] 	= true;
					if( (isset($_GET['eid']) && get_post_meta($_GET['eid'],'html',true) == "yes" ) 
					|| ( isset($_POST['packageID']) && isset($GLOBALS['packagefields'][$_POST['packageID']]['enhancement']) && isset($GLOBALS['packagefields'][$_POST['packageID']]['enhancement']['3']) &&  $GLOBALS['packagefields'][$_POST['packageID']]['enhancement']['3'] == 1 ) ){					
					}else{
					$field[$o]['showlimit'] = true;
					}
					
					$o++;
					$field[$o]['title'] 	= $CORE->_e(array('add','71'));
					$field[$o]['name'] 		= "post_tags";
					$field[$o]['type'] 		= "text";
					$field[$o]['help'] 		= $CORE->_e(array('add','73'));
					$field[$o]['class'] 	= "form-control";
					$field[$o]['ontop'] 	= true;
					$field[$o]['placeholder'] = $CORE->_e(array('add','71','flag_noedit')).", ".$CORE->_e(array('add','71','flag_noedit'));
					echo $CORE->BUILD_FIELDS($field,$data); 
									  
				} break;
				case "3": {// CATEGORY SELECTION
					
					if($DISPLAYSTYLE == "small"){ $divif = 'stepblock3'; }else{ $divif = ''; }
					echo "<div class='".$divif."'>";				  
					
					$field[$o]['title'] 	= $CORE->_e(array('add','13'));
					$field[$o]['name'] 		= "category";
					$field[$o]['type'] 		= "category";
					$field[$o]['class'] 	= "form-control";
					if( isset($_POST['packageID']) &&  $GLOBALS['packagefields'][$_POST['packageID']]['multiple_cats'] == "1"   ){
					$field[$o]['multi'] 	= true;
					}
					// MAX CATEGORIES
					if(isset($GLOBALS['packagefields'][$_POST['packageID']]['multiple_cats_amount']) && is_numeric($GLOBALS['packagefields'][$_POST['packageID']]['multiple_cats_amount']) ){
					$field[$o]['max'] 	= $GLOBALS['packagefields'][$_POST['packageID']]['multiple_cats_amount'];
					}else{
					$field[$o]['max'] 	= 10;
					}
					echo $CORE->BUILD_FIELDS($field,$data); 
					
					echo "</div>";
				  
				} break;				  
				case "4": { // LISTING ATTACHMENTS
				  
					$field[$o]['title'] 	= "";
					$field[$o]['name'] 		= "image";
					$field[$o]['type'] 		= "image";
					$field[$o]['class'] 	= "form-control";
					if($GLOBALS['CORE_THEME']['require_image'] == 1){
					$field[$o]['required'] 	= true;
					}
					$field[$o]['ontop'] 	= true;
					$o++;				 
					echo $CORE->BUILD_FIELDS($field,$data); 
				  
				} break;				
				case "5": { // LISTING ATTRIBUTES			 
				 
				echo $CORE->BUILD_FIELDS(hook_add_fieldlist($field),$data);				
				echo $CORE->CORE_FIELDS(false,true); // CUSTOM FIELDS
				
				} break;
				
				case "6": { // GOOGLE MAP ?>
 
            <div id="showmapbox">
            
            <input name="custom[map_location]" id="form_map_location" class="controls" type="text" placeholder="<?php echo $CORE->_e(array('add','54','flag_noedit')); ?>" value="<?php if(isset($_GET['eid'])){ echo get_post_meta($_GET['eid'],'map_location',true); } ?>">
            <div id="wlt_map_location" style="height:300px;width:100%;"></div>
           
            <div class="well well-sm">
            <b><?php echo $CORE->_e(array('add','46')); ?></b>  
             <?php echo $CORE->_e(array('add','47')); ?>: <span id="wlt_dcountry" class="label label-primary"><?php if(isset($_GET['eid']) && get_post_meta($_GET['eid'],'map-country',true) != ""){ echo get_post_meta($_GET['eid'],'map-country',true); }else{ echo '<i class="glyphicon glyphicon-remove"></i>'; } ?></span> 
             <?php echo $CORE->_e(array('add','48')); ?>: <span id="wlt_dstate" class="label label-primary"><?php if(isset($_GET['eid']) && get_post_meta($_GET['eid'],'map-state',true) != ""){ echo get_post_meta($_GET['eid'],'map-state',true); }else{ echo '<i class="glyphicon glyphicon-remove"></i>'; } ?></span> 
             <?php echo $CORE->_e(array('add','49')); ?>: <span id="wlt_dcity" class="label label-primary"><?php if(isset($_GET['eid']) && get_post_meta($_GET['eid'],'map-city',true) != ""){ echo get_post_meta($_GET['eid'],'map-city',true); }else{ echo '<i class="glyphicon glyphicon-remove"></i>'; } ?></span>
             </div>
            </div> 
            
             <input type="hidden" id="map-long" name="custom[map-log]" <?php if(isset($_GET['eid'])){ echo 'value="'.get_post_meta($_GET['eid'],'map-log',true).'"'; } ?>>
             <input type="hidden" id="map-lat" name="custom[map-lat]" <?php if(isset($_GET['eid'])){ echo 'value="'.get_post_meta($_GET['eid'],'map-lat',true).'"'; } ?>> 
             <input type="hidden" id="map-country" name="custom[map-country]" <?php if(isset($_GET['eid'])){ echo 'value="'.get_post_meta($_GET['eid'],'map-country',true).'"'; } ?>>
             <input type="hidden" id="map-address1" name="custom[map-address1]" <?php if(isset($_GET['eid'])){ echo 'value="'.get_post_meta($_GET['eid'],'map-address1',true).'"'; } ?>>
             <input type="hidden" id="map-address2" name="custom[map-address2]" <?php if(isset($_GET['eid'])){ echo 'value="'.get_post_meta($_GET['eid'],'map-address2',true).'"'; } ?>>
             <input type="hidden" id="map-address3" name="custom[map-address3]" <?php if(isset($_GET['eid'])){ echo 'value="'.get_post_meta($_GET['eid'],'map-address3',true).'"'; } ?>>
             <input type="hidden" id="map-zip" name="custom[map-zip]" <?php if(isset($_GET['eid'])){ echo 'value="'.get_post_meta($_GET['eid'],'map-zip',true).'"'; } ?>>
             <input type="hidden" id="map-state" name="custom[map-state]" <?php if(isset($_GET['eid'])){ echo 'value="'.get_post_meta($_GET['eid'],'map-state',true).'"'; } ?>>
             <input type="hidden" id="map-city" name="custom[map-city]" <?php if(isset($_GET['eid'])){ echo 'value="'.get_post_meta($_GET['eid'],'map-city',true).'"'; } ?>>
 
          
          
<script type="text/javascript"> 

var geocoder;var map;var marker = ''; var markers = [];
	
function initialize() {

if(typeof(map) != "undefined"){ return; }
   
  // GET DEFAULT LOCATION
   <?php if(isset($_GET['eid']) && get_post_meta($_GET['eid'],'map-log',true) !=""){   
   $DF_LOCATON = get_post_meta($_GET['eid'],'map-lat',true).",".get_post_meta($_GET['eid'],'map-log',true);
   }else{
   $DF_LOCATON = $GLOBALS['CORE_THEME']['google_coords'];   
   }
   
   if($DF_LOCATON == ""){ $DF_LOCATON ="0,0"; }
   $DF_ZOOM = $GLOBALS['CORE_THEME']['google_zoom'];
   if($DF_ZOOM == ""){ $DF_ZOOM = "5"; }
   ?>
   
  // CREATE MAP CANVUS
  var myOptions = {mapTypeId: google.maps.MapTypeId.ROADMAP, zoomControl: true, scaleControl: true }
  map = new google.maps.Map(document.getElementById("wlt_map_location"), myOptions); 
     
  // LOAD MAP LOCATIONS
  var defaultBounds = new google.maps.LatLngBounds(
      new google.maps.LatLng(<?php echo $DF_LOCATON; ?>) );
   map.fitBounds(defaultBounds);

  // ADD ON MARKER
  <?php if(isset($_GET['eid']) && get_post_meta($_GET['eid'],'map-log',true) !=""){ ?>
  var marker = new google.maps.Marker({
  	position: new google.maps.LatLng(<?php echo get_post_meta($_GET['eid'],'map-lat',true); ?>,<?php echo get_post_meta($_GET['eid'],'map-log',true); ?>),
  	map: map,
  	animation: google.maps.Animation.DROP,	
	icon: new google.maps.MarkerImage('<?php echo get_template_directory_uri(); ?>/framework/img/map/icon.png'),			 
  });
  <?php } ?> 

  // ADD SEARCH BOX
  map.controls[google.maps.ControlPosition.TOP_LEFT].push(document.getElementById('form_map_location'));
  var searchBox = new google.maps.places.SearchBox(document.getElementById('form_map_location'));

  // EVENT
  google.maps.event.addListener(searchBox, 'places_changed', function() {
    var places = searchBox.getPlaces();

    if (places.length == 0) {
      return;
    }
    for (var i = 0, marker; marker = markers[i]; i++) {
      marker.setMap(null);
    }
	
    // For each place, get the icon, place name, and location. 
    var bounds = new google.maps.LatLngBounds();
    for (var i = 0, place; place = places[i]; i++) {
      var image = {
        url: place.icon,
        size: new google.maps.Size(71, 71),
        origin: new google.maps.Point(0, 0),
        anchor: new google.maps.Point(17, 34),
        scaledSize: new google.maps.Size(25, 25)
      }; 
	  

        addMarker(place.geometry.location);
	    document.getElementById("map-long").value = place.geometry.location.lng();	
    	document.getElementById("map-lat").value =  place.geometry.location.lat();
	    getMyAddress(place.geometry.location,true)

      bounds.extend(place.geometry.location);
    }

    map.fitBounds(bounds);	
	map.setZoom(12);	 
  });

  // EVENT
  google.maps.event.addListener(map, 'bounds_changed', function() {
    var bounds = map.getBounds();
    searchBox.setBounds(bounds);
	
  });
  
  // EVENT
  google.maps.event.addListener(map, 'click', function(event){			
  	document.getElementById("map-long").value = event.latLng.lng();	
    document.getElementById("map-lat").value =  event.latLng.lat();
    getMyAddress(event.latLng,"yes");	
    addMarker(event.latLng);
  });
  
  // DEFAULT ZOOM LEVEL
  var listener = google.maps.event.addListener(map, "idle", function() { 
	  if (map.getZoom() != <?php echo $DF_ZOOM; ?>){ map.setZoom(<?php echo $DF_ZOOM; ?>);  } 
	  google.maps.event.removeListener(listener); 
  });
  
} // END INIT


jQuery("#form_map_location").focusout(function() {
setTimeout(function(){  getMapLocation(jQuery("#form_map_location").val()); }, 500);


});

function getMapLocation(location){
                        document.getElementById("map-state").value = "";
                        var geocoder = new google.maps.Geocoder();
                            if (geocoder) {	geocoder.geocode({"address": location}, function(results, status) {	if (status == google.maps.GeocoderStatus.OK) {
						 	 
                            map.setCenter(results[0].geometry.location);
                            addMarker(results[0].geometry.location);
                            getMyAddress(results[0].geometry.location,"no");			
                            document.getElementById("map-long").value = results[0].geometry.location.lng();	
                            document.getElementById("map-lat").value =  results[0].geometry.location.lat();
                            map.setZoom(<?php $default_zoom = $GLOBALS['CORE_THEME']['google_zoom']; if($default_zoom == ""){ $default_zoom = "9"; } echo $default_zoom; ?>);		
                            }});}			
}

 function getMyAddress(location,setaddress){
                         
                        jQuery('#showmapbox').show();
                        google.maps.event.trigger(map, 'resize');
                        var geocoder = new google.maps.Geocoder();
                        var country = "";
                        if (geocoder) {geocoder.geocode({"latLng": location}, function(results, status) { if (status == google.maps.GeocoderStatus.OK) {
                        
                        for (var i = 0; i < results[0].address_components.length; i++) {
				
							  var addr = results[0].address_components[i];
							  //alert(addr.types[0]);
							  switch (addr.types[0]){
								
								case "street_number": {
									document.getElementById("map-address1").value = addr.long_name;
								} break;
								
								case "route": {
									document.getElementById("map-address2").value = addr.long_name;
								} break;
								
								case "locality": 
								//case "postal_town": 
								{
								 
									document.getElementById("map-address3").value = addr.long_name;
									document.getElementById("map-city").value = addr.long_name;
								} break;
								
								case "postal_code": {
									document.getElementById("map-zip").value = addr.short_name;
								} break;
								
								case "administrative_area_level_1": {								
									document.getElementById("map-state").value = addr.long_name;
								} break;
								
								case "administrative_area_level_2": {								
									document.getElementById("map-state").value = addr.long_name;
								} break;
								
								case "administrative_area_level_3": {								
									document.getElementById("map-state").value = document.getElementById("map-state").value + addr.long_name;
								} break;
								
								case "country": {
									document.getElementById("map-country").value = addr.short_name;	
								} break;						  
							  
							  } // end switch
						  
                		} // end for	
						
						// NOW SET THE DISPLAY VALUES
						jQuery('#wlt_dcity').html(document.getElementById("map-city").value);					
						jQuery('#wlt_dstate').html(document.getElementById("map-state").value);
             			jQuery('#wlt_dcountry').html(document.getElementById("map-country").value);
			 
                        if(setaddress == "yes"){
                        document.getElementById("form_map_location").value = results[0].formatted_address;
                        }
                        
                        map.setCenter(results[0].geometry.location);		
                        map.setZoom(15);	
                        
                        }		});	}} 
                        
                        
                        function addMarker(location) {
						if (marker=='') {	
						
						
						marker = new google.maps.Marker({	position: location, 	map: map, draggable:true,     animation: google.maps.Animation.DROP,	});
						
						
						google.maps.event.addListener (marker, 'dragend', function (event){
						document.getElementById("map-long").value = event.latLng.lng();	
                        document.getElementById("map-lat").value =  event.latLng.lat();
                        getMyAddress(event.latLng,"yes");	
                        addMarker(event.latLng);
						});
						
						
						}						
                        marker.setPosition(location);
						map.setCenter(location); 						
						}
 
<?php if($DISPLAYSTYLE == "small"){ ?>
// LOAD MAP BOX
jQuery(document).ready(function() {                         
 
		setTimeout(function(){  initialize(); }, 1000);
 
});
<?php }else{ ?>
// LOAD MAP BOX
jQuery(document).ready(function() {                         
	jQuery( ".mapboxlink" ).click(function() { 	 
		setTimeout(function(){  initialize(); }, 1000);
	});
});
<?php } ?>
</script>

 
             <?php  } break; 
 
			 
			 default: {
			 
			 hook_add_listdata($k);
			 
			 } break;
			  
			  } ?> 
              
</div>
<?php if($DISPLAYSTYLE == ""){ ?>
</div>
</div>
<?php } ?>

<!--- STEP <?php echo $k; ?> --->

<?php $i++; } ?>




<?php do_action('hook_add_form_abovebutton'); /* HOOK */ ?>  
 
 
 
<div class="savebuttonarea">

    <hr />
    
    <div id="enhancementscopy" style="display:none;"><div></div></div>
    
    <?php if(isset($_GET['eid'])){ $elink = get_permalink($_GET['eid']); }else{ $elink = $GLOBALS['CORE_THEME']['links']['add']; } ?>
    <a class="btn btn-default pull-right hidden-xs" href="<?php echo $elink; ?>"><?php echo $CORE->_e(array('button','8')); ?></a>
    <button class="btn btn-primary" type="submit" id="MainSaveBtn"><?php echo $CORE->_e(array('add','16')); ?></button>
    
    <div class="clearfix"></div>
    
    <hr />

</div>

</form> <!-- END STEPS FORM DATA -->

</div>







 

<?php 
 
if(isset($_GET['eid'])){ 
// GET EXISTING UPLOAD COUNT
$EXISTING_UPLOAD_COUNT = $CORE->UPLOADSPACE($_GET['eid']);
 

if(  
(isset($_GET['mediaonly']) && current_user_can( 'edit_user', $userdata->ID )) ||
( isset($_POST['packageID']) &&  ( $GLOBALS['packagefields'][$_POST['packageID']]['multiple_images'] == "1" || ( ( count($GLOBALS['packagefields']) == 0 || count($GLOBALS['packagefields']) == 1 ) && $GLOBALS['CORE_THEME']['default_submission_fileuploads'] > 0) )  ) || 
( !isset($_POST['packageID']) && $GLOBALS['CORE_THEME']['default_submission_fileuploads'] > 0 )   
){ 

 

// QUICK FIX FOR ADIN UPLOADING
if( isset($_GET['mediaonly']) && current_user_can( 'edit_user', $userdata->ID)  ){ $GLOBALS['default_upload_space'] = 100; }
// CHECK THE USER HASNT ALREADY UPLOADED 1 IMAGE AS PART OF THE DEFAULT UPLOAD FORM
if($GLOBALS['default_upload_space'] == 1 && $EXISTING_UPLOAD_COUNT == 0 && !isset($_GET['eid'])){ /* blank me */ }else{
?>
 
<?php do_action('hook_add_before_media'); ?> 

<div class="panel panel-default" id="mediauploadblock"> 
<div id="step<?php echo $i; ?>" class="stepblockmedia <?php if(isset($_GET['mediaonly'])){ echo "in"; } ?>"><div class="panel-body"> 

<h4><?php echo $CORE->_e(array('add','65')); ?> (<?php echo $EXISTING_UPLOAD_COUNT."/".$GLOBALS['default_upload_space']; ?>) </h4>

<hr>
 
 
        <?php } ?>
        
        <script>
		function ShowThisType(type){
		
			jQuery(this).addClass('active');
			
			jQuery('#mediatablelist .item').hide();
			if(type == "all"){
				jQuery('#mediatablelist .item').show();
			}else{
				jQuery('#mediatablelist .ftype_'+type).show();
			}
		}
		 jQuery(document).ready(function() { 
            ShowThisType('image');
			//jQuery('#iconbar li:eq(2) a').tab('show')
        });
		</script>
 

<form id="fileupload" action="<?php echo get_home_url(); ?>/index.php" method="POST" enctype="multipart/form-data">
       
	   <?php if($EXISTING_UPLOAD_COUNT <= $GLOBALS['default_upload_space']){ ?>
       
       <!-- MASS UPLOAD FILE PROGRESS BAR --->
       <div class="fileupload-progress fade" id="fileuploaddisplayall" style="display:none;">
                <div class="progress progress-success progress-striped active" role="progressbar" aria-valuemin="0" aria-valuemax="100">
                    <div class="bar progress-bar progress-bar-success" style="width:0%;"></div>
                </div>
                <div class="progress-extended">&nbsp;</div>
        <hr />
       </div>
        
       <!--- UPLOAD BUTTONS -->
       <div class="fileupload-loading"></div>
       <div class="fileupload-buttonbar">
           
                <button type="button" class="btn btn-info start pull-right"  onclick="jQuery('#fileuploaddisplayall').show();">
                    <i class="glyphicon glyphicon-upload glyphicon glyphicon-white"></i>
                    <span><?php echo $CORE->_e(array('add','19')); ?></span>
                </button>
            
                <!-- The fileinput-button span is used to style the file input field as button -->
                <span class="btn btn-success fileinput-button">
                    <i class="glyphicon glyphicon-plus glyphicon glyphicon-white"></i>
                    <span><?php echo $CORE->_e(array('add','18')); ?></span>
                    <input type="file" name="files[]" multiple >
                </span>
                
     <div class="clearfix"></div>        
     </div>
     
     <p><small><?php echo $CORE->_e(array('add','61')); ?></small></p>
     <hr />
     
     <?php } ?>
     
     <!-- EDIT MEDIA BOX --->
     <div class="editbox" id="editmediabox" style="display:none;">
        <div class="bs-callout bs-callout-success">
            <div class="pull-right">
                <div class="btn btn-default" onclick="jQuery('#editmediabox').hide();">

                    <i class="glyphicon glyphicon-remove icon-white"></i>
                </div>
            </div>
            
            <h4><?php echo $CORE->_e(array('add','88')); ?></h4>
        	<hr />
            <div id="editmediaboxcontent"></div>
          	            
        </div>
     </div>
     <!-- END EDIT MEDIA BOX --->
 
        <ul class="nav nav-tabs nav-justified" role="tablist">           
            <li role="presentation"><a href="#t1" onClick="ShowThisType('all');" class="c1" role="tab" data-toggle="tab"><i class="fa fa-files-o"></i> <?php echo $CORE->_e(array('add','89')); ?></a></li>        
            <li role="presentation"  class="active"><a href="#t1" onClick="ShowThisType('image');" class="c1" role="tab" data-toggle="tab"><i class="fa fa-file-image-o"></i> <?php echo $CORE->_e(array('add','90')); ?></a></li>
            
            <?php if(isset($GLOBALS['CORE_THEME']['allow_video']) && $GLOBALS['CORE_THEME']['allow_video'] == 1){ ?>            
            <li role="presentation"><a href="#t1" onClick="ShowThisType('video');" class="c2" role="tab" data-toggle="tab"><i class="fa fa-file-video-o"></i> <?php echo $CORE->_e(array('add','91')); ?></a></li>            
            <?php } ?>
            
            <?php if(isset($GLOBALS['CORE_THEME']['allow_audio']) && $GLOBALS['CORE_THEME']['allow_audio'] == 1){ ?>
            <li role="presentation"><a href="#t1" onClick="ShowThisType('audio');" class="c3" role="tab" data-toggle="tab"><i class="fa fa-file-sound-o"></i> <?php echo $CORE->_e(array('add','92')); ?></a></li>
            <?php } ?>
            
            <?php if(isset($GLOBALS['CORE_THEME']['allow_docs']) && $GLOBALS['CORE_THEME']['allow_docs'] == 1){ ?>
            <li role="presentation"><a href="#t1" onClick="ShowThisType('appli');" class="c4" role="tab" data-toggle="tab"><i class="fa fa-file-word-o"></i> <?php echo $CORE->_e(array('add','93')); ?></a></li>   
            <?php } ?>
             
        </ul>
       
        
        <div id="mediatablelist" class="files">
        <?php echo $CORE->UPLOAD_GET($_GET['eid'],1,"all"); ?>
        <div class="clearfix"></div>
        </div>
        
</form>
 
 
   
 </div><!-- end panel-body -->
 
</div></div>
<!-- END  PANEL  -->

<form method="post" action="<?php echo get_home_url(); ?>/index.php" target="core_delete_attachment_iframe" name="core_delete_attachment" id="core_delete_attachment">
<input type="hidden"  name="core_delete_attachment" value="gogo" />
<input type="hidden" id="attachement_id" name="attachement_id" value="" />
</form>
<iframe frameborder="0" style="display:none;" scrolling="auto" name="core_delete_attachment_iframe" id="core_delete_attachment_iframe"></iframe>
<!-- The template to display files available for upload -->
<script id="template-upload" type="text/x-tmpl">
{% for (var i=0, file; file=o.files[i]; i++) { %}
{% if (file.error) { %}
<div class="alert alert-danger"><b><?php echo $CORE->_e(array('add','22')); ?>:</b> {%=file.error%}
<button type="button" class="close" data-dismiss="alert" aria-label="Close">
  <span aria-hidden="true">&times;</span>
</button></div> 
{% } else { %}
<div class="uploaditem template-upload fade">
    <div class="col-md-3 preview">
        <span class="fade"></span>
    </div>
    <div class="col-md-6">  
	<span class="fname">{%=file.name%}</span>  
<div class="progress progress-success progress-striped active" role="progressbar" aria-valuemin="0" aria-valuemax="100" aria-valuenow="0">
<div class="bar progress-bar progress-bar-info" style="width:0%;"></div>
</div>
</div> 
<div class="col-md-3">    
{% if (!i) { %}
<span class="cancel">
            <button class="btn btn-danger">
                <i class="glyphicon glyphicon-remove glyphicon glyphicon-white"></i>              
            </button>
</span>
{% } %}        
{% if (!o.options.autoUpload) { %}
<span class="start">
                <button class="btn btn-success">
                    <i class="glyphicon glyphicon-upload glyphicon glyphicon-white"></i>
                    <span><?php echo $CORE->_e(array('add','20')); ?></span>
                </button>
</span>
{% } %}    
    </div>
<div class="clearfix"></div>	
</div>
{% } %}
{% } %}
</script>
<!-- The template to display files available for download -->
<script id="template-download" type="text/x-tmpl">
{% for (var i=0, file; file=o.files[i]; i++) { %}
{% if (file.error) { %}
<div class="alert alert-danger"><b><?php echo $CORE->_e(array('add','22')); ?>:</b> {%=file.error%}
<button type="button" class="close" data-dismiss="alert" aria-label="Close">
  <span aria-hidden="true">&times;</span>
</button></div> 
{% } else { %}
<div class="uploaditem template-download fade {%=file.aid%}bb">
<div class="col-md-3 preview">
<a href="{%=file.url%}" title="{%=file.name%}" rel="gallery" download="{%=file.name%}"><img src="{%=file.thumbnail_url%}"></a>
</div>
<div class="col-md-6">	 
<input type="text" value="{%=file.name%}" onchange="WLTSetImgText('<?php echo str_replace("http://","",get_home_url()); ?>', '{%=file.aid%}', this.value, 'core_ajax_callback');" class="form-input col-md-12" />
</div>
<div class="col-md-3">
	<span class="delete">
	<button class="btn btn-danger" data-type="{%=file.delete_type%}" data-url="{%=file.delete_url%}"{% if (file.delete_with_credentials) { %} data-xhr-fields='{"withCredentials":true}'{% } %}>
	<i class="glyphicon glyphicon-trash glyphicon glyphicon-white"></i>            
	</button>
	</span>
</div>
<div class="clearfix"></div>	
</div>
{% } %}
{% } %}
</script>
<script>
jQuery(function () {
    // Initialize the jQuery File Upload widget:
    jQuery('#fileupload').fileupload({
        url: '<?php echo get_home_url(); ?>/index.php',
		type: 'POST',
		paramName: 'core_attachments',
		fileTypes: '/^image\/(gif|jpeg|png)$/',
		formData: {  name: 'core_post_id', value: <?php echo $_GET['eid']; ?>   },
		maxNumberOfFiles: <?php echo $GLOBALS['default_upload_space']-$EXISTING_UPLOAD_COUNT; ?>
	 
    });	
	jQuery('#fileupload').bind('fileuploaddestroy', function (e, data) {
		document.getElementById('attachement_id').value= data.url;
		document.core_delete_attachment.submit();	
	});
 
});	
</script> 
<script src="<?php echo FRAMREWORK_URI; ?>js/up/vendor/jquery.ui.widget.js" type="text/javascript"></script>
<script src="<?php echo FRAMREWORK_URI; ?>js/up/tmpl.min.js" type="text/javascript"></script>
<script src="<?php echo FRAMREWORK_URI; ?>js/up/load-image.min.js" type="text/javascript"></script>
<script src="<?php echo FRAMREWORK_URI; ?>js/up/canvas-to-blob.min.js" type="text/javascript"></script>
<script src="<?php echo FRAMREWORK_URI; ?>js/up/jquery.iframe-transport.js" type="text/javascript"></script>
<script src="<?php echo FRAMREWORK_URI; ?>js/up/jquery.fileupload.js" type="text/javascript"></script>
<script src="<?php echo FRAMREWORK_URI; ?>js/up/jquery.fileupload-fp.js" type="text/javascript"></script>
<script src="<?php echo FRAMREWORK_URI; ?>js/up/jquery.fileupload-ui.js" type="text/javascript"></script>

<?php /*
<script src="<?php echo FRAMREWORK_URI; ?>js/up/main.js" type="text/javascript"></script>
*/ ?>

<!--[if gte IE 8]><script src="<?php echo FRAMREWORK_URI; ?>js/up/cors/jquery.xdr-transport.js"></script><![endif]--> 
<?php } }// end media box  ?>


 


<script type="application/javascript">

function colAll(){
jQuery('#step1').removeClass("in");
jQuery('#step2').removeClass("in");
jQuery('#step3').removeClass("in");
jQuery('#step4').removeClass("in");
jQuery('#step5').removeClass("in");
jQuery('#step6').removeClass("in");
}
function VALIDATE_FORM_DATA(){
 
 
// USER REGISTRATION VALIDATION
<?php if(!$userdata->ID){ ?>
var de4 	= document.getElementById("form_email");
if(de4.value == ''){
	alert('<?php echo $CORE->_e(array('validate','0')); ?>');
	de4.style.border = 'thin solid red';
	de4.focus();
	colAll(); jQuery('.stepblock1').collapse('show');
	return false;
}
if( !isValidEmail( de4.value ) ) {	
	alert('<?php echo $CORE->_e(array('validate','23')); ?>');
	de4.style.border = 'thin solid blue';
	de4.focus();
	colAll(); jQuery('.stepblock1').collapse('show');
	return false;
}
var de42 	= document.getElementById("form_new_username");
if(de42.value == ''){
	alert('<?php echo $CORE->_e(array('validate','0')); ?>');
	de42.style.border = 'thin solid red';
	de42.focus();
	colAll(); jQuery('.stepblock1').collapse('show');
	return false;
}

<?php } ?>

<?php  hook_tpl_add_field_validation(); ?>


<?php if(isset($GLOBALS['CORE_THEME']['listingcats']) && $GLOBALS['CORE_THEME']['listingcats'] == 1){ ?>
// CATEGORY SELECTION 
if(jQuery('.stepblock3').find(":checkbox:checked").length == 0){
	alert('<?php echo $CORE->_e(array('validate','29')); ?>'); 
	colAll(); jQuery('.stepblock3').collapse('show');
	return false;
}
<?php } ?>
 

// IMAGE UPLOADS
<?php if($GLOBALS['default_upload_space'] > 0 && $GLOBALS['CORE_THEME']['require_image'] == 1){ ?>
var de1 	= document.getElementById("fileupload");
if(de1.value == ''){
	alert('<?php echo $CORE->_e(array('validate','27')); ?>');
	de1.style.border = 'thin solid red';
	de1.focus();
	<?php if(isset($_GET['eid'])){ ?>
	colAll(); jQuery('.stepblockmedia').collapse('show');
	<?php }else{ ?>
	colAll(); jQuery('.stepblock4').collapse('show');
	<?php } ?>
	return false;
} 
<?php } ?>

// LISTING DESCRIPTION VALIDATION
var de1 	= document.getElementById("form_post_title");
if(de1.value == ''){
	alert('<?php echo $CORE->_e(array('validate','0')); ?>');
	de1.style.border = 'thin solid red';
	de1.focus();
	colAll(); jQuery('.stepblock2').collapse('show');
	return false;
}

// MIN CHARACTERS FOR LISTING LENGHT
<?php if( (isset($_GET['eid']) && get_post_meta($_GET['eid'],'html',true) == "yes" ) || ( isset($_POST['packageID']) && isset($GLOBALS['packagefields'][$_POST['packageID']]['enhancement']) && isset($GLOBALS['packagefields'][$_POST['packageID']]['enhancement']['3']) && $GLOBALS['packagefields'][$_POST['packageID']]['enhancement']['3'] == 1 ) ){ ?>

<?php }else{ ?>
var de3 = document.getElementById("form_post_content");

if(jQuery("#form_post_content").val().length < <?php echo $GLOBALS['CORE_THEME']['descmin']; ?>){
	alert('<?php echo $CORE->_e(array('validate','28')); ?>');
	de3.style.border = 'thin solid red';
	de3.focus();
	colAll(); jQuery('.stepblock2').collapse('show');
	return false;
}
if(de3.value == ''){
	alert('<?php echo $CORE->_e(array('validate','0')); ?>');
	de3.style.border = 'thin solid red';
	de3.focus();
	colAll(); jQuery('.stepblock2').collapse('show');
	return false;
}
<?php } ?>
<?php 

/*** GOOGLE MAP ***/

if(isset($GLOBALS['CORE_THEME']['google_required']) && $GLOBALS['CORE_THEME']['google_required'] == 1){ ?> 

// CHECK IF THE COUNTRY FORM HAS A VALUE LONG/LATE VALUE
//if(document.getElementById("map-long").value == ""){
//getMapLocation(jQuery('#form_map_location').val());
// return false;
//}

var de4 	= document.getElementById("form_map_location");
if(de4.value == ''){
alert('<?php echo $CORE->_e(array('add','51')); ?>');
de4.style.border = 'thin solid red';
colAll(); jQuery('.stepblock6').collapse('show');
initialize();
return false;
}
<?php } ?>



// GET THE ENHANCEMENT FORM DATA
var newform2 = jQuery('#enhancementsblock .checkbox').clone(); //Clone form 1
jQuery('#enhancementscopy div').replaceWith(newform2);

jQuery('html,body').scrollTop(0);

// VALIDATE CUSTOM FIELDS
var formresult = ValidateCoreRegFields();  
if(formresult == false){
return false;
}

// LOAD IN DISPLAY UNIT
jQuery('#wlt_stepswizard').hide();
jQuery('#mediauploadblock').hide();
jQuery('#core_saving_wrapper').show();
 
}
</script> 


<script type="text/javascript" src="<?php echo FRAMREWORK_URI; ?>js/up/nicEdit.js"></script>
<?php if( (isset($_GET['eid']) && get_post_meta($_GET['eid'],'html',true) == "yes" ) || ( isset($_POST['packageID']) && isset($GLOBALS['packagefields'][$_POST['packageID']]['enhancement']) && isset($GLOBALS['packagefields'][$_POST['packageID']]['enhancement']['3']) && $GLOBALS['packagefields'][$_POST['packageID']]['enhancement']['3'] == 1) ){ ?>
<script type="application/javascript">
 jQuery(document).ready(function() { toggleHTML(); });
</script>
<?php } ?> 

 
<script type="application/javascript">
 
function listingenhancement(id,price){
  	
	// DISABLE CHECK
	jQuery("#"+id).attr("disabled", true);
	
	// ADD CHECK CLASS
	jQuery("."+id+'_b').toggleClass("sel");
	
	// CURRENT PRICE
	var current_amount_total = jQuery("#listingprice").text();	
	 
	var current_amount_total = current_amount_total.replace(".00", "");
	//var current_amount_total = current_amount_total.replace(".", "");
	var current_amount_total = current_amount_total.replace(",", "");
	
	// WORK OUT PRICES
	if(document.getElementById(id).checked == true){
		newtotal = parseFloat(current_amount_total)+price;
	}else{
		newtotal = parseFloat(current_amount_total)-price;
	}
	newtotal = Math.round(newtotal*100)/100;
	newtotal = newtotal.toFixed(2);	
	jQuery("#listingprice").text(newtotal);
	
		 
	if(id == 'exh3'){	 	
		toggleHTML();
	}
	
	// REMOVE DISABLE
	setTimeout(function(){ jQuery("#"+id).removeAttr("disabled");   }, 1000);	 
	 

}
 var area1, htmlenabled;
 function toggleHTML() {

        if(!area1) {
		
			area1 = new nicEditor({ buttonList : ['bold','italic',
'underline',
'left',
'center',
'right',
'justify',
'ol',
'ul',
'strikethrough',
'removeformat',
'indent',
'outdent',
'hr',
'image',
'forecolor',
'bgcolor',
'link' ,
'unlink' ,
'fontSize', 
'fontFamily', 
'fontFormat']}).panelInstance('form_post_content',{hasPanel : true});

htmlenabled = true;
	

 
        } else {
            // REMOVE
			area1.removeInstance('form_post_content');
            area1 = null;
						
			// STRIP HTML TAGS
			var html = jQuery("#form_post_content").text();
			var div = document.createElement("div");
			jQuery("#form_post_content").innerHTML = div;
						
        }
  	}  
	

jQuery(document).ready(function(){

    jQuery('.astep2, .astep1').live('click', function(e) {	
        	if(htmlenabled) { toggleHTML(); toggleHTML(); } 
    });
});
	
</script>

<script type="application/javascript">jQuery('video,audio').mediaelementplayer({audioWidth: 150});</script>



 



<!-- SAVING SPINNER -->
<div id="core_saving_wrapper" style="display:none;">
<div class="alert alert-warning">
<img src="<?php echo THEME_URI; ?>/framework/img/loading.gif" style="float:left; padding-right:30px;width:80px;" />
<h1 style="padding-top:0px;margin-top:0px;"><?php echo $CORE->_e(array('add','29')); ?></h1>
<p><?php echo $CORE->_e(array('add','30')); ?></p>
<div class="clearfix"></div>
</div>
</div>



<?php if(isset($_GET['eid'])){   ?>
<form action="<?php echo $GLOBALS['CORE_THEME']['links']['add']; ?>?eid=<?php echo $_GET['eid']; ?>" method="post" name="renewalfree" id="renewalfree">
<input type="hidden" value="renewalfree" name="action"><input type="hidden" value="<?php echo $_GET['eid']; ?>" name="pid">
</form>

<?php $can_show_hitcounter = get_post_meta($_GET['eid'],'visitorcounter',true); if($can_show_hitcounter == "yes"){ ?>
<hr />
<?php echo do_shortcode('[VISITORCHART postid="'.$_GET['eid'].'"]'); ?>
<?php  } } ?>