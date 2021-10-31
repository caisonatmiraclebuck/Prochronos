<?php

class PT_Image_Slider_Boxes extends PT_Shortcode{
	
	public $icon = '<span class="fa fa-camera"></span>';
	public $name = 'Slider + Boxes';
	public $description = 'Add image slider element to the page';
	public $category = '1. Sliders';
	public $image;
	public $default_options = array(
		'images' => '',
		'caption' => 'yes',
		'delay' => 5000,
		'navigation' => 'yes',
		'arrows' => 'yes',
		'element_name' => 'Image Slider',
		'extra_class' => '',
		
		'box1' => '<span>Title Here</span>Paragraph text here',
		'box1_link' => '',
		'box1_color' => '',
		'box1_h' => '150px',
		
		'box2' => '<span>Title Here</span>Paragraph text here',
		'box2_link' => '',
		'box2_color' => '',
		'box2_h' => '150px',
		
		'box3' => '<span>Title Here</span>Paragraph text here',
		'box3_link' => '',
		'box3_color' => '',
		'box3_h' => '150px',
		
		'box4' => '',
		'box4_link' => '',
		'box4_color' => '',
		'box4_h' => '150px',			
				
	);	

	function __construct(){
	
		$this->image  = PT_URL."/assets/images/admin/icon/slider-image2.jpg";
		parent::__construct();
	}
	

	public function shortcode_frontend( $atts, $content ){
		extract( shortcode_atts( $this->default_options, $atts ) );

		$random_string = pt_random_string();
		$html = '';		
		if( !empty( $images ) ){
			$image_ids = explode( ",", $images );
			$slides = '';
			$indicators = '';
			for( $i=0; $i<sizeof( $image_ids ); $i++ ){
				$image_id = $image_ids[$i];
				$image_data = wp_get_attachment_image_src( $image_id, 'full' );
				if( !empty( $image_data ) ){
					$image_post = get_post( $image_id );
					$indicators .= '<li data-target="#'.esc_attr($random_string).'" data-slide-to="'.esc_attr($i).'" class="'.( $i == 0 ? esc_attr('active') : '' ).'"></li>';
					$slides .= '<div class="item '.( $i == 0 ? esc_attr('active') : '' ).'">
                            		<img src="'.esc_url($image_data[0]).'">
                            		<div class="carousel-caption">
                                		'.( $caption == 'yes' ? $image_post->post_excerpt : '' ).'
                            		</div>
                        		</div>';
				}
			}
			$html = '<div id="'.esc_attr($random_string).'" class="carousel slide '.esc_attr($extra_class).'" data-ride="carousel" data-interval="'.esc_attr($delay).'">';
			if( $navigation == 'yes' ){
				$html .= '<ol class="carousel-indicators">'.$indicators.'</ol>';
			}
			$html .= '<div class="carousel-inner">'.$slides.'</div>';
			if( $arrows == 'yes' ){
				$html .= '
                    <a class="left carousel-control" href="#'.esc_attr($random_string).'" role="button" data-slide="prev">
                        <span class="glyphicon glyphicon-chevron-left"></span>
                    </a>
                    <a class="right carousel-control" href="#'.esc_attr($random_string).'" role="button" data-slide="next">
                        <span class="glyphicon glyphicon-chevron-right"></span>
                    </a>
				';
			}
			$html .= '</div>';
		}
		
		
		ob_start();
		?>
 
<div id="PT_Image_Slider_Boxes">
<div class="row">

	<div class="col-md-8">
		
        
        <div id="car-slider" class="owl-carousel owl-theme">
         
         <?php echo $html; ?> 
        </div> 
                 
        <script>
        jQuery(document).ready(function() {
        jQuery("#car-slider").owlCarousel({ 
              slideSpeed : 300,
              singleItem:true 
          }); 
        });
        </script>

	</div>
	 
	<div class="col-md-4">	
	
		<div class="bannerboxside">
			
            <?php if(strlen($box1) > 1){ ?>
			<div  style="background:<?php echo $box1_color; ?>; height:<?php echo $box1_h; ?>">
            <a href="<?php echo $box1_link; ?>">
            <?php echo stripslashes($box1); ?>       
            </a>            
            </div>
            <?php } ?>
            
            <?php if(strlen($box2) > 1){ ?>
			<div  style="background:<?php echo $box2_color; ?>; height:<?php echo $box2_h; ?>">
            <a href="<?php echo $box2_link; ?>">
            <?php echo stripslashes($box2); ?>       
            </a>            
            </div>
            <?php } ?>
            
            <?php if(strlen($box3) > 1){ ?>
			<div  style="background:<?php echo $box3_color; ?>; height:<?php echo $box3_h; ?>">
            <a href="<?php echo $box3_link; ?>">
            <?php echo stripslashes($box3); ?>       
            </a>            
            </div>
            <?php } ?>
            
            <?php if(strlen($box4) > 1){ ?>
			<div  style="background:<?php echo $box4_color; ?>; height:<?php echo $box4_h; ?>">
            <a href="<?php echo $box4_link; ?>">
            <?php echo stripslashes($box4); ?>       
            </a>            
            </div>
            <?php } ?>
            
            
			
		</div>	
		
	</div>
</div>
</div>
        <?php
		return ob_get_clean();
		
		

		return $html;
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
				'id' => 'images',
				'title' => __( 'Select Imagess', 'pt-builder' ),
				'desc' => __( 'Select images you want to add to the slider.', 'pt-builder' ),
				'type' => 'images',
				'value' => $images
			),
			array(
				'id' => 'caption',
				'title' => __( 'Show Captions', 'pt-builder' ),
				'desc' => __( 'Show or hide image captions.', 'pt-builder' ),
				'type' => 'select',
				'options' => array(
					'yes' => __( 'Yes', 'pt-builder' ),
					'no' => __( 'No', 'pt-builder' )
				),
				'value' => $caption
			),	
			array(
				'id' => 'delay',
				'title' => __( 'Delay', 'pt-builder' ),
				'desc' => __( 'Set delay between the slides in miliseconds. If the value is 0 than it will not autoplay.', 'pt-builder' ),
				'type' => 'textfield',
				'value' => $delay
			),
			array(
				'id' => 'navigation',
				'title' => __( 'Show Navigation', 'pt-builder' ),
				'desc' => __( 'Show or hide navigation bullets.', 'pt-builder' ),
				'type' => 'select',
				'options' => array(
					'yes' => __( 'Yes', 'pt-builder' ),
					'no' => __( 'No', 'pt-builder' )
				),
				'value' => $navigation
			),
			array(
				'id' => 'arrows',
				'title' => __( 'Show Arrows', 'pt-builder' ),
				'desc' => __( 'Show or hide navigation arrows.', 'pt-builder' ),
				'type' => 'select',
				'options' => array(
					'yes' => __( 'Yes', 'pt-builder' ),
					'no' => __( 'No', 'pt-builder' )
				),
				'value' => $arrows
			),
			
			/*array(
				'id' => 'extra_class',
				'title' => __( 'Extra Class', 'pt-builder' ),
				'desc' => __( 'Input extra class for the element.', 'pt-builder' ),
				'type' => 'textfield',
				'value' => $extra_class
			),*/
			
			
			array(
				'id' => 'box1',
				'title' => __( 'Box 1 Text', 'pt-builder' ),
				'desc' => __( 'Input text for this box.', 'pt-builder' ),
				'type' => 'textfield',
				'value' => $box1
			),
			array(
				'id' => 'box1_link',
				'title' => __( 'Box 1 Link', 'pt-builder' ),
				'desc' => __( 'Enter the the link URL.', 'pt-builder' ),
				'type' => 'textfield',
				'value' => $box1_link
			),
			array(
				'id' => 'box1_h',
				'title' => __( 'Box 1 Height', 'pt-builder' ),
				'desc' => __( 'Input a height value.', 'pt-builder' ),
				'type' => 'textfield',
				'value' => $box1_h
			),
			array(
				'id' => 'box1_color',
				'title' => __( 'Box 1 Background Color', 'pt-builder' ),
				'desc' => __( 'Select a background color.', 'pt-builder' ),
				'type' => 'colorpicker',
				'value' => $box1_color
			),	
			
			
					
			array(
				'id' => 'box2',
				'title' => __( 'Box 2 Text', 'pt-builder' ),
				'desc' => __( 'Input text for this box.', 'pt-builder' ),
				'type' => 'textfield',
				'value' => $box2
			),
			array(
				'id' => 'box2_link',
				'title' => __( 'Box 2 Link', 'pt-builder' ),
				'desc' => __( 'Enter the the link URL.', 'pt-builder' ),
				'type' => 'textfield',
				'value' => $box2_link
			),
			array(
				'id' => 'box2_h',
				'title' => __( 'Box 2 Height', 'pt-builder' ),
				'desc' => __( 'Input a height value.', 'pt-builder' ),
				'type' => 'textfield',
				'value' => $box2_h
			),
			array(
				'id' => 'box2_color',
				'title' => __( 'Box 2 Background Color', 'pt-builder' ),
				'desc' => __( 'Select a background color.', 'pt-builder' ),
				'type' => 'colorpicker',
				'value' => $box2_color
			),	
			
			
			
			array(
				'id' => 'box3',
				'title' => __( 'Box 3 Text', 'pt-builder' ),
				'desc' => __( 'Input text for this box. (Leave blank to disable)', 'pt-builder' ),
				'type' => 'textfield',
				'value' => $box3
			),
			array(
				'id' => 'box3_link',
				'title' => __( 'Box 3 Link', 'pt-builder' ),
				'desc' => __( 'Enter the the link URL.', 'pt-builder' ),
				'type' => 'textfield',
				'value' => $box3_link
			),
			array(
				'id' => 'box3_h',
				'title' => __( 'Box 3 Height', 'pt-builder' ),
				'desc' => __( 'Input a height value.', 'pt-builder' ),
				'type' => 'textfield',
				'value' => $box3_h
			),
			array(
				'id' => 'box3_color',
				'title' => __( 'Box 3 Background Color', 'pt-builder' ),
				'desc' => __( 'Select a background color.', 'pt-builder' ),
				'type' => 'colorpicker',
				'value' => $box3_color
			),	
			
			
			array(
				'id' => 'box4',
				'title' => __( 'Box 4 Text', 'pt-builder' ),
				'desc' => __( 'Input text for this box. (Leave blank to disable)', 'pt-builder' ),
				'type' => 'textfield',
				'value' => $box4
			),
			array(
				'id' => 'box4_link',
				'title' => __( 'Box 4 Link', 'pt-builder' ),
				'desc' => __( 'Enter the the link URL.', 'pt-builder' ),
				'type' => 'textfield',
				'value' => $box4_link
			),
			array(
				'id' => 'box4_h',
				'title' => __( 'Box 4 Height', 'pt-builder' ),
				'desc' => __( 'Input a height value.', 'pt-builder' ),
				'type' => 'textfield',
				'value' => $box1_h
			),
			array(
				'id' => 'box4_color',
				'title' => __( 'Box 4 Background Color', 'pt-builder' ),
				'desc' => __( 'Select a background color.', 'pt-builder' ),
				'type' => 'colorpicker',
				'value' => $box1_color
			),	
						
			
		);
		
		$options_html = new PT_Options( $options );
		
		return $options_html->get_options();
	}	
}

?>