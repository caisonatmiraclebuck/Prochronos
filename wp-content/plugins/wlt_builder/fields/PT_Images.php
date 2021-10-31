<?php
class PT_Images extends PT_Field{

	public $shortname = 'images';

	public function __construct( $field = array() ){
		$this->dependencies = array(
			'styles' => array(),
			'scripts' => array(
				'pt-images' => array(
					'src' => PT_URL . '/assets/js/admin/pt-images.js',
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

		$images = '';
		$image_ids = explode( ",", $value );
		if( !empty( $image_ids ) ){
			foreach( $image_ids as $image_id ){
				$image_data = wp_get_attachment_image_src( $image_id );
				if( !empty( $image_data ) ){
					$images .= '<div class="pt-image-wrapper">
									<img src="'.esc_url($image_data[0]).'" class="pt-option-thumb" data-image_id="'.esc_attr($image_id).'"/>
									<a href="javascript:;" class="remove_images" data-image_id="'.esc_attr($image_id).'"><span class="fa fa-times"></span></a>
								</div>';
				}
			}
		}

		$this->field_html = '
			<div class="pt-option-container">
				<label for="'.esc_attr($id).'">'.$title.'</label>
				<div class="pt-images-holder">
					'.$images.'
				</div>
				<input id="'.esc_attr($id).'" class="pt-option pt-images" value="'.esc_attr($value).'" type="hidden" />
				<a href="javascript:;" class="button pt-add-images">'.__( 'Select Images', 'pt-builder' ).'</a>				
				<small>'.$desc.'</small>
			</div>
		';
	}	
}
?>