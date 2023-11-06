<?php

namespace App\Http\Controllers\Guest;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Tymon\JWTAuth\Facades\JWTAuth;
use App\Models\User;

class GuestController extends Controller
{
    public function register(Request $request){
       
        $data = $request->validate([
            'name'=>'required',
            'surname'=>'required',
            'phone_number'=>'nullable',
            'email'=>'required|email|unique:users',
            'password'=>'required',
        ]);
       
        $phone = null;
        if(isset($data['phone_number'])){
            $phone = $data['phone_number'];
        }
        
         // User Model
         $user = User::create([
            "name" => $data['name'],
            'surname'=>$data['surname'],
            'phone_number'=>$phone,
            "email" => $data['email'],
            "password" => Hash::make($data['password']),
            'is_admin' => 0,
        ]);
        if($user){
            return response()->json([
                'message'=>'success',
                'user'=>$user
            ],200);
        }
        return response()->json([
            'message'=>'fail',
        ],405);

    }
}
