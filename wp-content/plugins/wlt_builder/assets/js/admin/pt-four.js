jQuery(document).ready(function($){
	$(document).on('keyup', '.pt-four-0, .pt-four-1, .pt-four-2, .pt-four-3', function(){
		var $this = $(this);
		var $parent = $this.closest('.pt-option-container');
		var value = [];
		
		$parent.find('input[class^="pt-four-"]').each(function(){
			if( $(this).val() !== "" ){
				value.push( $(this).val() );
			}
		});
		if( value.length > 0 ){
			$parent.find('input[class^="pt-four-"]').each(function(){
				var key = $(this).attr('class').split('pt-four-')[1];
				var $this = $(this)
				var val = $this.val() === "" ? 0 : $this.val();
				val = /^\d+$/.test(val) === true ? val+'px' : val;
				value[key] = val;
			});
		}

		$parent.find('.pt-option').val( value.join(',') );
	});
});