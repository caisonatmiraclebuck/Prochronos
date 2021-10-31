<?php

class PT_Iframe extends PT_Shortcode{
	
	public $icon = '<span class="fa fa-unsorted fa-rotate-90"></span>';
	public $name = 'Iframe';
	public $description = 'Add iframe element to the page';
	public $category = 'MISC';
	public $image;
	public $default_options = array(
		'link' => '',
		'ratio' => '',
		'element_name' => 'Iframe',
		'extra_class' => ''
	);		

	function __construct(){
		parent::__construct();
	}
	

	public function shortcode_frontend( $atts, $content ){
		extract( shortcode_atts( $this->default_options, $atts ) );
		return '<div class="embed-responsive embed-responsive-'.esc_attr($ratio).' '.esc_attr($extra_class).'">
                    <iframe class="embed-responsive-item" src="'.esc_url($link).'"></iframe>
                </div>';
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
				'id' => 'link',
				'title' => __( 'Link To Embed', 'pt-builder' ),
				'desc' => __( 'Input link which will be embeded.', 'pt-builder' ),
				'type' => 'textfield',
				'value' => $link
			),
			array(
				'id' => 'ratio',
				'title' => __( 'Aspect Ratio', 'pt-builder' ),
				'desc' => __( 'Select iframe aspect ratio.', 'pt-builder' ),
				'type' => 'select',
				'options' => array(
					'4by3' => __( '4:3', 'pt-builder' ),
					'16by9' => __( '16:9', 'pt-builder' )
				),
				'value' => $ratio
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