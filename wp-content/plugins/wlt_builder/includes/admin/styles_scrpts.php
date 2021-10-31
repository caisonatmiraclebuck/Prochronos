<?php
/*
Load scripts and stylesheets for the admin side
*/

if(isset($_SERVER['HTTPS'])) {
    if ($_SERVER['HTTPS'] == "on") {
        wp_enqueue_style( 'jquery-ui-css', 'https://code.jquery.com/ui/1.11.0/themes/smoothness/jquery-ui.css');
    }else{
	wp_enqueue_style( 'jquery-ui-css', 'https://code.jquery.com/ui/1.11.0/themes/smoothness/jquery-ui.css');
	}
}else{
wp_enqueue_style( 'jquery-ui-css', 'https://code.jquery.com/ui/1.11.0/themes/smoothness/jquery-ui.css');
}

wp_enqueue_style( 'pt-builder-css', PT_URL . '/assets/css/admin/builder.css' );

wp_enqueue_script( 'jquery' );
wp_enqueue_script( 'jquery-ui-core' );
wp_enqueue_script( 'jquery-ui-dialog' );
wp_enqueue_script( 'jquery-ui-sortable' );

wp_enqueue_script( 'pt-b64', PT_URL . '/assets/js/admin/b64.js' );
wp_enqueue_script( 'pt-builder', PT_URL . '/assets/js/admin/builder.js' );

wp_enqueue_script( 'pt-underscore-min', PT_URL . '/assets/js/admin/underscore-min.js' );
wp_enqueue_script( 'pt-modernizr', PT_URL . '/assets/js/admin/modernizr.custom.min.js' );
wp_enqueue_script( 'pt-shuffle', PT_URL . '/assets/js/admin/jquery.shuffle.js' );
wp_enqueue_script( 'pt-main', PT_URL . '/assets/js/admin/main.js' );


wp_enqueue_style( 'pt-font-awesome-css' );

/* CUSTOM CSS EDITOR */
wp_enqueue_script( 'pt-ace', PT_URL . '/assets/js/admin/ace/ace.js' );
wp_enqueue_script( 'pt-theme-textmate', PT_URL . '/assets/js/admin/ace/theme-textmate.js' );
wp_enqueue_script( 'pt-mode-css', PT_URL . '/assets/js/admin/ace/mode-css.js' );
wp_enqueue_script( 'pt-jquery-ace.min', PT_URL . '/assets/js/admin/ace/jquery-ace.min.js' );

?>