<?php

class PT_Text extends PT_Shortcode{
	
	public $icon = '<span class="fa fa-file-text-o"></span>';
	public $name = 'Blank Text Box';
	public $description = 'Add text block to the page';
	public $category = '3. Text';
	public $image;
	public $default_options = array(
		'element_name' => 'Text',
		'extra_class' => ''
	);		

	function __construct(){
		parent::__construct();
	}
	

	public function shortcode_frontend( $atts, $content ){
		extract( shortcode_atts( $this->default_options, $atts ) );

		return '<div class="'.esc_attr($extra_class).'">'.apply_filters( 'the_content', $content ).'</div>';
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
				'id' => 'pt_content',
				'title' => __( 'Text', 'pt-builder' ),
				'desc' => __( 'Write the text here.', 'pt-builder' ),
				'type' => 'editor',
				'value' => $atts['pt_content']
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