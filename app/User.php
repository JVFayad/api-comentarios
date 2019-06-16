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

    # Retorna todos as postagens do usuario
    public function posts()
    {
        return $this->hasMany('App\Post');
    }

    # Retorna todos os comentarios do usuario
    public function comments()
    {
        return $this->hasMany('App\Comment');
    }

    # Retorna todos as transacoes do usuario
    public function transactions()
    {
        return $this->hasMany('App\Transaction');
    }
}
