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

// GET CORE EMAILS
$wlt_emails = get_option("wlt_emails");  
 
		 
		 // update_option("wlt_emails","");
		if(is_array($wlt_emails) && count($wlt_emails) > 0 ){  ?>
        
        
            <table id="datatable_example" class="responsive table table-striped table-bordered" style="width:100%;margin-bottom:0; ">
            <thead>
            <tr>
              <th class="no_sort">Subject </th>
                            
              <th class="no_sort" style="width:110px;text-align:center;">Actions</th>
              
            </thead>
            <tbody>
            
            <script>
			
			function setemailcontent(div){
			
				jQuery('#message').val(jQuery('#'+div).val());
				tinyMCE.activeEditor.setContent(jQuery('#'+div).val());
			
			}
			function setemailsubject(div){
			
				jQuery('#esubject').val(jQuery('#'+div).val());
				
			
			}
			</script>
			
            
        <?php
 	  
		foreach($wlt_emails as $key=>$field){ ?>
		<tr>
         <td><?php echo stripslashes($field['subject']); ?></td>         
        
         <td class="ms" style="width:150px;">
         <center>
                <div class="btn-group1">
                  <a class="btn btn-small" rel="tooltip" 
                  href="admin.php?page=3&edit_email=<?php echo $key; ?>"
                  data-placement="left" data-original-title=" edit "><i class="gicon-edit"></i></a>                   
                  <a class="btn btn-inverse btn-small confirm" rel="tooltip" data-placement="bottom" 
                  data-original-title="Remove"
                  href="admin.php?page=3&delete_email=<?php echo $key; ?>"
                  ><i class="gicon-remove icon-white"></i></a> 
                  
                    <a class="btn btn-warning btn-small" rel="tooltip" data-placement="bottom" 
                  data-original-title="Send Test Email"
                  data-toggle="modal" href="#TestEmailModal" onclick="setemailsubject('<?php echo "tsmail_".$key; ?>');setemailcontent('<?php echo "temail_".$key; ?>')"
                  ><i class="gicon-envelope icon-white"></i></a> 
                  
                  <textarea style="display:none;" id="temail_<?php echo $key; ?>"><?php echo stripslashes($field['message']); ?></textarea>
                  <textarea style="display:none;" id="tsmail_<?php echo $key; ?>"><?php echo stripslashes($field['subject']); ?></textarea>
                  
                   
                  
                </div>
            </center>
            </td>
            </tr>
            <?php  }   ?> 
 
            </tbody>
            </table>
            
         <?php } ?>   
         
         
<div class="well" style="text-align:center;margin-top:40px;">	
 
 <a href="admin.php?page=3&et=1" class="alertme btn btn-default" >Install Sample Email Templates</a> 
<div class="clearfix"></div>
</div>     