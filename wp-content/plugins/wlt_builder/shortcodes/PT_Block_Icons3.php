<?php

class PT_Block_Icons3 extends PT_Shortcode{
	
	public $icon = '<span class="fa fa-compass"></span>';
	public $name = 'Icon Block 3';
	public $description = 'Add icon block to the page.';
	public $image;
	public $category = '3. Text';
	public $default_options = array(
		'element_name' => 'Icon Block 3',
		'extra_class' => '',
		'icon' => 'fa-cog',
		'bdcolor' => '#efefef',
		'bgcolor' => '#3498db',
		'txtcolor' => '#ffffff',
	);		

	function __construct(){
		
		$this->image  = PT_URL."/assets/images/admin/icon/icon-block3.jpg";
		parent::__construct();
	}
	

	public function shortcode_frontend( $atts, $content ){
		extract( shortcode_atts( $this->default_options, $atts ) );

ob_start();
?>

<div class="icon-block3 <?php echo esc_attr($extra_class); ?>" style="border-color:<?php echo $bdcolor; ?>">
    <div class="icon" style="background:<?php echo $bgcolor; ?>; color:<?php echo $txtcolor; ?>;">
        <i class="fa <?php echo $icon; ?>"></i>
    </div>
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
				'id' => 'icon',
				'title' => __( 'Icon', 'pt-builder' ),
				'desc' => __( 'Select an icon for this element.', 'pt-builder' ),
				'type' => 'iconpicker',
				'value' => $icon
			),
			array(
				'id' => 'extra_class',
				'title' => __( 'Extra Class', 'pt-builder' ),
				'desc' => __( 'Input extra class for the element.', 'pt-builder' ),
				'type' => 'textfield',
				'value' => $extra_class
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
			
						
		);
		
		$options_html = new PT_Options( $options );
		
		return $options_html->get_options();
	}	
}

?>