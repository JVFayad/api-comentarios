<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    protected $fillable = [
        'value', 'user_id'
    ];

    protected $dates = [
        'deleted_at'
    ];

    # Retorna o Usuario que realizou a transacao
    function user() {
        return $this->belongsTo('App\User');
    }
}
