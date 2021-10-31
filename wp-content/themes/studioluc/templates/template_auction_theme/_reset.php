<?php

add_action('hook_new_install','_newinstall');
function _newinstall(){ global $CORE, $wpdb;
 
 
 // CONTENT LAYOUT / SINGLE LAYOUT
$GLOBALS['theme_defaults']['content_layout'] = "listing-auction";
$GLOBALS['theme_defaults']['single_layout'] = "content-listing-auction";

// SEARCH SETUP
$GLOBALS['theme_defaults']['default_gallery_perrow'] = 3;
$GLOBALS['theme_defaults']['header_accountdetails'] = 1;
$GLOBALS['theme_defaults']['feedback_trustbar'] = 1;

// BREADCRUMBS
$GLOBALS['theme_defaults']['breadcrumbs_inner'] = 0;
// TEMPLATE
$GLOBALS['theme_defaults']['template'] 		= "template_auction_theme";
// SET HEADER
$GLOBALS['theme_defaults']['layout_header'] = 4;
$GLOBALS['theme_defaults']['layout_menu'] = 4;

// WIDE LAYOUT
$GLOBALS['theme_defaults']['layout_contentwidth'] = 0;
$GLOBALS['theme_defaults']['layout_layoutwidth'] = 1;


// HOME PAGE LAYOUT
$GLOBALS['theme_defaults']['homepage_layout'] = "layout-auction1";

// DEFAULTS FOR HOME PAGE OBJECTS
$GLOBALS['theme_defaults']['hdata'] = array(
"j1" => array("title1" => "Auction Theme", "title2" => "HTML5 Responsive Auction Theme", "title3" => "This is a simple hero unit, a simple jumbotron-style component for calling extra attention to featured content or information.", ),
"t1" => array("title1" => "Your Amazing Title Text Here", "title2" => "You can customize this area and enter your own title text via the admin area of the theme."  ),
"t2" => array("title1" => "Your Amazing Title Text Here", "title2" => "You can customize this area and enter your own title text via the admin area of the theme."  ),
); 

// WEBSITE LOGO
$GLOBALS['theme_defaults']['logo_text1'] 	= "Website Logo";
$GLOBALS['theme_defaults']['logo_text2'] 	= "Your company slogan";
$GLOBALS['theme_defaults']['logo_icon'] 	= "2";

 
 
$GLOBALS['theme_defaults']['widgetobject']['image3']['0'] = array(
'text' => "<div class='row'><div class='col-md-3 col-sm-3'>[D_CATEGORIES title='Categories' show_count='1']</div><div class='col-md-9 col-sm-9 hidden-xs'><a href=\"http://www.premiumpress.com/wordpress-auction-theme/\"><img src='".get_template_directory_uri()."/templates/".$GLOBALS['theme_defaults']['template']."/img/demo/slide1.jpg' alt='join' class='img-responsive wltatt_id'></a><div class='row' style='margin-top:20px;'><div class='col-md-6 col-sm-6'><a href=\"".home_url()."/?wp-login.php?action=register\"><img src='".get_template_directory_uri()."/templates/".$GLOBALS['theme_defaults']['template']."/img/demo/a1.jpg' alt='' class='img-responsive wltatt_id' style='border:1px solid #ddd;' /></a></div><div class='col-md-6 col-sm-6'><a href=\"".home_url()."/?wp-login.php?action=register\"><img src='".get_template_directory_uri()."/templates/".$GLOBALS['theme_defaults']['template']."/img/demo/a2.jpg' alt='' class='img-responsive wltatt_id' style='border:1px solid #ddd;' /></a></div></div></div></div>",
'fullw' => "yes",
); 
 
  
$GLOBALS['theme_defaults']['widgetobject']["tabs"][1] 	= array(
		"title1" => "Recently Added",
		"query1" => "order=desc&orderby=rand&posts_per_page=10",
		"spanclass1" => "span3",
		
		"title2" => "Going Soon",
		"query2" => "order=desc&orderby=rand&posts_per_page=10",
		"spanclass1" => "span3",
		
		"title3" => "Most Popular",
		"query3" => "order=desc&orderby=rand&posts_per_page=10",
		"spanclass1" => "span3",
				
		"fullw" => "yes",	
		"perrow"	=> "5",
);
$GLOBALS['theme_defaults']['homepage'] 		= array("widgetblock1" => "image3_0,tabs_1");

 
$GLOBALS['theme_defaults']['display'] 			= array('default_gallery_style' => 'grid');
 
 
   
// 5. REINSTALL THE SAMPLE DATA CATEGORIES 
$new_cat_array = array(
	"Example Category 1" => array ('Sub Cat 1','Sub Cat 2', 'Sub Cat 3'),
	"Example Category 2" => array ('Sub Cat 1','Sub Cat 2', 'Sub Cat 3'),
	"Example Category 2" => array ('Sub Cat 1','Sub Cat 2', 'Sub Cat 3'),
	"Example Category 3" => array ('Sub Cat 1','Sub Cat 2', 'Sub Cat 3'),
	"Example Category 4" => array ('Sub Cat 1','Sub Cat 2', 'Sub Cat 3'),
	"Example Category 5" => array ('Sub Cat 1','Sub Cat 2', 'Sub Cat 3'),
	"Example Category 6" => array ('Sub Cat 1','Sub Cat 2', 'Sub Cat 3'),
	"Example Category 7" => array ('Sub Cat 1','Sub Cat 2', 'Sub Cat 3'),
	"Example Category 8" => array ('Sub Cat 1','Sub Cat 2', 'Sub Cat 3'),
	"Example Category 9" => array ('Sub Cat 1','Sub Cat 2', 'Sub Cat 3'),
	"Example Category 10" => array ('Sub Cat 1','Sub Cat 2', 'Sub Cat 3'),
	"Example Category 11" => array ('Sub Cat 1','Sub Cat 2', 'Sub Cat 3'),
 	"Example Category 12" => array ('Sub Cat 1','Sub Cat 2', 'Sub Cat 3'),
);

  $cat_icons_small = array('','fa-car','fa-archive','fa fa-sitemap','fa fa-soccer-ball-o','fa-heart-o','fa-desktop','fa-child','fa-tint','fa-file-text','fa-google-wallet','fa-twitch','fa-yelp','fa-plug','fa-bullhorn','fa-paw');
 
$saved_cats_array = array(); $ff=1;
foreach($new_cat_array as $cat=>$catlist){
	if ( is_term( $cat , THEME_TAXONOMY ) ){	
		$term = get_term_by('slug', $cat, THEME_TAXONOMY);		 
		$nparent  = $term->term_id;
		$saved_cats_array[] = $term->term_id;	
	}else{
	
		$cat_id = wp_insert_term($cat, THEME_TAXONOMY, array('cat_name' => $cat ));
 
		if(!is_object($cat_id) && isset($cat_id['term_id'])){
		$saved_cats_array[] = $cat_id['term_id'];
		$nparent = $cat_id['term_id'];
		}else{
		$saved_cats_array[] = $cat_id->term_id;
		$nparent = $cat_id->term_id;
		}
		$ff++; 
	}
	
	// add in icon for this cat		
	$GLOBALS['theme_defaults']['category_icon_'.$nparent] = get_template_directory_uri()."/framework/img/demo/noimage.png";
	$GLOBALS['theme_defaults']['category_icon_small_'.$nparent] = $cat_icons_small[$ff];
	
	/* SUB CATS */
	if(is_array($catlist)){
		foreach($catlist as $newcat){
		wp_insert_term($newcat, THEME_TAXONOMY, array('cat_name' => $newcat,'parent' => $nparent));
		}	
	}
}


$i=1;
while($i < 16){
 
	$my_post = array();
	$my_post['post_title'] 		= "Example Item ".$i;
	$my_post['post_content'] 	= "<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Praesent tempus eleifend risus ut congue. Pellentesque nec lacus elit. Pellentesque convallis nisi ac augue pharetra eu tristique neque consequat. Mauris ornare tempor nulla, vel sagittis diam convallis eget.</p><p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Praesent tempus eleifend risus ut congue. Pellentesque nec lacus elit. Pellentesque convallis nisi ac augue pharetra eu tristique neque consequat. Mauris ornare tempor nulla, vel sagittis diam convallis eget.</p><blockquote><p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Integer posuere erat a ante.</p><small>Someone famous <cite title='Source Title'>Source Title</cite></small>
</blockquote><p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Praesent tempus eleifend risus ut congue. Pellentesque nec lacus elit. Pellentesque convallis nisi ac augue pharetra eu tristique neque consequat. Mauris ornare tempor nulla, vel sagittis diam convallis eget.</p><dl class='dl-horizontal'>
				<dt>Description lists</dt>
				<dd>A description list is perfect for defining terms.</dd>
				<dt>Euismod</dt>
				<dd>Vestibulum id ligula porta felis euismod semper eget lacinia odio sem nec elit.</dd>
				<dd>Donec id elit non mi porta gravida at eget metus.</dd>
				<dt>Malesuada porta</dt>
				<dd>Etiam porta sem malesuada magna mollis euismod.</dd>
				<dt>Felis euismod semper eget lacinia</dt>
				<dd>Fusce dapibus, tellus ac cursus commodo, tortor mauris condimentum nibh, ut fermentum massa justo sit amet risus.</dd>
			  </dl>";
	$my_post['post_type'] 		= THEME_TAXONOMY."_type";
	$my_post['post_status'] 	= "publish";
	$my_post['post_category'] 	= "";
	$my_post['tags_input'] 		= "";
	$POSTID 					= wp_insert_post( $my_post );
		
	add_post_meta($POSTID, "price_current", rand(80, 500));
	add_post_meta($POSTID, "price_bin", rand(500, 1500));
 	add_post_meta($POSTID, "image", get_template_directory_uri()."/framework/img/demo/noimage.png");
	add_post_meta($POSTID, "listing_expiry_date", date('Y-m-d H:i:s', strtotime("+3 days")));
	// UPDATE CAT LIST
	wp_set_post_terms( $POSTID, $saved_cats_array, THEME_TAXONOMY );
	
	$i++;	
} 
 

} 

?>