<?php

class PT_Tabs extends PT_Shortcode{
	
	public $icon = '<span class="fa fa-th-list"></span>';
	public $name = 'Tabs';
	public $description = 'Add tab element to the page';
	public $category = 'MISC';
	public $image;
	public $default_options = array(
		'titles' => '',
		'hor_ver' => 'horizontal',
		'vertical_position' => 'left',
		'element_name' => 'Tabs',
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
			$navigation = '';
			$tabs = '';
			for( $i=0; $i<sizeof($titles); $i++ ){
				$title = $titles[$i];
				$tabs_content = !empty( $content[$i] ) ? $content[$i] : '';
				$navigation .= '<li '.( $i == 0 ? esc_attr('class=active') : '' ).'><a href="#'.esc_attr($random_string).'_'.esc_attr($i).'" role="tab" data-toggle="tab">'.$title.'</a></li>';
				$tabs .= '<div class="tab-pane '.( $i == 0 ? esc_attr('active') : '' ).'" id="'.esc_attr($random_string).'_'.esc_attr($i).'">'.apply_filters( 'the_content', $tabs_content ).'</div>';
			}
			

			if( $hor_ver == 'horizontal' ){
				$html = '<ul class="nav nav-tabs" role="tablist">'.$navigation.'</ul><div class="tab-content">'.$tabs.'</div>';
			}
			else{
				if( $vertical_position == 'left' ){
					$html = '<div class="col-xs-3 no-padding">
                				<ul class="nav nav-tabs tabs-left">'.$navigation.'</ul>
                			</div>
                			<div class="col-xs-9 no-padding">
                				<div class="tab-content left">
                					'.$tabs.'
                				</div>
                			</div>';
				}
				else{
					$html = '<div class="col-xs-9 no-padding">
                				<div class="tab-content tabs-right">
                					'.$tabs.'
                				</div>					                				
                			</div>
                			<div class="col-xs-3 no-padding">
								<ul class="nav nav-tabs right">'.$navigation.'</ul>
                			</div>';
				}
			}
		}

		return '<div class="'.esc_attr($extra_class).'">'.$html.'</div>';
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
				'title' => __( 'Tabs Titles', 'pt-builder' ),
				'desc' => __( 'Add titles of the tabs, one title in each row.', 'pt-builder' ),
				'type' => 'textarea',
				'value' => $titles
			),
			array(
				'id' => 'hor_ver',
				'title' => __( 'Type of tabs', 'pt-builder' ),
				'desc' => __( 'Select what kind of tabs you want.', 'pt-builder' ),
				'type' => 'select',
				'options' => array(
					'horizontal' => __( 'Horizontal', 'pt-builder' ),
					'vertical' => __( 'Vertical', 'pt-builder' )
				),
				'value' => $hor_ver
			),	
			array(
				'id' => 'vertical_position',
				'title' => __( 'Vertical Tabs Position', 'pt-builder' ),
				'desc' => __( 'Select the position of the vertical tabs.', 'pt-builder' ),
				'type' => 'select',
				'options' => array(
					'left' => __( 'Left', 'pt-builder' ),
					'right' => __( 'Right', 'pt-builder' )
				),
				'value' => $vertical_position
			),
			array(
				'id' => 'pt_content',
				'title' => __( 'Tabs content', 'pt-builder' ),
				'desc' => __( 'Add tabs content. Follow the order of the titles and separate with /next/', 'pt-builder' ),
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