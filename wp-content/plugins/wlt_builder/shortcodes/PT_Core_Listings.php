<?php

class PT_Core_Listings extends PT_Shortcode{
	
	public $icon = '<span class="fa fa-sort-amount-desc"></span>';
	public $name = 'Listing';
	public $description = 'Add a listing block to the page';
	public $category = '8. Dynamic Content';
	public $image;
	public $default_options = array(
		'element_name' 	=> 'Listings',
		'type' 			=> 'listing_type',
		'style' 		=> 'list',
		'nav' 			=> 0,
		'num' 			=> 10,
		'item_class' 	=> 'col-md-4 col-sm-6 col-xs-12',
		'extra_class'	=> '',
		'query'	=> ''
	);		

	function __construct(){
		parent::__construct();
	}
	

	public function shortcode_frontend( $atts, $content ){
		extract( shortcode_atts( $this->default_options, $atts ) );

		// UNIQUE ID
		$ranid 		= rand();
		
		
		// ITEM CLASS
		$GLOBALS['item_class_size'] = $item_class;
		
		ob_start();
		?>
        
		<div class=" wlt_search_results <?php echo $style; ?>_style wlt_builder_listings">
		<?php 
		
		if(strlen($query) > 1){
		echo do_shortcode('[LISTINGS dataonly=1 nav='.$nav.' query="'.$query.'&post_type='.$type.'&posts_per_page='.$num.'"]');
		}else{
		
			if($type == "post"){
				echo do_shortcode('[LISTINGS dataonly=1 nav='.$nav.' show='.$num.' type="post"]');
			}else{
				echo do_shortcode('[LISTINGS dataonly=1 nav='.$nav.' show='.$num.']');
			}
				
		}
		
		 ?> 
		</div><div class="clearfix"></div>
		<?php
		unset($GLOBALS['item_class_size']);
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
				'id' => 'type',
				'title' => __( 'Display Content', 'pt-builder' ),
				'desc' => __( 'Select which content to display;', 'pt-builder' ),
				'type' => 'select',
				'options' => array(
					'listing_type' => "Website Listings",
					'post' => "Blog Posts",
				),
				'value' => $type
			),	
	 
			array(
				'id' => 'style',
				'title' => __( 'Display Style', 'pt-builder' ),
				'desc' => __( 'Select which style to display;', 'pt-builder' ),
				'type' => 'select',
				'options' => array(
					'list' => "List Style",
					'grid' => "Grid Style",
				),
				'value' => $style
			),	
			
			array(
				'id' => 'nav',
				'title' => __( 'Navigation', 'pt-builder' ),
				'desc' => __( 'Display page navigation?', 'pt-builder' ),
				'type' => 'select',
				'options' => array(
					1 => "Yes",
					0 => "No",
				),
				'value' => $nav
			),	
			
			array(
				'id' => 'num',
				'title' => __( 'Show #', 'pt-builder' ),
				'desc' => __( 'Enter a numerical value for the amount to display.', 'pt-builder' ),
				'type' => 'textfield',
				'value' => $num
			),	
			
			array(
				'id' => 'query',
				'title' => __( 'Query (<a href="http://www.premiumpress.com/docs/#QUERIES" target="_blank">sample queries</a>)', 'pt-builder' ),
				'desc' => __( 'Input your own WP query string.', 'pt-builder' ),
				'type' => 'textfield',
				'value' => $query
			),	
			array(
				'id' => 'item_class',
				'title' => __( 'Item Class', 'pt-builder' ),
				'desc' => __( 'Input class style for the item.', 'pt-builder' ),
				'type' => 'textfield',
				'value' => $item_class
			),	
			array(
				'id' => 'extra_class',
				'title' => __( 'Extra Class', 'pt-builder' ),
				'desc' => __( 'Input extra class for the element.', 'pt-builder' ),
				'type' => 'textfield',
				'value' => $extra_class
			),			
		);
		
		$options_html = new PT_Options( $options );
		
		return $options_html->get_options();
	}	
}

?>