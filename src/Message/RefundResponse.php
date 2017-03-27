<?php

namespace Omnipay\OKPAY\Message;

use Omnipay\Common\Message\AbstractResponse;
use Omnipay\Common\Message\RequestInterface;
use Omnipay\OKPAY\Support\Helpers;

class RefundResponse extends AbstractResponse
{
    protected $redirectUrl;
    protected $message;
    protected $success;

    public function __construct(RequestInterface $request, $data)
    {
        $this->request = $request;
        $this->data = $data;
        $this->success = false;
        $this->parseResponse($data);
    }

    public function isSuccessful()
    {
        return $this->success;
    }

    public function getMessage()
    {
        return $this->message;
    }

    private function parseResponse($data)
    {
        if ($data->Status != 'Completed') {
            $this->message = $data->Status;
            $this->success = false;

            return false;
        }
        $this->success = true;
    }

}
