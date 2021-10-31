<?php
class PT_Textarea extends PT_Field{

	public $shortname = 'textarea';

	public function __construct( $field = array() ){
		parent::__construct( $field );
	}

	public function generate_html(){
		extract( $this->field );

		$this->field_html = '
			<div class="pt-option-container">
				<label for="'.esc_attr($id).'">'.$title.'</label>
				<textarea id="'.esc_attr($id).'" class="pt-option pt-raw-textarea">'.str_replace( "/n/", "\n", $value ).'</textarea>
				<small>'.$desc.'</small>
			</div>
		';
	}
}
?>