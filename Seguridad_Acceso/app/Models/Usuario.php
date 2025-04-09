<?php

namespace App\Models;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Usuario extends Authenticatable
{
    use HasFactory, Notifiable;
    protected $table = 'usuarios';
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    protected $dates = [
        'fechaBloqueo',
        'created_at',
        'updated_at',
    ];

    protected $hidden = [
        'password',
    ];
}
