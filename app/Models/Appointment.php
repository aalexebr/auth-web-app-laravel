<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class Appointment extends Model
{
    use HasFactory;
    public function admin()
    {
        return $this->belongsTo(User::class, 'admin_id');
    }

    public function guest()
    {
        return $this->belongsTo(User::class, 'guest_id');
    }

    public function message()
    {
        return $this->hasOne(Message::class, 'appointment_id');
    }

}
