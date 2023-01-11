<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Http;
use Illuminate\Http\Request;
use Psr\Http\Message\RequestInterface;

class ImageController extends Controller
{

    public function postTransparency(Request $request) {
      $request->validate([
        "image_file"=>"required|image"
      ]);
      
        $file = $request->file("image_file");
      
        $response =Http::withHeaders([
          'x-api-key'=>"147d07b083abc001c55bbc9ba5c3138c79711358"
        ])
        ->post('https://sdk.photoroom.com/v1/segment', [
          "image_file_b64"=>base64_encode($file->get())
        ]);

        return response($response->body())->header("content-type", "image/png");
    }
    
}
