<?php

require 'vendor/autoload.php';

use Omnipay\PayU\GatewayFactory;

$dotenv = new Dotenv\Dotenv(__DIR__);
$dotenv->load();

// default is official sandbox
$posId = isset($_ENV['POS_ID']) ? $_ENV['POS_ID'] : '300046';
$secondKey = isset($_ENV['SECOND_KEY']) ? $_ENV['SECOND_KEY'] : '0c017495773278c50c7b35434017b2ca';
$oAuthClientSecret = isset($_ENV['OAUTH_CLIENT_SECRET']) ? $_ENV['OAUTH_CLIENT_SECRET'] : 'c8d4b7ac61758704f38ed5564d8c0ae0';

dump($posId);

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


    $purchaseRequest = [
        'customerIp'    => '127.0.0.1',
        'continueUrl'   => $returnUrl,
        'merchantPosId' => $posId,
        'description'   => $description,
        'currencyCode'  => 'PLN',
        'totalAmount'   => 15000,
        'exOrderId'     => $orderNo,
        'buyer'         => (object)[
            'email'     => 'jan.machala+payu@bileto.com',
            'firstName' => 'Jan',
            'lastName'  => 'Machala',
            'language'  => 'pl'
        ],
        'products'      => [
            (object)[
                'name'      => 'Jizdnky',
                'unitPrice' => 15000,
                'quantity'  => 1
            ]
        ],
        'payMethods'    => (object) [
            'payMethod' => (object) [
                'type'  => 'PBL', // this is for card-only forms (no bank transfers available)
                'value' => 'c'
            ]
        ]

    ];


    $response = $gateway->purchase($purchaseRequest);

    echo "TransactionId: " . $response->getTransactionId() . PHP_EOL;

    echo 'Is Successful: ' . (bool) $response->isSuccessful() . PHP_EOL;
    echo 'Is redirect: ' . (bool) $response->isRedirect() . PHP_EOL;

    // Payment init OK, redirect to the payment gateway
    echo $response->getRedirectUrl() . PHP_EOL;
} catch (\Exception $e) {
    dump((string)$e);
}