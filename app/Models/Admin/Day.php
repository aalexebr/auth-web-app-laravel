<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Admin\Setting;
class Day extends Model
{
    use HasFactory;

    public function settings(){
        return $this->belongsToMany(Setting::class);
    }
}
