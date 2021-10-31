jQuery(document).ready(function($){
	$(document).on( 'click', '.pt-checkbox-option', function( e ){
		e.preventDefault();
		var $this = $(this);
		var $parent = $this.closest('.pt-option-container');
		$parent.find('.pt-checkbox-option').not('.active').addClass('active');
		$this.removeClass('active');

		$parent.find('.pt-checkbox').val( $parent.find('.pt-checkbox-option.active').data('value') );
	});
});