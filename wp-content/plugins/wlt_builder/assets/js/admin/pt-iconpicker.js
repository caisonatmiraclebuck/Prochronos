jQuery(document).ready(function($){

	$(document).on( 'click', '.pt-icons-select', function(){
		var $this = $(this);
		var $parent = $this.parents('.pt-option-container');

		$parent.find( '.pt-iconpicker-list' ).slideToggle(200);
	});

	$(document).on( 'click', '.pt-icons-clear', function(e){
		var $this = $(this);
		var $parent = $this.parents('.pt-option-container');
		$parent.find( '.pt-icons-select span' ).remove();
		$parent.find( '.pt-iconpicker' ).val('');
		$this.fadeOut( 100, function(){
			$(this).remove();
		});

	});

	$(document).on( 'click', '.pt-icons li', function(){
		var $this = $(this);
		var $parent = $this.parents('.pt-option-container');

		$('.pt-icons li.active').removeClass('active');
		$this.addClass('active');

		$parent.find( '.pt-iconpicker' ).val( $this.data('icon_name') );
		$parent.find( '.pt-icons-select' ).html('<span class="fa '+$this.data('icon_name')+'"></span> Select Icon');
		if( $parent.find( '.pt-icons-clear' ).length == 0 ){
			$parent.find( '.pt-icons-select' ).after('<a href="javascript:;" class="button pt-icons-clear">Clear</a>');
		}
		$parent.find( '.pt-iconpicker-list' ).slideUp(200);

	});
});