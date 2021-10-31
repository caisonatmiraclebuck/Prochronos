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
<div class="panel panel-default" id="MyWidthdrawlBlock" style="display:none;">
        
	<div class="panel-heading"><?php echo $CORE->_e(array('account','55')); ?></div>
		 
		<div class="panel-body"> 
        
        <p><?php echo $CORE->_e(array('account','56')); ?></p>
        <p><b><?php echo $CORE->_e(array('account','57')); ?> <?php echo hook_price($GLOBALS['usercredit']); ?></b></p>
        <?php if(strlen($GLOBALS['CORE_THEME']['auction_house_percentage']) > 0){ ?>
        <p><?php echo str_replace("%a",$GLOBALS['CORE_THEME']['auction_house_percentage'],$CORE->_e(array('account','58'))); ?></p>
        <?php } ?>
        <hr />
        
         
        <form method="post">
        <input type="hidden" name="action" value="withdraw" /> 
        
          <div class="form-group">
            <label class="control-label" for="inputEmail"><?php echo $CORE->_e(array('account','59')); ?></label>
            <div class="controls">
              
            <div class="input-group"> 
            <span class="input-group-addon"><?php echo $GLOBALS['CORE_THEME']['currency']['symbol']; ?></span>
			<input type="text" name="amount" class="form-control" style="width:100px;" /> 
			</div>
              
            </div>
          </div>
          <div class="form-group">
            <label class="control-label"><?php echo $CORE->_e(array('account','60')); ?></label>
            <div class="controls">
              <textarea name="message" style="height:150px;" class="form-control"></textarea>
            </div>
          </div>
          <div class="form-group">
            <div class="controls">
              <label class="checkbox">
                
              </label>
              <button type="submit" class="btn btn-primary"><?php echo $CORE->_e(array('account','61')); ?></button>
            </div>
          </div>
        </form>
        
      	<hr />
        		 
		<button class="btn btn-default pull-right" type="button" onclick="jQuery('#MyAccountBlock').show();jQuery('#MyWidthdrawlBlock').hide();"><?php echo $CORE->_e(array('button','7')); ?></button>
		
        <div class="clearfix"></div>
        
        </div>
        
        </div>