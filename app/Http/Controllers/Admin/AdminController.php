<?php

namespace App\Http\Controllers\Admin;
// requests
use App\Http\Requests\RegisterAdminRequest;
use App\Http\Requests\UpdateAdminRequest;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Tymon\JWTAuth\Facades\JWTAuth;
use App\Models\Admin\AdminInfo;


class AdminController extends Controller
{
    public function registerAdmin(RegisterAdminRequest $request){
        $data = $request->all();
       
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

        $adminInfo = AdminInfo::create([
            'admin_id'=>$user->id,
            'resume'=>null,
            'picture'=>null,
            'address'=>null,
            'description'=>null,
        ]);
        if($user && $adminInfo){
            return response()->json([
                'message'=>'success',
                'user'=>$user,
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

    public function editAdmin(UpdateAdminRequest $request){
        $user1 = auth()->user();
        $user = User::with('adminInfo')->findOrFail($user1->id);
        $formData = $request->all();

        // $phone = null;
        // if(isset($formData['phone_number'])){
        //     $phone = $formData['phone_number'];
        // }

        $user->update([
            'name' => $formData['name'],
            'surname' => $formData['surname'],
            'phone_number' => $formData['phone_number'],
        ]);

        // PROFESSION
        if(isset($formData['profession'])){
            $user->professions()->sync($formData['profession']);
        }

        // ADMIN INFO

        $adminInfo = AdminInfo::where('admin_id',$user->id)->firstOrFail();

        // $resume =null;
        // $picture = null;
        // $description=null;
        // $address=null;

        // if(isset($formData['resume'])){
        //     $resume = $formData['resume'];
        // }
        // if(isset($formData['picture'])){
        //     $picture = $formData['picture'];
        // }
        // if(isset($formData['description'])){
        //     $description = $formData['description'];
        // }
        // if(isset($formData['address'])){
        //     $address = $formData['address'];
        // }

        $adminInfo->update([
            'resume'=>$formData['resume'],
            'picture'=>$formData['picture'],
            'description'=>$formData['description'],
            'address'=> $formData['address'],
        ]);
      
    
        return response()->json([
            "message"=> "Modificato con successo",
            'data' => $formData
        ],200); 
        
        // return response()->json([
        //     'message'=>'fail',
        // ],405);
        
    }
}
