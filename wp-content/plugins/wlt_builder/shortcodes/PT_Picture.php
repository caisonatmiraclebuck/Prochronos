<?php

class PT_Picture extends PT_Shortcode{
	
	public $icon = '<span class="fa fa-image"></span>';
	public $name = 'Picture';
	public $description = 'Add image element to the page';
	public $category = '5. Images';
	public $image;
	public $default_options = array(
		'image' => '',
		'element_name' => 'Single Photo',
		'extra_class' => ''
	);		

	function __construct(){
		parent::__construct();
	}
	

	public function shortcode_frontend( $atts, $content ){
		extract( shortcode_atts( $this->default_options, $atts ) );

		$html = '';
		if( !empty( $image ) )
		
		 if(substr($image,0,4) == "http"){
		 
		 $html = '<div class="pt-image '.esc_attr($extra_class).'">
	                    <img src="'.esc_url($image).'" class="img-responsive" alt="image">
	                </div>';
					
		 }else{		 
		 
			$image_data = wp_get_attachment_image_src( $image, 'full' );
			if( !empty( $image_data ) ){
				$image_post = get_post( $image );
				$html = '<div class="pt-image '.esc_attr($extra_class).'">
							<img src="'.esc_url($image_data[0]).'" class="img-responsive" title="'.esc_attr($image_post->post_title).'" alt="'.esc_attr(str_replace( " ", "_", $image_post->post_title )).'">
						</div>';
			}
		
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
				'id' => 'image',
				'title' => __( 'Image', 'pt-builder' ),
				'desc' => __( 'Select image you want to add.', 'pt-builder' ),
				'type' => 'image',
				'value' => $image
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