<?php

namespace Cyaxaress\Payment\Gateways\Zarinpal;

class Zarinpal
{
    private $merchant_id;

    private $callback_url;

    private $zarinpal_url = 'https://www.zarinpal.com/pg/services/WebGate/wsdl';

    public function __construct($merchant_id, $callback_url)
    {
        $this->merchant_id = $merchant_id;
        $this->callback_url = $callback_url;
    }

    private function error_message($code, $desc, $cb, $request = false)
    {
        if (empty($cb) && $request === true) {
            return 'CallbackURL should not be empty';
        }

        if (empty($desc) && $request === true) {
            return 'Transaction Description should not be empty';
        }

        $error = [
            '-1' => 'The submitted information is incomplete.',
            '-2' => 'The IP or Merchant code is incorrect.',
            '-3' => 'Due to Shaparak limitations, payment with the requested amount is not possible.',
            '-4' => 'The merchant\'s verification level is below silver.',
            '-11' => 'The requested transaction was not found.',
            '-12' => 'Editing the request is not possible.',
            '-21' => 'No financial operations found for this transaction.',
            '-22' => 'The transaction is unsuccessful.',
            '-33' => 'The transaction amount does not match the paid amount.',
            '-34' => 'The transaction split limit has been exceeded in terms of amount or count.',
            '-40' => 'Access to the related method is not allowed.',
            '-41' => 'Submitted AdditionalData is invalid.',
            '-42' => 'The payment ID lifespan must be between 30 minutes to 45 days.',
            '-54' => 'The requested transaction has been archived.',
            '100' => 'The operation was completed successfully.',
            '101' => 'The payment was successful and the transaction has already been verified.',
        ];

        if (array_key_exists("{$code}", $error)) {
            return $error["{$code}"];
        } else {
            return 'Unknown error while connecting to Zarinpal gateway';
        }
    }

    public function request($amount, $description, $mobile = null, $email = null)
    {
        $client = new SoapClient($this->zarinpal_url, ['encoding' => 'UTF-8']);

        $data = [
            'MerchantID' => $this->merchant_id,
            'Amount' => $amount,
            'CallbackURL' => $this->callback_url,
            'Description' => $description,
            'Email' => $email,
            'Mobile' => $mobile,
        ];

        try {
            $result = $client->PaymentRequest($data);
            if ($result->Status == 100) {
                return [
                    'status' => true,
                    'url' => 'https://www.zarinpal.com/pg/StartPay/'.$result->Authority,
                    'authority' => $result->Authority,
                ];
            } else {
                return [
                    'status' => false,
                    'message' => $this->error_message($result->Status, $description, $this->callback_url, true),
                    'code' => $result->Status,
                ];
            }
        } catch (Exception $e) {
            return [
                'status' => false,
                'message' => 'Connection to payment gateway failed: '.$e->getMessage(),
                'code' => -100,
            ];
        }
    }

    public function verify($amount, $authority)
    {
        $client = new SoapClient($this->zarinpal_url, ['encoding' => 'UTF-8']);

        $data = [
            'MerchantID' => $this->merchant_id,
            'Amount' => $amount,
            'Authority' => $authority,
        ];

        try {
            $result = $client->PaymentVerification($data);
            if ($result->Status == 100 || $result->Status == 101) {
                return [
                    'status' => true,
                    'ref_id' => $result->RefID,
                    'code' => $result->Status,
                    'message' => $this->error_message($result->Status, '', '', false),
                ];
            } else {
                return [
                    'status' => false,
                    'code' => $result->Status,
                    'message' => $this->error_message($result->Status, '', '', false),
                ];
            }
        } catch (Exception $e) {
            return [
                'status' => false,
                'message' => 'Connection to payment gateway failed: '.$e->getMessage(),
                'code' => -100,
            ];
        }
    }
}
