<?php

namespace Omnipay\PayU;

use Omnipay\Common\AbstractGateway;
use Omnipay\Common\Message\ResponseInterface;
use Omnipay\PayU\Messages\AccessTokenRequest;
use Omnipay\PayU\Messages\AccessTokenResponse;
use Omnipay\PayU\Messages\CompletePurchaseRequest;
use Omnipay\PayU\Messages\PurchaseRequest;

class Gateway extends AbstractGateway
{
    const URL_SANDBOX = 'https://secure.snd.payu.com';
    const URL_PRODUCTION = 'https://secure.payu.com';

    /** @var bool */
    private $isProductionMode;

    /**
     * Get gateway display name
     */
    public function getName()
    {
        return 'PayU';
    }

    /**
     * @return AccessTokenResponse
     */
    public function getAccessToken()
    {
        $request = parent::createRequest(AccessTokenRequest::class, [
            'clientId' => $this->parameters->get('posId'),
            'clientSecret' => $this->parameters->get('clientSecret'),
            'apiUrl' => $this->getApiUrl()
        ]);
        $response = $request->send();
        return $response;
    }

    /**
     * @param array $parameters
     * @return ResponseInterface
     */
    public function purchase(array $parameters = array())
    {
        $accessTokenResponse = $this->getAccessToken();
        $request = parent::createRequest(PurchaseRequest::class, [
            'accessToken' => $accessTokenResponse->getAccessToken(),
            'purchaseData' => $parameters,
            'apiUrl' => $this->getApiUrl()
        ]);
        $response = $request->send();
        return $response;
    }

    /**
     * @param array $parameters
     * @return CompletePurchaseRequest
     */
    public function completePurchase(array $parameters = array())
    {
        return $this->createRequest(CompletePurchaseRequest::class, $parameters);
    }

    /**
     * @return string
     */
    private function getApiUrl()
    {
        if ($this->isProductionMode) {
            return self::URL_PRODUCTION;
        } else {
            return self::URL_SANDBOX;
        }
    }

    public function getDefaultParameters()
    {
        return [
            'posId' => '',
            'secondKey' => '',
            'clientSecret' => '',
            'isProductionMode' => false,
        ];
    }

    /**
     * @param string $secondKey
     */
    public function setSecondKey($secondKey)
    {
        $this->parameters->set('secondKey', $secondKey);
    }

    /**
     * @param string $posId
     */
    public function setPosId($posId)
    {
        $this->parameters->set('posId', $posId);
    }

    /**
     * @param string $clientSecret
     */
    public function setClientSecret($clientSecret)
    {
        $this->parameters->set('clientSecret', $clientSecret);
    }

    /**
     * @param mixed $isProductionMode
     */
    public function setIsProductionMode($isProductionMode)
    {
        $this->isProductionMode = $isProductionMode;
    }
}