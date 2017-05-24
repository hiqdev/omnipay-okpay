<?php
/**
 * OKPAY driver for Omnipay PHP payment library.
 *
 * @link      https://github.com/hiqdev/omnipay-okpay
 * @package   omnipay-okpay
 * @license   MIT
 * @copyright Copyright (c) 2015-2017, HiQDev (http://hiqdev.com/)
 */

namespace Omnipay\OKPAY\Message;

class PurchaseRequest extends AbstractRequest
{
    public function getData()
    {
        $this->validate('purse', 'currency', 'amount', 'description');
        return [
            'ok_receiver' => $this->getPurse(),
            'ok_item_1_name' => $this->getDescription(),
            'ok_currency' => $this->getCurrency(),
            'ok_item_1_price' => $this->getAmount(),
            'ok_invoice' => $this->getTransactionId(),
            'ok_ipn' => $this->getNotifyUrl(),
            'ok_return_success' => $this->getReturnUrl(),
            'ok_return_fail' => $this->getCancelUrl(),
            'ok_fees' => $this->getFees(),
        ];
    }

    public function sendData($data)
    {
        return $this->response = new PurchaseResponse($this, $data, $this->getEndpoint());
    }
}
