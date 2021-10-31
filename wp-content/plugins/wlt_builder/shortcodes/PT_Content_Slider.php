<?php

class PT_Content_Slider extends PT_Shortcode{
	
	public $icon = '<span class="fa fa-th"></span>';
	public $name = 'Content Slider';
	public $description = 'Add content slider element to the page';
	public $category = '1. Sliders';
	public $image;
	public $default_options = array(
		'images' => '',
		'delay' => 5000,
		'navigation' => 'yes',
		'arrows' => 'yes',
		'element_name' => 'Content Slider',
		'extra_class' => ''
	);	

	function __construct(){
	
		$this->image  = PT_URL."/assets/images/admin/icon/slider-content.jpg";
		parent::__construct();
	}
	

	public function shortcode_frontend( $atts, $content ){
		extract( shortcode_atts( $this->default_options, $atts ) );

		
		$random_string = pt_random_string();
		$html = '';

		if( !empty( $images ) || !empty( $content ) ){
			$slides = '';
			$indicators = '';
			/* if there are images than create slider depending on them */
			if( !empty( $images ) ){
				$image_ids = explode( ",", $images );
				for( $i=0; $i<sizeof( $image_ids ); $i++ ){
					$image_id = $image_ids[$i];
					$image_data = wp_get_attachment_image_src( $image_id, 'full' );
					if( !empty( $image_data ) ){
						$content_slide = !empty( $content[$i] ) ? $content[$i] : '';
						$indicators .= '<li data-target="#'.esc_attr($random_string).'" data-slide-to="'.esc_attr($i).'" class="'.( $i == 0 ? esc_attr('active') : '' ).'"></li>';
						$slides .= '<div class="item '.( $i == 0 ? esc_attr('active') : '' ).'">
	                            		<img src="'.esc_url($image_data[0]).'">
	                            		<div class="carousel-caption">
	                                		'.$content_slide.'
	                            		</div>
	                        		</div>';
					}
				}
			}
			else{
				$content = explode( "/next/", $content );
				for( $i=0; $i<sizeof( $content ); $i++ ){
					$content_slide = strip_tags( $content[$i] );
					if( !empty( $content_slide ) ){
						$content_slide = $content[$i];
						$indicators .= '<li data-target="#'.esc_attr($random_string).'" data-slide-to="'.esc_attr($i).'" class="'.( $i == 0 ? esc_attr('active') : '' ).'"></li>';
						$slides .= '<div class="item '.( $i == 0 ? esc_attr('active') : '' ).'">
	                            		<div class="caption">
	                                		'.$content_slide.'
	                            		</div>
	                        		</div>';
	                 }
				}
			}
			$html = '<div id="'.esc_attr($random_string).'" class="carousel slide '.esc_attr($extra_class).'" data-ride="carousel" data-interval="'.esc_attr($delay).'">';
			if( $navigation == 'yes' ){
				$html .= '<ol class="carousel-indicators">'.$indicators.'</ol>';
			}
			$html .= '<div class="carousel-inner">'.$slides.'</div>';
			if( $arrows == 'yes' ){
				$html .= '
                    <a class="left carousel-control" href="#'.esc_attr($random_string).'" role="button" data-slide="prev">
                        <span class="glyphicon glyphicon-chevron-left"></span>
                    </a>
                    <a class="right carousel-control" href="#'.esc_attr($random_string).'" role="button" data-slide="next">
                        <span class="glyphicon glyphicon-chevron-right"></span>
                    </a>
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
				'id' => 'images',
				'title' => __( 'Select Imagess', 'pt-builder' ),
				'desc' => __( 'Select images you want to add to the slider.', 'pt-builder' ),
				'type' => 'images',
				'value' => $images
			),
			array(
				'id' => 'pt_content',
				'title' => __( 'Add Content', 'pt-builder' ),
				'desc' => __( 'Separate content for each slide with /next/.', 'pt-builder' ),
				'type' => 'editor',
				'value' => $atts['pt_content']
			),	
			array(
				'id' => 'delay',
				'title' => __( 'Delay', 'pt-builder' ),
				'desc' => __( 'Set delay between the slides in miliseconds. If the value is 0 than it will not autoplay.', 'pt-builder' ),
				'type' => 'textfield',
				'value' => $delay
			),
			array(
				'id' => 'navigation',
				'title' => __( 'Show Navigation', 'pt-builder' ),
				'desc' => __( 'Show or hide navigation bullets.', 'pt-builder' ),
				'type' => 'select',
				'options' => array(
					'yes' => __( 'Yes', 'pt-builder' ),
					'no' => __( 'No', 'pt-builder' )
				),
				'value' => $navigation
			),
			array(
				'id' => 'arrows',
				'title' => __( 'Show Arrows', 'pt-builder' ),
				'desc' => __( 'Show or hide navigation arrows.', 'pt-builder' ),
				'type' => 'select',
				'options' => array(
					'yes' => __( 'Yes', 'pt-builder' ),
					'no' => __( 'No', 'pt-builder' )
				),
				'value' => $arrows
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