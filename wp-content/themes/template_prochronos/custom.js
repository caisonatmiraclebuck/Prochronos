jQuery(document).ready(function(){
	jQuery('#form-row-rapper-price_bin').find('.required').css('display','none');
	jQuery('.formErrorClass').append('<span class="bidmssg" style="color:red;"></span>');
	jQuery('.cnfm_bid').attr('disabled','');
	
	jQuery('#cbid_amount').keyup(function(){
		//alert('hellow test');	
		var CbidAmt = jQuery(this).val();
		var bidAmt = jQuery('#bid_amount').val();
		if (bidAmt != CbidAmt) {
			console.log("Passwords do not match.");
			jQuery('.bidmssg').html('Your bidding amount does not match.Confirm Bid is disabled for security reasons.Please enter same amount to make confirm button enabled');
			jQuery('.bidmssg').css('color','red');
			jQuery('.cnfm_bid').attr('disabled','');

			return false;
		}
		else{
			jQuery('.bidmssg').html('Your bidding amount matched.');
			jQuery('.bidmssg').css('color','green');
			jQuery('.cnfm_bid').removeAttr('disabled');
			return true;
		}
	});
	
	jQuery('.dealer_form_btn').click(function(){
		//alert('clicked');
		var searchtext = jQuery('#searchText').val();
		var country = jQuery('#countrySelect option:selected').html();
		var ajax_url = jQuery('.ajax_url').val();
		jQuery.ajax({
			method : 'post',
			data: {searchtext: searchtext, country: country},
			url: ajax_url,
			success: function(data) {
				//alert(data);
				//alert(jQuery(data).find('div.paginContent').length);
				jQuery('.page_ul').html(data);
				jQuery('#pagingControls').css('display','none');
			},
		});
	});
	//console.log(jQuery('#form-row-rapper-price_bin').find('.required').length);
	jQuery('.formError_Class').append('<span class="bidmssg1" style="color:red;"></span>');
	jQuery('.cnfmBuy').attr('disabled','');
	var current_buy_now = jQuery('.CurrntBuyNow').val();
	jQuery('.BuyNowBidPrice').keyup(function(){
		var val_buy = jQuery(this).val();
		
		
		if(parseInt(val_buy) >= parseInt(current_buy_now)){
			jQuery('.bidmssg1').html('Your bidding amount matched.');
			jQuery('.bidmssg1').css('color','green');
			jQuery('.bidmssg1').css('display','block');
			jQuery('.cnfmBuy').removeAttr('disabled');
			//return true;
		
		}else{
			jQuery('.bidmssg1').html('Your bidding amount does not match.Confirm Bid is disabled for for security reasons.Please enter same amount to make confirm button enabled');
			jQuery('.bidmssg1').css('color','red');
			jQuery('.bidmssg1').css('display','block');
			jQuery('.cnfmBuy').attr('disabled','');  
			//return false;
		}
	
	});
	
	
});
