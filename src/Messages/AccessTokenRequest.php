<?php
namespace Omnipay\PayU\Messages;

use Omnipay\Common\Message\AbstractRequest;

class AccessTokenRequest extends AbstractRequest
{

    /** @var string */
    private $apiUrl;

    /**
     * @param string $clientId
     */
    public function setClientId($clientId)
    {
        $this->setParameter('clientId', $clientId);
    }

    /**
     * @param string $clientSecret
     */
    public function setClientSecret($clientSecret)
    {
        $this->setParameter('clientSecret', $clientSecret);
    }

    public function sendData($data)
    {
        $authorizeUrl = $this->apiUrl . '/pl/standard/user/oauth/authorize';

        $headers = [
            'Accept' => 'application/json',
            'ContentType' => 'application/json',
        ];
        $tokenData = $this->httpClient->post($authorizeUrl, $headers, $data)->send();

        $response = new AccessTokenResponse($this, $tokenData->json());
        return $response;
    }

    /**
     * @return array
     */
    public function getData()
    {
        return [
            'grant_type' => 'client_credentials',
            'client_id' => $this->parameters->get('clientId'),
            'client_secret' => $this->parameters->get('clientSecret'),
        ];
    }

    /**
     * @param string $apiUrl
     */
    public function setApiUrl($apiUrl)
    {
        $this->apiUrl = $apiUrl;
    }
}