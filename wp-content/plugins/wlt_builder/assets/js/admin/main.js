jQuery(document).ready(function($){
	"use strict";
	/* add custom  button to switch to the builder */
	var $pt_button = $('#insert-media-button').clone();
	$pt_button.removeAttr( 'id' );
	$pt_button.attr( 'href', 'javascript:;' );
	$pt_button.removeAttr( 'data-editor' );
	$pt_button.attr( 'class', 'button pt-builder-start' );
 
	$pt_button.html( '<i class="fa fa-cog"></i> PremiumPress Page Builder' );
	$pt_button.data( 'switch_to', 'builder' );
	$('#postdivrich').before( $pt_button );
	var PT_Builder;

	function pt_start_builder(){
		$('#postdivrich').hide();
		$pt_button.html( '<i class="fa fa-angle-double-left"></i> WP Editor' );
		$pt_button.data( 'switch_to', 'classic' );
		$pt_button.after('<div class="PT_Builder"><div class="pt-loader-wrapper"></div></div>');
		PT_Builder = $('.PT_Builder').PT_Builder();
	}
	/* start builder if it was last used */
	if( pt_data && pt_data.pt_initial_start == '1' ){
		pt_start_builder();
	}

	/* start builder on click */
	$pt_button.click(function(){
		var $this = $(this);
		if( $this.data( 'switch_to' ) == 'builder' ){
			//remember builder as a last used so start from it on the next page load
			var pt_initial_start_field = $('input[value="pt_initial_start"]');
			if( pt_initial_start_field.length > 0 ){
				$( '#'+pt_initial_start_field.attr('id').replace( 'key', 'value' ) ).val(1);
			}
			else{
				$.ajax({
					url: ajaxurl,
					data: {
						action: 'pt_update_meta',
						post_id: pt_data.post_id,
						meta_key: 'pt_initial_start',
						meta_value: '1'
					},
					method: "POST"
				});
			}
			pt_start_builder();
		}
		else{
			//remember visual editor as a last 
			var pt_initial_start_field = $('input[value="pt_initial_start"]');
			if( pt_initial_start_field.length > 0 ){
				$( '#'+pt_initial_start_field.attr('id').replace( 'key', 'value' ) ).val(0);
			}
			else{
				$.ajax({
					url: ajaxurl,
					data: {
						action: 'pt_update_last_usage',
						post_id: pt_data.post_id,
						pt_initial_start: '0'
					},
					method: "POST"
				});				
			}
			//handle builder to content if needed or it will auto updated on element adding and edditing
			PT_Builder.PT_Builder('destroy');			
			$('#postdivrich').show();
			$pt_button.html( '<i class="fa fa-cog"></i> PremiumPress Page Builder' );
			$pt_button.data( 'switch_to', 'builder' );
		}
	});
	
	/* save the data on the click on one of the following */
	$('#post-preview').click(function(e){
		PT_Builder.PT_Builder('save');
	});

	$('#publish, #save-post').click(function(e){
		if( $(this).data('locked') == '1' ){
			e.preventDefault();
			PT_Builder.PT_Builder('destroy');
			$(this).trigger('click');
		}
	});

	
	/* FILTERING ELEMENT LIST */
	$(document).on( 'click', '.pt-element-filter', function(){
		var $this = $(this),
			isActive = $this.hasClass('active');
		var filter;
		if( !isActive ){
			$('.pt-element-filter.active').removeClass('active');
			filter = $this.data('group');
		}
		else{
			filter = '';
		}

		$this.toggleClass( 'active' );

		$('.pt-elements-list').shuffle( 'shuffle', filter );
	});
	
});