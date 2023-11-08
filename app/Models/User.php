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
        'surname',
        'password',
        'is_admin'
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
        return $this->hasOne(AdminInfo::class, 'admin_id');
    }

    public function documents(){
        return $this->hasOne(Document::class, 'user_id');
    }

    public function settings(){
        return $this->hasMany(Setting::class, 'admin_id');
    }

    public function holidays(){
        return $this->hasMany(Holiday::class, 'admin_id');
    }

    public function services(){
        return $this->hasMany(Service::class, 'admin_id');
    }

    public function professions(){
        return $this->belongsToMany(Profession::class,'profession_user',  'admin_id','profession_id');
    }

    public function adminAppointments()
    {
        return $this->hasMany(Appointment::class, 'admin_id');
    }

    public function guestAppointments()
    {
        return $this->hasMany(Appointment::class, 'guest_id');
    }

    public function adminMessages()
    {
        return $this->hasMany(Message::class, 'admin_id');
    }

    public function guestMessages()
    {
        return $this->hasMany(Message::class, 'guest_id');
    }

    public function templates(){
        return $this->hasMany(MessageTemplate::class);
    }
}
