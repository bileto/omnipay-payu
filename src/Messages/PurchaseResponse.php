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
        $redirectUrl = $this->data['redirectUri'];
        if (!is_array($this->data) || !isset($redirectUrl) || !is_string($redirectUrl)) {
            return null;
        }
        return $redirectUrl;
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

    public function getTransactionReference()
    {
        if (isset($this->data['orderId'])) {
            return $this->data['orderId'];
        }
        return null;
    }

    public function isRedirect()
    {
        return is_string($this->data['redirectUri']);
    }
}