<?php

class PT_Accordion extends PT_Shortcode{
	
	public $icon = '<span class="fa fa-bars"></span>';
	public $name = 'Accordion';
	public $description = 'Add accordion element to the page';
	public $category = 'MISC';
	public $image;
	public $default_options = array(
		'titles' => '',
		'element_name' => 'Accordion',
		'extra_class' => ''
	);	

	function __construct(){
		parent::__construct();
	}
	

	public function shortcode_frontend( $atts, $content ){
		extract( shortcode_atts( $this->default_options, $atts ) );

		$titles = explode( "/n/", $titles );
		$content = explode( "/next/", $content );
		$random_string = pt_random_string();
		$html = '';
		if( !empty( $titles ) ){
			$html = '<div class="panel-group '.esc_attr($extra_class).'" id="'.esc_attr($random_string).'">';
			for( $i=0; $i<sizeof($titles); $i++ ){
				$title = $titles[$i];
				$accordion_content = !empty( $content[$i] ) ? $content[$i] : '';
				$html .= '
					<div class="panel panel-default">
						<div class="panel-heading">
							<h4 class="panel-title">
								<a data-toggle="collapse" data-parent="#'.esc_attr($random_string).'" href="#'.esc_attr($random_string).'_'.esc_attr($i).'">
									'.$title.'
								</a>
							</h4>
						</div>
						<div id="'.esc_attr($random_string).'_'.esc_attr($i).'" class="panel-collapse collapse '.( $i == 0 ? esc_attr('in') : '' ).'">
							<div class="panel-body">
								'.apply_filters( 'the_content', $accordion_content ).'
							</div>
						</div>
					</div>
				';
			}
			$html .= '</div>';
		}

		return $html;
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
				'id' => 'titles',
				'title' => __( 'Accordion Titles', 'pt-builder' ),
				'desc' => __( 'Add accordion title, one title in each row.', 'pt-builder' ),
				'type' => 'textarea',
				'value' => $titles
			),		
			array(
				'id' => 'pt_content',
				'title' => __( 'Accordion content', 'pt-builder' ),
				'desc' => __( 'Add accordion content. Follow the order of the titles and separate with /next/', 'pt-builder' ),
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