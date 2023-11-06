<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Admin\Profession;

// facades
use Illuminate\Support\Facades\Schema;

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
    }
}
