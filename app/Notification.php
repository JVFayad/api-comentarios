<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    protected $fillable = [
        'post_id', 'comment_id'
    ];

    protected $dates = [
        'deleted_at'
    ];

    # Retorna o Post referente a notificacao
    function post() {
        return $this->belongsTo('App\Post');
    }

    # Retorna o Comentario referente a notificacao
    function comment() {
        return $this->belongsTo('App\Comment');
    }
}
