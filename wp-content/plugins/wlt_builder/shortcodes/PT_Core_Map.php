<?php

class PT_Core_Map extends PT_Shortcode{
	
	public $icon = '<span class="fa fa-map-marker"></span>';
	public $name = 'Google Map';
	public $description = 'Add a Google map block to the page';
	public $category = '7. Maps';
	public $image;
	public $default_options = array(
		'element_name' => 'Google Map',
 		'height' => '500px',
		'address' => '',
		'zoom' => '10',
	);		

	function __construct(){
	
		$this->image  = PT_URL."/assets/images/admin/icon/map.jpg";
		parent::__construct();
	}
	

	public function shortcode_frontend( $atts, $content ){
		extract( shortcode_atts( $this->default_options, $atts ) );
		
		global $CORE;
		
		// UNIQUE ID
		$ranid 		= rand();
		
		// MAP DEFAULTS
		$defaults = $CORE->wlt_google_getdefaults(); 

		ob_start();
		?> 
        
        <?php if(strlen($address) > 1){ 
		
		
		wp_enqueue_script( 'googlemap', 'https://maps.googleapis.com/maps/api/js?v=3.exp&signed_in=true&libraries=places&key='.trim(stripslashes($GLOBALS['CORE_THEME']['googlemap_apikey'])) );
		
		?>
        
		 
        <script> 
        
        function initializeMapWidget<?php echo $ranid; ?>() {
		
          geocoder = new google.maps.Geocoder();
          var latlng = new google.maps.LatLng(0,0);
        
          map<?php echo $ranid; ?> = new google.maps.Map(document.getElementById('wlt_builder_singlemap_<?php echo $ranid; ?>'), { zoom: <?php echo $zoom; ?>, center: latlng });
          
          geocoder.geocode( { 'address': '<?php echo $address; ?>'}, function(results, status) {
            if (status == google.maps.GeocoderStatus.OK) {
              map<?php echo $ranid; ?>.setCenter(results[0].geometry.location);
              var marker = new google.maps.Marker({
                  map: map<?php echo $ranid; ?>,
                  position: results[0].geometry.location
              });
            } else {
              alert('Geocode was not successful for the following reason: ' + status);
            }
			
          });
		  
        } 
        
        jQuery( document ).ready(function() { initializeMapWidget<?php echo $ranid; ?>(); });
         
         </script>
         <div id="wlt_builder_singlemap_<?php echo $ranid; ?>" style="min-height:<?php echo $height; ?>; width:100%"></div>
        
        <?php }else{ ?>
        
        <style>
		#wlt_google_map { min-height:<?php echo $height; ?> }
		</style>
        <?php echo $CORE->wlt_googlemap_html(true); ?>
       
        
        <script> 
        jQuery(document).ready(function() { 
            loadGoogleMapsApi(); 
        });
        var wlt_map_options = [{
            l: "<?php echo home_url(); ?>/",
            path: "<?php echo get_template_directory_uri(); ?>", 
            id: "wlt_google_map", 
            region: "<?php echo $defaults['region']; ?>", 
            lang: "<?php echo $defaults['lang'] ?>", 
            long: <?php echo $defaults['long']; ?>, 
            lat: <?php echo $defaults['lat']; ?>, 	
            zoom: <?php echo $zoom ?>,
            data: "",
            mapicon: "map-icon"
        }];
        
        </script>
		<input type="hidden" value="<?php echo trim(stripslashes($GLOBALS['CORE_THEME']['googlemap_apikey'])); ?>" id="newgooglemapsapikey" />
        <?php } ?>
        
		<?php
		return ob_get_clean();
 
	}

	public function shortcode_options( $atts ){
		extract( shortcode_atts( $this->default_options, $atts ) );
		$options = array(
			array(
				'id' => 'element_name',
				'title' => __( 'Element Name', 'pt-builder' ),
				'desc' => __( 'Input custom element name for easy recognition.', 'pt-builder' ),
				'type' => 'textfield',
				'value' => $element_name
			),	
		 array(
				'id' => 'height',
				'title' => __( 'Min Display Height', 'pt-builder' ),
				'desc' => __( 'Input a value for the map display height.', 'pt-builder' ),
				'type' => 'textfield',
				'value' => $height
			),	
			
		 array(
				'id' => 'address',
				'title' => __( 'Fixed Address', 'pt-builder' ),
				'desc' => __( 'Enter an address only if you want the map to display this location only.', 'pt-builder' ),
				'type' => 'textfield',
				'value' => $address
			),
				
		 array(
				'id' => 'zoom',
				'title' => __( 'Zoom Level', 'pt-builder' ),
				'desc' => __( 'Enter a value between 1 - 20.', 'pt-builder' ),
				'type' => 'textfield',
				'value' => $zoom
			),			 
		);
		
		$options_html = new PT_Options( $options );
		
		return $options_html->get_options();
	}	
}

?>