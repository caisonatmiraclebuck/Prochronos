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

$user_info = get_userdata($authorID); 


// TURN ON/OFF DISPLAY
if(isset($GLOBALS['CORE_THEME']['allow_profile']) && $GLOBALS['CORE_THEME']['allow_profile'] != 1){ 
	header("location: ".home_url());
	exit();
}

// REGISTERED
$date = $CORE->TimeDiff($user_info->user_registered,'','',false, array('years','months','days','hours','seconds') );

// GET LAST LOGIN DATE
$lastlogin = get_user_meta($authorID, 'login_lastdate', true);
if($lastlogin == ""){ $lastlogin = $user_info->user_registered; };
		
// USER COUNTRY
$selected_country = get_user_meta($authorID,'country',true);
		  
// GET LISTING COUNT
$listings = $CORE->count_user_posts_by_type( $authorID, THEME_TAXONOMY."_type","", false  );
		
// SHOW PHONE NUMBER
$phone = get_user_meta( $authorID, 'phone', true);
		
// GET PROFILE BG STYLE
$pbg = get_user_meta($authorID,'pbg',true);
if($pbg == ""){ $pbg = 1; }

?>

<?php get_header($CORE->pageswitch()); ?>

<?php hook_author_before(); ?>
 

<div id="AuthorSingle">

<?php if($userdata->ID == $authorID && $GLOBALS['CORE_THEME']['links']['myaccount'] != ""){ ?><a href="<?php echo $GLOBALS['CORE_THEME']['links']['myaccount']; ?>" class="pull-right badge badge-success"><?php echo $CORE->_e(array('button','2')); ?></a><?php } ?> 

<div class="head" style="background:url('<?php echo FRAMREWORK_URI; ?>/img/profile/<?php echo $pbg; ?>.jpg'); background-size: 100% auto;"></div>

<div class="well profile">
 
    <div class="mbox" style="margin-top:-120px;">
    
        <div class="col-xs-12 col-sm-8">
    
            <!--<h1><?php echo get_the_author_meta( 'display_name', $authorID); ?></h1>-->
            <h1><?php echo get_user_meta( $authorID, 'company_name', true ); ?></h1>
            
            <?php if(strlen($selected_country) > 0){ ?>
            
            <div class="desc"><div class="flag flag-<?php echo strtolower($selected_country); ?> wlt_locationflag"></div><?php echo $GLOBALS['core_country_list'][$selected_country]; ?> </div>
            
            <?php } ?> 
            
            <?php if(isset($GLOBALS['CORE_THEME']['feedback_trustbar']) && $GLOBALS['CORE_THEME']['feedback_trustbar'] == '1' && !defined('WLT_CART')){ ?>
            
            <hr />
            
				<?php echo _user_trustbar($authorID, 'inone'); ?>
            
            <?php } ?>
             
            <!--<p><strong><?php echo $CORE->_e(array('auction','61')); ?></strong> <?php echo hook_date($user_info->user_registered); ?></p>
        
        	<p><strong><?php echo $CORE->_e(array('widgets','26')); ?></strong> <?php echo hook_date($lastlogin); ?></p>-->
        	<?php $companyName = get_user_meta($authorID,'company_name',true); 
        	/*if($companyName != '' && $companyName !== NULL){ ?>
				<p><strong>Company Name:</strong> <?php echo $companyName; ?></p>
			<?php } */

			$address = ''; 
			$street_name = get_user_meta($authorID,'street_name',true);
			if($street_name !='' && $street_name !== NULL){
				$address .= $street_name.',';
			}
			$house_no = get_user_meta($authorID,'house_no',true);
			if($house_no !='' && $house_no !== NULL){
				$address .= $house_no;
			}
			
			$postcode = get_user_meta($authorID,'postcode',true);
			if($postcode !='' && $postcode !== NULL){
				$address .= '<br>'.$postcode;
			}
			$company_city = get_user_meta($authorID,'company_city',true);
			if($company_city !='' && $company_city !== NULL){
				$address .= '<br>'.$company_city;
			}
			$company_country = get_user_meta($authorID,'company_country',true);
			if($company_country !='' && $company_country !== NULL){
				$address .= '<br>'.$company_country;
			}
			
			if($address != ''){ ?>
				<p><strong>Company Address:</strong><br><?php echo $address; ?></p>
			<?php }

			$company_mail = get_user_meta($authorID,'company_mail',true); 
			if($company_mail != '' && $company_mail !== NULL){ ?>
				<p><i class="fa fa-envelope"></i><?php echo $company_mail; ?></p>
			<?php }

			$company_phone = get_user_meta($authorID,'company_phone',true); 
			if($company_phone != '' && $company_phone !== NULL){ ?>
				<p><i class="fa fa-phone"></i><?php echo $company_phone; ?></p>
			<?php } 

			/*$company_link = get_user_meta($authorID,'company_link',true); 
			if($company_link != '' && $company_link !== NULL){ ?>
				<p><i class="fa fa-globe"></i><a href="<?php echo $company_link; ?>/" rel="nofollow" target="_blank">Visit Website</a></p>
			<?php }*/ ?>
			
			<!--<p><i class="fa fa-user"></i> <strong><a style="text-decoration:underline;" href="<?php echo get_author_posts_url( $authorID ); ?>"><?php echo get_the_author_meta( 'display_name', $authorID); ?></a> </strong></p>-->
			
			<?php $firstName = get_user_meta($authorID,'first_name',true); 
        	$lastName = get_user_meta($authorID,'last_name',true); 
        	if($firstName != '' && $firstName !== NULL){ ?>
				<p><strong>Contact person: </strong><?php echo $firstName.' '.$lastName; ?></p>
			<?php } ?>
			
			<p><strong><?php echo $CORE->_e(array('auction','61')); ?></strong> <?php echo hook_date($user_info->user_registered); ?></p>
        
        	<p><strong><?php echo $CORE->_e(array('widgets','26')); ?></strong> <?php echo hook_date($lastlogin); ?></p>
        </div>    
                             
		<div class="col-xs-12 col-sm-4 text-center">
			<div class="text-center">
				<?php echo str_replace("img-responsive","img-responsive img-circle", get_avatar( $authorID, 200 ) ); ?>
			</div>
		</div>

        <div class="clearfix"></div>
        
        <hr />
       
        <div class="linkbar">
        
        <ul class="list-inline">
            <?php 
			
			// MSG USER
			 echo "<li class='ee'><i class='fa fa-envelope'></i> <a href='".$GLOBALS['CORE_THEME']['links']['myaccount']."/?u=".$authorID."&tab=msg&show=1' rel='nofollow' target='_blank'>".$CORE->_e(array('single','7'))."</a></li> ";			
            
            // URL
           // $data = get_user_meta( $authorID, 'url', true);
            $data = get_user_meta($authorID,'company_link',true);
            
         
            if(strlen($data) > 0){ 
				echo "<li><i class='fa fa-globe'></i> <a href='".$data."' rel='nofollow' target='_blank'>".$CORE->_e(array('button','12'))."</a></li> "; 
            }
                
            // FACEBOOK
            $data = get_user_meta( $authorID, 'facebook', true);
            if(strlen($data) > 0){ 
				echo "<li class='fb'><i class='fa fa-facebook-square'></i> <a href='".$data."' rel='nofollow' target='_blank'>Facebook</a></li>"; 
            }  	
            
            // TWITTER
            $data = get_user_meta( $authorID, 'twitter', true);
            if(strlen($data) > 0){ 
				echo "<li class='tw'><i class='fa fa-twitter-square'></i> <a href='".$data."' rel='nofollow' target='_blank'>Twitter</a></li> "; 
            }  		
            
            // LINKEDIN
            $data = get_user_meta( $authorID, 'linkedin', true);
            if(strlen($data) > 0){ 
            echo "<li class='in'><i class='fa fa-linkedin-square'></i> <a href='".$data."' rel='nofollow' target='_blank'>Linkedin</a></li>"; 
            } 	
    
            // SKYPE
            $data = get_user_meta( $authorID, 'skype', true);
            if(strlen($data) > 0){ 
            echo "<li class='sk'><i class='fa fa-skype'></i> <a href='skype:".$data."' rel='nofollow' target='_blank'>Skype</a> </li>"; 
            }
            
            ?>
           </ul> 
         </div> 
          
    <div class="clearfix"></div>   
    
    
  <?php 
		
		// DISPLAY USER DESCRIPTION
		$dee = get_the_author_meta( 'description', $authorID); if(strlen($dee) > 1){ ?>
        
        <hr />
         
        <div class="userdescription"><?php echo wpautop($dee); ?></div>
    
        
        <script>
            jQuery(document).ready(function(){
                jQuery('.userdescription').shorten({
                    moreText: '<?php echo $CORE->_e(array('feedback','3')); ?>',
                    lessText: '<?php echo $CORE->_e(array('feedback','4')); ?>',
                    showChars: '500',
                });
            });
            </script>
 		 
        <?php } ?>  
          
</div>
   
   
   
  

 



<?php if(isset($GLOBALS['CORE_THEME']['feedback_enable']) && $GLOBALS['CORE_THEME']['feedback_enable'] == '1' && !defined('WLT_CART')){ ?>

<hr />
	 
<h4><?php echo $CORE->_e(array('feedback','0')); ?></h4>

<hr />

<div class="clearfix mbox"  id="AuthorSingleFeedback">
 
<?php WLT_FeedbackSystem($authorID); ?>
 
</div>

<?php } ?>

	<hr />
	<?php $args = array(
			'author'        =>  $authorID, // I could also use $user_ID, right?
			'post_type'        =>  'listing_type', 
			'post_status'      => 'publish',
			//'orderby'       =>  'post_date',
			//'order'         =>  'ASC',
			'posts_per_page' => '-1',
			'meta_key' => 'listing_expiry_date_timestamp',
			'orderby' => 'meta_value_num',
			'order' => 'ASC',
			'meta_query' => array(
					array(
						'key' => 'listing_expiry_date_timestamp',
						'value' => strtotime(date('Y-m-d H:i:s')),
						'compare' => '>='
					)
				)
			);

		$the_query = new WP_Query( $args ); ?>

	<h4><?php echo "Published Watches"; echo ' '.$the_query->found_posts.' items';?></h4>

	<hr /> 
	
	<div class="clearfix mbox"  id="AuthorSingleWatchlist">

		
	
		<div class="wlt_search_results grid_style">

			<?php hook_items_before(); ?>
	 
			<?php if ( $the_query->have_posts() ) : while ( $the_query->have_posts() ) : $the_query->the_post(); ?>	 

					<?php get_template_part( 'content', hook_content_templatename($post->post_type) ); ?> 
					
					<?php wp_reset_postdata(); ?>
		 
				<?php endwhile; ?>
			<?php else: ?>
				No Watches Published Yet
			<?php endif; ?>

			<?php hook_items_after(); ?>

			<div class="clearfix"></div>

		</div>

	</div>

</div>


<?php hook_author_after(); ?>
<script>
jQuery(document).ready(function(){
	jQuery('#AuthorSingleWatchlist .wlt_search_results div.itemdata').addClass('col-md-4');
});
</script> 	 
<?php get_footer($CORE->pageswitch()); ?>
