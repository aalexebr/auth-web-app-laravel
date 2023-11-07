<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Admin\Profession;

// facades
use Illuminate\Support\Facades\Schema;
use App\Models\User;

class ProfessionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        Schema::withoutForeignKeyConstraints(function(){
            Profession::truncate();
        });
        $professions = [
            'barbiere',
            'fisioterapista',
            'psicologa di michela'
        ];
        foreach ($professions as $profession) {

            Profession::create([
                'name' => $profession,
            ]);
        }

        // seeder profession
        $admins = User::where('is_admin',1)->get();

        foreach ($admins as $admin){
            $profs= Profession::all();
            $prof_id = [];
            foreach($profs as $prof){
                $prof_id[]= $prof->id;
            }
            $key = array_rand($prof_id);
            
            
            $admin->professions()->sync($prof_id[$key]);

        }
    }
}
