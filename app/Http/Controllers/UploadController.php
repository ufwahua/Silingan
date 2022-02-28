<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class UploadController extends Controller
{
    public function uploadImage(Request $request){
        $response=[];
          if ($request->hasfile('images')) {
            $images = $request->file('images');

                foreach($images as $image ){

                    $imagename = $image->getClientOriginalName();
                    $folderpath =$image->storeAs('public/images',$request['user_id']."/".$imagename);
                    
                    array_push($response,Storage::url($folderpath));
                }
            return response($response);
        }
         return response($request->file('images'));
    }   
}
