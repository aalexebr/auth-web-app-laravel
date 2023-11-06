<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class Holiday extends Model
{
    use HasFactory;

    public function user(){
        return $this->belongsTo(User::class, 'admin_id');
    }
}
