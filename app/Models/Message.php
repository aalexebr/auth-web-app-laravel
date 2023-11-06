<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Message extends Model
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
    
    public function appointment()
    {
        return $this->belongsTo(Appointment::class, 'appointment_id');
    }
}
