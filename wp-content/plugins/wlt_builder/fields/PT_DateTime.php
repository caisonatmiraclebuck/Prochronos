<?php
class PT_DateTime extends PT_Field{

	public $shortname = 'datetime';

	public function __construct( $field = array() ){
	 
	 
	// FIX FOR MULTOPLE DATE TIME ELEMENTS
	if(isset($_GET['post_type']) && $_GET['post_type'] == "listing_type"){ return; }
	
	if(isset($_GET['post']) && is_numeric($_GET['post'])){		
		$po = get_post($_GET['post']);		
		if($po->post_type == "listing_type"){ return; }	
	}
	
		$this->dependencies = array(
			'styles' => array(
				'pt-datetime-css' => array(
					'src' 	=> PT_URL.'/assets/css/admin/jquery.datetimepicker.css',
					'deps' 	=> false,
					'ver'	=> '2.3.4',
					'media' => false
				),
			),
			'scripts' => array(
				'pt-datetime-js' => array(
					'src' => PT_URL.'/assets/js/admin/jquery.datetimepicker.js',
					'deps' 	=> false,
					'ver'	=> '2.3.4',
					'in_footer' => true
				)			
			)
		);
		parent::__construct( $field );
	}

	public function generate_html(){
		extract( $this->field );
		$this->field_html = '
			<div class="pt-option-container">
				<label for="'.esc_attr($id).'">'.$title.'</label>
				<input value="'.esc_attr($value).'" type="text" id="'.esc_attr($id).'" class="pt-datetime pt-option"/>
				<small>'.$desc.'</small>
			</div>
		';
	}
}
?>