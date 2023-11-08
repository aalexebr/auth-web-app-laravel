<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Appointment;

class AppointmentController extends Controller
{
   public function appointments(){

    $user = auth()->user();
    $appointments = Appointment::where('admin_id',$user->id)
        ->with('guest')
        ->get();
    
    if($appointments){
        return response()->json([
            'appointments'=> $appointments
            ],200);  
    }
    return response()->json([
        'appointments'=> 'not found'
        ],404);
   }

}
