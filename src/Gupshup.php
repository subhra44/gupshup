<?php

namespace Subhra\Gupshup;

use Illuminate\Support\Facades\Http;

class Gupshup
{
    protected $url = 'https://enterprise.smsgupshup.com/GatewayAPI/rest';
    protected $countryCode = '91';

    public function sendSms($mobile, $message)
    {
        $userid = config('gupshup.userid');
        $password = config('gupshup.password');

        $params = [
            'method' => 'sendMessage',
            'send_to' => $this->addCountryCode($mobile),
            'msg' =>  urlencode($message),
            'userid' => $userid,
            'password' => $password,
            'v' => "1.1",
            'msg_type' => "TEXT", //Can be "FLASH"/"UNICODE_TEXT"/"BINARY"
            'auth_scheme' => "PLAIN",
            'format' => 'JSON'
        ];

        $response = Http::post($this->url, $params)
            ->getBody()
            ->getContents();

        $response = json_decode($response);

        return $response;
    }

    /**
     * Prepending Country Code to Mobile Numbers
     * @param $mobile
     * @return array|string
     */
    private function addCountryCode($mobile)
    {
        if (is_array($mobile)) {
            array_walk($mobile, function (&$value, $key) {
                $value = $this->countryCode . $value;
            });
            return $mobile;
        }

        return $this->countryCode . $mobile;
    }
}
