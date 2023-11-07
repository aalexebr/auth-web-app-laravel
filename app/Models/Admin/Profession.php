<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use  App\Models\User;

class Profession extends Model
{
    use HasFactory;

    public function users(){
        return $this->belongsToMany(User::class,'profession_user', 'profession_id', 'admin_id');
    }
}
