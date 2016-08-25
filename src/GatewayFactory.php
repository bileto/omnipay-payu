<?php

namespace Omnipay\PayU;

use Omnipay\Omnipay;

class GatewayFactory
{
    /**
     * @param string $posId
     * @param string $secondKey (MD5)
     * @param string $oAuthClientSecret (MD5)
     * @param bool $isSandbox
     * @return Gateway
     */
    public static function createInstance($posId, $secondKey, $oAuthClientSecret, $isSandbox = false)
    {
        /** @var \Omnipay\PayU\Gateway $gateway */
        $gateway = Omnipay::create('PayU');
        $gateway->initialize([
            'posId' => $posId,
            'secondKey' => $secondKey,
            'clientSecret' => $oAuthClientSecret,
            'testMode' => $isSandbox
        ]);
        return $gateway;
    }
}