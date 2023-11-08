<?php

namespace App\Http\Controllers\Guest;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Message;

class MessageController extends Controller
{
    public function messages(){

        $user = auth()->user();
        $messages = Message::where('guest_id',$user->id)
            ->with('admin')
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
