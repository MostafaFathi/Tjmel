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
            "msisdn" => $phoneNumber,
            "sid" => $sender,
            "msg" => $message,
            "fl" => 0,
            "dc" => 8,
        );
        list($header, $content) = PostRequest(
            "https://apps.gateway.sa/vendorsms/pushsms.aspx?user=abc&password=xyz&msisdn=966500xxxxxx&sid=SenderId&msg=test%20message&fl=0&gwid=2 " // the url to post to
            , “”,
            $data
        );
//        echo $content;
        dd($content,'h');
        $post_data = json_encode($data);
        $crl = curl_init('https://apps.gateway.sa/vendorsms/pushsms.aspx');
//        ?user='.$user.'
//    &password='.$password.'
//    &msisdn='.$phoneNumber.'&sid='.$sender.'&msg='.$message.'&fl=0&dc=8
//        curl_setopt($crl, CURLOPT_RETURNTRANSFER, true);
//        curl_setopt($crl, CURLINFO_HEADER_OUT, true);
//        curl_setopt($crl, CURLOPT_POST, true);
//        curl_setopt($crl, CURLOPT_POSTFIELDS, $post_data);
//
//        // Set HTTP Header for POST request
//        curl_setopt($crl, CURLOPT_HTTPHEADER, array(
//                'Content-type: application/x-www-form-urlencoded',
//                'Content-length: '. strlen($post_data) .''
//            )
//        );
//        // Submit the POST request
//        $result = curl_exec($crl);
//
//        $decodedResult = json_decode($result); //redirect_url

        if (isset($decodedResult->redirect_url)) {
            return redirect($decodedResult->redirect_url);
        }

        curl_close($crl);
        return ['longitude' => '', 'latitude' => ''];
    }

    function PostRequest($url, $referer, $_data) {
        // convert variables array to string:
        $data = array();
        while(list($n,$v) = each($_data)){
            $data[] = "$n=$v";
        }
        $data = implode('&', $data);
        // format --> test1=a&test2=b etc.
        // parse the given URL
        $url = parse_url($url);
        if ($url['scheme'] != 'http') {
            die('Only HTTP request are supported !');
        }
        // extract host and path:
        $host = $url['host'];
        $path = $url['path'];
        // open a socket connection on port 80
        $fp = fsockopen($host, 80);
        // send the request headers:
        fputs($fp, "POST $path HTTP/1.1\r\n");
        fputs($fp, "Host: $host\r\n");
        fputs($fp, "Referer: $referer\r\n");
        fputs($fp, "Content-type: application/x-www-form-urlencoded\r\n");
        fputs($fp, "Content-length: ". strlen($data) ."\r\n");
        fputs($fp, "Connection: close\r\n\r\n");
        fputs($fp, $data);
        $result = '';
        while(!feof($fp)) {
            // receive the results of the request
            $result .= fgets($fp, 128);
        }
        // close the socket connection:
        fclose($fp);
        // split the result header from the content
        $result = explode("\r\n\r\n", $result, 2);
        $header = isset($result[0]) ? $result[0] : '';
        $content = isset($result[1]) ? $result[1] : '';
        // return as array:
        return array($header, $content);
    }

}
