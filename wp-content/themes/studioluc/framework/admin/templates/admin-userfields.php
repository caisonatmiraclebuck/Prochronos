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

global $wpdb, $CORE, $userdata, $CORE_ADMIN;

// LOAD IN MAIN DEFAULTS 
$core_admin_values = get_option("core_admin_values");  
  
?> 

 

 <a data-toggle="modal" href="<?php echo get_home_url(); ?>/wp-admin/admin.php?page=1#myModal" class="btn btn-success" style="float:right;">Add New Field</a>
            
<div class="heading2">Fields</div>
        
      
       
 		<?php 
		
		$regfields = get_option("regfields");
		if(is_array($regfields) && count($regfields) > 0 ){  ?>
        
        
            <table id="datatable_example" class="responsive table table-striped table-bordered" style="width:100%;margin-bottom:0; ">
            <thead>
            <tr>
              <th class="no_sort">Description</th>
              <th class="no_sort" style="width:110px;text-align:center;">Required?</th>
              <th class="no_sort" style="width:110px;text-align:center;">Editable?</th>
              <th class="no_sort" style="width:110px;text-align:center;">Actions</th>
              
            </thead>
            <tbody>
            
        <?php 		
		//PUT IN CORRECT ORDER
		$ordered_regfields = $CORE->multisort( $regfields , array('order') ); 
		$a = 0; foreach($ordered_regfields as $key=>$field){ ?>
		<tr>
         <td><?php echo stripslashes($field['name']); ?></td>         
         <td><center><span class="label label-<?php echo $field['required']; ?>"><?php echo $field['required']; ?></span></center></td>
         <td><center><span class="label label-<?php echo $field['display_profile']; ?>"><?php echo $field['display_profile']; ?></span></center></td>
         <td class="ms">
         <center>
                <div class="btn-group1">
                  <a class="btn btn-small" rel="tooltip" 
                  href="admin.php?page=1&edit_reg_field=<?php echo $CORE->multisortkey($regfields, 'key', $field['key']); ?>"
                  data-placement="left" data-original-title=" edit "><i class="gicon-edit"></i></a>                   
                  <a class="btn btn-inverse btn-small confirm" rel="tooltip" data-placement="bottom" 
                  data-original-title="Remove"
                  href="admin.php?page=1&delete_reg_field=<?php echo $CORE->multisortkey($regfields, 'key', $field['key']); ?>"
                  ><i class="gicon-remove icon-white"></i></a> 
                </div>
            </center>
            </td>
            </tr>
            <?php  $a++; }   ?>
            
            <?php do_action('hook_admin_1_tab2_left'); ?> 
            
            </tbody>
            </table>
            
         <?php } ?>
 