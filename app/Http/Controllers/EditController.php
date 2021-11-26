<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Intervention\Image\Facades\Image;


class EditController extends Controller
{
    public function editPic(Request $request) {
           // Select l'activite en question
           $file = $request->file('image');
    
           $namefile = uniqid().".jpg";
   
           // = storage/app/uploads/images ;
           $destinationPath = public_path("img/".$namefile);
           
           // = Crée l'objet Image ;
           $image = Image::make($file->getRealPath());
           
           // Croppe et Enregistre l'image
           $image->resize(400, 400, function ($constraint) {
               $constraint->aspectRatio();
           })->encode('jpg', 100)->save($destinationPath);
   

         // Crée un gestionnaire cURL
        $ch = curl_init('https://sdk.photoroom.com/v1/segment');
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'x-api-key: 147d07b083abc001c55bbc9ba5c3138c79711358',
        ));
        // Crée un objet CURLFile
        $cfile = curl_file_create($destinationPath ,'image/jpeg','image_file');

        // Assigne les données POST
        $data = array('image_file' => $cfile);
        curl_setopt($ch, CURLOPT_POST,1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);

        // Exécute le gestionnaire
        $content = curl_exec($ch);

        dd($content);



        curl_close($ch);

   
        
    }

}
