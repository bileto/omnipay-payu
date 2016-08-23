<?php
namespace Omnipay\PayU\Messages;

use Omnipay\Common\Message\AbstractRequest;
use Omnipay\Common\Message\ResponseInterface;

class CompletePurchaseRequest extends AbstractRequest
{

    /** @var string */
    private $apiUrl;
    /** @var string */
    private $accessToken;

    /**
     * @return mixed
     */
    public function getData()
    {
        return [];
    }

    /**
     * @param  mixed $data The data to send
     * @return ResponseInterface
     */
    public function sendData($data)
    {
        $headers = [
            'Accept'        => 'application/json',
            'Content-Type'  => 'application/json',
            'Authorization' => $this->accessToken
        ];
        $url = $this->apiUrl . '/api/v2_1/orders/' . urlencode($this->getTransactionId());
        $httpRequest = $this->httpClient->get($url, $headers);
        $httpResponse = $httpRequest->send();

        $response = new CompletePurchaseResponse($this, $httpResponse->json());
        return $this->response = $response;
    }

    /**
     * @param string $accessToken
     */
    public function setAccessToken($accessToken)
    {
        $this->accessToken = $accessToken;
    }

    /**
     * @param string $apiUrl
     */
    public function setApiUrl($apiUrl)
    {
        $this->apiUrl = $apiUrl;
    }
}