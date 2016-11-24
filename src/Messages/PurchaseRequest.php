<?php
namespace Omnipay\PayU\Messages;

use Omnipay\Common\Message\AbstractRequest;
use Omnipay\Common\Message\ResponseInterface;

class PurchaseRequest extends AbstractRequest
{

    /**
     * @return array
     */
    public function getData()
    {
        return $this->getParameters();
    }

    /**
     * Send the request with specified data
     *
     * @param  mixed $data The data to send
     * @return ResponseInterface
     */
    public function sendData($data)
    {
        $headers = [
            'Accept'        => 'application/json',
            'Content-Type'  => 'application/json',
            'Authorization' => $data['accessToken']
        ];
        $apiUrl = $data['apiUrl'] . '/api/v2_1/orders';
        if (isset($data['purchaseData']['extOrderId'])) {
            $this->setTransactionId($data['purchaseData']['extOrderId']);
        }
        $httpRequest = $this->httpClient->post($apiUrl, $headers, json_encode($data['purchaseData']));
        $httpRequest->configureRedirects(true, 0);
        $httpResponse = $httpRequest->send();
        $responseData = $httpResponse->json();
        $response = new PurchaseResponse($this, $responseData);

        return $this->response = $response;
    }

    /**
     * @param string $apiUrl
     */
    public function setApiUrl($apiUrl)
    {
        $this->setParameter('apiUrl', $apiUrl);
    }

    /**
     * @param array $data
     */
    public function setPurchaseData($data)
    {
        $this->setParameter('purchaseData', $data);
    }

    /**
     * @param string $accessToken
     */
    public function setAccessToken($accessToken)
    {
        $this->setParameter('accessToken', $accessToken);
    }

}