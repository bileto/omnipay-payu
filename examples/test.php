<?php

require '../vendor/autoload.php';

use Omnipay\PayU\GatewayFactory;
use Omnipay\PayU\Messages\PurchaseResponse;

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/..');
$dotenv->load();

// default is official sandbox
$posId = isset($_ENV['POS_ID']) ? $_ENV['POS_ID'] : '300746';
$secondKey = isset($_ENV['SECOND_KEY']) ? $_ENV['SECOND_KEY'] : 'b6ca15b0d1020e8094d9b5f8d163db54';
$oAuthClientSecret = isset($_ENV['OAUTH_CLIENT_SECRET']) ? $_ENV['OAUTH_CLIENT_SECRET'] : '2ee86a66e5d97e3fadc400c9f19b065d';
$posAuthKey = isset($_ENV['POS_AUTH_KEY']) ? $_ENV['POS_AUTH_KEY'] : '300746';

$gateway = GatewayFactory::createInstance($posId, $secondKey, $oAuthClientSecret, true, $posAuthKey);

try {
    $orderNo = uniqid();
    $returnUrl = 'http://localhost:8000/gateway-return.php';
    $notifyUrl = 'http://127.0.0.1/uuid/notify';
    $description = 'Shopping at myStore.com';

    $purchaseRequest = [
        'purchaseData' => [
            'customerIp'    => '127.0.0.1',
            'continueUrl'   => $returnUrl,
            'notifyUrl'     => $notifyUrl,
            'merchantPosId' => $posId,
            'description'   => $description,
            'currencyCode'  => 'PLN',
            'totalAmount'   => 15000,
            'extOrderId'    => $orderNo,
            'buyer'         => (object)[
                'email'     => 'jan.machala+payu@bileto.com',
                'firstName' => 'Peter',
                'lastName'  => 'Morek',
                'language'  => 'pl'
            ],
            'products'      => [
                (object)[
                    'name'      => 'Lenovo ThinkPad Edge E540',
                    'unitPrice' => 15000,
                    'quantity'  => 1
                ]
            ],
            'payMethods'    => (object)[
                'payMethod' => (object)[
                    'type'  => 'PBL', // this is for card-only forms (no bank transfers available)
                    'value' => 'c'
                ]
            ]
        ]
    ];

    /** @var PurchaseResponse $response */
    $response = $gateway->purchase($purchaseRequest);

    echo "TransactionId: " . $response->getTransactionId() . PHP_EOL;
    echo "TransactionReference: " . $response->getTransactionReference() . PHP_EOL;
    echo 'Is Successful: ' . (bool)$response->isSuccessful() . PHP_EOL;
    echo 'Is redirect: ' . (bool)$response->isRedirect() . PHP_EOL;

    // Payment init OK, redirect to the payment gateway
    echo $response->getRedirectUrl() . PHP_EOL;
} catch (OpenPayU_Exception $e) {
    dump($e->getMessage());
} catch (Exception $e) {
    dump((string)$e);
}
