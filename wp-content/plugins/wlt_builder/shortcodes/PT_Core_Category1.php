<?php

class PT_Core_Category1 extends PT_Shortcode{
	
	public $icon = '<span class="fa fa-sitemap"></span>';
	public $name = 'Category Style 1';
	public $description = 'Add a category block to the page';
	public $category = '4. Category';
	public $image;
	public $default_options = array(
		'element_name' => 'Category Style 1', 
		 
		'show' => '9',
	 
	);		

	function __construct(){
	
		$this->image  = PT_URL."/assets/images/admin/icon/category1.jpg";
		parent::__construct();
	}
	

	public function shortcode_frontend( $atts, $content ){
		extract( shortcode_atts( $this->default_options, $atts ) );
	 	
		// UNIQUE ID
		$ranid 		= rand();
		ob_start();
	 	?>
        
		<?php echo do_shortcode('[D_CATEGORIES limit='.$show.']'); ?> 
        
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
				'id' => 'show',
				'title' => __( 'Display #', 'pt-builder' ),
				'desc' => __( 'Enter a numerical value for the number of categories to show.', 'pt-builder' ),
				'type' => 'textfield',
				 
				'value' => $show
			),	
		 		
		);
		
		$options_html = new PT_Options( $options );
		
		return $options_html->get_options();
	}	
}

?>