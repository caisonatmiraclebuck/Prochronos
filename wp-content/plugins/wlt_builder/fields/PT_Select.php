<?php
class PT_Select extends PT_Field{

	public $shortname = 'select';

	public function __construct( $field = array() ){		
		parent::__construct( $field );
	}

	public function generate_html(){
		extract( $this->field );

		if( !empty( $options ) ){
			foreach( $options as $option_key => $option_value ){
				$this->field_html .= '<option value="'.esc_attr($option_key).'" '.( $option_key == esc_attr($value) ? esc_attr('selected="selected"') : '' ).'>'.$option_value.'</option>';
			}
		}
		
		$this->field_html = '
			<div class="pt-option-container">
				<label for="'.esc_attr($id).'">'.$title.'</label>
				<select id="'.esc_attr($id).'" class="pt-option">
					'.$this->field_html.'
				</select>
				<small>'.$desc.'</small>
			</div>
		';
	}	
}
?>