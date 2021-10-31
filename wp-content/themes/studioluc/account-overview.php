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

global $CORE, $userdata; $membershipfields = get_option("membershipfields");

// GET MESSAGE COUNT
$mc = $CORE->MESSAGECOUNT($userdata->user_login);
if($mc == ""){ $mc = 0; }

// GET LISTING COUNT
$listings = $CORE->count_user_posts_by_type( $userdata->ID, THEME_TAXONOMY."_type","", false );
 
// GET TOTAL ORDERS
$orders = $CORE->ORDERTOTAL( $userdata->ID );

?>
 
<div id="MyDashboardBlock">

	<div class="account_header">
    
		<div class="account_header_wrapper">

		<ul class="list-group list-inline clearfix">

        <li class="col-md-4 hidden-xs ">
        
        <small><?php echo $CORE->_e(array('checkout','24')); ?>
        
        <?php if($GLOBALS['CORE_THEME']['show_account_names'] == 1){ $current_user = get_currentuserinfo(); if($current_user->user_firstname != ""){ ?>
        
         , <?php echo $current_user->user_firstname; ?> !
        
        <?php } } ?>
         
         </small>
        
        <h1><?php echo $CORE->_e(array('head','4')); ?></h1>
        
        </li>
        
        <?php ob_start(); ?>

        <li class="list-group-item col-md-3 col-sm-12 col-xs-12 text-center">
        <a href="javascript:void(0);" onclick="jQuery('#MyDetailsBlock').hide();jQuery('#MyMsgBlock').show(); jQuery('#MyFeedback').hide(); jQuery('#MyDashboardBlock').hide();">
        <span><?php echo $mc; ?></span> <?php echo $CORE->_e(array('account','113')); ?></a></li>
        
        <li class="list-group-item col-md-3 col-sm-12 col-xs-12 text-center">
        <a href="<?php echo get_home_url()."/?s=&uid=".$userdata->ID; ?>">
        <span><?php echo $listings; ?></span> <?php echo $CORE->_e(array('account','114')); ?></a></li>
        
        <li class="list-group-item col-md-2 col-sm-12 col-xs-12 text-center">
        <a href="#bottom">
        <span><?php echo $orders; ?></span> <?php echo $CORE->_e(array('account','115')); ?></a></li>
        
        <?php $SavedContent = ob_get_clean(); echo hook_account_dashboard_items($SavedContent);  ?>
        
        </ul>


      <?php if($GLOBALS['current_membership'] != "" && is_numeric($GLOBALS['current_membership']) && is_array($membershipfields) ){ ?>
       
            <div class="membershipinfo">
            <?php
			$date_expires = hook_date($GLOBALS['current_membership_expires']);
			if(strlen($date_expires) > 1){
			?>   
            <div class="pull-right"><?php echo $CORE->_e(array('single','20')); ?>: <?php echo $date_expires; ?></div>
            <?php } ?>
            
              <b><?php echo $membershipfields[$GLOBALS['current_membership']]['name']; ?></b> 
             
            <?php /** SHOW RENEW BUTTON IF EXPIRING SOON **/ 
			
			
			if(strtotime(date('Y-m-d H:i:s')) > strtotime(date('Y-m-d H:i:s', strtotime($GLOBALS['current_membership_expires']. '-30 days'))) ){ ?>
			<div class="clearfix"></div>
			<a class="btn btn-primary btn-right" href="javascript:void(0);" style="margin-top:10px;margin-right:0px;" onclick="document.getElementById('membershipID').value='<?php echo $GLOBALS['current_membership']; ?>';document.MEMBERSHIPFORM.submit();"><?php echo $CORE->_e(array('account','67')); ?></a>
            <div class="clearfix"></div>
            <?php }  /*---------------------------------------*/ ?>
           
                	    
			</div>
            
      <?php } ?> 
      
       <!-- START CUSTOM TEXT DISPLAY -->            
        <?php if(strlen($GLOBALS['customtext']) > 1){ echo "<hr />".$GLOBALS['customtext'].""; } ?>      

     

</div>
</div>              
<div class="clearfix"></div>  


<!-- ------------- -->
<?php if(is_numeric($GLOBALS['usercredit']) && $GLOBALS['usercredit'] < 0){ $current_price = str_replace("-","",$GLOBALS['usercredit']); ?>
            
         
             <div class="alert alert-danger">
               <b><span class="label label-danger"><?php echo $CORE->_e(array('account','77')); ?></span></b> 
               <span class="pull-right"><button style="margin-top:5px;" href="#myPaymentOptions" role="button" class="btn btn-danger" data-toggle="modal"><?php echo $CORE->_e(array('button','21')); ?></button></span>
               <br /><small><?php echo str_replace("%a",hook_price($current_price),$CORE->_e(array('account','78'))); ?></small>
               
               <div class="clearfix"></div>
			</div>           
            <?php 
			
			$STRING = ' 
				<!-- Modal -->
				<div id="myPaymentOptions" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
				 <div class="modal-dialog"><div class="modal-content">
				  <div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-hidden="true">x</button>
					<h4 id="myModalLabel">'.$CORE->_e(array('single','13')).' ('.hook_price($current_price).')</h4>
				  </div>
				  <div class="modal-body">'.$CORE->PAYMENTS(round($current_price,2), "PAY-".$userdata->ID."-".date("Ymd"), $post->post_title, $post->ID, $subscription = false).'</div>
				  <div class="modal-footer">
				  '.$CORE->admin_test_checkout().'
				  <button class="btn" data-dismiss="modal" aria-hidden="true">'.$CORE->_e(array('single','14')).'</button></div></div></div></div>
				<!-- End Modal -->';
				
				echo $STRING;
			
} ?>              
<!-- ------------- -->      
            
           
            
          <?php echo hook_account_dashboard_before(); ?>  
  

            
<div class="row">
          
    <div class="col-md-6">
 
        
     <div class="panel panel-default">
        <div class="panel-body">
       
        
        
        <ul class="nav nav-tabs" id="Tabs">
        
        <li class="active"><a href="#t1" data-toggle="tab"><?php echo $CORE->_e(array('account','109')); ?></a></li>
        
        <li><a href="#t2" data-toggle="tab"><?php echo $CORE->_e(array('account','111')); ?></a></li>
     
</ul>
 
<div class="tab-content">
        
        <div class="tab-pane active" id="t1">
        
         <ul class="listboxes">
        <?php 
		$recent = $CORE->RECENTLYVIEWED("", "", true);
		if(!empty($recent)){ $i = 0; $recent = array_reverse($recent);
		foreach ( $recent as $key) { $p = get_post($key); if($p->post_title == ""){ continue; } if($i > 9){ continue; }
		?>
		<li><a href="<?php echo get_permalink($p); ?>"><?php echo $p->post_title; ?></a></li>
		<?php $i++; }   ?>
		<?php }else{ ?>    
		<li><?php echo $CORE->_e(array('account','110')); ?></li>
		<?php } ?>
        		
		</ul>
        
         </div>
        
        <div class="tab-pane" id="t2">
        
         <ul class="listboxes">
        <?php $my_list = $CORE->MYFAVLIST($userdata->ID);
		
		if(!empty($my_list)){ ?>
        
        <?php $i=0; foreach($my_list as $ff){ if($i > 9){ continue; } $ff_l = get_post($ff); if($ff_l->post_title == ""){ continue; } ?>
        <li><a href="<?php echo get_permalink($ff_l); ?>"><?php echo $ff_l->post_title; ?></a></li>
        
        <?php $i++; } ?>
        
        <?php if(count($my_list) > 9){ ?>
        <li style="list-style:none;"><a href="<?php echo home_url()."/?s=&favs=1"; ?>" class="btn btn-success" style="display:block;margin-top:20px;"><?php echo $CORE->_e(array('button','35')); ?></a></li>
        <?php } ?>
       
       <?php  }else{ ?>
       <li><?php echo $CORE->_e(array('account','112')); ?></li>
       <?php } ?>
       </ul>
        
        </div>
        
    
       
</div>
       
       
        </div>
        </div>

	</div>    

    <div class="col-md-6">
    
    <?php if($GLOBALS['CORE_THEME']['show_account_latestnews'] != 1){ ?>
    
        <div class="panel panel-default" style="min-height:400px;">
        
        <div class="panel-heading"><?php echo $CORE->_e(array('homepage','19')); ?></div>
        
        <div class="panel-body">
         
 
        <div class="activity-feed">
        
        	<?php	
			
			$args = array(
				'post_type' 		=> 'post',
				'posts_per_page' 	=> 100,
			 
			);
			$the_query = new WP_Query($args);
			 
			if ( $the_query->have_posts() ) :
												 
			while ( $the_query->have_posts() ) :  $the_query->the_post(); 
			 
			?>
             
			   <div class="feed-item">
            <div class="date"><?php echo hook_date($post->post_date); ?></div>
            <div class="text"><a href="<?php echo get_permalink($post->ID); ?>"><?php echo $post->post_title; ?></a></div>
          </div>
			 
			<?php endwhile; endif; ?>
        
       
         
        </div>
       
       
        </div>
        </div>
        
        <?php } ?>
    
    </div> 
            
</div> 
 

        <?php if(!defined('HIDE_MYACCOUNT_ORDERS')){ ?>
        
        	<?php get_template_part( 'account', 'orders' ); ?> 
        
        <?php } ?> 
        
        <?php if($GLOBALS['CORE_THEME']['show_account_membership'] == '1' && !defined('WLT_CART') ){  ?>
        
            <?php get_template_part( 'account', 'membership' ); ?> 
        
        <?php } ?> 
         
</div>            
      
         
   <?php echo hook_account_dashboard_after(); ?>          
             
         
		
       
		<div  id="MyAccountBlock" <?php if(isset($_GET['tab'])){ echo "style='display:none;'"; } ?>>
        
		<?php echo hook_account_menu(); ?>	
        		
		<div class="clearfix"></div>
        
        </div>
            