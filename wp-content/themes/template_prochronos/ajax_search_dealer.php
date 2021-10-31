<?php include '../../../wp-load.php'; ?>
<?php
	$search = $_POST['searchtext'];
	$country = $_POST['country'];
	//print_r($country);
	if($country == 'All countries'){
		$country = '';
	}
	$args =array(
				'meta_query' => array(
					'relation' => 'AND',
							array(
								'key'     => 'company_country',
								'value'   => $country,
								//'value'   => $country,
								'compare' => 'LIKE',
							),
							array(
									'relation' => 'OR',
									array(
											'key' => 'company_city',
											'value' => $search,
											'compare' => 'LIKE',
									),
									array(
											'key' => 'company_country',
											'value' => $search,
											'compare' => 'LIKE',
									),
									array(
											'key' => 'postcode',
											'value' => $search,
											'compare' => '=',
									),
									array(
											'key' => 'company_name',
											'value' => $search,
											'compare' => 'LIKE',
									),
					),
				),
			);
	$blogusers = get_users($args);
	//echo $search;
	//echo $wpdb->last_query;
	//print_r($blogusers);
if(!empty($blogusers)){
	foreach($blogusers as $users){
	$user = get_user_by('id', $users->ID);
  ?>
	<div class="paginContent">
		<div class="country_info">
			<div class="col-md-12">
				<div class='col-md-4'>
					<a href='<?php echo get_author_posts_url( $users->ID ); ?>'> 
						<?php $dealersImage = get_user_meta($users->ID,'userphoto',true);  if($dealersImage != '' && $dealersImage !== NULL){ ?>
							<img src="<?php echo $dealersImage['img']; ?>" class="avatar img-responsive img-responsive"/>
						<?php } else { ?>
							<img src="<?php echo get_stylesheet_directory_uri(); ?>/images/cmpny_logo.png" class="avatar img-responsive img-responsive"/>
						<?php } ?>
					</a>
				</div>
				
				<div class='col-md-8'>
					<?php $companyName = get_user_meta( $users->ID, 'company_name', true ); ?>
					<a href='<?php echo get_author_posts_url( $users->ID ); ?>'><h2><?php echo $companyName; ?> </h2></a>
					<!--<a href='<?php echo site_url().'/single-dealer?dealer_id='.$users->ID;?>'><h2><?php echo $companyName; ?> </h2></a> -->
					<div class='linkbar linkbarSocial'>
						<?php if(get_user_meta($users->ID,'street_name',true) !=''){
							 echo get_user_meta($users->ID,'street_name',true).',';
						}
						if(get_user_meta($users->ID,'house_no',true) !=''){
							echo get_user_meta($users->ID,'house_no',true).'<br>';
						}
						
						if(get_user_meta($users->ID,'postcode',true) !=''){
							echo get_user_meta($users->ID,'postcode',true).'<br>';
						}
						if(get_user_meta($users->ID,'company_city',true) !=''){
							echo get_user_meta($users->ID,'company_city',true).'<br>';
						}
						if(get_user_meta($users->ID,'company_country',true) !=''){
							echo get_user_meta($users->ID,'company_country',true);
						} ?>
					</div>
					<?php $data = get_user_meta( $users->ID, 'company_link', true);
					if(strlen($data) > 0){ 
						echo "<div class='linkbar bottom'><span><i class='fa fa-globe'></i> <a href='".$data."' rel='nofollow' target='_blank'>".$CORE->_e(array('button','12'))."</a></span></div>"; 
					}  ?>
				</div>
				<!-- <div col-md-12><a href="#"><i class="fa fa-angle-right" aria-hidden="true"></i> Our Supply of Wacthes</a></div>-->
			</div>
		</div>
	</div>
 <?php } 
}
else{
	echo "No dealer found. Please try with some other filters";
	
	}

