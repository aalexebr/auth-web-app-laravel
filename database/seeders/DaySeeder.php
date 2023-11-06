<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Admin\Day;

// facades
use Illuminate\Support\Facades\Schema;

class DaySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Schema::withoutForeignKeyConstraints(function(){
            Day::truncate();
        });
        $days = [
            'Lunedì',
            'Martedì',
            'Mercoledì',
            'Giovedì',
            'Venerdì',
            'Sabato',
            'Domenica',
        ];
        foreach ($days as $day) {

            Day::create([
                'day' => $day,
            ]);
        }
    }
}
