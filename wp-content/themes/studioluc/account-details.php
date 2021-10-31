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

global $CORE, $userdata;

	
	// USER COUNTRY
	$selected_country = get_user_meta($userdata->ID,'country',true);
	if($selected_country == ""){
		$selected_country = $GLOBALS['CORE_THEME']['account_usercountry'];
	}
	
	// GET PROFILE BG STYLE
	$pbg = get_user_meta($userdata->ID,'pbg',true);

?>
<div class="panel panel-default" id="MyDetailsBlock" style="display:none;">

	<div class="panel-heading"><?php echo $CORE->_e(array('account','2')); ?></div>
		 
		<div class="panel-body">
       
		<form action="" method="post" onsubmit="return ValidateCoreRegFields();" enctype="multipart/form-data" id="myaccountdataform" name="myaccountdataform">
		<input type="hidden" name="action" value="update" />
        
        <h4><?php echo $CORE->_e(array('account','2')); ?></h4>
        
        <hr />
		 
            <div class="col-md-6">
            	
                <?php if(!isset($GLOBALS['CORE_THEME']['show_account_names']) || (isset($GLOBALS['CORE_THEME']['show_account_names']) && $GLOBALS['CORE_THEME']['show_account_names'] == 1 )){ ?>
            	<div class="form-group">
                    <label class="control-label"><i class="icon-user"></i> <?php echo $CORE->_e(array('checkout','35')); ?></label>
                    <div class="controls">
                        <input type="text" name="fname" class="form-control" value="<?php echo $userdata->first_name ?>">                         
                    </div>
                </div>
                <?php } ?>
            
                <div class="form-group">
                    <label class="control-label"><i class="icon-envelope"></i> <?php echo $CORE->_e(array('account','9')); ?></label>
                    <div class="controls">
                        <input type="text" name="email" class="form-control" value="<?php echo $userdata->user_email; ?>" disabled="disabled">                         
                    </div>
                </div>		 
                
                <div class="form-group">
                    <label class="control-label"><i class="icon-globe"></i> <?php echo $CORE->_e(array('account','14')); ?></label>
                    <div class="controls">
                        <input type="text" name="url" class="form-control" value="<?php echo get_user_meta($userdata->ID,'url',true); ?>">                       
                    </div>
                </div>
                
                <div class="form-group">
                    <label class="control-label"><i class="icon-bell"></i> <?php echo $CORE->_e(array('account','41')); ?></label>
                    <div class="controls">
                        <input type="text" name="phone" class="form-control" value="<?php echo get_user_meta($userdata->ID,'phone',true); ?>">                        
                    </div>
                </div>          
                
				 <div class="form-group">
                    <label class="control-label"><?php echo $CORE->_e(array('checkout','39')); ?></label>
                    <div class="controls">
                        <select name="country" class="form-control" >
                        <?php 
		 
						foreach($GLOBALS['core_country_list'] as $key=>$value){
								if(isset($selected_country) && $selected_country == $key){ $sel ="selected=selected"; }else{ $sel =""; }
								echo "<option ".$sel." value='".$key."'>".$value."</option>";} ?>
                        </select>                       
                    </div>
                </div>
                        
            </div> 
            
            <div class="col-md-6">
            
            	<?php if(!isset($GLOBALS['CORE_THEME']['show_account_names']) || (isset($GLOBALS['CORE_THEME']['show_account_names'])  && $GLOBALS['CORE_THEME']['show_account_names'] == 1 )){ ?>
               <div class="form-group">
                    <label class="control-label"> <?php echo $CORE->_e(array('checkout','36')); ?></label>
                    <div class="controls">
                        <input type="text" name="lname" class="form-control"  value="<?php echo $userdata->last_name ?>" >                         
                    </div>
                </div>
                <?php } ?>               
            
                <div class="bs-callout bs-callout-warning">
                
                <div class="form-group">
                    <label class="control-label"><i class="icon-lock"></i> <?php echo $CORE->_e(array('account','10')); ?></label>
                    <div class="controls">
                        <input type="password" name="password" class="form-control">
                       
                    </div>
                </div>
                
                <div class="form-group">
                    <label class="control-label"><i class="icon-lock"></i> <?php echo $CORE->_e(array('account','11')); ?></label>
                    <div class="controls">
                        <input type="password" name="password_r" class="form-control">                        
                    </div>
                </div>
                
                </div>
               
                <?php echo 
				str_replace("form-row row customfield","form-group", 
				str_replace("control-label col-md-3","control-label", 
				str_replace("field_wrapper col-md-9","controls",  $CORE->CORE_FIELDS(true)))); ?>            
            
            </div>
         
          
             <div class="col-md-12">
                    <label class="control-label"><i class="icon-comment"></i> <?php echo $CORE->_e(array('account','13')); ?></label>
                   <textarea style="height:120px;" class="form-control" name="description"><?php echo stripslashes($userdata->description); ?></textarea>                     
             </div>
 
            
        <div class="clearfix"></div>
        <?php if(isset($GLOBALS['CORE_THEME']['show_account_social']) && $GLOBALS['CORE_THEME']['show_account_social'] == '1'){ ?>
        
        <hr />
        
        <h4><?php echo $CORE->_e(array('account','86')); ?></h4>
        
        <hr />
        <div class="col-md-3">
        <label class="control-label"><i class="icon-comment"></i> Facebook</label>
        <input type="text" name="facebook" class="form-control" value="<?php echo get_user_meta($userdata->ID,'facebook',true); ?>">                   
        </div>
        <div class="col-md-3">
        <label class="control-label"><i class="icon-comment"></i> Twitter</label>
        <input type="text" name="twitter" class="form-control" value="<?php echo get_user_meta($userdata->ID,'twitter',true); ?>">                   
        </div>
        <div class="col-md-3">
        <label class="control-label"><i class="icon-comment"></i> LinkedIn</label>
        <input type="text" name="linkedin" class="form-control" value="<?php echo get_user_meta($userdata->ID,'linkedin',true); ?>">                   
        </div>
        <div class="col-md-3">
        <label class="control-label"><i class="icon-comment"></i> Skype</label>
        <input type="text" name="skype" class="form-control" value="<?php echo get_user_meta($userdata->ID,'skype',true); ?>">                   
        </div>
        <?php } ?>
        
        
        <div class="clearfix"></div>
        
        <hr />
        
         <?php if($GLOBALS['CORE_THEME']['show_profilelinks'] == 1){ ?>
         
        <h4><?php echo $CORE->_e(array('account','85')); ?></h4>
        
        <hr />
        <div id="bgp">
        <?php $i=1; while($i < 9){ ?>
        <div class="col-md-3">
        	
            <div class="thumbnail" onclick="jQuery('#pbg').val('<?php echo $i; ?>'); ChangeB(); jQuery(this).css('border-color','rgb(165, 194, 165)').css('background','rgb(246, 255, 246)'); " style="cursor:pointer; <?php if($pbg == $i){ echo "border:1px solid red"; } ?>">
            
            	<img src="<?php echo FRAMREWORK_URI; ?>/img/profile/<?php echo $i; ?>.jpg" class="img-responsive" />
            
            </div>
                         
        </div>
        <?php $i++; } ?>
        </div>
        
        <input type="hidden" id="pbg" name="pbg" value="<?php  if($pbg == ""){ echo 1; }else{ echo $pbg; } ?>" />
        
        <script>		
		function ChangeB(){		
			jQuery( "#bgp .thumbnail" ).each(function() {
				jQuery(this).css('border-color','#ddd').css('background','#fff').css('border-width','5px');
				
			});
			
		}
		</script>
        
        <?php } ?>
       
                
        <div class="clearfix"></div>
        
        <?php // USER PHOTO INTEGRATION
        if(function_exists('userphoto')){ ?>
                 
                <div class="col-md-12" style="margin-top:20px;">
                <style>#userphoto th { display:none; } .field-hint { font-size:11px; }</style>
                <?php 
                userphoto_display_selector_fieldset();
                userphoto_thumbnail($userdata->ID);	
				echo '<label><input type="checkbox" name="userphoto_delete" id="userphoto_delete" onclick="userphoto_onclick()"> Delete photo?</label> </div>';	
        
		 }elseif( isset($GLOBALS['CORE_THEME']['show_account_photo']) && $GLOBALS['CORE_THEME']['show_account_photo'] == '1'  ){
							
         ?> 
        
        <hr />
        
        <h4><?php echo $CORE->_e(array('account','79')); ?></h4>
        
        <hr />
        
        <div class="col-md-6">
        <div class="well text-center">       
        <?php echo get_avatar( $userdata->ID, 180 ); ?>
        </div>
        </div>
        
        <div class="col-md-6">
        
        <input type="file" name="wlt_userphoto" />
        </div>
        <div class="clearfix"></div>
        <?php } // end built in user photo ?>
        
        <?php echo hook_account_mydetails_after(); ?>	
		 
		<div class="clearfix"></div>
        <hr />
        
		<div class="text-center">
        	<button class="btn btn-primary btn-lg" type="submit"><?php echo $CORE->_e(array('button','6')); ?></button>
        </div>
		 
		   
		</form> 
	 
		 
	</div>
		 
</div>