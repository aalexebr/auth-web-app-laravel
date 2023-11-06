<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Tymon\JWTAuth\Contracts\JWTSubject;
use Illuminate\Foundation\Auth\User as Authenticatable;

// model rel
use App\Models\Admin\AdminInfo;
use App\Models\Admin\MessageTemplate;
use App\Models\Admin\Day;
use App\Models\Admin\Holiday;
use App\Models\Admin\Profession;
use App\Models\Admin\Service;
use App\Models\Admin\Setting;
use App\Models\Guest\Document;
use App\Models\Message;
use App\Models\Appointment;

class User extends Authenticatable implements JWTSubject
{
    use HasApiTokens, HasFactory, Notifiable;

    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    public function getJWTCustomClaims()
    {
        return [];
    }

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    // RELATIONSHIPS

    public function adminInfo(){
        return $this->hasOne(AdminInfo::class);
    }

    public function settings(){
        return $this->hasMany(Setting::class);
    }

    public function holidays(){
        return $this->hasMany(Holiday::class);
    }

    public function services(){
        return $this->hasMany(Service::class);
    }

    public function professions(){
        return $this->belongsToMany(Profession::class);
    }

    public function appointments(){
        return $this->hasMany(Appointment::class);
    }

    public function messages(){
        return $this->hasMany(Message::class);
    }

    public function templates(){
        return $this->hasMany(MessageTemplate::class);
    }
}
