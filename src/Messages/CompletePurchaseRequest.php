<?php
namespace Omnipay\PayU\Messages;

use Exception;
use Omnipay\Common\Message\AbstractRequest;
use Omnipay\Common\Message\ResponseInterface;
use OpenPayU_Exception;
use OpenPayU_Order;

class CompletePurchaseRequest extends AbstractRequest
{

    public function setAccessToken(string $accessToken): void
    {
        $this->setParameter('accessToken', $accessToken);
    }

    /**
     * @return array<string, mixed>
     */
    public function getData(): array
    {
        return $this->getParameters();
    }

    /**
     * @param mixed $data The data to send
     * @return ResponseInterface|CompletePurchaseResponse
     * @throws OpenPayU_Exception
     * @throws Exception
     */
    public function sendData($data): ResponseInterface
    {
        $payUResponse = OpenPayU_Order::retrieve($this->getTransactionReference());

        if (!$payUResponse) {
            throw new Exception('Could not fetch order data');
        }

        $response = new CompletePurchaseResponse($this, $payUResponse->getResponse());

        return $this->response = $response;
    }
}
