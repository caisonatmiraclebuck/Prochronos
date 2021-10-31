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
<div class="panel panel-default" id="MyMsgBlock" <?php if(isset($_GET['tab']) && $_GET['tab'] == "msg"){ }else{ ?>style="display:none;"<?php } ?>>
        		 
	<div class="panel-heading"><?php echo $CORE->_e(array('account','26')); ?></div>
		 
            <div class="panel-body"> 
             
              <div id="msgAjax"></div> 
              <form id="sendmsgform" name="sendmsgform" method="post" action="" class="alert" <?php if(isset($_GET['tab']) && $_GET['tab'] == "msg" && isset($_GET['show'])){ }else{ ?>style="display:none;"<?php } ?>>
              <input type="hidden" name="action" value="sendmsg" />
              
              <a href="#top" class="label label-warning" style="float:right;margin-top:30px;" onclick="jQuery('#sendmsgform').hide();"><?php echo $CORE->_e(array('account','48')); ?></a>
             
              <h3><?php echo $CORE->_e(array('account','29')); ?></h3>
             
              <p><?php echo $CORE->_e(array('account','30')); ?></p>
              
              <hr />
              
        	 <div class="input-group">
                  <span class="input-group-addon" id="ajaxMsgUser">@</span>
                  <input class="form-control" name="username" id="usernamefield" type="text" placeholder="<?php echo $CORE->_e(array('account','31','flag_noedit')); ?>"  value="<?php 
				  if(isset($_GET['u'])){				  
					  if(is_numeric($_GET['u'])){
						$muser = get_userdata($_GET['u'] );						 
						echo $muser->user_login;
					  }else{
						 echo strip_tags($_GET['u']);
					  }
				   } ?>">
              </div>
              <script type="application/javascript"> 
					jQuery('#usernamefield').change(function() { WLTValidateUsername('<?php echo str_replace("http://","",get_home_url()); ?>', this.value, 'ajaxMsgUser')  } );					
			  </script>
			  <hr />
              
              <div class="form-group">
			  <label><?php echo $CORE->_e(array('account','32')); ?></label>
              <input type="text" name="subject" id="subjectfield" value="<?php if(isset($_POST['subject'])){ echo strip_tags(strip_tags($_POST['subject'])); } ?>" class="form-control" >
              </div>
              
              <div class="form-group">
              <label><?php echo $CORE->_e(array('account','33')); ?></label>
              <textarea id="sendMsgContent" rows="3" class="form-control"  style="height:280px;" name="message"><?php if(isset($_POST['message'])){ echo strip_tags(strip_tags($_POST['message'])); } ?></textarea>               
              </div>
              
              <button class="btn btn-warning"><?php echo $CORE->_e(array('account','34')); ?></button>
              </form>
                
                
              <form method="post" action="" id="messageDel" name="messageDel">
              <input type="hidden" name="action" value="deletemsg" />
              <input type="hidden" name="messageID" id="messageID" value="" />
              </form>
              
              <form method="post" action="">
              <input type="hidden" name="action" value="deletemsgs" />
                <table class="table table-bordered table-striped">
         
                <thead>
                  <tr>
                  <th></th>
                    <th <?php if(!defined('IS_MOBILEVIEW')){ ?>style="width:80px;"<?php } ?>><?php echo $CORE->_e(array('account','35')); ?></th>
                    <th <?php if(!defined('IS_MOBILEVIEW')){ ?>style="min-width:380px;"<?php } ?>><?php echo $CORE->_e(array('account','36')); ?></th>
                    <th class="text-center"><?php echo $CORE->_e(array('account','37')); ?></th>
                  </tr>
                </thead>
                <tbody>
                <?php echo $CORE->MESSAGELIST($userdata->user_login); ?>
                  
                </tbody>
              </table>
              <div class="selectionbox">
            
              <button type="submit" class="pull-right"><?php echo $CORE->_e(array('account','84')); ?></button>
              <input type="checkbox" id="selecctall"/>  <?php echo $CORE->_e(array('account','83')); ?>
              
              </div>
              
              </form>
              
              <script>
			  jQuery(document).ready(function() {
					jQuery('#selecctall').click(function(event) {  //on click 
						if(this.checked) { // check select status
							jQuery('.checkbox1').each(function() { //loop through each checkbox
								this.checked = true;  //select all checkboxes with class "checkbox1"               
							});
						}else{
							jQuery('.checkbox1').each(function() { //loop through each checkbox
								this.checked = false; //deselect all checkboxes with class "checkbox1"                       
							});         
						}
					});
					
				});
			  </script>
              
            <hr />              
              
                       
            	 
		<div class="text-center">
        	 <a href="#top" class="btn btn-primary btn-lg" onclick="jQuery('#sendmsgform').show();"><?php echo $CORE->_e(array('account','38')); ?></a> 
        </div>
            
	</div> 
        
</div>  