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
        $crl = curl_init('https://apps.gateway.sa/vendorsms/pushsms.aspx?user='.$user.'
        &password='.$password.'
        &msisdn='.$phoneNumber.'&sid='.$sender.'&msg='.$message.'&fl=0');
        curl_setopt($crl, CURLOPT_RETURNTRANSFER, true);
//        curl_setopt($crl, CURLINFO_HEADER_OUT, true);
//        curl_setopt($crl, CURLOPT_POST, true);
//        curl_setopt($crl, CURLOPT_POSTFIELDS, $post_data);

        // Set HTTP Header for POST request
//        curl_setopt($crl, CURLOPT_HTTPHEADER, array(
//                'authorization: STJN99NK6Z-JBDZL26RHN-N2RJBBJWTD',
//                'content-type: application/json',
//            )
//        );
        // Submit the POST request
        $result = curl_exec($crl);
dd($result);
        $decodedResult = json_decode($result); //redirect_url

        if (isset($decodedResult->redirect_url)) {
            return redirect($decodedResult->redirect_url);
        }

        curl_close($crl);
        return ['longitude' => '', 'latitude' => ''];
    }



}
