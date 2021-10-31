<?php

class PT_Core_YouTube extends PT_Shortcode{
	
	public $icon = '<span class="fa fa-youtube-play"></span>';
	public $name = 'YouTube';
	public $description = 'Add a YouTube video to the page';
	public $category = '6. Video';
	public $image;
	public $default_options = array(
		'element_name' 	=> 'YouTube',
 		'link' 			=> '',
		'w' 			=> '100%',
		'h' 			=> '400px',
		'extra_class'	=> '',
 
	);		

	function __construct(){
	
		$this->image  = PT_URL."/assets/images/admin/icon/youtube.jpg";
		parent::__construct();
	}
	

	public function shortcode_frontend( $atts, $content ){
		extract( shortcode_atts( $this->default_options, $atts ) );
		
		global $CORE;
		
		// UNIQUE ID
		$ranid 		= rand();
		
		// GET VIDEO LINK
		$l = explode("?v=", $link);
		$code = explode("&", $l[1]);
 
		ob_start();
		?>       
		 
 		<iframe style="height:<?php echo $h; ?>; width:<?php echo $w; ?>;" src="https://www.youtube.com/embed/<?php echo $code[0]; ?>" frameborder="0" allowfullscreen></iframe>
        
		<?php
		return ob_get_clean();
 
	}

	public function shortcode_options( $atts ){
		extract( shortcode_atts( $this->default_options, $atts ) );
		$options = array(
			array(
				'id' => 'element_name',
				'title' => __( 'Element Name', 'pt-builder' ),
				'desc' => __( 'Input custom element name for easy recognition.', 'pt-builder' ),
				'type' => 'textfield',
				'value' => $element_name
			),	
		 array(
				'id' => 'link',
				'title' => __( 'Youtube Link', 'pt-builder' ),
				'desc' => __( 'Input the page link for the youtube video.', 'pt-builder' ),
				'type' => 'textfield',
				'value' => $link
			),
			
		 array(
				'id' => 'w',
				'title' => __( 'Width', 'pt-builder' ),
				'desc' => __( 'Input the value for the video width.', 'pt-builder' ),
				'type' => 'textfield',
				'value' => $w
			),	
		 array(
				'id' => 'h',
				'title' => __( 'Height', 'pt-builder' ),
				'desc' => __( 'Input the value for the video height.', 'pt-builder' ),
				'type' => 'textfield',
				'value' => $h
			),		
			
			array(
				'id' => 'extra_class',
				'title' => __( 'Extra Class', 'pt-builder' ),
				'desc' => __( 'Input extra class for the element.', 'pt-builder' ),
				'type' => 'textfield',
				'value' => $extra_class
			),				 
		);
		
		$options_html = new PT_Options( $options );
		
		return $options_html->get_options();
	}	
}

?>