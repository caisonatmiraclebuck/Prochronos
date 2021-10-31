<?php
/* 
* Theme: PREMIUMPRESS CORE FRAMEWORK FILE
* Url: www.premiumpress.com
* Author: Mark Fail
*
* THIS FILE WILL BE UPDATED WITH EVERY UPDATE
* IF YOU WANT TO MODIFY THIS FILE, CREATE A CHILD THEME
*
* http://codex.wordpress.org/Child_Themes
*/
if (!defined('THEME_VERSION')) {	header('HTTP/1.0 403 Forbidden'); exit; }

global $CORE, $userdata;

$membershipfields = get_option("membershipfields");
 

if(is_array($membershipfields) && count($membershipfields) > 0 && $CORE->_PACKNOTHIDDEN($membershipfields) > 0 ){
 

$STRING .='<div class="membershipblock_account">
		  <div class="clearfix"></div> 
          <hr />
		  <h3 class="text-center">'.$CORE->_e(array('add','24')).'</h3>
          <p class="text-center">'.$CORE->_e(array('add','25')).'</p> 
		  <hr /> 
          <div class="packagesblock">   
          <ul class="packagelistitems clearfix">'.$CORE->packageblock(3,'membershipfields',10).'</ul>
          </div>
		  <div class="clearfix"></div> 
		  </div>
      ';
echo $STRING;

} ?>