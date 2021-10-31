jQuery(document).ready(function($){
	$(document).on( 'click', '.pt-add-images', function( e ){
		e.preventDefault();
		
		var $this = $(this);
		var $parent = $this.closest('.pt-option-container');
		var $field = $parent.find( '.pt-images' );
		var $image_holder = $parent.find( '.pt-images-holder' );
		
		var PT_Frame = wp.media({
			multiple: true,
			title: 'Select Images'
		});

		PT_Frame.on('select', function(){
			var selection = PT_Frame.state().get('selection').toJSON();
			$image_holder.html('');
			for( var i=0; i<selection.length; i++ ){
				$image_holder.append( '<div class="pt-image-wrapper">\
										 <img src="'+selection[i].url+'" data-image_id="'+selection[i].id+'" class="pt-option-thumb" />\
									   	 <a href="javascript:;" class="remove_images" data-image_id="'+selection[i].id+'"><span class="fa fa-times"></span></a>\
									   </div>' );
			}
			update_images( $image_holder, $field );
			PT_Frame.close();
		});
				
		
		PT_Frame.open();
	});
	
	$(document).on( 'click', '.remove_images', function(e){
		e.preventDefault();
		var $this = $(this);
		var $parent = $this.closest('.pt-option-container');
		var $field = $parent.find( '.pt-images' );
		var $image_holder = $parent.find( '.pt-images-holder' );		
		var image_id = $this.data('image_id');
		$('img[data-image_id="'+image_id+'"]').fadeOut( 150, function(){ 
			$(this).remove();
			$this.remove(); 
			update_images( $image_holder, $field );
		});		
	});
	
	function update_images( $image_holder, $field ){
		var image_ids = [];
		$image_holder.find( 'img' ).each(function(){
			var $this = $(this);
			image_ids.push( $this.data('image_id') );
		});
		
		$field.val( image_ids.join(",") );
	}	

});