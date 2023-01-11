<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Psr\Http\Message\RequestInterface;

class ImageController extends Controller
{

    public function postTransparency(Request $request) {
        $curl = curl_init();

        curl_setopt_array($curl, [
          CURLOPT_URL => "https://sdk.photoroom.com/v1/segment",
          CURLOPT_RETURNTRANSFER => true,
          CURLOPT_ENCODING => "",
          CURLOPT_MAXREDIRS => 10,
          CURLOPT_TIMEOUT => 30,
          CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
          CURLOPT_CUSTOMREQUEST => "POST",
          CURLOPT_POSTFIELDS => "-----011000010111000001101001\r\nContent-Disposition: form-data; name=\"image_file\"\r\n\r\n\r\n-----011000010111000001101001\r\nContent-Disposition: form-data; name=\"format\"\r\n\r\n\r\n-----011000010111000001101001\r\nContent-Disposition: form-data; name=\"channels\"\r\n\r\n\r\n-----011000010111000001101001\r\nContent-Disposition: form-data; name=\"bg_color\"\r\n\r\n\r\n-----011000010111000001101001\r\nContent-Disposition: form-data; name=\"size\"\r\n\r\n\r\n-----011000010111000001101001\r\nContent-Disposition: form-data; name=\"crop\"\r\n\r\n\r\n-----011000010111000001101001--\r\n\r\n",
          CURLOPT_HTTPHEADER => [
            "Content-Type: multipart/form-data; boundary=---011000010111000001101001",
            "x-api-key:147d07b083abc001c55bbc9ba5c3138c79711358"
          ],
        ]);
        
        $response = curl_exec($curl);
        $err = curl_error($curl);
        
        curl_close($curl);
        
        if ($err) {
          echo "cURL Error #:" . $err;
        } else {
          echo $response;
        }
        dd($request);

    }
    //
}
