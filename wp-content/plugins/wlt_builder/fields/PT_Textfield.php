<?php
class PT_Textfield extends PT_Field{

	public $shortname = 'textfield';

	public function __construct( $field = array() ){
		parent::__construct( $field );
	}

	public function generate_html(){
		extract( $this->field );

		$this->field_html = '
			<div class="pt-option-container">
				<label for="'.esc_attr($id).'">'.$title.'</label>
				<input type="text" id="'.esc_attr($id).'" class="pt-option" value="'.esc_attr($value).'" />
				<small>'.$desc.'</small>
			</div>
		';		
	}	
}
?>