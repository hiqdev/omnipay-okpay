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

    public function getPurse()
    {
        return $this->getParameter('purse');
    }

    public function setPurse($value)
    {
        return $this->setParameter('purse', $value);
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
            'purse' => '',
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
