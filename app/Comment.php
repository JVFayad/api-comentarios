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

    # Retorna o Usuario que fez a Comentario
    function user() {
        return $this->belongsTo('App\User');
    }

    # Retorna o Post referente a este Comentario
    function post() {
        return $this->belongsTo('App\Post');
    }
}
