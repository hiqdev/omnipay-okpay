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

use Omnipay\Common\Message\AbstractResponse;
use Omnipay\Common\Message\RedirectResponseInterface;

class CompletePurchaseResponse extends AbstractResponse implements RedirectResponseInterface
{
    public function isSuccessful()
    {
        return ($this->data['ok_txn_status'] === 'completed') ? true : false;
    }

    public function isCancelled()
    {
        return ($this->data['ok_txn_status'] !== 'completed') ? true : false;
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
        return intval($this->data['ok_txn_id']);
    }

    public function getAmount()
    {
        return $this->data['ok_txn_gross'];
    }

    public function getCurrency()
    {
        return $this->data['ok_txn_currency'];
    }

    public function getDescription()
    {
        return $this->data['ok_item_1_name'];
    }

    public function getPurse()
    {
        return $this->data['ok_receiver'];
    }

    public function getFee()
    {
        return $this->data['ok_txn_fee'];
    }

    public function getPayer()
    {
        return $this->data['ok_payer_first_name'] . ' ' . $this->data['ok_payer_last_name'] . ' / ' . $this->data['ok_payer_email'];
    }

    public function getTime()
    {
        return new \DateTime($this->data['ok_txn_datetime']);
    }
}
