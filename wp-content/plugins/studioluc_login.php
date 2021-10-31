<?php
/**
 *
 * Plugin Name: Studio Luc login
 * Plugin URI: http://www.studioluc.nl
 * Version: 1.1
 * Author:Luc Bemelmans
 * Author URI: http://www.studioluc.nl
**/
function custom_login_logo() {
    echo '<style type="text/css">
        h1 a { background-image:url(http://www.studioluc.nl/wp-content/uploads/2016/04/login_logo.png) !important; }
    </style>';
}
add_action('login_head', 'custom_login_logo');