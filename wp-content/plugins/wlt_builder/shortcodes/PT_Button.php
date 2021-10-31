<?php

class PT_Button extends PT_Shortcode{
	public $icon = '<span class="fa fa-heart"></span>';
	public $name = 'Button';
	public $description = 'Add a button element to the page.';
	public $category = 'MISC';
	public $image;

	public $default_options = array(
		'bg_color' 			=> '',
		'bg_color_hvr' 		=> '',
		'font_color'		=> '',
		'font_color_hvr' 	=> '',
		'border_color' 		=> '',
		'border_color_hvr' 	=> '',
		'border_radius'		=> '',
		'border_width'		=> '',
		'link'				=> '#',
		'text'				=> '',
		'icon'				=> '',
		'size'				=> '',
		'target'			=> '_self',
		'element_name'		=> 'Button',
		'extra_class'		=> ''
	);

	function __construct(){
		parent::__construct();
	}

	public function create_style( $random_string ){
		extract( $this->default_options );
		$style = '
			<style>
				a.btn.'.$random_string.'{
					'.( !empty( $bg_color ) ? 'background-color: '.$bg_color.';' : '' ).'
					'.( !empty( $font_color ) ? 'color: '.$font_color.';' : '' ).'
					'.( !empty( $border_width ) ? 'border-width: '.$border_width.';' : '' ).'
					'.( !empty( $border_color ) ? 'border-color: '.$border_color.';' : '' ).'
					'.( !empty( $border_radius ) ? 'border-radius: '.$border_radius.';' : '' ).'
				}
				a.btn.'.$random_string.':hover, a.btn.'.$random_string.':focus, a.btn.'.$random_string.':active{
					'.( !empty( $bg_color_hvr ) ? 'background-color: '.$bg_color_hvr.';' : '' ).'
					'.( !empty( $font_color_hvr ) ? 'color: '.$font_color_hvr.';' : '' ).'
					'.( !empty( $border_color_hvr ) ? 'border-color: '.$border_color_hvr.';' : '' ).'
				}
			</style>
		';

		return $style;
	}	

	public function shortcode_frontend( $atts, $content ){
		$this->default_options = shortcode_atts( $this->default_options, $atts );
		extract( $this->default_options );

		$random_string = pt_random_string();
		$style = $this->create_style( $random_string );
		return '
			'.$style.'
			<a class="btn btn-default '.esc_attr($size).' '.esc_attr($random_string).' '.esc_attr($extra_class).'" href="'.esc_url($link).'" target="'.esc_attr($target).'">
				'.( !empty( $icon ) ? '<span class="fa '.esc_attr($icon).'"></span> ' : '' ).'
				'.$text.'
			</a>
		';
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
				'id' => 'bg_color',
				'title' => __( 'Button Background Color', 'pt-builder' ),
				'desc' => __( 'Select button background color.', 'pt-builder' ),
				'type' => 'colorpicker',
				'value' => $bg_color
			),
			array(
				'id' => 'bg_color_hvr',
				'title' => __( 'Button Background Color On Hover', 'pt-builder' ),
				'desc' => __( 'Select button background color. on hover', 'pt-builder' ),
				'type' => 'colorpicker',
				'value' => $bg_color_hvr
			),
			array(
				'id' => 'font_color',
				'title' => __( 'Font Color', 'pt-builder' ),
				'desc' => __( 'Select button font color.', 'pt-builder' ),
				'type' => 'colorpicker',
				'value' => $font_color
			),
			array(
				'id' => 'font_color_hvr',
				'title' => __( 'Font Color On Hover', 'pt-builder' ),
				'desc' => __( 'Select button font color on hover.', 'pt-builder' ),
				'type' => 'colorpicker',
				'value' => $font_color_hvr
			),
			array(
				'id' => 'border_color',
				'title' => __( 'Border Color', 'pt-builder' ),
				'desc' => __( 'Select border color.', 'pt-builder' ),
				'type' => 'colorpicker',
				'value' => $border_color
			),
			array(
				'id' => 'border_color_hvr',
				'title' => __( 'Border Color On Hover', 'pt-builder' ),
				'desc' => __( 'Select border color on hover.', 'pt-builder' ),
				'type' => 'colorpicker',
				'value' => $border_color_hvr
			),			
			array(
				'id' => 'border_radius',
				'title' => __( 'Border Radius', 'pt-builder' ),
				'desc' => __( 'Input border radius.', 'pt-builder' ),
				'type' => 'textfield',
				'value' => $border_radius,
				'std' => '2px'
			),
			array(
				'id' => 'border_width',
				'title' => __( 'Border Width', 'pt-builder' ),
				'desc' => __( 'Input border width in px or em.', 'pt-builder' ),
				'type' => 'textfield',
				'value' => $border_width
			),
			array(
				'id' => 'link',
				'title' => __( 'Link', 'pt-builder' ),
				'desc' => __( 'Input button link.', 'pt-builder' ),
				'type' => 'textfield',
				'value' => $link
			),
			array(
				'id' => 'text',
				'title' => __( 'Text', 'pt-builder' ),
				'desc' => __( 'Input button text.', 'pt-builder' ),
				'type' => 'textfield',
				'value' => $text
			),			
			array(
				'id' => 'size',
				'title' => __( 'Size', 'pt-builder' ),
				'desc' => __( 'Select button size.', 'pt-builder' ),
				'type' => 'select',
				'options' => array(
					'' => __( 'Default', 'pt-builder' ),
					'btn-xs' => __( 'Small', 'pt-builder' ),
					'btn-sm' => __( 'Meduim', 'pt-builder' ),
					'btn-lg' => __( 'Large', 'pt-builder' ),
				),
				'value' => $size
			),
			array(
				'id' => 'icon',
				'title' => __( 'Icon', 'pt-builder' ),
				'desc' => __( 'Select button icon.', 'pt-builder' ),
				'type' => 'iconpicker',
				'value' => $icon
			),
			array(
				'id' => 'target',
				'title' => __( 'Target Window', 'pt-builder' ),
				'desc' => __( 'Select window where to open.', 'pt-builder' ),
				'type' => 'select',
				'options' => array(
					'_self' => __( 'Same Window', 'pt-builder' ),
					'_blank' => __( 'New Window', 'pt-builder' ),
				),
				'value' => $target
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