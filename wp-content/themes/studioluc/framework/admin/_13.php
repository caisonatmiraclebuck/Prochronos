<?php
// CHECK THE PAGE IS NOT BEING LOADED DIRECTLY
if (!defined('THEME_VERSION')) {	header('HTTP/1.0 403 Forbidden'); exit; }
// SETUP GLOBALS
global $wpdb, $CORE, $userdata, $CORE_ADMIN;
// LOAD IN MAIN DEFAULTS 
$core_admin_values = get_option("core_admin_values");  
 
	
wp_register_style( 'wlt_wp_admin_css',  FRAMREWORK_URI.'admin/css/admin.css');
wp_enqueue_style( 'wlt_wp_admin_css' );
 


 
// LOAD IN HEADER
echo $CORE_ADMIN->HEAD(); ?>



<ul id="tabExample1" class="nav nav-tabs">

<?php
// HOOK INTO THE ADMIN TABS
function _13_tabs(){ $STRING = ""; global $wpdb; $core_admin_values = get_option("core_admin_values");

	if(isset($_GET['tab'])){ $_POST['tab'] = $_GET['tab']; }

	$pages_array = array( 
 
	"1" => array("t" => "Live Reports"	,"k"=>"home"),
	"2" => array("t" => "Email Reports"	,"k"=>"email"),
 
 	);
	foreach($pages_array as $page){
	 
	if( ( isset($_POST['tab']) && $_POST['tab'] == $page['k'] ) || ( !isset($_POST['tab']) && $page['k'] == "home" ) ){ $class = "active"; }else{ $class = ""; }
	
		$STRING .= '<li class="'.$class.'"><a href="#'.$page['k'].'" onclick="document.getElementById(\'ShowTab\').value=\''.$page['k'].'\'" data-toggle="tab">'.$page['t'].'</a></li>';		
	}
 
	return $STRING;

}
echo hook_admin_13_tabs(_13_tabs());
// END HOOK
?>  
          
</ul>

<div class="tab-content">

   
    <div class="tab-pane fade <?php if(!isset($_POST['tab']) || ( isset($_POST['tab']) && ( $_POST['tab'] =="" || $_POST['tab'] =="home" ) )){ echo "active in"; } ?> in" id="home">
    
    
     
 <script>jQuery(function(){ jQuery('#reg_field_1_date').datetimepicker(); jQuery('#reg_field_2_date').datetimepicker();}); </script>
</form>
 <form action="" method="get">
<input type="hidden" name="submitted" value="no">
<input type="hidden" name="page" value="13">
<input type="hidden" name="tab" id="ShowTab" value="home">



 <div class="well">     
 <div class="row-fluid">

 <div class="span2">Time Period</div>
 <div class="span4">
  
	 <div class="input-prepend date span6" id="reg_field_1_date" data-date-format="yyyy-MM-dd hh:mm:ss">
                    <span class="add-on" style="height: 32px;"><i class="gicon-calendar"></i></span>
                    <input type="text" name="date1" value="<?php if(!isset($_GET['date1'])){ echo date('Y-m-d H:i:s' , strtotime('-7 days')); }else{ echo $_GET['date1']; } ?>" id="date1"  data-format="yyyy-MM-dd hh:mm:ss" />
     </div>  
 </div>
 <div class="span4">
  
 	<div class="input-prepend date span6" id="reg_field_2_date" data-date-format="yyyy-MM-dd hh:mm:ss">
                    <span class="add-on" style="height: 32px;"><i class="gicon-calendar"></i></span>
                    <input type="text" name="date2" value="<?php if(!isset($_GET['date2'])){ echo date('Y-m-d H:i:s');  }else{ echo $_GET['date2']; } ?>" id="date2"  data-format="yyyy-MM-dd hh:mm:ss" />
                    </div> 
 
 </div>
 
  <div class="span2"><button class="btn btn-primary" type="submit">Update</button></div> 
 
 </div>  
 </div>
 
 </form>
 
 <hr />

 <div class="row-fluid">
  
     
<?php

if(!isset($_GET['date1'])){
$date1 = date('Y-m-d H:i:s' , strtotime('-7 days'));
$date2 = date('Y-m-d H:i:s');
}else{
$date1 = $_GET['date1'];
$date2 = $_GET['date2'];
}

$SQL = $CORE->reports($date1, $date2,true, true);
		// LOOP THROUGH AND RUN THE SQL QUERIES
		if(is_array($SQL)){ $STRING = "";
			
			foreach($SQL as $querystr){
				 
				if($querystr['sql'] == "none"){
				 						
				}else{ 
					$results = $wpdb->get_results($querystr['sql']);
					
				?>
                  
            <table id="datatable_example" class="responsive table table-striped table-bordered">
            <thead>
            <tr>
              <th class="no_sort"><?php echo $querystr['title']; ?></th>
              <th class="no_sort" style="width:70px;text-align:center;"></th>
            </tr></thead>
            <tbody>
            <?php
											
					if(!empty($results)){ ?>
                    
            
                             <?php
								foreach ( $results as $r ) {
									 $hits = "";
									if($querystr['hits']){
										$hits = get_post_meta($r->ID,'hits',true);
										if($hits == ""){ $hits = "0 views"; }else{ $hits = $hits." views"; }
									}
									if($querystr['date']){
										$hits = hook_date($r->post_date);
									}
									if($querystr['rating']){
										$hits = $r->meta_value ." votes";
									}
									if($querystr['users']){
										$hits = $r->meta_value ." listings";
										$link = get_home_url()."/?s=&uid=".$r->post_author;
									}elseif($querystr['orders']){
										$hits = $GLOBALS['CORE_THEME']['currency']['symbol']."".$r->meta_value ."";
										$link = get_home_url()."/wp-admin/admin.php?page=6&tab=home&oid=".$r->meta_value1;
									}else{
										$link = get_permalink($r->ID);
									}
									?>
                                    
                                      <tr>
            
         <td><a href='<?php echo $link; ?>' style="color:blue; text-decoration:underline;"><?php echo $r->post_title; ?></a></td>         
         <td><center><span class="label label-yes"><?php echo $hits; ?></span></center></td>
         
            </tr> 
                                    <?php
									
								 
								} // end foreach
						
					}else{
					?>
					 <tr>
            
         <td colspan=2>No Results Found</td>
         
            </tr> 
					<?php
					}		
					
									
							?>
                            </tbody></table>
                             
                            <?php
					
				} // end if	
			}// end foreach	
	
}
			echo $STRING;

?>
    
   </div>
  
 
   
    
 
    
    
    
    
    
    
    
    
    
    
    
    
    </div>

	<div class="tab-pane fade <?php if(isset($_POST['tab']) && $_POST['tab'] == "email"){ echo "active in"; } ?>" id="email">

<form method="post" name="admin_save_form" id="admin_save_form" enctype="multipart/form-data">
	<input type="hidden" name="submitted" value="yes">
	<input type="hidden" name="tab"  value="email">
	 
<style>
.ah {  
 background: #f7f7f7;
border: 1px solid #dddddd;
border-radius: 4px;
-webkit-box-shadow: 0 1px 1px rgba(0, 0, 0, 0.05);
box-shadow: 0 1px 1px rgba(0, 0, 0, 0.05); 
display: block;
padding: 8px 15px;
color: #269ccb;
font-weight: bold;
margin-bottom:10px;
}
.cb { margin-right:10px !important; }
</style>
<div class="tab-content" style="border-top: 1px solid #cdcdcd;">

 
 <script>
function changeboxme(id){

 var v = jQuery("#"+id).val();
 if(v == 1){
 jQuery("#"+id).val('0');
 }else{
 jQuery("#"+id).val('1');
 }
 
}
</script>
<div class="row-fluid">
    <div class="span6">
    
    <h3>Report Features</h3>
    <p>Tick the features below you want to include in your report.</p>
    
    <div class="ah">    
    <input name="" type="checkbox" value="1" class="cb" onchange="changeboxme('box1');" <?php if($core_admin_values['wlt_report']['f1'] == 1){ ?>checked="checked"<?php } ?>  /> 10 Most Recent Listings
    <input type="hidden" name="admin_values[wlt_report][f1]" value="<?php echo $core_admin_values['wlt_report']['f1']; ?>" id="box1" />   
    </div>
    
     <div class="ah">    
    <input name="" type="checkbox" value="1" class="cb" onchange="changeboxme('box2');" <?php if($core_admin_values['wlt_report']['f2'] == 1){ ?>checked="checked"<?php } ?> /> 10 Most Popular Listings
    <input type="hidden" name="admin_values[wlt_report][f2]" value="<?php echo $core_admin_values['wlt_report']['f2']; ?>" id="box2" />   
    </div>   
    
    <div class="ah">    
    <input name="" type="checkbox" value="1" class="cb" onchange="changeboxme('box3');" <?php if($core_admin_values['wlt_report']['f3'] == 1){ ?>checked="checked"<?php } ?> /> 10 Most User Rated Listings
    <input type="hidden" name="admin_values[wlt_report][f3]" value="<?php echo $core_admin_values['wlt_report']['f3']; ?>" id="box3" />   
    </div>  
      
    <div class="ah">    
    <input name="" type="checkbox" value="1" class="cb" onchange="changeboxme('box4');" <?php if($core_admin_values['wlt_report']['f4'] == 1){ ?>checked="checked"<?php } ?> /> 10 Most Recent Orders
    <input type="hidden" name="admin_values[wlt_report][f4]" value="<?php echo $core_admin_values['wlt_report']['f4']; ?>" id="box4" />   
    </div>
    
    <div class="ah">    
    <input name="" type="checkbox" value="1" class="cb" onchange="changeboxme('box5');" <?php if($core_admin_values['wlt_report']['f5'] == 1){ ?>checked="checked"<?php } ?> /> 10 Most User Search Terms
    <input type="hidden" name="admin_values[wlt_report][f5]" value="<?php echo $core_admin_values['wlt_report']['f5']; ?>" id="box5" />   
    </div>    
    
    <div class="ah">    
    <input name="" type="checkbox" value="1" class="cb" onchange="changeboxme('box6');" <?php if($core_admin_values['wlt_report']['f6'] == 1){ ?>checked="checked"<?php } ?> /> 10 Most Recent Comments
    <input type="hidden" name="admin_values[wlt_report][f6]" value="<?php echo $core_admin_values['wlt_report']['f6']; ?>" id="box6" />   
    </div>  
      
    <div class="ah">    
    <input name="" type="checkbox" value="1" class="cb" onchange="changeboxme('box7');" <?php if($core_admin_values['wlt_report']['f7'] == 1){ ?>checked="checked"<?php } ?> /> 10 Most Active Listing Authors
    <input type="hidden" name="admin_values[wlt_report][f7]" value="<?php echo $core_admin_values['wlt_report']['f7']; ?>" id="box7" />   
    </div>  
    
    <hr />
    
    <button type="submit" class="btn btn-primary" onclick="jQuery('#runreportnow').val('');">Save Changes</button>
       
           
    </div>
    
    <div class="span6">
    
        <h3>Email Daily Report</h3>
    	<p>Enter your email below to recieve the report daily via email;</p> 
    
    	<div style="background:#fff; padding:30px; border:1px solid #ddd;">
       
            <div class="form-row control-group row-fluid">
                <label class="control-label span4" for="normal-field">Email Report To</label>
                <div class="controls span7">
                <input type="text" name="admin_values[wlt_report][email]" class="row-fluid" value="<?php echo $core_admin_values['wlt_report']['email']; ?>">
                </div>
            </div>
 
            
            <hr />
            
            <button type="submit" class="btn btn-primary" onclick="jQuery('#runreportnow').val('');">Save Changes</button>
       
        </div>
        
        
        <h3>Download Report Now</h3>
    	<p>Select the date range to download the report now.</p> 
    
    	<div style="background:#fff; padding:30px; border:1px solid #ddd;">
       
       
       
       <script>jQuery(function(){ jQuery('#reg_field_1_date1').datetimepicker();  jQuery('#reg_field_2_date1').datetimepicker();}); </script>
	     
            <div class="form-row control-group row-fluid">
                <label class="control-label span4" for="normal-field">Date From</label>
                <div class="controls span7">
                	<div class="input-prepend date span6" id="reg_field_1_date1" data-date-format="yyyy-MM-dd hh:mm:ss">
                    <span class="add-on" style="height: 32px;"><i class="gicon-calendar"></i></span>
                    <input type="text" name="date1" value="<?php echo date('Y-m-d H:i:s' , strtotime('-7 days')); ?>" id="date1"  data-format="yyyy-MM-dd hh:mm:ss" />
                    </div>               
                </div>
            </div>
            
            <div class="form-row control-group row-fluid">
                <label class="control-label span4" for="normal-field">Date To</label>
                <div class="controls span7">
                	<div class="input-prepend date span6" id="reg_field_2_date1" data-date-format="yyyy-MM-dd hh:mm:ss">
                    <span class="add-on" style="height: 32px;"><i class="gicon-calendar"></i></span>
                    <input type="text" name="date2" value="<?php echo date('Y-m-d H:i:s'); ?>" id="date2"  data-format="yyyy-MM-dd hh:mm:ss" />
                    </div>               
                </div>
            </div>  
            
            <hr />
            
            <div style="text-align:center;"><button class="btn btn-info" onclick="jQuery('#runreportnow').val('yes');">Generate Report</button> </div> 
    
    <input name="runreportnow" value="" id="runreportnow" type="hidden" />
            
       
        </div> 
        
   
    
</div> 
 
 </div> </div> 
 
<?php // LOAD IN FOOTER
echo $CORE_ADMIN->FOOTER(); ?>