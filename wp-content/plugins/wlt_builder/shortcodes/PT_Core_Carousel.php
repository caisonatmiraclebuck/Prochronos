<?php

class PT_Core_Carousel extends PT_Shortcode{
	
	public $icon = '<span class="fa fa-rotate-right"></span>';
	public $name = 'Carousel';
	public $description = 'Add a carousel block to the page';
	public $category = '8. Dynamic Content';
	public $image;
	public $default_options = array(
		'element_name' => 'Carousel',
		'arrows' => 'no',
		'perrow' => '4',
		'query' => '',
	);		

	function __construct(){
		
		$this->image  = PT_URL."/assets/images/admin/icon/carousel.jpg";
		parent::__construct();
	}
	

	public function shortcode_frontend( $atts, $content ){
		extract( shortcode_atts( $this->default_options, $atts ) );
	 	
		// UNIQUE ID
		$ranid 		= rand();

		ob_start();
		?>
        
		<div class="owl-carousel<?php echo $ranid; ?> wlt_search_results grid_style wlt_builder_carousel">
		<?php echo do_shortcode('[LISTINGS dataonly=1 show=10 query="'.$query.'"]'); ?> 
		</div>
		
		<script> 
		jQuery(document).ready(function() { 	 
			jQuery(".owl-carousel<?php echo $ranid; ?>").owlCarousel({ items : <?php echo $perrow; ?>, autoPlay : true, <?php if($arrows == "yes"){ ?>
			navigation:true,  navigationText: [
			  "<i class='icon-chevron-left icon-white'><</i>",
			  "<i class='icon-chevron-right icon-white'>></i>"
			  ], <?php } ?>});   
		});
		</script> 
				
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
				'id' => 'perrow',
				'title' => __( 'Items Per Row', 'pt-builder' ),
				'desc' => __( 'Show or hide image captions.', 'pt-builder' ),
				'type' => 'select',
				'options' => array(
					'2' => 2,
					'3' => 3,
					'4' => 4,
					'5' => 5,
				),
				'value' => $perrow
			),	
			
			array(
				'id' => 'arrows',
				'title' => __( 'Display Arrows', 'pt-builder' ),
				'desc' => __( 'Show or hide carousel navigation.', 'pt-builder' ),
				'type' => 'select',
				'options' => array(
					'yes' => "Yes",
					'no' => "No",
				),
				'value' => $arrows
			),	
			array(
				'id' => 'query',
				'title' => __( 'Query (<a href="http://www.premiumpress.com/docs/#QUERIES" target="_blank">sample queries</a>)', 'pt-builder' ),
				'desc' => __( 'Input custom query for carousel data.', 'pt-builder' ),
				'type' => 'textfield',
				'value' => $query
			),			
		);
		
		$options_html = new PT_Options( $options );
		
		return $options_html->get_options();
	}	
}

?>