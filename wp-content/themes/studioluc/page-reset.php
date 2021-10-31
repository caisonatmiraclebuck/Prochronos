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
?>

<?php global $CORE, $errortext; ?>

<?php get_header($CORE->pageswitch()); ?>

 
<?php if(strlen($string) > 1){ ?>
 <div class="bs-callout bs-callout-danger">
  <button type="button" class="close" data-dismiss="alert">X</button>
  <?php echo $string; ?>
</div>
<?php } ?>

<style>
#pass1-text { display:none; }
</style>

<div class="panel panel-default">

<div class="panel-heading"><?php echo $CORE->_e(array('login','27')); ?></div>

<div class="panel-body">
    
<form name="resetpassform" id="resetpassform" action="<?php echo esc_url( site_url( 'wp-login.php?action=resetpass&key=' . urlencode( $_GET['key'] ) . '&login=' . urlencode( $_GET['login'] ), 'login_post' ) ); ?>" method="post" autocomplete="off">
<input type="hidden" id="user_login" value="<?php echo esc_attr( $_GET['login'] ); ?>" autocomplete="off" />

<input type="hidden" name="key" value="<?php echo strip_tags($_GET['key']); ?>" />
<input type="hidden" name="login" id="user_login" value="<?php echo strip_tags($_GET['login']); ?>" />
<input type="hidden" name="action" value="resetpass" />

	<p>
		<label for="pass1"><?php echo $CORE->_e(array('login','27')); ?><br>
		<input type="password" name="pass1" class="input" size="20" ></label>
	</p>
	<p>
		<label for="pass2"><?php echo $CORE->_e(array('login','28')); ?><br>
		<input type="password" name="pass2"  class="input" size="20" ></label>
	</p>
    
    <?php do_action( 'resetpassword_form' ); ?>
  
	<br class="clear">
    
	<p class="submit"><input type="submit" name="wp-submit" id="wp-submit" class="btn btn-primary" value="<?php echo $CORE->_e(array('login','29')); ?>"></p>
    
</form>

</div>
 

<?php get_footer($CORE->pageswitch()); ?>