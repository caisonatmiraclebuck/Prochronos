<?php

class PT_Section extends PT_Shortcode{	
	
	public $image;
	
	function __construct(){	
		$this->default_options = array(
			'width' => 'boxed',
			'bg_color' => '',
			'bg_image' => '',
			'padding' => '10px,0px,10px,0px',
			'margin' => '',
			'extra_class' => '',
			'element_name' => __( 'Section', 'pt-builder' )
		);		
		parent::__construct();
	}

	public function create_style( $random_string ){
		extract( $this->default_options );
		
		$style = '';
		if( !empty( $bg_image ) ){
			$image_data = wp_get_attachment_image_src( $bg_image, 'full' );
			if( !empty( $image_data ) ){
				$style .= 'background-image: url( '.$image_data[0].' ); ';
			}
		}		
		if( !empty( $bg_color ) ){
			$style .= 'background-color: '.$bg_color.'; ';
		}
		if( !empty( $padding ) && strlen(trim($padding)) > 4 ){
			$padding = explode( ",", $padding );
			$style .= 'padding: '.join( " ", $padding ).'; ';
		}
		if( !empty( $margin ) && strlen(trim($margin)) > 4 ){
			$margin = explode( ",", $margin );
			$style .= 'margin: '.join( " ", $margin ).'; ';
		}	
		
		return $style;	
	}

	public function shortcode_admin( $atts, $content ){
		extract( shortcode_atts( $this->default_options, $atts ) );

		return '<div class="pt-section pt-element-root sectionid'.esc_attr($atts['shortcode_id']).'" data-shortcode_id="'.esc_attr($atts['shortcode_id']).'" data-shortcode_element="PT_Section" data-contain_shortcode_element="PT_Row">
					<div class="pt-actions clearfix" style="float:left; width:30px; height:100%; padding-left: 1px; padding-right: 10px;">	
					
										
						<a href="javascript:;" style="float:none;" class="pt-section-drag" title="'.__( 'Drag Section', 'pt-builder' ).'"><span class="fa fa-arrows"></span></a>
						<!--<span class="pt-element-name">'.$element_name.'</span>-->
						<a href="javascript:;" class="pt-edit" title="'.__( 'Edit Element', 'pt-builder' ).'"><span class="fa fa-pencil"></span></a>
						<a href="javascript:;" class="pt-clone" title="'.__( 'Clone Element', 'pt-builder' ).'"><span class="fa fa-copy"></span></a>
						<a href="javascript:;" class="pt-delete" title="'.__( 'Delete Element', 'pt-builder' ).'"><span class="fa fa-trash-o"></span></a>
						
						<!--<a href="javascript:;" class="pt-colapse" title="'.__( 'Toggle Display Of Element', 'pt-builder' ).'"><span class="fa fa-caret-up"></span></a>-->
						
						
					</div>
					<div class="pt-collapsible" style="overflow:hidden;">
						<div class="pt-section-content '.esc_attr($atts['shortcode_id']).'">
							'.do_shortcode( $content ).'
						</div>
						<a href="javascript:;" class="button pt-add-newaction-row">Add Row</a>
					</div>
				</div>';	
	}

	public function shortcode_frontend( $atts, $content ){
		$this->default_options = shortcode_atts( $this->default_options, $atts );
		extract( $this->default_options );

		$random_string = pt_random_string();
		$style = $this->create_style( $random_string );

		return '<section style="'.( $width == 'boxed' ? '' : esc_attr($style) ).'" class="'.esc_attr($extra_class).'">
					<div class="container'.( $width == 'boxed' ? '' : esc_attr('-fluid') ).'" style="'.( $width == 'boxed' ? esc_attr($style) : '' ).'; max-width:100%;">
						'.do_shortcode( $content ).'
					</div>
				</section>';
	}
	
	public function shortcode_options( $atts = array() ){
		extract( shortcode_atts( $this->default_options, $atts ) );
		$options = array(
			array(
				'id' => 'element_name',
				'title' => __( 'Section Name', 'pt-builder' ),
				'desc' => __( 'Input custom section name for easy recognition.', 'pt-builder' ),
				'type' => 'textfield',
				'value' => $element_name
			),
			array(
				'id' => 'width',
				'title' => __( 'Section Width', 'pt-builder' ),
				'desc' => __( 'Select width of the section.', 'pt-builder' ),
				'type' => 'select',
				'options' => array(
					'boxed' => __( 'Boxed', 'pt-builder' ),
					'full' => __( 'Full Width', 'pt-builder' ),
				),
				'value' => $width
			),
			array(
				'id' => 'bg_color',
				'title' => __( 'Section Background Color', 'pt-builder' ),
				'desc' => __( 'Set background color for the section.', 'pt-builder' ),
				'type' => 'colorpicker',
				'value' => $bg_color
			),
			array(
				'id' => 'bg_image',
				'title' => __( 'Section Background Image', 'pt-builder' ),
				'desc' => __( 'Set background image for the section.', 'pt-builder' ),
				'type' => 'image',
				'value' => $bg_image
			),
			array(
				'id' => 'padding',
				'title' => __( 'Section Padding', 'pt-builder' ),
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
				'title' => __( 'Section Extra Class', 'pt-builder' ),
				'desc' => __( 'Input section extra class for additional styling.', 'pt-builder' ),
				'type' => 'textfield',
				'value' => $extra_class
			),
		);
		
		$options_html = new PT_Options( $options );
		
		return $options_html->get_options();
	}
}

?>