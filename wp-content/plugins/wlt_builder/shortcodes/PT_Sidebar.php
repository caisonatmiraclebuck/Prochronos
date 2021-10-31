<?php

class PT_Sidebar extends PT_Shortcode{
	
	public $icon = '<span class="fa fa-pause"></span>';
	public $name = 'Sidebar';
	public $description = 'Add sidebar to the page';
	public $category = 'MISC';
	public $image;
	public $default_options = array(
		'sidebar' => '',
		'element_name' => 'Sidebar',
		'extra_class' => ''
	);		

	function __construct(){
		parent::__construct();
	}
	

	public function shortcode_frontend( $atts, $content ){
		extract( shortcode_atts( $this->default_options, $atts ) );
		ob_start();
		dynamic_sidebar( $sidebar );
		$sidebar_html = ob_get_contents();
		ob_end_clean();
		return '<div class="'.esc_attr($extra_class).'">'.$sidebar_html.'</div>';
	}

	public function get_sidebars(){
		global $GLOBALS;
		$list = array();

		foreach ( $GLOBALS['wp_registered_sidebars'] as $sidebar ) {
			$list[$sidebar['id']] = $sidebar['name'];
		}

		return $list;
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
				'id' => 'sidebar',
				'title' => __( 'Sidebar', 'pt-builder' ),
				'desc' => __( 'Select which sidebar you want to add.', 'pt-builder' ),
				'type' => 'select',
				'options' => $this->get_sidebars(),
				'value' => $sidebar
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