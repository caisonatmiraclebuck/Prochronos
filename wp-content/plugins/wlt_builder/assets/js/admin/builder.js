function showcolbox(div){
		jQuery('#'+div).toggle();	
} 
 
/*
$parent is actually parent div of the element 
$parent_container is where it is cloned
*/
;(function ( $, window, document, undefined ) {
	"use strict";
	
	var pluginName = 'PT_Builder';
	var THIS; /* main instance holder */
	var $THIS; /* main jQuery instance */
	
	function PT_Builder( element, options ) {
		$('#publish').data('locked','1');
		$('#save-post').data('locked','1');
		THIS = this;
		THIS._showLoader();
		$THIS = $(this);
		THIS.shortcodes = {};
		THIS.element = element;
		THIS.$element = $(element);
		THIS.init();
		THIS.$builderWrapper = $('.pt-builder-content');
		THIS.$dialog = $('#pt-dialog');
		THIS._initVisual();
		THIS.dialogDefaultOptions = {
			open: function() {
				var $this = $(this);
				$this.parents('.ui-dialog').prev().click(function() { 
					$this.dialog( "destroy" ); 
				});

				$('.ui-dialog-buttonset button').addClass( 'pt-button' );
			},			
			resizable: false,
			close: function() {
				$(this).dialog('destroy');
			},
			closeOnEscape: true,
			modal: true,
			width: 850,
			//height: 800
		};
	}
	
	PT_Builder.prototype = {
		_getContent: function(){
		    if ( typeof tinyMCE !== 'undefined' && tinyMCE.get('content') && $("#wp-content-wrap").hasClass("tmce-active") ){
		        return tinyMCE.get('content').getContent();
		    }else{
		        return $('#content').val();
		    }
	    },
	    _initVisual: function() {	    	
	    	THIS.content = THIS._getContent();
			THIS.shortcodes = THIS._contentParser( {}, this.content, 0 );			
			if( !_.isEmpty( THIS.shortcodes ) ){
				THIS._buildVisual();
			}
			else{
				THIS._hideLoader();
				jQuery('#nobtxt').show();
				jQuery('.pt-main-actions').hide();
			}
	    },
		init: function(){
			THIS.$element.append('<div class="pt-builder-wrapper"> '+
								
									'<div class="pt-main-actions clearfix">'+
				 
										
										'<div class="right">' +
										'<a href="javascript:;" class="button pt-export">Export Data</a>'+
										'<a href="javascript:;" class="button pt-css">CSS</span></a>'+
										'<a href="javascript:;" class="button pt-preview">Preview</a>'+
										'<a href="javascript:;" class="button button-primary pt-save"></a></div>'+										
									'</div>'+
									'<div class="pt-builder-content"></div>'+'<p id="nobtxt" style="display:none; margin-top:50px; font-size: 24px;    font-weight: 300;    margin-bottom: 40px;">You have <span>no content yet.</span><br>Start by adding a <b>section</b> or load a <b> prebuilt </b>layout.</p>'+
										'<a href="javascript:;" class="button pt-add-newsection btn-add-action" data-contain_shortcode_element="PT_Section">Add Section</a> <a href="javascript:;" class="button pt-template">Prebuilt Layout</a>'+
										'<div id="pt-dialog"></div>'+
									'</div>'+
								  '</div>');
			
			
			
			/* DISABLE CLASS OF THE PT BUILDER CONTAINER WHEN ADDING NEW LINK */
			$(document).on( 'click', '.mce-btn button', function(){
				if( $(this).find('.mce-i-link').length > 0 ){					
					THIS.$dialog.removeClass( 'ui-dialog-content ui-widget-content' );
				}
			});
			$(document).on( 'click', '#wp-link-close, #wp-link-backdrop, #wp-link-submit, #wp-link-cancel a', function(){
				THIS.$dialog.addClass( 'ui-dialog-content ui-widget-content' );
			});
			
			/* IMPORT TEMPLATE*/
			$(document).on( 'click', '.pt-import-template', function(e){
				e.preventDefault();
				THIS._showLoader();
				$.ajax({
					url: ajaxurl,
					data: {
						action: 'pt_import_template'
					},
					method: "POST",
					success: function(response) {
						THIS.$dialog.html(response);
						var dialogOptions = {
							title: 'Import Template Data'
						};
						$.extend( dialogOptions, THIS.dialogDefaultOptions, dialogOptions );
						THIS.$dialog.dialog(dialogOptions);
					},
					error: function() {},
					complete: function() {
						THIS._hideLoader();
					}
				});
			});
			
			
			
			/* GET TEMPLATES LIST */
			$(document).on( 'click', '.pt-template', function(e){
				e.preventDefault();
				THIS._showLoader();
				$.ajax({
					url: ajaxurl,
					data: {
						action: 'pt_get_templates'
					},
					method: "POST",
					success: function(response) {
						THIS.$dialog.html(response);
						var dialogOptions = {
							title: 'Templates'
						};
						$.extend( dialogOptions, THIS.dialogDefaultOptions, dialogOptions );
						THIS.$dialog.dialog(dialogOptions);
					},
					error: function() {},
					complete: function() {
						THIS._hideLoader();
					}
				});
			});
			
			
			
			
			
			/* HANDE EXPORT TEMPLATES */			
			$(document).on( 'click', '.pt-export', function(e){
				e.preventDefault();
				THIS._showLoader();
				 
				$.ajax({
					url: ajaxurl,
					data: {
						action: 'pt_export_template',
						template_data: THIS._shortcodeContent( true ),
					},
					method: "POST",
					success: function(response) {
						THIS.$dialog.html(response);
						var dialogOptions = {
							title: 'Export Template Code'
						};
						$.extend( dialogOptions, THIS.dialogDefaultOptions, dialogOptions );
						THIS.$dialog.dialog(dialogOptions);
					},
					error: function() {},
					complete: function() {
						THIS._hideLoader();
					}
				});
			});
			
			/* HANDE SAVING TEMPLATES */			
			$(document).on( 'click', '.pt-save-import-template', function(e){
				e.preventDefault();
				THIS._setContent();

				var template_title = $('.import-title').val();
				if( _.isEmpty( template_title ) ){
					alert( 'Template title can not be empty' );
					return false;
				}

				var template_content = $('.import-data').val();
				if( _.isEmpty( template_content ) ){
					alert( 'Content is empty nothing to save' );
					return false;
				}
 

				THIS._showLoader();
				$.ajax({
					url: ajaxurl,
					data: {
						action: 'pt_save_template',
						template_title: template_title,
						template_content: template_content
					},
					method: "POST",
					success: function(response) {
						THIS._hideLoader();
						alert( 'Template data saved successfully!' );
					},
					error: function() {},
					complete: function() {
						THIS._hideLoader();
					}
				});
			});	

			/* HANDE SAVING TEMPLATES */			
			$(document).on( 'click', '.pt-save-template', function(e){
				e.preventDefault();
				THIS._setContent();

				var template_title = $('.pt-save-template-name').val();
				if( _.isEmpty( template_title ) ){
					alert( 'Template title can not be empty' );
					return false;
				}

				var template_content = THIS._shortcodeContent( true );
				if( _.isEmpty( template_content ) ){
					alert( 'Content is empty nothing to save' );
					return false;
				}

				THIS._showLoader();
				$.ajax({
					url: ajaxurl,
					data: {
						action: 'pt_save_template',
						template_title: template_title,
						template_content: template_content
					},
					method: "POST",
					success: function(response) {
						THIS.$dialog.find('.pt-templates-list').append( response );
					},
					error: function() {},
					complete: function() {
						THIS._hideLoader();
					}
				});
			});	

			/* HANDLE DELETING THE TEMPLATES */
			$(document).on( 'click', '.pt-delete-template', function(e){
				e.preventDefault();
				var $this = $(this);
				THIS._showLoader();
				$.ajax({
					url: ajaxurl,
					data: {
						action: 'pt_delete_template',
						template_id: $this.data('template_id')
					},
					method: "POST",
					success: function(response) {
						$this.parents('li').fadeOut( 100, function(){
							$(this).remove();
						});
					},
					error: function() {

					},
					complete: function() {
						THIS._hideLoader();
					}
				});
			});

			/* HANDLE ADDING A NEW TEMPLATE */
			$(document).on( 'click', '.pt-add-template', function(e){																  
																  
				e.preventDefault();
				
				// SHOW BITS
				jQuery('#nobtxt').hide();
				jQuery('.pt-main-actions').show();
				
				
				var $this = $(this);
				THIS._showLoader();
				$.ajax({
					url: ajaxurl,
					data: {
						action: 'pt_add_template',
						template_id: $this.data('template_id')
					},
					method: "POST",

					success: function(response) {
						if( response != '' ){
							var content = THIS._shortcodeContent( true ) + response;
							THIS._setContent( content );
							THIS._initVisual();
						}
					},
					error: function() {

					},
					complete: function() {
						
					}
				});				
			});

			/* HANDE ADDING CUSTOM CSS */
			$(document).on( 'click', '.pt-css', function(e){
				e.preventDefault();
				var editor;
				THIS.$dialog.html('<div id="pt-css-editor"></div>');
				var dialogOptions = {
					open: function() {
						$(this).parents('.ui-dialog').prev().click(function() { 
							$(this).dialog( "destroy" ); 
						});						
					    editor = ace.edit("pt-css-editor");
					    editor.setTheme("ace/theme/textmate");
					    editor.getSession().setMode("ace/mode/css");
					    editor.getSession().setValue( B64.decode( pt_data.pt_custom_css ) );
					    $('.ui-dialog-buttonset button').addClass( 'pt-button' );
					},
					width: 850,
					height: 400,
					title: 'Custom CSS',
					buttons: {
						Save: function(){
							/* SAVE CUSTOM CSS AS META */
							var code = B64.encode( editor.getSession().getValue() );
							pt_data.pt_custom_css = code;

							var pt_custom_css = $('input[value="pt_custom_css"]');
							if( pt_custom_css.length > 0 ){
								$( '#'+pt_custom_css.attr('id').replace( 'key', 'value' ) ).val( code );
							}
							$.ajax({
								url: ajaxurl,
								data: {
									action: 'pt_update_meta',
									post_id: pt_data.post_id,
									meta_key: 'pt_custom_css',
									meta_value: code
								},
								method: "POST"
							});
																	
							$(this).dialog('destroy');
							THIS.$dialog.html('');
						},
						Cancel: function(){										
							$(this).dialog('destroy');
							THIS.$dialog.html('');
						}
					}						
				}
				//$.extend( dialogOptions, THIS.dialogDefaultOptions, dialogOptions );
				THIS.$dialog.dialog( dialogOptions );
			});

			/* HANDLE PREVIEW */
			$(document).on( 'click', '.pt-preview', function(e){
				$('#post-preview').trigger('click');
			});

			/* COLAPSE ROWS AND SECTIONS */
			$(document).on( 'click', '.pt-colapse', function(e){
				var $this = $(this);
				var $parent = $this.closest('.pt-element-root');

				$this.find('span').toggleClass('fa-caret-up fa-caret-down');
				$parent.find('.pt-collapsible').slideToggle(100);
			});

			/* SAVE THE PAGE */
			$('.pt-save').text( $('#publish').val() );
			$(document).on( 'click', '.pt-save', function(e){
				$('#publish').trigger('click');
			});
			
			
			/* ADD NEW SECTION */
			$(document).on( 'click', '.pt-add-newaction-row', function(e){
				e.preventDefault();
				THIS._showLoader();
			 
				// SHOW BITS
				jQuery('#nobtxt').hide();
				jQuery('.pt-main-actions').show();
				
				try{THIS.$dialog.dialog('destroy')}
				catch(e){}

				var $this = $(this);
				var $parent = $this.closest('.pt-element-root');				
				if( $parent.length == 0 ){
					$parent = $this;
				}
				var parent = $parent.data('shortcode_id') || false;
				var shortcode_element = $parent.data('contain_shortcode_element');
				var params = {};
				var id = THIS._makeid();
				 
				$.ajax({
					url: ajaxurl,
					method: "POST",
					dataObject: "HTML",
					data: {
						action: 'pt_add_new',
						shortcode_element: shortcode_element,
						params: JSON.stringify( $.extend( {pt_content: ''}, params ) )
					},
					success: function( response ){
						/* IF ELEMENT HAVE OPTIONS */
						if( response != '' ){
							THIS.$dialog.html( response );
							var dialogOptions = {
								open: function(){
									var $this = $(this);
									$this.parents('.ui-dialog').prev().click(function() { 
										$this.dialog( "destroy" ); 
									});
									if( parseInt( $this.parents('.ui-dialog').css( 'top' ) ) < 60 ){
										$this.parents('.ui-dialog').css( 'top', '60px' );
									}
									$('.ui-dialog-buttonset button').addClass( 'pt-button' );
									THIS._optionsScripts();
								},
								width: 850,
								title: 'Element Options',
								resizable: false,
								close: function() {
									$(this).dialog('destroy');
								},
								closeOnEscape: true,
								modal: true,							
								buttons: {
									Save: function(){
										
										var $modal = $(this);
										params = THIS._getOptionParams( $modal, params );
										THIS.shortcodes[id] = {
											id: id,
											parent: parent,
											order: parent == false ? $('.pt-section').length : $parent.children().length,
											shortcode: shortcode_element.toLowerCase(),
											params: $.extend({ pt_content: '' }, params),
										};										
										THIS._visualElement( THIS.shortcodes[id] );
										/* HANDLE ADDING NEW ELEMENT AND CONNECT SCRIPTS TO IT */										
										$(this).dialog('destroy');
										THIS.$dialog.html('');
									},
									Cancel: function(){										
										$(this).dialog('destroy');
										THIS.$dialog.html('');
									},
								}								
							};
							THIS.$dialog.dialog( dialogOptions );
							
							// QUICK SAVE 
							$('.ui-dialog-buttonset button:first-child').trigger( "click" );
							
							
						}
						else{
							THIS.shortcodes[id] = {
								id: id,
								parent: parent,
								order: parent == false ? $('.pt-section').length : $parent.children().length,
								shortcode: shortcode_element.toLowerCase(),
								params: $.extend({ pt_content: '' }, params),
							};
							THIS._visualElement( THIS.shortcodes[id] );
						}
					},
					error: function(){

					},
					complete: function(){
						THIS._hideLoader(); 
					}
				});
				
			});
			
			
			/* ADD NEW SECTION */
			$(document).on( 'click', '.pt-add-newsection', function(e){
				e.preventDefault();
				THIS._showLoader();
			 
				// SHOW BITS
				jQuery('#nobtxt').hide();
				jQuery('.pt-main-actions').show();
				
				try{THIS.$dialog.dialog('destroy')}
				catch(e){}

				var $this = $(this);
				var $parent = $this.closest('.pt-element-root');				
				if( $parent.length == 0 ){
					$parent = $this;
				}
				var parent = $parent.data('shortcode_id') || false;
				var shortcode_element = $parent.data('contain_shortcode_element');
				var params = {};
				var id = THIS._makeid();
				 
				$.ajax({
					url: ajaxurl,
					method: "POST",
					dataObject: "HTML",
					data: {
						action: 'pt_add_new',
						shortcode_element: shortcode_element,
						params: JSON.stringify( $.extend( {pt_content: ''}, params ) )
					},
					success: function( response ){
						/* IF ELEMENT HAVE OPTIONS */
						if( response != '' ){
							THIS.$dialog.html( response );
							var dialogOptions = {
								open: function(){
									var $this = $(this);
									$this.parents('.ui-dialog').prev().click(function() { 
										$this.dialog( "destroy" ); 
									});
									if( parseInt( $this.parents('.ui-dialog').css( 'top' ) ) < 60 ){
										$this.parents('.ui-dialog').css( 'top', '60px' );
									}
									$('.ui-dialog-buttonset button').addClass( 'pt-button' );
									THIS._optionsScripts();
								},
								width: 850,
								title: 'Element Options',
								resizable: false,
								close: function() {
									$(this).dialog('destroy');
								},
								closeOnEscape: true,
								modal: true,							
								buttons: {
									Save: function(){
										
										var $modal = $(this);
										params = THIS._getOptionParams( $modal, params );
										THIS.shortcodes[id] = {
											id: id,
											parent: parent,
											order: parent == false ? $('.pt-section').length : $parent.children().length,
											shortcode: shortcode_element.toLowerCase(),
											params: $.extend({ pt_content: '' }, params),
										};										
										THIS._visualElement( THIS.shortcodes[id] );
										/* HANDLE ADDING NEW ELEMENT AND CONNECT SCRIPTS TO IT */										
										$(this).dialog('destroy');
										THIS.$dialog.html('');
									},
									Cancel: function(){										
										$(this).dialog('destroy');
										THIS.$dialog.html('');
									},
								}								
							};
							THIS.$dialog.dialog( dialogOptions );
							
							// QUICK SAVE 
							$('.ui-dialog-buttonset button:first-child').trigger( "click" );
							
							
						}
						else{
							THIS.shortcodes[id] = {
								id: id,
								parent: parent,
								order: parent == false ? $('.pt-section').length : $parent.children().length,
								shortcode: shortcode_element.toLowerCase(),
								params: $.extend({ pt_content: '' }, params),
							};
							THIS._visualElement( THIS.shortcodes[id] );
						}
					},
					error: function(){

					},
					complete: function(){
						THIS._hideLoader();
						 
						setTimeout(function(){
						  $('.sectionid'+id+' .pt-add-newaction-row').trigger( "click" );
						}, 1000);
						
					}
				});
				
			});
			

			/* ADD NEW SECTION, ROW, COLUMN, ELEMENT */
			$(document).on( 'click', '.pt-add', function(e){
				e.preventDefault();
				THIS._showLoader();
			 
				// SHOW BITS
				jQuery('#nobtxt').hide();
				jQuery('.pt-main-actions').show();
				
				try{THIS.$dialog.dialog('destroy')}
				catch(e){}

				var $this = $(this);
				var $parent = $this.closest('.pt-element-root');				
				if( $parent.length == 0 ){
					$parent = $this;
				}
				var parent = $parent.data('shortcode_id') || false;
				var shortcode_element = $parent.data('contain_shortcode_element');
				var params = {};
				var id = THIS._makeid();
				 
				$.ajax({
					url: ajaxurl,
					method: "POST",
					dataObject: "HTML",
					data: {
						action: 'pt_add_new',
						shortcode_element: shortcode_element,
						params: JSON.stringify( $.extend( {pt_content: ''}, params ) )
					},
					success: function( response ){
						/* IF ELEMENT HAVE OPTIONS */
						if( response != '' ){
							THIS.$dialog.html( response );
							var dialogOptions = {
								open: function(){
									var $this = $(this);
									$this.parents('.ui-dialog').prev().click(function() { 
										$this.dialog( "destroy" ); 
									});
									if( parseInt( $this.parents('.ui-dialog').css( 'top' ) ) < 60 ){
										$this.parents('.ui-dialog').css( 'top', '60px' );
									}
									$('.ui-dialog-buttonset button').addClass( 'pt-button' );
									THIS._optionsScripts();
								},
								width: 850,
								title: 'Element Options',
								resizable: false,
								close: function() {
									$(this).dialog('destroy');
								},
								closeOnEscape: true,
								modal: true,							
								buttons: {
									Save: function(){
										
										var $modal = $(this);
										params = THIS._getOptionParams( $modal, params );
										THIS.shortcodes[id] = {
											id: id,
											parent: parent,
											order: parent == false ? $('.pt-section').length : $parent.children().length,
											shortcode: shortcode_element.toLowerCase(),
											params: $.extend({ pt_content: '' }, params),
										};										
										THIS._visualElement( THIS.shortcodes[id] );
										/* HANDLE ADDING NEW ELEMENT AND CONNECT SCRIPTS TO IT */										
										$(this).dialog('destroy');
										THIS.$dialog.html('');
									},
									Cancel: function(){										
										$(this).dialog('destroy');
										THIS.$dialog.html('');
									},
								}								
							};
							THIS.$dialog.dialog( dialogOptions );
						 
						}
						else{
							THIS.shortcodes[id] = {
								id: id,
								parent: parent,
								order: parent == false ? $('.pt-section').length : $parent.children().length,
								shortcode: shortcode_element.toLowerCase(),
								params: $.extend({ pt_content: '' }, params),
							};
							THIS._visualElement( THIS.shortcodes[id] );
						}
					},
					error: function(){

					},
					complete: function(){
						THIS._hideLoader();
					}
				});
				
			});
		 
			/* SHOW ELEMENTS LIST */
			$(document).on( 'click', '.pt-add-list', function(){
				var $this = $(this);
				THIS._showLoader();
				var $parent = $this.closest('.pt-element-root');
				var parent = $parent.data('shortcode_id');
				$.ajax({
					url: ajaxurl,
					method: "POST",
					data:{
						action: 'pt_elements_listing',
						parent: parent
					},					
					success: function(response) {
						THIS.$dialog.html( response ).load(function(){
							$('.pt-elements-list').shuffle({
								itemSelector: '.pt-element-item',
								//sizer: $sizer
							}); 
						}); 

						var dialogOptions = {
							width: 850,
							title: 'Add Object',
							close: function(){
								THIS.dialog('destroy');
								THIS.$dialog.html('');
								$('.pt-elements-list').remove();
							},
						};
						$.extend( dialogOptions, THIS.dialogDefaultOptions, dialogOptions );

						THIS.$dialog.dialog( dialogOptions );

					},
					error: function() {

					},
					complete: function() {
						THIS._hideLoader();
						
						// SHOW FIRST TAB
						$('.pt-elements-list-filter a:first').trigger( "click" );
							 
					}
				});
			});
  
			/* HANDLE  DELETE */
			$(document).on( 'click', '.pt-delete', function() {
				var confirm_delete = confirm('Are you sure you want to delete this?');
				if ( confirm_delete == true ){
					var $this = $(this);
					var $parent = $this.closest('.pt-element-root');
					var shortcode_id = $parent.data('shortcode_id');
					THIS._deleteChildren( shortcode_id );
					$parent.fadeOut( 100, function(){
						$parent.remove();
					});
				}
			});

			/* HANDLE EDIT */
			$(document).on( 'click', '.pt-edit', function(e){
				e.preventDefault();
				THIS._showLoader();
				try{THIS.$dialog.dialog('destroy')}
				catch(e){}

				var $this = $(this);
				var $parent = $this.closest('.pt-element-root');
				if( $parent.length == 0 ){
					$parent = $this;
				}
				var id = $parent.data('shortcode_id') || false;
				var shortcode_element = $parent.data('shortcode_element');
				var params = THIS.shortcodes[id].params;

				$.ajax({
					url: ajaxurl,
					method: "POST",
					dataObject: "HTML",
					data: {
						action: 'pt_edit',
						shortcode_element: shortcode_element,
						params: JSON.stringify( $.extend( {pt_content: ''}, params ) )
					},
					success: function( response ){
						THIS.$dialog.html( response );

						var dialogOptions = {
							open: function(){
								var $this = $(this);
								$this.parents('.ui-dialog').prev().click(function() { 
									$this.dialog( "destroy" ); 
								});									
								if( parseInt( $this.parents('.ui-dialog').css( 'top' ) ) < 60 ){
									$this.parents('.ui-dialog').css( 'top', '60px' );
								}
								$('.ui-dialog-buttonset button').addClass( 'pt-button' );
								THIS._optionsScripts();								
							},
							width: 850,
							title: 'Edit Element',
							resizable: false,
							close: function() {
								$(this).dialog('destroy');
							},
							closeOnEscape: true,
							modal: true,
							buttons: {
								Save: function(){
									var $modal = $(this);
									params = THIS._getOptionParams( $modal, params );									

									THIS.shortcodes[id].params = $.extend({ pt_content: '' }, params);

									$parent.find('.pt-element-name:first').text( $('#element_name').val() );

									/* HANDLE ADDING NEW ELEMENT AND CONNECT SCRIPTS TO IT */									
									$(this).dialog('destroy');
									THIS.$dialog.html('');
								},
								Cancel: function(){									
									$(this).dialog('destroy');
									THIS.$dialog.html('');
								},								
							}							
						};
						THIS.$dialog.dialog( dialogOptions );
					},
					error: function(){

					},
					complete: function(){
						THIS._hideLoader();
					}
				});
			});


			/* HANDLE CLOSE */
			$(document).on( 'click', '.pt-clone', function(e){
				e.preventDefault();
				THIS._showLoader();
				try{THIS.$dialog.dialog('destroy')}
				catch(e){}

				var $this = $(this);
				var $parent = $this.closest('.pt-element-root');
				if( $parent.length == 0 ){
					$parent = $this;
				}

				var old_id = $parent.data('shortcode_id');
				var parent_id = THIS.shortcodes[old_id].parent;
				var $parent_container;

				if( parent_id ){
					$parent_container = $('.'+THIS.shortcodes[old_id].parent);
				}
				else{
					$parent_container = $('.pt-builder-content');
				}

				$parent_container.append( $parent.clone() );
				
				THIS._cloneShortcodes( old_id, $parent_container.children().length );

				THIS._bindScripts();
				THIS._hideLoader();
			});

			/* HANDLE LAYOUT OF THE ROW */
			$(document).on( 'click', '.pt-layout', function(){
				var $this = $(this);
				var layout = THIS._validateCellsList( $this.attr('title') );
				if( layout !== false ){
					THIS._updateColumns( $this.closest('.pt-element-root'), layout );
				}
			});

			/* HANDLE CUSTOM LAYOUT */
			$(document).on( 'click', '.pt-custom-layout', function(){
				var custom_layout = prompt( "Input custom layout", "" );
				if( _.isString( custom_layout ) ){
					custom_layout = THIS._validateCellsList( custom_layout );
					if( custom_layout !== false ){
						THIS._updateColumns( $(this).closest('.pt-element-root'), custom_layout );
					}
					else{
						alert('The desired layout is not valid and could not be generated.');
					}
				}
			});

			/* HANDLE SHOWING DESCRIPTION ON ELEMENT HOVER */			
			$(document).on( 'hover', '.pt-element-item', function(e){
				var $this = $(this);
				var decoded = $this.data('description');
				decoded.replace(/&#(\d+);/g, function(match, dec) {
   					return String.fromCharCode(dec);
 				});
				var image = $this.data('image');
				var imgstr = "";
				if(image != ""){
					imgstr = ' <div style="background:#fff; border:1px solid #ddd; margin-top:10px; text-align:center; padding:5px;"><img src="'+image+'"   style="width:100%;"></div>';
				}

				$('.pt-element-description').html( '<label>'+$this.find('.pt-element-text p').html()+'</label>' + decoded + imgstr );
			});

			$(window).scroll(function(){
				THIS._checkMainActionPosition();
			});
			$(window).resize(function(){
				THIS._checkMainActionPosition();
			});			
			THIS._checkMainActionPosition();
		},
		_checkMainActionPosition: function(){
			if( $('#wpadminbar').css('position') == 'fixed' ){
				var topOffset = $('#wpadminbar').outerHeight(true);
			}
			else{
				var topOffset = 0;			
			}			
			var main_action = $('.pt-main-actions');
			var offset = $('.pt-builder-content').offset();
			var top = offset.top - $(document).scrollTop();
			if( top < topOffset ){
				main_action.addClass( 'fixed' );
				main_action.css( 'top', topOffset );
			}
			else{
				main_action.removeClass( 'fixed' );
			}
		},
		/* GRAB SELECTED OPTIONS FROM THE OPTIONS MODAL WINDOW AND RETURN THEM AS PARAM */
		_getOptionParams: function( $modal, params ){
			$modal.find('.pt-option').each(function(){
				var $$this = $(this);
				if( $$this.is('input:checkbox') ){
					params[$$this.attr('id')] = $this.prop( 'checked' );
				}
				else if( $$this.is('input:radio') ){
					params[$$this.attr('id')] = $modal.find("input:radio[name='"+$$this.attr('name')+"']:checked").val();
				}
				else if( $$this.is("select") && $$this.is('[multiple]') ){
					params[$$this.attr('id')] = $$this.val().join(',');
				}
				else if( $$this.parents('.wp-editor-wrap').length > 0){
					var editor_id = $$this.attr('id');
					var content = '';
				    if ( $modal.find("#wp-"+editor_id+"-wrap") && $modal.find("#wp-"+editor_id+"-wrap").hasClass("tmce-active") ){
				        content =  tinyMCE.get(editor_id).getContent();
				    }else{
				        content =  $$this.val();
				    }
				    params[$$this.attr('id')] = content;										
				}
				else if( $$this.is('textarea') ){
					params[$$this.attr('id')] = $$this.val().replace(/\n/g, "/n/");
				}
				else{
					params[$$this.attr('id')] = $$this.val();
				}
			});	

			return params;		
		},
		/* DISPLAY LOADER BETWEEN THE REQUESTS */
		_showLoader: function(){
			$('.pt-loader-wrapper').show();
			$('.PT_Builder').animate({
				opacity: 0.4
			},
			0);
		},
		/* HIDE LOADER BETWEEN THE REQUESTS */
		_hideLoader: function(){
			$('.pt-loader-wrapper').hide();
			$('.PT_Builder').animate({
				opacity: 1
			},
			0);			
		},		
		/* BOND SCRIPTS FOR THE OPTIONS */
		_optionsScripts: function(){
			/* START COLORPICKERS */
			THIS.$dialog.find('.pt-colorpicker').each(function(){
				$(this).wpColorPicker();
			});

			/* START EDITORS */
			THIS.$dialog.find( '.wp-editor-area').each(function(){
				var $element = $(this);
		        var qt, textfield_id = $element.attr("id");

		        window.tinyMCEPreInit.mceInit[textfield_id] = _.extend({}, tinyMCEPreInit.mceInit['content']);

		        if(_.isUndefined(tinyMCEPreInit.qtInit[textfield_id])) {
		            window.tinyMCEPreInit.qtInit[textfield_id] = _.extend({}, tinyMCEPreInit.qtInit['replycontent'], {id: textfield_id})
		        }
		        qt = quicktags( window.tinyMCEPreInit.qtInit[textfield_id] );
		        QTags._buttonsInit();
				
				if(typeof tinyMCE !== 'undefined'){
		        window.switchEditors.go(textfield_id, 'tmce');
		        tinymce.execCommand( 'mceRemoveEditor', true, textfield_id );	
		        if(tinymce.majorVersion === "4") tinymce.execCommand( 'mceAddEditor', true, textfield_id ); 
				}
				
			});

			/* START SORTABLE ON MULTIPLE IMAGES */
			THIS.$dialog.find('.pt-images-holder').each(function(){
				var $image_holder = $(this);
				var $parent = $image_holder.closest('.pt-option-container');
				var $field = $parent.find( '.pt-images' );
				$image_holder.sortable({
					revert: false,
					update: function(event, ui) {
						var image_ids = [];
						$image_holder.find( 'img' ).each(function(){
							var $this = $(this);
							image_ids.push( $this.data('image_id') );
						});
						
						$field.val( image_ids.join(",") );
					}
				});	
			});

			/* START DATE TIME PICKER */
			THIS.$dialog.find('.pt-datetime').each(function(){
				var $this = $(this);
				$this.datetimepicker({
					format:'m/d/Y H:i',
				});
			});
						
		},
		/* VALIDATE CUSOMT LAYOUT */
        _validateCellsList: function(cells) {
            var return_cells = [],
                split = cells.replace(/\s/g, '').split('+'),
                b;
            var sum = _.reduce(_.map(split, function(c){
				if(c.match(/^[1-9]|1[0-2]\/[1-9]|1[0-2]$/)) {
                    b = c.split(/\//);
                    return_cells.push(b[0] + '' + b[1]);
                    return 12*parseInt(b[0], 10)/parseInt(b[1], 10);
                }
                return 10000;

            }), function(num, memo) {
                memo = memo + num;
                return memo;
            }, 0);

            if( sum !== 12 ){
            	return false;
            }
            else{
            	return return_cells.join('_');
        	}
        },
        /* GET DIRECT CHILDREN OF A ELEMENT */
        _getDirectChildren: function( parent_id ){
        	var children = [];
        	for( var item in THIS.shortcodes ){
        		if( THIS.shortcodes[item].parent == parent_id ){
        			children.push( THIS.shortcodes[item] );
        		}
        	}
        	/* sort the columns by an order */
			children.sort(function(a,b){
				return a.order - b.order;
			});

        	return children;
        },
        /* UPDATE COLUMNS OF THE ROW */
        _updateColumns: function( row, layout ){
        	var shortcode_id = row.data('shortcode_id');
        	var children = THIS._getDirectChildren( shortcode_id );
        	var $parent = $('.pt-row-content.'+shortcode_id);
        	var columns_layout = layout.toString().split(/\_/);
        	var last_column;
        	/* if there is less columns than the selected layout than add some */
        	for( var i=0; i<columns_layout.length; i++ ){
        		var column_width = columns_layout[i].split('');
        		var last_column = $('.pt-row-content.'+shortcode_id+' > .pt-column').eq(i);
        		var numerator, denominator;
        		if( column_width.length == 2 ){
					numerator = column_width[0];
					denominator = column_width[1];
				}
        		else if( column_width.length == 3 ){
					numerator = column_width[0];
					denominator = column_width[1]+column_width[2];
        		}
        		else if( column_width.length == 4 ){
					numerator = column_width[0]+column_width[1];
					denominator = column_width[2]+column_width[3];
        		}
        		
        		if( last_column.length > 0 ){
        			THIS.shortcodes[last_column.data('shortcode_id')].params['width'] = parseInt(numerator)+'/'+parseInt(denominator);
        			var column_span = 'span'+last_column.attr('class').split('span')[1];
        			var column_new_span = 'span'+( 12 * parseInt(numerator) ) / parseInt(denominator);
        			last_column.removeClass( column_span ).addClass( column_new_span );
        		}
        		else{
        			var new_id = THIS._makeid();
        			var old_last_column = $('.pt-row-content.'+shortcode_id+' > .pt-column:last');
        			last_column = old_last_column.clone();
        			var column_span = 'span'+last_column.attr('class').split('span')[1];
        			var column_new_span = 'span'+( 12 * parseInt(numerator) ) / parseInt(denominator);
        			last_column.removeClass( column_span ).addClass( column_new_span );        			
        			var old_id = last_column.data( 'shortcode_id' );
        			last_column.find( '.pt-column-content:first' ).html('');
					last_column.attr('data-shortcode_id', new_id);
					last_column.data( 'shortcode_id', new_id );
					last_column.html(function(i, oldHTML) {
						var regex = new RegExp( old_id, "g" );
					    return oldHTML.replace( regex, new_id );
					});
        			$parent.append( last_column );

					THIS.shortcodes[new_id] = {
						id: new_id,
						parent: shortcode_id,
						shortcode: 'pt_column',
						order: THIS.shortcodes[old_last_column.data('shortcode_id')].order + 1,
						params: {width: numerator+'/'+denominator, pt_content: ''},
					};	
        		}
        	}
        	/*if there is more columns already put the elements into the last row*/
        	var overflow = 0;
        	if( children.length > columns_layout.length ){
				overflow = children.length - columns_layout.length;
        	}

        	if( overflow > 0 ){
        		for( i=columns_layout.length; i<children.length; i++ ){
        			var last_column_shortcode_id = last_column.data('shortcode_id');
        			/* apdate elements from the oveflow column to be children of the last columns where they will be added */
        			$('.pt-column-content.'+children[i].id+' .pt-element').each(function(){
        				var $$this = $(this);
        				var element_shortcode_id = $$this.data( 'shortcode_id' );
        				THIS.shortcodes[element_shortcode_id].parent = last_column_shortcode_id;
        			});
        			var overflow_child = $('.pt-column-content.'+children[i].id);
        			/* apend elements from the overflow column to the last column */
        			last_column.find('.pt-column-content').append( overflow_child.html() );
        			delete THIS.shortcodes[children[i].id];
        			overflow_child.closest('.pt-element-root').remove();
        		}
        	}

        	THIS._bindScripts();
        	
        },
        _setContent: function( content ){
        	if( !content ){
				var content = THIS._shortcodeContent( true );
			}
		    if ( $("#wp-content-wrap").hasClass("tmce-active") ){
		    	tinyMCE.get('content').setContent( content );
		    }
		    else{
		        $('.wp-editor-area').val( content );
		    }
        },
        save: function(){
        	THIS._setContent();
        },
		destroy: function(){
			$(document).off( 'click', '.pt-template');
			$(document).off( 'click', '.pt-save-template');
			$(document).off( 'click', '.pt-delete-template');
			$(document).off( 'click', '.pt-add-template');
			$(document).off( 'click', '.pt-css');
			$(document).off( 'click', '.pt-preview');
			$(document).off( 'click', '.pt-add');
			$(document).off( 'click', '.pt-add-list');
			$(document).off( 'click', '.pt-edit');
			$(document).off( 'click', '.pt-delete');
			$(document).off( 'click', '.pt-colapse');
			$(document).off( 'click', '.pt-clone');
			$(document).off( 'click', '.pt-layout');
			$(document).off( 'click', '.pt-custom-layout');
			$(document).off( 'click', '.pt-element-item');
			$('#postdivrich').show();
			if(typeof tinyMCE !== 'undefined'){
			window.switchEditors.go('content', 'tmce');
			}
			THIS._setContent();
			THIS.$element.remove();
			$('#publish').data('locked','0');
			$('#save-post').data('locked','0');
		},
		/* REPLACE SHORTCODE ID IN THE CLONNED HTML */
		_cloneHTMLReplace: function( $element, old_id, new_id ){
			$element.attr('data-shortcode_id', new_id);
			$element.html(function(i, oldHTML) {
				var regex = new RegExp( old_id, "g" );
			    return oldHTML.replace( regex, new_id );
			});		
		},
		/* CLOONE SHORTCODES IN THE ARRAY */
		_cloneShortcodes: function( old_id, order, parent ) {
			var new_id = THIS._makeid();
			/* only update the order of the element that is being cloned leaving the order of its kids as they are */				
			THIS.shortcodes[new_id] = {
				id: new_id,
				order: THIS.shortcodes[old_id].order,
				parent: THIS.shortcodes[old_id].parent,
				shortcode: THIS.shortcodes[old_id].shortcode,
				params: $.extend({ pt_content: '' }, THIS.shortcodes[old_id].params),				
			};
			THIS._cloneHTMLReplace( $('div[data-shortcode_id="'+old_id+'"]:last'), old_id, new_id );
			if( order ){
				THIS.shortcodes[new_id].order = order;
			}
			else{
				THIS.shortcodes[new_id].parent = parent;
			}
            
 			var children = THIS._getDirectChildren( old_id );
 			for ( var i=0; i<children.length; i++ ) {
				var child_parent = new_id;
				old_id = children[i].id;
				THIS._cloneShortcodes( old_id, false, child_parent );
 			}		

		},
		/* PARSE CONTETNT FROM TINYMCE */
		_contentParser: function( shortcodes, content, parent ){
			var tags = pt_data.tags,
				self = this,
				reg = window.wp.shortcode.regexp(tags),
				matches = content.trim().match(reg),
				content = '',
				order = 0;
			if( matches !== null ){
				var regs = new RegExp('\\[(\\[?)(' + tags + ')(?![\\w-])([^\\]\\/]*(?:\\/(?!\\])[^\\]\\/]*)*?)(?:(\\/)\\]|\\](?:([^\\[]*(?:\\[(?!\\/\\2\\])[^\\[]*)*)(\\[\\/\\2\\]))?)(\\]?)');
				$.each(matches, function (raw, value) {
					var sub_matches = value.match( regs ),
						sub_content = sub_matches[5],
						sub_regexp = new RegExp('^[\\s]*\\[\\[?(' + tags + ')(?![\\w-])'),
						atts_raw = window.wp.shortcode.attrs(sub_matches[3]),
						atts = {};
					order++;
					for( var key in atts_raw.named ){
						 atts[key] = atts_raw.named[key];
					}
					/* 
						if has nested shortcodes than parse those and leave the content empty
						there is no chanse to shortcodes and text be mixed and the text will be in the bottom shortcode
						or at least it should :)
					*/
					if( !sub_content.match(regs) ){
						content = sub_content;
					}
					var id = self._makeid();
					shortcodes[id] = {
						id: id,
						order: order,
						parent: parent || false,
						shortcode:sub_matches[2],
						params: $.extend({ pt_content: content }, atts),
					};
					if( sub_content.match(regs) ){
						self._contentParser( shortcodes, sub_content, id );
					}					
				});
			}
			return shortcodes;
		},
		
		/* MAKE UNIQUE ID FOR EACH SHORETCODE ELEMENT */
		_makeid: function(){
			var text = "";
			var possible = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789";

			for( var i=0; i < 5; i++ ){
				text += possible.charAt(Math.floor(Math.random() * possible.length));
			}
			return text;
		},

		/* ADD ELEMENT VISUAL REPRESENTATION TO THE LAYOUT */
		_visualElement: function( object ) {
			var params_content = [];
			THIS._showLoader();
			for( var item in object.params ){
				if( item != 'pt_content' ){
					params_content.push( item+'="'+object.params[item]+'"' );
				}
			}
			params_content.push( 'shortcode_id="'+object.id+'"' );
			if( object.shortcode == 'pt_row' ){
				var column_id = THIS._makeid();
				THIS.shortcodes[column_id] = {
					id: column_id,
					parent: object.id,
					order: 1,
					shortcode: 'pt_column',
					params: {width: '1/1', pt_content: ''},
				};				
				var element_shortcode = '['+object.shortcode+' '+params_content.join(" ")+'][pt_column width="1/1" shortcode_id="'+column_id+'"][/pt_column][/'+object.shortcode+']';
			}
			else{
				var element_shortcode = '['+object.shortcode+' '+params_content.join(" ")+']'+object.params.pt_content+'[/'+object.shortcode+']';
			}
			
			$.ajax({
				url: ajaxurl,
				method: "POST",
				dataObject: "HTML",
				data: {
					action: 'pt_build_shortcode_admin',
					content: element_shortcode
				},
				success: function(response) {
					if( object.parent != false ){
						THIS.$builderWrapper.find('.'+object.parent).append( response );
					}
					else{
						THIS.$builderWrapper.append( response );
					}
					THIS._bindScripts();
				},
				erorr: function(){
					alert( 'An error occuer while trying to get visual representation of the shortcodes. PLease check you links and connectivity and try again.' );
				},
				complete: function() {
					THIS._hideLoader();
				}
			});
		},
		/* DELETE CHILDREN */
		_deleteChildren: function(parent){
			for(var id in THIS.shortcodes) {
				if( THIS.shortcodes[id].parent == parent ) {
					THIS._deleteChildren( THIS.shortcodes[id].id );					
				}
			}
			delete THIS.shortcodes[parent];
		},
		/* CREATE PARENT CHILD RELATION FROM THE LIST OF SHORTCODES */
		_nestedShortcodes: function( parent ){
			parent = parent || 0;
			var nested = [];
			for(var i in THIS.shortcodes) {
				if( THIS.shortcodes[i].parent == parent ) {
					var children = THIS._nestedShortcodes( THIS.shortcodes[i].id );

					nested.push({
						id: THIS.shortcodes[i].id,
						parent: THIS.shortcodes[i].parent,
						order: THIS.shortcodes[i].order,
						shortcode: THIS.shortcodes[i].shortcode,
						params: THIS.shortcodes[i].params,
						children: children.length > 0 ? children : false
					});
				}
			}
			nested.sort(function(a,b){
				return a.order - b.order;
			});

            return nested;
		},

		_adminShortcodes: function( object, clean ) {
			var params_content = [];
			for( var item in object.params ){
				if( item != 'pt_content' ){
					params_content.push( item+'="'+object.params[item]+'"' );
				}
			}
			if( !clean ){
				params_content.push( 'shortcode_id="'+object.id+'"' );
			}
			var shortcode_content = '['+object.shortcode+' '+params_content.join(" ")+']'+object.params.pt_content;
			if( !_.isEmpty( object.children ) ){
				for(var i=0; i<object.children.length; i++){
					shortcode_content += this._adminShortcodes( object.children[i], clean );
				}
			}
			shortcode_content += '[/'+object.shortcode+']';

			return shortcode_content;
		},
		/* GENERATE SHORTCODE STRING FOR INITIAL VISUAL REPRESENTATION OR FOR DROPPING IT INTO THE TEXTAREA 
			CLEAN MEANS THAT IT WILL REMOVE EXTRA ATTRIBUTE (SHORTCODE ID) FROM THE SHORTCODE
		*/
		_shortcodeContent: function( clean ){
			clean = clean || false;
			var nested_shortcodes = this._nestedShortcodes();
			var content = '';
			for( var item in nested_shortcodes ){
				content += this._adminShortcodes( nested_shortcodes[item], clean );
			}

			return content;
		},

		/* THIS FUNCTION IS FOR THE INITIAL BUILD */
		_buildVisual: function(){
			var content = THIS._shortcodeContent();
			$.ajax({
				url: ajaxurl,
				method: "POST",
				dataObject: "HTML",
				data: {
					action: 'pt_build_shortcode_admin',
					content: content
				},
				success: function(response) {
					THIS.$builderWrapper.html( response );
					THIS._bindScripts();
				},
				erorr: function(){
					alert( 'An error occuer while trying to get visual representation of the shortcodes. PLease check you links and connectivity and try again.' );
				},
				complete: function() {
					THIS._hideLoader();
				}
			});
		},
		/* UPDATE SHORTCODE ORDER AFTER SORT */
		_updateShortcodeOrder: function( $container, element_selector ){
			var order = 1;
			$container.find(element_selector).each(function(){
				var $this = $(this);
				var shortcode_id = $this.data('shortcode_id');
				THIS.shortcodes[shortcode_id].order = order;
				order++;
			});
		},
		/* DONT FORGET TO UNBIND THESE ON BUILDER DESTROY  */
		_bindScripts: function() {
			/* sortable sections */
			$('.pt-builder-content').sortable({
				placeholder: "sortable-placeholder",
				start: function(e, ui){
				    ui.placeholder.css({
				    	height: ui.item.outerHeight(),
				    	width: '100%',
				    	display: 'inline'
				    });
				},				
				handle: '.pt-section-drag',
				stop: function( event, ui ){
					THIS._updateShortcodeOrder( ui.item.closest('.pt-builder-content'), '.pt-section' );
				}
			});

			/* sortable rows */
			$('.pt-section-content').sortable({
				/* connnect with other section so the row can be moved to another section aswell */
				connectWith: '.pt-section-content',
				placeholder: "sortable-placeholder",
				start: function(e, ui){
				    ui.placeholder.css({
				    	height: ui.item.outerHeight(),
				    	width: '100%',
				    	display: 'inline-block'
				    });
				},				
				handle: '.pt-row-drag',
				stop: function( event, ui ){
					var shortcode_id = ui.item.data('shortcode_id');
					var parent_id = ui.item.closest('.pt-section-content').closest('.pt-element-root').data('shortcode_id');
					THIS.shortcodes[shortcode_id].parent = parent_id;
					THIS._updateShortcodeOrder( ui.item.closest('.pt-section-content'), '.pt-row' );
				}				
			});

			/* soratble columns. No handle since the lemenet is small */
			$('.pt-row-content').sortable({
				placeholder: "sortable-placeholder",
				start: function(e, ui){
				    ui.placeholder.css({
				    	height: ui.item.outerHeight(),
				    	width: ui.item.outerWidth(),
				    	display: 'inline-block'
				    });
				},
				stop: function( event, ui ){
					THIS._updateShortcodeOrder( ui.item.closest('.pt-row-content'), '.pt-column' );
				}
			});

			/* soratble columns. No handle since the element is small */
			$('.pt-column-content').sortable({
				/* connnect with other columns so the element can be moved to another section aswell */
				placeholder: "sortable-placeholder",
				start: function(e, ui){
				    ui.placeholder.css({
				    	height: ui.item.outerHeight(),
				    	width: '100%',
				    	display: 'inline-block'
				    });
				},
				connectWith: '.pt-column-content',
				stop: function( event, ui ){
					var shortcode_id = ui.item.attr('data-shortcode_id');
					var parent_id = ui.item.closest('.pt-column-content').closest('.pt-element-root').attr('data-shortcode_id');
					THIS.shortcodes[shortcode_id].parent = parent_id;
					THIS._updateShortcodeOrder( ui.item.closest('.pt-column-content'), '.pt-element' );
				}					
			});
		}


	}

	
    $.fn.PT_Builder = function( options ) {
		var args = arguments;
		
		if (options === undefined || typeof options === 'object') {
			// Create a plugin instance for each selected element.
			return this.each(function() {
				if (!$.data(this, 'plugin_' + pluginName)) {
					$.data(this, 'plugin_' + pluginName, new PT_Builder(this, options));
				}
			});
		} else if (typeof options === 'string' && options[0] !== '_' && options !== 'init') {
			// Call a pluguin method for each selected element.
			if (Array.prototype.slice.call(args, 1).length == 0 && $.inArray(options, $.fn.PT_Builder.getters) != -1) {
				// If the user does not pass any arguments and the method allows to
				// work as a getter then break the chainability
				var instance = $.data(this[0], 'plugin_' + pluginName);
				return instance[options].apply(instance, Array.prototype.slice.call(args, 1));
			} else {
				// Invoke the speficied method on each selected element
				return this.each(function() {
					var instance = $.data(this, 'plugin_' + pluginName);
					if (instance instanceof PT_Builder && typeof instance[options] === 'function') {
						instance[options].apply(instance, Array.prototype.slice.call(args, 1));
					}
				});
			}
		}
    }

})( jQuery, window, document );