<?php

namespace Omnipay\OKPAY\Message;

use Omnipay\Common\Message\AbstractResponse;
use Omnipay\Common\Message\RedirectResponseInterface;

class CompletePurchaseResponse extends AbstractResponse implements RedirectResponseInterface
{
    public function isSuccessful()
    {
        return ($this->data['ok_txn_status'] == 'completed') ? true : false;
    }

    public function isCancelled()
    {
        return ($this->data['ok_txn_status'] != 'completed') ? true : false;
    }

    public function isRedirect()
    {
        return false;
    }

    public function getRedirectUrl()
    {
        return null;
    }

    public function getRedirectMethod()
    {
        return null;
    }

    public function getRedirectData()
    {
        return null;
    }

    public function getTransactionId()
    {
        return intval($this->data['ok_invoice']);
    }

    public function getAmount()
    {
        return floatval($this->data['ok_txn_amount']);
    }

    public function getCurrency()
    {
        return $this->data['ok_txn_currency'];
    }

    public function getMessage()
    {
        return null;
    }
}
