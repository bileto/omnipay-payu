<?php

require '../vendor/autoload.php';

use Omnipay\PayU\GatewayFactory;
use Omnipay\PayU\Messages\CompletePurchaseResponse;

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/..');
$dotenv->load();

// default is official sandbox
$posId = isset($_ENV['POS_ID']) ? $_ENV['POS_ID'] : '300746';
$secondKey = isset($_ENV['SECOND_KEY']) ? $_ENV['SECOND_KEY'] : 'b6ca15b0d1020e8094d9b5f8d163db54';
$oAuthClientSecret = isset($_ENV['OAUTH_CLIENT_SECRET']) ? $_ENV['OAUTH_CLIENT_SECRET'] : '2ee86a66e5d97e3fadc400c9f19b065d';
$posAuthKey = isset($_ENV['POS_AUTH_KEY']) ? $_ENV['POS_AUTH_KEY'] : '300746';

$gateway = GatewayFactory::createInstance($posId, $secondKey, $oAuthClientSecret, true, $posAuthKey);

try {
    $completeRequest = ['transactionReference' => 'THTJ529R6W210622GUEST000P01'];
    /** @var CompletePurchaseResponse $response */
    $response = $gateway->completePurchase($completeRequest);

    echo "Is Successful: " . $response->isSuccessful() . PHP_EOL;
    echo "TransactionId: " . $response->getTransactionId() . PHP_EOL;
    echo "State code: " . $response->getCode() . PHP_EOL;
    echo "PaymentId: " , $response->getTransactionReference() . PHP_EOL;
    echo "Data: " . var_export($response->getData(), true) . PHP_EOL;

} catch (OpenPayU_Exception $e) {
    dump($e->getMessage());
} catch (Exception $e) {
    dump((string)$e);
}
