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
  
?> 

<div class="heading2">

  <a data-toggle="modal" href="#VideoModelBox" class="btn btn-warning youtube" onclick="PlayPPTVideo('ff0sStPqJVs','videoboxplayer','479','350');">Watch Video</a>
            
Page &amp; Button Links</div>
  

     	
         
     	 
        
             <div class="well" style="font-size:12px;padding:10px;">
              <p>The theme has a number of <a href="http://codex.wordpress.org/Pages" target="_blank" style="text-decoration:underline;">page templates</a> such as the 'account area' and 'add listing' pages which need to created first before button links will work.</p>
               First <a href="edit.php?post_type=page" style="text-decoration:underline;">create a new page</a> for each of the fields below, assign the correct page template then select the link to the newly created page below. 
             </div>
      		
            <?php
			
			$default_page_links = array(
			"myaccount" => array("name" => "My Account"),
			"callback" => array("name" => "Callback"),
			"add" => array("name" => "Add Listing"),
			"contact" => array("name" => "Contact Form"),
			"blog" => array("name" => "Blog"),
			"sellspace" => array("name" => "Advertising Page"),
			);
			$default_page_links = hook_admin_1_tab1_subtab2_pagelist($default_page_links);
			
			$pages = get_pages();  foreach($default_page_links as $k=>$v){ ?>         
            <!------------ FIELD -------------->          
            <div class="form-row control-group row-fluid" id="myaccount_page_select">
            <label class="control-label span4" for="normal-field">        
            <?php if(!isset($core_admin_values['links'][$k]) || $core_admin_values['links'][$k] == ""){ ?><img src="<?php echo get_template_directory_uri(); ?>/framework/admin/img/no.png"><?php } ?> 
            <?php echo $v['name']; ?>  </label>
            <div class="controls span8">             
            <select data-placeholder="Choose a page..." class="chzn-select" name="admin_values[links][<?php echo $k; ?>]">
            <option></option>
            <?php foreach ( $pages as $page ) {      
            $link = get_page_link( $page->ID );
			
			if(isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] == "on") { 
			$link = str_replace("http://","https://",$link);
			}
            $option = '<option value="'. $link.'"';
            if(isset($core_admin_values['links']) && $core_admin_values['links'][$k] == $link){ $option .= " selected=selected "; } 
            $option .= '>';
            $option .= $page->post_title;
            $option .= '</option>';
            echo $option;
            } ?>
          </select></div></div>
          <!------------ END FIELD -------------->  
        <?php } // end foreach  ?>
		

        
        <div style="height:250px;">&nbsp;</div>
     