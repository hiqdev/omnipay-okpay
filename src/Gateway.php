<?php
/**
 * OKPAY driver for Omnipay PHP payment library.
 *
 * @link      https://github.com/hiqdev/omnipay-okpay
 * @package   omnipay-okpay
 * @license   MIT
 * @copyright Copyright (c) 2015-2017, HiQDev (http://hiqdev.com/)
 */

namespace Omnipay\OKPAY;

use Omnipay\Common\AbstractGateway;

/**
 * Gateway Class.
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

    public function setFees($value)
    {
        return $this->setParameter('fees', $value);
    }

    public function getFees()
    {
        return $this->getParameter('fees');
    }

    public function getDefaultParameters()
    {
        return [
            'purse' => '',
            'secret' => '',
            'fees' => 1,
        ];
    }

    public function purchase(array $parameters = [])
    {
        return $this->createRequest('\Omnipay\OKPAY\Message\PurchaseRequest', $parameters);
    }

    public function completePurchase(array $parameters = [])
    {
        return $this->createRequest('\Omnipay\OKPAY\Message\CompletePurchaseRequest', $parameters);
    }

    public function refund(array $parameters = [])
    {
        return $this->createRequest('\Omnipay\OKPAY\Message\RefundRequest', $parameters);
    }
}
