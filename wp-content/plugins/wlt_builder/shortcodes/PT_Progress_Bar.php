<?php

class PT_Progress_Bar extends PT_Shortcode{
	
	public $icon = '<span class="fa fa-tasks"></span>';
	public $name = 'Progress Bar';
	public $description = 'Add progress bar element to the page';
	public $category = 'MISC';
	public $image;
	public $default_options = array(
		'color' => '',
		'style' => '',
		'value' => '',
		'label' => '',
		'element_name' => 'Progress Bar',
		'extra_class' => ''
	);		

	function __construct(){
		parent::__construct();
	}
	

	public function shortcode_frontend( $atts, $content ){
		extract( shortcode_atts( $this->default_options, $atts ) );
		return '<div class="progress '.esc_attr($extra_class).'">
                    <div class="progress-bar '.esc_attr($style).'" role="progressbar" aria-valuenow="'.esc_attr($value).'" aria-valuemin="0" aria-valuemax="100" style="width: '.esc_attr($value).'%; background-color: '.esc_attr($color).';">
                        '.$label.'
                    </div>
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
				'id' => 'color',
				'title' => __( 'Progress Bar Color', 'pt-builder' ),
				'desc' => __( 'Select progressbar color.', 'pt-builder' ),
				'type' => 'colorpicker',
				'value' => $color
			),
			array(
				'id' => 'style',
				'title' => __( 'Progress Bar Style', 'pt-builder' ),
				'desc' => __( 'Select progressbar style.', 'pt-builder' ),
				'type' => 'select',
				'options' => array(
					'' => __( 'No Stripes', 'pt-builder' ),
					'progress-bar-striped' => __( 'Stripes', 'pt-builder' ),
					'progress-bar-striped active' => __( 'Active Stripes', 'pt-builder' )
				),
				'value' => $style
			),
			array(
				'id' => 'label',
				'title' => __( 'Progress Bar Label', 'pt-builder' ),
				'desc' => __( 'Input label for the progressbar.', 'pt-builder' ),
				'type' => 'textfield',
				'value' => $label
			),
			array(
				'id' => 'value',
				'title' => __( 'Progressbar Value', 'pt-builder' ),
				'desc' => __( 'Input progress bar value in percentages.', 'pt-builder' ),
				'type' => 'textfield',
				'value' => $value
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