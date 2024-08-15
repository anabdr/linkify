<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UserController extends Controller
{
     

    public function modify(Request $request){

        $validated = $request->validate([
            'title' => 'required|unique:posts|max:255',
            'body' => 'required',
        ]);
        try{

        }catch(Exception $e){

        }
    }

    public function delete(Request $request){
        try{

        }catch(Exception $e){
            
        }
    }
}
