<?php

class PT_Core_Jumbo extends PT_Shortcode{
	
	public $icon = '<span class="fa fa-file-text-o"></span>';
	public $name = 'Jumbotron';
	public $description = 'Add a jumbotron block to the page';
	public $category = '2. Headers';
	public $image;
	public $default_options = array(
		'element_name' => 'Jumbotron',
		'arrows' => 'no',
		'extra_class' => '',
		'image' => '',
		'ovcolor' => '',
		'ovtsp'	=> '0.5',
		'bgcolor' => '#dddddd', 
		'padding' => '60px,60px,100px,60px',
		'margin' => '0px,0px,0px,0px',
	);		

	function __construct(){
		parent::__construct();
	}
	

	public function shortcode_frontend( $atts, $content ){
		extract( shortcode_atts( $this->default_options, $atts ) );
	 	
		// UNIQUE ID
		$ranid 		= rand();
		
		if( !empty( $image ) ){	
			
			if(!is_numeric($image)){
			$imagesrc = $image;
			}else{ 
			$image_data = wp_get_attachment_image_src( $image, 'full' );
			$imagesrc = $image_data[0];
			}
		}
		
		// CUSTOM CSS
		$style = ""; $style1 = "";
		
		// IMAGE
		if(isset($imagesrc)){		
		$style .= 'background-image: url( '.$imagesrc.' ); background-size:cover; ';		
		} 
		
		// COLOR
		if( !empty( $bgcolor ) ){
			$style .= 'background-color: '.$bgcolor.'; ';
		}
		
		// PADDING
		if( !empty( $padding ) && strlen(trim($padding)) > 4 ){
			$padding = explode( ",", $padding );
			$style1 .= 'padding: '.join( " ", $padding ).'; ';
		}
		
		// MARGIN
		if( !empty( $margin ) && strlen(trim($margin)) > 4 ){
			$margin = explode( ",", $margin );
			$style .= 'margin: '.join( " ", $margin ).'; ';
		}	
		
		// OVERLAY COLOR		
		if( !empty( $ovcolor ) ){
		
			if($ovtsp == ""){ $trs = "50"; }else{ $trs = $ovtsp; }
		 	
			  $hex = str_replace("#", "", $ovcolor);
			  if(strlen($hex) == 3) {
				  $r = hexdec(substr($hex,0,1).substr($hex,0,1));
				  $g = hexdec(substr($hex,1,1).substr($hex,1,1));
				  $b = hexdec(substr($hex,2,1).substr($hex,2,1));
			   } else {
				  $r = hexdec(substr($hex,0,2));
				  $g = hexdec(substr($hex,2,2));
				  $b = hexdec(substr($hex,4,2));
			   }
			$style1 .= 'background: rgba('.$r.', '.$g.', '.$b.', '.$trs.'); ';
		}

		ob_start();
		?>
 
        <div class="wlt_builder_jumbotron jumbotron <?php echo esc_attr($extra_class); ?>" style="<?php echo $style; ?>; padding:0px;">
        
            <div class="overlay" style="<?php echo $style1; ?>">
            
                <div class="inner">
                      
                	<?php echo apply_filters( 'the_content', $content  ); ?>  
                           
                </div>
            
            </div>
        
        </div>
				
		<?php
		return ob_get_clean();
 
	}

	public function shortcode_options( $atts ){
		extract( shortcode_atts( $this->default_options, $atts ) );
 
 		
		// DEFAULT FOR THIS VALUE
		if($atts['pt_content'] == ""){
		$atts['pt_content'] = "<h1>Hello, world!</h1><p>This is a simple hero unit, a simple jumbotron-style component for calling extra attention to featured content or information.</p><p><a class='btn btn-primary btn-lg' href='".home_url()."/?s='>Search Website</a></p>";
		}
		
		$options = array(
			array(
				'id' => 'element_name',
				'title' => __( 'Element Name', 'pt-builder' ),
				'desc' => __( 'Input custom element name for easy recognition.', 'pt-builder' ),
				'type' => 'textfield',
				'value' => $element_name
			),	
			array(
				'id' => 'pt_content',
				'title' => __( 'Text', 'pt-builder' ),
				'desc' => __( 'Write the text here.', 'pt-builder' ),
				'type' => 'editor',
				'value' => $atts['pt_content'],
			),
			
			array(
				'id' => 'image',
				'title' => __( 'Background Image', 'pt-builder' ),
				'desc' => __( 'Select an image you want to use as a background.', 'pt-builder' ),
				'type' => 'image',
				'value' => $image
			),
			array(
				'id' => 'bgcolor',
				'title' => __( 'Background Color', 'pt-builder' ),
				'desc' => __( 'Select a background color.', 'pt-builder' ),
				'type' => 'colorpicker',
				'value' => $bgcolor
			),
 
			array(
				'id' => 'ovcolor',
				'title' => __( 'Overlay Color', 'pt-builder' ),
				'desc' => __( 'Select a background color for the inner overlay.', 'pt-builder' ),
				'type' => 'colorpicker',
				'value' => $ovcolor
			),
			
			array(
				'id' => 'ovtsp',
				'title' => __( 'Overlay Transparency Value', 'pt-builder' ),
				'desc' => __( 'Input a value between 0 and 1 (1 is full color)', 'pt-builder' ),
				'type' => 'textfield',
				'value' => $ovtsp
			),
			array(
				'id' => 'padding',
				'title' => __( 'Inner Padding', 'pt-builder' ),
				'desc' => __( 'Input section padding.', 'pt-builder' ),
				'type' => 'four',
				'value' => $padding
			),
			array(
				'id' => 'margin',
				'title' => __( 'Section Margin', 'pt-builder' ),
				'desc' => __( 'Input section margin.', 'pt-builder' ),
				'type' => 'four',
				'value' => $margin
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