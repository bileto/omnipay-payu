<?php
namespace Omnipay\PayU\Messages;

use Omnipay\Common\Message\AbstractRequest;
use Omnipay\Common\Message\ResponseInterface;

class PurchaseRequest extends AbstractRequest
{

    /** @var string */
    private $apiUrl;
    /** @var string */
    private $accessToken;

    public function getData()
    {
        return $this->getParameters()['purchaseData'];
    }

    /**
     * Send the request with specified data
     *
     * @param  mixed $data The data to send
     * @return ResponseInterface
     */
    public function sendData($data)
    {
        $apiUrl = $this->apiUrl . '/api/v2_1/orders';
        $headers = [
            'Accept'        => 'application/json',
            'Content-Type'  => 'application/json',
            'Authorization' => $this->accessToken
        ];
        $httpResponse = $this->httpClient->post($apiUrl, $headers, json_encode($data))->send();
        $responseData = $httpResponse->json();
        $response = new PurchaseResponse($this, $responseData);

        return $this->response = $response;
    }

    public function setApiUrl($apiUrl)
    {
        $this->apiUrl = $apiUrl;
    }

    public function setPurchaseData($data)
    {
        $this->setParameter('purchaseData', $data);
    }

    /**
     * @param string $accessToken
     */
    public function setAccessToken($accessToken)
    {
        $this->accessToken = $accessToken;
    }

}