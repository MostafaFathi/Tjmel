<?php

namespace App\Traits;
trait SmsSender
{
    protected function send($phoneNumber, $message)
    {
        $user = 'tjmel';
        $password = 'tjmel4313477';
        $sender = 'THEPLANET';
        $message = urlencode($message);

        $crl = curl_init('https://apps.gateway.sa/vendorsms/pushsms.aspx?user=' . $user . '&password=' . $password . '&msisdn=' . $phoneNumber . '&sid=' . $sender . '&msg=' . $message . '&fl=0&gwid=2&dc=8');

        curl_setopt($crl, CURLOPT_RETURNTRANSFER, true);

        $result = '';//curl_exec($crl);

        curl_close($crl);
        return json_decode($result);
    }

}
