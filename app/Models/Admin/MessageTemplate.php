<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\Admin\Service;


class MessageTemplate extends Model
{
    use HasFactory;

        /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'message_templates';

    public function user(){
        return $this->belongsTo(User::class, 'admin_id');
    }
    public function service(){
        return $this->belongsTo(Service::class);
    }
}
