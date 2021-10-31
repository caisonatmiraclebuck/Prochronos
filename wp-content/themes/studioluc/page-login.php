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

<div class="row">



<div class="col-md-4 col-md-offset-4">

<?php hook_login_before(); ?>

<div class="panel panel-default" id="login_box">

<div class="panel-heading"><?php echo $CORE->_e(array('head','5')); ?></div>

	<div class="panel-body"> 
    
    
    
    
    
	<?php if(strlen($errortext) > 1){ ?>
    
     <div class="bs-callout bs-callout-danger"> <?php echo $errortext; ?>  </div>    
 
    
    <?php } ?> 
     
    <form class="loginform" id="loginform" action="<?php echo esc_url( site_url( 'wp-login.php', 'login_post' ) ); ?>" method="post" > 
    <input type="hidden" name="testcookie" value="1" /> 
    <input type="hidden" name="rememberme" id="rememberme" value="forever" />
    
    <?php /*if(!isset($_GET['redirect_to'])){ ?>
    <input type="hidden" name="redirect_to" value="<?php echo $GLOBALS['CORE_THEME']['links']['myaccount']; ?>" />     
    <?php } */ ?>
    
                <div class="form-group clearfix">
                  <label  for="inputEmail"><?php echo $CORE->_e(array('login','10')); ?></label>
                    <div class="input-group">
                      <span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
                       <input type="text" name="log" id="user_login" class="form-control" > 
                    </div>              
                </div>
    
                  <div class="form-group clearfix">
                  <label for="inputPassword"><?php echo $CORE->_e(array('account','10')); ?></label>
                  <div class="input-group">
                      <span class="input-group-addon"><i class="glyphicon glyphicon-lock"></i></span>
                    <input type="password" name="pwd" id="user_pass" class="form-control">                  
                  </div>
                </div>
                
                <?php do_action('login_form'); ?>
                 
                <hr />
                
                <div class="text-center">
                 <input type="submit" name="wp-submit" class="btn btn-primary btn-lg" style="width:100%;" value="<?php echo $CORE->_e(array('head','5')); ?>">  
                
                </div>
                
 
                
<?php if($GLOBALS['CORE_THEME']['allow_socialbuttons'] == '1'){ ?>
<hr />
<div class="wlt_socialloginbtns">

<h4>or sign-in with</h4>
<?php if($GLOBALS['CORE_THEME']['social_facebook'] == 1){ ?>
<div>
          <a href="<?php echo home_url(); ?>/?sociallogin=facebook" class="btn btn-lg btn-block onl_btn-facebook" data-toggle="tooltip" data-placement="top" title="" data-original-title="Facebook">
              <i class="fa fa-facebook fa-2x"></i>
              <span class="hidden-xs"></span>
            </a>
</div>
<?php } ?>
<?php if($GLOBALS['CORE_THEME']['social_twitter'] == 1){ ?>
<div>          
<a href="<?php echo home_url(); ?>/?sociallogin=twitter" class="btn btn-lg btn-block onl_btn-twitter" data-toggle="tooltip" data-placement="top" title="" data-original-title="Twitter">
              <i class="fa fa-twitter fa-2x"></i>
              <span class="hidden-xs"></span>
            </a>
</div>
<?php } ?>
<?php if($GLOBALS['CORE_THEME']['social_google'] == 1){ ?>
<div>            
<a href="<?php echo home_url(); ?>/?sociallogin=google" class="btn btn-lg btn-block onl_btn-google-plus" data-toggle="tooltip" data-placement="top" title="" data-original-title="Google Plus">
              <i class="fa fa-google-plus fa-2x"></i>
              <span class="hidden-xs"></span>
            </a>
</div>
<?php } ?> 
<?php if($GLOBALS['CORE_THEME']['social_linkedin'] == 1){ ?>
<div>           
<a href="<?php echo home_url(); ?>/?sociallogin=linkedin" class="btn btn-lg btn-block onl_btn-linkedin" data-toggle="tooltip" data-placement="top" title="" data-original-title="LinkedIn">
              <i class="fa fa-linkedin fa-2x"></i>
              <span class="hidden-xs"></span>
            </a>
</div> 
<?php } ?>
</div>
 <?php } ?>               
                <hr />
                
                <?php if(get_option('users_can_register') == 1 || defined('WLT_DEMOMODE') ){ ?>
                
                <a href="<?php echo site_url('wp-login.php?action=register', 'login_post'); ?>" class="btn btn-default"><?php echo $CORE->_e(array('head','6')); ?></a>
                
                <?php } ?>
                
                <a href="<?php echo site_url('wp-login.php?action=lostpassword', 'login_post'); ?>" class="btn btn-default pull-right"><?php echo $CORE->_e(array('login','29')); ?></a>
                
               
    </form>
          
	</div>
     
</div>    


</div> 
</div>



<?php hook_login_after(); ?>
	
<?php get_footer($CORE->pageswitch()); ?>