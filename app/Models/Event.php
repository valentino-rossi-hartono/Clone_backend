<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use Illuminate\Foundation\Auth\User as Authenticatable;

class Event extends Authenticatable
{
    use HasFactory;

    public $timestamps = false;
    protected $table = "events";
    protected $primaryKey = "id";

    protected $fillable = [
        'user_id',
        'event_name',
        'location',
        'quota',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function ticket()
    {
        return $this->hasMany(Ticket::class);
    }
}