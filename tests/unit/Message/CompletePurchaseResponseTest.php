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

use Omnipay\Tests\TestCase;

class CompletePurchaseResponseTest extends TestCase
{
    private $request;

    private $purse                  = 'purse@company.co';
    private $description            = 'sDf#$Sdf#$%';
    private $transactionReference   = '1234567890';
    private $transactionId          = '843145';
    private $amount                 = '8.69';
    private $currency               = 'USD';
    private $testMode               = true;
    private $status                 = 'completed';
    private $fee                    = '0.00';
    private $payer_first_name       = 'FirstName';
    private $payer_last_name        = 'LastName';
    private $payer_email            = 'email@example.com';
    private $datetime               = '2017-09-20 16:07:50';

    public function setUp()
    {
        parent::setUp();

        $this->request = new CompletePurchaseRequest($this->getHttpClient(), $this->getHttpRequest());
        $this->request->initialize([
            'purse'     => $this->purse,
            'secret'    => $this->secret,
            'testMode'  => $this->testMode,
        ]);
    }

    public function testSuccess()
    {
        $response = new CompletePurchaseResponse($this->request, [
            'ok_item_1_name'            => $this->description,
            'ok_receiver'               => $this->purse,
            'ok_txn_gross'              => $this->amount,
            'ok_txn_datetime'           => $this->datetime,
            'ok_invoice'                => $this->transactionId,
            'ok_txn_id'                 => $this->transactionReference,
            'ok_txn_status'             => $this->status,
            'ok_txn_currency'           => $this->currency,
            'ok_txn_fee'                => $this->fee,
            'ok_payer_first_name'       => $this->payer_first_name,
            'ok_payer_last_name'        => $this->payer_last_name,
            'ok_payer_email'            => $this->payer_email,
        ]);

        $this->assertTrue($response->isSuccessful());
        $this->assertNull($response->getMessage());
        $this->assertNull($response->getCode());
        $this->assertSame($this->amount,                $response->getAmount());
        $this->assertSame($this->description,           $response->getDescription());
        $this->assertSame($this->purse,                 $response->getPurse());
        $this->assertSame($this->currency,              $response->getCurrency());
        $this->assertSame($this->transactionId,         $response->getTransactionId());
        $this->assertSame($this->transactionReference,  $response->getTransactionReference());
        $this->assertSame($this->fee,                   $response->getFee());
        $this->assertEquals(new \DateTime($this->datetime), $response->getTime());
        $this->assertSame($this->payer_first_name . ' ' . $this->payer_last_name . ' / ' . $this->payer_email, $response->getPayer());
    }
}
