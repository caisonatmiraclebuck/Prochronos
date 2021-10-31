<?php

class PT_Core_Category2 extends PT_Shortcode{
	
	public $icon = '<span class="fa fa-sitemap"></span>';
	public $name = 'Category Style 2';
	public $description = 'Add a category block to the page';
	public $category = '4. Category';
	public $image;
	public $default_options = array(
		'element_name' => 'Category Style 2', 
		'perrow' => '3',
		 
		'showimg' => 'yes',
		'subcats' => 'yes',
		'showdesc' => 'yes',
		'maxsubcats' => 4,
		'cats' => '',
		'order' => 'asc',
	);		

	function __construct(){
	
		$this->image  = PT_URL."/assets/images/admin/icon/category2.jpg";
		parent::__construct();
	}
	

	public function shortcode_frontend( $atts, $content ){
		extract( shortcode_atts( $this->default_options, $atts ) );
	 	
		// UNIQUE ID
		$ranid 		= rand();
		ob_start();
		?>


<div class="wlt_builder_category style2 cols3">
 
<ul>
<?php
		$i = 1; $n = 1;
		$args = array(
			  'taxonomy'     => THEME_TAXONOMY,
			  'orderby'      => 'name',
			  'order'		=> $order,
			  'include' 	=> $cats,
			  'show_count'   => 0,
			  'pad_counts'   => 1,
			  'hierarchical' => 0,
			  'title_li'     => '',
			  'hide_empty'   => 0,			 
			 
		);
$categories = get_categories($args);
 

foreach ($categories as $category) { 
 	
		// IMAGE
		$image = "";
		if($showimg == "yes"){
			if(isset($category->term_id) && isset($GLOBALS['CORE_THEME']['category_icon_'.$category->term_id])   ){
			$image = $GLOBALS['CORE_THEME']['category_icon_'.$category->term_id];
			}else{
			$image = get_template_directory_uri()."/framework/img/demo/noimage.png";
			}
		}
		// LINK 
		$link = get_term_link($category);
		
		// PER ROW CSS 
		switch($perrow){
		case 1: { $css = "col-xs-12 col-md-12 col-sm-12";} break;
		case 2: { $css = "col-xs-12 col-md-6 col-sm-6";} break;
		case 3: { $css = "col-xs-12 col-md-4 col-sm-4";} break;
		case 4: { $css = "col-xs-12 col-md-3 col-sm-3";} break;
		default: { $css = "col-xs-12 col-md-4 col-sm-6";}
		
		}

?>

<li class="<?php echo $css; ?>">
	
    
    <div class="media">
    <?php if($showimg == "yes"){ ?>
    <a class="hidden-xs" href="<?php echo $link; ?>">
        <img class="media-object img-responsive cimg<?php echo $i; ?>" alt="<?php echo $category->name; ?>" src="<?php echo $image; ?>">
    </a>
    <?php } ?>
    
    <div class="media-body">
    
    <h4 class="media-heading"><a href="<?php echo $link; ?>"><?php echo $category->name; ?></a></h4>
   <?php if($showdesc == "yes"){ ?>
   <div class="catdesc"><?php echo $category->description; ?></div>
    <?php } ?>
    <?php
	if($subcats == "yes"){
	 
		$s = wp_list_categories("echo=0&taxonomy=".THEME_TAXONOMY."&title_li=&hierarchical=0&hide_empty=0&child_of=".$category->term_id);
		$showf = explode("</li>",$s);
		if(strlen($s) > 25 && strpos($s, "No categories") === false){
			$STRING = '<ul class="list-inline">';
							$ss = 0;
							foreach($showf as $subcat){ 
								if($ss >= $maxsubcats){ continue; }
								$STRING .= trim($subcat."</li>");
								$ss++;
							}
			$STRING .= '</ul>';
			echo $STRING;
		}	
	}
	?>
    
     
    </div>
    </div>
    
</li>
<?php
 
$i++;
}

?>
</ul>
<div class="clearfix"></div>
 
</div>

        
        <?php
		return ob_get_clean();
 
	}

	public function shortcode_options( $atts ){
		extract( shortcode_atts( $this->default_options, $atts ) );
		
		
		$args = array(
				  'taxonomy'     => THEME_TAXONOMY,				 
				  'show_count'   => 0,
				  'pad_counts'   => 1,
				  'hierarchical' => 0,				 		 
				  'hide_empty'   => 0,
				  'orderby' => 'id',
				 
				);			
				 
				$catList = array();
				$categories = get_categories($args); 				
				foreach ($categories as $category) {
				
					if($category->parent != 0){
						$catList[$category->term_id] = " -- ".$category->name;
					}else{
						$catList[$category->term_id] = $category->name;
					}				
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
				'id' => 'perrow',
				'title' => __( 'Items Per Row', 'pt-builder' ),
				'desc' => __( 'Enter a numerical value for the number of categories to show per row.', 'pt-builder' ),
				'type' => 'select',
				'options' => array(
					'1' => 1,
					'2' => 2,
					'3' => 3,
					'4' => 4,
					 
				),
				'value' => $perrow
			),	
 
			
array(
				'id' => 'cats',
				'title' => __( 'Display Categories', 'pt-builder' ),
				'desc' => __( 'Hold Ctrl and select to choose multiple categories.', 'pt-builder' ),
				'type' => 'multiple',
				'options' => $catList,
				'value' => $cats
			),	
			
			array(
				'id' => 'order',
				'title' => __( 'Display Order', 'pt-builder' ),
				'desc' => __( 'Select category display order', 'pt-builder' ),
				'type' => 'select',
				'options' => array(
					'asc' => "Ascending Order",
					'desc' => "Descending Order",
				),
				'value' => $order
			),	
			
			array(
				'id' => 'showimg',
				'title' => __( 'Show Image', 'pt-builder' ),
				'desc' => __( 'Show or hide image display.', 'pt-builder' ),
				'type' => 'select',
				'options' => array(
					'yes' => "Yes",
					'no' => "No",
				),
				'value' => $showimg
			),
			
			array(
				'id' => 'showdesc',
				'title' => __( 'Show Description', 'pt-builder' ),
				'desc' => __( 'Show or hide the category description.', 'pt-builder' ),
				'type' => 'select',
				'options' => array(
					'yes' => "Yes",
					'no' => "No",
				),
				'value' => $showdesc
			),
			
				array(
				'id' => 'subcats',
				'title' => __( 'Show Sub Categories', 'pt-builder' ),
				'desc' => __( 'Show or hide sub categories', 'pt-builder' ),
				'type' => 'select',
				'options' => array(
					'yes' => "Yes",
					'no' => "No",
				),
				'value' => $subcats
			),
			
			array(
				'id' => 'maxsubcats',
				'title' => __( 'Sub Categories #', 'pt-builder' ),
				'desc' => __( 'Enter a numerical value for the maximum number of sub categories to display.', 'pt-builder' ),
				'type' => 'textfield',
				 
				'value' => $maxsubcats
			),
		 			
		);
		
		$options_html = new PT_Options( $options );
		
		return $options_html->get_options();
	}	
}

?>