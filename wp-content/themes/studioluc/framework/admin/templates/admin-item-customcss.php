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


// LOAD IN MAIN DEFAULTS 
$core_admin_values = get_option("core_admin_values");  
  
?> 

<div class="heading2">Custom CSS </div>

<textarea class="row-fluid" id="custom_css_box" style="height:200px;font-size:11px;" name="adminArray[custom_css]"><?php echo stripslashes(get_option('custom_css')); ?></textarea>
 
<div class="heading2">Header Styles (wp_head)</div>
<p>Here you can enter your own custom CSS/meta data that will appear between your &lt;HEAD&gt; tags.</p>
<textarea class="row-fluid" id="default-textarea" style="height:200px;font-size:11px;" name="adminArray[custom_head]"><?php echo stripslashes(get_option('custom_head')); ?></textarea>
<small><span class="label label-no">Note</span> If your adding CSS please remember to include the &lt;style&gt; tags ... &lt;/style&gt; tags</small>

<div class="heading2">Footer Styles (wp_footer)</div>     
<p>Here you can enter any custom JAVASCRIPT/meta data that will appear after your &lt;BODY&gt; tags.</p>
<textarea  class="row-fluid" id="default-textarea" style="height:200px;font-size:11px;" name="adminArray[custom_footer]"><?php echo stripslashes(get_option('custom_footer')); ?></textarea>
