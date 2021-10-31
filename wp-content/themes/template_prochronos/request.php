<?php include '../../../wp-load.php';
global $wpdb, $table_prefix;
$action = $_REQUEST['action'];
	if($action =='requestSearch'){
		$brand = $_POST['brand'];
		$year = $_POST['year'];
		$ref_no = $_POST['ref_no'];
		$category = $_POST['category'];
		$model = $_POST['model'];
		$meta_query = array();
		$tax_query = array();
		if($year != ''){
			$meta_query[] = array(
					'key' => 'yearofwatch',
					'value' => $year,
					'compare'=> '=',
					);
		}
		if($ref_no != ''){
			$meta_query[] = array(
					'key' => 'referencenumber',
					'value' => $ref_no,
					'compare'=> '=',
					);
		}
		if($model != ''){
			$meta_query[] = array(
					'key' => 'modelofwatch',
					'value' => $model,
					'compare'=> '=',
					);
		}
		if($category != ''){
			//echo $category;
			$CatInfo = get_term_by('id', $category, 'listing');
			if(!empty($CatInfo)){
				//echo $CatInfo->name;
				$meta_query[] = array(
					'key' => 'typeofwatch',
					'value' => trim($CatInfo->name),
					'compare'=> 'LIKE',
				);
			}
		}
		if($brand != ''){
			$brandInfo = get_term_by('id', $brand, 'brands');
			if(!empty($brandInfo)){
				$meta_query[] = array(
					'key' => 'brand',
					'value' => $brandInfo->name,
					'compare'=> '=',
				);
			}
		}
		$args = array(
			'post_type' => 'listing_type',
			'post_per_page' => -1,
			'meta_key' => 'listing_expiry_date_timestamp',
			'orderby' => 'meta_value_num',
			'order' => 'ASC',
			//'tax_query' => $tax_query,
		 );
		 
		 $meta_query[] = array(
			'key' => 'listing_expiry_date_timestamp',
			'value' => strtotime(date('Y-m-d H:i:s')),
			'compare' => '>='
		);
		if(!empty($meta_query)){
			$args['meta_query'] = $meta_query;
		}
		///echo "<pre>"; print_r($args); echo "</pre>"; 
		$postslist = get_posts( $args );
		//echo $wpdb->last_query;
		//echo "<pre>"; print_r($postslist); echo "</pre>"; 
		if(!empty($postslist)){
			foreach($postslist as $list){ ?>
				<div class="itemdata icons itemid427 col-md-4 col-sm-6 col-xs-12 item-<?php echo $list->ID;?> col-xs-12">
					<div class="thumbnail clearfix" style="height: 328px;">
						<div class="galleryframe frame">
							<div class="overlay-gallery">
								<div class="lbox">
									<a href="<?php  echo $featured_img_url = get_the_post_thumbnail_url($list->ID,'full'); ?>" data-gal="prettyPhoto[ppt_gal_<?php echo $list->ID?>]"><span class="fa fa-camera"></span></a><a href="<?php echo get_permalink($list->ID);?>"><span class="fa fa-search"></span></a>
								</div>
							</div> 
							<img src="<?php echo $featured_img_url;?>">
						</div>
						<a href="<?php echo $featured_img_url; ?>" class="prettyPhoto" data-gal="prettyPhoto[ppt_gal_<?php echo $list->ID; ?>]" ></a> 
						<div class="content">  
							<h3>
								<a href="<?php echo get_permalink($list->ID);?>"><span><?php echo  $list->post_title;?></span></a> <span id="wlt_star_665059840983427" class="wlt_starrating pull-right" style="cursor: pointer;"><span class="fa fa-star-o size16 readonlyfalse" data-score="1" title="bad"></span><span class="fa fa-star-o size16 readonlyfalse" data-score="2" title="poor"></span><span class="fa fa-star-o size16 readonlyfalse" data-score="3" title="regular"></span><span class="fa fa-star-o size16 readonlyfalse" data-score="4" title="good"></span><span class="fa fa-star-o size16 readonlyfalse" data-score="5" title="very good"></span><input name="score" type="hidden"></span>
								
								<script type="text/javascript">jQuery(document).ready(function(){ 
									jQuery('#wlt_star_665059840983427').raty({
									path: 'http://223.196.72.250/prochronos/wp-content/themes/studioluc/framework/img/rating/',
									score: 0,size: 16, click: function(score, evt) {			 
										WLTSaveRating('223.196.72.250/prochronos', '<?php echo $list->ID?>', score, 'wlt_star_665059840983427');
									}}); }); 
								</script>
							</h3>
							<div class="row">
								<div class="col-md-6 col-sm-6 col-xs-6"> 
									<b><?php echo get_post_meta($list->ID,'price_current',true);?>€</b>  
								</div>
								<div class="col-md-6 col-sm-6 col-xs-6 text-right"> 
									<span class="wlt_shortcode_category"><a href="http://223.196.72.250/prochronos/listing-category/automatic-watches/" rel="tag"><?php $term = get_term_by('id', $category, 'listing'); ?></a></span> <span class="bids">0 bids</span>    
								</div>
							</div>
							<div class="line1"></div> 

							<span class="wlt_shortcode_excerpt"><?php echo $list->content;?></span>
							<?php $expire = get_post_meta($list->ID,'listing_expiry_date', true);?>
							<script>
								jQuery(document).ready(function() {		
									var dateStr ='<?php echo $expire;?>';
									var a=dateStr.split(' ');
									var d=a[0].split('-');
									var t=a[1].split(':');
									var date1 = new Date(d[0],(d[1]-1),d[2],t[0],t[1],t[2]);
									console.log(date1);		
									//alert(date1);	 
										
									jQuery('#timecounter<?php echo $list->ID;?>').countdown({timezone: 1, until: date1, onExpiry: WLTvalidateexpiry<?php echo $list->ID;?> });
								});
								
								function WLTvalidateexpiry<?php echo  $list->ID;?>(){  setTimeout(function(){ CoreDo('<?php echo site_url();?>/?core_aj=1&amp;action=validateexpiry&amp;pid=<?php echo $list->ID; ?>', 'timeleft_4271511499638608658'); jQuery('#timeleft_4271511499638608658_wrap').html('&lt;div class=ea_finished&gt;&lt;span class=aetxt&gt;Auction Finished&lt;/span&gt;&lt;/div&gt;'); }, 1000);  };
							</script>
								
							<span class="timecounter" id="timecounter<?php echo $list->ID;?>"></span>
						</div>
					</div> 
				</div>
			<?php }
		} else {
			echo "0";
		}
	}
	if($action =='delReqList'){
		// Default usage.
		$delQuery = $wpdb->delete( $table_prefix.'request_management', array( 'id' => $_POST['req_id'] ) );
		if($delQuery){
			$get_requests = $wpdb->get_results("SELECT * FROM `".$wpdb->prefix."request_management` ORDER BY `request_created` DESC"); 
			//echo "<pre>"; print_r($get_requests); echo "</pre>"; 
			$requestList = '';
			foreach($get_requests as $request){
				$d = $request->request_existance;
				$requestEnds = strtotime(date('d-m-Y', strtotime($request->request_created. ' + '.$d.' days')));
				$currentDate = strtotime(date('d-m-Y'));
				if($currentDate <= $requestEnds){
					
					$requestList .= '<li class="list-group-item"><div>';
					if(is_user_logged_in() && $request->requester_id == get_current_user_id()){
						$requestList .= '<span onclick="deleteListRequest('.$request->id.');"><i class="fa fa-trash"></i></span>';
					}
					
					if($request->brand != ''){
						$brand = get_term_by('id', $request->brand, 'brands');
						$requestList .= '<b>Brand:</b> '.$brand->name.'<br>';
					}
					if($request->model != ''){
						$requestList .= '<b>Model:</b> '.$request->model.'<br>';
					}
					if($request->type_of_watch != ''){
						$type_of_watch = get_term_by('id', $request->type_of_watch, 'listing');
						$requestList .= '<b>Type of Watch:</b> '.$type_of_watch->name.'<br>';
					}
					if($request->ref_no != ''){
						$requestList .= '<b>Reference Number:</b> '.$request->ref_no.'<br>';
					}
					if($request->year != ''){
						$requestList .= '<b>Year:</b> '.$request->year.'<br>';
					}
					if($request->gender != ''){
						$requestList .= '<b>Gender:</b> '.$request->gender.'<br>';
					}
					if($request->request_condition != ''){
						$requestList .= '<b>Request Condition:</b> '.$request->request_condition.'<br>';
					}
					if($request->watch_condition != ''){
						if($request->watch_condition == '1'){ $condition = 'New'; } else { $condition = 'Used'; }
						$requestList .= '<b>New or Used:</b> '.$condition.'<br>';
					}
					if($request->request_created != ''){
						$requestList .= '<b>Request Created:</b> '.date('d-m-Y', strtotime($request->request_created)).'<br>';
						
						if($request->request_existance != ''){
							$d = $request->request_existance;
							$requestList .= '<b>Request Ends:</b> '.date('d-m-Y', strtotime($request->request_created. ' + '.$d.' days')).'<br>';
						}
					}
					
					
					$requestList .= '<br><b>Requester Info:</b><br>';
					//$displayName = get_the_author_meta( 'display_name', $request->requester_id);
					$companyName = get_user_meta($request->requester_id,'company_name',true);
					$userUrl = get_author_posts_url( $request->requester_id );
					//$requestList .= '<i class="fa fa-user"></i> <a style="text-decoration:underline;" href="'.$userUrl.'">'.$displayName.'</a><br>';
					$requestList .= '<i class="fa fa-user"></i> <a style="text-decoration:underline;" href="'.$userUrl.'">'.$companyName.'</a><br>';
					
					if($companyName != '' && $companyName !== NULL){
						//$requestList .= '<b>Company Name:</b> '.$companyName.'<br>';
					}
					$address = '';
					if(get_user_meta($request->requester_id,'house_no',true) !=''){
						$address .= get_user_meta($request->requester_id,'house_no',true).',';
					}
					if(get_user_meta($request->requester_id,'street_name',true) !=''){
						$address .= get_user_meta($request->requester_id,'street_name',true).',';
					}
					if(get_user_meta($request->requester_id,'company_city',true) !=''){
						$address .= get_user_meta($request->requester_id,'company_city',true).',<br>';
					} 
					
					if(get_user_meta($request->requester_id,'company_country',true) !=''){
						$address .= get_user_meta($request->requester_id,'company_country',true).',';
					} 
					if(get_user_meta($request->requester_id,'postcode',true) !=''){
						$address .= get_user_meta($request->requester_id,'postcode',true).',';
					}
					if($address != ''){
						$requestList .= '<b>Address:</b> '.$address.'<br>';
					}
					$dealersImage = get_user_meta($request->requester_id,'userphoto',true); 
					if($dealersImage != '' && $dealersImage !== NULL){ 
						$requestList .= '<img src="'.$dealersImage['img'].'" width="150" height="60"/>';
					}
					$requestList .= '<br></div></li>';
				} else {
					$wpdb->update($wpdb->prefix."request_management", array('req_status'=>0), array('id'=>$request->id));
				}
			}
			echo $requestList;
		} else {
			echo "0"; 
		}
	}
	?>
