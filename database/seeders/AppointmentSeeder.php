<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Appointment;

// facades
use Illuminate\Support\Facades\Schema;

class AppointmentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Schema::withoutForeignKeyConstraints(function(){
            Appointment::truncate();
        });
        
        
        for ($i=0; $i < 10; $i++) { 
            $timeslot = [0.30, 1, 1.15,1.30,2];
            $min = [00,15,30];
            $key2 = array_rand($min);
            $key = array_rand($timeslot);
            Appointment::create([
                'date' => fake()->date('2023-m-d'),
                'appointment_time'=> fake()->time(rand(9,18).':'.$min[$key2]),
                'time_slot'=>$timeslot[$key],
                'admin_id' => rand(1,2),
                'guest_id' => rand(3,4),
            ]);
        }

    }
}
