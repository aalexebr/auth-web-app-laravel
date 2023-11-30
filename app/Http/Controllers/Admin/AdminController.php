<?php

namespace App\Http\Controllers\Admin;
// requests
use App\Http\Requests\RegisterAdminRequest;
use App\Http\Requests\UpdateAdminRequest;
use App\Http\Requests\AdminProfilePicRequest;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Tymon\JWTAuth\Facades\JWTAuth;
use App\Models\Admin\AdminInfo;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;


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
       

        $phone = null;
        if(!isset($formData['phone_number'])){
            $phone = $user->phone_number;
        }
        else{
            if (empty(trim($formData['phone_number'])) || $formData['phone_number'] == null || !isset($formData['phone_number'])) {
                $phone = $user->phone_number;
            } 
            else{
                $phone = $formData['phone_number'];
            }
        }
        
        $name= null;
        if(!isset($formData['name'])){
            $name = $user->name;
        }
        else{
            if (empty(trim($formData['name'])) || $formData['name'] == null || !isset($formData['name'])) {
                $name = $user->name;
            } 
            else{
                $name = $formData['name'];
            }
        }
        $surname= null;
        if(!isset($formData['surname'])){
            $surname = $user->surname;
        }
        else{
            if (empty(trim($formData['surname'])) || $formData['surname'] == null || !isset($formData['surname'])) {
                $surname = $user->surname;
            } 
            else{
                $surname = $formData['surname'];
            }
        }

        $user->update([
            'name' => $name,
            'surname' => $surname,
            'phone_number' => $phone,
        ]);

        // PROFESSION
        if(isset($formData['profession'])){
            $user->professions()->sync($formData['profession']);
        }

        // ADMIN INFO

        $adminInfo = AdminInfo::where('admin_id',$user->id)->firstOrFail();

        $description= null;
        if(!isset($formData['description'])){
            $description = $adminInfo->description;
        }
        else{
            if (empty(trim($formData['description'])) || $formData['description'] == null || !isset($formData['description'])) {
                $description = $adminInfo->description;
            } 
            else{
                $description = $formData['description'];
            }
        }
        
        $address= null;
        if(!isset($formData['address'])){
            $address = $adminInfo->address;
        }
        else{
            if (empty(trim($formData['address'])) || $formData['address'] == null || !isset($formData['address'])) {
                $address = $adminInfo->address;
            } 
            else{
                $address = $formData['address'];
            }
        }

        // file saving / update



    
        $adminInfo->update([
            'description'=>$description,
            'address'=>$address,
        ]);

    
      
        if($user && $adminInfo){
           return response()->json([
                "message"=> "Modificato con successo",
                'x'=>$formData
            ],200); 
        }
        return response()->json([
            "message"=> "Modificato con successo",
            'data' => $formData
        ],200); 
        
        // return response()->json([
        //     'message'=>'fail',
        // ],405);
        
    }

    public function x(Request $request)
    {
        
        $formData = $request->validate([
            'file'=>'nullable'
        ]);
        if($request->file('file')){
            $file = $request->file('file');
            $fileStored = Storage::put('admin_profile',$file);
        }
        else{
            $fileStored = null;
        }
        
       
        return response()->json([
                    'success'=>true,
                    'message'=> 'successful file upload',
                    'file'=>$formData
                ],200);
    
        
        
    }

    public function adminProfilePic(AdminProfilePicRequest $request)
    {
        
        $user = auth()->user();
        // $userId = User::findOrFail($user->id);
        $adminInfo = AdminInfo::where('admin_id',$user->id)->firstOrFail();
        $profilePic = null;
        if($request->file('file')){
            $file = $request->file('file');
            $profilePic = Storage::put('admin_profile',$file);
        }
        else{
            $profilePic = $adminInfo->picture;
        }
        
        $confirmation = $adminInfo->update([
            'picture'=>$profilePic,
        ]);

        if($confirmation){
            return response()->json([
                    'success'=>true,
                    'message'=> 'successful file upload',
                    'file'=>$profilePic
                ],200);
        }
        return response()->json([
            'message'=>'failed upload',
        ],405);  
        
    }

    public function adminCV(Request $request)
    {
        
        $user = auth()->user();
        // $userId = User::findOrFail($user->id);
        $adminInfo = AdminInfo::where('admin_id',$user->id)->firstOrFail();
        $profilePic = null;
        if($request->file('file')){
            $file = $request->file('file');
            $profilePic = Storage::put('admin_profile',$file);
        }
        else{
            $profilePic = $adminInfo->picture;
        }
        
        $confirmation = $adminInfo->update([
            'picture'=>$profilePic,
        ]);

        if($confirmation){
            return response()->json([
                    'success'=>true,
                    'message'=> 'successful file upload',
                    'file'=>$profilePic
                ],200);
        }
        return response()->json([
            'message'=>'failed upload',
        ],405);

        
    }

    
}
