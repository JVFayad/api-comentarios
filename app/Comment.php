<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    protected $fillable = [
        'content', 'type', 'highlight', 'highlight_value', 'user_id', 'post_id'
    ];

    protected $dates = [
        'deleted_at'
    ];

    # Retorna o usuario que fez o Comentario
    function user() {
        return $this->belongsTo('App\User');
    }

    # Retorna a postagem referente a este comentario
    function post() {
        return $this->belongsTo('App\Post');
    }

    # Retorna todas as notificacoes do comentario
    public function notifications()
    {
        return $this->hasMany('App\Notification');
    }
}
