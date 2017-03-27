<?php

namespace Omnipay\OKPAY\Message;

use Omnipay\Common\Message\AbstractRequest as OmnipayRequest;

abstract class AbstractRequest extends OmnipayRequest
{
    protected $liveEndpoint = 'https://www.okpay.com/process.html';
    protected $testEndpoint = 'https://www.okpay.com/process.html';

    protected function getEndpoint()
    {
        return $this->getTestMode() ? $this->testEndpoint : $this->liveEndpoint;
    }
}
