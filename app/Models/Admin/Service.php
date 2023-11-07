<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\Admin\MessageTemplate;

class Service extends Model
{
    use HasFactory;
    public function user(){
        return $this->belongsTo(User::class, 'admin_id');
    }

    public function template(){
        return $this->hasOne(MessageTemplate::class);
    }

}
