<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    protected $fillable = [
        'name', 'login', 'email', 'password', 'subscriber',
    ];

    protected $hidden = [
        'password', 'remember_token',
    ];

    protected $dates = [
        'deleted_at'
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    # Retorna todos os Posts do usuario
    public function posts()
    {
        return $this->hasMany('App\Post');
    }

    # Retorna todos os Comentarios do usuario
    public function comments()
    {
        return $this->hasMany('App\Comment');
    }

    # Retorna todos os Comentarios do usuario
    public function transactions()
    {
        return $this->hasMany('App\Transaction');
    }
}
