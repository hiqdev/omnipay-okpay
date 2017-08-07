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
use Symfony\Component\HttpFoundation\Request as HttpRequest;

class CompletePurchaseRequestTest extends TestCase
{
    private $request;

    private $purse                  = 'OK426375940';
    private $description            = 'evo.ru-tld.ru: deposit valenp';
    private $transactionId          = 2705801;
    private $amount                 = 68.71;
    private $currency               = 'USD';
    private $timestamp              = '2014-03-22 19:54:58';
    private $testMode               = true;

    private $data = [
        'ok_charset' => 'utf-8',
        'ok_receiver' => 'OK426375940',
        'ok_receiver_id' => '532844008',
        'ok_receiver_wallet' => 'OK426375940',
        'ok_receiver_email' => 'ilia@krukover.com',
        'ok_txn_id' => 2705801,
        'ok_txn_kind' => 'payment_link',
        'ok_txn_payment_type' => 'instant',
        'ok_txn_payment_method' => 'OKB',
        'ok_txn_gross' => '68.71',
        'ok_txn_net' => '68.71',
        'ok_txn_fee' => '0.00',
        'ok_txn_currency' => 'USD',
        'ok_txn_datetime' => '2014-03-22 19:54:58',
        'ok_txn_status' => 'completed',
        'ok_invoice' => '',
        'ok_payer_status' => 'verified',
        'ok_payer_id' => '914126735',
        'ok_payer_reputation' => '0',
        'ok_payer_first_name' => 'Valentin',
        'ok_payer_last_name' => 'Perevalov',
        'ok_payer_email' => 'valenp@mail.ru',
        'ok_payer_phone' => '7-9080858303',
        'ok_payer_country' => 'Russia',
        'ok_payer_city' => 'Chelyabinsk',
        'ok_payer_country_code' => 'RU',
        'ok_payer_state' => 'Chelyabinskaya obl.',
        'ok_payer_address_status' => 'confirmed',
        'ok_payer_street' => 'Truda 24-136',
        'ok_payer_zip' => '454006',
        'ok_payer_address_name' => 'Postal',
        'ok_items_count' => '1',
        'ok_item_1_name' => 'evo.ru-tld.ru: deposit valenp',
        'ok_item_1_type' => 'digital',
        'ok_item_1_quantity' => '1',
        'ok_item_1_gross' => '68.71',
        'ok_item_1_price' => '68.71',
        'ok_ipn_id' => '2011795',
    ];

    public function setUp()
    {
        parent::setUp();

        $httpRequest = new HttpRequest([], $this->data);

        $this->request = new CompletePurchaseRequest($this->getHttpClient(), $httpRequest);
        $this->request->initialize([
            'purse'     => $this->purse,
            'secret'    => $this->secret,
            'testMode'  => $this->testMode,
        ]);
    }

    public function testGetData()
    {
        $data = $this->request->getData();

        $this->assertSame($this->description,   $data['ok_item_1_name']);
        $this->assertSame($this->transactionId, $data['ok_txn_id']);
        $this->assertSame($this->amount,        $data['ok_txn_gross']);
        $this->assertSame($this->timestamp,     $data['ok_txn_datetime']);
        $this->assertSame($this->purse,         $data['ok_receiver']);
    }

    public function testSendData()
    {
        //        $data = $this->request->getData();
        $response = $this->request->sendData($this->data);
        $this->assertInstanceOf('Omnipay\OKPAY\Message\CompletePurchaseResponse', $response);
    }
}
