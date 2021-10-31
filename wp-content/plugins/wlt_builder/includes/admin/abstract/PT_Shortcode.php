<?php

class PT_Shortcode{
	public $icon = '';
	public $name = '';
	public $description = '';
	public $category = '';

	public $dependencies = array(
		'styles' => array(),
		'scripts' => array()
	);

	public $default_options = array();

	function __construct(){
 
		global $WLT_BUILDER_SHORTCODES; if(!is_array($WLT_BUILDER_SHORTCODES)){ $WLT_BUILDER_SHORTCODES = array(); }

		$shortcode = strtolower( get_class( $this ) );
		$WLT_BUILDER_SHORTCODES[$shortcode] = array(
			'category' => $this->category,
			'icon' => $this->icon,
			'name' => $this->name,
			'description' => $this->description,
			'image' => $this->image,
		);
		if( isset($_POST['action']) && $_POST['action'] == 'pt_build_preview_admin' ){
			add_shortcode( $shortcode, array( $this, 'shortcode_frontend' ) );
		}
		else if( is_admin() ){
			add_shortcode( $shortcode, array( $this, 'shortcode_admin' ) );
		}
		else{
			add_shortcode( $shortcode, array( $this, 'shortcode_frontend' ) );
		}

		add_action( 'wp_enqueue_scripts', array( $this, 'load_dependencies' ) );
	}
	
	public function load_dependencies(){
		if( !empty( $this->dependencies ) ){
			 	 
			pt_load_dependencies( $this->dependencies );
			 
		}
	}

	public function create_style( $random_string ){

	}

	public function shortcode_admin( $atts, $content ){
		$this->default_options = array_merge( array( 'element_name' => $this->name ), $this->default_options );
		$this->default_options = shortcode_atts( $this->default_options, $atts );
		extract( $this->default_options );	
		return '<div class="pt-element pt-element-root" data-shortcode_id="'.esc_attr($atts['shortcode_id']).'" data-shortcode_element="'.esc_attr(get_class( $this )).'">
					<div class="pt-actions">						
						<a href="javascript:;" class="pt-edit" title="'.__( 'Edit Element', 'pt-builder' ).'"><span class="fa fa-pencil"></span></a>						
						<a href="javascript:;" class="pt-clone" title="'.__( 'Clone Element', 'pt-builder' ).'"><span class="fa fa-copy"></span></a>
						<a href="javascript:;" class="pt-delete" title="'.__( 'Delete Element', 'pt-builder' ).'"><span class="fa fa-trash-o"></span></a>
					</div>
					<div class="pt-element-title">
						<h2 class="pt-element-name">'.$element_name.'</h2>
					</div>
				</div>';		
	}

	public function shortcode_frontend( $atts, $content ){
		$this->default_options = shortcode_atts( $this->default_options, $atts );
		extract( $this->default_options );

		$random_string = pt_random_string();
		$style = $this->create_style( $random_string );
		return '
			'.$style.'
			<a class="btn btn-default '.esc_attr($size).' '.esc_attr($random_string).'" href="'.esc_url($link).'" target="'.esc_attr($target).'">
				'.( !empty( $icon ) ? '<span class="fa '.esc_attr($icon).'"></span> ' : '' ).'
				'.$text.'
			</a>
		';
	}

	public function shortcode_options( $atts ){

	}	
}

?>