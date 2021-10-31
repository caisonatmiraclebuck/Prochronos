<?php
class PT_Options{
	public $options_html = '';
	
	function get_options(){
		return join( "", $this->options_html );
	}
	
	function __construct( $fields ){
		global $FIELDS;
		if( !empty( $fields ) ){
			foreach( $fields as $field ){
				$class = $FIELDS[ $field['type'] ];
				$object = new $class( $field );
				$this->options_html[] = $object->get_html_option();
			}
		}
	}
}
?>