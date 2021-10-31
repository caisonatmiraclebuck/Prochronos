<?php
/**
 * Plugin Name: [BUILDER] - PremiumPress Page Builder
 * Plugin URI: 
 * Description: Create custom page layouts with this PremiumPress page builder.
 * Version: 2.2
 * Author URI: http://www.premiumpress.com
 * Dare: Sep 28th, 2016
 */
 
if ( ! defined( 'ABSPATH' ) ) exit;

define( 'WLT_PAGE_BUILDER', true );

/* set global variables */
if ( ! defined( 'PT_PATH') ){
	define( 'PT_PATH', str_replace( '\\', '/', dirname( __FILE__ ) ) );
}
if ( ! defined( 'PT_URL' ) ){
	define( 'PT_URL', str_replace( str_replace( '\\', '/', WP_CONTENT_DIR ), str_replace( '\\', '/', WP_CONTENT_URL ), PT_PATH ) );
}


global $WLT_BUILDER_SHORTCODES;
global $FIELDS;
$WLT_BUILDER_SHORTCODES = array();
$FIELDS = array();

/* LOAD REQUIRED FILES */
require( PT_PATH.'/includes/helpers.php' );	
require( PT_PATH.'/includes/admin/abstract/PT_Shortcode.php' );
require( PT_PATH.'/includes/admin/abstract/PT_Field.php' );
require( PT_PATH.'/includes/admin/PT_Options.php' );

//add_filter('wpseo_pre_analysis_post_content', 'add_custom_to_yoast1');
function add_custom_to_yoast1( $content ) {
	global $post;
	$pid = $post->ID;
 

	$custom = get_post_custom($pid);
	die($custom);
	unset($custom['_yoast_wpseo_focuskw']); // Don't count the keyword in the Yoast field!

	foreach( $custom as $key => $value ) {
		if( substr( $key, 0, 1 ) != '_' && substr( $value[0], -1) != '}' && !is_array($value[0]) && !empty($value[0])) {
		  $custom_content .= $value[0] . ' ';
		}

	}

	$content = $content . ' ' . $custom_content;
	return $content;

	remove_filter('wpseo_pre_analysis_post_content', 'add_custom_to_yoast1'); // don't let WP execute this twice
}

/* LOAD ADMIN RESOURCES */
add_action( 'admin_enqueue_scripts', 'pt_load_admin_dependencies' );
function pt_load_admin_dependencies(){
	
	global $pagenow, $post;
		
	if( ( is_admin() && ( $pagenow == "post.php" || $pagenow == "post-new.php" ) )  ){
	
		if( in_array( $pagenow, array( 'post.php', 'post-new.php' ) ) && $post->post_type == "page"  ){
	 
			require( PT_PATH.'/includes/admin/styles_scrpts.php' );
		}
	}
 
}

/* LOAD FRONTEND BASIC RESOURCES */
add_action( 'wp_enqueue_scripts', 'pt_load_frontend_dependencies' );
function pt_load_frontend_dependencies(){

	/* jQUERY */
	wp_enqueue_script( 'jquery' );
	wp_enqueue_script( 'pt-frontend-js', PT_URL . '/assets/js/frontend/frontend.js', false, false, true);

	/* BOOTSTRAP */	
	wp_enqueue_style( 'pt-bootstrap-css' );
	wp_enqueue_script( 'pt-bootstrap-js' );

	/* FONT AWESOME */
	wp_enqueue_style( 'pt-font-awesome-css' );	

 
}
function my_theme_add_editor_styles() {



	// LOAD IN BOOTSTRAP STYLES FOR EDITOR	
	add_editor_style( PT_URL . '/third_party/bootstrap/css/bootstrap.min.css');
 
}
add_action( 'admin_init', 'my_theme_add_editor_styles' );
/* LOAD TEXT DOMAIN */
function pt_load_textdomain(){
	$textdomain = 'pt-builder';
	$locale = apply_filters( 'plugin_locale', get_locale(), $textdomain );
	// By default, try to load language files from /wp-content/languages/custom-meta-boxes/
	load_textdomain( $textdomain, PT_PATH . '/languages/' . $textdomain . '-' . $locale . '.mo' );	
	
}
add_action( 'init', 'pt_load_textdomain' );


function pt_tinymce_config( $init ) {
 
    $init['remove_linebreaks'] = false;
    $init['convert_newlines_to_brs'] = true;
    $init['remove_redundant_brs'] = false;
	
    if(!empty($in['extended_valid_elements'])){
        $in['extended_valid_elements'] .= ',';
	}

    $in['extended_valid_elements'] .= '@[id|class|style|title|itemscope|itemtype|itemprop|datetime|rel],div,div[*],dl,ul,ol,dt,dd,li,span,a|rev|charset|href|lang|tabindex|accesskey|type|name|href|target|title|class|onfocus|onblur]';
 	
    return $init;
	
}
add_filter('tiny_mce_before_init', 'pt_tinymce_config', 10);
 

/* LOAD FRONTEND STYLE AND CUSTOM CSS */
add_action( 'wp_enqueue_scripts', 'pt_load_frontend_style', 99999 );
function pt_load_frontend_style(){
	wp_enqueue_style( 'pt-builder-front-css');
}

add_action( 'wp_head','pt_custom_css', 99999 );
function pt_custom_css(){
	$post_meta = get_post_meta( get_the_ID() );	
	$pt_custom_css = !empty( $post_meta['pt_custom_css'] ) ? base64_decode( $post_meta['pt_custom_css'][0] ) : '';
	echo '<style>'.$pt_custom_css.'</style>';
}

/*
Check on which page we are and what to load
*/
add_action( 'wp_loaded', 'pt_check_page' );
function pt_check_page(){	

	if(!defined('THEME_VERSION')){ return; }

	if( is_admin() ){
		global $pagenow;

		if( in_array( $pagenow, array( 'post.php', 'post-new.php' ) ) ){
			/* load the resources */
			pt_load_shortcodes();
			add_action('admin_enqueue_scripts', 'pt_load_builder_data' );
			pt_load_fields();
		}
	}
	else{
		pt_load_shortcodes( true );
	}
}

/*
Load shortcodes for the admin section
*/
function pt_load_shortcodes( $instantiate = false ){	
	pt_load_classes( PT_PATH."/shortcodes/", true );

	do_action( 'pt_element_extend' );
}

/* ECHO BUILDER DATA */
function pt_load_builder_data(){
	global $WLT_BUILDER_SHORTCODES;
	$tags = array_keys( $WLT_BUILDER_SHORTCODES );
	$post_meta = get_post_meta( get_the_ID() );
	$pt_initial_start = !empty( $post_meta['pt_initial_start'] ) ? $post_meta['pt_initial_start'][0] : '0';
	$pt_custom_css = !empty( $post_meta['pt_custom_css'] ) ? $post_meta['pt_custom_css'][0] : '';
	echo '
		<script type="text/javascript">
			var pt_data = {
				tags: "'.join( "|", $tags ).'",
				url: "'.PT_URL.'",
				pt_initial_start: '.$pt_initial_start.',
				post_id: '.get_the_ID().',
				pt_custom_css: "'.$pt_custom_css.'"
			}
		</script>
	';
}

/* LOAD FIELDS FOR THE OPTIONS */
function pt_load_fields(){
	pt_load_classes( PT_PATH."/fields/", true );

	do_action( 'pt_field_extend' );
}


/*
Handle AJAX requests
*/
/* add new element */
add_action( 'wp_ajax_pt_add_new', 'pt_add_new' );
function pt_add_new(){
	pt_load_shortcodes();
	pt_load_fields();
	$shortcode_element = $_POST['shortcode_element'];
	$atts = array();
	if( isset( $_POST['params'] ) ){
		$atts = json_decode( stripslashes( $_POST['params'] ), true );
	}
	$object = new $shortcode_element;
	echo $object->shortcode_options( $atts );
	die();
}

/* edit element */
add_action( 'wp_ajax_pt_edit', 'pt_edit' );
function pt_edit(){
	pt_load_shortcodes();
	pt_load_fields();
	$shortcode_element = $_POST['shortcode_element'];
	$atts = array();
	if( isset( $_POST['params'] ) ){
		$atts = json_decode( stripslashes( $_POST['params'] ), true );
	}
	$object = new $shortcode_element;
	echo $object->shortcode_options( $atts );
	die();
}

/* create live preview */
add_action( 'wp_ajax_pt_build_preview_admin', 'pt_build_preview_admin' );
function pt_build_preview_admin(){
	global $STYLES;
	pt_load_shortcodes( true );
	$content = stripslashes( $_POST['content'] );
	$content_html = do_shortcode( $content );	
	die();
}

/* create initial content */
add_action( 'wp_ajax_pt_build_shortcode_admin', 'pt_build_shortcode_admin' );
function pt_build_shortcode_admin(){
	pt_load_shortcodes( true );
	$content = stripslashes( $_POST['content'] );
	$content_html = do_shortcode( $content );
	echo $content_html;
	die();
}

/*  */
add_action( 'wp_ajax_pt_update_meta', 'pt_update_meta' );
function pt_update_meta(){
	$post_id = $_POST['post_id'];
	$meta_key = $_POST['meta_key'];
	$meta_value = $_POST['meta_value'];

	update_post_meta( $post_id, $meta_key, $meta_value );
}
 
/* create listof available elements */
add_action( 'wp_ajax_pt_elements_listing', 'pt_elements_listing' );
function pt_elements_listing(){
	global $WLT_BUILDER_SHORTCODES;
	pt_load_shortcodes( true );
	$listing_nav_array = array();
	$listing_nav = '<ul class="pt-elements-list-filter">';
	$listing_html = '<div class="pt-elements-list">';
	$not_list = array( 'pt_section', 'pt_row', 'pt_column' );
	
	asort($WLT_BUILDER_SHORTCODES);
	
	foreach( $WLT_BUILDER_SHORTCODES as $key => $shortcode_data ){
 
		if( !in_array( $key, $not_list ) ){
			if( !in_array( $shortcode_data['category'], $listing_nav_array) ){
				$listing_nav_array[] = $shortcode_data['category'];
				$listing_nav .=  '<li><a href="javascript:;" class="pt-element-filter" data-group="'.esc_attr($shortcode_data['category']).'">'.ucwords( $shortcode_data['category']).'</li>';
			}
			$listing_html .= '<div class="pt-element-item" data-groups=\'["'.esc_attr($shortcode_data['category']).'"]\' data-image="'.htmlentities( $shortcode_data['image'] ).'" data-description="'.htmlentities( $shortcode_data['description'] ).'">
								<div class="pt-element-item-wrap">
									<a href="javascript:;" class="pt-add" data-shortcode_id="'.esc_attr($_POST['parent']).'" data-contain_shortcode_element="'.esc_attr($key).'">
										<div class="pt-element-text">
											'.$shortcode_data['icon'].'
											<p>'.$shortcode_data['name'].'</p>
										</div>
							  		</a>
							  	</div>
							   </div>';
		}
	}
	$listing_nav .= '</ul>';
	$listing_html .= '</div>';

	echo $listing_nav . $listing_html . '<div class="pt-element-description"></div>';
	die();
}


/* REGISTER TEMPLATE CUSTOM POST TYPE */
function pt_register_post_type(){

$args = array(
 
		'show_ui'            => false,
		 
 
	);
	register_post_type( 'pt_template', $args);	
	
		
}
/*GET LIST OF THE AVAILABLE TEMPLATES */
//add_action( 'init', 'pt_register_post_type' );

function myplugin_activate() {

	pt_register_post_type();
 
	$post_id = @wp_insert_post(
		array(
			'post_title' => "Sample Template 123",
			'post_content' => '',
			'post_status' => 'publish',
			'post_date' => date('Y-m-d H:i:s'),
			'post_type' => 'pt_template',
		)
	);
}
//register_activation_hook( __FILE__, 'myplugin_activate' );



add_action( 'wp_ajax_pt_export_template', 'pt_export_template' );
function pt_export_template(){ global $post;

ob_start();
?>
<div class="pt-templates-wrap">
<h4>The current page code is below;</h4>
<textarea style="width:100%;height:250px;" name="import-data" class="import-data"><?php echo stripslashes($_POST['template_data']); ?></textarea>
</div>
<?php
echo ob_get_clean(); 
die();
}


add_action( 'wp_ajax_pt_import_template', 'pt_import_template' );
function pt_import_template(){

ob_start();
?>
<div class="pt-templates-wrap">
<h4>Copy/Paste your import data into the box below and click save.</h4>
<input type="text" name="import-title" class="import-title"  placeholder="Tempate Name" style="width:70%; font-size:18px; margin-bottom:10px;" />
<textarea style="width:100%;height:250px;" name="import-data" class="import-data" placeholder="Tempate Data Goes Here..."></textarea>
<hr />
<button type="submit" class="butotn button-primary pt-save-import-template">Save As Template</button>
<hr />
</div>
<?php
echo ob_get_clean(); 
die();
}

add_action( 'wp_ajax_pt_get_templates', 'pt_get_templates' );
function pt_get_templates(){
	pt_register_post_type();
	
	
	// GET SAVED LAYOUTS
	$templates = get_posts(array(
		'post_type' => 'pt_template',
		'posts_per_page' => -1
	));
	
ob_start(); ?>

<style>
 
 
 
.tabs {
  position: relative;   
  min-height: 350px; /* This part sucks */
  clear: both;
  margin: 55px 0 25px;
 
  
}
.tab {
  float: left;
   
}
.tab label {
  background: #eee; 
  padding: 10px; 
  border: 1px solid #ccc; 
  margin-left: -1px; 
  position: relative;
  left: 1px; 
  top: -29px;
  -webkit-transition: background-color .17s linear;
}
.tab [type=radio] {
  display: none;   
}
.content {
  position: absolute;
  top: -1px;
  left: 0;
  background: white;
  right: 0;
  bottom: 0;
  padding: 20px;
  border: 1px solid #ccc; 
  -webkit-transition: opacity .6s linear;
  opacity: 0;
}
[type=radio]:checked ~ label {
  background: white;
  border-bottom: 1px solid white;
  z-index: 2;
}
[type=radio]:checked ~ label ~ .content {
  z-index: 1;
  opacity: 1;
}

#wlt_builder_template_data { height:300px;    overflow: scroll;    overflow-x: hidden; }
#wlt_builder_template_data img { cursor:pointer; border: 1px solid #ccc;    padding: 1px; }
.templateitem .txt { font-size:12px; font-weight:bold; margin-bottom:10px; color:#666; margin-top:5px; }

</style>

 

<div class="tabs">

<div style="float:right; margin-top:-40px;">
<input type="text" value="" class="pt-save-template-name"> 
<a href="javascript:;" class="button pt-save-template">Save Current Design</a>

<a href="javascript:;" class="button button-primary pt-import-template">Import Template</a>
</div>

    
   <div class="tab">
       <input type="radio" id="tab-1" name="tab-group-1" checked>
       <label for="tab-1">Templates</label>
       
       <div class="content">
          
          <script>
		  
jQuery(document).ready(function() {
 
	// LOAD IN TEMPLATES
	jQuery.ajax({				
			url : "http://www.premiumpress.com/_builder/templates.php",
			type: "POST",
			data: {'page' : 1 },
			dataType : 'json',
			success : function(response) {
				console.log(response);
				  
				var sst = "";
				jQuery.each( response , function( key, val ) {
					 sst = sst + "<div class='col-md-3 span3 templateitem' style='text-align:center'><img src='" + val.img +"' id='" + key + "'> <div class='txt'>" + val.name + "</div> </div>" ;
				});
				 
				jQuery('#wlt_builder_template_data').html(sst); 
				
				// ONCLICK HANDLE
				jQuery('.templateitem img').click(function(e) { 
					 
					 LoadInTemplateData(jQuery(this).attr("id"));				
				});
			},
			error : function(err){

        		// do error checking
        		//alert("something went wrong");
        		console.error(err);
        	}
		});
});

function LoadInTemplateData(id){

	// LOAD IN TEMPLATES
	jQuery.ajax({				
			url : "http://www.premiumpress.com/_builder/templates.php",
			type: "POST",
			data: {'tid' : id },
			dataType : 'json',
			success : function(encoded_content) {
				 console.log(encoded_content);
			  			
				content = B64.decode(encoded_content.data);
				css = B64.decode(encoded_content.css);
			
				jQuery( ".ui-dialog-titlebar-close" ).trigger( "click" );
				jQuery( ".pt-builder-start" ).trigger( "click" );
				
				if ( jQuery("#wp-content-wrap").hasClass("tmce-active") ){		    		
					tinyMCE.get('content').setContent( content );				
				}else{
					jQuery('.wp-editor-area').val( content );
				}
				
				// SWITCH BACK TO EDITOR
				jQuery( ".pt-builder-start" ).trigger( "click" );				
				
				// SAVE CSS
				jQuery( ".pt-css" ).trigger( "click" );
				editor = ace.edit("pt-css-editor");
				editor.setTheme("ace/theme/textmate");
				editor.getSession().setMode("ace/mode/css");
				editor.getSession().setValue( css );
				jQuery( ".ui-dialog-titlebar-close" ).trigger( "click" );
				
				// SET FULL PAGE
				jQuery("#fullpagewidth").val("full");
				 
			},
			error : function(err){

        		// do error checking
        		//alert("something went wrong");
        		console.error(err);
        	}
		})
}

</script>

<div id="wlt_builder_template_data"><div style="text-align:center;"><img src="<?php echo PT_URL . '/assets/images/loader.gif'; ?>" style="max-width:300px; border:0px;" /></div></div>
         
          
       </div> 
   </div>
    
   <div class="tab">
       <input type="radio" id="tab-2" name="tab-group-1">
       <label for="tab-2">My Saved Designs</label>
       
       <div class="content">
       
       <?php
	   
	   	$templates_html = '<ul class="pt-templates-list">';	
		if( !empty( $templates ) ){
		foreach( $templates as $template ){		 
			
				$templates_html .= '<li>
										<a href="javascript:;" class="pt-add-template" data-template_id="'.esc_attr($template->ID).'">
											'.$template->post_title.'
										</a>';
										
										 
										
										$templates_html .= '<a href="javascript:;" class="pt-delete-template" data-template_id="'.esc_attr($template->ID).'">
											<span class="fa fa-trash-o"></span>
										</a>';
										
										 
									$templates_html .= '</li>';
			}		
		}else{
		echo "<li>no saved layouts found</li>";
		}
		$templates_html .= '</ul>';
	    echo $templates_html;
		
	   ?>
       
       
       
       </div> 
   </div>
 
</div>
 

<?php
echo ob_get_clean();
die();
	
	
	
	
	
	
	
	
	


	$templates_html = '<div class="pt-templates-wrap">
						<div class="pt-save-template-box">
							<small>'.__( 'Save current page layout as a template by inputing template name and clicking on the Save button.', 'pt-builder' ).'</small>
							
							
							
							
							
						</div>';
	$templates_html .= '<small>'.__( 'Select one of the previously saved templates to append to the current layout.', 'pt-builder' ).'</small>';

	$templates_html .= '</div>';

	echo $templates_html;
	die();
}

/* SAVE TEMPLATE TO THE TEMPLATES LIST */
add_action( 'wp_ajax_pt_save_import_template', 'pt_save_import_template' );
function pt_save_import_template(){
	pt_register_post_type();
	$template_content = $_POST['template_content'];
	$template_title = $_POST['template_title'];
	$post_id = @wp_insert_post(
		array(
			'post_title' => $template_title,
			'post_content' => $template_content,
			'post_status' => 'publish',
			'post_date' => date('Y-m-d H:i:s'),
			'post_type' => 'pt_template',
		)
	);

	echo '<li>
			<a href="javascript:;" class="pt-add-template" data-template_id="'.esc_attr($post_id).'">
				'.$template_title.'
			</a>
			<a href="javascript:;" class="pt-delete-template" data-template_id="'.esc_attr($post_id).'">
				<span class="fa fa-trash-o"></span>
			</a>
		</li>';
	die();
}

/* SAVE TEMPLATE TO THE TEMPLATES LIST */
add_action( 'wp_ajax_pt_save_template', 'pt_save_template' );
function pt_save_template(){
	pt_register_post_type();
	$template_content = $_POST['template_content'];
	$template_title = $_POST['template_title'];
	$post_id = @wp_insert_post(
		array(
			'post_title' => $template_title,
			'post_content' => $template_content,
			'post_status' => 'publish',
			'post_date' => date('Y-m-d H:i:s'),
			'post_type' => 'pt_template',
		)
	);

	echo '<li>
			<a href="javascript:;" class="pt-add-template" data-template_id="'.esc_attr($post_id).'">
				'.$template_title.'
			</a>
			<a href="javascript:;" class="pt-delete-template" data-template_id="'.esc_attr($post_id).'">
				<span class="fa fa-trash-o"></span>
			</a>
		</li>';
	die();
}

/* DELETE TEMPLATE FROM THE TEMPLATE LIST */
add_action( 'wp_ajax_pt_delete_template', 'pt_delete_template' );
function pt_delete_template(){
	pt_register_post_type();
	$template_id = $_POST['template_id'];
	wp_delete_post( $template_id, true );
	echo '';
	die();
}

/* ADD TEMPLATE TO THE PAGE */
add_action( 'wp_ajax_pt_add_template', 'pt_add_template' );
function pt_add_template(){
	pt_register_post_type();
	$template_id = $_POST['template_id'];
	$template = get_post( $template_id );
	if( !empty( $template ) ){
		echo $template->post_content;
	}
	else{
		echo '';
	}
	die();
}

?>