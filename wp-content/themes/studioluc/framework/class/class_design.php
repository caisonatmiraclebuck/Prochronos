<?php
function WLT_FeedbackSystem($authorID){  global $CORE, $wpdb, $userdata;

if(isset($GLOBALS['CORE_THEME']['feedback_enable']) && $GLOBALS['CORE_THEME']['feedback_enable'] == '1'){

// GET USER FEEDBACK
$query = new WP_Query('posts_per_page=200&post_type=wlt_feedback&meta_key=uid&meta_value='.$authorID); 
$posts = $query->posts;
 
// GET MY FEEDBACK
$query1 = new WP_Query('posts_per_page=200&post_type=wlt_feedback&meta_key=auid&meta_value='.$authorID); 
$posts1 = $query1->posts;
?>    

<ul class="nav nav-tabs feedbacktabs" role="tablist">
  
  	<?php if(isset($GLOBALS['flag-myaccount'])){ ?>
  	<li class="active"><a href="#fb3" role="tab" data-toggle="tab">How it works.</a></li>
	<?php } ?>
  
	<li <?php if(!isset($GLOBALS['flag-myaccount'])){ ?>class="active"<?php } ?>>
    <a href="#fb0" role="tab" data-toggle="tab"><?php echo $CORE->_e(array('feedback','0')); ?> (<?php echo $query->found_posts; ?>)</a>
    </li>

	<li><a href="#fb1" role="tab" data-toggle="tab"><?php echo $CORE->_e(array('feedback','24')); ?> (<?php echo $query1->found_posts; ?>)</a></li>
     
</ul>

<div class="tab-content">

<?php if(isset($GLOBALS['flag-myaccount'])){ ?>
<div role="tabpanel" class="tab-pane active" id="fb3"> 

<div class="text-center">
<i class="glyphicon glyphicon-star" style="font-size:200px;margin-top:40px; margin-bottom:20px;"></i>

<div class="clearfix">

<p>Leave feedback on your experience with a user and their listing and help us build a smarter community.</p>

<p>The feedback you leave will help us create a trust factor and overall rating for a user.</p>

<p>Please try to resolve issues with the user before leaving feedback and avoid using rude and abusive comments.</p>

</div>

</div>

</div>
<?php } ?>


<?php $i = 0; while($i< 2){ 

// GET DATA QUERY
if($i == 0){ $data =  $posts; }else { $data = $posts1; }

// OUTPUT DISPLAY
?>

<div role="tabpanel" class="tab-pane <?php if($i == 0 && !isset($GLOBALS['flag-myaccount']) ){ ?>active<?php } ?>" id="fb<?php echo $i; ?>"> 
 
	<?php if(!empty($data)){ ?> 
     
	<ul class="list-group">

		<?php foreach($data as $post){

		// GET LISTING ID
		$listingid = get_post_meta($post->ID,'pid',true);
		if(!is_numeric($listingid)){ continue; }
		
		// GET SCORE
		$score = get_post_meta($post->ID,'score',true);
		if($score == ""){ $score = 0; }
		
		// CHECK IF THIS USER HAS PURCHASED THIS ITEM
		$SQL1 = "SELECT count(*) AS total FROM `".$wpdb->prefix."core_orders` WHERE order_items LIKE ('%".$listingid."%') AND user_id='".$post->post_author."' LIMIT 1 ";
		$result1 = $wpdb->get_results($SQL1);
		
		?>
		<li class="list-group-item"> 
         
			<div class="row">
    
			<div class="col-xs-3 col-md-3">
        
       		<small><a href="<?php echo get_permalink($listingid); ?>"><?php echo $CORE->_e(array('feedback','22')); ?> <?php echo get_post_meta($post->ID,'pid',true); ?></a></small>
        
       		<script type='text/javascript'>jQuery(document).ready(function(){ 
				jQuery('#wlt_feedbackstar_<?php echo $post->ID; ?>').raty({
				readOnly:  true,
				path: '<?php echo FRAMREWORK_URI; ?>img/rating/',
				score: <?php echo $score; ?>,
				size: 24,
				
				 
				}); });
            </script>
             
            <div id="wlt_feedbackstar_<?php echo $post->ID; ?>" class="wlt_starrating"  style="margin-top:10px;"></div> 
                
			   <?php if($result1[0]->total == 1){ ?>
               
               <span class="label label-success"><?php echo $CORE->_e(array('feedback','23')); ?></span>
               
               <?php } ?>
                    
               <?php if($userdata->ID == $post->post_author  ){ // && $result1[0]->total == 0 ?>
             
                
                <form id="deletefeedbackfrom" name="deletefeedbackfrom" method="post" action="" style="margin-top:10px;">         
                <input type="hidden" name="action" value="delfeedback" />         
                <input type="hidden" name="fid" value="<?php echo $post->ID; ?>" />
                <button type="submit"><?php echo $CORE->_e(array('feedback','9')); ?></button>        
                <div class="clearfix"></div>         
                </form>
            
                <?php } ?> 
            
            </div>
             
             <div class="col-xs-9 col-md-9">
             
             <?php echo "<a href='".get_author_posts_url( $post->post_author )."' class='hidden-xs pull-right'>".str_replace("avatar ","avatar img-circle ",get_avatar($post->post_author,50))."</a>"; ?>
             
             <h4><?php echo $post->post_title; ?></h4>
             
               <div class="article<?php echo $post->ID; ?>"><?php echo $post->post_content; ?></div>
            
            <?php if(strlen($post->post_content) > 100){  ?>     
            <script>
            jQuery(document).ready(function(){
                jQuery('.article<?php echo $post->ID; ?>').shorten({
                    moreText: '<?php echo $CORE->_e(array('feedback','3')); ?>',
                    lessText: '<?php echo $CORE->_e(array('feedback','4')); ?>',
                    showChars: '280',
                });
            });
            </script>
            <?php } ?>
                             
      </div>
                        
      </div> 
       
      </li>
       
      
    <?php wp_reset_postdata(); } wp_reset_query(); ?>
    
    </ul>

<?php }else{ ?>

<h4 class="text-center"><?php echo $CORE->_e(array('feedback','21')); ?></h4>

<?php } ?>

</div>

<?php $i++; } ?>

</div>


<?php } // end feedback system 

}










if(!function_exists('_user_trustbar')){
function _user_trustbar($user_id, $size = "big"){ global $wpdb, $CORE;

// MAKE SURE ITS ENABLED
if(isset($GLOBALS['CORE_THEME']['feedback_trustbar']) && $GLOBALS['CORE_THEME']['feedback_trustbar'] == '1'){ }else{ return; }


// COUNT RATING FROM ALL LISTINGS
$SQL = "SELECT count(*) as total, sum(mt2.meta_value) AS total_score FROM ".$wpdb->prefix."posts 
	INNER JOIN ".$wpdb->prefix."postmeta AS mt1 ON (".$wpdb->prefix."posts.ID = mt1.post_id ) 
	INNER JOIN ".$wpdb->prefix."postmeta AS mt2 ON (".$wpdb->prefix."posts.ID = mt2.post_id ) 
	WHERE 1=1 	
	AND ".$wpdb->prefix."posts.post_status = 'publish'	
	AND mt1.meta_key = 'uid' AND mt1.meta_value = '".$user_id."'
	AND mt2.meta_key = 'score'";
 
$result = $wpdb->get_results($SQL);
 
// working out
$T_R = $result[0]->total;
$T_S = $result[0]->total_score;
if($T_S  == ""){ $T_S  = 0; }

if($T_R > 0){
	$barWidth = ( $T_S / ($T_R * 5 ) ) * 100;
}else{
	$barWidth = 100;
}
 
// BAR COLOR
if($barWidth > 0 && $barWidth < 50){ $barcolor = "info"; } 
if($barWidth > 49 && $barWidth < 80){ $barcolor = "warning"; } 
if($barWidth > 79){ $barcolor = "success"; } 


if($size == "big"){
?>

<div class="feedback_big"> 
  
<small><?php echo $CORE->_e(array('feedback','5')); ?></small>

<p> <?php echo $barWidth; ?>% <span class="pull-right"><?php echo $T_R; ?> <?php echo $CORE->_e(array('feedback','2')); ?></span>  </p>

<div class="progress" style="margin:0px;">
  <div class="progress-bar progress-bar-<?php echo $barcolor; ?> progress-bar-striped" role="progressbar" aria-valuenow="40" aria-valuemin="0" aria-valuemax="100" style="width: <?php echo $barWidth; ?>%">
    <span class="sr-only"><?php echo $barWidth; ?>%</span>
  </div>
</div> 
 
  
</div>

<?php }elseif($size == "inone"){ ?>

 
<div class="progress" style="margin:0px;">
  <div class="progress-bar progress-bar-<?php echo $barcolor; ?> progress-bar-striped" role="progressbar" aria-valuenow="40" aria-valuemin="0" aria-valuemax="100" style="width: <?php echo $barWidth; ?>%">
  
  <span><?php echo $T_R; ?> <?php echo $CORE->_e(array('feedback','2')); ?>  <strong><?php echo $barWidth; ?>%</strong> </span>
    
  </div>
</div> 
 
 

<?php }else{ ?>

<div class="feedback_small">

<div class="clearfix"></div>
<div class="progress" style="height:8px; margin:0px; border-radius:0px;">
  <div class="progress-bar progress-bar-<?php echo $barcolor; ?> progress-bar-striped" role="progressbar" aria-valuenow="40" aria-valuemin="0" aria-valuemax="100" style="width: <?php echo $barWidth; ?>%">
    <span class="sr-only"><?php echo $barWidth; ?>%</span>
  </div>
</div>
</div>

<?php } ?>


<?php

}
}
  

function _accout_links($b_f ='<li class="hidden-sm hidden-xs">', $b_a = '</li>'){ global $userdata, $CORE;

$STRING = ""; $linkclass = "";

			if(isset($userdata) && $userdata->ID){
			 
				if(isset($GLOBALS['CORE_THEME']['links'])){				
				 
				// my account
				$STRING .= str_replace("hidden-sm hidden-xs","",$b_f).'<a href="'.$GLOBALS['CORE_THEME']['links']['myaccount'].'" class="ua1 '.$linkclass.'">'.$CORE->_e(array('head','4')).'</a>'.$b_a;
				 		 	
				// notifications
				$NOTIFICATION_COUNT = $CORE->MESSAGECOUNT($userdata->user_login);
				if($NOTIFICATION_COUNT > 0){							
				$STRING .= $b_f.'<a href="'.$GLOBALS['CORE_THEME']['links']['myaccount'].'?notify=1" class="ua2 '.$linkclass.'">'.$CORE->_e(array('head','8')).' ('.$NOTIFICATION_COUNT.')</span></a>'.$b_a;
				}
				
				// favorites
				if($GLOBALS['CORE_THEME']['show_account_favs'] == '1'){
			 
						 
				$STRING .= $b_f.'<a href="'.home_url().'/?s=&amp;favs=1" class="ua3 '.$linkclass.'">'.$CORE->_e(array('account','46')).' ('.$CORE->FAVSCOUNT().')</a>'.$b_a;
				}
				
				// logout
				$STRING .= $b_f.'<a href="'.wp_logout_url().'" class="ua4 '.$linkclass.'">'.$CORE->_e(array('account','8')).'</a>'.$b_a;
							
				
				}
			}else{
				
				//login
				$STRING .= $b_f.'<a href="'.site_url('wp-login.php?action=login', 'login_post').'" class="ua5 '.$linkclass.'">'.$CORE->_e(array('head','5','flag_link')).'</a>'.$b_a;
				
				// register
				$STRING .= $b_f.'<a href="'.site_url('wp-login.php?action=register', 'login_post').'" class="ua6 '.$linkclass.'">'.$CORE->_e(array('head','6','flag_link')).'</a>'.$b_a; 
				       
			}// end if
return $STRING;

}

 
 


if(!function_exists('DEFAULTLISTINGPAGE1')){
function DEFAULTLISTINGPAGE1(){ global $post, $CORE; $STRING = "";

// CAN WE DISPLAY THE GOOGLE MAP BOX ?
if( get_post_meta($post->ID,'showgooglemap',true) == "yes"){
	$my_long  			= get_post_meta($post->ID,'map-log',true);
	$my_lat  			= get_post_meta($post->ID,'map-lat',true);
	$GOOGLEMAPADDRESS 	= 'https://www.google.com/maps/dir/'.str_replace(",","",str_replace(" ","+",get_post_meta($post->ID,'map_location',true)))."/".$my_lat.",".trim($my_long);
}

$STRING .= '<div class="panel panel-default" id="DEFAULTLISTINGPAGE1">
<div class="panel-body">
 
<h1>[TITLE]</h1>

<ol class="breadcrumb">
  <li>[FAVS]</li>
  
  <li  class="pull-right">[RATING results=1]</li>
 
  <li class="pull-right hidden-xs"><i class="fa fa-area-chart"></i> [hits] views</li>
  <li class="pull-right hidden-xs">#[ID]</li>
  
</ol>

<small>[DATE]</small>

<div  class="pull-right">[SOCIAL]</div>

</div>  

 
<div class="col-md-6">
	[IMAGES]
</div>
<div class="col-md-6"> 
	[EXCERPT] 
	
	[FIELDS smalllist=1]
	
	[THEMEEXTRA]
 	 
	<div class="clearfix"></div>	
</div>

<div class="clearfix"></div> 



<div class="board">
	<div class="board-inner">
    
	<ul class="nav nav-tabs" id="Tabs">
    
	<div class="liner"></div>
					
    <li class="active"><a href="#home" data-toggle="tab" title="'.$CORE->_e(array('single','34')).'"><span class="round-tabs one"><i class="fa fa-file-text-o"></i></span></a></li>

    <li><a href="#t4" data-toggle="tab" title="'.$CORE->_e(array('single','37')).'"> <span class="round-tabs two"><i class="fa fa-comments-o"></i></span> </a></li>
				  
    <li><a href="#messages" data-toggle="tab" title="'.$CORE->_e(array('single','16')).'"><span class="round-tabs three"><i class="fa fa-bars"></i></span> </a></li>

    <li><a href="#settings" data-toggle="tab" title="'.$CORE->_e(array('single','36')).'"><span class="round-tabs four"><i class="glyphicon glyphicon-comment"></i></span></a></li>';
	
	if(isset($GOOGLEMAPADDRESS)){
	$STRING .='<li><a href="#doner" data-toggle="tab" title="'.$CORE->_e(array('button','52')).'" id="GoogleMapTab"><span class="round-tabs five"><i class="fa fa-map-marker"></i></span></a></li>';
   }
   
    $STRING .= '</ul></div>

	<div class="tab-content">
    
	<div class="tab-pane fade in active" id="home"> [THEMEEXTRA1] [CONTENT]</div>
    
	<div class="tab-pane fade" id="t4">[COMMENTS tab=0]</div>
    
	<div class="tab-pane fade" id="messages"><div class="well"><h3>'.$CORE->_e(array('single','16')).'</h3> <hr /> [FIELDS] </div> </div>
    
	<div class="tab-pane fade" id="settings">[CONTACT style="2"]</div>';
    
	if(isset($GOOGLEMAPADDRESS)){
	$STRING .= '<div class="tab-pane fade" id="doner">
	
		<div class="well">
		<a href="'.$GOOGLEMAPADDRESS.'" target="_blank" class="btn btn-default pull-right">
		'.$CORE->_e(array('button','56')).'</a>
		<h3>'.$CORE->_e(array('add','67')).'</h3>
		<hr />
		[GOOGLEMAP]	
		</div>
		<script>		
		jQuery( "#GoogleMapTab" ).click(function() {
		setTimeout(function () {google.maps.event.trigger(map, "resize"); }, 200);
		});
		</script>
	</div>';
	}else{
	$STRING .= '<style>.board .nav-tabs > li {width: 25%;}</style>';
	}
	
	$STRING .='<div class="clearfix"></div>
	
	</div>
</div></div>

<script>
jQuery(function(){jQuery(\'a[title]\').tooltip();});
</script>'; 

return $STRING;
}
}

if(!function_exists('DEFAULTLISTINGPAGE2')){
function DEFAULTLISTINGPAGE2(){ global $post, $CORE; $STRING = "";

// CAN WE DISPLAY THE GOOGLE MAP BOX ?
if( get_post_meta($post->ID,'showgooglemap',true) == "yes"){
	$my_long  			= get_post_meta($post->ID,'map-log',true);
	$my_lat  			= get_post_meta($post->ID,'map-lat',true);
	$GOOGLEMAPADDRESS 	= 'https://www.google.com/maps/dir/'.str_replace(",","",str_replace(" ","+",get_post_meta($post->ID,'map_location',true)))."/".$my_lat.",".trim($my_long);
}

$STRING .= '<div class="panel panel-default" id="DEFAULTLISTINGPAGE2">
<div class="panel-body">
 
<h1>[TITLE]</h1>

<ol class="breadcrumb">
  <li>[FAVS]</li>
  
  <li  class="pull-right">[RATING results=1]</li>
 
  <li class="pull-right hidden-xs"><i class="fa fa-area-chart"></i> [hits] views</li>
  <li class="pull-right hidden-xs">#[ID]</li>
  
</ol>

<small>[DATE]</small>

<div  class="pull-right">[SOCIAL]</div>

[IMAGES]

</div> 
 
[THEMEEXTRA]

<div class="clearfix"></div> 

<div class="board">
	<div class="board-inner">
    
	<ul class="nav nav-tabs" id="Tabs">
    
	<div class="liner"></div>
					
    <li class="active"><a href="#home" data-toggle="tab" title="'.$CORE->_e(array('single','34')).'"><span class="round-tabs one"><i class="fa fa-file-text-o"></i></span></a></li>

    <li><a href="#t4" data-toggle="tab" title="'.$CORE->_e(array('single','37')).'"> <span class="round-tabs two"><i class="fa fa-comments-o"></i></span> </a></li>
				  
    <li><a href="#messages" data-toggle="tab" title="'.$CORE->_e(array('single','16')).'"><span class="round-tabs three"><i class="fa fa-bars"></i></span> </a></li>

    <li><a href="#settings" data-toggle="tab" title="'.$CORE->_e(array('single','36')).'"><span class="round-tabs four"><i class="glyphicon glyphicon-comment"></i></span></a></li>';
	
	if(isset($GOOGLEMAPADDRESS)){
	$STRING .='<li><a href="#doner" data-toggle="tab" title="'.$CORE->_e(array('button','52')).'" id="GoogleMapTab"><span class="round-tabs five"><i class="fa fa-map-marker"></i></span></a></li>';
   }
   
    $STRING .= '</ul></div>

	<div class="tab-content">
    
	<div class="tab-pane fade in active" id="home">[THEMEEXTRA1] [CONTENT]</div>
    
	<div class="tab-pane fade" id="t4">[COMMENTS tab=0]</div>
    
	<div class="tab-pane fade" id="messages"><div class="well"><h3>'.$CORE->_e(array('single','16')).'</h3> <hr /> [FIELDS] </div> </div>
    
	<div class="tab-pane fade" id="settings">[CONTACT style="2"]</div>';
    
	if(isset($GOOGLEMAPADDRESS)){
	$STRING .= '<div class="tab-pane fade" id="doner">
	
		<div class="well">
		<a href="'.$GOOGLEMAPADDRESS.'" target="_blank" class="btn btn-default pull-right">
		'.$CORE->_e(array('button','56')).'</a>
		<h3>'.$CORE->_e(array('add','67')).'</h3>
		<hr />
		[GOOGLEMAP]	
		</div>
		<script>		
		jQuery( "#GoogleMapTab" ).click(function() {
		setTimeout(function () {google.maps.event.trigger(map, "resize"); }, 200);
		});
		</script>
	</div>';
	}else{
	$STRING .= '<style>.board .nav-tabs > li {width: 25%;}</style>';
	}
	
	$STRING .='<div class="clearfix"></div>
	
	</div>
</div></div>

<script>
jQuery(function(){jQuery(\'a[title]\').tooltip();});
</script>'; 

return $STRING;
}
}