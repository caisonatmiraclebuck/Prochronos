<?php

class PT_Core_Search2 extends PT_Shortcode{
	
	public $icon = '<span class="fa fa-search"></span>';
	public $name = 'Search Style 2';
	public $description = 'Add a search block to the page';
	public $category = '9. Search';
	public $image;
	public $default_options = array(
		'element_name' 	=> 'Search Style 2',  
		'images' => '',
		'extra_class'	=> '',
 
	);		

	function __construct(){
	
		$this->image  = PT_URL."/assets/images/admin/icon/search2.jpg";
		parent::__construct();
	}
	

	public function shortcode_frontend( $atts, $content ){
		extract( shortcode_atts( $this->default_options, $atts ) );
		
		global $CORE;
		
		// UNIQUE ID
		$ranid 		= rand();	
		
		
		if( !empty( $images ) ){
			$image_ids = explode( ",", $images );
			$slides = '';
			$indicators = '';
			for( $i=0; $i<sizeof( $image_ids ); $i++ ){
				$image_id = $image_ids[$i];
				$image_data = wp_get_attachment_image_src( $image_id, 'full' );
				if( !empty( $image_data ) ){
					$image_post = get_post( $image_id );
				 
					$slides .= '<img src="'.esc_url($image_data[0]).'" class="img-responsive">';
				}
			}
		}else{
		$slides = '<img src="http://placehold.it/750x400" alt="example slide" class="img-responsive">';
		}
		
		// BUILD DISPLAY
		ob_start();
		
	
	  
		?>
      <div class="wlt_builder_search style2"><div class="container-fluid"><div class="row">  
              
        	<div class="col-md-4">  
                      
                <div class="panel panel-default"> 
                            
                    <div class="panel-body">
                    <?php 	echo apply_filters( 'the_content', $content  ); ?>               
                 
                    <?php echo do_shortcode('[ADVANCEDSEARCH home=yes]'); ?>
                                
                    </div>                
                </div> 
                       
            </div> 
                       
            <div class="col-md-8"> 
            
                <div id="slider2<?php echo $ranid; ?>" class="owl-carousel">
                 <?php echo $slides; ?>
                </div>
                <script> 
                jQuery(document).ready(function() { 	 
                    jQuery("#slider2<?php echo $ranid; ?>").owlCarousel({ items : 1, autoPlay : true,  });   
                });
                </script> 
                                         
            </div>
            
        </div></div></div>
 
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
				'id' => 'pt_content',
				'title' => __( 'Text', 'pt-builder' ),
				'desc' => __( 'Write the text to appear above the search form here.', 'pt-builder' ),
				'type' => 'editor',
				'value' => $atts['pt_content'],
			),
		 	
			
			array(
				'id' => 'images',
				'title' => __( 'Select Imagess', 'pt-builder' ),
				'desc' => __( 'Select images you want to add to the slider.', 'pt-builder' ),
				'type' => 'images',
				'value' => $images
			),				 
		);
		
		$options_html = new PT_Options( $options );
		
		return $options_html->get_options();
	}	
}

?>