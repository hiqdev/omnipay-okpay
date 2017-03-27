<?php

namespace Omnipay\OKPAY;

use Omnipay\Common\AbstractGateway;

/**
 * Gateway Class
 */
class Gateway extends AbstractGateway
{
    public function getName()
    {
        return 'OKPAY';
    }

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
        return $this->getParameter('account_name');
    }

    public function setAccountName($value)
    {
        return $this->setParameter('account_name', $value);
    }

    public function getSecret()
    {
        return $this->getParameter('secret');
    }

    public function setSecret($value)
    {
        return $this->setParameter('secret', $value);
    }

    public function getDefaultParameters()
    {
        return array(
            'account' => '',
            'account_name' => '',
            'secret' => '',
        );
    }

    public function purchase(array $parameters = array())
    {
        return $this->createRequest('\Omnipay\OKPAY\Message\PurchaseRequest', $parameters);
    }

    public function completePurchase(array $parameters = array())
    {
        return $this->createRequest('\Omnipay\OKPAY\Message\CompletePurchaseRequest', $parameters);
    }

    public function refund(array $parameters = array())
    {
        return $this->createRequest('\Omnipay\OKPAY\Message\RefundRequest', $parameters);
    }
}
