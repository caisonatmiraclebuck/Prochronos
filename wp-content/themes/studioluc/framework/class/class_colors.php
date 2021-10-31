<?php
function wlt_core_customerize_settings(){

$fonts = wlt_core_customerize_fonts();

return array(
 

"body"	=> array(

	"title" => "Theme - Background Colors",
	"settings" => array(
		
			
		2 => array("title" => "background {image}", "d" => "3", "type" => "bgi", "div" => "body"),
		
		1 => array("title" => "background {color}", "d" => "1", "type" => "bgc", "div" => "body"),	
		
		3 => array("title" => "font {}", "d" => "4", "type" => "font", "div" => "body, h1, h2, h3, h4, h5, h6, #core_menu_wrapper .nav > li > a", "data" => $fonts),
		
		4 => array("title" => "font color {}", "d" => "1", "type" => "txt", "div" => "body",),
		5 => array("title" => "link color {}", "d" => "1", "type" => "txt", "div" => "a, a:active, a:focus",),
				
		 	
		
	),
),


"logo"	=> array(

	"title" => "Theme - Logo",
	"settings" => array(
		
		
		1 => array("title" => "logo {image} ", "d" => "3", "type" => "logoimg", "div" => "header"),
		
		 
		2 => array("title" => "logo text {main title}", "d" => "5", "type" => "logo1", "div" => ""),
		3 => array("title" => "logo text {sub title}", "d" => "5", "type" => "logo2", "div" => ""),
		
		4 => array("title" => "<hr>logo {text color}", "d" => "1", "type" => "txt", "div" => "#core_logo .main"),
		5 => array("title" => "<hr>logo {sub text color}", "d" => "1", "type" => "txt", "div" => "#core_logo .submain"),		
		
		6 => array("title" => "logo (text size)", "d" => "2", "type" => "txtsize", "div" => "#core_logo .main"),	
		
		
	),
),

"header"	=> array(

	"title" => "Theme - Header Colors",
	"settings" => array(
		
		1 => array("title" => "header {image}", "d" => "3", "type" => "bgi", "div" => "header"),
	 	2 => array("title" => "header {color} ", "d" => "1", "type" => "", "div" => "header"),
		
		
		5 => array("title" => "<hr>top nav {}", "d" => "1", "type" => "", "div" => "#core_header_navigation"),		
		6 => array("title" => "top nav (text color)", "d" => "1", "type" => "txt", "div" => "#core_header_navigation .nav > li a, #core_header_navigation a, #core_header_navigation .welcometext"),
		7 => array("title" => "top nav (text size)", "d" => "2", "type" => "txtsize", "div" => "#core_header_navigation .nav > li a, #core_header_navigation a, #core_header_navigation .welcometext"),	
 
		
		
	),
),

"menu"	=> array(

	"title" => "Theme - Menu Colors",
	"settings" => array(		
	 	
		1 => array("title" => "<hr>menu {}", "d" => "1", "type" => "", "div" => "#core_menu_wrapper"),
		2 => array("title" => "menu (text color)", "d" => "1", "type" => "txt", "div" => "#core_menu_wrapper .navbar-nav > li a"),
		3 => array("title" => "menu (text size)", "d" => "2", "type" => "txtsize", "div" => "#core_menu_wrapper .navbar-nav > li a"),
		
		4 => array("title" => "menu button ", "d" => "1", "type" => "bgc", "div" => "#core_menu_wrapper .nav > li.current-menu-item a, #core_menu_wrapper .nav > li a"),
		5 => array("title" => "menu button (text color)", "d" => "1", "type" => "txt", "div" => "#core_menu_wrapper .nav > li.current-menu-item a, #core_menu_wrapper .nav > li a"),
		
		
	),
),


"footer"	=> array(

	"title" => "Theme - Footer Colors",
	"settings" => array(
		
		1 => array("title" => "footer {} ", "d" => "1", "type" => "", "div" => "footer"),		
		2 => array("title" => "footer (text color)", "d" => "1", "type" => "txt", "div" => "footer"),
		3 => array("title" => "footer (text size)", "d" => "2", "type" => "txtsize", "div" => "footer .footer-block-content, footer .footer-block-title"),
		
		4 => array("title" => "<hr>copyright {} ", "d" => "1", "type" => "", "div" => "#footer_bottom"),
 		5 => array("title" => "copyright (text color)", "d" => "1", "type" => "txt", "div" => "#footer_bottom, #footer_bottom a"),
		6 => array("title" => "copyright (text size)", "d" => "2", "type" => "txtsize", "div" => "#footer_bottom, #footer_bottom a,#footer_bottom .copybit"),
		
		
		
	),
),


"panel"	=> array(

	"title" => "Theme - Panel Colors",
	"settings" => array(
		
		1 => array("title" => "panel title {} ", "d" => "1", "type" => "", "div" => ".panel-default>.panel-heading,#core_advanced_search_widget_box .panel-heading"),		
		2 => array("title" => "panel title (text color)", "d" => "1", "type" => "txt", "div" => ".panel-default>.panel-heading,#core_advanced_search_widget_box .panel-heading"),
		3 => array("title" => "panel title (text size)", "d" => "2", "type" => "txtsize", "div" => ".panel-default>.panel-heading,#core_advanced_search_widget_box .panel-heading"),
		
		
		4 => array("title" => "panel body {} ", "d" => "1", "type" => "", "div" => ".panel-default>.panel-heading+.panel-collapse>.panel-body, #core_advanced_search_widget_box form, .panel .list-group"),		
		5 => array("title" => "panel body (text color)", "d" => "1", "type" => "txt", "div" => ".panel-default>.panel-heading+.panel-collapse>.panel-body, #core_advanced_search_widget_box form,#core_advanced_search_widget_box label, #core_advanced_search_widget_box #head_group_cat,.core_widgets_categories_list ul li a"),
		6 => array("title" => "panel body (text size)", "d" => "2", "type" => "txtsize", "div" => ".panel-default>.panel-heading+.panel-collapse>.panel-body, #core_advanced_search_widget_box form"),
 		
		7 => array("title" => "panel border ", "d" => "1", "type" => "bdc", "div" => ".panel-default, .panel-default>.panel-heading"),
 		
	),
),


"button"	=> array(

	"title" => "Theme - Button Colors",
	"settings" => array(
		
		1 => array("title" => "button {} ", "d" => "1", "type" => "", "div" => ".btn-primary"),	
		2 => array("title" => "button (border color)", "d" => "1", "type" => "bdc", "div" => ".btn-primary"),	
		3 => array("title" => "button (text color)", "d" => "1", "type" => "txt", "div" => ".btn-primary"),
		4 => array("title" => "button (text size)", "d" => "2", "type" => "txtsize", "div" => ".btn-primary"),
		 
		
	),
),
 

);
 

}


function wlt_core_customerize_fonts(){

$fontsA = array(); 
$fontsA["none"] = "DDefault Font"; 
$fontsA["anton"]['google'] = true;
$fontsA["anton"] = '"Anton", arial, serif';
$fontsA["arial"]['google'] = false;
$fontsA["arial"] = 'Arial, "Helvetica Neue", Helvetica, sans-serif'; 
$fontsA["arial_black"]['google'] = false;
$fontsA["arial_black"] = '"Arial Black", "Arial Bold", Arial, sans-serif';	 
$fontsA["arial_narrow"]['google'] = false;
$fontsA["arial_narrow"] = '"Arial Narrow", Arial, "Helvetica Neue", Helvetica, sans-serif'; 
$fontsA["cabin"]['google'] = true;
$fontsA["cabin"] = 'Cabin, Arial, Verdana, sans-serif'; 
$fontsA["cantarell"]['google'] = true;
$fontsA["cantarell"] = 'Cantarell, Candara, Verdana, sans-serif'; 
$fontsA["cardo"]['google'] = true;
$fontsA["cardo"] = 'Cardo, "Times New Roman", Times, serif'; 
$fontsA["courier_new"]['google'] = false;
$fontsA["courier_new"] = 'Courier, Verdana, sans-serif'; 
$fontsA["crimson_text"]['google'] = true;
$fontsA["crimson_text"] = '"Crimson Text", "Times New Roman", Times, serif'; 
$fontsA["cuprum"]['google'] = true;
$fontsA["cuprum"] = '"Cuprum", arial, serif'; 
$fontsA["dancing_script"]['google'] = true;
$fontsA["dancing_script"] = '"Dancing Script", arial, serif'; 
$fontsA["droid_sans"]['google'] = true;
$fontsA["droid_sans"] = '"Droid Sans", "Lucida Grande", Tahoma, sans-serif'; 
$fontsA["droid_mono"]['google'] = true;
$fontsA["droid_mono"] = '"Droid Sans Mono", Consolas, Monaco, Courier, sans-serif'; 
$fontsA["droid_serif"]['google'] = true;
$fontsA["droid_serif"] = '"Droid Serif", Calibri, "Times New Roman", serif'; 
$fontsA["georgia"]['google'] = false;
$fontsA["georgia"] = 'Georgia, "Times New Roman", Times, serif'; 
$fontsA["im_fell_dw_pica"]['google'] = true;
$fontsA["im_fell_dw_pica"] = '"IM Fell DW Pica", "Times New Roman", serif'; 
$fontsA["im_fell_english"]['google'] = true;
$fontsA["im_fell_english"] = '"IM Fell English", "Times New Roman", serif'; 
$fontsA["inconsolata"]['google'] = true;
$fontsA["inconsolata"] = '"Inconsolata", Consolas, Monaco, Courier, sans-serif'; 
$fontsA["inconsolata"] = '"Josefin Sans Std Light", "Century Gothic", Verdana, sans-serif'; 
$fontsA["kreon"]['google'] = true;
$fontsA["kreon"] = "kreon, georgia,serif"; 
$fontsA["lato"]['google'] = true;
$fontsA["lato"] = '"Lato", arial, serif'; 
$fontsA["lobster"]['google'] = true;
$fontsA["lobster"] = 'Lobster, Arial, sans-serif'; 
$fontsA["lora"]['google'] = true;
$fontsA["lora"] = '"Lora", georgia, serif'; 
$fontsA["merriweather"]['google'] = true;
$fontsA["merriweather"] = 'Merriweather, georgia, times, serif'; 
$fontsA["molengo"]['google'] = true;
$fontsA["molengo"] = 'Molengo, "Trebuchet MS", Corbel, Arial, sans-serif';	 
$fontsA["nobile"]['google'] = true;
$fontsA["nobile"] = 'Nobile, Corbel, Arial, sans-serif'; 
$fontsA["ofl_sorts_mill_goudy"]['google'] = true;
$fontsA["ofl_sorts_mill_goudy"] = '"OFL Sorts Mill Goudy TT", Georgia, serif'; 
$fontsA["old_standard"]['google'] = true;
$fontsA["old_standard"] = '"Old Standard TT", "Times New Roman", Times, serif'; 
$fontsA["reenie_beanie"]['google'] = true;
$fontsA["reenie_beanie"] = '"Reenie Beanie", Arial, sans-serif'; 
$fontsA["tangerine"]['google'] = true;
$fontsA["tangerine"] = 'Tangerine, "Times New Roman", Times, serif'; 
$fontsA["times_new_roman"]['google'] = false;
$fontsA["times_new_roman"] = '"Times New Roman", Times, Georgia, serif'; 
$fontsA["trebuchet_ms"]['google'] = false;
$fontsA["trebuchet_ms"] = '"Trebuchet MS", "Lucida Grande", "Lucida Sans Unicode", "Lucida Sans", Arial, sans-serif'; 
$fontsA["verdana"]['google'] = false;
$fontsA["verdana"] = 'Verdana, sans-serif'; 
$fontsA["vollkorn"]['google'] = true;
$fontsA["vollkorn"] = 'Vollkorn, Georgia, serif'; 
$fontsA["yanone"]['google'] = true;
$fontsA["yanone"] = '"Yanone Kaffeesatz", Arial, sans-serif'; 
$fontsA["american_typewriter"]['google'] = false;
$fontsA["american_typewriter"] = '"American Typewriter", Georgia, serif'; 
$fontsA["andale"]['google'] = false;
$fontsA["andale"] = '"Andale Mono", Consolas, Monaco, Courier, "Courier New", Verdana, sans-serif'; 
$fontsA["baskerville"]['google'] = false;
$fontsA["baskerville"] = 'Baskerville, "Times New Roman", Times, serif'; 
$fontsA["bookman_old_style"]['google'] = false;
$fontsA["bookman_old_style"] = '"Bookman Old Style", Georgia, "Times New Roman", Times, serif'; 
$fontsA["calibri"]['google'] = false;
$fontsA["calibri"] = 'Calibri, "Helvetica Neue", Helvetica, Arial, Verdana, sans-serif'; 
$fontsA["cambria"]['google'] = false;
$fontsA["cambria"] = 'Cambria, Georgia, "Times New Roman", Times, serif'; 
$fontsA["candara"]['google'] = false;
$fontsA["candara"] = 'Candara, Verdana, sans-serif'; 
$fontsA["century_gothic"]['google'] = false;
$fontsA["century_gothic"] = '"Century Gothic", "Apple Gothic", Verdana, sans-serif'; 
$fontsA["century_schoolbook"]['google'] = false;
$fontsA["century_schoolbook"] = '"Century Schoolbook", Georgia, "Times New Roman", Times, serif'; 
$fontsA["consolas"]['google'] = false;
$fontsA["consolas"] = 'Consolas, "Andale Mono", Monaco, Courier, "Courier New", Verdana, sans-serif'; 
$fontsA["constantia"]['google'] = false;
$fontsA["constantia"] = 'Constantia, Georgia, "Times New Roman", Times, serif'; 
$fontsA["Corbel"]['google'] = false;
$fontsA["Corbel"] = 'Corbel, "Lucida Grande", "Lucida Sans Unicode", Arial, sans-serif'; 
$fontsA["franklin_gothic"]['google'] = false;
$fontsA["franklin_gothic"] = '"Franklin Gothic Medium", Arial, sans-serif'; 
$fontsA["garamond"]['google'] = false;
$fontsA["garamond"] = 'Garamond, "Hoefler Text", "Times New Roman", Times, serif'; 
$fontsA["gill_sans"]['google'] = false;
$fontsA["gill_sans"] = '"Gill Sans MT", "Gill Sans", Calibri, "Trebuchet MS", sans-serif'; 
$fontsA["helvetica"]['google'] = false;
$fontsA["helvetica"] = '"Helvetica Neue", Helvetica, Arial, sans-serif'; 
$fontsA["hoefler"]['google'] = false;
$fontsA["hoefler"] = '"Hoefler Text", Garamond, "Times New Roman", Times, sans-serif'; 
$fontsA["lucida_bright"]['google'] = false;
$fontsA["lucida_bright"] = '"Lucida Bright", Cambria, Georgia, "Times New Roman", Times, serif'; 
$fontsA["lucida_grande"]['google'] = false;
$fontsA["lucida_grande"] = '"Lucida Grande", "Lucida Sans", "Lucida Sans Unicode", sans-serif'; 
$fontsA["palatino"]['google'] = false;
$fontsA["palatino"] = '"Palatino Linotype", Palatino, Georgia, "Times New Roman", Times, serif'; 
$fontsA["rockwell"]['google'] = false;
$fontsA["rockwell"] = 'Rockwell, "Arial Black", "Arial Bold", Arial, sans-serif'; 
$fontsA["tahoma"]['google'] = false;
$fontsA["tahoma"] = 'Tahoma, Geneva, Verdana, sans-serif';
return $fontsA;
}
class wlt_core_customerize {

 
	function register ( $wp_customize ) {
	
	 $wp_customize->remove_control("header_image"); 
	 $wp_customize->remove_section("colors");
	 $wp_customize->remove_section("background_image");
	// $wp_customize->remove_section("static_front_page");
	
 
		foreach(wlt_core_customerize_settings() as $ck => $c){
		
				$wp_customize->add_section( 'premiumpress_'.$ck , array(
					'title'    => $c['title'],
					'priority' => 30,
					//'active_callback' => 'is_front_page',
				) ); 
				
				
				foreach($c['settings'] as $fk => $f){	
			
					$wp_customize->add_setting( $ck."_".$fk , array(
						'default'   => '#123456',
						'transport' => 'refresh',
					) );
					
					// SWITCH DISPLAY TYPE
					switch($f['d']){
					
						case "5": {
						
						$wp_customize->add_control( $ck."_".$fk  , array(
							'label'    => $f['title'] ,
							'section'  => 'premiumpress_'.$ck,
							'settings' => $ck."_".$fk,
							'type'     => 'text',
							'default'   => '',
							 
						) );
						
						} break;
					
						case "4": {
						
						$wp_customize->add_control( $ck."_".$fk  , array(
							'label'    => $f['title'] ,
							'section'  => 'premiumpress_'.$ck,
							'settings' => $ck."_".$fk,
							'type'     => 'select',
							'choices'  => $f['data']
						) );
												
						
						} break;
					
					
						case "3": {
						
						$wp_customize->add_control(
							   new WP_Customize_Image_Control(
								   $wp_customize,
								    $ck."_".$fk,
								   array(
									'label'    => $f['title'] ,
									'section'  => 'premiumpress_'.$ck,
									'settings' => $ck."_".$fk,
									//'context'    => 'your_setting_context' 
								 
								   )
							   )
						   );
							
						} break;
						case "2": {
						
							$wp_customize->add_control( $ck."_".$fk, array(
								'type'        => 'range',				
								'label'    => $f['title'] ,
								'section'  => 'premiumpress_'.$ck,
								//'description' => '',
								'input_attrs' => array(
									'min'   => 10,
									'max'   => 60,
									'step'  => 1, 
									 
								),
							) );
							
						} break;
					
						default: {
						
							$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, $ck."_".$fk, array(
									'label'    => $f['title'] ,
									'section'  => 'premiumpress_'.$ck,
									'settings' => $ck."_".$fk,
									//'description' => '',
							) ) );
						}
						
					}
					
				
					
				
				}// end foreach
				
		} // end foreach
			
	}
	
	
	public static function reset_customizer() {  
	
	 remove_theme_mods();
	
	}
	
   public static function header_output() { $STRING = "";
   
   $fonts = wlt_core_customerize_fonts();
   
   foreach(wlt_core_customerize_settings() as $ck => $c){
   
   		foreach($c['settings'] as $fk => $f){		
		
		   $mod = get_theme_mod($ck."_".$fk);
		   
		   // SKIP DISPLAY IF SET TO DEFAULT
		   if($mod == "" || $mod == "#123456" || $mod == "none"){ continue; }
		   
		   switch($f['type']){

			case "font": {
			
			if(isset($fonts[$mod]['google']) && $fonts[$mod]['google']){
			$FName = explode(",",$fonts[$mod]);
			$STRING .= " @import url('http://fonts.googleapis.com/css?v2&family=".str_replace('"',"",str_replace(' ',"+",$FName[0]))."'); ";
			}
			
			$STRING .= $f['div']."{ font-family:".$fonts[$mod]." }";	
			} break;
			case "txtsize": {
			$STRING .= $f['div']."{ font-size:".$mod."px }";	
			} break;
			case "txt": {
			$STRING .= $f['div']."{ color:".$mod." }";		
			} break;
			case "bdc": {
			$STRING .= $f['div']."{ border-color:".$mod." }";		
			} break;
			case "bgc": {
			$STRING .= $f['div']."{ background-color:".$mod." }";		
			} break;
			case "bgi": {
			$STRING .= $f['div']."{ background-image: url(".$mod.") }";		
			} break;
			
			case "logoimg": {			
		 
			$GLOBALS['CORE_THEME']['logo_url'] = $mod;
			} break;
			
			case "logo1": {			
			$GLOBALS['CORE_THEME']['logo_text1'] = $mod;
			} break;
			
			case "logo2": {			
			$GLOBALS['CORE_THEME']['logo_text2'] = $mod;
			} break;
			
			
			default: {			   
			$STRING .= $f['div']."{ background:".$mod." }";			   
			}
			
		   }		
   
		}
	}
   

     // OUTPUT
		if(strlen($STRING) > 2){
			echo "<style>".$STRING."</style>";
		}
   }
 
   
}

?>