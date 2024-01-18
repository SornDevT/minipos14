<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class UserController extends Controller
{
    //
    public function register(Request $request){

        try {
            
            $user = new User([
                'name' => $request->from_user_name,
                'email' => $request->from_email,
                'password' => hash::make($request->from_password)
            ]);
            $user->save();
            
            $success = true;
            $message = 'ບັນທຶກສຳເລັດ!';
            

        } catch (\Illuminate\Database\QueryException $ex) {
            //throw $th;
            $success = false;
            $message = $ex->getMessage();
        }

        $response = [
            'success' => $success,
            'message' => $message
        ];
        
        return response()->json($response);
    }
}
