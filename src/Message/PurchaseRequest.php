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
        $data['ok_receiver'] = $this->getPurse();
        $data['ok_item_1_name'] = $this->getDescription();
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
