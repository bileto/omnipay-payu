<?php
namespace Omnipay\PayU\Messages;

use Omnipay\Common\Message\AbstractRequest;
use Omnipay\Common\Message\ResponseInterface;
use OpenPayU_Exception;
use OpenPayU_Order;
use OpenPayU_Result;

class PurchaseRequest extends AbstractRequest
{

    /**
     * @return array<string, mixed>
     */
    public function getData(): array
    {
        return $this->getParameters();
    }

    /**
     * Send the request with specified data
     *
     * @param array<string, mixed> $data The data to send
     * @return ResponseInterface|PurchaseResponse
     * @throws OpenPayU_Exception
     */
    public function sendData($data): ResponseInterface
    {
        if (isset($data['purchaseData']['extOrderId'])) {
            $this->setTransactionId($data['purchaseData']['extOrderId']);
        }
        /** @var OpenPayU_Result $response */
        $response = OpenPayU_Order::create($data['purchaseData']);

        $response = new PurchaseResponse($this, $response->getResponse());

        return $this->response = $response;
    }

    /**
     * @param array<string, mixed> $data
     */
    public function setPurchaseData(array $data): void
    {
        $this->setParameter('purchaseData', $data);
    }
}
