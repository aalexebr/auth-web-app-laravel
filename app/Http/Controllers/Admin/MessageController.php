<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Message;

class MessageController extends Controller
{
    public function messages(){

        $user = auth()->user();
        $messages = Message::where('admin_id',$user->id)
            ->with('guest')
            ->get();
        
        if($messages){
            return response()->json([
                'messages'=> $messages
                ],200);  
        }
        return response()->json([
            'messages'=> 'not found'
            ],404);
       }
}
