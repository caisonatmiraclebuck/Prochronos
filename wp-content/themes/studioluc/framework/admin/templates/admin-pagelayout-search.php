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


// LOAD IN MAIN DEFAULTS 
$core_admin_values = get_option("core_admin_values");  

// DEFAULT ITEM
$THEMESTUB = str_replace("_theme","",str_replace("template_","",$GLOBALS['CORE_THEME']['template']));
if($THEMESTUB == ""){ $THEMESTUB = "framework"; }
 

// GET TEMPLATE LAYOUTS
$i=1; $layouts = array();
		$selected_template = $core_admin_values['template']; 
		$HandlePath = TEMPLATEPATH;
		if(substr($HandlePath,-1) != "/"){
		$HandlePath = $HandlePath . "/";
		}
	    $count=1; $TemplateString = "";
		if($handle1 = opendir($HandlePath)) {      
			while(false !== ($file = readdir($handle1))){			 		
				if(strpos($file,"content-listing-".$THEMESTUB) !== false ){ 				
				$file_name = str_replace(".php","",str_replace("content-","",$file)); 
				
				$layouts[] = $file_name;
				}
			 
		} }
 
?> 

 
 
<?php /*
<div class="heading2">Page Design</div> 

<div class="form-row control-group row-fluid">
<label class="control-label span6">Design Layout</label>
<div class="controls span6">
<select name="admin_values[search_layout]" class="chzn-select">
 
<?php $l=1; foreach($layouts as $f){ ?>
<option <?php selected( $core_admin_values['search_layout'], $f );  ?> value="<?php echo $f; ?>" >Layout <?php echo $l; ?></option>
<?php $l++; } ?>
<option></option>
</select>  
</div>                
</div>
*/ ?>
<input type="hidden" name="admin_values[search_layout]" value="<?php echo $layouts[0]; ?>" />







 <div class="heading2">Column Layout</div> 
 


 <div class="fieldbox">

<div class="form-row control-group row-fluid">
<label class="control-label span6">Page Layout</label>
<div class="controls row-fluid span6">
      
            <div class="span3">
            <a href="javascript:void(0);" onclick="document.getElementById('layout_body1').value='1';document.admin_save_form.submit();">
            <img src="<?php echo get_template_directory_uri(); ?>/framework/admin/img/core/l1.png" style="border:1px solid #ccc; padding:4px;background:#fff;<?php if($core_admin_values['layout_columns']['search'] == "1"){ echo "border:2px solid red;";} ?>" />
            </a>
                 
            </div>

            <div class="span3"> 
            <a href="javascript:void(0);" onclick="document.getElementById('layout_body1').value='2';document.admin_save_form.submit();">
            <img src="<?php echo get_template_directory_uri(); ?>/framework/admin/img/core/l2.png" style="border:1px solid #ccc; padding:4px;background:#fff;<?php if($core_admin_values['layout_columns']['search'] == "2"){ echo "border:2px solid red;";} ?>" />
            </a>
            
            </div>

            <div class="span3">   
            <a href="javascript:void(0);" onclick="document.getElementById('layout_body1').value='3';document.admin_save_form.submit();">
            <img src="<?php echo get_template_directory_uri(); ?>/framework/admin/img/core/l3.png" style="border:1px solid #ccc; padding:4px;background:#fff;<?php if($core_admin_values['layout_columns']['search'] == "3"){ echo "border:2px solid red;";} ?>" />
            </a>                               
                
            </div>
            
             <div class="span3">
             <a href="javascript:void(0);" onclick="document.getElementById('layout_body1').value='4';document.admin_save_form.submit();">
            <img src="<?php echo get_template_directory_uri(); ?>/framework/admin/img/core/l4.png" style="border:1px solid #ccc; padding:4px;background:#fff;<?php if($core_admin_values['layout_columns']['search'] == "4"){ echo "border:2px solid red;";} ?>" />
            </a>                             
                
            </div> 
                      
</div>
  <input type="hidden" name="admin_values[layout_columns][search]" id="layout_body1" value="<?php echo $core_admin_values['layout_columns']['search']; ?>" /> 
               
</div>










<div class="form-row control-group row-fluid">
    <label class="control-label span6" for="style">2 Column Width</label>
                <div class="controls span6">
                  <select name="admin_values[layout_columns][search_2columns]" class="chzn-select" id="2stylesearch">
                    <option value=""></option>
                    
                    <option value="0" <?php selected( $core_admin_values['layout_columns']['search_2columns'], 0 ); ?>>
                    363px X 757px</option>
                    
                    <option value="1" <?php selected( $core_admin_values['layout_columns']['search_2columns'], 1 ); ?>>
                    265px X 885px</option>   
                    
                     <option value="2" <?php selected( $core_admin_values['layout_columns']['search_2columns'], 2 ); ?>>
                    300px X 868px</option>                   
                  </select>
                </div>
</div>
<div class="form-row control-group row-fluid" <?php if($core_admin_values['layout_columns']['search'] != "4"){ echo 'style="display:none;"'; } ?>>
                <label class="control-label span6" for="style">3 Column Width</label>
                <div class="controls span4">
                  <select name="admin_values[layout_columns][search_3columns]" class="chzn-select" id="3stylesearch">
                    <option value=""></option>
                    <option value="0" <?php selected( $core_admin_values['layout_columns']['search_3columns'], 0 ); ?>>
                    250px / 500px / 250px </option>
                    <option value="1" <?php selected( $core_admin_values['layout_columns']['search_3columns'],1 ); ?>>
                    150px / 700px / 150px </option>                     
                  </select>
                </div>
</div>

<div class="clearfix"></div>
 


<p>Select the display setup for your search results page and set the column widths.</p>
</div>




 <div class="heading2">Display Options </div> 
 
 

	
   
   
 <div class="fieldbox">
        <div class="form-row control-group row-fluid">
        <label class="control-label span6" for="style">Results Per Page</label>       
        <div class="controls span3 input-append">        
        <input type="text"  name="adminArray[posts_per_page]" class="row-fluid" value="<?php echo get_option('posts_per_page'); ?>">
        <span class="add-on">#</span>        
        </div>
        </div> 
        
      <p>Enter a numerical value for how many items to show per page in search results.</p>
        
</div>



 
 
 
<div class="fieldbox">
    
        <div class="form-row control-group row-fluid">
        <label class="control-label span6" for="style">Default View</label>
        <div class="controls span5">
        <select name="admin_values[display][default_gallery_style]" class="chzn-select" id="default_gallery_style">
          <option value=""></option>
          <option value="grid" <?php if($core_admin_values['display']['default_gallery_style'] == "grid"){ echo "selected=selected"; } ?>>Grid</option>
          <option value="list" <?php if($core_admin_values['display']['default_gallery_style'] == "list"){ echo "selected=selected"; } ?>>List</option> 
     
          <option value="listonly" <?php if($core_admin_values['display']['default_gallery_style'] == "listonly"){ echo "selected=selected"; } ?>>List Only (hide others)</option>
        </select>
        </div>
        </div>  
        
        <div class="form-row control-group row-fluid">
        <label class="control-label span6" for="style">Grid View</label>
        <div class="controls span5">
        <select name="admin_values[default_gallery_perrow]" class="chzn-select" id="default_gallery_perrow">
          <option value=""></option>
          <option value="2" <?php selected( $core_admin_values['default_gallery_perrow'], "2" );  ?>>2 Grid Items Per Row</option>
           <option value="3" <?php selected( $core_admin_values['default_gallery_perrow'], "3" );  ?>>3 Grid Items Per Row</option>
          <option value="4" <?php selected( $core_admin_values['default_gallery_perrow'], "4" );  ?>>4 Grid Items Per Row</option>
          <option value="5" <?php selected( $core_admin_values['default_gallery_perrow'], "5" );  ?>>5 Grid Items Per Row</option>
        </select>
        </div>
        </div>
        
      <p>Select the default display view for search results. </p>
        
</div>
   
   
   
 


   
            
<div class="fieldbox">
       
          <div class="form-row control-group row-fluid ">
                            <label class="control-label span6">Show Small Search Box </label>
                            <div class="controls span5">
                              <div class="row-fluid">
                                <div class="pull-left">
                                  <label class="radio off">
                                  <input type="radio" name="toggle" 
                                  value="off" onchange="document.getElementById('search_searchbar').value='0'">
                                  </label>
                                  <label class="radio on">
                                  <input type="radio" name="toggle"
                                  value="on" onchange="document.getElementById('search_searchbar').value='1'">
                                  </label>
                                  <div class="toggle <?php if($core_admin_values['search_searchbar'] == '1'){  ?>on<?php } ?>">
                                    <div class="yes">ON</div>
                                    <div class="switch"></div>
                                    <div class="no">OFF</div>
                                  </div>
                                </div> 
                               </div>
                             </div>
                             
                             <input type="hidden" class="row-fluid" id="search_searchbar" name="admin_values[search_searchbar]" value="<?php echo $core_admin_values['search_searchbar']; ?>">
            </div>

<p>Turn ON if you want to display a small search box above search results. </p>
     

</div>
            
 
<div class="fieldbox">
       
           <div class="form-row control-group row-fluid ">
                            <label class="control-label span6">Show Sub Categories</label>
                            <div class="controls span5">
                              <div class="row-fluid">
                                <div class="pull-left">
                                  <label class="radio off">
                                  <input type="radio" name="toggle" 
                                  value="off" onchange="document.getElementById('subcategories').value='0'">
                                  </label>
                                  <label class="radio on">
                                  <input type="radio" name="toggle"
                                  value="on" onchange="document.getElementById('subcategories').value='1'">
                                  </label>
                                  <div class="toggle <?php if($core_admin_values['subcategories'] == '1'){  ?>on<?php } ?>">
                                    <div class="yes">ON</div>
                                    <div class="switch"></div>
                                    <div class="no">OFF</div>
                                  </div>
                                </div> 
                               </div>
                             </div>
                             
                             <input type="hidden" class="row-fluid" id="subcategories" name="admin_values[subcategories]" 
                             value="<?php echo $core_admin_values['subcategories']; ?>">
            </div> 
            
            
      <p>Turn ON if you want to display sub categories (if available) above search results</p> 
</div>



<div class="fieldbox">
       
           <div class="form-row control-group row-fluid ">
                            <label class="control-label span6">Rotate 'Top of Category' Listings.</label>
                            <div class="controls span5">
                              <div class="row-fluid">
                                <div class="pull-left">
                                  <label class="radio off">
                                  <input type="radio" name="toggle" 
                                  value="off" onchange="document.getElementById('topofcategoryrotate').value='0'">
                                  </label>
                                  <label class="radio on">
                                  <input type="radio" name="toggle"
                                  value="on" onchange="document.getElementById('topofcategoryrotate').value='1'">
                                  </label>
                                  <div class="toggle <?php if($core_admin_values['topofcategoryrotate'] == '1'){  ?>on<?php } ?>">
                                    <div class="yes">ON</div>
                                    <div class="switch"></div>
                                    <div class="no">OFF</div>
                                  </div>
                                </div> 
                               </div>
                             </div>
                             
                             <input type="hidden" class="row-fluid" id="topofcategoryrotate" name="admin_values[topofcategoryrotate]" 
                             value="<?php echo $core_admin_values['topofcategoryrotate']; ?>">
            </div> 
            
            
      <p>Turn ON if you wish to roatte the top of category listings instead of displaying them in one big list.</p> 
</div>





 <div class="heading2">Order/ Sort By Options</div> 
 
 
 <div class="fieldbox">

<div class="form-row control-group row-fluid ">
                            <label class="control-label span6" rel="tooltip" data-original-title="Turn on/off the sort by box." data-placement="top">Show Sort By Options </label>
                            <div class="controls span5">
                              <div class="row-fluid">
                                <div class="pull-left">
                                  <label class="radio off">
                                  <input type="radio" name="toggle" 
                                  value="off" onchange="document.getElementById('search_sortby').value='0'">
                                  </label>
                                  <label class="radio on">
                                  <input type="radio" name="toggle"
                                  value="on" onchange="document.getElementById('search_sortby').value='1'">
                                  </label>
                                  <div class="toggle <?php if($core_admin_values['search_sortby'] == '1'){  ?>on<?php } ?>">
                                    <div class="yes">ON</div>
                                    <div class="switch"></div>
                                    <div class="no">OFF</div>
                                  </div>
                                </div> 
                               </div>
                             </div>
                             
                             <input type="hidden" class="row-fluid" id="search_sortby" name="admin_values[search_sortby]" value="<?php echo $core_admin_values['search_sortby']; ?>">
            </div>

<p>Turn ON to display 'order by' options on the search results page.</p>    
            
</div>


<div class="fieldbox">

        <div class="form-row control-group row-fluid">
        <label class="control-label span6" for="style">Default Order By</label>
        <div class="controls span5">
        <select name="admin_values[display][orderby]" class="chzn-select" id="default_orderby">
        <option value=""></option>     
        <option value="system" <?php if($core_admin_values['display']['orderby'] == "system"){ echo "selected=selected"; } ?>>System Set (no default order)</option>
        <option value="post_date*desc" <?php if($core_admin_values['display']['orderby'] == "post_date*desc"){ echo "selected=selected"; } ?>>Date (Newest First)</option>
        <option value="post_date*asc" <?php if($core_admin_values['display']['orderby'] == "post_date*asc"){ echo "selected=selected"; } ?>>Date (Newest Last)</option>
        <option value="post_author*asc" <?php if($core_admin_values['display']['orderby'] == "post_author*asc"){ echo "selected=selected"; } ?>>Author (A-z) </option>
        <option value="post_author*desc" <?php if($core_admin_values['display']['orderby'] == "post_author*desc"){ echo "selected=selected"; } ?>>Author (Z-a)</option>
        <option value="post_title*asc" <?php if($core_admin_values['display']['orderby'] == "post_title*asc"){ echo "selected=selected"; } ?>>Listing Title (A-z)</option>
        <option value="post_title*desc" <?php if($core_admin_values['display']['orderby'] == "post_title*desc"){ echo "selected=selected"; } ?>>Listing Title (Z-a)</option>
        <option value="post_modified*asc" <?php if($core_admin_values['display']['orderby'] == "post_modified*asc"){ echo "selected=selected"; } ?>>Date Modified (Newest Last)</option>
        <option value="post_modified*desc" <?php if($core_admin_values['display']['orderby'] == "post_modified*desc"){ echo "selected=selected"; } ?>>Date Modified (Newest First)</option>
        <option value="ID*asc" <?php if($core_admin_values['display']['orderby'] == "ID*asc"){ echo "selected=selected"; } ?>>Wordpress POST ID (0 - 1)</option>
        <option value="ID*desc" <?php if($core_admin_values['display']['orderby'] == "ID*desc"){ echo "selected=selected"; } ?>>Wordpress POST ID (1 - 0)</option>
        
        <option>------------------</option>
         <option value="meta&featured*desc" <?php if($core_admin_values['display']['orderby'] == "meta&featured*desc"){ echo "selected=selected"; } ?>>Featured Listings (top)</option>
        <option value="meta&featured*asc" <?php if($core_admin_values['display']['orderby'] == "meta&featured*asc"){ echo "selected=selected"; } ?>>Featured Listings (bottom)</option>
 
        
        
        <?php if(defined('WLT_IDEAS')){ ?>
        <option value="meta&votes*desc" <?php if($core_admin_values['display']['orderby'] == "meta&votes*desc"){ echo "selected=selected"; } ?>>Votes(hig - low)</option>
        <option value="meta&votes*asc" <?php if($core_admin_values['display']['orderby'] == "meta&votes*asc"){ echo "selected=selected"; } ?>>Votes (low - hig)</option>
        <?php }elseif(defined('WLT_AUCTION')){	?>
          <option value="meta&price_current*desc" <?php if($core_admin_values['display']['orderby'] == "meta&price_current*desc"){ echo "selected=selected"; } ?>>Price (hig - low)</option>
        <option value="meta&price_current*asc" <?php if($core_admin_values['display']['orderby'] == "meta&price_current*asc"){ echo "selected=selected"; } ?>>Price (low - hig)</option>
        <?php }elseif(!defined('DEFAULTS_PRICE_SEARCH') ){ ?>
        <option value="meta&price*desc" <?php if($core_admin_values['display']['orderby'] == "meta&price*desc"){ echo "selected=selected"; } ?>>Price (hig - low)</option>
        <option value="meta&price*asc" <?php if($core_admin_values['display']['orderby'] == "meta&price*asc"){ echo "selected=selected"; } ?>>Price (low - hig)</option>
        <?php } ?>
          </select>
        </div>
        </div>
        
    <p>Select the default display order for search results. </p>
      
        
</div>





 <div class="fieldbox">
     
 <label>Custom Sort By Options</label> 
    
  <p>Here you can create your own orderby options for the search results page.</p>
   
    <textarea class="row-fluid" style="height:200px; font-size:11px;" name="admin_values[orderbydata]"><?php echo stripslashes($core_admin_values['orderbydata']); ?></textarea>  
   
   <p><span class="label label-default"> Format: TEXT [QUERY] </span> <span class="label label-info">Example Code Below:</span></p>
   
   <pre style="margin-top:5px; font-size:10px;">
   Price (low-high)[orderby=price&amp;order=asc]
   Price (high-low)[orderby=price&amp;order=desc]
    </pre>
    
    
</div>
        
        






<div class="heading2">Customized Display Code </div> 

<p style="padding:10px; background:#fff; border:1px dashed green;">Here you can use your own combination of shortcodes and HTML to create your search results layout. </p>

	

          <div class="form-row control-group row-fluid ">
                            <label class="control-label span4"> Enable Custom Display</label>
                            <div class="controls span5">
                              <div class="row-fluid">
                                <div class="pull-left">
                                  <label class="radio off">
                                  <input type="radio" name="toggle" 
                                  value="off" onchange="document.getElementById('customsearch_enable').value='0'">
                                  </label>
                                  <label class="radio on">
                                  <input type="radio" name="toggle"
                                  value="on" onchange="document.getElementById('customsearch_enable').value='1'">
                                  </label>
                                  <div class="toggle <?php if($core_admin_values['customsearch_enable'] == '1'){  ?>on<?php } ?>">
                                    <div class="yes">ON</div>
                                    <div class="switch"></div>
                                    <div class="no">OFF</div>
                                  </div>
                                </div> 
                               </div>
                             </div>
                             
                             <input type="hidden" class="row-fluid" id="customsearch_enable" name="admin_values[customsearch_enable]" 
                             value="<?php echo $core_admin_values['customsearch_enable']; ?>">
            </div> 


<textarea class="row-fluid" id="itemcode" name="admin_values[itemcode]" style="height:300px;background:#E8FDE9;"><?php echo stripslashes($core_admin_values['itemcode']); ?></textarea>
         
            
<input type="hidden" name="customsearchpage" id="customsearchpage" value="" /> 
             <?php if($core_admin_values['content_layout'] != "listing" && $core_admin_values['content_layout'] != ""){ ?>
            <a href="javascript:void(0);" onclick="document.getElementById('customsearchpage').value='content-<?php echo $core_admin_values['content_layout']; ?>';document.admin_save_form.submit();" 
            class="btn btn-default" style="float:right;">Get Codes From Default Layout</a> 
            <?php } ?>
            
 <a href="javascript:void(0);" class="btn btn-info "onclick="jQuery('#spbuts').show();">Show Shortcodes</a>
            
           <div style="display:none;" id="spbuts">
           <hr />
           <a href="javascript:void(0);" onclick="jQuery('#spbuts').hide();" class="label">Hide Shortcodes</a>
           
            <div class='well'>
            
            
			   <?php 
			   
			   global $THEME_SHORTCODES;
			   $btnArray =  $THEME_SHORTCODES->shortcodelist();
			   
			   array(
               'ID' =>'post ID',
               'IMAGE' =>'display image',		   
               'TITLE' =>'title with link to listing page',
               'TITLE-NOLINK' =>'title without link',
               'EXCERPT' =>'short content',
               'BUTTON' =>'more info button',
               'DATE' =>' listing creation date',
               'AUTHOR' =>'author',
               'CATEGORY' =>'category',
               'LISTINGSTATUS' =>'listing status',
               'LOCATION' =>'listing location',
               'AUTHORIMAGE' =>'author image',
               'AUTHORIMAGE-CIRCLE' =>'author image with circular background',
               'TIMESINCE' =>'',
               'RATING' =>'star rating',
               ); 
			   
			 
               foreach( $btnArray as $k => $b){
			   if(isset($b['singleonly'])){ continue; }
			   if(!isset($b['desc'])){ $b['desc'] = ""; }
                echo "<a href='javascript:void(0);' onclick=\"AddthisShortC('".$k."','itemcode');\" class='btn' style='margin-right:10px; margin-bottom:5px;' rel='tooltip' data-original-title='".$b['desc']."' data-placement='bottom'>".$k."</a>";
               }               
               ?>
               
          
           
           </div>
           </div>

 



 