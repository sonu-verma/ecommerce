<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    public function user(){
        return $this->belongsTo(User::class,'id_user');
    }

    public function order(){
        return $this->belongsTo(Order::class,'id_order');
    }
}
