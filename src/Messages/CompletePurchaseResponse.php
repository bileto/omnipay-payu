<?php

namespace Omnipay\PayU\Messages;

use Omnipay\Common\Message\AbstractResponse;

class CompletePurchaseResponse extends AbstractResponse
{
    /**
     * @return boolean
     */
    public function isSuccessful()
    {
        return 'SUCCESS' === $this->data['status']['statusCode'] ? true : false;
    }

    /**
     * @return string
     */
    public function getTransactionId()
    {
        return (string) $this->data['orders'][0]['orderId'];
    }

    /**
     * PAYMENT_ID is not present for transaction in state PENDING
     * @return null|string
     */
    public function getTransactionReference()
    {
        if(isset($this->data['properties'])) {
            $properties = $this->data['properties'];
            $paymentIdProperty = array_filter($properties, function ($item) {
                return $item['name'] === 'PAYMENT_ID';
            });
            if (isset($paymentIdProperty[0]['value'])) {
                return (string)$paymentIdProperty[0]['value'];
            }
        };

        return null;
    }

    /**
     * Status code (string)
     *
     * @return string
     */
    public function getCode()
    {
        return $this->data['orders'][0]['status'];
    }

}