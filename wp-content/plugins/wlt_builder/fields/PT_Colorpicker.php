<?php
class PT_Colorpicker extends PT_Field{

	public $shortname = 'colorpicker';

	public function __construct( $field = array() ){		
		$this->dependencies = array(
			'styles' => array(
				'wp-color-picker' => array()
			),
			'scripts' => array(
				'wp-color-picker' => array()
			)
		);		
		parent::__construct( $field );
	}

	public function generate_html(){
		extract( $this->field );

		$this->field_html = '
			<div class="pt-option-container">
				<label for="'.esc_attr($id).'">'.$title.'</label>
				<input type="text" id="'.esc_attr($id).'" class="pt-option pt-colorpicker" value="'.esc_attr($value).'" />
				<small>'.$desc.'</small>
			</div>
		';		
	}
}
?>