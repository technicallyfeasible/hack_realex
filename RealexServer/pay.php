<?php
require_once ('vendor/autoload.php');
          
use com\realexpayments\remote\sdk\domain\Card;                                          
use com\realexpayments\remote\sdk\domain\CardType;
use com\realexpayments\remote\sdk\domain\PresenceIndicator;                                    
use com\realexpayments\remote\sdk\domain\payment\AutoSettle;                            
use com\realexpayments\remote\sdk\domain\payment\AutoSettleFlag;
use com\realexpayments\remote\sdk\domain\payment\PaymentRequest;
use com\realexpayments\remote\sdk\domain\payment\PaymentResponse;                 
use com\realexpayments\remote\sdk\domain\payment\PaymentType;         
use com\realexpayments\remote\sdk\RealexClient;
use com\realexpayments\remote\sdk\RealexException;
use com\realexpayments\remote\sdk\RealexServerException;
use com\realexpayments\remote\sdk\http\HttpConfiguration;
  
$card = ( new Card() )                                                          
        ->addType( CardType::VISA )
        ->addNumber( "4263970000005262" )                                       
        ->addExpiryDate( "1220" )
        ->addCvn( "123" )
        ->addCvnPresenceIndicator( PresenceIndicator::CVN_PRESENT )
        ->addCardHolderName( "James Mason" );

$request = ( new PaymentRequest() )                                               
        ->addType( PaymentType::AUTH )                                          
        ->addCard( $card )                                                      
        ->addMerchantId( "hackathon3" )                                                                           
        ->addAmount( 1001 )                                                       
        ->addCurrency( "GBP" )                                              
        ->addAutoSettle( ( new AutoSettle() )->addFlag( AutoSettleFlag::TRUE ) );
  
$httpConfiguration = new HttpConfiguration();
$httpConfiguration->setEndpoint("https://epage.sandbox.payandshop.com/epage-remote.cgi");
// $httpConfiguration->setOnlyAllowHttps(false); // if connecting from a non-SSL environment, never use in a Production environment!
$client = new RealexClient("secret", $httpConfiguration);

try {
	$paymentResponse = $client->send($request);
	echo $paymentResponse->getMessage();
	return $paymentResponse->getMessage();
}
catch (RealexServerException $e){
	echo $e->getErrorCode() . ": " . $e->getMessage();
	return $e->getMessage();
}
catch (RealexException $e) {
	echo $e->getCode() . ": " . $e->getMessage();
	return $e->getMessage();
}
?>
