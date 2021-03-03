<?php

namespace App\Traits;
trait SmsSender
{
    protected function send($phoneNumber,$message)
    {
        // Prepare new cURL resource
        $user = 'tjmel';
        $password = 'tjmel4313477';
        $sender = 'TJMEL';
        $data = array(
            "user" => $user,
            "password" => $password,
            "sid" => $sender,
            "msisdn" => $phoneNumber,
            "msg" => $message,
            "fl" => '0',
            "dc" => '8',
        );
        $post_data = json_encode($data);
        $crl = curl_init('https://apps.gateway.sa/vendorsms/pushsms.aspx');
//        ?user='.$user.'
//    &password='.$password.'
//    &msisdn='.$phoneNumber.'&sid='.$sender.'&msg='.$message.'&fl=0&dc=8
        curl_setopt($crl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($crl, CURLINFO_HEADER_OUT, true);
        curl_setopt($crl, CURLOPT_POST, true);
        curl_setopt($crl, CURLOPT_POSTFIELDS, $post_data);

        // Set HTTP Header for POST request
        curl_setopt($crl, CURLOPT_HTTPHEADER, array(
                'Content-type: application/x-www-form-urlencoded',
                'Content-length: '. strlen($post_data) .''
            )
        );
        // Submit the POST request
        $result = curl_exec($crl);

        $decodedResult = json_decode($result); //redirect_url
        dd($decodedResult);
        if (isset($decodedResult->redirect_url)) {
            return redirect($decodedResult->redirect_url);
        }

        curl_close($crl);
        return ['longitude' => '', 'latitude' => ''];
    }



}
