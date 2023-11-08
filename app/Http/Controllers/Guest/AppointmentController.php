<?php

namespace App\Http\Controllers\Guest;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Appointment;

class AppointmentController extends Controller
{
    public function appointments(){

        $user = auth()->user();
        $appointments = Appointment::where('guest_id',$user->id)
            ->with('admin')
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
