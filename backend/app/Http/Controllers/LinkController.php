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

        $user = auth()->user();

        try{

            $exist = Link::where('url',"http://" . $request->url)->first();

            if($exist){                
                return response()->json($exist->code,200);
            }else{
                $link = new Link();
                $link->url = "http://" . $request->url;
                $link->code = Str::random(6);
                $link->user_id = $user->id;;
                $link->save();
            }
            

            return response()->json($link->code, 200);
            
        }catch(Exception $e){
            file_put_contents('errorAddLink.txt', $e->getMessage() . PHP_EOL, FILE_APPEND);
        }              

    }

    public function all(){
        try{
            $user = auth()->user();
            
            $links = Link::where('user_id',$user->id)->get();

            return response()->json($links,200);

        }catch(Exception $e){

            file_put_contents('errorAllLink.txt', $e->getMessage() . PHP_EOL, FILE_APPEND);

        }
    }

    public function redirectLink($link){

        try{

            $link = Link::where('code',$link)->first();            

            if($link){

                $link->count++;
                $link->save();

                return redirect()->away($link->url);

            } else {

                return response()->json('No se ha encontrado el link',500);
            }


        }catch (Exception $e) {

            file_put_contents('errorRedirect.txt', $e->getMessage() . PHP_EOL, FILE_APPEND);

        }

    }
}
