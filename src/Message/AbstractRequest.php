<?php

namespace Omnipay\OKPAY\Message;

use Omnipay\Common\Message\AbstractRequest as OmnipayRequest;

abstract class AbstractRequest extends OmnipayRequest
{
    protected $liveEndpoint = 'https://www.okpay.com/process.html';
    protected $testEndpoint = 'https://www.okpay.com/process.html';

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

    public function getEndpoint()
    {
        return $this->getTestMode() ? $this->testEndpoint : $this->liveEndpoint;
    }

    public function setDescription($value)
    {
        return $this->setParameter('description', $value);
    }

    public function getDescriotion()
    {
        return $this->getParameter('description');
    }
}
