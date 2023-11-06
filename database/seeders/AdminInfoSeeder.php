<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

// users
use App\Models\User;
use App\Models\Admin\AdminInfo;

// facades
use Illuminate\Support\Facades\Schema;

class AdminInfoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Schema::withoutForeignKeyConstraints(function(){
            AdminInfo::truncate();
        });

        $users = User::where('is_admin',1)->get();

        foreach($users as $user){
            AdminInfo::create([
                'admin_id'=>$user->id,
                'description'=> fake()->sentence(),
                'address'=> fake()->address() 
            ]);
        }
    }
}
