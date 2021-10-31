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


function createDateRangeArray($strDateFrom,$strDateTo) {

 $aryRange=array();

  $iDateFrom=mktime(1,0,0,substr($strDateFrom,5,2),     substr($strDateFrom,8,2),substr($strDateFrom,0,4));
  $iDateTo=mktime(1,0,0,substr($strDateTo,5,2),     substr($strDateTo,8,2),substr($strDateTo,0,4));

  if ($iDateTo>=$iDateFrom) {
    array_push($aryRange,date('Y-m-d',$iDateFrom)); // first entry

    while ($iDateFrom<$iDateTo) {
      $iDateFrom+=86400; // add 24 hours
      array_push($aryRange,date('Y-m-d',$iDateFrom));
    }
  }
  return $aryRange;
}
 
function wlt_chartdata($query=0,$return=false){ global $wpdb; $STRING = "";
	 
	$DATE1 = date("Y-m-d",mktime(0, 0, 0, date("m")-1  , date("d")+10, date("Y")));
	$DATE2 = date("Y-m-d",mktime(0, 0, 0, date("m")  , date("d")+1, date("Y")));	
	
	$dates = createDateRangeArray($DATE1,$DATE2); 
	$newdates = array();
	foreach($dates as $date){	  
	 $newdates[''.$date.''] = 0;
	}
 
	if($return){ return $newdates; }
 
	// GET ALL DATA FOR THE LAST 31 DAYS
	if($query == 0){
	$SQL1 = "select ".$wpdb->prefix."posts.post_date from ".$wpdb->prefix."posts where ".$wpdb->prefix."posts.post_date >= '".$DATE1."' and ".$wpdb->prefix."posts.post_date < '".$DATE2."' AND ".$wpdb->prefix."posts.post_type='".THEME_TAXONOMY."_type' GROUP BY ID";
	}elseif($query == 1){
	$SQL1 = "select ".$wpdb->prefix."posts.post_date,".$wpdb->prefix."postmeta.meta_value from ".$wpdb->prefix."posts LEFT JOIN ".$wpdb->prefix."postmeta ON (".$wpdb->prefix."posts.ID = ".$wpdb->prefix."postmeta.post_id) where ".$wpdb->prefix."posts.post_date >= '".$DATE1."' and ".$wpdb->prefix."posts.post_date < '".$DATE2."' AND ".$wpdb->prefix."posts.post_type='".THEME_TAXONOMY."_type' AND ".$wpdb->prefix."postmeta.meta_key = 'PackageID'  AND ".$wpdb->prefix."postmeta.meta_value='1' GROUP BY ID";
	}elseif($query == 2){
	$SQL1 = "select ".$wpdb->prefix."posts.post_date,".$wpdb->prefix."postmeta.meta_value from ".$wpdb->prefix."posts LEFT JOIN ".$wpdb->prefix."postmeta ON (".$wpdb->prefix."posts.ID = ".$wpdb->prefix."postmeta.post_id) where ".$wpdb->prefix."posts.post_date >= '".$DATE1."' and ".$wpdb->prefix."posts.post_date < '".$DATE2."' AND ".$wpdb->prefix."posts.post_type='".THEME_TAXONOMY."_type' AND ".$wpdb->prefix."postmeta.meta_key = 'PackageID'  AND ".$wpdb->prefix."postmeta.meta_value='2' GROUP BY ID";
	}elseif($query == 3){
	$SQL1 = "select ".$wpdb->prefix."posts.post_date,".$wpdb->prefix."postmeta.meta_value from ".$wpdb->prefix."posts LEFT JOIN ".$wpdb->prefix."postmeta ON (".$wpdb->prefix."posts.ID = ".$wpdb->prefix."postmeta.post_id) where ".$wpdb->prefix."posts.post_date >= '".$DATE1."' and ".$wpdb->prefix."posts.post_date < '".$DATE2."' AND ".$wpdb->prefix."posts.post_type='".THEME_TAXONOMY."_type' AND ".$wpdb->prefix."postmeta.meta_key = 'PackageID'  AND ".$wpdb->prefix."postmeta.meta_value='3' GROUP BY ID";
	}elseif($query == 4){
	$SQL1 = "select ".$wpdb->prefix."posts.post_date,".$wpdb->prefix."postmeta.meta_value from ".$wpdb->prefix."posts LEFT JOIN ".$wpdb->prefix."postmeta ON (".$wpdb->prefix."posts.ID = ".$wpdb->prefix."postmeta.post_id) where ".$wpdb->prefix."posts.post_date >= '".$DATE1."' and ".$wpdb->prefix."posts.post_date < '".$DATE2."' AND ".$wpdb->prefix."posts.post_type='".THEME_TAXONOMY."_type' AND ".$wpdb->prefix."postmeta.meta_key = 'PackageID'  AND ".$wpdb->prefix."postmeta.meta_value='4' GROUP BY ID";
	}elseif($query == 5){
	$SQL1 = "select ".$wpdb->prefix."posts.post_date,".$wpdb->prefix."postmeta.meta_value from ".$wpdb->prefix."posts LEFT JOIN ".$wpdb->prefix."postmeta ON (".$wpdb->prefix."posts.ID = ".$wpdb->prefix."postmeta.post_id) where ".$wpdb->prefix."posts.post_date >= '".$DATE1."' and ".$wpdb->prefix."posts.post_date < '".$DATE2."' AND ".$wpdb->prefix."posts.post_type='".THEME_TAXONOMY."_type' AND ".$wpdb->prefix."postmeta.meta_key = 'PackageID'  AND ".$wpdb->prefix."postmeta.meta_value='5' GROUP BY ID";
	}elseif($query == 6){
	$SQL1 = "select ".$wpdb->prefix."posts.post_date,".$wpdb->prefix."postmeta.meta_value from ".$wpdb->prefix."posts LEFT JOIN ".$wpdb->prefix."postmeta ON (".$wpdb->prefix."posts.ID = ".$wpdb->prefix."postmeta.post_id) where ".$wpdb->prefix."posts.post_date >= '".$DATE1."' and ".$wpdb->prefix."posts.post_date < '".$DATE2."' AND ".$wpdb->prefix."posts.post_type='".THEME_TAXONOMY."_type' AND ".$wpdb->prefix."postmeta.meta_key = 'PackageID'  AND ".$wpdb->prefix."postmeta.meta_value='6' GROUP BY ID";
	}elseif($query == 7){
	$SQL1 = "select ".$wpdb->prefix."posts.post_date,".$wpdb->prefix."postmeta.meta_value from ".$wpdb->prefix."posts LEFT JOIN ".$wpdb->prefix."postmeta ON (".$wpdb->prefix."posts.ID = ".$wpdb->prefix."postmeta.post_id) where ".$wpdb->prefix."posts.post_date >= '".$DATE1."' and ".$wpdb->prefix."posts.post_date < '".$DATE2."' AND ".$wpdb->prefix."posts.post_type='".THEME_TAXONOMY."_type' AND ".$wpdb->prefix."postmeta.meta_key = 'PackageID'  AND ".$wpdb->prefix."postmeta.meta_value='7' GROUP BY ID";
	}elseif($query == 8){
	$SQL1 = "select ".$wpdb->prefix."posts.post_date,".$wpdb->prefix."postmeta.meta_value from ".$wpdb->prefix."posts LEFT JOIN ".$wpdb->prefix."postmeta ON (".$wpdb->prefix."posts.ID = ".$wpdb->prefix."postmeta.post_id) where ".$wpdb->prefix."posts.post_date >= '".$DATE1."' and ".$wpdb->prefix."posts.post_date < '".$DATE2."' AND ".$wpdb->prefix."posts.post_type='".THEME_TAXONOMY."_type' AND ".$wpdb->prefix."postmeta.meta_key = 'PackageID'  AND ".$wpdb->prefix."postmeta.meta_value='8' GROUP BY ID";
	}elseif($query == 9){
	$SQL1 = "SELECT order_date AS post_date FROM ".$wpdb->prefix."core_orders LEFT JOIN ".$wpdb->users." ON (".$wpdb->users.".ID = ".$wpdb->prefix."core_orders.user_id) WHERE ".$wpdb->prefix."core_orders.order_date >= '".$DATE1."' and ".$wpdb->prefix."core_orders.order_date < '".$DATE2."'";
	}
	
	 
	$result = $wpdb->get_results($SQL1);
 	if(!$result){ return 0; }
	
	foreach($result as $value){	 
	  $postDate = explode(" ",$value->post_date);	 
		$newdates[$postDate[0]] ++;
	}	 
	 
	// FORMAT RESULTS FOR CHART	
	$i=1;  
	foreach($newdates as $key=>$val){
		$a = $key; 
		if(!is_numeric($val)){$val=0; }
		 	
		$STRING .= '['.$i.','.$val.'], ';
		$i++;		 
	}
	// RETURN DATA	
	return $STRING;
 
}

// LOAD IN MAIN DEFAULTS 
$core_admin_values = get_option("core_admin_values");  
  
?> 



<h4>New listings and orders received during the last 30 days.</h4>
 
<div style="background:#efefef;padding-top:20px; padding-right:20px;">
<div id="placeholder" style="height:300px; margin-left:20px; margin-bottom:10px; margin-top:10px;"></div>
 
<script type="text/javascript">
jQuery(function () {
        
    var datasets = {
        "a": {
            label: "New Listings",
            data: [<?php echo wlt_chartdata(0); ?>],
			color: "#8EC252"
        },
		 					
        "j": {
            label: "New Orders",
            data: [<?php echo wlt_chartdata(9); ?>],
			color: "#333"
        },
		 	
		 };
          
            // insert checkboxes 
            var choiceContainer =jQuery("#choices");
    jQuery.each(datasets, function(key, val) {
        choiceContainer.append('<div style="float:left;width:150px; margin-bottom:10px;"><input style="float:left; margin-top:8px; margin-right:4px;" type="checkbox" name="' + key +
                               '" checked="checked" id="id' + key + '">' +
                               '<label for="id' + key + '">'
                                + val.label + '</label></div>');
    });
            choiceContainer.find("input").click(plotAccordingToChoices);

            
            function plotAccordingToChoices() {
                var data = [];

                choiceContainer.find("input:checked").each(function () {
                    var key =jQuery(this).attr("name");
                    if (key && datasets[key])
                        data.push(datasets[key]);
                });

                if (data.length > 0)
                   jQuery.plot(jQuery("#placeholder"), data, {
                        shadowSize: 0,
                        yaxis: {   },
                        xaxis: {   ticks: [0, <?php $s = wlt_chartdata(0,true); $i=1;foreach($s as $val=>$da){ echo '['.$i.', "'.substr($val,5,5).'"],'; $i++;  } ?>  ],  
						lines: { show: true },
						label: 'string' },						
						selection: { mode: "xy" },
                                                grid: { hoverable: true, clickable: true },
                                                bars: { show: true,lineWidth:3,autoScale: true, fillOpacity: 1 },
                                        points: { show: true },
                                        legend: {container:jQuery("#LegendContainer")    }
             
                                


                        
                    });
            }
       var previousPoint = null;
   	   jQuery("#placeholder").bind("plothover", function (event, pos, item) {
       jQuery("#x").text(pos.x.toFixed(2));
       jQuery("#y").text(pos.y.toFixed(2));

       
            if (item) {
                if (previousPoint != item.datapoint) {
                    previousPoint = item.datapoint;
                    
                   jQuery("#tooltip").remove();
                    var x = item.datapoint[0].toFixed(2),
                        y = item.datapoint[1];
                    if (y==1)
                    {
                    showTooltip(item.pageX, item.pageY, y + " " + item.series.label );
                    }
                    else
                    {
                    showTooltip(item.pageX, item.pageY, y + " " + item.series.label );
                    }
                }
                }
                else {
               jQuery("#tooltip").remove();
                previousPoint = null;            
            
            
        }
    });
function showTooltip(x, y, contents) {
       jQuery('<div id="tooltip">' + contents + '</div>').css( {
            position: 'absolute',
            display: 'none',
            top: y + 5,
            left: x + 5,
            border: '1px solid #fdd',
            padding: '2px',
            'background-color': '#fff',
            opacity: 0.80
        }).appendTo("body").fadeIn(200);
    }
            plotAccordingToChoices();
        });
</script>
<script language="javascript" type="text/javascript" src="<?php echo get_bloginfo('template_url')."/framework/admin/"; ?>js/jquery.flot.js"></script> 
<div id="LegendContainer" style="float:right; margin-right:20px;margin-top:-10px;"></div>
<div id="choices" style="padding:10px;">&nbsp;</div>
<div class="clearfix"></div>
</div> 
 

<h4>New listings created each month for the last 12 months.</h4> 
 
<style>
.dd { background:#efefef; padding:20px; }
.dd ul li { float:left; width:33%;     font-size: 16px;    line-height: 25px; }
.dd ul li span { font-weight:bold; }
</style> 
<div  class="dd">
<ul>
<?php
 $i=0;
while($i < 15){

	if($i == 0){
	$days = 0;
	}else{
	$days = $i * 28;
	}
?>
<li><img  src="<?php echo get_template_directory_uri(); ?>/framework/admin/img/icons/26.png" align="absmiddle" style="padding-right:5px;">
<?php echo date('F Y', strtotime("-".$days." days")); ?>: 

<span>
<?php
 
$count = $wpdb->get_var("SELECT count(*) FROM ".$wpdb->prefix."posts WHERE ".$wpdb->prefix."posts.post_type = '".THEME_TAXONOMY."_type' AND post_date LIKE '%". date('Y-m', strtotime("-".$days." days")). "-%' ");
echo $count;
?>
</span>

</li>
<?php
$i++;
} 
?> 
</ul>
<div class="clearfix"></div>
</div>

<h4>Most active members</h4>


<div  class="dd">
<ul>

<?php

$SQL = "SELECT  count(*) as total, ".$wpdb->prefix."users.user_nicename, ".$wpdb->prefix."posts.post_author 
FROM ".$wpdb->prefix."posts
INNER JOIN ".$wpdb->prefix."users ON (".$wpdb->prefix."posts.post_author = ".$wpdb->prefix."users.ID AND ".$wpdb->prefix."users.user_status != 1 )
WHERE ".$wpdb->prefix."posts.post_type =  'listing_type' AND ".$wpdb->prefix."posts.post_status =  'publish'
GROUP BY ".$wpdb->prefix."posts.post_author ORDER BY count(".$wpdb->prefix."posts.post_author) DESC LIMIT 10";
 
 
$result = $wpdb->get_results($SQL);

foreach($result as $r){
?>
<li>
<img  src="<?php echo get_template_directory_uri(); ?>/framework/admin/img/icons/27.png" align="absmiddle" style="padding-right:5px;">  <a href="user-edit.php?user_id=<?php echo $r->post_author; ?>" style="text-decoration:underline;"><?php echo $r->user_nicename; ?></a> has <span><?php echo $r->total; ?></span> listings 
</li>

<?php } ?>

</ul>
<div class="clearfix"></div>
</div>
