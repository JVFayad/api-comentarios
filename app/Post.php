<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    protected $fillable = [
        'content', 'type', 'user_id'
    ];

    protected $dates = [
        'deleted_at'
    ];

    # Retorna o usuario que fez a postagem
    function user() {
        return $this->belongsTo('App\User');
    }

    # Retorna todos os comentários da postagem
    public function comments()
    {
        return $this->hasMany('App\Comment');
    }

    # Retorna todas as notificacoes da postagem
    public function notifications()
    {
        return $this->hasMany('App\Notification');
    }
}
