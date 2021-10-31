<?php

class PT_Core_Search extends PT_Shortcode{
	
	public $icon = '<span class="fa fa-search"></span>';
	public $name = 'Basic Search';
	public $description = 'Add a search block to the page';
	public $category = '9. Search';
	public $image;
	public $default_options = array(
		'element_name' 	=> 'Search',
 		'type' 			=> 0,
		'w' 			=> '100%',
		'h' 			=> '400px',
		'extra_class'	=> '',
 
	);		

	function __construct(){
	
		//$this->image  = PT_URL."/assets/images/admin/icon/youtube.jpg";
		parent::__construct();
	}
	

	public function shortcode_frontend( $atts, $content ){
		extract( shortcode_atts( $this->default_options, $atts ) );
		
		global $CORE;
		
		// UNIQUE ID
		$ranid 		= rand();		
		
		// BUILD DISPLAY
		ob_start();
		
		echo apply_filters( 'the_content', $content  );
		
		// DSPLAY SEARCH
		if($type == 0){
		
			$advance_search = Core_Advanced_Search::instance();
			echo $advance_search->build_form( null, true );		
		
		}else{
 	 
		?>       
		 
        <div class="wlt_builder_search row <?php echo $extra_class; ?>">
        
        <form role="search" method="get" id="searchform" class="searchform navbar-form navbar-left" action="<?php echo esc_url( home_url( '/' ) ); ?>">
         
  			<div class="form-group">
                <input type="text" value="<?php echo get_search_query(); ?>" name="s" id="s" class="form-control" />
               
        	</div>
               <input type="submit" id="searchsubmit" value="<?php echo esc_attr_x( 'Search', 'submit button' ); ?>" class="btn btn-default" />
        </form>
        </div>
 
		<?php
		
		}
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
				'id' => 'type',
				'title' => __( 'Display Type', 'pt-builder' ),
				'desc' => __( 'Show or hide carousel navigation.', 'pt-builder' ),
				'type' => 'select',
				'options' => array(
					1 => "Basic Search",
					0 => "Advanced Search",
				),
				'value' => $type
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