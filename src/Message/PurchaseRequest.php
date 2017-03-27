<?php

namespace Omnipay\OKPAY\Message;

class PurchaseRequest extends AbstractRequest
{
    public function getAccount()
    {
        return $this->getParameter('account');
    }

    public function setAccount($value)
    {
        return $this->setParameter('account', $value);
    }

    public function getAccountName()
    {
        return $this->getParameter('accountName');
    }

    public function setAccountName($value)
    {
        return $this->setParameter('accountName', $value);
    }

    public function getEndpoint()
    {
        return $this->getTestMode() ? $this->testEndpoint : $this->liveEndpoint;
    }

    public function getData()
    {
        $this->validate('account', 'accountName', 'currency', 'amount');

        $data['ok_receiver'] = $this->getAccount();
        $data['ok_item_1_name'] = $this->getAccountName();
        $data['ok_currency'] = $this->getCurrency();
        $data['ok_item_1_price'] = $this->getAmount();
        $data['ok_invoice'] = $this->getTransactionId();

        return $data;
    }

    public function sendData($data)
    {
        return $this->response = new PurchaseResponse($this, $data, $this->getEndpoint());
    }
}
