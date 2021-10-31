<?php
class PT_Editor extends PT_Field{

	public $shortname = 'editor';

	public function __construct( $field = array() ){	
		parent::__construct( $field );
	}

	public function generate_html(){
		extract( $this->field );

		ob_start();
		wp_editor( $value, $id, array('editor_class' => 'pt-option') );
		$editor = ob_get_contents();
		ob_end_clean();
		
		$this->field_html = '
			<div class="pt-option-container pt-full-width">
				'.$editor.'
				<small>'.$desc.'</small>
			</div>
		';
	}
}
?>