<?php
/*
Template Name: [Request Dealers]
*/
/* =============================================================================
   [PREMIUMPRESS FRAMEWORK] THIS FILE SHOULD NOT BE EDITED
   ========================================================================== */
if (!defined('THEME_VERSION')) {	header('HTTP/1.0 403 Forbidden'); exit; }
/* ========================================================================== */
global  $userdata, $CORE; get_currentuserinfo();  $GLOBALS['flag-members'] = 1; 
global $wpdb;
/* =============================================================================
   LOAD PAGE TEMPLATE
   ========================================================================== */
   
// RANDOM NUMBERS


/* =============================================================================
   PAGE ACTIONS // 
   ========================================================================== */

// no index for report page

// LOAD HEADER   

$page_body 		= get_post_meta($post->ID, 'body', true);
if($page_body == "remove"){
	$GLOBALS['wlt_remove_body'] = true;
} 

// MOBILE VIEW HOME PAGE
if(defined('IS_MOBILEVIEW')){ 
	include("home-mobile.php");
}else{	?>
<?php get_header($CORE->pageswitch()); ?>
<?php hook_page_before(); 
//$all_dealers = get_users();
//echo "<pre>"; print_r($emailArr);  echo "</pre>"; 
if (have_posts()) : while (have_posts()) : the_post(); 
$current_user = wp_get_current_user();
	if($_POST['submit']){
		//echo "<pre>"; print_r($_POST); echo "</pre>"; die();
		
		$brand = $_POST['brand'];
		$brand = get_term_by('id', $brand, 'brands');
		$brand_id = $brand->term_id; /* brand = (match with brand name)*/
		$model = $_POST['model']; /* modelofwatch = */
		$year = $_POST['cus_year']; /* yearofwatch */
		$type_of_watch = $_POST['type_of_watch']; 
		$type_of_watch = get_term_by('id', $type_of_watch, 'listing'); 
		$category = $type_of_watch->term_id; /* typeofwatch = (Match with type name)*/
		$ref_no = $_POST['ref_no']; /* referencenumber = */
		$gender = $_POST['gender']; /* genderofwatch LIKE*/
		$request_condition = $_POST['request_condition'];  /* conditionofwatch LIKE */ 
		$req_country = $_POST['req_country'];
		$request_date = $_POST['request_date'];
		$request_existance = $_POST['request_existance'];
		//$requester_email = 'nrawat@getyoursolutions.com';
		//$requester_email = $current_user->user_email;
		$requester_email = $_POST['requester_email'];
		$requesterId = $_POST['requester_id'];
		$condition = $_POST['condition']; /* condition = */
		//$date = "Mar 03, 2011";
		$date = strtotime($request_date);
		//$request_existance = strtotime("+$request_existance day", $date);
		//$request_existance = $request_existance." days";
		$request_existance = $request_existance;
		/*Code to check if request match with any listing [START] */
			$args = array(
				'post_type' => 'listing_type',
				'meta_query' => array(
					'relation' => 'AND',
					array(
						'key' => 'key1',
						'value' => 'value1',
						'compare' => '='
					),

					array(
						'key' => 'key1',
						'value' => 'value2',
						'compare' => '='
					)
				)
			);
		/*Code to check if request match with any listing [END] */
		$table_prefix = $wpdb->prefix;
		$insert = $wpdb->insert($table_prefix.'request_management', array(
			'brand' => $brand_id,
			'model' => $model,
			'year' => $year, 
			'type_of_watch' => $category, 
			'ref_no' => $ref_no, 
			'gender' => $gender, 
			'request_condition' => $request_condition, 
			//'request_date' => $request_date, 
			'request_existance' => $request_existance, 
			'requester_email' => $requester_email, 
			'req_status' => 1, 
			'request_created' => date('Y-m-d h:i:s'), 
			'requester_id' => $requesterId,
			'watch_condition' => $condition,
		));

		//$all_dealers = get_users('role=subscriber');
		$all_dealers = get_users();
		$emailArr = array();
		foreach($all_dealers as $dealer){
			$emailArr[] = $dealer->user_email;
		}
		$emailArr[] = get_option('admin_email');
		
		if(!in_array("info@prochronos.com", $emailArr))
		{
			$emailArr[] = "info@prochronos.com";
		}
		//echo "<pre>"; print_r($emailArr); echo "</pre>";  die();
		foreach($emailArr as $dealer){
			//echo $dealer->user_email."<br>"; 
			//$email = $dealer->user_email;
			$email = $dealer;
			//$email = 'kdogra@getyoursolutions.com';
			//  $to = $email;
			//$subject = "New Request Has been Created";
			$subject = "A new request for a watch";
			//$message = "<b>Dear Watch Dealer</b><br> ";
			$message = "<b>Dear user,</b><br> ";
			//$message .= "<b>New request has been created following are the details</b><br><br>";
			$message .= "<b>A new request has been made on our website. Please see the details below.</b><br><br>";
			if($brand != ''){
				$message .= 'Brand: '.$brand->name.'<br>';
			}
			if($model != ''){
				$message .= 'Model: '.$model.'<br>';
			}
			if($type_of_watch != ''){
				$message .= 'Type of Watch: '.$type_of_watch->name.'<br>';
			}
			if($brand != ''){
				$message .= 'Year: '.$year.'<br>';
			}
			if($condition == '1'){ $condition = 'New'; } else { $condition = 'Used'; }
				$message .= 'New or Used: '.$condition.'<br>';
			
			if($ref_no != ''){
				 $message .= 'Reference No: '.$ref_no.'<br>';
			 }
			 if($gender != ''){
				$message .= 'Gender: '.$gender.'<br>';
			}
			if($request_condition != ''){
				$message .= 'Condition of Watch: '.$request_condition.'<br>';
			}
			if($request_existance != ''){
				$message .= 'Length of the request: '.$request_existance.' Days<br>';
			}
			
			$message .= '</br></br><b>Requester Details</b>';
			
			$userData = get_userdata( $requesterId );
			//$message .= '<p>'.$userData->display_name.'</p>';
			
			if(get_user_meta($requesterId,'company_name',true) !=''){
				$message .= '<p><a href="'.get_author_posts_url( $requesterId ).'">'.get_user_meta($requesterId,'company_name',true).'</a></p>';
			}
			$address = ''; 
			
			if(get_user_meta($requesterId,'street_name',true) !=''){
				$address .= get_user_meta($requesterId,'street_name',true).',';
			}
			if(get_user_meta($requesterId,'house_no',true) !=''){
				$address .= get_user_meta($requesterId,'house_no',true).',<br>';
			}
			if(get_user_meta($requesterId,'postcode',true) !=''){
				$address .= get_user_meta($requesterId,'postcode',true).'<br>';
			}
			if(get_user_meta($requesterId,'company_city',true) !=''){
				$address .= get_user_meta($requesterId,'company_city',true).'<br>';
			}
			if(get_user_meta($requesterId,'company_country',true) !=''){
				$address .= get_user_meta($requesterId,'company_country',true);
			}
			
			
			$message .= '<p>'.$address.'</p>';
			$logo = get_user_meta($requesterId,'userphoto',true); 
			if($logo != '' && $logo != NULL){
				$img = $logo['img'];
				$message .= '<img src="'.$img.'" width="150" height="60">';
			}
			
			$message .='<br><a href="'.get_the_permalink().'" target="_blank">Click Here</a> to visit request page.'; 
			
			$message .='<br><br>Kind Regards,<br>Prochronos Management'; 
			
			$header = "From:".$requester_email."\r\n";
			// $header .= "Cc:afgh@somedomain.com \r\n";
			$header .= "MIME-Version: 1.0\r\n";
			$header .= "Content-type: text/html\r\n";
			
			$retval = wp_mail($email,$subject,$message,$header);
			// $retval = true;
			//echo $retval;
		}
		if( $retval == true ) {
			//echo "Request sent successfully...";
			echo "<div class='alert alert-warning'><p>Request sent successfully, you will receive an e-mail confirmation of the request.</p></div>";
		}else {
			echo "<div class='alert alert-warning'><p>Request could not be sent. Please try again</p></div>";
		}
	}
?>
<div id="core_saving_wrapper" style="display:none;">
	<div class="alert alert-warning">
		<img src="http://223.196.72.250/prochronos/wp-content/themes/studioluc/framework/img/loading.gif" style="float:left; padding-right:30px;width:80px;">
		<h1 style="padding-top:0px;margin-top:0px;">Saving Your Request</h1>
		<p>This may take a few minutes so please wait...</p>
		<div class="clearfix"></div>
	</div>
</div>
<div class="panel panel-default">
    <div class="panel-heading">
        <?php the_title(); ?>
    </div>
    <div class="panel-body">
        <?php // if ( has_post_thumbnail() ) { ?>
			<?php the_post_thumbnail('full',array("class" => "img-polaroid")); ?>
			<hr /> 
        <?php // } ?>
        <?php //the_content(); ?>
        <div class="requestFormCont row">
			<div class="form-group custom-group col-md-4 col-sm-6 col-xs-12">
				<label for="email">Brand:<span class="redAs">*</span></label>
				<div class="inputBox">
					  <select name="brand" class="form-control brand_data" tabindex="21" id="reg_field_brand">
							<option value=""></option>
							 <?php $terms = get_terms( array(
							'taxonomy' => 'brands',
							'hide_empty' => false
						) ); 
						foreach($terms as $term){
							
						?><option value="<?php echo $term->term_id;?>"><?php echo $term->name;?></option>
						<?php } ?>
					</select>
				</div>
			</div>
			<div class="form-group custom-group col-md-4 col-sm-6 col-xs-12">
				<label for="pwd">Model:</label>
				<input type="text" class="form-control model_data" id="pwd" placeholder="Enter Model" name="model">
			</div>
			<div class="form-group custom-group col-md-4 col-sm-6 col-xs-12">
				<label for="pwd">Type of Watch:</label>
				<div class="inputBox">
					<select name ="type_of_watch"  class="form-control category_data">
						<option value=""></option>
				   <?php $terms = get_terms( array(
							'taxonomy' => 'listing',
							'hide_empty' => false
						) ); 
						foreach($terms as $term){
							
					?><option value="<?php echo $term->term_id;?>"><?php echo $term->name;?></option>
					<?php } ?>
					</select>
				</div>
			</div>
			<div class="form-group custom-group col-md-4 col-sm-6 col-xs-12">
				<label for="pwd">Reference number:</label>
				<input type="text" class="form-control ref_no_data" id="pwd" placeholder="Enter Reference number" name="ref_no">
			</div>
			<div class="form-group custom-group col-md-4 col-sm-6 col-xs-12">
				<label for="pwd">Year:</label>
				<input type="text" class="form-control year_data" id="pwd" placeholder="Enter Year" name="year">
			</div>
			<div class="form-group custom-group col-md-4 col-sm-6 col-xs-12">
				<button  class="btn btn-default requestSearch ">Search</button>
				<button  class="btn btn-default requestOnly ">Leave Request</button>
			</div>
        </div>
   
		<div class="col-sm-12" style="">        
			<div class=" wlt_search_results grid_style wlt_builder_listings">
				<div class="searchResultList"></div>
				<div class="request_Form" style="display:none">
					<h3 class="sorryData">Sorry , No listing Found</h3>
					<div class="sorryData">
						You can leave a request for a specific watch by filling in the form below. You will receive an e-mail notification if a listing is created on our website that matches this requested watch.
					</div>
					<div class="requestFormCont col-sm-12">
						<form method="post" action="">
							<h2>*Leave a request </h2>
							<?php if(is_user_logged_in()){ ?>
								<input type="hidden" class="form-control" id="" name="requester_email" value="<?php echo $current_user->user_email;  ?>">
							<?php } else { ?>
								<div class="form-group">
									<label for="Brand">Your Email:</label>
									<div class="inputBox">
										<input type="text" class="form-control" id="" name="requester_email" placeholder="Your email ">
									</div>
								</div>
							<?php }?>
							
							<div class="form-group">
								<label for="Brand">Brand:</label>
								<div class="inputBox">
									<select name="brand" class="form-control" tabindex="21" id="reg_field_brand">
										<option value=""></option>
											 <?php $terms = get_terms( array(
											'taxonomy' => 'brands',
											'hide_empty' => false
										) ); 
										foreach($terms as $term){ ?>
											<option value="<?php echo $term->term_id;?>"><?php echo $term->name;?></option>
										<?php } ?>
									</select>
								</div>
							</div>
							<div class="form-group">
								<label for="Model">Model:</label>
								<div class="inputBox">
									<input type="text" class="form-control" id="" name="model" placeholder="Model ">
								</div>
							</div>
							<div class="form-group">
								<label for="Category">Type of Watch:</label>
								<div class="inputBox">
									<select name ="type_of_watch"  class="form-control">
										<option value=""></option>
										<?php $terms = get_terms( array(
											'taxonomy' => 'listing',
											'hide_empty' => false
										) ); 
										foreach($terms as $term){
											if($term->name !== 'Fast Auctions' && $term->name !== 'Slow Auctions'){ ?>
												<option value="<?php echo $term->term_id;?>"><?php echo $term->name;?></option>
											<?php }
										} ?>
									</select>
								</div>
							</div>
							<div class="form-group">
								<label for="Referencenumber">Reference number:</label>
								<div class="inputBox">
									<input type="text" name="ref_no" class="form-control" id="" placeholder="Reference number">
								</div>
							</div>
							<div class="form-group">
								<label for="Year">Year:</label>
								<div class="inputBox">
									<input type="text" class="form-control" id="" name= "cus_year" placeholder="Year">
								</div>
							</div>
							<div class="form-group">
								<label for="Year">Condition:</label>
								<div class="inputBox">
									<select name="condition" class="form-control" id="">
										<option value="1">New</option>
										<option value="2">Used</option>
									</select>
								</div>
							</div>
							<div class="form-group">
								<label for="Gender">Gender:</label>
								<div class="inputBox">
									<div class="radioGroup"> 
										<span class="genderRadio"> <input class="form-check-input" type="radio" name="gender" id="" value="Men"> Men
										</span> <span class="genderRadio"><input class="form-check-input" type="radio" name="gender" id="" value="Ladies"> Ladies
										</span> <span class="genderRadio">  <input class="form-check-input" type="radio" name="gender" id="" value="Unisex "> Unisex</span> 
									</div>
								</div>
							</div>
							<div class="form-group">
								<label for="Condition ">Condition :</label>
								<div class="inputBox">
									<div class="radioGroup"> 
										<span class="genderRadio"><input class="form-check-input" type="radio" name="request_condition" id="" value="Unworn"> 0 Unworn</span>
										<span class="genderRadio"><input class="form-check-input" type="radio" name="request_condition" id="" value="Mint"> 1 Mint</span> 
										<span class="genderRadio"> <input class="form-check-input" type="radio" name="request_condition" id="" value="Excellent "> 2 Excellent</span> 
										<span class="genderRadio"> <input class="form-check-input" type="radio" name="request_condition" id="" value="Good  "> 3 Good</span>
										<span class="genderRadio"><input class="form-check-input" type="radio" name="request_condition" id="" value="Fair "> 4 Fair</span>
										<span class="genderRadio"><input class="form-check-input" type="radio" name="request_condition" id="" value="poor  "> 5 poor</span>
									</div>
								</div>
							</div>
							<!--<div class="form-group">
								<label for="Country">Country of the requester :</label>
								<div class="inputBox">
									 <select name="req_country" class="form-control" tabindex="12" id="reg_field_company_country"><option value="Afghanistan">Afghanistan</option><option value="Albania">Albania</option><option value="Algeria">Algeria</option><option value="Andorra">Andorra</option><option value="Angola">Angola</option><option value="Anguilla">Anguilla</option><option value="Antigua &amp; Barbuda">Antigua &amp; Barbuda</option><option value="Argentina">Argentina</option><option value="Armenia">Armenia</option><option value="Australia">Australia</option><option value="Austria">Austria</option><option value="Azerbaijan">Azerbaijan</option><option value="Bahamas">Bahamas</option><option value="Bahrain">Bahrain</option><option value="Bangladesh">Bangladesh</option><option value="Barbados">Barbados</option><option value="Belarus">Belarus</option><option value="Belgium">Belgium</option><option value="Belize">Belize</option><option value="Benin">Benin</option><option value="Bermuda">Bermuda</option><option value="Bhutan">Bhutan</option><option value="Bolivia">Bolivia</option><option value="Bosnia &amp; Herzegovina">Bosnia &amp; Herzegovina</option><option value="Botswana">Botswana</option><option value="Brazil">Brazil</option><option value="Brunei Darussalam">Brunei Darussalam</option><option value="Bulgaria">Bulgaria</option><option value="Burkina Faso">Burkina Faso</option><option value="Myanmar/Burma">Myanmar/Burma</option><option value="Burundi">Burundi</option><option value="Cambodia">Cambodia</option><option value="Cameroon">Cameroon</option><option value="Canada">Canada</option><option value="Cape Verde">Cape Verde</option><option value="Cayman Islands">Cayman Islands</option><option value="Central African Republic">Central African Republic</option><option value="Chad">Chad</option><option value="Chile">Chile</option><option value="China">China</option><option value="" selected="selected"></option><option value="Colombia">Colombia</option><option value="Comoros">Comoros</option><option value="Congo">Congo</option><option value="Costa Rica">Costa Rica</option><option value="Croatia">Croatia</option><option value="Cuba">Cuba</option><option value="Cyprus">Cyprus</option><option value="Czech Republic">Czech Republic</option><option value="Democratic Republic of the Congo">Democratic Republic of the Congo</option><option value="Denmark">Denmark</option><option value="Djibouti">Djibouti</option><option value="Dominican Republic">Dominican Republic</option><option value="Dominica">Dominica</option><option value="Ecuador">Ecuador</option><option value="Egypt">Egypt</option><option value="El Salvador">El Salvador</option><option value="Equatorial Guinea">Equatorial Guinea</option><option value="Eritrea">Eritrea</option><option value="Estonia">Estonia</option><option value="Ethiopia">Ethiopia</option><option value="Fiji">Fiji</option><option value="Finland">Finland</option><option value="France">France</option><option value="French Guiana">French Guiana</option><option value="Gabon">Gabon</option><option value="Gambia">Gambia</option><option value="Georgia">Georgia</option><option value="Germany">Germany</option><option value="Ghana">Ghana</option><option value="Great Britain">Great Britain</option><option value="Greece">Greece</option><option value="Grenada">Grenada</option><option value="Guadeloupe">Guadeloupe</option><option value="Guatemala">Guatemala</option><option value="Guinea">Guinea</option><option value="Guinea-Bissau">Guinea-Bissau</option><option value="Guyana">Guyana</option><option value="Haiti">Haiti</option><option value="Honduras">Honduras</option><option value="Hungary">Hungary</option><option value="" selected="selected"></option><option value="Iceland">Iceland</option><option value="India">India</option><option value="Indonesia">Indonesia</option><option value="Iran">Iran</option><option value="Iraq">Iraq</option><option value="Israel and the Occupied Territories">Israel and the Occupied Territories</option><option value="Italy">Italy</option><option value="Ivory Coast (Cote d\'Ivoire)">Ivory Coast (Cote d\'Ivoire)</option><option value="Jamaica">Jamaica</option><option value="Japan">Japan</option><option value="Jordan">Jordan</option><option value="Kazakhstan">Kazakhstan</option><option value="Kenya">Kenya</option><option value="Kosovo">Kosovo</option><option value="Kuwait">Kuwait</option><option value="Kyrgyz Republic (Kyrgyzstan)">Kyrgyz Republic (Kyrgyzstan)</option><option value="Laos">Laos</option><option value="Latvia">Latvia</option><option value="Lebanon">Lebanon</option><option value="Lesotho">Lesotho</option><option value="Liberia">Liberia</option><option value="Libya">Libya</option><option value="Liechtenstein">Liechtenstein</option><option value="Lithuania">Lithuania</option><option value="Luxembourg">Luxembourg</option><option value="Republic of Macedonia">Republic of Macedonia</option><option value="Madagascar">Madagascar</option><option value="Malawi">Malawi</option><option value="Malaysia">Malaysia</option><option value="Maldives">Maldives</option><option value="Mali">Mali</option><option value="Malta">Malta</option><option value="Martinique">Martinique</option><option value="Mauritania">Mauritania</option><option value="Mauritius">Mauritius</option><option value="Mayotte">Mayotte</option><option value="Mexico">Mexico</option><option value="Moldova, Republic of">Moldova, Republic of</option><option value="Monaco">Monaco</option><option value="Mongolia">Mongolia</option><option value="" selected="selected"></option><option value="Montenegro">Montenegro</option><option value="Montserrat">Montserrat</option><option value="Morocco">Morocco</option><option value="Mozambique">Mozambique</option><option value="Namibia">Namibia</option><option value="Nepal">Nepal</option><option value="Netherlands">Netherlands</option><option value="New Zealand">New Zealand</option><option value="Nicaragua">Nicaragua</option><option value="Niger">Niger</option><option value="Nigeria">Nigeria</option><option value="Korea, Democratic Republic of (North Korea)">Korea, Democratic Republic of (North Korea)</option><option value="Norway">Norway</option><option value="Oman">Oman</option><option value="Pacific Islands">Pacific Islands</option><option value="Pakistan">Pakistan</option><option value="Panama">Panama</option><option value="Papua New Guinea">Papua New Guinea</option><option value="Paraguay">Paraguay</option><option value="Peru">Peru</option><option value="Philippines">Philippines</option><option value="Poland">Poland</option><option value="Portugal">Portugal</option><option value="Puerto Rico">Puerto Rico</option><option value="Qatar">Qatar</option><option value="Reunion">Reunion</option><option value="Romania">Romania</option><option value="Russian Federation">Russian Federation</option><option value="Rwanda">Rwanda</option><option value="Saint Kitts and Nevis">Saint Kitts and Nevis</option><option value="Saint Lucia">Saint Lucia</option><option value="Saint Vincent\'s &amp; Grenadines">Saint Vincent\'s &amp; Grenadines</option><option value="Samoa">Samoa</option><option value="Sao Tome and Principe">Sao Tome and Principe</option><option value="Saudi Arabia">Saudi Arabia</option><option value="Senegal">Senegal</option><option value="Serbia">Serbia</option><option value="Seychelles">Seychelles</option><option value="Sierra Leone">Sierra Leone</option><option value="Singapore">Singapore</option><option value="" selected="selected"></option><option value="Slovak Republic (Slovakia)">Slovak Republic (Slovakia)</option><option value="Slovenia">Slovenia</option><option value="Solomon Islands">Solomon Islands</option><option value="Somalia">Somalia</option><option value="South Africa">South Africa</option><option value="Korea, Republic of (South Korea)">Korea, Republic of (South Korea)</option><option value="South Sudan">South Sudan</option><option value="Spain">Spain</option><option value="Sri Lanka">Sri Lanka</option><option value="Sudan">Sudan</option><option value="Suriname">Suriname</option><option value="Swaziland">Swaziland</option><option value="Sweden">Sweden</option><option value="Switzerland">Switzerland</option><option value="Syria">Syria</option><option value="Tajikistan">Tajikistan</option><option value="Tanzania">Tanzania</option><option value="Thailand">Thailand</option><option value="Timor Leste">Timor Leste</option><option value="Togo">Togo</option><option value="Trinidad &amp; Tobago">Trinidad &amp; Tobago</option><option value="Tunisia">Tunisia</option><option value="Turkey">Turkey</option><option value="Turkmenistan">Turkmenistan</option><option value="Turks &amp; Caicos Islands">Turks &amp; Caicos Islands</option><option value="Uganda">Uganda</option><option value="Ukraine">Ukraine</option><option value="United Arab Emirates">United Arab Emirates</option><option value="United States of America (USA)">United States of America (USA)</option><option value="Uruguay">Uruguay</option><option value="Uzbekistan">Uzbekistan</option><option value="Venezuela">Venezuela</option><option value="Vietnam">Vietnam</option><option value="Virgin Islands (UK)">Virgin Islands (UK)</option><option value="Virgin Islands (US)">Virgin Islands (US)</option><option value="Yemen">Yemen</option><option value="Zambia">Zambia</option><option value="Zimbabwe">Zimbabwe</option></select>
								</div>
							</div>
							<div class="form-group">
								<label for="Datestarts">Date when request starts :</label>
								<div class="inputBox">
									<input type="text" name="request_date" class="form-control" id="datepicker" placeholder="start date dd/mm/yy">
								</div>
							</div>
							<div class="form-group">
								<label for="Dateends">Days after request ends:</label>
								<div class="inputBox">
								   <input type="text" name="request_existance" class="form-control" id="" placeholder="1-30 ">
								</div>
							</div>-->
							<div class="form-group">
								<label for="Dateends">Number of days that the request is valid</label>
								<div class="inputBox">
									<select name="request_existance" class="form-control">
										<option value="1">1 Day</option>
										<option value="2">2 Days</option>
										<option value="3">3 Days</option>
										<option value="4">4 Days</option>
										<option value="5">5 Days</option>
										<option value="6">6 Days</option>
										<option value="7">7 Days</option>
										<option value="8">8 Days</option>
										<option value="9">9 Days</option>
										<option value="10">10 Days</option>
										<option value="11">11 Days</option>
										<option value="12">12 Days</option>
										<option value="13">13 Days</option>
										<option value="14">14 Days</option>
										<option value="15">15 Days</option>
										<option value="16">16 Days</option>
										<option value="17">17 Days</option>
										<option value="18">18 Days</option>
										<option value="19">19 Days</option>
										<option value="20">20 Days</option>
										<option value="21">21 Days</option>
										<option value="22">22 Days</option>
										<option value="23">23 Days</option>
										<option value="24">24 Days</option>
										<option value="25">25 Days</option>
										<option value="26">26 Days</option>
										<option value="27">27 Days</option>
										<option value="28">28 Days</option>
										<option value="29">29 Days</option>
										<option value="30">30 Days</option>
									</select>
									<input type="hidden" name="requester_id" value="<?php echo get_current_user_id() ?>">
								</div>
							</div>
							<input type="submit" class="btn btn-default requestSendBtn" name="submit" value="Send">
						</form>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
	<?php $get_requests = $wpdb->get_results("SELECT * FROM `".$wpdb->prefix."request_management` ORDER BY `request_created` DESC"); 
	//echo "<pre>"; print_r($get_requests); echo "</pre>"; 
	$requestList = '';
	foreach($get_requests as $request){
		$d = $request->request_existance;
		$requestEnds = strtotime(date('d-m-Y', strtotime($request->request_created. ' + '.$d.' days')));
		$currentDate = strtotime(date('d-m-Y'));
		if($currentDate <= $requestEnds){
			
			$requestList .= '<li class="list-group-item"><div>';
			if(is_user_logged_in() && $request->requester_id == get_current_user_id()){
				$requestList .= '<span class="deleteBtnReq" onclick="deleteListRequest('.$request->id.');"><i class="fa fa-trash"></i></span>';
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
			if(get_user_meta($request->requester_id,'street_name',true) !=''){
				$address .= get_user_meta($request->requester_id,'street_name',true).' ';
			}
			if(get_user_meta($request->requester_id,'house_no',true) !=''){
				$address .= get_user_meta($request->requester_id,'house_no',true).',<br>';
			}
			if(get_user_meta($request->requester_id,'postcode',true) !=''){
				$address .= get_user_meta($request->requester_id,'postcode',true).',<br>';
			}
			if(get_user_meta($request->requester_id,'company_city',true) !=''){
				$address .= get_user_meta($request->requester_id,'company_city',true).',<br>';
			} 
			
			if(get_user_meta($request->requester_id,'company_country',true) !=''){
				$address .= get_user_meta($request->requester_id,'company_country',true).'';
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
	} ?>
	<script type="text/javascript">
		jQuery(document).ready(function(){
			jQuery('.requestSearch').click(function(){
				var year = jQuery('.year_data').val();
				var brand = jQuery('.brand_data option:selected').val();
				var ref_no = jQuery('.ref_no_data').val();
				var category = jQuery('.category_data option:selected').val();
				var model = jQuery('.model_data').val();
				if(brand == ''){
					jQuery('.brand_data').addClass('error');
					return false;
				}
				jQuery.ajax({
					method : 'post',
					data: {action: 'requestSearch', year: year, brand: brand, ref_no :ref_no, category: category, model: model},
					url: '<?php echo get_stylesheet_directory_uri();?>/request.php',
					success: function(data) {
						jQuery('.brand_data.error').removeClass('error');
						if(data != 0 ){
							jQuery('.wlt_search_results .searchResultList').html(data);
							jQuery('.request_Form, .sorryData').css('display','none');
						}else{
							jQuery('.wlt_search_results .searchResultList').html('');
							jQuery('.request_Form, .sorryData').css('display','block');
						}
					},

				});
				
			});
			jQuery('.requestOnly').click(function(){
				//jQuery('.wlt_search_results .searchResultList').html('');
				jQuery('.request_Form').css('display','block');
				jQuery('.sorryData').css('display','none');
			});
			
			jQuery('.brand_data.error').click(function(){
				jQuery(this).removeClass('error');
			});
			
			var appendHtml = '';
			appendHtml += '<div class="normallayout"><div class="panel panel-default"><div class="panel-heading">Previous Requests</div><ul class="list-group clearfix prevReqSide">';
			appendHtml += '<?php echo $requestList; ?>';
			appendHtml += '</ul></div></div></div>';
			
			jQuery('#core_left_column').append(appendHtml);
			
			jQuery('.requestSendBtn').click(function(){
				jQuery('#core_saving_wrapper').css('display','block');
				jQuery(window).scrollTop(jQuery('#core_saving_wrapper').offset().top);
				//jQuery('.panel.panel-default').css('display','none');
				
			});
		});

		function deleteListRequest(listId){
			jQuery.ajax({
				method : 'post',
				data: {action: 'delReqList', req_id: listId},
				url: '<?php echo get_stylesheet_directory_uri();?>/request.php',
				success: function(data) {
					//alert(data);
					/*jQuery('.brand_data.error').removeClass('error');*/
					if(data != 0 ){
						alert('Request deleted successfully.');
						jQuery('#core_left_column ul.prevReqSide').html(data);
						
					}else{
						alert('Error in deleting request. Please contact administrator.');
					}
				},

			});
		}
	</script>
<?php  hook_page_after(); ?>
<?php endwhile; endif; ?>
<?php get_footer($CORE->pageswitch());


} ?>
<style>
#core_advanced_search_widget_box, .core_widgets_categories_list {
  display: none;
}
</style>
