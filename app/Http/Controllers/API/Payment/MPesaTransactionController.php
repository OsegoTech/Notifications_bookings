<?php

namespace App\Http\Controllers\API\Payment;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class MPesaTransactionController extends Controller
{
    //generate token
    protected function getAccessToken(): string
    {
        $key = 'lgSqtu4xLhKb8QjjaGAhjhwiYhiwMnkM';
        $secret = 'BlAE5WAVRBAcHb4L';
        $credentials = base64_encode("$key:$secret");

        $url = 'https://sandbox.safaricom.co.ke/oauth/v1/generate?grant_type=client_credentials';

        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_HTTPHEADER, array('Authorization: Basic '.$credentials)); //setting a custom header
        curl_setopt($curl, CURLOPT_HEADER, true);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        $curl_response = curl_exec($curl);

        $headerSize = curl_getinfo($curl, CURLINFO_HEADER_SIZE);
        $body = substr($curl_response, $headerSize);

        curl_close($curl);
        $body = json_decode($body, true);
        return $body['access_token'];
    }
    //make stk push request
    public function stkPush():array
    {
        $data=[
            "BusinessShortCode"=> "174379",
            "Password"=> "MTc0Mzc5YmZiMjc5ZjlhYTliZGJjZjE1OGU5N2RkNzFhNDY3Y2QyZTBjODkzMDU5YjEwZjc4ZTZiNzJhZGExZWQyYzkxOTIwMTYwMjE2MTY1NjI3",
            "Timestamp"=>"20160216165627",
            "TransactionType"=> "CustomerPayBillOnline",
            "Amount"=> "1",
            "PartyA"=>"254743168819",
            "PartyB"=>"174379",
            "PhoneNumber"=>"254743168819",
            "CallBackURL"=> "https://6b83-41-90-69-116.ngrok-free.app",
            "AccountReference"=>"Test",
            "TransactionDesc"=>"Test"
        ];
        $url = 'https://sandbox.safaricom.co.ke/mpesa/stkpush/v1/processrequest';

        $curl = curl_init();
        curl_setopt($curl, CURLINFO_HEADER_OUT , true);
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_HTTPHEADER, array('Content-Type:application/json','Authorization:Bearer '.$this->getAccessToken()));

        $curl_post_data = $data;

        $data_string = json_encode($curl_post_data);

        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_POST, true);
        curl_setopt($curl, CURLOPT_POSTFIELDS, $data_string);

        $curl_response = curl_exec($curl);

        curl_close($curl);

        dd($curl_response);

        return response()->json([
            'data'=>$curl_response
        ]);
    }

    //check transaction status
    //process callback
}
