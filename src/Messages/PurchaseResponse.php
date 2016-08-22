<?php

namespace Omnipay\PayU\Messages;

use Omnipay\Common\Message\AbstractResponse;
use Omnipay\Common\Message\RedirectResponseInterface;

class PurchaseResponse extends AbstractResponse implements RedirectResponseInterface
{
    /**
     * @return boolean
     */
    public function isSuccessful()
    {
        if ('SUCCESS' !== $this->data['status']['statusCode']) {
            return false;
        }
        $redirectUrl = $this->getRedirectUrl();

        return is_string($redirectUrl);
    }

    /**
     * Gets the redirect target url.
     */
    public function getRedirectUrl()
    {
        if (isset($this->data['redirectUri']) && is_string($this->data['redirectUri'])) {
            return $this->data['redirectUri'];
        } else {
            return null;
        }

    }

    /**
     * Get the required redirect method (either GET or POST).
     */
    public function getRedirectMethod()
    {
        return 'GET';
    }

    /**
     * Gets the redirect form data array, if the redirect method is POST.
     */
    public function getRedirectData()
    {
        return null;
    }

    /**
     * @return string
     */
    public function getState()
    {
        return $this->data['status']['statusCode'];
    }

    /**
     * PayU orderId
     * @return string
     */
    public function getTransactionId()
    {
        return (string)$this->data['orderId'];
    }

    /**
     * PayU orderId
     * @return string
     * todo: use getTransactionId
     */
    public function getTransactionReference()
    {
        return $this->getTransactionId();
    }

    public function isRedirect()
    {
        return is_string($this->data['redirectUri']);
    }
}