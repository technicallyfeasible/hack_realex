<?php
require_once ('vendor/autoload.php');

use com\realexpayments\hpp\sdk\domain\HppRequest;
use com\realexpayments\hpp\sdk\RealexHpp;
use com\realexpayments\hpp\sdk\RealexValidationException;
use com\realexpayments\hpp\sdk\RealexException;

header("Access-Control-Allow-Origin: *");


$hppRequest = ( new HppRequest() )
	->addMerchantId( "hackathon3" )
	->addAmount( $_REQUEST["amount"] )
	->addCurrency( "GBP" )
	->addAutoSettleFlag( "1" );

$realexHpp = new RealexHpp( "secret" );

try { 
	$requestJson = $realexHpp->requestToJson( $hppRequest ); 
	echo $requestJson; 
	return $requestJson; 
}
catch (RealexValidationException $e) {
	echo $e->getMessage(); 
	return $e->getMessage();
}
catch (RealexException $e) {
	echo $e->getMessage(); 
	return $e->getMessage();
}

 /* Sample HPP Request JSON
 * {"MERCHANT_ID":"cmVhbGV4c2FtZGJveA==","ACCOUNT":"","ORDER_ID":"ZXprME1VTTJNRE5FTFVNd016STRNUQ==","AMOUNT":"MTAwMQ==","CURRENCY":"RVVS","TIMESTAMP":"MjAxNjAzMDgxNzMwNDI=","SHA1HASH":"MGJhM2ZiZjg4YzAyZTFhYTFiN2EzMDg1NmM2Y2NjODFjMDJiYWZhZg==","AUTO_SETTLE_FLAG":"MQ==","COMMENT1":"","COMMENT2":"","RETURN_TSS":"","SHIPPING_CODE":"","SHIPPING_CO":"","BILLING_CODE":"","BILLING_CO":"","CUST_NUM":"","VAR_REF":"","PROD_ID":"","HPP_LANG":"","CARD_PAYMENT_BUTTON":"","CARD_STORAGE_ENABLE":"","OFFER_SAVE_CARD":"","PAYER_REF":"","PMT_REF":"","PAYER_EXIST":"","VALIDATE_CARD_ONLY":"","DCC_ENABLE":""}
 */
?>
