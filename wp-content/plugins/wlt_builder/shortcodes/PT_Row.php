<?php

class PT_Row extends PT_Shortcode{

	public $image;
	
	function __construct(){
		$this->default_options = array(
			'element_name' => __( 'Row', 'pt-builder' )
		);		
		parent::__construct();
	}
	
	public function shortcode_frontend( $atts, $content ){
		return '<div class="row">'.do_shortcode( $content ).'</div>';
	}

	public function shortcode_admin( $atts, $content ){
		extract( shortcode_atts( $this->default_options, $atts ) );

		return '<div class="pt-row pt-element-root" data-shortcode_id="'.esc_attr($atts['shortcode_id']).'" data-shortcode_element="PT_Row">
		
					<div class="pt-actions clearfix" style="float:left; width:30px; height:100%;  padding:0px;  padding-right:10px; margin-right:10px; padding-bottom: 10px;">	
										
						<a href="javascript:;" style="float:none;" class="pt-row-drag" title="'.__( 'Drag Row', 'pt-builder' ).'"><span class="fa fa-arrows"></span></a>	
																	
						<a href="javascript:;" class="pt-edit" title="'.__( 'Edit Element', 'pt-builder' ).'"><span class="fa fa-pencil"></span></a>
						
						<a href="javascript:;" class="pt-columns" onclick="showcolbox(\'colsbox_'.esc_attr($atts['shortcode_id']).'\')" title="'.__( 'Edit Columns', 'pt-builder' ).'"><span class="fa fa-table"></span></a>
						
						<div  id="colsbox_'.esc_attr($atts['shortcode_id']).'" style="display:none;">
							<a href="javascript:;" class="pt-layout" title="1/1"><img src="'.PT_URL.'/assets/images/admin/layout/1_1.png" /></a>
							<a href="javascript:;" class="pt-layout" title="1/2 + 1/2"><img src="'.PT_URL.'/assets/images/admin/layout/12_12.png" /></a>
							<a href="javascript:;" class="pt-layout" title="1/3 + 1/3 + 1/3"><img src="'.PT_URL.'/assets/images/admin/layout/13_13_13.png" /></a>
							<a href="javascript:;" class="pt-layout" title="1/4 + 1/4 + 1/4 + 1/4"><img src="'.PT_URL.'/assets/images/admin/layout/14_14_14_14.png" /></a>
							<a href="javascript:;" class="pt-layout" title="3/12 + 6/12 + 3/12"><img src="'.PT_URL.'/assets/images/admin/layout/312_612_312.png" /></a>
							<a href="javascript:;" class="pt-layout" title="3/12 + 9/12"><img src="'.PT_URL.'/assets/images/admin/layout/312_912.png" /></a>
							<a href="javascript:;" class="pt-layout" title="9/12 + 3/12"><img src="'.PT_URL.'/assets/images/admin/layout/912_312.png" /></a>
						</div> 
						
												
						<a href="javascript:;" class="pt-custom-layout" title="'.__( 'Build Custom Layout', 'pt-builder' ).'"><span class="fa fa-align-left"></span></a>
					 	
						<!--<span class="pt-element-name">'.$element_name.'</span>-->
					 	<a href="javascript:;" class="pt-clone" title="'.__( 'Clone Element', 'pt-builder' ).'"><span class="fa fa-copy"></span></a>
						<a href="javascript:;" class="pt-delete" title="'.__( 'Delete Element', 'pt-builder' ).'"><span class="fa fa-trash-o"></span></a>
						
						<!--<a href="javascript:;" class="pt-colapse" title="'.__( 'Toggle Display Of Element', 'pt-builder' ).'"><span class="fa fa-caret-up"></span></a>-->
						
					</div>
					<div class="pt-row-content '.esc_attr($atts['shortcode_id']).' clearfix pt-collapsible" style="overflow:hidden;">
						'.do_shortcode( $content ).'
					</div>
				</div>';
	}

	public function shortcode_options( $atts = array() ){
		extract( shortcode_atts( $this->default_options, $atts ) );
		$options = array(
			array(
				'id' => 'element_name',
				'title' => __( 'Row Name', 'pt-builder' ),
				'desc' => __( 'Input custom row name for easy recognition.', 'pt-builder' ),
				'type' => 'textfield',
				'value' => $element_name
			)
		);
		
		$options_html = new PT_Options( $options );
		
		return $options_html->get_options();
	}
}

?>