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

    # Retorna se a notificacao ja expirou
    # ou nao: expira 2 horas depois
    public function expired() {
        $dt_expires = $this->created_at->addHours(2);

        return $dt_expires < \Carbon\Carbon::now();
    }

    # Cria a notificacao
    public function createNotification($post_id, $comment_id) 
    {
        $this->post_id = $post_id;
        $this->comment_id = $comment_id;
        $this->save();

        // Mandar email
    }
}
