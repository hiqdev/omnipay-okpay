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

use Omnipay\Common\Exception\InvalidRequestException;

class RefundRequest extends AbstractRequest
{
    protected $endpoint = 'https://api.okpay.com/OkPayAPI?wsdl';

    public function getSecret()
    {
        return $this->getParameter('secret');
    }

    public function setSecret($value)
    {
        return $this->setParameter('secret', $value);
    }

    public function getPayeeAccount()
    {
        return $this->getParameter('payeeAccount');
    }

    public function setPayeeAccount($value)
    {
        return $this->setParameter('payeeAccount', $value);
    }

    public function getData()
    {
        $this->validate('purse', 'payeeAccount', 'amount', 'secret', 'description');

        $data['secret'] = $this->getSecret();
        $data['walletId'] = $this->getPurse();
        $data['receiver'] = $this->getPayeeAccount();
        $data['amount'] = $this->getAmount();
        $data['currency'] = $this->getCurrency();
        $data['description'] = $this->getDescription();

        return $data;
    }

    public function sendData($data)
    {
        $response = $this->soapCall($data);

        return $this->response = new RefundResponse($this, $response);
    }

    private function soapCall($data)
    {
        $datePart = gmdate('Ymd');
        $timePart = gmdate('H');
        $authString = "{$data['secret']}:{$datePart}:{$timePart}";

        $sha256 = bin2hex(hash('sha256', $authString, true));
        $secToken = strtoupper($sha256);

        try {
            $client = new \SoapClient(
                $this->endpoint, [
                    'soap_version' => SOAP_1_1,
                    'stream_context' => stream_context_create(
                        [
                            'ssl' => [
                                'verify_peer' => false,
                                'verify_peer_name' => false,
                            ],
                        ]
                    ),
                ]
            );

            $this->WalletID = $data['walletId'];
            $this->SecurityToken = $secToken;
            $this->Currency = $data['currency'];
            $this->Receiver = $data['receiver'];
            $this->Amount = $data['amount'];
            $this->Comment = $data['description'];
            $this->IsReceiverPaysFees = false;

            $webService = $client->Send_Money($this);
            $wsResult = $webService->Send_MoneyResult;

            return $wsResult;
        } catch (\Exception $e) {
            throw new InvalidRequestException($e->getMessage());
        }
    }
}
