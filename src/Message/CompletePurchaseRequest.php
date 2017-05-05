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

use Omnipay\Common\Exception\InvalidResponseException;

class CompletePurchaseRequest extends AbstractRequest
{
    public function getData()
    {
        $request = 'ok_verify=true';

        foreach ($this->httpRequest->request->all() as $key => $value) {
            $value = urlencode(stripslashes($value));
            $request .= "&$key=$value";
        }

        $fsocket = false;
        $result = false;

        if ($fp = @fsockopen('ssl://www.okpay.com', 443, $errno, $errstr, 30)) {
            // Connected via HTTPS
            $fsocket = true;
        } elseif ($fp = @fsockopen('www.okpay.com', 80, $errno, $errstr, 30)) {
            // Connected via HTTP
            $fsocket = true;
        }

        // If connected to OKPAY
        if ($fsocket === true) {
            $header = 'POST /ipn-verify.html HTTP/1.0' . "\r\n" .
                'Host: www.okpay.com' . "\r\n" .
                'Content-Type: application/x-www-form-urlencoded' . "\r\n" .
                'Content-Length: ' . strlen($request) . "\r\n" .
                'Connection: close' . "\r\n\r\n";

            @fputs($fp, $header . $request);
            $string = '';
            while (!@feof($fp)) {
                $res = @fgets($fp, 1024);
                $string .= $res;
                // Find verification result in response
                if ($res === 'VERIFIED' || $res === 'INVALID' || $res === 'TEST') {
                    $result = $res;
                    break;
                }
            }
            @fclose($fp);
        }

        if ($result !== 'VERIFIED') {
            throw new InvalidResponseException('IPN verify failed: ' . $result);
        }

        return $this->httpRequest->request->all();
    }

    public function sendData($data)
    {
        return $this->response = new CompletePurchaseResponse($this, $data);
    }
}
