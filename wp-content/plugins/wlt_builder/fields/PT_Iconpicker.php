<?php
class PT_Iconpicker extends PT_Field{

	public $shortname = 'iconpicker';

	public function __construct( $field = array() ){		
		$this->dependencies = array(
			'styles' => array(),
			'scripts' => array(
				'pt-iconpicker' => array(
					'src' => PT_URL.'/assets/js/admin/pt-iconpicker.js',
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

		$icons_html = '';
		$icons = pt_icons_list();
		foreach( $icons as $icon_key => $icon_name ){
			if( $icon_key != 'none' ){
				$icons_html .= '<li data-icon_name="'.esc_attr($icon_key).'" class="'.( $icon_key == $value ? esc_attr('active') : '' ).'"><span class="fa '.esc_attr($icon_key).'"></span></li>';
			}
		}

		$this->field_html = '
			<div class="pt-option-container">
				<label for="'.esc_attr($id).'">'.$title.'</label>
				<a href="javascript:;" class="button pt-icons-select">'.( !empty( $value ) ? '<span class="fa '.esc_attr($value).'"></span> ' : '' ).__( 'Select Icon', 'pt-builder' ).'</a>
				'.(
					!empty( $value ) ? '<a href="javascript:;" class="button pt-icons-clear">'.__( 'Clear', 'pt-builder' ).'</a>' : ''
				).'
				<input type="hidden" id="'.esc_attr($id).'" class="pt-option pt-iconpicker" value="'.esc_attr($value).'" />
				<div class="pt-iconpicker-list">
					<ul class="pt-icons">
						'.$icons_html.'
					</ul>
				</div>
				<small>'.$desc.'</small>
			</div>
		';
	}	
}
?>