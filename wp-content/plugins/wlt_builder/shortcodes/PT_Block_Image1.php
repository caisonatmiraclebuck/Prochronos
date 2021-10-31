<?php

class PT_Block_Image1 extends PT_Shortcode {
	
	public $icon = '<span class="fa fa-file-image-o"></span>';
	public $name = 'Image Block 1';
	public $description = 'Add icon block to the page.';
	public $image;
	public $category = '5. Images';
	public $default_options = array(
		'element_name' => 'Image Block 1',
		'extra_class' => '',
		'image' => '',
		'bdcolor' => '#dddddd',
		'bgcolor' => '#fafafa',
		'txtcolor' => '#222222',
		'link' => 'http://',
	);		

	function __construct(){
		
		$this->image  = PT_URL."/assets/images/admin/icon/image-block1.jpg";
		parent::__construct();
	}
	

	public function shortcode_frontend( $atts, $content ){
		extract( shortcode_atts( $this->default_options, $atts ) );
		
		if( !empty( $image ) ){	
			
			if(!is_numeric($image)){
			$imagesrc = $image;
			}else{ 
			$image_data = wp_get_attachment_image_src( $image, 'full' );
			$imagesrc = $image_data[0];
			}
		}

ob_start();
?>
<div class="image-block1 <?php echo esc_attr($extra_class); ?>" style="background-color:<?php echo $bgcolor; ?>;color:<?php echo $txtcolor; ?>;border-color:<?php echo $bdcolor; ?>">
	<?php if(isset($imagesrc)){ ?>
    <div class="image">
    	<a href='<?php echo $link; ?>'><img src="<?php echo $imagesrc; ?>" alt="image" class="img-responsive"></a>
    </div>
    <?php } ?>
    <div class="txt">
        <?php echo apply_filters( 'the_content', $content ); ?>
    </div>
</div> 

<?php
return ob_get_clean();
 
	}

	public function shortcode_options( $atts ){
		extract( shortcode_atts( $this->default_options, $atts ) );
		
		// DEFAULT CONTENT
		if($atts['pt_content'] == ""){ $atts['pt_content'] = "<h3>Title Text Here</h3><p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Praesent tempus eleifend risus ut congue.</p>"; }
		
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
				'value' => $atts['pt_content']
			),

			
			array(
				'id' => 'bgcolor',
				'title' => __( 'Background Color', 'pt-builder' ),
				'desc' => __( 'Select a background color.', 'pt-builder' ),
				'type' => 'colorpicker',
				'value' => $bgcolor
			),
			
			array(
				'id' => 'bdcolor',
				'title' => __( 'Border Color', 'pt-builder' ),
				'desc' => __( 'Select a border color.', 'pt-builder' ),
				'type' => 'colorpicker',
				'value' => $bdcolor
			),
			
			array(
				'id' => 'txtcolor',
				'title' => __( 'Text Color', 'pt-builder' ),
				'desc' => __( 'Select a text color.', 'pt-builder' ),
				'type' => 'colorpicker',
				'value' => $txtcolor
			),
 			array(
				'id' => 'image',
				'title' => __( 'Image', 'pt-builder' ),
				'desc' => __( 'Select an image you want to use.', 'pt-builder' ),
				'type' => 'image',
				'value' => $image
			),
			array(
				'id' => 'link',
				'title' => __( 'Image Link', 'pt-builder' ),
				'desc' => __( 'Input a link the user will view when clicking the image..', 'pt-builder' ),
				'type' => 'textfield',
				'value' => $link
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