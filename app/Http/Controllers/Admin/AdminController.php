<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Tymon\JWTAuth\Facades\JWTAuth;

class AdminController extends Controller
{
    public function registerAdmin(Request $request){
       
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
            'is_admin' => 1,
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

    public function getAdmin()
    {
        $user1 = auth()->user();
        $user = User::with('adminInfo','professions')->findOrFail($user1->id);
        
        if($user){
            return response()->json([
                'user'=> $user
                ],200);  
        }
        return response()->json([
            'message'=> 'user not found'
            ],404);
        
    }
}
