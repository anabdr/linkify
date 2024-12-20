<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Link;
use Illuminate\Support\Str;
use Validator;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

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

    public function delete (Request $request){
        $validator = Validator::make(request()->all(), [
            'code' => 'required',
        ]);
          
        if($validator->fails()){
            return response()->json($validator->errors()->toJson(), 400);
        }

        $user = auth()->user();

        try{

            $url = $this->searchLink('code',$request->code,$user->id);

            if($url){

                $url->delete();
                return response()->json(200);

            }else{
                return response()->json(500);
            }
        }catch(Exception $e){
            file_put_contents('errorDeleteLink.txt', $e->getMessage() . PHP_EOL, FILE_APPEND);
        }
    }

    public function addClick (Request $request){
        $validator = Validator::make(request()->all(), [
            'code' => 'required',
        ]);
          
        if($validator->fails()){
            return response()->json($validator->errors()->toJson(), 400);
        }
        try{

            $user = auth()->user();

            $link = $this->searchLink('code',$request->code,$user->id);            
            
            if($link){

                $this->addCount($link,$user->id);
                
                return response()->json(200);
            }            

        }catch(Exception $e){
            file_put_contents('addClick.txt', $e->getMessage() . PHP_EOL, FILE_APPEND);
        }
    }

    public function all(){
        try{
            $user = auth()->user();
            
            $links = Link::leftJoin('days_links', 'days_links.link_id', '=', 'links.id')
                ->where('links.user_id', $user->id)
                ->select(
                    'links.user_id as user_id',
                    'links.url as url',
                    'links.code as code',
                    DB::raw('COALESCE(SUM(days_links.count), 0) as count'),
                    DB::raw('COALESCE(MAX(days_links.date), NULL) as date') 
                )
                ->groupBy('links.user_id', 'links.url', 'links.code')
                ->get();

            return response()->json($links,200);

        }catch(Exception $e){

            file_put_contents('errorAllLink.txt', $e->getMessage() . PHP_EOL, FILE_APPEND);

        }
    }

    public function redirectLink($link){

        try{

            $user = auth()->user();

            $link = Link::where('code',$link)->first();            

            if($link){

                $this->addCount($link);               

                return redirect()->away($link->url);

            } else {

                return response()->json('No se ha encontrado el link',500);
            }


        }catch (Exception $e) {

            file_put_contents('errorRedirect.txt', $e->getMessage() . PHP_EOL, FILE_APPEND);

        }

    }

    public function searchLink($name,$value,$userId){

        $link = Link::where($name,$value)
                ->where('user_id',$userId)
                ->first();

        return $link;
    }

    public function addCount($link,$userId=null){

        $date = Carbon::now()->format('Y-m-d');
        
        $query = DB::table('days_links')
            ->where('link_id',$link->id)
            ->where('date', Carbon::now()->format('Y-m-d'));
            if($userId){
                $query->where('user_id', $userId);
            }
        $daysLinks = $query->first();


        if($daysLinks){
            $count = intval($daysLinks->count);
                    
            DB::table('days_links')
                ->where('id',$daysLinks->id)
                ->update([
                    'count' => $count+1
                ]);
        }else{
            DB::table('days_links')
                ->insert([
                    'date' => $date,
                    'link_id' => $link->id,
                    'count' => 1,                            
                ]);
        }
        
    }
}
