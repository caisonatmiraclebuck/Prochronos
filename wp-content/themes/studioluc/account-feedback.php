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

?>
	<?php if(isset($_GET['fpagen'])){ ?>
    <script>jQuery(document).ready(function() { jQuery('#MyAccountBlock').hide();jQuery('#MyFeedback').show(); });</script>
    <?php } ?>

<div class="panel panel-default" id="MyFeedback" style="display:none;">
        
	<div class="panel-heading"><?php echo $CORE->_e(array('feedback','2')); ?></div>
		 
	<div class="panel-body" id="AuthorSingleFeedback">
 	
    <?php if(!isset($_GET['fdid'])){ ?>
    
	<?php WLT_FeedbackSystem($userdata->ID); ?>
    
    <?php } ?>
    
	<?php if(isset($_GET['fdid']) && is_numeric($_GET['fdid'])){ ?>
          
        <form id="addfeedbackform" name="addfeedbackform" method="post" action="" class="alert" onsubmit="return CHECKFEEDBACK();" style="padding:0px;">         
        <input type="hidden" name="action" value="addfeedback" />         
        <input type="hidden" name="pid" value="<?php echo $_GET['fdid']; ?>" />  
        <script>jQuery(document).ready(function() { jQuery('#MyAccountBlock').hide();jQuery('#MyFeedback').show();jQuery('#MyFeedbackList').hide(); });</script>
        
        <script language="javascript" type="text/javascript">

		function CHECKFEEDBACK()
		{ 
 		
			var f1 	= document.getElementById("fd1"); 
			var f2 	= document.getElementById("fd2");
			  			
			if(f1.value == '')
			{
				alert('<?php echo $CORE->_e(array('validate','0')); ?>');
				f1.focus();
				f1.style.border = 'thin solid red';
				return false;
			}
			if(f2.value == '')
			{
				alert('<?php echo $CORE->_e(array('validate','0')); ?>');
				f2.focus();
				f2.style.border = 'thin solid red';
				return false;
			} 		   		
			
			return true;
		}
 
    	</script>   
            
        <h3><?php echo $CORE->_e(array('feedback','1')); ?></h3> 
                
        <p><?php echo $CORE->_e(array('feedback','14')); ?></p>  
                    
        <hr /> 
        
        <?php if($CORE->FEEDBACKEXISTS($_GET['fdid'], $userdata->ID) == true){  ?>         
        
        <div class="text-center alert alert-info">
        
        <h4><?php echo $CORE->_e(array('feedback','15')); ?></h4>
        <p><?php echo $CORE->_e(array('feedback','16')); ?></p>
        
        </div>
        
        <?php }else{ ?>
            
              <div class="form-group">
			  <label><?php echo $CORE->_e(array('feedback','17')); ?></label>
              <input type="text" name="subject" id="fd1" value="<?php if(isset($_POST['subject'])){ echo strip_tags(strip_tags($_POST['subject'])); } ?>" class="form-control" >
              </div>
              
              <div class="form-group">
              <label><?php echo $CORE->_e(array('feedback','18')); ?></label>
              <textarea id="fd2" rows="3" class="form-control"  style="height:200px;" name="message"><?php if(isset($_POST['message'])){ echo strip_tags(strip_tags($_POST['message'])); } ?></textarea>               
              </div>
              
              <hr />
              
              
              <div class="col-md-4">
              <?php echo $CORE->_e(array('feedback','19')); ?>
              </div>
              
              <div class="col-md-6">
              
              <script type='text/javascript'>jQuery(document).ready(function(){ 
				jQuery('#wlt_feedbackstar_00').raty({				 
				path: '<?php echo FRAMREWORK_URI; ?>img/rating/',
				score: 5,
				size: 24, 
				 
				}); }); </script> 
		 		
				<div id="wlt_feedbackstar_00" class="wlt_starrating"></div>
              </div>
              
              <div class="clearfix"></div>
              
              <hr />  
                 
             <button class="btn btn-lg btn-warning" type="submit"><?php echo $CORE->_e(array('feedback','20')); ?></button>
         <?php } ?>
         
         </form> 
         <?php } ?> 
      
       
	</div>     

</div>