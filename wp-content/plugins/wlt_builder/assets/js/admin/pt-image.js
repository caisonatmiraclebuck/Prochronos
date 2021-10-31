jQuery(document).ready(function($){
	$(document).on( 'click', '.pt-add-image', function( e ){
		var $this = $(this);
		var $parent = $this.closest('.pt-option-container');
		var $field = $parent.find( '.pt-image' );
		e.preventDefault();

		var PT_Frame = wp.media({
			multiple: false,
			title: 'Select Image'
		});

		PT_Frame.on('select', function(){
			var selection = PT_Frame.state().get('selection'),
				model = selection.first();
			$field.val( model.attributes.id );
			$parent.find('img').remove();
			$this.before( '<div class="pt-image-wrapper">\
						  	<img src="'+model.attributes.url+'" data-image_id="'+model.attributes.id+'" class="pt-option-thumb" />\
						 	<a href="javascript:;" class="remove_image"><span class="fa fa-times"></span></a>\
						  </div>' );
			PT_Frame.close();
		});

		PT_Frame.open();
	});
	
	$(document).on( 'click', '.remove_image', function(e){
		e.preventDefault();
		var $this = $(this);
		var $parent = $this.closest('.pt-option-container');
		var $field = $parent.find( '.pt-image' );
		$('img[data-image_id="'+$field.val()+'"]').fadeOut( 100, function(){ 
				$(this).remove();
				$this.remove();
		});
		$field.val('');
	});
});