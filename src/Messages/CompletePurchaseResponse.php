<?php

namespace Omnipay\PayU\Messages;

use Omnipay\Common\Message\AbstractResponse;

class CompletePurchaseResponse extends AbstractResponse
{
    /**
     * @return boolean
     */
    public function isSuccessful(): bool
    {
        return 'COMPLETED' === $this->getCode();
    }

    /**
     * @return string|null
     */
    public function getTransactionId(): ?string
    {
        if (isset($this->data->orders[0]->extOrderId) && !empty($this->data->orders[0]->extOrderId)) {
            return (string) $this->data->orders[0]->extOrderId;
        }

        return null;
    }

    public function isCancelled(): bool
    {
        return in_array($this->getCode(), ['CANCELED', 'REJECTED'], true);
    }

    /**
     * PAYMENT_ID is not present for transaction in state PENDING
     * @return null|string
     */
    public function getTransactionReference(): ?string
    {
        if (isset($this->data->orders[0]->orderId) && !empty($this->data->orders[0]->orderId)) {
            return (string) $this->data->orders[0]->orderId;
        }

        return null;
    }

    /**
     * Status code (string)
     *
     * @return string
     */
    public function getCode(): string
    {
        return $this->data->orders[0]->status;
    }

    public function isPending(): bool
    {
        return in_array($this->getCode(), ['PENDING', 'WAITING_FOR_CONFIRMATION', 'NEW']);
    }

    /**
     * @return string|null
     */
    public function getPaymentReference(): ?string
    {
        return $this->getTransactionReference();
    }
}
