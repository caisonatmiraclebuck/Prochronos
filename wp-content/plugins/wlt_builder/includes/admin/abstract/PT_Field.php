<?php

abstract class PT_Field{
	public $field = array();
	public $field_html = '';

	public $dependencies = array(
		'styles' => array(),
		'scripts' => array()
	);
	
	public function __construct( $field ){
		global $FIELDS;
		$FIELDS[$this->shortname] = get_class( $this );
		
		if( is_admin() ){
			if( empty( $field['value'] ) && isset( $field['std'] ) && !empty( $field['std'] ) ){
				$field['value'] = $field['std'];
			}

			$this->field = $field;

			add_action( 'admin_enqueue_scripts', array( $this, 'load_dependencies' ) );
			if( !empty( $field ) ){
				$this->generate_html();
			}
		}
	}
	
	public function get_html_option(){
		return $this->field_html;
	}

	public function load_dependencies(){
		if(  !empty( $this->dependencies ) ){
			pt_load_dependencies( $this->dependencies );
		}
	}

	public function generate_html(){

	}
}

?>