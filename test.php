<?php

require 'vendor/autoload.php';

use Omnipay\PayU\GatewayFactory;

// sandbox
$posId = 300046;
$secondKey = '0c017495773278c50c7b35434017b2ca';
$oAuthClientSecret = 'c8d4b7ac61758704f38ed5564d8c0ae0';

$gateway = GatewayFactory::createInstance($posId, $secondKey, $oAuthClientSecret, true);

try {
    $merchantId = 'A1029DTmM7';
    $orderNo = '12345677';
    $returnUrl = 'http://localhost:8000/gateway-return.php';
    $description = 'Shopping at myStore.com (Lenovo ThinkPad Edge E540, Shipping with PPL)';

//    $purchase = new \Omnipay\PayU\Purchase($merchantId, $orderNo, $returnUrl, $description);
//    $purchase->setCart([
//        new \Omnipay\PayU\CartItem("Notebook", 1, 1500000, "Lenovo ThinkPad Edge E540..."),
//        new \Omnipay\PayU\CartItem("Shipping", 1, 0, "PPL"),
//    ]);

    $response = $gateway->purchase([]);

//    /** @var \Omnipay\PayU\Message\ProcessPaymentResponse $response */
//    $response = $gateway->purchase($purchase->toArray())->send();

    echo 'Is redirect: ' . $response->isRedirect();

    // Payment init OK, redirect to the payment gateway
    echo $response->getRedirectUrl();
} catch (\Exception $e) {
    dump((string)$e);
}