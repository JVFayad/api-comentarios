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

    # Retorna o Usuario que fez a postagem
    function user() {
        return $this->belongsTo('App\User');
    }
}
