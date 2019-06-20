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

    # Cria uma transacao
    public function createTransaction($highlight_value, $user_id) 
    {
        $this->value = $highlight_value;
        $this->user_id = $user_id;
        $this->save();
    }
}
