<?php

class PT_Heading extends PT_Shortcode{
	
	public $icon = '<span class="fa fa-header"></span>';
	public $name = 'Heading';
	public $description = 'Add heading element to the page';
	public $category = '2. Headers';
	public $image;
	public $default_options = array(
		'heading' => '',
		'text' => 'Head Text Here',
		'align' => 'left',
		'color' => '',
		'element_name' => 'Heading',
		'extra_class' => '',
		'bgcolor' => '#ededed', 
		'padding' => '10px,10px,10px,10px',
		'margin' => '10px,0px,10px,0px',
		
	);		

	function __construct(){
		parent::__construct();
	}
	

	public function shortcode_frontend( $atts, $content ){
		extract( shortcode_atts( $this->default_options, $atts ) );


		// CUSTOM CSS
		$style = "";
		
		// IMAGE
		if(isset($imagesrc)){		
		$style .= 'background-image: url( '.$imagesrc.' ); background-size:cover; ';		
		} 
		
		// COLOR
		if( !empty( $bgcolor ) ){
			$style .= 'background-color: '.$bgcolor.'; ';
		}
		
		// PADDING
		if( !empty( $padding ) && strlen(trim($padding)) > 4 ){
			$padding = explode( ",", $padding );
			$style .= 'padding: '.join( " ", $padding ).'; ';
		}
		
		// MARGIN
		if( !empty( $margin ) && strlen(trim($margin)) > 4 ){
			$margin = explode( ",", $margin );
			$style .= 'margin: '.join( " ", $margin ).'; ';
		}




		return '<div class="headings text-'.esc_attr($align).' '.esc_attr($extra_class).'" style="'.esc_attr($style).'">
                    <'.$heading.'>'.$text.'</'.$heading.'>
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
				'id' => 'heading',
				'title' => __( 'Heading', 'pt-builder' ),
				'desc' => __( 'Select heading.', 'pt-builder' ),
				'type' => 'select',
				'options' => array(
					'h1' => __( 'H1', 'pt-builder' ),
					'h2' => __( 'H2', 'pt-builder' ),
					'h3' => __( 'H3', 'pt-builder' ),
					'h4' => __( 'H4', 'pt-builder' ),
					'h5' => __( 'H5', 'pt-builder' ),
					'h6' => __( 'H6', 'pt-builder' ),
				),
				'value' => $heading
			),
			array(
				'id' => 'text',
				'title' => __( 'Heading Text', 'pt-builder' ),
				'desc' => __( 'Input text for the heading.', 'pt-builder' ),
				'type' => 'textfield',
				'value' => $text
			),
			array(
				'id' => 'color',
				'title' => __( 'Font Color', 'pt-builder' ),
				'desc' => __( 'Select heading font color.', 'pt-builder' ),
				'type' => 'colorpicker',
				'value' => $color
			),
			array(
				'id' => 'align',
				'title' => __( 'Text Align', 'pt-builder' ),
				'desc' => __( 'Select text align.', 'pt-builder' ),
				'type' => 'select',
				'options' => array(
					'left' => __( 'Left', 'pt-builder' ),
					'center' => __( 'Center', 'pt-builder' ),
					'right' => __( 'Right', 'pt-builder' ),
				),
				'value' => $align
			),
			
			array(
				'id' => 'bgcolor',
				'title' => __( 'Background Color', 'pt-builder' ),
				'desc' => __( 'Select a background color.', 'pt-builder' ),
				'type' => 'colorpicker',
				'value' => $bgcolor
			),
 
			array(
				'id' => 'padding',
				'title' => __( 'Inner Padding', 'pt-builder' ),
				'desc' => __( 'Input section padding.', 'pt-builder' ),
				'type' => 'four',
				'value' => $padding
			),
			array(
				'id' => 'margin',
				'title' => __( 'Section Margin', 'pt-builder' ),
				'desc' => __( 'Input section margin.', 'pt-builder' ),
				'type' => 'four',
				'value' => $margin
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