<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Link;
use Illuminate\Support\Str;
use Validator;

class LinkController extends Controller
{
    public function add(Request $request){

        $validator = Validator::make(request()->all(), [
            'url' => 'required',
        ]);
  
        if($validator->fails()){
            return response()->json($validator->errors()->toJson(), 400);
        }

        try{
            $link = new Link();
            $link->url = $request->url;
            $link->code = Str::random(6);
            $link->user_id = 1;
            $link->save();

            return response()->json($link->code, 200);
            
        }catch(Exception $e){
            file_put_contents('errorAddLink', $e->getMessage());
        }

              

    }
}
