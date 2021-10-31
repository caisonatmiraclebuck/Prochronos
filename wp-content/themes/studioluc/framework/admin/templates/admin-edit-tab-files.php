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
if (!defined('THEME_VERSION')) {	header('HTTP/1.0 403 Forbidden'); exit; } global $CORE_ADMIN, $CORE, $MEDIA, $post;

// LOAD IN MEDIA ELEMENTS
wp_enqueue_script('video', FRAMREWORK_URI.'player/mediaelement-and-player.min.js');
wp_enqueue_script('video');

// LOAD IN MAIN DEFAULTS 
$core_admin_values = get_option("core_admin_values");  
  
?> 

<div id="deletefilediv"></div>


<?php if(isset($_GET['action']) ){ ?>

 
<?php

$f = 1;
$allmedia = $MEDIA->_GET($post->ID, "all");
foreach($allmedia as $media){
 
if(is_array($CORE->allowed_music_types) && in_array($media['type'],$CORE->allowed_music_types)){
						
						$media_display = ''.$media['name'];
					 
						$media_display .= '<audio id="audio_id_'.$media['id'].'" width="200" height="150" controls="controls" preload="none"><source type="'.$media['type'].'" src="'.$media['src'].'" /></audio>';
						 
}elseif(is_array($CORE->allowed_video_types) && in_array($media['type'],$CORE->allowed_video_types)){
							 
						$media_display = '<video id="video_id_'.$media['id'].'"  width="200" height="150" controls="controls" preload="none">
						<source type="'.$media['type'].'" src="'.$media['src'].'" /> 
						<object width="100%" height="300" style="width: 100%; height: 100%;" type="application/x-shockwave-flash" data="'.get_template_directory_uri().'/framework/slider/flashmediaelement.swf">
							<param name="movie" value="'.get_template_directory_uri().'/framework/slider/flashmediaelement.swf" />
							<param name="flashvars" value="controls=true&file='.$media['src'].'" />							 
							<img src="'.$media['src'].'"  title="No video playback capabilities" />
						</object>
						</video>';
						
}elseif(is_array($CORE->allowed_doc_types) && in_array($media['type'],$CORE->allowed_doc_types)){
						
						$media_display = "";				
						if( $media['type'] == "application/octet-stream"){
						$media_display .= '<img src="'.FRAMREWORK_URI.'img/icons/compress_small.png" alt="zip"> ';
						}elseif($media['type'] == "application/pdf"){		
						$media_display .= '<img src="'.FRAMREWORK_URI.'img/icons/pdf_small.png" alt="pdf"> ';
						}elseif($media['type'] == "application/msword"){		
						$media_display .= '<img src="'.FRAMREWORK_URI.'img/icons/doc_small.png" alt="doc"> ';
						}
						
						$media_display .= '<a href="'.$media['src'].'" target="_blank">'.$media['name'].'</a>';	
						
}elseif(is_array($CORE->allowed_image_types) && in_array($media['type'],$CORE->allowed_image_types)){

	if(file_exists($media['thumbnail'])){
	$media_display = '<a href="'.$media['src'].'" data-gal="prettyPhoto[ppt_gal]"><img src="'.$media['thumbnail'].'" alt="'.$media['name'].'" style="max-width:200px;" /></a>';	
	}else{
	$media_display = '<a href="'.$media['src'].'" data-gal="prettyPhoto[ppt_gal]"><img src="'.$media['src'].'" alt="'.$media['name'].'" style="max-width:200px;" /></a>';	
	}
	  
							
					 
}
 
?>

<div style=" overflow:hidden; margin-right:10px; margin-bottom:10px;  float:left;" id="mediaid<?php echo $media['id']; ?>">

    <div  style="height:150px; width:200px; background:#000;"> 
    
    <?php echo $media_display;  ?>
    
    </div>
    <div style="height:40px; width:200px; background:#0BAB68; width:100%; text-align:center; line-height:40px; position:relative;">
    
        <a href="post.php?post=<?php echo $media['id']; ?>&action=edit" target="_blank" style="color:#fff;">Edit File</a> |  
    
        <a href="javascript:void(0);" onclick="setdeleteattachment('<?php echo $media['id']; ?>');" style="color:#fff;">Delete File</a> 
    
    </div> 

</div>
<?php $f++; } ?>
 
 
<div class="clear"></div>

 
<script>

jQuery(document).ready(function(){  
	jQuery('video, audio').mediaelementplayer();
});

function setdeleteattachment(fileid){

	jQuery('#mediaid' + fileid).hide();

	jQuery( "#deletefilediv" ).append( "<div class='updated below-h2'><b class='label'>Remeber</b> to save changes after deleting files.</div><input type='hidden' name='wlt_attachdelete[]' value='"+fileid+"'>" );
}
</script>
<?php } ?>

<input name="wlt_attachfile[]" type="file" /><br />
<input name="wlt_attachfile[]" type="file" /><br />
<input name="wlt_attachfile[]" type="file" /><br />
<input name="wlt_attachfile[]" type="file" /><br />
<input name="wlt_attachfile[]" type="file" /><br /> 


<?php if(isset($_GET['mediaonly'])){ ?>
<input type="hidden" name="smalleditor" value="1" />
<input type="hidden" name="mediaonly" value="1" />
<?php } ?>

<hr />

<input name="save" type="submit" class="button button-primary button-large" id="publish" accesskey="p" value="Save Changes" style="margin-top:10px;">   
