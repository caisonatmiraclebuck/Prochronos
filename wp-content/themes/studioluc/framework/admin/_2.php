<?php
// CHECK THE PAGE IS NOT BEING LOADED DIRECTLY
if (!defined('THEME_VERSION')) {	header('HTTP/1.0 403 Forbidden'); exit; }
// SETUP GLOBALS
global $wpdb, $CORE, $userdata, $CORE_ADMIN;

 
// GET ADMIN VARIABLES 
$core_admin_values = get_option("core_admin_values");
 
// LOAD IN HEADER
echo $CORE_ADMIN->HEAD();

?>
  

<?php // LOAD IN FOOTER
echo $CORE_ADMIN->FOOTER(); ?>