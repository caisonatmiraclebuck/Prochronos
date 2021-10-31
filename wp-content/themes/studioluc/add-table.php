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

// HOOK PACKAGES BEFORE
hook_packages_before();
// CHECK WE HAVE PACKAGES AVAILABLE 
 
?>

 
<!-- memberships form -->
<form method="post" name="MEMBERSHIPFORM" action="<?php echo $GLOBALS['CORE_THEME']['links']['myaccount']; ?>" id="MEMBERSHIPFORM" style="margin:0px;padding:0px;">
<input type="hidden" name="membershipID" id="membershipID" value="-1" />
<input type="hidden" name="showpaymentform" value="1" />
</form>
 
<?php function _core_display_packages_block(){ global $wpdb, $CORE; $packagefields = get_option("packagefields"); $membershipfields = get_option("membershipfields"); 

$STRING = '<!-- packages form -->
<form method="post" name="PACKAGESFORM" action="'.$GLOBALS['CORE_THEME']['links']['add'].'" id="PACKAGESFORM">
<input type="hidden" name="packageID" id="packageID" value="-1" />
<div class="panel panel-default" id="PACKAGEBLOCK">
 
<div class="panel-body"> 

<i class="fa fa-magic mainicon hidden-xs"></i>
<h2>'.$CORE->_e(array('add','26')).'</h2>
<p>'.$CORE->_e(array('add','27')).'</p> 
';  

if(isset($GLOBALS['CORE_THEME']['custom']['package_text']) && strlen($GLOBALS['CORE_THEME']['custom']['package_text']) > 2 ){ $STRING .= wpautop(stripslashes($GLOBALS['CORE_THEME']['custom']['package_text'])); }  
    
    if(is_array($packagefields) && $CORE->_PACKNOTHIDDEN($packagefields) > 0){ 
    $STRING .='
	<div class="clearfix"></div> 
          
		  <hr />
          <div class="packagesblock row">
          '.$CORE->packageblock(3,'packagefields',20).'
          </div>  
      '; 
     } 
    if(is_array($membershipfields) && count($membershipfields) > 0 && isset($GLOBALS['CORE_THEME']['show_mem_listingpage']) && $GLOBALS['CORE_THEME']['show_mem_listingpage'] == 1){    
    $STRING .='
		  <div class="clearfix"></div> 
          <hr />
		  <h3 class="text-center">'.$CORE->_e(array('add','24')).'</h3>
          <p class="text-center">'.$CORE->_e(array('add','25')).'</p> 
		  <hr /> 
          <div class="packagesblock">   
          <ul class="packagelistitems">'.$CORE->packageblock(3,'membershipfields',10).'</ul>
          </div>
      ';
    }
 

$STRING .='<div class="clearfix"></div><hr /><p class="text-center"><i class="fa fa-history"></i> &nbsp;'.$CORE->_e(array('add','28')).'</p></div></div><!-- // END PACKAGELBOCK --> ';
$STRING .='</form><!-- end packages form --><br />';
return $STRING;
} 

echo hook_packages(_core_display_packages_block());

hook_packages_after(); 

?>