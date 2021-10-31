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

global $CORE;


/* =============================================================================
   EDIT LISTING DATA
   ========================================================================== */ 
 
// CHECK IF WE ARE EDITING A LISTING
if(isset($_GET['eid']) && is_numeric($_GET['eid']) ){
	
	$ff = get_post($_GET['eid']);
	 
	$_POST['packageID'] = get_post_meta($_GET['eid'], 'packageID', true);
	
	if(isset($_GET['upgradepakid']) && is_numeric($_GET['upgradepakid']) ){
	$_POST['packageID'] = $_GET['upgradepakid'];
	}	
}







?>



 
<?php if(isset($_GET['eid'])){ ?>
<form method="get" name="PACKAGESFORM" action="<?php echo $GLOBALS['CORE_THEME']['links']['add']; ?>" id="PACKAGESFORM">
<input type="hidden" name="upgradepakid" id="packageID" value="1" />
<input type="hidden" name="eid" value="<?php echo $_GET['eid']; ?>" />
<?php }else{ ?>
<form method="post" name="PACKAGESFORM" action="<?php echo $GLOBALS['CORE_THEME']['links']['add']; ?>" id="PACKAGESFORM">
<input type="hidden" name="packageID" id="packageID" value="-1" />
<?php } ?>

 
 
<?php


// PACKAGE /MEMEBERSHIP DATA
$packagefields = $CORE->multisort( $GLOBALS['packagefields'] , array('order') );	
 
foreach($packagefields as $field){

	// SET FIRST ITEM AS DEFAULT PACKAGE ID
	if($_POST['packageID'] == ""){ $_POST['packageID'] = $field['ID']; }

	// HIDE IF HIDDEN
	if(isset($field['hidden']) && $field['hidden'] == "yes"){ continue; }
	
	// HIDE ALSO IF EXISTING PACKAGE HAS THIS MEMBERSHIP
	if(isset($GLOBALS['current_membership']) && is_numeric($GLOBALS['current_membership']) && $GLOBALS['current_membership'] == $field['ID']){ continue; }
	
	// WORK OUR PRICE
	$PRICE = hook_price($field['price']);
	if($field['price'] == "" || $field['price'] == 0){
	$PRICE = $CORE->_e(array('button','19'));
	}

?>
<a href="javascript:void(0);" onclick="document.getElementById('packageID').value='<?php echo $field['ID']; ?>';document.PACKAGESFORM.submit();">

<div class="clearfix packblock <?php if(isset($_POST['packageID']) && $field['ID'] != "" && $_POST['packageID'] == $field['ID']){ ?>selected<?php } ?>"><div class="wrap">
	
 
    <div class="price">
    <span><?php echo $PRICE; ?></span>
    </div>

	<span class="fa fa-info-circle pull-right infom<?php echo $field['ID']; ?>"></span>

	<h4><?php echo stripslashes($field['name']); ?></h4>

	<p><?php echo stripslashes($field['subtext']); ?></p>
	
</div></div>
</a>

<!----------------------- PACKAGE DESCRIPTION ------------------------->
		<div id="myModal<?php echo $field['ID']; ?>" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
		<div class="modal-dialog"><div class="modal-content">
		  <div class="modal-header">
			<button type="button" class="close" data-dismiss="modal" aria-hidden="true">x</button>
			<h4 class="modal-title"><?php echo stripslashes($field['name']); ?></h4>
		  </div>
		  <div class="modal-body">
		
        	<p><?php echo stripslashes($field['description']); ?></p>	
            
            
            <?php                   
		 
           $STRING = ' <ul class="list-group">';			
			
			  if(defined('WLT_AUCTION') ){	
				 if($GLOBALS['CORE_THEME']['auction_theme_usl'] == '1'){			 
				 }else{
				 	$STRING .= '<li class="list-group-item ">'.$PRICE." ".str_replace("%a", $field['expires'] ,$CORE->_e(array('add',34))).'</li>';
				 }
			 }else{			 
			 $STRING .= '<li class="list-group-item ">'.$PRICE." ".str_replace("%a", $field['expires'] ,$CORE->_e(array('add',34))).'</li>';
			 }   
			
			// LIST PACKAGE FEATURES
			if(!isset($field['enable_text']) || (isset($field['enable_text']) && $field['enable_text'] == "1" ) ){
			 
				$earray = array(
				'1' => array('dbkey'=>'frontpage',		'text'=>$CORE->_e(array('add','40')),'desc'=>$CORE->_e(array('add','40d')),  ),
				'2' => array('dbkey'=>'featured',		'text'=>$CORE->_e(array('add','41')),'desc'=>$CORE->_e(array('add','41d')) ),
				'3' => array('dbkey'=>'html',			'text'=>$CORE->_e(array('add','42')),'desc'=>$CORE->_e(array('add','42d')) ), 
				'4' => array('dbkey'=>'visitorcounter',	'text'=>$CORE->_e(array('add','43')),'desc'=>$CORE->_e(array('add','43d')) ),
				'5' => array('dbkey'=>'topcategory',	'text'=>$CORE->_e(array('add','44')),'desc'=>$CORE->_e(array('add','44d')) ),
				'6' => array('dbkey'=>'showgooglemap',	'text'=>$CORE->_e(array('add','45')),'desc'=>$CORE->_e(array('add','45d')) ),
				);
				$i=0;
				foreach($earray as $key=>$enhance){
					// CHECK WE ARE USING THIS FEATURE
					 if(defined('WLT_DEMOMODE') || $GLOBALS['CORE_THEME']['enhancement'][$key.'_price'] > 0){
						// NOW CHECK IF ITS PART OF THE PACKAGE
						if($i%2){ $bit = "even"; }else{ $bit = 'odd'; }
						if(isset($field['enhancement'][$key]) && $field['enhancement'][$key] == "1"){
						$STRING .= '<li class="list-group-item row-'.$bit.'">
						<span class="col-md-2"><i class="glyphicon glyphicon-ok"></i></span>
						<span class="col-md-10">'.$enhance['text'].'</span>
						<div class="clearfix"></div>
						</li>';
						}else{ 
						$STRING .= '<li class="list-group-item row-'.$bit.'">
						<span class="col-md-2"><i class="glyphicon glyphicon-remove"></i></span>
						<span class="col-md-10">'.$enhance['text'].'</span>
						<div class="clearfix"></div>
						</li>';
						 
						}// END IF
						$i++;
					 } // END IF		
				} // END FOREACH
				
				
				 
			}// end if default text
			
			// ADD ON EXTRAS DEFINED BY THE USER
			 $i=1; 
			 while($i < 10){
			 if(isset($field['etext'.$i]) && strlen($field['etext'.$i]) > 1){
				 if($i%2){ $bit = "even"; }else{ $bit = 'odd'; }
				 $STRING .= '<li class="list-group-item row-'.$bit.'">
							'.$field['etext'.$i].'
							</li>';
				}
				$i++; 
			}  
			
			echo $STRING;
            ?>
            		
		  </div>
		  
		</div>
		</div></div> 		
		<!----------------------- end PACKAGE DESCRIPTION ------------------------->

<script>

jQuery('.infom<?php echo $field['ID']; ?>').hover(function () {
    jQuery('#myModal<?php echo $field['ID']; ?>').modal({
        show: true
    });
});

</script>
<?php } ?>

</form>






<?php

$total_price = 0; $total_days = 0; $total_packages_price = $GLOBALS['CORE_THEME']['enhancement']['1_price']+
$GLOBALS['CORE_THEME']['enhancement']['2_price']+
$GLOBALS['CORE_THEME']['enhancement']['3_price']+
$GLOBALS['CORE_THEME']['enhancement']['5_price']+
$GLOBALS['CORE_THEME']['enhancement']['6_price']+
$GLOBALS['CORE_THEME']['enhancement']['4_price'];
 

// ADD-ON PACKAGE PRICE
if(isset($_GET['eid']) && !isset($_GET['upgradepakid'])){ 
$total_price = get_post_meta($_GET['eid'],'listing_price_due',true);
}else{
$total_price += $CORE->packagedata($_POST['packageID'],"price");;
}
 
 
?>

 
 
<div class="panel panel-default" id="enhancementsblock"> 
<div class="panel-body"> 
 
<?php 
  

if(  ( !isset($_GET['eid']) && $total_packages_price+$total_price > 0 ) || ( isset($_GET['eid']) && ( get_post_meta($_GET['eid'], 'listing_price_paid',true) == "" || isset($_GET['upgradepakid']) ) && $total_packages_price+$total_price > 0 ) ){ ?>

 

 
<?php if($GLOBALS['CORE_THEME']['show_enhancements'] == 1 && $GLOBALS['packagefields'][$_POST['packageID']]['price']+$total_packages_price > 0){  ?>
     
    <?php if($total_packages_price > 0  ){  ?> 
    
    <h4><?php echo $CORE->_e(array('add','31')); ?></h4>
    
    <p><?php echo $CORE->_e(array('add','32')); ?></p>
    
    <?php echo $CORE->packageenhancements(); ?>
    
    <hr />
    
    <?php } ?>
     
<?php } 

 
if(!is_numeric($total_price)){ $total_price = 0; }
$total_days += $GLOBALS['packagefields'][$_POST['packageID']]['expires']; 
?>
<p><?php echo $CORE->_e(array('add','33')); ?>: </p>
<div class="alert alert-success text-center totalpayment"><?php echo $GLOBALS['CORE_THEME']['currency']['symbol']; ?><span id="listingprice"><?php echo hook_price(array($total_price, false)); ?></span>
<?php if($total_days > 0){ ?> <?php echo str_replace("%a",$total_days,$CORE->_e(array('add','34'))); ?><?php } ?>
</div>
   
<?php /* end NEW PACKAGE OPTIONS ADDED IN NEW VERSION */ ?>
<?php  }

?>









<?php if(isset($_GET['eid']) ){  ?>

<div class="media">
 

<div class="editinfo">
<ul>

<li><span><?php echo $CORE->_e(array('add','6')); ?></span> <?php 
if(isset($GLOBALS['packagefields'][$_POST['packageID']]['name']) && $GLOBALS['packagefields'][$_POST['packageID']]['name'] != ""){ 
echo $GLOBALS['packagefields'][$_POST['packageID']]['name']; 
}else{
 echo $CORE->_e(array('add','70')); 
} 

?> &nbsp; </li>

<li><span><?php echo $CORE->_e(array('single','17')); ?></span> <?php echo hook_date($ff->post_date); ?></li>
<?php if($ff->post_date != $ff->post_modified){ ?>
<li><span><?php echo $CORE->_e(array('single','18')); ?></span> <?php echo hook_date($ff->post_modified); ?></li>
<?php } ?>
<li><span><?php echo $CORE->_e(array('single','19')); ?></span> <?php echo get_post_meta($_GET['eid'],'hits',true).' '.$CORE->_e(array('single','33')); ?></li>
<?php $expires = get_post_meta($_GET['eid'], 'listing_expiry_date',true); if($expires != ""){ ?>
<li><span><?php echo $CORE->_e(array('single','20')); ?></span> <?php echo hook_date($expires); ?></li>
<?php } ?>
</ul>
</div>


<?php if(isset($GLOBALS['CORE_THEME']['renewlisting']) && $GLOBALS['CORE_THEME']['renewlisting'] == 1){  echo $CORE->RENEW_TOOLBOX($_GET['eid'], false); } ?> 

</div>

<?php }  ?>



    </div>
</div>





 