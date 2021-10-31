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

$sellspace = $CORE->SELLSPACE(2);

$mybanners = $CORE->SELLSPACE(3, $userdata->ID);

$sellspacedata = $GLOBALS['CORE_THEME']['sellspace']; ?>

<?php if(isset($_GET['selladd'])){ ?>
    <script>
	jQuery(document).ready(function(){
	
	jQuery('#MyAccountBlock').hide();jQuery('#MyAdvertising').show();	 

	});
	</script>
<?php } ?>	

<div class="panel panel-default" id="MyAdvertising" style="display:none;">
        
<div class="panel-heading"><?php echo $CORE->_e(array('account','89')); ?></div>
		 
<div class="panel-body" id="PremiumAdvertising">    
    
 	<ul class="nav nav-tabs" id="SellSpaceTabs">
    
	<div class="liner"></div>
					
    	<li class="active"><a href="#a1" data-toggle="tab"><?php echo $CORE->_e(array('account','90')); ?></a></li>

    	<li><a href="#a2" data-toggle="tab"><?php echo $CORE->_e(array('account','91')); ?></a></li>
    
    	<li><a href="#a3" data-toggle="tab" class="graphtab"><?php echo $CORE->_e(array('account','92')); ?></a></li>
  
    </ul></div>

	<div class="tab-content" style="padding:20px;">
    
    <div class="tab-pane fade" id="a3"> <div class="well">

    <?php
 
    // COUNT EXISTING ADVERTISERS
	$campaigns = new WP_Query( array('posts_per_page' => 200, 'post_type' => 'wlt_campaign', 'orderby' => 'post_date', 'order' => 'desc', 'author' => $userdata->ID  ) );
  	
	$showcart = false;
 	
	if(empty($campaigns->posts)){
	?>
    <div class="text-center"><?php echo $CORE->_e(array('account','93')); ?></div>
    <?php
	}
	if(!empty($campaigns->posts)){  
   ?>
   
   <h2 style="padding-top:0px;margin-top:0px;"><?php echo $CORE->_e(array('account','94')); ?></h2>
  
   <hr />
  

		   
      <?php foreach($campaigns->posts as $order){ 
	  
	  // BITS
	  $bits = explode("-",$order->post_title);
	  
	  // AVAILABLE BANNERS
	  $avibanner = $CORE->SELLSPACE(3, $userdata->ID, array($sellspace[$bits[1]]["sw"], $sellspace[$bits[1]]["sh"]));
	  
	  // TIME LEFT
	  $timeleft = get_post_meta($order->ID, 'listing_expiry_date',true);
	  
	  // GET ACTIVE BANNER ID
	  $activebannerID = get_post_meta($order->ID, 'bannerid', true);
	  
	  ?>
      
      <ul class="list-group" style="background:#fff; margin-bottom:20px;">
      
      <li class="list-group-item">
      
      <div class="col-md-6">      
      <div> <b><?php echo $sellspace[$bits[1]]["n"]; ?></b> </div>      
      <small><?php echo $CORE->_e(array('account','95')); ?>: <?php echo $sellspace[$bits[1]]["sw"]; ?> x <?php echo $sellspace[$bits[1]]["sh"]; ?></small>      
      </div>    
     
      <div class="col-md-3 text-center">
      <div><?php echo $CORE->_e(array('account','96')); ?></div>
      <small><?php echo get_post_meta($order->ID, 'impressions', true); ?></small>      
      </div>    
      
      <div class="col-md-3 text-center">
      <div><?php echo $CORE->_e(array('account','97')); ?></div>
      <small><?php echo get_post_meta($order->ID, 'clicks', true); ?></small>      
      </div>    
      
      <div class="clearfix"></div>
      
      </li> 
      
      <li class="list-group-item">
      
      <?php $showcart=true; echo do_shortcode('[VISITORCHART postid="'.$order->ID.'" sellspace=1]'); ?>
      
      </li>
      
    <form action="" method="post" >
	<input type="hidden" name="action" value="sellspace_set" />
   	<input type="hidden" name="cid" value="<?php echo $order->ID; ?>" />
     
     <li class="list-group-item">
       
     <div class="pull-right">
     
	 <?php  if(is_array($avibanner) && !empty($avibanner) ){ ?>
    
    <?php echo $CORE->_e(array('account','98')); ?>:
          
      <select name="bannerid" class="selectpicker">
      <option></option>
      <?php 
	  foreach( $avibanner as $kh){ ?>
      <option value="<?php echo $kh['id']; ?>" <?php selected( $activebannerID, $kh['id'] ); ?>> <?php echo $kh['name']; ?> </option>
      <?php } ?>
      </select>  
        
      
      <?php }else{ ?>
      
      <div class="alert alert-info" style="margin:0px;"><?php echo $CORE->_e(array('account','99')); ?>:  <?php echo $sellspace[$bits[1]]["sw"]; ?> x <?php echo $sellspace[$bits[1]]["sh"]; ?></div>
      
      <?php } ?>
      
      </div>
      
      <div class="clearfix"></div>
      
      </li>
      
      <li class="list-group-item">
      
      <div class="pull-right">
      <?php echo $CORE->_e(array('account','100')); ?>: <input type="input"   name="camurl" value="<?php echo get_post_meta($order->ID, 'url', true); ?>"  />
      </div> 
      
      <div class="clearfix"></div>
      
      </li>
      <li class="list-group-item">
      <?php if($activebannerID != "" && $activebannerID != 0 ){?>
      <small> <?php if($timeleft != ""){ echo "Time Left: ". do_shortcode('[TIMELEFT key="listing_expiry_date" postid="'.$order->ID.'" layout="1"]'); } ?></small>
      <?php } ?>
      <button class="btn btn-success pull-right">save</button>   
      
      <div class="clearfix"></div>
      
      </li>
      
       </form>
       
      </ul>     
   	
	  <?php }
	  
	  
	  // END QUERY
	wp_reset_postdata();
	
	   ?>
       
       
       

   
   <?php } ?>
   
    </div></div>
   
    <div class="tab-pane fade" id="a2"><div class="well">
    
    <a href="javascript:void(0);" onclick="jQuery('#bupload').show();" class="pull-right btn btn-info"><?php echo $CORE->_e(array('account','101')); ?></a>
         
      <h2 style="padding-top:0px;margin-top:0px;"><?php echo $CORE->_e(array('account','102')); ?></h2>
      <hr />
        
     
	<form action="" method="post"  enctype="multipart/form-data" style="display:none" id="bupload">
	<input type="hidden" name="action" value="sellspace" />
     
   
    
    <p><?php echo $CORE->_e(array('account','104')); ?></p>
   
    <input type="file" name="wlt_banner[]" />
    <input type="file" name="wlt_banner[]" />
    <input type="file" name="wlt_banner[]" />
    <input type="file" name="wlt_banner[]" />
    <br />
    <a href="javascript:void(0);" onclick="jQuery('#bupload').hide();" class="pull-right btn btn-default"><?php echo $CORE->_e(array('single','14')); ?></a>
    <button type="submit" class="btn btn-success"><?php echo $CORE->_e(array('button','6')); ?></button>   
   
    <hr /> 
    </form>
    
        
    <?php if(!empty($mybanners)){	?>
    
	  <ul class="list-group" style="background:#fff;">
      <?php foreach($mybanners as $k=> $ban){ ?>
      <li class="list-group-item">
      
          <div class="col-md-9">
          <p><?php echo $ban['w']; ?> X <?php echo $ban['h']; ?> </p>
          <a href="<?php echo $ban['img']; ?>" target="_blank" class="frame"><img src="<?php echo $ban['img']; ?>" class="img-responsive"></a>
          </div>
         
          
          <div class="col-md-3">
           <form action="" method="post" >
			<input type="hidden" name="action" value="sellspace_delete" />
   			<input type="hidden" name="delid" value="<?php echo $ban['id']; ?>" />
   
          <button class="btn btn-lg btn-success"><?php echo $CORE->_e(array('button','3')); ?></button>
          </form>
          </div>
      
      <div class="clearfix"></div>
      
      </li>
      <?php } ?>
      </ul>
   
   <?php } ?>       
       
       
	
       
  </div></div>
        
        
   <div class="tab-pane fade in active" id="a1"> <div class="well"> 
     
  <h2 style="padding-top:0px;margin-top:0px;"><?php echo $CORE->_e(array('account','103')); ?></h2>
  <hr />
 
  <?php echo do_shortcode('[SELLSPACE]'); ?>
 	
    
    <div class="clearfix"></div>
    
    
    </div>
        
        </div>  
    
    
    
    <hr />
              
    <button class="btn  btn-default pull-right" type="button" onclick="jQuery('#MyAccountBlock').show();jQuery('#MyAdvertising').hide();"><?php echo $CORE->_e(array('button','7')); ?></button>
	
    <div class="clearfix"></div>
         
    </div> 
    
</div> 

<?php if( $showcart ){ ?>

<script type="text/javascript" src="https://www.google.com/jsapi"></script>

<?php } ?>