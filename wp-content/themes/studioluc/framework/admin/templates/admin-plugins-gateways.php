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


// LOAD IN MAIN DEFAULTS 
$core_admin_values = get_option("core_admin_values");  
  
?> 


<div class="heading2">PremiumPress Payment Gateway Plugins </div>

 
<?php

$plugins = array(

1 => array("title" => "All Themes"),

	"wlt_gateway_bank" => array("t" => "Bank Details Payment Form", "d" => "This will add a new payment gateway to your PremiumPress powered website.", "i" => "bank.png",  ),
	
 

"wlt_gateway_adyen" => array("t" => "Adyen Gateway Plugin", "d" => "This plugin will install a new payment gateway into your website.", "i" => "adyen.png",  ),	


"wlt_gateway_coinpayments" => array("t" => "Coin Payments Gateway Plugin", "d" => "This plugin will install a new payment gateway into your website.", "i" => "coinpayment.png",  ),	

"wlt_gateway_authorize.net" => array("t" => "Authorize.net Payment Gateway", "d" => "This plugin will install a new payment gateway into your website.", "i" => "auth.png",  ),	

"wlt_gateway_molpay" => array("t" => "Molpay Payment Gateway", "d" => "This plugin will install a new payment gateway into your website.", "i" => "molypay.png",  ),	

"wlt_gateway_nab" => array("t" => "NAB Transact Direct Payment Gateway", "d" => "This plugin will install a new payment gateway into your website.", "i" => "nab.png",  ),	

"wlt_gateway_sagepay" => array("t" => "SagePay (AKA Protex) Payment Gateway", "d" => "This plugin will install a new payment gateway into your website.", "i" => "sagepay.png",  ),	

"wlt_gateway_ccavenue" => array("t" => "CCAvenue Payment Gateway", "d" => "This plugin will install a new payment gateway into your website.", "i" => "ccavenue.png",  ),	

"wlt_gateway_paymill" => array("t" => "PayMill Payment Gateway", "d" => "This plugin will install a new payment gateway into your website.", "i" => "paymill.png",  ),	

"wlt_gateway_braintree" => array("t" => "BrainTree Payment Gateway", "d" => "This plugin will install a new payment gateway into your website.", "i" => "braintree.png",  ),	

"wlt_gateway_worldpay" => array("t" => "WorldPay Payment Gateway", "d" => "This plugin will install a new payment gateway into your website.", "i" => "worldpay.png",  ),	

"wlt_gateway_iDeal" => array("t" => "iDeal Payment Gateway", "d" => "This plugin will install a new payment gateway into your website.", "i" => "ideal.png",  ),	

"wlt_gateway_payfast" => array("t" => "PayFast Payment Gateway", "d" => "This plugin will install a new payment gateway into your website.", "i" => "payfast.png",  ),	

"wlt_gateway_paypal_flow" => array("t" => "PayPal Flow Payment Gateway", "d" => "This plugin will install a new payment gateway into your website.", "i" => "paypalflow.png",  ),

"wlt_gateway_stripe" => array("t" => "Stripe Payment Gateway", "d" => "This plugin will install a new payment gateway into your website.", "i" => "stripe.png",  ),
	
"wlt_gateway_payza" => array("t" => "PayZa Payment Gateway", "d" => "This plugin will install a new payment gateway into your website.", "i" => "payza.png",  ),
	
"wlt_gateway_payumoney" => array("t" => "Payumoney Payment Gateway", "d" => "This plugin will install a new payment gateway into your website.", "i" => "payumoney.png",  ),
 	
	
	
2 => array("title" => "Auction Theme Only"),


	"wlt_gateway_paypal_adaptive" => array("t" => "PayPal Adaptive Payments for Auction Theme", "d" => "This plugin will install a new payment gateway into your website.", "i" => "paypal1.png",  ),
	
 );
 
 

if(!defined('WLT_AUCTION')){	

unset($plugins[2]);
unset($plugins["wlt_gateway_paypal_adaptive"]);
}
 

foreach($plugins as $key => $p){ ?>

<?php if(isset($p['title'])){ ?>

<div class="heading">
<h4 class="clear heading1"><?php echo $p['title']; ?></h4>
</div>

<?php }else{ ?>

 
<div class="thumbnail1" style="  padding-bottom:10px;">

<div style="float:left; margin:10px; margin-right:20px; ">
<img src="<?php echo get_template_directory_uri(); ?>/framework/admin/img/gateways/<?php echo $p['i']; ?>" style="width:100px;" />
</div>

<h4 style="margin-top:0px;margin-bottom:0px; font-weight:bold;"><?php echo $p['t']; ?></h4>

<p><?php echo $p['d']; ?></p>
 

<a href="<?php echo home_url(); ?>/wp-admin/plugin-install.php?tab=plugin-information&plugin=<?php echo $key; ?>&TB_iframe=true&width=772&height=513" class="button btn" style="margin-top:10px;">Install Now</a>

</div>

<?php }?>

<?php } ?>