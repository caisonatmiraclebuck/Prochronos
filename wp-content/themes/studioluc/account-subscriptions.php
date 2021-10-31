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

?>
<div class="panel panel-default" id="MySubscriptionBlock" style="display:none;">

    <div class="panel-heading"><?php echo $CORE->_e(array('account','44')); ?></div>
             
    <div class="panel-body"> 
             
             <form method="post">
             <input type="hidden" name="action" value="subscrption" /> 
             
             <p><?php echo $CORE->_e(array('account','49')); ?></p>
             
             <select class="form-control" name="selsubs[]" multiple="multiple" style="height:200px;">
             <?php 
             
             $user_subscriptions = get_user_meta($userdata->ID,'email_subscriptions',true);
             $user_subscriptions = str_replace("**","*",$user_subscriptions);
             $us = explode("*",$user_subscriptions);
             echo $CORE->CategoryList(array($us,false,0,THEME_TAXONOMY)); ?>
             </select>
             
             <hr />
             
            <div class="text-center">
            
            <button class="btn btn-primary btn-lg" type="submit"><?php echo $CORE->_e(array('button','6')); ?></button>
          
          	</div>
             
            </form>
              
    </div>
    
</div>