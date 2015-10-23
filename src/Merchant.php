<?php

/*
 * OKPAY plugin for PHP merchant library
 *
 * @link      https://github.com/hiqdev/php-merchant-okpay
 * @package   php-merchant-okpay
 * @license   BSD-3-Clause
 * @copyright Copyright (c) 2015, HiQDev (https://hiqdev.com/)
 */

namespace hiqdev\php\merchant\okpay;

class Merchant extends \hiqdev\php\merchant\Merchant
{
    protected static $_defaults = [
        'name'        => 'okpay',
        'label'       => 'OKPAY',
        'actionUrl'   => 'https://www.okpay.com/process.html',
        'checkUrl'    => 'https://www.okpay.com/ipn-verify.html',
        'confirmText' => 'OK',
        'fees'        => 1,
    ];

    public function getInputs()
    {
        return [
            'ok_receiver'       => $this->purse,
            'ok_fees'           => $this->fees,
            'ok_currency'       => strtoupper($this->currency),
            'ok_item_1_name'    => $this->description,
            'ok_item_1_price'   => $this->total,
            'ok_ipn'            => $this->confirmUrl,
            'ok_return_success' => $this->successUrl,
            'ok_return_fail'    => $this->failureUrl,
        ];
    }

    public function validateConfirmation($data)
    {
        if ($this->purse!=$data['ok_receiver']) {
            return 'Wrong receiver';
        }
        if ($data['ok_txn_status']!='completed') {
            return "Not completed: $data[ok_txn_status]";
        }
        $data['ok_verify'] = 'true';
        $result = static::curl($this->checkUrl, $data);
        if ($result!='VERIFIED') {
            return error("Not VERIFIED: $result");
        }
        $this->mset(array(
            'from'  => trim($data['ok_payer_first_name'].' '.$data['ok_payer_last_name']).'/'.$data['ok_payer_email'],
            'txn'   => $data['ok_txn_id'],
            'sum'   => $data['ok_txn_gross'],
            'time'  => $this->formatDatetime($data['ok_txn_datetime']),
        ));
        return null;
    }
}
