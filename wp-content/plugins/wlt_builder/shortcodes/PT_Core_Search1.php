<?php

class PT_Core_Search1 extends PT_Shortcode{
	
	public $icon = '<span class="fa fa-search"></span>';
	public $name = 'Search Style 1';
	public $description = 'Add a search block to the page';
	public $category = '9. Search';
	public $image;
	public $default_options = array(
		'element_name' 	=> 'Search Style 1',
  
		'w' 			=> '100%',
		'h' 			=> '400px',
		'extra_class'	=> '',
 
	);		

	function __construct(){
	
		$this->image  = PT_URL."/assets/images/admin/icon/search1.jpg";
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
	  
		?>
        <div class="clearfix"></div>
        <div class="wlt_builder_search style1 row <?php echo $extra_class; ?>">
        <div class="well">    
				<form method="get" action="<?php echo get_home_url(); ?>/" class="clearfix">
				<div class="col-md-5">        
					<input type="text" value="" placeholder="<?php echo $CORE->_e(array('homepage','6','flag_noedit')); ?>" class="hsk form-control" name="s" />        
				</div>
				<div class="col-md-5">        
					<select name="cat1" class="form-control"><option value="">&nbsp;</option><?php echo $CORE->CategoryList(array(0,false,0,THEME_TAXONOMY)); ?></select> 
				</div>
				<div class="col-md-2">
				<button class="btn btn-primary"><?php echo $CORE->_e(array('button','11')); ?></button>     
				</div>
				</form>
        </div>      
		</div>
 
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