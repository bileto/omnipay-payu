<?php

require 'vendor/autoload.php';

use Omnipay\PayU\GatewayFactory;

// sandbox
$posId = 300046;
$secondKey = '0c017495773278c50c7b35434017b2ca';
$oAuthClientSecret = 'c8d4b7ac61758704f38ed5564d8c0ae0';

$gateway = GatewayFactory::createInstance($posId, $secondKey, $oAuthClientSecret, true);

try {
    $completeRequest = ['transactionId' => 'X7CBNL2NS4160822GUEST000P01'];
    $response = $gateway->completePurchase($completeRequest);

    echo "Is Successful: " . $response->isSuccessful() . PHP_EOL;
    echo "TransactionId: " . $response->getTransactionId() . PHP_EOL;
    echo "State code: " . $response->getCode() . PHP_EOL;
    echo "PaymentId: " , $response->getTransactionReference() . PHP_EOL;

} catch (\Exception $e) {
    dump($e->getResponse()->getBody(true));
    dump((string)$e);
}