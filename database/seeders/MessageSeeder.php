<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use App\Models\Message;
use Illuminate\Support\Facades\Schema;
use App\Models\Appointment;

class MessageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Schema::withoutForeignKeyConstraints(function(){
            Message::truncate();
        });

        // $appointments = Appointment::all();

        for ($i=0; $i < 10; $i++) { 
            $admin = rand(1,2);
            $guest = rand(3,4);
            $appointments = Appointment::where('guest_id',$guest)->get();
            $appointment_id = [];
            foreach($appointments as $apt){
                $appointment_id[]= $apt->id;
            }
            $key = array_rand($appointment_id);
            Message::create([
                'admin_id' => $admin,
                'guest_id' => $guest,
                'appointment_id'=> $appointment_id[$key],
                'message'=> fake()->sentence(),
            ]);

        }
    }
}
