<?php
class PT_Checkbox extends PT_Field{

	public $shortname = 'checkbox';

	public function __construct( $field = array() ){
		$this->dependencies = array(
			'styles' => array(),
			'scripts' => array(
				'pt-checkbox' => array(
					'src' => PT_URL.'/assets/js/admin/pt-checkbox.js',
					'deps' 	=> false,
					'ver'	=> '1.0.0',
					'in_footer' => true
				)
			)
		);
		parent::__construct( $field );
	}

	public function generate_html(){
		extract( $this->field );
		if( empty( $value ) ){
			$value = '0';
		}
		$this->field_html = '
			<div class="pt-option-container">
				<label for="'.esc_attr($id).'">'.$title.'</label>				
				<a href="javascript:;" class="pt-checkbox-option '.( ( '0' == $value ) ? 'active' : '' ).'" data-value="0">'.__( 'No', 'pt-builder' ).'</a>
				<a href="javascript:;" class="pt-checkbox-option '.( ( '1' == $value ) ? 'active' : '' ).'" data-value="1">'.__( 'Yes', 'pt-builder' ).'</a>
				<input value="'.esc_attr($value).'" type="hidden" id="'.esc_attr($id).'" class="pt-option pt-checkbox"/>
				<small>'.$desc.'</small>
			</div>
		';
	}
}
?>