<?php

class PT_Heading2 extends PT_Shortcode{
	
	public $icon = '<span class="fa fa-header"></span>';
	public $name = 'Heading Style 2';
	public $description = 'Add heading element to the page';
	public $category = '2. Headers';
	public $image;
	public $default_options = array(
		'heading' => 'h2',
		'element_name' => 'Heading1',
			
		'text' => 'This is your main heading text',	
		'color' => '#FFFFFF',
	
 		'text1' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Praesent tempus eleifend risus ut congue.',	
		'color1' => '#EFEFEF',
		
		'bgcolor' => '#333333', 
		'align' => 'bottom',
		
	);		


	function __construct(){
	
		$this->image  = PT_URL."/assets/images/admin/icon/heading2.jpg";
		parent::__construct();
	}
	

	public function shortcode_frontend( $atts, $content ){
		extract( shortcode_atts( $this->default_options, $atts ) );
 
		
		//BG COLOR
		$style = "";
		if( !empty( $bgcolor ) ){
			$style .= 'background-color: '.$bgcolor.'; ';
		}
		
		// COLORs
		$style1 = "";
		if( !empty( $color ) ){
			$style1 .= 'color: '.$color1.'; ';
		}
		$style2 = "";
		if( !empty( $color1 ) ){
			$style2 .= 'color: '.$color1.'; ';
		}		
  
		if($align == "top"){
		
		return '<div class="heading_style2_arrow_up" style="border-bottom: 5px solid '.$bgcolor.';" ></div><div class="heading_style2" style="'.esc_attr($style).'">
                    <'.$heading.'  style="'.esc_attr($style1).'">'.$text.'</'.$heading.'>
					<h3  style="'.esc_attr($style2).'">'.$text1.'</h3>					
                </div>';
		
		}elseif($align == "bottom"){
		
		return '<div class="heading_style2" style="'.esc_attr($style).'">
                    <'.$heading.'  style="'.esc_attr($style1).'">'.$text.'</'.$heading.'>
					<h3  style="'.esc_attr($style2).'">'.$text1.'</h3>					
                </div><div class="heading_style2_arrow_down" style="border-top: 20px solid '.$bgcolor.';" ></div>';
				
		}else{
		
		return '<div class="heading_style2" style="'.esc_attr($style).'">
                    <'.$heading.'  style="'.esc_attr($style1).'">'.$text.'</'.$heading.'>
					<h3  style="'.esc_attr($style2).'">'.$text1.'</h3>					
                </div>';
		}
		
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
				'id' => 'text1',
				'title' => __( 'Sub heading Text', 'pt-builder' ),
				'desc' => __( 'Input text for the heading.', 'pt-builder' ),
				'type' => 'textfield',
				'value' => $text1
			),
			array(
				'id' => 'color1',
				'title' => __( 'Font Color', 'pt-builder' ),
				'desc' => __( 'Select heading font color.', 'pt-builder' ),
				'type' => 'colorpicker',
				'value' => $color1
			),	
			
				array(
				'id' => 'bgcolor',
				'title' => __( 'Background Color', 'pt-builder' ),
				'desc' => __( 'Select a background color.', 'pt-builder' ),
				'type' => 'colorpicker',
				'value' => $bgcolor
			),	
			
				array(
				'id' => 'align',
				'title' => __( 'Arrow Position', 'pt-builder' ),
				'desc' => __( 'Select the position of the arrow.', 'pt-builder' ),
				'type' => 'select',
				'options' => array(
					'top' => __( 'Top', 'pt-builder' ),
					'bottom' => __( 'Bottom', 'pt-builder' ),
					'none' => __( 'None', 'pt-builder' ),
				),
				'value' => $align
			),	
			 			
		);
		
		$options_html = new PT_Options( $options );
		
		return $options_html->get_options();
	}	
}

?>