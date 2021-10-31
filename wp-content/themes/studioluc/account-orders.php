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

$order_string = $CORE->MYORDERS(); 

if(strlen($order_string) > 1){ ?> 
        
<div class="panel panel-default hidden-xs" id="MyOrders">
        
	<div class="panel-heading"><?php echo $CORE->_e(array('order_status','title0')); ?></div>
		 
		<div class="panel-body">
        
        <table class="table table-striped">
              <thead>
                <tr>
                  <th>#</th>
                  <th><?php echo $CORE->_e(array('order_status','title1')); ?></th>
                  <th><?php echo $CORE->_e(array('order_status','title2')); ?></th>
                  <th><?php echo $CORE->_e(array('order_status','title3')); ?></th>
                  <th><?php echo $CORE->_e(array('order_status','title4')); ?></th>
                  <th> </th>
                </tr>
              </thead>
              <tbody>
              <?php echo $order_string; ?>              
              </tbody>
            </table>
         
         <?php do_action('hook_account_orders_after'); ?>
         
		</div>       
        
</div>        

<?php }