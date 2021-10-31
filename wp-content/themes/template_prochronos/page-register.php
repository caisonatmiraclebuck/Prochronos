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
 
<?php hook_register_before(); ?>

<div class="row"><div class="col-md-5 col-md-offset-3">
 
<div class="panel panel-default" id="register_box">

<div class="panel-heading"><?php echo $CORE->_e(array('login','6')); ?></div>

	<div class="panel-body">
        
    <?php if(strlen($errortext) > 1){ ?>
     <div class="bs-callout bs-callout-danger">
      <button type="button" class="close" data-dismiss="alert">x</button>
      <?php echo $errortext; ?>
    </div>
    <?php } ?>
    
    <?php if(isset($GLOBALS['CORE_THEME']['register_text']) && strlen($GLOBALS['CORE_THEME']['register_text']) > 2){ echo stripslashes(do_shortcode($GLOBALS['CORE_THEME']['register_text']))."<hr />"; } ?>
    
    <form class="registerform" name="registerform" id="registerform" action="<?php echo site_url('wp-login.php?action=register', 'login_post'); ?>" method="post" 
    onsubmit="return ValidateCoreRegFields();">
    
    <div class="form-group clearfix">
	<label class="control-label col-md-4"><?php echo $CORE->_e(array('login','10')); ?></label>
	<div class="col-md-8">
    	<input type="text" name="user_login" id="user_login" tabindex="1" value="<?php echo esc_html(strip_tags($_POST['user_login'])); ?>" class="form-control">                 
	</div>
	</div>            
                
    <div class="form-group clearfix">
    <label class="control-label col-md-4"><?php echo $CORE->_e(array('account','9')); ?></label>
    <div class="col-md-8">
		<input type="text" name="user_email" id="user_email" tabindex="2" value="<?php echo esc_html(strip_tags($_POST['user_email'])); ?>" class="form-control">                 
    </div>
    </div>

	<?php echo str_replace("col-md-3","col-md-5",str_replace("col-md-9","col-md-7",$CORE->CORE_FIELDS())); ?>
     
   <?php if($GLOBALS['CORE_THEME']['visitor_password'] == '1'){  ?>
                
                 
                 <div class="form-group clearfix">
                  <label class="control-label col-md-4"><?php echo $CORE->_e(array('account','10')); ?></label>
                  <div class=" col-md-8">
                 
                    <input type="password" name="pass1" id="pass1" value="<?php echo esc_html(strip_tags($_POST['pass1'])); ?>" tabindex="200" class="form-control"> 
                     
                  </div>
                </div>
                 
                  <div class="form-group clearfix">
                  <label class="control-label col-md-4"><?php echo $CORE->_e(array('account','11')); ?></label>
                  <div class=" col-md-8">
                  
                    <input type="password" name="pass2" id="pass2" value="<?php echo esc_html(strip_tags($_POST['pass2'])); ?>" tabindex="201" class="form-control"> 
                     
                  </div>
                </div>                        
    <?php } ?>                
                 
                <hr />
               
               <?php if($GLOBALS['CORE_THEME']['register_securitycode'] == 1){ $reg_nr1 = rand("0", "9"); $reg_nr2 = rand("0", "9"); ?>
               
                <div class="form-group clearfix">
                  <label class="control-label col-md-4"><?php echo $CORE->_e(array('single','5')); ?> </label>
                  <div class="input-group controls col-md-6">
                  <span class="input-group-addon" ><?php echo $reg_nr1; ?> + <?php echo $reg_nr2; ?> = </span>
                    <input type="text" name="reg_val" tabindex="500" class="form-control" style="width:50px;"> 
                    <input type="hidden" name="reg1" value="<?php echo $reg_nr1; ?>" />
                    <input type="hidden" name="reg2" value="<?php echo $reg_nr2; ?>" />
                  </div>
                </div>
                <hr />
              
               <?php } ?>           
                
                 <?php do_action('register_form_custom'); ?>
                <div class="clearfix"></div>
                 
                <input type="submit" class="btn btn-primary btn-lg" style="width:100%" value="<?php echo $CORE->_e(array('head','6')); ?>">
    	
    </form>    
    
    

 
	</div>
</div>


</div></div>



<?php hook_register_after(); ?>

<?php get_footer($CORE->pageswitch()); ?>
