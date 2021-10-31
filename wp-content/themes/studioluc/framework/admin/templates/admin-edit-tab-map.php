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
$core_admin_values = get_option("core_admin_values"); 

$MYLOCATION = "";
if(isset($_GET['eid'])){
$MYLOCATION = get_post_meta($_GET['eid'],'map_location',true);
}
  
?> 
<div style='font-weight:bold; padding:10px; padding-left:0px; border-bottom:1px solid #ddd; color:#666; margin-top:10px;margin-bottom:10px;'>Map Location </div>     
    
    <div id="wlt_map_location" style="height:300px;width:100%;"></div>
    <input type="text" onchange="getMapLocation(this.value);" style="width:100%;" name="wlt_field[map_location]" id="form_map_location" class="long" tabindex="14" value="<?php echo $MYLOCATION; ?>">
 <input type="hidden" id="map-long" name="wlt_field[map-log]" value="<?php echo get_post_meta($_GET['eid'],'map-log',true); ?>">
 <input type="hidden" id="map-lat" name="wlt_field[map-lat]"  value="<?php echo get_post_meta($_GET['eid'],'map-lat',true); ?>"> 
 <input type="hidden" id="map-country" name="wlt_field[map-country]"  value="<?php echo get_post_meta($_GET['eid'],'map-country',true); ?>">
 <input type="hidden" id="map-address1" name="wlt_field[map-address1]"  value="<?php echo get_post_meta($_GET['eid'],'map-address1',true); ?>">
 <input type="hidden" id="map-address2" name="wlt_field[map-address2]"  value="<?php echo get_post_meta($_GET['eid'],'map-address2',true); ?>">
 <input type="hidden" id="map-address3" name="wlt_field[map-address3]"  value="<?php echo get_post_meta($_GET['eid'],'map-address3',true); ?>">
 <input type="hidden" id="map-zip" name="wlt_field[map-zip]"  value="<?php echo get_post_meta($_GET['eid'],'map-zip',true); ?>">
  <input type="hidden" id="map-state" name="wlt_field[map-state]"  value="<?php echo get_post_meta($_GET['eid'],'map-state',true); ?>">
 <input type="hidden" id="map-city" name="wlt_field[map-city]"  value="<?php echo get_post_meta($_GET['eid'],'map-city',true); ?>">
 
<script type="text/javascript"> 
var geocoder;var map;var marker = '';   var markerArray = [];    

function loadGoogleMapsApi(){
    if(typeof googlemap === "undefined"){
        var script = document.createElement("script");
        script.src = "https://maps.google.com/maps/api/js?callback=loadWLTGoogleMapsApiReady&key=<?php echo trim(stripslashes($core_admin_values['googlemap_apikey'])); ?>";
        document.getElementsByTagName("head")[0].appendChild(script);				
    } else {
        loadWLTGoogleMapsApiReady();
    }
}
function loadWLTGoogleMapsApiReady(){ 
	jQuery("body").trigger("gmap_loaded"); 
}
jQuery("body").bind("gmap_loaded", function(){

			<?php if(isset($_GET['eid']) && get_post_meta($_GET['eid'],'map-log',true) !=""){ ?>
			var myLatlng = new google.maps.LatLng(<?php echo get_post_meta($_GET['eid'],'map-lat',true); ?>,<?php echo get_post_meta($_GET['eid'],'map-log',true); ?>);
			var myOptions = { zoom: 8,  center: myLatlng,  mapTypeId: google.maps.MapTypeId.ROADMAP}
			
			<?php }else{ ?>
			var myLatlng = new google.maps.LatLng(0,0);
			var myOptions = { zoom: 1,  center: myLatlng,  mapTypeId: google.maps.MapTypeId.ROADMAP}
			<?php } ?>
			 
			
            map = new google.maps.Map(document.getElementById("wlt_map_location"), myOptions);
			<?php if(isset($_GET['eid']) && get_post_meta($_GET['eid'],'map-log',true) !=""){ ?>
			var marker = new google.maps.Marker({
					position: myLatlng,
					map: map				 
				});
			markerArray.push(marker);
			<?php } ?>
			
			google.maps.event.addListener(map, 'click', function(event){			
				document.getElementById("map-long").value = event.latLng.lng();	
				document.getElementById("map-lat").value =  event.latLng.lat();
				getMyAddress(event.latLng);	
				addMarker(event.latLng);			
			});

});
function addMarker(location) {

	jQuery(markerArray).each(function(id, marker) {	
        marker.setVisible(false);
    });
	
	marker = new google.maps.Marker({	position: location, 	map: map,	});
	markerArray.push(marker);
	map.panTo(marker.position); 
	map.setCenter(location);  
}	
function getMapLocation(location){
 
			document.getElementById("map-state").value = "";
			var geocoder = new google.maps.Geocoder();if (geocoder) {	geocoder.geocode({"address": location}, function(results, status) {	if (status == google.maps.GeocoderStatus.OK) {
		 
			map.setCenter(results[0].geometry.location);
			addMarker(results[0].geometry.location);
			getMyAddress(results[0].geometry.location,"no");		
			document.getElementById("map-long").value = results[0].geometry.location.lng();	
			document.getElementById("map-lat").value =  results[0].geometry.location.lat();
			map.setZoom(9);		
			}});}
			
}
function getMyAddress(location){var geocoder = new google.maps.Geocoder();if (geocoder) {geocoder.geocode({"latLng": location}, function(results, status) { 

	if (status == google.maps.GeocoderStatus.OK) {
			 
				for (var i = 0; i < results[0].address_components.length; i++) {
				
                          var addr = results[0].address_components[i];
						   
						  switch (addr.types[0]){
						  	
							case "street_number": {
								document.getElementById("map-address1").value = addr.long_name;
							} break;
							
							case "route": {
								document.getElementById("map-address2").value = addr.long_name;
							} break;
							
							case "locality": 
							case "postal_town": 
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
				 
			
			// document.getElementById("form_map_location").value = results[0].formatted_address;
			map.setCenter(results[0].geometry.location);
			}
});	}}

</script>